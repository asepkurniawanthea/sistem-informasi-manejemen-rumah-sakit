<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_2']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
	
$penyetor = '';
if (isset($_SESSION['pembayaranreportrekapbayar_penyetor']))
    $penyetor = $_SESSION['pembayaranreportrekapbayar_penyetor'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['penyetor'])) {
    $penyetor = $_GET['penyetor'];
    $_SESSION['pembayaranreportrekapbayar_penyetor'] = $_GET['penyetor'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Penyetor</td>
            <td>
			<select name="penyetor" class="text_dt" style="width:228px;" >
			<option value="" > - </option>
			<?php $sql = 'SELECT DISTINCT m_pegawai.NAMA_PEGAWAI
						FROM m_app_modul
						INNER JOIN m_app_user ON (m_app_modul.MODUL_ID = m_app_user.MODUL_ID)
						INNER JOIN m_pegawai ON (m_app_user.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE m_app_modul.NAMA_MODUL = "Kasir"
						ORDER BY m_pegawai.NAMA_PEGAWAI';
				  $get = mysql_query($sql) or die(mysql_error());	 
				  while($dat = mysql_fetch_array($get)){
					?>
					<option value="<?php echo $dat['NAMA_PEGAWAI']; ?>" <?php if($penyetor == $dat['NAMA_PEGAWAI']) echo 'selected="selected"'; ?>><?php echo $dat['NAMA_PEGAWAI']; ?></option>
					<?php
				  }
				  ?>
			</select></td>
       </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_REQUEST['kasir']; ?>" />
</form>
<br />
<?php
if(isset($_GET['kasir'])){
	$kasir = $_GET['kasir'];
	if($_GET['kasir'] == 'umum') $qry_filter = ' AND t_irja.UNIT_ID <> "9" AND t_irja.UNIT_ID <> "35" AND t_irja.UNIT_ID <> "34" AND t_irja.UNIT_ID <> "42" AND t_irja.UNIT_ID <> "40" AND t_irja.UNIT_ID <> "31"';
	if($_GET['kasir'] == 'igd') $qry_filter = ' AND t_irja.UNIT_ID = "9"'; 
	if($_GET['kasir'] == 'kusta') $qry_filter = ' AND (t_irja.UNIT_ID = "35" OR t_irja.UNIT_ID = "34" OR t_irja.UNIT_ID = "42" OR t_irja.UNIT_ID = "40" OR t_irja.UNIT_ID = "31")'; 
}

$qry_filter_user = '';
if(!empty($penyetor)){
	$qry_filter_user = 'AND t_irja_tarif.USER_KASIR LIKE "%' . $penyetor . '"';
}

if($kasir == 'igd'){
$qry_kunjungan = 'SELECT * FROM (SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja_tarif.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP = "01"
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				UNION 
				SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja_tarif.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND (m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09") 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				UNION
				SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja_tarif.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF_GROUP <> "02" AND m_tarif.KODE_TARIF_GROUP <> "09" 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				) t_penerimaan
				ORDER BY NAMA_UNIT,TARIF_ID';
}else{
$qry_kunjungan = 'SELECT * FROM (SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP = "01"
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				UNION 
				SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND (m_tarif.KODE_TARIF_GROUP = "02" OR m_tarif.KODE_TARIF_GROUP = "09") 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				UNION
				SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) <= 12 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" AND CAST(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%H") AS UNSIGNED) >= 18 THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_irja_tarif.ST_BAYAR = "Lunas" ' . $qry_filter . '
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF_GROUP <> "02" AND m_tarif.KODE_TARIF_GROUP <> "09" 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT
				) t_penerimaan
				ORDER BY NAMA_UNIT,TARIF_ID';	
}				
				
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
   <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Unit</th>
    <th rowspan="2">Tarif</th>
	<th rowspan="2">Group Tarif</th>
    <th colspan="4">Jumlah</th>
    <th colspan="4">Rupiah</th>
  </tr>
  <tr>
    <th>Shift 1 </th>
    <th>Shift 2 </th>
    <th>Shift 3 Am</th>
	<th>Shift 3 Pm</th>
    <th>Shift 1 </th>
    <th>Shift 2</th>
    <th>Shift 3 Am</th>
	<th>Shift 3 Pm</th>
  </tr>
<?php $no = 1; 
$total_1 = 0;
$total_2 = 0;
$total_3 = 0;
$total_3_b = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_TARIF']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_TARIF_GROUP']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_TARIF_1']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_TARIF_2']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_TARIF_3']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_TARIF_3_B']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_RUPIAH_1']); 
	$total_1 = $total_1 + $dat_kunjungan['JUMLAH_RUPIAH_1']; ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_RUPIAH_2']); 
	$total_2 = $total_2 + $dat_kunjungan['JUMLAH_RUPIAH_2']; ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_RUPIAH_3']); 
	$total_3 = $total_3 + $dat_kunjungan['JUMLAH_RUPIAH_3']; ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['JUMLAH_RUPIAH_3_B']); 
	$total_3_b = $total_3_b + $dat_kunjungan['JUMLAH_RUPIAH_3_B']; ?></td>
  </tr>
 <?php $no++; } ?>
<tr>
    <td colspan="8" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total_1); ?></td>
	<td align="right"><?php echo currFormat($total_2); ?></td>
	<td align="right"><?php echo currFormat($total_3); ?></td>
	<td align="right"><?php echo currFormat($total_3_b); ?></td>
  </tr> 
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_GET['kasir']; ?>" />
	<input type="hidden" name="penyetor" value="<?php echo $penyetor; ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_rekap_klinik.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_rajal.xls" />            
</form>
