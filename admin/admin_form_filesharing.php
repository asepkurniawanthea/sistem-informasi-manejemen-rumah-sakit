<?php
$instansi = '';
$user = '';
$keterangan = '';
$uploaded_id = '';

if(isset($_POST['uploaded_id'])){
	$inst_arr = explode('-',$_POST['instansi']);
	$app = $inst_arr[0]; 
	$modul = $inst_arr[1];
	$desc = $_POST['keterangan'];
	$user_filename = $_FILES['namafile']['name'];
	$ext = pathinfo($user_filename, PATHINFO_EXTENSION);
	$tm = getDatetimeSkr();
	$date = new DateTime();
	$sistem_filename = $date->format('YmdHisU') . '.' . $ext; 
	move_uploaded_file($_FILES['namafile']['tmp_name'], $fs_path . '/' . $sistem_filename);
	
	$cn_user = $_POST['cn_user'];
	$nama_user = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
	$nama_modul = $_SESSION['SES_SIMRS_NAMA_MODUL'];
	if($nama_modul == 'Admin') $nama_modul = 'EDP';
	$u = 1;
	while ($u <= $cn_user){
		if(isset($_POST['user_' . $u])){
			mysql_query('INSERT INTO db_repository.fs_uploaded(TIME_UPLOADED,USER_UPLOADED,APP_ID_UPLOADED,
				USER_ID_UPLOADED,SISTEM_FILE_NAME,USER_FILE_NAME,APP_ID,MODUL_ID,USER_ID,DESCRIPTION)
				VALUES(' . fieldDatetime($tm) . ',"' . $nama_user . ' (' . $nama_modul . ')' . '","1","' .$_SESSION['SES_SIMRS_NAMA_USER'] . '",
				"' . $sistem_filename . '","' . $user_filename . '","' . $app . '","' . $modul . '","' . $_POST['user_' . $u] . '",
				"' . $desc . '")') or die(mysql_error());
		}
	$u++;}
	
	?>
		<script language="JavaScript" >
			alert('Upload File Berhasil.');
			window.location = "index.php?link=2f75e5370a99742ca004d5437551ab8b";
		</script>
	<?php
}
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		<form method="post" enctype="multipart/form-data" name="FUpload" id="frmUpload">
			<table class="tableform" border="0" >
				<tr>
					<td>File</td>
					<td><input type="file" name="namafile" id="namafile" size="60" /></td>
					<td align="right">&nbsp;</td>
				</tr>
				<tr>
					<td>Instansi Penerima</td>
					<td><select name="instansi" style="width:400px;" class="text_dt" onchange="javascript: MyAjaxRequest('cusersharing','index.php?ajaxrequest=cusersharing&modul=' + this.value);">
						<option value="" > - </option>
						<?php
						$sql_modul = 'SELECT * FROM (SELECT DISTINCT CASE WHEN db_simrs.m_app_modul.MODUL_ID = 14 THEN "EDP" 
								ELSE db_simrs.m_app_modul.NAMA_MODUL END AS NAMA_MODUL,
								CONCAT("1-",db_simrs.m_app_modul.MODUL_ID) AS MODUL_ID
								FROM db_simrs.m_app_modul
								INNER JOIN db_simrs.m_app_user 
								ON (db_simrs.m_app_modul.MODUL_ID = db_simrs.m_app_user.MODUL_ID)
								WHERE db_simrs.m_app_modul.MODUL_ID <> 7
								AND db_simrs.m_app_modul.MODUL_ID <> 8
								AND db_simrs.m_app_modul.MODUL_ID <> 13
								AND db_simrs.m_app_modul.MODUL_ID <> 17
								AND db_simrs.m_app_modul.MODUL_ID <> 99
								UNION
								SELECT db_inventorirs.m_app_modul.NAMA_MODUL,
								CONCAT("2-",db_inventorirs.m_app_modul.MODUL_ID) AS MODUL_ID
								FROM db_inventorirs.m_app_modul
								INNER JOIN db_inventorirs.m_app_user 
								ON (db_inventorirs.m_app_modul.MODUL_ID = db_inventorirs.m_app_user.MODUL_ID)
								WHERE db_inventorirs.m_app_modul.MODUL_ID = 7
								OR db_inventorirs.m_app_modul.MODUL_ID = 8
								OR db_inventorirs.m_app_modul.MODUL_ID = 13
								OR db_inventorirs.m_app_modul.MODUL_ID = 17
								) t ORDER BY t.NAMA_MODUL';
					$get_modul = mysql_query($sql_modul) or die(mysql_error());
					while($dat_modul = mysql_fetch_array($get_modul)){
						$slc_modul = '';
						if($instansi == $dat_modul['MODUL_ID']) $slc_modul = 'selected="selected"'
						?>
						
						<option value="<?php echo $dat_modul['MODUL_ID']; ?>" <?php echo $slc_modul; ?> ><?php echo $dat_modul['NAMA_MODUL']; ?></option>
					<?php }	
					?>
						</select></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>User</td>
					<td><div id="cusersharing">
					</div></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td colspan="2"><textarea name="keterangan" id="keterangan" class="text_dt5" /><?php echo $keterangan; ?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><input type="submit" name="upload" value="upload" class="myButton" onclick="doSubmit(); return false;" /></td>
				</tr>
		</table>
		<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
		<input type="hidden" name="uploaded_id" value="<?php echo $uploaded_id; ?>" />
	</form>
	</div>
<script>
function checkall(){
     jQuery('.u').each(function() { 
                this.checked = true; 
            });      
};
function uncheckall(){
     jQuery('.u').each(function() { 
                this.checked = false; 
            });      
};

function doSubmit(){
	if(document.getElementById("namafile").files.length == 0 ){
		alert("File Belum Dipilih.");
	}else{
		fileSize = $("#namafile")[0].files[0].size;
		fileSize = fileSize / 1048576;
		<?php if(strtolower($_SESSION['SES_SIMRS_NAMA_MODUL']) != 'pengadaan'){ ?>
		if(fileSize > 256){
			alert("Ukuran File Tidak Boleh Dari 256 M.");
		}else{
			document.getElementById("frmUpload").submit();
		}
		<?php }else{  ?>
		document.getElementById("frmUpload").submit();
		<?php } ?>
	}	
}
</script>