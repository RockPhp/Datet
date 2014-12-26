<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once dirname(__FILE__).'/Rock/Datet/DateObj.php';
require_once dirname(__FILE__).'/Rock/Datet/DateDiff.php';
require_once dirname(__FILE__).'/Rock/Datet/DateUtil.php';
// date_default_timezone_set('UTC');
//require_once 'Rock/AutoLoad.php';

$format = '%e/%m/%Y %H:%M:%S';

echo 'Exemplo DateDiff (Day Light Save Time / Horario Verao entra na conta): <br/><br/>';

$date1 = '01/01/2013 00:00:00';
$date2 = '01/03/2013 00:00:00';

echo $date1 . "\n<br>";
echo $date2 . "\n<br>";

$dateDiff = new Rock_Datet_DateDiff(new Rock_Datet_DateObj($date1, $format), new Rock_Datet_DateObj($date2, $format));
echo '<pre>';
print_r($dateDiff);
echo '</pre><hr/>';
$dateObj = new Rock_Datet_DateObj('29/5/2014 00:30:10', '%e/%m/%Y %H:%M:%S');
$date = new Rock_Datet_DateUtil($dateObj);
?>
Exemplo DateUtil
<br />
<br />
$dateObj = new Rock_Datet_DateObj('29/5/2014 00:30:10','%e/%m/%Y %H:%M:%S');
<br />
$date = new Rock_Datet_DateUtil($dateObj);
<br />
<br />
<table border="1">
	<thead>
		<tr>
			<td><b>Comando</b></td>
			<td><b>Resultado</b></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>$dateObj-&gt;getDate();</td>
			<td><?php echo $dateObj->getDate();?></td>
		</tr>
		<tr>
			<td>$dateObj-&gt;isWeekend();</td>
			<td><?php var_dump($dateObj->isWeekend());?></td>
		</tr>
		<tr>
			<td>$date-&gt;getLastDayMonth()-&gt;getDate();</td>
			<td><?php echo $date->getLastDayMonth()->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;getLastWorkingDayMonty()-&gt;getDate();</td>
			<td><?php echo $date->getLastWorkingDayMonty()->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;getSumWorkingDays(7)-&gt;getDate();</td>
			<td><?php echo $date->getSumWorkingDays(7)->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;addHoliday(new Rock_Datet_DateObj('4/6/2014'));</td>
			<td><?php $date->addHoliday(new Rock_Datet_DateObj('4/6/2014'));?>DateUtil Object</td>
		</tr>
		<tr>
			<td>$date-&gt;getSumWorkingDays(7)-&gt;getDate();</td>
			<td><?php echo $date->getSumWorkingDays(7)->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;getSumDays(4)-&gt;getDate() ;</td>
			<td><?php echo $date->getSumDays(4)->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;getSumMonths(9)-&gt;getDate();</td>
			<td><?php echo $date->getSumMonths(9)->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;isWorkingDay();</td>
			<td><?php var_dump($date->isWorkingDay());?></td>
		</tr>
		<tr>
			<td>$date-&gt;getSumWorkingDaysPrev(9)-&gt;getDate();</td>
			<td><?php echo $date->getSumWorkingDaysPrev(9)->getDate();?></td>
		</tr>
		<tr>
			<td>$date-&gt;getSumWorkingDaysNext(9)-&gt;getDate();</td>
			<td><?php echo $date->getSumWorkingDaysNext(9)->getDate();?></td>
		</tr>
	</tbody>
</table>
