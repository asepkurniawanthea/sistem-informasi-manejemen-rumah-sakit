<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

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
if(!empty($pegawai)){
	$sql_search_pegawai = 'AND CONCAT(p.NAMA_PEGAWAI,p.NIP) LIKE "%' . $pegawai . '%"';
}

$sql_search_unitkerja = '';
if(!empty($unit_kerja)){
	$sql_search_unitkerja = 'AND p.UNIT_KERJA_ID = "' . $unit_kerja . '"';
}

$arr_unit = array();
$qry_unit = 'SELECT r_unit_kerja.UNIT_KERJA_ID,r_unit_kerja.UNIT_KERJA
			FROM r_unit_kerja
			ORDER BY UNIT_KERJA';
$get_unit = mysql_query($qry_unit) or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
	$arr_unit[$dat_unit['UNIT_KERJA_ID']] = $dat_unit['UNIT_KERJA']; 
}

$sql_ls = 'SELECT DATE_FORMAT(DATE_ADD(STR_TO_DATE("' . $tahun . '/' . $bulan . '/01","%Y/%m/%d"), INTERVAL -1 MONTH),"%Y") AS TAHUN,
			DATE_FORMAT(DATE_ADD(STR_TO_DATE("' . $tahun . '/' . $bulan . '/01","%Y/%m/%d"), INTERVAL -1 MONTH),"%m") AS BULAN
			FROM DUAL';
$get_ls = mysql_query($sql_ls) or die(mysql_error());
$dat_ls = mysql_fetch_assoc($get_ls);
$ls_tahun = $dat_ls['TAHUN'];			
$ls_bulan = $dat_ls['BULAN'];

$qry_remun = 'SELECT p.NIP,p.NAMA_PEGAWAI,p.PENDIDIKAN,p.GOLONGAN,p.JABATAN AS JABATAN_DESC,
			j.JABATAN,j.GAJI_KMK,j.INSENTIF_MAKSIMAL,j.INSENTIF_MINIMAL,
			n.CORP_GRADE,n.NILAI_JAB,n.NILAI_JAB_MIN,n.NILAI_JAB_MAX,
			u.UNIT_KERJA,
			g.GAJI_BERSIH AS GAJI_BERSIH,
			r.REMUNERASI_BERSIH,
			a.JUMLAH_ANGGARAN,a.PERSEN_PEMBAGIAN,
			MAX(i.IKI) AS IKI
			FROM r_pegawai_ori p
			LEFT JOIN r_unit_kerja u
			ON (p.UNIT_KERJA_ID = u.UNIT_KERJA_ID)
			LEFT JOIN r_jabatan j
			ON (p.JABATAN_ID = j.JABATAN_ID)
			LEFT JOIN r_remun_nilai_jabatan n
			ON (j.NILAI_JABATAN_ID = n.NILAI_JABATAN_ID)
			LEFT JOIN t_remun_index_kinerja i
			ON (i.NIP = p.NIP
			AND i.TAHUN = "' . $tahun . '"
			AND i.BULAN = "' . $bulan . '")
			LEFT JOIN r_gaji g
			ON (p.NIP = g.NIP 
			AND g.TAHUN = "' . $ls_tahun . '"
			AND g.BULAN = "' . $ls_bulan . '")
			LEFT JOIN r_remunerasi r
			ON (p.NIP = r.NIP 
			AND r.TAHUN = "' . $ls_tahun . '"
			AND r.BULAN = "' . $ls_bulan . '")
			LEFT JOIN r_remun_anggaran a
			ON (a.TAHUN = "' . $tahun . '"
			AND a.BULAN = "' . $bulan . '")
			WHERE 1
			' . $sql_search_pegawai . '
			' . $sql_search_unitkerja . '
			GROUP BY p.NIP
			ORDER BY p.NAMA_PEGAWAI';
?>
<style>
div.vertical
{
 margin-left: -85px;
 position: absolute;
 width: 200px;
 transform: rotate(-90deg);
 -webkit-transform: rotate(-90deg); /* Safari/Chrome */
 -moz-transform: rotate(-90deg); /* Firefox */
 -o-transform: rotate(-90deg); /* Opera */
 -ms-transform: rotate(-90deg); /* IE 9 */
}

