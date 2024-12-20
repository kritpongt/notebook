<? 
function getfulldate($date = '', $format = '', $mod = '', $checkdate = false){
	$arr_date['date'] = $arr_date['original'] = $date;
	// ============== validation date ============== //
	if($date != '' && stripos($date, 'now') === false){
		$datetime		= explode(' ', preg_replace('/^([^0-9]+)/', '', $date));
		$time 			= $datetime[1] ?? '';
		$date_str		= preg_replace('/([^0-9]+)/', '-', $datetime[0]);
		$arr_date_str	= explode('-', $date_str);
		$arr_date_str[1] ??= '01';
		$arr_date_str[2] ??= '01';
		if(count($arr_date_str) == 3){
			$y 	    = $arr_date_str[0];
			$m 	    = $arr_date_str[1];
			$d 	    = $arr_date_str[2];
			$d_tmp  = $d;
			$arr_date['date'] = "{$y}-{$m}-{$d}";
			$prove  = true;
			if(!checkdate($m, $d, $y)){
				$y 			= max(1000, $y %= 10000);
				$m          = min(12, $m);
				$d 			= max(1, $d);
				$date_tmp 	= new DateTime("{$y}-{$m}");
				$t_tmp 		= $date_tmp->format("t");
				if($d > $t_tmp){
					$arr_date['date'] = $date_tmp->format("Y-m-t");
				}else{
					$arr_date['date'] = $date_tmp->format("Y-m-{$d}");
				}
				$prove = false;
			}
			if($checkdate){ $arr_date['prove'] = $prove; return $arr_date; }
		}else{ 
			return false;
		}
	}
	// ============== validation time ============== //
	if($time != ''){
		$chktime = DateTime::createFromFormat('H:i:s', $time);
		if($chktime && $chktime->format('H:i:s') == $time){
			$arr_date['time'] = ' '.$time;
		}
	}
	// ================== set date ================== //
	$set_date 	= new DateTime($arr_date['date'].$arr_date['time']);
	$arr_date['set'] = $set_date;
	$year 		= $set_date->format('Y');
	$month 		= $set_date->format('m');
	$day 		= $set_date->format('d');
	$arr_time = array(
		'H' => $set_date->format('H'),
		'i' => $set_date->format('i'),
		's' => $set_date->format('s')
	);
	// ================ modify date ================ //
	if($mod != ''){
		if(preg_match('/^\s*([+-]?\s*[0-9]+)\s*(month|year)s?$/', $mod, $matches)){
			$ext_month = (int)str_replace(' ', '', $matches[1]);
			if($matches[2] == 'year'){
				$ext_month *= 12;
			}
			if($ext_month > 0){
				$year += floor($ext_month / 12);
			}else{
				$year += ceil($ext_month / 12);
			}
			$ext_month = $ext_month % 12;
			$month += $ext_month;
			if($month > 12){
				$year++;
				$month -= 12;
			}else if($month < 1){
				$year--;
				$month += 12;
			}
			$day = $d_tmp ?? $day;
			if(!checkdate($month, $day, $year)){
				$arr_date['set'] = DateTime::createFromFormat('Y-m-d', "{$year}-{$month}-01");
				$arr_date['set']->modify('last day of');
			}else{
				$arr_date['set'] = DateTime::createFromFormat('Y-m-d', "{$year}-{$month}-{$day}");
			}
			if($arr_date['time'] != '' || stripos($date, 'now') !== false){
				$arr_date['set']->setTime($arr_time['H'], $arr_time['i'], $arr_time['s']);
			}
		}else{
			$arr_date['set'] = $set_date->modify($mod);
		}
	}
	// ================= format date ================= //
	if($format == ''){ $format = 'Y-m-d'; }
	$arr_date['result'] = $arr_date['set']->format($format);

	return $arr_date['result'];
}

function array_getfulldate($date = '', $mod = ''){
	if(preg_match('/^\s*([+-]?)\s*([0-9]+)\s*(day|month|year)s?$/', $mod, $matches)){
		$ext_number = (int)str_replace(' ', '', $matches[2]);
		$i = abs($ext_number);
	}
	if(empty($i) || $i < 1){ return false; }

	$arr_date[0] = (new DateTime($date))->format("Y-m-d");
	for($j = 1; $j <= $i; $j++){
		$arr_date[$j] = getfulldate($date, '', "{$matches[1]} {$j} {$matches[3]}");
	}
	return $arr_date;
}

function array_periods($amount, $periods){
	if($periods <= 0){ return false; }
	$amt 		= floor($amount / $periods);
	$remain 	= $amount % $periods;
	$result 	= array();
	for($i = 1; $i <= $periods; $i++){
		if($i <= $remain){
			$result[] = sprintf('%.2f', $amt + 1);
		}else{
			$result[] = sprintf('%.2f', $amt);
		}
	}
	return $result;
}

function sanitizedTextArea($text){
	$result = str_replace(['\r\n', "\r"], "\n", $text);
	return $result;
}

function array_invert($arr_data){
	$result = array();
	if(!is_array($arr_data)){ return false; }
	foreach($arr_data as $key => $val){
		if(is_array($val)){ return false; }
		$result[$val] = $key;
	}
	return $result;
}
?>