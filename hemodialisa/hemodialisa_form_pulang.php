<?php
$irja_id = $_GET['idx'];

$pasien_pulang_id = '';
$ket_pasien_pulang = '';
$minta_rujukan = '';
$selesai = '';
$rujukan_unit_id = '';
$pasien_keadaan_id = '';
$jns_pelayanan = '';
$rujuk_balik = '';

if($jns_order == ''){	
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PASIEN_PULANG_ID,t_irja.KET_PASIEN_PULANG,t_irja.MT_RUJUKAN,NO_KLINIK,
				t_irja.RUJUKAN_UNIT_ID,t_irja.RUJUKAN_RUANG_ID,t_irja.RUJUK_BALIK,t_irja.JNS_PELAYANAN,t_irja.PASIEN_KEADAAN_ID
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
}else{
	$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,t_hemodialisa.PASIEN_PULANG_ID,t_hemodialisa.KET_PASIEN_PULANG,t_hemodialisa.MT_RUJUKAN,NO_KLINIK,
				t_hemodialisa.RUJUKAN_UNIT_ID,NULL AS RUJUKAN_RUANG_ID,NULL AS RUJUK_BALIK,NULL AS JNS_PELAYANAN,t_hemodialisa.PASIEN_KEADAAN_ID
				FROM t_hemodialisa
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $irja_id . '"';
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$pasien_pulang_id = $dat_pasien['PASIEN_PULANG_ID'];
$ket_pasien_pulang = $dat_pasien['KET_PASIEN_PULANG'];
$mt_rujukan = $dat_pasien['MT_RUJUKAN'];
$rujukan_unit_id = $dat_pasien['RUJUKAN_UNIT_ID'];
$rujukan_ruang_id = $dat_pasien['RUJUKAN_RUANG_ID'];

$pasien_keadaan_id = $dat_pasien['PASIEN_KEADAAN_ID'];
$jns_pelayanan = $dat_pasien['JNS_PELAYANAN'];
$rujuk_balik = $dat_pasien['RUJUK_BALIK'];

if($dat_pasien['NO_KLINIK'] != '') $selesai = '1';

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_pulang.php');

?>
<form name="formrujukan" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
    <table border="0" width="70%">
        <? if ($jns_order == ''){ ?>
		<tr>
            <td width="20%">Status Pasien Pulang</td>
            <td width="30%">
                <select name="pasien_pulang_id" id="pasien_pulang_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPulang($pasien_pulang_id); ?>
                </select>
            </td>
        </tr>
		<tr>
            <td>Poliklinik</td>
            <td><div id="unit">
                <select name="rujukan_unit_id" id="rujukan_unit_id" style="width:240px;" class="text_dt">
                    <option value="" > - </option>
                    <?php echo getUnit('irja',$rujukan_unit_id); ?>
                </select></div>
            </td>
        </tr>
		<tr>
            <td>Ruang Rawat</td>
            <td><div id="unit">
                <select name="rujukan_ruang_id" id="rujukan_ruang_id" style="width:240px;" class="text_dt">
                    <option value="" > - </option>
                    <?php echo getRuang('',$rujukan_ruang_id); ?>
                </select></div>
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td><input type="checkbox" name="rujuk_balik" value="1" <?php if($rujuk_balik == '1') echo 'checked="checked"'; ?> />&nbsp;Rujuk Balik</td>
			<td>&nbsp;</td>
        </tr>
		<?php } ?>
		<tr>
			  <td>Keterangan</td>
            <td colspan="2"><textarea name="ket_pasien_pulang" class="text_dt2"><?php echo $ket_pasien_pulang; ?></textarea></td>
		</tr>
		<?php if($jns_order == ''){ ?>
        <tr>
            <td>&nbsp;</td>
			<td><input type="checkbox" name="mt_rujukan" value="1" <?php if($mt_rujukan == '1') echo 'checked="checked"'; ?> />&nbsp;Minta Rujukan</td>
			<td>&nbsp;</td>
        </tr>
		<?php } ?>
        <tr>
            <td colspan="2" align="right">&nbsp;</td>
			<td><?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
			<input type="checkbox" name="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } 
			if($hemodialisa_final == '' or $_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" /><?php } ?></td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>