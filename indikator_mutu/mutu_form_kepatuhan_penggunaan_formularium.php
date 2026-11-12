<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['formularium_tgl_1']))
    $tgl_1 = $_SESSION['formularium_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['formularium_tgl_1']))
    $tgl_2 = $_SESSION['formularium_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['formularium_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['formularium_tgl_2'] = $_GET['tgl_2'];
}

$ruang_id = '';
if (isset($_SESSION['formularium_ruang_id']))
		$ruang_id = $_SESSION['formularium_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['formularium_ruang_id'] = $ruang_id;
}
$unit_id = '';
if (isset($_SESSION['formularium_unit_id']))
		$unit_id = $_SESSION['formularium_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['formularium_unit_id'] = $unit_id;
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
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT TRIM(SUBSTRING_INDEX(INSTANSI_PENGIRIM,"Kelas",1)) AS INSTANSI_PENGIRIM 
								FROM t_farmasi_apotik_pengeluaran 
								WHERE JENIS_PENGELUARAN = "2"
								AND TANGGAL_KELUAR >= STR_TO_DATE("01/01/2018","%d/%m/%Y")
								AND INSTANSI_PENGIRIM <> ""
								ORDER BY INSTANSI_PENGIRIM'; 
					$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					if($dat_unit['INSTANSI_PENGIRIM'] != ''){
						$select = '';
						if($dat_unit['INSTANSI_PENGIRIM'] == $ruang_id) $select = 'selected="selected"';
						echo '<option value="' . $dat_unit['INSTANSI_PENGIRIM'] . '" ' . $select . ' >' . $dat_unit['INSTANSI_PENGIRIM'] . '</option>';
					}	
				}?>
			</select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Poliklinik/ IGD</td>
			<td><select name="unit_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT INSTANSI_PENGIRIM 
								FROM t_farmasi_apotik_pengeluaran 
								WHERE JENIS_PENGELUARAN = "1"
								AND TANGGAL_KELUAR >= STR_TO_DATE("01/01/2018","%d/%m/%Y")
								AND INSTANSI_PENGIRIM <> ""
								ORDER BY INSTANSI_PENGIRIM'; 
					$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					$select = '';
					if($dat_unit['INSTANSI_PENGIRIM'] == $unit_id) $select = 'selected="selected"';
					echo '<option value="' . $dat_unit['INSTANSI_PENGIRIM'] . '" ' . $select . ' >' . $dat_unit['INSTANSI_PENGIRIM'] . '</option>';
				}?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=7e0cdfb83197571fb3e2aa452ca865b8" >
			<input type="button" value="tutup" class="myButton1" /></a></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT TANGGAL_KELUAR,INSTANSI_PENGIRIM,NOMR,
				RAWAT_ID,
				SUM(FORMULARIUM) AS FORMULARIUM,
				SUM(NON_FORMULARIUM) AS NON_FORMULARIUM,
				SUM(JML_OBAT) AS JML_OBAT,
				COUNT(DISTINCT NO_PENGELUARAN) AS JML_RESEP
				FROM (
					SELECT t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR AS TANGGAL_KELUAR_RL, 
					DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,
					t_farmasi_apotik_pengeluaran.NIK AS NOMR,
					t_farmasi_apotik_pengeluaran.RAJAL_ID AS RAWAT_ID,
					COUNT(DISTINCT CASE WHEN m_persediaan_farmasi.FORMULARIUM = "1" 
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL = "1"
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS FORMULARIUM,
					COUNT(DISTINCT CASE WHEN (m_persediaan_farmasi.FORMULARIUM = ""
							OR m_persediaan_farmasi.FORMULARIUM IS NULL)
							AND (m_persediaan_farmasi.FORMULARIUM_NASIONAL = ""
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL IS NULL)
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS NON_FORMULARIUM,
					COUNT(DISTINCT m_persediaan_farmasi.PERSEDIAAN_ID) AS JML_OBAT		
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_rajal_resep ON (t_rajal_resep_detail.RAJAL_RESEP_ID = t_rajal_resep.RAJAL_RESEP_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
					AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1"
					AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR >= ' . $tgl_filter_1 . '
					AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR <= ' . $tgl_filter_2 . '
					AND (m_persediaan_farmasi.ALKES = "" OR m_persediaan_farmasi.ALKES IS NULL)
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,
					t_farmasi_apotik_pengeluaran.NIK,
					t_farmasi_apotik_pengeluaran.RAJAL_ID
					UNION ALL
					SELECT t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR AS TANGGAL_KELUAR_RL,  
					DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,
					t_farmasi_apotik_pengeluaran.NIK AS NOMR,
					t_farmasi_apotik_pengeluaran.RANAP_ID AS RAWAT_ID,
					COUNT(DISTINCT CASE WHEN m_persediaan_farmasi.FORMULARIUM = "1" 
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL = "1"
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS FORMULARIUM,
					COUNT(DISTINCT CASE WHEN (m_persediaan_farmasi.FORMULARIUM = ""
							OR m_persediaan_farmasi.FORMULARIUM IS NULL)
							AND (m_persediaan_farmasi.FORMULARIUM_NASIONAL = ""
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL IS NULL)
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS NON_FORMULARIUM,
					COUNT(DISTINCT m_persediaan_farmasi.PERSEDIAAN_ID) AS JML_OBAT
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN t_ranap_resep ON (t_ranap_resep_detail.RANAP_RESEP_ID = t_ranap_resep.RANAP_RESEP_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
					AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2"
					AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR >= ' . $tgl_filter_1 . '
					AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR <= ' . $tgl_filter_2 . '
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,
					t_farmasi_apotik_pengeluaran.NIK,
					t_farmasi_apotik_pengeluaran.RANAP_ID
				) t_resep
				WHERE 1';
if(!empty($unit_id)){
	$qry_pasien = $qry_pasien . ' AND INSTANSI_PENGIRIM LIKE "%' . $unit_id . '%"';
}
if(!empty($ruang_id)){
	$qry_pasien = $qry_pasien . ' AND INSTANSI_PENGIRIM LIKE "%' . $ruang_id . '%"';
}
$qry_pasien = $qry_pasien . ' GROUP BY TANGGAL_KELUAR,INSTANSI_PENGIRIM,NOMR,
				RAWAT_ID
				ORDER BY TANGGAL_KELUAR_RL,INSTANSI_PENGIRIM';

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
		<th rowspan="2">Unit - Ruang</th>
        <th colspan="2">Kepatuhan Formularium Nas/ RS</th>
		<th rowspan="2">Keterangan</th> 
		<th rowspan="2">Action</th>
	</tr>
    <tr>
      <th>Sesuai<br />Formularium Nas/ RS</th>
      <th>Tidak Sesuai<br />Formularium Nas/ RS</th>
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
            <td align="center"><?php echo $data['TANGGAL_KELUAR']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['INSTANSI_PENGIRIM']; ?></td>
			<td align="right"><?php echo currFormat($data['FORMULARIUM']); ?></td>
			<td align="right"><?php echo currFormat($data['NON_FORMULARIUM']); ?></td>
			<td><input type="text" name="keterangan<?php echo $no; ?>" id="keterangan<?php echo $no; ?>"
			class="text_dt" size="60" /></td>
			<td align="center">
				<a href='#' onclick='simpan(<?php echo $data['RAWAT_ID'] . ',"' . $data['NOMR'] . '","' . $data['TANGGAL_KELUAR'] . '",' . $data['FORMULARIUM'] . ',' . $data['NON_FORMULARIUM'] . ',' . $no; ?>)' >simpan</a>
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
<script>
function simpan(id,nomr,tg,form,nonform,dt){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=kepatuhanpenggunaanformularium',
		type: 'POST',
		async : false,
		data: {
			idx	: id,
			nomormr	: nomr,
			tanggal	: tg,
			formularium	: form,
			nonformularium	: nonform,
			keterangan : document.getElementById('keterangan' + dt).value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>