<?php if(isset($_GET['idx']) and isset($_GET['trx']) and isset($_GET['tahun']) and isset($_GET['bulan'])){
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

$appidx = '1';

$idx = $_GET['idx'];
$trx = $_GET['trx'];
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

if(isset($_POST['simpan'])){
	$get_id = mysql_query('SELECT INDEX_KINERJA_ID FROM t_remun_index_kinerja
					WHERE PEGAWAI_IDX = "' . $_POST['idx'] . '"
					AND TAHUN = "' . $_POST['tahun'] . '"
					AND BULAN = "' . $_POST['bulan'] . '"') or die(mysql_error());
	if(mysql_num_rows($get_id) > 0){
		$dat_id = mysql_fetch_assoc($get_id);
		mysql_query('DELETE FROM t_remun_index_kinerja WHERE INDEX_KINERJA_ID = "' . $dat_id['INDEX_KINERJA_ID'] . '"') or die(mysql_error());
		mysql_query('DELETE FROM t_remun_index_kinerja_detail WHERE INDEX_KINERJA_ID = "' . $dat_id['INDEX_KINERJA_ID'] . '"') or die(mysql_error());
	}

	mysql_query('INSERT INTO t_remun_index_kinerja(PEGAWAI_IDX,PEGAWAI_IDX_PENILAI,TAHUN,BULAN,TOTAL_CAPAIAN,REGISTER)
				VALUES("' . $_POST['idx'] . '","' . $_POST['penilai_id']  . '","' . $_POST['tahun']  . '",
				"' . $_POST['bulan']  . '","' . $_POST['total_capaian']  . '","' . $user_name  . '")') or die(mysql_error());
	$get_id = mysql_query('SELECT INDEX_KINERJA_ID FROM t_remun_index_kinerja
					WHERE PEGAWAI_IDX = "' . $_POST['idx'] . '"
					AND TAHUN = "' . $_POST['tahun'] . '"
					AND BULAN = "' . $_POST['bulan'] . '"') or die(mysql_error());			
	$dat_id = mysql_fetch_assoc($get_id);	
	$trx = $dat_id['INDEX_KINERJA_ID'];	
	
	$cnr = $_POST['cnr'];
	$t = 1;
	while($t <= $cnr){
		mysql_query('INSERT INTO t_remun_index_kinerja_detail(INDEX_KINERJA_ID,
				KEGIATAN_KINERJA_ID,OB,CAPAIAN_PERSEN)
				VALUES("' . $trx . '","' . $_POST['kegiatan_id_' . $t] . '",
				"' . $_POST['ob_' . $t] . '","' . $_POST['capaian_persen_' . $t] . '")') or die(mysql_error());
	$t++;
	}
	?>
	<script language="JavaScript" >
	alert('Simpan Data Index Kinerja Individu Berhasil.');
	window.location = "index.php?link=ca69ac058982b2f75d36a7b3c8c48dd0&idx=<?php echo $idx; ?>&trx=<?php echo $trx; ?>&tahun=<?php echo $tahun; ?>&bulan=<?php echo $bulan; ?>";
	</script>
<?php
}

$qry_pegawai = 'SELECT r_pegawai.PEGAWAI_IDX,r_pegawai.PEGAWAI_ID,r_pegawai.APP_ID,
			r_pegawai.UNIT_KERJA_ID,r_pegawai.JABATAN_ID,r_pegawai.KEPALA_UNIT_KERJA,
			r_pegawai.NIP,r_pegawai.PENDIDIKAN,r_pegawai.GOLONGAN,r_jabatan.JABATAN,
			r_jabatan.JABATAN_DESC,r_jabatan.NILAI_JABATAN_ID,r_remun_nilai_jabatan.CORP_GRADE,
			r_remun_nilai_jabatan.NILAI_JAB_MIN,r_remun_nilai_jabatan.NILAI_JAB_MAX,r_remun_nilai_jabatan.NILAI_JAB,
			r_remun_nilai_jabatan.JND,r_unit_kerja.UNIT_KERJA,pgw.NAMA_PEGAWAI
			FROM db_sdm.r_pegawai r_pegawai
			INNER JOIN db_sdm.r_jabatan r_jabatan 
			ON (r_pegawai.JABATAN_ID = r_jabatan.JABATAN_ID)
			INNER JOIN db_sdm.r_remun_nilai_jabatan r_remun_nilai_jabatan 
			ON (r_jabatan.NILAI_JABATAN_ID = r_remun_nilai_jabatan.NILAI_JABATAN_ID)
			INNER JOIN db_sdm.r_unit_kerja r_unit_kerja 
			ON (r_pegawai.UNIT_KERJA_ID = r_unit_kerja.UNIT_KERJA_ID)
			INNER JOIN (
					SELECT "1" AS APP,db_simrs.m_pegawai.PEGAWAI_ID,db_simrs.m_pegawai.NAMA_PEGAWAI
					FROM db_simrs.m_pegawai
					UNION ALL
					SELECT "2" AS APP,db_inventorirs.m_pegawai.PEGAWAI_ID,db_inventorirs.m_pegawai.NAMA_PEGAWAI
					FROM db_inventorirs.m_pegawai
			) pgw
			ON (r_pegawai.PEGAWAI_ID = pgw.PEGAWAI_ID AND r_pegawai.APP_ID = pgw.APP)
			WHERE r_pegawai.PEGAWAI_IDX = "' . $idx . '"';
$get_pegawai = mysql_query($qry_pegawai) or die(mysql_error());
$dat_pegawai = mysql_fetch_assoc($get_pegawai);
$pegawai_id = $dat_pegawai['PEGAWAI_ID'];
$app_id = $dat_pegawai['APP_ID'];
$nama_pegawai = $dat_pegawai['NAMA_PEGAWAI'];
$unit_kerja_id = $dat_pegawai['UNIT_KERJA_ID'];
$jabatan_id = $dat_pegawai['JABATAN_ID'];
$kepala_unit_kerja = $dat_pegawai['KEPALA_UNIT_KERJA'];
$nip = $dat_pegawai['NIP'];
$pendidikan = $dat_pegawai['PENDIDIKAN'];
$golongan = $dat_pegawai['GOLONGAN'];
$jabatan = $dat_pegawai['JABATAN'];
$jabatan_desc = $dat_pegawai['JABATAN_DESC'];
$nilai_jabatan_id = $dat_pegawai['NILAI_JABATAN_ID'];
$corp_grade = $dat_pegawai['CORP_GRADE'];
$nilai_jab_min = $dat_pegawai['NILAI_JAB_MIN'];
$nilai_jab_max = $dat_pegawai['NILAI_JAB_MAX'];
$nilai_jab = $dat_pegawai['NILAI_JAB'];
$jnd = $dat_pegawai['JND'];
$unit_kerja = $dat_pegawai['UNIT_KERJA'];

if($kepala_unit_kerja != '1'){
	$qry_penilai = 'SELECT r_pegawai.PEGAWAI_IDX,r_pegawai.PEGAWAI_ID,r_pegawai.APP_ID,
			r_pegawai.UNIT_KERJA_ID,r_pegawai.JABATAN_ID,r_pegawai.KEPALA_UNIT_KERJA,
			r_pegawai.NIP,r_pegawai.PENDIDIKAN,r_pegawai.GOLONGAN,r_jabatan.JABATAN,
			r_jabatan.JABATAN_DESC,pgw.NAMA_PEGAWAI,
			(SELECT COUNT(prs.PEGAWAI_IDX) FROM r_pegawai prs
				WHERE prs.UNIT_KERJA_ID = "' . $unit_kerja_id . '"
				
			) AS JUMLAH_PERSONIL
			FROM db_sdm.r_pegawai r_pegawai
			INNER JOIN db_sdm.r_jabatan r_jabatan 
			ON (r_pegawai.JABATAN_ID = r_jabatan.JABATAN_ID)
			INNER JOIN (
					SELECT "1" AS APP,db_simrs.m_pegawai.PEGAWAI_ID,db_simrs.m_pegawai.NAMA_PEGAWAI
					FROM db_simrs.m_pegawai
					UNION ALL
					SELECT "2" AS APP,db_inventorirs.m_pegawai.PEGAWAI_ID,db_inventorirs.m_pegawai.NAMA_PEGAWAI
					FROM db_inventorirs.m_pegawai
			) pgw
			ON (r_pegawai.PEGAWAI_ID = pgw.PEGAWAI_ID AND r_pegawai.APP_ID = pgw.APP)
			WHERE r_pegawai.UNIT_KERJA_ID = "' . $unit_kerja_id . '"
			AND r_pegawai.KEPALA_UNIT_KERJA = "1"';
	$get_penilai = mysql_query($qry_penilai) or die(mysql_error());
	$dat_penilai = mysql_fetch_assoc($get_penilai);
	$penilai_id = $dat_penilai['PEGAWAI_IDX'];
	$nama_penilai = $dat_penilai['NAMA_PEGAWAI'];
	$nip_pnl = $dat_penilai['NIP'];
	$pendidikan_pnl = $dat_penilai['PENDIDIKAN'];
	$golongan_pnl = $dat_penilai['GOLONGAN'];
	$jabatan_pnl = $dat_penilai['JABATAN'];
	$jabatan_desc_pnl = $dat_penilai['JABATAN_DESC'];
	$jumlah_personil = $dat_penilai['JUMLAH_PERSONIL'];
}else{
	$penilai_id = '';
	$nama_penilai = '';
	$nip_pnl = '';
	$pendidikan_pnl = '';
	$golongan_pnl = '';
	$jabatan_pnl = '';
	$jabatan_desc_pnl = '';
	$jumlah_personil = '';
}

$arr_bulan['01'] = 'Januari';
$arr_bulan['02'] = 'Februari';
$arr_bulan['03'] = 'Maret';
$arr_bulan['04'] = 'April';
$arr_bulan['05'] = 'Mei';
$arr_bulan['06'] = 'Juni';
$arr_bulan['07'] = 'Juli';
$arr_bulan['08'] = 'Agustus';
$arr_bulan['09'] = 'September';
$arr_bulan['10'] = 'Oktober';
$arr_bulan['11'] = 'Nopember';
$arr_bulan['12'] = 'Desember';

$qry_remun = 'SELECT r_remun_kegiatan_kinerja.KEGIATAN_KINERJA_ID,r_remun_kegiatan_kinerja.KRITERIA_KINERJA_ID,
				r_remun_kegiatan_kinerja.KEGIATAN,r_remun_kegiatan_kinerja.TARGET,r_remun_kegiatan_kinerja.UNIT_KERJA_ID,
				r_remun_kegiatan_kinerja.TARGET_TAHUN,r_remun_kegiatan_kinerja.TARGET_BULAN,r_remun_kegiatan_kinerja.SATUAN,
				r_remun_kriteria_kinerja.KRITERIA,rmn.INDEX_KINERJA_DETAIL_ID,rmn.CAPAIAN_PERSEN,
				rmn.INDEX_KINERJA_ID,rmn.TAHUN,rmn.BULAN,rmn.OB,rmn.TOTAL_CAPAIAN
				FROM r_remun_kegiatan_kinerja
				INNER JOIN r_remun_kriteria_kinerja 
				ON (r_remun_kegiatan_kinerja.KRITERIA_KINERJA_ID = r_remun_kriteria_kinerja.KRITERIA_KINERJA_ID)
				LEFT JOIN ( 
					SELECT t_remun_index_kinerja_detail.INDEX_KINERJA_DETAIL_ID,
					t_remun_index_kinerja_detail.CAPAIAN_PERSEN,t_remun_index_kinerja.INDEX_KINERJA_ID,
					t_remun_index_kinerja.TAHUN,t_remun_index_kinerja.BULAN,t_remun_index_kinerja_detail.KEGIATAN_KINERJA_ID,
					t_remun_index_kinerja_detail.OB,t_remun_index_kinerja.TOTAL_CAPAIAN
					FROM t_remun_index_kinerja_detail 
					INNER JOIN t_remun_index_kinerja 
					ON (t_remun_index_kinerja_detail.INDEX_KINERJA_ID = t_remun_index_kinerja.INDEX_KINERJA_ID)
					WHERE t_remun_index_kinerja.PEGAWAI_IDX = "' . $idx . '"
					AND t_remun_index_kinerja.TAHUN = "' . $tahun . '"
					AND t_remun_index_kinerja.BULAN = "' . $bulan . '"
				) rmn
				ON (r_remun_kegiatan_kinerja.KEGIATAN_KINERJA_ID = rmn.KEGIATAN_KINERJA_ID)
				WHERE r_remun_kegiatan_kinerja.UNIT_KERJA_ID = "' . $unit_kerja_id . '"
				ORDER BY r_remun_kriteria_kinerja.KRITERIA_KINERJA_ID,
				r_remun_kegiatan_kinerja.KEGIATAN_KINERJA_ID';	
$get_remun = mysql_query($qry_remun) or die(mysql_error());
$rspan_kriteria = array();				
$sum_target = array();				
$kriteria_id = '';
$kriteria_crow = 0;
$total_capaian = 0;
$total_capaian_print = 0;
$total_row = 0;
$capaian_kinerja = 0;
while($dat_remun = mysql_fetch_array($get_remun)){
	if($dat_remun['KRITERIA_KINERJA_ID'] != $kriteria_id){
		$kriteria_id = $dat_remun['KRITERIA_KINERJA_ID'];
		$rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] = 1;
		$sum_target[$dat_remun['KRITERIA_KINERJA_ID']] = $dat_remun['TARGET'];
		$kriteria_crow = 1;
	}else{
		$kriteria_crow++;
		$rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] = $kriteria_crow;
		$sum_target[$dat_remun['KRITERIA_KINERJA_ID']] += $dat_remun['TARGET'];
	}
	
	if($dat_remun['KRITERIA_KINERJA_ID'] == '2' or $dat_remun['KRITERIA_KINERJA_ID'] == '3'){
		$capaian_kinerja += floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100;	
	}
	$total_row++;
	$total_capaian_print = $dat_remun['TOTAL_CAPAIAN'];
}

$auth = true;
if($pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID'] and $app_id == $appidx) $auth = false;
if($kepala_unit_kerja != '1') $jumlah_personil = 1;

if(isset($_GET['cetak'])){
	include('remunerasi/remunerasi_print_index_kinerja.php');
}
?>
<div style=" height:auto; padding:15px; ">
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		<table width="100%" border="0" >
			<tr>
				<td width="16%">Unit Kerja</td>
				<td width="25%">:&nbsp;<?php echo $unit_kerja; ?></td>
				<td>&nbsp;</td>
				<td>Periode</td>
				<td>:&nbsp;<?php echo $arr_bulan[$bulan] . ' ' . $tahun; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>PEGAWAI NEGERI SIPIL<br />YANG DINILAI</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td width="16%">PEJABAT PENILAI</td>
				<td width="25%">&nbsp;</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:&nbsp;<?php echo $nama_pegawai; ?></td>
				<td>&nbsp;</td>
				<td>Nama</td>
				<td>:&nbsp;<?php echo $nama_penilai; ?></td>
			</tr>
			<tr>
				<td>NIP</td>
				<td>:&nbsp;<?php echo $nip; ?></td>
				<td>&nbsp;</td>
				<td>NIP</td>
				<td>:&nbsp;<?php echo $nip_pnl; ?></td>
			</tr>
			<tr>
				<td>Pangkat/Gol. Ruang</td>
				<td>:&nbsp;<?php echo $golongan; ?></td>
				<td>&nbsp;</td>
				<td>Pangkat/Gol. Ruang</td>
				<td>:&nbsp;<?php echo $golongan_pnl; ?></td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td>:&nbsp;<?php echo $jabatan_desc; ?></td>
				<td>&nbsp;</td>
				<td>Jabatan</td>
				<td>:&nbsp;<?php echo $jabatan_desc_pnl; ?></td>
			</tr>
		</table>
 	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php if($auth == true){ ?>
	<form name="fromindex" method="post" >
	<input type="hidden" name="idx" value="<?php echo $idx; ?>" />
	<input type="hidden" name="trx" value="<?php echo $trx; ?>" />
	<input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
	<input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
	<input type="hidden" name="penilai_id" value="<?php echo $penilai_id; ?>" />
	<?php } ?>
	<table width="100%" border="1" class="tableData" id="tfhover">
	  <tr>
		<th rowspan="2">NO</th>
		<th rowspan="2">KRITERIA</th>
		<th rowspan="2">% TARGET </th>
		<th rowspan="2">% DETAIL<br/>TARGET </th>
		<th rowspan="2">URAIAN KEGIATAN </th>
		<th colspan="2">TARGET</th>
		<th rowspan="2">JUMLAH<br />PERSONIL </th>
		<th rowspan="2">OB</th>
	    <th rowspan="2">SATUAN</th>
        <th rowspan="2" colspan="3">CAPAIAN</th>
	  </tr>
	  <tr>
		<th>TAHUN</th>
		<th>BULAN</th>
	  </tr>
	  <?php 
	  mysql_data_seek($get_remun,0);
	  $kriteria_id = '';
	  $x = 1;
	  $r = 1;
	  while($dat_remun = mysql_fetch_array($get_remun)){?>
	  <tr>
		<?php
		if($dat_remun['KRITERIA_KINERJA_ID'] != $kriteria_id){
			$kriteria_id = $dat_remun['KRITERIA_KINERJA_ID'];
			echo '<td align="center" rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $x . '</td>';
			echo '<td rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $dat_remun['KRITERIA'] . '</td>';
			echo '<td align="center" rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $sum_target[$dat_remun['KRITERIA_KINERJA_ID']] . '</td>';
			$x++;
		}
		?>	
		<td align="center"><?php echo $dat_remun['TARGET']; ?></td>
		<td><?php echo $dat_remun['KEGIATAN']; ?></td>
		<td align="center"><?php echo $dat_remun['TARGET_TAHUN']; ?></td>
		<td align="center"><?php echo $dat_remun['TARGET_BULAN']; ?></td>
		<td align="center"><?php echo $jumlah_personil; ?></td>
		<td align="center"><input type="text" name="ob_<?php echo $r; ?>" class="text_dt" size="5" style="text-align:right;" value="<?php echo $dat_remun['OB']; ?>" 
			<?php if($auth == false) echo 'readonly="readonly"'; ?> />
			<input type="hidden" name="kegiatan_id_<?php echo $r; ?>" value="<?php echo $dat_remun['KEGIATAN_KINERJA_ID']; ?>" />
		</td>
		<td align="center"><?php echo $dat_remun['SATUAN']; ?></td>
		<td align="center"><input type="text" name="capaian_persen_<?php echo $r; ?>" class="text_dt" size="5" style="text-align:right;" 
			value="<?php echo floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100; ?>" 
			<?php if($auth == false) echo 'readonly="readonly"'; ?> /></td>
		<?php if($r == 1){ ?>	
		<td align="center" rowspan="<?php echo $total_row; ?>"><input type="text" name="capaian_kinerja_<?php echo $r; ?>" class="text_dt" size="5" style="text-align:right;" 
			value="<?php echo $capaian_kinerja; ?>" 
			<?php if($auth == false) echo 'readonly="readonly"'; ?> /></td>
		<?php } ?>	
		<td align="center"><input type="text" name="capaian_persen_<?php echo $r; ?>" class="text_dt" size="5" style="text-align:right;" 
			value="<?php if($dat_remun['KRITERIA_KINERJA_ID'] == '2' or $dat_remun['KRITERIA_KINERJA_ID'] == '3'){
							echo $capaian_kinerja * ($dat_remun['TARGET']/100);
							$total_capaian += $capaian_kinerja * ($dat_remun['TARGET']/100);
						}else{
							echo (floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100) * ($dat_remun['TARGET']/100);
							$total_capaian += (floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100) * ($dat_remun['TARGET']/100);
						}
			 ?>" 
			<?php if($auth == false) echo 'readonly="readonly"'; ?> /></td>	
	  </tr>
	  <?php $r++; } ?>
	  <tr>
		<td colspan="12" align="center">TOTAL CAPAIAN</td>
		<td align="center"><input type="text" name="total_capaian" class="text_dt" size="5" style="text-align:right;" 
			value="<?php echo $total_capaian; ?>" 
			<?php if($auth == false) echo 'readonly="readonly"'; ?> /></td>
	  </tr>
	  </table>
	  <table width="100%">
	  <tr>
		<td align="right"><?php if($auth== true){ ?>
		<input type="hidden" name="cnr" value="<?php echo $r-1; ?>" />
		<input type="submit" name="simpan" value="simpan" class="myButton" />
		<?php } if(!empty($trx)){ ?>
		<input type="button" name="print" value="print" class="myButton" onclick="JavaScript : print_skp();" />
		<?php } ?>
		<a href="index.php?link=173231fa678d920639ddd6d8784da06b"><input type="button" name="selesai" value="selesai" class="myButton" /></a>
		</td>
	  </tr>
	</table>
	<?php if($auth== true){ ?>
	</form>
	<?php } ?>
	</div>
</div>
<script language="JavaScript" >
function print_skp(){
	window.location = "<?php echo currentUrl(); ?>&cetak=1";
}
</script>
<?php } ?>
