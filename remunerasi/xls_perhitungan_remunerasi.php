<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$unit_kerja = '';
if (isset($_POST['unit_kerja']))
    $unit_kerja = $_POST['unit_kerja'];
$tahun = '';
if (isset($_POST['tahun']))
    $tahun = $_POST['tahun'];
$bulan = '';
if (isset($_POST['bulan']))
    $bulan = $_POST['bulan'];
$pegawai = '';
if (isset($_POST['pegawai']))
		$pegawai = $_POST['pegawai'];	
	
$arr_bulan = array('01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Maret',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'Agustus',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'Nopember',
				'12' => 'Desember');	

$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

$sql_search_pegawai = '';
if(!empty($pegawai)){
	$sql_search_pegawai = 'AND CONCAT(p.NAMA_PEGAWAI,p.NIP) LIKE "%' . $pegawai . '%"';
}

$sql_search_unitkerja = '';
if(!empty($unit_kerja)){
	$sql_search_unitkerja = 'AND p.UNIT_KERJA_ID = "' . $unit_kerja . '"';
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
			ORDER BY u.UNIT_KERJA_ID,p.NAMA_PEGAWAI';
?>
<table border="1" width="100%">
<tr>
	<th colspan="33">REMUNERASI BULAN <?php echo strtoupper($arr_bulan[$bulan]); ?> TAHUN <?php echo $tahun; ?></th>
</tr>
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
		<th>Kode Jabatan</th>
		<th>Grade</th>
		<th>Nilai Jabatan Min</th>
		<th>Nilai Jabatan Max</th>
		<th>Nilai Jabatan</th>
		<th>100%</th>
		<th>Usulan</th>
		<th>Min 25%</th>
		<th>100%</th>
		<th>Max 220% dan MS 330%</th>
		<th>Point Kinerja</th>
		<th>Besaran Kinerja</th>
		<th>RM + PNBP</th>
		<th>KMK PNBP</th>
		<th>Usulan 100%</th>
	</tr>
    <?
    $x = 1;	
	$unit_kerja = '';
	$rs = mysql_query($qry_remun) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        if($unit_kerja != $data['UNIT_KERJA']){
			$unit_kerja = $data['UNIT_KERJA'];
			?>
			<tr>
				<td colspan="33"><strong><?php echo $unit_kerja; ?></strong></td>
			</tr>	
		<?php } ?>
        <tr>
            <td align="center"><? echo $x; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td>'<?php echo $data['NIP']; ?></td>
			<td><?php echo $data['PENDIDIKAN']; ?></td>
			<td><?php echo $data['GOLONGAN']; ?></td>
			<td><?php echo $data['JABATAN_DESC']; ?></td>
			<td align="center"><?php echo $data['JABATAN']; ?></td>
			<td align="center"><?php echo $data['CORP_GRADE']; ?></td>
			<td align="right"><?php echo $data['NILAI_JAB_MIN']; ?></td>
			<td align="right"><?php echo $data['NILAI_JAB_MAX']; ?></td>
			<td align="right"><?php echo $data['NILAI_JAB']; ?></td>
			<td align="right"><?php echo $data['NILAI_JAB']; ?></td>
			<td align="right"><?php echo $data['JUMLAH_ANGGARAN']; ?></td>
			<td align="right"><?php $p1_p2 = $data['JUMLAH_ANGGARAN'] * $data['NILAI_JAB'];  
							echo $p1_p2; ?></td>
			<td align="right"><?php echo $data['GAJI_KMK']; ?></td>
			<td align="right"><?php echo $data['GAJI_BERSIH']; ?></td>
			<td align="right"><?php  $p1_100 = ($data['GAJI_KMK'] - $data['GAJI_BERSIH']) * (100/100); 
							echo $p1_100; ?></td>
			<td align="right"><?php $p1_usulan = ($data['JUMLAH_ANGGARAN'] * $data['NILAI_JAB']) * (30/100);  
							echo $p1_usulan; ?></td>
			<td align="right"><?php echo $data['INSENTIF_MINIMAL']; ?></td>
			<td align="right"><?php echo $data['INSENTIF_MINIMAL'] * 4; ?></td>
			<td align="right"><?php echo $data['INSENTIF_MAKSIMAL']; ?></td>
			<td align="center"><?php echo $data['IKI']; ?></td>
			<td align="right"><?php $besaran_kinerja = $p1_p2 * (70/100) * $data['IKI']; 
							echo $besaran_kinerja; ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="center"><?php $rm_pnbp = $data['GAJI_BERSIH'] + $p1_100 + $besaran_kinerja;
						echo $rm_pnbp; ?></td>
			<td align="center"><?php $kmk_pnbp = $p1_100 + $besaran_kinerja;
						echo $kmk_pnbp; ?></td>			
			<td align="right"><?php $rem_usulan = $p1_usulan + $besaran_kinerja;
						echo $rem_usulan; ?></td>						
			<td align="right"><?php $rem_sbl_pajak = $rem_usulan * ($data['PERSEN_PEMBAGIAN']/100);
						echo $rem_sbl_pajak; ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><?php echo $data['REMUNERASI_BERSIH']; ?></td>
			<td align="right">&nbsp;</td>
	</tr>
	<?php $x++; } ?>
</table>