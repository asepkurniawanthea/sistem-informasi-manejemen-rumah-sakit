<?php
if(isset($_GET['idx']) and isset($_GET['kelas'])){

$search_tarif = '';
if(isset($_GET['grp'])) $search_tarif = $_GET['grp'];
$kelas = $_GET['kelas'];
?>
<script type="text/javascript">
	function add_tindakan_execute(irna_id, tarif_id, kelas){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=kasirformaadtindakanirna&irna_id=' + irna_id + '&tarif_id=' + tarif_id + '&kelas=' + kelas,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				return data;		
			}
		});
	}

    function add_tindakan(irna_id, tarif_id, kelas){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekkasirformaadtindakanirna',
			data: { xirna_id : irna_id, xtarif_id : tarif_id},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data == 0){
						rtr = add_tindakan_execute(irna_id, tarif_id, kelas);
						setTimeout(opener.location.reload(), 5000);
					}else{
						if(confirm('Item Sudah Ada. Tambah Item ?')){
							rtr = add_tindakan_execute(irna_id, tarif_id, kelas)
							setTimeout(opener.location.reload(), 5000);
						}else{
							opener.location.reload();
						}	
					}
				}	
			}
		});
	}
	
	function add_tindakan_execute_auto(irna_id, tarif_id, kelas){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=kasirformaadtindakanirnaauto&irna_id=' + irna_id + '&tarif_id=' + tarif_id + '&kelas=' + kelas,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				return data;		
			}
		});
	}

	function add_tindakan_autocomp(irna_id, tarif_id, kelas){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekkasirformaadtindakanirnaauto',
			data: { xirna_id : irna_id, xtarif_id : tarif_id},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data == 0){
						rtr = add_tindakan_execute_auto(irna_id, tarif_id, kelas);
						document.getElementById('tindakan').value = '';
						setTimeout(opener.location.reload(), 5000);
					}else{
						if(confirm('Item Sudah Ada. Tambah Item ?')){
							rtr = add_tindakan_execute_auto(irna_id, tarif_id, kelas)
							document.getElementById('tindakan').value = '';
							setTimeout(opener.location.reload(), 5000);
						}else{
							opener.location.reload();
						}	
					}
				}	
			}
		});
    }
	
	jQuery(document).ready(function() {
        jQuery("#tindakan").autocomplete("index.php?autocomp=autocompkasirtindakanirna&kelas=<?php echo $kelas; ?>",{width: 550});
    });
