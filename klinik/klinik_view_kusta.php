<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irja_id = $_GET['idx'];
$sql_kusta = 'SELECT t_irja.KUSTA_TYPE,t_irja.KUSTA_BTA_SEMULA,
			t_irja.KUSTA_BTA_RATA2_SEMULA,
			DATE_FORMAT(t_irja.KUSTA_TGL_BTA_RATA2,"%d/%m/%Y") AS KUSTA_TGL_BTA_RATA2,
			DATE_FORMAT(t_irja.KUSTA_MDT_MULAI,"%d/%m/%Y") AS KUSTA_MDT_MULAI,
			t_irja.KUSTA_DOSIS_ANTIREAKSI,t_irja.KUSTA_DOSIS_LAMPRENE,
			DATE_FORMAT(t_irja.KUSTA_RFT_COT,"%d/%m/%Y") AS KUSTA_RFT_COT,
			t_irja.KUSTA_BTA_MH_SKR,t_irja.KUSTA_PENYAKIT_LAIN,
			t_irja.KUSTA_YG_PERLU_DIHUBUNGI,t_irja.KUSTA_ALAMAT_DIHUBUNGI,
			t_irja.KUSTA_TELEPON_DIHUBUNGI,t_irja.KUSTA_KETERANGAN,
			t_irja.KUSTA_OPNAME,t_irja.KUSTA_KETERANGAN_OPNAME
			FROM t_irja
			WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
$get_kusta = mysql_query($sql_kusta) or die(mysql_error());
$dat_kusta = mysql_fetch_assoc($get_kusta);
$kusta_type = $dat_kusta['KUSTA_TYPE']; 
$kusta_bta_semula = $dat_kusta['KUSTA_BTA_SEMULA'];
$kusta_bta_rata2_semula = $dat_kusta['KUSTA_BTA_RATA2_SEMULA'];
$kusta_tgl_bta_rata2 = $dat_kusta['KUSTA_TGL_BTA_RATA2'];
$kusta_mdt_mulai = $dat_kusta['KUSTA_MDT_MULAI'];
$kusta_dosis_antireaksi = $dat_kusta['KUSTA_DOSIS_ANTIREAKSI'];
$kusta_dosis_lamprene = $dat_kusta['KUSTA_DOSIS_LAMPRENE'];
$kusta_rft_cot = $dat_kusta['KUSTA_RFT_COT'];
$kusta_bta_mh_skr = $dat_kusta['KUSTA_BTA_MH_SKR'];
$kusta_penyakit_lain = $dat_kusta['KUSTA_PENYAKIT_LAIN'];
$kusta_yg_perlu_dihubungi = $dat_kusta['KUSTA_YG_PERLU_DIHUBUNGI'];
$kusta_alamat_dihubungi = $dat_kusta['KUSTA_ALAMAT_DIHUBUNGI'];
$kusta_telepon_dihubungi = $dat_kusta['KUSTA_TELEPON_DIHUBUNGI'];			
$kusta_keterangan = $dat_kusta['KUSTA_KETERANGAN'];
$kusta_opname = $dat_kusta['KUSTA_OPNAME'];
$kusta_keterangan_opname = $dat_kusta['KUSTA_KETERANGAN_OPNAME'];

$sql_pod = 'SELECT t_irja_pod.POD_ID,t_irja_pod.SUB_POD
			FROM t_irja_pod
			WHERE t_irja_pod.IRJA_ID = "' . $irja_id . '"';
