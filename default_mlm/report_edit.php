<? session_start();
// require_once('connectmysql.php');
// require_once('global.php');
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
							<input type="text" class="form-control" autocomplete="off" name="" id="" value="<?= ''?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="input-group">
							<div class="input-group-addon" style="min-width: 100px;"><?= 'รหัส'?></div>
							<input type="text" class="form-control" autocomplete="off" name="" id="" value="">
							<span class="input-group-btn">
								<button type="button" class="btn btn-white btn-md btn-default no-border"><?= 'เลือก'?></button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group" style="padding-right: 0px;">
						<div class="input-group">
							<div class="input-group-addon" style="min-width:100px"><?= 'วันที่'?></div>
							<input class="form-control datepicker" autocomplete="off" name="" id="" value="">
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
						<select class="form-control minimal select2" name="" id="">
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
							<select class="form-control minimal select2" name="" id="">
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
							<input type="checkbox" class="ace" name="status" id="status" value="<?= $data['status']?>">
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
	$('#payment_method').attr('data-title', txt_fillin + '<?= $wording_lan['payment_method']?>')
	$('#payment_method').attr('required', '')
})
</script>