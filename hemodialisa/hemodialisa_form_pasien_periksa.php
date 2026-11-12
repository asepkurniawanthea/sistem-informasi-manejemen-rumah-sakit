<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$jns_order = $_GET['ord'];

if(empty($jns_order)){
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,
				m_pasien.NIK,t_irja.PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"IRJ" AS JNSP, t_irja.IRJA_ID AS IDXORD,
				t_irja.NO_KLINIK
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
}else{
	$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
				""  AS ASAL_PASIEN_ID, "" AS KET_ASAL_PASIEN,t_hemodialisa.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,t_hemodialisa.PASIEN_MASUK,
				CASE WHEN t_hemodialisa.JNS_ORDER = "IRJ" THEN CONCAT(m_unit.NAMA_UNIT,"(",m_pegawai.NAMA_PEGAWAI,")") 
					WHEN t_hemodialisa.JNS_ORDER = "IRN" THEN CONCAT(m_ruang.NAMA_RUANG,"(",m_pegawai.NAMA_PEGAWAI,")") 
				END AS ASAL_PASIEN,
				m_pasien.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CASE WHEN t_hemodialisa.JNS_ORDER = "IRJ" THEN "HRJ" 
				WHEN t_hemodialisa.JNS_ORDER = "IRN" THEN "HRI"  
				END AS JNSP,t_hemodialisa.RAWAT_ID AS IDXORD,
				t_hemodialisa.JENIS_BAYAR_ID,
				t_hemodialisa.NO_KLINIK
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $_GET['idx'] . '"
				AND (t_hemodialisa.JNS_ORDER = "IRJ" OR t_hemodialisa.JNS_ORDER = "IRN")';
}				
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
$jnsp = $dat_pasien['JNSP'];
$idxord = $dat_pasien['IDXORD'];

$hemodialisa_final = $dat_pasien['NO_KLINIK'];
$jns_perawatan = '1';
if($jns_order == 'IRN') $jns_perawatan = '2'; 

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>
<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
<table>
	<tr><td>
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Identitas</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Rekam Medik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Rekam Medik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pamu') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pamu&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Pengkajian Awal Medis</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'paku') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=paku&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Pengkajian Awal Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=paku&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Pengkajian Awal Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien Terintegrasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Catatan Perkembangan Pasien Terintegrasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmtn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pmtn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Pemantauan Pelaksanaan Hemodialisa Harian</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pmtn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Pemantauan Pelaksanaan Hemodialisa Harian</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'itdl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Pemantauan Intradialitik</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=itdl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Pemantauan Intradialitik</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pshd') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pshd&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Post HD & Perencanaan Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pshd&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Post HD & Perencanaan Pulang</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Diagnosa</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Diagnosa</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Tindakan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Tindakan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Obat & BHP</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Obat & BHP</a>
		</div>
	<? } ?>
	
	<?php if($jns_order == ''){ ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. Radiologi</a>
		</div>-->
		<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. EKG/EEG/USG</a>
		</div>-->
	<? } ?>
	
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'thrp') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Terapi & Monitoring</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Terapi & Monitoring</a>
		</div>-->
	<? } ?>

	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Catatan Perkembangan Pasien</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Asuhan Keperawatan</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Asuhan Keperawatan</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Pemberian Edukasi</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<!--<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
		</div>-->
	<? } else { ?>
		<!--<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Rencana Pemulangan</a>
		</div>-->
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" style="color:#FF0000; ">Status Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>" >Status Pulang</a>
		</div>
	<? } ?>
</td></tr>	
</table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('hemodialisa/hemodialisa_form_biodata.php');
}else{
	if($_GET['smn'] == 'rwyt') include('hemodialisa/hemodialisa_form_riwayat_pasien.php');
	if($_GET['smn'] == 'anms') include('hemodialisa/hemodialisa_form_anamnesis.php');
	if($_GET['smn'] == 'dgns') include('hemodialisa/hemodialisa_form_diagnosa.php');
	if($_GET['smn'] == 'tndk') include('hemodialisa/hemodialisa_form_tindakan.php');
	if($_GET['smn'] == 'idnt') include('hemodialisa/hemodialisa_form_biodata.php');
	if($_GET['smn'] == 'thrp') include('hemodialisa/hemodialisa_form_therapi.php');
	if($_GET['smn'] == 'plng') include('hemodialisa/hemodialisa_form_pulang.php');
	if($_GET['smn'] == 'askp') include('hemodialisa/hemodialisa_form_askep.php');
	
	if($_GET['smn'] == 'lbrm') include('hemodialisa/hemodialisa_form_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('hemodialisa/hemodialisa_form_radiologi.php');
	if($_GET['smn'] == 'resp') include('hemodialisa/hemodialisa_form_resep.php');
	if($_GET['smn'] == 'frms') include('hemodialisa/hemodialisa_form_farmasi.php');
	if($_GET['smn'] == 'alrg') include('hemodialisa/hemodialisa_form_alergi.php');
	if($_GET['smn'] == 'pekg') include('hemodialisa/hemodialisa_form_penunjang_ekg.php');
		
	if($_GET['smn'] == 'rcpl') include('hemodialisa/hemodialisa_form_rencana_pulang.php');
	if($_GET['smn'] == 'cppt') include('hemodialisa/hemodialisa_form_perkembangan_pasien.php');
	if($_GET['smn'] == 'petp') include('hemodialisa/hemodialisa_form_edukasi_pasien.php');
	
	if($_GET['smn'] == 'pmtn') include('hemodialisa/hemodialisa_form_pemantauan_hemodialisis.php');
	if($_GET['smn'] == 'itdl') include('hemodialisa/hemodialisa_form_pemantauan_intradialitik.php');
	if($_GET['smn'] == 'pshd') include('hemodialisa/hemodialisa_form_perencanaan_pulang.php');
	
	if($_GET['smn'] == 'paku') include('hemodialisa/hemodialisa_form_askep.php');
	if($_GET['smn'] == 'pamu') include('hemodialisa/hemodialisa_form_pengkajian_awal_medis.php');
	if($_GET['smn'] == 'cppn') include('hemodialisa/hemodialisa_form_perkembangan_pasien_terintegrasi.php');
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
</script>
<?php } ?>