<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,t_irja.NO_PENDAFTARAN,
				CASE WHEN t_irja.MCU = "mcu1" THEN "Medical Checkup Paket A"
					WHEN t_irja.MCU = "mcu2" THEN "Medical Checkup Paket B" 
					WHEN t_irja.MCU = "mcu3" THEN "Medical Checkup Paket C" 
					WHEN t_irja.MCU = "mcu4" THEN "Medical Checkup Paket D" 
					WHEN t_irja.MCU = "mcu5" THEN "Medical Checkup Paket E" 
					WHEN t_irja.MCU = "mcu6" THEN "Medical Checkup Paket F" 
					WHEN t_irja.MCU = "mcu7" THEN "Medical Checkup Paket G" 
				END AS NAMA_UNIT,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$no_pendaftaran = $dat_pasien['NO_PENDAFTARAN'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$userkasir = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Poliklinik</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:450px; float:right; text-indent:5px; " align="right">
	<?php 
	$kasir = 'umum'; 
	$link = 'kasirpembayaranpoliklinik';
	if(isset($_GET['kasir'])){
		$kasir = $_GET['kasir'];
		if($kasir == 'igd') $link = 'kasirpembayaranigd';
		if($kasir == 'kusta') $link = 'kasirpembayarankusta';
	}
?>
	<!--<a href="index.php?link=<?php echo md5('kasirformtindakan'); ?>&idx=<?php echo $irja_id; ?>&kasir=<?php echo $kasir; ?>" ><input type="button" value="tambah tindakan" class="myButton1"></a>
	<a href="index.php?link=<?php echo md5('kasirformpemeriksaanpenunjang'); ?>&idx=<?php echo $irja_id; ?>&ord=irj&kasir=<?php echo $kasir; ?>" ><input type="button" value="tambah penunjang" class="myButton1"></a>-->
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5($link); ?>&kasir=<?php echo $kasir; ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$sql_tarif  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
				t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_irja_tarif 
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL
				GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
$dat_tarif = mysql_fetch_assoc($get_tarif);
$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
$status = $dat_tarif['ST_BAYAR'];
$nomor_tarif_irja = $dat_tarif['NO_TARIF'];
$bayar_total = 0;	
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
  <tr>
	<td align="center">&nbsp;</td>
	<td align="center">
	<!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="t-<?php echo $dat_tarif['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif['NO_TARIF']; ?></td>
	<td align="center"><?php echo $dat_tarif['TGL_TARIF']; ?></td>
	<td colspan="5"><?php echo $nama_unit; ?></td>
	<td align="center"><?php echo $dat_tarif['NAMA_JAMINAN']; ?></td>
	<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
	<td align="center"><?php echo $status; ?></td>
  </tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09"
								THEN (SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID)
							ELSE "" END AS NAMA_DOKTER	
							FROM t_irja_tarif
							INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE (t_irja_tarif.IRJA_ID = "' . $idx . '"
									OR t_irja_tarif.IRJA_ID = (SELECT x.IRJA_ID FROM t_irja x WHERE x.NO_PENDAFTARAN = "' . $no_pendaftaran . '"
									AND x.IRJA_ID <> "' . $idx . '")) 
							AND t_irja_tarif.NO_TARIF IS NOT NULL
							GROUP BY t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php 
			$nama_tarif = $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')';
			if(!empty($dat_tarif_detail['NAMA_DOKTER'])) $nama_tarif = $nama_tarif . ', ' .$dat_tarif_detail['NAMA_DOKTER']; 
			echo $nama_tarif; ?></td>
			<td align="right"><?php echo $dat_tarif_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI']); 
			$bayar_total = $bayar_total + ($dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI']);
			?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
			<?php $y++; }
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
							AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
							AND t_ipenunjang_tarif.ST_BATAL IS NULL	
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			while($dat_tarif_penunjang_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI']); 
			$bayar_total = $bayar_total + ($dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php $y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Tindakan/ Pemeriksaan Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ ?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_mcu(<?php echo $idx; ?>,'<?php echo $no_pendaftaran; ?>');return false;" />
				<?php } } ?>
				</td>
			</tr> 
</table>
</div>
</div>
<div id="bayar"></div>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}
function bayar_mcu(idx,no_pendaftaran){
 MyAjaxRequest('bayar','index.php?ajaxrequest=bayarmcu&idx=' + idx + '&no=' + no_pendaftaran);
 alert('Simpan Data Pembayaran Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
</script> 
<?php } ?>