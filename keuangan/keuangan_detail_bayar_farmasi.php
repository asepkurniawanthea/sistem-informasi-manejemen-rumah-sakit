<?php if(isset($_GET['idx']) && isset($_GET['jns'])){
$idx = $_GET['idx'];
$jns = $_GET['jns'];

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
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter / Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($tgl_daftar)){ echo $tgl_daftar; }else{ echo '-'; } ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=5fe59ee6eb8f0179c56771050d685868');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">  
<?php
$sql_resep  = 'SELECT DISTINCT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN';				
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
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN'])){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			$sql_resep_detail = 'SELECT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM 
					t_farmasi_apotik_pengeluaran
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_penjualan_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.PENJUALAN_RESEP_DETAIL_ID = t_penjualan_resep_detail.PENJUALAN_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					GROUP BY t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID';	
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
							if($dat_resep['ST_VERIF'] != ''){
								echo 'Verif : ' . $dat_resep['ST_VERIF'];
							}else{ ?>
								<input type="button" class="myButton" value="verifikasi" onclick="verif_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
							<?php } 
					} ?>
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
function verif_farmasi(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=veriffarmasi&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
</script> 
<?php } ?>