<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_tgl_1']))
    $tgl_1 = $_SESSION['kepatuhanidentifikasiiri_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_tgl_1']))
    $tgl_2 = $_SESSION['kepatuhanidentifikasiiri_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kepatuhanidentifikasiiri_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kepatuhanidentifikasiiri_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_searchkey']))
		$searchkey = $_SESSION['kepatuhanidentifikasiiri_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kepatuhanidentifikasiiri_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_ruang_id']))
		$ruang_id = $_SESSION['kepatuhanidentifikasiiri_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['kepatuhanidentifikasiiri_ruang_id'] = $ruang_id;
}

$j_tanggal = '1';
if (isset($_SESSION['kepatuhanidentifikasiiri_j_tanggal']))
		$j_tanggal = $_SESSION['kepatuhanidentifikasiiri_j_tanggal'];

if (isset($_GET['j_tanggal'])) {
    $j_tanggal = $_GET['j_tanggal'];
	$_SESSION['kepatuhanidentifikasiiri_j_tanggal'] = $j_tanggal;
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
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=a22c8f1a1cdf8fe52fd13d56df5abe90" >
			<input type="button" value="tutup" class="myButton1" /></a></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$tgl_filter = '';
if($j_tanggal == '1'){
	$tgl_filter = 'AND irn.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irn.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '';
}else{
	$tgl_filter = 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
}

$qry_pasien = 'SELECT irn.IRNA_ID,irn.NOMR, 
				DATE_FORMAT(irn.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(irn.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG,
				un.RUANG_ID,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR
				FROM db_simrs.t_irna irn
				INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_ruang un ON (irn.RUANG_ID = un.RUANG_ID)	
				WHERE irn.NO_PENDAFTARAN IS NOT NULL AND irn.ST_BATAL IS NULL 
				' . $tgl_filter;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irn.IRNA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
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
        <th rowspan="2">Unit - Ruang</th>
        <th colspan="5">Dilakukan Identifikasi</th>
		<th rowspan="2">Tgl Observasi</th>
		<th rowspan="2">Action</th>
    </tr>
    <tr>
      <th width="155px">Sebelum<br />Tindakan</th>
      <th width="155px">Sebelum<br />Pemberian Obat</th>
	  <th width="155px">Sebelum<br />Pengambilan Sample</th>
	  <th width="155px">Sebelum<br />Pemberian Nutrisi</th>
      <th width="155px">Sebelum<br />Transfusi</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
			<td align="center"><?php echo $data['TGL_KELUAR']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center">
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>"
				value="2" />&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>"
				value="3" />&nbsp;NA&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>"
				value="2" />&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="pmob<?php echo $no; ?>" id="pmob<?php echo $no; ?>"
				value="3" />&nbsp;NA&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="radio" name="pspl<?php echo $no; ?>" id="pspl<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="pspl<?php echo $no; ?>" id="pspl<?php echo $no; ?>"
				value="2" />&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="pspl<?php echo $no; ?>" id="pspl<?php echo $no; ?>"
				value="3" />&nbsp;NA&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="radio" name="pnts<?php echo $no; ?>" id="pnts<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="pnts<?php echo $no; ?>" id="pnts<?php echo $no; ?>"
				value="2" />&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="pnts<?php echo $no; ?>" id="pnts<?php echo $no; ?>"
				value="3" />&nbsp;NA&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>"
				value="2" />&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="trfs<?php echo $no; ?>" id="trfs<?php echo $no; ?>"
				value="3" />&nbsp;NA&nbsp;&nbsp;
			</td>
			<td><input type="text" name="tgl_edu_<?php echo $no; ?>" id="tgl_edu_<?php echo $no; ?>" size="10" class="text_dt"
				value="<?php echo $tgl_skr; ?>" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $no; ?>')" /></td>
			<td><a href="#" onclick="simpan(<?php echo $data['IRNA_ID'] . ',' . $no; ?>);" >simpan</a></td>	
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
function simpan(id,dt){
	var x_tndk = '';
	var tindakan = document.querySelector('input[name="tndk' + dt + '"]:checked');
	if(tindakan != null){
		x_tndk = tindakan.value; 
	}
	var x_pmob = '';
	var pemb_obat = document.querySelector('input[name="pmob' + dt + '"]:checked');
	if(pemb_obat != null){
		x_pmob = pemb_obat.value; 
	}
	var x_pspl = '';
	var peng_sample = document.querySelector('input[name="pspl' + dt + '"]:checked');
	if(peng_sample != null){
		x_pspl = peng_sample.value; 
	}
	var x_pnts = '';
	var penm_nutrisi = document.querySelector('input[name="pnts' + dt + '"]:checked');
	if(penm_nutrisi != null){
		x_pnts = penm_nutrisi.value; 
	}
	var x_trfs = '';
	var sbl_transfusi = document.querySelector('input[name="trfs' + dt + '"]:checked');
	if(sbl_transfusi != null){
		x_trfs = sbl_transfusi.value; 
	}
	
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=identifikasiiri',
		type: 'POST',
		async : false,
		data: {
			idx	: id,
			tndk : x_tndk,
			pmob : x_pmob,
			pspl : x_pspl,
			pnts : x_pnts,
			trfs : x_trfs,
			tgl : document.getElementById('tgl_edu_' + dt).value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>			