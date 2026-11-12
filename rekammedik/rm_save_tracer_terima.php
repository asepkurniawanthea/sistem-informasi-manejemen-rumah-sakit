<?php
$rm_tracer_id = $_POST['rm_tracer_id'];
$keterangan = trim($_POST['keterangan']);
$nama_user = currentUser();
if (strpos($rm_tracer_id, 'p') !== false){
	mysql_query('UPDATE t_rm_tracer SET RM_TERIMA = NOW(),RM_USER_TERIMA = "' . $nama_user . '",RM_KETERANGAN_TERIMA = "' . $keterangan . '"
				WHERE RM_TRACER_ID = "' . str_replace('p','',$rm_tracer_id) . '" AND RM_TERIMA IS NULL') or die(mysql_error());
}else{
	mysql_query('UPDATE t_rm_tracer SET RM_TERIMA = NOW(),RM_USER_TERIMA = "' . $nama_user . '",RM_KETERANGAN_TERIMA = "' . $keterangan . '"
				WHERE RM_TRACER_ID = "' . $rm_tracer_id . '" AND RM_TERIMA IS NULL') or die(mysql_error());
}	
?>
<script language="JavaScript" >
	opener.location.reload();	
    window.close();
</script>