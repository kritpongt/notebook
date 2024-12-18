<? require('rpdialog.php');
?>

<script>
	function sale_print(id){
		var wlink = '../invoice/invoice_aprint_sale_temp.php?bid='+id;
		window.open(wlink);
	}
	function sale_look(id){
		var link 	= '<?=$actual_link?>invoice/invoice_aprint_sale_look.php';
		var wlink 	= link+'?bid='+id;
		window.open(wlink);
	}
	function sale_edit(id,sano_temp){
		var txt		= "แก้ไขเลขที่บิล: " + sano_temp;
		var link	= 'index.php?sessiontab=<?= $data["sessiontab"]?>&sub=<?= $data["sub"]?>&state=6&ctrl=edit&bid='+id;
		aconfirm(txt,link);
	}
	function sale_cancel(id,sano_temp){
		var txt		= "<?=$wording_lan["cancel_this_bill"]?> : "+sano_temp;
		var link	= 'index.php?sessiontab=<?=$data["sessiontab"];?>&sub=<?=$data["sub"];?>&state=4&bid='+id;
		remark_confirm(txt,link);
	}
</script>

<?
if($data['state'] == 4){
	include('report_editadd.php');
}else if($data['state'] == 5){
	include('report_operate.php');
}else{
	$case_status = ",CASE status_terminate WHEN '0' THEN CONCAT('<a onclick=\"status_terminate(0,\'',m.id,'\',\'',m.mcode,'\',\'" . $linkx . "\')\" style=\"cursor:pointer;\"><font class=\"text-danger\">NO</font></a>')
	ELSE CONCAT('<a Onclick=\"status_terminate(1,\'',m.id,'\',\'',m.mcode,'\',\'" . $linkx . "\')\"><font class=\"text-success\" style=\"cursor:pointer;\">YES</font></a>') END AS status_terminate ";

	$array_show = array(

	);
	$array_option = array(

	);
	/**
	 * $array_search
	 * 0 : text description
	 * 1 : gen rpdialog 
	 * 2 : rpdialog width (destop-tablet-mobile)-md-sm-xs
	 * 3 : rpdialog array show
	 * 4 : show / no show (search)
	 * 5 : fix / %LIKE% / between(-)
	 * 6 : sql where alias */
	$array_search = array(
		'locationbase' 	=> array($array_option["locationbase"][0], 'DROPDOWN_MULTI', '2-3-6', $arr_locationbase, ''),
		's_list' 		=> array($wording_lan["list_number"], 'DROPDOWN', '2-3-6', $arr_page, ''),
		'btn_search' 	=> array($wording_lan["bt"]["search"], 'SUBMIT', '2-3-12')
	);
	include('check_report_status.php');
	$arr_tmp 	= [''];
	$arr_show 	= array_filter($array_show, function($item) use($arr_tmp){
		return !in_array($item, $arr_tmp);
	});
	$sqlwhere 	= search_where($data, $arr_show, $array_option, $array_search);
	$sqlhaving 	= search_where($data, $arr_tmp, $array_option, $array_search);
	
	$sql = "SELECT * ";
	$sql .= "FROM {$dbprefix}table tb ";
	$sql .= "WHERE 1=1 ";
	$sql .= $sqlwhere;
	if($sqlhaving != ''){
		$sql .= ' HAVING '.$sqlhaving;
	}

	box_search_datatable($data, $array_search);

	$obj = new tables();
	$obj->setLimitPage($data['s_list']); 
	$obj->setQuery($sql);
	$obj->set_select($array_show);	
	$obj->set_sdesc($array_option);	
	$obj->set_option($array_search);
	$obj->setorder('id', 'DESC');
	// $obj->setHLight("status", 'YES', array("#FF9999"));

	/** 
	 * Access
	 * 1:   add
	 * 2:   edit
	 * 4:   del
	 * 8:   look
	 * 16:  download */
	// if($acc->isAccess(2)){
	// 	$obj->setSpecial("../images/true.gif", "", "sale_special", "id,mcode", "IMAGE", $wording_lan["re_pass"]);
	// 	$obj->setSpecial("../images/editlink.gif", "", "sale_edit", "id,sano_temp", "IMAGE", $wording_lan['edit']);
	// 	$obj->setSpecial("../images/cancel.gif", "", "sale_cancel", "id,sano_temp,linkx", "IMAGE",$wording_lan["bt"]["cancle"]);
	// 	================ one column multi select ================
	// 	$obj->setdel("index.php?sessiontab={$data['sessiontab']}&sub={$data['sub']}&state=5","id","id","<font class='txt-button-link' style='color:red;font-size:19px;'>"."ยืนยันรับชำระ"."</font>", 'ยืนยันรับชำระเงิน');
	// 	=========== more than one column multi select ===========
	// 	$obj->setselect('multi_cancel',"id","selfield","<font class='txt-button-link' >".$wording_lan["bt"]['cancle']."</font>", 'ยืนยันการยกเลิก', 1, '');
	// 	$obj->setselect("index.php?sessiontab=".$data['sessiontab']."&sub=".$data['sub']."&state=5","id","delfield","<font class='txt-button-link' style='color:red;font-size:19px;'>"."ยืนยันรับชำระ"."</font>", 'ยืนยันการชำระเงิน', 1, '');
	// }
	// if($acc->isAccess(8)){
	// 	$obj->setSpecial("../images/Amber-Printer.gif", "", "sale_print", "id", "IMAGE", $wording_lan["print"]);
	// 	$obj->setSpecial("../images/search.gif", "", "sale_look", "sano", "IMAGE", $wording_lan["look"]);
	// }

	$header = array(
		"name_ltd"	=> array($wording_lan["company_name_show"], 'center'),
		"header"	=> array($reportname, 'center'),
		"page_n"	=> array($wording_lan["Number-pages"], 'right'),
		"ist_user"	=> array($wording_lan["user_test"].$_SESSION['inv_usercode'], 'left'),
		"print_d"	=> array($wording_lan["date_print"].getfulldate('', "d/m/Y"), 'right')
	);
	if($_POST){
		$header['src_w'] = array($wording_lan["search_conditions"], 'right', $_POST);
	} 
	if($acc->isAccess(16)){
		$obj->setexcelnew($wording_lan["bt"]["load_excel"], 'report.xls', $header);
		$obj->setpdf($wording_lan["bt"]["load_pdf"], 'report.pdf', 14, 'L', $header);
		$obj->setSpecialButton($wording_lan["print_all"], '../invoice/invoice_aprint_sale.php?lid='.$_SESSION['admininvent'].$linkx);
	}
	$obj->showdata();
}
?>