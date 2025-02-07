<? session_start();
// require_once('connectmysql.php');
// require_once('global.php');

// if(isset($_POST)){ getDataPOSTForm(); }
?>

<form class="form-horizontal" id="" action="" method="POST">
	<div class="row">
		<div class="col-md-6 col-md-offset-3" style="padding: 0px 0px;">
			<div class="col-md-12">
				<div class="text-title text-center">
					<div class="box-title "><font size="4px"><?= 'แก้ไข'?></font></div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="">
						<div class="input-group">
							<div class="input-group-addon" style="min-width:100px"><?= 'ชื่อ'?></div>
							<input type="text" class="form-control" autocomplete="off" id="" name="" value="<?= $data['name']?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="input-group">
							<div class="input-group-addon" style="min-width: 100px;"><?= 'รหัส'?></div>
							<input type="text" class="form-control" autocomplete="off" id="" name="" value="<?= $data['code']?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-white btn-md btn-default no-border" id="btn-select"><?= 'เลือก'?></button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="input-group">
							<div class="input-group-addon" style="min-width:100px"><?= 'วันที่'?></div>
							<input class="form-control datepicker" autocomplete="off" id="" name="" value="<?= $date?>">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:100px"><?= 'ระหว่างวันที่'?></span>
							<input type="text" class="form-control datepicker" autocomplete="off" name="sadate1" value="">
							<span class="input-group-addon" style="min-width:100px"><?= 'ถึง'?></span>
							<input type="text" class="form-control datepicker" autocomplete="off" name="sadate2" value="">
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<select class="form-control minimal select2" id="" name="" value="<?= $data['select']?>">
							<option value=""><?= 'กรุณาเลือก'?></option>
							<? 
							foreach($arr_select as $key => $val){
								?><option value="<?= $key?>" <?= ($data['key'] == $key ? 'selected': '')?>><?= $val?></option><?
							} ?>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon" style="min-width:100px"><?= 'เลือกรายการ'?><font color="#ff0000">*</font></div>
							<select class="form-control minimal select2" id="" name="" value="<?= $data['select']?>">
								<option value=""><?= $wording_lan["alert"]["waiting"]?>...</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group input-group" style="">
						<div class="input-group-addon" style="min-width:100px;"><?= $wording_lan['status']?></div>
						<input class="form-control text-right" type="text" id="flag-status" value="OFF" readonly>
						<div class="input-group-addon checkbox checkbox-info">
							<input type="checkbox" class="ace" id="status" name="status" value="<?= $data['status']?>">
							<label for="status">&nbsp;</label>
						</div>
					</div>
					<script>
						$('#status').on('change', function(){
							$('#flag-status').val(this.checked ? 'ON' : 'OFF')
							if(this.checked){ this.value = '1' }
						})
						if($('#status').val() == 1){
							$('#status').prop('checked', true)
							$('#status').trigger('change')
						}
					</script>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="text-title text-center">
							<div class="box-title "><font size="4px"><?= $wording_lan['remark']?></font></div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<textarea class="form-control" name="remark" style="height:120px" placeholder="กรุณากรอกข้อความ"><?= $data['remark']?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group text-center div-to-hide-xs">
						<button type="submit" class="btn btn-md btn-success">
							<?= $wording_lan["bt"]["save"]?>
						</button>
						<button type="reset" class="btn btn-md btn-danger" onclick="window.location='?sessiontab=<?= $_GET['sessiontab']?>&sub=<?= $_GET['sub']?>'">
							<?= $wording_lan["bt"]["cancle"]?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="modal-select" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<i class="glyphicon glyphicon-th"></i><?= $wording_lan["bt"]["choose_member"]?>
				</h4>
			</div>
			<div class="modal-body scroll-button">
				<table class="table table-hover" id="datatable-member" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?= $wording_lan["add"]?></th>
							<th><?= $wording_lan["member_id"]?></th>
							<th><?= $wording_lan["name_t"]?></th>
							<th><?= $wording_lan["member_type"]?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?= $wording_lan["close_window"]?></button>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function(){
	$('.select2').select2({ })
	$('.datepicker').datepicker({
		todayBtn: 'linked',
		format: 'yyyy-mm-dd',
		autoclose: true,
		language: 'th',
		todayHighlight: true
	});
	$('form').bootstrap3Validate(function(e, data) { })
	var txt_fillin = '<?= $wording_lan["pls_fillin"]?>'
	var txt_select = '<?= $wording_lan["pls_select"]?>'
	$('input[name="member"]').attr('data-title', txt_fillin + '<?= $wording_lan['member']?>')
	$('input[name="member"]').attr('required', '')


	$('#collector_id').on('change', function(){
		let mcode = $('#collector_id').val()
		if(mcode != ''){ select_mb(mcode) }
	})
	$('#collector_id').trigger('change')

	$('input[name="amount"]').on('blur', function(){
		validateInputAmount(this)
	})

	$("#btn-select").click(function(){
		const member_type = 'Collector'
		$('#modal-select').modal('show');
		$('#datatable-member').DataTable().clear().destroy();
		$('#datatable-member').DataTable({
			"ajax": { "url": `member_listpicker.php?&member_type=${member_type}` },
			"autoWidth": false,
			"oLanguage": {
				"sLengthMenu": "แสดง _MENU_ รายการ ต่อหน้า",
				"sZeroRecords": "<?=$wording_lan["data_not_fund"]?>",
				"sInfo": "<?=$wording_lan["Display"]?> _START_ <?=$wording_lan["Item"]?> <?=$wording_lan["From"]?> _TOTAL_ <?=$wording_lan["Item"]?> <?=$wording_lan["Each"]?> _END_ ",
				"sSearch": "<?=$wording_lan["search_branch"]?> :",
				"sSearchPlaceholder": "<?=$wording_lan["search_branch_1"]?>",
				"oPaginate": {
					"sFirst": "<?= $wording_lan["bt"]["page_first"]?>",
					"sLast": "<?= $wording_lan["bt"]["page_last"]?>",
					"sNext": "<?= $wording_lan["bt"]["page_next"]?>",
					"sPrevious": "<?= $wording_lan["bt"]["page_back"]?>",
				}
			},
			"columnDefs": [
				{
					"searchable": true,
					"className": "dt-center",
					"width": "10%",
					"targets": 0
				},
				{
					"searchable": true,
					"className": "dt-left",
					"width": "20%",
					"targets": 1
				}
			]	
		});
		$('.dataTables_length').hide();
	});
})

function validateInputAmount(input){
	let str_num = input.value.replace(/[^0-9.]/g, '')
	let parts = str_num.split('.');
	if(parts.length > 2){
		str_num = parts[0] + '.' + parts[1]
	}
	let num = Math.floor(parseFloat(str_num) * 100) / 100
	if(!Number(num)){
		input.value = ''
	}else{
		input.value = num.toFixed(2)
	}
}

function select_mb(id){
	const member_type = 'Collector';
	const url = `member_listpicker.php?&member_type=${member_type}`;
	fetch(url, {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: new URLSearchParams({ where: `mcode = ${id}` })
	}).then(function(res){
		return res.json()
	}).then(function(data){
		with(data.searchData){
			$('#collector_id').val(mcode)
			$('#collector_name').val(name_t)
		}
	}).catch(function(err){
		// console.log(`select_mb error: ${err}`)
		$('#collector_id').val('')
		$('#collector_name').val('')
	})
}
</script>