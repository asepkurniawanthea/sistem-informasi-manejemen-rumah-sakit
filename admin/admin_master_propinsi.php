<?php
$propinsi_id = '';
$nama_propinsi = '';

if (isset($_POST['propinsi_id'])) {
    $propinsi_id = $_POST['propinsi_id'];
    $nama_propinsi = $_POST['nama_propinsi'];
    if (!empty($propinsi_id)) {
        mysql_query('UPDATE m_propinsi SET NAMA_PROPINSI = "' . $nama_propinsi . '" WHERE PROPINSI_ID = "' . $propinsi_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_propinsi (NAMA_PROPINSI) VALUES ("' . $nama_propinsi . '")') or die(mysql_error());
    }
    $propinsi_id = '';
    $nama_propinsi = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $propinsi_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_propinsi WHERE PROPINSI_ID = ' . $propinsi_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_propinsi = $dat['NAMA_PROPINSI'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_propinsi WHERE PROPINSI_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE m_propinsi.NAMA_PROPINSI LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $propinsi_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $propinsi_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $propinsi_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="propinsi_id" id="propinsi_id" value="<?php echo $propinsi_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table class="tableform" border="0" width="250">
        <tr><td>Propinsi</td>
            <td><input type="text" name="nama_propinsi" id="nama_propinsi" value="<?php echo $nama_propinsi; ?>" class="text_dt" size="30" /></td>
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
            <th width="10">Id</th><th>Propinsi</th><th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_propinsi.PROPINSI_ID,m_propinsi.NAMA_PROPINSI
				FROM m_propinsi ' . $sql_search . 'ORDER BY NAMA_PROPINSI';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['PROPINSI_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_PROPINSI'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['PROPINSI_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
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