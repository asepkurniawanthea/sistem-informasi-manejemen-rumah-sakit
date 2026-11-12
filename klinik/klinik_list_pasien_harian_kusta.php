<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tgl Daftar</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">MDT Mulai</th>
		<th rowspan="2">Tgl Lahir</th>
        <th rowspan="2">Dewasa</th>
		<th rowspan="2">Anak</th>
        <th colspan="6">Tipe Kusta </th>
		<th rowspan="2">Observasi</th>
		<th rowspan="2">Non MH</th>
        <th rowspan="2">Kabupaten</th>
		<th rowspan="2">Propinsi</th>
        <th rowspan="2">Dokter DPJP</th>
        <th colspan="3">POD</th>
        <th rowspan="2">RFT (COT) </th>
		<th rowspan="2">Penyakit Lain</th>
		<th rowspan="2">Kunjungan<br/>Baru</th>
		<th rowspan="2">Kunjungan<br/>Ke</th>
		<th rowspan="2">Opname</th>
		<th rowspan="2">Status<br/>Pulang</th>
    </tr>
    <tr>
	  <th>N</th>		
      <th>TT</th>
      <th>BT</th>
      <th>BB</th>
      <th>BL</th>
      <th>LL</th>
      <th>Tanpa Cacat</th>
      <th>Cacat TK 1</th>
      <th>Cacat Tk 2</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['KUSTA_MDT_MULAI']); ?></td>
			<td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td align="center"><?php if(strtolower($data['USIA']) == 'dewasa') echo '&radic;'; ?></td>
			<td align="center"><?php if(strtolower($data['USIA']) == 'anak') echo '&radic;'; ?></td>
			<td><?php if($data['NR'] == '1') echo '&radic;'; ?></td>
            <td><?php if($data['TT'] == '1') echo '&radic;'; ?></td>
			<td><?php if($data['BT'] == '1') echo '&radic;'; ?></td>
			<td><?php if($data['BB'] == '1') echo '&radic;'; ?></td>
			<td><?php if($data['BL'] == '1') echo '&radic;'; ?></td>
			<td><?php if($data['LL'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['OBSERVASI'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['NON_MH'] == '1') echo '&radic;'; ?></td>
            <td><?php echo $data['NAMA_KOTA']; ?></td>
			<td><?php echo $data['NAMA_PROPINSI']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php if($data['POD_TANPA_CACAT'] == '1') echo '&radic;'; ?></td>
            <td><?php if($data['POD_CACAT_TK1'] == '1') echo '&radic;';; ?></td>
            <td><?php if($data['POD_CACAT_TK2'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php echo changeDateFormat($data['KUSTA_RFT_COT']); ?></td>
			<td><?php echo $data['KUSTA_PENYAKIT_LAIN']; ?></td>
			<td align="center"><?php if($data['KUSTA_KUNJUNGAN'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php echo $data['JML_KUNJUNGAN'] + 1; ?></td>
			<td><?php if($data['KUSTA_OPNAME'] == '1') echo $data['KUSTA_KETERANGAN_OPNAME']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
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
		<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
					<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
                    <input type="hidden" name="xlsfile" value="klinik/xls_report_pasien_harian_kusta.php" />
                    <input type="hidden" name="xlsname" value="rpt_pasien_harian_kusta.xls" />            
        </form>