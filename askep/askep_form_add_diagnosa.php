<?php
$askep_diagnosa_id = '';
$domain = '';
$diagnosa = '';
$gejala = '';
$etiologi = '';
if(isset($_POST['tambah'])){
	include('askep/askep_save_add_diagnosa.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
    <table class="tableform" border="0" width="100%">	
		<tr><td width="250">Domain</td>
            <td><select name="domain" id="domain" style="width:500px;" class="text_dt" onchange="javascript : MyAjaxRequest('cdiagnosa','index.php?ajaxrequest=cdiagnosa&domain_id=' + this.value);return false;" >
				<option value=""> - </option>
				<?php 
				$sql_domain = 'SELECT m_askep_domain.ID_DOMAIN,m_askep_domain.NAMA_DOMAIN
								FROM m_askep_domain';
				$get_domain = mysql_query($sql_domain) or die(mysql_error());
				while($dat_domain = mysql_fetch_array($get_domain)){
					echo '<option value="Domain ' . $dat_domain['ID_DOMAIN'] . ' - ' . $dat_domain['NAMA_DOMAIN'] . '">Domain ' . $dat_domain['ID_DOMAIN'] . ' - ' . $dat_domain['NAMA_DOMAIN'] . '</option>';
				}	
				?>
			</select></td></tr>
		<tr><td>Diagnosa Keperawatan</td>
            <td><div id="cdiagnosa"><select name="diagnosa" style="width:500px;" class="text_dt" />
									<option value=""> - </option>
									</select></div></td></tr>
		<tr><td>Daftar Gejala - Batasan Karakteristik</td>
            <td><div id="cgejala"><select name="gejala" style="width:500px;" class="text_dt" />
				<option value=""> - </option>
				</select></div>
				</td></tr>	
		<tr><td>Daftar Etiologi - Faktor Resiko</td>
            <td><div id="cetiologi"><select name="etiologi" style="width:500px;" class="text_dt" />
				<option value=""> - </option>
				</select></div></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>		
        <tr><td>&nbsp;</td><td align="right">
                <input type="submit" name="tambah" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
            </td></tr>
    </table>
	<input type="hidden" name="irna_id" value="<?php echo $_GET['idx']; ?>" />
	<input type="hidden" name="nomr" value="<?php echo $_GET['nomr']; ?>" />
	<input type="hidden" name="askep_diagnosa_id" value="<?php echo $askep_diagnosa_id; ?>" />
</form>
</div>	
</body>