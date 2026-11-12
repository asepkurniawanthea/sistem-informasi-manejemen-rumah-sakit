<?php
if(isset($_POST['simpan'])){
include('admin/admin_save_tarif_kelas.php');
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
			<th>Rawat Inap</th>
			<th>Kamar Operasi</th>
			<th>Kamar Bersalin</th>
			<th>One Day Care</th>
			</tr>
        <?php
        $sql_tarif = 'SELECT * FROM m_tarif_group WHERE NON_KELAS IS NULL ORDER BY NAMA_TARIF_GROUP';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error);
		$idc = 0;
        while ($dat_tarif = mysql_fetch_array($get_tarif)) {
            ?>
			<tr>
			<td align="center"><?php echo $idc + 1; ?></td>	
			<td align="center"><?php echo $dat_tarif['KODE_TARIF_GROUP']; ?></td>
			<td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
			<td align="center"><input type="checkbox" name="rawat_inap<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['IRNA'] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="checkbox" name="kamar_operasi<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['KAMAR_OPERASI'] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="checkbox" name="kamar_bersalin<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['KAMAR_BERSALIN'] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="checkbox" name="one_day_care<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" <?php if($dat_tarif['ONE_DAY_CARE'] == '1') echo 'checked="checked"'; ?> />
			<input type="hidden" name="id<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_GROUP_ID']; ?>" />	
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