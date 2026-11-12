<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['whlklab_tgl_1']))
    $tgl_1 = $_SESSION['whlklab_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['whlklab_tgl_1']))
    $tgl_2 = $_SESSION['whlklab_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['whlklab_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['whlklab_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['whlklab_searchkey']))
		$searchkey = $_SESSION['whlklab_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['whlklab_searchkey'] = $searchkey;
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
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=8d8bbbce9278991cd8d5518f514bcd0b" >
			<input type="button" value="tutup" class="myButton1" /></a>
			</td>		
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT * FROM (
				SELECT t_order.*,psn.NAMA_PASIEN,
				mun.NAMA_UNIT,mru.NAMA_RUANG,
				NULL AS PENGUMPUL_DATA,NULL AS SIMPAN,
				NULL AS WAKTU_LAPOR_ID
				FROM (SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
				"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "IRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1" 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				UNION
				SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
				"Hemodialisa" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "HRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				UNION
				SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
				"Kamar Operasi" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "ORJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				UNION
				SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
				"Kamar Operasi" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "ORI"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				UNION
				SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
				"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "IRN"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				UNION
				SELECT tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
				"Hemodialisa" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				WHERE tip.JNS_ORDER = "HRI"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				) t_order 
				INNER JOIN db_simrs.m_pasien psn ON (t_order.NOMR = psn.NOMR)
				LEFT JOIN db_simrs.m_unit mun ON (t_order.UNIT_ID = mun.UNIT_ID)
				LEFT JOIN db_simrs.m_ruang mru ON (t_order.RUANG_ID = mru.RUANG_ID)
				UNION ALL
				SELECT tip.PENUNJANG_ID AS RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER,
				DATE_FORMAT(tipt.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				DATE_FORMAT(tipt.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(tipt.TANGGAL_LAPOR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_LAPOR,
				NULL AS UNIT_ID,NULL AS RUANG_ID,tip.NO_PASIEN_PENUNJANG AS NOMR,
				"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
				GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT,
				tip.NAMA_PASIEN,tip.INSTANSI_PENGIRIM AS NAMA_UNIT,
				NULL AS NAMA_RUANG,wlh.PENGUMPUL_DATA,NULL AS SIMPAN,
				wlh.WAKTU_LAPOR_ID
				FROM t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
				LEFT JOIN db_repository.mutu_waktu_lapor_hasil_laboratorium wlh
					ON (
						tip.PENUNJANG_ID = wlh.RAWAT_ID
						AND tipt.NO_TARIF = wlh.NO_TARIF
						AND mtp.FORM_HASIL = wlh.FORM_HASIL
					)
				WHERE tip.JNS_ORDER = "APS"
				AND tipt.NO_TARIF IS NOT NULL
				AND tipt.HASIL_TES_KRITIS = "1"
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tip.JNS_ORDER,tipt.NO_TARIF,
				mtp.FORM_HASIL
				) t_lab';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_lab.NOMR,t_lab.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
	
$qry_pasien = $qry_pasien . ' ORDER BY t_lab.NO_TARIF';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
		<th>Pengirim</th>
		<th>Pemeriksaan</th>
        <!--<th>Jam Permintaan</th>
		<th>Jam Sampling</th>-->
		<th>Jam Keluar Hasil</th>
		<th>Jam Dilaporkan</th>
		<th>Keterangan</th>
		<th>Action</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6) {
					echo formatNoMR($data['NOMR']);
				}else{
					echo $data['NOMR'];
				}?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php $nama_unit =  $data['NAMA_UNIT'];
					if($nama_unit == '') $nama_unit= $data['NAMA_RUANG'];	
					if($data['EXT_NAMA_UNIT'] != '') $nama_unit .= $data['EXT_NAMA_UNIT'];
					echo $nama_unit; ?></td>
			<td><?php echo $data['CH_REPORT']; ?></td>		
			<!--<td align="center"><?php echo $data['TANGGAL_ORDER']; ?></td>
			<td align="center"><?php echo $data['TANGGAL_SAMPLING']; ?></td>-->
			<td align="center"><?php echo $data['TANGGAL_HASIL']; ?></td>
			<td align="center"><?php echo $data['TANGGAL_LAPOR']; ?></td>
			
			<!--<td align="center"><?php if($data['JNS_ORDER'] == 'APS'){
				$tgl_lapor = '';
				$jam_lapor = '';
				$menit_lapor = '';
				if($data['TANGGAL_LAPOR'] != '' and $data['TANGGAL_LAPOR'] != '00/00/0000'){
					$tgl_lapor = $data['TANGGAL_LAPOR']; 
					$arr_jam_lapor = explode(':',$data['JAM_LAPOR']);
					$jam_lapor = $arr_jam_lapor[0];
					$menit_lapor = $arr_jam_lapor[1];
				}else{
					if($data['TANGGAL_HASIL'] != '' and $data['TANGGAL_HASIL'] != '00/00/0000'){
						$arr_tgl_lapor = explode(' ',$data['TANGGAL_HASIL']);
						$tgl_lapor = $arr_tgl_lapor[0]; 
						$arr_jam_lapor = explode(':',$arr_tgl_lapor[1]);
						$jam_lapor = $arr_jam_lapor[0];
						$menit_lapor = $arr_jam_lapor[1];
					}	
				}	
			?>
			<input type="text" name="tgl_edu_<?php echo $no; ?>" id="tgl_edu_<?php echo $no; ?>" value="<?php echo $tgl_lapor; ?>" size="10" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $no; ?>')"/>
			<select name="jam_<?php echo $no; ?>" id="jam_<?php echo $no; ?>" class="text_dt">
				<?php echo getJam($jam_lapor); ?>
			</select><select name="menit_<?php echo $no; ?>" id="menit_<?php echo $no; ?>" class="text_dt">
				<?php echo getMenit($menit_lapor); ?>
			</select>
			<?php 
			}else{
				echo $data['TANGGAL_LAPOR'];	
			}
			?>
			</td>-->
			<td><input type="text" name="keterangan<?php echo $x; ?>" id="keterangan<?php echo $no; ?>"
			class="text_dt" size="60" /></td>
			<td><a href='#' onclick='simpan(<?php echo $data['RAWAT_ID'] . ',"' . $data['NOMR'] . '","' . $data['NO_TARIF'] . '","' . $data['FORM_HASIL'] . '","' . $data['TANGGAL_HASIL'] . '","' . $data['TANGGAL_LAPOR'] . '",' . $no; ?>)' >simpan</a></td>
			<!--<td align="center">
			<?php if($data['JNS_ORDER'] == 'APS'){ ?>
			<input type="checkbox" name="save_<?php echo $no; ?>" id="save_<?php echo $no; ?>" value="1" 
				<?php if($data['SIMPAN'] == '1') echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('save_<?php echo $no; ?>','<?php echo $data['RAWAT_ID'] . '|' . $data['WAKTU_LAPOR_ID'] . '|' . $data['NO_TARIF'] . '|' . $data['FORM_HASIL']; ?>',
				'tgl_edu_<?php echo $no; ?>','jam_<?php echo $no; ?>','menit_<?php echo $no; ?>','usr_<?php echo $no; ?>');" />
			<div id="usr_<?php echo $no; ?>"><?php echo $data['PENGUMPUL_DATA']; ?></div>
			<?php } ?>
			</td>-->
        </tr>
        <?
    }
    ?>
</table>
</form>
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
<div id="msg_ta"></div>		
<script language="JavaScript" >
function simpan(id,nmr,trf,frm,hsl,lpr,dt){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=jamlaporlaboratorium',
		type: 'POST',
		async : false,
		data: {
			idx			: id,
			nomr		: nmr,
			tarif		: trf,
			form		: frm,
			tglhasil	: hsl,
			tgllapor	: lpr,
			keterangan	: document.getElementById('keterangan' + dt).value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>			