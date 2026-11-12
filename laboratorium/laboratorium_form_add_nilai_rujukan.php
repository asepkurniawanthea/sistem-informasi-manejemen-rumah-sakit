<?php if(isset($_GET['pemeriksaan_group']) && isset($_GET['pemeriksaan'])){ 
$nilai_rujukan_id = '';
$umur_tahun = '';
$umur_bulan = '';
$umur_hari = '';
$jns_kelamin_lk = '';
$jns_kelamin_pr = '';
$nilai_rujukan = '';
$methode = '';
$satuan = '';
$label_umur = '';

if(isset($_GET['idx'])){
	$nilai_rujukan_id = $_GET['idx'];
	$sql_periksa_item = 'SELECT m_nilai_rujukan_laboratorium.UMUR_TAHUN,m_nilai_rujukan_laboratorium.UMUR_BULAN,
					m_nilai_rujukan_laboratorium.UMUR_HARI,m_nilai_rujukan_laboratorium.JNS_KELAMIN_LK,
					m_nilai_rujukan_laboratorium.JNS_KELAMIN_PR,m_nilai_rujukan_laboratorium.NILAI_RUJUKAN,
					m_nilai_rujukan_laboratorium.SATUAN,m_nilai_rujukan_laboratorium.METHODE,m_nilai_rujukan_laboratorium.LABEL_UMUR
					FROM m_nilai_rujukan_laboratorium
					WHERE m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID = "' . $nilai_rujukan_id . '"';
	$get_periksa_item = mysql_query($sql_periksa_item) or die(mysql_error());
	$dat_periksa_item = mysql_fetch_assoc($get_periksa_item);
	$umur_tahun = $dat_periksa_item['UMUR_TAHUN'];
	$umur_bulan = $dat_periksa_item['UMUR_BULAN'];
	$umur_hari = $dat_periksa_item['UMUR_HARI'];
	$jns_kelamin_lk = $dat_periksa_item['JNS_KELAMIN_LK'];
	$jns_kelamin_pr = $dat_periksa_item['JNS_KELAMIN_PR'];
	$nilai_rujukan = $dat_periksa_item['NILAI_RUJUKAN'];
	$methode = $dat_periksa_item['METHODE'];
	$satuan = $dat_periksa_item['SATUAN'];
	$label_umur = $dat_periksa_item['LABEL_UMUR'];
}

$sql_periksa = 'SELECT m_nilai_rujukan_laboratorium.METHODE,m_nilai_rujukan_laboratorium.SATUAN
				FROM m_nilai_rujukan_laboratorium
				WHERE m_nilai_rujukan_laboratorium.CH_REPORT = "' . $_GET['pemeriksaan_group'] . '"
				AND m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN = "' . $_GET['pemeriksaan'] . '"';
$get_periksa = mysql_query($sql_periksa) or die(mysql_error());
$dat_periksa = mysql_fetch_assoc($get_periksa);
$satuan = $dat_periksa['SATUAN']; 				
$methode = $dat_periksa['METHODE']; 

if(isset($_POST['simpan'])){
	$nilai_rujukan_id = $_POST['nilai_rujukan_id'];
	$methode = $_POST['methode'];
	$satuan = $_POST['satuan'];
	$umur_tahun = $_POST['umur_tahun'];
	$umur_bulan = $_POST['umur_bulan'];
	$umur_hari = $_POST['umur_hari'];
	if(isset($_POST['jns_kelamin_lk'])) $jns_kelamin_lk = $_POST['jns_kelamin_lk'];
	if(isset($_POST['jns_kelamin_pr'])) $jns_kelamin_pr = $_POST['jns_kelamin_pr'];
	$nilai_rujukan = $_POST['nilai_rujukan'];
	$pemeriksaan = $_POST['pemeriksaan'];
	$pemeriksaan_group = $_POST['pemeriksaan_group'];
	$label_umur = $_POST['label_umur'];
	
$_err = '';

if(empty($label_umur)) $_err = $_err . 'Keterangan Umur Belum Diisi. \n';	
if(empty($methode)) $_err = $_err . 'Methode Belum Diisi. \n';	
if(empty($satuan)) $_err = $_err . 'Satuan Belum Diisi. \n';	
if(empty($umur_tahun) and empty($umur_bulan) and empty($umur_hari)) $_err = $_err . 'Umur Belum Diisi. \n';	
if(empty($nilai_rujukan)) $_err = $_err . 'Nilai Rujukan Belum Diisi. \n';

if(!empty($_err)) {
	$msg_info = $_err;
}else{
	if(empty($umur_tahun)) $umur_tahun = '0';
	if(empty($umur_bulan)) $umur_bulan = '0';
	if(empty($umur_hari)) $umur_hari = '0';
	
	if(empty($jns_kelamin_lk) and empty($jns_kelamin_pr)){
		$jns_kelamin_lk = '1';
		$jns_kelamin_pr = '1';
	}	
	
	if(empty($nilai_rujukan_id)){
		mysql_query('INSERT INTO m_nilai_rujukan_laboratorium(UMUR_TAHUN,UMUR_BULAN,UMUR_HARI,
				JNS_KELAMIN_LK,JNS_KELAMIN_PR,NILAI_RUJUKAN,SATUAN,METHODE,CH_REPORT,NAMA_PEMERIKSAAN,
				LABEL_UMUR)
				VALUES("' . $umur_tahun . '","' . $umur_bulan . '","' . $umur_hari . '",
				"' . $jns_kelamin_lk . '","' . $jns_kelamin_pr . '","' . $nilai_rujukan . '","' . $satuan . '","' . $methode . '",
				"' . $pemeriksaan_group . '","' . $pemeriksaan . '",
				"' . $label_umur . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE m_nilai_rujukan_laboratorium 
					SET UMUR_TAHUN = "' . $umur_tahun . '",UMUR_BULAN = "' . $umur_bulan . '",UMUR_HARI = "' . $umur_hari . '",
					JNS_KELAMIN_LK = "' . $jns_kelamin_lk . '",JNS_KELAMIN_PR = "' . $jns_kelamin_pr . '",NILAI_RUJUKAN = "' . $nilai_rujukan . '",
					SATUAN = "' . $satuan . '",METHODE = "' . $methode . '",LABEL_UMUR = "' . $label_umur . '"
					WHERE m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID = "' . $nilai_rujukan_id . '"') or die(mysql_error());
	}
	?>
	<script language="JavaScript" >
        window.location = "index.php?link=<?php echo md5('laboratoriumformnilairujukan'); ?>&pemeriksaan_group=<?php echo $pemeriksaan_group; ?>&pemeriksaan=<?php echo $pemeriksaan; ?>";
    </script> 
	<?php	
} 	
}				
?>
<form name="searchicd" method="post" action="index.php?link=<?php echo md5('laboratoriumformaddnilairujukan'); ?>&pemeriksaan_group=<?php echo $_GET['pemeriksaan_group']; ?>&pemeriksaan=<?php echo $_GET['pemeriksaan']; ?>">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <table class="tableform" border="0" >
        <tr>
            <td>Group Pemeriksaan</td>
            <td><?php echo $_GET['pemeriksaan_group']; ?></td>
        </tr>
		<tr>
            <td>Pemeriksaan</td>
            <td><?php echo $_GET['pemeriksaan']; ?></div></td>
        </tr>
		<tr>
			<td>Methode</td>
			<td><input type="text" name="methode" value="<?php echo $methode; ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Satuan</td>
			<td><input type="text" name="satuan" value="<?php echo $satuan; ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Keterangan Umur</td>
			<td><input type="text" name="label_umur" value="<?php echo $label_umur; ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Umur Sampai Dengan</td>
			<td>Tahun&nbsp;&nbsp;<input type="text" name="umur_tahun" value="<?php echo $umur_tahun; ?>" class="text_dt" style="text-align:right;" size="5" />&nbsp;&nbsp;
			Bulan&nbsp;&nbsp;<input type="text" name="umur_bulan" value="<?php echo $umur_bulan; ?>" class="text_dt" style="text-align:right;" size="5" />&nbsp;<i>(max 11)</i>&nbsp;&nbsp;
			Hari&nbsp;&nbsp;<input type="text" name="umur_hari" value="<?php echo $umur_hari; ?>" class="text_dt" style="text-align:right;" size="5" />&nbsp;<i>(max 29)</i></td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td><input type="checkbox" name="jns_kelamin_lk" value="1" <?php if($jns_kelamin_lk == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;Laki-laki&nbsp;&nbsp;
			<input type="checkbox" name="jns_kelamin_pr" value="1" <?php if($jns_kelamin_pr == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;Perempuan</td>
		</tr>
		<tr>
			<td>Nilai Rujukan</td>
			<td><input type="text" name="nilai_rujukan" value="<?php echo $nilai_rujukan; ?>" class="text_dt" size="30" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="index.php?link=<?php echo md5('laboratoriumformnilairujukan'); ?>&pemeriksaan_group=<?php echo $_GET['pemeriksaan_group']; ?>&pemeriksaan=<?php echo $_GET['pemeriksaan']; ?>" ><input type="button" value="tutup" class="myButton1" /></a>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="pemeriksaan_group" value="<?php echo $_REQUEST['pemeriksaan_group']; ?>" />
	<input type="hidden" name="pemeriksaan" value="<?php echo $_REQUEST['pemeriksaan']; ?>" />
	<input type="hidden" name="nilai_rujukan_id" value="<?php echo $nilai_rujukan_id; ?>" />
</div>
</form>
<?php } ?>