<?php
if(isset($_POST['simpan'])){
include('admin/admin_save_tarif.php');
}
?>
<br />
<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />	
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="50">No</th>
			<th>Kode</th>
			<th>Nama Group Tarif</th>
			<th>Poliklinik</th>
			<th>IGD</th>
			<th>Rawat Inap</th>
			<th>Laboratorium</th>
			<th>Radiologi</th>
			<th>Rehabilitasi Medik</th>
			<th>Modul Penunjang</th>
			<th>Unit</th>
			<th>Penerimaan<br />Lain-lain</th>
			</tr>
        <?php
        $sql_tarif = 'SELECT * FROM m_tarif_group WHERE NON_KELAS = "1" ORDER BY NAMA_TARIF_GROUP';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error);
		$idc = 0;
        while ($dat_tarif = mysql_fetch_array($get_tarif)) {
            $labrad = false;
			if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1'
				or $dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1') $labrad = true;
			$rhb = false;
			if($dat_tarif['REHABILITASI_MEDIK'] == '1') $rhb = true;	
			?>
			<tr>
			<td align="center"><?php echo $idc + 1; ?></td>	
			<td align="center"><?php echo $dat_tarif['KODE_TARIF_GROUP']; ?></td>
			<td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
			<td align="center"><?php if($labrad == false and $rhb == false){ ?>
				<input type="checkbox" name="poliklinik<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['POLIKLINIK'] == '1') echo 'checked="checked"'; ?> />
			<?php } ?></td>
			<td align="center"><?php if($labrad == false and $rhb == false){ ?>
				<input type="checkbox" name="igd<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['IGD'] == '1') echo 'checked="checked"'; ?> />
			<?php } ?></td>
			<td align="center"><?php if($labrad == false and $rhb == false){ ?>
				<input type="checkbox" name="irna<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['IRNA'] == '1') echo 'checked="checked"'; ?> />
			<?php } ?></td>
			<td align="center"><?php if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_tarif['REHABILITASI_MEDIK'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($labrad == false){ ?>
				<input type="checkbox" name="penunjang<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['PENUNJANG'] == '1') echo 'checked="checked"'; ?> />
			<?php } ?>
			</td>
			<td>
			<select name="unit<?php echo $idc+1; ?>" class="text_dt" style="width:160px;" >
                 <option value="" ></option>
				 <?php echo getUnit('pnj',$dat_tarif['UNIT_ID']); ?>
            </select>
			<input type="hidden" name="id<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" />	
			</td>
			<td align="center"><?php if($labrad == false and $rhb == false){ ?>
				<input type="checkbox" name="penerimaan_lain<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['PENERIMAAN_LAIN_LAIN'] == '1') echo 'checked="checked"'; ?> />
			<?php } ?>
			</td>
			</tr>
			<?php
        $idc++;
		}
        ?>
    </table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >                      
								<input type="hidden" name="rowcnt" value="<?php echo $idc; ?>" />
								<input type="submit" name="simpan" value="simpan" class="myButton1" /> 
                </td>
            </tr>
        </table>
		</form>