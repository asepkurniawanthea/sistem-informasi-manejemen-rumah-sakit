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
	
$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
		m_pasien.JNS_KELAMIN,t_irna.RUANG_ID,m_ruang.NAMA_RUANG,
		m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
		FROM t_irna
		INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
		INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
		LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$unit_id = $dat_pasien['NAMA_RUANG'];
$dokter = $dat_pasien['NAMA_PEGAWAI'];		

$diagnosa = '';
$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA FROM t_irna_diagnosa
		WHERE t_irna_diagnosa.IRNA_ID = "' . $idx . '"
		AND t_irna_diagnosa.DIAGNOSA_ORDER <= 3
		ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
	$diagnosa .= $dat_diagnosa['DIAGNOSA'] . ',';
}
$diagnosa = substr($diagnosa,0,strlen($diagnosa)-1);		
$edoc_content = '<style>
	.aTable tr td {
  border: 1px solid black;padding-left:5px;
}

	.aTable tr th {
  border: 1px solid black;padding-left:5px;
}
</style>
<br/><table class="aTable" border="0" width="100%" cellspacing="0" cellpadding="1">
	<tr>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Kesadaran</th>
		<th rowspan="2">Suhu</th>
		<th rowspan="2">Nadi</th>
		<th rowspan="2">TD</th>
		<th rowspan="2">Respirasi</th>
		<th colspan="2">Pemberian Cairan</th>
		<th colspan="5">Pengeluaran Cairan</th>
		<th rowspan="2">Perawat/ Bidan</th>
	</tr>	
	<tr>
		<th>Per Os</th>
		<th>Parenteral</th>
		<th>Diurese<br/>(BAK)</th>
		<th>Defikasi<br/>(BAB)</th>
		<th>Muntah</th>
		<th>Pendarahan</th>
		<th>Lain-lain</th>
	</tr>';
	
	$qry_kontrol = 'SELECT IRNA_KONTROL_ID,IRNA_ID,KESADARAN,SUHU,NADI,TD,RESPIRASI,PEMBERIAN_CAIRAN_PEROS,
		PEMBERIAN_CAIRAN_PARENTERAL,PENGELUARAN_CAIRAN_BAK,PENGELUARAN_CAIRAN_BAB,PENGELUARAN_CAIRAN_MUNTAH,
		PENGELUARAN_CAIRAN_PENDARAHAN,PENGELUARAN_CAIRAN_LAIN,
		DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y %H:%i:%s") AS TGL_ASSESMENT,
		REGISTER
		FROM t_irna_kontrol_istimewa
		WHERE IRNA_ID = "' . $idx . '"
		ORDER BY TGL_ASSESMENT';
	$get_kontrol = mysql_query($qry_kontrol) or die(mysql_error());
	while($dat_kontrol = mysql_fetch_array($get_kontrol)){ 
		$edoc_content .= '<tr>
			<td align="center">' . $dat_kontrol['TGL_ASSESMENT'] . '</td>
			<td>' . $dat_kontrol['KESADARAN'] . '</td>
			<td>' . $dat_kontrol['SUHU'] . '</td>
			<td>' . $dat_kontrol['NADI'] . '</td>
			<td>' . $dat_kontrol['TD'] . '</td>
			<td>' . $dat_kontrol['RESPIRASI'] . '</td>
			<td>' . $dat_kontrol['PEMBERIAN_CAIRAN_PEROS'] . '</td>
			<td>' . $dat_kontrol['PEMBERIAN_CAIRAN_PARENTERAL'] . '</td>
			<td>' . $dat_kontrol['PENGELUARAN_CAIRAN_BAK'] . '</td>
			<td>' . $dat_kontrol['PENGELUARAN_CAIRAN_BAB'] . '</td>
			<td>' . $dat_kontrol['PENGELUARAN_CAIRAN_MUNTAH'] . '</td>
			<td>' . $dat_kontrol['PENGELUARAN_CAIRAN_PENDARAHAN'] . '</td>
			<td>' . $dat_kontrol['PENGELUARAN_CAIRAN_LAIN'] . '</td>
			<td>' . $dat_kontrol['REGISTER'] . '</td>
		</tr>';
	}	
$edoc_content .= '</table>';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>KONTROL ISTIMEWA</title>
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
					<td colspan="5" ><div align="center"><span class="style5"><h3>FORMULIR KONTROL ISTIMEWA</h3></span></div></td>
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
					<td>Diagnosa Medis</td>
					<td>: <?php echo $diagnosa; ?></td>
				</tr>
				</table>
				<!-- end detail pasien -->
				</td>
                </tr>
				<tr>
				<td width="40px" style="vertical-align:top;">
					<?php echo $edoc_content; ?>	
                </td>
                </tr>
        </table>
        </div>
    </body>
</html>
<?php } ?>