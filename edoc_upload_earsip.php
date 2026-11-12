<?php
include('config/config.php');
include('shared/connect_db.php');

$dir = 'E:/earsip_rm';
$dh = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    if (file_exists($dir . '/' . $filename)){
		$arr_filename = explode('_',$filename);
		$nomr = $arr_filename[0];
		$jns_perawatan = $arr_filename[2];	
		$tanggal = $arr_filename[1];	
        mysql_query('INSERT INTO t_rm_dokumen_earsip(NOMR,
				JNS_PERAWATAN,TANGGAL,NAMA_FILE)
				VALUES("' . $nomr . '","' . $jns_perawatan . '",
				STR_TO_DATE("' . $tanggal . '","%d-%m-%Y"),"' . $filename . '")') or die(mysql_error());
    }
}
?>