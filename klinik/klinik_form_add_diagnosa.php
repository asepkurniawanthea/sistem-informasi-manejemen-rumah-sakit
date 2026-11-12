<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 500});
    });
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
$temp_icd_code = '';
$gigi = '';
?>
<body>


<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
        <tr>
            <td>Diagnosa</td><td><input type="text" name="q" id="diagnosa" size="77" value="<?php echo $temp_icd_code; ?>" class="text_dt"  /></td></tr>
			<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '5'){ ?>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td>Elemen Gigi</td><td><input type="text" name="gigi" id="gigi" size="77" value="<?php echo $gigi; ?>" class="text_dt"  /></td>
			</tr>
			<?php } ?>
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="button" value="tambah" class="myButton1" onclick="save_diagnosa();" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
	
	</table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irja_id" value="<?php echo $_REQUEST['idx']; ?>" />
</form>
<table border="0" width="100%" >
<tr>
  <td>Kanan</td>		
</tr>
<tr>
	<td>
	<!-- kanan -->
		<table width="100%" class="tableData2">
		  <tr>
			<td align="center" width="5" scope="col">&nbsp;</td>
			<td align="center" width="5" scope="col">&nbsp;</td>
			<td align="center" width="5" scope="col">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 5.5 | V'); return false;" >5.5<br />V</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 5.4 | IV'); return false;">5.4<br />IV</a></td>
			<td align="center" width="1%" scope="col">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 5.3 | III'); return false;">5.3<br />III</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 5.2 | II'); return false;">5.2<br />II</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 5.1 | I'); return false;">5.1<br />I</a></td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.8 | 8'); return false;">1.8<br />8</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.7 | 7'); return false;">1.7<br />7</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.6 | 6'); return false;">1.6<br />6</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.5 | 5'); return false;">1.5<br />5</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.4 | 4'); return false;">1.4<br />4</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.3 | 3'); return false;">1.3<br />3</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.2 | 2'); return false;">1.2<br />2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 1.1 | 1'); return false;">1.1<br />1</a></td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.8 | 8'); return false;">8<br />4.8</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.7 | 7'); return false;">7<br />4.7</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.6 | 6'); return false;">6<br />4.6</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.5 | 5'); return false;">5<br />4.5</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.4 | 4'); return false;">4<br />4.4</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.3 | 3'); return false;">3<br />4.3</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.2 | 2'); return false;">2<br />4.2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 4.1 | 1'); return false;">1<br />4.1</a></td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row">&nbsp;</td>
			<td align="center" width="5">&nbsp;</td>
			<td align="center" width="5">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 8.5 | V'); return false;">V<br />8.5</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 8.4 | IV'); return false;">IV<br />8.4</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 8.3 | III'); return false;">III<br />8.3</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 8.2 | II'); return false;">II<br />8.2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kanan | 8.1 | I'); return false;">I<br />8.1</a></td>
		  </tr>
		</table>
	<!-- end kanan -->
	</td>
	</tr>
	<tr><td>Kiri</td></tr>
	<tr><td>
	<!-- kiri -->
		<table width="100%" class="tableData2">
		  <tr>
			<td align="center" width="5" scope="col"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 6.1 | I'); return false;">6.1<br />I</a></td>
			<td align="center" width="5" scope="col"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 6.2 | II'); return false;">6.2<br />II</a></td>
			<td align="center" width="5" scope="col"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 6.3 | III'); return false;">6.3<br />III</a></td>
			<td align="center" width="1%" scope="col">&nbsp;</td>
			<td align="center" width="5" scope="col"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 6.4 | IV'); return false;">6.4<br />IV</a></td>
			<td align="center" width="5" scope="col"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 6.5 | V'); return false;">6.5<br />V</a></td>
			<td align="center" width="5" scope="col">&nbsp;</td>
			<td align="center" width="5" scope="col">&nbsp;</td>
			<td align="center" width="5" scope="col">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.1 | 1'); return false;">2.1<br />1</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.2 | 2'); return false;">2.2<br />2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.3 | 3'); return false;">2.3<br />3</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.4 | 4'); return false;">2.4<br />4</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.5 | 5'); return false;">2.5<br />5</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.6 | 6'); return false;">2.6<br />6</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.7 | 7'); return false;">2.7<br />7</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 2.8 | 8'); return false;">2.8<br />8</a></td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.1 | 1'); return false;">1<br />3.1</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.2 | 2'); return false;">2<br />3.2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.3 | 3'); return false;">3<br />3.3</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.4 | 4'); return false;">4<br />3.4</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.5 | 5'); return false;">5<br />3.5</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.6 | 6'); return false;">6<br />3.6</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.7 | 7'); return false;">7<br />3.7</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 3.8 | 8'); return false;">8<br />3.8</a></td>
		  </tr>
		  <tr>
			<td align="center" width="5" scope="row"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 7.1 | I'); return false;">I<br />7.1</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 7.2 | II'); return false;">II<br />7.2</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 7.3 | III'); return false;">III<br />7.3</a></td>
			<td align="center" width="1%">&nbsp;</td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 7.4 | IV'); return false;">IV<br />7.4</a></td>
			<td align="center" width="5"><a href="#" onclick="JavaScript : add_diagnosa_gigi('<?php echo $_GET['idx']; ?>','Kiri | 7.5 | V'); return false;">V<br />7.5</a></td>
			<td align="center" width="5">&nbsp;</td>
			<td align="center" width="5">&nbsp;</td>
			<td align="center" width="5">&nbsp;</td>
		  </tr>
		</table>
	<!-- end kiri -->
	</td></tr>
</table>		
</div>
</body>
 <script language="JavaScript" >
    function add_diagnosa_gigi(idx,diagnosa){
		document.getElementById("gigi").value = document.getElementById("gigi").value + ' ' + diagnosa;
	}
	
	function save_diagnosa(){
		var diagnosa = jQuery("#diagnosa").val();
		var gigi = jQuery("#gigi").val();
		var p_diagnosa = window.opener.jQuery("#diagnosa").val();
		
		if(p_diagnosa.length == 0){
			window.opener.jQuery("#diagnosa").val(diagnosa + ' /' + gigi);	
		}else{
			window.opener.jQuery("#diagnosa").val(p_diagnosa + ' \n ' + diagnosa + '/' + gigi);
		}	
		jQuery("#diagnosa").val('');
		jQuery("#gigi").val('');
	}	
 </script>