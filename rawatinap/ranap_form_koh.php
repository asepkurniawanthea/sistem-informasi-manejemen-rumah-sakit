<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irna_id'])){
	
	$kuping_telinga_kanan = array('p_ktk'=>((isset($_POST['p_ktk'])) ? $_POST['p_ktk'] : ''),
						'p_ktk_bi'=>replace_quote($_POST['p_ktk_bi']),
						'p_ktk_mi'=>replace_quote($_POST['p_ktk_mi']),
						'p_ktk_s'=>replace_quote($_POST['p_ktk_s']),
						'p_ktk_f'=>replace_quote($_POST['p_ktk_f']),
						'p_ktk_g'=>replace_quote($_POST['p_ktk_g']));
	$kuping_telinga_kanan = json_encode($kuping_telinga_kanan);
	$kuping_telinga_kanan = str_replace('"','|',$kuping_telinga_kanan);
	
	$kuping_telinga_kiri = array('p_ktr'=>((isset($_POST['p_ktr'])) ? $_POST['p_ktr'] : ''),
						'p_ktr_bi'=>replace_quote($_POST['p_ktr_bi']),
						'p_ktr_mi'=>replace_quote($_POST['p_ktr_mi']),
						'p_ktr_s'=>replace_quote($_POST['p_ktr_s']),
						'p_ktr_f'=>replace_quote($_POST['p_ktr_f']),
						'p_ktr_g'=>replace_quote($_POST['p_ktr_g']));
	$kuping_telinga_kiri = json_encode($kuping_telinga_kiri);
	$kuping_telinga_kiri = str_replace('"','|',$kuping_telinga_kiri);
	
	$dahi = array('p_dh'=>((isset($_POST['p_dh'])) ? $_POST['p_dh'] : ''),
						'p_dh_bi'=>replace_quote($_POST['p_dh_bi']),
						'p_dh_mi'=>replace_quote($_POST['p_dh_mi']),
						'p_dh_s'=>replace_quote($_POST['p_dh_s']),
						'p_dh_f'=>replace_quote($_POST['p_dh_f']),
						'p_dh_g'=>replace_quote($_POST['p_dh_g']));
	$dahi = json_encode($dahi);
	$dahi = str_replace('"','|',$dahi);
	
	$dagu = array('p_dh'=>((isset($_POST['p_dh'])) ? $_POST['p_dh'] : ''),
						'p_dh_bi'=>replace_quote($_POST['p_dh_bi']),
						'p_dh_mi'=>replace_quote($_POST['p_dh_mi']),
						'p_dh_s'=>replace_quote($_POST['p_dh_s']),
						'p_dh_f'=>replace_quote($_POST['p_dh_f']),
						'p_dh_g'=>replace_quote($_POST['p_dh_g']));
	$dagu = json_encode($dagu);
	$dagu = str_replace('"','|',$dagu);
	
	$dagu = array('p_dg'=>((isset($_POST['p_dg'])) ? $_POST['p_dg'] : ''),
						'p_dg_bi'=>replace_quote($_POST['p_dg_bi']),
						'p_dg_mi'=>replace_quote($_POST['p_dg_mi']),
						'p_dg_s'=>replace_quote($_POST['p_dg_s']),
						'p_dg_f'=>replace_quote($_POST['p_dg_f']),
						'p_dg_g'=>replace_quote($_POST['p_dg_g']));
	$dagu = json_encode($dagu);
	$dagu = str_replace('"','|',$dagu);
	
	$jari_tengah_tangan_kanan = array('p_jtk'=>((isset($_POST['p_jtk'])) ? $_POST['p_jtk'] : ''),
						'p_jtk_bi'=>replace_quote($_POST['p_jtk_bi']),
						'p_jtk_mi'=>replace_quote($_POST['p_jtk_mi']),
						'p_jtk_s'=>replace_quote($_POST['p_jtk_s']),
						'p_jtk_f'=>replace_quote($_POST['p_jtk_f']),
						'p_jtk_g'=>replace_quote($_POST['p_jtk_g']));
	$jari_tengah_tangan_kanan = json_encode($jari_tengah_tangan_kanan);
	$jari_tengah_tangan_kanan = str_replace('"','|',$jari_tengah_tangan_kanan);
	
	$jari_tengah_tangan_kiri = array('p_jtr'=>((isset($_POST['p_jtr'])) ? $_POST['p_jtr'] : ''),
						'p_jtr_bi'=>replace_quote($_POST['p_jtr_bi']),
						'p_jtr_mi'=>replace_quote($_POST['p_jtr_mi']),
						'p_jtr_s'=>replace_quote($_POST['p_jtr_s']),
						'p_jtr_f'=>replace_quote($_POST['p_jtr_f']),
						'p_jtr_g'=>replace_quote($_POST['p_jtr_g']));
	$jari_tengah_tangan_kiri = json_encode($jari_tengah_tangan_kiri);
	$jari_tengah_tangan_kiri = str_replace('"','|',$jari_tengah_tangan_kiri);
	
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irna_pemeriksaan_koh (IRNA_ID,KUPING_TELINGA_KANAN,KUPING_TELINGA_KIRI,
				DAHI,DAGU,JARI_TENGAH_TANGAN_KANAN,
				JARI_TENGAH_TANGAN_KIRI,TGL_ASSESMENT,REGISTER,
				PEMERIKSAAN_LAIN,PEGAWAI_ID) 
				VALUES ("' . $_POST['irna_id'] . '","' . $kuping_telinga_kanan . '","' . $kuping_telinga_kiri . '",
				"' . $dahi . '","' . $dagu . '","' . $jari_tengah_tangan_kanan . '","' . $jari_tengah_tangan_kiri . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['pemeriksaan_lain']) . '",
				"' . $_POST['pegawai_id'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_pemeriksaan_koh 
				SET KUPING_TELINGA_KANAN = "' . $kuping_telinga_kanan . '",
				KUPING_TELINGA_KIRI = "' . $kuping_telinga_kiri . '",
				DAHI = "' . $dahi . '",
				DAGU = "' . $dagu . '",
				JARI_TENGAH_TANGAN_KANAN = "' . $jari_tengah_tangan_kanan . '",
				JARI_TENGAH_TANGAN_KIRI = "' . $jari_tengah_tangan_kiri . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				PEMERIKSAAN_LAIN = "' . replace_quote($_POST['pemeriksaan_lain']) . '",
				PEGAWAI_ID = "' . $_POST['pegawai_id'] . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Pemeriksaan BTH/ KOH Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRNA_ID,KUPING_TELINGA_KANAN,KUPING_TELINGA_KIRI,DAHI,DAGU,JARI_TENGAH_TANGAN_KANAN,
			JARI_TENGAH_TANGAN_KIRI,PEMERIKSAAN_LAIN
			FROM t_irna_pemeriksaan_koh
			WHERE IRNA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRNA_ID'];

$kuping_telinga_kanan = str_replace('|','"',$dat_pasien['KUPING_TELINGA_KANAN']);
$kuping_telinga_kanan = preg_replace('/\r|\n/','\n',trim($kuping_telinga_kanan));
$kuping_telinga_kanan = json_decode($kuping_telinga_kanan,true);

$p_ktk = ((isset($kuping_telinga_kanan['p_ktk']) ? $kuping_telinga_kanan['p_ktk'] : ''));
$p_ktk_bi = ((isset($kuping_telinga_kanan['p_ktk_bi']) ? $kuping_telinga_kanan['p_ktk_bi'] : ''));
$p_ktk_mi = ((isset($kuping_telinga_kanan['p_ktk_mi']) ? $kuping_telinga_kanan['p_ktk_mi'] : ''));
$p_ktk_s = ((isset($kuping_telinga_kanan['p_ktk_s']) ? $kuping_telinga_kanan['p_ktk_s'] : ''));
$p_ktk_f = ((isset($kuping_telinga_kanan['p_ktk_f']) ? $kuping_telinga_kanan['p_ktk_f'] : ''));
$p_ktk_g = ((isset($kuping_telinga_kanan['p_ktk_g']) ? $kuping_telinga_kanan['p_ktk_g'] : ''));

$kuping_telinga_kiri = str_replace('|','"',$dat_pasien['KUPING_TELINGA_KIRI']);
$kuping_telinga_kiri = preg_replace('/\r|\n/','\n',trim($kuping_telinga_kiri));
$kuping_telinga_kiri = json_decode($kuping_telinga_kiri,true);

$p_ktr = ((isset($kuping_telinga_kiri['p_ktr']) ? $kuping_telinga_kiri['p_ktr'] : ''));
$p_ktr_bi = ((isset($kuping_telinga_kiri['p_ktr_bi']) ? $kuping_telinga_kiri['p_ktr_bi'] : ''));
$p_ktr_mi = ((isset($kuping_telinga_kiri['p_ktr_mi']) ? $kuping_telinga_kiri['p_ktr_mi'] : ''));
$p_ktr_s = ((isset($kuping_telinga_kiri['p_ktr_s']) ? $kuping_telinga_kiri['p_ktr_s'] : ''));
$p_ktr_f = ((isset($kuping_telinga_kiri['p_ktr_f']) ? $kuping_telinga_kiri['p_ktr_f'] : ''));
$p_ktr_g = ((isset($kuping_telinga_kiri['p_ktr_g']) ? $kuping_telinga_kiri['p_ktr_g'] : ''));

$dahi = str_replace('|','"',$dat_pasien['DAHI']);
$dahi = preg_replace('/\r|\n/','\n',trim($dahi));
$dahi = json_decode($dahi,true);

$p_dh = ((isset($dahi['p_dh']) ? $dahi['p_dh'] : ''));
$p_dh_bi = ((isset($dahi['p_dh_bi']) ? $dahi['p_dh_bi'] : ''));
$p_dh_mi = ((isset($dahi['p_dh_mi']) ? $dahi['p_dh_mi'] : ''));
$p_dh_s = ((isset($dahi['p_dh_s']) ? $dahi['p_dh_s'] : ''));
$p_dh_f = ((isset($dahi['p_dh_f']) ? $dahi['p_dh_f'] : ''));
$p_dh_g = ((isset($dahi['p_dh_g']) ? $dahi['p_dh_g'] : ''));

$dagu = str_replace('|','"',$dat_pasien['DAGU']);
$dagu = preg_replace('/\r|\n/','\n',trim($dagu));
$dagu = json_decode($dagu,true);

$p_dg = ((isset($dagu['p_dg']) ? $dagu['p_dg'] : ''));
$p_dg_bi = ((isset($dagu['p_dg_bi']) ? $dagu['p_dg_bi'] : ''));
$p_dg_mi = ((isset($dagu['p_dg_mi']) ? $dagu['p_dg_mi'] : ''));
$p_dg_s = ((isset($dagu['p_dg_s']) ? $dagu['p_dg_s'] : ''));
$p_dg_f = ((isset($dagu['p_dg_f']) ? $dagu['p_dg_f'] : ''));
$p_dg_g = ((isset($dagu['p_dg_g']) ? $dagu['p_dg_g'] : ''));

$jari_tengah_tangan_kanan = str_replace('|','"',$dat_pasien['JARI_TENGAH_TANGAN_KANAN']);
$jari_tengah_tangan_kanan = preg_replace('/\r|\n/','\n',trim($jari_tengah_tangan_kanan));
$jari_tengah_tangan_kanan = json_decode($jari_tengah_tangan_kanan,true);

$p_jtk = ((isset($jari_tengah_tangan_kanan['p_jtk']) ? $jari_tengah_tangan_kanan['p_jtk'] : ''));
$p_jtk_bi = ((isset($jari_tengah_tangan_kanan['p_jtk_bi']) ? $jari_tengah_tangan_kanan['p_jtk_bi'] : ''));
$p_jtk_mi = ((isset($jari_tengah_tangan_kanan['p_jtk_mi']) ? $jari_tengah_tangan_kanan['p_jtk_mi'] : ''));
$p_jtk_s = ((isset($jari_tengah_tangan_kanan['p_jtk_s']) ? $jari_tengah_tangan_kanan['p_jtk_s'] : ''));
$p_jtk_f = ((isset($jari_tengah_tangan_kanan['p_jtk_f']) ? $jari_tengah_tangan_kanan['p_jtk_f'] : ''));
$p_jtk_g = ((isset($jari_tengah_tangan_kanan['p_jtk_g']) ? $jari_tengah_tangan_kanan['p_jtk_g'] : ''));

$jari_tengah_tangan_kiri = str_replace('|','"',$dat_pasien['JARI_TENGAH_TANGAN_KIRI']);
$jari_tengah_tangan_kiri = preg_replace('/\r|\n/','\n',trim($jari_tengah_tangan_kiri));
$jari_tengah_tangan_kiri = json_decode($jari_tengah_tangan_kiri,true);

$p_jtr = ((isset($jari_tengah_tangan_kiri['p_jtr']) ? $jari_tengah_tangan_kiri['p_jtr'] : ''));
$p_jtr_bi = ((isset($jari_tengah_tangan_kiri['p_jtr_bi']) ? $jari_tengah_tangan_kiri['p_jtr_bi'] : ''));
$p_jtr_mi = ((isset($jari_tengah_tangan_kiri['p_jtr_mi']) ? $jari_tengah_tangan_kiri['p_jtr_mi'] : ''));
$p_jtr_s = ((isset($jari_tengah_tangan_kiri['p_jtr_s']) ? $jari_tengah_tangan_kiri['p_jtr_s'] : ''));
$p_jtr_f = ((isset($jari_tengah_tangan_kiri['p_jtr_f']) ? $jari_tengah_tangan_kiri['p_jtr_f'] : ''));
$p_jtr_g = ((isset($jari_tengah_tangan_kiri['p_jtr_g']) ? $jari_tengah_tangan_kiri['p_jtr_g'] : ''));

$pemeriksaan_lain = $dat_pasien['PEMERIKSAAN_LAIN'];
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<table border="0" align="center" style="position:static;" width="95%">
        <tr>
			<td colspan="2">Pemeriksaan</td>
			<td align="center">BI</td>
			<td align="center">MI</td>
			<td align="center">S</td>
			<td align="center">F</td>
			<td align="center">G</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="p_ktk" value="1" <?php if($p_ktk == '1') echo 'checked'; ?> /></td>
			<td>Kuping Telinga Kanan</td>
			<td><input type="text" name="p_ktk_bi" value="<?php echo $p_ktk_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktk_mi" value="<?php echo $p_ktk_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktk_s" value="<?php echo $p_ktk_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktk_f" value="<?php echo $p_ktk_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktk_g" value="<?php echo $p_ktk_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td><input type="checkbox" name="p_ktr" value="1" <?php if($p_ktr == '1') echo 'checked'; ?> /></td>
			<td>Kuping Telinga Kiri</td>
			<td><input type="text" name="p_ktr_bi" value="<?php echo $p_ktr_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktr_mi" value="<?php echo $p_ktr_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktr_s" value="<?php echo $p_ktr_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktr_f" value="<?php echo $p_ktr_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_ktr_g" value="<?php echo $p_ktr_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="p_dh" value="<?php echo $p_dh; ?>" class="text_dt" style="width:180px;" /></td>
			<td><input type="text" name="p_dh_bi" value="<?php echo $p_dh_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dh_mi" value="<?php echo $p_dh_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dh_s" value="<?php echo $p_dh_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dh_f" value="<?php echo $p_dh_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dh_g" value="<?php echo $p_dh_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="p_dg" value="<?php echo $p_dg; ?>" class="text_dt" style="width:180px;" /></td>
			<td><input type="text" name="p_dg_bi" value="<?php echo $p_dg_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dg_mi" value="<?php echo $p_dg_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dg_s" value="<?php echo $p_dg_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dg_f" value="<?php echo $p_dg_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_dg_g" value="<?php echo $p_dg_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="p_jtk" value="<?php echo $p_jtk; ?>" class="text_dt" style="width:180px;" /></td>
			<td><input type="text" name="p_jtk_bi" value="<?php echo $p_jtk_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtk_mi" value="<?php echo $p_jtk_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtk_s" value="<?php echo $p_jtk_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtk_f" value="<?php echo $p_jtk_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtk_g" value="<?php echo $p_jtk_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="p_jtr" value="<?php echo $p_jtr; ?>" class="text_dt" style="width:180px;" /></td>
			<td><input type="text" name="p_jtr_bi" value="<?php echo $p_jtr_bi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtr_mi" value="<?php echo $p_jtr_mi ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtr_s" value="<?php echo $p_jtr_s ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtr_f" value="<?php echo $p_jtr_f ?>" class="text_dt" /></td>
			<td><input type="text" name="p_jtr_g" value="<?php echo $p_jtr_g ?>" class="text_dt" /></td>
		</tr>
		<tr>
			<td colspan="2">Catatan</td>
			<td colspan="5"><textarea name="pemeriksaan_lain" class="text_dt2" ><?php echo $pemeriksaan_lain; ?></textarea></td>
		</tr>
        <tr>
            <td colspan="8">*<i>Mohon item pemeriksaan laboratoriumnya diisi di Perm. Laboratorium</i></td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($irna_final == ''){ ?>
			<?php if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }else{ ?>
			<input type="hidden" name="pegawai_id" id="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
			<?php } ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "63"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
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