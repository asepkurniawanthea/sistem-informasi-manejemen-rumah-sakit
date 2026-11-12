<?php
$data_arr = '[';
$no = 0;
$pager = new PS_Pagination($connect, $qry_tindakan, 15, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
								"kode_tarif" : "' . $data['KODE_TARIF'] . '-' . $data['TARIF_ID'] . '",
								"nama_tarif" : "' . $data['NAMA_TARIF'] . '",
								"group" : "' . $data['NAMA_TARIF_GROUP'] . '",
								"tarif_non_kelas" : "' . currFormat($data['TARIF_NON_KELAS']) . '",
								"tarif_kelas_3" : "' . currFormat($data['TARIF_KELAS_3']) . '",
								"tarif_kelas_2" : "' . currFormat($data['TARIF_KELAS_2']) . '",
								"tarif_kelas_1" : "' . currFormat($data['TARIF_KELAS_1']) . '",
								"tarif_kelas_utama" : "' . currFormat($data['TARIF_KELAS_UTAMA']) . '",
								"tarif_kelas_utama_2" : "' . currFormat($data['TARIF_KELAS_UTAMA_2']) . '",
								"tarif_hcu" : "' . currFormat($data['TARIF_HCU']) . '",
								"tarif_icu" : "' . currFormat($data['TARIF_ICU']) . '",
								"tarif_nicu" : "' . currFormat($data['TARIF_NICU']) . '",
								"tarif_picu" : "' . currFormat($data['TARIF_PICU']) . '",
								"tarif_iccu" : "' . currFormat($data['TARIF_ICCU']) . '",
								"tarif_perina" : "' . currFormat($data['TARIF_PERINA']) . '",
								"tarif_perina_sehat" : "' . currFormat($data['TARIF_KELAS_PERINA_SEHAT']) . '",
								"tarif_perina_sakit" : "' . currFormat($data['TARIF_KELAS_PERINA_SAKIT']) . '",
								"st_aktif" : "' . (($data['ST_AKTIF'] == '1') ? '&radic;' : '') . '",
								"register" : "' . $data['USER_ADMIN'] . '"},';
	
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
			{ "data": "kode_tarif" },
			{ "data": "nama_tarif" },
			{ "data": "group" },
			{ "data": "tarif_non_kelas" },
			{ "data": "tarif_kelas_3" },
			{ "data": "tarif_kelas_2" },
			{ "data": "tarif_kelas_1" },
			{ "data": "tarif_kelas_utama" },
			{ "data": "tarif_kelas_utama_2" },
			{ "data": "tarif_hcu" },
			{ "data": "tarif_icu" },
			{ "data": "tarif_nicu" },
			{ "data": "tarif_picu" },
			{ "data": "tarif_iccu" },
			{ "data": "tarif_perina" },
			{ "data": "tarif_perina_sehat" },
			{ "data": "tarif_perina_sakit" },
			{ "data": "st_aktif" },
			{ "data": "register" }
		],
		"fnRowCallback" : function(nRow,aData,iDisplayIndex) {
			$('td:eq(1)', nRow).css( "text-align", "center" );
			$('td:eq(2)', nRow).css( "text-align", "center" );
			$('td:eq(5)', nRow).css( "text-align", "right" );
			$('td:eq(6)', nRow).css( "text-align", "right" );
			$('td:eq(7)', nRow).css( "text-align", "right" );
			$('td:eq(8)', nRow).css( "text-align", "right" );
			$('td:eq(9)', nRow).css( "text-align", "right" );
			$('td:eq(10)', nRow).css( "text-align", "right" );
			$('td:eq(11)', nRow).css( "text-align", "right" );
			$('td:eq(12)', nRow).css( "text-align", "right" );
			$('td:eq(13)', nRow).css( "text-align", "right" );
			$('td:eq(14)', nRow).css( "text-align", "right" );
			$('td:eq(15)', nRow).css( "text-align", "right" );
			$('td:eq(16)', nRow).css( "text-align", "right" );
			$('td:eq(17)', nRow).css( "text-align", "right" );
			$('td:eq(18)', nRow).css( "text-align", "right" );
			$('td:eq(19)', nRow).css( "text-align", "center" );
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
                    tarif_id: row.data().kode_tarif
                },
                url: "http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=detailtarifupdate",
                 
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
<div id="table_data">
<table id="example" border="1" class="tableData" id="tfhover" >
	<thead>
    <tr>
        <th></th>
		<th>No</th>
		<th>Kode-ID</th>
        <th>Nama Tarif</th>
		<th>Group</th>
		<th>Non_Kelas</th>
		<th>Kelas_3</th>
		<th>Kelas_2</th>
		<th>Kelas_1</th>
		<th>Kelas_Utama<br />(VIP)</th>
		<th>Kelas_Utama_2<br />(VVIP)</th>
		<th>HCU</th>
		<th>ICU</th>
		<th>NICU</th>
		<th>PICU</th>
		<th>ICCU</th>
		<th>Perina</th>
		<th>Perina_Sehat</th>
		<th>Perina_Sakit</th>
		<th>Aktif</th>
		<th>Register</th>
    </tr>
	</thead>
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
</div>
<div id="form_data" style="display:none;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
			<form name="form_br" id="form_br" method="post">
			<table border="0" class="tableform" >
				<tr>
					<td>&nbsp;</td>
					<td>Kode Tarif</td>
					<td colspan="4"><input type="text" name="kode_tarif" value="" class="text_dt" style="width:350px;" /></td>
				</tr>
				<tr>
					<td width="23">&nbsp;</td>
					<td width="200">Tarif Group</td>
					<td><select name="kode_tarif_group" class="text_dt" style="width:358px;" >
						<option value=""> -- </option>
					<?php $sql_group = 'SELECT * FROM m_tarif_group ORDER BY NAMA_TARIF_GROUP';
						$get_group = mysql_query($sql_group) or die(mysql_error());	
						while($dat_group = mysql_fetch_array($get_group)){ ?>
						<option value="<?php echo $dat_group['KODE_TARIF_GROUP']; ?>"><?php echo $dat_group['NAMA_TARIF_GROUP'] . ' (' . $dat_group['KODE_TARIF_GROUP'] . ')'; ?></option>
					<?php } ?>
					</select></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana ICU</td>
					<td><input type="text" name="jasa_sarana_icu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Nama</td>
					<td><input type="text" name="nama_tarif" value="" class="text_dt" style="width:350px;" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan ICU</td>
					<td><input type="text" name="jasa_pelayanan_icu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Satuan</td>
					<td><input type="text" name="satuan" value="" class="text_dt" style="width:350px;" /></td>
					<td>&nbsp;</td>
					<td>Tarif ICU</td>
					<td><input type="text" name="tarif_icu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana</td>
					<td><input type="text" name="jasa_sarana" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana NICU</td>
					<td><input name="jasa_sarana_nicu" type="text" class="text_dt" id="jasa_sarana_nicu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Dokter</td>
					<td><input type="text" name="jasa_dokter" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan NICU</td>
					<td><input name="jasa_pelayanan_nicu" type="text" class="text_dt" id="jasa_pelayanan_nicu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa RS</td>
					<td><input type="text" name="jasa_rs" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif NICU</td>
					<td><input name="tarif_nicu" type="text" class="text_dt" id="tarif_nicu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan</td>
					<td><input type="text" name="jasa_pelayanan" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana PICU</td>
					<td><input name="jasa_sarana_picu" type="text" class="text_dt" id="jasa_sarana_picu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Non Kelas</td>
					<td><input type="text" name="tarif_non_kelas" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan PICU</td>
					<td><input name="jasa_pelayanan_picu" type="text" class="text_dt" id="jasa_pelayanan_picu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 3</td>
					<td><input type="text" name="jasa_sarana_kelas_3" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif PICU</td>
					<td><input name="tarif_picu" type="text" class="text_dt" id="tarif_picu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 3</td>
					<td><input type="text" name="jasa_pelayanan_kelas_3" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana ICCU </td>
					<td><input name="jasa_sarana_iccu" type="text" class="text_dt" id="jasa_sarana_iccu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 3</td>
					<td><input type="text" name="tarif_kelas_3" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan ICCU </td>
					<td><input name="jasa_pelayanan_iccu" type="text" class="text_dt" id="jasa_pelayanan_iccu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 2</td>
					<td><input type="text" name="jasa_sarana_kelas_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif ICCU </td>
					<td><input name="tarif_iccu" type="text" class="text_dt" id="tarif_iccu" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 2</td>
					<td><input type="text" name="jasa_pelayanan_kelas_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana Perina </td>
					<td><input name="jasa_sarana_perina" type="text" class="text_dt" id="jasa_sarana_perina" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 2</td>
					<td><input type="text" name="tarif_kelas_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Perina </td>
					<td><input name="jasa_pelayanan_perina" type="text" class="text_dt" id="jasa_pelayanan_perina" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 1</td>
					<td><input type="text" name="jasa_sarana_kelas_1" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif Perina </td>
					<td><input name="tarif_perina" type="text" class="text_dt" id="tarif_perina" style="width:350px;text-align:right" value="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 1</td>
					<td><input type="text" name="jasa_pelayanan_kelas_1" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas Perina Sehat</td>
					<td><input type="text" name="jasa_sarana_kelas_perina_sehat" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 1</td>
					<td><input type="text" name="tarif_kelas_1" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas Perina Sehat</td>
					<td><input type="text" name="jasa_pelayanan_kelas_perina_sehat" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Utama (VIP) </td>
				  <td><input type="text" name="jasa_sarana_kelas_utama" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Perina Sehat</td>
				  <td><input type="text" name="tarif_kelas_perina_sehat" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Utama (VIP) </td>
				  <td><input type="text" name="jasa_pelayanan_kelas_utama" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Perina Sakit</td>
				  <td><input type="text" name="jasa_sarana_kelas_perina_sakit" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Utama (VIP) </td>
				  <td><input type="text" name="tarif_kelas_utama" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Perina Sakit</td>
				  <td><input type="text" name="jasa_pelayanan_kelas_perina_sakit" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="jasa_sarana_kelas_utama_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Perina Sakit</td>
				  <td><input type="text" name="tarif_kelas_perina_sakit" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="jasa_pelayanan_kelas_utama_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Mapping LIS</td>
				  <td><select name="kode_mapping" class="text_dt" style="width:358px;" >
					<option value=""> -- </option>
					<option value="x"><--Pemeriksaan Baru--></option>
					<?php 
						$sql_mapping = 'SELECT KODE_PEMERIKSAAN_LAB,NAMA_PEMERIKSAAN_LAB FROM m_tarif_pemeriksaan_lab
							ORDER BY NAMA_PEMERIKSAAN_LAB';
						$get_mapping = mysql_query($sql_mapping) or die(mysql_error());	
						while($dat_mapping = mysql_fetch_array($get_mapping)){
					?>
						<option value="<?php echo $dat_mapping['KODE_PEMERIKSAAN_LAB']; ?>"><?php echo $dat_mapping['NAMA_PEMERIKSAAN_LAB']; ?></option>
					<?php } ?>
					</select>
				  </td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="tarif_kelas_utama_2" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana HCU</td>
				  <td><input type="text" name="jasa_sarana_hcu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan HCU</td>
					<td><input type="text" name="jasa_pelayanan_hcu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif HCU</td>
				  <td><input type="text" name="tarif_hcu" value="" class="text_dt" style="width:350px;text-align:right" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="checkbox" name="st_aktif" value="1" checked="checked" />
                    Aktif&nbsp;&nbsp;
                    <input name="button" type="button" class="myButton" onclick="simpan_tambah();" value="simpan"/>
					<input type="reset" value="reset" class="myButton" />
					<input type="button" value="tutup" class="myButton" onclick="tutup();" /></td>
				</tr>
			</table>
			<input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
			</form>
		</div>	
