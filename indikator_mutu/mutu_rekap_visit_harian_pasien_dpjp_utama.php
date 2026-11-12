<style>
.list_isi{
	height:550px;
}
</style>
<?php
include('shared/array_filter_report_tarif.php');
$arr_visite = getStringArrayFilter('visite');

$tahun = date('Y');
if (isset($_SESSION['visithariandpjp_tahun']))
    $tahun = $_SESSION['visithariandpjp_tahun'];
$bulan = date('m');
if (isset($_SESSION['visithariandpjp_tahun']))
    $bulan = $_SESSION['visithariandpjp_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['visithariandpjp_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['visithariandpjp_bulan'] = $_GET['bulan'];
}

$ruang_id = '';
if (isset($_SESSION['visithariandpjp_ruang_id']))
		$ruang_id = $_SESSION['visithariandpjp_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['visithariandpjp_ruang_id'] = $ruang_id;
}

$dokter_id = '';
if (isset($_SESSION['visithariandpjp_dokter_id']))
		$dokter_id = $_SESSION['visithariandpjp_dokter_id'];
	
if (isset($_GET['dokter_id'])) {
    $dokter_id = $_GET['dokter_id'];
	$_SESSION['visithariandpjp_dokter_id'] = $dokter_id;
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
		<tr>
            <td>Tahun</td>
            <td><select name="tahun" class="text_dt" style="width:180px;" >
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
				<option value="2021" <?php if($tahun == '2021') echo 'selected="selected"'; ?> >2021</option>
				<option value="2022" <?php if($tahun == '2022') echo 'selected="selected"'; ?> >2022</option>
			</select></td>
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>	
        </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" class="text_dt" style="width:180px;">
				<option value="01" <?php if($bulan == '01') echo 'selected="selected"'; ?>>Januari</option>
				<option value="02" <?php if($bulan == '02') echo 'selected="selected"'; ?>>Februari</option>
				<option value="03" <?php if($bulan == '03') echo 'selected="selected"'; ?>>Maret</option>
				<option value="04" <?php if($bulan == '04') echo 'selected="selected"'; ?>>April</option>
				<option value="05" <?php if($bulan == '05') echo 'selected="selected"'; ?>>Mei</option>
				<option value="06" <?php if($bulan == '06') echo 'selected="selected"'; ?>>Juni</option>
				<option value="07" <?php if($bulan == '07') echo 'selected="selected"'; ?>>Juli</option>
				<option value="08" <?php if($bulan == '08') echo 'selected="selected"'; ?>>Agustus</option>
				<option value="09" <?php if($bulan == '09') echo 'selected="selected"'; ?>>September</option>
				<option value="10" <?php if($bulan == '10') echo 'selected="selected"'; ?>>Oktober</option>
				<option value="11" <?php if($bulan == '11') echo 'selected="selected"'; ?>>Nopember</option>
				<option value="12" <?php if($bulan == '12') echo 'selected="selected"'; ?>>Desember</option>
			</select></td>
			<td>Dokter</td>
			<td><select name="dokter_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getDokterRanap($dokter_id); ?>
			</select></td>		
		</tr>
		<tr>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" /></td>		
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT DATE_FORMAT(x_vst.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) < 660 THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_L11,
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) >= 660 
						AND (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) <= 780
						THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_B1113,	
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) > 780 THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_M13,	
				m_ruang.NAMA_RUANG
				FROM (
					SELECT t_vst.IRNA_TARIF_ID,
					t_vst.IRNA_ID,
					STR_TO_DATE(DATE_FORMAT(t_vst.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_TARIF,
					SUBSTRING_INDEX(DATE_FORMAT(t_vst.TGL_TARIF,"%H:%i"),":",1) AS JAM_TARIF,
					SUBSTRING_INDEX(DATE_FORMAT(t_vst.TGL_TARIF,"%H:%i"),":",-1) AS MENIT_TARIF,
					t_vst.PEGAWAI_ID,
					t_vst.RUANG_ID,
					t_irna.PEGAWAI_ID AS DPJP_UTAMA,
					t_irna.PASIEN_KELUAR,
					t_irna_log.PEGAWAI_ID AS DPJP_UTAMA_PINDAH,
					t_irna_log.TANGGAL_UPDATE AS TGL_KELUAR_PINDAH
					FROM (	
						SELECT t_irna_tarif.IRNA_TARIF_ID,
						t_irna_tarif.IRNA_ID,
						t_irna_tarif.TGL_TARIF,
						CASE WHEN t_irna_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL AND t_irna_tarif.PEGAWAI_PELAKSANA_ID <> 0
								THEN t_irna_tarif.PEGAWAI_PELAKSANA_ID ELSE t_irna_tarif.PEGAWAI_ID
						END AS PEGAWAI_ID,
						t_irna_tarif.RUANG_ID
						FROM t_irna_tarif
						INNER JOIN m_tarif
						ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID) 
						WHERE DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%Y") = "' . $tahun . '"  
						AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%m") = "' . $bulan . '"  
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND (t_irna_tarif.ST_BAYAR = "" OR t_irna_tarif.ST_BAYAR = "Lunas") 
						AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_visite . ')
					) t_vst	
					LEFT JOIN t_irna ON (t_vst.IRNA_ID = t_irna.IRNA_ID AND t_vst.PEGAWAI_ID = t_irna.PEGAWAI_ID)
					LEFT JOIN t_irna_log ON (t_vst.IRNA_ID = t_irna_log.IRNA_ID
						AND t_vst.PEGAWAI_ID = t_irna_log.PEGAWAI_ID
						AND t_irna_log.JNS_UPDATE = "R" 
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL 
						AND t_irna_log.TANGGAL_KELUAR IS NOT NULL)	
					WHERE 1
				) x_vst
				INNER JOIN t_irna ON (x_vst.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (x_vst.RUANG_ID = m_ruang.RUANG_ID)
				WHERE 1';	
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND m_ruang.BANGSAL = "' . $ruang_id . '" ';
}
if (!empty($dokter_id)) {
    $qry_pasien = $qry_pasien . ' AND x_vst.DPJP_UTAMA = "' . $dokter_id . '" ';
}

$qry_pasien = $qry_pasien . ' AND (x_vst.DPJP_UTAMA IS NOT NULL OR (x_vst.DPJP_UTAMA_PINDAH IS NOT NULL
								AND x_vst.TGL_TARIF <= x_vst.TGL_KELUAR_PINDAH))
							GROUP BY DATE_FORMAT(x_vst.TGL_TARIF,"%d/%m/%Y"),m_ruang.NAMA_RUANG			
							ORDER BY x_vst.TGL_TARIF';
							

$extparam = '&tahun=' . $tahun . '&bulan=' . $bulan . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Unit - Ruang</th>
		<th colspan="3">Waktu Visite</th>
		<th rowspan="2">Keterangan</th>
    </tr>
	  <tr>
      <th>< 11.00</th>
	  <th>11.00 - 13.00</th>
      <th>> 13.00</th>
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
            <td align="center"><?php echo $data['TGL_TARIF']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="right"><?php echo currFormat($data['VISIT_L11']); ?></td>
			<td align="right"><?php echo currFormat($data['VISIT_B1113']); ?></td>
			<td align="right"><?php echo currFormat($data['VISIT_M13']); ?></td>
			<td>&nbsp;</td>
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