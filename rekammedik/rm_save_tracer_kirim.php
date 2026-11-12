<?php
$irja_id = $_POST['irja_id'];
$keterangan = trim($_POST['keterangan']);
$nama_user = currentUser();

if (strpos($irja_id, 'p') !== false) {
	mysql_query('INSERT INTO t_rm_tracer(PENUNJANG_ID,RM_KIRIM,RM_USER_KIRIM,RM_KETERANGAN_KIRIM)
				VALUES("' . str_replace('p','',$irja_id) . '",NOW(),"' . $nama_user . '","' . $keterangan . '")') or die(mysql_error());
}else{	
	mysql_query('INSERT INTO t_rm_tracer(IRJA_ID,RM_KIRIM,RM_USER_KIRIM,RM_KETERANGAN_KIRIM)
				VALUES("' . $irja_id . '",NOW(),"' . $nama_user . '","' . $keterangan . '")') or die(mysql_error());
}				
?>
<script language="JavaScript" >
  opener.location.reload();	
    window.close();
</script>