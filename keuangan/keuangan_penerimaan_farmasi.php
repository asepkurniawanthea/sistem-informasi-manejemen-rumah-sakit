<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportfarmasi_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportfarmasi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportfarmasi_tgl_2']))
    $tgl_2 = $_SESSION['pembayaranreportfarmasi_tgl_2'];
	
$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportfarmasi_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportfarmasi_jns_bayar'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportfarmasi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportfarmasi_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportfarmasi_jns_bayar'] = $_GET['jns_bayar'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Jenis Pembayaran</td>
            <td>
			<select name="jns_bayar" class="text_dt" style="width:160px;" >
			<?php echo getJnsBayar($jns_bayar,'1');?>
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
<table width="100%" border="1" class="tableData" id="tfhover">
   <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Jenis Bayar</th>
	<th rowspan="2">NOMR</th>
    <th rowspan="2">Nama Pasien</th>
	<th rowspan="2">Nama Unit/ Ruang </th>
    <th rowspan="2">Tgl Masuk </th>
    <th rowspan="2">Tgl Keluar</th>
	<th colspan="2">Depo Umum</th>
	<th colspan="2">Depo IGD</th>
	<th colspan="2">Depo Kusta</th>
	<th colspan="2">Pengembalian</th>
	<th rowspan="2">Jumlah</th>
	<th rowspan="2">Jam Kerja</th>
  </tr>
   <tr>
     <th>Jumlah</th>
     <th>Biaya</th>
     <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
   </tr>
<?php $no = 1; 
$depo_umum = 0;
$depo_igd = 0;
$depo_kusta = 0;
$pengembalian = 0;
$total = 0;
$qry_pembayaran = 'SELECT t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				SUM(CASE WHEN t_bayar_main.DEPO = "20" THEN t_bayar_main.JML_FARMASI ELSE 0 END) AS JML_DEPO_RAJAL,
				SUM(CASE WHEN t_bayar_main.DEPO = "20" THEN t_bayar_main.HARGA_FARMASI ELSE 0 END) AS HARGA_DEPO_RAJAL,
				SUM(CASE WHEN t_bayar_main.DEPO = "21" THEN t_bayar_main.JML_FARMASI ELSE 0 END) AS JML_DEPO_IGD,
				SUM(CASE WHEN t_bayar_main.DEPO = "21" THEN t_bayar_main.HARGA_FARMASI ELSE 0 END) AS HARGA_DEPO_IGD,
				SUM(CASE WHEN t_bayar_main.DEPO = "22" THEN t_bayar_main.JML_FARMASI ELSE 0 END) AS JML_DEPO_KUSTA,
				SUM(CASE WHEN t_bayar_main.DEPO = "22" THEN t_bayar_main.HARGA_FARMASI ELSE 0 END) AS HARGA_DEPO_KUSTA,
				SUM(t_bayar_main.JML_PENGEMBALIAN) AS JML_PENGEMBALIAN,
				SUM(t_bayar_main.HARGA_PENGEMBALIAN) AS HARGA_PENGEMBALIAN,
				t_bayar_main.TGL_BAYAR,
				t_bayar_main.SHIFT
				FROM (
					SELECT t_bayar_l2.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l2.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l2.TGL_MASUK,t_bayar_l2.TGL_KELUAR,
					SUM(t_bayar_l2.JML_FARMASI) AS JML_FARMASI,
					SUM(t_bayar_l2.HARGA_FARMASI) AS HARGA_FARMASI,
					SUM(t_bayar_l2.JML_PENGEMBALIAN) AS JML_PENGEMBALIAN,
					SUM(t_bayar_l2.HARGA_PENGEMBALIAN) AS HARGA_PENGEMBALIAN,
					t_bayar_l2.KASIR,
					t_bayar_l2.TGL_BAYAR,
					t_bayar_l2.SHIFT,
					t_bayar_l2.DEPO
					FROM (
						-- farmasi igd
						SELECT "FMS" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.UNIT_ID AS DEPO,
						0 AS JML_PENGEMBALIAN,
						0 AS HARGA_PENGEMBALIAN
						FROM db_simrs.t_irja igd
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID IN (' . $arr_igd . ')
						' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY igd.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end farmasi igd
						
						-- farmasi rawat jalan
						UNION ALL
						SELECT "FMS" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.UNIT_ID AS DEPO,
						0 AS JML_PENGEMBALIAN,
						0 AS HARGA_PENGEMBALIAN
						FROM db_simrs.t_irja irj
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
						' . (($jns_bayar != '1') ? 'AND DATE(fms.TANGGAL_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_KELUAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irj.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end farmasi rawat jalan
						
						-- farmasi rawat inap
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,NULL AS UNIT_ID,fms.RUANG_ID,
						DATE_FORMAT(irn.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.UNIT_ID AS DEPO,
						0 AS JML_PENGEMBALIAN,
						0 AS HARGA_PENGEMBALIAN
						FROM db_simrs.t_irna irn
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irn.IRNA_ID = fms.RANAP_ID 
						AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "2")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end farmasi rawat inap
						
						-- pengembalian igd
						UNION ALL
						SELECT "FMS" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI, 0 AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID AS DEPO,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_PENGEMBALIAN,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_PENGEMBALIAN
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irja igd
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID IN (' . $arr_igd . ')
						' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY igd.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end pengembalian igd	
						
						-- pengembalian rawat jalan
						UNION ALL
						SELECT "FMS" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI, 0 AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KEMBALI,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID AS DEPO,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_PENGEMBALIAN,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_PENGEMBALIAN
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irja irj
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
						' . (($jns_bayar != '1') ? 'AND DATE(fms.TANGGAL_KEMBALI) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_KEMBALI) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irj.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end pengembalian rawat jalan
						
						-- pengembalian rawat inap
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,NULL AS UNIT_ID,fms.RUANG_ID,
						DATE_FORMAT(irn.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI, 0 AS HARGA_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID AS DEPO,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_PENGEMBALIAN,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_PENGEMBALIAN
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irna irn
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "2")
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN,
						fms.UNIT_ID
						-- end pengembalian rawat inap
					) t_bayar_l2
					INNER JOIN db_simrs.m_jaminan jmn
					ON (t_bayar_l2.JENIS_BAYAR_ID = jmn.JAMINAN_ID)
					INNER JOIN db_simrs.m_pasien psn
					ON (t_bayar_l2.NOMR = psn.NOMR)
					LEFT JOIN db_simrs.m_unit unt
					ON (t_bayar_l2.UNIT_ID = unt.UNIT_ID)
					LEFT JOIN db_simrs.m_ruang rng
					ON (t_bayar_l2.RUANG_ID = rng.RUANG_ID)	
					GROUP BY t_bayar_l2.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l2.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l2.TGL_MASUK,t_bayar_l2.TGL_KELUAR,
					t_bayar_l2.KASIR,t_bayar_l2.TGL_BAYAR,t_bayar_l2.SHIFT,
					t_bayar_l2.DEPO
					UNION ALL
					SELECT CONCAT("y",fms.FARMASI_PENGELUARAN_APOTIK_ID) AS RAWAT_ID,jmn.NAMA_JAMINAN,
					fms.NIK AS NOMR,fms.NAMA_PELANGGAN AS NAMA_PASIEN,"APS" AS NAMA_UNIT,
					NULL AS NAMA_RUANG,DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
					DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
					COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
					SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
					0 AS JML_PENGEMBALIAN,
					0 AS HARGA_PENGEMBALIAN,
					SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
					' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
					'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
					fms.SHIFT_PEMBAYARAN AS SHIFT,
					fms.UNIT_ID AS DEPO
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
					ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_simrs.m_jaminan jmn
					ON (1 = jmn.JAMINAN_ID)
					WHERE fms.NO_PENGELUARAN IS NOT NULL 
					AND fms.JENIS_PENGELUARAN = "3"
					' . (($jns_bayar != '1') ? 'AND fms.FARMASI_PENGELUARAN_APOTIK_ID = "xyz"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
					GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID
				) t_bayar_main
				GROUP BY t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				t_bayar_main.TGL_BAYAR,
				t_bayar_main.SHIFT
				ORDER BY t_bayar_main.RAWAT_ID';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){ 
$nama_unit = '';
if($dat_pembayaran['NAMA_UNIT'] != '') $nama_unit = $dat_pembayaran['NAMA_UNIT'];
if($dat_pembayaran['NAMA_RUANG'] != '') $nama_unit = $dat_pembayaran['NAMA_RUANG'];

$depo_umum += $dat_pembayaran['HARGA_DEPO_RAJAL'];
$depo_igd += $dat_pembayaran['HARGA_DEPO_IGD'];
$depo_kusta += $dat_pembayaran['HARGA_DEPO_KUSTA'];
$pengembalian += $dat_pembayaran['HARGA_PENGEMBALIAN'];
$subtotal = ($dat_pembayaran['HARGA_DEPO_RAJAL'] + $dat_pembayaran['HARGA_DEPO_IGD'] + $dat_pembayaran['HARGA_DEPO_KUSTA']) - $dat_pembayaran['HARGA_PENGEMBALIAN'];
$total += $subtotal;
if($dat_pembayaran['HARGA_DEPO_RAJAL'] + $dat_pembayaran['HARGA_DEPO_IGD'] + $dat_pembayaran['HARGA_DEPO_KUSTA'] + $dat_pembayaran['HARGA_PENGEMBALIAN'] > 0){
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['NAMA_JAMINAN']; ?></td>
    <td><?php echo ((strlen($dat_pembayaran['NOMR']) == 6) ? formatNomr($dat_pembayaran['NOMR']) : $dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
    <td><?php echo $nama_unit; ?></td>
	<td><?php echo $dat_pembayaran['TGL_MASUK']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_KELUAR']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_DEPO_RAJAL']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_DEPO_RAJAL']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_DEPO_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_DEPO_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_DEPO_KUSTA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_DEPO_KUSTA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PENGEMBALIAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PENGEMBALIAN']); ?></td>
	<td align="right"><?php echo currFormat($subtotal); ?></td>
	<td align="center"><?php $jam_kerja = $dat_pembayaran['TGL_BAYAR'];
					if($dat_pembayaran['SHIFT'] != '') $jam_kerja .= ' ['.$dat_pembayaran['SHIFT'] . ']'; 
					echo $jam_kerja; ?></td>
  </tr>
 <?php 
 
$no++; } } ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" colspan="2"><?php echo currFormat($depo_umum); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($depo_igd); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($depo_kusta); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($pengembalian); ?></td>
	<td align="right"><?php echo currFormat($total); ?></td>
	<td align="center">&nbsp;</td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_penerimaan_farmasi.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_farmasi.xls" />            
</form>
