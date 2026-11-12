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
			$pdf_path = $new_pdf_path;
			$swf_nama_file = str_replace('.pdf','.swf',$nama_file);
			$swf_output = $rmfile_path . '/flexpaper/' . $swf_nama_file;
			//$cmd = $swftool_path . " -b " .  $pdf_path . " -o "  .  $swf_output;
			$cmd = $swftool_path . " " .  $pdf_path . " -o "  .  $swf_output . " -T 9 -f";
		}else{
			$pdf_path = $rmfile_path . '/' . $nomr . '/' . $nama_file;
			$swf_nama_file = str_replace('.pdf','.swf',$nama_file);
			$swf_output = $rmfile_path . '/flexpaper/' . $swf_nama_file;
			//$cmd = $swftool_path . " -b " .  $pdf_path . " -o "  .  $swf_output;
			$cmd = $swftool_path . " " .  $pdf_path . " -o "  .  $swf_output . " -T 9 -f";
		}	
	}else{
		$sql_pdf = 'SELECT t_rm_dokumen_earsip.NAMA_FILE
			FROM t_rm_dokumen_earsip
			WHERE t_rm_dokumen_earsip.FILE_ID = "' . $fid . '"';
		$get_pdf = mysql_query($sql_pdf) or die(mysql_error());
		$dat_pdf = mysql_fetch_assoc($get_pdf);	
		$nama_file = $dat_pdf['NAMA_FILE'];
	
		$pdf_path = $earsipfile_path . '/' . $nama_file;
		$swf_nama_file = str_replace('.pdf','.swf',$nama_file);
		$swf_nama_file = str_replace('.PDF','.swf',$nama_file);
		$swf_output = $rmfile_path . '/flexpaper/' . $swf_nama_file;
		//$cmd = $swftool_path . " -b " .  $pdf_path . " -o "  .  $swf_output;
		$cmd = $swftool_path . " " .  $pdf_path . " -o "  .  $swf_output . " -T 9 -f";
	}	

	exec($cmd);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">	
    <head> 
        <title>FlexPaper</title>         
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<link href="image/logo.png" rel="shortcut icon" />
        <style type="text/css" media="screen"> 
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }   
			#flashContent { display:none; }
        </style> 
		<script type="text/javascript" src="flexpaper/js/flexpaper_flash.js"></script>
    </head> 
    <body> 
    	<div style="position:absolute;left:10px;top:10px;">
	        <a id="viewerPlaceHolder" style="width:1024px;height:600px;display:block"></a>
	        
	        <script type="text/javascript"> 
				var fp = new FlexPaperViewer(	
						 'flexpaper/FlexPaperViewers',
						 'viewerPlaceHolder', { config : {
						 SwfFile : escape('http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/flexpaper/<?php echo $swf_nama_file; ?>'),
						 Scale : 0.6, 
						 ZoomTransition : 'easeOut',
						 ZoomTime : 0.5,
						 ZoomInterval : 0.2,
						 FitPageOnLoad : true,
						 FitWidthOnLoad : true,
						 FullScreenAsMaxWindow : false,
						 ProgressiveLoading : false,
						 MinZoomSize : 0.2,
						 MaxZoomSize : 5,
						 SearchMatchAll : false,
						 InitViewMode : 'Portrait',
						 PrintPaperAsBitmap : false,
						 PrintToolsVisible : false, 
						 ReadOnly : true,
						 PrintEnabled : false,
						 
						 
						 ViewModeToolsVisible : true,
						 ZoomToolsVisible : true,
						 NavToolsVisible : true,
						 CursorToolsVisible : true,
						 SearchToolsVisible : true,
  						
  						 localeChain: 'en_US'
						 }});
	        </script>
        </div>
        
   </body> 
</html> 
<?php } ?>