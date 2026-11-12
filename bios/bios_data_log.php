<?php
include('keuangan/bos_refdata.php');

$tgl_1 = '';
if (isset($_SESSION['boslog_tgl_1']))
    $tgl_1 = $_SESSION['boslog_tgl_1'];
	
$username = '';
if (isset($_SESSION['boslog_username']))
    $username = $_SESSION['boslog_username'];	

$password = '';
if (isset($_SESSION['boslog_password']))
    $password = $_SESSION['boslog_password'];	
	
if (isset($_POST['tgl_1'])) {
    $tgl_1 = $_POST['tgl_1'];
    $_SESSION['boslog_tgl_1'] = $_POST['tgl_1'];
}

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $_SESSION['boslog_username'] = $_POST['username'];
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $_SESSION['boslog_password'] = $_POST['password'];
}
?>
<form name="search" method="post" action="index.php">
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Tanggal</td>
			<td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" style="width:260px;" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
				</td>
		</tr>
		<tr><td>Username</td>
			<td><input name="username" type="text" id="username"  class="text_dt" value="<?php echo $username; ?>" style="width:260px;" /></td>
		</tr>
		<tr><td>Password</td>
			<td><input name="password" type="text" id="password"  class="text_dt" value="<?php echo $password; ?>" style="width:260px;" /></td>
		</tr>
		<tr><td>&nbsp;</td>
			<td><input type="submit" id="simpan"  class="myButton" value="lihat" /></td>
		</tr>
    </table>
</form>
<br />	
    <table border="1" class="tableData" id="tfhover">
        <tr>
			<th>Tanggal</th>
			<th>Summary</th>
			<th>Error Detail</th>
		</tr>
<?php
	if(isset($_POST['tgl_1'])){
		$parameter = array('Tanggal' => $_POST['tgl_1'],'Username' => $_POST['username'],'Password' => $_POST['password']);
		$fparameter = json_encode($parameter);
		$json_response = json_decode('{"log":' . getBosDataRef('log','POST',$fparameter) . '}',true);
		if(is_array($json_response)){
			$json_data = $json_response['log'];
			foreach($json_data as $row){ ?>
				<tr>
					<td><?php $row['Tanggal']; ?></td>
					<td><?php $row['summary']; ?></td>
					<td><?php $row['errordetail']; ?></td>
				</tr>
<?php		}
		}
	}		
?>		
     </table>   