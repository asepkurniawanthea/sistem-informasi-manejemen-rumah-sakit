<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$nama_petugas = '';
$tanggal = '';
$langkah_1 = '';
$langkah_2 = '';
$langkah_3 = '';
$langkah_4 = '';
$langkah_5 = '';

if(isset($_POST['simpan'])){
	$nama_petugas = $_POST['nama_petugas'];
	$tanggal = $_POST['tanggal'];
	if(isset($_POST['langkah_1'])) $langkah_1 = $_POST['langkah_1'];
	if(isset($_POST['langkah_2'])) $langkah_2 = $_POST['langkah_2'];
	if(isset($_POST['langkah_3'])) $langkah_3 = $_POST['langkah_3'];
	if(isset($_POST['langkah_4'])) $langkah_4 = $_POST['langkah_4'];
	if(isset($_POST['langkah_5'])) $langkah_5 = $_POST['langkah_5'];
	
	$app_id = substr($nama_petugas,0,1);
	$pegawai_id = substr($nama_petugas,1,5);
	$pegawai_id = $pegawai_id * 1;
	$get_id = mysql_query('SELECT kct.KEPATUHAN_CUCITANGAN_ID
		FROM db_repository.mutu_kepatuhan_cuci_tangan_5langkah kct
		WHERE kct.PEGAWAI_ID = "' . $pegawai_id . '"
		AND kct.APP_ID = "' . $app_id . '"
		AND DATE_FORMAT(kct.TANGGAL,"%d/%m/%Y") = "' . $tanggal . '"') or die(mysql_error());
	if(mysql_num_rows($get_id) == 0){
		mysql_query('INSERT INTO db_repository.mutu_kepatuhan_cuci_tangan_5langkah
		(PEGAWAI_ID,APP_ID,LANGKAH_1,LANGKAH_2,LANGKAH_3,LANGKAH_4,
		LANGKAH_5,TANGGAL,PENGUMPUL_DATA) VALUES(
		"' . $pegawai_id . '","' . $app_id . '","' . $langkah_1 . '",
		"' . $langkah_2 . '","' . $langkah_3 . '","' . $langkah_4 . '",
		"' . $langkah_5 . '",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),"' . currentUser() . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE db_repository.mutu_kepatuhan_cuci_tangan_5langkah
				SET LANGKAH_1 = "' . $langkah_1 . '",
				LANGKAH_2 = "' . $langkah_2 . '",
				LANGKAH_3 = "' . $langkah_3 . '",
				LANGKAH_4 = "' . $langkah_4 . '",
				LANGKAH_5 = "' . $langkah_5 . '",
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
	<td colspan="6"><strong>Form Pemantauan Kepatuhan Cuci Tangan</strong></td>
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
	<td width="200px">Langkah 1</td>
	<td><input type="checkbox" name="langkah_1" id="langkah_1" value="1"  
	<?php if($langkah_1 == '1') echo 'checked'; ?> /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Langkah 2</td>
	<td><input type="checkbox" name="langkah_2" id="langkah_2" value="1"  
	<?php if($langkah_2 == '1') echo 'checked'; ?> /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Langkah 3</td>
	<td><input type="checkbox" name="langkah_3" id="langkah_3" value="1"  
	<?php if($langkah_3 == '1') echo 'checked'; ?> /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Langkah 4</td>
	<td><input type="checkbox" name="langkah_4" id="langkah_4" value="1"  
	<?php if($langkah_4 == '1') echo 'checked'; ?> /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Langkah 5</td>
	<td><input type="checkbox" name="langkah_5" id="langkah_5" value="1"  
	<?php if($langkah_5 == '1') echo 'checked'; ?> /></td>
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
	<a href="index.php?link=acb271665706d7ce1a4bb61250950197" >
			<input type="button" value="tutup" class="myButton1" /></a>
	</td>
</tr>
</table>
</form>
</div>
</div> 