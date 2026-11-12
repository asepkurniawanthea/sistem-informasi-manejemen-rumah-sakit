<?php
$unit_id = '3'; 
if (isset($_SESSION['pendaftaranjadwaldokter_unit_id']))
		$unit_id = $_SESSION['pendaftaranjadwaldokter_unit_id']; 
if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pendaftaranjadwaldokter_unit_id'] = $unit_id;
}

if(currentModul() == 'igd') $unit_id = '9';
if(currentModul() == 'kusta') $unit_id = '35';
if(currentModul() == 'klinik') $unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];

if(isset($_POST['simpan'])){
include('pendaftaran/pendaftaran_save_jadwal_dokter.php');
}
?>
<form name="form1" method="get" action="index.php">
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" class="tableform" width="350">
        <tr><td>Unit/Klinik</td>
            <td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('cruang','index.php?ajaxrequest=cruang&unit_id=' + this.value);return false;">
<?php if((currentModul() == 'pendaftaran') or (currentModul() == 'admin') or (currentModul() == 'ipapp')) echo getUnit('irjp',$unit_id); 
if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta'){
 $sql = 'SELECT * FROM m_unit WHERE UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"';
 $rsl = mysql_query($sql);
    while ($dat = mysql_fetch_array($rsl)) {
        echo ' <option value="' . $dat['UNIT_ID'] . '" >' . $dat['NAMA_UNIT'] . '</option>';
    } 
} ?>
                </select></td></tr>
		<tr>			
		<td colspan="2" align="right"><input type="submit" name="cari" value="cari" class="myButton" /></td></tr>
    </table>
</form>

<form name="form2" method="post" >
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />	
	<input type="hidden" name="unit_id" id="unit_id" value="<?php echo $unit_id; ?>" />
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="140" rowspan="2">Unit/Klinik</th>
			<th width="140" rowspan="2">Dokter</th>
			<th colspan="2">Minggu</th>
			<th colspan="2">Senin</th>
			<th colspan="2">Selasa</th>
			<th colspan="2">Rabu</th>
			<th colspan="2">Kamis</th>
			<th colspan="2">Jumat</th>
			<th colspan="2">Sabtu</th>
			</tr>
        <tr>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
        </tr>
        <?php
        $sql = 'SELECT NAMA_UNIT FROM m_unit WHERE UNIT_ID = "' . $unit_id . '"';
		$get = mysql_query($sql) or die (mysql_error());
		$dat = mysql_fetch_assoc($get);
		$nama_unit = $dat['NAMA_UNIT'];

		$sql_dokter = 'SELECT m_pegawai.NAMA_PEGAWAI,t_dokter_jaga.UNIT_ID,m_pegawai.PEGAWAI_ID,
						(SELECT MAX(x.JAM_MULAI_PRAKTEK) FROM t_dokter_jaga_jadwal x WHERE x.UNIT_ID = t_dokter_jaga.UNIT_ID
							AND x.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID) AS JAM_MULAI_PRAKTEK,
						(SELECT MAX(x.JAM_SELESAI_PRAKTEK) FROM t_dokter_jaga_jadwal x WHERE x.UNIT_ID = t_dokter_jaga.UNIT_ID
							AND x.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID) AS JAM_SELESAI_PRAKTEK	
						FROM t_dokter_jaga
						INNER JOIN m_pegawai ON (t_dokter_jaga.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_dokter_jaga.UNIT_ID = "' . $unit_id . '" ORDER BY m_pegawai.NAMA_PEGAWAI';
		$get_dokter = mysql_query($sql_dokter) or die(mysql_error);
		$idc = 0;	
        while ($dat_dokter = mysql_fetch_array($get_dokter)) {
            ?>
			<tr>
				<td rowspan="2"><?php echo $nama_unit; ?></td>
				<td rowspan="2"><?php echo $dat_dokter['NAMA_PEGAWAI']; ?></td>
				<td align="center"><input type="checkbox" name="minggu<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'0') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '0') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_minggu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'0'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="senin<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'1') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '1') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_senin<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'1'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="selasa<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'2') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '2') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_selasa<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'2'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="rabu<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'3') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '3') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_rabu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'3'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="kamis<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'4') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '4') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_kamis<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'4'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="jumat<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'5') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '5') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_jumat<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'5'); ?>" class="text_dt" style="width:60px;" /></td>
				<td align="center"><input type="checkbox" name="sabtu<?php echo $idc+1; ?>" value="<?php echo $dat_dokter['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($unit_id,$dat_dokter['PEGAWAI_ID'],'6') > 0) echo 'checked="checked"'; //if(cekCurrentDay() == '6') echo ' disabled="disabled"'; ?> /></td>
				<td><input type="text" name="buka_sabtu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalBuka($unit_id,$dat_dokter['PEGAWAI_ID'],'6'); ?>" class="text_dt" style="width:60px;" /></td>
				</tr>
				<tr>
				  <td><input type="text" name="kuota_minggu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'0'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_minggu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'0'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_senin<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'1'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_senin<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'1'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_selasa<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'2'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_selasa<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'2'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_rabu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'3'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_rabu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'3'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_kamis<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'4'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_kamis<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'4'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_jumat<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'5'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_jumat<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'5'); ?>" class="text_dt" style="width:60px;" /></td>
				  <td><input type="text" name="kuota_sabtu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalKuota($unit_id,$dat_dokter['PEGAWAI_ID'],'6'); ?>" class="text_dt" style="width:40px;" /></td>	
				  <td><input type="text" name="tutup_sabtu<?php echo $idc+1; ?>" value="<?php echo cekDokterJadwalTutup($unit_id,$dat_dokter['PEGAWAI_ID'],'6'); ?>" class="text_dt" style="width:60px;" /></td>
				</tr>
			<?php
        $idc++;
		}
        ?>
    </table>
<?php if(currentModul() == 'klinik' or $_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >                      
								<input type="hidden" name="rowcnt" value="<?php echo $idc; ?>" />
								<input type="submit" name="simpan" value="simpan" class="myButton1" /> 
                </td>
            </tr>
        </table>
<?php } ?>		
		</form>