<? 
define('INTERFACE_PATH', __DIR__.'/');
define('INTERFACE_AR_PATH', INTERFACE_PATH.'ar/');
define('EXPORT_DDR_PATH', INTERFACE_AR_PATH.'out/');
define('EXPORT_DDR_URL', '../interface/ar/out/');

$encryptionKey = '-2m$5RY0^53~';

$interface_input = array(
	'ktb' => array(
		'special_structure' => array(
			'head' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'bank_code' 		=> [3, ' '],
				'company_account' 	=> [10, ' '],
				'company_name' 		=> [25, ' '],
				'effective_date' 	=> [6, ' '],
				'filler' 			=> [89, '0'],
			),
			'detail' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'bank_code' 		=> [3, ' '],
				'account_number' 	=> [10, ' '],
				'transaction_code' 	=> [1, ' '],
				'amount' 			=> [13, '0'],
				'service_type' 		=> [2, ' '],
				'status' 			=> [1, ' '],
				'user_reference' 	=> [103, ' '],
			),
			'trailer' => array(
				'record_type' 			=> [1, ' '],
				'sequence_no' 			=> [6, '0'],
				'bank_code' 			=> [3, ' '],
				'company_a/c_no' 		=> [10, '0'],
				'number_of_debit' 		=> [7, '0'],
				'total_debit_amount' 	=> [18, '0'],
				'number_of_credit' 		=> [7, '0'],
				'total_credit_amount' 	=> [18, '0'],
				'filer' 				=> [70, '0'],
			)
		),
		'transaction_code' => array(
			'D' => array('number_of_debit', 'total_debit_amount'),
			'C' => array('number_of_credit', 'total_credit_amount')
		)
	),
	'bbl' => array(
		'standard_format' => array(
			'head' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'bank_code' 		=> [3, ' '],
				'company_account' 	=> [10, ' '],
				'company_name' 		=> [40, ' '],
				'effective_date' 	=> [8, ' '],
				'service_code'      => [8, ' '],
				'spare' 			=> [77, ''],
			),
			'detail' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'bank_code' 		=> [3, ' '],
				'company_account'	=> [10, ' '],
				'payment_date'		=> [8, '0'],
				'payment_time'		=> [6, '0'],
				'customer_name'		=> [50, ' '],
				'customer_no/ref_1'	=> [20, ' '],
				'ref_2'				=> [20, ' '],
				'ref_3'				=> [20, ' '],
				'branch_no'			=> [4, '0'],
				'teller_no'			=> [4, '0'],
				'kind_of_transaction'=> [1, ' '],
				'transaction_code'	=> [3, ' '],
				'cheque_no'			=> [7, ' '],
				'amount'			=> [13, '0'],
				'cheque_bank_code'	=> [3, '0'],
				'spare'				=> [77, ' '],
			),
			'trailer' => array(
				'record_type' 				=> [1, ' '],
				'sequence_no' 				=> [6, '0'],
				'bank_code' 				=> [3, '0'],
				'company_a/c' 				=> [10, '0'],
				'total_debit_payment_comm'	=> [13, '0'],
				'total_debit_transaction'	=> [6, '0'],
				'total_credit_payment_amt'	=> [13, '0'],
				'total_credit_transaction'	=> [6, '0'],
				'total_discount_credit_card'=> [13, '0'],
				'total_vat_credit_card'		=> [10, '0'],
				'spare'						=> [175, ' '],
			)
		),
		'kind_of_transaction' => array(
			'D' => array('total_debit_transaction', 'total_debit_payment_comm'),
			'C' => array('total_credit_transaction', 'total_credit_payment_amt')
		)
	),
	'counter_service' => array(
		'standard_format' => array(
			'head' => array(
				'record_type' 		=> [1, ' '],
				'process_date'      => [8, ' '],
				'client_no'         => [3, ' '],
				'client_name'       => [50, ' '],
				'tax_id'            => [10 ,' '],
				'filler'            => [338, ' '],
			),
			'detail' => array(
				'record_type' 		    => [1, ' '],
				'counter_no'            => [5, '0'],
				'term_no'               => [1, '0'],
				'pos_tax_id'            => [20, ' '],
				'service_run_no'        => [6, '0'],
				'record_status'         => [1, ' '],
				'operating_date'        => [8, ' '],
				'operating_time'        => [6, ' '],
				'client_service_no'     => [2, ' '],
				'client_service_runno'  => [6, ' '],
				'vat_rate'              => [4, '0'],
				'amount_received'       => [9, '0'], // ทั้งหมด 10 หลัก รวม '+' ด้านหน้าตัวเลข
				'vat_amount'            => [9, '0'], // ทั้งหมด 10 หลัก รวม '+' ด้านหน้าตัวเลข
				'bill_type'             => [1, ' '],
				'bill_no'               => [6, '0'],
				'customer_name'         => [50, ' '],
				'customer_addr_1'       => [40, ' '],
				'customer_addr_2'       => [40, ' '],
				'customer_addr_3'       => [40, ' '],
				'customer_tell_no'      => [20, ' '],
				'reference_1'           => [25, ' '],
				'reference_2'           => [25, ' '],
				'reference_3'           => [25, ' '],
				'reference_4'           => [25, ' '],
				'comm_paid_code'        => [1, ' '],
				'zone'                  => [2, ' '],
				'r_service_runno'       => [6, ' '],
				'canceloperating'       => [8, ' '],
				'operate_by_staff'      => [7, ' '],
				'operating_round'       => [1, ' '],
				'tel_code'              => [3, ' '],
				'filler'                => [6, ' '],
			),
			'trailer' => array(
				'record_type' 			=> [1, ' '],
				'record_count'          => [8, '0'],
				'total_amount'          => [12, '0'],
				'filler'                => [388, ' '],
			),
		),
		'bill_type' => array(
			'H' => array('record_count', 'total_amount'),
		)
	),
	'scb' => array(
		'standard_format' => array(
			'head' => array(
				'record_type' 		=> [1, ''],
				'sequence_no' 		=> [6, '0'],
				'bank_code' 		=> [3, '0'],
				'company_account' 	=> [10, '0'],
				'company_name' 		=> [40, ' '],
				'effective_date' 	=> [8, '0'],
				'service_code'      => [8, ' '],
				'spare' 			=> [180, ' '],
			),
			'detail' => array(
				'record_type' 		    => [1, ' '],
				'sequence_no' 		    => [6, '0'],
				'bank_code' 		    => [3, '0'],
				'company_account'       => [10, '0'],
				'payment_date'          => [8, '0'],
				'payment_time'          => [6, '0'],
				'customer_name'         => [50, ' '],
				'customer_no_ref_1'     => [20, ' '],
				'ref_2'                 => [20, ' '],
				'ref_3'                 => [20, ' '],
				'branch_no'             => [4, '0'],
				'teller_no'             => [4, '0'],
				'kind_of_transaction'   => [1, ' '],
				'transaction_code'      => [3, ' '],
				'cheque_no'             => [7, '0'],
				'amount'                => [13, '0'],
				'chq_bank_code'         => [3, '0'],
				'spare'                 => [77, ' '],
			),
			'trailer' => array(
				'record_type' 			    => [1, ' '],
				'sequence_no' 			    => [6, '0'],
				'bank_code' 			    => [3, '0'],
				'company_account' 		    => [10, '0'],
				'total_debit_amount'        => [13, '0'],
				'total_debit_transaction'   => [6, '0'],
				'total_credit_amount'       => [13, '0'],
				'total_credit_transaction'  => [6, '0'],
				'spare'                     => [198, ' '],
			),
		),
		'kind_of_transaction' => array(
			'D' => array('total_debit_transaction', 'total_debit_amount'),
			'C' => array('total_credit_transaction', 'total_credit_amount')
		)
	),
	'thai_post' => array(
		'standard_format' => array(
			'head' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'cat_code'          => [3, ' '],
				'company_account'   => [10, '0'],
				'company_name'      => [40, ' '],
				'effective'         => [8, ' '],
				'service_code'      => [8, ' '],
				'spare'             => [100, ' '],
			),
			'detail' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'cat_code'          => [3, ' '],
				'payment_date'      => [16, '0'],
				'ref_1'             => [20, ' '],
				'ref_2'             => [20, ' '],
				'ref_3'             => [20, ' '],
				'postoffice_no'     => [6, '0'],
				'pos_id'            => [13, ' '],
				'transaction_num'   => [9, '0'],
				'receive_num'       => [9, ' '],
				'amount'            => [13, '0'],
				'vat'               => [10, '0'],
				'customer_name'     => [30, ' '],
			),
			'trailer' => array(
				'record_type' 			=> [1, ' '],
				'sequence_no' 			=> [6, '0'],
				'cat_code'              => [3, ' '],
				'company_account'       => [10, '0'],
				'total_amount'          => [13, '0'],
				'total_transaction'     => [6, '0'],
				'spare'                 => [137, ' '],
			),
		),
		'cat_code' => array(
			'THP' => array('total_transaction', 'total_amount'),
		),
	),
	'gsb' => array(
		'standard_format' => array(
			'head' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'service_type'      => [2, ' '],
				'r_fee'             => [2, '0'],
				'bank_code' 		=> [4, '0'],
				'company_code'      => [4, ' '],
				'classify_type'     => [6, ' '],
				'company_name'      => [25, ' '],
				'company_acc_1'     => [12, ' '],
				'company_acc_2'     => [3, ' '],
				'effective_date'    => [6, '0'],
				'filler'            => [57, ' '],
			),
			'detail' => array(
				'record_type' 		=> [1, ' '],
				'sequence_no' 		=> [6, '0'],
				'service_type'      => [2, ' '],
				'acc_no_1'          => [12, ' '],
				'acc_no_2'          => [3, ' '],
				'atm'               => [10, '0'],
				'status_flag'       => [1, ' '],
				'cust_name'         => [30, ' '],
				'company_desc'      => [63, ' '],
			),
			'trailer' => array(
				'record_type' 			=> [1, ' '],
				'sequence_no' 			=> [6, '0'],
				'service_type'          => [2, ' '],
				'r_fee'                 => [2, ' '],
				'bank_code'             => [4, '0'],
				'company_code'          => [4, '0'],
				'classify_type'         => [6, ' '],
				'trn_total'             => [8, '0'],
				'amt_total'             => [15, '0'],
				'succ_trn_total'        => [8, '0'],
				'succ_amt_total'        => [15, '0'],
				'rej_trn_total'         => [8, '0'],
				'rej_amt_total'         => [15, '0'],
				'filler'                => [34, ' '],
			),
		),
		'status_flag' => array(
			'9' => array('trn_total','amt_total'),
		),
	),
);

