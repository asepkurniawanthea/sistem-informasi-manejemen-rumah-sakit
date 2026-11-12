<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];

$tgl_filter = '';
$tgl_filter2 = '';
if (isset($_SESSION['rajalformtindakan_tgl_filter' . $idx])){
	$tgl_filter = $_SESSION['rajalformtindakan_tgl_filter' . $idx];
	$tgl_filter2 = $_SESSION['rajalformtindakan_tgl_filter2' . $idx];
}		

if (isset($_POST['tgl_filter'])) {
    $tgl_filter = $_POST['tgl_filter'];
	$_SESSION['rajalformtindakan_tgl_filter' . $idx] = $tgl_filter;
	$tgl_filter2 = $_POST['tgl_filter2'];
	$_SESSION['rajalformtindakan_tgl_filter2' . $idx] = $tgl_filter2;
?>
<script language="JavaScript" >
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php	
}

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
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Poliklinik</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:450px; float:right; text-indent:5px; " align="right">
	<?php 
	$kasir = 'umum'; 
	$link = '7a3672f268cb0a37713fbe1b2cec6326';
	if(isset($_GET['kasir'])){
		$kasir = $_GET['kasir'];
		if($kasir == 'igd') $link = 'b319673487d547ee3272bc777ee01810';
		if($kasir == 'kusta') $link = '7f8169f411076bd9a47b34ed2a982bae';
	}
?>
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo $link; ?>&kasir=<?php echo $kasir; ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="search" method="post">
<?php if($jenis_bayar_id != '1'){ ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_filter" id="tgl_1" value="<?php echo $tgl_filter; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></div>
	<div style=" width:250px; float:right; text-indent:5px;" align="left"><div id="total_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Total Klaim</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Sd</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_filter2" id="tgl_2" value="<?php echo $tgl_filter2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="tidak_diklaim">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tidak Diklaim</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="submit" name="filter" value="filter" class="myButton1" /></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sudah_dibayar">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sudah Dibayar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sisa_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sisa Tagihan</div><br><br>
	<?php }else{ ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_filter" id="tgl_1" value="<?php echo $tgl_filter; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></div>
	<div style=" width:250px; float:right; text-indent:5px;" align="left"><div id="total_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Total Tagihan</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Sd</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_filter2" id="tgl_2" value="<?php echo $tgl_filter2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sudah_dibayar">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sudah Dibayar</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="submit" name="filter" value="filter" class="myButton1" /></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sisa_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sisa Tagihan</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="deposit">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Deposit</div><br><br>
	<?php } ?>
</form>
</div>
  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$total_tagihan = 0;
$sudah_dibayar = 0;
$tidak_diklaim = 0;
$tidak_diklaim_bayar = 0;

$user_verif = '';

$bayar_total = 0;	
$nomor_tarif_irja = '';	
$status_bayar = false;

$sql_tarif  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
					SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
					t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irja_tarif.ST_VERIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_irja_tarif 
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
					LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
			AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif .= 'GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
					t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
					ORDER BY t_irja_tarif.TGL_TARIF';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
					t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.ST_VERIF
					FROM t_ipenunjang 
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"	
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL 
					AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "") ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
					ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

$sql_tarif_operasi = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
							END 
					END)
				) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,t_operasi_tarif.ST_VERIF
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
				
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
					SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
					t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_hemodialisa_tarif.ST_VERIF
					FROM t_hemodialisa 
					INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
					AND t_hemodialisa.JNS_ORDER = "IRJ"	
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa.ST_BATAL IS NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
					t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
					t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
					ORDER BY t_hemodialisa.TANGGAL_ORDER';
$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
					t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
					t_ipenunjang_tarif.ST_VERIF
					FROM t_ipenunjang 
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "HRJ"	
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
					ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());
	
$sql_tarif_penunjang_operasi = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
					t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.ST_VERIF
					FROM t_ipenunjang 
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "ORJ"	
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang_operasi .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_penunjang_operasi .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
					ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang_operasi = mysql_query($sql_tarif_penunjang_operasi) or die(mysql_error());

$sql_ambulance  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ambulance_tarif.ST_VERIF
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" 
					AND t_ambulance_tarif.JNS_ORDER = "IRJ"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_ambulance .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
					ORDER BY t_ambulance_tarif.TGL_TARIF';
