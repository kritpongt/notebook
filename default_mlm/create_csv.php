<? session_start();
require("../backoffice/connectmysql.php");
require("../function/global_center.php");
require("../interface/class.interface.php");

set_time_limit(0);
ini_set('memory_limit', '4096M');

getDataGetForm();
$data 		= getDataForm_invoice();
$sql 		= data_decrypt($data['source']);
$rs 		= query_full($sql);

$path_save 	= '../function/fileexport/directory/'.date('d');
$path_l 	= '../function/fileexport/directory';
if(!is_dir($path_save)){
	mkdir($path_save, 0777, true);
	chmod($path_save, 0777);
}
if($_POST['print'] == 1){
	$conf_file = array(
		'name' 	=> $_POST['nfile'],
		'dest' 	=> $path_l,
	);
	$l_filename	= $conf_file['dest'].'/'.$conf_file['name'].'.json';
	$file		= fopen($l_filename, 'w');
	$count_rs	= count($rs);
	if($count_rs <= 0){
		echo json_encode(['st' => 'error']);
		exit;
	}
	$arr_loading = array('total' => $count_rs, 'current' => 0); 
	fwrite($file, json_encode($arr_loading)); 
	fclose($file);
}

$filename 	= "collector_assign_export_".getfulldate('', 'dmyhis').".csv";
$arr_head 	= ['No.', 'Contract No.', 'Install Seq.', 'Due date', 'Customer code', 'Customer name', 'Province', 'Collector code', 'Start date', 'End date'];
$path_full 	= $path_save.'/'.$filename;
$output 	= fopen($path_full, 'w');
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM
fputcsv($output, $arr_head);
$i 			= 1;
foreach($rs as $key => $val){
	$arr_record = array(
		$i,
		$val['contract_id'],
		$val['install_seq'],
		$val['install_date'],
		$val['customer_code'],
		$val['customer_name'],
		$val['province'],
		$val['collector_code'],
		$val['st_date'],
		$val['en_date']
	);
	fputcsv($output, $arr_record);
	$i+=1;
}
fclose($output);

if($_POST['print'] == 1){
	$json_data 	= file_get_contents($l_filename);
	if($json_data != false){
		$arr_loading['current'] += 1;
		if(file_put_contents($l_filename, $arr_loading) == false){
			echo json_encode(['st' => 'error']);
			exit;
		}
	}
}
if($_POST['print'] == 1){
	@unlink($l_filename);
	$res = array(
		'i_filename' 	=> $filename,
		'path' 			=> $path_full,
		'st' 			=> 'success'
	);
	echo json_encode($res);
}
exit;
?>