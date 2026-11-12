<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['pembayarandeposit_tgl_1']))
    $tgl_1 = $_SESSION['pembayarandeposit_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayarandeposit_tgl_1']))
    $tgl_2 = $_SESSION['pembayarandeposit_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayarandeposit_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayarandeposit_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayarandeposit_searchkey']))
		$searchkey = $_SESSION['pembayarandeposit_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayarandeposit_searchkey'] = $searchkey;
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
			<td>NOMR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('pembayaranformdeposit'); ?>" >
			<input type="button" value="tambah deposit" class="myButton" />
			</a></td>		
            <td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_penerimaan = 'SELECT xd.RAWAT_ID,DATE_FORMAT(xd.TGl_DEPOSIT,"%d/%m/%Y") AS TGL_DEPOSIT,
				t_irja.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,	
				m_pasien.ALAMAT,m_unit.NAMA_UNIT,CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR,deposit.JUMLAH_DEPOSIT,xd.USER_KASIR
				FROM t_deposit xd
				INNER JOIN (
					SELECT td.RAWAT_ID,MAX(td.DEPOSIT_ID) AS DEPOSIT_ID,
					SUM(CASE WHEN td.ST_BATAL = "" OR td.ST_BATAL IS NULL THEN td.JUMLAH_DEPOSIT END) AS JUMLAH_DEPOSIT	
					FROM t_deposit td
					GROUP BY td.RAWAT_ID
				) deposit
				ON (xd.DEPOSIT_ID = deposit.DEPOSIT_ID)
				LEFT JOIN t_irja
				ON (xd.RAWAT_ID = t_irja.IRJA_ID)
				LEFT JOIN t_irna
				ON (xd.RAWAT_ID = t_irna.IRNA_ID
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_irna.ST_BATAL IS NULL
				AND t_irna.PASIEN_MASUK IS NOT NULL)
				LEFT JOIN m_unit
				ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang
				ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pasien
				ON (t_irja.NOMR = m_pasien.NOMR)
				WHERE DATE(xd.TGl_DEPOSIT) >= ' . $tgl_filter_1 . ' 
				AND DATE(xd.TGl_DEPOSIT) <= ' . $tgl_filter_2;	  
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_penerimaan = $qry_penerimaan . ' AND CONCAT(m_pasien.NAMA_PASIEN,m_pasien.NOMR) LIKE "%' . $searchkey . '%"';
}	
$qry_penerimaan = $qry_penerimaan . ' ORDER BY m_pasien.NAMA_PASIEN';
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nomr</th>
        <th>Nama Pasien</th>
		<th>Tanggal Lahir</th>
		<th>Alamat</th>
        <th>Klinik/ Ruang</th>
        <th>Tanggal Masuk</th>
        <th>Deposit</th>
		<th>Register</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_penerimaan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_DEPOSIT']; ?></td>
            <td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
			<td><?php echo $data['ALAMAT']; ?></td>
			<td><?php $nama_unit = $data['NAMA_UNIT']; 
				if($data['NAMA_RUANG'] != '') $nama_unit .= '/ ' . $data['NAMA_RUANG']; 
				echo $nama_unit; ?></td>
			<td align="center"><?php echo $data['TGL_DAFTAR']; ?></td>	
			<td align="right"><?php echo currFormat($data['JUMLAH_DEPOSIT']); ?></td>
			<td><?php echo $data['USER_KASIR']; ?></td>
			<td align="center">
			<a href="index.php?link=6c19828ebd5fe4845aef9c025927fed5&idx=<?php echo $data['RAWAT_ID']; ?>">detail</a>
			</td>
        </tr>
			<?php	
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