function interface_bank_ddr($bank, $format, $head, $detail, $total, $record, $tx){
	global $interface_input;
	$conf 			= $interface_input[$bank][$format];
	$transactions 	= $interface_input[$bank][$tx];
	$arr_trans 		= array();
	foreach($transactions as $arr){
		$arr_trans 	= array_merge($arr_trans, $arr);
	}
	$arr_head 		= $head;
	$arr_detail 	= $detail;
	$arr_trailer 	= $total;
	foreach($conf as $key => $arr_field){
		switch($key){
			case 'head':
				foreach($arr_field as $k => $v){
					$h_content .= adjustStrLen($arr_head[$k], $v[0], $v[1]);
				}
				$h_content .= "\n";
				break;
			case 'detail':
				$d_content = array_reduce($record, function($result, $item) use($arr_field, $transactions, $tx, &$arr_detail, &$arr_trailer, $bank){
					foreach($arr_field as $k => $v){
						if(empty($arr_detail[$k])){
							if(in_array($k, ['amount','amount_received','atm'])){
								if(in_array($bank, ["counter_service"])){ $result .= '+'; }
								$result .= adjustStrLen($item[$k], $v[0], $v[1], 'LEFT');
								$amount = $item[$k];
								foreach($transactions as $index => $value){
									if(strtolower($index) == strtolower($item[$tx])){
										$arr_trailer[$value[0]] += 1;
										$arr_trailer[$value[1]] += $amount;
									}
								}
							}else if(in_array($k, ["vat_amount"])){
								$result .= adjustStrLen('+'.$item[$k], $v[0], $v[1], 'LEFT');
							}else{
								$result .= adjustStrLen($item[$k], $v[0], $v[1]);
							}
						}else if(!empty($arr_detail[$k]) && in_array($k, ['sequence_no'])){
							$result .= adjustStrLen($arr_detail[$k], $v[0], $v[1], 'LEFT');
							$arr_detail[$k] = (int)$arr_detail[$k] + 1;
						}else{
							$result .= adjustStrLen($arr_detail[$k], $v[0], $v[1]);
						}
					}
					$result .= "\n";
					return $result;
				}, '');
				break;
			case 'trailer':
				foreach($arr_field as $k => $v){
					if(in_array($k, ['sequence_no'])){
						$t_content .= adjustStrLen($arr_detail[$k], $v[0], $v[1], 'LEFT');
					}else if(in_array($k, $arr_trans)){
						if(in_array($bank, ["counter_service"]) && in_array($k, ['total_amount'])){ $arr_trailer[$k] = '+'.$arr_trailer[$k]; }
						$t_content .= adjustStrLen($arr_trailer[$k], $v[0], $v[1], 'LEFT');
					}else{
						$t_content .= adjustStrLen($arr_trailer[$k], $v[0], $v[1]);
					}
				}
				$t_content .= "\n";
				break;
		}
	}
	return $h_content.$d_content.$t_content;
}

