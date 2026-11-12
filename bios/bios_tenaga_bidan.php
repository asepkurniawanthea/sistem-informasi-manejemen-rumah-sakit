<?php
include('bios/bios_refdata.php');
include('bios/bios_senddata.php');

$connect_9 = mysql_connect($hostname_9, $username_9, $password_9) or die(mysql_error());
mysql_select_db($database_9, $connect_9) or die(mysql_error());

$base_url = 'https://api.bios.liveprod.cloud';

//publish
if(isset($_POST['publish'])){
	$response_login = sendToBiosLogin();
	$json_response_login = json_decode($response_login,true);
	if($json_response_login['status'] == '200'){
		$token = $json_response_login['data']['token'];
		$l = 1;
		while($l <= 20){
			//pengulangan data cekbox
			if(isset($_POST['publish_' . $l])){
				//ambil detail
				$q_data = 'SELECT DATE_FORMAT(TANGGAL_TRANSAKSI,"%Y-%m-%d") AS TANGGAL_TRANSAKSI,
					PNS,NON_PNS_TETAP,KONTRAK 
					FROM bidan
					WHERE BIDAN_ID = "' . $_POST['publish_' . $l] . '"';
				$g_data = mysql_query($q_data) or die(mysql_error());
				$d_data = mysql_fetch_assoc($g_data);	
				
				//$arr_kode_akun = explode('-',$d_data['KODE_AKUN']);
				$content = '{
						"tgl_transaksi" : "' . $d_data['TANGGAL_TRANSAKSI'] . '",
						"pns" : ' . $d_data['PNS'] . ',
						"non_pns_tetap" : ' . $d_data['NON_PNS_TETAP'] . ',
						"kontrak" : ' . $d_data['KONTRAK'] . '
				}';
				
				echo $response = sendToBiosData('pk1/sdm/bidan','POST',$token,$content);
				$json_response = json_decode($response,true);
				
				if(isset($json_response['kode']) and $json_response['kode'] == '001'){
					mysql_query('UPDATE bidan SET TANGGAL_UPDATE = NOW()
						WHERE BIDAN_ID = "' . $_POST['publish_' . $l] . '"') or die(mysql_error());
				}	
				
			}	
		$l++;
		}
	}	
}

//isi referensi kode akun
// if(!isset($_SESSION['ref_akun_penerimaan'])){
// 	$_SESSION['ref_akun_penerimaan'] = '{"ref_penerimaan":' . getBiosDataRef('akun_penerimaan') . '}';
// }

//inisialisasi isian form pencarian
$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND KODE_AKUN = "' . $searchkey . '" ';
}

//inisialisasi isian form
$bidan_id = '';
$tanggal_transaksi = '';
$pns = '';
$non_pns_tetap = '';
$kontrak = '';

