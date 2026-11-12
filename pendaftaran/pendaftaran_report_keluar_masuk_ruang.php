<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapruang_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapruang_tgl_1'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapruang_tgl_1'] = $_GET['tgl_1'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}	

$qry_kunjungan = 'SELECT SUM(PASIEN_KELUAR) AS PASIEN_KELUAR, SUM(PASIEN_MASUK) AS PASIEN_MASUK,
					RUANG_ID, NAMA_RUANG,KELAS_RAWAT,
					JNS_PERAWATAN,DESKRIPSI
					FROM (
					SELECT m_ruang.RUANG_ID, m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
					m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,COUNT(t_irna_log.IRNA_LOG_ID) AS PASIEN_KELUAR,
					0 AS PASIEN_MASUK
					FROM m_ruang
					LEFT JOIN t_irna_log ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					AND t_irna_log.JNS_UPDATE = "R")
					GROUP BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
					UNION
					SELECT m_ruang.RUANG_ID, m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
					m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,0 AS PASIEN_KELUAR,
					COUNT(t_irna_log.IRNA_LOG_ID) AS PASIEN_MASUK
					FROM m_ruang
					LEFT JOIN t_irna_log ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					AND t_irna_log.JNS_UPDATE = "R")
					GROUP BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
					) t_ruang 
					GROUP BY RUANG_ID, NAMA_RUANG,KELAS_RAWAT
					ORDER BY NAMA_RUANG,KELAS_RAWAT';
$data_arr = '[';
$no = 0;
$pager = new PS_Pagination($connect, $qry_kunjungan, 15, 5, '&tgl_1=' . $tgl_1, 'index.php?link=' . $_REQUEST['link']);
$rs = $pager->paginate();
if (!$rs) die(mysql_error());
while ($data = mysql_fetch_array($rs)) { 
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
	$nomor = ($hal * 15) + $no;
    $data_arr = $data_arr . '{"nomor" : "' . $nomor . '",
								"ruang_id" : "' . $data['RUANG_ID'] . '",
								"ruang_rawat" : "' . $data['NAMA_RUANG'] . '",
								"kelas" : "' . $data['KELAS_RAWAT'] . '",
								"jns_perawatan" : "' . $data['JNS_PERAWATAN'] . '",
								"deskripsi" : "' . $data['DESKRIPSI'] . '",
								"jml_pasien_masuk" : "' . $data['PASIEN_MASUK'] . '",
								"jml_pasien_keluar" : "' . $data['PASIEN_KELUAR'] . '"},';
	
}

$qry_total = 'SELECT SUM(PASIEN_KELUAR) AS PASIEN_KELUAR, SUM(PASIEN_MASUK) AS PASIEN_MASUK
					FROM (SELECT m_ruang.RUANG_ID, m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
					m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,COUNT(t_irna_log.IRNA_LOG_ID) AS PASIEN_KELUAR,
					0 AS PASIEN_MASUK
					FROM m_ruang
					LEFT JOIN t_irna_log ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					AND t_irna_log.JNS_UPDATE = "R")
					GROUP BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
					UNION
					SELECT m_ruang.RUANG_ID, m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
					m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,0 AS PASIEN_KELUAR,
					COUNT(t_irna_log.IRNA_LOG_ID) AS PASIEN_MASUK
					FROM m_ruang
					LEFT JOIN t_irna_log ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					AND t_irna_log.JNS_UPDATE = "R")
					GROUP BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
					) t_ruang';
$get_total = mysql_query($qry_total) or die(mysql_error());
$dat_total = mysql_fetch_assoc($get_total);
$data_arr = $data_arr . '{"nomor" : "",
								"ruang_id" : "",
								"ruang_rawat" : "",
								"kelas" : "",
								"jns_perawatan" : "",
								"deskripsi" : "<strong>TOTAL PASIEN</strong>",
								"jml_pasien_masuk" : "<strong>MASUK : ' . $dat_total['PASIEN_MASUK'] . '</strong>",
								"jml_pasien_keluar" : "<strong>KELUAR : ' . $dat_total['PASIEN_KELUAR'] . '</strong>"}';
//$data_arr = substr($data_arr,0,strlen($data_arr) - 1);
$data_arr = $data_arr . '];';
?>
<style type="text/css" class="init">
	td.details-control {
	background: url('lib/datatable/examples/resources/details_open.png') no-repeat center center;
	cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('lib/datatable/examples/resources/details_close.png') no-repeat center center;
	}
</style>
<script type="text/javascript" language="javascript" src="lib/datatable/media/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatable/examples/resources/syntax/shCore.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatable/examples/resources/demo.js"></script>
<script type="text/javascript" language="javascript" class="init">
var dataSet = <?php echo $data_arr; ?>

$(document).ready(function() {
	var table = $('#tfhover').DataTable( {
		data: dataSet,
		"columns": [
			{
				"className":      'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{ "data": "nomor" },
			{ "data": "ruang_id" },
			{ "data": "ruang_rawat" },
			{ "data": "kelas" },
			{ "data": "jns_perawatan" },
			{ "data": "deskripsi" },
			{ "data": "jml_pasien_masuk" },
			{ "data": "jml_pasien_keluar" }
		],
		"fnRowCallback" : function(nRow,aData,iDisplayIndex) {
			$('td:eq(0)', nRow).css( "text-align", "center" );
			$('td:eq(1)', nRow).css( "text-align", "center" );
			$('td:eq(2)', nRow).css( "text-align", "center" );
			$('td:eq(4)', nRow).css( "text-align", "center" );
			$('td:eq(7)', nRow).css( "text-align", "right" );
			$('td:eq(8)', nRow).css( "text-align", "right" );
			return nRow;
		},
		"paging":   false,
		"info":   false,
		"ordering": false,
		"filter": false,
		"order": [[1, 'asc']]
	} );
	
	// Add event listener for opening and closing details
	$('#tfhover tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table.row( tr );

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			var tgl = $('#tgl_1').val();
			
			$.ajax({
                type: 'POST',
                data: {
                    ruang_id: row.data().ruang_id, tanggal: tgl
                },
                url: "http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=irnadetailkeluarmasukruang",
                 
                success: function (response) {
                    row.child( response ).show();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    row.child( 'Error loading content: ' + thrownError ).show();
                }
            });
            tr.addClass('shown');
		}
	} );
} );
</script>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>&nbsp;</td>
            <td><input type="submit" value="cari" class="myButton" /></td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<table id="tfhover" class="tableData" >
    <thead>
	<tr>
		<th width="40px;"></th>
		<th width="40px;">No</th>
		<th width="40px;">Id</th>
		<th>Nama Ruang</th>
		<th>Kelas</th>
		<th>Perawatan</th>
		<th>Deskripsi</th>
		<th>Pasien Masuk</th>
		<th>Pasien Keluar</th>
    </tr>
	</thead>
</table>	
<table width="100%" border="0" class="tableNav" >
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
								<td align="center">&nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>

