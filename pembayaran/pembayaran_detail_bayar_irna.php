<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];

$tgl_filter = '';
$tgl_filter2 = '';
$ruang_tindakan = '';
if (isset($_SESSION['ranapformtindakan_tgl_filter' . $idx])){
	$tgl_filter = $_SESSION['ranapformtindakan_tgl_filter' . $idx];
	$tgl_filter2 = $_SESSION['ranapformtindakan_tgl_filter2' . $idx];
	$ruang_tindakan = $_SESSION['ranapformtindakan_ruang_tindakan' . $idx];
}		

if (isset($_POST['tgl_filter'])) {
    $tgl_filter = $_POST['tgl_filter'];
	$_SESSION['ranapformtindakan_tgl_filter' . $idx] = $tgl_filter;
	$tgl_filter2 = $_POST['tgl_filter2'];
	$_SESSION['ranapformtindakan_tgl_filter2' . $idx] = $tgl_filter2;
	$ruang_tindakan = $_POST['ruang_tindakan'];
	$_SESSION['ranapformtindakan_ruang_tindakan' . $idx] = $ruang_tindakan;
?>
<script language="JavaScript" >
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php	
}

$ruang_tindakan_k = '';
$ruang_tindakan_i = '';
if($ruang_tindakan != ''){
	$arr_ruang_tindakan = explode('|',$ruang_tindakan);
	$ruang_tindakan_k = $arr_ruang_tindakan[0];
	$ruang_tindakan_i = $arr_ruang_tindakan[1];
}

$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,m_ruang.NAMA_RUANG,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.KELAS_RAWAT,t_irna.NO_SEP,t_irna.ST_PULANG,
				DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s") AS TANGGAL_PULANG,
				t_irna.JENIS_BAYAR_ID,t_irja.UNIT_ID AS KASIR,
				t_irna.COST_SHARING
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
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
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$irna_id = $dat_pasien['IRNA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_RUANG'] . ' /Kelas ' . $dat_pasien['KELAS_RAWAT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kelas_rawat = $dat_pasien['KELAS_RAWAT'];

$nosep = $dat_pasien['NO_SEP'];
$st_pulang = $dat_pasien['ST_PULANG'];
$tanggal_pulang = $dat_pasien['TANGGAL_PULANG'];
$cost_sharing = $dat_pasien['COST_SHARING'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$userkasir = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];

$kasir = 'umum';
if($dat_pasien['KASIR'] == '9') $kasir = 'igd'; 

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:550px; float:right; text-indent:5px; " align="right">
	<!--
	<a href="index.php?link=<?php echo md5('kasirformtindakanrawatinap'); ?>&idx=<?php echo $irna_id; ?>" ><input type="button" value="tambah tindakan" class="myButton1"></a>
	<a href="index.php?link=<?php echo md5('kasirformpemeriksaanpenunjang'); ?>&idx=<?php echo $irna_id; ?>&ord=irn" ><input type="button" value="tambah penunjang" class="myButton1"></a>
	<?php if(empty($st_pulang)){ ?>
	<input type="button" value="pasien pulang" id="bt_pasien_pulang" class="myButton1" onclick="javascript : pasien_pulang('<?php echo $irna_id; ?>');return false;" />
	<?php } ?>
	-->
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('kasirpembayaranrawatinap'); ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="search" method="post">
<?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="ruang_tindakan" style="width:200px;" class="text_dt">
			<option value="">--</option>
			<?php
			$qry_klinik = 'SELECT t_irja.UNIT_ID,m_unit.NAMA_UNIT 
						FROM t_irja
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						WHERE t_irja.IRJA_ID = "' . $idx . '"';
			$get_klinik = mysql_query($qry_klinik) or die(mysql_error());
			while($data_klinik = mysql_fetch_array($get_klinik)){
				echo '<option value="1|' . $data_klinik['UNIT_ID'] . '" ' . (($ruang_tindakan == '1|' . $data_klinik['UNIT_ID']) ? 'selected="selected"' : '') . '>' . $data_klinik['NAMA_UNIT'] . '</option>';	
			}
			$qry_kamar = 'SELECT DISTINCT t_log.NAMA_RUANG,t_log.RUANG_ID
					FROM (
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1
						) AS TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $idx . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NOT NULL
						UNION ALL
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						t_irna_log.TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $idx . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NULL
					) t_log	 
					ORDER BY t_log.TANGGAL_MASUK';
			$get_kamar = mysql_query($qry_kamar) or die(mysql_error());
			while($data_kamar = mysql_fetch_array($get_kamar)){
				echo '<option value="2|' . $data_kamar['RUANG_ID'] . '" ' . (($ruang_tindakan == '2|' . $data_kamar['RUANG_ID']) ? 'selected="selected"' : '') . '>' . $data_kamar['NAMA_RUANG'] . '</option>';	
			}
			
			if(mysql_num_rows($get_kamar) == 0){
				echo '<option value="2|' . $dat_pasien['RUANG_ID'] . '" ' . (($ruang_tindakan == '2|' . $dat_pasien['RUANG_ID']) ? 'selected="selected"' : '') . '>' . $dat_pasien['NAMA_RUANG'] . '</option>';	
			}
			?>	
			</select></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sisa_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sisa Tagihan</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="submit" name="filter" value="filter" class="myButton1" /></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="deposit">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Deposit</div><br><br>
<?php }else{ ?>
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="ruang_tindakan" style="width:200px;" class="text_dt">
			<option value="">--</option>
			<?php
			$qry_klinik = 'SELECT t_irja.UNIT_ID,m_unit.NAMA_UNIT 
						FROM t_irja
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						WHERE t_irja.IRJA_ID = "' . $idx . '"';
			$get_klinik = mysql_query($qry_klinik) or die(mysql_error());
			while($data_klinik = mysql_fetch_array($get_klinik)){
				echo '<option value="1|' . $data_klinik['UNIT_ID'] . '" ' . (($ruang_tindakan == '1|' . $data_klinik['UNIT_ID']) ? 'selected="selected"' : '') . '>' . $data_klinik['NAMA_UNIT'] . '</option>';	
			}
			$qry_kamar = 'SELECT DISTINCT t_log.NAMA_RUANG,t_log.RUANG_ID
					FROM (
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1
						) AS TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $idx . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NOT NULL
						UNION ALL
						SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,
						m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.RUANG_ID,
						t_irna_log.TANGGAL_MASUK
						FROM t_irna_log
						LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID)
						WHERE t_irna_log.IRNA_ID = "' . $idx . '"
						AND t_irna_log.JNS_UPDATE = "R"
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL
						AND t_irna_log.TANGGAL_KELUAR IS NULL
					) t_log	 
					ORDER BY t_log.TANGGAL_MASUK';
			$get_kamar = mysql_query($qry_kamar) or die(mysql_error());
			while($data_kamar = mysql_fetch_array($get_kamar)){
				echo '<option value="2|' . $data_kamar['RUANG_ID'] . '" ' . (($ruang_tindakan == '2|' . $data_kamar['RUANG_ID']) ? 'selected="selected"' : '') . '>' . $data_kamar['NAMA_RUANG'] . '</option>';	
			}
			
			if(mysql_num_rows($get_kamar) == 0){
				echo '<option value="2|' . $dat_pasien['RUANG_ID'] . '" ' . (($ruang_tindakan == '2|' . $dat_pasien['RUANG_ID']) ? 'selected="selected"' : '') . '>' . $dat_pasien['NAMA_RUANG'] . '</option>';	
			}
			?>	
			</select></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sudah_dibayar">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sudah Dibayar</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="submit" name="filter" value="filter" class="myButton1" /></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><div id="sisa_tagihan">0</div></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Sisa Tagihan</div><br><br>
<?php } ?>	
</form>
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$total_tagihan = 0;
$sudah_dibayar = 0;
$tidak_diklaim = 0;
$tidak_diklaim_bayar = 0;

$bayar_total_irja = 0;			
$bayar_total_farmasi_irja = 0;
$status_bayar_irja = false;	

