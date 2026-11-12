<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_operasi.OPERASI_ID,t_operasi.NOMR,t_operasi.PEGAWAI_PELAKSANA_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.JENIS_BAYAR_ID,t_operasi.KELAS_RAWAT,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,
				m_ruang.NAMA_RUANG,t_irna.KELAS_JAMINAN,t_operasi.RAWAT_ID
				FROM t_operasi
				INNER JOIN t_irna ON (t_irna.IRNA_ID = t_operasi.RAWAT_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$operasi_id = $dat_pasien['OPERASI_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_PELAKSANA_ID'];
$tgl_operasi = $dat_pasien['TANGGAL_OPERASI'];
$jam_operasi = $dat_pasien['JAM_OPERASI'];
$ruang_id = $dat_pasien['RUANG_ID'];
$kelas_rawat = $dat_pasien['KELAS_RAWAT'];
$nama_ruang = $dat_pasien['NAMA_RUANG'];

$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$kelas_jaminan = $dat_pasien['KELAS_JAMINAN'];
$umur = getUmurDaftar($tgl_lahir,$tgl_operasi) . ' tt. ' . $tgl_operasi;

$rawat_id = $dat_pasien['RAWAT_ID'];
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php include('pasien/pasien_view_short.php'); ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat/ Kelas</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_ruang . '/ ' . $kelas_rawat; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pelaksana Operasi</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_dokter; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_operasi . ' ' . $jam_operasi; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Operasi</div><br><br>
</div>

<div  style="height:75px; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>">Identitas</a>
		</div>
		<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Riwayat Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Riwayat Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pstj') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=pstj&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Persetujuan Dokter</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=pstj&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Persetujuan Dokter</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'sfty') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=sfty&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Procedure Safety (Time Out)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=sfty&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Procedure Safety (Time Out)</a>
		</div>
	<? } ?>	
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'anst') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=anst&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Perencanaan Anastesi & Sedasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=anst&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Perencanaan Anastesi & Sedasi</a>
		</div>
	<? } ?>	
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'hmpt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=hmpt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Skala Risiko Jatuh (Humpty Dumpty)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=hmpt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Skala Risiko Jatuh (Humpty Dumpty)</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ctpr') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=ctpr&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Catatan Keperawatan Pra-Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=ctpr&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Catatan Keperawatan Pra-Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'skjt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=skjt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Skala Jatuh (OMSSS)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=skjt&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Skala Jatuh (OMSSS)</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'mrfl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=mrfl&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Morse Fall Scale</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=mrfl&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Morse Fall Scale</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Tindakan Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Tindakan Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lpbd') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=lpbd&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Laporan Pembedahan</a>-->
		</div>
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=lpbd&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Laporan Pembedahan</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'stpr') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=stpr&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" style="color:#FF0000; ">Status Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&smn=stpr&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>" >Status Operasi</a>
		</div>
	<? } ?>

</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('operasi/operasi_form_biodata.php');
}else{
	if($_GET['smn'] == 'idnt') include('operasi/operasi_form_biodata.php');
	if($_GET['smn'] == 'pstj') include('operasi/operasi_form_view_persetujuan_dokter.php');
	if($_GET['smn'] == 'sfty') include('operasi/operasi_form_view_prosedure_safety.php');
	if($_GET['smn'] == 'anst') include('operasi/operasi_form_view_perencanaan_anastesi_sedasi.php');
	if($_GET['smn'] == 'hmpt') include('operasi/operasi_form_view_humpty_dumpty.php');
	if($_GET['smn'] == 'ctpr') include('operasi/operasi_form_view_catatan_keperawatan_praoperasi.php');
	if($_GET['smn'] == 'skjt') include('operasi/operasi_form_view_skala_jatuh_ontario.php');
	if($_GET['smn'] == 'mrfl') include('operasi/operasi_form_view_morse_fall_scale.php');
	if($_GET['smn'] == 'tndk') include('operasi/operasi_form_view_tindakan.php');
	if($_GET['smn'] == 'lpbd') include('operasi/operasi_form_view_laporan_pembedahan.php');
	if($_GET['smn'] == 'stpr') include('operasi/operasi_form_view_status.php');
	if($_GET['smn'] == 'lbrm') include('operasi/operasi_form_view_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('operasi/operasi_form_view_radiologi.php');
	if($_GET['smn'] == 'rwyt') include('operasi/operasi_form_riwayat_pasien.php');
}
?>
</div>
</div>
<?php } ?>