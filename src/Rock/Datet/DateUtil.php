<?php

class Rock_Datet_DateUtil
{

    /**
     * Timestamp do dia de referencia
     *
     * @var integer
     */
    private $ts;

    /**
     * Array String MesDia de feriados
     *
     * @var string[]
     */
    private $mesDiaFeriados;

    /**
     * Formato da data de referencia.
     *
     * @var string
     */
    private $format;

    /**
     * Construtor.
     *
     * @param Rock_Datet_DateObj $dateObj            
     */
    public function __construct(Rock_Datet_DateObj $dateObj)
    {
        $this->setNovaData($dateObj);
        $this->mesDiaFeriados = array();
    }

    /**
     * Substituir data de referencia por uma nova.
     *
     * @param Rock_Datet_DateObj $dateObj            
     */
    public function setNovaData(Rock_Datet_DateObj $dateObj)
    {
        $this->format = $dateObj->getFormat();
        $this->ts = $dateObj->getTimeStamp();
    }

    /**
     * Soma dias.
     *
     * @param integer $qtdDias            
     * @return integer Timestamp
     */
    private function somaDia($qtdDias)
    {
        $somaDia = $qtdDias;
        if ($qtdDias > 0) {
            $somaDia = "+$qtdDias";
        }
        $ts = strtotime("$somaDia day", $this->ts);
        return $ts;
    }

    /**
     * Calcula ultimo dia do mes.
     *
     * @return integer Timestamp
     */
    private function ultimoDiaMes()
    {
        $ts = $this->ts;
        $mesAtual = strftime('%m', $ts);
        $mesTmp = $mesAtual;
        $i = 0;
        while ($mesAtual == $mesTmp) {
            $ts = $this->somaDia(++ $i);
            $mesTmp = strftime('%m', $ts);
        }
        return $this->somaDia(-- $i);
    }

    /**
     * Retorna novo Rock_Datet_DateObj.
     *
     * @param integer $ts
     *            Timestamp
     * @return DateObj
     */
    private function returnDateObj($ts)
    {
        return new Rock_Datet_DateObj(strftime($this->format, $ts), $this->format);
    }

    /**
     * Soma meses.
     *
     * @param integer $qtdMes            
     * @return integer Timestamp
     */
    private function somaMes($qtdMes)
    {
        $ts = strtotime("+$qtdMes month", $this->ts);
        return $ts;
    }

    /**
     * Verifica se o Timestamp é dia útil.
     *
     * @param integer $ts            
     * @return boolean
     */
    private function checkDiaUtil($ts)
    {
        $diaSemana = strftime('%u', $ts);
        $mes = strftime('%m', $ts);
        $dia = strftime('%d', $ts);
        if ($diaSemana < 6 && ! in_array($mes . $dia, $this->mesDiaFeriados)) {
            return true;
        }
        return false;
    }

    /**
     * Retorna Rock_Datet_DateObj com dias somados.
     *
     * @param integer $qtdDias            
     * @return Rock_Datet_DateObj
     */
    public function getSumDays($qtdDias)
    {
        return $this->returnDateObj($this->somaDia($qtdDias));
    }

    /**
     * Retorna Rock_Datet_DateObj com dias somados, se o dia calculado não for útil, retorna o dia útil seguinte.
     *
     * @param integer $qtdDias            
     * @return Rock_Datet_DateObj
     */
    public function getSumWorkingDaysNext($qtdDias)
    {
        $ts = $this->somaDia($qtdDias);
        while (! $this->checkDiaUtil($ts)) {
            $ts = strtotime("+1 day", $ts);
        }
        return $this->returnDateObj($ts);
    }

    /**
     * Retorna Rock_Datet_DateObj com dias somados, se o dia calculado não for útil, retorna o dia útil anterior.
     *
     * @param integer $qtdDias            
     * @return Rock_Datet_DateObj
     */
    public function getSumWorkingDaysPrev($qtdDias)
    {
        $ts = $this->somaDia($qtdDias);
        while (! $this->checkDiaUtil($ts)) {
            $ts = strtotime("-1 day", $ts);
        }
        return $this->returnDateObj($ts);
    }

    /**
     * Retorna Rock_Datet_DateObj com dias úteis somados.
     *
     * @param integer $qtdDias            
     * @return Rock_Datet_DateObj
     */
    public function getSumWorkingDays($qtdDias)
    {
        $ts = $this->ts;
        $i = 0;
        $dias = 0;
        while ($i < $qtdDias) {
            $ts = $this->somaDia(++ $dias);
            if ($this->checkDiaUtil($ts)) {
                $i ++;
            }
        }
        return $this->returnDateObj($ts);
    }

    /**
     * Retorna Rock_Datet_DateObj com último dia do mes.
     *
     * @return Rock_Datet_DateObj
     */
    public function getLastDayMonth()
    {
        return $this->returnDateObj($this->ultimoDiaMes());
    }

    /**
     * Retorna Rock_Datet_DateObj com último dia útil do mes.
     *
     * @return Rock_Datet_DateObj
     */
    public function getLastWorkingDayMonty()
    {
        $ts = $this->ultimoDiaMes();
        while (! $this->checkDiaUtil($ts)) {
            $ts = strtotime("-1 day", $ts);
        }
        return $this->returnDateObj($ts);
    }

    /**
     * Adiciona feriados considerados nos calculos de dias úteis, ignora ano.
     *
     * @param Rock_Datet_DateObj $dateObj            
     * @return Rock_Datet_DateUtil
     */
    public function addHoliday(Rock_Datet_DateObj $dateObj)
    {
        $ts = $dateObj->getTimeStamp();
        $mes = strftime('%m', $ts);
        $dia = strftime('%d', $ts);
        array_push($this->mesDiaFeriados, $mes . $dia);
        return $this;
    }

    /**
     * Retorna Rock_Datet_DateObj com meses somados.
     *
     * @param integer $qtdMes            
     * @return Rock_Datet_DateObj
     */
    public function getSumMonths($qtdMes)
    {
        return $this->returnDateObj($this->somaMes($qtdMes));
    }

    /**
     * Retorna se é dia útil.
     *
     * @return boolean
     */
    public function isWorkingDay()
    {
        return $this->checkDiaUtil($this->ts);
    }
}

