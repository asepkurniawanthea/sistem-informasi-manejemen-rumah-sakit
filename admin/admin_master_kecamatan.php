<?php
$kecamatan_id = '';
$nama_kecamatan = '';
$kota_id = '';

if (isset($_POST['kecamatan_id'])) {
    $kecamatan_id = $_POST['kecamatan_id'];
    $nama_kecamatan = $_POST['nama_kecamatan'];
    $kota_id = $_POST['kota_id'];
    if (!empty($kecamatan_id)) {
        mysql_query('UPDATE m_kecamatan SET NAMA_KECAMATAN = "' . $nama_kecamatan . '",KOTA_ID = "' . $kota_id . '" WHERE KECAMATAN_ID = "' . $kecamatan_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_kecamatan (NAMA_KECAMATAN,KOTA_ID) VALUES ("' . $nama_kecamatan . '","' . $kota_id . '")') or die(mysql_error());
    }
    $kecamatan_id = '';
    $nama_kecamatan = '';
    $kota_id = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $kecamatan_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_kecamatan WHERE KECAMATAN_ID = ' . $kecamatan_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_kecamatan = $dat['NAMA_KECAMATAN'];
    $kota_id = $dat['KOTA_ID'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_kecamatan WHERE KECAMATAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' WHERE CONCAT(m_kecamatan.NAMA_KECAMATAN, m_kota.NAMA_KOTA) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $kecamatan_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $kecamatan_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $kecamatan_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="kecamatan_id" id="kecamatan_id" value="<?php echo $kecamatan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
   <table class="tableform" border="0" width="250">
        <tr><td>Kecamatan</td>
            <td><input type="text" name="nama_kecamatan" id="nama_kecamatan" value="<?php echo $nama_kecamatan; ?>" class="text_dt"/></td>
        </tr><tr><td>Kota</td>
            <td><select name="kota_id" id="kota_id" class="text_dt">
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
            <th width="10">Id</th><th>Kecamatan</th><th>Kota</th><th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_kecamatan.KECAMATAN_ID,m_kecamatan.NAMA_KECAMATAN,m_kecamatan.KOTA_ID,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
				FROM m_kecamatan
				INNER JOIN m_kota ON (m_kecamatan.KOTA_ID = m_kota.KOTA_ID)
				INNER JOIN m_propinsi ON (m_propinsi.PROPINSI_ID = m_kota.PROPINSI_ID)
				' . $sql_search . 'ORDER BY NAMA_PROPINSI, NAMA_KOTA, NAMA_KECAMATAN';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['KECAMATAN_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_KECAMATAN'] . '</td>';
            echo '<td>' . $dat['NAMA_PROPINSI'] . ' - ' . $dat['NAMA_KOTA'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['KECAMATAN_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
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