function adjustStrLen($str, $length, $pad_char = '', $flag = 'RIGHT'){
	$len = mb_strlen($str, 'UTF-8');
	if($len < $length){
        // Padding
        $padding = str_repeat($pad_char, ($length - $len));
		if($flag == 'RIGHT'){
            $result = $str.$padding;
        }else if($flag == 'LEFT'){
            $result = $padding.$str;
        }
	}else{
        // Trimming
        if($flag == 'RIGHT'){
            $result = mb_substr($str, 0, $length, 'UTF-8');
        }else if($flag == 'LEFT'){
            $result = mb_substr($str, ($len - $length), $length, 'UTF-8');
        }
	}
	return $result;
}

function data_encrypt($data){
	global $encryptionKey;
	$method = 'AES-256-ECB';
	$result = base64_encode(openssl_encrypt($data, $method, $encryptionKey));
	return $result;
}

function data_decrypt($data){
	global $encryptionKey;
	$method = 'AES-256-ECB';
	$result = openssl_decrypt(base64_decode($data), $method, $encryptionKey);
	return $result;
}

function readFileCSV($path_file){
	$content 	= convertStringUTF8($path_file);
	if($content !== false){
		$file 	= fopen('php://temp', 'rw+');
		fwrite($file, $content);
		rewind($file);
	}else{
		$file 	= fopen($path_file, 'r');
	}
	while(($row = fgetcsv($file)) !== false){
		yield $row;
	}
	fclose($file);
}

