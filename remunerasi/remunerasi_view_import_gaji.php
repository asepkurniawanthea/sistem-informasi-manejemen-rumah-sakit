<?php
$tahun = '';
if (isset($_SESSION['remunviewgaji_tahun']))
    $tahun = $_SESSION['remunviewgaji_tahun'];

$bulan = '';
if (isset($_SESSION['remunviewgaji_bulan']))
    $bulan = $_SESSION['remunviewgaji_bulan'];

$pegawai = '';
if (isset($_SESSION['remunviewgaji_pegawai']))
    $pegawai = $_SESSION['remunviewgaji_pegawai'];

if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['remunviewgaji_tahun'] = $_GET['tahun'];
}

if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['remunviewgaji_bulan'] = $_GET['bulan'];
}

if (isset($_GET['pegawai'])) {
    $pegawai = $_GET['pegawai'];
    $_SESSION['remunviewgaji_pegawai'] = $_GET['pegawai'];
}

$qry_gaji = 'SELECT rg.*,ru.UANG_MAKAN,ru.PAJAK,ru.UANG_MAKAN_BERSIH,
			 rr.REMUNERASI,rr.PAJAK AS PAJAK_REMUNERASI,
			 rr.REMUNERASI_BERSIH
			FROM db_sdm.r_gaji rg 
			LEFT JOIN db_sdm.r_uang_makan ru ON (rg.NIP = ru.NIP AND ru.TAHUN = "' . $tahun . '" AND ru.BULAN = "' . $bulan . '")
			LEFT JOIN db_sdm.r_remunerasi rr ON (rg.NIP = rr.NIP AND rr.TAHUN = "' . $tahun . '" AND rr.BULAN = "' . $bulan . '")
			WHERE 1 ';
