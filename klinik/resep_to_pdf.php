<?php if(isset($_GET['idx'])){

function setGarisIfNull($str){
	$ret = $str;
	if(trim($str) == '' or $str == '00/00/0000') $ret = '__________';
	
	return $ret;	
}

$idx = $_GET['idx'];

include('../config/config.php');
include('../shared/connect_db.php');
include('../shared/function.php');
include('../shared/enum_function.php');
	
$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
		m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
		m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
		FROM t_irja
		INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
		INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
		LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$unit_id = $dat_pasien['NAMA_UNIT'];
$dokter = $dat_pasien['NAMA_PEGAWAI'];		

$qry_resep = 'SELECT DISTINCT t_irja_resep.IRJA_ID,t_irja_resep.NO_RESEP,t_irja_resep.ST_RESEP,m_pegawai.NAMA_PEGAWAI,
				DATE_FORMAT(t_irja_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP
				FROM t_irja_resep
				LEFT JOIN m_pegawai ON (t_irja_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE IRJA_ID = "' . $idx . '" 
				AND t_irja_resep.RESEP IS NOT NULL
				AND t_irja_resep.NO_RESEP IS NOT NULL
				ORDER BY t_irja_resep.NO_RESEP';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
$edoc_content = '<style>table.productsTable td {
    border-width: 1px;
    padding: 5px;
    border-style: inset;
	border-color: gray; }
	</style>
	<br/>
	<table width="100%" class="productsTable" cellpadding="0" cellspacing="0" 
		autosize="1" style="border: 1px solid black;padding-left:1px;border-collapse: collapse;">
	<tr>
		<th width="30">No</th>
		<th width="100">Tanggal</th>
		<th width="70">Nomor</th>
		<th width="120">Pengirim</th>
		<th colspan="2">Nama Obat</th>
		<th>Jumlah</th>
		<th>Satuan</th>
		<th>Aturan Pakai</th>
		<th>Waktu Pakai</th>
		<th>Racikan</th>
		<th>Generik</th>
		<th>Psiko<br/>tropika</th>
		<th>Form RS</th>
		<th>Form NS</th>
	</tr>';
	
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();
$arr_nama_racikan = getResepNamaRacikan();

$i = 1;
while ($dat_resep = mysql_fetch_array($get_resep)) { 
    $edoc_content .= '<tr>
        <td align="center">' . $i .' </td>
		<td>' . $dat_resep['TGL_RESEP'] . '</td>
		<td>' . $dat_resep['NO_RESEP'] .'</td>
		<td>' . $dat_resep['NAMA_PEGAWAI'] . '</td>
        <td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		</tr>';
			
		$qry_det_resep = 'SELECT t_irja_resep.IRJA_RESEP_ID,t_irja_resep.RESEP,t_irja_resep.ST_RESEP,t_irja_resep.RACIKAN,
			t_irja_resep.GENERIK,t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
			t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
			t_irja_resep.JUMLAH_KELUAR,t_irja_resep.HARGA,t_irja_resep.SATUAN_DOSIS,
			t_irja_resep.WAKTU_PAKAI
			FROM t_irja_resep
			LEFT JOIN m_pegawai ON (t_irja_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRJA_ID = "' . $idx . '" 
			AND t_irja_resep.NO_RESEP = "' . $dat_resep['NO_RESEP'] . '"
			ORDER BY t_irja_resep.NO_RESEP';
		$get_det_resep = mysql_query($qry_det_resep) or die(mysql_error());
		$y = 1;
		while($dat_det_resep = mysql_fetch_array($get_det_resep)){
			$resep = $dat_det_resep['RESEP'];
			if($dat_det_resep['RACIKAN'] == '1'){
				$resep = '';
				$arr_nmr = explode('|',$dat_det_resep['RESEP']);
					foreach($arr_nmr as $row){
						if(is_numeric($row)){
							$resep .= $arr_nama_racikan[$row] . ' ';
						}else{
							$resep .= $row . ' ';
						}
					}
				$resep = substr($resep,0,strlen($resep)-1); 
			}

			$edoc_content .= '<tr>
				<td colspan="4">&nbsp;</td>
				<td width="30" align="center">' . $y . '</td>
				<td>' . $resep . '</td>
				<td align="right">' . $dat_det_resep['JUMLAH'] . '</td>
				<td>' . $dat_det_resep['SATUAN'] . '</td>
				<td>';
			
			$arr_atp = explode('|',$dat_det_resep['DOSIS']);
			$atp = '';
			foreach($arr_atp as $row){
				if(is_numeric($row)){
					$atp .= $arr_aturan_pakai[$row] . ',';
				}else{
					$atp .= $row . ',';
				}
			}
			$edoc_content .= substr($atp,0,strlen($atp)-1);
						
			$arr_str = explode('|',$dat_det_resep['SATUAN_DOSIS']);
			$str = '';
			foreach($arr_str as $row){
				if(is_numeric($row)){
					$str .= $arr_satuan_resep[$row] . ',';
				}else{
					$str .= $row . ',';
				}
			}
			$edoc_content .= ' ' . substr($str,0,strlen($str)-1);
			$edoc_content .= '</td><td>';
			$arr_wkp = explode('|',$dat_det_resep['WAKTU_PAKAI']);
				$wkp = '';
				foreach($arr_wkp as $row){
					if(is_numeric($row)){
						$wkp .= $arr_waktu_pakai[$row] . ',';
				}else{
						$wkp .= $row . ',';
					}
				}
				$wkp = substr($wkp,0,strlen($wkp)-1);
			$edoc_content .= str_replace('Bila perlu,','Bila perlu ',$wkp); 
			$edoc_content .= '</td>
					<td align="center">' . (($dat_det_resep['RACIKAN'] == '1') ? '&radic;' : '') . '</td>
					<td align="center">' . (($dat_det_resep['GENERIK'] == '1') ? '&radic;' : '') . '</td>
					<td align="center">' . (($dat_det_resep['PSIKOTROPIKA'] == '1') ? '&radic;' : '') . '</td>
					<td align="center">' . (($dat_det_resep['FORMULARIUM'] == '1') ? '&radic;' : '') . '</td>
					<td align="center">' . (($dat_det_resep['FORMULARIUM_NASIONAL'] == '1') ? '&radic;' : '') . '</td>
				</tr>';
				
			if($dat_det_resep['RACIKAN'] == '1'){
				$sql_racikan = 'SELECT t_irja_resep_racikan.IRJA_RESEP_RACIKAN_ID,t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,
							t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.FORMULARIUM,t_irja_resep_racikan.FORMULARIUM_NASIONAL,
							t_irja_resep_racikan.JUMLAH_KELUAR,t_irja_resep_racikan.HARGA
							FROM t_irja_resep_racikan 
							WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_det_resep['IRJA_RESEP_ID'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				while($dat_racikan = mysql_fetch_array($get_racikan)){
					$edoc_content .= '<tr>
					<td colspan="5">&nbsp;</td>
					<td>' . $dat_racikan['RESEP'] . '</td>
					<td align="right">' . $dat_racikan['JUMLAH'] . '</td>
					<td>' . $dat_racikan['SATUAN'] . '</td>
					<td colspan="5" align="center">&nbsp;</td>
					<td align="center">' . (($dat_racikan['FORMULARIUM'] == '1') ? '&radic;' : '') . '</td>
					<td align="center">' . (($dat_racikan['FORMULARIUM_NASIONAL'] == '1') ? '&radic;' : ''). '</td>
					</tr>';
				}	
			}
			$y++; 
		}
		$i++;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>RESEP</title>
    <link rel="stylesheet" media="print" href="../style/radiologi_diagnosa_pdf.css" type="text/css">
</head>
    <body>
       <div id="TextLayer" align="right">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <!-- header logo/sitanala -->
              <table width="100%" border="0">
				<tr>
					<td width="15%" rowspan="6"><div align="center"><img src="../image/logo_kemenkes.png" width="110" height="110" /></div></td>
                    <td >&nbsp;</td>
                    <td width="17%" rowspan="6" ><div align="center"><img src="../image/logo_sitanala_new.png" width="120" height="110" /></div></td>
                </tr>
                <tr>
                    <td width="70%"><div align="center"><span class="style7">RSUP dr. SITANALA TANGERANG</span></div></td>
                </tr>
                <tr>
					<td><div align="center">Jln. dr. Sitanala No. 99 Neglasari Tangerang 15001 PO BOX 513</div></td>
                </tr>
                <tr>
                    <td><div align="center">Telp. (021) 55 230 59 Fax. (021) 55 23 111</div></td>
                </tr>
                <tr>
					<td><div align="center"></div></td>
                </tr>
                <tr>
					<td>&nbsp;</td>
                </tr>
               </table>
               <!-- end header logo/sitanala -->
               </td>
            </tr>
            <tr>
				<td>
                <!-- detail pasien -->
                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
					<td colspan="5" ><div align="center"><span class="style5"><h3>RESEP</h3></span></div></td>
                </tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="1" style="border: 1px solid black;padding-left:5px;">
				<tr>
					<td>Nomor RM</td>
					<td>: <?php echo formatNomr($nomr); ?></td>
					<td>&nbsp;</td>
					<td>Nama Pasien</td>
					<td>: <?php echo $nama_pasien; ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td>: <?php echo $tgl_lahir; ?></td>
					<td>&nbsp;</td>
					<td>Jenis Kelamin</td>
					<td>: <?php echo jenisKelamin($jns_kelamin); ?></td>
				</tr>
				<tr>
					<td>Ruang/ Kelas</td>
					<td>: <?php echo $unit_id; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				</table>
				<!-- end detail pasien -->
				</td>
                </tr>
				<tr>
				<td style="vertical-align:top;">
					<?php echo $edoc_content; ?>	
                </td>
                </tr>
        </table>
        </div>
    </body>
</html>
<?php } ?>