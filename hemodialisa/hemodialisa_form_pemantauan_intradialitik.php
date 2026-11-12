<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$idx = $_GET['idx'];	
$pemantauan_id = '';
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$pra_hemodialisa = '';
$keluhan = '';
$bbtb = '';
$kesadaran = '';	
$td = '';	
$nafas_nadi = '';	
$suhu = '';	
$qb = '';	
$qd = '';
$tek_vena = '';	
$tmp = '';	
$volume = '';	
$asesmen = '';		

if (isset($_GET['idrc'])){

	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>&idrc=<?php echo $_GET['idrc']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
	}
	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM t_irja_pemantauan_intradialitik WHERE PEMANTAUAN_ID = "' . $_GET['idrc'] . '"');
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
	}
}    

if (isset($_POST['pemantauan_id'])){
	if($jns_order == ''){
		if(empty($_POST['pemantauan_id'])){
			mysql_query('INSERT INTO t_irja_pemantauan_intradialitik (
				IRJA_ID,PRA_HEMODIALISA,JAM,KELUHAN,BB_TB,KESADARAN,TEKANAN_DARAH,NAFAS_NADI,
				SUHU,QB,QD,TEKANAN_VENA,TMP,VOLUME_YANG_DITARIK,ASSESMENT,PERAWAT,TGL_ASSESMENT,
				RESGISTER)
				VALUES("' . $_POST['idx'] . '",
				"' . ((isset($_POST['pra_hemodialisa'])) ? '1' : '') . '",
				STR_TO_DATE("' . $tanggal . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
				"' . replace_quote($_POST['keluhan']) . '",
				"' . replace_quote($_POST['bbtb']) . '",
				"' . replace_quote($_POST['kesadaran']) . '",
				"' . replace_quote($_POST['td']) . '",
				"' . replace_quote($_POST['nafas_nadi']) . '",
				"' . replace_quote($_POST['suhu']) . '",
				"' . replace_quote($_POST['qb']) . '",
				"' . replace_quote($_POST['qd']) . '",
				"' . replace_quote($_POST['tek_vena']) . '",
				"' . replace_quote($_POST['tmp']) . '",
				"' . replace_quote($_POST['volume']) . '",
				"' . replace_quote($_POST['asesmen']) . '",
				"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				NOW(),
				"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				)') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemantauan_intradialitik 
				SET PRA_HEMODIALISA = "' . ((isset($_POST['pra_hemodialisa'])) ? '1' : '') . '",
				JAM = STR_TO_DATE("' . $tanggal . ' ' . $_POST['jam'] . ':' . $_POST['$menit'] . '","%d/%m/%Y %H:%i"),
				KELUHAN = "' . replace_quote($_POST['keluhan']) . '", 
				BB_TB = "' . replace_quote($_POST['bbtb']) . '",
				KESADARAN = "' . replace_quote($_POST['kesadaran']) . '",
				TEKANAN_DARAH = "' . replace_quote($_POST['td']) . '",
				NAFAS_NADI = "' . replace_quote($_POST['nafas_nadi']) . '",
				SUHU = "' . replace_quote($_POST['suhu']) . '",
				QB = "' . replace_quote($_POST['qb']) . '",
				QD = "' . replace_quote($_POST['qd']) . '",
				TEKANAN_VENA = "' . replace_quote($_POST['tek_vena']) . '",
				TMP = "' . replace_quote($_POST['tmp']) . '",
				VOLUME_YANG_DITARIK = "' . replace_quote($_POST['volume']) . '",
				ASSESMENT = "' . replace_quote($_POST['asesmen']) . '",
				PERAWAT = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				TGL_ASSESMENT = NOW(),
				RESGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE PEMANTAUAN_ID = "' . $_POST['pemantauan_id'] . '"') or die(mysql_error());	
		}		
	}else{
		if(empty($_POST['pemantauan_id'])){
			mysql_query('INSERT INTO t_hemodialisa_pemantauan_intradialitik (
				HEMODIALISA_ID,PRA_HEMODIALISA,JAM,KELUHAN,BB_TB,KESADARAN,TEKANAN_DARAH,NAFAS_NADI,
				SUHU,QB,QD,TEKANAN_VENA,TMP,VOLUME_YANG_DITARIK,ASSESMENT,PERAWAT,TGL_ASSESMENT,
				RESGISTER)
				VALUES("' . $_POST['idx'] . '",
				"' . ((isset($_POST['pra_hemodialisa'])) ? '1' : '') . '",
				STR_TO_DATE("' . $tanggal . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
				"' . replace_quote($_POST['keluhan']) . '",
				"' . replace_quote($_POST['bbtb']) . '",
				"' . replace_quote($_POST['kesadaran']) . '",
				"' . replace_quote($_POST['td']) . '",
				"' . replace_quote($_POST['nafas_nadi']) . '",
				"' . replace_quote($_POST['suhu']) . '",
				"' . replace_quote($_POST['qb']) . '",
				"' . replace_quote($_POST['qd']) . '",
				"' . replace_quote($_POST['tek_vena']) . '",
				"' . replace_quote($_POST['tmp']) . '",
				"' . replace_quote($_POST['volume']) . '",
				"' . replace_quote($_POST['asesmen']) . '",
				"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				NOW(),
				"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				)') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_hemodialisa_pemantauan_intradialitik 
				SET PRA_HEMODIALISA = "' . ((isset($_POST['pra_hemodialisa'])) ? '1' : '') . '",
				JAM = STR_TO_DATE("' . $tanggal . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
				KELUHAN = "' . replace_quote($_POST['keluhan']) . '", 
				BB_TB = "' . replace_quote($_POST['bbtb']) . '",
				KESADARAN = "' . replace_quote($_POST['kesadaran']) . '",
				TEKANAN_DARAH = "' . replace_quote($_POST['td']) . '",
				NAFAS_NADI = "' . replace_quote($_POST['nafas_nadi']) . '",
				SUHU = "' . replace_quote($_POST['suhu']) . '",
				QB = "' . replace_quote($_POST['qb']) . '",
				QD = "' . replace_quote($_POST['qd']) . '",
				TEKANAN_VENA = "' . replace_quote($_POST['tek_vena']) . '",
				TMP = "' . replace_quote($_POST['tmp']) . '",
				VOLUME_YANG_DITARIK = "' . replace_quote($_POST['volume']) . '",
				ASSESMENT = "' . replace_quote($_POST['asesmen']) . '",
				PERAWAT = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				TGL_ASSESMENT = NOW(),
				RESGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE PEMANTAUAN_ID = "' . $_POST['pemantauan_id'] . '"') or die(mysql_error());	
		}		
	}
	
	/*
	include('lib/vendor/autoload.php');
	include('lib/html2openxml/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_pemantauan_intradialitik.php');
	erm_pemantauan_intradialitik($_POST['idx'],$jns_order,$_POST['idxord']);
	*/
	?>
	<script language="JavaScript" >
        alert('Simpan Data Pemantauan Intridialitik Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>";
	</script>	
<?php }

if($jns_order == ''){
	$sql_pemantauan = 'SELECT PEMANTAUAN_ID,IRJA_ID,PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%H:%i") AS JAM,
					KELUHAN,BB_TB,KESADARAN,
					TEKANAN_DARAH,NAFAS_NADI,SUHU,QB,QD,TEKANAN_VENA,TMP,VOLUME_YANG_DITARIK,ASSESMENT
					FROM t_irja_pemantauan_intradialitik
					WHERE IRJA_ID = "' . $idx . '"
					ORDER BY JAM';
}else{
	$sql_pemantauan = 'SELECT PEMANTAUAN_ID,HEMODIALISA_ID,PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%H:%i") AS JAM,
					KELUHAN,BB_TB,KESADARAN,
					TEKANAN_DARAH,NAFAS_NADI,SUHU,QB,QD,TEKANAN_VENA,TMP,VOLUME_YANG_DITARIK,ASSESMENT
					FROM t_hemodialisa_pemantauan_intradialitik
					WHERE HEMODIALISA_ID = "' . $idx . '"
					ORDER BY JAM';
}	
$get_pemantauan = mysql_query($sql_pemantauan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>Jam</th>
	<th>Keluhan</th>
	<th>BB (kg)<br/>/TB (cm)</th>
	<th>Kesadaran</th>
	<th>Tekanan<br/>Darah</th>
	<th>Nafas<br/>/Nadi<br/>(x/menit)</th>
	<th>Suhu<br/>(<span>&#8451;</span>)</th>
	<th>Qb<br/>(ml/menit)</th>
	<th>Qd<br/>(ml/menit)</th>
	<th>Tekanan Vena<br/>(mmhg)</th>
	<th>TMP<br/>(mmhg)</th>
	<th>Volume Yg<br/>Ditarik (ml)</th>
	<th>Asesmen/Intervensi<br/>/Keterangan/Tranfusi<br/>/Obat Insidental</th>
	<th>Option</th>
</tr>
<?php while($dat_pemantauan = mysql_fetch_array($get_pemantauan)){ ?>
	<tr>
		<td><?php echo $dat_pemantauan['JAM']; 
			if($dat_pemantauan['PRA_HEMODIALISA'] == '1') echo ' (Pra)'; ?></td>
		<td><?php echo $dat_pemantauan['KELUHAN']; ?></td>
		<td><?php echo $dat_pemantauan['BB_TB']; ?></td>
		<td><?php echo $dat_pemantauan['KESADARAN']; ?></td>
		<td><?php echo $dat_pemantauan['TEKANAN_DARAH']; ?></td>
		<td><?php echo $dat_pemantauan['NAFAS_NADI']; ?></td>
		<td><?php echo $dat_pemantauan['SUHU']; ?></td>
		<td><?php echo $dat_pemantauan['QB']; ?></td>
		<td><?php echo $dat_pemantauan['QD']; ?></td>
		<td><?php echo $dat_pemantauan['TEKANAN_VENA']; ?></td>
		<td><?php echo $dat_pemantauan['TMP']; ?></td>
		<td><?php echo $dat_pemantauan['VOLUME_YANG_DITARIK']; ?></td>
		<td><?php echo $dat_pemantauan['ASSESMENT']; ?></td>
		<td><?php if($hemodialisa_final == '' and (isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])
				or isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']))){ ?>
		<a href="<?php echo currentUrl(); ?>&vdrc=<?php echo $dat_pemantauan['PEMANTAUAN_ID']; ?>" >ubah</a>
		<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_pemantauan['PEMANTAUAN_ID']; ?>&nmr=<?php echo $dat_pemantauan['JAM']; ?>" >hapus</a>
		<?php } ?>
		</td>
	</tr>
<?php } ?>
</table>
<br/>
<br/>
<?php 
if(isset($_GET['vdrc'])){
	if($jns_order == ''){
		$qry_pemantauan = 'SELECT PEMANTAUAN_ID,
					PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%d/%m/%Y") AS TANGGAL,
					DATE_FORMAT(JAM,"%H") AS JAM,
					DATE_FORMAT(JAM,"%i") AS MENIT,
					KELUHAN,
					BB_TB,
					KESADARAN,
					TEKANAN_DARAH,
					NAFAS_NADI,
					SUHU,
					QB,
					QD,
					TEKANAN_VENA,
					TMP,
					VOLUME_YANG_DITARIK,
					ASSESMENT
				FROM t_irja_pemantauan_intradialitik 
				WHERE PEMANTAUAN_ID = "' . $_GET['vdrc'] . '"';
	}else{			
		$qry_pemantauan = 'SELECT PEMANTAUAN_ID,
					PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%d/%m/%Y") AS TANGGAL,
					DATE_FORMAT(JAM,"%H") AS JAM,
					DATE_FORMAT(JAM,"%i") AS MENIT,
					KELUHAN,
					BB_TB,
					KESADARAN,
					TEKANAN_DARAH,
					NAFAS_NADI,
					SUHU,
					QB,
					QD,
					TEKANAN_VENA,
					TMP,
					VOLUME_YANG_DITARIK,
					ASSESMENT 
				FROM t_hemodialisa_pemantauan_intradialitik 
				WHERE PEMANTAUAN_ID = "' . $_GET['vdrc'] . '"';
	}			
	$get_pemantauan = mysql_query($qry_pemantauan) or die(mysql_error());
	$dat_pemantauan = mysql_fetch_assoc($get_pemantauan);	
	$pemantauan_id = $dat_pemantauan['PEMANTAUAN_ID'];
	$tanggal = $dat_pemantauan['TANGGAL'];
	$jam = $dat_pemantauan['JAM'];
	$menit = $dat_pemantauan['MENIT'];
	$pra_hemodialisa = $dat_pemantauan['PRA_HEMODIALISA'];
	$keluhan = $dat_pemantauan['KELUHAN'];
	$bbtb = $dat_pemantauan['BB_TB'];
	$kesadaran = $dat_pemantauan['KESADARAN'];	
	$td = $dat_pemantauan['TEKANAN_DARAH'];	
	$nafas_nadi = $dat_pemantauan['NAFAS_NADI'];	
	$suhu = $dat_pemantauan['SUHU'];	
	$qb = $dat_pemantauan['QB'];	
	$qd = $dat_pemantauan['QD'];
	$tek_vena = $dat_pemantauan['TEKANAN_VENA'];	
	$tmp = $dat_pemantauan['TMP'];	
	$volume = $dat_pemantauan['VOLUME_YANG_DITARIK'];	
	$asesmen = $dat_pemantauan['ASSESMENT'];		
}
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
	<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php echo $pemantauan_id; ?>" />
	<input type="hidden" name="idxord" id="idxord" value="<?php echo $idxord; ?>" />
	<input type="hidden" name="jns_perawatan" id="jns_perawatan" value="<?php echo $jns_perawatan; ?>" />
	<table border="0" width="90%">
	<tr>
    <td>&nbsp;</td>
    <td>Jam</td>
    <td><select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="pra_hemodialisa" value="1" <?php if($pra_hemodialisa == '1') echo 'checked'; ?>/>&nbsp;Pra Hemodialisa
			<input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>" /></td>
    <td>&nbsp;</td>
	</tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">Keluhan</td>
    <td colspan="2"><textarea name="keluhan" id="keluhan" rows="3" class="text_dt2" ><?php echo $keluhan; ?></textarea></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">BB (kg) / TB (cm)</td>
    <td colspan="2"><input type="text" name="bbtb" id="bbtb" value="<?php echo $bbtb; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Kesadaran</td>
    <td colspan="2"><input type="text" name="kesadaran" id="kesadaran" value="<?php echo $kesadaran; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Tekanan Darah</td>
    <td colspan="2"><input type="text" name="td" id="td" value="<?php echo $td; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Nafas / Nadi (x/menit)</td>
    <td colspan="2"><input type="text" name="nafas_nadi" id="nafas_nadi" value="<?php echo $nafas_nadi; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Suhu (<span>&#8451;</span>)</td>
    <td colspan="2"><input type="text" name="suhu" id="suhu" value="<?php echo $suhu; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Qb (ml/menit)</td>
    <td colspan="2"><input type="text" name="qb" id="qb" value="<?php echo $qb; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Qd (ml/menit)</td>
    <td colspan="2"><input type="text" name="qd" id="qd" value="<?php echo $qd; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Tekanan Vena (mmhg)</td>
    <td colspan="2"><input type="text" name="tek_vena" id="tek_vena" value="<?php echo $tek_vena; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">TMP (mmhg)</td>
    <td colspan="2"><input type="text" name="tmp" id="tmp" value="<?php echo $tmp; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Volume Yg Ditarik (ml)</td>
    <td colspan="2"><input type="text" name="volume" id="volume" value="<?php echo $volume; ?>" class="text_dt" style="width:500px;" ></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
	<td valign="top">Asesmen/Intervensi
				/Keterangan<br/>/Tranfusi
			/Obat Insidental</td>
    <td colspan="2"><textarea name="asesmen" id="asesmen" rows="3" class="text_dt2" ><?php echo $asesmen; ?></textarea></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($hemodialisa_final == '' and (isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])
				or isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']))){ ?>
				<input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_pemantauan();" />
	<?php 	$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "' . $jns_perawatan . '"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idxord . '"
						' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
						AND JENIS_DOKUMEN_ID = "33"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				if(mysql_num_rows($get_view_rm) >0){
					$dat_view_rm = mysql_fetch_assoc($get_view_rm);
				?>
					<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />			
				<?php } } ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  </table>
</form>
<script>
function simpan_pemantauan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>