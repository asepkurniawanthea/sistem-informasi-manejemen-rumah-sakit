<?php
$search_tarif = '';
if(isset($_GET['grp'])) $search_tarif = $_GET['grp'];
?>
<script type="text/javascript">
	function add_penunjang_execute(p_id, tarif_id){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=penunjangformaddtindakan&p_id=' + p_id + '&tarif_id=' + tarif_id + '&no_tarif=<?php echo $_GET['no']; ?>' + '&unit_id=<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>',
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				return data;		
			}
		});
	}

    function add_penunjang(p_id, tarif_id){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekpenunjangformaddtindakan',
			data: { xp_id : p_id, xtarif_id : tarif_id, xord : '<?php echo $_GET['ord']; ?>', xno : '<?php echo $_GET['no']; ?>'},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data == 0){
						rtr = add_penunjang_execute(p_id, tarif_id);	
						setTimeout(opener.location.reload(), 5000);
					}else{
						if(confirm('Item Sudah Ada. Tambah Item ?')){
							rtr = add_penunjang_execute(p_id, tarif_id);	
							setTimeout(opener.location.reload(), 5000);
						}else{
							opener.location.reload();
						}	
					}
				}	
			}
		});
	}
</script>
<body>

<div style="margin:2px; float:left; padding:5px; padding-left:10px; padding-right:10px; width:100%; background-color:#006600; left:0; right:0; top:0px; border:0px solid #006600; border-radius:5px; color:#FFFFFF;  " align="center" >
<div class="myButton2"  style=" margin:2px; margin-left:5px;margin-right:5px; padding:0px; font-size:13px; float:left; border:0px solid #C8EFAD; color:#CC0000 ">
	<a href="#"><?php echo $_SESSION['SES_SIMRS_NAMA_UNIT']; ?></a></div><div style="float:none; "></div></div>
</div>
<div style="margin:2px; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:auto; border:0px solid #999; border-radius:5px; width:100%; float:left; ">
    <table width="85%" border="1" class="tableData" id="tfhover">
        <tr><th colspan="4" style="font-weight:bold; letter-spacing:1px; "><?php echo $_SESSION['SES_SIMRS_NAMA_UNIT']; ?><div id="add"></div>
		</th></tr>				
        <tr align="center" style="font-weight:bold "><td>Nama Pemeriksaan</td>
		<td>Satuan</td>
		<td>Tarif (Rp.)</td>
		<td>Option</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
			<input type="text" name="q" id="penunjang" size="77" class="text_dt" /></td>			
			<td align="center"><a href="#" >tambah</a></td>
		</tr>
    <?php
		$sql_tarif = 'SELECT DISTINCT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif.SATUAN,m_tarif.TARIF_NON_KELAS
					FROM m_tarif 
					WHERE m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" 
					AND m_tarif.ST_AKTIF = "1"
					UNION
					SELECT DISTINCT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif.SATUAN,m_tarif.TARIF_NON_KELAS
					FROM m_tarif 
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" 
					AND m_tarif_group.PENUNJANG = "1"
					AND m_tarif.ST_AKTIF = "1"';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
		while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
			<tr>
				<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
				<td width="90px"><?php echo $dat_tarif['SATUAN']; ?></td>
				<td align="right" width="60px"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
				<td align="center" width="20px"><a href="#" onclick="add_penunjang('<?php echo $_GET['idx']; ?>','<?php echo $dat_tarif['TARIF_ID']; ?>'); return false;" >tambah</a></td>
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