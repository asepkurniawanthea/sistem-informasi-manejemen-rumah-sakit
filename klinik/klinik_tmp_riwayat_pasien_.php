<?php
$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$qry_jns_doc = '';
$qry_tanggal = '';

if($jnsdoc != ''){
	$qry_jns_doc = 'AND tr.JENIS_DOKUMEN_ID = "' . $jnsdoc . '"';
}

if($tgl_1 != '' or $tgl_2 != ''){
	$qry_tanggal = 'AND STR_TO_DATE(DATE_FORMAT(tr.TANGGAL,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . '
		AND STR_TO_DATE(DATE_FORMAT(tr.TANGGAL,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2;
}
$qry_rm = 'SELECT * FROM (
			SELECT tr.FILE_ID,tr.JENIS_DOKUMEN_ID,
			DATE_FORMAT(tr.TANGGAL,"%d-%m-%Y") AS TANGGAL,
			rm.JENIS_DOKUMEN,un.NAMA_UNIT,
			rm.LIST_ORDER	
			FROM t_rm_dokumen_file tr
			INNER JOIN m_rm_jenis_dokumen rm
			ON (tr.JENIS_DOKUMEN_ID = rm.JENIS_DOKUMEN_ID)
			INNER JOIN t_irja tj ON (tr.RAWAT_ID = tj.IRJA_ID)
			INNER JOIN m_unit un ON (tj.UNIT_ID = un.UNIT_ID)
			WHERE tr.NOMR = "' . $nomr . '"
			AND tr.JNS_PERAWATAN = "1"
			' . $qry_jns_doc . '
			' . $qry_tanggal . '
			UNION
			SELECT tr.FILE_ID,tr.JENIS_DOKUMEN_ID,
			DATE_FORMAT(tr.TANGGAL,"%d-%m-%Y") AS TANGGAL,
			rm.JENIS_DOKUMEN,un.NAMA_RUANG AS NAMA_UNIT,
			rm.LIST_ORDER	
			FROM t_rm_dokumen_file tr
			INNER JOIN m_rm_jenis_dokumen rm
			ON (tr.JENIS_DOKUMEN_ID = rm.JENIS_DOKUMEN_ID)
			INNER JOIN t_irna tn ON (tr.RAWAT_ID = tn.IRNA_ID)
			INNER JOIN m_ruang un ON (tn.RUANG_ID = un.RUANG_ID)
			WHERE tr.NOMR = "' . $nomr . '"
			AND tr.JNS_PERAWATAN = "2"
			' . $qry_jns_doc . '
			' . $qry_tanggal . '
			) t_rm ORDER BY LIST_ORDER';
$get_rm = mysql_query($qry_rm) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Unit/ Ruang</th>
<th>Jenis Dokumen</th>
<th>Option</th>
</tr>
<?php $no = 1; 
while($dat_rm = mysql_fetch_array($get_rm)){ ?>
<tr>
	<td align="center"><?php echo $no; ?></td>
	<td align="center"><?php echo $dat_rm['TANGGAL']; ?></td>
	<td><?php echo $dat_rm['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_rm['JENIS_DOKUMEN']; ?></td>
	<td align="center"><a href="#" onclick="window.open('index.php?flex=<?php echo $dat_rm['FILE_ID']; ?>', '_blank');">lihat</a></td>
</tr>
<?php $no++; 
} ?>
</table>