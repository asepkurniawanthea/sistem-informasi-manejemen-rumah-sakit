<?php
$qry_kamar = 'SELECT t_operasi.OPERASI_ID,t_operasi.TANGGAL_ORDER,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_RENCANA_OPERASI,"%d/%m/%Y") AS TANGGAL_RENCANA_OPERASI,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.PEGAWAI_PELAKSANA_ID,t_operasi.PEGAWAI_ID,t_operasi.ST_APPROVE,
				t_operasi.KETERANGAN,CONCAT(m_ruang.NAMA_RUANG," /",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.ST_OPERASI,t_operasi.RUANG_ID
				FROM t_operasi
				INNER JOIN m_ruang ON (t_operasi.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_operasi.RAWAT_ID = "' . $irna_id . '"
				AND t_operasi.JNS_ORDER = "IRN"';
$get_kamar = mysql_query($qry_kamar) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th>Tanggal Rencana<br />Operasi</th>
	<th>Ruang Rawat/ Kelas</th>
	<th>Dokter Pegirim</th>
	<th>Tanggal Operasi</th>
	<th>Dokter Pelaksana Operasi</th>
	<th>Status</th>
	<th>Keterangan</th>
	<th>Option</th>
</tr>
<?php
$i = 1;
while ($dat_kamar = mysql_fetch_array($get_kamar)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_kamar['TANGGAL_RENCANA_OPERASI']; ?></td>
		<td><?php echo $dat_kamar['NAMA_RUANG']; ?></td>
        <td><?php echo $dat_kamar['DOKTER_PENGIRIM']; ?></td>
		<td><?php echo $dat_kamar['TANGGAL_OPERASI'] . ' ' . $dat_kamar['JAM_OPERASI']; ?></td>
		<td><?php echo $dat_kamar['DOKTER_OPERASI']; ?></td>
		<td><?php if($dat_kamar['ST_OPERASI'] == '1') echo '&radic'; ?></td>
		<td><?php echo $dat_kamar['KETERANGAN']; ?></td>
		<td align="center">
			<?php if($irna_final == ''){  
					if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){ 
						if($dat_kamar['ST_APPROVE'] != '1'){ ?>
							<a href="<?php echo currentUrl(); ?>&iop=<?php echo $dat_kamar['OPERASI_ID']; ?>&nmo=<?php echo $dat_kamar['OPERASI_ID']; ?>" >hapus</a>
						<?php }
					}else{
						if($dat_kamar['ST_APPROVE'] != '1' and $dat_kamar['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ ?>
							<a href="<?php echo currentUrl(); ?>&iop=<?php echo $dat_kamar['OPERASI_ID']; ?>&nmo=<?php echo $dat_kamar['OPERASI_ID']; ?>" >hapus</a>
						<?php }
					}
			} ?></td>
    </tr>
<?php    
    $i++;
	}
?>