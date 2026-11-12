<?php if(isset($_GET['idx'])){ 

$operasi_id = $_GET['idx'];
$sql_operasi = 'SELECT t_operasi.*,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN,
					m_jaminan.NAMA_JAMINAN,t_operasi.PEGAWAI_PELAKSANA_ID,m_pegawai2.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					m_jaminan2.NAMA_JAMINAN AS NAMA_JAMINAN2,t_irja.TANGGAL_DAFTAR,t_irja.ASAL_PASIEN_ID
					FROM t_operasi
					INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID) 
					INNER JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_operasi.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					INNER JOIN m_jaminan m_jaminan2 ON (t_operasi.JENIS_BAYAR_ID = m_jaminan2.JAMINAN_ID)
					WHERE t_operasi.OPERASI_ID = "' . $operasi_id . '"';
$get_operasi = mysql_query($sql_operasi) or die(mysql_error());
$dat_operasi = mysql_fetch_assoc($get_operasi);
$unit_id = $dat_operasi['NAMA_UNIT'];
$no_sjp = $dat_operasi['NO_SJP'];
$pemeriksa = $dat_operasi['NAMA_PEMERIKSA'];
$no_sep = $dat_operasi['NO_SEP'];

$jaminan = $dat_operasi['NAMA_JAMINAN'];
$jaminan2 = $dat_operasi['NAMA_JAMINAN2'];
$no_peserta = $dat_operasi['NO_PESERTA'];
$tgl_daftar = changeDateFormat($dat_operasi['TANGGAL_DAFTAR']);
$jenis_bayar_id = $dat_operasi['JENIS_BAYAR_ID'];  
$asal_pasien_id = $dat_operasi['ASAL_PASIEN_ID'];
$ket_asal_pasien = $dat_operasi['KET_ASAL_PASIEN'];
$dokter = $dat_operasi['NAMA_PEGAWAI'];
$unit = $dat_operasi['NAMA_UNIT'];
$asal_pasien = $dat_operasi['KET_ASAL_PASIEN'];  
$nomr = $dat_operasi['NOMR'];
	
$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];			
?>
<div style=" height:auto; padding:15px; ">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($nama_pasien==''){
				echo "-"; 
			} else {			
				echo $nama_pasien;
			}
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_lahir; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($tgl_lahir==''){
				echo "-"; 
			} else {			
				echo getUmurDaftar($tgl_lahir,$tgl_daftar);
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Umur</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($alamat==''){
				echo "-"; 
			} else {			
				echo $alamat;
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php 
			if ($nik==''){
				echo "-"; 
			} else {			
				echo $nik;
			}
			 
		?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dokter; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Asal Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Kiriman Dari</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Unit</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">Kamar Operasi</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php if(!empty($pemeriksa)){ echo $pemeriksa; }else{ echo '&nbsp;'; } ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Pemeriksa</div><br><br>
    <!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $jaminan2; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php 
			if ($no_peserta==''){
				echo "-"; 
			} else {			
				echo $no_peserta;
			}
			 
		?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php 
			if ($no_sep==''){
				echo "-"; 
			} else {			
				echo $no_sep;
			}
			 
		?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $no_sjp; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor SJP</div><br><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<a href="#" onclick="javascript : ubah_pendaftaran(<?php echo $_GET['idx']; ?>); return false;" ><input type="button" value="ubah" class="myButton" /></a>
			<?php if(isset($_GET['opt'])){ ?>
			<a href="index.php?link=bb3084792b827e72ba6a9da67bba222c" ><input type="button" value="tutup" class="myButton" /></a>
			<?php } else { ?>
			<a href="index.php?link=eb46dcb75725cf8b4ca7e751e4f655ee" ><input type="button" value="tutup" class="myButton" /></a>
			<?php } ?>
<div id="batal"></div>
</div>
</div>
<script language="JavaScript" >
function ubah_pendaftaran(idx){
	window.location = "index.php?link=<?php echo md5('pendaftaranformeditdaftaroperasi'); ?>&idx=<?php echo $_GET['idx']; ?>";			
}
</script> 
<?php } ?>