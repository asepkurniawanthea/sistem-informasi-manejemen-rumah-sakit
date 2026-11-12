<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_tindakan.php');

if (isset($_GET['idk']))
    include('rawatinap/ranap_del_add_tindakan.php');

$irna_id = $_GET['idx'];
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');

$tgl_filter = '';
$tgl_filter2 = '';
$ruang_tindakan = '';
$nama_tindakan = '';
if (isset($_SESSION['ranapformtindakan_tgl_filter' . $irna_id])){
	$tgl_filter = $_SESSION['ranapformtindakan_tgl_filter' . $irna_id];
	$tgl_filter2 = $_SESSION['ranapformtindakan_tgl_filter2' . $irna_id];
	$ruang_tindakan = $_SESSION['ranapformtindakan_ruang_tindakan' . $irna_id];
	$nama_tindakan = $_SESSION['ranapformtindakan_nama_tindakan' . $irna_id];
}		

if (isset($_POST['tgl_filter'])) {
    $tgl_filter = $_POST['tgl_filter'];
	$_SESSION['ranapformtindakan_tgl_filter' . $irna_id] = $tgl_filter;
	$tgl_filter2 = $_POST['tgl_filter2'];
	$_SESSION['ranapformtindakan_tgl_filter2' . $irna_id] = $tgl_filter2;
	$ruang_tindakan = $_POST['ruang_tindakan'];
	$_SESSION['ranapformtindakan_ruang_tindakan' . $irna_id] = $ruang_tindakan;
	$nama_tindakan = $_POST['nama_tindakan'];
	$_SESSION['ranapformtindakan_nama_tindakan' . $irna_id] = $nama_tindakan;
?>
<script language="JavaScript" >
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php	
}
?>
<form name="search" method="post" onchange="false_kan();">
<table width="100%" border="0">
	<tr>
		<td width="60px">&nbsp;Tanggal</td>
		<td width="160px"><input type="text" name="tgl_filter" id="tgl_1" value="<?php echo $tgl_filter; ?>" size="15" class="text_dt" onblur="false_kan();" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
		<td width="20px">&nbsp;Sd</td>
		<td width="160px"><input type="text" name="tgl_filter2" id="tgl_2" value="<?php echo $tgl_filter2; ?>" size="15" class="text_dt" onblur="false_kan();" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>		
		<td width="50px">&nbsp;Ruang</td>
		<td width="250px">
			<select name="ruang_tindakan" style="width:250px;" class="text_dt" onblur="false_kan();">
			<option value="">--</option>
			<?php
			$qry_kamar = 'SELECT DISTINCT t_log.NAMA_RUANG,t_log.RUANG_ID
					FROM (
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1
						) AS TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $irna_id . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NOT NULL
						UNION ALL
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						t_irna_log.TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $irna_id . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NULL
					) t_log	 
					ORDER BY t_log.TANGGAL_MASUK';
			$get_kamar = mysql_query($qry_kamar) or die(mysql_error());
			while($data_kamar = mysql_fetch_array($get_kamar)){
				echo '<option value="' . $data_kamar['RUANG_ID'] . '" ' . (($ruang_tindakan == $data_kamar['RUANG_ID']) ? 'selected="selected"' : '') . '>' . $data_kamar['NAMA_RUANG'] . '</option>';	
			}
			?>	
			</select>
		</td>
		<td width="70px">&nbsp;Tindakan</td>
		<td width="80px"><input type="text" name="nama_tindakan" id="nama_tindakan" value="<?php echo $nama_tindakan; ?>" class="text_dt" onblur="false_kan();" /></td>
		<td>&nbsp;<input type="submit" name="filter" value="filter" class="myButton1" /></td>		
	</tr>
</table>
</form>
<br />
<form name="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_tindakan.php'); ?>
	</table>
	<?php if($irna_final == ''){ ?>
	<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			Tanggal&nbsp;&nbsp;
			<input type="text" name="tanggal" id="tgl_3" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" onblur="false_kan();" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" onblur="false_kan();" >
			<?php echo getMenit($menit); ?>
			</select>&nbsp;&nbsp;
			<?php //if(in_array($_SESSION['SES_SIMRS_NAMA_USER'],getUserCasemix())){ ?>
			<select name="ruang_id_tindakan" id="ruang_id_tindakan" style="width:228px;" class="text_dt" onchange="getTmpTidur(this.value,'<?php echo $tmp_tidur; ?>');" onblur="false_kan();" >
			<option value=""> - </option>
			<?php echo getRuangRawat(''); ?>
			</select>
			<?php //} ?>
			<?php $grp_tarif = '52';
			if(strtoupper($kelas_rawat) == 'IGD') $grp_tarif = '02'; ?> 	
			<a href="#" onclick="window.open('index.php?popup=ranapformtindakan&idx=<?php echo $irna_id; ?>&kelas=<?php echo $kelas_rawat; ?>&pegawai=<?php echo $pegawai_id; ?>&ruang=<?php echo $ruang_id; ?>&grp=<?php echo $grp_tarif; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas_rawat; ?>" />
			<input type="hidden" name="kelas_jaminan" value="<?php echo $kelas_jaminan; ?>" />
			
			<!--<input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>" />
			<input type="hidden" name="jam" value="<?php echo $jam; ?>" />
			<input type="hidden" name="menit" value="<?php echo $menit; ?>" />-->
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>
	<?php } ?>
</form>