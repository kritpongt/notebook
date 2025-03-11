<? session_start();
require_once("connectmysql.php");
require_once("adminchecklogin.php");
session_write_close();

if($_GET['member_type'] != ''){
	$expl 		= explode(',', $_GET['member_type']);
	$arr_tmp 	= array();
	foreach($expl as $val){
		$arr_tmp = $arr_tmp + $arr_group_mtype1[strtolower($val)];
	}
	$str_mtype1 = implode("','", array_keys($arr_tmp));
	if($str_mtype1 != ''){
		$table_where = " AND m.mtype1 IN('".$str_mtype1."')";
	}
}

$table 		= " SELECT m.mcode, m.name_t,
					CONCAT('<img style=\"cursor:pointer\" src=\"../images/add_pic.gif\" name=\"[]\" onclick=\"select_mb(\'',m.mcode,'\')\" data-dismiss=\"modal\">')as btn_selector
					provinceId, amphurId, districtId, zip
				FROM `ali_member` m  WHERE 1 {$table_where}";
if($_POST['searchData'] != ''){ $where .= ' WHERE 1 AND '.$_POST['searchData']; }
$order 		= "ORDER BY mcode ASC";
$limit		= "";

$column 			= array('btn_selector','mcode','name_t', 'mtype1', 'provinceId');
$query 				= "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $column)." FROM ({$table})tb {$where} {$order} {$limit}";
$result_mysqli 		= mysqli_query($linksql, $query);
if(!$result_mysqli){ echo $query; die(mysqli_error($linksql)); }

$query 				= "SELECT FOUND_ROWS()";
$result_mysqli_row 	= mysqli_query($linksql, $query);
$number_row 		= mysqli_fetch_array($result_mysqli_row);

$output = array(
	"sEcho" 				=> intval($_GET['sEcho']),
	"iTotalRecords" 		=> $iTotal,
	"iTotalDisplayRecords" 	=> $number_row[0],
	"aaData" 				=> array(),
);

while($aRow = mysqli_fetch_array($result_mysqli)){
	for($i = 0; $i < count($column); $i++){
		$row[$i] = $aRow[$column[$i]];
	}
	$output['aaData'][] = $row;
	if($_POST['searchData'] != ''){
		$output['searchResult'] = array(
			'mcode' 	=> $aRow['mcode'],
			'name_t' 	=> $aRow['name_t'],
			'mtype1' 	=> $aRow['mtype1'],
			'province' 	=> $aRow['provinceId'],
		);
	}
}

echo json_encode($output);
?>