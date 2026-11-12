<?php
$pegawai_id = '';
$unit_id = '';
$ruang_id = '';
$pelaksana_penunjang_id = '';

if (isset($_POST['pelaksana_penunjang_id'])) {
    $pegawai_id = $_POST['pegawai_id'];
    $unit_id = $_POST['unit_id'];
    $ruang_id = $_POST['ruang_id'];
    if (!empty($pelaksana_penunjang_id)) {
        mysql_query('UPDATE t_pelaksana_penunjang SET PEGAWAI_ID = "' . $pegawai_id . '",UNIT_ID = "' . $unit_id . '",RUANG_ID = "' . $ruang_id . '" WHERE PELAKSANA_PENUNJANG_ID = "' . $pelaksana_penunjang_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO t_pelaksana_penunjang (PEGAWAI_ID,UNIT_ID,RUANG_ID) VALUES ("' . $pegawai_id . '","' . $unit_id . '","' . $ruang_id . '")') or die(mysql_error());
    }
	$pegawai_id = '';
	$ruang_id = '';
	$pelaksana_penunjang_id = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $pelaksana_penunjang_id = $_GET['ide'];
    $sql = 'SELECT * FROM t_pelaksana_penunjang WHERE PELAKSANA_PENUNJANG_ID = ' . $pelaksana_penunjang_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $pegawai_id = $dat['PEGAWAI_ID'];
    $unit_id = $dat['UNIT_ID'];
    $ruang_id = $dat['RUANG_ID'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM t_pelaksana_penunjang WHERE PELAKSANA_PENUNJANG_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND CONCAT(m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $pelaksana_penunjang_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $pelaksana_penunjang_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $pelaksana_penunjang_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}

if (isset($_GET['idr'])) {
    $pelaksana_penunjang_id = $_GET['idr'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $pelaksana_penunjang_id; ?>] reset password?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idxr=<?php echo $pelaksana_penunjang_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="pelaksana_penunjang_id" id="pelaksana_penunjang_id" value="<?php echo $pelaksana_penunjang_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="700">
        <tr><td>Unit</td>
            <td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;" >
                    <option value=""> - </option>
<?php echo getUnit('',$unit_id); ?>
                </select></td><td>Ruang</td>
            <td><div id="cruang" ><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
                        <option value=""> - </option>
<?php echo getRuang($unit_id, $ruang_id); ?>
                    </select></div></td></tr>
		<tr>
		<td>Nama Pegawai</td><td><select name="pegawai_id" id="pegawai_id"  class="text_dt" style="width:228px;">
                    <option> - </option>
                    <?php
                    $sql = 'SELECT m_pegawai.*,m_pegawai_tipe.* FROM m_pegawai 
							INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
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
            </td>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
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
            <th width="10">Id</th>
			<th>Nama Pegawai</th>
			<th>Unit</th>
			<th width="70">Action</th></tr>
        <?php
        $sql = 'SELECT m_pegawai_tipe.KET_TIPE_PEGAWAI,t_pelaksana_penunjang.*, m_pegawai.*, m_unit.*,m_ruang.*
		FROM t_pelaksana_penunjang
        LEFT JOIN m_pegawai ON (t_pelaksana_penunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_unit ON (t_pelaksana_penunjang.UNIT_ID = m_unit.UNIT_ID)
		LEFT JOIN m_ruang ON (t_pelaksana_penunjang.RUANG_ID = m_ruang.RUANG_ID)
		LEFT JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
		WHERE 1 ' . $sql_search . ' ORDER BY m_pegawai.NAMA_PEGAWAI';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['PELAKSANA_PENUNJANG_ID'] . '</td>';
            if($dat['NAMA_PEGAWAI'] != '-'){
				echo '<td>' . $dat['NAMA_PEGAWAI'] . '</td>';
			}else{
				echo '<td>[' . $dat['KET_TIPE_PEGAWAI'] . ']</td>';
			}	
			$nama_unit = $dat['NAMA_UNIT'];
			if(!empty($dat['IRJA'])) $nama_unit = 'Klinik ' . $dat['NAMA_UNIT'];
            echo '<td>' . $nama_unit . ' ' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['PELAKSANA_PENUNJANG_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['PELAKSANA_PENUNJANG_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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