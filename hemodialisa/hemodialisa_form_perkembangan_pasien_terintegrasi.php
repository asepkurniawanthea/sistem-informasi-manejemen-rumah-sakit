<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irja_id = $_GET['idx'];	
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$pemberi_asuhan = '';
$hasil_asesmen = '';
$intruksi_ppa = '';
$verifikasi_dpjp = '';	

$new_line = htmlspecialchars('<br>');

if (isset($_GET['idrc']))
    include('hemodialisa/hemodialisa_del_perkembangan_pasien_terintegrasi.php');	

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_perkembangan_pasien_terintegrasi.php');			

if($jns_order == ''){
	$sql_perkembangan = 'SELECT t_irja_perkembangan.IRJA_PERKEMBANGAN_ID,
					DATE_FORMAT(t_irja_perkembangan.TANGGAL,"%d-%m-%Y %H:%i") AS TANGGAL,
					t_irja_perkembangan.PEMBERI_ASUHAN,m_pegawai.NAMA_PEGAWAI,
					t_irja_perkembangan.UNIT_ID,m_unit.NAMA_UNIT,
					t_irja_perkembangan.IRJA_ID,
					t_irja_perkembangan.HASIL_ASESMEN,
					t_irja_perkembangan.INTRUKSI_PPA,
					t_irja_perkembangan.VERIFIKASI_DPJP,
					m_pegawai.TIPE_PEGAWAI_ID
					FROM t_irja_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_unit
					ON (t_irja_perkembangan.UNIT_ID = m_unit.UNIT_ID)
					WHERE t_irja_perkembangan.NOMR = "' . $nomr . '"
					AND t_irja_perkembangan.IRJA_ID = "' . $irja_id . '"
					ORDER BY t_irja_perkembangan.TANGGAL';
}else{
	$sql_perkembangan = 'SELECT t_hemodialisa_perkembangan.HEMODIALISA_PERKEMBANGAN_ID AS IRJA_PERKEMBANGAN_ID,
					DATE_FORMAT(t_hemodialisa_perkembangan.TANGGAL,"%d-%m-%Y %H:%i") AS TANGGAL,
					t_hemodialisa_perkembangan.PEMBERI_ASUHAN,m_pegawai.NAMA_PEGAWAI,
					55 AS UNIT_ID,"Hemodialisa" NAMA_UNIT,
					t_hemodialisa_perkembangan.HEMODIALISA_ID AS IRJA_ID,
					t_hemodialisa_perkembangan.HASIL_ASESMEN,
					t_hemodialisa_perkembangan.INTRUKSI_PPA,
					t_hemodialisa_perkembangan.VERIFIKASI_DPJP,
					m_pegawai.TIPE_PEGAWAI_ID
					FROM t_hemodialisa_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_hemodialisa_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_hemodialisa_perkembangan.NOMR = "' . $nomr . '"
					AND t_hemodialisa_perkembangan.HEMODIALISA_ID = "' . $irja_id . '"
					ORDER BY t_hemodialisa_perkembangan.TANGGAL';
}					
$get_perkembangan = mysql_query($sql_perkembangan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>Tanggal</th>
	<!--<th>Unit</th>-->
	<th>Profesional/ Pemberi Asuhan</th>
	<th>Hasil Assesment/ IAR<br/>Penatalaksanaan Pasien (SOAP/ADIME)</th>
	<th>Intruksi PPA<br/>(Termasuk Pasca Bedah)</th>
	<th>Verifikasi DPJP</th>
	<th>Option</th>
</tr>
<?php while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){ ?>
	<tr>
		<td valign="top"><?php echo $dat_perkembangan['TANGGAL']; ?></td>
		<!--<td><?php echo $dat_perkembangan['NAMA_UNIT']; ?></td>-->
		<td valign="top"><?php echo $dat_perkembangan['NAMA_PEGAWAI']; ?></td>
		<td><?php $hasil_asesmenx = str_replace('|','"',$dat_perkembangan['HASIL_ASESMEN']);
				$hasil_asesmenx = str_replace($new_line,'<br>',$hasil_asesmenx);
				$hasil_asesmenx = preg_replace('/\r|\n/','<br>',trim($hasil_asesmenx));
				$hasil_asesmenx = json_decode($hasil_asesmenx,true);
				echo 'Subjective (S) : <br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $hasil_asesmenx['s'] . '<br><br>';
				echo 'Objective (O) : <br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $hasil_asesmenx['o'] . '<br><br>';
				echo 'Assesment (A) : <br>';
				$dg = 0;
				$hasil_asesmeny = '';
				while($dg <= 3){
					if($hasil_asesmenx['d' . $dg] != ''){
						$hasil_asesmeny .= '-' . $hasil_asesmenx['d' . $dg] . ',';	
					}	
				$dg++;
				}				
				
				if($hasil_asesmeny != ''){	
					$hasil_asesmeny = 'Diagnosa : ' . substr($hasil_asesmeny,0,strlen($hasil_asesmeny)-1);	
				}	
				
				$dg = 4;
				$hasil_asesmenz = '';
				while($dg <= 7){
					if($hasil_asesmenx['d' . $dg] != ''){
						$hasil_asesmenz .= '-' . $hasil_asesmenx['d' . $dg] . ',';	
					}	
				$dg++;
				}	
				
				if($hasil_asesmenz != ''){	
					$hasil_asesmeny .= '<br>Diagnosa Banding : ' . substr($hasil_asesmenz,0,strlen($hasil_asesmenz)-1);	
				}
				
				if($hasil_asesmenx['a'] != ''){
					$hasil_asesmeny .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;' . $hasil_asesmenx['a'];
				}	
				echo $hasil_asesmeny . '<br><br>';
				echo 'Plan (P) : <br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $hasil_asesmenx['p'];
		?></td>
		<td valign="top"><?php $intruksi_ppanya = str_replace($new_line,'<br>',$dat_perkembangan['INTRUKSI_PPA']); 
			$intruksi_ppanya = str_replace('<br><br>','<br>',$intruksi_ppanya);
			$hasil_asesmenx = preg_replace('/\r|\n/','<br>',trim($intruksi_ppanya));
			echo $intruksi_ppanya; ?></td>
		<td valign="top"><?php echo $dat_perkembangan['VERIFIKASI_DPJP']; ?></td>
		<td  valign="middle" align="center">
		<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
				and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
		<a href="<?php echo currentUrl(); ?>&vdrc=<?php echo $dat_perkembangan['IRJA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >ubah</a>
		<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_perkembangan['IRJA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >hapus</a>
		<?php } ?>
		<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
		<?php if(isPerawat($dat_perkembangan['TIPE_PEGAWAI_ID'])){ ?>
		<a href="<?php echo currentUrl(); ?>&vdrc=<?php echo $dat_perkembangan['IRJA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >ubah</a>
		<?php if($dat_perkembangan['VERIFIKASI_DPJP'] == ''){ ?>
		<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_perkembangan['IRJA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >hapus</a>
		<?php } } } ?>
		</td>
	</tr>
<?php } ?>
</table>
<br />
<?php 
$perkem_id = '';	
if(isset($_GET['vdrc'])){
	if($jns_order == ''){
		$qry_perk = 'SELECT pk.*,m_pegawai.TIPE_PEGAWAI_ID FROM t_irja_perkembangan pk
				INNER JOIN m_pegawai ON (pk.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
				WHERE pk.IRJA_PERKEMBANGAN_ID = "' . $_GET['vdrc'] . '"';
	}else{
		$qry_perk = 'SELECT pk.HEMODIALISA_PERKEMBANGAN_ID AS IRJA_PERKEMBANGAN_ID,pk.HEMODIALISA_ID AS IRJA_ID,
				pk.TANGGAL,pk.PEMBERI_ASUHAN,pk.HASIL_ASESMEN,pk.INTRUKSI_PPA,pk.VERIFIKASI_DPJP,
				m_pegawai.TIPE_PEGAWAI_ID,pk.UNIT_ID 
				FROM t_hemodialisa_perkembangan pk
				INNER JOIN m_pegawai ON (pk.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
				WHERE pk.HEMODIALISA_PERKEMBANGAN_ID = "' . $_GET['vdrc'] . '"';
	}
				
	$get_perk = mysql_query($qry_perk) or die(mysql_error());
	$dat_perk = mysql_fetch_assoc($get_perk);	
	$pemberi_asuhan = $dat_perk['PEMBERI_ASUHAN'];
	$hasil_asesmen = $dat_perk['HASIL_ASESMEN'];
	$hasil_asesmen = str_replace('|','"',$dat_perk['HASIL_ASESMEN']);
	$hasil_asesmen = preg_replace('/\r|\n/','\n',trim($hasil_asesmen));
	$hasil_asesmen = json_decode($hasil_asesmen,true);
	
	$hasil_asesmen_subjective = ((isset($hasil_asesmen['s'])) ? $hasil_asesmen['s'] : '');
	$hasil_asesmen_subjective = str_replace($new_line . $new_line,"\n",trim($hasil_asesmen_subjective));
	$hasil_asesmen_subjective = str_replace('<br>',"\n",trim($hasil_asesmen_subjective));
	$hasil_asesmen_subjective = str_replace($new_line,"\n",trim($hasil_asesmen_subjective));
	
	$hasil_asesmen_objective = ((isset($hasil_asesmen['o'])) ? $hasil_asesmen['o'] : '');
	$hasil_asesmen_objective = str_replace($new_line . $new_line,"\n",trim($hasil_asesmen_objective));
	$hasil_asesmen_objective = str_replace('<br>',"\n",trim($hasil_asesmen_objective));
	$hasil_asesmen_objective = str_replace($new_line,"\n",trim($hasil_asesmen_objective));
	
	$hasil_asesmen_asesmen = ((isset($hasil_asesmen['a'])) ? $hasil_asesmen['a'] : '');
	$hasil_asesmen_asesmen = str_replace($new_line . $new_line,"\n",trim($hasil_asesmen_asesmen));
	$hasil_asesmen_asesmen = str_replace('<br>',"\n",trim($hasil_asesmen_asesmen));
	$hasil_asesmen_asesmen = str_replace($new_line,"\n",trim($hasil_asesmen_asesmen));
	
	$hasil_asesmen_plan = ((isset($hasil_asesmen['p'])) ? $hasil_asesmen['p'] : '');
	$hasil_asesmen_plan = str_replace($new_line . $new_line,"\n",trim($hasil_asesmen_plan));
	$hasil_asesmen_plan = str_replace('<br>',"\n",trim($hasil_asesmen_plan));
	$hasil_asesmen_plan = str_replace($new_line,"\n",trim($hasil_asesmen_plan));
	
	$intruksi_ppa = $dat_perk['INTRUKSI_PPA'];
	$intruksi_ppa = str_replace($new_line . $new_line,"\n",trim($intruksi_ppa));
	$intruksi_ppa = str_replace($new_line,"\n",trim($intruksi_ppa));
	
	$verifikasi_dpjp = $dat_perk['VERIFIKASI_DPJP'];
	$irja_id = $dat_perk['IRJA_ID'];
	$unit_id = $dat_perk['UNIT_ID'];
	$tipe_pegawai_id = $dat_perk['TIPE_PEGAWAI_ID'];
	$perkem_id = $dat_perk['IRJA_PERKEMBANGAN_ID'];
}
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa_0").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_1").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_2").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_3").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_4").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_5").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_6").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
		jQuery("#diagnosa_7").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 675});
    });
