<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['monitoring_transfusi_tgl_1']))
    $tgl_1 = $_SESSION['monitoring_transfusi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['monitoring_transfusi_tgl_1']))
    $tgl_2 = $_SESSION['monitoring_transfusi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['monitoring_transfusi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['monitoring_transfusi_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['monitoring_transfusi_searchkey']))
		$searchkey = $_SESSION['monitoring_transfusi_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['monitoring_transfusi_searchkey'] = $searchkey;
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
$jam_skr = date('H');
$menit_skr = date('i');
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
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
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" /></td>
			<td>&nbsp;</td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>	
<br />
<?php
$qry_pasien = 'SELECT DISTINCT * FROM (SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
				"" AS DIAGNOSA,
				"" AS JNS_OPERASI,
				t_operasi.RAWAT_ID,t_operasi.JNS_ORDER
				FROM t_operasi
				INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				WHERE t_operasi.ST_APPROVE = "1" 
				AND t_operasi.JNS_ORDER = "IRJ"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
				"" AS DIAGNOSA,
				"" AS JNS_OPERASI,
				t_operasi.RAWAT_ID,t_operasi.JNS_ORDER
				FROM t_operasi
				INNER JOIN t_irna ON (t_operasi.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "IRN"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,
				"" AS DIAGNOSA,
				"" AS JNS_OPERASI,
				t_operasi.RAWAT_ID,t_operasi.JNS_ORDER
				FROM t_operasi
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "APS"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order WHERE 1';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
$qry_pasien = $qry_pasien . ' ORDER BY t_order.OPERASI_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Diagnosa</th>
		<th>Jenis Operasi</th>
		<th>Tranfusi Darah</th>
		<th>Dilakukan<br />Monitoring</th>
		<th>Action</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['OPERASI_ID'];
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
    echo ($hal * 10) + $no; ?></td>
            <td align="center"><?php echo $data['TANGGAL_OPERASI']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<td><?php echo $data['JNS_OPERASI']; ?></td>
			<td>
				<input type="radio" name="tranfusi<?php echo $no; ?>" id="tranfusi<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="tranfusi<?php echo $no; ?>" id="tranfusi<?php echo $no; ?>"
				value="0" />&nbsp;Tdk
			</td>
			<td>
				<input type="radio" name="monitoring<?php echo $no; ?>" id="monitoring<?php echo $no; ?>"
				value="1" />&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="monitoring<?php echo $no; ?>" id="monitoring<?php echo $no; ?>"
				value="0" />&nbsp;Tdk
			</td>
			<td><a href='#' onclick='simpan(<?php echo $data['OPERASI_ID'] . ',' . $data['RAWAT_ID'] . ',"' . $data['JNS_ORDER'] . '","' . $data['DIAGNOSA'] . '","' . $data['JNS_OPERASI'] . '","' . $data['TANGGAL_OPERASI'] . '",' . $no; ?>);' >simpan</a></td>	
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
<script language="JavaScript" >
function simpan(opr,id,ord,dg,jn,tgl,dt){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=monitoringtransfusi',
		type: 'POST',
		async : false,
		data: {
			operasi	: opr,
			idx : id,
			order : ord,
			diagnosa : dg,
			jenis : jn,
			tanggal : tgl,
			tranfusi : document.querySelector('input[name="tranfusi' + dt + '"]:checked').value,
			monitoring : document.querySelector('input[name="monitoring' + dt + '"]:checked').value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>	