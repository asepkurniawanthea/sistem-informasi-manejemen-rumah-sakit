<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
$temp_icd_code = '';
$gigi = '';

if (isset($_GET['hpsdiagnosa'])) {
	mysql_query('DELETE FROM t_irna_diagnosa_pulang WHERE IRNA_DIAGNOSA_PULANG_ID="'.$_GET['hpsdiagnosa'].'"');
?>
<script language="JavaScript" >
	opener.location.reload();
</script>
<?
}

$sql_cek_no_ranap1 = 'SELECT t_irna_diagnosa_pulang.DIAGNOSA,t_irna_diagnosa_pulang.IRNA_DIAGNOSA_PULANG_ID,
					CASE WHEN TRIM(t_irna_diagnosa_pulang.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa_pulang.ICD_CODE
					ELSE CONCAT(t_irna_diagnosa_pulang.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
					FROM t_irna_diagnosa_pulang
					LEFT JOIN m_icd_x ON (t_irna_diagnosa_pulang.ICD_CODE = m_icd_x.ICD_CODE)
					WHERE t_irna_diagnosa_pulang.IRNA_ID = "' . $_GET['idx'] . '"
					ORDER BY t_irna_diagnosa_pulang.DIAGNOSA_ORDER';
$get_cek_no_ranap1 = mysql_query($sql_cek_no_ranap1) or die(mysql_error());
?>
<body>
    <table width="95%" class="tableData" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; border:1px; "  >
		<tr>
			<th style="font-size:14px;  font-weight:bold;" align="left">Diagnosa</th>
			<th style="font-size:14px;  font-weight:bold;" align="center" width="80px">Option</th>
		</tr>						
		<?php 
			while($row_cek_no_ranap1=mysql_fetch_array($get_cek_no_ranap1)) {
		?>
        <tr>
			<td align="left" style="text-indent:5px;"><?php echo $row_cek_no_ranap1['DIAGNOSA'] . ' ' . $row_cek_no_ranap1['ICD'];?></td>
			<td align="center" style="text-indent:5px;"><a href="index.php?popup=ranapformhapusdiagnosa&idx=<?php echo $_GET['idx'];?>&hpsdiagnosa=<?php echo $row_cek_no_ranap1['IRNA_DIAGNOSA_PULANG_ID'];?>" >hapus</a></td>
		</tr>
		<?php } ?>
		<tr>
			<td align="right" colspan="3" style="padding-right:15px; ">
				<input type="button" name="selesai" value="tutup" class="myButton1" onclick="window.close();" />
			</td>
		</tr>
	</table>    
<div id="ad"></div>		
</body>