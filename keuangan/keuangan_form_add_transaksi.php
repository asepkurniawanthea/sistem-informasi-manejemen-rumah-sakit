<?php
$connect = mysql_connect($hostname_6, $username_6, $password_6) or die(mysql_error());
mysql_select_db($database_6, $connect) or die(mysql_error());
		
$transaksi_id = '';
$nama_transaksi = '';
$deskripsi = '';
if(isset($_POST['simpan'])){
	if(empty($_POST['transaksi_id'])){
		mysql_query('INSERT INTO m_journal_transaksi(NAMA_TRANSAKSI,DESKRIPSI)
				VALUES("' . $_POST['nama_transaksi'] . '","' . $_POST['deskripsi'] . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE m_journal_transaksi SET NAMA_TRANSAKSI = "' . $_POST['nama_transaksi'] . '",
				DESKRIPSI = "' . $_POST['deskripsi'] . '"
				WHERE JOURNAL_TRANSAKSI_ID = "' . $_POST['transaksi_id'] . '"') or die(mysql_error());
	}
	echo '<script language="JavaScript" >';
	echo 'alert("Data Transaksi Telah Disimpan.");';
	echo 'opener.location.reload();';
	echo 'window.close();';
	echo '</script>';
}
if(isset($_GET['id'])){
	$transaksi_id = $_GET['id'];
	$sql_trans_det = 'SELECT * FROM m_journal_transaksi WHERE JOURNAL_TRANSAKSI_ID = "' . $transaksi_id . '"';
	$get_trans_det = mysql_query($sql_trans_det) or die(mysql_error());
	$dat_trans_det = mysql_fetch_assoc($get_trans_det);
	$nama_transaksi = $dat_trans_det['NAMA_TRANSAKSI'];
	$deskripsi = $dat_trans_det['DESKRIPSI'];
} 
?>
<body>
<div style=" height:auto; padding:5px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:5px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formakun" method="post">
<input type="hidden" name="transaksi_id" value="<?php echo $transaksi_id; ?>" />
<table border="0" width="100%">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Nama Transaksi</td>
		<td><input type="text" name="nama_transaksi" value="<?php echo $nama_transaksi; ?>" class="text_dt" style="width:295px;" /></td>
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