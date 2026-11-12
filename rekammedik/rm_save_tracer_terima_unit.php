<?php
$rm_tracer_id = $_POST['rm_tracer_id'];
$keterangan = trim($_POST['keterangan']);
$nama_user = currentUser();

if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta'){
	mysql_query('UPDATE t_rm_tracer SET IRJA_TERIMA = NOW(),
				IRJA_USER_TERIMA = "' . $nama_user . '",
				IRJA_KETERANGAN_TERIMA = "' . $keterangan . '"
				WHERE RM_TRACER_ID = "' . $rm_tracer_id . '" 
				AND IRJA_TERIMA IS NULL') or die(mysql_error());
}else if(currentModul() == 'rawat inap'){
	mysql_query('UPDATE t_rm_tracer 
				INNER JOIN t_irna ON (t_rm_tracer.IRJA_ID = t_irna.IRNA_ID)
				SET ADMS_TERIMA = NOW(),
				ADMS_USER_TERIMA = "' . $nama_user . '",
				IRJA_KETERANGAN_TERIMA = "' . $keterangan . '",
				ADMS_TERIMA_RUANG_ID = t_irna.RUANG_ID
				WHERE RM_TRACER_ID = "' . $rm_tracer_id . '"') or die(mysql_error());	
}else{
	mysql_query('UPDATE t_rm_tracer SET ADMS_TERIMA = NOW(),ADMS_USER_TERIMA = "' . $nama_user . '",ADMS_KETERANGAN_TERIMA = "' . $keterangan . '"
				WHERE RM_TRACER_ID = "' . $rm_tracer_id . '" AND ADMS_TERIMA IS NULL') or die(mysql_error());
}				
?>
<script language="JavaScript" >
	opener.location.reload();	
    window.close();
</script>