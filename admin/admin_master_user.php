<?php
$user_id = '';
$nama_user = '';
$pegawai_id = '';
$modul_id = '';
$unit_id = '';
$ruang_id = '';
$admin = '';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $nama_user = $_POST['nama_user'];
    $pegawai_id = $_POST['pegawai_id'];
    $modul_id = $_POST['modul_id'];
    $unit_id = $_POST['unit_id'];
    $ruang_id = $_POST['ruang_id'];
    if (isset($_POST['admin']))
        $admin = '1';
    if (!empty($user_id)) {
        mysql_query('UPDATE m_app_user SET NAMA_USER = "' . $nama_user . '",PEGAWAI_ID = "' . $pegawai_id . '",MODUL_ID = "' . $modul_id . '",UNIT_ID = "' . $unit_id . '",RUANG_ID = "' . $ruang_id . '",ADMIN = "' . $admin . '" WHERE USER_ID = "' . $user_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_app_user (NAMA_USER,PEGAWAI_ID,MODUL_ID,KUNCI,UNIT_ID,RUANG_ID,ADMIN) VALUES ("' . $nama_user . '","' . $pegawai_id . '","' . $modul_id . '","' . MD5('123') . '","' . $unit_id . '","' . $ruang_id . '","' . $admin . '")') or die(mysql_error());
    }
    $user_id = '';
    $nama_user = '';
    $pegawai_id = '';
    $modul_id = '';
    $unit_id = '';
    $ruang_id = '';
    $admin = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $user_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_app_user WHERE USER_ID = ' . $user_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_user = $dat['NAMA_USER'];
    $pegawai_id = $dat['PEGAWAI_ID'];
    $modul_id = $dat['MODUL_ID'];
    $unit_id = $dat['UNIT_ID'];
    $ruang_id = $dat['RUANG_ID'];
    $admin = $dat['ADMIN'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_app_user WHERE USER_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

if (isset($_GET['idxr'])) {
    mysql_query('UPDATE m_app_user SET KUNCI = "' . MD5('123') . '" WHERE USER_ID = ' . $_GET['idxr']) or die(mysql_error());
    $msg_info = 'Reset Password Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND (m_app_user.NAMA_USER LIKE "%' . $searchkey . '%"
						OR m_pegawai.NAMA_PEGAWAI LIKE "%' . $searchkey . '%"
						OR m_app_modul.NAMA_MODUL LIKE "%' . $searchkey . '%") ';
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

if (isset($_GET['idr'])) {
    $user_id = $_GET['idr'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $user_id; ?>] reset password?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idxr=<?php echo $user_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Nama User Login</td><td><input name="nama_user" type="text" id="nama_user"  class="text_dt" value="<?php echo $nama_user; ?>" size="33" /></td>
		<td>Nama Pegawai</td><td><select name="pegawai_id" id="pegawai_id"  class="text_dt" style="width:228px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT m_pegawai.*,m_pegawai_tipe.* FROM m_pegawai 
							LEFT JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
							WHERE NAMA_PEGAWAI <> "asepkurniawan27@gmail.com"   
							ORDER BY NAMA_PEGAWAI';
                    $get = mysql_query($sql);
                    while ($dat = mysql_fetch_array($get)) {
                        ?>
                         <option value="<?php echo $dat['PEGAWAI_ID']; ?>" <?php if ($dat['PEGAWAI_ID'] == $pegawai_id) echo 'selected="selected"'; ?> >
						<?php if($dat['NAMA_PEGAWAI'] != '-') {
							echo $dat['NAMA_PEGAWAI']; 
						}else{ 
							echo '[' . $dat['KET_TIPE_PEGAWAI'] . ']';
						}	?></option>
                        <?php
                    }
                    ?>
                </select>
            </td></tr>
        <tr><td>Modul</td><td><select name="modul_id" id="modul_id" class="text_dt" style="width:228px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT * FROM m_app_modul WHERE NAMA_MODUL <> "Developer" ORDER BY NAMA_MODUL';
                    $get = mysql_query($sql);
                    while ($dat = mysql_fetch_array($get)) {
                        ?>
                        <option value="<?php echo $dat['MODUL_ID']; ?>" <?php if ($dat['MODUL_ID'] == $modul_id) echo 'selected="selected"'; ?> ><?php echo $dat['NAMA_MODUL']; ?></option>
                        <?php
                    }
                    ?>
                </select></td><td>Ruang</td>
            <td><div id="cruang" ><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
                        <option value=""> - </option>
<?php echo getRuang($unit_id, $ruang_id); ?>
                    </select></div></td></tr>
        <tr><td>Unit</td>
            <td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;" >
                    <option value=""> - </option>
<?php echo getUnit('',$unit_id); ?>
                </select></td>
				<td>Admin&nbsp;&nbsp;<input type="checkbox" name="admin" value="1" <?php if ($admin == '1') echo 'checked="checked"'; ?>/></td><td align="right"><input type="submit" value="simpan" class="myButton1" /></td>
				</tr>
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
			<th>Nama User Login</th>
			<th>Nama Pegawai</th>
			<th width="200">Modul</th>
			<th width="200">Unit</th>
			<th width="70">Admin</th>
			<th width="185">Action</th></tr>
        <?php
        $sql = 'SELECT m_app_user.*, m_app_modul.*, m_pegawai.*, m_unit.*,m_ruang.*, 
		CASE WHEN m_app_user.ADMIN = "1" THEN "&radic;" END AS USERADMIN
		FROM m_app_user
        LEFT JOIN m_pegawai ON (m_app_user.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_app_modul ON (m_app_user.MODUL_ID = m_app_modul.MODUL_ID)
		
		LEFT JOIN m_unit ON (m_app_user.UNIT_ID = m_unit.UNIT_ID)
		LEFT JOIN m_ruang ON (m_app_user.RUANG_ID = m_ruang.RUANG_ID)
		WHERE m_app_user.NAMA_USER <> "asepkurniawan" ' . $sql_search . ' ORDER BY m_pegawai.NAMA_PEGAWAI';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['USER_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_USER'] . '</td>';
            echo '<td>' . $dat['NAMA_PEGAWAI'] . '</td>';
            echo '<td>' . $dat['NAMA_MODUL'] . '</td>';
			$nama_unit = $dat['NAMA_UNIT'];
			if(!empty($dat['IRJA'])) $nama_unit = 'Klinik ' . $dat['NAMA_UNIT'];
            echo '<td>' . $nama_unit . ' ' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['USERADMIN'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['USER_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['USER_ID'] . '&searchkey=' . $searchkey . '">hapus</a>&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idr=' . $dat['USER_ID'] . '&searchkey=' . $searchkey . '">reset password</a></td></tr>';
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