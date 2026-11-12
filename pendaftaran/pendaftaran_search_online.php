<?php
$site = '';
$group = '';
$loket_1 = '';
$loket_2 = '';

if(isset($_SESSION['pendaftaran_mandiri_site'])) 
	$site = $_SESSION['pendaftaran_mandiri_site'];
if(isset($_SESSION['pendaftaran_mandiri_group'])) 
	$group = $_SESSION['pendaftaran_mandiri_group'];
if(isset($_SESSION['pendaftaran_mandiri_loket_1'])) 
	$loket_1 = $_SESSION['pendaftaran_mandiri_loket_1'];
if(isset($_SESSION['pendaftaran_mandiri_loket_2'])) 
	$loket_2 = $_SESSION['pendaftaran_mandiri_loket_2'];

if(isset($_POST['simpan'])){
	$_SESSION['pendaftaran_mandiri_site'] = $_POST['site'];
	$_SESSION['pendaftaran_mandiri_group'] = $_POST['group'];
	$_SESSION['pendaftaran_mandiri_loket_1'] = $_POST['loket_1'];
	$_SESSION['pendaftaran_mandiri_loket_2'] = $_POST['loket_2'];
	
	$site = $_POST['site'];
	$group = $_POST['group'];
	$loket_1 = $_POST['loket_1'];
	$loket_2 = $_POST['loket_2'];
	
	$loket = '';
	if($loket_1 != '') $loket .= $loket_1;
	if($loket_2 != '') $loket .= $loket_2;
}
?>
<style type="text/css">
<!--
.style1 {font-size: 42px; font-weight: bold;}
.style2 {font-size: 24px; font-weight: bold;}
-->
</style>
<table width="400px" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<div class="div_menu" style=" height:auto;position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
			<form name="form_antrian" method="post" >
			<table border="0" width="100%">
				<tr>
					<td width="120px">LOKASI</td>
					<td width="20px">&nbsp;&nbsp;:&nbsp;</td>
					<td><select name="site" class="text_dt" style="width:200px;" required>
						<option value=""> -- </option>
						<?php 
							$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
							mysql_select_db($database_4, $connect_4) or die(mysql_error());
							
							$query = mysql_query('SELECT m_site.SITE_ID,m_site.NAMA_SITE
											FROM m_site') or die(mysql_error());
							while($data = mysql_fetch_array($query)){
								echo '<option value="' . $data['SITE_ID'] . '" ' . (($data['SITE_ID']== $site) ? 'selected="selected"' : '') . ' >' . $data['NAMA_SITE'] . '</option>';
							}				
						?>
					</select></td>
				</tr>
				<tr>
					<td>GROUP</td>
					<td>&nbsp;&nbsp;:&nbsp;</td>
					<td><select name="group" class="text_dt" style="width:150px;">
						<option value=""> -- </option>
						<option value="A" <?php if($group == 'A') echo 'selected="selected"'; ?> >A</option>
						<option value="B" <?php if($group == 'B') echo 'selected="selected"'; ?> >B</option>
						<option value="C" <?php if($group == 'C') echo 'selected="selected"'; ?> >C</option>
						<option value="D" <?php if($group == 'D') echo 'selected="selected"'; ?> >D</option>
						<option value="E" <?php if($group == 'E') echo 'selected="selected"'; ?> >E</option>
					</select></td>
				</tr>
				<tr>
					<td>LOKET</td>
					<td>&nbsp;&nbsp;:&nbsp;</td>
					<td><select name="loket_1" class="text_dt" style="width:70px;">
						<option value=""> -- </option>
						<option value="A" <?php if($loket_1 == 'A') echo 'selected="selected"'; ?> >A</option>
						<option value="B" <?php if($loket_1 == 'B') echo 'selected="selected"'; ?> >B</option>
						<option value="C" <?php if($loket_1 == 'C') echo 'selected="selected"'; ?> >C</option>
						<option value="D" <?php if($loket_1 == 'D') echo 'selected="selected"'; ?> >D</option>
						<option value="E" <?php if($loket_1 == 'E') echo 'selected="selected"'; ?> >E</option>
					</select>
					<select name="loket_2" class="text_dt" style="width:77px;">
						<option value=""> -- </option>
						<option value="1" <?php if($loket_2 == '1') echo 'selected="selected"'; ?> >1</option>
						<option value="2" <?php if($loket_2 == '2') echo 'selected="selected"'; ?> >2</option>
						<option value="3" <?php if($loket_2 == '3') echo 'selected="selected"'; ?> >3</option>
						<option value="4" <?php if($loket_2 == '4') echo 'selected="selected"'; ?> >4</option>
						<option value="5" <?php if($loket_2 == '5') echo 'selected="selected"'; ?> >5</option>
						<option value="6" <?php if($loket_2 == '6') echo 'selected="selected"'; ?> >6</option>
						<option value="7" <?php if($loket_2 == '7') echo 'selected="selected"'; ?> >7</option>
						<option value="8" <?php if($loket_2 == '8') echo 'selected="selected"'; ?> >8</option>
						<option value="9" <?php if($loket_2 == '9') echo 'selected="selected"'; ?> >9</option>
						<option value="10" <?php if($loket_2 == '10') echo 'selected="selected"'; ?> >10</option>
					</select></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><input type="submit" name="simpan" value="SIMPAN" class="myButton" /></td>
				</tr>
			</table>
			<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
			</form>
		</div>
	</td>
</tr>
<tr>
	<td>
		<?php if(isset($_SESSION['pendaftaran_mandiri_site'])){ 
			if($loket == '') $msg_info = 'Loket Belum Dipilih.'; 
		?>
		<div class="div_menu" style=" height:auto;position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
			<table border="0" width="100%">
				<tr>
					<td width="120px">NOMOR ANTRIAN</td>
					<td width="20px">&nbsp;&nbsp;:&nbsp;</td>
					<td rowspan="3"><div align="center" valign="midle"><span class="style1">
					<div id="nomor_antrian">
						<?php if(isset($_SESSION['pendaftaran_mandiri_noantrian'])) 
							echo $_SESSION['pendaftaran_mandiri_grpantrian'] . '-' . $_SESSION['pendaftaran_mandiri_noantrian']; ?>	
					</div>
					</span></div></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
					<!--
					<input name="btdaftar" type="button" id="btdaftar" value="FORM PENDAFTARAN" class="myButton" onclick="goto_form_daftar();" />
					--></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table border="0" width="100%">
				<tr>
					<td rowspan="3" width="140px">
					<div id="loading" align="center" valign="midle">
						<img id="img_loading" src="image/loading_2.gif" height="50" width="50" />
					</div>
					</td>
					<td width="40px" align="right"><input type="button" name="next" value="NEXT" class="myButton" onclick="get_next_antrian();" /></td>
					<td width="40px" align="right"><input name="repeate" type="button" id="repeate" value="REPEATE" class="myButton" onclick="set_repeate_antrian();" /></td>
					<td width="40px"><input name="noshow" type="button" id="noshow" value="NO SHOW" class="myButton" onclick="set_noshow_antrian();" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right"><input name="btmanual" type="button" id="btmanual" value="MANUAL" class="myButton" onclick="set_manual_antrian();" /></td>
					<td><div id="listmanual">
					<select name="manual" id="manual" class="text_dt" style="width:79px;height:25px;">
						<option value=""> -- </option>
						</select></div></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right"><input name="btrecall" type="button" id="btrecall" value="RECALL" class="myButton" onclick="set_recall_antrian();" /></td>
					<td><div id="listrecall">
						<select name="recall" id="recall" class="text_dt" style="width:79px;height:25px;">
						<option value=""> -- </option>
						</select></div></td>
				</tr>
			</table>
		</div>
		<?php } ?>	
	</td>
</tr>
<tr>
	<td>
		<?php if(isset($_SESSION['pendaftaran_mandiri_site'])){ ?>
		<div class="div_menu" style=" height:auto;position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		<table border="0" width="100%">
				<tr>
					<td width="120px">SISA ANTRIAN</td>
					<td width="10px">:</td>
					<td><span class="style2"><div id="sisa_antrian"></div></span></td>
				</tr>
			</table>
		</div>
		<?php } ?>
	</td>
</tr>
</table>
<?php if(isset($_SESSION['pendaftaran_mandiri_site'])){ ?>
<script language="javascript">
var img = document.getElementById('img_loading');
img.style.visibility = 'hidden'; //visible

function goto_form_daftar(){
img.style.visibility = 'visible';

	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=cekantrian',
			data: {id : 'x'},
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data.trim() == 'fail'){
						alert('Tidak Ada Antrian Yang Dipanggil.');
					}else{
						var arr_data = data.split('|');
						var id_trans = arr_data[0];
						var id_daftar = arr_data[1];
						var grpantrian = arr_data[2];
						var id_klinik = arr_data[3];
						var pasien_baru = arr_data[4];
						var nomr = arr_data[5];
						
						if(grpantrian === 'A'){
							if(id_daftar ===''){
								window.open("index.php?link=d1baaf8a639bfcc3af8382ba7a8d90fb&pasien=umum&ol=" + id_trans);
							}else{
								if(id_klinik == '35'){
									if(pasien_baru == '1'){
										window.open("index.php?link=51b536eac7f9b0872ff8e7d52521e447&pasien=kusta&baru=1&ol=" + id_trans);
									}else{
										window.open("index.php?link=51b536eac7f9b0872ff8e7d52521e447&pasien=kusta&nomr=" + nomr + "&ol=" + id_trans);
									}		
								}else{
									if(pasien_baru == '1'){
										window.open("index.php?link=c75e8f0fa3053bee0eb6da6e71ab9cde&pasien=umum&baru=1&ol=" + id_trans);
									}else{
										window.open("index.php?link=c75e8f0fa3053bee0eb6da6e71ab9cde&pasien=umum&nomr=" + nomr + "&ol=" + id_trans);
									}
								}
							}			
						}else if(grpantrian === 'B'){
							window.open("index.php?link=25b3a13ed2787a7f473ecdcb17bc053a&ol=" + id_trans);
						}else if(grpantrian === 'C'){	
							if(id_daftar === ''){
								window.open("index.php?link=d0bea3dd85f312e433ef12148bc4ad42&pasien=mcu&ol=" + id_trans);
							}else{
								if(pasien_baru == '1'){
									window.open("index.php?link=229127c93886e771a82948e042db46f3&pasien=mcu&baru=1&ol=" + id_trans);
								}else{
									window.open("index.php?link=229127c93886e771a82948e042db46f3&pasien=mcu&nomr=" + nomr + "&ol=" + id_trans);
								}
							}	
						}
					}
				img.style.visibility = 'hidden';
				}	
	},});
}

