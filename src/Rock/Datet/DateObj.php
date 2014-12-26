<?php 
require_once dirname(__FILE__).'/strptime.php';

class Rock_Datet_DateObj
{

    private $ts;

    private $format;

    /**
     *
     * @param string $data            
     * @param string $format
     *            Formato padrão da função strftime() http://php.net/strftime
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

    private function getArrayTime($data)
    {
        $arrayTime = strptime($data, $this->format);
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
     * @param string $format
     *            não obrigatório. Formato padrão da função strftime() http://php.net/strftime
     * @return string
     */
    public function getDate($format = null)
    {
        $format = empty($format) ? $this->format : $format;
        return strftime($format, $this->ts);
    }
}
