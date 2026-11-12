<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

$appidx = '1';

$pegawai = '';
if(isset($_SESSION['renum_pegawai'])){
	$pegawai = $_SESSION['renum_pegawai'];
}

$unit_kerja = '';
if(isset($_SESSION['renum_unitkerja'])){
	$unit_kerja = $_SESSION['renum_unitkerja'];
}

$tahun = date('Y');
if(isset($_SESSION['renum_tahun'])){
	$tahun = $_SESSION['renum_tahun'];
}

$bulan = date('m');
$bulan = substr('00',0,2 - strlen($bulan)) . $bulan;
if(isset($_SESSION['renum_bulan'])){
	$bulan = $_SESSION['renum_bulan'];
}

if (isset($_POST['pegawai'])) {
    $pegawai = $_POST['pegawai'];
	$_SESSION['renum_pegawai'] = $_POST['pegawai'];
}	
if (isset($_POST['unit_kerja'])) {
	$unit_kerja = $_POST['unit_kerja'];
	$_SESSION['renum_unitkerja'] = $_POST['unit_kerja'];
}	
if (isset($_POST['tahun'])) {
	$tahun = $_POST['tahun'];
	$_SESSION['renum_tahun'] = $_POST['tahun'];
}
if (isset($_POST['bulan'])) {	
	$bulan = $_POST['bulan'];
	$_SESSION['renum_bulan'] = $_POST['bulan'];
}

$sql_search_pegawai = '';
$sql_search_pegawai_2 = '';
if(!empty($pegawai)){
	$sql_search_pegawai = 'AND db_simrs.m_pegawai.NAMA_PEGAWAI LIKE "%' . $pegawai . '%"';
	$sql_search_pegawai_2 = 'AND db_inventorirs.m_pegawai.NAMA_PEGAWAI LIKE "%' . $pegawai . '%"';
}

$sql_search_unitkerja = '';
if(!empty($unit_kerja)){
	$sql_search_unitkerja = 'AND db_sdm.r_pegawai.UNIT_KERJA_ID = "' . $unit_kerja . '"';
}

$sql_search_tahun = '';
if(!empty($tahun)){
	$sql_search_tahun = 'AND db_sdm.t_remun_index_kinerja.TAHUN = "' . $tahun . '"';
}

$sql_search_bulan = '';
if(!empty($bulan)){
	$sql_search_bulan = 'AND db_sdm.t_remun_index_kinerja.BULAN = "' . $bulan . '"';
}

$unit = '';
$kepala = '';
$sql_search_kepala = '';
$sql_search_user = '';
if(currentModul() != 'remunerasi'){
	$qry_pegawai = 'SELECT r_pegawai.PEGAWAI_IDX,r_pegawai.PEGAWAI_ID,r_pegawai.APP_ID,
					r_pegawai.UNIT_KERJA_ID,r_pegawai.JABATAN_ID,r_pegawai.KEPALA_UNIT_KERJA
					FROM r_pegawai
					WHERE r_pegawai.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
					AND r_pegawai.APP_ID = "' . $appidx . '"';
	$get_pegawai = mysql_query($qry_pegawai) or die(mysql_error());
	$dat_pegawai = mysql_fetch_assoc($get_pegawai);
	$unit = $dat_pegawai['UNIT_KERJA_ID'];	
	$kepala = $dat_pegawai['KEPALA_UNIT_KERJA'];
	if($kepala == '1') {
		$sql_search_kepala = 'AND db_sdm.r_pegawai.UNIT_KERJA_ID = "' . $unit . '"'; 
	}else{
		$sql_search_user = 'AND db_sdm.r_pegawai.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
						AND db_sdm.r_pegawai.APP_ID = "' . $appidx . '"'; 
	}	
}