//submit simpan
if (isset($_POST['bidan_id'])) {
	$bidan_id = $_POST['bidan_id'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $pns = $_POST['pns'];
    $non_pns_tetap = $_POST['non_pns_tetap'];
    $kontrak = $_POST['kontrak'];
   
    if (!empty($bidan_id)) {
        mysql_query('UPDATE bidan SET TANGGAL_TRANSAKSI = ' . fieldDate($tanggal_transaksi) . ',PNS = "' . $pns . '",NON_PNS_TETAP = "' . $non_pns_tetap . '",KONTRAK = "' . $kontrak . '" WHERE BIDAN_ID = "' . $bidan_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO bidan(TANGGAL_TRANSAKSI,PNS,NON_PNS_TETAP,KONTRAK) VALUES(
					' . fieldDate($tanggal_transaksi) . ',"' . $pns . '","' . $non_pns_tetap . '","' . $kontrak . '")') or die(mysql_error());
    }
    $bidan_id = '';
	$tanggal_transaksi = '';
	$pns = '';
	$non_pns_tetap = '';
	$kontrak = '';
    $msg_info = 'Simpan Data Berhasil.';
}

//inisialisasi isian form ubah
if (isset($_GET['ide'])) {
    $bidan_id = $_GET['ide'];
    $sql = 'SELECT DATE_FORMAT(bidan.TANGGAL_TRANSAKSI,"%d/%m/%Y") AS TANGGAL_TRANSAKSI,
			bidan.PNS,bidan.NON_PNS_TETAP,bidan.KONTRAK
			FROM bidan WHERE BIDAN_ID = ' . $bidan_id;
    $get = mysql_query($sql) or die(mysql_error());
    $dat = mysql_fetch_assoc($get);
    $tanggal_transaksi = $dat['TANGGAL_TRANSAKSI'];
    $pns = $dat['PNS'];
    $non_pns_tetap = $dat['NON_PNS_TETAP'];
    $kontrak = $dat['KONTRAK'];
}

//hapus data
if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM bidan WHERE BIDAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

if (isset($_GET['idd'])) {
    $bidan_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $bidan_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $bidan_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="search" method="post" action="index.php">
    <input type="hidden" name="bidan_id" id="bidan_id" value="<?php echo $bidan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Tanggal Transaksi</td>
			<td><input type="text" name="tanggal_transaksi" id="tgl_1" value="<?php echo $tanggal_transaksi; ?>" style="width:260px;" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
				</td>
		</tr>
		<!-- <tr><td>Kode Akun</td>
			<td><select name="kode_akun" id="kode_akun"  class="text_dt" style="width:270px;">
			<option value="" >--</option>
			<?php
			$json_response = json_decode($_SESSION['ref_akun_penerimaan'],true);
			$json_data = $json_response['ref_penerimaan'];
			foreach($json_data as $row){
				$selected = '';
				if($kode_akun == $row['Kode'] . '--' . $row['Uraian']) $selected = 'selected="selected"'; 
				echo '<option value="' . $row['Kode'] . '--' . $row['Uraian'] . '" ' . $selected . ' >' . $row['Kode'] . '--' . $row['Uraian'] . '</option>';
			} ?>	
			</select></td>
		</tr> -->
		<tr><td>PNS</td>
			<td><input name="pns" type="text" id="pns"  class="text_dt" value="<?php echo $pns; ?>" style="width:260px;text-align:right;" /></td>
		</tr>
		<tr><td>Non PNS Tetap</td>
			<td><input name="non_pns_tetap" type="text" id="non_pns_tetap"  class="text_dt" value="<?php echo $non_pns_tetap; ?>" style="width:260px;text-align:right;" /></td>
		</tr>
		<tr><td>Kontrak</td>
			<td><input name="kontrak" type="text" id="kontrak"  class="text_dt" value="<?php echo $kontrak; ?>" style="width:260px;text-align:right;" /></td>
		</tr>	
		<tr><td>&nbsp;</td>
			<td><input type="submit" id="simpan"  class="myButton" value="simpan" /></td>
		</tr>
    </table>
</form>
<br />
<!-- <form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <select name="searchkey" id="searchkey"  class="text_dt" style="width:270px;">
			<option value="" >--</option>
			<?php
			$json_response = json_decode($_SESSION['ref_akun_penerimaan'],true);
			$json_data = $json_response['ref_penerimaan'];
			foreach($json_data as $row){
				$selected = '';
				if($searchkey == $row['Kode'] . '--' . $row['Uraian']) $selected = 'selected="selected"'; 
				echo '<option value="' . $row['Kode'] . '--' . $row['Uraian'] . '" ' . $selected . ' >' . $row['Kode'] . '--' . $row['Uraian'] . '</option>';
			} ?>	
			</select>
            &nbsp;&nbsp;
			<input type="submit" id="cari"  class="myButton" value="cari" />
			&nbsp;
			</td>			
        </tr> 
	</table>
</form> -->	
<form name="form3" method="post" action="index.php">
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="50">No</th>
			<!--<th width="50">Id</th>-->
			<th>Tanggal Transaksi</th>
			<th>PNS</th>
			<th>Non PNS Tetap</th>
			<th>Kontrak</th>
			<th>Tanggal Update</th>
			<th>Publish</th>
			<th width="100">Option</th>
		</tr>
        <?php
        $sql = 'SELECT bidan.BIDAN_ID,bidan.TANGGAL_UPDATE,
				bidan.TANGGAL_TRANSAKSI,bidan.PNS,bidan.NON_PNS_TETAP,bidan.KONTRAK
				FROM bidan 
				WHERE 1 ' . $sql_search . ' 
				ORDER BY bidan.TANGGAL_TRANSAKSI DESC';
        $no = 0;
		$r = 1;
		$pager = new PS_Pagination($connect, $sql, 20, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr><td align="center">';
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
        
			//echo '</td><td align="center">' . $dat['SALDO_PENGELOLAAN_KAS_ID'] . '</td>';
            echo '<td>' . $dat['TANGGAL_TRANSAKSI'] . '</td>';
            echo '<td>' . $dat['PNS'] . '</td>';
			echo '<td align="right">' . currFormat($dat['NON_PNS_TETAP']) . '</td>';
			echo '<td align="right">' . currFormat($dat['KONTRAK']) . '</td>';
			echo '<td>' . $dat['TANGGAL_UPDATE'] . '</td>';
			echo '<td align="center">'; ?>
				<input type="checkbox" name="publish_<?php echo $r; ?>" id="publish_<?php echo $r; ?>" value="<?php echo $dat['BIDAN_ID']; ?>" />        
			<?php echo '</td><td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['BIDAN_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;
			<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['BIDAN_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
			$r++;
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
								<td align="center">
									<input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
									<input type="submit" id="publish" name="publish" class="myButton" value="publish" />
								</td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
</form>		