if($tahun != '') $qry_gaji .= 'AND rg.TAHUN = "' . $tahun . '" ';
if($bulan != '') $qry_gaji .= 'AND rg.BULAN = "' . $bulan . '" ';
if($pegawai != '') $qry_gaji .= 'AND CONCAT(rg.NIP,rg.NAMA_PEGAWAI) LIKE "%' . $pegawai . '%"'; 
$get_gaji = mysql_query($qry_gaji) or die(mysql_error());
$dat_gaji = mysql_fetch_assoc($get_gaji);
$update = $dat_gaji['TGL_UPDATE']; 
?>
<form name="search" method="get" action="index.php">
   <table class="tableform" border="0" >
        <tr>
            <td>Tahun</td>
            <td><select name="tahun" id="tahun" style="width:150px;" class="text_dt" >
                    <option value=""> - </option>
					<option value="2020" <?php if($tahun == '2020') echo 'selected'; ?>>2020</option>
					<option value="2021" <?php if($tahun == '2021') echo 'selected'; ?>>2021</option>
					<option value="2022" <?php if($tahun == '2022') echo 'selected'; ?>>2022</option>
					<option value="2023" <?php if($tahun == '2023') echo 'selected'; ?>>2023</option>
					<option value="2024" <?php if($tahun == '2024') echo 'selected'; ?>>2024</option>
                </select></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>NIP/ Nama Pegawai</td>
            <td colspan="2"><input type="text" name="pegawai" id="pegawai" value="<?php echo $pegawai; ?>" class="text_dt" size="25"/></td>
        </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" id="bulan" style="width:150px;" class="text_dt" >
                    <option value=""> - </option>
					<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
					<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
					<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
					<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
					<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
					<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
					<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
					<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
					<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
					<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
					<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>Nopember</option>
					<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
                </select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<table border="1" class="tableData" id="tfhover" >
	<tr>
	  <th rowspan="2">No</th>
	  <th rowspan="2">Tahun</th>
	  <th rowspan="2">Bulan</th>
	  <th rowspan="2">NIP</th>
	  <th rowspan="2">Nama Pegawai</th>
	  <th colspan="10">Penghasilan</th>
	  <th colspan="8">Pemotongan</th>
	  <th rowspan="2">Gaji Bersih</th>
	  <th colspan="3">Uang Makan </th>
	  <th colspan="3">Remunerasi</th>
	  <th width="150" rowspan="2">Option</th>
  </tr>
	<tr>
		<th>Gaji Pokok</th>
		  <th>Tunjangan<br />Isteri Suami</th>
		  <th>Tunjangan<br />Anak</th>
		  <th>Tunjangan<br />Struktur</th>
		  <th>Tunjangan<br />Fungsional</th>
		  <th>Tunjangan<br />Umum PNS</th>
		  <th>Bulat</th>
		  <th>Tunjangan Beras</th>
		  <th>Tunjangan Pajak</th>
		  <th>Jumlah</th>
		  <th>BPJS</th>
		  <th>IWP</th>
		  <th>PPH</th>
		  <th>Sewa Rumah</th>
		  <th>Potongan<br/>Kelebihan Tunjangan</th>
		  <th>Potongan Lain</th>
		  <th>Tape RUM</th>
		  <th>Jumlah</th>
		  <th>Uang Makan</th>
		  <th>Pajak</th>
		  <th>Bersih</th>
		  <th>Remunerasi</th>
		  <th>Pajak</th>
		  <th>Bersih</th>
    </tr>
    <?
	$no = 0;
	$extparam = '&tahun=' . $tahun . '&bulan=' . $bulan;
    $pager = new PS_Pagination($connect, $qry_gaji, 25, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
	$x = 1;	
    while ($data = mysql_fetch_array($rs)) {
    $id = $data['GAJI_ID'];
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
    echo ($hal * 25) + $no;
        ?></td>
           <td><?php echo $data['TAHUN']; ?></td>
		   <td><?php echo $data['BULAN']; ?></td>
		   <td><?php echo $data['NIP']; ?></td>
		   <td><?php echo $data['NAMA_PEGAWAI']; ?></td>
		   <td align="right"><?php echo currFormat($data['GAJI_POKOK']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_ISTERI_SUAMI']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_ANAK']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_STRUKTUR']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_WIL_TERPENCIL']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_TAMB_UMUM']); ?></td>
		   <td align="right"><?php echo currFormat($data['BULAT']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_BERAS']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNJANGAN_PAJAK']); ?></td>
		   <td align="right"><?php echo currFormat($data['JUMLAH_PENGHASILAN']); ?></td>
		   <td align="right"><?php echo currFormat($data['POTONGAN_BERAS']); ?></td>
		   <td align="right"><?php echo currFormat($data['WP']); ?></td>
		   <td align="right"><?php echo currFormat($data['PPH']); ?></td>
		   <td align="right"><?php echo currFormat($data['SEWA_RUMAH']); ?></td>
		   <td align="right"><?php echo currFormat($data['TUNGGAKAN']); ?></td>
		   <td align="right"><?php echo currFormat($data['POTONGAN_LAIN']); ?></td>
		   <td align="right"><?php echo currFormat($data['TAPE_RUM']); ?></td>
		   <td align="right"><?php echo currFormat($data['JUMLAH_POTONGAN']); ?></td>
		   <td align="right"><?php echo currFormat($data['GAJI_BERSIH']); ?></td> 
		   <td align="right"><?php echo currFormat($data['UANG_MAKAN']); ?></td>
		   <td align="right"><?php echo currFormat($data['PAJAK']); ?></td>
		   <td align="right"><?php echo currFormat($data['UANG_MAKAN_BERSIH']); ?></td>
		   <td align="right"><?php echo currFormat($data['REMUNERASI']); ?></td>
		   <td align="right"><?php echo currFormat($data['PAJAK_REMUNERASI']); ?></td>
		   <td align="right"><?php echo currFormat($data['REMUNERASI_BERSIH']); ?></td> 	
		   <td><a href="#" onclick="cetak_slip(<?php echo $id; ?>);">cetak_slip</a></td>
		</tr>
	<?php $x++; } ?>
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
<script type="text/javascript">
function cetak_slip(idx){
	window.open("pdf/slip_gaji.php?idx=" + idx);
}
</script>	