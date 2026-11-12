<?php
$qry_alergi = 'SELECT t_irja_alergi.IRJA_ALERGI_ID,t_irja_alergi.IRJA_ID,t_irja_alergi.ALERGI
				 FROM t_irja_alergi 
				 WHERE t_irja_alergi.IRJA_ID = "' . $irja_id . '"';
$get_alergi = mysql_query($qry_alergi);
?>
<tr>
    <th width="40">No</th>
    <th>Alergi</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_alergi = mysql_fetch_array($get_alergi)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td><?php echo $dat_alergi['ALERGI']; ?></td>
        <td align="center">
		<?php if($_REQUEST['link'] != md5('klinikviewpasienperiksa')){  ?>
		<a href="<?php echo currentUrl(); ?>&idg=<?php echo $dat_alergi['IRJA_ALERGI_ID']; ?>&nmg=<?php echo $dat_alergi['ALERGI']; ?>" >hapus</a>
		<?php } ?>
		</td>
    </tr>
    <?php
    $i++;
}
?>