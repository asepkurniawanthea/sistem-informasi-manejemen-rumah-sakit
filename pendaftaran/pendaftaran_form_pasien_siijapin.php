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

$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());	

if(isset($_POST['simpan']) and isset($_POST['verif'])){
	if(currentModul() == 'pendaftaran' or currentModul() == 'ipapp'){
		if($_POST['rd_nomr'] == '2' and $_POST['nomr'] == ''){ ?>
			<script language="JavaScript" >
			alert('Bukan Pasien Baru. No MR Belum Diisi.');
			</script>
		<?php 
		}else{
			mysql_query('UPDATE t_daftar_mcu
				SET TGL_RENCANA_KUNJUNGAN = STR_TO_DATE("' . $_POST['tgl_minta'] . '","%d-%m-%Y"),
				USER_VERIFIKASI = "' . $user_name . '"
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
				NIK = "' . $_POST['nik'] . '",
				PEKERJAAN = "' . $_POST['pekerjaan'] . '"
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
	}
}	
	
$qry_daftar = 'SELECT d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,m.NIK,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	61 AS KLINIK_ID,d.MCU_ID,d.DOKTER AS DOKTER_ID,
	"1" CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,m.PEKERJAAN
	FROM t_daftar_mcu d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE d.DAFTAR_ID = "' . $id . '"';
$get_daftar = mysql_query($qry_daftar) or die(mysql_error());
$dat_daftar = mysql_fetch_assoc($get_daftar);
?>
<form name="pendaftaranedit" method="post" action="<?php echo currentUrl(); ?>" >
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
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<input type="text" name="pekerjaan" value="<?php echo $dat_daftar['PEKERJAAN']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Pekerjaan</div><br><br><br><br><br>
	</div>


	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- rencana kunjungan -->
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Kunjungan</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="text" name="tgl_minta" id="tgl_daftar" value="<?php echo $dat_daftar['TGL_RENCANA_KUNJUNGAN']; ?>" class="text_dt" style="width:150px;" />
		<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/ Unit</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php if(isset($arr_unit[$dat_daftar['KLINIK_ID']])){
			echo $arr_unit[$dat_daftar['KLINIK_ID']];
		}else{
			echo '&nbsp;';
		}?>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<?php if(isset($arr_mcu[$dat_daftar['MCU_ID']])){
			echo $arr_mcu[$dat_daftar['MCU_ID']];
		}else{
			echo '&nbsp;';
		}?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Paket</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php if(isset($arr_dokter[$dat_daftar['DOKTER_ID']])){
			echo $arr_dokter[$dat_daftar['DOKTER_ID']];
		}else{
			echo '&nbsp;';
		}?>
	</div><br>
	</div>
	
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
<tr>
	<td width="20%" align="right">
		<input type="hidden" name="id_daftar" value="<?php echo $dat_daftar['DAFTAR_ID']; ?>" />
		<input type="hidden" name="id_member" value="<?php echo $dat_daftar['MEMBER_ID']; ?>" />
		<input type="hidden" name="rd_nomr" value="<?php echo $dat_daftar['RD_NOMR']; ?>" />
		<?php if((currentModul() == 'pendaftaran' or currentModul() == 'ipapp') 
				and $dat_daftar['USER_VERIFIKASI'] == ''){ ?>
			<input type="checkbox" name="verif" value="1" />&nbsp;Verif&nbsp;&nbsp;	
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
		<?php } ?>	
		<a href="index.php?link=498e1df887d6c3ae2d99b909814e36c1&id=<?php echo $_GET['id']; ?>"><input type="button" value="selesai" class="myButton1" /></a>
	</td>
</tr>
</table>
</div>
</div>	
</form>
<?php } ?>