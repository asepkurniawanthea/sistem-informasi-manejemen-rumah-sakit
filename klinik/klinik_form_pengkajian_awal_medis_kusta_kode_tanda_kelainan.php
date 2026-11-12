<?php
if (isset($_POST['irja_id'])){
	$st_save = true;
	if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
	if($pegawai_id != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	if($st_save){
		$kode = array('01'=>((isset($_POST['td_01'])) ? '1' : ''),
						'02'=>((isset($_POST['td_02'])) ? '1' : ''),
						'03'=>((isset($_POST['td_03'])) ? '1' : ''),
						'04'=>((isset($_POST['td_04'])) ? '1' : ''),
						'05'=>((isset($_POST['td_05'])) ? '1' : ''),
						'06'=>((isset($_POST['td_06'])) ? '1' : ''),
						'07'=>((isset($_POST['td_07'])) ? '1' : ''),
						'08'=>((isset($_POST['td_08'])) ? '1' : ''),
						'09'=>((isset($_POST['td_09'])) ? '1' : ''),
						'10'=>((isset($_POST['td_10'])) ? '1' : ''),
						'11'=>((isset($_POST['td_11'])) ? '1' : ''),
						'12'=>((isset($_POST['td_12'])) ? '1' : ''),
						'13'=>((isset($_POST['td_13'])) ? '1' : ''),
						'14'=>((isset($_POST['td_14'])) ? '1' : ''),
						'15'=>((isset($_POST['td_15'])) ? '1' : ''),
						'16'=>((isset($_POST['td_16'])) ? '1' : ''),
						'17'=>((isset($_POST['td_17'])) ? '1' : ''),
						'18'=>((isset($_POST['td_18'])) ? '1' : ''),
						'19'=>((isset($_POST['td_19'])) ? '1' : ''));
		$kode = json_encode($kode);
		$kode = str_replace('"','|',$kode);
		if(empty($_POST['idx'])){
			mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_kusta 
				(IRJA_ID,KODE_TANDA_KELAINAN,REGISTER)
				VALUES ("' . $_POST['irja_id'] . '","' . $kode . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pengkajian_awal_medis_kusta
				SET KODE_TANDA_KELAINAN = "' . $kode . '",
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Medis Kusta Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}
}	
$qry_pasien = 'SELECT IRJA_ID,KODE_TANDA_KELAINAN,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_irja_pengkajian_awal_medis_kusta
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$kode_tanda_kelainan = str_replace('|','"',$dat_pasien['KODE_TANDA_KELAINAN']);
$kode_tanda_kelainan = json_decode($kode_tanda_kelainan,true);
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />		
	<table border="0" align="center" style="position:static; " width="80%">
	   <tr>
			<td rowspan="20" width="200px" align="center"><img src="edoc_rekammedik/new/pengkajian_awal_medis_kusta_kode_tanda_kelainan.jpg" width="150px" /></td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_01" value="1" <?php echo ((isset($kode_tanda_kelainan['01']) and $kode_tanda_kelainan['01'] == '1') ? 'checked' : ''); ?> />&nbsp;Hypo Pigmentasi</td>
		</tr>
		<tr>
			<td height="40px;"><input type="checkbox" name="td_02" value="1" <?php echo ((isset($kode_tanda_kelainan['02']) and $kode_tanda_kelainan['02'] == '1') ? 'checked' : ''); ?> />&nbsp;Hypo/ Anaesthesia</td>
		</tr>
		<tr>
			<td height="45px;"><input type="checkbox" name="td_03" value="1" <?php echo ((isset($kode_tanda_kelainan['03']) and $kode_tanda_kelainan['03'] == '1') ? 'checked' : ''); ?> />&nbsp;Kelainan di kulit dengan batas tegas</td>
		</tr>
		<tr>
			<td height="45px;"><input type="checkbox" name="td_04" value="1" <?php echo ((isset($kode_tanda_kelainan['04']) and $kode_tanda_kelainan['04'] == '1') ? 'checked' : ''); ?> />&nbsp;Kelainan kulit dengan Hypo Pigmentasi dan Hypo/ Anaesthesia dengan batas tegas</td>
		</tr>
		<tr>
			<td height="40px;"><input type="checkbox" name="td_05" value="1" <?php echo ((isset($kode_tanda_kelainan['05']) and $kode_tanda_kelainan['05'] == '1') ? 'checked' : ''); ?> />&nbsp;Kelainan di kulit difus dan rata</td>
		</tr>
		<tr>
			<td height="50px;"><input type="checkbox" name="td_06" value="1" <?php echo ((isset($kode_tanda_kelainan['06']) and $kode_tanda_kelainan['06'] == '1') ? 'checked' : ''); ?> />&nbsp;Infeksi yang difus</td>
		</tr>
		<tr>
			<td height="40px;"><input type="checkbox" name="td_07" value="1" <?php echo ((isset($kode_tanda_kelainan['07']) and $kode_tanda_kelainan['07'] == '1') ? 'checked' : ''); ?> />&nbsp;Tonjolan (Papel, Nodule)</td>
		</tr>
		<tr>
			<td height="50px;"><input type="checkbox" name="td_08" value="1" <?php echo ((isset($kode_tanda_kelainan['08']) and $kode_tanda_kelainan['08'] == '1') ? 'checked' : ''); ?> />&nbsp;Penebalan urat syaraf</td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_09" value="1" <?php echo ((isset($kode_tanda_kelainan['09']) and $kode_tanda_kelainan['09'] == '1') ? 'checked' : ''); ?> />&nbsp;Alis mata rontok</td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_10" value="1" <?php echo ((isset($kode_tanda_kelainan['10']) and $kode_tanda_kelainan['10'] == '1') ? 'checked' : ''); ?> />&nbsp;Hidung pelana (penyok)</td>
		</tr>
		<tr>
			<td height="60px;"><input type="checkbox" name="td_11" value="1" <?php echo ((isset($kode_tanda_kelainan['11']) and $kode_tanda_kelainan['11'] == '1') ? 'checked' : ''); ?> />&nbsp;Kontraktur</td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_12" value="1" <?php echo ((isset($kode_tanda_kelainan['12']) and $kode_tanda_kelainan['12'] == '1') ? 'checked' : ''); ?> />&nbsp;Hilangnya jari-jari atau bagian dari anggota gerak (Mutilasi)</td>
		</tr>
		<tr>
			<td height="40px;"><input type="checkbox" name="td_13" value="1" <?php echo ((isset($kode_tanda_kelainan['13']) and $kode_tanda_kelainan['13'] == '1') ? 'checked' : ''); ?> />&nbsp;Atrophy otot</td>
		</tr>
		<tr>
			<td height="50px;"><input type="checkbox" name="td_14" value="1" <?php echo ((isset($kode_tanda_kelainan['14']) and $kode_tanda_kelainan['14'] == '1') ? 'checked' : ''); ?> />&nbsp;Ulkus Trophis</td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_15" value="1" <?php echo ((isset($kode_tanda_kelainan['15']) and $kode_tanda_kelainan['15'] == '1') ? 'checked' : ''); ?> />&nbsp;Drop foot, Wrist drop</td>
		</tr>
		<tr>
			<td height="50px;"><input type="checkbox" name="td_16" value="1" <?php echo ((isset($kode_tanda_kelainan['16']) and $kode_tanda_kelainan['16'] == '1') ? 'checked' : ''); ?> />&nbsp;Pembesaran buah dada pada penderita laki-laki (Ginaccomasti)</td>
		</tr>
		<tr>
			<td height="40px;"><input type="checkbox" name="td_17" value="1" <?php echo ((isset($kode_tanda_kelainan['17']) and $kode_tanda_kelainan['17'] == '1') ? 'checked' : ''); ?> />&nbsp;Perut bekas infiltrat (sigaret paper) yang tidak aktif lagi</td>
		</tr>
		<tr>
			<td height="35px;"><input type="checkbox" name="td_18" value="1" <?php echo ((isset($kode_tanda_kelainan['18']) and $kode_tanda_kelainan['18'] == '1') ? 'checked' : ''); ?> />&nbsp;Pembesaran Testis</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="td_19" value="1" <?php echo ((isset($kode_tanda_kelainan['19']) and $kode_tanda_kelainan['19'] == '1') ? 'checked' : ''); ?> />&nbsp;Logof talmus</td>
		</tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
		<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID'] and $irja_final == ''){ ?>
		<td colspan="8" align="right" ><input type="submit" value="simpan" class="myButton1" onclick="simpan();" />
		<?php } ?>
		</td>
        </tr>
    </table>
</form>