$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Kwitansi</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Tindakan/ Pemeriksaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="100px">Pembayaran</th>
	<th width="150px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	$t = 1;
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		$harga = 0;
		$status = $dat_tarif['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif['HARGA'];
		$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center">
		<!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="t-<?php echo $dat_tarif['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09"
								THEN (SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID)
							ELSE "" END AS NAMA_DOKTER,m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR,
							t_irja_tarif.TDK_KLAIM_VERIF	
							FROM t_irja_tarif
							INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" 
							AND t_irja_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php 
			$nama_tarif = $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')';
			if(!empty($dat_tarif_detail['NAMA_DOKTER'])) $nama_tarif = $nama_tarif . ', ' .$dat_tarif_detail['NAMA_DOKTER']; 
			echo $nama_tarif; ?></td>
			<td align="right"><?php echo $dat_tarif_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI'];
					if($dat_tarif_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_detail['TARIF_NON_KELAS'] * $dat_tarif_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_detail['TDK_KLAIM_VERIF'];
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;			
						$sudah_dibayar += $harga;
						if($dat_tarif['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif['ST_VERIF'];
						}else{ 
							if($dat_tarif['KODE_TARIF_GROUP'] == '120'){ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_mcu(<?php echo $idx; ?>,'<?php echo $dat_tarif['NO_TARIF']; ?>'); return false;"/>
							<?php }else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_irja(<?php echo $idx; ?>,'<?php echo $dat_tarif['NO_TARIF']; ?>'); return false;"/>
							<?php }	
					} 
				} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
	}


	while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
		$harga = 0;
		$status = $dat_tarif_penunjang['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_penunjang['HARGA'];
		$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif_penunjang['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_penunjang['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif_penunjang['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR,
							t_ipenunjang_tarif.TDK_KLAIM_VERIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "IRJ"	
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_penunjang_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_penunjang_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI'];
					if($dat_tarif_penunjang_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_penunjang_detail['TDK_KLAIM_VERIF'];
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga; 
						$sudah_dibayar += $harga;
						if($dat_tarif_penunjang['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif_penunjang['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_penunjang(<?php echo $idx; ?>,'<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>','irj'); return false;" />
					<?php } 
					} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
	}
	
	//operasi
	while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
		$harga = 0;
		$status = $dat_tarif_operasi['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_operasi['HARGA'];
		$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif_operasi['NO_TARIF'];
		$operasi_id = $dat_tarif_operasi['OPERASI_ID'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_operasi['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_operasi['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif_operasi['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_operasi_detail  = 'SELECT t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
							ELSE	
								CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								END 
							END AS TARIF_NON_KELAS,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR,
							t_operasi_tarif.TDK_KLAIM_VERIF
							FROM t_operasi_tarif
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" 
							AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
							AND t_operasi_tarif.NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_operasi_detail = mysql_query($sql_tarif_operasi_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_operasi_detail = mysql_fetch_array($get_tarif_operasi_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['NAMA_TARIF'] . ' (' . $dat_tarif_operasi_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_operasi_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_operasi_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_detail['KUANTITI'];
					if($dat_tarif_operasi_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_operasi_detail['TDK_KLAIM_VERIF'];
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga; 
						$sudah_dibayar += $harga;
						if($dat_tarif_operasi['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif_operasi['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_operasi(<?php echo $operasi_id; ?>,'<?php echo $dat_tarif_operasi['NO_TARIF']; ?>'); return false;" />
					<?php }
					} ?></td>
			</tr>
		<?php
	$i++;
	}
	//end operasi
	
	//penunjang operasi
	while($dat_tarif_penunjang_operasi = mysql_fetch_array($get_tarif_penunjang_operasi)){
		$harga = 0;
		$status = $dat_tarif_penunjang_operasi['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_penunjang_operasi['HARGA'];
		$no_bayar = $dat_tarif_penunjang_operasi['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif_penunjang_operasi['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_penunjang_operasi['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_penunjang_operasi['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_operasi['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang_operasi['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_operasi['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif_penunjang_operasi['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR,
							t_ipenunjang_tarif.TDK_KLAIM_VERIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang_operasi['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "ORJ"	
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_penunjang_operasi_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_operasi_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_operasi_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_operasi_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_operasi_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_operasi_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_penunjang_operasi_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_penunjang_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_operasi_detail['KUANTITI'];
					if($dat_tarif_penunjang_operasi_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_penunjang_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_operasi_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_penunjang_operasi_detail['TDK_KLAIM_VERIF'];
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga; 
						$sudah_dibayar += $harga;
						if($dat_tarif_penunjang_operasi['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif_penunjang_operasi['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_operasi['NO_TARIF']; ?>,'orj');return false;"/>
					<?php }
					} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
	}
	
	//hemodialisa
	while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
		$harga = 0;
		$status = $dat_tarif_hemodialisa['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_hemodialisa['HARGA'];
		$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif_hemodialisa['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_hemodialisa['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_hemodialisa_tarif.TARIF_ID,COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							m_tarif.NAMA_TARIF,m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR,
							t_hemodialisa_tarif.TDK_KLAIM_VERIF
							FROM t_hemodialisa
							INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
							INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
							AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"
							AND t_hemodialisa.JNS_ORDER = "IRJ"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")							
							GROUP BY t_hemodialisa_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_hemodialisa_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_hemodialisa_detail['NAMA_TARIF'] . ' (' . $dat_tarif_hemodialisa_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_hemodialisa_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_hemodialisa_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_hemodialisa_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_hemodialisa_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_hemodialisa_detail['KUANTITI'];
					if($dat_tarif_hemodialisa_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_hemodialisa_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_hemodialisa_detail['TDK_KLAIM_VERIF'];
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga; 
						$sudah_dibayar += $harga;
						if($dat_tarif_hemodialisa['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif_hemodialisa['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,'irj');return false;" />
					<?php } 
					} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
	}
	
	while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
		$harga = 0;
		$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_penunjang_hemodialisa['HARGA'];
		$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_irja = $dat_tarif_penunjang_hemodialisa['NO_TARIF'];
		$jnsorder = $dat_tarif_penunjang_hemodialisa['JNS_ORDER'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang_hemodialisa['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_tarif_penunjang_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR,
							t_ipenunjang_tarif.TDK_KLAIM_VERIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "HRJ"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_penunjang_hemodialisa_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_hemodialisa_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_hemodialisa_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_hemodialisa_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_hemodialisa_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_hemodialisa_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_penunjang_hemodialisa_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_penunjang_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_hemodialisa_detail['KUANTITI'];
					if($dat_tarif_penunjang_hemodialisa_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_penunjang_hemodialisa_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_hemodialisa_detail['KUANTITI'];
					}
					
					$user_verif = $dat_tarif_penunjang_hemodialisa_detail['TDK_KLAIM_VERIF'];
				}
			}   
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;					 
						$sudah_dibayar += $harga;
						if($dat_tarif_penunjang_hemodialisa['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_tarif_penunjang_hemodialisa['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>,'<?php echo $jnsorder; ?>');return false;"/>
					<?php }
					} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
	}

while($dat_ambulance = mysql_fetch_array($get_ambulance)){
		$harga = 0;
		$status = $dat_ambulance['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_ambulance['HARGA'];
		$no_bayar = $dat_ambulance['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$nomor_tarif_ambulance = $dat_ambulance['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center">
		<!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="t-<?php echo $dat_ambulance['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_ambulance['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_ambulance['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_ambulance['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_ambulance['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_ambulance['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_ambulance_detail  = 'SELECT t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09"
								THEN (SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_ambulance_tarif.PEGAWAI_ID)
							ELSE "" END AS NAMA_DOKTER,m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR,
							t_ambulance_tarif.TDK_KLAIM_VERIF	
							FROM t_ambulance_tarif
							INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" 
							AND t_ambulance_tarif.JNS_ORDER = "IRJ" 
							AND t_ambulance_tarif.NO_TARIF = "' . $dat_ambulance['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_ambulance_detail = mysql_query($sql_ambulance_detail) or die(mysql_error());				
			$y = 1;
			while($dat_ambulance_detail = mysql_fetch_array($get_ambulance_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php 
			$nama_tarif = $dat_ambulance_detail['NAMA_TARIF'] . ' (' . $dat_ambulance_detail['NAMA_TARIF_GROUP'] . ')';
			if(!empty($dat_ambulance_detail['NAMA_DOKTER'])) $nama_tarif = $nama_tarif . ', ' .$dat_ambulance_detail['NAMA_DOKTER']; 
			echo $nama_tarif; ?></td>
			<td align="right"><?php echo $dat_ambulance_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_ambulance_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_ambulance_detail['TARIF_NON_KELAS'] * $dat_ambulance_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_ambulance_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_ambulance_detail['TARIF_NON_KELAS'] * $dat_ambulance_detail['KUANTITI'];
					if($dat_ambulance_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_ambulance_detail['TARIF_NON_KELAS'] * $dat_ambulance_detail['KUANTITI'];
					}
					
					$user_verif = $dat_ambulance_detail['TDK_KLAIM_VERIF'];
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga; 
						$sudah_dibayar += $harga;
						if($dat_ambulance['ST_VERIF'] != ''){
							echo 'Verif : ' . $dat_ambulance['ST_VERIF'];
						}else{ ?>
							<input type="button" class="myButton" value="verifikasi" onclick="verif_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance['NO_TARIF']; ?>,'irj');return false;" />
					<?php }
					} ?></td>
			</tr>
		<?php
	$i++;
	$t++;
}
?>  
<tr>
	<td colspan="8" align="right">Total Tindakan/ Pemeriksaan Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total); ?></td>
	<td colspan="3" align="center">&nbsp;</td>
</tr>
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl_filter . '" ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
$get_resep = mysql_query($sql_resep) or die(mysql_error());	
$bayar_farmasi_total = 0;					
?>
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Resep</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Persediaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="100px">Pembayaran</th>
	<th width="150px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_resep = mysql_fetch_array($get_resep)){
		$no_resep = $dat_resep['NO_RESEP'];
		$status = $dat_resep['ST_BATAL'];
		$no_bayar = $dat_resep['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep['NO_RESEP']; ?></td>
		<td align="center"><?php echo $dat_resep['TANGGAL_KELUAR']; ?></td>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN']) and $dat_resep['JAMINAN_ID'] == '1'){
							echo 'Lunas';
						}else if($dat_resep['JAMINAN_ID'] != '1'){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			 $sql_resep_detail = 'SELECT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_rajal_resep.NO_RESEP';
			$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20px" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	
				</tr>
				<?php
			$y++; 
			if($status != '1'){
				$total = $total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); 
				$bayar_farmasi_total = $bayar_farmasi_total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']);	
			}	
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="3" align="center">
				<?php if($dat_resep['ST_BATAL'] != '1'){
						$total_tagihan += $total;
						$sudah_dibayar += $total;
							if($dat_resep['ST_VERIF'] != ''){
								echo 'Verif : ' . $dat_resep['ST_VERIF'];
							}else{ ?>
								<input type="button" class="myButton" value="verifikasi" onclick="verif_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
							<?php } 
					} ?>
				</td>
			</tr>
			<?php
	$i++;
	}	

	//hemodialisa
	$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM 
					t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl_filter . '" ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
	$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
	$get_resep = mysql_query($sql_resep) or die(mysql_error());	
	$i = 1;
	while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			?>
			<tr>
			<td align="center"><?php echo $i; ?></td>
			<td align="center"><?php echo $dat_resep['NO_RESEP']; ?>-Hemodialisa</td>
			<td align="center"><?php echo $dat_resep['TANGGAL_KELUAR']; ?></td>
			<td colspan="5">&nbsp;</td>
			<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; ?></td>
			<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
			<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN']) and $dat_resep['JAMINAN_ID'] == '1'){
							echo 'Lunas';
						}else if($dat_resep['JAMINAN_ID'] != '1'){
							echo 'Lunas';
						} ?></td>
			</tr>
			<?php
				 $sql_resep_detail = 'SELECT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
						t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
						t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
						t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
						t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
						m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
						FROM 
						t_farmasi_apotik_pengeluaran
						INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
						AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
						INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
						INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
						INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
						AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
						AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
						INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
						WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
						AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
						AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
						GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
						t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
						t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
						t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
						t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
						m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
						ORDER BY t_rajal_resep.NO_RESEP';
				$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
				$y = 1;
				$total = 0;
				while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
					?>
					<tr>
					<td colspan="3">&nbsp;</td>	
					<td width="20px" align="center"><?php echo $y; ?></td>
					<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
					<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR']); ?></td>
					<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
					<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	
					</tr>
					<?php
				$y++; 
				if($status != '1'){
					$total = $total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); 
					$bayar_farmasi_total = $bayar_farmasi_total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']);
				}	
				}
				?>
				<tr>
					<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
					<td colspan="3" align="center">
					<?php if($dat_resep['ST_BATAL'] != '1'){
						$total_tagihan += $total;
							$sudah_dibayar += $total;
							if($dat_resep['ST_VERIF'] != ''){
								echo 'Verif : ' . $dat_resep['ST_VERIF'];
							}else{ ?>
								<input type="button" class="myButton" value="verifikasi" onclick="verif_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
							<?php }
					} ?>
					</td>
				</tr>
				<?php
		$i++;
		}	
	//	
?>
<tr>
	<td colspan="8" align="right">Total Farmasi Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_farmasi_total); ?></td>
	<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="8" align="right">Total Pembayaran Poliklinik/ IGD Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total + $bayar_farmasi_total); ?></td>
	<td colspan="3" align="center">
	<input type="button" class="myButton" value="verifikasi semua" onclick="verif_irja_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>'); return false;" />	
	</td>
</tr>
<?php if($tidak_diklaim > 0 and $jenis_bayar_id != '1'){ ?>
<tr>
	<td colspan="8" align="right">Tidak Diklaim Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($tidak_diklaim); ?></td>
	<td colspan="4" align="center">
	<?php $sisa = $tidak_diklaim - $tidak_diklaim_bayar; 
	if($user_verif != ''){ 
		echo $user_verif;
	}else{ ?>		
			<input type="button" class="myButton" value="verifikasi tidak diklaim" onclick="javascript : verif_tidak_diklaim(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />&nbsp;
	<?php } ?>			
	</td>
</tr>
<?php } ?>
</table>
</div>
</div>
<div id="bayar"></div>
<script language="JavaScript" >
<?php if($jenis_bayar_id != '1'){ ?>
document.getElementById("total_tagihan").innerHTML= "<?php echo currFormat($total_tagihan); ?>";
document.getElementById("tidak_diklaim").innerHTML= "<?php echo currFormat($tidak_diklaim); ?>";
document.getElementById("sudah_dibayar").innerHTML= "<?php echo currFormat($tidak_diklaim_bayar); ?>";
document.getElementById("sisa_tagihan").innerHTML= "<?php echo currFormat($tidak_diklaim - $tidak_diklaim_bayar); ?>";
<?php }else{ 
$sql_deposit = 'SELECT SUM(JUMLAH_DEPOSIT) AS DEPOSIT FROM db_simrs.t_deposit
		WHERE RAWAT_ID = "' . $idx . '" AND ST_BATAL IS NULL';
$get_deposit = mysql_query($sql_deposit) or die(mysql_error());
$dat_deposit = mysql_fetch_assoc($get_deposit);
$deposit = $dat_deposit['DEPOSIT'];		
?>
document.getElementById("total_tagihan").innerHTML= "<?php echo currFormat($total_tagihan); ?>";
document.getElementById("sudah_dibayar").innerHTML= "<?php echo currFormat($sudah_dibayar); ?>";
document.getElementById("sisa_tagihan").innerHTML= "<?php echo currFormat($total_tagihan - $sudah_dibayar); ?>";
document.getElementById("deposit").innerHTML= "<?php echo currFormat($deposit); ?>";
<?php } ?>

function selesai(link){
window.location = link;
}
function verif_irja(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifirja&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_mcu(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifmcu&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_penunjang(idx,no,ord){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifpenunjang&idx=' + idx + '&no=' + no + '&ord=' + ord);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_farmasi(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=veriffarmasi&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_hemodialisa(idx,no,ord){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifhemodialisa&idx=' + idx + '&no=' + no + '&ord=' + ord);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_ambulance(idx,no,ord){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifambulance&idx=' + idx + '&no=' + no + '&ord=' + ord);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}


function verif_operasi(idx,no){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifoperasi&idx=' + idx + '&no=' + no);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_irja_all(idx,tgl1,tgl2){
 MyAjaxRequest('bayar','index.php?ajaxrequest=verifirjaall&idx=' + idx + '&tgl1=' + tgl1 + '&tgl2=' + tgl2);
 alert('Simpan Data Verif Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}

function verif_tidak_diklaim(idx,tgl1,tgl2){
 MyAjaxRequest('bayar','index.php?ajaxrequest=veriftidakdiklaimirja&idx=' + idx + '&tgl1=' + tgl1 + '&tgl2=' + tgl2);
 alert('Simpan Data Pembayaran Berhasil.');
 window.location = "<?php echo currentURl(); ?>";
}
</script> 
<?php } ?>