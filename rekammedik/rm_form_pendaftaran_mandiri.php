<?php if(isset($_GET['id'])){ 
$id = $_GET['id'];

$arr_unit = array();
$arr_unit[0] = '-';
$get_unit = mysql_query('SELECT * FROM m_unit') or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
		$arr_unit[$dat_unit['UNIT_ID']] = $dat_unit['NAMA_UNIT'];
}

$arr_jaminan = array();
$arr_jaminan[0] = '-';
$get_jaminan = mysql_query('SELECT * FROM m_jaminan') or die(mysql_error());
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
		$arr_jaminan[$dat_jaminan['JAMINAN_ID']] = $dat_jaminan['NAMA_JAMINAN'];
}

$arr_dokter = array();
$get_dokter = mysql_query('SELECT * FROM m_pegawai WHERE TIPE_PEGAWAI_ID IN (1,2,3,4,18)') or die(mysql_error());
$arr_dokter[0] = '-';
while($dat_dokter = mysql_fetch_array($get_dokter)){
		$arr_dokter[$dat_dokter['PEGAWAI_ID']] = $dat_dokter['NAMA_PEGAWAI'];
}

$arr_mcu = array();
$get_mcu = mysql_query('SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"') or die(mysql_error());
$arr_mcu[0] = '-';
while($dat_mcu = mysql_fetch_array($get_mcu)){
		$arr_mcu[$dat_mcu['TARIF_ID']] = $dat_mcu['NAMA_TARIF'];
}

$arr_agama = array(
	'1' => 'Islam',
	'2' => 'Kristen',
	'3' => 'Katholik',
	'4' => 'Hindu',
	'5' => 'Budha',
	'6' => 'Lain-lain'
);

$arr_cash = getCash();
$arr_rekening = getRekening();

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());	
	