th.vertical
{
 height: 180px;
 width: 30px;
 line-height: 45px;
 padding-bottom: 120px;
}
</style>
<form name="searchpegawai" method="post" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Unit Kerja</td>
            <td><select name="unit_kerja" class="text_dt" style="width:180px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($unit_kerja == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
				</select></td>
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
			<td>Nama Pegawai</td>
            <td><input type="text" name="pegawai" class="text_dt" id="pegawai" value="<?php echo $pegawai; ?>" style="width:170px;" /></td>
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
			<td colspan="4" align="right"><input type="submit" name="cari" value="cari" class="myButton1" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Nama</th>
		<th rowspan="2">NIP</th>
        <th rowspan="2">Pendidikan</th>
		<th rowspan="2">Gol</th>
		<th rowspan="2">Jabatan</th>
		<th colspan="5">Kode Jabatan & Grading</th>
		<th rowspan="2">Total Job Value</th>
		<th rowspan="2">PIR</th>
		<th rowspan="2">100%<br />(P1+P2)</th>
		<th rowspan="2">Gaji KMK<br />(Remunerasi)</th>
		<th rowspan="2">RM (Gaji<br />+Tunjangan)</th>
		<th colspan="2">Position(P1)<br />Gaji</th>
		<th colspan="5">Performance(P2)<br />Insentif</th>
		<th rowspan="2">People(P3)</th>
		<th rowspan="2">People(P3)<br />COVID</th>
		<th colspan="3">Jml Remunerasi<br />Sebelum Pajak</th>
		<th rowspan="2">Jml Remunerasi<br />Sebelum Pajak</th>
		<th rowspan="2">Pajak</th>
		<th rowspan="2">Remunerasi Dibayarkan<br />Setelah Pajak</th>
		<th rowspan="2">Jml Remunerasi<br />Bulan Lalu</th>
		<th rowspan="2">Selisih</th>
    </tr>
	<tr>
		<th class="vertical" style="text-align:left;"><div class="vertical">Kode Jabatan</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Grade</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Nilai Jabatan Min</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Nilai Jabatan Max</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Nilai Jabatan</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">100%</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Usulan</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Min 25%</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">100%</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Max 220% dan MS 330%</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Point Kinerja</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Besaran Kinerja</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">RM + PNBP</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">KMK PNBP</div></th>
		<th class="vertical" style="text-align:left;"><div class="vertical">Usulan 100%</div></th>
	</tr>
    <?
    $x = 1;	
	$no = 0;
    $pager = new PS_Pagination($connect, $qry_remun, 10, 5, '&pegawai=' . $pegawai, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs) die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
        ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NIP']; ?></td>
			<td><?php echo $data['PENDIDIKAN']; ?></td>
			<td><?php echo $data['GOLONGAN']; ?></td>
			<td><?php echo $data['JABATAN_DESC']; ?></td>
			<td align="center"><?php echo $data['JABATAN']; ?></td>
			<td align="center"><?php echo $data['CORP_GRADE']; ?></td>
			<td align="right"><?php echo currFormat($data['NILAI_JAB_MIN']); ?></td>
			<td align="right"><?php echo currFormat($data['NILAI_JAB_MAX']); ?></td>
			<td align="right"><?php echo currFormat($data['NILAI_JAB']); ?></td>
			<td align="right"><?php echo currFormat($data['NILAI_JAB']); ?></td>
			<td align="right"><?php echo currFormat($data['JUMLAH_ANGGARAN']); ?></td>
			<td align="right"><?php $p1_p2 = $data['JUMLAH_ANGGARAN'] * $data['NILAI_JAB'];  
							echo currFormat($p1_p2); ?></td>
			<td align="right"><?php echo currFormat($data['GAJI_KMK']); ?></td>
			<td align="right"><?php echo currFormat($data['GAJI_BERSIH']); ?></td>
			<td align="right"><?php  $p1_100 = ($data['GAJI_KMK'] - $data['GAJI_BERSIH']) * (100/100); 
							echo currFormat($p1_100); ?></td>
			<td align="right"><?php $p1_usulan = ($data['JUMLAH_ANGGARAN'] * $data['NILAI_JAB']) * (30/100);  
							echo currFormat($p1_usulan); ?></td>
			<td align="right"><?php echo currFormat($data['INSENTIF_MINIMAL']); ?></td>
			<td align="right"><?php echo currFormat($data['INSENTIF_MINIMAL'] * 4); ?></td>
			<td align="right"><?php echo currFormat($data['INSENTIF_MAKSIMAL']); ?></td>
			<td align="center"><?php echo $data['IKI']; ?></td>
			<td align="right"><?php $besaran_kinerja = $p1_p2 * (70/100) * $data['IKI']; 
							echo currFormat($besaran_kinerja); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="center"><?php $rm_pnbp = $data['GAJI_BERSIH'] + $p1_100 + $besaran_kinerja;
						echo currFormat($rm_pnbp); ?></td>
			<td align="center"><?php $kmk_pnbp = $p1_100 + $besaran_kinerja;
						echo currFormat($kmk_pnbp); ?></td>			
			<td align="right"><?php $rem_usulan = $p1_usulan + $besaran_kinerja;
						echo currFormat($rem_usulan); ?></td>						
			<td align="right"><?php $rem_sbl_pajak = $rem_usulan * ($data['PERSEN_PEMBAGIAN']/100);
						echo currFormat($rem_sbl_pajak); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><?php echo currFormat($data['REMUNERASI_BERSIH']); ?></td>
			<td align="right">&nbsp;</td>
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
		<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="unit_kerja" value="<?php echo $unit_kerja; ?>" />
                    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
					<input type="hidden" name="pegawai" value="<?php echo $pegawai; ?>" />
					<input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
                    <input type="hidden" name="xlsfile" value="remunerasi/xls_perhitungan_remunerasi.php" />
                    <input type="hidden" name="xlsname" value="rpt_perhitungan_remunerasi.xls" />            
        </form>