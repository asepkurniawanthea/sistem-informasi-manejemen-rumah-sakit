<?php
$anamnesis = '';
$pemeriksaan_fisik = '';
$pemeriksaan_penunjang = '';

$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.ANAMNESIS,
				t_irja.PEMERIKSAAN_FISIK, t_irja.PEMERIKSAAN_PENUNJANG
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$anamnesis = $dat_pasien['ANAMNESIS'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pasien['PEMERIKSAAN_PENUNJANG'];

if (isset($_POST['irja_id']))
    include('operasi/klinik_save_anamnesis.php');
?>
<style>
table tr td{
border:0px solid #ccc;
}


table.sub_tbl tr td,table.sub_tbl tr th{
border-collapse:collapse;
border-color:#CCCCCC;
border:1px solid #ccc;
}
table.sub_tbl th {
		background: #bfd255; /* Old browsers */
	background: -moz-linear-gradient(top, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfd255', endColorstr='#9ecb2d',GradientType=0 );
	color:#fff;
	padding:5px;
	
}
table.sub_tbl input {		
	margin:5px;	
}
table.sub_tbl tr td{		
	padding:5px;
	border:1px solid #ccc;
	border-collapse:collapse;
	border-color:#CCCCCC;	
}
.lap_bedah{	
	padding:5px;
}
.lap_bedah tr td{
	border:1px solid #ccc;
	padding:5px;
}
</style>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />		   
	<table border="1" cellpadding="0" cellspacing="0" align="center" style="position:static; " width="80%" class="lap_bedah">
		<tr>
			<td colspan="3" align="center" style="font-size:18px; ">LAPORAN PEMBEDAHAN</td>
		</tr>
		<tr>
			<td colspan="3" align="center" style="font-size:18px; ">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" align="center" style="font-size:18px; ">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" >Nama Pasien :</td>
			<td align="left" >Nama Tambahan</td>
			<td align="left" >Jenis Kelamin</td>
		</tr>
		<tr>
			<td align="left" >DPJP Bedah :</td>
			<td align="left" >Operator 1</td>
			<td align="left" >Asisten Oeprator :</td>
		</tr>
		<tr>
			<td align="left" >DPJP Anestesiologi :</td>
			<td align="left" colspan="2" >Asisten Anestesiologi</td>
		</tr>
		
		
    </table>
</form>