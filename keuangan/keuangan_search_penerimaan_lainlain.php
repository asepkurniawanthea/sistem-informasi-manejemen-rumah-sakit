<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['keuanganpenerimaanlain_tgl_1']))
    $tgl_1 = $_SESSION['keuanganpenerimaanlain_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['keuanganpenerimaanlain_tgl_1']))
    $tgl_2 = $_SESSION['keuanganpenerimaanlain_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['keuanganpenerimaanlain_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['keuanganpenerimaanlain_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['keuanganpenerimaanlain_searchkey']))
		$searchkey = $_SESSION['keuanganpenerimaanlain_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['keuanganpenerimaanlain_searchkey'] = $searchkey;
}
$tarif = '';
if (isset($_SESSION['keuanganpenerimaanlain_tarif']))
		$tarif = $_SESSION['keuanganpenerimaanlain_tarif'];

if (isset($_GET['tarif'])) {
    $tarif = $_GET['tarif'];
	$_SESSION['keuanganpenerimaanlain_tarif'] = $tarif;
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
			<td>Nama Instansi/ PIC</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Tarif</td>
			<td><input type="text" name="tarif" id="tarif" value="<?php echo $tarif; ?>" class="text_dt"/></td>		
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<?php if(currentModul() != 'kasir'){ ?>
            <a href="index.php?link=<?php echo md5('keuanganformpenerimaanlain-lain'); ?>" >
			<input type="button" value="tambah pembayaran" class="myButton" />
			</a>
            <?php } ?>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_penerimaan = 'SELECT pl.PENERIMAAN_LAINLAIN_ID,pl.TANGGAL,pl.JENIS_INSTANSI,
	  pl.NAMA_INSTANSI,pl.PIC,pl.TELEPON,pl.KETERANGAN,pl.NO_TARIF,pl.REGISTER,
	  SUM(pltarif.KUANTITI * mtr.TARIF_NON_KELAS) AS HARGA,
      mdl.NAMA_MODUL,pl.USER_UNIT,pl.NO_PEMBAYARAN,
      pl.KODE_CASH,pl.KODE_REKENING
	  FROM
	  db_simkeu.r_penerimaan_lainlain pl
	  INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pltarif
	  ON (pl.PENERIMAAN_LAINLAIN_ID = pltarif.PENERIMAAN_LAINLAIN_ID)
	  INNER JOIN db_simrs.m_tarif mtr
	  ON (pltarif.TARIF_ID = mtr.TARIF_ID)
	  INNER JOIN db_simrs.m_tarif_group mtrg
	  ON (mtr.KODE_TARIF_GROUP = mtrG.KODE_TARIF_GROUP)
      LEFT JOIN db_simrs.m_app_modul mdl
      ON (pl.UNIT = mdl.MODUL_ID)
	  WHERE pl.TANGGAL >= ' . $tgl_filter_1 . '
	  AND pl.TANGGAL <= ' . $tgl_filter_2;

if(currentModul() != 'kasir'){
    $qry_penerimaan = $qry_penerimaan . ' AND pl.UNIT = "' . $_SESSION['SES_SIMRS_MODUL_ID'] . '"';
}

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_penerimaan = $qry_penerimaan . ' AND CONCAT(pl.NAMA_INSTANSI,pl.PIC) LIKE "%' . $searchkey . '%"';
}	
if (!empty($tarif)) {
	$tarif = str_replace(' ', '%', $tarif);
	$qry_penerimaan = $qry_penerimaan . ' AND CONCAT(mtr.NAMA_TARIF,mtrg.NAMA_TARIF_GROUP) LIKE "%' . $tarif . '%"';
}
$qry_penerimaan = $qry_penerimaan . ' GROUP BY pl.PENERIMAAN_LAINLAIN_ID';
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&tarif=' . $tarif;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jenis Instansi</th>
        <th>Nama Instansi</th>
        <th>PIC</th>
        <th>Telepon</th>
        <th>Keterangan</th>
        <th>Nama Tarif </th>
        <th>Jumlah</th>
		<th>Harga</th>
        <?php if(currentModul() == 'kasir'){ ?>
            <th>Unit</th>
            <th>Register</th>
            <th>Status</th>
        <?php }else{ ?>
            <th>Register</th>
            <th>Status</th>
		<?php } ?>
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL']); ?></td>
            <td><?php echo $data['JENIS_INSTANSI']; ?></td>
			<td><?php echo $data['NAMA_INSTANSI']; ?></td>
			<td><?php echo $data['PIC']; ?></td>
			<td><?php echo $data['TELEPON']; ?></td>
			<td colspan="3"><?php echo $data['KETERANGAN']; ?></td>
			<td align="right"><?php echo currFormat($data['HARGA']); ?></td>
            <?php if(currentModul() == 'kasir'){ ?>
            <td><?php echo $data['NAMA_MODUL']; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
            <td><?php if($data['NO_PEMBAYARAN'] != '') echo 'Lunas'; 
            if($data['KODE_CASH'] != '') echo ' /' . $data['KODE_CASH'];
            if($data['KODE_REKENING'] != '') echo ' /' . $data['KODE_REKENING']; ?></td>    
            <?php }else{ ?>
            <td><?php echo $data['USER_UNIT']; ?></td>
            <td><?php if($data['NO_PEMBAYARAN'] != '') echo 'Lunas'; 
            if($data['KODE_CASH'] != '') echo ' /' . $data['KODE_CASH'];
            if($data['KODE_REKENING'] != '') echo ' /' . $data['KODE_REKENING']; ?></td>    
            <?php } ?>    
			<td align="center">
            <?php if(currentModul() == 'kasir'){ ?>    
                <a href="index.php?link=78cbd64fe5af657357bebe8e68cf2d38&id=<?php echo $data['PENERIMAAN_LAINLAIN_ID']; ?>">detail</a>
            <?php }else{ 
                if($data['NO_PEMBAYARAN'] == ''){
                ?>
                <a href="index.php?link=78cbd64fe5af657357bebe8e68cf2d38&id=<?php echo $data['PENERIMAAN_LAINLAIN_ID']; ?>">ubah</a>
            <?php } } ?>    
            </td>
        </tr>
        <?
		$qry_penerimaan_detail = 'SELECT pltarif.PENERIMAAN_LAINLAIN_TARIF_ID,
								pltarif.TARIF_ID,mtr.NAMA_TARIF,mtrg.NAMA_TARIF_GROUP,
								pltarif.KUANTITI,pltarif.KUANTITI * mtr.TARIF_NON_KELAS AS HARGA
								FROM db_simkeu.r_penerimaan_lainlain_tarif pltarif
								INNER JOIN db_simrs.m_tarif mtr
								ON (pltarif.TARIF_ID = mtr.TARIF_ID)
								INNER JOIN db_simrs.m_tarif_group mtrg
								ON (mtr.KODE_TARIF_GROUP = mtrG.KODE_TARIF_GROUP)
								WHERE pltarif.PENERIMAAN_LAINLAIN_ID = "' . $data['PENERIMAAN_LAINLAIN_ID'] . '"';
		$get_penerimaan_detail = mysql_query($qry_penerimaan_detail) or die(mysql_error());
		while($dat_penerimaan_detail = mysql_fetch_array($get_penerimaan_detail)){
			?>
			<tr>
			<td align="center" colspan="7">&nbsp;</td>
			<td><?php echo $dat_penerimaan_detail['NAMA_TARIF_GROUP'] . '-' . $dat_penerimaan_detail['NAMA_TARIF']; ?></td>
            <td align="right"><?php echo currFormat($dat_penerimaan_detail['KUANTITI']); ?></td>
			<td align="right"><?php echo currFormat($dat_penerimaan_detail['HARGA']); ?></td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <?php if(currentModul() == 'kasir'){ ?>
            <td align="center">&nbsp;</td>
            <?php } ?>
			</tr>
			<?php
		}	
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