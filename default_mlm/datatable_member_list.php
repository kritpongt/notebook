<?
header('Content-Type: application/json');

session_start();
require_once("connectmysql.php");
require_once("adminchecklogin.php");
session_write_close();

$q 				= $_POST['q'];
$start 			= $_POST['start'];
$length 		= $_POST['length'];

if($_GET['member_type'] != ''){
	$expl 		= explode(',', $_GET['member_type']);
	$arr_tmp 	= array();
	foreach($expl as $val){
		$arr_tmp = $arr_tmp + $arr_group_mtype1[strtolower($val)];
	}
	$str_mtype1 = implode("','", array_keys($arr_tmp));
	if($str_mtype1 != ''){
		$where1 = " AND m.mtype1 IN('".$str_mtype1."')";
	}
}

$col_btn 			= ['btn'];
$col_tb 			= ['mcode', 'name_t', 'mtype1', 'provinceId'];
$columns 			= array_merge($col_btn, $col_tb);
if($q != '' && count($col_tb) > 0){
	foreach($col_tb as $col){
		$arr_where[] = " {$val} LIKE '%{$q}%'";
	}
	$where2 		.= " AND (".implode(' OR ', $arr_where).")";
}
$sub_query 			= " SELECT m.mcode, m.name_t,
							CONCAT('<img style=\"cursor:pointer\" src=\"../images/add_pic.gif\" name=\"[]\" onclick=\"select_mb(\'',m.mcode,'\')\" data-dismiss=\"modal\">')as btn_selector
							provinceId, amphurId, districtId, zip
						FROM `ali_member` m 
						WHERE 1 {$where1} {$where2}";
if($_POST['searchData'] != ''){ $where .= ' WHERE 1 AND '.$_POST['searchData']; }
$order 				= "ORDER BY mcode ASC";
if($start != '' && $length != ''){ $limit = "LIMIT {$start}, {$length}"; }

$query 				= "SELECT SQL_CALC_FOUND_ROWS ".implode(",", $columns)." FROM ({$sub_query})tb {$where} {$order} {$limit}";
$result_mysqli 		= mysqli_query($linksql, $query);
if(!$result_mysqli){ echo $query; die(mysqli_error($linksql)); }

$query 				= "SELECT FOUND_ROWS()";
$result_mysqli_row 	= mysqli_query($linksql, $query);
$count_rs 			= mysqli_fetch_array($result_mysqli_row);
$query 				= "SELECT COUNT(1) FROM ali_member";
$result_mysqli_row 	= mysqli_query($linksql, $query);
$total 				= mysqli_fetch_array($result_mysqli_row);

$output = array(
	"sEcho" 				=> intval($_GET['sEcho']),
	"iTotalRecords" 		=> $total[0],
	"iTotalDisplayRecords" 	=> $count_rs[0],
	"aaData" 				=> array(),
);

while($aRow = mysqli_fetch_array($result_mysqli)){
	for($i = 0; $i < count($columns); $i++){
		$row[$i] = $aRow[$columns[$i]];
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