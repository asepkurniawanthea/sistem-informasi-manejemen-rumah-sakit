<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.POD,t_irja.NEW_RM,t_irja.NO_KLINIK,t_irja.ST_COVID19,t_irja.ST_COVID19_KOMORBIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

$no_telepon = $dat_pasien['NO_TELEPON'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$pod = $dat_pasien['POD'];

$status_anamnesis = '1';
$status_diagnosa = '1';
$new_rm = $dat_pasien['NEW_RM'];
$irja_final = $dat_pasien['NO_KLINIK'];

// new rekam medik
if($new_rm == '1'){ ?>	
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style="height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php include('pasien/pasien_view_short.php'); ?>
 	</div>
	<!--<div  style="height:<?php echo $hg; ?>; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">-->
	<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
	<table>
	<tr><td>
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" >Identitas (App Kusta)</a>
		</div>	
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Pasien (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Pasien (App Kusta)</a>
		</div>
	<?php } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ksta') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Form Kusta</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" >Form Kusta</a>
		</div>
	<? } } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" >Identitas</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekam Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Rekam Medik</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamk&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkus') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkus&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perubahan Di Kulit & Urat Saraf</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkus&idx=<?php echo $_GET['idx']; ?>" >Perubahan Di Kulit & Urat Saraf</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pokt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pokt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan Okupasi Terapi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pokt&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan Okupasi Terapi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'psdo') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psdo&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan Saraf & Otot</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psdo&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan Saraf & Otot</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'epck') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=epck&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Evaluasi Pencegahan Kecacatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=epck&idx=<?php echo $_GET['idx']; ?>" >Evaluasi Pencegahan Kecacatan</a>
		</div>
	<? } ?>
	
	<?php } ?>
	<?php if(currentModul() == 'klinik'){ ?>
	<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '5' or $_SESSION['SES_SIMRS_UNIT_ID'] == '65'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamg&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<?php } ?>
	<?php }else if($_SESSION['SES_SIMRS_UNIT_ID'] == '29'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamm&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamm&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<?php } ?>
	<?php }else if($_SESSION['SES_SIMRS_UNIT_ID'] == '44'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamu') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<?php } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis Kusta</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamk&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis Kusta</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkus') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkus&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perubahan Di Kulit & Urat Saraf</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkus&idx=<?php echo $_GET['idx']; ?>" >Perubahan Di Kulit & Urat Saraf</a>
		</div>
	<? } ?>
	
	<?php }else{ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamu') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>
	<?php } ?>
	
	<? } ?>
	
	<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '34'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pokt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pokt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan Okupasi Terapi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pokt&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan Okupasi Terapi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'psdo') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psdo&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan Saraf & Otot</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psdo&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan Saraf & Otot</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'epck') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=epck&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Evaluasi Pencegahan Kecacatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=epck&idx=<?php echo $_GET['idx']; ?>" >Evaluasi Pencegahan Kecacatan</a>
		</div>
	<? } ?>
	
	<?php } ?>
	
	
	<?php } ?> 
	
	<?php if(currentModul() == 'igd'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tria') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tria&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Triase Pasein Gawat Darurat</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tria&idx=<?php echo $_GET['idx']; ?>" >Triase Pasien Gawat Darurat</a>
		</div>
	<?php } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmgd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmgd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Medis Gawat Darurat</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmgd&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Medis Gawat Darurat</a>
		</div>
	<?php } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamu') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
		</div>-->
	<?php } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkgd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkgd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Keperawatan Gawat Darurat</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkgd&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Keperawatan Gawat Darurat</a>
		</div>
	<?php } ?>
	<? } ?>
	
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta'){ ?>
	
	<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '2' or $_SESSION['SES_SIMRS_UNIT_ID'] == '63'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Kebidanan & Kandungan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pamd&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Kebidanan & Kandungan</a>
		</div>
	<? } ?>
	<?php }else if($_SESSION['SES_SIMRS_UNIT_ID'] == '5' or $_SESSION['SES_SIMRS_UNIT_ID'] == '65'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkgm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkgm&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Kesehatan Gigi & Mulut</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkgm&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Kesehatan Gigi & Mulut</a>
		</div>
	<? } ?>
	<?php }else{ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Keperawatan</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien Terintegrasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien Terintegrasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan <?php echo ((currentModul() == 'igd') ? 'IGD' : 'Poliklinik');?></a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan <?php echo ((currentModul() == 'igd') ? 'IGD' : 'Poliklinik');?></a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'igd'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta' or (currentModul() == 'klinik' and $_SESSION['SES_SIMRS_UNIT_ID'] == '44')){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkoh') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkoh&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lokasi Pem. Lab BTA/ KOH</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pkoh&idx=<?php echo $_GET['idx']; ?>" >Lokasi Pem. Lab BTA/ KOH</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmhs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmhs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pem. Lab Histopatologik/ Sitopatologik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmhs&idx=<?php echo $_GET['idx']; ?>" >Pem. Lab Histopatologik/ Sitopatologik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lmks') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lembar Konsultasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" >Lembar Konsultasi</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lmkp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lmkp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lembar Konsultasi POD</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lmkp&idx=<?php echo $_GET['idx']; ?>" >Lembar Konsultasi POD</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'scvd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Covid 19</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" >Status Covid 19</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'trin') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=trin&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Transfer Pasien Internal</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=trin&idx=<?php echo $_GET['idx']; ?>" >Transfer Pasien Internal</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'trex') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=trex&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Transfer Pasien Eksternal</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=trex&idx=<?php echo $_GET['idx']; ?>" >Transfer Pasien Eksternal</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'srkn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srkn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Kontrol</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srkn&idx=<?php echo $_GET['idx']; ?>" >Surat Kontrol</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'srrj') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srrj&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Rujukan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srrj&idx=<?php echo $_GET['idx']; ?>" >Surat Rujukan</a>
		</div>
	<? } ?>
	
	<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '62'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'psth') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psth&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Persetujuan Test HIV</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=psth&idx=<?php echo $_GET['idx']; ?>" >Persetujuan Test HIV</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnth') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnth&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Penolakan Test HIV</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnth&idx=<?php echo $_GET['idx']; ?>" >Penolakan Test HIV</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'prph') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=prph&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Pemeriksaan HIV di Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=prph&idx=<?php echo $_GET['idx']; ?>" >Perm. Pemeriksaan HIV di Laboratorium</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lpth') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lpth&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Laporan Test Antibodi HIV</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lpth&idx=<?php echo $_GET['idx']; ?>" >Laporan Test Antibodi HIV</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rjph') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rjph&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rujukan Pasien HIV</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rjph&idx=<?php echo $_GET['idx']; ?>" >Rujukan Pasien HIV</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '61'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmmc') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmmc&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan Medical Checkup</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pmmc&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan Medical Checkup</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'skdk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skdk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Keterangan Dokter</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skdk&idx=<?php echo $_GET['idx']; ?>" >Surat Keterangan Dokter</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'skbn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skbn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Keterangan Bebas Narkoba</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skbn&idx=<?php echo $_GET['idx']; ?>" >Surat Keterangan Bebas Narkoba</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'skpm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skpm&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Keterangan Pemeriksaan Kesehatan Mata</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skpm&idx=<?php echo $_GET['idx']; ?>" >Surat Keterangan Pemeriksaan Kesehatan Mata</a>
		</div>
	<? } ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'skpj') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skpj&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Keterangan Pemeriksaan Kesehatan Jiwa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=skpj&idx=<?php echo $_GET['idx']; ?>" >Surat Keterangan Pemeriksaan Kesehatan Jiwa</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'srks') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srks&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Keterangan Sakit</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=srks&idx=<?php echo $_GET['idx']; ?>" >Surat Keterangan Sakit</a>
		</div>
	<? } ?>
	<!--
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frsp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frsp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Form Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frsp&idx=<?php echo $_GET['idx']; ?>" >Form Resep</a>
		</div>
	<? } ?>
	-->
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pemulangan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" >Status Pulang</a>
		</div>
	<? } ?>
	</td></tr>
	</table>
