<?php if(isset($_GET['idx'])){
	$idx	= $_GET['idx'];
	
	include('../config/config.php');
	include('../shared/connect_db.php');
	include('../shared/function.php');

	mysql_query('UPDATE t_irja SET PRINT_RRKRJ = "1" WHERE IRJA_ID = "' . $idx . '"') or die(mysql_error());

	$sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.TANGGAL_DAFTAR,m_pasien.NAMA_PASIEN,m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NAMA_IBU,
			m_pasien.NAMA_AYAH,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_agama.NAMA_AGAMA,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,
			m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
			m_asal_pasien.KET_ASAL_PASIEN,t_irja.P_JAWAB_NAMA,m_pasien.NO_TELEPON,m_pasien.PENDIDIKAN_ID
			FROM t_irja
			INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
			LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$rsl = mysql_query($sql);
	$data = mysql_fetch_assoc($rsl);
	$rm = formatNomr($data['NOMR']);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>RRKRJ</title>
        <link rel="stylesheet" media="screen" href="style/rm.css" type="text/css">
            <link rel="stylesheet" media="print" href="style/rm_print.css" type="text/css">
                <style type="text/css">
					div.kotak{
border-style: solid ;
border-width: thin ;}
                </style>
</head>
                <body>
                    <div id="TopLayer"><a href="Javascript:self.print()">Print</a></div>
                    <div id="TextLayer" align="right">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <!-- header logo/sitanala -->
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="15%" rowspan="6"><div align="center"><img src="http://192.168.1.2/nsimrs/image/logo.jpg" width="112" height="131" /></div></td>
                                            <td >&nbsp;</td>
                                            <td width="17%" rowspan="6" ><div align="center"><img src="http://192.168.1.2/nsimrs/image/lOGOsitanala.jpg" width="120" height="131" /></div></td>
                                        </tr>
                                        <tr>
                                            <td width="70%"><div align="center"><span class="style7">RSK Dr. SITANALA TANGERANG</span></div></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><div align="center">Jl. Dr. Sitanala No. 99 Tangerang Kotak Pos 513</div></td>
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
                                    <table width="100%" border="1" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td colspan="2" scope="col"><div align="center"><span class="style5">&nbsp;RINGKASAN RIWAYAT KLINIK RAWAT JALAN</span></div></td>
                                            <td rowspan="2" scope="col" width="20%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td scope="col"><div align="center">NOMOR REKAM MEDIK </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row"><div class="kotak" ><div align="center" class="style9"><strong><?php echo $rm; ?></strong></div></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row"><div align="center">TANGGAL</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row"><div class="kotak" ><div align="center" class="style9"><strong><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></strong></div></div></td>
                                                    </tr>
                                                </table></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" scope="row"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td scope="col" width="65%">&nbsp;NAMA KELUARGA : AYAH/SUAMI/MARGA</td>
                                                        <td scope="col" width="35%"><div align="center">NAMA PASIEN : </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;<strong><?php echo strtoupper($data['NAMA_SUAMI_ISTERI']); ?></strong></td>
                                                        <td><div align="center"><strong><?php echo strtoupper($data['NAMA_PASIEN']); ?></strong></div></td>
                                                    </tr>
                                                </table></td>
                                        </tr>

                                        <tr>
                                            <td width="53%" height="23" scope="row">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td scope="col" width="65%">&nbsp;TEMPAT : <strong><?php echo strtoupper($data['TMP_LAHIR']); ?></strong></td>
                                                        <td scope="col" width="35%">TGL. LAHIR : <strong><?php echo changeDateFormat($data['TGL_LAHIR']); ?></strong></td>
                                                    </tr>
                                                </table>                                            </td>
                                            <td width="30%" colspan="2">&nbsp;AGAMA : <strong><?php echo strtoupper($data['NAMA_AGAMA']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td scope="col" width="65%">&nbsp;NAMA IBU : </td>
                                                        <td scope="col" width="35%">NAMA AYAH :</td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;<strong><?php echo strtoupper($data['NAMA_IBU']); ?></strong></td>
                                                        <td><?php echo strtoupper($data['NAMA_AYAH']); ?></td>
                                                    </tr>
                                                </table>                                            </td>
                                            <td colspan="2" valign="top">&nbsp;PEKERJAAN : <strong><?php echo strtoupper($data['PEKERJAAN']); ?></strong></td>
                                        </tr>
                                        
                                        <tr>
                                            <td rowspan="6" scope="row"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                    <tr>
                                                        <td width="20%" scope="col">&nbsp;ALAMAT</td>
														<td colspan="2" scope="col">: <strong><?php echo strtoupper($data['ALAMAT']);?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;RT/RW</td>
                                                        <td colspan="2">: <strong><?php echo strtoupper($data['ALAMAT_RT'] . '/' . $data['ALAMAT_RW']);?></strong>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;DESA/KELURAHAN </td>
                                                        <td>: <strong><?php echo strtoupper($data['NAMA_KELURAHAN']); ?></strong></td>
                                                        <td width="25%"><div align="right"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;KECAMATAN</td>
                                                        <td>: <strong><?php echo strtoupper($data['NAMA_KECAMATAN']); ?></strong></td>
                                                        <td><div align="right"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">&nbsp;KODYA/KABUPATEN</td>
                                                        <td>: <strong><?php echo strtoupper($data['NAMA_KOTA']); ?></strong></td>
                                                        <td><div align="right">&nbsp;</div></td>
                                                    </tr>
                                                </table></td>
                                            <td colspan="2">&nbsp;JENIS KELAMIN : <strong><?php echo strtoupper(jenisKelamin($data['JNS_KELAMIN'])); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;STATUS PERKAWINAN : <strong><?php echo strtoupper(statusKawin($data['ST_KAWIN'])); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;PENDIDIKAN : <strong><?php echo strtoupper(jenPendidikan($data['PENDIDIKAN_ID'])); ?></strong></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" valign="top">&nbsp;DIKIRIM OLEH :<strong><?php echo strtoupper($data['KET_ASAL_PASIEN']); ?></strong></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" valign="top">&nbsp;PENANGGUNG JAWAB : <strong><?php echo strtoupper($data['P_JAWAB_NAMA']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">&nbsp;TELEPON :<strong><?php echo strtoupper($data['NO_TELEPON']); ?></strong> </td>
                                        </tr>
                              </table>
							   <!-- end detail pasien -->
							  </td>
                            </tr>
							<tr height="150px">
								<td>
									<table border="0" height="100%" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td valign="top"><div style="height:93%; border:1px solid #000; padding:2px; margin-top:2px; text-indent:5px;">Riwayat Operasi</div></td>
											<td>&nbsp;</td>
											<td valign="top"><div style="height:93%; border:1px solid #000; padding:2px; margin-top:2px; text-indent:5px;">Riwayat Alergi Obat</div></td>
											<td>&nbsp;</td>
											<td valign="top"><div style="height:93%; border:1px solid #000; padding:2px; margin-top:2px; text-indent:5px;">Riwayat Rawat Inap</div></td>											
										</tr>
									</table>
								</td>
							</tr>
                            <tr>
                                <td>
                                    <!-- table riwayat -->
                                    <table width="100%" border="1" cellspacing="0">
                                        <tr>
                                            <td width="5%" height="25"><div align="center"><strong>TGL</strong></div></td>
                                            <td width="10%"><div align="center"><strong>KLINIK</strong></div></td>
                                            <td width="25%"><div align="center"><strong>D I A G N O S A</strong></div></td>
                                            <td width="6%"><div align="center"><strong>ICD10</strong></div></td>
                                            <td width="10%"><div align="center"><strong>TINDAKAN DAN TERAPI</strong></div></td>
                                            <td width="8%"><div align="center"><strong>ICD9CM</strong></div></td>
                                            <td width="10%"><div align="center"><strong>KODE DOKTER /TENAGA KES LAIN</strong></div></td>
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>
                                        <tr height="50px">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
											<td>&nbsp;</td>                                            
                                        </tr>                                                                                
                                    </table>
                                    <!-- end table riwayat -->
                                </td>
                            </tr>
                        </table>
                    </div>
                </body>
</html>
<?php 
if(isset($_GET['autoprint'])){
		?>
		<script language="javascript" type="text/javascript">
			self.print();
			window.close();
		</script>
		<?php
}
} ?>