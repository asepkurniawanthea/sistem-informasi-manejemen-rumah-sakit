<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$jns_order = $_GET['ord'];

if(empty($jns_order)){
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,
				m_pasien.NIK,t_irja.PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"IRJ" AS JNSP, t_irja.IRJA_ID AS IDXORD
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
				t_hemodialisa.JENIS_BAYAR_ID
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $_GET['idx'] . '"
				AND (t_hemodialisa.JNS_ORDER = "IRJ" OR t_hemodialisa.JNS_ORDER = "IRN")
				UNION
				SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NO_PASIEN_PENUNJANG AS NOMR,t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
				""  AS ASAL_PASIEN_ID, "" AS KET_ASAL_PASIEN,t_hemodialisa.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				t_hemodialisa.NAMA_PASIEN,DATE_FORMAT(t_hemodialisa.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,t_hemodialisa.JNS_KELAMIN,
				t_hemodialisa.ALAMAT,t_hemodialisa.NIK,t_hemodialisa.PASIEN_MASUK,
				CONCAT(t_hemodialisa.INSTANSI_PENGIRIM,"(",t_hemodialisa.PENGIRIM,")") AS ASAL_PASIEN,
				t_hemodialisa.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"APS" AS JNSP,t_hemodialisa.RAWAT_ID AS IDXORD,
				t_hemodialisa.JENIS_BAYAR_ID
				FROM t_hemodialisa
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $_GET['idx'] . '"
				AND t_hemodialisa.JNS_ORDER = "APS"';
}				
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

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

$no_telepon = $dat_pasien['NO_TELEPON'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$jnsp = $dat_pasien['JNSP'];
$idxord = $dat_pasien['IDXORD'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

$status_anamnesis = '1';
$status_diagnosa = '1';
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>

	<div  style="height:75px; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'idnt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Identitas</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=idnt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Identitas</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Riwayat Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'anms') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>		
	<? } else { ?>
			<? if (!isset($_GET['smn'])) { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Anamnesis & Pemeriksaan</a>
		</div>
		<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>">Anamnesis & Pemeriksaan</a>
		</div>
		<? } ?>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'alrg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Alergi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Alergi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Diagnosa</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Diagnosa</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Tindakan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Tindakan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Resep</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Resep</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Obat & BHP</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Obat & BHP</a>
		</div>
	<? } ?>
	
	<?php if($jnsp != 'APS'){ ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. Laboratorium</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. Radiologi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. EKG/EEG/USG</a>
		</div>
	<? } ?>
	
	<?php } ?>
	
	<?php if($jnsp != 'APS' and empty($jns_order)){ ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Perm. Operasi</a>
		</div>
	<? } ?>
	
	<?php } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'thrp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Terapi & Monitoring</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=thrp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Terapi & Monitoring</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Catatan Perkembangan Pasien</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Asuhan Keperawatan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=askp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Asuhan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Pemberian Edukasi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Rencana Pemulangan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" style="color:#FF0000; ">Status Pulang</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>" >Status Pulang</a>
		</div>
	<? } ?>
	

</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('hemodialisa/hemodialisa_view_anamnesis.php');
}else{
	if($_GET['smn'] == 'anms') include('hemodialisa/hemodialisa_view_anamnesis.php');
	if($_GET['smn'] == 'dgns') include('hemodialisa/hemodialisa_view_diagnosa.php');
	if($_GET['smn'] == 'tndk') include('hemodialisa/hemodialisa_view_tindakan.php');
	if($_GET['smn'] == 'lbrm') include('hemodialisa/hemodialisa_view_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('hemodialisa/hemodialisa_view_radiologi.php');
	if($_GET['smn'] == 'pnjg') include('hemodialisa/hemodialisa_view_penunjang.php');
	if($_GET['smn'] == 'resp') include('hemodialisa/hemodialisa_view_resep.php');
	if($_GET['smn'] == 'frms') include('hemodialisa/hemodialisa_view_farmasi.php');
	if($_GET['smn'] == 'thrp') include('hemodialisa/hemodialisa_view_therapi.php');
	if($_GET['smn'] == 'plng') include('hemodialisa/hemodialisa_view_pulang.php');
	if($_GET['smn'] == 'idnt') include('hemodialisa/hemodialisa_form_biodata.php');
	if($_GET['smn'] == 'askp'){
		if(empty($jns_order)){
			$sql_cek_askep = 'SELECT t_irja_askep.ST_SELESAI FROM t_irja_askep
							WHERE t_irja_askep.IRJA_ASKEP_ID = "' . $idx . '"';
		}else{
			$sql_cek_askep = 'SELECT t_hemodialisa_askep.ST_SELESAI FROM t_hemodialisa_askep
							WHERE t_hemodialisa_askep.HEMODIALISA_ASKEP_ID = "' . $idx . '"';
		}					
		$get_cek_askep = mysql_query($sql_cek_askep) or die(mysql_error());
		$dat_cek_askep = mysql_fetch_assoc($get_cek_askep);
		if($dat_cek_askep['ST_SELESAI'] != '1'){
			include('hemodialisa/hemodialisa_form_askep.php');
		}else{
			include('hemodialisa/hemodialisa_view_askep.php');
		}	
	}
	if($_GET['smn'] == 'alrg') include('hemodialisa/hemodialisa_view_alergi.php');
	if($_GET['smn'] == 'pekg') include('hemodialisa/hemodialisa_view_penunjang_ekg.php');
	if($_GET['smn'] == 'oprs') include('hemodialisa/hemodialisa_view_operasi.php');
	if($_GET['smn'] == 'rwyt') include('hemodialisa/hemodialisa_view_riwayat_pasien.php');
	if($_GET['smn'] == 'rcpl') include('hemodialisa/hemodialisa_view_rencana_pulang.php');
	if($_GET['smn'] == 'cppt') include('hemodialisa/hemodialisa_view_perkembangan_pasien.php');
	if($_GET['smn'] == 'petp') include('hemodialisa/hemodialisa_view_edukasi_pasien.php');
}
?>
</div>
</div>
<?php } ?>
<script language="javascript" type="text/javascript">
function view_riwayat(){
	window.open("index.php?link=<?php echo md5('rmriwayatpasien'); ?>&nomr=<?php echo $nomr; ?>","Riwayat Pasien");
}
</script>