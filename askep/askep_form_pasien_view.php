<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,
				m_ruang.KELAS_RAWAT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,m_pegawai2.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT,
				m_ruang.NAMA_RUANG
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
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

$irna_id = $dat_pasien['IRNA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
$ruang_id = $dat_pasien['RUANG_ID'];
$kelas_rawat = $dat_pasien['KELAS_RAWAT'];
$tmp_tidur = $dat_pasien['NO_TMP_TIDUR'];
$nama_ruang = $dat_pasien['NAMA_RUANG'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kasus_polisi = $dat_pasien['KASUS_POLISI'];
$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$nama_dokter_rawat = $dat_pasien['NAMA_DOKTER_RAWAT'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php include('pasien/pasien_view_short.php'); ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat/ Kelas</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_ruang . '/ ' . $kelas_rawat; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo setIfNull($tmp_tidur); ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Tempat Tidur</div><br><br>
</div>

	<div  style=" height:75px; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnsf') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=pnsf&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Penilaian Status Fungsional</a>
		</div>		
	<? } else { ?>
			<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=pnsf&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Penilaian Status Fungsional</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=pnsf&idx=<?php echo $_GET['idx']; ?>">Penilaian Status Fungsional</a>
		</div>
		<? } ?>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pjna') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=pjna&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Rawat Inap Umum</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=pjna&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Rawat Inap Umum</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ctkp') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ctkp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Keperawatan</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ctkp&idx=<?php echo $_GET['idx']; ?>" >Catatan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ctpo') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ctpo&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Pemberian Obat</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ctpo&idx=<?php echo $_GET['idx']; ?>" >Catatan Pemberian Obat</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'peso') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=peso&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pelaporan Efek Samping Obat</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=peso&idx=<?php echo $_GET['idx']; ?>" >Pelaporan Efek Samping Obat</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tnsn') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=tnsn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tensi-Nafas-Suhu-Nadi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=tnsn&idx=<?php echo $_GET['idx']; ?>" >Tensi-Nafas-Suhu-Nadi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ckmb') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ckmb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Intake/Output</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=ckmb&idx=<?php echo $_GET['idx']; ?>" >Intake/Output</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'sppi') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=sppi&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surveilans Pencegahan & Pengendalian Infeksi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=sppi&idx=<?php echo $_GET['idx']; ?>" >Surveilans Pencegahan & Pengendalian Infeksi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'mfsc') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=mfsc&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Skala Jatuh Morse</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=mfsc&idx=<?php echo $_GET['idx']; ?>" >Skala Jatuh Morse</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpsc') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=cpsc&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Comfort Scale</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=cpsc&idx=<?php echo $_GET['idx']; ?>" >Comfort Scale</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'snfl') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=snfl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Skala Nyeri Flacc</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=snfl&idx=<?php echo $_GET['idx']; ?>" >Skala Nyeri Flacc</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'nrwb') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=nrwb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Numeric Rating Scale & Skala Nyeri Wong Baker</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=nrwb&idx=<?php echo $_GET['idx']; ?>" >Numeric Rating Scale & Skala Nyeri Wong Baker</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'sask') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=sask&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Askep</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('askepranapformpasienview'); ?>&smn=sask&idx=<?php echo $_GET['idx']; ?>" >Status Askep</a>
		</div>
	<? } ?>

</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('askep/askep_view_status_fungsional.php');
}else{
	if($_GET['smn'] == 'pnsf') include('askep/askep_view_status_fungsional.php');
	if($_GET['smn'] == 'pjna') include('askep/askep_view_pengkajian_awal.php');
	if($_GET['smn'] == 'ctkp') include('askep/askep_view_catatan_keperawatan.php');
	if($_GET['smn'] == 'ctpo') include('askep/askep_view_catatan_pemberian_obat.php');
	if($_GET['smn'] == 'peso') include('askep/askep_view_pelaporan_eso.php');
	if($_GET['smn'] == 'tnsn') include('askep/askep_view_pemeriksaan_fisik.php');
	if($_GET['smn'] == 'sppi') include('askep/askep_view_pengendalian_infeksi.php');
	if($_GET['smn'] == 'mfsc') include('askep/askep_view_morsefall_scale.php');
	if($_GET['smn'] == 'cpsc') include('askep/askep_view_comport_scale.php');
	if($_GET['smn'] == 'snfl') include('askep/askep_view_skala_nyeri_flacc.php');
	if($_GET['smn'] == 'nrwb') include('askep/askep_view_numeric_rating_scale.php');
	if($_GET['smn'] == 'ckmb') include('askep/askep_view_catatan_keluar_masuk.php');
	if($_GET['smn'] == 'sask') include('askep/askep_view_status.php');
}
?>
</div>
</div>
<?php } ?>
