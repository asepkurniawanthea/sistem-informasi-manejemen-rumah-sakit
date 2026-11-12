<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#nama_obat").autocomplete("index.php?autocomp=autocompranapfarmasi",{width: 450});
    });
	jQuery(document).ready(function() {
        jQuery("#dosis").autocomplete("index.php?autocomp=autocompranapdosispemberianobat",{width: 450});
    });
	jQuery(document).ready(function() {
        jQuery("#dosis").autocomplete("index.php?autocomp=autocompranapstatusdosispemberianobat",{width: 450});
    });
	function get_satuan(resep){
		MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
	}
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php

if (isset($_POST['pemberian_obat_id'])) {
    include('rawatinap/ranap_save_edit_add_pemberian_obat.php');
}

$idx = $_GET['idx'];
$idc = $_GET['idc'];

$qry_pem_obat = 'SELECT DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%d/%m/%Y") AS TANGGAL,
						DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%H") AS JAM,
						DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%i") AS MENIT,
						t_irna_pemberian_obat.INSIDENTIL,
						t_irna_pemberian_obat.NAMA_PERSEDIAAN,
						t_irna_pemberian_obat.FORMULARIUM,
						t_irna_pemberian_obat.FORMULARIUM_NASIONAL,
						t_irna_pemberian_obat.SATUAN,
						t_irna_pemberian_obat.DOSIS,
						t_irna_pemberian_obat.STATUS_DOSIS,
						t_irna_pemberian_obat.OBAT_DR_LUAR,
						t_irna_pemberian_obat.RESEP,
						t_irna_pemberian_obat.PEGAWAI_ID
						FROM t_irna_pemberian_obat
					WHERE 	t_irna_pemberian_obat.IRNA_ID = "' . $idx . '" AND t_irna_pemberian_obat.PEMBERIAN_OBAT_ID = "' . $idc . '"';

$get_pem_obat = mysql_query($qry_pem_obat) or die(mysql_error());
$dat_pem_obat = mysql_fetch_array($get_pem_obat);
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="200px;">Tanggal</td>
            <td>
			<input type="text" name="tanggal" id="tgl_1" class="text_dt" size="10" value="<?php echo $dat_pem_obat['TANGGAL']; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($dat_pem_obat['JAM']); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($dat_pem_obat['MENIT']); ?>
			</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="insidentil" value="1" <?php if($dat_pem_obat['INSIDENTIL'] == '1') echo 'checked="checked"'; ?> />Insidentil</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="obat_resep" value="1" <?php if($dat_pem_obat['RESEP'] == '1') echo 'checked="checked"'; ?> />Resep</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="obat_dari_luar" value="1" <?php if($dat_pem_obat['OBAT_DR_LUAR'] == '1') echo 'checked="checked"'; ?> />Obat Dari Luar</td>
		</tr>
        <tr>
			<td>Nama Obat/BHP</td>
            <td><input type="text" name="nama_obat" id="nama_obat" value="<?php 
				$formularium = '';
				if($dat_pem_obat['FORMULARIUM'] == '1') $formularium = ' [Form RS';
				if($dat_pem_obat['FORMULARIUM_NASIONAL'] == '1'){
					if(!empty($formularium)){
						$formularium = $formularium . ' - Form Nasional';
					}else{
						$formularium = ' [Form Nasional';
					}
				}
				if(!empty($formularium)) $formularium = $formularium . ']'; 
				echo $dat_pem_obat['NAMA_PERSEDIAAN'] . $formularium;
			?>" class="text_dt" size="71"/></td>
		</tr>
		<tr>
			<td>Dosis</td>
            <td><input type="text" name="dosis" id="dosis" class="text_dt" size="10" value="<?php echo $dat_pem_obat['DOSIS']; ?>" /></td>
		</tr>
		<tr>
			<td>Status Dosis</td>
            <td><input type="text" name="status_dosis" name="status_dosis" class="text_dt" size="60" value="<?php echo $dat_pem_obat['STATUS_DOSIS']; ?>" /></td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($dat_pem_obat['PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="batal" class="myButton1" /></a></td>
	</tr>
	</table>
    <input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
	<input type="hidden" name="pemberian_obat_id" value="<?php echo $_REQUEST['idc']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>