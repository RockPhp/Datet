<?php

class Rock_Datet_DateObj
{
    private $ts;

    private $format;

    /**
     *
     * @param string $data
     * @param string $format
     *                       Formato padrão da função strftime() http://php.net/strftime
     */
    public function __construct($data = '', $format = '%d/%m/%Y')
    {
        $this->format = $format;
        try {
            $this->setDate($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * http://php.net/strptime#86572
     */
    private function strptime($sDate, $sFormat)
    {
        if (function_exists("strptime")) {
            return strptime($sDate, $sFormat);
        }

        $aResult = array(
            'tm_sec'   => 0,
            'tm_min'   => 0,
            'tm_hour'  => 0,
            'tm_mday'  => 1,
            'tm_mon'   => 0,
            'tm_year'  => 0,
            'tm_wday'  => 0,
            'tm_yday'  => 0,
            'unparsed' => $sDate,
        );

        while ($sFormat != "") {
            // ===== Search a %x element, Check the static string before the %x =====
            $nIdxFound = strpos($sFormat, '%');
            if ($nIdxFound === false) {
                // There is no more format. Check the last static string.
                $aResult['unparsed'] = ($sFormat == $sDate) ? "" : $sDate;
                break;
            }

            $sFormatBefore = substr($sFormat, 0, $nIdxFound);
            $sDateBefore   = substr($sDate,   0, $nIdxFound);

            if ($sFormatBefore != $sDateBefore) {
                break;
            }

            // ===== Read the value of the %x found =====
            $sFormat = substr($sFormat, $nIdxFound);
            $sDate   = substr($sDate,   $nIdxFound);

            $aResult['unparsed'] = $sDate;

            $sFormatCurrent = substr($sFormat, 0, 2);
            $sFormatAfter   = substr($sFormat, 2);

            $nValue = -1;
            $sDateAfter = "";

            switch ($sFormatCurrent) {
                case '%S': // Seconds after the minute (0-59)

                    sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);

                    if (($nValue < 0) || ($nValue > 59)) {
                        return false;
                    }

                    $aResult['tm_sec']  = $nValue;
                    break;

                // ----------
                case '%M': // Minutes after the hour (0-59)
                    sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);

                    if (($nValue < 0) || ($nValue > 59)) {
                        return false;
                    }

                    $aResult['tm_min']  = $nValue;
                    break;

                // ----------
                case '%H': // Hour since midnight (0-23)
                    sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);

                    if (($nValue < 0) || ($nValue > 23)) {
                        return false;
                    }

                    $aResult['tm_hour']  = $nValue;
                    break;

                // ----------
                case '%d': // Day of the month (1-31)
                    sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);

                    if (($nValue < 1) || ($nValue > 31)) {
                        return false;
                    }

                    $aResult['tm_mday']  = $nValue;
                    break;

                // ----------
                case '%m': // Months since January (0-11)
                    sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);

                    if (($nValue < 1) || ($nValue > 12)) {
                        return false;
                    }

                    $aResult['tm_mon']  = ($nValue - 1);
                    break;

                // ----------
                case '%Y': // Years since 1900
                    sscanf($sDate, "%4d%[^\\n]", $nValue, $sDateAfter);

                    if ($nValue < 1900) {
                        return false;
                    }

                    $aResult['tm_year']  = ($nValue - 1900);
                    break;

                // ----------
                default:
                    break 2; // Break Switch and while

            } // END of case format

            // ===== Next please =====
            $sFormat = $sFormatAfter;
            $sDate   = $sDateAfter;

            $aResult['unparsed'] = $sDate;
        } // END of while($sFormat != "")

        // ===== Create the other value of the result array =====
        $nParsedDateTimestamp = mktime($aResult['tm_hour'], $aResult['tm_min'], $aResult['tm_sec'],
                                $aResult['tm_mon'] + 1, $aResult['tm_mday'], $aResult['tm_year'] + 1900);

        // Before PHP 5.1 return -1 when error
        if (($nParsedDateTimestamp === false)
        || ($nParsedDateTimestamp === -1)) {
            return false;
        }

        $aResult['tm_wday'] = (int) strftime("%w", $nParsedDateTimestamp); // Days since Sunday (0-6)
        $aResult['tm_yday'] = (strftime("%j", $nParsedDateTimestamp) - 1); // Days since January 1 (0-365)

        return $aResult;
    }

    private function getArrayTime($data)
    {
        $arrayTime = $this->strptime($data, $this->format);
        if (! empty($arrayTime['unparsed'])) {
            throw new Exception($arrayTime['unparsed']);
        }
        if ($arrayTime['tm_hour'] > 23 || $arrayTime['tm_hour'] < 0) {
            $arrayTime['tm_hour'] = 0;
        }
        if ($arrayTime['tm_min'] > 59 || $arrayTime['tm_min'] < 0) {
            $arrayTime['tm_min'] = 0;
        }
        if ($arrayTime['tm_sec'] > 59 || $arrayTime['tm_sec'] < 0) {
            $arrayTime['tm_sec'] = 0;
        }
        $arrayTime['tm_mon'] ++;
        $arrayTime['tm_year'] += 1900;

        return $arrayTime;
    }

    private function setDate($data)
    {
        if (empty($data)) {
            $this->ts = time();
        } else {
            $arrayTime = $this->getArrayTime($data);
            // $timezone = date_default_timezone_get();
            // date_default_timezone_set('UTC');
            $this->ts = mktime($arrayTime['tm_hour'], $arrayTime['tm_min'], $arrayTime['tm_sec'], ($arrayTime['tm_mon']), $arrayTime['tm_mday'], ($arrayTime['tm_year']));
            // date_default_timezone_set($timezone);
        }
    }

    public function getTimeStamp()
    {
        return $this->ts;
    }

    public function isWeekend()
    {
        $diaSemana = strftime('%u', $this->ts);
        if ($diaSemana > 5) {
            return true;
        }

        return false;
    }

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Retorna data no formato especificado
     *
     * @param  string $format
     *                        não obrigatório. Formato padrão da função strftime() http://php.net/strftime
     * @return string
     */
    public function getDate($format = null)
    {
        $format = empty($format) ? $this->format : $format;

        return strftime($format, $this->ts);
    }
}
