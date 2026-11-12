<?php
$irja_id = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PASIEN_PULANG_ID,t_irja.KET_PASIEN_PULANG,t_irja.MT_RUJUKAN,NO_KLINIK,
				t_irja.RUJUKAN_UNIT_ID,t_irja.RUJUK_BALIK,t_irja.JNS_PELAYANAN,t_irja.PASIEN_KEADAAN_ID
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$pasien_pulang_id = $dat_pasien['PASIEN_PULANG_ID'];
$ket_pasien_pulang = $dat_pasien['KET_PASIEN_PULANG'];
$mt_rujukan = $dat_pasien['MT_RUJUKAN'];
$rujukan_unit_id = $dat_pasien['RUJUKAN_UNIT_ID'];

$pasien_keadaan_id = $dat_pasien['PASIEN_KEADAAN_ID'];
$jns_pelayanan = $dat_pasien['JNS_PELAYANAN'];
$rujuk_balik = $dat_pasien['RUJUK_BALIK'];

$selesai = '';
if($dat_pasien['NO_KLINIK'] != '') $selesai = '1';
?>
<form name="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0" width="70%">
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
            <td>Poliklinik Rujukan</td>
            <td><div>
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
			<tr>
			  <td>Keadaan Pulang</td>
            <td colspan="2"><select name="pasien_keadaan_id" id="pasien_keadaan_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getKeadaanPulangRanap($pasien_keadaan_id); ?>
                </select></td>
			</tr>
			<tr>
			  <td>Jenis Pelayanan</td>
            <td colspan="2"><select name="jns_pelayanan" id="jns_pelayanan" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getJenisPelayananIgd($jns_pelayanan); ?>
                </select></td>
			</tr>
		<tr>
			  <td>Keterangan</td>
            <td colspan="2"><input type="text" name="ket_pasien_pulang" value="<?php echo $ket_pasien_pulang; ?>" size="60" class="text_dt2"  /></td>
		</tr>
        <tr>
            <td>&nbsp;</td>
			<td><input type="checkbox" name="mt_rujukan" value="1" <?php if($mt_rujukan == '1') echo 'checked="checked"'; ?> />&nbsp;Minta Rujukan</td>
			<td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="right">&nbsp;</td>
			<td><input type="checkbox" name="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
</form>