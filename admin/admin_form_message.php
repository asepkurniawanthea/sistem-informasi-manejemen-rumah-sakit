<?php
$message = '';
$message_id = '';

if(isset($_POST['send'])){
	$message = $_POST['message'];
	$cn_instansi = $_POST['cn_instansi'];
	$tm = getDatetimeSkr();
	$nomor = getNomorHarian('Kasir');
	$nama_user = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
	$nama_modul = $_SESSION['SES_SIMRS_NAMA_MODUL'];
	if($nama_modul == 'Admin') $nama_modul = 'EDP';
	$u = 1;
	while ($u <= $cn_instansi){
		if(isset($_POST['instansi_' . $u])){
			$inst_arr = explode('-',$_POST['instansi_' . $u]);
			$app = $inst_arr[0];
			$instansi = $inst_arr[1];
			mysql_query('INSERT INTO db_repository.msg_broadcast(TIME_SEND,NO_MESSAGE,USER_SEND,
				APP_ID,MODUL_ID,CONTENT_MESSAGE)
				VALUES(' . fieldDatetime($tm) . ',"' . $nomor . '","' . $nama_user . ' (' . $nama_modul . ')' . '",
				"' . $app . '","' . $instansi . '","' . $message . '")') or die(mysql_error());
		}
	$u++;}
	
	?>
		<script language="JavaScript" >
			alert('Kirim Pesan Berhasil.');
			window.location = "index.php?link=c200b3156a52f7b4e636e91133a29f99";
		</script>
	<?php
}
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		<form method="post" enctype="multipart/form-data" name="FUpload">
			<table class="tableform" border="0" >
				<tr>
					<td>Message</td>
					<td colspan="2"><textarea name="message" id="message" class="text_dt5" /><?php echo $message; ?></textarea></td>
				</tr>
				<tr>
					<td>Instansi Penerima</td>
					<td><?php
						$sql_modul = 'SELECT * FROM (SELECT DISTINCT CASE WHEN db_simrs.m_app_modul.MODUL_ID = 14 THEN "EDP" 
								ELSE db_simrs.m_app_modul.NAMA_MODUL END AS NAMA_MODUL,
								CONCAT("1-",db_simrs.m_app_modul.MODUL_ID) AS MODUL_ID
								FROM db_simrs.m_app_modul
								INNER JOIN db_simrs.m_app_user 
								ON (db_simrs.m_app_modul.MODUL_ID = db_simrs.m_app_user.MODUL_ID)
								WHERE db_simrs.m_app_modul.MODUL_ID <> 7
								AND db_simrs.m_app_modul.MODUL_ID <> 8
								AND db_simrs.m_app_modul.MODUL_ID <> 13
								AND db_simrs.m_app_modul.MODUL_ID <> 17
								AND db_simrs.m_app_modul.MODUL_ID <> 99
								AND db_simrs.m_app_modul.MODUL_ID <> 14
								UNION
								SELECT db_inventorirs.m_app_modul.NAMA_MODUL,
								CONCAT("2-",db_inventorirs.m_app_modul.MODUL_ID) AS MODUL_ID
								FROM db_inventorirs.m_app_modul
								INNER JOIN db_inventorirs.m_app_user 
								ON (db_inventorirs.m_app_modul.MODUL_ID = db_inventorirs.m_app_user.MODUL_ID)
								WHERE db_inventorirs.m_app_modul.MODUL_ID = 7
								OR db_inventorirs.m_app_modul.MODUL_ID = 8
								OR db_inventorirs.m_app_modul.MODUL_ID = 13
								OR db_inventorirs.m_app_modul.MODUL_ID = 17
								) t ORDER BY t.NAMA_MODUL';
					$get_modul = mysql_query($sql_modul) or die(mysql_error());
					$x = 1;
					while($dat_modul = mysql_fetch_array($get_modul)){ ?>
						<input type="checkbox" name="instansi_<?php echo $x; ?>" value="<?php echo $dat_modul['MODUL_ID']; ?>" checked="checked" class="u" /><?php echo $dat_modul['NAMA_MODUL']; ?>&nbsp;&nbsp;
					<?php 
					$x++;
					}	
					?>
					<input type="hidden" name="cn_instansi" value="<?php echo $x; ?>" />
					<br />
					<br />
					<a href="#" id="custom_button1" onclick="checkall();" >check all</a> | <a href="#" id="custom_button2" onclick="uncheckall();">uncheck all</a>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><input type="submit" name="send" value="send" class="myButton" /></td>
				</tr>
		</table>
		<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
		<input type="hidden" name="message_id" value="<?php echo $message_id; ?>" />
	</form>
	</div>
<script>
function checkall(){
     jQuery('.u').each(function() { 
                this.checked = true; 
            });      
};
function uncheckall(){
     jQuery('.u').each(function() { 
                this.checked = false; 
            });      
};
</script>