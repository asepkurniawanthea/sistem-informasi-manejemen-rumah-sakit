<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'] = $_GET['tgl_2'];
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
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna.NOMR,t_irna.TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_propinsi.NAMA_PROPINSI,
				m_kota.NAMA_KOTA,m_kecamatan.NAMA_KECAMATAN,m_kelurahan.NAMA_KELURAHAN,
				m_jaminan.NAMA_JAMINAN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.NAMA_PASIEN
				FROM t_irna
				  INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				  INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				  INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				WHERE t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL';
?>
<table border="1" class="tableData" id="tfhover">
  <tr>
    <th width="5">No</th>
    <th>Tanggal</th>
	<th>Ruang Rawat</th>
	<th>NOMR</th>
	<th>Nama Pasien</th>
	<th>Tmp Lahir</th>
	<th>Tgl Lahir</th>
	<th>Jns Kel</th>
	<th>Propinsi</th>
	<th>Kota</th>
	<th>Kecamatan</th>
	<th>Kelurahan</th>
	<th>Alamat Rt/Rw</th>
	<th>Jaminan</th>
  </tr>
<?php  
$no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, '', 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($dat_kunjungan = mysql_fetch_array($rs)) {
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
	<td><?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_RUANG']; ?></td>
    <td><?php echo formatNomr($dat_kunjungan['NOMR']); ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_kunjungan['TMP_LAHIR']; ?></td>
	<td><?php echo $dat_kunjungan['TGL_LAHIR']; ?></td>
	<td><?php echo $dat_kunjungan['JNS_KELAMIN']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PROPINSI']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KOTA']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KECAMATAN']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KELURAHAN']; ?></td>
	<td><?php echo $dat_kunjungan['ALAMAT'] . ' ' . $dat_kunjungan['ALAMAT_RT'] . '/' . $dat_kunjungan['ALAMAT_RW']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_JAMINAN']; ?></td>
  </tr>
 <?php $no++; } ?> 
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
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
    <input type="hidden" name="xlsfile" value="rekammedik/xls_report_pemetaan_pasien_ranap.php" />
    <input type="hidden" name="xlsname" value="rpt_pemetaan_irna.xls" />            
</form>
