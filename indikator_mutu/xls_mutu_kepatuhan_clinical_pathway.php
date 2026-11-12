<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$ruang_id = $_POST['ruang_id'];
$searchkey = $_POST['searchkey'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT kcp.CLINICAL_PATHWAY_ID,kcp.RAWAT_ID,
			kcp.RUANG_ID,kcp.PENGKAJIAN,kcp.OBAT,
			kcp.PENUNJANG,kcp.DIET,kcp.EDUKASI,
			DATE_FORMAT(kcp.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			kcp.PENGUMPUL_DATA,
			psn.NOMR,psn.NAMA_PASIEN,
			CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG
			FROM db_repository.mutu_kepatuhan_clinical_pathway kcp	
			INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = kcp.RAWAT_ID) 
			INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
			LEFT JOIN db_simrs.m_ruang un ON (un.RUANG_ID = kcp.RUANG_ID)
			WHERE kcp.TANGGAL >= ' . $tgl_filter_1 . '
			AND kcp.TANGGAL <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY kcp.CLINICAL_PATHWAY_ID';
?>
<table border="1" >
	<tr>
		<th colspan="10">Kepatuhan Clinical Pathway Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Ruang Rawat</th>
        <th>Pengkajian</th>
		<th>Obat</th>
		<th>Penunjang</th>
		<th>Diet</th>
		<th>Edukasi</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center">
				<?php if($data['PENGKAJIAN'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['OBAT'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['PENUNJANG'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['DIET'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['EDUKASI'] == '1') echo 'Ya'; ?>
			</td>
        </tr>
        <?
    $no++; }
    ?>
</table>
