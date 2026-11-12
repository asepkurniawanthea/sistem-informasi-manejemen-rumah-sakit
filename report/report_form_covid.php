<?php
//-----variabel baru
$ruang_rawat = '';
$tgl_masuk_rs = '';
$riwayat_pekerjaan = '';
$severity_level = '';
$varian = '';
$komorbid = '';
$hasil_rontgen = '';
$hasil_sgtf = '';
$terapi = '';
$tgl_masukicu = '';
$status_pasien = '';
$los = '';
$status_vaksin = '';
$tgl_vaksin = '';
$tgl_ambil_wgs = '';
$tgl_kirim_wgs = '';
$tgl_hasil_wgs = '';
$hasil_wgs = '';
$tmp_lahir = '';

$irna_id = '';
$irna_lapor_covid_id = '';
$nama_pasien = '';
$tmp_lahir = '';
$tgl_lahir = '';
$jns_kelamin = '';

$st_baru = '';

$tgl_1 = '';
if (isset($_SESSION['ranapsearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['ranapsearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['ranapsearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['ranapsearchpasienperiksa_tgl_2'];

if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['ranapsearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['ranapsearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

if(isset($_GET['no_irna']) and !empty($_GET['no_irna'])){
	$irna_id = $_GET['no_irna']; 
	//if(strlen($irna_id) == 6){
		/*$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $irna_id . '"';*/
		/*$sql_pasien = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
					DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,t_irna.RUANG_ID,t_irna.IRNA_ID,m_ruang.NAMA_RUANG
					FROM m_pasien INNER JOIN t_irna ON (t_irna.NOMR = m_pasien.NOMR)
					LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					WHERE t_irna.IRNA_ID = "' . $irna_id . '"';*/
		$sql_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,m_ruang.RUANG_ID,t_irna.ST_COVID19,t_irna.ST_COVID19_KOMORBIT,
					m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,t_irna_laporan_covid.IRNA_LAPOR_COVID_ID,t_irna_laporan_covid.USIA,t_irna_laporan_covid.RIWAYAT_PEKERJAAN,
					t_irna_laporan_covid.SEVERITY_LEVEL,t_irna_laporan_covid.VARIAN,t_irna_laporan_covid.KOMORBID,t_irna_laporan_covid.HASIL_RONTGEN,
					t_irna_laporan_covid.HASIL_SGTF,t_irna_laporan_covid.TERAPI,DATE_FORMAT(t_irna_laporan_covid.TGL_ICU, "%d/%m/%Y") AS TGL_ICU,
					t_irna_laporan_covid.STATUS_PASIEN,DATEDIFF(t_irna.PASIEN_KELUAR,t_irna.TANGGAL_DAFTAR) AS LOS,t_irna_laporan_covid.STATUS_VAKSIN,DATE_FORMAT(t_irna_laporan_covid.TGL_VAKSIN, "%d/%m/%Y") AS TGL_VAKSIN,
					DATE_FORMAT(t_irna_laporan_covid.TGL_AMBIL_WGS, "%d/%m/%Y") AS TGL_AMBIL_WGS,DATE_FORMAT(t_irna_laporan_covid.TGL_KIRIM_WGS, "%d/%m/%Y") AS TGL_KIRIM_WGS,
					DATE_FORMAT(t_irna_laporan_covid.TGL_KELUAR_WGS,"%d/%m/%Y") AS TGL_KELUAR_WGS,t_irna_laporan_covid.HASIL_WGS,m_pasien.TMP_LAHIR,
					m_pasien.NAMA_PASIEN,date_format(m_pasien.TGL_LAHIR,"%d/%m/%Y") as TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,m_pasien.NOMR,m_pasien.PASIEN_ID,
					t_irna.USER_IRNA,m_pegawai.NAMA_PEGAWAI,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
					m_ruang.KELAS_RAWAT,t_irna.ST_PINDAH,t_irna.PASIEN_MASUK,t_irna.ST_PULANG,t_irna_resume_medis.PEMERIKSAAN_RADIOLOGI
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
					LEFT JOIN t_irna_laporan_covid ON (t_irna_laporan_covid.IRNA_ID = t_irna.IRNA_ID)
					LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
					LEFT JOIN t_irna_resume_medis ON (t_irna.IRNA_ID = t_irna_resume_medis.IRNA_ID)
					WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL	AND (m_ruang.RUANG_ID="47"
					or m_ruang.RUANG_ID="101" or m_ruang.RUANG_ID="87" or m_ruang.RUANG_ID="86") 
					AND ((DATE(t_irna.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' AND DATE(t_irna.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . ')
					OR t_irna.ST_PULANG IS NULL) AND t_irna.IRNA_ID = "' . $irna_id . '"';
	//}else{
		//$sql_pasien = 'SELECT * FROM t_irna_laporan_covid WHERE IRNA_LAPOR_COVID_ID = "' . $irna_lapor_covid_id . '" ORDER BY IRNA_LAPOR_COVID_ID DESC LIMIT 1';

	//}

    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tmp_lahir = $dat_pasien['TMP_LAHIR'];
    $tgl_lahir = $dat_pasien['TGL_LAHIR'];
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$pasien_id = $dat_pasien['PASIEN_ID'];
	$irna_id = $dat_pasien['IRNA_ID'];
	$ruang_id = $dat_pasien['RUANG_ID'];
	$ruang_rawat = $dat_pasien['NAMA_RUANG'];
	$tgl_masuk_rs = $dat_pasien['TANGGAL_DAFTAR'];
	$riwayat_pekerjaan = $dat_pasien['RIWAYAT_PEKERJAAN'];
	$severity_level = $dat_pasien['SEVERITY_LEVEL'];
	$varian = $dat_pasien['VARIAN'];

	if($dat_pasien['ST_COVID19_KOMORBIT'] == "2"){
		$komorbid="Komorbid";
	}else{
		$komorbid="Non Komorbid";
 	}

	if($dat_pasien['ST_PULANG'] == "1"){
        $los=$dat_pasien['LOS']+1;
    }else{
        $tgl_masuk=$dat_pasien['TANGGAL_DAFTAR'];
        $tgl_skrg=date('d/m/Y');
        $los=$tgl_masuk-$tgl_skrg+1;
    } 
                

	//$komorbid = $komorbid;
	$hasil_rontgen = $dat_pasien['PEMERIKSAAN_RADIOLOGI'];
	$hasil_sgtf = $dat_pasien['HASIL_SGTF'];
	$terapi = $dat_pasien['TERAPI'];
	$tgl_masukicu = $dat_pasien['TGL_ICU'];
	$status_pasien = $dat_pasien['STATUS_PASIEN'];
	$status_vaksin = $dat_pasien['STATUS_VAKSIN'];
	$tgl_vaksin = $dat_pasien['TGL_VAKSIN'];
	$tgl_ambil_wgs = $dat_pasien['TGL_AMBIL_WGS'];
	$tgl_kirim_wgs = $dat_pasien['TGL_KIRIM_WGS'];
	$tgl_hasil_wgs = $dat_pasien['TGL_KELUAR_WGS'];
	$hasil_wgs = $dat_pasien['HASIL_WGS'];
	$irna_lapor_covid_id = $dat_pasien['IRNA_LAPOR_COVID_ID'];

	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';

}

//if(isset($_GET['no_irna']) and empty($_GET['no_irna'])){

//if(isset($_GET['no_irna']) and empty($_GET['no_irna'])) $st_baru = '1';
/*if (isset($_GET['idx'])) {
    $irna_lapor_covid_id = $_GET['idx'];
	
    $sql_pasien = 'SELECT * FROM t_irna_laporan_covid WHERE IRNA_LAPOR_COVID_ID = "' . $irna_lapor_covid_id . '"';
    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$riwayat_rekerjaan = $dat_pasien['RIWAYAT_PEKERJAAN'];
	$severity_level = $dat_pasien['SEVERITY_LEVEL'];
	$varian = $dat_pasien['VARIAN'];
	
	
	$irna_id  = $dat_pasien['IRNA_ID'];
	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';
}*/

if (isset($_POST['irna_lapor_covid_id'])) {
    include('report/report_form_save_covid.php');
}

?>
<div style=" height:auto; padding:15px; ">	
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
	<div class="div_menu" style=" height:auto; width:auto; padding:15px;  border:1px solid #999; border-radius:5px; margin:5px; ">
		<?php 
		//$aps = '1';
		/*include('laboratorium/retaillab_pasien_edit.php');*/
		/*include('report/report_pasien_edit.php');*/
		?>
		
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Nama Pasien</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<!--<input type="hidden" name="khusus" id="khusus" value="<?php echo $khusus; ?>" />-->
			<input type="text" name="nama_pasien" id="nama_pasien" class="text_dt" value="<?php echo $nama_pasien; ?>" size="50" readonly="readonly"/>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
		<!---->

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Tempat/Tanggal Lahir</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:220px; float:left; text-indent:5px; " align="left">
			<input type="text" name="tmp_lahir" id="tmp_lahir" class="text_dt" value="<?php echo $tmp_lahir; ?>" size="30" readonly="readonly"/>
		</div>
		<div style=" width:450px; float:left; text-indent:5px; " align="left">
			/&nbsp;<input type="text" name="tgl_lahir" id="tgl_lahir" class="text_dt" value="<?php echo $tgl_lahir; ?>" size="16" onblur="javascript : MyAjaxRequest('umur','index.php?ajaxrequest=umur&tgl_lahir=' + this.value);return false;" readonly="readonly"/>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
		<!---->

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Umur</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:450px; float:left; text-indent:5px; " align="left"><div id="umur" style="color:#FF0000"><?php echo getUmur($tgl_lahir); ?></div></div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
		<!---->

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Jenis Kelamin </div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if($jns_kelamin == 'L') echo 'checked="checked"'; ?> readonly="readonly"/>
			&nbsp;Laki-laki&nbsp;&nbsp;
			<input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if($jns_kelamin == 'P') echo 'checked="checked"'; ?> readonly="readonly"/>
			&nbsp;Perempuan
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
		<!---->
		
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Nama Ruang Rawat</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="ruang_rawat" id="ruang_rawat" class="text_dt" value="<?php echo $ruang_rawat; ?>" size="50" readonly="readonly"/>
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Tgl Masuk RS</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left">
			<input type="text" name="tgl_masuk_rs" id="tgl_masuk_rs" value="<?php echo $tgl_masuk_rs; ?>" size="15" class="text_dt" readonly="readonly"/>
        </div>
		<br/><br/>

		<!--<div style=" width:250px; float:left; text-indent:5px; " align="left">Riwayat Pekerjaan</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="riwayat_pekerjaan" id="riwayat_pekerjaan" style="width:228px;" class="text_dt">
				<option value="<?php if($riwayat_pekerjaan == "-") echo "-"; ?>">-</option>
				<option value="<?php if($riwayat_pekerjaan == "Bekerja") echo "Bekerja"; ?>">Bekerja</option>
				<option value="<?php if($riwayat_pekerjaan == "Tidak Bekerja") echo "Tidak Bekerja"; ?>">Tidak Bekerja</option>
		</select>
		</div>-->
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Pekerjaan </div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="radio" name="riwayat_pekerjaan" id="riwayat_pekerjaan" value="Bekerja" <?php if($riwayat_pekerjaan == 'Bekerja') echo 'checked="checked"'; ?>/>
			&nbsp;Bekerja&nbsp;&nbsp;
			<input type="radio" name="riwayat_pekerjaan" id="riwayat_pekerjaan" value="Tidak Bekerja" <?php if($riwayat_pekerjaan == 'Tidak Bekerja') echo 'checked="checked"'; ?>/>
			&nbsp;Tidak Bekerja
		</div>
		<!---->
		<br/><br/>

		<!--<div style=" width:250px; float:left; text-indent:5px; " align="left">Severity Level</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="severity_level" id="severity_level" style="width:228px;" class="text_dt">
			<option value="-">-</option>
			<option value="Sedang">Sedang</option>
			<option value="Berat">Berat</option>
			<option value="Kritikal">Kritikal</option>
		</select>
		</div>-->
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Severity Level </div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="radio" name="severity_level" id="severity_level" value="Sedang" <?php if($severity_level == 'Sedang') echo 'checked="checked"'; ?>/>
			&nbsp;Sedang&nbsp;&nbsp;
			<input type="radio" name="severity_level" id="severity_level" value="Berat" <?php if($severity_level == 'Berat') echo 'checked="checked"'; ?>/>
			&nbsp;Berat
			<input type="radio" name="severity_level" id="severity_level" value="Kritikal" <?php if($severity_level == 'Kritikal') echo 'checked="checked"'; ?>/>
			&nbsp;Kritikal
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Varian</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="varian" id="varian" class="text_dt" value="<?php echo $varian; ?>" size="110" />
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Komorbid</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="komorbid" id="komorbid" class="text_dt" value="<?php echo $komorbid; ?>" size="110" readonly="readonly"/>
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Hasil Rontgen</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<textarea name="hasil_rontgen" id="hasil_rontgen"class="text_dt11" readonly="readonly"><?php echo $hasil_rontgen; ?> </textarea>
		
			<!--<input type="text" name="hasil_rontgen" id="hasil_rontgen" class="text_dt" value="<?php echo $hasil_rontgen; ?>" size="50" />-->
		</div>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Hasil SGTF</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="hasil_sgtf" id="hasil_sgtf" class="text_dt" value="<?php echo $hasil_sgtf; ?>" size="110" />
		</div>
		<br/><br/>
		
		<!--<div style=" width:250px; float:left; text-indent:5px; " align="left">Terapi</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="terapi" id="terapi" style="width:228px;" class="text_dt">
			<option value="-">-</option>
			<option value="Ventilator">Ventilator</option>
			<option value="HNFC">HNFC</option>
			<option value="NRM">NRM</option>
		</select>
		</div>-->
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Terapi </div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="radio" name="terapi" id="terapi" value="Ventilator" <?php if($terapi == 'Ventilator') echo 'checked="checked"'; ?>/>
			&nbsp;Ventilator&nbsp;&nbsp;
			<input type="radio" name="terapi" id="terapi" value="HNFC" <?php if($terapi == 'HNFC') echo 'checked="checked"'; ?>/>
			&nbsp;HNFC
			<input type="radio" name="terapi" id="terapi" value="NRM" <?php if($terapi == 'NRM') echo 'checked="checked"'; ?>/>
			&nbsp;NRM
		</div>
		<br/><br/>

		<div style=" width:250px; float:Left; text-indent:5px; " align="left">Tgl Masuk ICU</div>
		<div style=" width:20px; float:Left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left"><input type="text" name="tgl_masukicu" id="tgl_masukicu" value="<?php echo $tgl_masukicu; ?>" size="15" class="text_dt" />
            <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar72')"/></div>
		
		<br><br>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Status Pasien Saat Ini</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="status_pasien" id="status_pasien" class="text_dt" value="<?php echo $status_pasien; ?>" size="110" />
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">LOS</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="los" id="los" class="text_dt" value="<?php echo $los. ' hari'; ?>" size="110" readonly="readonly"/>
		</div>
		<br/><br/>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Status Vaksin</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="status_vaksin" id="status_vaksin" class="text_dt" value="<?php echo $status_vaksin; ?>" size="110" />
		</div>
		<br/><br/>
		
		<div style=" width:250px; float:Left; text-indent:5px; " align="left">Tgl Vaksin</div>
		<div style=" width:20px; float:Left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left"><input type="text" name="tgl_vaksin" id="tgl_vaksin" value="<?php echo $tgl_vaksin; ?>" size="15" class="text_dt" />
               <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar70')"/></div>
		<br><br>

		<div style=" width:250px; float:Left; text-indent:5px; " align="left">Tgl Pengambilan Sample WGS</div>
		<div style=" width:20px; float:Left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left"><input type="text" name="tgl_ambil_wgs" id="tgl_ambil_wgs" value="<?php echo $tgl_ambil_wgs; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar190')"/></div>
		<br><br>

		<div style=" width:250px; float:Left; text-indent:5px; " align="left">Tgl Pengiriman Sample WGS</div>
		<div style=" width:20px; float:Left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left"><input type="text" name="tgl_kirim_wgs" id="tgl_kirim_wgs" value="<?php echo $tgl_kirim_wgs; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar191')"/></div>
		<br><br>

		<div style=" width:250px; float:Left; text-indent:5px; " align="left">Tgl Keluar Hasil WGS</div>
		<div style=" width:20px; float:Left; ">:</div>
		<div style=" width:250px; float:Left; text-indent:5px; " align="left"><input type="text" name="tgl_hasil_wgs" id="tgl_hasil_wgs" value="<?php echo $tgl_hasil_wgs; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar192')"/></div>
		<br><br>

		<div style=" width:250px; float:left; text-indent:5px; " align="left">Hasil WGS</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="hasil_wgs" id="hasil_wgs" class="text_dt" value="<?php echo $hasil_wgs; ?>" size="110" />
		</div>
		<br/><br/>
	</div>
    <div class="div_menu" style=" height:auto; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;" align="right">
			<a href="index.php?link=593ead4bbdd314afbcc7ac148cd9fa94&" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan >>" class="myButton1" />
    </div>	
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irna_lapor_covid_id" id="irna_lapor_covid_id" value="<?php echo $irna_lapor_covid_id; ?>" />
	<input type="hidden" name="st_baru" id="st_baru" value="<?php echo $st_baru; ?>" />
</form>
</div>
<script type="text/javascript">
document.getElementById("nama_pasien").focus();
</script>