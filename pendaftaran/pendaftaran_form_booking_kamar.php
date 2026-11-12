<?php
$idx = '';
$ruang_id = '';
$diagnosa_awal = '';
$emergency = '';
$dw_an_by = '';
$lk_pr = '';
$tgl_booking = '';

if (isset($_GET['idx'])) {
    $idx = $_GET['idx'];
	$sql_kunjungan = 'SELECT t_irja.*,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN,
					m_jaminan.NAMA_JAMINAN,
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE IRJA_ID = "' . $idx . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
	$asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
	$unit = $dat_kunjungan['NAMA_UNIT'];
	$asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$jaminan = $dat_kunjungan['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_kunjungan['JENIS_BAYAR_ID'];
	$nomr = $dat_kunjungan['NOMR'];
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	
	$sql_diagnosa = 'SELECT CONCAT(t_irja_diagnosa.ICD_CODE," ",t_irja_diagnosa.DIAGNOSA) AS DIAGNOSA
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0';
	$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
	$dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
	$diagnosa_awal = $dat_diagnosa['DIAGNOSA'];
}	

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];

if (isset($_POST['idx'])) {
	$idx = $_POST['idx'];
	$nomr = $_POST['nomr'];
	$ruang_id = $_POST['ruang_id'];
	if(isset($_POST['emergency']))
		$emergency = $_POST['emergency'];
	if(isset($_POST['dw_an_by']))
		$dw_an_by = $_POST['dw_an_by'];
	$lk_pr = $_POST['lk_pr'];
	
    mysql_query('INSERT INTO t_irna_booking_kamar(IRNA_ID,NOMR,TANGGAL_BOOKING,RUANG_ID,EMERGENCY,LK_PR,DW_AN_BY,USER_PENDAFTARAN)
				VALUES("' . $idx . '","' . $nomr . '",NOW(),
				"' . $ruang_id . '","' . $emergency . '",
				"' . $lk_pr . '","' . $dw_an_by . '",
				"' . $user_name . '")') or die(mysql_error());
?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('pendaftaranbookingkamar'); ?>";
 </script> 
<?php				
}
?>
<div style=" height:auto; padding:15px; ">
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
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
				echo getUmur($tgl_lahir);
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
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa Awal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:750px; float:left; text-indent:5px; " align="left">
		<?php echo $diagnosa_awal; ?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;
	</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- -->
			

			
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="ruang_id" id="ruang_id" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<?php echo getRuangRawat($ruang_id); ?>
				</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 

				<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:left; ">&nbsp;</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
						<input type="radio" name="dw_an_by" value="DW" >Dewasa&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="dw_an_by" value="AN" >Anak&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="dw_an_by" value="BY" >Bayi</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>  	

				<div style=" width:250px; float:left; text-indent:25px; " align="left">Emergency</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
					<input type="radio" name="emergency" value="Emergency" />&nbsp;Emergency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="emergency" value="Non Emergency" />&nbsp;Non Emergency
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>	    

   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
	<input type="submit" name="simpan" value="simpan" class="myButton1" />

    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="diagnosa_awal" id="diagnosa_awal" value="<?php echo $diagnosa_awal; ?>" />
	<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
	<input type="hidden" name="lk_pr" id="lk_pr" value="<?php echo $jns_kelamin; ?>" />
</div>
</form>

</div>