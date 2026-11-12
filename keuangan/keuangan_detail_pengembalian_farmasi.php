<?php if(isset($_GET['idx']) && isset($_GET['jns'])){
$idx = $_GET['idx'];
$jns = $_GET['jns'];

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
$qry_pasien = 'SELECT t_farmasi_apotik_pengembalian_resep.NOMR,t_farmasi_apotik_pengembalian_resep.NO_RESEP,t_ranap_resep.RANAP_ID,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengembalian_resep.NAMA_PASIEN,t_farmasi_apotik_pengembalian_resep.ALAMAT,t_farmasi_apotik_pengembalian_resep.DOKTER_PENGIRIM,
					t_farmasi_apotik_pengembalian_resep.INSTANSI_PENGIRIM,t_ranap_resep.RANAP_RESEP_ID,
					t_farmasi_apotik_pengembalian_resep.JAMINAN_ID,t_farmasi_apotik_pengembalian_resep.PERSEN_JAMINAN,
					t_farmasi_apotik_pengembalian_resep.NO_PENGEMBALIAN,t_farmasi_apotik_pengembalian_resep.NO_RESEP
					FROM t_farmasi_apotik_pengembalian_resep
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengembalian_resep.NO_RESEP = t_ranap_resep.RANAP_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengembalian_resep.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID = "' . $_GET['idx'] . '"';					
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$pegawai_id = $dat_pasien['DOKTER_PENGIRIM'];
$nama_unit = $dat_pasien['INSTANSI_PENGIRIM'];
$ranap_id = $dat_pasien['NO_RESEP'];

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());
$sql_rawat = 'SELECT DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR, m_pasien.JNS_KELAMIN, m_pasien.ALAMAT, m_pasien.NIK,
			DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
			FROM t_irna  
			INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
			WHERE m_pasien.NOMR = "' . $nomr . '"
			AND t_irna.IRNA_ID = "' . $ranap_id . '"';
$get_rawat = mysql_query($sql_rawat) or die(mysql_error());			
$dat_rawat = mysql_fetch_assoc($get_rawat);

$tgl_lahir = $dat_rawat['TGL_LAHIR'];
$jns_kelamin = $dat_rawat['JNS_KELAMIN'];
$alamat = $dat_rawat['ALAMAT'];
$nik = $dat_rawat['NIK'];
$tgl_daftar = $dat_rawat['TANGGAL_DAFTAR'];
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
	<div style=" width:250px; float:right; text-indent:5px; " align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=a9a01ffdd1842959f1435ea0664bf10c');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">  
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$sql_resep  = 'SELECT DISTINCT t_farmasi_apotik_pengembalian_resep.NO_PENGEMBALIAN,m_jaminan.NAMA_JAMINAN,
					DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI,"%d/%m/%Y") AS TANGGAL_KEMBALI,
					t_farmasi_apotik_pengembalian_resep.NO_PEMBAYARAN,t_farmasi_apotik_pengembalian_resep.USER_PEMBAYARAN,
					t_farmasi_apotik_pengembalian_resep.JAMINAN_ID,t_farmasi_apotik_pengembalian_resep.ST_BATAL,
					t_farmasi_apotik_pengembalian_resep.ST_VERIF,FARMASI_PENGEMBALIAN_APOTIK_ID
					FROM t_farmasi_apotik_pengembalian_resep
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengembalian_resep.NO_RESEP = t_ranap_resep.RANAP_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengembalian_resep.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID = "' . $_GET['idx'] . '"';							
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
		$no_pengembalian = $dat_resep['NO_PENGEMBALIAN'];
		$no_bayar = $dat_resep['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep['NO_PENGEMBALIAN']; ?></td>
		<td align="center"><?php echo $dat_resep['TANGGAL_KEMBALI']; ?></td>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if(!empty($dat_resep['JAMINAN_ID'])){
						if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if($dat_resep['JAMINAN_ID'] != '1') {
							echo 'Lunas';
						}else if($dat_resep['JAMINAN_ID'] == '1' and !empty($dat_resep['NO_PEMBAYARAN'])){
							echo 'Lunas';
						}
					}else{
						if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN'])){
							echo 'Lunas';
						}
					} ?></td>
		</tr>
		<?php
			 $sql_resep_detail = 'SELECT t_farmasi_apotik_pengembalian_resep_detail.FARMASI_PENGEMBALIAN_ID,
								SUM(t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI) AS JUMLAH_KEMBALI,
								t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL,
								m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN
								FROM t_farmasi_apotik_pengembalian_resep_detail
								INNER JOIN t_farmasi_apotik_pengembalian_resep ON (t_farmasi_apotik_pengembalian_resep_detail.FARMASI_PENGEMBALIAN_ID = t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID)
								INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengembalian_resep_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
								INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
								WHERE FARMASI_PENGEMBALIAN_ID = "' . $_GET['idx'] . '" 
								AND t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI > 0
								GROUP BY t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL,
								m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN';
			$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20px" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KEMBALI']); ?></td>
				<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KEMBALI'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>	
				</tr>
				<?php
			$y++; $total = $total + ($dat_resep_detail['JUMLAH_KEMBALI'] * $dat_resep_detail['HARGA_JUAL']); 
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="3" align="center">
					<?php if($dat_resep['ST_BATAL'] != '1'){
							if($dat_resep['ST_VERIF'] != ''){
								echo 'Verif : ' . $dat_resep['ST_VERIF'];
							}else{ ?>
								<input type="button" class="myButton" value="verifikasi" onclick="verif_pengembalian_farmasi(<?php echo $dat_resep['FARMASI_PENGEMBALIAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGEMBALIAN']; ?>);return false;" />
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

function verif_pengembalian_farmasi(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifpengembalianfarmasi&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
</script> 
<?php } ?>