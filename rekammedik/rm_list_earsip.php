<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Pelayanan</th>
		<th>File</th>
		<th width="200">Option</th>
    </tr>
    <?
	$no = 1;	
	$rs = mysql_query($qry_riwayat) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['FILE_ID'];
        ?>
        <tr>
            <td width="30" align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo $data['JNS_PERAWATAN']; ?></td>
			<td><?php echo $data['NAMA_FILE']; ?></td>
			<td align="center"><a href="#" onclick="window.open('http://<?php echo $_SERVER['SERVER_NAME']; ?>/nsimrs/rekammedik/earsip_view.php?file=<?php echo $data['NAMA_FILE']; ?>', '_blank');" >lihat</a></td>
        </tr>
        <?
    $no++; }
    ?>
</table>