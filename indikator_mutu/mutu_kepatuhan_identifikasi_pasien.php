<style>
.list_isi{
	height:550px;
}
</style>
<?php
function setVal($vl){
	$ret = $vl;
	if($vl == '') $ret = 'NA';
	return $ret;
}
$tgl_1 = '';
if (isset($_SESSION['kepatuhanidentifikasipasien_tgl_1']))
    $tgl_1 = $_SESSION['kepatuhanidentifikasipasien_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kepatuhanidentifikasipasien_tgl_1']))
    $tgl_2 = $_SESSION['kepatuhanidentifikasipasien_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kepatuhanidentifikasipasien_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kepatuhanidentifikasipasien_tgl_2'] = $_GET['tgl_2'];
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
    <table class="tableform" border="0">
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>	
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = '	SELECT DATE_FORMAT(TGL_OBSERVASI,"%d/%m/%Y") AS TGL_OBSERVASI,
				NOMR,NAMA_PASIEN,mun.NAMA_UNIT,mur.NAMA_RUANG,
				SUM(PEMBERIAN_OBAT) AS PEMBERIAN_OBAT,
				SUM(PEMBERIAN_NUTRISI) AS PEMBERIAN_NUTRISI,
				SUM(PEMBERIAN_DARAH)AS PEMBERIAN_DARAH,
				SUM(PENGAMBILAN_SPESIMEN) AS PENGAMBILAN_SPESIMEN,
				SUM(SEBELUM_TINDAKAN) AS SEBELUM_TINDAKAN
				FROM (
					SELECT t_kip.RAWAT_ID,t_kip.NOMR,psn.NAMA_PASIEN,
					t_kip.TGL_OBSERVASI,
					t_kip.UNIT_ID,
					t_kip.RUANG_ID,
					t_kip.PEMBERIAN_OBAT,
					t_kip.PEMBERIAN_NUTRISI,	
					t_kip.PEMBERIAN_DARAH,
					t_kip.PENGAMBILAN_SPESIMEN,
					t_kip.SEBELUM_TINDAKAN
					FROM (
						SELECT irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						mkj.TGL_OBSERVASI,
						mkj.UNIT_ID,
						NULL AS RUANG_ID,
						CASE WHEN mkj.SEBELUM_PEMBERIAN_OBAT <> 2 THEN mkj.SEBELUM_PEMBERIAN_OBAT END AS PEMBERIAN_OBAT,
						NULL AS PEMBERIAN_NUTRISI,	
						CASE WHEN mkj.SEBELUM_TRANSFUSI <> 2 THEN mkj.SEBELUM_TRANSFUSI END AS PEMBERIAN_DARAH,
						NULL AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mkj.SEBELUM_TINDAKAN <> 2 THEN mkj.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irja irj
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_irj_igd mkj
						ON (irj.IRJA_ID = mkj.RAWAT_ID)
						WHERE mkj.TGL_OBSERVASI >= ' . $tgl_filter_1 . '
						AND mkj.TGL_OBSERVASI <= ' . $tgl_filter_2 . '
						UNION ALL
						SELECT irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						mki.TGL_OBSERVASI,
						NULL AS UNIT_ID,
						mki.RUANG_ID,
						CASE WHEN mki.SEBELUM_PEMBERIAN_OBAT <> 2 THEN mki.SEBELUM_PEMBERIAN_OBAT END AS PEMBERIAN_OBAT,
						NULL AS PEMBERIAN_NUTRISI,	
						CASE WHEN mki.SEBELUM_TRANSFUSI <> 2 THEN mki.SEBELUM_TRANSFUSI END AS PEMBERIAN_DARAH,
						NULL AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mki.SEBELUM_TINDAKAN <> 2 THEN mki.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irna irn
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_iri mki
						ON (irn.IRNA_ID = mki.RAWAT_ID)
						WHERE mki.TGL_OBSERVASI >= ' . $tgl_filter_1 . '
						AND mki.TGL_OBSERVASI <= ' . $tgl_filter_2 . '
						UNION ALL
						SELECT irp.IRJA_ID AS RAWAT_ID,irp.NOMR,
						mkp.TGL_OBSERVASI,
						mkp.UNIT_ID,
						NULL AS RUANG_ID,
						NULL AS PEMBERIAN_OBAT,
						CASE WHEN mkp.UNIT_ID IN (18) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PEMBERIAN_NUTRISI,	
						NULL AS PEMBERIAN_DARAH,
						CASE WHEN mkp.UNIT_ID IN (45,17) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mkp.UNIT_ID IN (31,41,51,47,52,40) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irja irp
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_ipenunjang mkp
						ON (irp.IRJA_ID = mkp.RAWAT_ID)
						WHERE mkp.JNS_ORDER <> "APS" 
						AND mkp.TGL_OBSERVASI >= ' . $tgl_filter_1 . '
						AND mkp.TGL_OBSERVASI <= ' . $tgl_filter_2 . '
					) t_kip
					INNER JOIN db_simrs.m_pasien psn ON (t_kip.NOMR = psn.NOMR)
					UNION ALL
					SELECT mkp.RAWAT_ID,ipj.NO_PASIEN_PENUNJANG AS NOMR,
					ipj.NAMA_PASIEN,
					mkp.TGL_OBSERVASI,
					mkp.UNIT_ID,
					NULL AS RUANG_ID,
					NULL AS PEMBERIAN_OBAT,
					CASE WHEN mkp.UNIT_ID IN (18) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PEMBERIAN_NUTRISI,	
					NULL AS PEMBERIAN_DARAH,
					CASE WHEN mkp.UNIT_ID IN (45,17) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PENGAMBILAN_SPESIMEN,
					CASE WHEN mkp.UNIT_ID IN (31,41,51,47,52,40) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
					FROM db_simrs.t_ipenunjang ipj
					INNER JOIN db_repository.mutu_kepatuhan_identifikasi_ipenunjang mkp
					ON (ipj.PENUNJANG_ID = mkp.RAWAT_ID)
					WHERE ipj.JNS_ORDER = "APS" AND mkp.JNS_ORDER = "APS" 
					AND mkp.TGL_OBSERVASI >= ' . $tgl_filter_1 . '
					AND mkp.TGL_OBSERVASI <= ' . $tgl_filter_2 . '
				) x_kip
				LEFT JOIN db_simrs.m_unit mun ON (x_kip.UNIT_ID = mun.UNIT_ID)
				LEFT JOIN db_simrs.m_ruang mur ON (x_kip.RUANG_ID = mur.RUANG_ID)
				GROUP BY DATE_FORMAT(TGL_OBSERVASI,"%d/%m/%Y"),
				NOMR,NAMA_PASIEN,mun.NAMA_UNIT,mur.NAMA_RUANG
				ORDER BY TGL_OBSERVASI,NOMR';

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tgl Observasi</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
		<th>Unit</th>
        <th>Pemberian Obat</th>
        <th>Pemberian Nutrisi</th>
        <th>Pemberian Darah</th>
		<th>Pengambilan Spesimen</th>
		<th>Sebelum Tindakan</th>
		<th>Denominator</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_OBSERVASI']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php $nama_unit = $data['NAMA_UNIT'];
				if($nama_unit == '') $nama_unit = $data['NAMA_RUANG'];
				echo $nama_unit; ?></td>
			<td align="center"><?php echo setVal($data['PEMBERIAN_OBAT']); ?></td>	
			<td align="center"><?php echo setVal($data['PEMBERIAN_NUTRISI']); ?></td>	
			<td align="center"><?php echo setVal($data['PEMBERIAN_DARAH']); ?></td>	
			<td align="center"><?php echo setVal($data['PENGAMBILAN_SPESIMEN']); ?></td>	
			<td align="center"><?php echo setVal($data['SEBELUM_TINDAKAN']); ?></td>	
			<td align="center">
				<?php
					
				?>
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