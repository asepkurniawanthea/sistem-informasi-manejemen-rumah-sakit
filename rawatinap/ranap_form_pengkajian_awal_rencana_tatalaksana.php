<table border="0" width="100%">
<?php
$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,SUM(t_irja_tarif.KUANTITI) AS KUANTITI
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF <> "103001" AND m_tarif.KODE_TARIF <> "102001"
				OR (t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik" AND t_irja_tarif.IRJA_ID = "' . $irja_id . '")
				AND t_irja_tarif.NO_TARIF IS NOT NULL
				GROUP BY m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY t_irja_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';				
$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());
if(mysql_num_rows($get_tindakan) == 0){
?>
		<tr>
			<td width="180px">Tindakan</td>
			<td width="10px">:</td>
			<td colspan="5">-</td>
		</tr>	
<?php }else{ 
$t = 1;
while($dat_tindakan = mysql_fetch_array($get_tindakan)){
if($t == 1){ ?>
		<tr>
			<td width="180px">Tindakan</td>
			<td width="10px">:</td>
			<td colspan="2"><?php echo $dat_tindakan['NAMA_TARIF_GROUP'] . '-' . $dat_tindakan['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_tindakan['KUANTITI'] . ' ' . $dat_tindakan['SATUAN']; ?></td>
		</tr>	
<?php }else{ ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><?php echo $dat_tindakan['NAMA_TARIF_GROUP'] . '-' . $dat_tindakan['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_tindakan['KUANTITI'] . ' ' . $dat_tindakan['SATUAN']; ?></td>
		</tr>	
<?php } 
$t++; } } ?>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
<?php
$qry_resep = 'SELECT t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.DOSIS,
				CASE WHEN t_irja_resep.SATUAN IS NOT NULL THEN CONCAT(t_irja_resep.JUMLAH," ",t_irja_resep.SATUAN)
				ELSE t_irja_resep.JUMLAH END AS JUMLAH,t_irja_resep.PSIKOTROPIKA,
				t_irja_resep.IRJA_RESEP_ID
				FROM t_irja_resep
				WHERE IRJA_ID = "' . $irja_id . '" AND t_irja_resep.RESEP IS NOT NULL
				AND t_irja_resep.NO_RESEP IS NOT NULL
				ORDER BY t_irja_resep.NO_RESEP';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
if(mysql_num_rows($get_resep) == 0){
?>		
		<tr>
			<td>Resep</td>
			<td>:</td>
			<td colspan="5">-</td>
		</tr>
<?php }else{
$r = 1;
while($dat_resep = mysql_fetch_array($get_resep)){
if($r == 1){ ?>
		<tr>
			<td>Resep</td>
			<td>:</td>
			<td colspan="2"><?php echo $dat_resep['RESEP']; ?></td>
			<td><?php echo $dat_resep['DOSIS']; ?></td>
			<td><?php echo $dat_resep['JUMLAH']; ?></td>
			<td><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '<i>Psikotropika</i>'; ?></td>
		</tr>
<?php }else{ ?>	
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><?php echo $dat_resep['RESEP']; ?></td>
			<td><?php echo $dat_resep['DOSIS']; ?></td>
			<td><?php echo $dat_resep['JUMLAH']; ?></td>
			<td><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '<i>Psikotropika</i>'; ?></td>
		</tr>
<?php }
	if($dat_resep['RACIKAN'] == '1'){
			$sql_racikan = 'SELECT t_irja_resep_racikan.RESEP,
							CASE WHEN t_irja_resep_racikan.SATUAN IS NOT NULL THEN CONCAT(t_irja_resep_racikan.JUMLAH," ",t_irja_resep_racikan.SATUAN)
							ELSE t_irja_resep_racikan.JUMLAH END AS JUMLAH
							FROM t_irja_resep_racikan 
							WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_resep['IRJA_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2"><?php echo $dat_racikan['RESEP']; ?></td>
				<td><?php echo $dat_racikan['JUMLAH']; ?></td>
				<td>&nbsp;</td>
				</tr>
		<?php	}
	}	
$r++; } } ?>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
<?php
$qry_penunjang = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY t_ipenunjang_tarif.NO_TARIF,m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
$get_penunjang = mysql_query($qry_penunjang) or die(mysql_error());
if(mysql_num_rows($get_penunjang) == 0){
?>		
		<tr>
			<td>Penunjang</td>
			<td>:</td>
			<td colspan="5">-</td>
		</tr>
<?php }else{ 
$p = 1;
while($dat_penunjang = mysql_fetch_array($get_penunjang)){
if($p == 1){ ?>
		<tr>
			<td>Penunjang</td>
			<td>:</td>
			<td colspan="2"><?php echo $dat_penunjang['NAMA_TARIF_GROUP'] . '-' . $dat_penunjang['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_penunjang['KUANTITI'] . ' ' . $dat_penunjang['SATUAN']; ?></td>
		</tr>	
<?php }else{ ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><?php echo $dat_penunjang['NAMA_TARIF_GROUP'] . '-' . $dat_penunjang['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_penunjang['KUANTITI'] . ' ' . $dat_penunjang['SATUAN']; ?></td>
		</tr>	
<?php } 
$p++; } } 
$qry_hemodialisa  = 'SELECT t_hemodialisa_tarif.TARIF_ID,COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							m_tarif.NAMA_TARIF
							FROM t_hemodialisa
							INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
							INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_hemodialisa.RAWAT_ID = "' . $irja_id . '" 
							AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
							AND t_hemodialisa.JNS_ORDER = "IRJ"	
							GROUP BY t_hemodialisa_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
$get_hemodialisa = mysql_query($qry_hemodialisa) or die(mysql_error());
while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){							
?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><?php echo $dat_hemodialisa['NAMA_TARIF_GROUP'] . '-' . $dat_hemodialisa['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_hemodialisa['KUANTITI'] . ' ' . $dat_hemodialisa['SATUAN']; ?></td>
		</tr>	
<?php } 
$qry_penunjang_hemodialisa  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
							AND t_ipenunjang.JNS_ORDER = "HRJ"	
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
$get_penunjang_hemodialisa = mysql_query($qry_penunjang_hemodialisa) or die(mysql_error());
while($dat_penunjang_hemodialisa = mysql_fetch_array($get_penunjang_hemodialisa)){
?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><?php echo $dat_penunjang_hemodialisa['NAMA_TARIF_GROUP'] . '-' . $dat_penunjang_hemodialisa['NAMA_TARIF']; ?></td>
			<td colspan="3"><?php echo $dat_penunjang_hemodialisa['KUANTITI'] . ' ' . $dat_penunjang_hemodialisa['SATUAN']; ?></td>
		</tr>
<?php } ?>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>			
</table>					