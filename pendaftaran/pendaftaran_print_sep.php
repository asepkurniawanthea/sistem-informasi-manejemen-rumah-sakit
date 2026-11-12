<?php
include('../config/config.php');
$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

$sql_sep = 'SELECT t_irja.IRJA_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.NO_SEP,t_irja.NO_PESERTA,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			m_pasien.JNS_KELAMIN,m_unit.NAMA_UNIT,t_irja.JKN_DIAGNOSA,t_irja.JKN_CATATAN,t_irja.JKN_NAMA_PKK,t_irja.JKN_PBI_NONPBI,
			t_irja.JKN_KELAS_RAWAT
			FROM t_irja
			INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
$get_sep = mysql_query($sql_sep) or die(mysql_error());			
$dat_sep = mysql_fetch_assoc($get_sep);

$no_sep = $dat_sep['NO_SEP']; 
$tgl_sep = $dat_sep['TANGGAL_DAFTAR'];
$no_kartu = $dat_sep['NO_PESERTA'];
$nama_peserta = $dat_sep['NAMA_PASIEN'];
$tgl_lahir = $dat_sep['TGL_LAHIR'];
$jns_kelamin_array = array ('L' => 'Laki-laki', 'P' => 'Perempuan');
$jns_kelamin = $jns_kelamin_array[$dat_sep['JNS_KELAMIN']]; 
$poli_tujuan = $dat_sep['NAMA_UNIT'];
$asal_faskes = $dat_sep['JKN_NAMA_PKK'];
$diagnosa = $dat_sep['JKN_DIAGNOSA'];
$catatan = $dat_sep['JKN_CATATAN'];

$peserta = $dat_sep['JKN_PBI_NONPBI'];
$kelas_rawat = $dat_sep['JKN_KELAS_RAWAT'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Print</title>
        <link rel="stylesheet" media="screen" href="../style/sep.css" type="text/css">
            <link rel="stylesheet" media="print" href="../style/sep_print.css" type="text/css">
                <style type="text/css">
<!--
.style1 {font-size: 11px}
.style3 {font-size: 11px}
.style2 {font-size: 7px}
-->
                </style>
</head>
                <body>
                    <div id="TopLayer" ><a href="Javascript:self.print()">Print</a></div>
                    <div id="TextLayer" align="left">
                        <table border="0" cellspacing="2" cellpadding="0">
                            <tr>
                                <td colspan="3" rowspan="2" align="center" scope="col">
								<table width="100%">
									<tr>
										<td rowspan="2"><img src="../image/bpjs.png" witdh="50" height="30"></td>
									    <td align="center"><span class="style3"><strong>SURAT ELEGIBILITAS PESERTA</strong></span></td>
									</tr>
									<tr>
									  <td align="center"><strong><span class="style3">RSK. Dr. SITANALA TANGERANG</strong></span></td>
								  </tr>
								</table>
								</td>
                                <td colspan="2" scope="col" >&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="100" scope="row">&nbsp;</td>
                                <td colspan="2" >&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td scope="row"><span class="style1">No. SEP </span></td>
                              <td colspan="2" ><span class="style1">:&nbsp;<?php echo $no_sep; ?></span></td>
                              <td colspan="2"><span class="style1"></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Tgl. SEP </span></td>
                                <td ><span class="style1">:&nbsp;<?php echo $tgl_sep; ?></span></td>
                                <td width="100"><span class="style1"></span></td>
                                <td colspan="2"><span class="style1"></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">No.  Kartu </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $no_kartu; ?></span></td>
                                <td><span class="style1">Peserta</span></td>
                                <td colspan="2" rowspan="2" valign="top"><span class="style1">:&nbsp;<?php echo $peserta; ?></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Nama Peserta </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $nama_peserta; ?></span></td>
                                <td><span class="style1"></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Tgl. Lahir</span></td>
                                <td><span class="style1">:&nbsp;<?php echo $tgl_lahir; ?></span></td>
                                <td><span class="style1">COB</span></td>
                                <td colspan="2"><span class="style1"></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Jns. Kelamin </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $jns_kelamin; ?></span></td>
                                <td><span class="style1">Jns. Rawat </span></td>
                                <td colspan="2"><span class="style1">:&nbsp;Rawat Jalan</span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Poli Tujuan </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $poli_tujuan; ?></span></td>
                                <td><span class="style1">Kls. Rawat </span></td>
                                <td colspan="2"><span class="style1">:&nbsp;<?php echo $kelas_rawat; ?></span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Asal Faskes Tk. I </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $asal_faskes; ?></span></td>
                                <td><span class="style1"></span></td>
                                <td colspan="2"><span class="style1"></span></td>
                            </tr>
                            
                            <tr>
                                <td scope="row"><span class="style1">Diagnosa Awal </span></td>
                                <td><span class="style1">:&nbsp;<?php echo $diagnosa; ?></span></td>
                                <td><span class="style1"></span></td>
                                <td width="120" ><span class="style1">Pasien/</span></td>
                                <td width="129" ><span class="style1">Petugas</span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1"></span></td>
                                <td><span class="style1"></span></td>
                                <td><span class="style1"></span></td>
                                <td><span class="style1">Keluarga Pasien </span></td>
                                <td><span class="style1">BPJS Kesehatan </span></td>
                            </tr>
                            <tr>
                                <td scope="row"><span class="style1">Catatan</span></td>
                                <td><span class="style1">:&nbsp;<?php echo $catatan; ?></span></td>
                                <td><span class="style1"></span></td>
                                <td><span class="style1"></span></td>
                                <td><span class="style1"></span></td>
                            </tr>
                            <tr>
                                <td scope="row">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3" scope="row"><span class="style2"><i>*Saya menyetujui BPJS Kesehatan menggunakan Informasi Medis Pasien jika diperlukan,</i></span></td>
                                <td>-------------------</td>
                                <td>-------------------</td>
                            </tr>
                            <tr>
                              <td colspan="3" scope="row"><span class="style2"><i>*SEP bukan sebagai bukti penjaminan peserta</i></span></td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>
