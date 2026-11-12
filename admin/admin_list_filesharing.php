<?php
$tgl_1 = '';
if (isset($_SESSION['filesharing_tgl_1']))
    $tgl_1 = $_SESSION['filesharing_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['filesharing_tgl_1']))
    $tgl_2 = $_SESSION['filesharing_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['filesharing_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['filesharing_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['filesharing_searchkey']))
		$searchkey = $_SESSION['filesharing_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['filesharing_searchkey'] = $searchkey;
}

$tgl_filter_1 = '';
if (!empty($tgl_1)) {
    $tgl_filter_1 = fieldDate($tgl_1);
}
$tgl_filter_2 = '';
if (!empty($tgl_2)) {
    $tgl_filter_2 = fieldDate($tgl_2);
}

if(!empty($tgl_filter_1) and empty($tgl_filter_2)) $tgl_filter_2 = $tgl_filter_1;  
if(empty($tgl_filter_1) and !empty($tgl_filter_2)) $tgl_filter_1 = $tgl_filter_2; 

$sql_tanggal_filter = '';
if(!empty($tgl_filter_1)) $sql_tanggal_filter = ' AND STR_TO_DATE(DATE_FORMAT(TIME_UPLOADED,"%d%m%Y"),"%d%m%Y") >= ' . $tgl_filter_1
	. ' AND STR_TO_DATE(DATE_FORMAT(TIME_UPLOADED,"%d%m%Y"),"%d%m%Y") <= ' . $tgl_filter_2;
	
$sql_key_filter = '';
if(!empty($searchkey)) $sql_key_filter = ' AND CONCAT(USER_FILE_NAME,DESCRIPTION) LIKE "%' . $searchkey . '%"';	

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM db_repository.fs_uploaded WHERE SISTEM_FILE_NAME = "' . $_GET['idx'] . '"') or die(mysql_error());
    $msg_info = 'Hapus File Berhasil.';
}

if (isset($_GET['idf'])) {
    $idf = $_GET['idf'];
	$nmf = $_GET['nmf'];
    ?>
    <script language="JavaScript" >
        if(confirm("<?php echo $nmf; ?> dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $idf; ?>";
        }
    </script>
    <?php
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>File</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:210px;" /></td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>	
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('adminformfilesharing'); ?>" >
			<input type="button" value="upload file" class="myButton" />
			</a>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Nama File</th>
			<th>Pengirim</th>
			<th>Penerima</th>
			<th>Keterangan</th>
			<th width="185">Action</th></tr>
        <?php
		$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
		mysql_select_db($database_5, $connect) or die(mysql_error());

        $sql = 'SELECT DISTINCT * FROM (SELECT "A" AS ST,TIME_UPLOADED,"" AS USER_UPLOADED,USER_ID_UPLOADED,
				SISTEM_FILE_NAME,USER_FILE_NAME,APP_ID_UPLOADED,DESCRIPTION,APP_ID,MODUL_ID
				FROM fs_uploaded
				WHERE APP_ID_UPLOADED = 1
				AND USER_ID_UPLOADED = "' . $_SESSION['SES_SIMRS_NAMA_USER'] . '"
				UNION ALL
				SELECT "B" AS ST,TIME_UPLOADED,USER_UPLOADED,USER_ID_UPLOADED,
				SISTEM_FILE_NAME,USER_FILE_NAME,APP_ID_UPLOADED,DESCRIPTION,APP_ID,MODUL_ID
				FROM fs_uploaded
				WHERE APP_ID = 1
				AND USER_ID = "' . $_SESSION['SES_SIMRS_NAMA_USER'] . '"
				) t WHERE 1 
				' . $sql_tanggal_filter . '
				' . $sql_key_filter . '
				ORDER BY TIME_UPLOADED DESC';
        $no = 0;
		$pager = new PS_Pagination($connect, $sql, 10, 5, '', 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) { ?>
			<tr>
            <td align="center"><?
			$no = ($no + 1);
			if (isset($_GET['page'])) {
				if ($_GET['page'] == 0) {
					$hal = 0;
				} else {
					$hal = $_GET['page'] - 1;
				}
			} else {
				$hal = 0;
			}
			echo ($hal * 10) + $no;
            echo '<td align="center">' . $dat['TIME_UPLOADED'] . '</td>';
            echo '<td>' . $dat['USER_FILE_NAME'] . '</td>';
            echo '<td>' . $dat['USER_UPLOADED'] . '</td>';
			echo '<td>';
				if($dat['ST'] == 'A'){
					if($dat['APP_ID'] == '1') $sql_modul = 'SELECT NAMA_MODUL FROM db_simrs.m_app_modul WHERE MODUL_ID = "' . $dat['MODUL_ID'] . '"';
					if($dat['APP_ID'] == '2') $sql_modul = 'SELECT NAMA_MODUL FROM db_inventorirs.m_app_modul WHERE MODUL_ID = "' . $dat['MODUL_ID'] . '"';
				$get_modul = mysql_query($sql_modul) or die(mysql_error());
				$dat_modul = mysql_fetch_assoc($get_modul);
					if($dat_modul['NAMA_MODUL'] == 'Admin'){
						echo 'EDP';
					}else{
						echo $dat_modul['NAMA_MODUL'];
					}	
				}
			echo '</td>';
            echo '<td>' . $dat['DESCRIPTION'] . '</td>';
			$uname = urlencode($dat['USER_FILE_NAME']);
			$sname = $dat['SISTEM_FILE_NAME'];
			?>
            <td><a href="#" onclick="window.open('<?php echo currentURL(); ?>&filesharing=1&uname=<?php echo $uname; ?>&sname=<?php echo $sname; ?>');return false;" >download</a>
			<?php
			if($dat['ST'] == 'A'){
				echo '&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idf=' . $sname . '&nmf=' . $uname . '">hapus</a>';
			}	
			echo '</td></tr>';
        }
        ?>
    </table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="midfle" >
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