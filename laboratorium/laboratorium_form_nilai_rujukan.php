<?php
$pemeriksaan_group = 'Hematologi';
if (isset($_SESSION['labgroupperiksa_pemeriksaan_group']))
		$pemeriksaan_group = $_SESSION['labgroupperiksa_pemeriksaan_group'];

if (isset($_GET['pemeriksaan_group'])) {
    $pemeriksaan_group = $_GET['pemeriksaan_group'];
	$_SESSION['labgroupperiksa_pemeriksaan_group'] = $pemeriksaan_group;
}

$pemeriksaan = 'Hemoglobin (Hb)';
if (isset($_SESSION['labgroupperiksa_pemeriksaan']))
		$pemeriksaan = $_SESSION['labgroupperiksa_pemeriksaan'];

if (isset($_GET['pemeriksaan'])) {
    $pemeriksaan = $_GET['pemeriksaan'];
	$_SESSION['labgroupperiksa_pemeriksaan'] = $pemeriksaan;
}

if(isset($_GET['add'])){
?>
	<script language="JavaScript" >
        window.location = "index.php?link=<?php echo md5('laboratoriumformaddnilairujukan'); ?>&pemeriksaan_group=<?php echo $pemeriksaan_group; ?>&pemeriksaan=<?php echo $pemeriksaan; ?>";
    </script> 
<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_nilai_rujukan_laboratorium WHERE NILAI_RUJUKAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

if (isset($_GET['idd'])) {
    $nilai_rujukan = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $nilai_rujukan; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $nilai_rujukan; ?>";
        }
    </script>
    <?php
}
?>
<form name="searchicd" method="get" >
    <table class="tableform" border="0" >
        <tr>
            <td>Group Pemeriksaan</td>
            <td><select name="pemeriksaan_group" id="pemeriksaan_group" class="text_dt" onchange="javascript: MyAjaxRequest('sl_pemeriksaan','index.php?ajaxrequest=pemeriksaanlab&group=' + this.value);return false;">
			<?php
			$sql_group = 'SELECT DISTINCT CH_REPORT FROM m_tarif_pemeriksaan WHERE LENGTH(CH_REPORT) > 0';
			$get_group = mysql_query($sql_group) or die(mysql_error());
			while($dat_group = mysql_fetch_array($get_group)){ ?>
				<option value="<?php echo $dat_group['CH_REPORT']; ?>" <?php if($dat_group['CH_REPORT'] == $pemeriksaan_group) echo 'selected="selected"'; ?>  
				><?php echo $dat_group['CH_REPORT']; ?></option>
			<?php } ?>
			</select></td>
        </tr>
		<tr>
            <td>Pemeriksaan</td>
            <td><div id="sl_pemeriksaan" >
			<select name="pemeriksaan" class="text_dt" onchange="javascript: MyAjaxRequest('itm_pemeriksaan','index.php?ajaxrequest=itempemeriksaanlab&group=' + document.getElementById('pemeriksaan_group').value + '&periksa=' + this.value);return false;">
			<?php
			$sql_pemeriksaan = 'SELECT DISTINCT CONCAT(NAMA_PEMERIKSAAN_GROUP," ",NAMA_PEMERIKSAAN) AS NAMA_PEMERIKSAAN  FROM m_tarif_pemeriksaan WHERE CH_REPORT = "' . $pemeriksaan_group . '"';
			$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
			while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){ ?>
				<option value="<?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?>" <?php if($dat_pemeriksaan['NAMA_PEMERIKSAAN'] == $pemeriksaan) echo 'selected="selected"'; ?>  
				><?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?></option>
			<?php } ?>
			</select></div></td>
        </tr>
        <tr>
            <td><div id="pr"></div></td>
            <td align="right"><input type="submit" name="add" value="tambah nilai rujukan" class="myButton" />
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
$qry_rujukan = 'SELECT m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID,m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,m_nilai_rujukan_laboratorium.UMUR_HARI,
				m_nilai_rujukan_laboratorium.NILAI_RUJUKAN,m_nilai_rujukan_laboratorium.JNS_KELAMIN_LK,
				m_nilai_rujukan_laboratorium.JNS_KELAMIN_PR,m_nilai_rujukan_laboratorium.SATUAN,
				m_nilai_rujukan_laboratorium.CH_REPORT,m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN,
				m_nilai_rujukan_laboratorium.METHODE,m_nilai_rujukan_laboratorium.LABEL_UMUR
				FROM m_nilai_rujukan_laboratorium
				WHERE m_nilai_rujukan_laboratorium.CH_REPORT = "' . $pemeriksaan_group . '"
				AND m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN = "' . $pemeriksaan . '"
				ORDER BY m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,m_nilai_rujukan_laboratorium.UMUR_HARI';
$get_rujukan = mysql_query($qry_rujukan) or die(mysql_error());
?>
<div id="itm_pemeriksaan" >
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Keterangan Umur</th>
		<th>Umur Tahun</th>
        <th>Umur Bulan</th>
		<th>Umur Hari</th>
		<th>Laki-laki</th>
		<th>Perempuan</th>
		<th>Satuan</th>
		<th>Nilai Rujukan</th>
		<th>Methode</th>
		<th>Option</th>
    </tr>
    <?
    $no = 1;
    while ($dat_rujukan = mysql_fetch_array($get_rujukan)) {
        $id = $dat_rujukan['NILAI_RUJUKAN_ID'];
        ?>
        <tr>
            <td width="20" align="center"><?php echo $no; ?></td>
			<td><?php echo $dat_rujukan['LABEL_UMUR']; ?></td>
            <td align="right"><?php echo $dat_rujukan['UMUR_TAHUN']; ?></td>
			<td align="right"><?php echo $dat_rujukan['UMUR_BULAN']; ?></td>
			<td align="right"><?php echo $dat_rujukan['UMUR_HARI']; ?></td>
			<td align="center"><?php if($dat_rujukan['JNS_KELAMIN_LK'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_rujukan['JNS_KELAMIN_PR'] == '1') echo '&radic;'; ?></td>
			<td><?php echo $dat_rujukan['SATUAN']; ?></td>
			<td><?php echo $dat_rujukan['NILAI_RUJUKAN']; ?></td>
			<td><?php echo $dat_rujukan['METHODE']; ?></td>
			<td width="80" align="center"><a href="index.php?link=<?php echo md5('laboratoriumformaddnilairujukan'); ?>&idx=<?php echo $id; ?>&pemeriksaan_group=<?php echo $dat_rujukan['CH_REPORT']; ?>&pemeriksaan=<?php echo $dat_rujukan['NAMA_PEMERIKSAAN']; ?>">edit</a>
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idd=<?php echo $id; ?>">hapus</a></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
</div>
<br />
<a href="#" style="color:#FF0000; " onclick="window.open('/nsimrs/manual/manual-laboratorium-nilai_rujukan.pdf');"><i>* download manual pengisian nilai rujukan</i></a> 