</div>	
<?php 
//end new rekam medik
}else{	
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style="height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php include('pasien/pasien_view_short.php'); ?>
 	</div>
	<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
	<table>
	<tr><td>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" >Identitas</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" >Identitas (App Kusta)</a>
		</div>
	<? } } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekam Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Rekam Medik</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Pasien (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Pasien (App Kusta)</a>
		</div>
	<? } } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'anms') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>		
	<? } else { ?>
	<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>">Anamnesis & Pemeriksaan</a>
		</div>
		<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'alrg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Alergi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" >Alergi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Diagnosa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" >Diagnosa</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ksta') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pasien Kusta</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" >Pasien Kusta</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'igd'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'thrp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Terapi & Monitoring</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>" >Terapi & Monitoring</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Asuhan Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" >Asuhan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pemulangan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" >Status Pulang</a>
		</div>
	<? } ?>
	</td></tr>
	</table>
</div>
<?php } ?>
<div class="div_menu" style="height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('klinik/klinik_form_biodata.php');
}else{
	if($_GET['smn'] == 'anms') include('klinik/klinik_form_anamnesis.php');
	if($_GET['smn'] == 'dgns') include('klinik/klinik_form_diagnosa.php');
	if($_GET['smn'] == 'tndk') include('klinik/klinik_form_tindakan.php');
	if($_GET['smn'] == 'lbrm') include('klinik/klinik_form_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('klinik/klinik_form_radiologi.php');
	if($_GET['smn'] == 'pnjg') include('klinik/klinik_form_penunjang.php');
	if($_GET['smn'] == 'resp') include('klinik/klinik_form_resep.php');
	if($_GET['smn'] == 'frms') include('klinik/klinik_form_farmasi.php');
	if($_GET['smn'] == 'thrp') include('klinik/klinik_form_therapi.php');
	if($_GET['smn'] == 'plng') include('klinik/klinik_form_pulang.php');
	if($_GET['smn'] == 'idnt') include('klinik/klinik_form_biodata.php');
	if($_GET['smn'] == 'askp') include('klinik/klinik_form_askep.php');
	if($_GET['smn'] == 'alrg') include('klinik/klinik_form_alergi.php');
	if($_GET['smn'] == 'pekg') include('klinik/klinik_form_penunjang_ekg.php');
	if($_GET['smn'] == 'ksta') include('klinik/klinik_form_kusta.php');
	if($_GET['smn'] == 'idnk') include('klinik/klinik_form_biodata_kusta.php');
	if($_GET['smn'] == 'rwyk') include('klinik/klinik_form_riwayat_kusta.php');
	if($_GET['smn'] == 'oprs') include('klinik/klinik_form_operasi.php');
	if($_GET['smn'] == 'rwyt') include('klinik/klinik_form_riwayat_pasien.php');
	if($_GET['smn'] == 'phmd') include('klinik/klinik_form_hemodialisa.php');
	if($_GET['smn'] == 'rcpl') include('klinik/klinik_form_rencana_pulang.php');
	if($_GET['smn'] == 'cppt') include('klinik/klinik_form_perkembangan_pasien.php');
	if($_GET['smn'] == 'cppn') include('klinik/klinik_form_perkembangan_pasien_terintegrasi.php');
	if($_GET['smn'] == 'petp') include('klinik/klinik_form_edukasi_pasien.php');
	if($_GET['smn'] == 'pamk') include('klinik/klinik_form_pengkajian_awal_medis_kusta.php');
	if($_GET['smn'] == 'pkus') include('klinik/klinik_form_pengkajian_awal_medis_kusta_perubahan_kulit_uratsaraf.php');
	if($_GET['smn'] == 'kttk') include('klinik/klinik_form_pengkajian_awal_medis_kusta_kode_tanda_kelainan.php');
	if($_GET['smn'] == 'pokt') include('klinik/klinik_form_pemeriksaan_okupasi_terapi.php');
	if($_GET['smn'] == 'psdo') include('klinik/klinik_form_pemeriksaan_saraf_otot.php');
	if($_GET['smn'] == 'epck') include('klinik/klinik_form_evaluasi_pencegahan_kecacatan.php');
	if($_GET['smn'] == 'lmfs') include('klinik/klinik_form_lembar_fisioterapi.php');
	if($_GET['smn'] == 'pamd') include('klinik/klinik_form_pengkajian_awal_medis_kandungan.php');
	if($_GET['smn'] == 'pamg') include('klinik/klinik_form_pengkajian_awal_medis_gigi.php');
	if($_GET['smn'] == 'pamm') include('klinik/klinik_form_pengkajian_awal_medis_mata.php');
	if($_GET['smn'] == 'pamu') include('klinik/klinik_form_pengkajian_awal_medis_umum.php');
	if($_GET['smn'] == 'pkgm') include('klinik/klinik_form_pengkajian_awal_kesehatan_mulut.php');
	if($_GET['smn'] == 'lmks') include('klinik/klinik_form_lembar_konsul.php');
	if($_GET['smn'] == 'lmkp') include('klinik/klinik_form_lembar_konsul.php');
	if($_GET['smn'] == 'scvd') include('klinik/klinik_form_covid.php');
	if($_GET['smn'] == 'tria') include('klinik/klinik_form_triase.php');
	if($_GET['smn'] == 'pmgd') include('klinik/klinik_form_pengkajian_medis_gawat_darurat.php');
	if($_GET['smn'] == 'pkgd') include('klinik/klinik_form_pengkajian_keperawatan_gawat_darurat.php');
	if($_GET['smn'] == 'rcpm') include('klinik/klinik_form_rencana_pulang.php');
	if($_GET['smn'] == 'trin') include('klinik/klinik_form_transfer_internal.php');
	if($_GET['smn'] == 'trex') include('klinik/klinik_form_transfer_eksternal.php');
	if($_GET['smn'] == 'srkn') include('klinik/klinik_form_surat_kontrol.php');
	if($_GET['smn'] == 'srrj') include('klinik/klinik_form_surat_rujukan.php');
	if($_GET['smn'] == 'psth') include('klinik/klinik_form_persetujuan_hiv.php');
	if($_GET['smn'] == 'pnth') include('klinik/klinik_form_penolakan_hiv.php');
	if($_GET['smn'] == 'prph') include('klinik/klinik_form_permintaan_test_hiv.php');
	if($_GET['smn'] == 'lpth') include('klinik/klinik_form_laporan_test_hiv.php');
	if($_GET['smn'] == 'rjph') include('klinik/klinik_form_surat_rujukan_pasien_hiv.php');
	if($_GET['smn'] == 'pmmc') include('klinik/klinik_form_pemeriksaan_mcu.php');
	if($_GET['smn'] == 'skdk') include('klinik/klinik_form_pemeriksaan_mcu_skd.php');
	if($_GET['smn'] == 'skbn') include('klinik/klinik_form_pemeriksaan_mcu_narkoba.php');
	if($_GET['smn'] == 'skpm') include('klinik/klinik_form_pemeriksaan_mcu_mata.php');
	if($_GET['smn'] == 'skpj') include('klinik/klinik_form_pemeriksaan_mcu_jiwa.php');
	if($_GET['smn'] == 'srks') include('klinik/klinik_form_surat_keterangan_sakit.php');
	if($_GET['smn'] == 'frsp') include('klinik/klinik_form_resep_keluar.php');
	if($_GET['smn'] == 'pmhs') include('klinik/klinik_form_histopatologik_sitopatologik.php');
	if($_GET['smn'] == 'pkoh') include('klinik/klinik_form_koh.php');
}
?>
</div>
</div>
<script language="javascript" type="text/javascript">
var _haschange = false;

$('form :input').change(function(){
   _haschange = true;
});

window.addEventListener('beforeunload',(event) => {
    if (_haschange) {
        event.preventDefault();
    }
});

function false_kan(){
	_haschange = false;
}

function push_session(){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/sessions/index.php',
		data: { ids : '1' },
		cache: false,
		async : false,
		success: function(json) {			
		},
		error: function (request, status, error) {
	
		}
	});
}	

setInterval(function(){ 
	push_session();
}, 60000);
</script>
<?php } ?>