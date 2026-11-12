<?php

ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
date_default_timezone_set('Asia/Jakarta');

$hostname = 'localhost';
$database = 'db_simrs';
$username = 'root';
$password = 'root';

$hostname_2 = 'localhost';
$database_2 = 'simrs2012';
$username_2 = 'root';
$password_2 = 'root';

$hostname_3 = 'localhost';
$database_3 = 'db_inventorirs';
$username_3 = 'root';
$password_3 = 'root';

$hostname_4 = 'localhost';
$database_4 = 'db_customer_servicers';
$username_4 = 'root';
$password_4 = 'root';

$hostname_5 = 'localhost';
$database_5 = 'db_repository';
$username_5 = 'root';
$password_5 = 'root';

$hostname_6 = 'localhost';
$database_6 = 'db_simkeu';
$username_6 = 'root';
$password_6 = 'root';

$hostname_7 = 'localhost';
$database_7 = 'db_sdm';
$username_7 = 'root';
$password_7 = 'root';

$hostname_8 = 'localhost';
$database_8 = 'db_siijapin';
$username_8 = 'root';
$password_8 = 'root';

$hostname_9 = 'localhost';
$database_9 = 'db_bios';
$username_9 = 'root';
$password_9 = 'root';

$hostname_10 = 'localhost';
$database_10 = 'bpjs_antrian';
$username_10 = 'root';
$password_10 = 'root';

$site = 'nsimrs';
$inacbgs_host = '192.168.1.11';
$bpjs_host = 'new-api.bpjs-kesehatan.go.id:8080';
//$bpjs_host = 'dvlp.bpjs-kesehatan.go.id';
$rs_account	= array(
		'id'	=> 'id12345',				
		'key'	=> 'rs0987654',		
		'code'	=> '0000000',
		'user'	=> 'usernya'	
	);
$app_path = 'D:/xampp564/htdocs/';
$swftool_path = 'C:/"Program Files (x86)"/SWFTools/pdf2swf.exe';
$ziptool_path = 'C:/"Program Files (x86)"/7-Zip/7z.exe';
$htmltopdf_tool_path = 'C:/"Program Files"/wkhtmltopdf/bin/wkhtmltopdf.exe';
$rmfile_path = 'D:/erekammedik';	
$earsipfile_path = 'E:/earsip_rm';
$dicom_path = 'E:/dicom';	
$fs_path = 'E:/filesharing';
$eklaim_arsip_path = 'E:/eklaim';		
$upload_lap_gaji_path = 'E:/sdm_laporan_gaji';

$rs_kode = '9999999';
$rs_nama = 'RS Dr. Sitanala';
$rs_kelas = 'A';
$rs_tarif_inacbg = 'A / I / RSKUSTA';

$app_title_brw = 'SIMRS - RSUP Dr. SITANALA';
$app_title_hdr1 = 'Sistem Informasi Manajemen Rumah Sakit';
$app_title_hdr2 = 'RSUP Dr. SITANALA';
$app_title_hdr3 = $rs_kode . ' ' . $rs_tarif_inacbg;
$app_title_ftr = 'Sistem Informasi Manajemen Rumah Sakit &copy;2014';
?>