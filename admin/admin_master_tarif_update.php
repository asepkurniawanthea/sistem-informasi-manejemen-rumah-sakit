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

$tahun = date('Y');
if (isset($_SESSION['rmsearchtarifupdate_tahun']))
		$tahun = $_SESSION['rmsearchtarifupdate_tahun'];

if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
	$_SESSION['rmsearchtarifupdate_tahun'] = $tahun;
}

$arr_group_tarif = getArrayTarifGroup();

if(isset($_POST['cnr']))
include('admin/admin_save_tarif_update.php');
?>
<form name="searchicd" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
			<td>Nama Tarif/ Kode</td>
			<td><input type="text" name="nama_tarif_u" value="<?php echo $nama_tarif_u; ?>" class="text_dt" style="width:200px;" /></td>
		</tr>
		<tr>
            <td>Group</td>
            <td><select name="group_id_u" class="text_dt" style="width:200px;" >
			<?php foreach ($arr_group_tarif  as $key => $arr){ ?>
				<option value="<?php echo $key; ?>" <?php if($key == $group_id_u) echo 'selected="selected"'; ?> ><?php echo $arr; ?></option>
			<?php } ?>
			</select></td>
        </tr>
		<tr>
            <td>Tahun</td>
            <td><select name="tahun" id="tahun" class="text_dt" style="width:100px;">
				<option value="2014" <?php if($tahun == '2014') echo 'selected="selected"'; ?> >2014</option>
				<option value="2015" <?php if($tahun == '2015') echo 'selected="selected"'; ?> >2015</option>
				<option value="2016" <?php if($tahun == '2016') echo 'selected="selected"'; ?> >2016</option>
				<option value="2017" <?php if($tahun == '2017') echo 'selected="selected"'; ?> >2017</option>
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
				<option value="2021" <?php if($tahun == '2021') echo 'selected="selected"'; ?> >2021</option>
				<option value="2022" <?php if($tahun == '2022') echo 'selected="selected"'; ?> >2022</option>
				<option value="2023" <?php if($tahun == '2023') echo 'selected="selected"'; ?> >2023</option>
				<option value="2024" <?php if($tahun == '2024') echo 'selected="selected"'; ?> >2024</option>
			</select></td>
        </tr>
        <tr>
            <td><div id="pr"></div></td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			<!--<input type="button" value="tambah tarif" class="myButton" onclick="javascript : if(confirm('Tambah Tarif?')){ MyAjaxRequest('pr','index.php?ajaxrequest=tambahtarif&tahun=' + document.getElementById('tahun').value);return false; }"/>-->
			<!--<input type="button" value="aktifkan" class="myButton" onclick="javascript : if(confirm('Aktifkan Tarif?')){ MyAjaxRequest('pr','index.php?ajaxrequest=aktifkantarif&tahun=' + document.getElementById('tahun').value);return false; }"/>
			<input type="button" value="simpan" class="myButton" onclick="javascript : if(confirm('Simpan Update?')){ document.getElementById('formx').submit(); }"/>-->
			<input type="button" value="tambah tarif" class="myButton" onclick="tambah_tarif();" /> 
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
$qry_tindakan = 'SELECT m_tarif.*,m_tarif_group.NAMA_TARIF_GROUP
				FROM m_tarif 
				LEFT JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE m_tarif.TAHUN_UPDATE = "' . $tahun . '" '; 
if(!empty($nama_tarif_u)) $qry_tindakan = $qry_tindakan . 'AND CONCAT(m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF) LIKE "%' . $nama_tarif_u . '%" '; 
if(!empty($group_id_u)) $qry_tindakan = $qry_tindakan . 'AND m_tarif_group.KODE_TARIF_GROUP = "' . $group_id_u . '" '; 
$qry_tindakan = $qry_tindakan . 'ORDER BY m_tarif.KODE_TARIF';

$extparam = '&group_id_u=' . $group_id_u . '&nama_tarif_u=' . $nama_tarif_u;
$action = '';
include('admin/admin_list_master_tarif_update.php');
?>
