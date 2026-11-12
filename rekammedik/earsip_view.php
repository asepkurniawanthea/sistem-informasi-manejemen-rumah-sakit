<?php 
if(isset($_GET['file'])){
	$pdf_path = 'http://' . $_SERVER['SERVER_NAME'] . '/filesharing/earsip_rm/' . $_GET['file'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">	
    <head> 
        <title>E-Rekam Medik</title>         
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<link href="../image/logo.png" rel="shortcut icon" />
        <style type="text/css" media="screen"> 
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }  
        </style> 
		<script type="text/javascript" src="../script/pdf/build/pdf.js"></script>
		<script type="text/javascript" src="../script/pdf/build/pdf.worker.js"></script>
    </head> 
    <body> 
    	<iframe
			src="../script/pdf/web/viewer.html?file=<?php echo $pdf_path; ?>"
			frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" />
   </body> 
</html> 
<?php } ?>