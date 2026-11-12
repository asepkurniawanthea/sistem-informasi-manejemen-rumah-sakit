<?php
$kota_id = '';
$nama_kota = '';
$propinsi_id = '';

if (isset($_POST['kota_id'])) {
    $kota_id = $_POST['kota_id'];
    $nama_kota = $_POST['nama_kota'];
    $propinsi_id = $_POST['propinsi_id'];
    if (!empty($kota_id)) {
        mysql_query('UPDATE m_kota SET NAMA_KOTA = "' . $nama_kota . '",PROPINSI_ID = "' . $propinsi_id . '" WHERE KOTA_ID = "' . $kota_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_kota (NAMA_KOTA,PROPINSI_ID) VALUES ("' . $nama_kota . '","' . $propinsi_id . '")') or die(mysql_error());
    }
    $kota_id = '';
    $nama_kota = '';
    $propinsi_id = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $kota_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_kota WHERE KOTA_ID = ' . $kota_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_kota = $dat['NAMA_KOTA'];
    $propinsi_id = $dat['PROPINSI_ID'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_kota WHERE KOTA_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE CONCAT(m_kota.NAMA_KOTA, m_propinsi.NAMA_PROPINSI) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $kota_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $kota_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $kota_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="kota_id" id="kota_id" value="<?php echo $kota_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table class="tableform" border="0" width="250">
        <tr><td>Kota</td>
            <td><input type="text" name="nama_kota" id="nama_kota" value="<?php echo $nama_kota; ?>" class="text_dt" size="30" /></td>
        </tr><tr><td>Propinsi</td>
            <td><select name="propinsi_id" id="propinsi_id" class="text_dt">
                    <option> - </option>
                    <?php $get_prop = mysql_query('SELECT * FROM m_propinsi ORDER BY NAMA_PROPINSI');
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['PROPINSI_ID']; ?>" <?php if ($propinsi_id == $dat_prop['PROPINSI_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['NAMA_PROPINSI']; ?></option>
<?php } ?>
                </select></td>
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
            <th width="10">Id</th><th>Kota</th><th>Propinsi</th><th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_kota.KOTA_ID,m_kota.NAMA_KOTA,m_kota.PROPINSI_ID,m_propinsi.NAMA_PROPINSI
				FROM m_kota
				INNER JOIN m_propinsi ON (m_kota.PROPINSI_ID = m_propinsi.PROPINSI_ID)' . $sql_search . 'ORDER BY NAMA_PROPINSI, NAMA_KOTA';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['KOTA_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_KOTA'] . '</td>';
            echo '<td>' . $dat['NAMA_PROPINSI'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['KOTA_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
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