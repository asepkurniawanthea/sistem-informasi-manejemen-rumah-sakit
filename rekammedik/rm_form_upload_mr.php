<?php
$nomr = '';
if (isset($_SESSION['rmformupload_nomr']))
    $nomr = $_SESSION['rmformupload_nomr'];

if (isset($_POST['nomr'])){
    $nomr = $_POST['nomr'];
	$_SESSION['rmformupload_nomr'] = $nomr;
}	

$kunjungan = '';
$jns_dokumen = '';
$keterangan = '';

if(isset($_POST['upload']))
	include('rekammedik/rm_form_upload_mr_save.php');
if (isset($_GET['flid']))
    include('rekammedik/rm_del_upload_mr.php');
?>
<form method="post" enctype="multipart/form-data" name="form_search">
    <table class="tableform" border="0" >
        <tr>
			<td>Nomor MR</td>
            <td><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt"/></td>
			<td><input name="submit" type="submit" class="myButton" value="cari" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
if(!empty($nomr)){

$sql_search = 'SELECT *,DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_search = mysql_query($sql_search) or die(mysql_error());
if(mysql_num_rows($get_search) > 0){
	$dat_pasien = mysql_fetch_assoc($get_search);
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$alamat = $dat_pasien['ALAMAT'];
	$nik = $dat_pasien['NIK'];
	
	$umur = getUmur($tgl_lahir);
	?>
	<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		<form method="post" enctype="multipart/form-data" name="FUpload">
			<table class="tableform" border="0" >
				<tr>
					<td>Kunjungan/ Rawat</td>
					<td><select name="kunjungan" style="width:400px;" class="text_dt" onchange="javascript: MyAjaxRequest('cjenisdocumen','index.php?ajaxrequest=cjenisdocumen&rawat=' + this.value);">
						<option value="" ></option>
						<?php 
						$sql_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID AS RAWAT_ID,
									"Rawat Jalan" AS JNS_PERAWATAN,"RJ" AS JNS_PERAWATAN_ID,
									DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK,
									m_unit.NAMA_UNIT,t_irja.TANGGAL_DAFTAR AS ORD_MASUK
									FROM t_irja 
									INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
									WHERE t_irja.NOMR = "' . $nomr . '"
									AND t_irja.NO_PENDAFTARAN IS NOT NULL 
									AND t_irja.ST_BATAL IS NULL
									UNION 
									SELECT t_irna.IRNA_ID AS RAWAT_ID,
									"Rawat Inap" AS JNS_PERAWATAN,"RI" AS JNS_PERAWATAN_ID,
									DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK,
									m_ruang.NAMA_RUANG AS NAMA_UNIT,t_irna.TANGGAL_DAFTAR AS ORD_MASUK
									FROM t_irna 
									INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
									WHERE t_irna.NOMR = "' . $nomr . '"
									AND t_irna.NO_PENDAFTARAN IS NOT NULL 
									AND t_irna.ST_BATAL IS NULL
									) t_doc
									ORDER BY ORD_MASUK DESC';
						$get_kunjungan = mysql_query($sql_kunjungan) or die(mysql_error());
						while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){
							$slc_kunjungan = '';
							if($kunjungan == $dat_kunjungan['JNS_PERAWATAN_ID'] . $dat_kunjungan['RAWAT_ID']) $slc_kunjungan = 'selected="selected"'; 
							echo '<option value="' . $dat_kunjungan['JNS_PERAWATAN_ID'] . $dat_kunjungan['RAWAT_ID'] . '" ' . $slc_kunjungan . ' >' . $dat_kunjungan['PASIEN_MASUK'] . ' ' . $dat_kunjungan['NAMA_UNIT'] . '</option>';
						}	
						?>
						</select></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Jenis Status/ Dokumen</td>
					<td><div id="cjenisdocumen">
					<select name="jns_dokumen" style="width:400px;" class="text_dt">
						<option value="" > - </option>
						</select>
						</div>
						</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td colspan="2"><textarea name="keterangan" id="keterangan" class="text_dt5" /><?php echo $keterangan; ?></textarea></td>
				</tr>
				<tr>
					<td>File</td>
					<td><input type="file" name="namafile" id="namafile" size="60" /></td>
					<td align="right"><input type="submit" name="upload" value="upload" class="myButton" /></td>
				</tr>
		</table>
		<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
		<input type="hidden" name="nomr" value="<?php echo $nomr; ?>" />
	</form>
	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php
	
	$qry_riwayat = 'SELECT * FROM (SELECT t_rm_dokumen_file.FILE_ID,
					t_rm_dokumen_file.RAWAT_ID,"Rawat Jalan" AS JNS_PERAWATAN,
					t_irja.TANGGAL_DAFTAR AS PASIEN_MASUK,m_unit.NAMA_UNIT,
					"RJ" AS ID_JNS_PERAWATAN,m_rm_jenis_dokumen.JENIS_DOKUMEN,
					t_rm_dokumen_file.KETERANGAN,t_rm_dokumen_file.USER_UPLOAD
					FROM t_rm_dokumen_file
					INNER JOIN t_irja ON (t_rm_dokumen_file.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_rm_jenis_dokumen ON (t_rm_dokumen_file.JENIS_DOKUMEN_ID = m_rm_jenis_dokumen.JENIS_DOKUMEN_ID)
					WHERE t_rm_dokumen_file.NOMR = "' . $nomr . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_rm_dokumen_file.JNS_PERAWATAN = "1"
					AND t_rm_dokumen_file.KETERANGAN IS NOT NULL
					UNION ALL
					SELECT t_rm_dokumen_file.FILE_ID,
					t_rm_dokumen_file.RAWAT_ID,"Rawat Inap" AS JNS_PERAWATAN,
					t_irna.TANGGAL_DAFTAR AS PASIEN_MASUK,m_ruang.NAMA_RUANG AS NAMA_UNIT,
					"RI" AS ID_JNS_PERAWATAN,m_rm_jenis_dokumen.JENIS_DOKUMEN,
					t_rm_dokumen_file.KETERANGAN,t_rm_dokumen_file.USER_UPLOAD
					FROM t_rm_dokumen_file
					INNER JOIN t_irna ON (t_rm_dokumen_file.RAWAT_ID = t_irna.IRNA_ID)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					INNER JOIN m_rm_jenis_dokumen ON (t_rm_dokumen_file.JENIS_DOKUMEN_ID = m_rm_jenis_dokumen.JENIS_DOKUMEN_ID)
					WHERE t_rm_dokumen_file.NOMR = "' . $nomr . '"
					AND t_irna.NO_PENDAFTARAN IS NOT NULL 
					AND t_irna.ST_BATAL IS NULL
					AND t_rm_dokumen_file.JNS_PERAWATAN = "2"
					AND t_rm_dokumen_file.KETERANGAN IS NOT NULL) t_doc
					ORDER BY PASIEN_MASUK DESC';
	$extparam = '&nomr=' . $nomr;
	include('rekammedik/rm_list_upload_mr.php');
	?>	
	</div>
	<?php
	}else{
		$msg_info = 'Data Pasien Tidak Ditemukan.';
	}
}
?>
