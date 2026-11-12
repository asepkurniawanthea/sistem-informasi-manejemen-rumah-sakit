<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$nama_petugas = '';
$tanggal = '';
$keterangan = '';
$penggunaan_apd = '';

if(isset($_POST['simpan'])){
	$nama_petugas = $_POST['nama_petugas'];
	$tanggal = $_POST['tanggal'];
	$keterangan = $_POST['keterangan'];
	$penggunaan_apd = $_POST['penggunaan_apd'];
	
	
	$app_id = substr($nama_petugas,0,1);
	$pegawai_id = substr($nama_petugas,1,5);
	$pegawai_id = $pegawai_id * 1;
	$get_id = mysql_query('SELECT kct.APD_ID
		FROM db_repository.mutu_penggunaan_apd kct
		WHERE kct.PEGAWAI_ID = "' . $pegawai_id . '"
		AND kct.APP_ID = "' . $app_id . '"
		AND DATE_FORMAT(kct.TANGGAL,"%d/%m/%Y") = "' . $tanggal . '"') or die(mysql_error());
	if(mysql_num_rows($get_id) == 0){
		mysql_query('INSERT INTO db_repository.mutu_penggunaan_apd
		(PEGAWAI_ID,APP_ID,PENGGUNAAN_APD,TANGGAL,PENGUMPUL_DATA,KETERANGAN) VALUES(
		"' . $pegawai_id . '","' . $app_id . '","' . $penggunaan_apd . '",
		STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),"' . currentUser() . '",
		"' . $keterangan . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE db_repository.mutu_penggunaan_apd
				SET PENGGUNAAN_APD = "' . $penggunaan_apd . '",
				KETERANGAN = "' . $keterangan . '",
				PENGUMPUL_DATA = "' . currentUser() . '"
				WHERE PEGAWAI_ID = "' . $pegawai_id . '"
				AND APP_ID = "' . $app_id . '"
				AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tanggal . '"') or die(mysql_error());
	}
	$msg_info = 'Data Berhasil Disimpan.';
}					
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#nama_petugas").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				mutu_param : function(){
					return 'nama_petugas';
				}
		}});
	});	
</script>		
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
<form name="search" method="post">
<table border="0" width="90%">
<tr>
	<td colspan="6"><strong>Form Penggunaan APD</strong></td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Nama Petugas</td>
	<td><input type="text" name="nama_petugas" id="nama_petugas" value="<?php echo $nama_petugas; ?>" class="text_dt" style="width:380px;" /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Tanggal</td>
	<td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Penggunaan APD</td>
	<td><input type="checkbox" name="penggunaan_apd" id="penggunaan_apd" value="1"  
	<?php if($penggunaan_apd == '1') echo 'checked'; ?> />&nbsp;Lengkap</td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Keterangan</td>
	<td><input type="text" name="keterangan" id="keterangan" value="<?php echo $keterangan; ?>" style="width:380px;" class="text_dt" />
          </td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4" align="right">
	<input type="submit" name="simpan" value="simpan" class="myButton" />
	</td>
</tr>
</table>
</form>
</div>
</div> 