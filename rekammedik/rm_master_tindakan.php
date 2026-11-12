<?php
$group_id = '03';
if (isset($_SESSION['rmsearchtindakan_group_id']))
		$group_id = $_SESSION['rmsearchtindakan_group_id'];

if (isset($_GET['group_id'])) {
    $group_id = $_GET['group_id'];
	$_SESSION['rmsearchtindakan_group_id'] = $group_id;
}

if(isset($_POST['cnr']))
include('rekammedik/rm_save_icd_tindakan.php');
?>
<form name="searchicd" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Group Tindakan</td>
            <td><select name="group_id" class="text_dt" >
			<?php
			$sql_group = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
						FROM m_tarif_group';
			$get_group = mysql_query($sql_group) or die(mysql_error());
			while($dat_group = mysql_fetch_array($get_group)){ ?>
				<option value="<?php echo $dat_group['KODE_TARIF_GROUP']; ?>" <?php if($dat_group['KODE_TARIF_GROUP'] == $group_id) echo 'selected="selected"'; ?>  
				><?php echo $dat_group['NAMA_TARIF_GROUP']; ?></option>
			<?php } ?>
			</select></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			<input type="button" value="simpan" class="myButton" onclick="document.getElementById('formx').submit();"/>
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
$qry_tindakan = 'SELECT m_tarif.TARIF_ID,m_tarif_group.REHABILITASI_MEDIK,m_tarif_group.KAMAR_OPERASI,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
				m_tarif_group.KODE_TARIF_GROUP,m_tarif.ICD_CODE,m_tarif.USER_RM,m_tarif.ST_AKTIF,
				m_tarif_group.LABORATORIUM,m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO
				FROM m_tarif_group
				INNER JOIN m_tarif ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE m_tarif_group.KODE_TARIF_GROUP = "' . $group_id . '"
				AND m_tarif.ST_AKTIF = "1"';

$extparam = '&group_id=' . $group_id;
$action = '';
include('rekammedik/rm_list_master_tindakan.php');
?>
