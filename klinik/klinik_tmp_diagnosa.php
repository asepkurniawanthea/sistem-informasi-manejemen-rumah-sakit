<?php
$qry_diagnosa = 'SELECT t_irja_diagnosa.IRJA_DIAGNOSA_ID,t_irja_diagnosa.IRJA_ID,t_irja_diagnosa.DIAGNOSA_ORDER,
				 t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.USER_RM,m_icd_x.DESKRIPSI
				 FROM t_irja_diagnosa 
				 LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				 WHERE t_irja_diagnosa.IRJA_ID = "' . $irja_id . '"
				ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa);
?>
<tr>
    <th width="40">No</th>
    <th>Diagnosa</th>
	<th>ICD Code</th>
	<th>ICD</th>
    <th>Keterangan</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_diagnosa = mysql_fetch_array($get_diagnosa)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td><?php echo $dat_diagnosa['DIAGNOSA']; ?></td>
		<td width="100" align="center"><?php echo $dat_diagnosa['ICD_CODE']; ?></td>
		<td><?php echo $dat_diagnosa['DESKRIPSI']; ?></td>
        <td width="200"><input type="hidden" name="diagnosa_id<?php echo $i; ?>" value="<?php echo $dat_diagnosa['IRJA_DIAGNOSA_ID']; ?>" />
		<select name="diagnosa_order<?php echo $i; ?>" style="width:228px;" class="text_dt" >
		<option value="0" <?php if($dat_diagnosa['DIAGNOSA_ORDER'] == 0) echo 'selected="selected"'; ?>>Diagnosa Utama</option>
		<?php
			$l = 1;
			while($l <= 30){
			?>
			<option value="<?php echo $l; ?>" <?php if($dat_diagnosa['DIAGNOSA_ORDER'] == $l) echo 'selected="selected"'; ?>>Diagnosa Sekunder <?php echo $l; ?></option>
			<?php
			$l++;
			}
		?>
		<select/></td>
        <td align="center">
		<?php if($_REQUEST['link'] != md5('klinikviewpasienperiksa')){ 
		if(empty($dat_diagnosa['USER_RM'])){ ?>
		<a href="<?php echo currentUrl(); ?>&idg=<?php echo $dat_diagnosa['IRJA_DIAGNOSA_ID']; ?>&nmg=<?php echo $dat_diagnosa['DIAGNOSA']; ?>" >hapus</a>
		<?php } } ?>
		</td>
    </tr>
    <?php
    $i++;
}
?>