function get_sisa_antrian(site){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=sisa',
			data: { st : site,
					group : '<?php echo $group; ?>' },
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					document.getElementById("sisa_antrian").innerHTML= data;
				}	
	},});	
}

function get_manual_antrian(site){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=listmanual',
			data: { st : site,
					group : '<?php echo $group; ?>' },
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					document.getElementById("listmanual").innerHTML= data;
				}	
	},});	
}

function get_recall_antrian(site){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=listrecall',
			data: { st : site,
					group : '<?php echo $group; ?>' },
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					document.getElementById("listrecall").innerHTML= data;
				}	
	},});	
}

function get_next_antrian(){
img.style.visibility = 'visible';
	
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=next',
			data: { st : '<?php echo $site; ?>', 
				lkt : '<?php echo $loket; ?>',
				group : '<?php echo $group; ?>' },
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data.trim() === 'fail'){
						alert('Tidak Ada Antrian.');
						img.style.visibility = 'hidden';
					}else{
						var arr_data = data.split('|');
						var id = arr_data[0];
						var nomor = arr_data[1];
						var storder = arr_data[2];
						var irjaid = arr_data[3];
					
						document.getElementById("nomor_antrian").innerHTML= nomor;
						img.style.visibility = 'hidden';
					}	
				}	
	},});
}

