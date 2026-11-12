<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');
include('./shared/enum_function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$jns_bayar = $_POST['jns_bayar'];		

$arr_akomodasi =  str_replace('`','"',$_POST['arr_akomodasi']);
$arr_visit_dokter_umum =  str_replace('`','"',$_POST['arr_visit_dokter_umum']);
$arr_visit_dokter_spesialis =  str_replace('`','"',$_POST['arr_visit_dokter_spesialis']);
$arr_tindakan_ri =  str_replace('`','"',$_POST['arr_tindakan_ri']);

$arr_karcis =  str_replace('`','"',$_POST['arr_karcis']);
$arr_konsul_dokter_umum_igd =  str_replace('`','"',$_POST['arr_konsul_dokter_umum_igd']);
$arr_konsul_dokter_spesialis_igd =  str_replace('`','"',$_POST['arr_konsul_dokter_spesialis_igd']);
$arr_tindakan_igd =  str_replace('`','"',$_POST['arr_tindakan_igd']);

$arr_konsul_dokter_umum_rj =  str_replace('`','"',$_POST['arr_konsul_dokter_umum_rj']);
$arr_konsul_dokter_spesialis_rj =  str_replace('`','"',$_POST['arr_konsul_dokter_spesialis_rj']);
$arr_tindakan_rj =  str_replace('`','"',$_POST['arr_tindakan_rj']);

$arr_konsul_dokter_umum_opr =  str_replace('`','"',$_POST['arr_konsul_dokter_umum_opr']);
$arr_konsul_dokter_spesialis_opr =  str_replace('`','"',$_POST['arr_konsul_dokter_spesialis_opr']);

$arr_operasi =  str_replace('`','"',$_POST['arr_operasi']);

$arr_laboratorium =  str_replace('`','"',$_POST['arr_laboratorium']);
$arr_radiologi =  str_replace('`','"',$_POST['arr_radiologi']);
$arr_fisioterapi =  str_replace('`','"',$_POST['arr_fisioterapi']);
$arr_okupasi_terapi =  str_replace('`','"',$_POST['arr_okupasi_terapi']);
$arr_prothese =  str_replace('`','"',$_POST['arr_prothese']);
$arr_psikologi =  str_replace('`','"',$_POST['arr_psikologi']);

$arr_terapi_wicara =  str_replace('`','"',$_POST['arr_terapi_wicara']);
$arr_perawatan_luka =  str_replace('`','"',$_POST['arr_perawatan_luka']);

$arr_pmi =  str_replace('`','"',$_POST['arr_pmi']);
$arr_skrining_gizi =  str_replace('`','"',$_POST['arr_skrining_gizi']);
$arr_askep =  str_replace('`','"',$_POST['arr_askep']);
$arr_sewalahan =  str_replace('`','"',$_POST['arr_sewalahan']);
$arr_diklat =  str_replace('`','"',$_POST['arr_diklat']);

$arr_peml_jenazah =  str_replace('`','"',$_POST['arr_peml_jenazah']);
$arr_ambulance =  str_replace('`','"',$_POST['arr_ambulance']);
$arr_londry =  str_replace('`','"',$_POST['arr_londry']);

$arr_konsul_di_rj = $arr_konsul_dokter_umum_rj . ',' . $arr_konsul_dokter_spesialis_rj;
$arr_konsul_di_igd = $arr_konsul_dokter_umum_igd . ',' . $arr_konsul_dokter_spesialis_igd . ',' . $arr_konsul_dokter_umum_rj . ',' . $arr_konsul_dokter_spesialis_rj;;

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

if($tgl_1 == '') $tgl_1 = date('d-m-Y');
if($tgl_2 == '') $tgl_2 = date('d-m-Y');

$cash = '';
if (isset($_POST['cash']))
    $cash = $_POST['cash'];

$rekening = '';
if (isset($_POST['rekening']))
    $rekening = $_POST['rekening'];	

$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);
?>
<table border="1">
	<tr>
        <th colspan="4">Uraian Penerimaan Pembayaran <?php 
			if($jns_bayar == ''){ 
				echo '-';
			}else{
				$sql_jaminan = 'SELECT NAMA_JAMINAN FROM m_jaminan WHERE JAMINAN_ID = "' . $jns_bayar . '"';
				$get_jaminan = mysql_query($sql_jaminan) or die(mysql_error());
				$dat_jaminan = mysql_fetch_assoc($get_jaminan);
				echo $dat_jaminan['NAMA_JAMINAN'];
			}	
		?>
		Tanggal <?php echo $tgl_1; ?> S/d <?php echo $tgl_2; ?></th>
   </tr>
   <tr>
    <th>No</th>
	<th>Uraian Penerimaan</th>
	<th>Jumlah</th>
    <th>Biaya</th>
  </tr>