function convertStringUTF8($path_file){
	$content 	= file_get_contents($path_file);
	$encoding 	= mb_detect_encoding($content, mb_detect_order(), true);
	if($encoding !== 'UTF-8' && $encoding !== false){
		$converted_str = mb_convert_encoding($content, 'UTF-8', $encoding);
	}else{
		return false;
	}
	return $converted_str;
}

// ====== ใช้ที่ ar_bank_statement_check.php ====== //
function get_bank_statement_bbl($path_file){
	$arr_csv 	= readFileCSV($path_file);
	$i 			= 1;
	foreach($arr_csv as $row){
		if($i < 8){
			$i++;
			continue;
		}
		foreach($row as &$val){
			$val = trim($val);
		}
		$content[] = array(
			'datetime' 		=> convertToDATETIME($row[0]),
			'description' 	=> $row[4],
			'cheque_no' 	=> $row[7],
			'amount' 		=> $row[13],
			'branch' 		=> $row[19]
		);
	}
	return chk_bank_statement($content);
}

function get_bank_statement_ktb($path_file){
	$arr_csv 	= readFileCSV($path_file);
	$i 			= 1;
	$j 			= 0;
	foreach($arr_csv as $row){
		if($i < 9){
			$i++;
			continue;
		}else if(trim($row[0]) == ''){
			$j++;
			continue;
		}else if($j == 2){
			break;
		}
		foreach($row as &$val){
			$val = trim($val);
		}
		if($row[1] != ''){ $teller_id = ' (Teller ID: '.$row[1].')'; }
		$content[] = array(
			'datetime' 			=> convertToDATETIME($row[0]),
			'transaction_code' 	=> $row[2],
			'description' 		=> $row[3].$teller_id,
			'cheque_no' 		=> $row[4],
			'amount' 			=> $row[5],
		);
	}
	return chk_bank_statement($content);
}

function get_bank_statement_scb($path_file){
	$arr_csv 	= readFileCSV($path_file);
	$i 			= 1;
	foreach($arr_csv as $row){
		if($i < 2){
			$i++;
			continue;
		}
		foreach($row as &$val){
			$val = trim($val);
		}
		$content[] = array(
			'datetime' 			=> convertToDATETIME($row[1].' '.$row[2]),
			'transaction_code' 	=> $row[3],
			'channel' 			=> $row[4],
			'cheque_no' 		=> $row[5],
			'description' 		=> $row[10],
			'amount' 			=> $row[7],
		);
	}
	return chk_bank_statement($content);
}

function get_bank_statement_kbank($path_file){
	$arr_csv 	= readFileCSV($path_file);
	$i 			= 1;
	foreach($arr_csv as $row){
		if($i < 11){
			$i++;
			continue;
		}
		foreach($row as &$val){
			$val = trim($val);
		}
		$content[] = array(
			'datetime' 			=> convertToDATETIME($row[0].' '.$row[1]),
			'branch' 			=> $row[8],
			'transaction_code' 	=> $row[7],
			'channel' 			=> $row[10],
			'description' 		=> $row[11],
			'amount' 			=> $row[5],
		);
	}
	return chk_bank_statement($content);
}

function chk_bank_statement($arr_content){
	if(count($arr_content) < 1){ return false; }

	foreach($arr_content as &$val){
		$normalize_float = floatval(str_replace(',', '', $val['amount']));
		if($val['datetime'] == '' || $normalize_float <= 0){
			$val['status'] 	= '<font color=red>FAILURE</font>';
			$no_data 		+= 1;
			continue;
		}
		$val['status'] 	= '<font color=green>SUCCESS</font>';
		$success 		+= 1;
	}
	$status = array(
		'success' 	=> $success,
		'error' 	=> $error,
		'no_data' 	=> $no_data,
		'total' 	=> count($arr_content)
	);
	return ['content' => $arr_content, 'status' => $status];
}

