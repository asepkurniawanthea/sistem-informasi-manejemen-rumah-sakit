<?php
$menu_id = '';
$nama_menu = '';
$link_id = '';
$icon_file = '';
$nama_file = '';
$st_tampilkan = '';
$judul_menu = '';
$admin = '';
$param = '';
if (isset($_POST['menu_id'])) {
    $menu_id = $_POST['menu_id'];
    $nama_menu = $_POST['nama_menu'];
    $link_id = $_POST['link_id'];
    $icon_file = $_POST['icon_file'];
    $nama_file = $_POST['nama_file'];
    $judul_menu = $_POST['judul_menu'];
    if (isset($_POST['st_tampilkan'])) {
        $st_tampilkan = '1';
    } else {
        $st_tampilkan = '0';
    }
    if (isset($_POST['admin'])) {
        $admin = '"1"';
    } else {
        $admin = 'NULL';
    }
    $param = $_POST['param'];
    $link_id = strtolower(str_replace(' ', '', $nama_menu));

    if (!empty($menu_id)) {
        mysql_query('UPDATE m_app_menu SET NAMA_MENU = "' . $nama_menu . '",PARAM = "' . $param . '",LINK_ID = "' . md5($link_id) . '",ICON_FILE = "' . $icon_file . '",NAMA_FILE = "' . $nama_file . '", ST_TAMPILKAN="' . $st_tampilkan . '", JUDUL_MENU="' . $judul_menu . '", ADMIN = ' . $admin . ' WHERE MENU_ID = ' . $menu_id) or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_app_menu (NAMA_MENU,PARAM,LINK_ID,ICON_FILE,NAMA_FILE,ST_TAMPILKAN,JUDUL_MENU,ADMIN) VALUES ("' . $nama_menu . '","' . $param . '","' . md5($link_id) . '","' . $icon_file . '","' . $nama_file . '","' . $st_tampilkan . '","' . $judul_menu . '",' . $admin . ')') or die(mysql_error());
    }
    $menu_id = '';
    $nama_menu = '';
    $link_id = '';
    $icon_file = '';
    $nama_file = '';
    $st_tampilkan = '';
    $judul_menu = '';
    $param = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $menu_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_app_menu WHERE MENU_ID = ' . $menu_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $menu_id = $dat['MENU_ID'];
    $nama_menu = $dat['NAMA_MENU'];
    $link_id = $dat['LINK_ID'];
    $icon_file = $dat['ICON_FILE'];
    $nama_file = $dat['NAMA_FILE'];
    $st_tampilkan = $dat['ST_TAMPILKAN'];
    $judul_menu = $dat['JUDUL_MENU'];
    $admin = $dat['ADMIN'];
    $param = $dat['PARAM'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_app_menu WHERE MENU_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE CONCAT(m_app_menu.NAMA_MENU,m_app_menu.NAMA_FILE) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $menu_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $menu_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $menu_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="menu_id" id="menu_id" value="<?php echo $menu_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table class="tableform" border="0" width="900">
        <tr>
            <td width="20%;">Menu</td>
            <td><input name="nama_menu" type="text" id="nama_menu" class="text_dt" value="<?php echo $nama_menu; ?>" size="40" /></td>		
            <td width="20%;">Param</td>
            <td><input name="param" type="text" id="param" class="text_dt" value="<?php echo $param; ?>" size="40" /></td>
        </tr>
        <tr>
            <td>Link</td>
            <td><input name="link_id" type="text" id="link_id" class="text_dt" value="<?php echo $link_id; ?>" size="40" readonly="readonly" /></td>		
            <td>Judul Menu</td>
            <td><input name="judul_menu" type="text" id="judul_menu" class="text_dt" value="<?php echo $judul_menu; ?>" size="40" /></td>
        </tr>
        <tr>
            <td>File</td>
            <td><input name="nama_file" type="text" id="nama_file" class="text_dt" value="<?php echo $nama_file; ?>" size="40" /></td>		
            <td>Icon File</td>
            <td><input name="icon_file" type="text" id="icon_file" class="text_dt" value="<?php echo $icon_file; ?>" size="40" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td valign="middle">Tampil&nbsp;&nbsp;<input type="checkbox" name="st_tampilkan" id="st_tampilkan" <?php if ($st_tampilkan == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;&nbsp;Admin&nbsp;&nbsp;<input type="checkbox" name="admin" id="admin" <?php if ($admin == '1') echo 'checked="checked"'; ?> /></td>		
            <td>&nbsp;</td>		
            <td colspan="2" align="left"><input type="submit" value="simpan" class="myButton1" /></td>
        </tr>	
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
        <table id="tfhover" class="tableData" border="1" >        	
            <thead>		
                <tr>		
                    <th width="10">Id</th>
                    <th>Menu</th>
                    <th>Param</th>
                    <th>Link</th>
                    <th>Judul</th>
                    <th>File</th>
                    <th>Icon File</th>
                    <th>Tampil</th>
                    <th>Admin</th>
                    <th width="70">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = 'SELECT * FROM m_app_menu' . $sql_search . ' ORDER BY m_app_menu.NAMA_MENU ';
                $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
                $rs = $pager->paginate();
                if (!$rs)
                    die(mysql_error());

                while ($dat = mysql_fetch_array($rs)) {
                    $id = $dat['MENU_ID'];
                    echo '<tr>';
                    echo '<td align="center" >' . $dat['MENU_ID'] . '</td>';
                    echo '<td>' . $dat['NAMA_MENU'] . '</td>';
                    echo '<td>' . $dat['PARAM'] . '</td>';
                    echo '<td>' . $dat['LINK_ID'] . '</td>';
                    echo '<td>' . $dat['JUDUL_MENU'] . '</td>';
                    echo '<td>' . $dat['NAMA_FILE'] . '</td>';
                    echo '<td>' . $dat['ICON_FILE'] . '</td>';
                    echo '<td align="center">';
                    if ($dat['ST_TAMPILKAN'] == '1')
                        echo '&radic;';
                    echo '</td>';
                    echo '<td align="center">';
                    if ($dat['ADMIN'] == '1')
                        echo '&radic;';
                    echo '</td>';
                    echo '<td align="center" ><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['MENU_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['MENU_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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