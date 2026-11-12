<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('shared/enum_function.php');

include('lib/vendor/autoload.php');
include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
include('edoc_rekammedik/new/erm_create_rrkrj.php');

function is_valid_name($file) {
  return preg_match('/^([-\.\w]+)$/', $file) > 0;
}

$sql_trans = 'SELECT t_irja.IRJA_ID,t_irja.NOMR
				FROM t_irja
				WHERE t_irja.NO_PENDAFTARAN IS NOT NULL 
				AND t_irja.ST_BATAL IS NULL
				AND t_irja.UNIT_ID <> 9	
				AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d"),"%Y-%m-%d") 
				>= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
$bat_content = '@echo off' . " \n";
while($dat_trans = mysql_fetch_array($get_trans)){
	$id = $dat_trans['IRJA_ID'];
	$nomr = $dat_trans['NOMR'];
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $id)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $id, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $id)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $id, 0700, true);
	}
	
	if(!file_exists($rmfile_path . '/ps1/1/' . $nomr . '/' . $id)){
		@mkdir($rmfile_path . '/ps1/1/' . $nomr . '/' . $id, 0700, true);
	}
	
	erm_create_rrkrj($id,$nomr);
			
	$ps1_file = $rmfile_path . '/ps1/1/' . $nomr . '_' . $id . '.ps1';
	$ps1_file = str_replace('/','\\',$ps1_file);
	$source_path = $rmfile_path . '/doc/1/' . $nomr . '/' . $id;
	$target_path = $rmfile_path . '/pdf/1/' . $nomr . '/' . $id;
	$source_path = str_replace('/','\\',$source_path);
	$target_path = str_replace('/','\\',$target_path);

		$ps1_content = '$word_app = New-Object -ComObject Word.Application
		Get-ChildItem -Path ' . $source_path . ' -Filter *.doc? | ForEach-Object {
			$document = $word_app.Documents.Open($_.FullName)
			$pdf_filename = "' . $target_path . '\$($_.BaseName).pdf"
			$document.SaveAs($pdf_filename,17)
			$document.Close()
			}
			$word_app.Quit()';
		file_put_contents($ps1_file,$ps1_content);
		$bat_content .= 'powershell -executionpolicy bypass -NoProfile -File "' . $ps1_file . '"' . " \n";
}
$bat_content .= 'exit';
file_put_contents('C:/erm_rj_create_pdf.bat',$bat_content);
?>