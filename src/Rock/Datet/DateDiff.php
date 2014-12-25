<?php

class Rock_Datet_DateDiff
{
    private $years = 0;

    private $months = 0;

    private $days = 0;

    private $hours = 0;

    private $minutes = 0;

    private $seconds = 0;

    private $positive = true;

    private $secondsTotal = 0;

    private $daysTotal = 0;

    private $dateIni;

    private $dateEnd;

    private function calcDiffYears()
    {
        if ($this->daysTotal > 364) {
            $rest = $this->daysTotal % 365;
            $yearsDays = $this->daysTotal - $rest;
            $this->years = $yearsDays / 365;
            $this->days = $rest;
        }
    }

    private function calcDiffMonths()
    {
        if ($this->days > 27) {
            $this->calcDiffYears();
            $mesIni = $this->dateIni->getDate('%m');
            $mesFim = $this->dateEnd->getDate('%m');
            $months = $mesFim - $mesIni;
            if ($this->years > 0) {
                $months = $this->years * 12 + $months;
            }
            $this->months = $months;
            $dateUtil = new Rock_Datet_DateUtil($this->dateIni);
            $daysTmp = $this->daysTotal;
            $daysTmp2 = $daysTmp;
            $i = 0;
            do {
                $dateTmp = $dateUtil->getSumMonths($i);
                $daysTmp -= date('t', mktime(0, 0, 0, $dateTmp->getDate('%m'), 1, $dateTmp->getDate('%Y')));
                if ($daysTmp >= 0) {
                    $daysTmp2 = $daysTmp;
                }
                $i ++;
            } while ($i < $this->months);
            if ($daysTmp2 > $daysTmp) {
                $this->months --;
            }
            $this->months = $this->months - ($this->years * 12);
            $this->days = $daysTmp2;
        }
    }

    private function calcDiffDays()
    {
        if ($this->hours > 23) {
            $rest = $this->hours % 24;
            $daysHours = $this->hours - $rest;
            $this->days = $daysHours / 24;
            $this->hours = $rest;
            $this->calcDiffMonths();
        }
    }

    private function calcDiffHours()
    {
        if ($this->minutes > 59) {
            $this->hours = floor($this->minutes / 60);
            settype($this->hours, 'int');
            $this->minutes = $this->minutes - ($this->hours * 60);
            $this->calcDiffDays();
        }
    }

    private function calcDiffMinutes()
    {
        if ($this->seconds > 59) {
            $this->minutes = floor($this->seconds / 60);
            settype($this->minutes, 'int');
            $this->seconds = $this->seconds - ($this->minutes * 60);
            $this->calcDiffHours();
        }
    }

    private function calcDiffSeconds()
    {
        $this->seconds = $this->dateEnd->getTimeStamp() - $this->dateIni->getTimeStamp();
        $this->calcDiffMinutes();
    }

    private function calcPositive(Rock_Datet_DateObj $dataIni, Rock_Datet_DateObj $dataFim)
    {
        $this->dateIni = $dataIni;
        $this->dateEnd = $dataFim;
        if ($this->dateIni->getTimeStamp() > $this->dateEnd->getTimeStamp()) {
            $this->positive = false;
            $this->dateIni = $dataFim;
            $this->dateEnd = $dataIni;
        }
    }

    private function setTotals()
    {
        $this->secondsTotal = $this->dateEnd->getTimeStamp() - $this->dateIni->getTimeStamp();
        $rest = $this->secondsTotal % 86400;
        $daysSeconds = $this->secondsTotal - $rest;
        $this->daysTotal = $daysSeconds / 86400;
    }

    public function __construct(Rock_Datet_DateObj $dataIni, Rock_Datet_DateObj $dataFim)
    {
        $this->calcPositive($dataIni, $dataFim);
        $this->setTotals();
        $this->calcDiffSeconds();
    }

    public function getYears()
    {
        return $this->years;
    }

    public function getMonths()
    {
        return $this->months;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function getMinutes()
    {
        return $this->minutes;
    }

    public function getSeconds()
    {
        return $this->seconds;
    }

    public function getPositive()
    {
        return $this->positive;
    }

    public function getSecondsTotal()
    {
        return $this->secondsTotal;
    }

    public function getDaysTotal()
    {
        return $this->daysTotal;
    }
}
