<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

if (isset($_GET['idro']))
    include('rawatinap/ranap_del_add_rekonsiliasi_obat.php');

$sql_rekon ='SELECT DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL,"%d/%m/%Y") AS TANGGAL,
		DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL,"%H") AS JAM,
		DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL,"%i") AS MENIT,
		t_irna_rekonsiliasi.BERAT_BADAN,t_irna_rekonsiliasi.TINGGI_BADAN,
		DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL_DOKTER,"%d/%m/%Y") AS TANGGAL_DOKTER,
		t_irna_rekonsiliasi.DOKTER,
		DATE_FORMAT(t_irna_rekonsiliasi.APOTEKER_TANGGAL,"%d/%m/%Y") AS APOTEKER_TANGGAL,
		t_irna_rekonsiliasi.APOTEKER,
		DATE_FORMAT(t_irna_rekonsiliasi.PERAWAT_TANGGAL,"%d/%m/%Y") AS PERAWAT_TANGGAL,
		t_irna_rekonsiliasi.PERAWAT,
		t_irna_rekonsiliasi.INTRUKSI_DOKTER,
		t_irna_rekonsiliasi.IRNA_ID
		FROM t_irna_rekonsiliasi
		WHERE t_irna_rekonsiliasi.IRNA_ID = "' . $irna_id . '"';
$get_rekon = mysql_query($sql_rekon) or die(mysql_error());
$dat_rekon = mysql_fetch_assoc($get_rekon);
$rekon_id = $dat_rekon['IRNA_ID'];
$tanggal = $dat_rekon['TANGGAL'];
$jam = $dat_rekon['JAM'];
$menit = $dat_rekon['MENIT'];
$berat_badan = $dat_rekon['BERAT_BADAN']; 		
$tinggi_badan = $dat_rekon['TINGGI_BADAN']; 		
$intruksi_dokter = $dat_rekon['INTRUKSI_DOKTER']; 		
$dokter = $dat_rekon['DOKTER']; 		
$dokter_tanggal = $dat_rekon['TANGGAL_DOKTER']; 		
$apoteker = $dat_rekon['APOTEKER']; 		
$apoteker_tanggal = $dat_rekon['APOTEKER_TANGGAL']; 		
$perawat = $dat_rekon['PERAWAT']; 		
$perawat_tanggal = $dat_rekon['PERAWAT_TANGGAL']; 

if(empty($rekon_id)){
	$tanggal = date('d/m/Y');
	$jam = date('H');
	$menit = date('i');
}		

if(isset($_POST['irna_id'])){
	//
	$_err = '';

	if (empty($_err)) {
		$sql_cek_no_ranap = 'SELECT NO_RAWAT
							FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
		$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
		if (empty($dat_cek_no_ranap['NO_RAWAT'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {

			$tanggal = $_POST['tanggal'];
			$jam = $_POST['jam'];
			$menit = $_POST['menit'];
			$berat_badan = $_POST['berat_badan']; 		
			$tinggi_badan = $_POST['tinggi_badan']; 		
			$intruksi_dokter = $_POST['intruksi_dokter']; 		
			$dokter = $_POST['dokter']; 		
			$dokter_tanggal = $_POST['dokter_tanggal']; 		
			$apoteker = $_POST['apoteker']; 		
			$apoteker_tanggal = $_POST['apoteker_tanggal']; 		
			$perawat = $_POST['perawat']; 		
			$perawat_tanggal = $_POST['perawat_tanggal']; 
			
			mysql_query('DELETE FROM t_irna_rekonsiliasi WHERE IRNA_ID = "' . $irna_id  . '"') or die(mysql_error());
			mysql_query('INSERT INTO t_irna_rekonsiliasi(IRNA_ID,TANGGAL,BERAT_BADAN,TINGGI_BADAN,TANGGAL_DOKTER,
						DOKTER,APOTEKER_TANGGAL,APOTEKER,PERAWAT_TANGGAL,PERAWAT,INTRUKSI_DOKTER)
						VALUES("' . $irna_id . '",' . fieldDatetime($tanggal . ' ' . $jam . ':' . $menit . ':01') . ',
						"' . $berat_badan . '","' . $tinggi_badan . '",' . fieldDate($dokter_tanggal)  . ',
						"' . $dokter . '",' . fieldDate($apoteker_tanggal)  . ',"' . $apoteker . '",
						' . fieldDate($perawat_tanggal)  . ',"' . $perawat . '","' . $intruksi_dokter . '")') or die(mysql_error());
		}		
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Rekonsiliasi Obat Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
	//
}
?>
<form name="formedukasi" id="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('rawatinap/ranap_tmp_rekonsiliasi_obat.php'); ?>        
    </table>
	<table border="0" width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=ranapformrekonsiliasiobat&idx=<?php echo $irna_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=350')" ><input type="button" value="tambah" class="myButton1" /></a>
			</td>	
    </tr>
	<tr>
		<td width="200px">Tanggal</td>
		<td colspan="4"><input type="text" name="tanggal" id="tgl_edu_1" class="text_dt" value="<?php echo $tanggal; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>	</td>
	</tr>
	<tr>
		<td>Berat Badan</td>
		<td colspan="4"><input type="text" name="berat_badan" value="<?php echo $berat_badan; ?>" size="20" class="text_dt"  /></td>
	</tr>
	<tr>
		<td>Tinggi Badan</td>
		<td colspan="4"><input type="text" name="tinggi_badan" value="<?php echo $tinggi_badan; ?>" size="20" class="text_dt"  /></td>
	</tr>
	<tr>
		<td>Intruksi Dokter</td>
		<td colspan="4"><textarea name="intruksi_dokter" class="text_dt2" ><?php echo $intruksi_dokter; ?></textarea></td>
	</tr>
	<tr>
		<td>Dokter</td>
		<td width="300px"><select name="dokter" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($dokter); ?>
			</select></td>
		<td>Tanggal</td>
		<td><input type="text" name="dokter_tanggal" id="tgl_edu_2" class="text_dt" value="<?php echo $dokter_tanggal; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
	</tr>
	<tr>
		<td>Apoteker</td>
		<td><input type="text" name="apoteker" value="<?php echo $apoteker; ?>" style="width:220px;" class="text_dt"  /></td>
		<td width="200px">Tanggal</td>
		<td><input type="text" name="apoteker_tanggal" id="tgl_edu_3" class="text_dt" value="<?php echo $apoteker_tanggal; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
	</tr>
	<tr>
		<td>Perawat</td>
		<td><select name="perawat" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getPerawat($perawat); ?>
			</select></td>
		<td>Tanggal</td>
		<td><input type="text" name="perawat_tanggal" id="tgl_edu_4" class="text_dt" value="<?php echo $perawat_tanggal; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
	</tr>
	<tr>
            <td colspan="5" align="right">
			<input type="button" value="simpan" class="myButton" onclick="simpan();" />
			</td>	
    </tr>
	</table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedukasi').submit();
}	
</script>