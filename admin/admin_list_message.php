<?php
$tgl_1 = '';
if (isset($_SESSION['message_tgl_1']))
    $tgl_1 = $_SESSION['message_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['message_tgl_1']))
    $tgl_2 = $_SESSION['message_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['message_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['message_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['message_searchkey']))
		$searchkey = $_SESSION['message_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['message_searchkey'] = $searchkey;
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
if(!empty($tgl_filter_1)) $sql_tanggal_filter = ' AND STR_TO_DATE(DATE_FORMAT(TIME_SEND,"%d%m%Y"),"%d%m%Y") >= ' . $tgl_filter_1
	. ' AND STR_TO_DATE(DATE_FORMAT(TIME_SEND,"%d%m%Y"),"%d%m%Y") <= ' . $tgl_filter_2;
	
$sql_key_filter = '';
if(!empty($searchkey)) $sql_key_filter = ' AND CONTENT_MESSAGE LIKE "%' . $searchkey . '%"';	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Message</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:210px;" /></td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>	
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('adminformmessage'); ?>" >
			<input type="button" value="send message" class="myButton" />
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
			<th>Message</th>
			<th>Pengirim</th>
			<th>Penerima</th>
			<th>Tidak Aktif</th></tr>
        <?php
		$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
		mysql_select_db($database_5, $connect) or die(mysql_error());

        $sql = 'SELECT DISTINCT * FROM (SELECT DISTINCT msg_broadcast.TIME_SEND,
						msg_broadcast.USER_SEND,msg_broadcast.CONTENT_MESSAGE,
						msg_broadcast.ST_MESSAGE,msg_broadcast.NO_MESSAGE
						FROM msg_broadcast
				) t WHERE 1 
				' . $sql_tanggal_filter . '
				' . $sql_key_filter . '
				ORDER BY TIME_SEND DESC';
        $no = 0;
		$pager = new PS_Pagination($connect, $sql, 5, 5, '', 'index.php?link=' . $_REQUEST['link']);
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
			echo ($hal * 5) + $no;
            echo '<td align="center">' . $dat['TIME_SEND'] . '</td>';
            echo '<td>' . $dat['CONTENT_MESSAGE'] . '</td>';
            echo '<td>' . $dat['USER_SEND'] . '</td>';
			echo '<td>';
	
				$penerima = '';
				$sql_modul = 'SELECT * FROM (SELECT db_simrs.m_app_modul.NAMA_MODUL FROM db_simrs.m_app_modul 
								INNER JOIN db_repository.msg_broadcast
								ON (db_simrs.m_app_modul.MODUL_ID = db_repository.msg_broadcast.MODUL_ID)
								WHERE db_repository.msg_broadcast.NO_MESSAGE = "' . $dat['NO_MESSAGE'] . '"
								AND db_repository.msg_broadcast.APP_ID = "1"
								UNION ALL
								SELECT db_inventorirs.m_app_modul.NAMA_MODUL FROM db_inventorirs.m_app_modul 
								INNER JOIN db_repository.msg_broadcast
								ON (db_inventorirs.m_app_modul.MODUL_ID = db_repository.msg_broadcast.MODUL_ID)
								WHERE db_repository.msg_broadcast.NO_MESSAGE = "' . $dat['NO_MESSAGE'] . '"
								AND db_repository.msg_broadcast.APP_ID = "2"
								) t ORDER BY NAMA_MODUL';
				$get_modul = mysql_query($sql_modul) or die(mysql_error());
				while($dat_modul = mysql_fetch_array($get_modul)){
					$penerima = $penerima . $dat_modul['NAMA_MODUL'] . ',';
				}
				
			echo substr($penerima,0,strlen($penerima)- 1) . '</td>';
			?>
			<td align="center">
				<input type="checkbox" name="tidak_aktif" id="tidak_aktif_<?php echo $no; ?>" value="1" 
				<?php if($dat['ST_MESSAGE']== '1') echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('tidak_aktif_<?php echo $no; ?>','<?php echo $dat['NO_MESSAGE']; ?>');" />
			</td></tr>
			<?php
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
<div id="msg_ta"></div>		
<script language="JavaScript" >
function centang_opt(ck,id){
	if(document.getElementById(ck).checked){
		if(confirm('Tidak Aktifkan ?')){
			MyAjaxRequest('msg_ta','index.php?ajaxrequest=msgtidakaktif&opt=1&id=' + id);
		}else{
			document.getElementById(ck).checked = false;
		}
		return false;
	}else{
		MyAjaxRequest('msg_ta','index.php?ajaxrequest=msgtidakaktif&opt=2&id=' + id);
		return false;
	}
}
</script>		