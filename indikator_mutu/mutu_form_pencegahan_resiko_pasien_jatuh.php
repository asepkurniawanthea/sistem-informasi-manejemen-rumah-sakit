<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['pencegahanjatuh_tgl_1']))
    $tgl_1 = $_SESSION['pencegahanjatuh_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pencegahanjatuh_tgl_1']))
    $tgl_2 = $_SESSION['pencegahanjatuh_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pencegahanjatuh_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pencegahanjatuh_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pencegahanjatuh_searchkey']))
		$searchkey = $_SESSION['pencegahanjatuh_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pencegahanjatuh_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['pencegahanjatuh_ruang_id']))
		$ruang_id = $_SESSION['pencegahanjatuh_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pencegahanjatuh_ruang_id'] = $ruang_id;
}

$j_tanggal = '1';
if (isset($_SESSION['pencegahanjatuh_j_tanggal']))
		$j_tanggal = $_SESSION['pencegahanjatuh_j_tanggal'];

if (isset($_GET['j_tanggal'])) {
    $j_tanggal = $_GET['j_tanggal'];
	$_SESSION['pencegahanjatuh_j_tanggal'] = $j_tanggal;
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
			<a href="index.php?link=deddbee68420628c89441fb326bf85f2" >
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
        <th rowspan="2">Unit - Ruang</th>
        <th rowspan="2">Assesment<br />Jatuh Awal</br >dan Ulang</th>
		<th rowspan="2">Grading<br />Resiko</br >Jatuh</th>
        <th colspan="4">Pencegahan Jatuh</th>
		<th rowspan="2" width="65px">Jatuh</th>
		<th rowspan="2">Tgl Observasi</th>
		<th rowspan="2">Action</th>
    </tr>
    <tr>
      <th width="65px">Gelang<br />Kuning</th>
      <th width="65px">Segitiga<br />Kuning</th>
	  <th width="65px">Pagar<br />Tmp Tidur</th>
	  <th width="65px">Edukasi</th>
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
			<td><?php echo $data['NAMA_RUANG']; ?></td>
            <td><input type="text" name="assesment<?php echo $no; ?>" id="assesment<?php echo $no; ?>"
			class="text_dt" size="6" /></td>
			<td><input type="text" name="grading<?php echo $no; ?>" id="grading<?php echo $no; ?>"
			class="text_dt" size="6" /></td>
			<td align="center">
				<input type="radio" name="glk<?php echo $no; ?>" id="glk<?php echo $no; ?>"
				value="1" />&nbsp;Ya<br />
				<input type="radio" name="glk<?php echo $no; ?>" id="glk<?php echo $no; ?>"
				value="2" />&nbsp;Tdk<br />
				<input type="radio" name="glk<?php echo $no; ?>" id="glk<?php echo $no; ?>"
				value="3" />&nbsp;NA<br />
			</td>
			<td align="center">
				<input type="radio" name="stk<?php echo $no; ?>" id="stk<?php echo $no; ?>"
				value="1" />&nbsp;Ya<br />
				<input type="radio" name="stk<?php echo $no; ?>" id="stk<?php echo $no; ?>"
				value="2" />&nbsp;Tdk<br />
				<input type="radio" name="stk<?php echo $no; ?>" id="stk<?php echo $no; ?>"
				value="3" />&nbsp;NA<br />
			</td>
			<td align="center">
				<input type="radio" name="ptt<?php echo $no; ?>" id="ptt<?php echo $no; ?>"
				value="1" />&nbsp;Ya<br />
				<input type="radio" name="ptt<?php echo $no; ?>" id="ptt<?php echo $no; ?>"
				value="2" />&nbsp;Tdk<br />
				<input type="radio" name="ptt<?php echo $no; ?>" id="ptt<?php echo $no; ?>"
				value="3" />&nbsp;NA<br />
			</td>
			<td align="center">
				<input type="radio" name="edk<?php echo $no; ?>" id="edk<?php echo $no; ?>"
				value="1" />&nbsp;Ya<br />
				<input type="radio" name="edk<?php echo $no; ?>" id="edk<?php echo $no; ?>"
				value="2" />&nbsp;Tdk<br />
				<input type="radio" name="edk<?php echo $no; ?>" id="edk<?php echo $no; ?>"
				value="3" />&nbsp;NA<br />
			</td>
			<td align="center">
				<input type="radio" name="jth<?php echo $no; ?>" id="jth<?php echo $no; ?>"
				value="1" />&nbsp;Ya<br />
				<input type="radio" name="jth<?php echo $no; ?>" id="jth<?php echo $no; ?>"
				value="2" />&nbsp;Tdk
			</td>
			<td><input type="text" name="tgl_edu_<?php echo $no; ?>" id="tgl_edu_<?php echo $no; ?>" size="10" class="text_dt"
				value="<?php echo $tgl_skr; ?>" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $no; ?>')" /></td>
			<td><a href="#" onclick="simpan(<?php echo $data['IRNA_ID'] . ',' . $no . ',' . $data['RUANG_ID']; ?>);" >simpan</a></td>	
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
function simpan(id,dt,rg){
	var x_gelang_kuning = '';
	var gelang_kuning = document.querySelector('input[name="glk' + dt + '"]:checked');
	if(gelang_kuning != null){
		x_gelang_kuning = gelang_kuning.value; 
	}
	
	var x_segitiga_kuning = '';
	var segitiga_kuning = document.querySelector('input[name="stk' + dt + '"]:checked');
	if(segitiga_kuning != null){
		x_segitiga_kuning = segitiga_kuning.value; 
	}
	
	var x_pagar_tdr = '';
	var pagar_tdr = document.querySelector('input[name="ptt' + dt + '"]:checked');
	if(pagar_tdr != null){
		x_pagar_tdr = pagar_tdr.value; 
	}
	
	var x_edukasi = '';
	var edukasi = document.querySelector('input[name="edk' + dt + '"]:checked');
	if(edukasi != null){
		x_edukasi = edukasi.value; 
	}
	
	var x_jatuh = '';
	var jatuh = document.querySelector('input[name="jth' + dt + '"]:checked');
	if(jatuh != null){
		x_jatuh = jatuh.value; 
	}
	
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=pencegahanpasienjatuh',
		type: 'POST',
		async : false,
		data: {
			idx	: id,
			rng : rg,
			glk : x_gelang_kuning,
			stk : x_segitiga_kuning,
			ptt : x_pagar_tdr,
			edk : x_edukasi,
			jth : x_jatuh,
			asm : document.getElementById('assesment' + dt).value,
			grd : document.getElementById('grading' + dt).value,
			tgl : document.getElementById('tgl_edu_' + dt).value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>			