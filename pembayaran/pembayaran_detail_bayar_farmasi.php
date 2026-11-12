<?php if(isset($_GET['idx']) && isset($_GET['jns'])){
$idx = $_GET['idx'];
$jns = $_GET['jns'];

if($jns == '1'){
$qry_pasien = 'SELECT t_irja.IRJA_ID AS FARMASI_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,m_unit.NAMA_UNIT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
}else if($jns == '2'){
$qry_pasien = 'SELECT t_irna.IRNA_ID AS FARMASI_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,"" AS UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,m_ruang.NAMA_RUANG AS NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
}else{
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
$qry_pasien = 'SELECT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID AS FARMASI_ID,t_farmasi_apotik_pengeluaran.NIK AS NOMR,
				"" AS PEGAWAI_ID,"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,"" AS UNIT_ID,"" AS NAMA_JAMINAN,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN AS NAMA_PASIEN,
				"" AS TGL_LAHIR,"" AS JNS_KELAMIN,t_farmasi_apotik_pengeluaran.ALAMAT,"" AS NIK,
				"" AS PASIEN_MASUK,t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM AS NAMA_UNIT,
				"" AS TANGGAL_DAFTAR
				FROM t_farmasi_apotik_pengeluaran
				WHERE t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '"';
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

$irja_id = $dat_pasien['FARMASI_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

$arr_cash = getCash();
$arr_rekening = getRekening();

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Poliklinik/ Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($tgl_daftar)){ echo $tgl_daftar; }else{ echo '-'; } ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('kasirpembayaranfarmasi'); ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">  
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

if($jns == '1'){
	$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';				
}else if($jns == '2'){
	$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP';				
}else{
	$sql_resep  = 'SELECT DISTINCT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN';				
}				
$get_resep = mysql_query($sql_resep) or die(mysql_error());				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Resep</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Persediaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="100px">Pembayaran</th>
	<th width="150px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_resep = mysql_fetch_array($get_resep)){
		$no_resep = $dat_resep['NO_RESEP'];
		$status = $dat_resep['ST_BATAL'];
		$no_bayar = $dat_resep['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep['NO_RESEP']; ?></td>
		<td align="center"><?php echo $dat_resep['TANGGAL_KELUAR']; ?></td>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; 
		if($dat_resep['KODE_CASH'] != '') echo ' /' . $dat_resep['KODE_CASH'];
		if($dat_resep['KODE_REKENING'] != '') echo ' /' . $dat_resep['KODE_REKENING']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN']) and (in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan()) or $dat_resep['JAMINAN_ID'] == '')){
							echo 'Lunas';
						}else if(!in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan()) and $dat_resep['JAMINAN_ID'] != ''){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			if($jns == '1'){
			 $sql_resep_detail = 'SELECT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_rajal_resep.NO_RESEP DESC';
			}else if($jns == '2'){
			$sql_resep_detail = 'SELECT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_ranap_resep.NO_RESEP DESC';
			}else{
			$sql_resep_detail = 'SELECT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_penjualan_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.PENJUALAN_RESEP_DETAIL_ID = t_penjualan_resep_detail.PENJUALAN_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID';	
			}
			$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20px" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>	
				</tr>
				<?php
			$y++; $total = $total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); 
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="3" align="center">
				<?php if($dat_resep['ST_BATAL'] != '1'){
						if(in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan()) or $dat_resep['JAMINAN_ID'] == ''){
							if(empty($dat_resep['NO_PEMBAYARAN'])){ 

								echo '<select id="fr_ch_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="fr_rk_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
						?>
								<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
						<?php }else{ 
						?>
							<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
							<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
							<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
							<option value=""></option>
							<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
							</select>
						<?php }
					}else{ 
					//jaminan
					?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
					<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php }	} ?>
				</td>
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

function bayar_farmasi(idx,no){
	var kode_cash = document.getElementById("fr_ch_" + no).value;
 	var kode_rekening = document.getElementById("fr_rk_" + no).value;
 	if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 		MyAjaxRequest('bayar','index.php?ajaxrequest=bayarfarmasi&idx=' + idx + '&no=' + no + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 		alert('Simpan Data Pembayaran Berhasil.');
 		window.location = "<?php echo currentURl(); ?>";
 	}	
}

function batal_bayar_farmasi(idx, no){
	var jns_batal = document.getElementById("batal_fms_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarfarmasi&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}
	}	
}

function print_kwitansi_farmasi(idx){
	window.open('http://localhost/nsimrs_print/print_pembayaran_farmasi.php?idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
</script> 
<?php } ?>