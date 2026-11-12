<?php
if(isset($_POST['simpan'])){
include('admin/admin_save_tarif_odc.php');
}
?>
<br />
<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />	
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="50">No</th>
			<th>Kode Tarif</th>
			<th>Nama Group Tarif</th>
			<th>Nama Tarif</th>
			<th>Jasa Sarana</th>
			<th>Jasa Pelayanan</th>
			<th>Tarif</th>
			<th>Kelas Tarif</th>
			<th>One Day Care</th>
			</tr>
        <?php
        $sql_tarif = 'SELECT * FROM m_tarif_group 
						INNER JOIN m_tarif 
						ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)		
						WHERE NON_KELAS IS NULL
						AND ONE_DAY_CARE = "1"
						AND ST_AKTIF = "1"
						ORDER BY NAMA_TARIF_GROUP,NAMA_TARIF';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error);
		$idc = 0;
        while ($dat_tarif = mysql_fetch_array($get_tarif)) {
            ?>
			<tr>
			<td align="center"><?php echo $idc + 1; ?></td>	
			<td align="center"><?php echo $dat_tarif['KODE_TARIF']; ?></td>
			<td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
			<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
			<?php if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '3'){ ?>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_SARANA_KELAS_3']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_PELAYANAN_KELAS_3']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['TARIF_KELAS_3']); ?></td>
			<?php } else if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '2'){ ?>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_SARANA_KELAS_2']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_PELAYANAN_KELAS_2']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['TARIF_KELAS_2']); ?></td>
			<?php } else if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '1'){ ?>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_SARANA_KELAS_1']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['JASA_PELAYANAN_KELAS_1']); ?></td>
			<td align="right"><?php echo currFormat($dat_tarif['TARIF_KELAS_1']); ?></td>
			<?php }else{ ?>
			<td align="right">0</td>
			<td align="right">0</td>
			<td align="right">0</td>
			<?php } ?>
			<td align="center"><select name="kelas<?php echo $idc+1; ?>" class="text_dt">
			<option value="" > - </option>
			<option value="1" <?php if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '1') echo 'selected="selected"'; ?> >Kelas 1</option>
			<option value="2" <?php if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '2') echo 'selected="selected"'; ?> >Kelas 2</option>
			<option value="3" <?php if($dat_tarif['ODC'] == '1' and $dat_tarif['KELAS_ODC'] == '3') echo 'selected="selected"'; ?> >Kelas 3</option>
			</select></td>
			<td align="center"><input type="checkbox" name="one_day_care<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_ID']; ?>" <?php if($dat_tarif['ODC'] == '1') echo 'checked="checked"'; ?> />
			<input type="hidden" name="id<?php echo $idc+1; ?>" value="<?php echo $dat_tarif['TARIF_ID']; ?>" />	</td>
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