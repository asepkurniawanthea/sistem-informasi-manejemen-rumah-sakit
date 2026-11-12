<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
if (isset($_POST['irna_pemeriksaan_id'])) {
    include('rawatinap/ranap_save_edit_add_pemeriksaan_fisik.php');
}

$idx = $_GET['idx'];
$idc = $_GET['idc'];

$qry_pemeriksaan1 = 'SELECT DATE_FORMAT(t_irna_pemeriksaan_fisik.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				  DATE_FORMAT(t_irna_pemeriksaan_fisik.TANGGAL_PERIKSA,"%H") AS JAM,
				  DATE_FORMAT(t_irna_pemeriksaan_fisik.TANGGAL_PERIKSA,"%i") AS MENIT,
				  t_irna_pemeriksaan_fisik.FREKUENSI_NADI,
				  t_irna_pemeriksaan_fisik.SUHU,
				  t_irna_pemeriksaan_fisik.PERNAFASAN,
				  t_irna_pemeriksaan_fisik.TEKANAN_DARAH_A,
				  t_irna_pemeriksaan_fisik.TEKANAN_DARAH_B,
				  t_irna_pemeriksaan_fisik.BERAT_BADAN,
				  t_irna_pemeriksaan_fisik.TINGGI_BADAN,
				  t_irna_pemeriksaan_fisik.PEGAWAI_ID
				FROM t_irna_pemeriksaan_fisik
				WHERE IRNA_ID = "' . $idx . '" AND t_irna_pemeriksaan_fisik.IRNA_PEMERIKSAAN_FISIK_ID = "' . $idc . '"';

$get_cek_no_pemeriksaan1 = mysql_query($qry_pemeriksaan1) or die(mysql_error());
$dat_cek_no_pemeriksaan1 = mysql_fetch_array($get_cek_no_pemeriksaan1);
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="200px;">Tanggal</td>
            <td>
			<input type="text" name="tanggal" id="tgl_1" class="text_dt" size="10" value="<?php echo $dat_cek_no_pemeriksaan1['TANGGAL_PERIKSA'] ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($dat_cek_no_pemeriksaan1['JAM']); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($dat_cek_no_pemeriksaan1['MENIT']); ?>
			</select>
			</td>
		</tr>	
					<td>Tensi</td>
					<td><input type="text" name="tekanan_darah_a" class="text_dt" size="8" value="<?php echo $dat_cek_no_pemeriksaan1['TEKANAN_DARAH_A'];?>">/<input type="text" name="tekanan_darah_b" class="text_dt" size="7" value="<?php echo $dat_cek_no_pemeriksaan1['TEKANAN_DARAH_B'];?>">&nbsp;mmHg</td>
				</tr>
				<tr>
					<td>Frekuensi Nafas</td>
					<td><input type="text" name="frekuensi_nafas" class="text_dt" value="<?php echo $dat_cek_no_pemeriksaan1['PERNAFASAN'];?>">&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td><input type="text" name="suhu_tubuh" class="text_dt" value="<?php echo $dat_cek_no_pemeriksaan1['SUHU'];?>">&nbsp;oC</td>
				</tr>
				<tr>
					<td>Frekuensi Nadi</td>
					<td><input type="text" name="frekuensi_nadi" class="text_dt" value="<?php echo $dat_cek_no_pemeriksaan1['FREKUENSI_NADI'];?>">&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Berat Badan</td>
					<td><input type="text" name="berat_badan" class="text_dt" value="<?php echo $dat_cek_no_pemeriksaan1['BERAT_BADAN'];?>">&nbsp;Kg</td>
				</tr>
				<tr>
					<td>Tinggi Badan</td>
					<td><input type="text" name="tinggi_badan" class="text_dt" value="<?php echo $dat_cek_no_pemeriksaan1['TINGGI_BADAN'];?>">&nbsp;Cm</td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($dat_cek_no_pemeriksaan1['PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="batal" class="myButton1" /></a></td>
	</tr>
	</table>
    <input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
	<input type="hidden" name="irna_pemeriksaan_id" value="<?php echo $_REQUEST['idc']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>