$get_pod = mysql_query($sql_pod) or die(mysql_error());
$podsub = array();
while($dat_pod = mysql_fetch_array($get_pod)){
		$podsub[$dat_pod['SUB_POD']] = $dat_pod['SUB_POD']; 
}			
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0" width="100%">
	<tr><td>
	<table border="0" width="100%">
	<tr>
    <td>&nbsp;</td>
    <td width="180">Tipe Kusta </td>
    <td width="200"><select name="kusta_type" class="text_dt" style="width:100px;">
		<option value=""> -- </option>
		<option value="BB" <?php if($kusta_type == 'BB') echo 'selected="selected"'; ?>>BB</option>
		<option value="BL" <?php if($kusta_type == 'BL') echo 'selected="selected"'; ?>>BL</option>
		<option value="LL" <?php if($kusta_type == 'LL') echo 'selected="selected"'; ?>>LL</option>
		<option value="BT" <?php if($kusta_type == 'BT') echo 'selected="selected"'; ?>>BT</option>
		<option value="TT" <?php if($kusta_type == 'TT') echo 'selected="selected"'; ?>>TT</option>
		<option value="NL" <?php if($kusta_type == 'NL') echo 'selected="selected"'; ?>>NL</option>
		<option value="PB" <?php if($kusta_type == 'PB') echo 'selected="selected"'; ?>>PB</option>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>BTA Semula</td>
    <td><select name="kusta_bta_rata2_semula" class="text_dt" style="width:100px;">
		<option value=""> -- </option>
		<option value="0" <?php if($kusta_bta_rata2_semula == '0') echo 'selected="selected"'; ?>>0</option>
		<option value="1" <?php if($kusta_bta_rata2_semula == '1') echo 'selected="selected"'; ?>>1</option>
		<option value="2" <?php if($kusta_bta_rata2_semula == '2') echo 'selected="selected"'; ?>>2</option>
		<option value="3" <?php if($kusta_bta_rata2_semula == '3') echo 'selected="selected"'; ?>>3</option>
		<option value="4" <?php if($kusta_bta_rata2_semula == '4') echo 'selected="selected"'; ?>>4</option>
		<option value="5" <?php if($kusta_bta_rata2_semula == '5') echo 'selected="selected"'; ?>>5</option>
		<option value="6" <?php if($kusta_bta_rata2_semula == '6') echo 'selected="selected"'; ?>>6</option>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tanggal BTA</td>
    <td><input type="text" name="kusta_tgl_bta_rata2" id="tgl_1" size="15" class="text_dt" value="<?php echo $kusta_tgl_bta_rata2; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>MDT Mulai </td>
    <td><input type="text" name="kusta_mdt_mulai" id="tgl_2" size="15" class="text_dt" value="<?php echo $kusta_mdt_mulai; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar9')"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Yang Perlu Dihubungi </td>
    <td><input type="text" name="kusta_yg_perlu_dihubungi" value="<?php echo $kusta_yg_perlu_dihubungi; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat</td>
    <td><input type="text" name="kusta_alamat_dihubungi" value="<?php echo $kusta_alamat_dihubungi; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Telepon</td>
    <td><input type="text" name="kusta_telepon_dihubungi" value="<?php echo $kusta_telepon_dihubungi; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Anti Reaksi </td>
    <td><input type="text" name="kusta_dosis_antireaksi" value="<?php echo $kusta_dosis_antireaksi; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Dosis Lamprene </td>
    <td><input type="text" name="kusta_dosis_lamprene" value="<?php echo $kusta_dosis_lamprene; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>RFT (COT) </td>
    <td><input type="text" name="kusta_rft_cot" id="tgl_3" size="15" class="text_dt" value="<?php echo $kusta_rft_cot; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>BTA Sekarang </td>
    <td><select name="kusta_bta_mh_skr" class="text_dt" style="width:100px;">
		<option value=""> -- </option>
		<option value="0" <?php if($kusta_bta_mh_skr == '0') echo 'selected="selected"'; ?>>0</option>
		<option value="1" <?php if($kusta_bta_mh_skr == '1') echo 'selected="selected"'; ?>>1</option>
		<option value="2" <?php if($kusta_bta_mh_skr == '2') echo 'selected="selected"'; ?>>2</option>
		<option value="3" <?php if($kusta_bta_mh_skr == '3') echo 'selected="selected"'; ?>>3</option>
		<option value="4" <?php if($kusta_bta_mh_skr == '4') echo 'selected="selected"'; ?>>4</option>
		<option value="5" <?php if($kusta_bta_mh_skr == '5') echo 'selected="selected"'; ?>>5</option>
		<option value="6" <?php if($kusta_bta_mh_skr == '6') echo 'selected="selected"'; ?>>6</option>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Penyakit Lain </td>
    <td><input type="text" name="kusta_penyakit_lain" value="<?php echo $kusta_penyakit_lain; ?>" size="60" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>Opname </td>
    <td><input type="checkbox" name="kusta_opname" value="1" <?php if($kusta_opname == '1') echo 'checked="checked"'; ?> />&nbsp;Ya&nbsp;<input type="text" name="kusta_keterangan_opname" value="<?php echo $kusta_keterangan_opname; ?>" size="53" class="text_dt"  /></td>
    <td>&nbsp;</td>
  </tr> 
 <tr>
    <td>&nbsp;</td>
    <td>Keterangan</td>
    <td><textarea name="kusta_keterangan" rows="5" class="text_dt3"><?php echo $kusta_keterangan; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
	</td>
	<td>
	<table border="0" >	
	<tr>
		<td colspan="3" align="right">Kategori P.O.D&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_1" value="1" <?php if($pod == 1) echo 'checked="checked"'; ?> />&nbsp;Tanpa Cacat</td>
		<td colspan="2" width="180">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_2" value="2" <?php if($pod == 2) echo 'checked="checked"'; ?> />&nbsp;Cacat Tingkat I</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_1" id="podsub_1" value="1" <?php if(isset($podsub[1])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('2');" />&nbsp;Anestesi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_2" id="podsub_2" value="2" <?php if(isset($podsub[2])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('2');" />&nbsp;Parese</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_3" id="podsub_3" value="3" <?php if(isset($podsub[3])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('2');" />&nbsp;Kulit Kering</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_3" value="3" <?php if($pod == 3) echo 'checked="checked"'; ?> />&nbsp;Cacat Tingkat II</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_4" id="podsub_4" value="4" <?php if(isset($podsub[4])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Lagophthalmw</td>
		<td colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_5" id="podsub_5" value="5" <?php if(isset($podsub[5])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Clawing</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_6" id="podsub_6" value="6" <?php if(isset($podsub[6])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Kontraktur</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_7" id="podsub_7" value="7" <?php if(isset($podsub[7])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Fissura</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_8" id="podsub_8" value="8" <?php if(isset($podsub[8])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Absorpsi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_9" id="podsub_9" value="9" <?php if(isset($podsub[9])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Mutilasi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_10" id="podsub_10" value="10" <?php if(isset($podsub[10])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Inversi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_11" id="podsub_11" value="11" <?php if(isset($podsub[11])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Eksversi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_12" id="podsub_12" value="12" <?php if(isset($podsub[12])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Rocker Bottom</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_13" id="podsub_13" value="13" <?php if(isset($podsub[13])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Short Foot</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_14" id="podsub_14" value="14" <?php if(isset($podsub[14])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Ulkus</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_15" id="podsub_15" value="15" <?php if(isset($podsub[15])) echo 'checked="checked"'; ?> onclick="JavaScript : centang_pod('3');" />&nbsp;Amputasi</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	</table>
	</td></tr></table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			&nbsp;</td>	
        </tr>
	</table>
</form>