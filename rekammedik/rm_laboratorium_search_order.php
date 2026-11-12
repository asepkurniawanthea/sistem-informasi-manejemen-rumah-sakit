<?php
$tgl_1 = '';
if (isset($_SESSION['laboratoriumsearchorder_tgl_1']))
    $tgl_1 = $_SESSION['laboratoriumsearchorder_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['laboratoriumsearchorder_tgl_1']))
    $tgl_2 = $_SESSION['laboratoriumsearchorder_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['laboratoriumsearchorder_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['laboratoriumsearchorder_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['laboratoriumsearchorder_searchkey']))
		$searchkey = $_SESSION['laboratoriumsearchorder_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['laboratoriumsearchorder_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['laboratoriumsearchorder_ruang_id']))
		$ruang_id = $_SESSION['laboratoriumsearchorder_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['laboratoriumsearchorder_ruang_id'] = $ruang_id;
}
$unit_id = '';
if (isset($_SESSION['laboratoriumsearchorder_unit_id']))
		$unit_id = $_SESSION['laboratoriumsearchorder_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['laboratoriumsearchorder_unit_id'] = $unit_id;
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
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Poliklinik</td>
			<td> <select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getUnit('umumigd',$unit_id); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DISTINCT t_order.*,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.NAMA_PASIEN ELSE t_ipenunjang.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.TGL_LAHIR ELSE t_ipenunjang.TGL_LAHIR END AS TGL_LAHIR,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.ALAMAT ELSE t_ipenunjang.ALAMAT END AS ALAMAT,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pegawai.NAMA_PEGAWAI ELSE t_ipenunjang.PENGIRIM END AS NAMA_PEGAWAI, 
				m_jaminan.NAMA_JAMINAN,CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM,
				CASE WHEN t_order.JNS_ORDER IN ("IRJ","HRJ","ORJ") THEN t_irja.ST_BARU ELSE "" END AS ST_BARU,
				CASE WHEN t_order.JNS_ORDER IN ("HRJ","HRI") THEN "Hemodialisa"
					WHEN t_order.JNS_ORDER IN ("ORJ","ORI") THEN "Kamar Operasi" END AS EXT_NAMA_UNIT
				FROM (
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				CASE WHEN t_ipenunjang.UNIT_ID = 50 THEN NULL ELSE t_ipenunjang.UNIT_ID END AS UNIT_ID,
				t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,t_ipenunjang.PEGAWAI_ID,
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d/%m/%Y") AS TANGGAL_ORDER_NW,
				DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d/%m/%Y") AS TANGGAL_PERIKSA_NW,
				t_ipenunjang.USER_CM
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER <> "APS"
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang.JNS_ORDER,t_ipenunjang_tarif.NO_TARIF
				UNION ALL
				SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				"" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,NULL AS PEGAWAI_ID,
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d/%m/%Y") AS TANGGAL_ORDER_NW,
				DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d/%m/%Y") AS TANGGAL_PERIKSA_NW,
				t_ipenunjang.USER_CM
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
				GROUP BY t_ipenunjang.PENUNJANG_ID
				) t_order 
				INNER JOIN m_jaminan ON (t_order.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pasien ON (t_order.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_order.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_irja ON (t_order.PENUNJANG_ID = t_irja.IRJA_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND (t_order.NOMR LIKE "%' . $searchkey . '%"
										OR m_pasien.NAMA_PASIEN LIKE "%' . $searchkey . '%"
										OR t_ipenunjang.NAMA_PASIEN LIKE "%' . $searchkey . '%")';
}		
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.RUANG_ID = "' . $ruang_id . '" AND 
			(t_order.JNS_ORDER = "IRN" OR t_order.JNS_ORDER = "HRI" OR t_order.JNS_ORDER = "ORI")';
}
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $unit_id . '" AND 
			(t_order.JNS_ORDER = "IRJ" OR t_order.JNS_ORDER = "HRJ" OR t_order.JNS_ORDER = "ORJ")';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY F_ORDER';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('laboratoriumformpemeriksaan') . '&idx=###" >proses</a>';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Order</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Klinik/Ruang/Instansi</th>
		<th>Dokter Pengirim</th>
        <th>Pembayaran</th>
		<th>Tgl Order Baru</th>
		<th>Tgl Periksa Baru</th>
		<th>Register</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PENUNJANG_ID'];
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6){ echo formatNoMR($data['NOMR']); }else{ echo $data['NOMR']; } ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php $nama_unit = $data['NAMA_UNIT'];
			if($nama_unit == '') $nama_unit = $data['NAMA_RUANG'];
			if($nama_unit == '') $nama_unit = $data['INSTANSI_PENGIRIM'];
			if($data['EXT_NAMA_UNIT'] != '') $nama_unit .= '-' . $data['EXT_NAMA_UNIT'];
			echo $nama_unit; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN'];  ?></td>
			<td><?php echo $data['TANGGAL_ORDER_NW'];  ?></td>
			<td><?php echo $data['TANGGAL_PERIKSA_NW'];  ?></td>
			<td><?php echo $data['USER_CM']; ?></td>
            <td align="center">
			<a href="index.php?link=ab9f87c13ef339aa3b4464abb8305fba&idx=<?php echo $id; ?>&ord=<?php echo strtolower($data['JNS_ORDER']); ?>&no=<?php echo $data['NO_TARIF']; ?>" >ubah</a>
			</td>
        </tr>
        <?
    }
    ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>