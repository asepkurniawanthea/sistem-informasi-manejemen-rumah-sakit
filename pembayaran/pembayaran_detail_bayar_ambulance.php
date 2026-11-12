<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];

$sql_tanggal = 'SELECT DATE_FORMAT(CURRENT_DATE(),"%d/%m/%Y") AS TANGGAL FROM DUAL';
$get_tanggal = mysql_query($sql_tanggal) or die(mysql_error());
$dat_tanggal = mysql_fetch_assoc($get_tanggal);
$tanggal = $dat_tanggal['TANGGAL'];

$idx = $_GET['idx'];
if($ord == 'irj'){
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,m_unit.NAMA_UNIT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
}else{
	$qry_pasien = 'SELECT t_irna.IRNA_ID AS IRJA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,CONCAT(m_ruang.NAMA_RUANG," ",t_irna.KELAS_RAWAT) AS NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.NO_SEP,t_irna.ST_PULANG,
				DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s") AS TANGGAL_PULANG,
				t_irna.JENIS_BAYAR_ID
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
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
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$userkasir = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">
	<a href="index.php?link=<?php echo md5('kasirformbayarambulance'); ?>&idx=<?php echo $idx; ?>&ord=<?php echo $ord; ?>&notjs=1" ><input type="button" value="tambah pembayaran" class="myButton1"></a>
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('kasirpembayaranambulance'); ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$sql_tarif  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.NO_PEMBAYARAN,
				SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
				t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_ambulance_tarif.KODE_CASH,t_ambulance_tarif.KODE_REKENING
				FROM t_ambulance_tarif 
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = UPPER("' . $ord . '")
				GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
				t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
				ORDER BY t_ambulance_tarif.TGL_TARIF';		
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Kwitansi</th>
	<th width="70px">Tanggal</th>
	<th width="70px">Tujuan</th>
	<th colspan="2">Tindakan</th>
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
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif['TANGGAL_DAFTAR']; ?></td>
		<td colspan="6"><?php echo $dat_tarif['GMAP_DIRECTION']; ?></td>
		<td align="center"><?php echo $dat_tarif['NAMA_JAMINAN']; 
		if($dat_tarif['KODE_CASH'] != '') echo ' /' . $dat_tarif['KODE_CASH'];
		if($dat_tarif['KODE_REKENING'] != '') echo ' /' . $dat_tarif['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ambulance_tarif.TARIF_ID,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,m_tarif.NAMA_TARIF
							FROM t_ambulance_tarif
							INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" 
							AND t_ambulance_tarif.JNS_ORDER = "' . strtoupper($ord) . '"
							AND t_ambulance_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
							GROUP BY t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td colspan="2"><?php echo $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
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
				<td colspan="9" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="ab_ch_' . $dat_tarif['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="ab_rk_' . $dat_tarif['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>,<?php echo $harga; ?>,'<?php echo $ord; ?>');return false;" />
					<?php  } else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_ambulance(<?php echo $idx; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>,'<?php echo $ord; ?>');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>,'<?php echo $ord; ?>');return false;"/>&nbsp;
					<select name="batal_amb_<?php echo $dat_tarif['NO_TARIF']; ?>" id="batal_amb_<?php echo $dat_tarif['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
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
function bayar_ambulance(idx,no,harga,ord){
 var kode_cash = document.getElementById("ab_ch_" + no).value;
 var kode_rekening = document.getElementById("ab_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){		
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarambulance&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ord=' + ord + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }	
}
function print_kwitansi_ambulance(idx,no,ord){
 window.open('http://localhost/nsimrs_print/print_pembayaran_ambulance.php?idx=' + idx + '&no=' + no + '&ord=' + ord + '&user=<?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
function batal_bayar_ambulance(idx, no,jn){
	var jns_batal = document.getElementById("batal_amb_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarambulance&idx=' + idx + '&no=' + no + '&ord=' + jn + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}
</script> 
<?php } ?>