$nomor_tarif_irna = '';
//rawat jalan - IGD
if($ruang_tindakan == '' or $ruang_tindakan_k == '1'){
	$sql_tarif_irja  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
				t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.KODE_TARIF_GROUP,
				t_irja_tarif.KODE_CASH,t_irja_tarif.KODE_REKENING
				FROM t_irja_tarif 
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_irja .= 'AND DATE(t_irja_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_irja .= 'AND DATE(t_irja_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_irja_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
	$sql_tarif_irja .= 'GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
				ORDER BY t_irja_tarif.TGL_TARIF';
	$get_tarif_irja = mysql_query($sql_tarif_irja) or die(mysql_error());

	$sql_tarif_penunjang_irja = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_ipenunjang_tarif.KODE_CASH,t_ipenunjang_tarif.KODE_REKENING
				FROM t_ipenunjang 
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL 
				AND (m_tarif.MCU = "" OR m_tarif.MCU IS NULL) ';
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang_irja .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang_irja .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
	$sql_tarif_penunjang_irja .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
	$get_tarif_penunjang_irja = mysql_query($sql_tarif_penunjang_irja) or die(mysql_error());

	$sql_tarif_operasi_irja  = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *
					(CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
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
				t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
				t_operasi_tarif.KODE_CASH,t_operasi_tarif.KODE_REKENING
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_operasi_irja .= 'AND DATE(t_operasi_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_operasi_irja .= 'AND DATE(t_operasi_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_operasi_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
	$sql_tarif_operasi_irja  .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
	$get_tarif_operasi_irja = mysql_query($sql_tarif_operasi_irja) or die(mysql_error());	

	$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
					SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
					t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
					t_hemodialisa_tarif.KODE_CASH,t_hemodialisa_tarif.KODE_REKENING
					FROM t_hemodialisa 
					INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
					AND t_hemodialisa.JNS_ORDER = "IRJ"	
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa.ST_BATAL IS NULL ';
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_hemodialisa .= 'AND DATE(t_hemodialisa.TANGGAL_ORDER) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_hemodialisa .= 'AND DATE(t_hemodialisa.TANGGAL_ORDER) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_hemodialisa.TANGGAL_ORDER) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
	$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
					t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
					t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
					ORDER BY t_hemodialisa.TANGGAL_ORDER';
	$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
	$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
					t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
					t_ipenunjang_tarif.KODE_CASH,t_ipenunjang_tarif.KODE_REKENING
					FROM t_ipenunjang 
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")		
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';	
	
	$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
					ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
	$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

	$sql_ambulance_irja  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
					t_ambulance_tarif.KODE_CASH,t_ambulance_tarif.KODE_REKENING
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ' ;
	
	if($tgl_filter != '' and $tgl_filter2 == '') $sql_ambulance_irja .= 'AND DATE(t_ambulance_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
	if($tgl_filter != '' and $tgl_filter2 != '') $sql_ambulance_irja .= 'AND DATE(t_ambulance_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ambulance_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';	
	
	$sql_ambulance_irja  .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
					ORDER BY t_ambulance_tarif.TGL_TARIF';
	$get_ambulance_irja = mysql_query($sql_ambulance_irja) or die(mysql_error());						
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="40px">No</th>
	<th width="80px">No Kwitansi</th>
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
	while($dat_tarif_irja = mysql_fetch_array($get_tarif_irja)){
		$harga = 0;
		$status = $dat_tarif_irja['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_tarif_irja['HARGA'];
			$total_tagihan += $dat_tarif_irja['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_tarif_irja['HARGA'];	
		$no_bayar = $dat_tarif_irja['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_tarif_irja['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_irja['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_irja['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_irja['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_irja['NAMA_JAMINAN']; 
		if($dat_tarif_irja['KODE_CASH'] != '') echo ' /' . $dat_tarif_irja['KODE_CASH'];
		if($dat_tarif_irja['KODE_REKENING'] != '') echo ' /' . $dat_tarif_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_irja['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_irja_detail  = 'SELECT t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09"
								THEN (SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID)
							ELSE "" END AS NAMA_DOKTER,m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR	
							FROM t_irja_tarif
							INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" 
							AND t_irja_tarif.NO_TARIF = "' . $dat_tarif_irja['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "") 
							GROUP BY t_irja_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_irja_detail = mysql_query($sql_tarif_irja_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_irja_detail = mysql_fetch_array($get_tarif_irja_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php 
			$nama_tarif = $dat_tarif_irja_detail['NAMA_TARIF'] . ' (' . $dat_tarif_irja_detail['NAMA_TARIF_GROUP'] . ')';
			if(!empty($dat_tarif_irja_detail['NAMA_DOKTER'])) $nama_tarif = $nama_tarif . ', ' .$dat_tarif_irja_detail['NAMA_DOKTER']; 
			echo $nama_tarif; ?></td>
			<td align="right"><?php echo $dat_tarif_irja_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_irja_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_irja_detail['KUANTITI']); ?></td>
			<td align="center">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_irja_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_irja_detail['KUANTITI'];
					if($dat_tarif_irja_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_irja_detail['KUANTITI'];
					}
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){
						echo '<select id="rj_ch_' . $dat_tarif_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="rj_rk_' . $dat_tarif_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';

						if($dat_tarif_irja['KODE_TARIF_GROUP'] == '120'){ ?>
							<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_mcu(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
						<?php }else { ?>
							<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_irja(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
						<?php }
					$status_bayar_irja = true;
					} else { 
						if($dat_tarif_irja['KODE_TARIF_GROUP'] == '120'){ ?>
							<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_mcu(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>);return false;" />&nbsp;
							<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_mcu(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>);return false;"/>&nbsp;
							<select name="batal_mcu_<?php echo $dat_tarif_irja['NO_TARIF']; ?>" id="batal_mcu_<?php echo $dat_tarif_irja['NO_TARIF']; ?>" class="text_dt" >
							<option value=""></option>
							<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
							</select>
						<?php }else{ ?>
							<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_irja(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>);return false;" />&nbsp;
							<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_irja(<?php echo $idx; ?>,<?php echo $dat_tarif_irja['NO_TARIF']; ?>);return false;"/>&nbsp;
							<select name="batal_irj_<?php echo $dat_tarif_irja['NO_TARIF']; ?>" id="batal_irj_<?php echo $dat_tarif_irja['NO_TARIF']; ?>" class="text_dt" >
							<option value=""></option>
							<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
							</select>
				<?php } } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	/*****/
	while($dat_tarif_penunjang_irja = mysql_fetch_array($get_tarif_penunjang_irja)){
		$harga = 0;
		$status = $dat_tarif_penunjang_irja['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_tarif_penunjang_irja['HARGA'];
			$total_tagihan += $dat_tarif_penunjang_irja['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_tarif_penunjang_irja['HARGA'];
		$no_bayar = $dat_tarif_penunjang_irja['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_tarif_penunjang_irja['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_irja['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang_irja['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_irja['NAMA_JAMINAN']; 
		if($dat_tarif_penunjang_irja['KODE_CASH'] != '') echo ' /' . $dat_tarif_penunjang_irja['KODE_CASH'];
		if($dat_tarif_penunjang_irja['KODE_REKENING'] != '') echo ' /' . $dat_tarif_penunjang_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_penunjang_irja['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_irja_detail_penunjang  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang_irja['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")	
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_irja_detail_penunjang = mysql_query($sql_tarif_irja_detail_penunjang) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_penunjang_irja_detail = mysql_fetch_array($get_tarif_irja_detail_penunjang)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_irja_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_irja_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_irja_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_irja_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_irja_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_penunjang_irja_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_penunjang_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_irja_detail['KUANTITI'];
					if($dat_tarif_penunjang_irja_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_penunjang_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_irja_detail['KUANTITI'];
					}
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="pn_ch_' . $dat_tarif_penunjang_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="pn_rk_' . $dat_tarif_penunjang_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?>,<?php echo $harga; ?>,'irj');return false;" />
					<?php 
					$status_bayar_irja = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?>,'irj');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_pnj_<?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?>" id="batal_pnj_<?php echo $dat_tarif_penunjang_irja['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	//operasi
	while($dat_tarif_operasi_irja = mysql_fetch_array($get_tarif_operasi_irja)){
		$harga = 0;
		$status = $dat_tarif_operasi_irja['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_tarif_operasi_irja['HARGA'];
			$total_tagihan += $dat_tarif_operasi_irja['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_tarif_operasi_irja['HARGA'];
		$no_bayar = $dat_tarif_operasi_irja['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_tarif_operasi_irja['NO_TARIF'];
		$operasi_id = $dat_tarif_operasi_irja['OPERASI_ID'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi_irja['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_operasi_irja['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi_irja['NAMA_JAMINAN']; 
		if($dat_tarif_operasi_irja['KODE_CASH'] != '') echo ' /' . $dat_tarif_operasi_irja['KODE_CASH'];
		if($dat_tarif_operasi_irja['KODE_REKENING'] != '') echo ' /' . $dat_tarif_operasi_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_operasi_irja['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_operasi_irja_detail  = 'SELECT t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
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
							END AS TARIF_NON_KELAS,m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" 
							AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
							AND t_operasi_tarif.NO_TARIF = "' . $dat_tarif_operasi_irja['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_operasi_irja_detail = mysql_query($sql_tarif_operasi_irja_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_operasi_irja_detail = mysql_fetch_array($get_tarif_operasi_irja_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_operasi_irja_detail['NAMA_TARIF'] . ' (' . $dat_tarif_operasi_irja_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_operasi_irja_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_operasi_irja_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_operasi_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_irja_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_operasi_irja_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_tarif_operasi_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_irja_detail['KUANTITI'];
					if($dat_tarif_operasi_irja_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_tarif_operasi_irja_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_irja_detail['KUANTITI'];
					}
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="op_ch_' . $dat_tarif_operasi_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="op_rk_' . $dat_tarif_operasi_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
					<?php 
					$status_bayar_irja = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_opr_<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>" id="batal_opr_<?php echo $dat_tarif_operasi_irja['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	//end operasi
	//hemodialisa
	while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
		$harga = 0;
		$status = $dat_tarif_hemodialisa['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_tarif_hemodialisa['HARGA'];
			$total_tagihan += $dat_tarif_hemodialisa['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_tarif_hemodialisa['HARGA'];
		$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_tarif_hemodialisa['NO_TARIF'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_hemodialisa['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['NAMA_JAMINAN']; 
		if($dat_tarif_hemodialisa['KODE_CASH'] != '') echo ' /' . $dat_tarif_hemodialisa['KODE_CASH'];
		if($dat_tarif_hemodialisa['KODE_REKENING'] != '') echo ' /' . $dat_tarif_hemodialisa['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_hemodialisa_tarif.TARIF_ID,COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							m_tarif.NAMA_TARIF,m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
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
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="hd_ch_' . $dat_tarif_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="hd_rk_' . $dat_tarif_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
						?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,<?php echo $harga; ?>,'irj');return false;" />
					<?php 
					$status_bayar_irja = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,'hirj');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,'irj');return false;"/>&nbsp;
					<select name="batal_hmd_<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" id="batal_hmd_<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
		$harga = 0;
		$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_tarif_penunjang_hemodialisa['HARGA'];
			$total_tagihan += $dat_tarif_penunjang_hemodialisa['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_tarif_penunjang_hemodialisa['HARGA'];	
		$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_tarif_penunjang_hemodialisa['NO_TARIF'];
		$jnsorder = strtolower($dat_tarif_penunjang_hemodialisa['JNS_ORDER']);
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang_hemodialisa['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['NAMA_JAMINAN']; 
		if($dat_tarif_penunjang_hemodialisa['KODE_CASH'] != '') echo ' /' . $dat_tarif_penunjang_hemodialisa['KODE_CASH'];
		if($dat_tarif_penunjang_hemodialisa['KODE_REKENING'] != '') echo ' /' . $dat_tarif_penunjang_hemodialisa['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_penunjang_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
							AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"
							AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")	
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
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="pn_ch_' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="pn_rk_' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>,<?php echo $harga; ?>,'<?php echo $jnsorder; ?>');return false;" />
					<?php 
					$status_bayar_irja = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>,'<?php echo $jnsorder; ?>');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_pnj_<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" id="batal_pnj_<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}	
	//
	//ambulance irja
	while($dat_ambulance_irja = mysql_fetch_array($get_ambulance_irja)){
		$harga = 0;
		$status = $dat_ambulance_irja['ST_BAYAR'];
		if($status != 'Batal'){
			$harga = $dat_ambulance_irja['HARGA'];
			$total_tagihan += $dat_ambulance_irja['HARGA'];
		}
		if(strtolower($status) == 'lunas') $sudah_dibayar += $dat_ambulance_irja['HARGA'];	
		$no_bayar = $dat_ambulance_irja['NO_PEMBAYARAN'];
		$bayar_total_irja = $bayar_total_irja + $harga;
		$nomor_tarif_irna = $dat_ambulance_irja['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_ambulance_irja['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_ambulance_irja['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_ambulance_irja['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_ambulance_irja['NAMA_JAMINAN']; 
		if($dat_ambulance_irja['KODE_CASH'] != '') echo ' /' . $dat_ambulance_irja['KODE_CASH'];
		if($dat_ambulance_irja['KODE_REKENING'] != '') echo ' /' . $dat_ambulance_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_ambulance_irja['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_ambulance_irja_detail  = 'SELECT t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							"" AS NAMA_DOKTER,m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR	
							FROM t_ambulance_tarif
							INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" 
							AND t_ambulance_tarif.JNS_ORDER = "IRJ" 
							AND t_ambulance_tarif.NO_TARIF = "' . $dat_ambulance_irja['NO_TARIF'] . '"
							AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")
							GROUP BY t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_ambulance_irja_detail = mysql_query($sql_ambulance_irja_detail) or die(mysql_error());				
			$y = 1;
			while($dat_ambulance_irja_detail = mysql_fetch_array($get_ambulance_irja_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php 
			$nama_tarif = $dat_ambulance_irja_detail['NAMA_TARIF'] . ' (' . $dat_ambulance_irja_detail['NAMA_TARIF_GROUP'] . ')';
			if(!empty($dat_ambulance_irja_detail['NAMA_DOKTER'])) $nama_tarif = $nama_tarif . ', ' .$dat_ambulance_irja_detail['NAMA_DOKTER']; 
			echo $nama_tarif; ?></td>
			<td align="right"><?php echo $dat_ambulance_irja_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_ambulance_irja_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_ambulance_irja_detail['TARIF_NON_KELAS'] * $dat_ambulance_irja_detail['KUANTITI']); ?></td>
			<td align="center">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_ambulance_irja_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_ambulance_irja_detail['TARIF_NON_KELAS'] * $dat_ambulance_irja_detail['KUANTITI'];
					if($dat_ambulance_irja_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_ambulance_irja_detail['TARIF_NON_KELAS'] * $dat_ambulance_irja_detail['KUANTITI'];
					}
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						echo '<select id="ab_ch_' . $dat_ambulance_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="ab_rk_' . $dat_ambulance_irja['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance_irja['NO_TARIF']; ?>,<?php echo $harga; ?>,'irj');return false;" />
					<?php 
					$status_bayar_irja = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance_irja['NO_TARIF']; ?>,'irj');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance_irja['NO_TARIF']; ?>,'irj');return false;"/>&nbsp;
					<select name="batal_amb_<?php echo $dat_ambulance_irja['NO_TARIF']; ?>" id="batal_amb_<?php echo $dat_ambulance_irja['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	//end ambulance irja	
?>
<tr>
	<td colspan="8" align="right">Total Tindakan/ Pemeriksaan Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_irja); ?></td>
	<td colspan="4" align="center">&nbsp;</td>
</tr>  
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$sql_resep_irja  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';

if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep_irja .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep_irja .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
					
$sql_resep_irja  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP DESC';	
$get_resep_irja = mysql_query($sql_resep_irja) or die(mysql_error());					
?>
 <tr>
	<th width="40px">No</th>
	<th width="80px">No Resep</th>
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
	while($dat_resep_irja = mysql_fetch_array($get_resep_irja)){
		$no_resep = $dat_resep_irja['NO_RESEP'];
		$status = $dat_resep_irja['ST_BATAL'];
		$no_bayar = $dat_resep_irja['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep_irja['NO_RESEP']; ?></td>
		<td align="center"><?php echo $dat_resep_irja['TANGGAL_KELUAR']; ?></td>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?php echo $dat_resep_irja['NAMA_JAMINAN']; 
		if($dat_resep_irja['KODE_CASH'] != '') echo ' /' . $dat_resep_irja['KODE_CASH'];
		if($dat_resep_irja['KODE_REKENING'] != '') echo ' /' . $dat_resep_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_resep_irja['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep_irja['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep_irja['NO_PEMBAYARAN']) and in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						}else if(!in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			 $sql_resep_irja_detail = 'SELECT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
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
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_rajal_resep.NO_RESEP DESC';
			$get_detail_irja_resep = mysql_query($sql_resep_irja_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_irja_detail = mysql_fetch_array($get_detail_irja_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20px" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_irja_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_irja_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_irja_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']); ?></td>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	
				</tr>
				<?php
			 $y++; 
			if($status != '1'){
				$total = $total + ($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']); 
				$bayar_total_farmasi_irja = $bayar_total_farmasi_irja + ($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']);
			}	
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="3" align="center">
				<?php if($dat_resep_irja['ST_BATAL'] != '1'){
						$total_tagihan += $total;
						if(in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							if(empty($dat_resep_irja['NO_PEMBAYARAN'])){ 
								$status_bayar_irja = true;

								echo '<select id="fr_ch_' . $dat_resep_irja['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="fr_rk_' . $dat_resep_irja['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
						?>
								<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;" />
						<?php }else{ 
								$sudah_dibayar += $total;
						?>
								<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
								<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
								<select name="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" class="text_dt" >
								<option value=""></option>
								<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
								<?php } ?>
								</select>
						<?php }
						}else{ 
							//jaminan
						?>
						<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
						<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
						<select name="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" class="text_dt" >
						<option value=""></option>
						<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php } ?>
						</select>
					<?php	}	
					} ?>
				</td>
			</tr>
			<?php
	$i++;
	}
	
$sql_resep_irja  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep_irja .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep_irja .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';					
					
$sql_resep_irja .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP DESC';	
$get_resep_irja = mysql_query($sql_resep_irja) or die(mysql_error());					
while($dat_resep_irja = mysql_fetch_array($get_resep_irja)){
		$no_resep = $dat_resep_irja['NO_RESEP'];
		$status = $dat_resep_irja['ST_BATAL'];
		$no_bayar = $dat_resep_irja['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep_irja['NO_RESEP']; ?>-Hemodialisa</td>
		<td align="center"><?php echo $dat_resep_irja['TANGGAL_KELUAR']; ?></td>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?php echo $dat_resep_irja['NAMA_JAMINAN']; 
		if($dat_resep_irja['KODE_CASH'] != '') echo ' /' . $dat_resep_irja['KODE_CASH'];
		if($dat_resep_irja['KODE_REKENING'] != '') echo ' /' . $dat_resep_irja['KODE_REKENING']; ?></td>
		<td><?php echo $dat_resep_irja['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep_irja['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep_irja['NO_PEMBAYARAN']) and in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						}else if(!in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			 $sql_resep_irja_detail = 'SELECT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
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
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_rajal_resep.NO_RESEP DESC';
			$get_detail_irja_resep = mysql_query($sql_resep_irja_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_irja_detail = mysql_fetch_array($get_detail_irja_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20px" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_irja_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_irja_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_irja_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']); ?></td>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	
				</tr>
				<?php
			$y++; 
			if($status != '1'){
				$total = $total + ($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']); 
				$bayar_total_farmasi_irja = $bayar_total_farmasi_irja + ($dat_resep_irja_detail['JUMLAH_KELUAR'] * $dat_resep_irja_detail['HARGA_JUAL']);
			}
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="3" align="center">
				<?php if($dat_resep_irja['ST_BATAL'] != '1'){
						$total_tagihan += $total;
						if(in_array($dat_resep_irja['JAMINAN_ID'],getArrNonJaminan())){
							if(empty($dat_resep_irja['NO_PEMBAYARAN'])){ 
								$status_bayar_irja = true;

								echo '<select id="fr_ch_' . $dat_resep_irja['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="fr_rk_' . $dat_resep_irja['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
						?>
								<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;" />
						<?php }else{ 
								$sudah_dibayar += $total;
						?>
								<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
								<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
								<select name="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" class="text_dt" >
								<option value=""></option>
								<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
								<?php } ?>
								</select>
						<?php }
						}else{ 
							//jaminan
						?>
						<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
						<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep_irja['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
						<select name="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep_irja['NO_PENGELUARAN']; ?>" class="text_dt" >
						<option value=""></option>
						<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php } ?>
						</select>
					<?php	}	
					} ?>
				</td>
			</tr>
			<?php
	$i++;
	}	
?>
<tr>
	<td colspan="8" align="right">Total Farmasi Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_farmasi_irja); ?></td>
	<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="8" align="right">Total Pembayaran Poliklinik/ IGD Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_irja + $bayar_total_farmasi_irja); ?></td>
	<td colspan="3" align="center">
	<?php if($status_bayar_irja){ 
		echo '<select id="al_ch" class="text_dt" style="width:60px;" >';
		foreach ($arr_cash as $row) {
			echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
		}
		echo '</select>&nbsp;';

		echo '<select id="al_rk" class="text_dt" style="width:60px;" >';
		echo '<option value=""> - </option>';
		foreach ($arr_rekening as $row) {
			echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
		}
		echo '</select>&nbsp;&nbsp;';	
	?>
	<input type="button" class="myButton" value="bayar semua [IRJ]" onclick="javascript : bayar_irja_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />	
	<?php } ?>
	</td>
</tr>  
<tr>
	<td colspan="8" align="right"><input type="radio" name="pr_rj" id="pr_rj_1" value="1" checked />Semua
	<input type="radio" name="pr_rj" id="pr_rj_2" value="2" />Belum Diprint</td>
	<td colspan="3" align="center">
	<input type="button" class="myButton" value="print semua [IRJ]" onclick="javascript : print_irja_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />&nbsp;
	<input type="button" class="myButton" value="batal semua [IRJ]" onclick="javascript : batal_irja_all(<?php echo $idx; ?>);return false;"/>&nbsp;
	<select name="batal_semua" id="batal_semua" class="text_dt" >
	<option value=""></option>
	<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>  
</table>
<br />
<?php 
//end rawat jalan - IGD	
} 
?>
<!-- start pembayaran irna -->
<?php 
$bayar_total_irna = 0;			
$bayar_total_farmasi_irna = 0;		
$status_bayar_irna = false;	

if($ruang_tindakan == '' or $ruang_tindakan_k == '2'){
	
$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

$sql_tarif  = 'SELECT DISTINCT t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				SUM(t_irna_tarif.KUANTITI *(
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
							END 
						END)
				) AS HARGA,t_irna_tarif.ST_BAYAR,
				t_irna_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.KELAS_JAMINAN,
				t_irna_tarif.KODE_CASH,t_irna_tarif.KODE_REKENING
				FROM t_irna_tarif 
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF IS NOT NULL ';

if($ruang_tindakan_i != '') $sql_tarif .= 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif .= 'AND DATE(t_irna_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif .= 'AND DATE(t_irna_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_irna_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';

$sql_tarif .= 'GROUP BY t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				t_irna_tarif.ST_BAYAR,t_irna_tarif.USER_KASIR
				ORDER BY t_irna_tarif.TGL_TARIF';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_ipenunjang_tarif.KODE_CASH,t_ipenunjang_tarif.KODE_REKENING
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
			
if($ruang_tindakan_i != '') $sql_tarif_penunjang .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	

$sql_tarif_operasi  = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
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
				t_operasi_tarif.KELAS_JAMINAN,
				t_operasi_tarif.KODE_CASH,t_operasi_tarif.KODE_REKENING
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2") ';
				
if($ruang_tindakan_i != '') $sql_tarif_operasi .= 'AND t_operasi.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_operasi .= 'AND DATE(t_operasi_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_operasi .= 'AND DATE(t_operasi_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_operasi_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
				t_hemodialisa_tarif.KODE_CASH,t_hemodialisa_tarif.KODE_REKENING
				FROM t_hemodialisa 
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL ';

if($ruang_tindakan_i != '') $sql_tarif_hemodialisa .= 'AND t_hemodialisa.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_hemodialisa .= 'AND DATE(t_hemodialisa.TANGGAL_ORDER) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_hemodialisa .= 'AND DATE(t_hemodialisa.TANGGAL_ORDER) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_hemodialisa.TANGGAL_ORDER) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	

$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.KODE_CASH,t_ipenunjang_tarif.KODE_REKENING
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
if($ruang_tindakan_i != '') $sql_tarif_penunjang_hemodialisa .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());	

$sql_ambulance_irna  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
					t_ambulance_tarif.KODE_CASH,t_ambulance_tarif.KODE_REKENING
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
if($ruang_tindakan_i != '') $sql_ambulance_irna .= 'AND t_ambulance_tarif.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_ambulance_irna .= 'AND DATE(t_ambulance_tarif.TGL_TARIF) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_ambulance_irna .= 'AND DATE(t_ambulance_tarif.TGL_TARIF) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_ambulance_tarif.TGL_TARIF) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_ambulance_irna  .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
					ORDER BY t_ambulance_tarif.TGL_TARIF';
$get_ambulance_irna = mysql_query($sql_ambulance_irna) or die(mysql_error());	
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="40px">No</th>
	<th width="80px">No Kwitansi</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Tindakan/ Pemeriksaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="50px">Kelas</th>
	<th width="100px">Pembayaran</th>
	<th width="100px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
		$status = $dat_tarif['ST_BAYAR'];
		$nomor_tarif_irna = $dat_tarif['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif['KELAS_RAWAT']; ?></td>
		<td align="center"><?php echo $dat_tarif['NAMA_JAMINAN'] . ' [' . $dat_tarif['KELAS_RAWAT'] . ']'; 
		if($dat_tarif['KODE_CASH'] != '') echo ' /' . $dat_tarif['KODE_CASH'];
		if($dat_tarif['KODE_REKENING'] != '') echo ' /' . $dat_tarif['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_irna_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_irna_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							m_tarif.TARIF_NON_KELAS,
							m_tarif.TARIF_KELAS_3, 
							m_tarif.TARIF_KELAS_2,
							m_tarif.TARIF_KELAS_1,
							m_tarif.TARIF_KELAS_UTAMA,
							m_tarif.TARIF_KELAS_UTAMA_2,
							m_tarif.TARIF_HCU,
							m_tarif.TARIF_ICU,
							m_tarif.TARIF_NICU,
							m_tarif.TARIF_PICU,
							m_tarif.TARIF_ICCU,
							m_tarif.TARIF_PERINA,
							m_tarif.TARIF_KELAS_PERINA_SEHAT,
							m_tarif.TARIF_KELAS_PERINA_SAKIT,
							t_irna_tarif.KELAS_RAWAT,t_irna_tarif.KELAS_JAMINAN,m_tarif_group.NON_KELAS,
							m_kelas_rawat.BOBOT AS BOBOT_RAWAT,m_kelas_rawat2.BOBOT AS BOBOT_JAMINAN,
							m_tarif.TDK_KLAIM,t_irna_tarif.TDK_KLAIM_BAYAR
							FROM t_irna_tarif
							INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_kelas_rawat ON (t_irna_tarif.KELAS_RAWAT = m_kelas_rawat.KELAS_RAWAT) 
							LEFT JOIN m_kelas_rawat m_kelas_rawat2 ON (t_irna_tarif.KELAS_JAMINAN = m_kelas_rawat2.KELAS_RAWAT) 
							WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
							GROUP BY t_irna_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0; 
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_detail['NAMA_TARIF'] . ' (' . $dat_tarif_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = 0;
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == '3') $tarif = $dat_tarif_detail['TARIF_KELAS_3'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == '2') $tarif = $dat_tarif_detail['TARIF_KELAS_2'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == '1') $tarif = $dat_tarif_detail['TARIF_KELAS_1'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'UTAMA') $tarif = $dat_tarif_detail['TARIF_KELAS_UTAMA'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'VIP') $tarif = $dat_tarif_detail['TARIF_KELAS_UTAMA'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'UTAMA 2') $tarif = $dat_tarif_detail['TARIF_KELAS_UTAMA_2'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'VVIP') $tarif = $dat_tarif_detail['TARIF_KELAS_UTAMA_2'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'HCU') $tarif = $dat_tarif_detail['TARIF_HCU'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'ICU') $tarif = $dat_tarif_detail['TARIF_ICU'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'NICU') $tarif = $dat_tarif_detail['TARIF_NICU'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'PICU') $tarif = $dat_tarif_detail['TARIF_PICU'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'ICCU') $tarif = $dat_tarif_detail['TARIF_ICCU'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'PERINA') $tarif = $dat_tarif_detail['TARIF_PERINA'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'BAYI SEHAT') $tarif = $dat_tarif_detail['TARIF_KELAS_PERINA_SEHAT'];
				if(strtoupper($dat_tarif_detail['KELAS_RAWAT']) == 'BAYI SAKIT') $tarif = $dat_tarif_detail['TARIF_KELAS_PERINA_SAKIT'];
				
				if(strtoupper($dat_tarif_detail['NON_KELAS']) == '1') $tarif = $dat_tarif_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_tarif_detail['KUANTITI']); 
				if($status != 'Batal'){
					$harga = $harga + ($tarif * $dat_tarif_detail['KUANTITI']); 
					$bayar_total_irna = $bayar_total_irna + ($tarif * $dat_tarif_detail['KUANTITI']); 
				} ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php 
			if($status != 'Batal'){
				if($dat_tarif_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $tarif * $dat_tarif_detail['KUANTITI'];
					if($dat_tarif_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $tarif * $dat_tarif_detail['KUANTITI'];
					}
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
				
					if($no_bayar == ''){ 
						echo '<select id="ri_ch_' . $dat_tarif['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="ri_rk_' . $dat_tarif['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_irna(<?php echo $irna_id; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi(<?php echo $irna_id; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar(<?php echo $irna_id; ?>,<?php echo $dat_tarif['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_iri_<?php echo $dat_tarif['NO_TARIF']; ?>" id="batal_iri_<?php echo $dat_tarif['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	} 
	
	while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
		$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
		$status = $dat_tarif_penunjang['ST_BAYAR'];
		if($status != 'Batal') $bayar_total_irna = $bayar_total_irna + $dat_tarif_penunjang['HARGA'];
		$nomor_tarif_irna = $dat_tarif_penunjang['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang['DESKRIPSI']; ?></td>
		<td>Non Kelas</td>
		<td align="center"><?php echo $dat_tarif_penunjang['NAMA_JAMINAN']; 
		if($dat_tarif_penunjang['KODE_CASH'] != '') echo ' /' . $dat_tarif_penunjang['KODE_CASH'];
		if($dat_tarif_penunjang['KODE_REKENING'] != '') echo ' /' . $dat_tarif_penunjang['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_penunjang['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "IRN"	
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0;
			while($dat_tarif_penunjang_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = $dat_tarif_penunjang_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_tarif_penunjang_detail['KUANTITI']); 
				if($status != 'Batal') $harga = $harga + ($tarif * $dat_tarif_penunjang_detail['KUANTITI']); 
				?></td>
			<td align="right">&nbsp;</td>
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
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
				
					if($no_bayar == ''){ 
						echo '<select id="pn_ch_' . $dat_tarif_penunjang['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="pn_rk_' . $dat_tarif_penunjang['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>,<?php echo $harga; ?>,'irn');return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>,'irn');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_pnj_<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>" id="batal_pnj_<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
		$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
		$status = $dat_tarif_operasi['ST_BAYAR'];
		$nomor_tarif_irna = $dat_tarif_operasi['NO_TARIF'];					
		$operasi_id = $dat_tarif_operasi['OPERASI_ID'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_operasi['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['KELAS_RAWAT']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['NAMA_JAMINAN'] . ' [' . $dat_tarif_operasi['KELAS_RAWAT'] . ']'; 
		if($dat_tarif_operasi['KODE_CASH'] != '') echo ' /' . $dat_tarif_operasi['KODE_CASH'];
		if($dat_tarif_operasi['KODE_REKENING'] != '') echo ' /' . $dat_tarif_operasi['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_operasi['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_operasi_detail  = 'SELECT t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							m_tarif.TARIF_NON_KELAS,
							m_tarif.TARIF_KELAS_3, 
							m_tarif.TARIF_KELAS_2,
							m_tarif.TARIF_KELAS_1,
							m_tarif.TARIF_KELAS_UTAMA,
							m_tarif.TARIF_KELAS_UTAMA_2,
							m_tarif.TARIF_HCU,
							m_tarif.TARIF_ICU,
							m_tarif.TARIF_NICU,
							m_tarif.TARIF_PICU,
							m_tarif.TARIF_ICCU,
							m_tarif.TARIF_PERINA,
							m_tarif.TARIF_KELAS_PERINA_SEHAT,
							m_tarif.TARIF_KELAS_PERINA_SAKIT,
							t_operasi_tarif.KELAS_RAWAT,t_operasi_tarif.KELAS_JAMINAN,m_tarif_group.NON_KELAS,
							m_kelas_rawat.BOBOT AS BOBOT_RAWAT,m_kelas_rawat2.BOBOT AS BOBOT_JAMINAN,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_kelas_rawat ON (t_operasi_tarif.KELAS_RAWAT = m_kelas_rawat.KELAS_RAWAT) 
							LEFT JOIN m_kelas_rawat m_kelas_rawat2 ON (t_operasi_tarif.KELAS_JAMINAN = m_kelas_rawat2.KELAS_RAWAT) 
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" 
							AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
							AND t_operasi_tarif.NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"
							GROUP BY t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_operasi_detail = mysql_query($sql_tarif_operasi_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0; 
			while($dat_tarif_operasi_detail = mysql_fetch_array($get_tarif_operasi_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['NAMA_TARIF'] . ' (' . $dat_tarif_operasi_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_operasi_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = 0;
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == '3') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_3'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == '2') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_2'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == '1') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_1'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'UTAMA') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_UTAMA'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'VIP') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_UTAMA'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'UTAMA 2') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_UTAMA_2'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'VVIP') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_UTAMA_2'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'HCU') $tarif = $dat_tarif_operasi_detail['TARIF_HCU'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'ICU') $tarif = $dat_tarif_operasi_detail['TARIF_ICU'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'NICU') $tarif = $dat_tarif_operasi_detail['TARIF_NICU'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'PICU') $tarif = $dat_tarif_operasi_detail['TARIF_PICU'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'ICCU') $tarif = $dat_tarif_operasi_detail['TARIF_ICCU'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'PERINA') $tarif = $dat_tarif_operasi_detail['TARIF_PERINA'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'BAYI SEHAT') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_PERINA_SEHAT'];
				if(strtoupper($dat_tarif_operasi_detail['KELAS_RAWAT']) == 'BAYI SAKIT') $tarif = $dat_tarif_operasi_detail['TARIF_KELAS_PERINA_SAKIT'];
				
				if(strtoupper($dat_tarif_operasi_detail['NON_KELAS']) == '1') $tarif = $dat_tarif_operasi_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_tarif_operasi_detail['KUANTITI']); 
				if($status != 'Batal'){
					$harga = $harga + ($tarif * $dat_tarif_operasi_detail['KUANTITI']); 
					$bayar_total_irna = $bayar_total_irna + ($tarif * $dat_tarif_operasi_detail['KUANTITI']); 
				} ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_tarif_operasi_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $tarif * $dat_tarif_detail['KUANTITI'];
					if($dat_tarif_operasi_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $tarif * $dat_tarif_detail['KUANTITI'];
					}
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
				
					if($no_bayar == ''){ 
						echo '<select id="op_ch_' . $dat_tarif_operasi['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="op_rk_' . $dat_tarif_operasi['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_opr_<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" id="batal_opr_<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
		$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
		$status = $dat_tarif_hemodialisa['ST_BAYAR'];
		if($status != 'Batal') $bayar_total_irna = $bayar_total_irna + $dat_tarif_hemodialisa['HARGA'];
		$nomor_tarif_irna = $dat_tarif_hemodialisa['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_hemodialisa['DESKRIPSI']; ?></td>
		<td>Non Kelas</td>
		<td align="center"><?php echo $dat_tarif_hemodialisa['NAMA_JAMINAN']; 
		if($dat_tarif_hemodialisa['KODE_CASH'] != '') echo ' /' . $dat_tarif_hemodialisa['KODE_CASH'];
		if($dat_tarif_hemodialisa['KODE_REKENING'] != '') echo ' /' . $dat_tarif_hemodialisa['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_hemodialisa_tarif.TARIF_ID,COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							m_tarif.NAMA_TARIF,m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
							FROM t_hemodialisa
							INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
							INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"
							AND t_hemodialisa.JNS_ORDER = "IRN"	
							GROUP BY t_hemodialisa_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0;
			while($dat_tarif_hemodialisa_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_hemodialisa_detail['NAMA_TARIF'] . ' (' . $dat_tarif_hemodialisa_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_hemodialisa_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_hemodialisa_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = $dat_tarif_hemodialisa_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_tarif_hemodialisa_detail['KUANTITI']); 
				if($status != 'Batal') $harga = $harga + ($tarif * $dat_tarif_hemodialisa_detail['KUANTITI']); 
			?></td>
			<td align="right">&nbsp;</td>
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
				}
			}   
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
					
					if($no_bayar == ''){ 
						echo '<select id="hd_ch_' . $dat_tarif_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="hd_rk_' . $dat_tarif_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,<?php echo $harga; ?>,'irn');return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,'hirn');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_hemodialisa(<?php echo $idx; ?>,<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>,'irn');return false;"/>&nbsp;
					<select name="batal_hmd_<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" id="batal_hmd_<?php echo $dat_tarif_hemodialisa['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
		$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
		$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
		if($status != 'Batal') $bayar_total_irna = $bayar_total_irna + $dat_tarif_penunjang_hemodialisa['HARGA'];
		$nomor_tarif_irna = $dat_tarif_penunjang_hemodialisa['NO_TARIF'];					
		$jnsorder = strtolower($dat_tarif_penunjang_hemodialisa['JNS_ORDER']);
		?>
		<tr>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang_hemodialisa['DESKRIPSI']; ?></td>
		<td>Non Kelas</td>
		<td align="center"><?php echo $dat_tarif_penunjang_hemodialisa['NAMA_JAMINAN']; 
		if($dat_tarif_penunjang_hemodialisa['KODE_CASH'] != '') echo ' /' . $dat_tarif_penunjang_hemodialisa['KODE_CASH'];
		if($dat_tarif_penunjang_hemodialisa['KODE_REKENING'] != '') echo ' /' . $dat_tarif_penunjang_hemodialisa['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_penunjang_hemodialisa['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"
							AND (t_ipenunjang.JNS_ORDER = "HRI"	OR t_ipenunjang.JNS_ORDER = "ORI")	
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0;
			while($dat_tarif_penunjang_hemodialisa_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_hemodialisa_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_hemodialisa_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_hemodialisa_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_hemodialisa_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = $dat_tarif_penunjang_hemodialisa_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_tarif_penunjang_hemodialisa_detail['KUANTITI']); 
				if($status != 'Batal') $harga = $harga + ($tarif * $dat_tarif_penunjang_hemodialisa_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
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
				}
			} 
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
					
					if($no_bayar == ''){ 
						echo '<select id="pn_ch_' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="pn_rk_' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>,<?php echo $harga; ?>,'<?php echo $jnsorder; ?>');return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>,'<?php echo $jnsorder; ?>');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_penunjang(<?php echo $idx; ?>,<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_pnj_<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" id="batal_pnj_<?php echo $dat_tarif_penunjang_hemodialisa['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	//ambulace irna
	while($dat_ambulance_irna = mysql_fetch_array($get_ambulance_irna)){
		$no_bayar = $dat_ambulance_irna['NO_PEMBAYARAN'];
		$status = $dat_ambulance_irna['ST_BAYAR'];
		if($status != 'Batal') $bayar_total_irna = $bayar_total_irna + $dat_ambulance_irna['HARGA'];
		$nomor_tarif_irna = $dat_ambulance_irna['NO_TARIF'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_ambulance_irna['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_ambulance_irna['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_ambulance_irna['DESKRIPSI']; ?></td>
		<td>Non Kelas</td>
		<td align="center"><?php echo $dat_ambulance_irna['NAMA_JAMINAN']; 
		if($dat_ambulance_irna['KODE_CASH'] != '') echo ' /' . $dat_ambulance_irna['KODE_CASH'];
		if($dat_ambulance_irna['KODE_REKENING'] != '') echo ' /' . $dat_ambulance_irna['KODE_REKENING']; ?></td>
		<td><?php echo $dat_ambulance_irna['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_ambulance_irna_detail  = 'SELECT t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09"
								THEN (SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_ambulance_tarif.PEGAWAI_ID)
							ELSE "" END AS NAMA_DOKTER,m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR	
							FROM t_ambulance_tarif
							INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN" 
							AND t_ambulance_tarif.NO_TARIF = "' . $dat_ambulance_irna['NO_TARIF'] . '"
							GROUP BY t_ambulance_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_ambulace_irna_detail = mysql_query($sql_ambulance_irna_detail) or die(mysql_error());				
			$y = 1;
			$harga = 0;
			while($dat_ambulace_irna_detail = mysql_fetch_array($get_ambulace_irna_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_ambulace_irna_detail['NAMA_TARIF'] . ' (' . $dat_ambulace_irna_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_ambulace_irna_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_ambulace_irna_detail['SATUAN']; ?></td>
			<td align="right"><?php $tarif = $dat_ambulace_irna_detail['TARIF_NON_KELAS']; 
				echo currFormat($tarif * $dat_ambulace_irna_detail['KUANTITI']); 
				if($status != 'Batal') $harga = $harga + ($tarif * $dat_ambulace_irna_detail['KUANTITI']); 
			?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php if($status != 'Batal'){
				if($dat_ambulace_irna_detail['TDK_KLAIM'] == '1'){
					$tidak_diklaim += $dat_ambulace_irna_detail['TARIF_NON_KELAS'] * $dat_ambulace_irna_detail['KUANTITI'];
					if($dat_ambulace_irna_detail['TDK_KLAIM_BAYAR'] != ''){
						$tidak_diklaim_bayar += $dat_ambulace_irna_detail['TARIF_NON_KELAS'] * $dat_ambulace_irna_detail['KUANTITI'];
					}
				}
			}  
		
		$y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="4" align="center"><?php if($status != 'Batal'){ 
					$total_tagihan += $harga;
					if(strtolower($status) == 'lunas') $sudah_dibayar += $harga;	
					
					if($no_bayar == ''){ 
						echo '<select id="ab_ch_' . $dat_ambulance['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select id="ab_rk_' . $dat_ambulance['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance['NO_TARIF']; ?>,<?php echo $harga; ?>,'irn');return false;" />
					<?php 
					$status_bayar_irna = true;
					} else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance['NO_TARIF']; ?>,'irn');return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_ambulance(<?php echo $idx; ?>,<?php echo $dat_ambulance['NO_TARIF']; ?>,'irn');return false;"/>&nbsp;
					<select name="batal_amb_<?php echo $dat_ambulance['NO_TARIF']; ?>" id="batal_amb_<?php echo $dat_ambulance['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	//end ambulance irna
?>
<tr>
	<td colspan="8" align="right">Total Tindakan/ Pemeriksaan Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_irna); ?></td>
	<td colspan="4" align="center">&nbsp;</td>
</tr> 
<?php	
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());	

$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
if($ruang_tindakan_i != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';
	
$sql_resep  .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
$get_resep = mysql_query($sql_resep) or die(mysql_error());	
?> 
 <tr>
	<th>No</th>
	<th>No Resep</th>
	<th>Tanggal</th>
	<th colspan="2">Persediaan</th>
	<th>Jumlah</th>
	<th>Satuan</th>
	<th>Harga</th>
	<th>Kelas</th>
	<th>Pembayaran</th>
	<th>Register</th>
	<th>Status</th>
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
		<td colspan="6">&nbsp;</td>
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; 
		if($dat_resep['KODE_CASH'] != '') echo ' /' . $dat_resep['KODE_CASH'];
		if($dat_resep['KODE_REKENING'] != '') echo ' /' . $dat_resep['KODE_REKENING']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN']) and in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						}else if(!in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			 $sql_resep_detail = 'SELECT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
					GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_ranap_resep.NO_RESEP DESC';
			$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
				<td>&nbsp;</td>
				</tr>
				<?php
			$y++; 
			if($status != '1'){
				$total = $total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); 
				$bayar_total_farmasi_irna = $bayar_total_farmasi_irna + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']);
			}	
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="4" align="center">
				<?php if($dat_resep['ST_BATAL'] != '1'){
						$total_tagihan += $total;
						if(in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							if(empty($dat_resep['NO_PEMBAYARAN'])){ 
								$status_bayar_irna = true;

								echo '<select id="fr_ch_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="fr_rk_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
						?>
								<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
						<?php }else{ 
								$sudah_dibayar += $total;
						?>
								<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
								<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
								<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
								<option value=""></option>
								<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
								<?php } ?>
								</select>
						<?php }
						}else{ ?>
							<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
							<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
							<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
							<option value=""></option>
							<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
							</select>
						<?php }
					} ?>
				</td>
			</tr>
			<?php
	$i++;
	}

$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.KODE_CASH,t_farmasi_apotik_pengeluaran.KODE_REKENING
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
if($ruang_tindakan_i != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan_i . '" ';				
if($tgl_filter != '' and $tgl_filter2 == '') $sql_resep .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) = STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y") ';
if($tgl_filter != '' and $tgl_filter2 != '') $sql_resep .= 'AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND DATE(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR) <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y") ';

	
$sql_resep .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
$get_resep = mysql_query($sql_resep) or die(mysql_error());	
while($dat_resep = mysql_fetch_array($get_resep)){
		$no_resep = $dat_resep['NO_RESEP'];
		$status = $dat_resep['ST_BATAL'];
		$no_bayar = $dat_resep['NO_PEMBAYARAN'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><?php echo $dat_resep['NO_RESEP']; ?></td>
		<td align="center"><?php echo $dat_resep['TANGGAL_KELUAR']; ?></td>
		<td colspan="6">&nbsp;</td>
		<td align="center"><?php echo $dat_resep['NAMA_JAMINAN']; 
		if($dat_resep['KODE_CASH'] != '') echo ' /' . $dat_resep['KODE_CASH'];
		if($dat_resep['KODE_REKENING'] != '') echo ' /' . $dat_resep['KODE_REKENING']; ?></td>
		<td><?php echo $dat_resep['USER_PEMBAYARAN']; ?></td>
		<td align="center"><?php if($dat_resep['ST_BATAL'] == '1'){ 
							echo 'Batal';
						}else if(!empty($dat_resep['NO_PEMBAYARAN']) and in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						}else if(!in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							echo 'Lunas';
						} ?></td>
		</tr>
		<?php
			 $sql_resep_detail = 'SELECT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_RESEP = "' . $no_resep . '" 
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
					GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,
					t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,m_persediaan_farmasi.NAMA_PERSEDIAAN,
					m_persediaan_farmasi.SATUAN,t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID
					ORDER BY t_ranap_resep.NO_RESEP DESC';
			$get_detail_resep = mysql_query($sql_resep_detail) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_resep_detail = mysql_fetch_array($get_detail_resep)){
				?>
				<tr>
				<td colspan="3">&nbsp;</td>	
				<td width="20" align="center"><?php echo $y; ?></td>
				<td><?php echo $dat_resep_detail['NAMA_PERSEDIAAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR']); ?></td>
				<td><?php echo $dat_resep_detail['SATUAN']; ?></td>
				<td align="right"><?php echo currFormat($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<?php
			$y++; 
			if($status != '1'){
				$total = $total + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']); 
				$bayar_total_farmasi_irna = $bayar_total_farmasi_irna + ($dat_resep_detail['JUMLAH_KELUAR'] * $dat_resep_detail['HARGA_JUAL']);
			}	
			}
			?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="4" align="center">
				<?php if($dat_resep['ST_BATAL'] != '1'){
						$total_tagihan += $total;
						if(in_array($dat_resep['JAMINAN_ID'],getArrNonJaminan())){
							if(empty($dat_resep['NO_PEMBAYARAN'])){ 
								$status_bayar_irna = true;

								echo '<select id="fr_ch_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="fr_rk_' . $dat_resep['NO_PENGELUARAN'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
						?>
								<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;" />
						<?php }else{ 
								$sudah_dibayar += $total;
						?>
								<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
								<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
								<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
								<option value=""></option>
								<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
								<?php } ?>
								</select>
						<?php }
						}else{ ?>
							<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>);return false;" />&nbsp;
							<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_farmasi(<?php echo $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID']; ?>,<?php echo $dat_resep['NO_PENGELUARAN']; ?>);return false;"/>&nbsp;
							<select name="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" id="batal_fms_<?php echo $dat_resep['NO_PENGELUARAN']; ?>" class="text_dt" >
							<option value=""></option>
							<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
							</select>
						<?php }
					} ?>
				</td>
			</tr>
			<?php
	$i++;
	}	
?> 
<tr>
	<td colspan="8" align="right">Total Farmasi Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_farmasi_irna); ?></td>
	<td colspan="4" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="8" align="right">Total Pembayaran Rawat Inap Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_irna + $bayar_total_farmasi_irna); ?></td>
	<td colspan="4" align="center">
	<?php if($status_bayar_irna){ 
		echo '<select id="an_ch" class="text_dt" style="width:60px;" >';
		foreach ($arr_cash as $row) {
			echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
		}
		echo '</select>&nbsp;';

		echo '<select id="an_rk" class="text_dt" style="width:60px;" >';
		echo '<option value=""> - </option>';
		foreach ($arr_rekening as $row) {
			echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
		}
		echo '</select>&nbsp;&nbsp;';
	?>
	<input type="button" class="myButton" value="bayar semua [IRI]" onclick="javascript : bayar_irna_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>','<?php echo $ruang_tindakan; ?>');return false;" />	
	<?php } ?>
	</td>
</tr>
<tr>
	<td colspan="8" align="right"><input type="radio" name="pr_rn" id="pr_ri_1" value="1" checked />Semua
	<input type="radio" name="pr_rn" id="pr_ri_2" value="2" />Belum Diprint</td>
	<td colspan="4" align="center">
	<input type="button" class="myButton" value="print semua [IRI]" onclick="javascript : print_irna_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>','<?php echo $ruang_tindakan_i; ?>');return false;" />
	<input type="button" class="myButton" value="batal semua [IRI]" onclick="javascript : batal_irna_all(<?php echo $idx; ?>);return false;"/>&nbsp;
	<select name="batal_semua_iri" id="batal_semua_iri" class="text_dt" >
	<option value=""></option>
	<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
	<?php } ?>
	</select>
	</td>
</tr>
<?php if($ruang_tindakan == ''){?>
<tr>
	<td colspan="8" align="right">Total Pembayaran Poliklinik/ IGD & Rawat Inap Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($bayar_total_irja + $bayar_total_farmasi_irja + $bayar_total_irna + $bayar_total_farmasi_irna); ?></td>
	<td colspan="4" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="8" align="right"><input type="radio" name="pr_all" id="pr_all_1" value="1" checked />Semua
	<input type="radio" name="pr_all" id="pr_all_2" value="2" />Belum Diprint</td>
	<td colspan="4" align="center">
	<input type="button" class="myButton" value="print semua [IRJ + IRI]" onclick="javascript : print_all(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />
	</td>
</tr>
<?php }
if($tidak_diklaim > 0 and !in_array($jenis_bayar_id,getArrNonJaminan())){ ?>
<tr>
	<td colspan="8" align="right">Tidak Diklaim Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($tidak_diklaim); ?></td>
	<td colspan="4" align="center">
	<?php $sisa = $tidak_diklaim - $tidak_diklaim_bayar; 
	if($sisa > 0){ 
		echo '<select id="kl_ch" class="text_dt" style="width:60px;" >';
			foreach ($arr_cash as $row) {
				echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
			}
			echo '</select>&nbsp;';

			echo '<select id="kl_rk" class="text_dt" style="width:60px;" >';
			echo '<option value=""> - </option>';
			foreach ($arr_rekening as $row) {
				echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
			}
			echo '</select>&nbsp;&nbsp;';
	?>
			<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_tidak_diklaim(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />
	<?php }else{ ?>		
			<input type="button" class="myButton" value="print tidak diklaim" onclick="javascript : print_tidak_diklaim(<?php echo $idx; ?>,'<?php echo $tgl_filter; ?>','<?php echo $tgl_filter2; ?>');return false;" />&nbsp;
	<?php } ?>			
	</td>
</tr>
<?php } 

if($cost_sharing > 0){ 
 $total_bayar_irja_irna = $bayar_total_irja + $bayar_total_farmasi_irja + $bayar_total_irna + $bayar_total_farmasi_irna;
 $sisa_bayar = $total_bayar_irja_irna - $cost_sharing; 
?>
<tr>
	<td colspan="8" align="right">Cost Sharing Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($cost_sharing); ?></td>
	<td colspan="4" align="center">
	&nbsp;
	</td>
</tr>
<tr>
	<td colspan="8" align="right">Sisa Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($sisa_bayar); ?></td>
	<td colspan="4" align="center">
	<input type="button" class="myButton" value="print [CS]" onclick="javascript : print_cs(<?php echo $idx; ?>);return false;" />
	</td>
</tr>
<?php } ?>
</table>
<?php } ?>
</div>
</div>
<?php
$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());
	
if($tgl_filter == '' and $tgl_filter2 == '' and $ruang_tindakan == ''){
	if(in_array($jenis_bayar_id,getArrNonJaminan())) $sisa_tagihan = $total_tagihan - $sudah_dibayar;
	if(!in_array($jenis_bayar_id,getArrNonJaminan())) $sisa_tagihan = $tidak_diklaim - $tidak_diklaim_bayar;
	
	if($sisa_tagihan == 0){
		mysql_query('UPDATE t_irna SET ST_LUNAS = "1" WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());	
	}else{
		mysql_query('UPDATE t_irna SET ST_LUNAS = NULL WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());
	}
}	
?>
<div id="bayar"></div>
<script language="JavaScript" >
<?php if(!in_array($jenis_bayar_id,getArrNonJaminan())){ ?>
document.getElementById("total_tagihan").innerHTML= "<?php echo currFormat($total_tagihan); ?>";
document.getElementById("tidak_diklaim").innerHTML= "<?php echo currFormat($tidak_diklaim); ?>";
document.getElementById("sudah_dibayar").innerHTML= "<?php echo currFormat($tidak_diklaim_bayar); ?>";
document.getElementById("sisa_tagihan").innerHTML= "<?php echo currFormat($tidak_diklaim - $tidak_diklaim_bayar); ?>";
<?php }else{ 
$sql_deposit = 'SELECT SUM(JUMLAH_DEPOSIT) AS DEPOSIT FROM t_deposit
		WHERE RAWAT_ID = "' . $idx . '" AND ST_BATAL IS NULL';
$get_deposit = mysql_query($sql_deposit) or die(mysql_error());
$dat_deposit = mysql_fetch_assoc($get_deposit);
$deposit = $dat_deposit['DEPOSIT'];		
$sisa_dibayarkan = $total_tagihan - $sudah_dibayar - $deposit;	
?>
document.getElementById("total_tagihan").innerHTML= "<?php echo currFormat($total_tagihan); ?>";
document.getElementById("sudah_dibayar").innerHTML= "<?php echo currFormat($sudah_dibayar); ?>";
document.getElementById("sisa_tagihan").innerHTML= "<?php echo currFormat($total_tagihan - $sudah_dibayar); ?>";
document.getElementById("deposit").innerHTML= "<?php echo currFormat($deposit); ?> / <?php echo currFormat($sisa_dibayarkan); ?>";
<?php } ?>
function selesai(link){
window.location = link;
}
function pasien_pulang(idx){
 if(confirm('Pasien Pulang?')){
	MyAjaxRequest('bayar','index.php?ajaxrequest=pasienpulang&idx=' + idx);
	alert('Simpan Pasien Pulang Berhasil.');
	<?php if($jns_pembayaran == 'JKN'){
		echo 'updatePulang("' . $nosep . '","' . $tanggal_pulang . '",0);';
	} ?>
	document.getElementById('bt_pasien_pulang').style.display = 'none';
 }
}
function bayar_irna(idx,no,harga){
 var kode_cash = document.getElementById("ri_ch_" + no).value;
 var kode_rekening = document.getElementById("ri_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarirna&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}
function print_kwitansi(idx,no){
 <?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>	
	window.open('http://localhost/nsimrs_print/print_pembayaran_irna.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php }else{ ?>
	window.open('http://localhost/nsimrs_print/print_pembayaran_irna.php?idx=' + idx + '&no=' + no + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php } ?>
}
function batal_bayar(idx, no){
	var jns_batal = document.getElementById("batal_iri_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{	
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarirna&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}

function print_irna_all(idx,tgl1,tgl2,ruang){
	var print_y = false;
	var optprint = '';
	
	if(document.getElementById('pr_ri_1').checked){
		optprint = '1';
	}	
	if(document.getElementById('pr_ri_2').checked){
		optprint = '2';
	}	
	
	if(optprint != ''){
		if(optprint == '1'){
			if(confirm('Print Semua ?')){
				print_y = true;
			}
		}
		
		if(optprint == '2'){
			if(confirm('Print Yang Belum ?')){
				print_y = true;
			}
		}
	}
	
	if(optprint != '' && print_y){
		window.open('http://localhost/nsimrs_print/print_pembayaran_irna_all.php?idx=' + idx + '&no=<?php echo $nomor_tarif_irna; ?>' + '&user=<?php echo $userkasir; ?>&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&ruang=' + ruang + '&opt=' + optprint,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');	
	}
}

function bayar_farmasi(idx,no){
 var kode_cash = document.getElementById("fr_ch_" + no).value;
 var kode_rekening = document.getElementById("fr_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){		
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarfarmasi&idx=' + idx + '&no=' + no + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function batal_bayar_farmasi(idx, no){
	var jns_batal = document.getElementById("batal_fms_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarfarmasi&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}

function bayar_irja(idx,no,harga){
 var kode_cash = document.getElementById("rj_ch_" + no).value;
 var kode_rekening = document.getElementById("rj_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarirja&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }	
}

function print_kwitansi_irja(idx,no){
<?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>		
	window.open('http://localhost/nsimrs_print/print_pembayaran_irja.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
<?php }else{ ?>
	window.open('http://localhost/nsimrs_print/print_pembayaran_irja.php?idx=' + idx + '&no=' + no  + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php } ?> 
}

function batal_bayar_irja(idx, no){
	var jns_batal = document.getElementById("batal_irj_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{	
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarirja&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}
	}	
}

function bayar_penunjang(idx,no,harga,ord){
 var kode_cash = document.getElementById("pn_ch_" + no).value;
 var kode_rekening = document.getElementById("pn_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarpenunjang&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ord=' + ord  + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function print_kwitansi_penunjang(idx,no,ord){
<?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>		
 window.open('http://localhost/nsimrs_print/print_pembayaran_penunjang.php?idx=' + idx + '&no=' + no + '&ord=' + ord,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
<?php }else{ ?>
	window.open('http://localhost/nsimrs_print/print_pembayaran_penunjang.php?idx=' + idx + '&no=' + no + '&ord=' + ord  + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php } ?> 
}

function batal_bayar_penunjang(idx, no){
	var jns_batal = document.getElementById("batal_pnj_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarpenunjang&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}
	}	
}

function print_irja_all(idx,tgl1,tgl2){
	var print_y = false;
	var optprint = '';
	
	if(document.getElementById('pr_rj_1').checked){
		optprint = '1';
	}	
	if(document.getElementById('pr_rj_2').checked){
		optprint = '2';
	}	
	
	if(optprint != ''){
		if(optprint == '1'){
			if(confirm('Print Semua ?')){
				print_y = true;
			}
		}
		
		if(optprint == '2'){
			if(confirm('Print Yang Belum ?')){
				print_y = true;
			}
		}
	}
	
	if(optprint != '' && print_y){
		window.open('http://localhost/nsimrs_print/print_pembayaran_irja_all.php?idx=' + idx + '&no=<?php echo $nomor_tarif_irna; ?>' + '&user=<?php echo $userkasir; ?>&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&opt=' + optprint,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');	
	}	
}

function print_cs(idx){
	window.open('http://localhost/nsimrs_print/print_pembayaran_irna_cs.php?idx=' + idx + '&no=<?php echo $nomor_tarif_irna; ?>' + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');	
}

function bayar_operasi(idx,no,harga){
 var kode_cash = document.getElementById("op_ch_" + no).value;
 var kode_rekening = document.getElementById("op_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayaroperasi&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }	
}

function print_kwitansi_operasi(idx,no){
	<?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>		
		window.open('http://localhost/nsimrs_print/print_pembayaran_operasi.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	<?php }else{ ?>
		window.open('http://localhost/nsimrs_print/print_pembayaran_operasi.php?idx=' + idx + '&no=' + no + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php } ?> 		
}

function batal_bayar_operasi(idx, no){
	var jns_batal = document.getElementById("batal_opr_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayaroperasi&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}

function bayar_hemodialisa(idx,no,harga,ord){
 var kode_cash = document.getElementById("hd_ch_" + no).value;
 var kode_rekening = document.getElementById("hd_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarhemodialisa&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ord=' + ord + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function print_kwitansi_hemodialisa(idx,no,ord){
 <?php if(in_array($jenis_bayar_id,getArrNonJaminan())){ ?>
	window.open('http://localhost/nsimrs_print/print_pembayaran_penunjang.php?idx=' + idx + '&no=' + no + '&ord=' + ord,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php }else{ ?>
	window.open('http://localhost/nsimrs_print/print_pembayaran_penunjang.php?idx=' + idx + '&no=' + no + '&ord=' + ord + '&user=<?php echo $userkasir; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
 <?php } ?>			
}

function batal_bayar_hemodialisa(idx, no,ord){
	var jns_batal = document.getElementById("batal_hmd_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarhemodialisa&idx=' + idx + '&no=' + no  + '&ord=' + ord + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}

function print_all(idx,tgl1,tgl2){
	var print_y = false;
	var optprint = '';
	
	if(document.getElementById('pr_all_1').checked){
		optprint = '1';
	}	
	if(document.getElementById('pr_all_2').checked){
		optprint = '2';
	}
	
	
	if(optprint != ''){
		if(optprint == '1'){
			if(confirm('Print Semua ?')){
				print_y = true;
			}
		}
		
		if(optprint == '2'){
			if(confirm('Print Yang Belum ?')){
				print_y = true;
			}
		}
	}
	
	if(optprint != '' && print_y){
		window.open('http://localhost/nsimrs_print/print_pembayaran_all.php?idx=' + idx + '&no=<?php echo $nomor_tarif_irna; ?>' + '&user=<?php echo $userkasir; ?>&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&opt=' + optprint,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');	
	}
}

function bayar_ambulance(idx,no,harga,ord){
 var kode_cash = document.getElementById("ab_ch_" + no).value;
 var kode_rekening = document.getElementById("ab_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarambulance&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ord=' + ord + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function print_kwitansi_ambulance(idx,no,ord){
 window.open('http://localhost/nsimrs_print/print_pembayaran_ambulance.php?idx=' + idx + '&no=' + no + '&ord=' + ord + '&user=<?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}

function batal_bayar_ambulance(idx, no,jn){
	var jns_batal = document.getElementById("batal_amb_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarambulance&idx=' + idx + '&no=' + no + '&ord=' + jn + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}

function bayar_irja_all(idx,tgl1,tgl2){
 var kode_cash = document.getElementById("al_ch").value;
 var kode_rekening = document.getElementById("al_rk").value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarirjaall&idx=' + idx + '&kasir=<?php echo $kasir; ?>&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }	
}

function bayar_irna_all(idx,tgl1,tgl2,ruang){
 var kode_cash = document.getElementById("an_ch").value;
 var kode_rekening = document.getElementById("an_rk").value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){		
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarirnaall&idx=' + idx + '&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&ruang=' + ruang + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function print_kwitansi_farmasi(idx){
	window.open('http://localhost/nsimrs_print/print_pembayaran_farmasi.php?idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}

function bayar_mcu(idx,no,harga){
 var kode_cash = document.getElementById("rj_ch_" + no).value;
 var kode_rekening = document.getElementById("rj_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){		
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarmcunew&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }	
}

function print_kwitansi_mcu(idx,no){
	window.open('http://localhost/nsimrs_print/print_pembayaran_mcu.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');		
}

function batal_bayar_mcu(idx, no){
var jns_batal = document.getElementById("batal_mcu_" + no).value;
if(jns_batal == ''){
	alert('Pilih Jenis Batal.');	
}else{		
	if(confirm(no +' Dibatalkan ?')){
		MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarmcu&idx=' + idx + '&no=' + no  + '&st=' + jns_batal);	
		alert('Simpan Data Pembatalan Berhasil.');
		window.location = '<?php echo currentURl(); ?>';
	}	
 }	
}

function bayar_tidak_diklaim(idx,tgl1,tgl2){
 var kode_cash = document.getElementById("kl_ch").value;
 var kode_rekening = document.getElementById("kl_rk").value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayartidakdiklaimirna&idx=' + idx + '&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}

function print_tidak_diklaim(idx,tgl1,tgl2){
	window.open('http://localhost/nsimrs_print/print_pembayaran_irna_tidak_diklaim.php?idx=' + idx + '&no=<?php echo $nomor_tarif_irna; ?>' + '&user=<?php echo $userkasir; ?>&tgl1=' + tgl1 + '&tgl2=' + tgl2,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');		
}

function batal_irja_all(idx){
	var jns_batal = document.getElementById("batal_semua").value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm('Batalkan Pembayaran 1 Jam Terakhir ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalirjaall&idx=' + idx + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}
	}	
}

function batal_irna_all(idx){
	var jns_batal = document.getElementById("batal_semua_iri").value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm('Batalkan Pembayaran ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalirnaall&idx=' + idx + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			//window.location = '<?php echo currentURl(); ?>';
		}
	}	
}
</script>  
<?php } ?>