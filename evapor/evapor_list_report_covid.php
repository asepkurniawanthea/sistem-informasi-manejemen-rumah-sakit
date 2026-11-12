<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Ruang Rawat</th>
        <th>Inisial Nama</th>
        <th>Usia</th>
        <th>Gender</th>
        <th>Riwayat Pekerjaan</th>
        <th>Severity Level</th>
        <th>Varian</th>
        <th>Komorbid</th>
        <th>Hasil Rontgen</th>
        <th>Hasil SGTF</th>
        <th>Terapi</th>
        <th>Tgl Masuk RS</th>
        <th>Tgl Masuk ICU</th>
        <th>Status Pasien Saat Ini</th>
        <th>LOS</th>
        <th>Status Vaksin</th>
        <th>Tgl Vaksin</th>
        <th>Tgl Pengambilan Sample WGS</th>
        <th>Tgl Pengiriman Sample WGS</th>
        <th>Tgl Keluar Hasil WGS</th>
        <th>Hasil WGS</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRNA_ID'];
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
            <td><?php echo $data['NAMA_RUANG']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <?php
                $tgl_lahir=$data['TGL_LAHIR'];
                $tgl_daftar=$data['TANGGAL_DAFTAR'];
                $umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
            ?>
            <td><?php echo $umur; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['RIWAYAT_PEKERJAAN'];?></td>
            <td><?php echo $data['SEVERITY_LEVEL'];?></td>
            <td><?php echo $data['VARIAN'];?></td>
            <?php if($data['ST_COVID19_KOMORBIT'] == "2"){
                        $komorbid="Komorbid";
                    }else{
                        $komorbid="Non Komorbid";
                    }
                 
            ?>
            <td><?php echo $komorbid;?></td>
            <td><?php echo $data['PEMERIKSAAN_RADIOLOGI'];?></td>
            <td><?php echo $data['HASIL_SGTF'];?></td>
            <td><?php echo $data['TERAPI'];?></td>
            <td><?php echo $data['TANGGAL_DAFTAR'];?></td>
            <td><?php echo $data['TGL_ICU'];?></td>
            <td><?php echo $data['STATUS_PASIEN'];?></td>
            <td><?php echo $data['LOS'];?></td>
            <td><?php echo $data['STATUS_VAKSIN'];?></td>
            <td><?php echo $data['TGL_VAKSIN'];?></td>
            <td><?php echo $data['TGL_AMBIL_WGS'];?></td>
            <td><?php echo $data['TGL_KIRIM_WGS'];?></td>
            <td><?php echo $data['TGL_KELUAR_WGS'];?></td>
            <td><?php echo $data['HASIL_WGS'];?></td>
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
                            <?php echo $pager->renderSummary();?>							
                        </td>
                        <td align="center">
                            <?php echo $pager->renderFirst();?>							
                        </td>
                        <td align="center">
                            <? echo $pager->renderPrev();?>							
                        </td>
                        <td align="center">
                            <? echo $pager->renderNav();?>							
                        </td>
                        <td align="center">
                            <? echo $pager->renderNext();?>							
                        </td>
                        <td align="center">
                            <? echo $pager->renderLast();?>
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
	<input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
	<!--<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
	<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />-->
    <input type="hidden" name="xlsfile" value="evapor/xls_evapor_report_covid.php" />
    <input type="hidden" name="xlsname" value="rpt_pasien_covid.xls" />            
</form>		