<?php
$pegawai_id = '';
$pasien_masuk = '';
$ruang_id = '';
$tmp_tidur = '';
	
if(isset($_GET['idx'])){	
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,t_irna.PEGAWAI_RAWAT_ID,
				t_irna.PEGAWAI_RAWAT_ID_2,t_irna.PEGAWAI_RAWAT_ID_3,t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,t_irna.NO_TMP_TIDUR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.ST_PINDAH,t_irna.LOG_PINDAH_ID,t_irna.DIAGNOSA_AWAL
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$diagnosa = $dat_pasien['DIAGNOSA_AWAL'];

$irna_id = $dat_pasien['IRNA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$pegawai_rawat_id = $dat_pasien['PEGAWAI_RAWAT_ID'];
$pegawai_rawat_id_2 = $dat_pasien['PEGAWAI_RAWAT_ID_2'];
$pegawai_rawat_id_3 = $dat_pasien['PEGAWAI_RAWAT_ID_3'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
$ruang_id = $dat_pasien['RUANG_ID'];
$tmp_tidur = $dat_pasien['NO_TMP_TIDUR'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$st_pindah = $dat_pasien['ST_PINDAH'];
$log_pindah_id = $dat_pasien['LOG_PINDAH_ID'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_edit_pasien_masuk.php');
?>
<div style=" height:auto; padding:15px;">
<form name="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="pasien_masuk" id="pasien_masuk" value="<?php echo $pasien_masuk; ?>" />
	<input type="hidden" name="log_pindah_id" id="log_pindah_id" value="<?php echo $log_pindah_id; ?>" />
	
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
       <?php include('pasien/pasien_view_short.php'); ?>
		
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $diagnosa; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="ruang_id" id="ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur','index.php?ajaxrequest=ctmptidur&ruang_id=' + this.value);return false;" >
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
		</select></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="ctmptidur">
		<select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getTempatTidurEdit($ruang_id,$tmp_tidur); ?>
		</select>
	</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Tempat Tidur</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Penanggungjawab</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_id); ?>
			</select>
    </div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><select name="pegawai_rawat_id" id="pegawai_rawat_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id); ?>
			</select></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter Yang Merawat</div><br><br>
	
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><select name="pegawai_rawat_id_2" id="pegawai_rawat_id_2" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_2); ?>
			</select></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><select name="pegawai_rawat_id_3" id="pegawai_rawat_id_3" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_3); ?>
			</select></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
    </div>
	
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; " align="right">
		<a href="index.php?link=<?php echo md5('ranappasienperiksa'); ?>" >
		<input type="button" value="tutup" class="myButton1" />
		</a>
		<input type="submit" value="simpan" class="myButton1" />
    </div>       
   
</form>

</div>
<?php } ?>