function convertToDATETIME($input_date){
	$thaiMonths = [
        '01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.',
        '05' => 'พ.ค.', '06' => 'มิ.ย.', '07' => 'ก.ค.', '08' => 'ส.ค.',
        '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.'
    ];
	foreach($thaiMonths as $key => $val){
		if(strpos($input_date, $val) !== false){
			$input_date = str_replace($val, $key, $input_date);
			break;
		}
	}
	$datetime		= explode(' ', $input_date);
	$date 			= $datetime[0];
	$time 			= $datetime[1] ?? '';
	if(is_numeric($date)){
		$new_date 	= getfulldate('1900-01-01', 'Y-m-d', '+'.($date - 2).'days');
	}else if($date != ''){
		$chk_date 	= DateTime::createFromFormat('Y-m-d', $date);
		if($chk_date && $chk_date->format('Y-m-d') === $date){
			$new_date 			= $date;
		}else{
			$date_str			= preg_replace('/([^0-9]+)/', '-', $date);
			$arr_date			= explode('-', $date_str);
			list($d, $m, $y) 	= $arr_date;
			$year_now 			= getfulldate('', 'y');
			if($y > ($year_now + 20) && strlen($y) == 2){
				$new_date 		= getfulldate("25{$y}-{$m}-{$d}", 'Y-m-d', '-543 year');
			}else{
				$new_date 		= getfulldate("{$y}-{$m}-{$d}", 'Y-m-d');
			}
		}
	}
	if($time != ''){
		$obj_time 	= DateTime::createFromFormat('G:i', $time);
		if($obj_time !== false){
			$time 	= $obj_time->format('H:i:s');
		}
	}
	return $new_date.' '.$time;
}

require_once("../PHPExcel/Classes/PHPExcel.php");
// OLD PHPExcel Read Excel File
function excelReader($tmp_file){
	$excelReader 	= PHPExcel_IOFactory::createReaderForFile($tmp_file);
	// $excelReader->setReadDataOnly(true);
	$excelObj 		= $excelReader->load($tmp_file);
	$spreadsheet 	= $excelObj->getSheetNames();
	foreach($spreadsheet as $key => $val){
		$worksheet 	= $excelObj->getSheet($key);
		foreach($worksheet->getRowIterator() as $index => $row){
			$rowData = array();
			foreach($row->getCellIterator() as $cell){
				$rowData[] = $cell->getValue();
			}
			$arr_filter = array_filter($rowData, function($item){
				return !empty($item);
			});
			if(count($arr_filter) < 1){
				$countEmpty++;
				if($countEmpty == 3){ break; }
				continue;
			}else{
				$countEmpty = 0;
			}
			yield $key => $rowData;
		}
	}
}

function addressExtraction($address){
	$address = trim($address);
	if($address == ''){ return false; }
	preg_match('/(.*?)\s(ต\.|ตำบล|แขวง|อ\.|อำเภอ|เขต)/', $address, $matches_address);
	preg_match('/(ต\.|ตำบล|แขวง)(.+?)\s/', $address, $matches_district);
	preg_match('/(อ\.|อำเภอ|เขต)(.+?)\s/', $address, $matches_area);
	preg_match('/(จ\.|จังหวัด)(.+?)(?:\s(\d{5}))?$/', $address, $matches_province);
	$result = array(
		'address' 		=> $matches_address[1],
		'district' 		=> $matches_district[2],
		'area' 			=> $matches_area[2],
		'province' 		=> $matches_province[2],
		'postal_code' 	=> $matches_province[3]
	);
	return $result;
}

function vocationMapId(string $text){
	global $arr_vocation;
	if(empty($text)){ return false; }
	$arr_career = array(
		'1' => ['ครู', 'อาจารย์'],
		'2' => ['พยาบาล', 'แพทย์'],
		'3' => ['ร้านค้า'],
		'4' => ['เกษตร'],
		'5' => ['เจ้าของบริษัท'],
		'6' => ['พนักงาน'],
		'7' => ['ราชการ', 'รัฐ']
	);
	foreach($arr_career as $key => $arr_keyword){
		foreach($arr_keyword as $word){
			if(mb_strpos($text, $word, 0, 'UTF-8') !== false){
				return $key;
			}
		}
	}
	return '99';
}

function extractAddressParts(...$arr_str){
	$result = array();
	foreach($arr_str as $key => $val){
		if(empty($val)){ continue; }
		array_push($result, addressExtraction($val));
	}
	return $result;
}
?>