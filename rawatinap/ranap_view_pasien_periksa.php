<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,
				m_ruang.KELAS_RAWAT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,m_pegawai2.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT,
				m_ruang.NAMA_RUANG,t_irna.KELAS_JAMINAN,t_irna.DEWASA_ANAK_BAYI,t_irna.BANGSA,
				m_pegawai3.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT_2,m_pegawai4.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT_3
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_irna.PEGAWAI_RAWAT_ID_2 = m_pegawai3.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai4 ON (t_irna.PEGAWAI_RAWAT_ID_3 = m_pegawai4.PEGAWAI_ID)
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
if($tmp_tidur == '') $tmp_tidur = '-';
$nama_ruang = $dat_pasien['NAMA_RUANG'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kasus_polisi = $dat_pasien['KASUS_POLISI'];
$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$nama_dokter_rawat = $dat_pasien['NAMA_DOKTER_RAWAT'];
$nama_dokter_rawat_2 = $dat_pasien['NAMA_DOKTER_RAWAT_2'];
$nama_dokter_rawat_3 = $dat_pasien['NAMA_DOKTER_RAWAT_3'];

$kelas_jaminan = $dat_pasien['KELAS_JAMINAN'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;
$usia = $dat_pasien['DEWASA_ANAK_BAYI'];
$bangsa = $dat_pasien['BANGSA'];
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php include('pasien/pasien_view_short.php'); ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat/ Kelas</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_ruang . '/ ' . $kelas_rawat; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tmp_tidur; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Tempat Tidur</div><br><br>
</div>

	<div  style=" height:120px; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'bdta') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>		
	<? } else { ?>
			<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>">Identitas</a>
		</div>
		<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Riwayat Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rmsk') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Masuk</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Masuk</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'kjam') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'anms') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan & Terapi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan & Terapi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Diagnosa</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" >Diagnosa</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'alrg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Alergi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" >Alergi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP (Farmasi)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP (Farmasi)</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'kpro') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Keperawatan Pra Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" >Catatan Keperawatan Pra Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'prkb') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpob') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekonsiliasi Obat</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" >Rekonsiliasi Obat</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pulang</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Keluar</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" >Riwayat Keluar</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'kmtn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Sebab kematian</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" >Sebab Kematian</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pndh') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pindah Ruang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" >Pindah Ruang</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<div id="mode-maju5">
		<a href="#" style="color:#FF0000;" onclick="view_askep();">Asuhan Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="#" onclick="view_askep();" >Asuhan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmby') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rincian Pembayaran</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapviewpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" >Rincian Pembayaran</a>
		</div>
	<? } ?>
	
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('rawatinap/ranap_form_biodata.php');
}else{
	if($_GET['smn'] == 'bdta') include('rawatinap/ranap_view_biodata.php');
	if($_GET['smn'] == 'rmsk') include('rawatinap/ranap_view_riwayat_masuk.php');
	if($_GET['smn'] == 'prkb') include('rawatinap/ranap_view_perkembangan.php');
	if($_GET['smn'] == 'pfsk') include('rawatinap/ranap_view_pemeriksaan_fisik.php');
	if($_GET['smn'] == 'tndk') include('rawatinap/ranap_view_tindakan.php');	
	if($_GET['smn'] == 'lbrm') include('rawatinap/ranap_view_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('rawatinap/ranap_view_radiologi.php');
	if($_GET['smn'] == 'pnjg') include('rawatinap/ranap_view_penunjang.php');
	if($_GET['smn'] == 'resp') include('rawatinap/ranap_view_resep.php');
	if($_GET['smn'] == 'frms') include('rawatinap/ranap_view_farmasi.php');
	if($_GET['smn'] == 'cpob') include('rawatinap/ranap_view_pemberian_obat.php');
	if($_GET['smn'] == 'plng') include('rawatinap/ranap_view_pulang.php');
	if($_GET['smn'] == 'kmtn') include('rawatinap/ranap_view_sebab_kematian.php');
	if($_GET['smn'] == 'ckmb') include('rawatinap/ranap_view_catatan_keluar_masuk.php');
	if($_GET['smn'] == 'pndh') include('rawatinap/ranap_view_pindah_kamar.php');
	if($_GET['smn'] == 'pekg') include('rawatinap/ranap_view_penunjang_ekg.php');
	if($_GET['smn'] == 'alrg') include('rawatinap/ranap_view_alergi.php');
	if($_GET['smn'] == 'anms') include('rawatinap/ranap_view_anamnesa.php');
	if($_GET['smn'] == 'pmby') include('rawatinap/ranap_view_pembayaran.php');
	if($_GET['smn'] == 'oprs') include('rawatinap/ranap_view_operasi.php');
	if($_GET['smn'] == 'kpro') include('operasi/operasi_view_catatan_keperawatan_praoperasi.php');
	if($_GET['smn'] == 'rwyt') include('rawatinap/ranap_form_riwayat_pasien.php');
	if($_GET['smn'] == 'phmd') include('rawatinap/ranap_view_hemodialisa.php');
	if($_GET['smn'] == 'kjam') include('rawatinap/ranap_view_pengkajian_awal.php');
	if($_GET['smn'] == 'dgns') include('rawatinap/ranap_view_diagnosa.php');
	if($_GET['smn'] == 'rcpl') include('rawatinap/ranap_view_rencana_pulang.php');
	if($_GET['smn'] == 'petp') include('rawatinap/ranap_view_edukasi_pasien.php');
}
?>
</div>
</div>
<script language="javascript" type="text/javascript">
function view_riwayat(){
	window.open("index.php?link=<?php echo md5('rmriwayatpasien'); ?>&nomr=<?php echo $nomr; ?>","Riwayat Pasien");
}

function view_askep(){
	window.open("index.php?link=7c0543a384f13f8d8baeb8ae576b2883&idx=<?php echo $_GET['idx']; ?>","Asuhan Keperawatan");
}
</script>
<?php } ?>
