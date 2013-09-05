<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	function getMonthList($begin = 0,$end = 12,$value = NULL){
		
		$months = array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
		$html = '<label>Месяц:</label>';
		$html .= '<select name="month" class="span2">';
		for($i=$begin;$i<$end;$i++):
			$html .= '<option value="'.($i+1).'"';
			if(is_null($value) && ($i+1)==date('m')):
				$html .= ' selected ';
			elseif(!is_null($value) && ($i+1) == $value):
				$html .= ' selected ';
			endif;
			$html .= '>'.$months[$i].'</option>';
		endfor;
		$html .= '</select>';
		return $html;
	}
	
	function getYearsList($begin,$end,$reverse = FALSE,$value = NULL){
		
		$html = '<label>Год:</label>';
		$html .= '<select name="year" class="span2">';
		if($reverse == FALSE):
			for($i=$begin;$i<$end;$i++):
				$html .= '<option value="'.$i.'"';
				if(is_null($value) && $i==date('Y')):
					$html .= ' selected ';
				elseif(!is_null($value) && $i == $value):
					$html .= ' selected ';
				endif;
				$html .= '>'.$i.'</option>';
			endfor;
		else:
			for($i=$begin;$i>=$end;$i--):
				$html .= '<option value="'.$i.'"';
				if($i==date('Y')):
					$html .= ' selected ';
				endif;
				$html .= '>'.$i.'</option>';
			endfor;
		endif;
		$html .= '</select>';
		return $html;
	}
	
	function seconds2times($seconds){
		$times = array();
		$count_zero = false;
		$periods = array(60,3600,86400,31536000);
		for($i=3;$i>=0;$i--):
			$period = floor($seconds/$periods[$i]);
			if(($period > 0) || ($period == 0 && $count_zero)):
				$times[$i+1] = $period;
				$seconds -= $period * $periods[$i];
				$count_zero = true;
			endif;
		endfor;
		$times[0] = $seconds;
		return $times;
}
	
	function PluralNumber($count,$arg0,$arg1,$arg2,$arg3){
		
		//PluralNumber($days, ‘ д’, ‘ень’, ‘ня’, ‘ней’);
		//PluralNumber($hours, ‘ час’, ”, ‘а’, ‘ов’);
		//PluralNumber(mins, ‘ минут’, ‘у’, ‘ы’, ”);
		
		if($count == 0):
			return '';
		endif;
		$result = $arg0;
		$last_digit = $count%10;
		$last_two_digits = $count%100;
		if($last_digit == 1 && $last_two_digits != 11):
			$result .= $arg1;
			echo $result;echo '<br/>';
		elseif(($last_digit == 2 && $last_two_digits != 12) || ($last_digit == 3 && $last_two_digits != 13) || ($last_digit == 4 && $last_two_digits != 14)):
			$result .= $arg2;
		else:
			$result .= $arg3;
		endif;
		return $count.' '.$result;
	}
	
	function currentDate($time = FALSE){
		
		if($time):
			return strtotime(date('Y-m-d H:i:s'));
		else:
			return strtotime(date('Y-m-d'));
		endif;
	}
	
	function yesterday($user_date){
		
		if(!$user_date):
			return FALSE;
		endif;
		
		$sub_date = strtotime(date_without_time($user_date))- mktime(0,0,0,date("m"),date("d")-1,date("Y"));
		if($sub_date == 0):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	function commentsDate($userDate = NULL){
		
		if(!is_null($userDate)):
			$date = strtotime(date_without_time($userDate));
			if($date == current_date()):
				return $string = 'cегодня в '.date_time($userDate);
			elseif(yesterday($userDate)):
				return $string = 'вчера в '.date_time($userDate);
			else:
				return $string = month_date_with_time($userDate);
			endif;
		else:
			return '';
		endif;
		
	}
	
	function commentsDateTime($userDate = NULL){
		
		if(!is_null($userDate)):
			$date = strtotime(date_without_time($userDate));
			if($date == current_date()):
				return $string = date_full_time($userDate);
			else:
				return $string = date("d.m.y",strtotime(swap_dot_date_without_time($userDate)));
			endif;
		else:
			return '';
		endif;
	}
	
	function monthDate($field){
		
		$months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
		$list = explode("-",$field);
		$list[2] = (int)$list[2];
		$field = implode("-",$list);
		$nmonth = $months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function monthDateTime($field){
		
		$months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
		$list = explode("-",$field);
		$list[2] = (int)$list[2];
		$time = substr($field,11);
		$field = implode("-",$list).' '.$time;
		$nmonth = $months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 в \$6:\$8";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function monthDotDate($field){
		
		$months = array("01"=>"янв","02"=>"фев","03"=>"мар","04"=>"апр","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"авг","09"=>"сен","10"=>"окт","11"=>"ноя","12"=>"дек");
		$list = preg_split("/\./",$field);
		$nmonth = $months[$list[1]];
		$pattern = "/(\d+)(\.)(\w+)(\.)(\d+)/i";
		$replacement = "\$1 $nmonth \$5";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function splitDate($field){
	
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1"; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	function dateWithoutTime($field){
	
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$1-$3-\$5";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function getTime($field){
	
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$6:\$8";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function getFullTime($field){
	
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$6:\$8:\$10";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function swapDotDate($field){
		
		if($field != '0000-00-00'):
			$list = preg_split("/-/",$field);
			$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
			$replacement = "\$5.$3.\$1";
			return preg_replace($pattern, $replacement,$field);
		else:
			return '';
		endif;
		
	}
	
	function swapDotDateWithoutTime($field){
		
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$5.$3.\$1";
		return preg_replace($pattern, $replacement,$field);
	}
	
	function swapDotDateWithTime($field){
			
		$list = preg_split("/-/",$field);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$5.$3.\$1 в \$6:\$8";
		return preg_replace($pattern, $replacement,$field);
	}

	function futureDays($days = 1,$date = NULL){
		
		if(is_null($date)):
			return (time()+($days*24*60*60));
		else:
			return (strtotime($date)+($days*24*60*60));
		endif;
	}
	
	function daysDiff($startDateTime,$endDateTime){
		
		$timeSting = '';
		$times_values = array('сек.','мин.','час.','д.','лет');
		$times = seconds2times($endDateTime-$startDateTime);
		for($i=count($times)-1;$i>=0;$i--):
			$timeSting .= $times[$i].' '.$times_values[$i].' ';
		endfor;
		return $timeSting;
	}
	
?>