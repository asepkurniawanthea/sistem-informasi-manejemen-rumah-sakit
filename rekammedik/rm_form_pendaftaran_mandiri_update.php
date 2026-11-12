<?php if(isset($_GET['id'])){ 
$id = $_GET['id'];

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());	

if(isset($_POST['simpan'])){
	$pasien_baru = '';
	if(!empty($_POST['nomr'])) $pasien_baru = "1";
	
	mysql_query('UPDATE t_daftar_irja_online
		SET NOMR = "' . $_POST['nomr'] . '",
		NAMA_PASIEN = "' . $_POST['nama_pasien'] . '",
		TMP_LAHIR = "' . $_POST['tmp_lahir'] . '",
		TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d-%m-%Y"),
		AGAMA = "' . $_POST['agama'] . '",
		JNS_KELAMIN = "' . $_POST['jns_kelamin'] . '",
		NAMA_IBU = "' . $_POST['nama_ibu'] . '",
		ALAMAT = "' . $_POST['alamat'] . '",
		NIK = "' . $_POST['nik'] . '",
		PASIEN_BARU = "' . $pasien_baru . '"
		WHERE DAFTAR_ID = "' . $_POST['id_daftar'] . '"') or die(mysql_error());
		
	mysql_query('UPDATE m_customer_member
		SET NOMR = "' . $_POST['nomr'] . '",
		NAMA_PASIEN = "' . $_POST['nama_pasien'] . '",
		TMP_LAHIR = "' . $_POST['tmp_lahir'] . '",
		TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d-%m-%Y"),
		AGAMA = "' . $_POST['agama'] . '",
		JNS_KELAMIN = "' . $_POST['jns_kelamin'] . '",
		NAMA_IBU = "' . $_POST['nama_ibu'] . '",
		ALAMAT = "' . $_POST['alamat'] . '",
		NIK = "' . $_POST['nik'] . '"
		WHERE MEMBER_ID= "' . $_POST['id_member'] . '"') or die(mysql_error());	
		
	if(!empty($_POST['nomr'])){
		mysql_query('UPDATE m_customer_member SET RD_NOMR = "1" WHERE MEMBER_ID= "' . $_POST['id_member'] . '"') or die(mysql_error());	
	}
	
	?>
	<script language="JavaScript" >
	alert('Simpan Data Berhasil.');
	</script>
	<?php
}	
	
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
	t.NO_ANTRIAN,d.STATUS_VERIF,d.YANKES
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
<form name="formupdate" method="post" action="<?php echo currentUrl(); ?>" >
<div style=" height:auto; padding:15px; ">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<!-- data pasien -->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="nomr" value="<?php echo $dat_daftar['NOMR']; ?>" class="text_dt" style="width:150px;" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="nama_pasien" value="<?php echo $dat_daftar['NAMA_PASIEN']; ?>" class="text_dt" size="30" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Tempat Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="tmp_lahir" value="<?php echo $dat_daftar['TMP_LAHIR']; ?>" class="text_dt" size="30" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="tgl_lahir" value="<?php echo $dat_daftar['TGL_LAHIR']; ?>" class="text_dt" style="width:150px;" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Lahir</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<select name="jns_kelamin" class="text_dt" style="width:160px;" >
		<option value="L" <?php if($dat_daftar['JNS_KELAMIN'] == 'L') echo 'selected'; ?> >Laki-laki</option>
		<option value="P" <?php if($dat_daftar['JNS_KELAMIN'] == 'P') echo 'selected'; ?> >Perempuan</option>
	</select>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<select name="agama" class="text_dt" style="width:160px;" >
		<option value="1" <?php if($dat_daftar['AGAMA'] == '1') echo 'selected'; ?> >Islam</option>
		<option value="2" <?php if($dat_daftar['AGAMA'] == '2') echo 'selected'; ?> >Kristen</option>
		<option value="3" <?php if($dat_daftar['AGAMA'] == '3') echo 'selected'; ?> >Katholik</option>
		<option value="4" <?php if($dat_daftar['AGAMA'] == '4') echo 'selected'; ?> >Hindu</option>
		<option value="5" <?php if($dat_daftar['AGAMA'] == '5') echo 'selected'; ?> >Budha</option>
		<option value="6" <?php if($dat_daftar['AGAMA'] == '6') echo 'selected'; ?> >Lain-lain</option>
	</select>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Agama</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Ibu</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="nama_ibu" value="<?php echo $dat_daftar['NAMA_IBU']; ?>" class="text_dt" size="30" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="nik" value="<?php echo $dat_daftar['NIK']; ?>" class="text_dt" size="30" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">NIK</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<textarea name="alamat" class="text_dt6"><?php echo $dat_daftar['ALAMAT']; ?></textarea>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br><br><br><br>
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
	<td width="20%" align="center">
		<input type="hidden" name="id_daftar" value="<?php echo $dat_daftar['DAFTAR_ID']; ?>" />
		<input type="hidden" name="id_member" value="<?php echo $dat_daftar['MEMBER_ID']; ?>" />
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		<a href="index.php?link=eafc635547580f953ff8a2e139da3c75&id=<?php echo $_GET['id']; ?>"><input type="button" value="selesai" class="myButton1" /></a>
	</td>
</tr>
</table>
</div>
</div>	
</form>
<?php } ?>