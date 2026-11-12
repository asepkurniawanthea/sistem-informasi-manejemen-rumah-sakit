<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.POD
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

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$pod = $dat_pasien['POD'];

$status_anamnesis = '1';
$status_diagnosa = '1';

$hg = '75px';
if(currentModul() == 'kusta') $hg = '115px';
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>

	<div  style=" height:<?php echo $hg; ?>; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>" >Identitas</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=idnk&idx=<?php echo $_GET['idx']; ?>" >Identitas (App Kusta)</a>
		</div>
	<? } } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Riwayat Pasien</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat (App Kusta)</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rwyk&idx=<?php echo $_GET['idx']; ?>" >Riwayat (App Kusta)</a>
		</div>
	<? } } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'anms') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>		
	<? } else { ?>
		<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>">Anamnesis & Pemeriksaan</a>
		</div>
		<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'alrg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Alergi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" >Alergi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Diagnosa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" >Diagnosa</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'kusta'){ ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ksta') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pasien Kusta</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=ksta&idx=<?php echo $_GET['idx']; ?>" >Pasien Kusta</a>
		</div>
	<? } ?>
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
		</div>
	<? } ?>
	
	<?php if(currentModul() == 'igd'){ ?>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
		</div>
	<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'thrp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Terapi & Monitoring</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>" >Terapi & Monitoring</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Asuhan Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>" >Asuhan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pemulangan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('klinikformeditpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" >Status Pulang</a>
		</div>
	<? } ?>

</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('klinik/klinik_form_anamnesis.php');
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
	if($_GET['smn'] == 'petp') include('klinik/klinik_form_edukasi_pasien.php');
}
?>
</div>
</div>
<script language="javascript" type="text/javascript">
function view_riwayat(){
	window.open("index.php?link=<?php echo md5('rmriwayatpasien'); ?>&nomr=<?php echo $nomr; ?>","Riwayat Pasien");
}
</script>
<?php } ?>