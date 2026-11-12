<?php 
$fid = $_GET['flex'];
if(!empty($fid)){
	if(!isset($_GET['earsip'])){
		$sql_pdf = 'SELECT t_rm_dokumen_file.NOMR,
				t_rm_dokumen_file.RAWAT_ID,
				t_rm_dokumen_file.JNS_PERAWATAN,
				t_rm_dokumen_file.NAMA_FILE
				FROM t_rm_dokumen_file
			WHERE t_rm_dokumen_file.FILE_ID = "' . $fid . '"';
		$get_pdf = mysql_query($sql_pdf) or die(mysql_error());
		$dat_pdf = mysql_fetch_assoc($get_pdf);	
		$nomr = $dat_pdf['NOMR'];
		$nama_file = $dat_pdf['NAMA_FILE'];
		$rawat = $dat_pdf['JNS_PERAWATAN'];
		$idx = $dat_pdf['RAWAT_ID'];
	
		$new_pdf_path = $rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file;
		if(file_exists($new_pdf_path)){
			$pdf_path = 'http://' . $_SERVER['SERVER_NAME'] . '/erekammedik/pdf/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file;
		}else{
			$pdf_path = 'http://' . $_SERVER['SERVER_NAME'] . '/erekammedik/' . $nomr . '/' . $nama_file;
		}	
	}else{
		$sql_pdf = 'SELECT t_rm_dokumen_earsip.NAMA_FILE
			FROM t_rm_dokumen_earsip
			WHERE t_rm_dokumen_earsip.FILE_ID = "' . $fid . '"';
		$get_pdf = mysql_query($sql_pdf) or die(mysql_error());
		$dat_pdf = mysql_fetch_assoc($get_pdf);	
		$nama_file = $dat_pdf['NAMA_FILE'];
	
		$pdf_path = 'http://' . $_SERVER['SERVER_NAME'] . '/earsip/' . $nama_file;
	}	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">	
    <head> 
        <title>E-Rekam Medik</title>         
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<link href="image/logo.png" rel="shortcut icon" />
        <style type="text/css" media="screen"> 
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }  
        </style> 
		<script type="text/javascript" src="script/pdf/build/pdf.js"></script>
		<script type="text/javascript" src="script/pdf/build/pdf.worker.js"></script>
    </head> 
    <body> 
    	<iframe
			src="script/pdf/web/viewer.html?file=<?php echo $pdf_path?>"
			frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" />
   </body> 
</html> 
<?php } ?>