$qry_remun = 'SELECT t.APP,t.PEGAWAI_ID,t.KET_TIPE_PEGAWAI,t.NAMA_PEGAWAI,
			db_sdm.r_pegawai.PEGAWAI_IDX,db_sdm.r_pegawai.UNIT_KERJA_ID,
			db_sdm.r_pegawai.JABATAN_ID,db_sdm.r_pegawai.KEPALA_UNIT_KERJA,
			db_sdm.r_pegawai.NIP,db_sdm.r_pegawai.PENDIDIKAN,
			db_sdm.r_pegawai.GOLONGAN,db_sdm.r_jabatan.JABATAN,
			db_sdm.r_jabatan.JABATAN_DESC,db_sdm.r_unit_kerja.UNIT_KERJA,
			db_sdm.r_remun_nilai_jabatan.NILAI_JAB,
			db_sdm.t_remun_index_kinerja.INDEX_KINERJA_ID,db_sdm.t_remun_index_kinerja.REGISTER,
			db_sdm.t_remun_index_kinerja.TOTAL_CAPAIAN	
			FROM (
					SELECT "1" AS APP,db_simrs.m_pegawai.PEGAWAI_ID,db_simrs.m_pegawai_tipe.KET_TIPE_PEGAWAI,
					db_simrs.m_pegawai.NAMA_PEGAWAI
					FROM db_simrs.m_pegawai
					LEFT JOIN db_simrs.m_pegawai_tipe 
					ON (db_simrs.m_pegawai.TIPE_PEGAWAI_ID = db_simrs.m_pegawai_tipe.TIPE_PEGAWAI_ID)
					WHERE db_simrs.m_pegawai.NAMA_PEGAWAI <> "-"
					' . $sql_search_pegawai. '
					UNION ALL
					SELECT "2" AS APP,db_inventorirs.m_pegawai.PEGAWAI_ID,"" AS KET_TIPE_PEGAWAI,
					db_inventorirs.m_pegawai.NAMA_PEGAWAI
					FROM db_inventorirs.m_pegawai
					WHERE db_inventorirs.m_pegawai.NAMA_PEGAWAI <> "-"
					' . $sql_search_pegawai_2. '
			) t 
			INNER JOIN db_sdm.r_pegawai
			ON (t.PEGAWAI_ID = db_sdm.r_pegawai.PEGAWAI_ID AND t.APP = db_sdm.r_pegawai.APP_ID)
			INNER JOIN db_sdm.r_jabatan
			ON (db_sdm.r_pegawai.JABATAN_ID = db_sdm.r_jabatan.JABATAN_ID)
			INNER JOIN db_sdm.r_remun_nilai_jabatan
			ON (db_sdm.r_jabatan.NILAI_JABATAN_ID = db_sdm.r_remun_nilai_jabatan.NILAI_JABATAN_ID)
			INNER JOIN db_sdm.r_unit_kerja
			ON (db_sdm.r_pegawai.UNIT_KERJA_ID = db_sdm.r_unit_kerja.UNIT_KERJA_ID)
			LEFT JOIN t_remun_index_kinerja 
			ON (r_pegawai.PEGAWAI_IDX = t_remun_index_kinerja.PEGAWAI_IDX
			' . $sql_search_tahun . ' ' . $sql_search_bulan . ')
			WHERE 1 ' . $sql_search_unitkerja . '
			' . $sql_search_kepala . '
			' . $sql_search_user . '
			ORDER BY t.NAMA_PEGAWAI'; 			
$arr_unit = array();
$qry_unit = 'SELECT r_unit_kerja.UNIT_KERJA_ID,r_unit_kerja.UNIT_KERJA
			FROM r_unit_kerja
			ORDER BY UNIT_KERJA';
$get_unit = mysql_query($qry_unit) or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
	$arr_unit[$dat_unit['UNIT_KERJA_ID']] = $dat_unit['UNIT_KERJA']; 
}

$sql_anggaran = 'SELECT r_remun_anggaran.JUMLAH_ANGGARAN
				FROM r_remun_anggaran
				WHERE r_remun_anggaran.BULAN = "' . $bulan . '"
				AND r_remun_anggaran.TAHUN = "' . $tahun . '"';
