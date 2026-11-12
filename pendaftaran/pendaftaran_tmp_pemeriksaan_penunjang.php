<?php
$qry_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,
				CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND t_ipenunjang.JNS_PENUNJANG = "PNJ"
				AND t_ipenunjang.DESKRIPSI = "Penunjang (Pendaftaran)"
				AND t_ipenunjang.NO_ORDER IS NULL
				ORDER BY t_ipenunjang_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Pemeriksaan</th>
    <th>Nama Pemeriksaan</th>
    <th>Tarif (Rp.)</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
$total = 0;
if($tgl_daftar != $tgl_sekarang){
	$i++;
	$sql_karcis = 'SELECT TARIF_ID,NAMA_TARIF,TARIF_NON_KELAS
			FROM m_tarif WHERE KODE_TARIF = "01001" AND ST_AKTIF = "1"';
	$get_karcis = mysql_query($sql_karcis) or die(mysql_error());
	$dat_karcis = mysql_fetch_assoc($get_karcis);
	$total += $dat_karcis['TARIF_NON_KELAS'];	
?>
<tr>
    <td align="center">1</td>
	<td>&nbsp;</td>
	<td>Administrasi</td>
    <td>Karcis</td>
    <td align="right"><?php echo currFormat($dat_karcis['TARIF_NON_KELAS']); ?></td>
	<td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="karcis" value="<?php echo $dat_karcis['TARIF_ID']; ?>" checked /></td>
</tr>
<?php
}
$nomor = '';
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td align="center"><?php if($nomor != $dat_tarif['NO_TARIF']) { echo $dat_tarif['NO_TARIF']; $nomor = $dat_tarif['NO_TARIF']; }  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<?php if($jenis_bayar_id == '1' and empty($dat_tarif['NO_PEMBAYARAN'])){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php }else if($jenis_bayar_id != '1'){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php } ?></td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>