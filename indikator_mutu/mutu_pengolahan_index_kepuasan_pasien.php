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
			<input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_jml_nilai = 'SELECT ';
$qry_jml_nilai_isi = 'SELECT ';
$x = 1;
while($x <= 30){
	$qry_jml_nilai .= 'SUM(PERTANYAAN_' . $x . ') AS PERTANYAAN_' . $x . ',';	
	$qry_jml_nilai_isi .= 'SUM(CASE WHEN PERTANYAAN_' . $x . ' > 0 THEN 1 ELSE 0 END) AS PERTANYAAN_' . $x . ',';	
$x++;
}
$qry_jml_nilai = substr($qry_jml_nilai,0,strlen($qry_jml_nilai) - 1);
$qry_jml_nilai_isi = substr($qry_jml_nilai_isi,0,strlen($qry_jml_nilai_isi) - 1);
$qry_jml_nilai .= ' FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
			WHERE TANGGAL >= ' . $tgl_filter_1 . ' AND TANGGAL <= ' . $tgl_filter_2;
$qry_jml_nilai_isi .= ' FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
			WHERE TANGGAL >= ' . $tgl_filter_1 . ' AND TANGGAL <= ' . $tgl_filter_2;			
	
$qry_pemantauan = 'SELECT * FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
			WHERE TANGGAL >= ' . $tgl_filter_1 . ' AND TANGGAL <= ' . $tgl_filter_2;
if(!empty($pelayanan)){
	$qry_pemantauan .= ' AND UNIT_PELAYANAN = "' . $pelayanan . '"';
	$qry_jml_nilai .= ' AND UNIT_PELAYANAN = "' . $pelayanan . '"';
	$qry_jml_nilai_isi .= ' AND UNIT_PELAYANAN = "' . $pelayanan . '"';
}
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&pelayanan=' . $pelayanan;
?>
<table border="1" class="tableData" id="tfhover" >
   <tr>
    <th rowspan="2">No</th>
    <th rowspan="2">No Responden</th>
    <th colspan="30">Nilai</th>
  </tr>
  <tr>
    <?php 
		$x = 1;
		while($x <= 30){
			echo '<th>U ' . $x . '</th>';
		$x++;
		}
	?>
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
            <td align="center"><?php echo $data['NO_RESPONDEN']; ?></td>
			<?php $x = 1;
			while($x <=30){ ?>
			<td><?php echo $data['PERTANYAAN_' . $x]; ?></td>
			<?php $x++; 
			} ?>
        </tr>
        <?
    }
    ?>
<tr>
	<td colspan="2">Jumlah Nilai</td>
	<?php $get_jml_nilai = mysql_query($qry_jml_nilai) or die(mysql_error());
	$dat_jml_nilai = mysql_fetch_assoc($get_jml_nilai);
	$x = 1;
	while($x <= 30){
		echo '<td>' . $dat_jml_nilai['PERTANYAAN_' . $x] . '</td>';
	$x++; }
	
	echo '</tr><tr><td colspan="2">NRR</td>';
	mysql_data_seek($get_jml_nilai,0);
	$dat_jml_nilai = mysql_fetch_assoc($get_jml_nilai);
	$get_jml_nilai_isi = mysql_query($qry_jml_nilai_isi) or die(mysql_error());
	$dat_jml_nilai_isi = mysql_fetch_assoc($get_jml_nilai_isi);
	$x = 1;
	while($x <= 30){
		$nrr = 0;
		if($dat_jml_nilai_isi['PERTANYAAN_' . $x] > 0) $nrr = $dat_jml_nilai['PERTANYAAN_' . $x] / $dat_jml_nilai_isi['PERTANYAAN_' . $x];
		echo '<td>' . number_format($nrr,1) . '</td>';
	$x++; }
	echo '</tr><tr><td colspan="2">NRR Tertimbang</td>';
	mysql_data_seek($get_jml_nilai,0);
	$dat_jml_nilai = mysql_fetch_assoc($get_jml_nilai);
	mysql_data_seek($get_jml_nilai_isi,0);
	$dat_jml_nilai_isi = mysql_fetch_assoc($get_jml_nilai_isi);
	$x = 1;
	while($x <= 30){
		$nrr = 0;
		if($dat_jml_nilai_isi['PERTANYAAN_' . $x] > 0) $nrr = ($dat_jml_nilai['PERTANYAAN_' . $x] / $dat_jml_nilai_isi['PERTANYAAN_' . $x]) * 0.033;
		echo '<td>' . number_format($nrr,1) . '</td>';
	$x++; }
	echo '</tr><tr><td colspan="2">Index Kepuasan</td>';
	mysql_data_seek($get_jml_nilai,0);
	$dat_jml_nilai = mysql_fetch_assoc($get_jml_nilai);
	mysql_data_seek($get_jml_nilai_isi,0);
	$dat_jml_nilai_isi = mysql_fetch_assoc($get_jml_nilai_isi);
	$x = 1;
	while($x <= 30){
		echo '<td>&nbsp;</td>';
	$x++; }
	?>
</tr>	
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