$get_anggaran = mysql_query($sql_anggaran) or die(mysql_error());
$dat_anggaran = mysql_fetch_assoc($get_anggaran);
$jml_anggaran = $dat_anggaran['JUMLAH_ANGGARAN'];	
?>
<form name="searchpegawai" method="post" action="index.php">
    <table class="tableform" >
        <tr>
            <?php if(currentModul() == 'remunerasi'){ ?>
			<td>Unit Kerja</td>
            <td><select name="unit_kerja" class="text_dt" style="width:180px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($unit_kerja == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
				</select></td>
			<?php } ?>	
			<td>Tahun</td>
            <td><select name="tahun" class="text_dt" style="width:180px;" >
				<option value="2016" <?php if($tahun == '2016') echo 'selected="selected"'; ?> >2016</option>
				<option value="2017" <?php if($tahun == '2017') echo 'selected="selected"'; ?> >2017</option>
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
			</select></td>
        </tr>
		<tr>
            <?php if(currentModul() == 'remunerasi'){ ?>
			<td>Nama Pegawai</td>
            <td><input type="text" name="pegawai" class="text_dt" id="pegawai" value="<?php echo $pegawai; ?>" style="width:170px;" /></td>
			<?php } ?>
			<td>Bulan</td>
            <td><select name="bulan" class="text_dt" style="width:180px;" >
				<option value="01" <?php if($bulan == '01') echo 'selected="selected"'; ?> >Januari</option>
				<option value="02" <?php if($bulan == '02') echo 'selected="selected"'; ?> >Februari</option>
				<option value="03" <?php if($bulan == '03') echo 'selected="selected"'; ?> >Maret</option>
				<option value="04" <?php if($bulan == '04') echo 'selected="selected"'; ?> >April</option>
				<option value="05" <?php if($bulan == '05') echo 'selected="selected"'; ?> >Mei</option>
				<option value="06" <?php if($bulan == '06') echo 'selected="selected"'; ?> >Juni</option>
				<option value="07" <?php if($bulan == '07') echo 'selected="selected"'; ?> >Juli</option>
				<option value="08" <?php if($bulan == '08') echo 'selected="selected"'; ?> >Agustus</option>
				<option value="09" <?php if($bulan == '09') echo 'selected="selected"'; ?> >September</option>
				<option value="10" <?php if($bulan == '10') echo 'selected="selected"'; ?> >Oktober</option>
				<option value="11" <?php if($bulan == '11') echo 'selected="selected"'; ?> >Nopember</option>
				<option value="12" <?php if($bulan == '12') echo 'selected="selected"'; ?> >Desember</option>
			</select></td>
        </tr>
		<tr>
			<td colspan="4" align="right"><input type="submit" name="cari" value="cari" class="myButton1" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Nama</th>
		<?php if(currentModul() == 'remunerasi'){ ?>
		<th>App-Tipe</th>
		<?php } ?>
		<th>NIP</th>
        <th>Pendidikan</th>
		<th>Golongan</th>
		<th>Jabatan</th>
		<th>Unit Kerja</th>
		<?php if(currentModul() == 'remunerasi'){ ?>
		<th>Kepala</th>
		<?php } ?>
		<th>Capaian<br />IKI</th>
		<th>Remunerasi</th>
		<th>Register</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
	$no = 0;
    $pager = new PS_Pagination($connect, $qry_remun, 10, 5, '&pegawai=' . $pegawai, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs) die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    $id = $data['PEGAWAI_IDX'];
	$tr = $data['INDEX_KINERJA_ID'];
	$p1 = ($jml_anggaran * $data['NILAI_JAB']) * (30 / 100);
	$p2 = ($jml_anggaran * $data['NILAI_JAB']) * (70/100) * $data['TOTAL_CAPAIAN'];	
	$jml_remunerasi = $p1 + $p2;
	$pajak = 0;
	$gol_array = explode('/',$data['GOLONGAN']);
	if(sizeof($gol_array) == 2){
		$gol = $gol_array[0];
		if(strtoupper($gol) == 'III') $pajak = (5 / 100) * $jml_remunerasi;
		if(strtoupper($gol) == 'IV') $pajak = (15 / 100) * $jml_remunerasi;
	}
	$remunerasi = $jml_remunerasi - $pajak;
        ?>
        <tr>
            <td align="center"><?
					$no = ($no + 1);
					if (isset($_GET['page'])) {
						if ($_GET['page'] == 0) {
							$hal = 0;
						} else {
							$hal = $_GET['page'] - 1;
						}
					} else {
						$hal = 0;
					}
					echo ($hal * 10) + $no;
        ?>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<?php if(currentModul() == 'remunerasi'){ ?>
			<td><?php $app = 'SIM';
				if($data['APP'] == '2') $app = 'SIV';
				if(!empty($data['KET_TIPE_PEGAWAI'])) $app = $app . '-' . $data['KET_TIPE_PEGAWAI']; 
				echo $app;
			?></td>
			<?php } ?>
			<td><?php echo $data['NIP']; ?></td>
			<td><?php echo $data['PENDIDIKAN']; ?></td>
			<td><?php echo $data['GOLONGAN']; ?></td>
			<td><?php echo $data['JABATAN'] . '-' . $data['JABATAN_DESC']; ?></td>
			<td><?php echo $data['UNIT_KERJA']; ?></td>
			<?php if(currentModul() == 'remunerasi'){ ?>
			<td align="center"><?php if($data['KEPALA_UNIT_KERJA'] == '1') echo '&radic;'; ?></td>
			<?php } ?>
			<td align="center"><?php echo $data['TOTAL_CAPAIAN']; ?></td>
			<td align="right"><?php echo currFormat($remunerasi); ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
			<td align="center">
			<?php $link_a = '<a href="index.php?link=cd3868a9498dad713cbf6036e1614ef3&idx=' . $id . '&trx=' . $tr . '&tahun=' . $tahun . '&bulan=' . $bulan . '" >lihat</a>'; 
				$link_b = '<a href="index.php?link=ca69ac058982b2f75d36a7b3c8c48dd0&idx=' . $id . '&trx=' . $tr . '&tahun=' . $tahun . '&bulan=' . $bulan . '" >lihat</a>'; 	
				$link_c = '<a href="index.php?link=ca69ac058982b2f75d36a7b3c8c48dd0&idx=' . $id . '&trx=' . $tr . '&tahun=' . $tahun . '&bulan=' . $bulan . '" >nilai</a>'; 	
				
				if(currentModul() == 'remunerasi'){
					if(!empty($data['INDEX_KINERJA_ID'])){ 
						echo $link_a;
				 	}
				}else{ 
					if($kepala != '1'){ 
						if(!empty($data['INDEX_KINERJA_ID'])){ 
							echo $link_b;
						}
					}else{ 
						if($data['APP'] == $appidx and $data['PEGAWAI_ID'] == $_SESSION['SES_SIMRS_PEGAWAI_ID']){
							if(!empty($data['INDEX_KINERJA_ID'])){
								echo $link_b;	
							}	
						}else{
							echo $link_c;
						}
					} 
				} ?>	
			</td>
	</tr>
	<?php $x++; } ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>