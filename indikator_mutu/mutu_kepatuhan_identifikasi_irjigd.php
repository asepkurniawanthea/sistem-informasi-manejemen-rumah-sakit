<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kepatuhanidentifikasiirj_tgl_1']))
    $tgl_1 = $_SESSION['kepatuhanidentifikasiirj_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kepatuhanidentifikasiirj_tgl_1']))
    $tgl_2 = $_SESSION['kepatuhanidentifikasiirj_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kepatuhanidentifikasiirj_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kepatuhanidentifikasiirj_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kepatuhanidentifikasiirj_searchkey']))
		$searchkey = $_SESSION['kepatuhanidentifikasiirj_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kepatuhanidentifikasiirj_searchkey'] = $searchkey;
}

$unit_id = '';
if (isset($_SESSION['kepatuhanidentifikasiirj_unit_id']))
		$unit_id = $_SESSION['kepatuhanidentifikasiirj_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['kepatuhanidentifikasiirj_unit_id'] = $unit_id;
}

$j_tanggal = '1';
if (isset($_SESSION['kepatuhanidentifikasiirj_j_tanggal']))
		$j_tanggal = $_SESSION['kepatuhanidentifikasiirj_j_tanggal'];

if (isset($_GET['j_tanggal'])) {
    $j_tanggal = $_GET['j_tanggal'];
	$_SESSION['kepatuhanidentifikasiirj_j_tanggal'] = $j_tanggal;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$tgl_skr = date('d/m/Y');	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
            <td colspan="2"><input type="radio" name="j_tanggal" value="1" <?php if($j_tanggal == '1') echo 'checked="checked"'; ?>/>&nbsp;Tanggal Masuk
			&nbsp;&nbsp;<input type="radio" name="j_tanggal" value="2" <?php if($j_tanggal == '2') echo 'checked="checked"'; ?> />&nbsp;Tanggal Keluar</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>Poliklinik/ IGD</td>
			<td><select name="unit_id" class="text_dt" style="width:210px;"
				<?php if(currentModul() == 'klinik') echo 'disabled="disabled"'; ?> >
				<option value=""> - </option>
				<?php if(currentModul() == 'monitoring mutu'){
						echo getUnit('umumigd',$unit_id);
					}else if(currentModul() == 'igd'){
						echo getUnit('igd',$_SESSION['SES_SIMRS_UNIT_ID']);
					}else if(currentModul() == 'kusta'){
						echo getUnit('kusta',$_SESSION['SES_SIMRS_UNIT_ID']);
					}else if(currentModul() == 'klinik'){
						echo getUnit('umum',$_SESSION['SES_SIMRS_UNIT_ID']);
					} 
				 ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$tgl_filter = '';
if($j_tanggal == '1'){
	$tgl_filter = 'AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '';
}else{
	$tgl_filter = 'AND STR_TO_DATE(DATE_FORMAT(irj.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(irj.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
}
$unit_filter = '';
if(currentModul() == 'monitoring mutu'){
	if(!empty($unit_id)) $unit_filter = 'AND irj.UNIT_ID = "' . $unit_id . '"';
}else{
	$unit_filter = 'AND irj.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"';
}
$qry_pasien = 'SELECT irj.IRJA_ID,irj.NOMR, 
				DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(irj.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				un.NAMA_UNIT,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				irj.MCU,un.UNIT_ID,
				mki.KEPATUHAN_IDENTIFIKASI_ID,
				mki.SEBELUM_TINDAKAN,
				mki.SEBELUM_PEMBERIAN_OBAT,
				mki.SEBELUM_TRANSFUSI,
				DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y") AS TGL_OBSERVASI, 
				mki.PENGUMPUL_DATA
				FROM db_simrs.t_irja irj
				INNER JOIN db_simrs.m_pasien psn ON (irj.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_unit un ON (irj.UNIT_ID = un.UNIT_ID)	
				LEFT JOIN db_repository.mutu_kepatuhan_identifikasi_irj_igd mki
				ON (irj.IRJA_ID = mki.RAWAT_ID)
				WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
				' . $unit_filter . ' ' . $tgl_filter;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irj.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tgl Masuk</th>
		<th rowspan="2">Tgl Keluar</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Unit - Klinik</th>
        <th colspan="3">Dilakukan Identifikasi</th>
		<th rowspan="2" width="125px">Tgl Observasi</th>
		<th rowspan="2" width="100px">Register</th>
    </tr>
    <tr>
      <th width="155px">Sebelum<br />Tindakan</th>
      <th width="155px">Sebelum<br />Pemberian Obat</th>
      <th width="155px">Sebelum<br />Transfusi</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
			<td align="center"><?php echo $data['TGL_KELUAR']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php $nama_unit = $data['NAMA_UNIT'];
			if($data['MCU'] != '') $nama_unit .= '-MCU';
			echo $nama_unit; ?></td>
			<td align="center">
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|1'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '1') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>',this.value,'tndk','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>1"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|0'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '0') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>1',this.value,'tndk','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>2"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|2'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '2') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>2',this.value,'tndk','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;NA
			</td>
			<td align="center">
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|1'; ?>"
				<?php if($data['SEBELUM_PEMBERIAN_OBAT'] == '1') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('pmob<?php echo $no; ?>',this.value,'pmob','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>1"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|0'; ?>"
				<?php if($data['SEBELUM_PEMBERIAN_OBAT'] == '0') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('pmob<?php echo $no; ?>1',this.value,'pmob','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>2"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|2'; ?>"
				<?php if($data['SEBELUM_PEMBERIAN_OBAT'] == '2') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('pmob<?php echo $no; ?>2',this.value,'pmob','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;NA
			</td>
			<td align="center">
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|1'; ?>"
				<?php if($data['SEBELUM_TRANSFUSI'] == '1') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('trfs<?php echo $no; ?>',this.value,'trfs','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>1"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|0'; ?>"
				<?php if($data['SEBELUM_TRANSFUSI'] == '0') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('trfs<?php echo $no; ?>1',this.value,'trfs','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>2"
				value="<?php echo $data['IRJA_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|2'; ?>"
				<?php if($data['SEBELUM_TRANSFUSI'] == '2') echo 'checked="checked"'; ?> 
				onclick="JavaScript : centang_opt('trfs<?php echo $no; ?>2',this.value,'trfs','usr_<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>','<?php echo $data['UNIT_ID']; ?>');"
				/>&nbsp;NA
			</td>
			<td><input type="text" name="tgl_edu_<?php echo $no; ?>" id="tgl_edu_<?php echo $no; ?>" size="10" class="text_dt"
				value="<?php $tgl_observasi = $data['TGL_OBSERVASI'];  
							if($tgl_observasi == '' or $tgl_observasi == '00/00/0000') $tgl_observasi = $tgl_skr;
							echo $tgl_observasi; ?>" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $no; ?>')" /></td>
			<td><div id="usr_<?php echo $no; ?>"><?php echo $data['PENGUMPUL_DATA']; ?></div></td>
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
function centang_opt(ck,id,fl,usr,dt,un){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=identifikasiirjigd',
		type: 'POST',
		async : false,
		data: {
			idx	: id,
			field : fl,
			dtx : document.getElementById(dt).value,
			unt : un
		},
		success: function(data) {
			document.getElementById(usr).innerHTML = data;
		},
		timeout: 60
	});
}
</script>			