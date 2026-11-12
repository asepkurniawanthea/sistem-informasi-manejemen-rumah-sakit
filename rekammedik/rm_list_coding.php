<?php
$searchkey = '';
$search = '';
$tgl_daftar1 = '';
$tgl_daftar2 = '';
if (isset($_GET['tgl_daftar1']))
    $tgl_daftar1 = $_GET['tgl_daftar1'];
if (isset($_GET['tgl_daftar2']))
    $tgl_daftar2 = $_GET['tgl_daftar2'];
if (empty($tgl_daftar1) && empty($tgl_daftar2))
    $search = 'AND DATE_FORMAT(TANGGAL_DAFTAR, "%Y/%m/%d") = DATE_FORMAT(NOW(), "%Y/%m/%d") ';
if (!empty($tgl_daftar1) && empty($tgl_daftar2))
    $search = 'AND DATE_FORMAT(TANGGAL_DAFTAR, "%Y/%m/%d") = DATE_FORMAT(' . fieldDate($tgl_daftar1) . ', "%Y/%m/%d") ';
if (!empty($tgl_daftar1) && !empty($tgl_daftar2))
    $search = 'AND (TANGGAL_DAFTAR >= ' . fieldDate($tgl_daftar1) . ' AND TANGGAL_DAFTAR <= ' . fieldDate($tgl_daftar2) . ') ';

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
    $searchkey = str_replace(' ', '%', $searchkey);
    if (!empty($searchkey))
        $search = $search . 'AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT) LIKE "%' . $searchkey . '%"';
}
?>
<form name="searchkunjungan" method="get" action="index.php">
    <table class="tableform" >
        <tr><th colspan="2">ICD CODE</th>
        </tr>
        <tr>
            <td>Nomor MR/ Nama/ Klinik</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" /></td>
        </tr>
        <tr>
            <td>Tanggal Daftar</td>
            <td><input type="text" name="tgl_daftar1" id="tgl_daftar1" value="<?php echo $tgl_daftar1; ?>" size="15" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar2')"/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="text" name="tgl_daftar2" id="tgl_daftar2" value="<?php echo $tgl_daftar2; ?>" size="15" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar3')"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left"><input type="submit" value="Cari" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_klinik_kunjungan.KLINIK_KUNJUNGAN_ID,t_klinik_kunjungan.NOMR,DATE_FORMAT(t_klinik_kunjungan.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
  CASE t_klinik_kunjungan.ST_BARU_LAMA WHEN "1" THEN "Baru" END AS ST_BARU_LAMA,
  t_klinik_kunjungan.UNIT_ID,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_unit.NAMA_UNIT,
  t_klinik_kunjungan.USER_RM, DATE_FORMAT(t_klinik_kunjungan.PASIEN_KELUAR,"%d-%m-%Y %H:%i:%s") AS PASIEN_KELUAR
  FROM t_klinik_kunjungan
  INNER JOIN m_pasien ON (t_klinik_kunjungan.NOMR = m_pasien.NOMR)
  INNER JOIN m_unit ON (t_klinik_kunjungan.UNIT_ID = m_unit.UNIT_ID)
  WHERE 1 ' . $search;
?>
<table class="tabledata">
    <tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Kunjungan</th>
        <th>Klinik/Ruang</th>
        <th>Pasien Pulang</th>
        <th>ICD Code</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, '', 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['KLINIK_KUNJUNGAN_ID'];
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
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td align="center"><?php echo $data['ST_BARU_LAMA']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
            <td><?php echo $data['PASIEN_KELUAR']; ?></td>
            <td align="center"><?php if (!empty($data['USER_RM'])) echo 'Ok'; ?></td>
            <td align="center">
                <?php
                $link_icd = '#';
                if (empty($data['USER_RM']))
                    $link_icd = 'index.php?link=' . md5('rmformcoding') . '&idx=' . $id . '&nomr=' . $data['NOMR'];
                ?>
                <a href="<?php echo $link_icd; ?>" >icd</a> | 
                <a href="index.php?link=<?php echo md5('rmviewdetailcoding'); ?>&idx=<?php echo $id; ?>&nomr=<?php echo $data['NOMR']; ?>" >detail</a></td>
        </tr>
        <?
    }
    ?>
</table>
<br />
<div align="left" >
    <?php
    echo $pager->renderFirst() . " | ";
    echo $pager->renderPrev() . " | ";
    echo $pager->renderNav() . " | ";
    echo $pager->renderNext() . " | ";
    echo $pager->renderLast();
    ?>
</div>