</div>	
<script type="text/javascript" language="javascript">
function tambah_tarif(){
	document.getElementById("table_data").style.display = 'none';
	document.getElementById("form_data").style.display = 'block';
}

function tutup(){
	document.getElementById("table_data").style.display = 'block';
	document.getElementById("form_data").style.display = 'none';
}

function simpan_update(form_id) {
	var form_data = new FormData($('#form' + form_id)[0]);
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=simpantarifupdate',
		type: 'POST',
		processData: false,
		contentType: false,
		data: form_data,
		cache: false,
		success: function(data) {
			if(data == 'ok'){
				alert('Data Perubahan Telah Disimpan');
				window.location = "<?php echo currentUrl(); ?>";
			}else{
				alert(data);
			}
		},
		timeout: 10000
	});
}

function simpan_tambah() {
	var form_data = new FormData($('#form_br')[0]);
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=simpantariftambah',
		type: 'POST',
		processData: false,
		contentType: false,
		data: form_data,
		cache: false,
		success: function(data) {
			if(data == 'ok'){
				alert('Data Telah Disimpan');
				window.location = "<?php echo currentUrl(); ?>";
			}else{
				alert(data);
			}
		},
		timeout: 10000
	});
}
</script>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
	<input type="hidden" name="xlsfile" value="admin/xls_master_tarif.php" />
    <input type="hidden" name="xlsname" value="master_tarif.xls" /> 
</form>	