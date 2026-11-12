<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = preg_replace('~\r\n?~', "\n", $ret);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$irna_id = $_GET['idx'];

if(isset($_POST['irna_id'])){
		$antropometri = array(
			'bb' => replace_quote($_POST['bb']),
			'lila' => replace_quote($_POST['lila']),
			'imt' => replace_quote($_POST['imt']),
			'tb' => replace_quote($_POST['tb']),
			'tilut' => replace_quote($_POST['tilut']),
			'status_gizi' => replace_quote($_POST['status_gizi'])
		);
		
		$antropometri = json_encode($antropometri);
		$antropometri = str_replace('"','|',$antropometri);
		
		$intervensi_gizi = array(
			'tujuan' => replace_quote($_POST['tujuan']),
			'intervensi' => replace_quote($_POST['intervensi']),
			'konseling' => replace_quote($_POST['konseling'])
		);
		
		$intervensi_gizi = json_encode($intervensi_gizi);
		$intervensi_gizi = str_replace('"','|',$intervensi_gizi);
		
		$st_selesai = 'NULL';
		if(isset($_POST['selesai'])) $st_selesai = '"1"';
		
	if($_POST['idx_asuhan'] == ''){
		mysql_query('INSERT INTO t_irna_asuhan_gizi (IRNA_ID,ANTROPOMETRI,BIOKIMIA,KLINIK,RIWAYAT_GIZI,
				RIWAYAT_PERSONAL,DIAGNOSA_GIZI,INTERVENSI_GIZI,MONITORING_EVALUASI,
				TGL_ASSESMENT,PEGAWAI_ID,ST_SELESAI,USER_GIZI,ST_CREATE_ERM,TANGGAL)
				VALUES("' . $_POST['irna_id'] . '","' . $antropometri . '",
				"' . replace_quote($_POST['biokimia']) . '","' . replace_quote($_POST['klinik']) . '",
				"' . replace_quote($_POST['riwayat_gizi']) . '","' . replace_quote($_POST['riwayat_personal']) . '",
				"' . replace_quote($_POST['diagnosa_gizi']) . '","' . $intervensi_gizi . '",
				"' . replace_quote($_POST['monitoring']) . '",NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				"' . $st_selesai . '","' . $user_name . '",NULL,
				STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"))') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_asuhan_gizi SET ANTROPOMETRI = "' . $antropometri . '",
				BIOKIMIA = "' . replace_quote($_POST['biokimia']) . '",
				KLINIK = "' . replace_quote($_POST['klinik']) . '",
				RIWAYAT_GIZI = "' . replace_quote($_POST['riwayat_gizi']) . '",
				RIWAYAT_PERSONAL = "' . replace_quote($_POST['riwayat_personal']) . '",
				DIAGNOSA_GIZI = "' . replace_quote($_POST['diagnosa_gizi']) . '",
				INTERVENSI_GIZI = "' . $intervensi_gizi . '",
				MONITORING_EVALUASI = "' . replace_quote($_POST['monitoring']) . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_SELESAI = "' . $st_selesai . '",
				USER_GIZI = "' . $user_name . '",
				ST_CREATE_ERM = NULL,
				TANGGAL = STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y")
				WHERE IRNA_ASUHAN_ID = "' . $_POST['idx_asuhan'] . '"') or die(mysql_error());
	}	
	?>
		<script language="JavaScript" >
			alert('Simpan Data Asuhan Gizi Berhasil.');
			window.location = "index.php?link=74ac04efa30ba0f5fb861758cbad5b3a&smn=asgz&idx=<?php echo $_GET['idx']; ?>";
		</script>
	<?php
}

$sql_asuhan_gizi = 'SELECT DISTINCT IRNA_ASUHAN_ID,DATE_FORMAT(d.TANGGAL,"%d/%m/%Y") AS TANGGAL,
	DATE_FORMAT(d.TANGGAL,"%d%m%Y") AS TANGGAL_LNK
	FROM t_irna_asuhan_gizi d
	WHERE d.IRNA_ID = "' . $irna_id . '"';
$get_asuhan_gizi = mysql_query($sql_asuhan_gizi) or die(mysql_error());	
if(mysql_num_rows($get_asuhan_gizi) > 0){
?>
<table width="100%" border="1" class="tableData">
<tr>
<?php
$st_tr = '';
$x = 1;
while($dat_asuhan_gizi = mysql_fetch_array($get_asuhan_gizi)){ 
	echo '<td align="center"><a href="index.php?link=' . $_GET['link'] . '&smn=asgz&idx=' . $_GET['idx'] . '&ida=' . $dat_asuhan_gizi['IRNA_ASUHAN_ID'] . '">' . $dat_asuhan_gizi['TANGGAL'] . '</a></td>';
	if($x == 10){
		echo '</tr><tr>';
		$st_tr = '1';
		$x = 1;
	}	
	$x++;
} 
if($x < 10){
	$z = $x;
	while($z < 12){
		echo '<td align="center">&nbsp;</td>';
	$z++;
	}	
}	
if($st_tr == '') echo '</tr>';
?>
</table></br>
<?php } ?> 

<br/>
<?php 
$antropometri = array();
$biokomia = '';
$klinik = '';
$riwayat_gizi = '';
$riwayat_personal = '';
$diagnosa_gizi = '';
$intervensi_gizi = array();
$monitoring = '';

$idx_asuhan = '';
$tgl_assesment = '';
$tgl_skr = '';
$selesai = '';
$tanggal = '';

if(isset($_GET['ida'])){
	$qry_det_asuhan = 'SELECT DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,IRNA_ASUHAN_ID,ANTROPOMETRI,
				BIOKIMIA,KLINIK,RIWAYAT_GIZI,RIWAYAT_PERSONAL,DIAGNOSA_GIZI,
				INTERVENSI_GIZI,MONITORING_EVALUASI
				FROM t_irna_asuhan_gizi
				WHERE IRNA_ASUHAN_ID = "' . $_GET['ida'] . '"';
	$get_det_asuhan = mysql_query($qry_det_asuhan) or die(mysql_error());
	$dat_det_asuhan = mysql_fetch_assoc($get_det_asuhan); 	
	$antropometri = str_replace('|','"',$dat_det_asuhan['ANTROPOMETRI']);
	$antropometri = preg_replace('/\r|\n/','\n',trim($antropometri));
	$antropometri = json_decode($antropometri,true);
	$biokomia = $dat_det_asuhan['BIOKIMIA'];
	$klinik = $dat_det_asuhan['KLINIK'];
	$riwayat_gizi = $dat_det_asuhan['RIWAYAT_GIZI'];
	$riwayat_personal = $dat_det_asuhan['RIWAYAT_PERSONAL'];
	$diagnosa_gizi = $dat_det_asuhan['DIAGNOSA_GIZI'];
	$intervensi_gizi = str_replace('|','"',$dat_det_asuhan['INTERVENSI_GIZI']);
	$intervensi_gizi = preg_replace('/\r|\n/','\n',trim($intervensi_gizi));
	$intervensi_gizi = json_decode($intervensi_gizi,true);
	$monitoring = $dat_det_asuhan['MONITORING_EVALUASI'];
	$tanggal = $dat_det_asuhan['TANGGAL'];
	$idx_asuhan = $_GET['ida'];
}	
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $idx; ?>" />
	<input type="hidden" name="idx_asuhan" id="idx_asuhan" value="<?php echo $idx_asuhan; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $selesai; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
    <table border="0" width="90%">
		<tr>
			<td>Tanggal</td>
			<td><input type="text" name="tanggal" id="tgl_3" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/><td>
			<td colspan="5"></td>
		</tr>
        <tr>
            <td>BB</td>
            <td><input type="text" name="bb" value="<?php echo ((isset($antropometri['bb']) ? $antropometri['bb'] : '')); ?>" class="text_dt" > kg</td>
			<td>&nbsp;</td>
			<td>LILA</td>
            <td><input type="text" name="lila" value="<?php echo ((isset($antropometri['lila']) ? $antropometri['lila'] : '')); ?>" class="text_dt" > cm</td>
			<td>&nbsp;</td>
			<td>IMT</td>
            <td><input type="text" name="imt" value="<?php echo ((isset($antropometri['imt']) ? $antropometri['imt'] : '')); ?>" class="text_dt" > kg/m2</td>
		</tr>
		<tr>
            <td>TB</td>
            <td><input type="text" name="tb" value="<?php echo ((isset($antropometri['tb']) ? $antropometri['tb'] : '')); ?>" class="text_dt" > cm</td>
			<td>&nbsp;</td>
			<td>Tilut</td>
            <td><input type="text" name="tilut" value="<?php echo ((isset($antropometri['tilut']) ? $antropometri['tilut'] : '')); ?>" class="text_dt" > cm</td>
			<td>&nbsp;</td>
			<td>Status Gizi</td>
            <td><input type="text" name="status_gizi" value="<?php echo ((isset($antropometri['status_gizi']) ? $antropometri['status_gizi'] : '')); ?>" class="text_dt" ></td>
		</tr>
        <tr>
            <td>Biokimia</td>
            <td colspan="7">
                <textarea name="biokimia" id="biokimia" cols="100" style="height:100px;" class="text_dt"><?php echo $biokomia; ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Klinik/ Fisik</td>
            <td colspan="7">
                <textarea name="klinik" id="klinik" cols="100" style="height:100px;" class="text_dt"><?php echo $klinik; ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Riwayat Gizi</td>
            <td colspan="7">
                <textarea name="riwayat_gizi" id="riwayat_gizi" cols="100" style="height:100px;" class="text_dt"><?php echo $riwayat_gizi; ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Riwayat Personal</td>
            <td colspan="7">
                <textarea name="riwayat_personal" id="riwayat_personal" cols="100" style="height:100px;" class="text_dt"><?php echo $riwayat_personal; ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Diagnosa Gizi</td>
            <td colspan="7">
                <textarea name="diagnosa_gizi" id="diagnosa_gizi" cols="100" style="height:100px;" class="text_dt"><?php echo $diagnosa_gizi; ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Intervensi Gizi</td>
			<td>Tujuan</td>
            <td colspan="6">
                <textarea name="tujuan" id="tujuan" cols="73" style="height:100px;" class="text_dt"><?php echo ((isset($intervensi_gizi['tujuan']) ? $intervensi_gizi['tujuan'] : '')); ?></textarea>
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td>Intervensi</td>
            <td colspan="6">
                <textarea name="intervensi" id="intervensi" cols="73" style="height:100px;" class="text_dt"><?php echo ((isset($intervensi_gizi['intervensi']) ? $intervensi_gizi['intervensi'] : '')); ?></textarea>
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td>Konseling Gizi/ Edukasi</td>
            <td colspan="6">
                <textarea name="konseling" id="konseling" cols="73" style="height:100px;" class="text_dt"><?php echo ((isset($intervensi_gizi['konseling']) ? $intervensi_gizi['konseling'] : '')); ?></textarea>
            </td>
        </tr>
		<tr>
            <td>Monitoring dan Evaluasi</td>
            <td colspan="7">
                <textarea name="monitoring" id="monitoring" cols="100" style="height:100px;" class="text_dt"><?php echo $monitoring; ?></textarea>
            </td>
        </tr>
        <tr><td colspan="8" align="right">
			<?php if($irna_final == ''){ ?>
			<input type="button" value="simpan" class="myButton" onclick="simpan();" />
			<?php } ?>
		   </td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>