<?php
$search_tarif = '';
if(isset($_GET['grp'])) $search_tarif = $_GET['grp'];
?>
<script type="text/javascript">
    function add_radiologi_execute(irja_id, tarif_id){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=klinikformaadradiologi&irja_id=' + irja_id + '&tarif_id=' + tarif_id,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				return data;		
			}
		});
	}

    function add_radiologi(irja_id, tarif_id){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekklinikformaadradiologi',
			data: { xirja_id : irja_id, xtarif_id : tarif_id},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data == 0){
						rtr = add_radiologi_execute(irja_id, tarif_id);
						setTimeout(opener.location.reload(), 5000);
					}else{
						if(confirm('Item Sudah Ada. Tambah Item ?')){
							rtr = add_radiologi_execute(irja_id, tarif_id)
							setTimeout(opener.location.reload(), 5000);
						}else{
							opener.location.reload();
						}	
					}
				}	
			}
		});
	}

	function add_radiologi_autocomp(irja_id, tarif_id){
      javascript : MyAjaxRequest('add','index.php?ajaxrequest=klinikformaadradiologiauto&irja_id=' + irja_id + '&tarif_id=' + tarif_id);
	  document.getElementById('radiologi').value = '';
	  setTimeout(opener.location.reload(), 5000);
    }
	
	jQuery(document).ready(function() {
        jQuery("#radiologi").autocomplete("index.php?autocomp=autocompklinikradiologi",{width: 490});
    });
</script>
<body>

<div style="margin:2px; float:left; padding:5px; padding-left:10px; padding-right:10px; width:100%; background-color:#006600; left:0; right:0; top:0px; border:0px solid #006600; border-radius:5px; color:#FFFFFF;  " align="center" >
<?php
if(currentModul() == 'igd'){
$sql_group_tarif = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
					FROM m_tarif_group
					WHERE m_tarif_group.RADIOLOGI = "1"
					OR m_tarif_group.RADIOLOGI_CITO = "1"
					ORDER BY m_tarif_group.NAMA_TARIF_GROUP';
}else{
$sql_group_tarif = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
					FROM m_tarif_group
					WHERE m_tarif_group.RADIOLOGI = "1"
					OR m_tarif_group.RADIOLOGI_CITO = "1"
					ORDER BY m_tarif_group.NAMA_TARIF_GROUP';
}					
$get_group_tarif = mysql_query($sql_group_tarif) or die(mysql_error());	
while ($dat_tarif_group = mysql_fetch_array($get_group_tarif)){
?>
	<div class="myButton2"  style=" margin:2px; margin-left:5px;margin-right:5px; padding:0px; font-size:13px; float:left; border:0px solid #C8EFAD; color:#CC0000 ">
	<a href="<?php echo currentURL(); ?>&grp=<?php echo $dat_tarif_group['KODE_TARIF_GROUP']; ?>&nm=<?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?>"><?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?></a></div><div style="float:none; "></div>
<?php
}
?>
</div>
<div style="margin:2px; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:auto; border:0px solid #999; border-radius:5px; width:100%; float:left; ">

<? if(isset($_GET['grp'])){ ?>
    <table width="100%" border="1" class="tableData" id="tfhover">
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
        <tr align="center" style="font-weight:bold "><td>Nama Poto</td>
		<td>Satuan</td>
		<td>Tarif (Rp.)</td>
		<td>Option</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
			<input type="text" name="q" id="radiologi" size="77" class="text_dt" /></td>			
			<td align="center"><a href="#" onclick="add_radiologi_autocomp('<?php echo $_GET['idx']; ?>',document.getElementById('radiologi').value); return false;" >tambah</a></td>
		</tr>
    <?php
		$sql_tarif = 'SELECT DISTINCT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,m_tarif.TARIF_NON_KELAS,
					m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,m_tarif.TDK_KLAIM
					FROM m_tarif 
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE m_tarif.KODE_TARIF_GROUP = "' . $search_tarif . '"  
					AND m_tarif.ST_AKTIF = "1"';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
		while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
			<tr>
				<td><?php echo $dat_tarif['NAMA_TARIF'] . (($dat_tarif['TDK_KLAIM'] == '1') ? '&nbsp;<strong>(Tidak Diklaim)</strong>' : ''); ?></td>
				<td width="90px"><?php echo $dat_tarif['SATUAN']; ?></td>
				<td align="right" width="60px"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
				<td align="center" width="20px"><a href="#" onclick="add_radiologi('<?php echo $_GET['idx']; ?>','<?php echo $dat_tarif['TARIF_ID']; ?>'); return false;" >tambah</a></td>
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