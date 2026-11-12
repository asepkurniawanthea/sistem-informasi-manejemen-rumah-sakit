<script>
	function buka_filter(val){
		window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&filter_report=" + val;
	}
	
	function centang_opt(ck,val){
		if(document.getElementById('kd_jenis_tarif' + ck).checked){
			MyAjaxRequest('msg_ta','index.php?ajaxrequest=simpancekfilterreport&opt=1&val=' + val);
			return false;
		}else{
			MyAjaxRequest('msg_ta','index.php?ajaxrequest=simpancekfilterreport&opt=2&val=' + val);
			return false;
		}
	}
</script>
<?php
$filter_report = '';
if(isset($_GET['filter_report'])) $filter_report = $_GET['filter_report']; 
?>
<form name="form1" id="form1" method="post" >
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table width="40%" class="tableform" border="0">
	<tr>
		<td>Filter Report (Tarif)</td>
		<td>
			<select name="filter_report" class="text_dt" style="width:200px;" onchange="buka_filter(this.value); return false;" >
				<option value="">-</option>
				<?php
					$sql_filter_report = 'SELECT * FROM m_jenis_tarif';
					$get_filter_report = mysql_query($sql_filter_report) or die(mysql_error());
					while($dat_filter_report = mysql_fetch_array($get_filter_report)){
						echo '<option value="' . $dat_filter_report['KODE_JENIS_TARIF'] . '" ' . (($filter_report == $dat_filter_report['KODE_JENIS_TARIF']) ? 'selected="selected"' : '') . ' >' . $dat_filter_report['JENIS_TARIF'] . '</option>';
					}
				?>
			</select>
		</td>
	</tr>	
</table>
<table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                &nbsp;
            </td>			
        </tr> 
	</table>		
<?php
$qry_tarif = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP,
					t_filter_report_tarif.KODE_JENIS_TARIF,m_tarif_group.NON_KELAS
					FROM m_tarif_group
					LEFT JOIN t_filter_report_tarif 
					ON (m_tarif_group.KODE_TARIF_GROUP = t_filter_report_tarif.KODE_TARIF_GROUP
					AND t_filter_report_tarif.KODE_JENIS_TARIF = "' . $filter_report . '"
					AND t_filter_report_tarif.LEVEL_DT = "1")
					ORDER BY m_tarif_group.NON_KELAS,m_tarif_group.NAMA_TARIF_GROUP';
$data_arr = '[';
$no = 0;
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    $no = ($no + 1);
    $data_arr = $data_arr . '{"nomor" : "' . $no . '",
								"kode_tarif_group" : "' . $dat_tarif['KODE_TARIF_GROUP'] . '",
								"nama_tarif_group" : "' . $dat_tarif['NAMA_TARIF_GROUP'] . '",
								"kelas" : "' . (($dat_tarif['NON_KELAS'] == '1') ? 'Non Kelas' : 'Kelas') . '",
								"ck" : "' . $no . '|1-' . $dat_tarif['KODE_TARIF_GROUP'] . '|' . $dat_tarif['KODE_JENIS_TARIF'] . '|' . $filter_report . '"},';
	
}
$data_arr = substr($data_arr,0,strlen($data_arr) - 1);
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
	var table = $('#example').DataTable( {
		data: dataSet,
		"columns": [
			{
				"className":      'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{ "data": "kode_tarif_group" },
			{ "data": "nama_tarif_group" },
			{ "data": "kelas" },
			{ "data": "ck" }
		],
		"fnRowCallback" : function(nRow,aData,iDisplayIndex) {
			$('td:eq(1)', nRow).css( "text-align", "center" );
			$('td:eq(2)', nRow).css( "text-align", "left" );
			$('td:eq(3)', nRow).css( "text-align", "left" );
			$('td:eq(4)', nRow).css( "text-align", "center" );
			return nRow;
		},
		"aoColumnDefs": [{
            "aTargets": [4],
            "mRender": function (data, type, full) {
                var arr_data = data.split('|');
				if (arr_data[2] != '') {
                    return '<input type="checkbox" name="kd_jenis_tarif' + arr_data[0] + '" id="kd_jenis_tarif' + arr_data[0] + '" checked value="' + arr_data[1] + '|' + arr_data[3] + '" onclick="JavaScript : centang_opt(' + arr_data[0] + ',this.value);">';
                } else {
				return '<input type="checkbox" name="kd_jenis_tarif' + arr_data[0] + '" id="kd_jenis_tarif' + arr_data[0] + '" value="' + arr_data[1] + '|' + arr_data[3] + '" onclick="JavaScript : centang_opt(' + arr_data[0] + ',this.value);">';
                }
            }
        }],
		"paging":   false,
		"info":   false,
		"ordering": false,
		"filter": false,
		"order": [[1, 'asc']]
	} );
	
	// Add event listener for opening and closing details
	$('#example tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table.row( tr );

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			$.ajax({
                type: 'POST',
                data: {
                    kode_tarif_group: row.data().ck
                },
                url: "http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=detailtarif",
                 
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
<table id="example" class="tableData" >
    <thead>
	<tr>
		<th width="40px"></th>
		<th width="100px">Kode</th>
		<th>Nama  Tarif Group</th>
		<th width="150px">Kelas/Non Kelas</th>
		<th width="150px">Option</th>
    </tr>
	</thead>
</table>
</form>
<div id="msg_ta"></div>