<style>
.list_isi{
	height:550px;
}
</style>
<?php
$link = 'index.php';
$unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
	
if(currentModul() == 'pendaftaran'){
	if($unit_id == '9'){
		$link = 'index.php?link=' . md5('pendaftaranbaruigd') . '&pasien=igd';
	} else if($unit_id == '35'){
		$link = 'index.php?link=' . md5('pendaftaranbarukusta') . '&pasien=kusta';
	} else if($unit_id == '50'){
		$link = 'index.php?link=' . md5('pendaftaranbarurawatinap');
	} else {
		 $link = 'index.php?link=' . md5('pendaftaranbarupoliklinik') . '&pasien=umum';
	}	 
}

if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta') $link = 'index.php?link=' . md5('klinikpasienmasuk');

if(currentModul() == 'kasir'){
	if($unit_id == '9'){
		$link = 'index.php?link=' . md5('kasirpembayaranigd') . '&kasir=igd';
	} else if($unit_id == '35'){
		$link = 'index.php?link=' . md5('kasirpembayarankusta') . '&kasir=kusta';
	} else if($unit_id == '50'){
		$link = 'index.php?link=' . md5('kasirpembayaranrawatinap');
	} else {
		 $link = 'index.php?link=' . md5('kasirpembayaranpoliklinik') . '&kasir=umum';
	}
}
if(currentModul() == 'admin') $link = 'index.php?link=' . md5('adminuserlogin');
if(currentModul() == 'rekam medik') $link = 'index.php?link=' . md5('rmpasienrawatjalan');
if(currentModul() == 'laboratorium') $link = 'index.php?link=' . md5('laboratoriumsearchorder');
if(currentModul() == 'radiologi') $link = 'index.php?link=' . md5('radiologisearchorder');
if(currentModul() == 'penunjang') $link = 'index.php?link=' . md5('penunjangsearchorder');
if(currentModul() == 'rawat inap') $link = 'index.php?link=' . md5('ranappasienperiksa');
if(currentModul() == 'casemix') $link = 'index.php?link=' . md5('casemixmonitoringpasienirja');
if(currentModul() == 'kamar operasi') $link = 'index.php?link=' . md5('operasisearchorder');
if(currentModul() == 'hemodialisa') $link = 'index.php?link=' . md5('hemodialisasearchorder');

?>
 <script language="JavaScript" >
     window.location = "<?php echo $link; ?>";
 </script> 