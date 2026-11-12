<?php
$modul_menu_id = '';
$modul_id = '';
$menu_id = '';
$menu_group = 'NULL';
$urut = '';

if (isset($_POST['modul_menu_id'])) {
    $modul_menu_id = $_POST['modul_menu_id'];
    $modul_id = $_POST['modul_id'];
    if(isset($_POST['menu_group'])){
		$menu_group = '"' . $_POST['menu_group'] . '"';
	}
	$urut = $_POST['urut'];
    $menu_id = $_POST['menu_id'];
    if (!empty($modul_menu_id)) {
        mysql_query('UPDATE m_app_modul_menu SET MODUL_ID = "' . $modul_id . '",MENU_ID = "' . $menu_id . '",MENU_GROUP = ' . $menu_group . ',
		URUT = "' . $urut . '" WHERE MODUL_MENU_ID = "' . $modul_menu_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_app_modul_menu (MODUL_ID,MENU_ID,MENU_GROUP,URUT) VALUES ("' . $modul_id . '","' . $menu_id . '",' . $menu_group . ',
		"' . $urut . '")') or die(mysql_error());
    }
    $modul_menu_id = '';
    $menu_id = '';
    $menu_group = '';
	$urut = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $modul_menu_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_app_modul_menu WHERE MODUL_MENU_ID = ' . $modul_menu_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $modul_id = $dat['MODUL_ID'];
    $menu_id = $dat['MENU_ID'];
    $menu_group = $dat['MENU_GROUP'];
	$urut = $dat['URUT'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_app_modul_menu WHERE MODUL_MENU_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE CONCAT(m_app_menu.NAMA_MENU,m_app_modul.NAMA_MODUL) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $modul_menu_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $modul_menu_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $modul_menu_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="modul_menu_id" id="modul_menu_id" value="<?php echo $modul_menu_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table class="tableform" border="0" width="600" >
       <tr><td width="20%">Modul</td><td colspan="2"><select name="modul_id" id="modul_id" class="text_dt" style="width:350px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT * FROM m_app_modul ORDER BY m_app_modul.NAMA_MODUL';
                    $get = mysql_query($sql);
                    while ($dat = mysql_fetch_array($get)) {
                        ?>
                        <option value="<?php echo $dat['MODUL_ID']; ?>" <?php if ($dat['MODUL_ID'] == $modul_id) echo 'selected="selected"'; ?> ><?php echo $dat['NAMA_MODUL']; ?></option>
                    <?php } ?>
                </select></td></tr>
        <tr><td>Menu</td><td colspan="2"><select name="menu_id" id="menu_id" class="text_dt" style="width:350px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT * FROM m_app_menu ORDER BY m_app_menu.NAMA_MENU';
                    $get = mysql_query($sql);
                    while ($dat = mysql_fetch_array($get)) {
                        ?>
                        <option value="<?php echo $dat['MENU_ID']; ?>" <?php if ($dat['MENU_ID'] == $menu_id) echo 'selected="selected"'; ?> ><?php echo $dat['NAMA_MENU']; ?></option>
                    <?php } ?>
                </select></td></tr>
        <tr><td>Kolom Group</td><td><input type="radio" name="menu_group" id="menu_group" value="tr" <?php if ($menu_group == 'tr') echo 'checked="checked"'; ?> />&nbsp;Transaksi
                <input type="radio" name="menu_group" id="menu_group" value="rp" <?php if ($menu_group == 'rp') echo 'checked="checked"'; ?> />&nbsp;Report
                <input type="radio" name="menu_group" id="menu_group" value="tl" <?php if ($menu_group == 'tl') echo 'checked="checked"'; ?> />&nbsp;Utility</td>
        <td align="right">&nbsp;</td></tr>
		 <tr><td>Urut</td><td><input type="text" name="urut" value="<?php echo $urut; ?>" size="10" class="text_dt" /></td>
        <td align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>

<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td colspan="5" align="right">
                <input type="text" name="searchkey" class="text_dt" id="searchkey" value="<?php echo $searchkey; ?>" />&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>	
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="10">Id</th>
			<th width="250">Modul</th>
			<th>Menu</th>
			<th width="100">Menu Group</th>
			<th width="100">Urut</th>
			<th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_app_modul_menu.*,m_app_modul.*,m_app_menu.*
		FROM m_app_modul_menu
		INNER JOIN m_app_modul ON (m_app_modul_menu.MODUL_ID = m_app_modul.MODUL_ID)
		INNER JOIN m_app_menu ON (m_app_modul_menu.MENU_ID = m_app_menu.MENU_ID)' . $sql_search . '
		ORDER BY m_app_modul.NAMA_MODUL,m_app_modul_menu.MENU_GROUP,m_app_modul_menu.URUT';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['MODUL_MENU_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_MODUL'] . '</td>';
            echo '<td>' . $dat['NAMA_MENU'] . '</td>';
            echo '<td align="center">' . $dat['MENU_GROUP'] . '</td>';
			echo '<td align="center">' . $dat['URUT'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['MODUL_MENU_ID'] . '&searchkey=' . $searchkey . '">edit</a>|<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['MODUL_MENU_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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