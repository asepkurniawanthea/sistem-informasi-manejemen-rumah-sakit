<br />
<table border="1" class="tableData" id="tfhover">
    <tr>
		<th width="150px">Jenis Foto</th>
		<th>Ekspertise</th>
		<th width="150px">Option</th>
	</tr>
<?php 
$sql_template = 'SELECT * FROM m_radiologi_template_ekspertise
	ORDER BY JENIS_FOTO';
$get_template = mysql_query($sql_template) or die(mysql_error());	
while($dat_template = mysql_fetch_array($get_template)){
	?>
	<tr>
		<td><?php echo strtoupper($dat_template['JENIS_FOTO']); ?></td>
		<td><?php echo $dat_template['EKSPERTISE']; ?></td>
		<td align="center">
		<a href="index.php?link=8abdd3046f5a61aa4b723486ee018063&idt=<?php echo $dat_template['TEMPLATE_RADIOLOGI_ID']; ?>">ubah</a>
		</td>
	</tr>
<?php } ?>
<tr>
	<td colspan="3" align="right">
		<input type="button" value="tambah" class="myButton1" onclick="window.location = 'index.php?link=8abdd3046f5a61aa4b723486ee018063';" />
	</td>
</tr>
</table>