</script>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="perkembangan_id" id="perkembangan_id" value="<?php echo $perkem_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="unit_id" id="unit_id" value="<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>" />
	<table border="0" width="100%">
	<!--<tr>
    <td>&nbsp;</td>
    <td>Tanggal & Pukul</td>
    <td><input type="text" name="tanggal" id="tgl_1" size="15" class="text_dt" value="<?php echo $tanggal; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/>
	  <select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select></td>
    <td>&nbsp;</td>
	</tr>-->
	<!--<tr>
    <td>&nbsp;</td>
    <td width="180">Profesional Pemberi Asuhan</td>
    <td width="200"><select name="pemberi_asuhan" id="pemberi_asuhan" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaRanap($_SESSION['SES_SIMRS_PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td valign="top" rowspan="12">Hasil Assesment/ IAR<br/>Penatalaksanaan Pasien</td>
    <td valign="top">Subjective (S)</td>
    <td colspan="2"><textarea name="hasil_asesmen_subjective" id="hasil_asesmen_subjective" rows="5" class="text_dt2" ><?php echo $hasil_asesmen_subjective; ?></textarea></td>
  </tr>
  <tr>
    <td valign="top">Objective (O)</td>
    <td colspan="2"><textarea name="hasil_asesmen_objective" id="hasil_asesmen_objective" rows="5" class="text_dt2" ><?php echo $hasil_asesmen_objective; ?></textarea></td>
  </tr>
  <tr>
    <td valign="top">Assesement (A)</td>
    <td colspan="2"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($hasil_asesmen['d0'])) ? $hasil_asesmen['d0'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa 1" ></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($hasil_asesmen['d1'])) ? $hasil_asesmen['d1'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa 2"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($hasil_asesmen['d2'])) ? $hasil_asesmen['d2'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa 3"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($hasil_asesmen['d3'])) ? $hasil_asesmen['d3'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa 4"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($hasil_asesmen['d4'])) ? $hasil_asesmen['d4'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa Banding"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($hasil_asesmen['d5'])) ? $hasil_asesmen['d5'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa Banding"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($hasil_asesmen['d6'])) ? $hasil_asesmen['d6'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa Banding" ></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($hasil_asesmen['d7'])) ? $hasil_asesmen['d7'] : ''); ?>" class="text_dt" style="width:670px;" placeholder="Diagnosa Banding" ></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2"><textarea name="hasil_asesmen" id="hasil_asesmen" rows="5" class="text_dt2" ><?php echo $hasil_asesmen_asesmen; ?></textarea></td>
  </tr>
  
  <tr>
    <td valign="top">Plan (P)</td>
    <td colspan="2"><textarea name="hasil_asesmen_plan" id="hasil_asesmen_plan" rows="5" class="text_dt2" ><?php echo $hasil_asesmen_plan; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">Intruksi PPA<br/>(Termasuk Pasca Bedah)</td>
    <td colspan="2"><textarea name="intruksi_ppa" id="intruksi_ppa" rows="5" class="text_dt2" style="height:300px;" ><?php echo $intruksi_ppa; ?></textarea></td>
  </tr>
  <?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
  <tr>
    <td>&nbsp;</td>
    <td>Verifikasi DPJP</td>
    <td><?php $checked = ''; 
		$nama_dokter = '';
		$tgl_verif = '';
		if($verifikasi_dpjp != ''){
			$checked = 'checked';
			$arr_verifikasi_dpjp = explode('|',$verifikasi_dpjp);
			$nama_dokter = $arr_verifikasi_dpjp[0];
			$tgl_verif = $arr_verifikasi_dpjp[1];
		} ?><input type="checkbox" name="verifikasi_dpjp" value="1" <?php echo $checked; ?> />&nbsp;Ya
		<?php echo $nama_dokter . ' ' . $tgl_verif; ?></td>
	<td>&nbsp;</td>
  </tr>
<?php } ?>
<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
  <tr>
    <td>&nbsp;</td>
    <td>Verifikasi DPJP</td>
    <td>:&nbsp;<?php $nama_dokter = '';
		$tgl_verif = '';
		if($verifikasi_dpjp != ''){
			$arr_verifikasi_dpjp = explode('|',$verifikasi_dpjp);
			$nama_dokter = $arr_verifikasi_dpjp[0];
			$tgl_verif = $arr_verifikasi_dpjp[1];
		} echo $nama_dokter . ' ' . $tgl_verif; ?></td>
	<td>&nbsp;</td>
  </tr>
<?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($hemodialisa_final == ''){
				if((isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
					and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID'])){ ?>
	<input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_perkembangan();" />
	<input type="hidden" name="pemberi_asuhan" id="pemberi_asuhan" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
	 <?php if(!empty($irja_id)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irja_id . '"
						AND JENIS_DOKUMEN_ID = "7"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
	<?php } } if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $verifikasi_dpjp == ''){ ?>
	<input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_perkembangan();" />
	<input type="hidden" name="pemberi_asuhan" id="pemberi_asuhan" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
	 <?php if(!empty($irja_id)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "' . $jns_perawatan . '"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idxord . '"
						AND JENIS_DOKUMEN_ID = "37"
						' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
	<?php } } } ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  </table>
</form>
<script>
function simpan_perkembangan(){
	_haschange = false;
	
	/*if(($('#hasil_asesmen').val() == '') && ($('#intruksi_ppa').val() == '') && ($('#verifikasi_dpjp').val() == '')){
			alert('Catatan Perkembangan Pasien Belum Diisi.');
	}else{*/
		$('#formedit').submit();
	//}	
}	
</script>