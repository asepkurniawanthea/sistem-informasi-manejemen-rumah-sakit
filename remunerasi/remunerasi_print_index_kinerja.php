<?php 
$pdf_content = '<style>.tbl tr td {
			   border: 1px solid black;
			   padding-left:1px;
			   padding-bottom:1px;
			   border-collapse: collapse;
			}</style>
			<style>.tbc tr td {
			   border: none;
			   padding-left:1px;
			   padding-bottom:1px;
			   border-collapse: collapse;
			}</style>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbc" autosize="1" >
			<tr>
				<td colspan="6" align="center"><strong>SASARAN KINERJA PEGAWAI (SKP)</strong></td>
			</tr>
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td width="16%" colspan="2"><strong>Unit Kerja</strong></td>
				<td width="25%" colspan="4">:&nbsp;<strong>' . $unit_kerja . '</strong></td>
			</tr>
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td width="3%" align="center"><strong>NO</strong></td>
				<td colspan="2"><strong>PEJABAT PENILAI</strong></td>
				<td width="3%" align="center"><strong>NO</strong></td>
				<td colspan="2"><strong>PEGAWAI NEGERI SIPIL YANG DINILAI</strong></td>
			</tr>
			<tr>
				<td align="center">1</td>
				<td width="15%">Nama</td>
				<td>:&nbsp;' . $nama_penilai . '</td>
				<td align="center">1</td>
				<td width="15%">Nama</td>
				<td>:&nbsp;' . $nama_pegawai . '</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>NIP</td>
				<td>:&nbsp;' . $nip_pnl . '</td>
				<td align="center">2</td>
				<td>NIP</td>
				<td>:&nbsp;' . $nip . '</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Pangkat/Gol. Ruang</td>
				<td>:&nbsp;' . $golongan_pnl . '</td>
				<td align="center">3</td>
				<td>Pangkat/Gol. Ruang</td>
				<td>:&nbsp;' . $golongan . '</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Jabatan</td>
				<td>:&nbsp;' . $jabatan_desc_pnl . '</td>
				<td align="center">4</td>
				<td>Jabatan</td>
				<td>:&nbsp;' . $jabatan_desc . '</td>
			</tr>
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
		</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbl" autosize="1" >
	  <tr>
		<td rowspan="2">NO</td>
		<td rowspan="2">KRITERIA</td>
		<td rowspan="2">% TARGET </td>
		<td rowspan="2">% DETAIL<br/>TARGET </td>
		<td rowspan="2">URAIAN KEGIATAN </td>
		<td colspan="2">TARGET</td>
		<td rowspan="2">JUMLAH<br />PERSONIL </td>
		<td rowspan="2">OB</td>
	    <td rowspan="2">SATUAN</td>
        <td rowspan="2" colspan="3">CAPAIAN</td>
	  </tr>
	  <tr>
		<td>TAHUN</td>
		<td>BULAN</td>
	  </tr>';

mysql_data_seek($get_remun,0);
$kriteria_id = '';
$x = 1;
$r = 1;
while($dat_remun = mysql_fetch_array($get_remun)){
	$pdf_content = $pdf_content . '<tr>';
	if($dat_remun['KRITERIA_KINERJA_ID'] != $kriteria_id){
		$kriteria_id = $dat_remun['KRITERIA_KINERJA_ID'];
		$pdf_content = $pdf_content . '<td align="center" rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $x . '</td>';
		$pdf_content = $pdf_content . '<td rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $dat_remun['KRITERIA'] . '</td>';
		$pdf_content = $pdf_content . '<td align="center" rowspan="' . $rspan_kriteria[$dat_remun['KRITERIA_KINERJA_ID']] . '">' . $sum_target[$dat_remun['KRITERIA_KINERJA_ID']] . '</td>';
		$x++;
	}
	$capaian_persen = floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100;
	$capaian_index = (($dat_remun['KRITERIA_KINERJA_ID'] == '2' or $dat_remun['KRITERIA_KINERJA_ID'] == '3') ? $capaian_kinerja * ($dat_remun['TARGET']/100) : (floor(($dat_remun['OB'] / $dat_remun['TARGET_BULAN']) * 100) / 100) * ($dat_remun['TARGET']/100));
	$pdf_content = $pdf_content . '<td align="center">' . $dat_remun['TARGET'] . '</td>
		<td>' . $dat_remun['KEGIATAN'] . '</td>
		<td align="center">' . $dat_remun['TARGET_TAHUN'] . '</td>
		<td align="center">' . $dat_remun['TARGET_BULAN'] . '</td>
		<td align="center">' . $jumlah_personil . '</td>
		<td align="center">' . $dat_remun['OB'] . '</td>
		<td align="center">' . $dat_remun['SATUAN'] . '</td>
		<td align="center">' . $capaian_persen . '</td>
		' .  (($r == 1) ? '<td align="center" rowspan="' . $total_row . '">' . $capaian_kinerja . '</td>' : '') . '
		<td align="center">' . $capaian_index . '</td></tr>';
	  $r++; 
} 
$pdf_content = $pdf_content . '<tr><td colspan="12" align="center">TOTAL CAPAIAN</td>
		<td align="center">' . $total_capaian_print . '</td></tr>';

$date = new DateTime();
$tahun = $date->format('Y');
$bulan = substr('00',0,2- strlen($date->format('m'))) . $date->format('m');
$hari = substr('00',0,2- strlen($date->format('d'))) . $date->format('d');
$pdf_content = $pdf_content . '</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbc" autosize="1" >
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
			<td width="20%">Tangerang, ' . $hari . ' ' . $arr_bulan[$bulan] . ' ' . $tahun . '</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
			<td>Kepala Bagian/Instalasi/Unit</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
			<td>' . $unit_kerja . '</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
			<td>' . $nama_penilai . '</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
			<td>NIP. ' . $nip_pnl . '</td>
		</tr>
	</table>';

include('lib/mpdf/mpdf.php');
$mpdf = new mPDF('utf-8', array(340,220));
$mpdf->WriteHTML($pdf_content);
$mpdf->autoPageBreak = false;
$filename = substr('00000',0,5 - strlen($idx)) . $idx . $tahun . $bulan . '.pdf'; 
$mpdf->Output('remunerasi/'. $filename);	
?>
<script language="JavaScript" >
	window.open('http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/remunerasi/<?php echo $filename; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=678,height=1024'); 
</script>