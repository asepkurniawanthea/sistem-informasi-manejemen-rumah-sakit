<?php
$group_id_u = '01';
if (isset($_SESSION['rmsearchtarifupdate_group_id_u']))
		$group_id_u = $_SESSION['rmsearchtarifupdate_group_id_u'];

if (isset($_GET['group_id_u'])) {
    $group_id_u = $_GET['group_id_u'];
	$_SESSION['rmsearchtarifupdate_group_id_u'] = $group_id_u;
}

$nama_tarif_u = '';
if (isset($_SESSION['rmsearchtarifupdate_nama_tarif_u']))
		$nama_tarif_u = $_SESSION['rmsearchtarifupdate_nama_tarif_u'];

if (isset($_GET['nama_tarif_u'])) {
    $nama_tarif_u = $_GET['nama_tarif_u'];
	$_SESSION['rmsearchtarifupdate_nama_tarif_u'] = $nama_tarif_u;
}

$arr_group_tarif = getArrayTarifGroup();
?>
<form name="searchicd" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
			<td>Nama Tarif/ Kode</td>
			<td><input type="text" name="nama_tarif_u" value="<?php echo $nama_tarif_u; ?>" class="text_dt" style="width:200px;" /></td>
		</tr>
		<tr>
            <td>Group Tindakan</td>
            <td><select name="group_id_u" class="text_dt" style="width:200px;" >
			<?php foreach ($arr_group_tarif  as $key => $arr){ ?>
				<option value="<?php echo $key; ?>" <?php if($key == $group_id_u) echo 'selected="selected"'; ?> ><?php echo $arr; ?></option>
			<?php } ?>
			</select></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
$qry_tindakan = 'SELECT m_tarif.*,m_tarif_group.NAMA_TARIF_GROUP
				FROM m_tarif 
				LEFT JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE m_tarif.ST_AKTIF = "1" '; 
if(!empty($nama_tarif_u)) $qry_tindakan = $qry_tindakan . 'AND CONCAT(m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF) LIKE "%' . $nama_tarif_u . '%"'; 
if(!empty($group_id_u)) $qry_tindakan = $qry_tindakan . 'AND m_tarif_group.KODE_TARIF_GROUP = "' . $group_id_u . '"'; 

$extparam = '&group_id_u=' . $group_id_u . '&nama_tarif_u=' . $nama_tarif_u;
$action = '';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama Tarif</th>
		<th>Group</th>
		<th>Non_Kelas</th>
		<th>Kelas_3</th>
		<th>Kelas_2</th>
		<th>Kelas_1</th>
		<th>Kelas_Utama<br />(VIP)</th>
		<th>Kelas_Utama_2<br />(VVIP)</th>
		<th>HCU</th>
		<th>ICU</th>
		<th>NICU</th>
		<th>PICU</th>
		<th>ICCU</th>
		<th>Perina</th>
		<th>Perina_Sehat</th>
		<th>Perina_Sakit</th>
    </tr>
<?php	
 $no = 0;
 $pager = new PS_Pagination($connect, $qry_tindakan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
 $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['TARIF_ID'];
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center"><?php echo $data['KODE_TARIF']; ?></td>
			<td><?php echo $data['NAMA_TARIF']; ?></td>
			<td><?php echo $data['NAMA_TARIF_GROUP']; ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_NON_KELAS']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_3']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_2']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_1']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_UTAMA']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_UTAMA_2']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_HCU']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_ICU']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_NICU']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_PICU']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_ICCU']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_PERINA']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_PERINA_SEHAT']); ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_KELAS_PERINA_SAKIT']); ?></td>
	</tr>		
	<?php } ?>			
</table>		
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="midfle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>	