</script>
<body>
<style>
a{ color:#FFFFFF;}
</style>

<div style="margin:2px; float:left; padding:5px; padding-left:5px; padding-right:5px; width:100%; background-color:#006600; left:0; right:0; top:0px; border:1px solid #999; border-radius:5px; color:#FFFFFF;  " align="center" >
<?php
$sql_group_tarif = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.LABORATORIUM,m_tarif_group.LABORATORIUM_CITO,
					m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
					m_tarif_group.REHABILITASI_MEDIK
					FROM m_tarif_group
					WHERE m_tarif_group.NON_KELAS IS NULL OR m_tarif_group.IRNA = "1"
					ORDER BY m_tarif_group.NON_KELAS,m_tarif_group.KODE_TARIF_GROUP';
				
$get_group_tarif = mysql_query($sql_group_tarif) or die(mysql_error());	
while ($dat_tarif_group = mysql_fetch_array($get_group_tarif)){
?>
	<div class="myButton2"  style=" margin:2px; margin-left:5px;margin-right:5px; padding:0px; font-size:13px; float:left; border:0px solid #C8EFAD; color:#CC0000 ">
	<a href="<?php echo currentURL(); ?>&grp=<?php echo $dat_tarif_group['KODE_TARIF_GROUP']; ?>&nm=<?if($dat_tarif_group['LABORATORIUM'] == '1' or $dat_tarif_group['LABORATORIUM_CITO'] == '1') echo 'LABORATORIUM - '; if($dat_tarif_group['RADIOLOGI'] == '1' or $dat_tarif_group['RADIOLOGI_CITO'] == '1') echo 'RADIOLOGI - '; if($dat_tarif_group['REHABILITASI_MEDIK'] == '1') echo 'REHABILITASI MEDIK - ';  ?>
	<?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?>"><?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?></a></div><div style="float:none; "></div>
<?php
}
?>
</div>

<div style="margin:2px; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:auto; border:1px solid #999; border-radius:5px; width:100%; float:left; ">

<? if(isset($_GET['grp'])){ ?>
    <table width="100%" border="1" class="tableData" id="tfhover" align="center">
        <tr><th colspan="4" style="font-weight:bold; letter-spacing:1px; ">
			<?php
				$nama_tarif =$_GET['grp'];
				$sql_tarif1 = 'SELECT NAMA_TARIF_GROUP from m_tarif_group where KODE_TARIF_GROUP = "' . $nama_tarif . '"';
				$get_group_tarif1 = mysql_query($sql_tarif1) or die(mysql_error());	
				$dat_tarif_group1 = mysql_fetch_array($get_group_tarif1);
				if (!isset($_GET['nm'])){
					echo strtoupper($dat_tarif_group1['NAMA_TARIF_GROUP']);
				} else {
					echo strtoupper($_GET['nm']); 
				}
			?>
			<div id="add"></div>
		</th></tr>				
        <tr align="center" style="font-weight:bold "><td>Nama Tindakan</td>
		<td>Satuan</td>
		<td>Tarif (Rp.)</td>
		<td>Option</td>
		</tr>
		<tr>
			<td colspan="3" align="center"><input type="text" name="q" id="tindakan" size="77" class="text_dt" /></td><td align="center" ><a href="#" onclick="add_tindakan_autocomp('<?php echo $_GET['idx']; ?>',document.getElementById('tindakan').value,'<?php echo $kelas; ?>'); return false;" >tambah</a></td>
		</tr>
    <?php
		$field = 'NULL';
		if(strtoupper($kelas) == '3') $field = 'm_tarif.TARIF_KELAS_3';
		if(strtoupper($kelas) == '2') $field = 'm_tarif.TARIF_KELAS_2';
		if(strtoupper($kelas) == '1') $field = 'm_tarif.TARIF_KELAS_1';
		if(strtoupper($kelas) == 'UTAMA') $field = 'm_tarif.TARIF_KELAS_UTAMA';
		if(strtoupper($kelas) == 'VIP') $field = 'm_tarif.TARIF_KELAS_UTAMA';
		if(strtoupper($kelas) == 'UTAMA 2') $field = 'm_tarif.TARIF_KELAS_UTAMA_2';
		if(strtoupper($kelas) == 'VVIP') $field = 'm_tarif.TARIF_KELAS_UTAMA_2';
		if(strtoupper($kelas) == 'HCU') $field = 'm_tarif.TARIF_HCU';
		if(strtoupper($kelas) == 'ICU') $field = 'm_tarif.TARIF_ICU';
		if(strtoupper($kelas) == 'NICU') $field = 'm_tarif.TARIF_NICU';
		if(strtoupper($kelas) == 'PICU') $field = 'm_tarif.TARIF_PICU';
		if(strtoupper($kelas) == 'ICCU') $field = 'm_tarif.TARIF_ICCU';
		if(strtoupper($kelas) == 'PERINA') $field = 'm_tarif.TARIF_PERINA';
		if(strtoupper($kelas) == 'BAYI SEHAT') $field = 'm_tarif.TARIF_KELAS_PERINA_SEHAT';
		if(strtoupper($kelas) == 'BAYI SAKIT') $field = 'm_tarif.TARIF_KELAS_PERINA_SAKIT';
		
		$sql_tarif = 'SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif.SATUAN,' . $field . ' AS TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif_group.NON_KELAS
					FROM m_tarif 
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE m_tarif.KODE_TARIF_GROUP = "' . $search_tarif . '"  
					AND m_tarif.ST_AKTIF = "1"';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
		while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
			<tr>
				<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
				<td width="90px"><?php echo $dat_tarif['SATUAN']; ?></td>
				<td align="right" width="60px"><?php if($dat_tarif['NON_KELAS'] == '1'){
														echo currFormat($dat_tarif['TARIF_NON_KELAS']);
													}else{
														echo currFormat($dat_tarif['TARIF']);
													} ?></td>
				<td align="center" width="20px"><a href="#" onclick="add_tindakan('<?php echo $_GET['idx']; ?>','<?php echo $dat_tarif['TARIF_ID']; ?>','<?php echo $kelas; ?>'); return false;" >tambah</a></td>
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
<?php }?>
</div>
<?php } ?>