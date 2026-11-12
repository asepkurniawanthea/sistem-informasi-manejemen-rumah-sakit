<?php
if(isset($_GET['idx'])){
	$idx	= $_GET['idx'];
	
	mysql_query('UPDATE t_irja SET PRINT_TRACER = "1" WHERE IRJA_ID = "' . $idx . '"') or die(mysql_error());
	
	$sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.TANGGAL_DAFTAR,t_irja.ST_BARU,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT,
			m_jaminan.NAMA_JAMINAN,t_irja.USER_RM,t_irja.USER_PENDAFTARAN
			FROM m_pasien
			INNER JOIN t_irja ON (m_pasien.NOMR = t_irja.NOMR)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
			WHERE t_irja.IRJA_ID = "' . $idx . '" AND DATE_FORMAT(TANGGAL_DAFTAR,"%d/%m/%Y") = DATE_FORMAT(NOW(),"%d/%m/%Y")';
	$res	= mysql_query($sql) or die(mysql_error());
	$a		= mysql_num_rows($res);
	$data	= mysql_fetch_array($res);

		$tpb = 'LAMA';
		if($data['ST_BARU'] == '1'){
			$tpb = 'BARU';
		}
		$petugas_array = explode('|', $data['USER_RM']);
		$petugas='';
		if (count($petugas_array)>1) $petugas = $petugas_array[1];
		?>
        <html xmlns="http://www.w3.org/1999/xhtml">
		<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Tracer</title>
        <link rel="stylesheet" media="screen" href="style/rm.css" type="text/css">
        <link rel="stylesheet" media="print" href="style/rm_print.css" type="text/css">
		</head>
        <body>
        <div id="TopLayer"><a href="Javascript:self.print()">Print</a></div>
        <div id="TextLayer">
		<table width="396px">
        <tr><th colspan="2"> TRACER </th></tr>
        <tr><td>STATUS PASIEN</td><td>:&nbsp;<?php echo $tpb; ?></td></tr>
        <tr><td>NAMA</td><td>:&nbsp;<?php echo strtoupper($data['NAMA_PASIEN']); ?></td></tr>
        <tr><td>NOMOR RM</td><td>:&nbsp;<?php echo formatNomr($data['NOMR']);?></td></tr>
        <tr><td>TUJUAN</td><td>:&nbsp;<?php echo strtoupper($data['NAMA_UNIT']); ?></td></tr>
        <tr><td>TANGGAL</td><td>:&nbsp;<?php echo date('d-m-Y'); ?></td></tr>
        <tr><td>CARA BAYAR</td><td>:&nbsp;<?php echo strtoupper($data['NAMA_JAMINAN']); ?></td></tr>
        <tr><td>PETUGAS</td><td>:&nbsp;<?php echo strtoupper($petugas);?></td></tr>
        <tr><td colspan="2" align="center">F-DITJEN BUK YANMED-10-12</td><td></td></tr>
        </table>
		</div>
        </body>
</html>
        <?php
}