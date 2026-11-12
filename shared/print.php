<?php
$print = $_GET['print'];
if ($print == 'radiologidiagnosa') {
    include('radiologi/radiologi_print_diagnosa.php');
    die();
}
if ($print == 'rrkrj') {
    include('rekammedik/rm_print_rrkrj.php');
    die();
}
if ($print == 'tracer') {
    include('rekammedik/rm_print_tracer.php');
    die();
}
if ($print == 'gelangpasien') {
    include('pendaftaran/pendaftaran_print_gelang.php');
    die();
}
if ($print == 'hasillaboratorium') {
    include('laboratorium/laboratorium_print_hasil.php');
    die();
}

if ($print == 'downloadmr') {
	$pdf_path = $app_path . 'nsimrs/pasien_mr_file/' . $_GET['nomr'] . '/' . $_GET['file'];
	$swf_output_path = $app_path . 'nsimrs/flexpaper/docs/'. $_GET['nomr'] . '_' . $_GET['file'];
	$cmd = $swftool_path . ' -b "' . $pdf_path . '" -o "' . $swf_output_path . '.swf"';
	exec($cmd);
	//var_dump($output);
	include('flexpaper/flexpaper_viewer.php');
	die();
}
?>