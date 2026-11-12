<?php
$pegawai_id = '';
$asal_pasien_id = '';
$ket_asal_pasien = '';
$unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
$pasien_masuk = '';
$asal_pasien = '';

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_pasien_masuk.php');
	
if(isset($_GET['idx'])){	
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,m_asal_pasien.KET_ASAL_PASIEN AS ASAL_PASIEN,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
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

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
$asal_pasien = $dat_pasien['ASAL_PASIEN'];

$no_telepon = $dat_pasien['NO_TELEPON'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
?>
<div style=" height:auto; padding:15px;">
<form name="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="pasien_masuk" id="pasien_masuk" value="<?php echo $pasien_masuk; ?>" />
	
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
       <?php include('pasien/pasien_view_short.php'); ?>
    

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Pasien</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($ket_asal_pasien)){ echo $ket_asal_pasien; } else { echo '&nbsp;'; } ?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Keterangan Asal Pasien</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter DPJP</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value="" > - </option>
				<?php echo getDokter($pegawai_id, $unit_id); ?>
		</select>
    </div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
    </div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; " align="right">
		<!--<input type="checkbox" name="pasien_batal" value="1" />Batal, Keterangan
		&nbsp;<input type="text" name="keterangan_batal" size="45" class="text_dt" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
		<input type="submit" value="simpan" class="myButton1" />
    </div>       
</form>

</div>
<?php } ?>