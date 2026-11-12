<?php
$search_tarif = '';
?>
<script type="text/javascript">
    function add_tindakan(irja_id, tarif_id){
      javascript : MyAjaxRequest('add','index.php?ajaxrequest=pendaftaranformaadtindakan&irja_id=' + irja_id + '&tarif_id=' + tarif_id);
	  setTimeout(opener.location.reload(), 3000);
    }
</script>
<body>

<div style="margin:2px; float:left; padding:5px; padding-left:10px; padding-right:10px; width:100%; background-color:#006600; left:0; right:0; top:0px; border:0px solid #006600; border-radius:5px; color:#FFFFFF;  " align="center" >
<div class="myButton2"  style=" margin:2px; margin-left:5px;margin-right:5px; padding:0px; font-size:13px; float:left; border:0px solid #C8EFAD; color:#CC0000 ">
	<a href="#">TINDAKAN DI POLIKLINIK</a></div><div style="float:none; "></div>
</div>
<div style="margin:2px; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:auto; border:0px solid #999; border-radius:5px; width:100%; float:left; ">
    <table width="85%" border="1" class="tableData" id="tfhover">
        <tr><th colspan="3" style="font-weight:bold; letter-spacing:1px; ">EKG - EEG - USG<div id="add"></div>
		</th></tr>				
        <tr align="center" style="font-weight:bold "><td>Nama Tindakan</td>
		<td>Tarif (Rp.)</td>
		<td>Option</td>
		</tr>
		<tr>
			<td colspan="2" align="left">
			<input type="text" name="q" id="tindakan" size="77" class="text_dt" /></td>			
			<td align="center"><a href="#" >tambah</a></td>
		</tr>
    <?php
		$sql_tarif = 'SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif.SATUAN,m_tarif.TARIF_NON_KELAS
					FROM m_tarif 
					INNER JOIN m_unit ON (m_tarif.UNIT_ID = m_unit.UNIT_ID)
					WHERE m_tarif.ST_AKTIF = "1"';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
		while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
			<tr>
				<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
				<td align="right" width="80px"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
				<td align="center" width="20px"><a href="#" onclick="add_tindakan('<?php echo $_GET['idx']; ?>','<?php echo $dat_tarif['TARIF_ID']; ?>'); return false;" >tambah</a></td>
			</tr>
		<?php
		}	
	?>	
	</table>
	<table border="0" width="100%">
	<tr>
		<td align="right"><a href="#" onClick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
	</table>
</div>