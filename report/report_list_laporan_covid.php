<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Ruang Rawat</th>
        <th>Nomor MR</th>
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
        <th width="100">Action</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kun, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td><?php echo $data['NOMR']; ?></td>
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
            <?php
                if($data['ST_PULANG'] == "1"){
                    $los=$data['LOS']+1;
                }else{
                    $tgl_masuk=$data['TANGGAL_DAFTAR'];
					$tgl_masuk=date_create($tgl_masuk);
					$tgl_skrg=date_create();
                    //$tgl_skrg=date('d/m/Y');
                    //$los=$tgl_masuk-$tgl_skrg+1;
					$los  = date_diff( $tgl_skrg, $tgl_masuk);
                } 
                
            ?>
            <td><?php echo $los . ' hari';?></td>
            <td><?php echo $data['STATUS_VAKSIN'];?></td>
            <td><?php echo $data['TGL_VAKSIN'];?></td>
            <td><?php echo $data['TGL_AMBIL_WGS'];?></td>
            <td><?php echo $data['TGL_KIRIM_WGS'];?></td>
            <td><?php echo $data['TGL_KELUAR_WGS'];?></td>
            <td><?php echo $data['HASIL_WGS'];?></td>
            <td align="center"><?php echo str_replace('###', $data['IRNA_ID'], $action); ?>
            <!--<td align="center">
            <a href="index.php?link=ae31dfb0a2bce5010204c6c1bdc2c1bd&no_irna=###" >ubah</a>-->
            <a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&idx=<?php echo $data['IRNA_ID']; ?>" >periksa</a>
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