<?php 
include('keuangan/keuangan_uraian_penerimaan_qry_rj_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_igd.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ri_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ok_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_rj_kusta.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ri_kusta.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ok_kusta.php');

$qry_pembayaran .= '					
					-- lain-lain
					UNION ALL
					SELECT "PENERIMAAN LAIN-LAIN" AS JENIS_PENERIMAAN,	
					UPPER(mtrg.NAMA_TARIF_GROUP) AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					pnm.PIC AS URAIAN,	
					SUM(pnmt.KUANTITI) AS JUMLAH,
					SUM(pnmt.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simkeu.r_penerimaan_lainlain pnm
					INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnmt 
					ON (pnm.PENERIMAAN_LAINLAIN_ID = pnmt.PENERIMAAN_LAINLAIN_ID)
					INNER JOIN db_simrs.m_tarif mtr 
					ON (pnmt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE 1
					' . (($jns_bayar != '1') ? 'AND pnm.PENERIMAAN_LAINLAIN_ID = "xyz"' : 'AND DATE(pnm.TANGGAL) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnm.TANGGAL) <= ' . $tgl_filter_2) . '
					' . (($cash != '') ? ' AND pnm.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND pnm.KODE_REKENING = "' . $rekening . '" ' : '') . '
					AND pnm.NO_PEMBAYARAN IS NOT NULL
					GROUP BY mtrg.NAMA_TARIF_GROUP,pnm.PIC';	
							
$no = 1;					
$jenis_penerimaan = '';
$jenis_uraian = '';
$nama_unit = '';
$total_per_penerimaan = 0;
$total_per_uraian = 0;
$total = 0;
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){
	if($dat_pembayaran['JNS_URAIAN'] != $jenis_uraian
		and $jenis_uraian != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong>TOTAL <?php echo $jenis_uraian; ?></strong></td>
				<td colspan="2" align="right"><?php echo currFormat($total_per_uraian); ?></td>
			</tr>
	<?php $total_per_uraian = 0;
	}
	
	if($dat_pembayaran['JENIS_PENERIMAAN'] != $jenis_penerimaan
		and $jenis_penerimaan != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong>TOTAL <?php echo $jenis_penerimaan; ?></strong></td>
				<td colspan="2" align="right"><?php echo currFormat($total_per_penerimaan); ?></td>
			</tr>
	<?php $total_per_penerimaan = 0; 
	}		
	
	if($dat_pembayaran['JENIS_PENERIMAAN'] != $jenis_penerimaan){
		$jenis_penerimaan = $dat_pembayaran['JENIS_PENERIMAAN'];
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td colspan="3"><strong><?php echo $jenis_penerimaan; ?></strong></td>
			</tr>
		<?php	
	}

			
	
	if($dat_pembayaran['JNS_URAIAN'] != $jenis_uraian){
		$jenis_uraian = $dat_pembayaran['JNS_URAIAN'];
		$no = 1;
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td colspan="3"><strong><?php echo $jenis_uraian; ?></strong></td>
			</tr>
		<?php	
	}	
	
	if($dat_pembayaran['NAMA_UNIT'] != $nama_unit){
		$nama_unit = $dat_pembayaran['NAMA_UNIT'];
		if($nama_unit != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong><?php echo strtoupper($nama_unit); ?></strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<?php }	
	}
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['URAIAN']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JUMLAH']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['BIAYA']); ?></td>
  </tr>
 <?php 
	if($dat_pembayaran['URAIAN'] != 'RETURN OBAT'){
		$total_per_penerimaan = $total_per_penerimaan + $dat_pembayaran['BIAYA'];
		$total_per_uraian = $total_per_uraian + $dat_pembayaran['BIAYA'];
		$total = $total + $dat_pembayaran['BIAYA'];
	}else{
		$total_per_penerimaan = $total_per_penerimaan - $dat_pembayaran['BIAYA'];
		$total_per_uraian = $total_per_uraian - $dat_pembayaran['BIAYA'];
		$total = $total - $dat_pembayaran['BIAYA'];
	}
	
	$no++;  
} ?>
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL <?php echo $jenis_uraian; ?></strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total_per_uraian); ?></td>
	</tr> 
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL <?php echo $jenis_penerimaan; ?></strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total_per_penerimaan); ?></td>
	</tr>
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL PENERIMAAN</strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total); ?></td>
	</tr>
</table>