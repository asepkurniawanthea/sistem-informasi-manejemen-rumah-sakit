<?php
$connect = mysql_connect($hostname_6, $username_6, $password_6) or die(mysql_error());
mysql_select_db($database_6, $connect) or die(mysql_error());
		
$akun_induk = '';
$kode_akun = '';
$nama_akun = '';
$pos = 'D';
$deskripsi = '';
$akun_id = '';
if(isset($_POST['simpan'])){
	if(empty($_POST['akun_id'])){
		mysql_query('INSERT INTO m_akun(KODE_AKUN,KODE_AKUN_INDUK,
				NAMA_AKUN,POS_AKUN,DESKRIPSI)
				VALUES("' . $_POST['kode_akun'] . '","' . $_POST['akun_induk'] . '",
				"' . $_POST['nama_akun'] . '","' . $_POST['pos'] . '",
				"' . $_POST['deskripsi'] . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE m_akun SET KODE_AKUN = "' . $_POST['kode_akun'] . '",
					KODE_AKUN_INDUK = "' . $_POST['akun_induk'] . '",
					NAMA_AKUN = "' . $_POST['nama_akun'] . '",
					POS_AKUN = "' . $_POST['pos'] . '",
					DESKRIPSI = "' . $_POST['deskripsi'] . '"
					WHERE AKUN_ID = "' . $_POST['akun_id'] . '"') or die(mysql_error());
	}
	echo '<script language="JavaScript" >';
	echo 'alert("Data Akun Telah Disimpan.");';
	echo 'opener.location.reload();';
	echo 'window.close();';
	echo '</script>';
}
if(isset($_GET['prn'])) $akun_induk = $_GET['prn'];
if(isset($_GET['id'])){
	$akun_id = $_GET['id'];
	$sql_akun_det = 'SELECT * FROM m_akun WHERE AKUN_ID = "' . $akun_id . '"';
	$get_akun_det = mysql_query($sql_akun_det) or die(mysql_error());
	$dat_akun_det = mysql_fetch_assoc($get_akun_det);
	$akun_induk = $dat_akun_det['KODE_AKUN_INDUK'];
	$kode_akun = $dat_akun_det['KODE_AKUN'];
	$nama_akun = $dat_akun_det['NAMA_AKUN'];
	$pos = $dat_akun_det['POS_AKUN'];
	$deskripsi = $dat_akun_det['DESKRIPSI'];
} 
?>
<body>
<div style=" height:auto; padding:5px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:5px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formakun" method="post">
<input type="hidden" name="akun_id" value="<?php echo $akun_id; ?>" />
<table border="0" width="100%">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Akun Induk</td>
		<td><select name="akun_induk" class="text_dt" style="width:303px;">
		<option value=""> -- </option>
		<?php
		$sql_akun = 'SELECT m_akun.KODE_AKUN,m_akun.NAMA_AKUN
					FROM m_akun
					ORDER BY m_akun.KODE_AKUN';
		$get_akun = mysql_query($sql_akun) or die(mysql_error());
		while($dat_akun = mysql_fetch_array($get_akun)){ ?>
		<option value="<?php echo $dat_akun['KODE_AKUN']; ?>" <?php if($akun_induk == $dat_akun['KODE_AKUN']) echo 'selected="selected"'; ?> ><?php echo $dat_akun['KODE_AKUN'] . ' - ' . $dat_akun['NAMA_AKUN']; ?></option>	
		<?php } ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Kode Akun</td>
		<td><input type="text" name="kode_akun" value="<?php echo $kode_akun; ?>" class="text_dt" style="width:295px;" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Nama Akun</td>
		<td><input type="text" name="nama_akun" value="<?php echo $nama_akun; ?>" class="text_dt" style="width:295px;" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Pos</td>
		<td><input type="radio" name="pos" value="D" <?php if($pos == 'D') echo 'checked="checked"'; ?> />&nbsp;Debet
		<input type="radio" name="pos" value="K" <?php if($pos == 'K') echo 'checked="checked"'; ?> />&nbsp;Kredit</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Deskripsi</td>
		<td><textarea name="deskripsi" class="text_dt6" style="width:295px;" ><?php echo $deskripsi; ?></textarea></td>
	</tr>
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td align="right" colspan="2">
	<input type="submit" name="simpan" value="simpan" class="myButton1" />
	<a href="#" onClick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
</table>
</form>
</div>
</div>