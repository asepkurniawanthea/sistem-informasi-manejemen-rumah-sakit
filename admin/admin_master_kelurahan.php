<?php
$kelurahan_id = '';
$nama_kelurahan = '';
$kecamatan_id = '';
$kota_id = '';

if (isset($_POST['kelurahan_id'])) {
    $kelurahan_id = $_POST['kelurahan_id'];
    $nama_kelurahan = $_POST['nama_kelurahan'];
    $kecamatan_id = $_POST['kecamatan_id'];
    if (!empty($kelurahan_id)) {
        mysql_query('UPDATE m_kelurahan SET NAMA_KELURAHAN = "' . $nama_kelurahan . '",KECAMATAN_ID = "' . $kecamatan_id . '" WHERE KELURAHAN_ID = "' . $kelurahan_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_kelurahan (NAMA_KELURAHAN,KECAMATAN_ID) VALUES ("' . $nama_kelurahan . '","' . $kecamatan_id . '")') or die(mysql_error());
    }
    $kelurahan_id = '';
    $nama_kelurahan = '';
    $kecamatan_id = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $kelurahan_id = $_GET['ide'];
    $sql = 'SELECT m_kelurahan.*,m_kecamatan.* FROM m_kelurahan 
	INNER JOIN m_kecamatan ON (m_kelurahan.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
	WHERE KELURAHAN_ID = ' . $kelurahan_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_kelurahan = $dat['NAMA_KELURAHAN'];
    $kecamatan_id = $dat['KECAMATAN_ID'];
	$kota_id = $dat['KOTA_ID'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_kelurahan WHERE KELURAHAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE CONCAT(m_kelurahan.NAMA_KELURAHAN, m_kecamatan.NAMA_KECAMATAN) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $kelurahan_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $kelurahan_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $kelurahan_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="kelurahan_id" id="kelurahan_id" value="<?php echo $kelurahan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
   <table class="tableform" border="0" width="250">
        <tr><td>Kelurahan</td>
            <td><input type="text" name="nama_kelurahan" id="nama_kelurahan" value="<?php echo $nama_kelurahan; ?>" class="text_dt" /></td>
        </tr>
		<tr><td>Kota</td>
            <td><select name="kota_id" id="kota_id" class="text_dt" onchange="javascript : MyAjaxRequest('ckecamatan','index.php?ajaxrequest=ckecamatanadmin&kota_id=' + this.value);return false;">
                    <option> - </option>
                    <?php $get_kota = mysql_query('SELECT m_kota.*,m_propinsi.* FROM m_kota 
					INNER JOIN m_propinsi ON (m_kota.PROPINSI_ID = m_propinsi.PROPINSI_ID) 
					ORDER BY NAMA_PROPINSI, NAMA_KOTA');
                    while ($dat_kota = mysql_fetch_array($get_kota)) {
                        ?>
                        <option value="<?php echo $dat_kota['KOTA_ID']; ?>" <?php if ($kota_id == $dat_kota['KOTA_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_kota['NAMA_PROPINSI'] . ' - ' . $dat_kota['NAMA_KOTA']; ?></option>
<?php } ?>
                </select></td>
        </tr>
		<tr><td>Kecamatan</td>
            <td>
			<div id="ckecamatan" >
			<select name="kecamatan_id" id="kecamatan_id" class="text_dt">
                    <option> - </option>
                    <?php
                    $get_kecamatan = mysql_query('SELECT * FROM m_kecamatan ORDER BY KOTA_ID, NAMA_KECAMATAN');
                    while ($dat_kecamatan = mysql_fetch_array($get_kecamatan)) {
                        ?>
                        <option value="<?php echo $dat_kecamatan['KECAMATAN_ID']; ?>" <?php if ($kecamatan_id == $dat_kecamatan['KECAMATAN_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_kecamatan['NAMA_KECAMATAN']; ?></option>
<?php } ?>
                </select></div></td>
        </tr>
        <tr><td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>

<form name="form2" method="post" action="index.php">
     <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <input type="text" name="searchkey" class="text_dt" id="searchkey" value="<?php echo $searchkey; ?>" />&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="10">Id</th><th>Kelurahan</th><th>Kecamatan</th><th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_kelurahan.KELURAHAN_ID, m_kelurahan.NAMA_KELURAHAN,
			m_kelurahan.KECAMATAN_ID, m_kecamatan.NAMA_KECAMATAN, m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
			FROM m_kelurahan
			INNER JOIN m_kecamatan ON (m_kelurahan.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			INNER JOIN m_kota ON (m_kecamatan.KOTA_ID = m_kota.KOTA_ID)
			INNER JOIN m_propinsi ON (m_kota.PROPINSI_ID = m_propinsi.PROPINSI_ID)
			' . $sql_search . 'ORDER BY NAMA_PROPINSI, NAMA_KOTA, NAMA_KECAMATAN, NAMA_KELURAHAN';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['KELURAHAN_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_KELURAHAN'] . '</td>';
            echo '<td>' . $dat['NAMA_PROPINSI'] . ' - ' . $dat['NAMA_KOTA'] . ' - ' . $dat['NAMA_KECAMATAN'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['KELURAHAN_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
        }
        ?>
    </table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
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
		</form>