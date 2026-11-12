<?php
$pegawai_id = '';
$nama_pegawai = '';
$alamat_pegawai = '';
$email = '';
$no_telp_pegawai = '';
$tipe_pegawai_id = '';

if (isset($_POST['pegawai_id'])) {
    $pegawai_id = $_POST['pegawai_id'];
    $nama_pegawai = $_POST['nama_pegawai'];
    $alamat_pegawai = $_POST['alamat_pegawai'];
    $email = $_POST['email'];
    $no_telp_pegawai = $_POST['no_telp_pegawai'];
    $tipe_pegawai_id = $_POST['tipe_pegawai_id'];

    if (!empty($pegawai_id)) {
        mysql_query('UPDATE m_pegawai SET NAMA_PEGAWAI = "' . $nama_pegawai . '",ALAMAT_PEGAWAI = "' . $alamat_pegawai . '",EMAIL = "' . $email . '",NO_TELP_PEGAWAI = "' . $no_telp_pegawai . '",TIPE_PEGAWAI_ID = "' . $tipe_pegawai_id . '" WHERE PEGAWAI_ID = "' . $pegawai_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_pegawai (NAMA_PEGAWAI,ALAMAT_PEGAWAI,EMAIL,NO_TELP_PEGAWAI,TIPE_PEGAWAI_ID) VALUES ("' . $nama_pegawai . '","' . $alamat_pegawai . '","' . $email . '","' . $no_telp_pegawai . '","' . $tipe_pegawai_id . '")') or die(mysql_error());
    }
    $pegawai_id = '';
    $nama_pegawai = '';
    $alamat_pegawai = '';
    $email = '';
    $no_telp_pegawai = '';
    $tipe_pegawai_id = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $pegawai_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_pegawai WHERE PEGAWAI_ID = ' . $pegawai_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_pegawai = $dat['NAMA_PEGAWAI'];
    $alamat_pegawai = $dat['ALAMAT_PEGAWAI'];
    $email = $dat['EMAIL'];
    $no_telp_pegawai = $dat['NO_TELP_PEGAWAI'];
    $tipe_pegawai_id = $dat['TIPE_PEGAWAI_ID'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_pegawai WHERE PEGAWAI_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND m_pegawai.NAMA_PEGAWAI LIKE "%' . $searchkey . '%" OR m_pegawai_tipe.KET_TIPE_PEGAWAI LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $pegawai_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $pegawai_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $pegawai_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="pegawai_id" id="pegawai_id" value="<?php echo $pegawai_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="900">
        <tr><td width="15%">Nama Pegawai</td><td><input name="nama_pegawai" type="text" class="text_dt" id="nama_pegawai" value="<?php echo $nama_pegawai; ?>" size="40" /></td>
		<td width="15%">Alamat</td><td><input name="alamat_pegawai" type="text" class="text_dt" id="alamat_pegawai" value="<?php echo $alamat_pegawai; ?>" size="40" /></td></tr>
        <tr><td>Email</td><td><input name="email" type="text" class="text_dt" id="email" value="<?php echo $email; ?>" size="40" /></td><td>Nomor Telepon</td><td><input type="text" name="no_telp_pegawai" class="text_dt" id="no_telp_pegawai" value="<?php echo $no_telp_pegawai; ?>" /></td></tr>
        <tr><td>Tipe Pegawai</td><td><select name="tipe_pegawai_id" class="text_dt" id="tipe_pegawai_id" style="width:270px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT * FROM m_pegawai_tipe';
                    $get = mysql_query($sql);
                    while ($dat = mysql_fetch_array($get)) {
                        ?>
                        <option value="<?php echo $dat['TIPE_PEGAWAI_ID']; ?>" <?php if ($dat['TIPE_PEGAWAI_ID'] == $tipe_pegawai_id) echo 'selected="selected"'; ?> ><?php echo $dat['KET_TIPE_PEGAWAI']; ?></option>
                        <?php
                    }
                    ?>
                </select></td><td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
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
			<th width="200">Nama Pegawai</th>
			<th>Alamat</th>
			<th width="200">Nomor Telepon</th>
			<th width="200">Email</th>
			<th width="200">Tipe Pegawai</th>
			<th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_pegawai.*, m_pegawai_tipe.*
		FROM m_pegawai
		LEFT JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
		WHERE m_pegawai.NAMA_PEGAWAI <> "asepkurniawan27@gmail.com" ' . $sql_search . ' ORDER BY m_pegawai.NAMA_PEGAWAI';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['PEGAWAI_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_PEGAWAI'] . '</td>';
            echo '<td>' . $dat['ALAMAT_PEGAWAI'] . '</td>';
            echo '<td>' . $dat['NO_TELP_PEGAWAI'] . '</td>';
            echo '<td>' . $dat['EMAIL'] . '</td>';
            echo '<td>' . $dat['KET_TIPE_PEGAWAI'] . '</td>';
            echo '<td align="center"><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['PEGAWAI_ID'] . '&searchkey=' . $searchkey . '">edit</a><!--|<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['PEGAWAI_ID'] . '&searchkey=' . $searchkey . '">hapus</a>--></td></tr>';
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