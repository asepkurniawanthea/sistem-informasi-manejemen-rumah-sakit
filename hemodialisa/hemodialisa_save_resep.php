<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();

$_err = '';
if (isset($_POST['simpan'])) {
		
		if(empty($jns_order)){
				$nomor = getNomorBulanan('IRJA');	
				$sql_cek_resep = 'SELECT NO_RESEP FROM t_irja_resep WHERE IRJA_ID = "' . $irja_id . '"
							AND NO_RESEP IS NOT NULL';
				$get_cek_resep = mysql_query($sql_cek_resep) or die(mysql_error());
				if(mysql_num_rows($get_cek_resep) > 0){
					$dat_cek_resep = mysql_fetch_assoc($get_cek_resep);
					$nomor = $dat_cek_resep['NO_RESEP'];
				}	
				mysql_query('UPDATE t_irja_resep SET NO_RESEP = "' . $nomor . '",TGL_RESEP = NOW() 
						WHERE IRJA_ID = "' . $irja_id . '" AND NO_RESEP IS NULL') or die(mysql_error());
				mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '",
						ST_CREATE_ERM_RESEP = NULL
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
		}else{
				$nomor = getNomorBulanan('IRJA');	
				$sql_cek_resep = 'SELECT NO_RESEP FROM t_hemodialisa_resep WHERE HEMODIALISA_ID = "' . $irja_id . '"
						AND NO_RESEP IS NOT NULL';
				$get_cek_resep = mysql_query($sql_cek_resep) or die(mysql_error());
				if(mysql_num_rows($get_cek_resep) > 0){
					$dat_cek_resep = mysql_fetch_assoc($get_cek_resep);
					$nomor = $dat_cek_resep['NO_RESEP'];
				}	
				mysql_query('UPDATE t_hemodialisa_resep SET NO_RESEP = "' . $nomor . '" 
						WHERE HEMODIALISA_ID = "' . $irja_id . '" AND NO_RESEP IS NULL') or die(mysql_error());
				mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '",
						ST_CREATE_ERM_RESEP = NULL
						WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
		}	
if($_err == ''){
?>
<script language="JavaScript" >
	alert('Simpan Data Resep Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
	}else{
			$msg_info = $_err;
	}
}
?>