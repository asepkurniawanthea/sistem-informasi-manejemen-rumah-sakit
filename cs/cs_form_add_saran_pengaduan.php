<?php
$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());

$idx = '';
if(isset($_GET['idx'])) $idx = $_GET['idx']; 

if(isset($_POST['simpan'])){
	$idx = $_POST['idx'];	
	if(empty($idx)){
		mysql_query('INSERT INTO t_saran_pengaduan(NAMA,ALAMAT,NO_CONTACT,
				EMAIL,PERIHAL,DESKRIPSI,TGL_SARAN,MEDIA)
				VALUES("' . $_POST['nama_lengkap'] . '","' . $_POST['alamat'] . '",
				"' . $_POST['no_telepon'] . '","' . $_POST['email'] . '",
				"' . $_POST['perihal'] . '","' . $_POST['keterangan'] . '",
				NOW(),"' . $_POST['media'] . '")') or die(mysql_error());
		
		$get_idx = mysql_query('SELECT SARAN_PENGADUAN_ID 
						FROM t_saran_pengaduan
						ORDER BY SARAN_PENGADUAN_ID DESC LIMIT 1') or die(mysql_error());
		$dat_idx = mysql_fetch_assoc($get_idx);
		$idx = $dat_idx['SARAN_PENGADUAN_ID'];	
	}else{
		mysql_query('UPDATE t_saran_pengaduan
					SET NAMA = "' . $_POST['nama_lengkap'] . '",
					ALAMAT = "' . $_POST['alamat'] . '",
					NO_CONTACT = "' . $_POST['no_telepon'] . '",
					EMAIL = "' . $_POST['email'] . '",
					PERIHAL = "' . $_POST['perihal'] . '",
					DESKRIPSI = "' . $_POST['keterangan'] . '",
					MEDIA = "' . $_POST['media'] . '"
					WHERE SARAN_PENGADUAN_ID = "' . $idx . '"') or die(mysql_error());
	}
	$msg_info = 'Data Berhasil Disimpan.';
?>
<script language="JavaScript" >
	window.location = "index.php?link=d8e23abee8294e6da4e5b96ae664fcc5";
</script> 
<?php	
}
$qry_saran = 'SELECT * FROM t_saran_pengaduan
			WHERE SARAN_PENGADUAN_ID = "' . $idx . '"';
$get_saran = mysql_query($qry_saran) or die(mysql_error());
$dat_saran = mysql_fetch_assoc($get_saran);						
?>
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
<form name="search" method="post">
<table border="0" width="90%">
<tr>
	<td>&nbsp;</td>
	<td>Nama Lengkap</td>
	<td><input type="text" name="nama_lengkap" id="nama_lengkap" value="<?php echo $dat_saran['NAMA']; ?>" class="text_dt" style="width:240px;" />
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Alamat</td>
	<td><input type="text" name="alamat" id="alamat" value="<?php echo $dat_saran['ALAMAT']; ?>" class="text_dt" style="width:440px;" />
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Nomor Telepon</td>
	<td><input type="text" name="no_telepon" id="no_telepon" value="<?php echo $dat_saran['NO_CONTACT']; ?>" class="text_dt" style="width:240px;" />
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Email</td>
	<td><input type="text" name="email" id="email" value="<?php echo $dat_saran['EMAIL']; ?>" class="text_dt" style="width:240px;" />
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Perihal</td>
	<td><input type="text" name="perihal" id="perihal" value="<?php echo $dat_saran['PERIHAL']; ?>" class="text_dt" style="width:240px;" />
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Keterangan</td>
	<td><textarea name="keterangan" id="keterangan" class="text_dt2" ><?php echo $dat_saran['DESKRIPSI']; ?></textarea>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Media</td>
	<td><select name="media" class="text_dt" style="width:240px;">
				<option value=""> - </option>
				<option value="2" <?php if($dat_saran['MEDIA'] == '2') echo 'selected="selected"'; ?>>Telepon</option>
				<option value="3" <?php if($dat_saran['MEDIA'] == '3') echo 'selected="selected"'; ?>>Surat</option>
				<option value="4" <?php if($dat_saran['MEDIA'] == '4') echo 'selected="selected"'; ?>>Langsung</option>
				<option value="5" <?php if($dat_saran['MEDIA'] == '5') echo 'selected="selected"'; ?>>Lain-lain</option>
			</select></textarea>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td colspan="3" align="right">
	<input type="submit" name="simpan" value="simpan" class="myButton" />
	<a href="index.php?link=d8e23abee8294e6da4e5b96ae664fcc5">
		<input type="button" value="tutup" class="myButton" />
		</a>
	<input type="hidden" name="idx" value="<?php echo $idx; ?>" />
	</td>
</tr>
</table>
</form>
</div>
</div> 