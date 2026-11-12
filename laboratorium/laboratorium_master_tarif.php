<?php
$group_id_u = '01';
if (isset($_SESSION['rmsearchtarifupdate_group_id_u']))
		$group_id_u = $_SESSION['rmsearchtarifupdate_group_id_u'];

if (isset($_GET['group_id_u'])) {
    $group_id_u = $_GET['group_id_u'];
	$_SESSION['rmsearchtarifupdate_group_id_u'] = $group_id_u;
}
?>
<form name="searchicd" method="get" action="index.php">
    <table class="tableform" border="0" >
		<tr>
            <td>Group Tarif</td>
            <td>
			<?php
			$sql_group = 'SELECT * FROM (
						SELECT "1" AS ORD,m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
						FROM m_tarif_group
						WHERE LABORATORIUM = "1" OR LABORATORIUM_CITO = "1"
						UNION ALL
						SELECT "2" AS ORD,m_tarif.KODE_TARIF AS KODE_TARIF_GROUP,m_tarif.NAMA_TARIF AS NAMA_TARIF_GROUP
						FROM m_tarif
						WHERE m_tarif.KODE_TARIF_GROUP = "120"
						AND ST_AKTIF = "1"
						) t_trf
						ORDER BY ORD,NAMA_TARIF_GROUP';
			$get_group = mysql_query($sql_group) or die(mysql_error());			
			?>
			<select name="group_id_u" class="text_dt" style="width:200px;" >
			<?php while ($dat_group  =  mysql_fetch_array($get_group)){ ?>
				<option value="<?php echo $dat_group['KODE_TARIF_GROUP']; ?>" <?php if($dat_group['KODE_TARIF_GROUP'] == $group_id_u) echo 'selected="selected"'; ?> ><?php echo $dat_group['NAMA_TARIF_GROUP']; ?></option>
			<?php } ?>
			</select></td>
        </tr>
        <tr>
            <td><div id="pr"></div></td>
            <td align="right"><input type="submit" value="tampilkan" class="myButton" />
			<td>&nbsp;</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
if(substr($group_id_u,0,3) == '120'){
	$qry_tindakan = 'SELECT m_tarif.*
				FROM m_tarif 
				WHERE m_tarif.MCU = "1" AND m_tarif.UNIT_ID = "45" ';
	if(!empty($group_id_u)) $qry_tindakan = $qry_tindakan . 'AND m_tarif.KODE_TARIF LIKE "MCU' . $group_id_u . '%"'; 	
}else{
	$qry_tindakan = 'SELECT m_tarif.*
				FROM m_tarif 
				LEFT JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE m_tarif.ST_AKTIF = "1" AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1") ';
	if(!empty($group_id_u)) $qry_tindakan = $qry_tindakan . 'AND m_tarif_group.KODE_TARIF_GROUP = "' . $group_id_u . '"'; 
}

$extparam = '&group_id_u=' . $group_id_u;
$action = '';
include('laboratorium/laboratorium_list_master_tarif.php');
?>
