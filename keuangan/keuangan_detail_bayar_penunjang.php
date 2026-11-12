<?php if(isset($_GET['idx']) and isset($_GET['no']) and isset($_GET['ord']) and isset($_GET['jnsp'])){
$idx = $_GET['idx'];
$no = $_GET['no'];
$ord = $_GET['ord'];
$jnsp = $_GET['jnsp'];

$sql_tanggal = 'SELECT DATE_FORMAT(CURRENT_DATE(),"%d/%m/%Y") AS TANGGAL FROM DUAL';
$get_tanggal = mysql_query($sql_tanggal) or die(mysql_error());
$dat_tanggal = mysql_fetch_assoc($get_tanggal);
$tanggal = $dat_tanggal['TANGGAL'];

$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID, t_ipenunjang.RAWAT_ID,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NO_PASIEN_PENUNJANG ELSE m_pasien.NOMR END AS NOMR,
	t_ipenunjang_tarif.TANGGAL_DAFTAR,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
	t_ipenunjang.NIK,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_PASIEN ELSE m_pasien.NAMA_PASIEN END AS NAMA_PASIEN,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.TGL_LAHIR ELSE m_pasien.TGL_LAHIR END AS TGL_LAHIR,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.JNS_KELAMIN ELSE m_pasien.JNS_KELAMIN END AS JNS_KELAMIN,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.ALAMAT ELSE m_pasien.ALAMAT END AS ALAMAT,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.INSTANSI_PENGIRIM ELSE m_unit_pengirim.NAMA_UNIT END AS NAMA_UNIT_PENGIRIM,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.PENGIRIM ELSE m_pegawai.NAMA_PEGAWAI END AS NAMA_PEGAWAI,
	t_ipenunjang_tarif.USER_PENDAFTARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang.JNS_ORDER,
	SUM(CASE WHEN t_ipenunjang_tarif.NO_PEMBAYARAN IS NULL THEN 1 ELSE 0 END) AS STATUS_PEMBAYARAN
	FROM t_ipenunjang
	INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID) 
	LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit m_unit_pengirim ON (t_ipenunjang.UNIT_ID = m_unit_pengirim.UNIT_ID)
	LEFT JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
	LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	WHERE t_ipenunjang_tarif.NO_SJP = "' . $no . '"
	AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"';
if($ord == 'irj') $qry_pasien = $qry_pasien . ' AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';				
if($ord == 'aps') $qry_pasien = $qry_pasien . ' AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';				

$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = changeDateFormat($dat_pasien['TANGGAL_DAFTAR']);

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=8f721e6002958a774fc7cb36848173fd');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php

if($ord == 'irj'){
		$sql_tarif  = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_ipenunjang_tarif.ST_VERIF
				FROM t_ipenunjang 
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_SJP = "' . $no . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ"	
				GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
}else if($ord == 'aps'){
		$sql_tarif  = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_ipenunjang_tarif.ST_VERIF
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_SJP = "' . $no . '"
				AND t_ipenunjang.JNS_ORDER = "APS"	
				GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
}		
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Kwitansi</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Tindakan/ Pemeriksaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="100px">Pembayaran</th>
	<th width="150px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		$harga = $dat_tarif['HARGA'];
		$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
		$status = $dat_tarif['ST_BAYAR'];
		$penj_id = $dat_tarif['RAWAT_ID'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			if($ord == 'irj'){
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			}else{
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" 
							AND t_ipenunjang.JNS_ORDER = "APS"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			}
			
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php $y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
						if($dat_tarif['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_penunjang(<?php echo $idx; ?>,'<?php echo $dat_tarif['NO_TARIF']; ?>','<?php echo $ord; ?>'); return false;" />
					<?php }
					} ?></td>
			</tr>
		<?php
	$i++;
	}	
?>  
</table>
</div>
</div>
<div id="bayar"></div>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}
function verif_penunjang(idx,no,ord){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifpenunjang&idx=' + idx + '&no=' + no + '&ord=' + ord);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
</script> 
<?php } ?>