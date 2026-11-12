<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_6, $username_6, $password_6) or die(mysql_error());
mysql_select_db($database_6, $connect) or die(mysql_error());
$searchkey = '';
if (isset($_SESSION['keuanganmasterakun_searchkey']))
		$searchkey = $_SESSION['keuanganmasterakun_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['keuanganmasterakun_searchkey'] = $searchkey;
}
if (isset($_GET['idk'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>";
		}
    </script>
    <?php
	}
	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM m_akun WHERE AKUN_ID = "' . $_GET['idk'] . '"');
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
		<tr>
			<td>Nama Akun</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
if(empty($searchkey)){
	$qry_masterakun = 'SELECT m_akun.AKUN_ID,m_akun.KODE_AKUN,m_akun.KODE_AKUN_INDUK,
				m_akun.NAMA_AKUN,m_akun.POS_AKUN,m_akun.DESKRIPSI
				FROM m_akun
				WHERE (m_akun.KODE_AKUN_INDUK IS NULL OR m_akun.KODE_AKUN_INDUK = "")
				ORDER BY m_akun.KODE_AKUN';
}else{
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_masterakun = 'SELECT * FROM (
				SELECT m_akun.AKUN_ID,m_akun.KODE_AKUN,m_akun.KODE_AKUN_INDUK,
				m_akun.NAMA_AKUN,m_akun.POS_AKUN,m_akun.DESKRIPSI
				FROM m_akun
				INNER JOIN (
					SELECT ak.AKUN_ID,ak.KODE_AKUN,ak.KODE_AKUN_INDUK,
					ak.NAMA_AKUN,ak.POS_AKUN,ak.DESKRIPSI
					FROM m_akun ak
					WHERE CONCAT(ak.KODE_AKUN,ak.NAMA_AKUN) LIKE "%' . $searchkey . '%"
				) t_akun
				ON m_akun.KODE_AKUN = t_akun.KODE_AKUN_INDUK	
				WHERE (m_akun.KODE_AKUN_INDUK IS NULL OR m_akun.KODE_AKUN_INDUK = "")
				UNION
				SELECT m_akun.AKUN_ID,m_akun.KODE_AKUN,m_akun.KODE_AKUN_INDUK,
				m_akun.NAMA_AKUN,m_akun.POS_AKUN,m_akun.DESKRIPSI
				FROM m_akun
				WHERE (m_akun.KODE_AKUN_INDUK IS NULL OR m_akun.KODE_AKUN_INDUK = "")
				AND CONCAT(m_akun.KODE_AKUN,m_akun.NAMA_AKUN) LIKE "%' . $searchkey . '%"
				) t_akunz ORDER BY KODE_AKUN';
}				
$extparam = '&searchkey=' . $searchkey;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="35px">No</th>
        <th width="100px">Kode Akun</th>
        <th width="280px">Nama Akun</th>
        <th width="100px">POS</th>
		<th>Deskripsi</th>
        <th width="170px">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_masterakun, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    ?>
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
        ?></td>
            <td align="center"><?php echo $data['KODE_AKUN']; ?></td>
            <td><?php echo $data['NAMA_AKUN']; ?></td>
			<td>&nbsp;</td>
			<td><?php echo $data['DESKRIPSI']; ?></td>
			<td align="center">
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddakun&prn=<?php echo $data['KODE_AKUN']; ?>&id=<?php echo $data['AKUN_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >ubah</a>
				<?php
				$qry_masterakun_detail = 'SELECT m_akun.AKUN_ID,m_akun.KODE_AKUN,m_akun.KODE_AKUN_INDUK,
								m_akun.NAMA_AKUN,m_akun.POS_AKUN,m_akun.DESKRIPSI
								FROM m_akun
								WHERE m_akun.KODE_AKUN_INDUK = "' . $data['KODE_AKUN'] . '"';
				$get_masterakun_detail = mysql_query($qry_masterakun_detail) or die(mysql_error()); 
				if(mysql_num_rows($get_masterakun_detail) == 0){?>
				<a href="index.php?link=<?php echo $_REQUEST['link'] . '&idk=' . $data['AKUN_ID'] . '&nmk=' . $data['NAMA_AKUN']; ?>">hapus</a>
				<?php } ?>
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddakun&prn=<?php echo $data['KODE_AKUN']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >tambah akun</a>
			</td>
        </tr>
        <? while($dat_masterakun_detail = mysql_fetch_array($get_masterakun_detail)){
			?>
			<tr>
			<td align="center">&nbsp;</td>
			<td align="center"><?php echo $dat_masterakun_detail['KODE_AKUN']; ?></td>
			<td><?php echo $dat_masterakun_detail['NAMA_AKUN']; ?></td>
			<td align="center"><?php echo (($dat_masterakun_detail['POS_AKUN'] == 'D') ? 'Debet' : 'Kredit'); ?></td>
			<td><?php echo $dat_masterakun_detail['DESKRIPSI']; ?></td>
			<td align="center">
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddakun&prn=<?php echo $data['KODE_AKUN']; ?>&id=<?php echo $dat_masterakun_detail['AKUN_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >ubah</a>
				<a href="index.php?link=<?php echo $_REQUEST['link'] . '&idk=' . $dat_masterakun_detail['AKUN_ID'] . '&nmk=' . $dat_masterakun_detail['NAMA_AKUN']; ?>">hapus</a>
			</td>
			</tr>
			<?php
		}	
    }
	if($no == 0){ ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center"><a href="#" onclick="window.open('index.php?popup=keuanganformaddakun&prn=','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >tambah akun</a></td>
		</tr>
	<?php } ?>
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