$qry_daftar = 'SELECT d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	d.NOMR,d.NAMA_PASIEN,d.TMP_LAHIR,
	DATE_FORMAT(d.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	d.AGAMA,d.JNS_KELAMIN,d.NAMA_IBU,d.ALAMAT,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	d.KLINIK_ID,d.MCU_ID,d.DOKTER_ID,
	d.HANYA_AMBIL_RESEP,d.CARA_BAYAR,d.METODE_BAYAR,d.JUMLAH_BAYAR,d.STATUS_BAYAR,
	d.NO_CONTACT,c.EMAIL,m.RD_NOMR,m.POTO_KARTU,m.POTO_KTP,m.POTO_KK,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y %H:%i:%s") AS TGL_DAFTAR,
	d.YANKES,d.JAM_LAYANAN,d.NO_BPJS,d.NIK,d.POTO_RUJUKAN,d.POTO_PEMBAYARAN,
	t.NO_ANTRIAN,d.STATUS_VERIF,d.YANKES,d.NO_TARIF,d.TRX_ID
	FROM t_daftar_irja_online d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	INNER JOIN t_trans t
	ON (d.DAFTAR_ID = t.DAFTAR_ID)
	WHERE d.DAFTAR_ID = "' . $id . '"';
$get_daftar = mysql_query($qry_daftar) or die(mysql_error());
$dat_daftar = mysql_fetch_assoc($get_daftar);
?>
<div style=" height:auto; padding:15px; ">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- data pasien -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
<?php if($dat_daftar['NOMR'] == ''){
		if($dat_daftar['RD_NOMR'] == '2') echo 'Lupa NOMR';
		if($dat_daftar['RD_NOMR'] == '3') echo 'Pasien Baru';
	}else{
		echo formatNoMR($dat_daftar['NOMR']); 
} ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $dat_daftar['NAMA_PASIEN']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Tempat Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dat_daftar['TMP_LAHIR']; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $dat_daftar['TGL_LAHIR']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Lahir</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($dat_daftar['JNS_KELAMIN']); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo ((isset($arr_agama[$dat_daftar['AGAMA']])) ? $arr_agama[$dat_daftar['AGAMA']] : ''); ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Agama</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Ibu</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dat_daftar['NAMA_IBU']; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $dat_daftar['ALAMAT']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dat_daftar['NIK']; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">No Telepon</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php $no_telepon = $dat_daftar['NO_CONTACT'];
				$no_telepon_baru = '';
				if(strlen($no_telepon) >= 10){
					if(substr($no_telepon,0,2) == '08'){
						$no_telepon_baru = '628' . substr($no_telepon,2,strlen($no_telepon) - 2);
					}else if(substr($no_telepon,0,4) == '+628'){
						$no_telepon_baru = substr($no_telepon,1,strlen($no_telepon) - 1);	
					}else{
						$no_telepon_baru = $no_telepon;
					}	
				}	
				if(substr($no_telepon_baru,0,3) == '628'){
					echo '<div onclick="openwhatsapp(' . $no_telepon_baru . ');"><img src="image/whatsapp.png" width="15" height="15" style="float:left;">&nbsp;' . $no_telepon . '</div>';	
				}else{
					echo $no_telepon;
				} ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $dat_daftar['EMAIL']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Email</div><br>
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- rencana kunjungan -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Tgl Rencana Kunjungan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dat_daftar['TGL_RENCANA_KUNJUNGAN']; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $dat_daftar['TGL_DAFTAR']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Tgl Daftar Online</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik Tujuan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo ((isset($arr_unit[$dat_daftar['KLINIK_ID']])) ? $arr_unit[$dat_daftar['KLINIK_ID']] : ''); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo ((isset($arr_dokter[$dat_daftar['DOKTER_ID']])) ? $arr_dokter[$dat_daftar['DOKTER_ID']] : ''); ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Paket MCU</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo ((isset($arr_mcu[$dat_daftar['MCU_ID']])) ? $arr_mcu[$dat_daftar['MCU_ID']] : '-'); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo (($dat_daftar['HANYA_AMBIL_RESEP'] == '1') ? '&radic;' : '-'); ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Hanya Ambil Resep</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Estimasi Dilayani/ Antrian</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dat_daftar['JAM_LAYANAN'] . '/ ' . $dat_daftar['NO_ANTRIAN']; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php
	if($dat_daftar['YANKES'] == '1') echo 'YANKES';
	if($dat_daftar['YANKES'] == '2') echo 'Sitanala SIAP';
	if($dat_daftar['YANKES'] == '3') echo 'JKN Mobile';
	if($dat_daftar['YANKES'] == '') echo '-';
?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Daftar Melalui</div><br>
</div>

<?php if($dat_daftar['CARA_BAYAR'] == '12'){ ?> 

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- pembayaran -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Jumlah Tagihan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">Rp. <?php echo currFormat($dat_daftar['JUMLAH_BAYAR']); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo ((isset($arr_jaminan[$dat_daftar['CARA_BAYAR']])) ? $arr_jaminan[$dat_daftar['CARA_BAYAR']] : ''); 
			if($dat_daftar['METODE_BAYAR'] != '') echo '-' . $dat_daftar['METODE_BAYAR']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Metode Pembayaran</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">No Kartu Peserta</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left">
<input type="text" name="no_jkn" id="no_jkn" value="<?php echo $dat_daftar['NO_BPJS']; ?>" class="text_dt"/>
<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
	<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
	<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
	<image src="/nsimrs/sep/image/loading_circle_green.gif" width="22" height="22" align="top" border="0" id="loader" style="display:none" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
</div>

<?php }else{ ?>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- pembayaran -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Jumlah Tagihan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">Rp. <?php echo currFormat($dat_daftar['JUMLAH_BAYAR']); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo ((isset($arr_jaminan[$dat_daftar['CARA_BAYAR']])) ? $arr_jaminan[$dat_daftar['CARA_BAYAR']] : ''); 
			if($dat_daftar['METODE_BAYAR'] != '') echo '-' . $dat_daftar['METODE_BAYAR']; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Metode Pembayaran</div><br>
</div>

<?php } ?>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- status -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Status Pembayaran</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if($dat_daftar['CARA_BAYAR'] == '1'){ 
					if($dat_daftar['STATUS_BAYAR'] == '1') echo 'Lunas'; 
					if($dat_daftar['STATUS_BAYAR'] == '') echo 'Menunggu Bayar'; 
					if($dat_daftar['STATUS_BAYAR'] == '2') echo 'Konfirmasi Bayar'; 
				}else{
					echo 'Lunas';
			}?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Status Verifikasi Data</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo (($dat_daftar['STATUS_VERIF'] == '1') ? 'Sudah' : 'Belum'); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
<tr>
	<td align="right">
		<?php
			if($dat_daftar['POTO_KTP'] != ''){
				$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['POTO_KTP'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['POTO_KTP'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Poto KTP"></a>';
			}
			
			if($dat_daftar['POTO_KK'] != ''){
				$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['POTO_KK'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['POTO_KK'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Poto KK"></a>';
			}
			
			if($dat_daftar['CARA_BAYAR'] != '1' and $dat_daftar['POTO_KARTU'] != ''){
				$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['POTO_KARTU'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['POTO_KARTU'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Poto Kartu Peserta"></a>';
			}
			
			if($dat_daftar['POTO_RUJUKAN'] != ''){
				$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['POTO_RUJUKAN'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['POTO_RUJUKAN'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Poto Surat Rujukan"></a>';
			}
			
			if($dat_daftar['POTO_PEMBAYARAN'] != ''){
				$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['POTO_PEMBAYARAN'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['POTO_PEMBAYARAN'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Poto Surat Rujukan"></a>';
			}
		?>	
	</td>
	<td width="30%" align="center">
		<?php if(currentModul() == 'ipapp' or currentModul() == 'rekam medik' or currentModul() == 'pendaftaran'){ ?>
		<input type="checkbox" name="verif" id="verif" value="1" onclick="verif_opt();" <?php if($dat_daftar['STATUS_VERIF'] == '1') echo 'checked'; ?> />&nbsp;Verif&nbsp;&nbsp;
		<a href="index.php?link=492225d11bcbc01707ed58c63b4decb9&id=<?php echo $id; ?>"><input type="button" value="ubah data" class="myButton1" /></a>
		<?php } ?>
		
		<?php if(currentModul() == 'kasir' and $dat_daftar['STATUS_BAYAR'] != '1'){ ?>
		<input type="button" value="bayar" class="myButton1" onclick="lunas_opt();" />
		<select id="rj_ch" class="text_dt" style="width:60px;" >
		<?php foreach ($arr_cash as $row) { ?>
		<option value="<?php echo $row['kode']; ?>"><?php echo $row['kode']; ?></option>
		<?php } ?>
		</select>
		<select id="rj_rk" class="text_dt" style="width:60px;" >
		<option value=""> - </option>
		<?php foreach ($arr_rekening as $row) { ?>
		<option value="<?php echo $row['kode']; ?>"><?php echo $row['kode']; ?></option>
		<?php } ?>
		</select>&nbsp;&nbsp;
		<?php } ?>
		<?php if(currentModul() == 'kasir' and $dat_daftar['STATUS_BAYAR'] == '1'){ ?>
		<?php if(currentModul() == 'kasir' and $dat_daftar['MCU_ID'] == ''){ ?>
		<input type="button" value="print" class="myButton1" onclick="print_kwitansi('<?php echo $id; ?>','<?php echo $dat_daftar['NO_TARIF']; ?>');" />
		<?php }else{ ?>
		<input type="button" value="print" class="myButton1" onclick="print_kwitansi_mcu('<?php echo $id; ?>','<?php echo $dat_daftar['NO_TARIF']; ?>');" />
		<?php } ?>
		<?php } ?>
		<a href="index.php?link=46582c28134ff2c8ba5590e096360f14"><input type="button" value="selesai" class="myButton1" /></a>
	</td>
</tr>
</table>
</div>
</div>
<div id="msg_ta"></div>
<script language="javascript">
function openwhatsapp(phone){
	window.open('https://wa.me/' + phone);
}	

function verif_opt(){
	if(document.getElementById('verif').checked){
		MyAjaxRequest('msg_ta','index.php?ajaxrequest=daftaronlineverif&idx=<?php echo $id; ?>');
		return false;
		alert('Simpan Data Verif Berhasil.');
	}
}

function lunas_opt(){
	var kode_cash = document.getElementById("rj_ch").value;
	var kode_rekening = document.getElementById("rj_rk").value;
	if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
		MyAjaxRequest('msg_ta','index.php?ajaxrequest=daftaronlinelunas&idx=<?php echo $id; ?>&ch=' + kode_cash + '&rk=' + kode_rekening);
		return false;
		
		alert('Simpan Data Lunas Berhasil.');
		window.location = "<?php echo currentURl(); ?>";
	}
}

function print_kwitansi(idx,no){
  window.open('http://localhost/nsimrs_print/print_pembayaran_irja.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}

function print_kwitansi_mcu(idx,no){
	window.open('http://localhost/nsimrs_print/print_pembayaran_mcu.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');		
}
</script>	
<?php } ?>