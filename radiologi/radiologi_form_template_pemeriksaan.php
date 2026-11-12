<?php 
$id_template = '';
$jenis_foto = '';
$ekspertise = '';
if(isset($_GET['idt'])){
	$id_template = $_GET['idt'];
	$sql_template = 'SELECT * FROM m_radiologi_template_ekspertise
			WHERE TEMPLATE_RADIOLOGI_ID = "' . $id_template . '"';
	$get_template = mysql_query($sql_template) or die(mysql_error());		
	$dat_template = mysql_fetch_assoc($get_template);
	$jenis_foto = $dat_template['JENIS_FOTO'];
	$ekspertise = $dat_template['EKSPERTISE'];	
}


if(isset($_POST['simpan'])){
	$jenis_foto = $_POST['jenis_foto'];
	$ekspertise = $_POST['hasil_diagnosa'];
	
	$ekspertise = str_replace('<p>','<br />',$ekspertise);
	$ekspertise = str_replace('</p>','',$ekspertise);
	
	if($_POST['template_id'] == ''){	
		mysql_query('INSERT INTO m_radiologi_template_ekspertise (JENIS_FOTO,EKSPERTISE)
			VALUES ("' . trim($jenis_foto) . '","' . mysql_real_escape_string($ekspertise) . '")') or die(mysql_error());
		$get_id = mysql_query('SELECT TEMPLATE_RADIOLOGI_ID FROM m_radiologi_template_ekspertise
			ORDER BY TEMPLATE_RADIOLOGI_ID DESC LIMIT 1');
		$dat_id = mysql_fetch_assoc($get_id);
		$id_template = $dat_id['TEMPLATE_RADIOLOGI_ID'];	
	}else{
		mysql_query('UPDATE m_radiologi_template_ekspertise SET JENIS_FOTO = "' . trim($jenis_foto) . '",
			EKSPERTISE = "' . mysql_real_escape_string($ekspertise) . '"
			WHERE TEMPLATE_RADIOLOGI_ID = "' . $_POST['template_id'] . '"');
	}
	
	$msg_info = 'Data Template telah disimpan.';
}
?>
<div style=" height:auto; padding:15px; ">
<form name="form1" method="post" >  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<script type="text/javascript" src="script/tiny_mce/tiny_mce.js" language="javascript"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
		width: "850",
        height: "400",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
 
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		 
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
		 
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		 
		// Style formats
		style_formats : [
		{title : 'Bold text', inline : 'b'},
		{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
		{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
		{title : 'Example 1', inline : 'span', classes : 'example1'},
		{title : 'Example 2', inline : 'span', classes : 'example2'},
		{title : 'Table styles'},
		{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		 
		// Replace values for the template plugin
		template_replace_values : {
		username : "Some User",
		staffid : "991234"
		}
});
</script>
<table border="0" width="100%">
<tr>
	<td>Jenis Foto</td> 
	<td><input type="text" name="jenis_foto" value="<?php echo $jenis_foto; ?>" class="text_dt" size="60" /></td>
</tr>
<tr>
	<td>Ekspertise</td>
	<td rowspan="2"><textarea name="hasil_diagnosa" id="hasil_diagnosa" ><?php echo $ekspertise; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
  </tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>	
<tr>
	<td>&nbsp;</td><td><input type="submit" name="simpan" value="simpan" class="myButton1" />
	<input type="button" value="tutup" class="myButton1" onclick="window.location = 'index.php?link=7656714ab979b7c7f98b02b4767155d2';" />
	</td>
</tr>	
</table>
</div>
<input type="hidden" name="template_id" value="<?php echo $id_template; ?>" />
</form>
</div>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />