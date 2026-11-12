<?php
$search_tarif = '';
if(isset($_GET['grp'])) $search_tarif = $_GET['grp'];
?>
<script type="text/javascript">
    function add_laboratorium(irja_id, tarif_id){
      javascript : MyAjaxRequest('add','index.php?ajaxrequest=laboratoriumformaadperiksa&penunjang_id=' + irja_id + '&tarif_id=' + tarif_id);
	  opener.location.reload();
    }
	function add_laboratorium_autocomp(irja_id, tarif_id){
      javascript : MyAjaxRequest('add','index.php?ajaxrequest=laboratoriumformaadperiksauto&penunjang_id=' + irja_id + '&tarif_id=' + tarif_id);
	  document.getElementById('laboratorium').value = '';
	  opener.location.reload();
    }
	jQuery(document).ready(function() {
        jQuery("#laboratorium").autocomplete("index.php?autocomp=autocompkliniklaboratorium",{width: 490});
    });
</script>
<body>
<style>
a{ color:#FFFFFF;}
</style>
<div style="margin:2px; position:absolute; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:0px; border:1px solid #999; border-radius:5px; color:#FFFFFF; " align="center" >
<?php
$sql_group_tarif = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
					FROM m_tarif_group
					WHERE m_tarif_group.LABORATORIUM = "1"
					OR m_tarif_group.LABORATORIUM_CITO = "1"
					ORDER BY m_tarif_group.KODE_TARIF_GROUP';	
$get_group_tarif = mysql_query($sql_group_tarif) or die(mysql_error());	
while ($dat_tarif_group = mysql_fetch_array($get_group_tarif)){
?>
	<div class="myButton1"  style=" margin:2px; margin-left:2px;margin-right:2px; padding:2px; font-size:13px; float:left ">
	<a href="<?php echo currentURL(); ?>&grp=<?php echo $dat_tarif_group['KODE_TARIF_GROUP']; ?>&nm=<?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?>"><font color="#FFF"><?php echo $dat_tarif_group['NAMA_TARIF_GROUP']; ?></font></a></div><div style="float:none; "></div>
<?php
}
?>
</div>
<div style="margin:2px; position:absolute; padding:5px; padding-left:5px; padding-right:5px; background-color:#C8EFAD; left:0; right:0; top:175px; border:1px solid #999; border-radius:5px; ">

<? if(isset($_GET['grp'])){ ?>
    <table width="85%" border="1" class="tableData" id="tfhover">
        <tr><th colspan="3" style="font-weight:bold; letter-spacing:1px; ">
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
        <tr align="center" style="font-weight:bold "><td>Nama Pemeriksaan</td>
		<td>Tarif (Rp.)</td>
		<td>Option</td>
		</tr>
		<tr>
			<td colspan="2" align="left">
			<input type="text" name="q" id="laboratorium" size="77" class="text_dt" /></td>			
			<td align="center"><a href="#" onclick="add_laboratorium_autocomp('<?php echo $_GET['idx']; ?>',document.getElementById('laboratorium').value); return false;" >tambah</a></td>
		</tr>
    <?php
		$sql_tarif = 'SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif.SATUAN,m_tarif.TARIF_NON_KELAS
					FROM m_tarif WHERE m_tarif.KODE_TARIF_GROUP = "' . $search_tarif . '"  
					AND m_tarif.ST_AKTIF = "1"';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
		while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
			<tr>
				<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
				<td align="right" width="80px"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
				<td align="center" width="20px"><a href="#" onclick="add_laboratorium('<?php echo $_GET['idx']; ?>','<?php echo $dat_tarif['TARIF_ID']; ?>'); return false;" >tambah</a></td>
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