<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
        <th colspan="2">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Jenis Kelamin</th>
        <th rowspan="2">Alamat</th>
		<th rowspan="2">No Telepon</th>
		<th rowspan="2">Email</th>
        <th rowspan="2">Klinik/Unit</th>
		<th rowspan="2">Dokter</th>
		<th rowspan="2">Paket MCU</th>
		<th rowspan="2">Estimasi<br />Dilayani</th>
        <th rowspan="2">Pembayaran</th>
		<th rowspan="2">Status</th>
		<th rowspan="2">Register</th>
		<th rowspan="2">Option</th>
    </tr>
    <tr>
		<th>Daftar<br />Online </th>		
		<th>Rencana<br />Kunjungan</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['DAFTAR_ID'];
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
            <td align="center"><?php echo $data['TGL_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['TGL_RENCANA_KUNJUNGAN']; ?></td>
            <td align="center"><?php if($data['NOMR'] == ''){
							if($data['RD_NOMR'] == '2') echo 'Lupa NOMR';
							if($data['RD_NOMR'] == '3') echo 'Pasien Baru';
						}else{
							echo formatNoMR($data['NOMR']); 
						} ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
			<td><?php $no_telepon = $data['NO_CONTACT'];
				$no_telepon_baru = '';
				if(strlen($no_telepon) >= 10){
					if(substr($no_telepon,0,2) == '08'){
						$no_telepon_baru = '628' . substr($no_telepon,2,strlen($no_telepon) - 2);
					}else if(substr($no_telepon,0,4) == '+628'){
						$no_telepon_baru = substr($no_telepon,1,strlen($no_telepon) - 1);	
					}else{
						$no_telepon_baru = $no_telepon;
					}	
				}	
				if(substr($no_telepon_baru,0,3) == '628'){
					echo '<div onclick="openwhatsapp(' . $no_telepon_baru . ');"><img src="image/whatsapp.png" width="15" height="15" style="float:left;">&nbsp;' . $no_telepon . '</div>';	
				}else{
					echo $no_telepon;
				} ?></td>
			<td><?php $arr_email = explode('@',$data['EMAIL']);
					if(sizeof($arr_email) == '2'){
						echo $arr_email[0] . '<br />@' . $arr_email[1];
					}else{
						$data['EMAIL'];	
					} ?></td>	
            <td><?php echo ((isset($arr_unit[$data['KLINIK_ID']])) ? $arr_unit[$data['KLINIK_ID']] : ''); ?></td>
			<td><?php echo ((isset($arr_dokter[$data['DOKTER_ID']])) ? $arr_dokter[$data['DOKTER_ID']] : ''); ?></td>
			<td><?php echo ((isset($arr_mcu[$data['MCU_ID']])) ? $arr_mcu[$data['MCU_ID']] : ''); ?></td>
            <td><?php echo $data['JAM_LAYANAN'] . '/ ' . $data['NO_ANTRIAN']; ?></td>
			<td><?php echo ((isset($arr_jaminan[$data['CARA_BAYAR']])) ? $arr_jaminan[$data['CARA_BAYAR']] : ''); ?></td>
			<td><?php if($data['CARA_BAYAR'] == '1'){ 
					if($data['ST_BAYAR'] == '1') echo 'Lunas'; 
					if($data['ST_BAYAR'] == '') echo 'Menunggu Bayar'; 
				}else{
					echo 'Lunas';
			}?></td>
			<td><?php if(currentModul() == 'pendaftaran' or currentModul() == 'ipapp') echo $data['USER_VERIFIKASI'];
					if(currentModul() == 'kasir') echo $data['USER_KASIR_VERIFIKASI'];
			?></td>
			<td align="center">
				<?php if($data['DAFTAR'] == '1'){ ?>
				<a href="index.php?link=c44832822ebfef57e5898556a9da1709&id=<?php echo $data['DAFTAR_ID']; ?>">detail</a>
				<?php }else{ ?>
				<a href="index.php?link=a80e42713c61d0fd865abe56153ce76e&id=<?php echo $data['DAFTAR_ID']; ?>">detail</a>
				<?php } ?>
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
                    <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
					<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
					<input type="hidden" name="verifikasi" value="<?php echo $verifikasi; ?>" />
                    <!--<input type="hidden" name="xlsfile" value="rekammedik/xls_pasien_pendaftaran_mandiri.php" />-->
					<input type="hidden" name="xlsfile" value="ipaap/xls_report_siijapin.php" />
                    <input type="hidden" name="xlsname" value="rpt_pasien_pendaftaran_mandiri.xls" />            
        </form>
<script language="javascript">
function openwhatsapp(phone){
	window.open('https://wa.me/' + phone);
}	
</script>			