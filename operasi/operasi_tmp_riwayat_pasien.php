<?php
$data_arr = '[';
$no = 0;
$get_riwayat = mysql_query($qry_riwayat) or die(mysql_error());
while ($dat_riwayat = mysql_fetch_array($get_riwayat)) {
    $no = ($no + 1);
    $data_arr = $data_arr . '{"nomor" : "' . $no . '",
								"rawat_id" : "' . $dat_riwayat['ID_JNS_PERAWATAN'] . $dat_riwayat['RAWAT_ID'] . '",
								"tanggal_masuk" : "' . $dat_riwayat['PASIEN_MASUK'] . '",
								"jenis_perawatan" : "' . $dat_riwayat['PELAYANAN'] . '",
								"diagnosa" : "' . $dat_riwayat['DIAGNOSA'] . '"},';
	
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
			{ "data": "nomor" },
			{ "data": "rawat_id" },
			{ "data": "tanggal_masuk" },
			{ "data": "jenis_perawatan" },
			{ "data": "diagnosa" }
		],
		"fnRowCallback" : function(nRow,aData,iDisplayIndex) {
			$('td:eq(1)', nRow).css( "text-align", "center" );
			$('td:eq(2)', nRow).css( "text-align", "center" );
			$('td:eq(3)', nRow).css( "text-align", "center" );
			return nRow;
		},
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
                    rawat_id: row.data().rawat_id
                },
                url: "http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=detailrmfile",
                 
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
		<th width="40px">No</th>
		<th width="100px">Kode</th>
		<th width="100px">Tanggal</th>
		<th>Pelayanan</th>
		<th>Diagnosa</th>
    </tr>
	</thead>
</table>	