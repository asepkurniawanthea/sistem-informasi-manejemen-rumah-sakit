<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
if($ord == 'irj'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'irn'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'aps'){
	if(!isset($_GET['br'])){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NIK AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
	}else{
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NIK AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
	}	
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' .$dat_pasien['NAMA_PEGAWAI'] . ')';
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Order</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('kasirpembayaranradiologi'); ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$sql_tarif  = 'SELECT DISTINCT t_ipenunjang.NO_PENDAFTARAN,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang.ST_BAYAR,
				t_ipenunjang.USER_KASIR
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL 
				GROUP BY t_ipenunjang.NO_PENDAFTARAN,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang.NO_PEMBAYARAN,
				t_ipenunjang.ST_BAYAR,t_ipenunjang.USER_KASIR
				ORDER BY t_ipenunjang.TANGGAL_DAFTAR DESC';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th>No</th>
	<th>No Kwitansi</th>
	<th>Tanggal</th>
	<th colspan="2">Tarif</th>
	<th>Jumlah</th>
	<th>Harga</th>
	<th width="150">Register</th>
	<th width="150">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		$harga = $dat_tarif['HARGA'];
		$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
		$status = $dat_tarif['ST_BAYAR'];
		?>
		<tr>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td width="70" align="center"><?php echo $dat_tarif['NO_PENDAFTARAN']; ?></td>
		<td width="70" align="center"><?php echo $dat_tarif['TANGGAL_DAFTAR']; ?></td>
		<td colspan="2"><?php echo $dat_tarif['DESKRIPSI']; ?></td>
		<td>&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_ipenunjang_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang.NO_PENDAFTARAN = "' . $dat_tarif['NO_PENDAFTARAN'] . '"
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_detail['KUANTITI'] . ' ' . $dat_tarif_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php $y++; }
		?>
			<tr>
				<td colspan="7" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="2" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ ?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_radiologi(<?php echo $penunjang_id; ?>,<?php echo $dat_tarif['NO_PENDAFTARAN']; ?>,<?php echo $harga; ?>);return false;" />
					<?php } else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_radiologi(<?php echo $penunjang_id; ?>,<?php echo $dat_tarif['NO_PENDAFTARAN']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_radiologi(<?php echo $penunjang_id; ?>,<?php echo $no_bayar; ?>);return false;"/>
				<?php } } ?></td>
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
function bayar_radiologi(idx,no,harga){
 MyAjaxRequest('bayar','index.php?ajaxrequest=bayarradiologi&idx=' + idx + '&no=' + no + '&jm=' + harga);
 alert('Simpan Data Pembayaran Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
function print_kwitansi_radiologi(idx,no){
 window.open('http://localhost/nsimrs_print/print_pembayaran_radiologi.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
function batal_bayar_radiologi(idx, no){
	if(confirm(no +' Dibatalkan ?')){
		MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarradiologi&idx=' + idx + '&no=' + no);	
		alert('Simpan Data Pembatalan Berhasil.');
		window.location = '<?php echo currentURl(); ?>';
	}	
}
</script> 
<?php } ?>