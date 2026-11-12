<?php
$jaminan_id = '';
$nama_jaminan = '';
$aktif = '';
$urut = '';

if (isset($_POST['jaminan_id'])) {
    $jaminan_id = $_POST['jaminan_id'];
    $nama_jaminan = $_POST['nama_jaminan'];
    $urut = $_POST['urut'];
    if (isset($_POST['aktif']))
        $aktif = '1';
    if (!empty($jaminan_id)) {
        mysql_query('UPDATE m_jaminan SET NAMA_JAMINAN = "' . $nama_jaminan . '",URUT = "' . $urut . '",PENDAFTARAN = "' . $aktif . '" WHERE JAMINAN_ID = "' . $jaminan_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_jaminan (NAMA_JAMINAN,URUT,PENDAFTARAN) VALUES ("' . $nama_jaminan . '","' . $urut . '","' . $aktif . '")') or die(mysql_error());
    }
    $jaminan_id = '';
	$nama_jaminan = '';
	$aktif = '';
	$urut = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $jaminan_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_jaminan WHERE JAMINAN_ID = ' . $jaminan_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_jaminan = $dat['NAMA_JAMINAN'];
    $urut = $dat['URUT'];
    $aktif = $dat['PENDAFTARAN'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_jaminan WHERE JAMINAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND m_jaminan.NAMA_JAMINAN LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $user_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $user_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $user_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="jaminan_id" id="jaminan_id" value="<?php echo $jaminan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="500">
        <tr><td>Nama Jaminan</td><td><input name="nama_jaminan" type="text" id="nama_jaminan"  class="text_dt" value="<?php echo $nama_jaminan; ?>" size="33" /></td></tr>
        <tr><td>Urutan</td><td><input name="urut" type="text" id="urut"  class="text_dt" value="<?php echo $urut; ?>" size="10" /></td></tr>
        <tr><td>Aktif&nbsp;&nbsp;<input type="checkbox" name="aktif" value="1" <?php if ($aktif == '1') echo 'checked="checked"'; ?>/></td>
		<td align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>
<br />
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
            <th width="10">Id</th>
			<th>Nama Jaminan</th>
			<th>Urut</th>
			<th>Aktif</th>
			<th>Option</th>
		</tr>
        <?php
        $sql = 'SELECT *,CASE WHEN PENDAFTARAN = "1" THEN "&radic;" END AS AKTIF 
			FROM m_jaminan 
		WHERE 1 ' . $sql_search . ' ORDER BY URUT';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['JAMINAN_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_JAMINAN'] . '</td>';
            echo '<td>' . $dat['URUT'] . '</td>';
            echo '<td align="center">' . $dat['AKTIF'] . '</td>';
            echo '<td align="center" width="100"><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['JAMINAN_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
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