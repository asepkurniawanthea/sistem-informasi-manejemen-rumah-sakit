<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['indexkepuasan_tgl_1']))
    $tgl_1 = $_SESSION['indexkepuasan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['indexkepuasan_tgl_1']))
    $tgl_2 = $_SESSION['indexkepuasan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['indexkepuasan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['indexkepuasan_tgl_2'] = $_GET['tgl_2'];
}

$pelayanan = '';
if (isset($_SESSION['indexkepuasan_pelayanan']))
		$pelayanan = $_SESSION['indexkepuasan_pelayanan'];

if (isset($_GET['pelayanan'])) {
    $pelayanan = $_GET['pelayanan'];
	$_SESSION['indexkepuasan_pelayanan'] = $pelayanan;
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
			<td>Pelayanan</td>
			<td><select name="pelayanan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<option value="rj" <?php if($pelayanan == 'rj') echo 'selected="selected"'; ?>>Rawat Jalan</option>
				<option value="ri" <?php if($pelayanan == 'ri') echo 'selected="selected"'; ?>>Rawat Inap</option>
				<option value="gd" <?php if($pelayanan == 'gd') echo 'selected="selected"'; ?>>Instalasi Gawat Darurat</option>
			</select>	
		</tr>	
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=498d507d3e400c19acfa2dc720594b67" >
				<input type="button" value="koresponden baru" class="myButton1" /></a>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pemantauan = 'SELECT PENGUKURAN_KEPUASAN_ID,TANGGAL,
				CASE WHEN UNIT_PELAYANAN = "rj" THEN "Rawat Jalan"
					WHEN UNIT_PELAYANAN = "ri" THEN "Rawat Inap"
					WHEN UNIT_PELAYANAN = "gd" THEN "Instalasi Gawat Darurat"
				END AS PELAYANAN,NO_RESPONDEN,
				UMUR_TAHUN,UMUR_BULAN,JNS_KELAMIN,
				CASE WHEN PENDIDIKAN = "1" THEN "SD Kebawah"
					WHEN PENDIDIKAN = "2" THEN "SLTP"
					WHEN PENDIDIKAN = "3" THEN "SLTA"
					WHEN PENDIDIKAN = "4" THEN "D1-D2-D3–D4"
					WHEN PENDIDIKAN = "5" THEN "S1"
					WHEN PENDIDIKAN = "6" THEN "S2 Keatas"
				END AS PENDIDIKAN,
				CASE WHEN PEKERJAAN = "1" THEN "PNS/ TNI/ POLRI"
					WHEN PEKERJAAN = "2" THEN "Pegawai Swasta"
					WHEN PEKERJAAN = "3" THEN "Wiraswasta/ Usahawan"
					WHEN PEKERJAAN = "4" THEN "Pelajar/ Mahasiswa"
					WHEN PEKERJAAN = "5" THEN "Lainnya"
				END AS PEKERJAAN,REGISTER
				FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
			WHERE TANGGAL >= ' . $tgl_filter_1 . '
			AND TANGGAL <= ' . $tgl_filter_2 . '';
if(!empty($pelayanan)){
	$qry_pemantauan = $qry_pemantauan . ' AND UNIT_PELAYANAN = "' . $pelayanan . '"';
}
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&pelayanan=' . $pelayanan;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Pelayanan</th>
		<th>No Respondes</th>
		<th>Umur</th> 
		<th>Jenis Kelamin</th> 
		<th>Pendidikan</th> 
		<th>Pekerjaan</th> 
		<th>Register</th> 
		<th>Option</th> 
	</tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pemantauan, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
			<td><?php echo $data['PELAYANAN']; ?></td>
			<td><?php echo $data['NO_RESPONDEN']; ?></td>
			<td><?php echo $data['UMUR_TAHUN'] . ' Thn ' . $data['UMUR_BULAN'] . ' Bln'; ?></td>
			<td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
			<td><?php echo $data['PENDIDIKAN']; ?></td>
			<td><?php echo $data['PEKERJAAN']; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
			<td align="center"><a href="index.php?link=498d507d3e400c19acfa2dc720594b67&idx=<?php echo $data['PENGUKURAN_KEPUASAN_ID']; ?>">
				buka
				</a></td>
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