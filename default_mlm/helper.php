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
	$remain_f 	= fmod($amount, $periods);
	$remain 	= floor($remain_f);
	$f_point 	= round($remain_f - $remain, 2);
	$result 	= array();
	for($i = 1; $i <= $periods; $i++){
		$period_amount = $amt;
		if($i <= $remain){ $period_amount++; }
		$result[] = sprintf('%.2f', $period_amount);
	}
	if($f_point > 0){ $result[0] += $f_point; }
	return $result;
}

function array_periods_amt($total_amt, $install_amt, $unshift = false){
	if($install_amt <= 0 || $install_amt > $total_amt){ return false; }
	$period 	= floor($total_amt / $install_amt);
	$remain_f 	= fmod($total_amt, $install_amt);
	$result 	= array();
	for($i = 1; $i <= $period; $i++){
		$result[] = sprintf('%.2f', $install_amt);
	}
	if($remain_f > 0){
		$remaining_amt = sprintf('%.2f', $remain_f);
		if($unshift === true){
			$result = array_merge([$remaining_amt], $result);
		}else{
			$result[] = $remaining_amt;
		}
	}
	return $result;
}

function query_y(string $sql){
	global $linksql;
	$objQuery = mysqli_query($linksql, $sql);
	if(!$objQuery){ return false; }

	while($rowData = $objQuery->fetch_assoc()){
		foreach($rowData as $key => $val){
			$data[$key] = $val;
		}
		yield $data;
	}
	mysqli_free_result($objQuery);
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

function log_update($topic = '', $tb, $tb_where, $arr_updated, $log_update_conf_key = ''){
	global $wording_lan;
	$rs_sql 	= query("*", $tb, $tb_where);
	$rs_base 	= $rs_sql[0];

	if(!empty($log_update_conf_key)){
		$tb 	= $log_update_conf_key;
	}
	// include("log_conf.php");
	/* 	$log_update_conf[$tb] = array(
		'col_exclude' => [],
		'col_lang' => [
			'total' 	=> $wording_lan['price'],
			'tot_pv' 	=> $wording_lan['pv'],
			'send' 		=> $wording_lan['txt_send'],
		],
		'col_lang_sub' => [
			'send' => [
				'1' 	=> $wording_lan["send"]["1"],
				'2' 	=> $wording_lan['send']['2'],
			]
		]
	); */
	if(count($rs_sql) < 1 || empty($arr_updated)){ return false; }

	foreach($arr_updated as $key => $val){
		if($rs_base[$key] == '0' && $val == ''){
			$val = '0';
		}else if($rs_base[$key] == '0000-00-00' && $val == ''){
			$val = '0000-00-00';
		}else if((is_numeric($rs_base[$key]) && strpos($rs_base[$key], '.')) !== false){
			$val = number_format($val, 2, '.', '');
		}
		if(array_key_exists($key, $rs_base) && $rs_base[$key] != (string)$val){
			$diff_key[] = $key;
		}
	}

	$arr_exclude 	= $log_update_conf[$tb]['col_exclude'];
	$select_col 	= array_filter($diff_key, function($val) use($arr_exclude){
		return !in_array($val, $arr_exclude);
	});

	$txt_log 		= empty($topic) ? 'แก้ไข '.$tb : $topic;
	foreach($select_col as $k){
		$txt_column = $log_update_conf[$tb]['col_lang'][$k] ?? $k;
		$col_sub 	= $log_update_conf[$tb]['col_lang_sub'][$k];
		$txt_log 	.= '<br>'.$txt_column.': \''.($col_sub[$rs_base[$k]] ?? $rs_base[$k]).'\' '.$wording_lan['is'].' \''.($col_sub[$arr_updated[$k]] ?? $arr_updated[$k]).'\'.';
	}
	if(count($select_col) > 0){
		return $txt_log;
	}
}

function setPaymentGroup($bill_data){
	global $dbprefix, $arr_payment_term_ar, $arr_payment_group;
	$payment_term = $bill_data['payment_term'];
	if($payment_term == ''){ return false; }

	foreach($bill_data as $key => $val){
		if(stripos($key, 'txt') === false && stripos($key, 'select') === false && stripos($key, 'option') === false){ continue; }
		if(stripos($key, 'txt') !== false && (float)$val > 0){
			$n_key 		= str_replace('txt', '', $key);
			$data_tmp['txt'][$n_key] 	= $val;
			$data_tmp['select'][$n_key] = $bill_data['select'.$n_key];
			$data_tmp['option'][$n_key] = $bill_data['option'.$n_key];
		}
	}

	if(in_array($payment_term, array_keys($arr_payment_term_ar))){
		$arr_payment 		= query_maps('payment_column', 'id', 'payment');
		$sql 				= "SELECT pt.id, pt.payment_id,
									io.mapping_code
								FROM {$dbprefix}payment_type pt
								LEFT JOIN {$dbprefix}inventory_order io ON(io.id = pt.inventory_order_id)
								WHERE pt.inventory_order_id != '0'";
		$rs_payment_type 	= query_full($sql);
		foreach($rs_payment_type as $pay_type){
			$arr_payment_type[$pay_type['payment_id']][$pay_type['id']] = $pay_type['mapping_code'];
		}
		foreach($arr_payment as &$pay){
			$pay = $arr_payment_type[$pay];
		}
		
		foreach($data_tmp['select'] as $key => $val){
			if(empty($arr_payment[$key])){ continue; }
			$payment_group 		= $arr_payment[$key][$val];
			break;
		}
		$result = array(
			'meta' 					=> $data_tmp,
			'payment_group' 		=> $payment_group,
			'payment_group_desc' 	=> $arr_payment_group[$payment_group]
		);
		return $result;

	}else if($payment_term === '000'){
		$result = array(
			'meta' 					=> $data_tmp,
			'payment_group' 		=> '013',
			'payment_group_desc' 	=> $arr_payment_group['013']
		);
		return $result;
	}
}

function getMemberStructure(){
	global $dbprefix;
	$rs_member  = query_full("SELECT mcode, sp_code, upa_code, lr
							  FROM {$dbprefix}member
							  GROUP BY id ASC");
	foreach($rs_member as $member){
		$sp[$member['sp_code']][] = $member['mcode'];
	}

	$rs_team 	= query('mcode, team_id, subteam_id', $dbprefix.'member', "1=1 ORDER BY id ASC");
	foreach($rs_team as $val){
		$GLOBALS['member_team'][$val['mcode']] = array(
			'team_id' 		=> $val['team_id'],
			'subteam_id' 	=> $val['subteam_id']
		);
	}
	$rs_leader = query('id, name', $dbprefix.'team', "1=1 AND mcode_ref != ''");
	foreach($rs_leader as $val){
		$GLOBALS['team_leader'][$val['mcode_ref']]['team_id'] = $val['id'];
		$GLOBALS['team_leader'][$val['mcode_ref']]['team'] = $val['name'];
	}
	$rs_leader = query('id, name', $dbprefix.'subteam', "1=1 AND mcode_ref != ''");
	foreach($rs_leader as $val){
		$GLOBALS['team_leader'][$val['mcode_ref']]['subteam_id'] = $val['id'];
		$GLOBALS['team_leader'][$val['mcode_ref']]['subteam'] = $val['name'];
	}

	$data_m = updateMemberStructure($sp);
}

function updateMemberStructure($data_structure, $mcode = '', $level = 1, &$arr_member = []){
	global $dbprefix, $member_team, $team_leader;
	if($mcode == ''){
		$rs_top 	= query_full("SELECT mcode
							  	  FROM {$dbprefix}member 
							  	  WHERE sp_code = ''");
		foreach($rs_top as $topper){
			$mcode 	= $topper['mcode'];
			$arr_member[$mcode] = array(
				'sp_code' 	=> '',
				'level' 	=> $level
			);
			$arr_member = updateMemberStructure($data_structure, $mcode, $level, $arr_member);
		}
		return $arr_member;
	}else{
		if(isset($team_leader)){
			$upd_team = array(
				'team_id' 		=> $member_team[$mcode]['team_id'],
				'subteam_id' 	=> $member_team[$mcode]['subteam_id']
			);
			$arr_member[$mcode] = array_merge($arr_member[$mcode], $upd_team);
		}else{
			$sp_code = $arr_member[$mcode]['sp_code'];
			$upd_team = array(
				'team_id' 		=> $arr_member[$sp_code]['team_id'] ?? $member_team[$mcode]['team_id'],
				'subteam_id' 	=> $arr_member[$sp_code]['subteam_id'] ?? $member_team[$mcode]['subteam_id']
			);
		}

		if(!isset($data_structure[$mcode])){ return $arr_member; }

		$level++;
		foreach($data_structure[$mcode] as $child){
			$arr_member[$child] = array(
				'sp_code' 	=> $mcode,
				'level' 	=> $level,
			);
			$arr_member[$child] = array_merge($arr_member[$child], $upd_team);
			$arr_member = updateMemberStructure($data_structure, $child, $level, $arr_member);
		}
		return $arr_member;
	}
}

function insert_temp($table, ...$rs_data){
	$rs_column_tb 	= query_full("SHOW COLUMNS FROM {$table} WHERE field != 'id'");
	$arr_column_tb 	= array_fill_keys(array_column($rs_column_tb, 'Field'), '');
	$count_column 	= count($arr_column_tb);

	foreach($rs_data as $value){
		if($i == 0){
			$base_data = $value[0];
			$i++; continue;
		}
		
		if(!is_array($value[0])){ return false; }
		if(count($value[0]) < 1 || empty($value[1])){ continue; }
		$col_join 			= $value[1];
		$arr_coljoin[$i] 	= $value[2] ?? $value[1];
		$arr_data 			= array_column($value[0], null, $col_join);
		$arr_rs['query'.$i] = $arr_data;
		$i++;
	}

	$count_query = count($arr_rs);
	foreach($base_data as $key => $val){
		for($i = 1; $i <= $count_query; $i++){
			$data_tmp 	= $arr_rs['query'.$i];
			if(!isset($data_tmp)){ continue; }
			
			$column 	= $arr_coljoin[$i];
			if(isset($data_tmp[$val[$column]])){
				if($count_column > 0){
					$arr_intersect1 = array_intersect_key($base_data[$key], $arr_column_tb);
					$arr_intersect2 = array_intersect_key($data_tmp[$val[$column]], $arr_column_tb);
				}
				$r_data = array_merge($arr_column_tb ?? [], $base_data[$key], $data_tmp[$val[$column]]);
				if(count($r_data) !== $count_column){ return $base_data[$key]; }
				$base_data[$key] = $r_data;
			}
		}
	}

	if(count($base_data) > 0){
		truncate($table);
		muti_insert($table, $base_data);
	}
}

function setTaskInsertTemp($task_name, $set_minutes){
	if($task_name == ''){ return false; }
	$path 		= dirname(__DIR__).'/backoffice';
	$file 		= $path.'/task_insert_temp.txt';
	$content 	= getTaskInsertTemp($task_name, $file);

	$datetime 	= getfulldate('', 'Y-m-d H:i:s');
	if($content !== false && new DateTime($datetime) < new DateTime($content)){ return false; }
	
	$time 		= getfulldate('', 'Y-m-d H:i:s', "+".abs($set_minutes)." minutes");
	$task_entry = 'Task: '.$task_name.' - '.$time."\n";
	if(!file_exists($file) || !$content){
		file_put_contents($file, $task_entry, FILE_APPEND | LOCK_EX);
	}else{
		$tasks 		= getTaskInsertTemp($task_name, $file, true);
		$tasks[] 	= $task_entry;
		$handle 	= fopen($file, 'w');
		if($handle){
			foreach($tasks as $task){
				fwrite($handle, $task);
			}
			fclose($handle);
		}
	}
}

function getTaskInsertTemp($task_name, $path_file, $exclude = false){
	if(!file_exists($path_file)){ return false; }
	$tasks = array();

	$file = fopen($path_file, 'r');
	while(($line = fgets($file)) !== false){
		if(preg_match('/^Task: (\S+) - (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', trim($line), $matches)){
			if($exclude !== false){
				if($matches[1] !== $task_name){ $tasks[] = $line; }
				continue;
			}

			if($matches[1] === $task_name && !empty($matches[2])){
				fclose($file);
				return $matches[2];
			}
		}
	}
	fclose($file);
	return $exclude !== false ? $tasks : false;
}

function reorder_rs($arr_order, $rs_data){
	$arr_top = array();
	foreach($arr_order as $value){
		if(empty($value[0]) || empty($value[1])){ continue; }
		foreach($rs_data as $key => $val){
			if(preg_match('/'.preg_quote($value[1], '/').'/u', $val[$value[0]])){
				$arr_top[] = $val;
				unset($rs_data[$key]);
				break;
			}
		}
	}
	return array_merge($arr_top, $rs_data);
}
?>