function set_repeate_antrian(){
img.style.visibility = 'visible';
		
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=repeate',
		data: { st : '<?php echo $site; ?>', lkt : '<?php echo $loket; ?>'},
		async: false,
		cache: false,
		success: function(data) {					
			if (data.length > 0){
				if(data.trim() === 'fail'){
					alert('Tidak Ada Antrian.');
				}
				img.style.visibility = 'hidden';
			}	
	},});	
}

function set_noshow_antrian(){
img.style.visibility = 'visible';

	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=noshow',
			data: {id : 'x'},
			async: false,
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data.trim() == 'fail'){
						alert('Tidak Ada Antrian.');
					}
					document.getElementById("nomor_antrian").innerHTML= '';
					img.style.visibility = 'hidden';
				}	
	},});
}

function set_manual_antrian(){
img.style.visibility = 'visible';
var noman = document.getElementById('manual').value;

if(noman.trim() === ''){
	alert('Tidak Ada Antrian.');
	img.style.visibility = 'hidden';
	return false;
 }else{
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=manual',
			data: { st : '<?php echo $site; ?>', lkt : '<?php echo $loket; ?>', man : noman},
			async: false,
			cache: false,
			success: function(data) {				
				if (data.length > 0){
					var arr_data = data.split('|');
					var id = arr_data[0];
					var nomor = arr_data[1];
					
					document.getElementById("nomor_antrian").innerHTML= nomor;
					img.style.visibility = 'hidden';
				}	
	},});
 }	
}

function set_recall_antrian(){
img.style.visibility = 'visible';
var recall = document.getElementById('recall').value;

if(recall.trim() === ''){
	alert('Tidak Ada Antrian.');
	img.style.visibility = 'hidden';
	return false;
 }else{
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?mqm=recall',
			data: { st : '<?php echo $site; ?>', lkt : '<?php echo $loket; ?>', rcl : recall},
			async: false,
			cache: false,
			success: function(data) {		
				if (data.length > 0){
					var arr_data = data.split('|');
					var id = arr_data[0];
					var nomor = arr_data[1];
					
					document.getElementById("nomor_antrian").innerHTML= nomor;
					img.style.visibility = 'hidden';
				}	
	},});
 }	
}

jQuery(document).ready(function(){
		setInterval(function(){
			get_sisa_antrian('<?php echo $site; ?>');
		},5000);
    });

jQuery(document).ready(function(){
		setInterval(function(){
			get_manual_antrian('<?php echo $site; ?>');
			get_recall_antrian('<?php echo $site; ?>');
		},60000);
    });	
	
get_sisa_antrian('<?php echo $site; ?>');	
get_manual_antrian('<?php echo $site; ?>');
get_recall_antrian('<?php echo $site; ?>');
</script>
<?php } ?>