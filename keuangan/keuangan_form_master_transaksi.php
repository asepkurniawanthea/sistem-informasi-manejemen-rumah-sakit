<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_6, $username_6, $password_6) or die(mysql_error());
mysql_select_db($database_6, $connect) or die(mysql_error());
$searchkey = '';
if (isset($_SESSION['keuanganmastertransaksi_searchkey']))
		$searchkey = $_SESSION['keuanganmastertransaksi_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['keuanganmastertransaksi_searchkey'] = $searchkey;
}
if (isset($_GET['idj'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmj']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idj=<?php echo $_GET['idj']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>";
		}
    </script>
    <?php
	}
	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM m_journal_transaksi WHERE JOURNAL_TRANSAKSI_ID = "' . $_GET['idj'] . '"');
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}
if (isset($_GET['idd'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmd']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idd=<?php echo $_GET['idd']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>";
		}
    </script>
    <?php
	}
	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM m_journal_transaksi_detail WHERE JOURNAL_TRANSAKSI_DETAIL_ID = "' . $_GET['idd'] . '"');
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
			<td>Nama Transaksi</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_mastertransaksi = 'SELECT m_journal_transaksi.JOURNAL_TRANSAKSI_ID,m_journal_transaksi.NAMA_TRANSAKSI,
					m_journal_transaksi.DESKRIPSI
					FROM m_journal_transaksi';
if(!empty($searchkey)) $qry_mastertransaksi .= ' WHERE m_journal_transaksi.NAMA_TRANSAKSI LIKE "%' . $searchkey . '%"';					
$extparam = '&searchkey=' . $searchkey;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="35px" rowspan="2">No</th>
        <th width="400px" rowspan="2">Nama Transaksi</th>
        <th width="300px" colspan="2">POS</th>
		<th rowspan="2">Deskripsi</th>
        <th width="250px" rowspan="2">Option</th>
    </tr>
    <tr>
      <th width="150px">Debet</th>
      <th width="150px">Kredit</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_mastertransaksi, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td><?php echo $data['NAMA_TRANSAKSI']; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $data['DESKRIPSI']; ?></td>
			<td align="center">
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddtransaksi','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >tambah trans</a>
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddtransaksi&id=<?php echo $data['JOURNAL_TRANSAKSI_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >ubah</a>
				<?php
				$qry_mastertransaksi_detail = 'SELECT t_trans.*,m_akun.NAMA_AKUN
							FROM (
							SELECT m_journal_transaksi_detail.JOURNAL_TRANSAKSI_DETAIL_ID,
							m_journal_transaksi_detail.AKUN_ID,m_journal_transaksi_detail.POS,
							m_akun.KODE_AKUN,m_akun.NAMA_AKUN,m_akun.KODE_AKUN_INDUK
							FROM m_journal_transaksi_detail
							INNER JOIN m_akun ON (m_journal_transaksi_detail.AKUN_ID = m_akun.AKUN_ID)
							WHERE m_journal_transaksi_detail.JOURNAL_TRANSAKSI_ID = "' . $data['JOURNAL_TRANSAKSI_ID'] . '"
							) t_trans
							INNER JOIN m_akun 
							ON (t_trans.KODE_AKUN_INDUK = m_akun.KODE_AKUN)';
				$get_mastertransaksi_detail = mysql_query($qry_mastertransaksi_detail) or die(mysql_error()); 
				if(mysql_num_rows($get_mastertransaksi_detail) == 0){?>
				<a href="index.php?link=<?php echo $_REQUEST['link'] . '&idj=' . $data['JOURNAL_TRANSAKSI_ID'] . '&nmj=' . $data['NAMA_TRANSAKSI']; ?>">hapus</a>
				<?php } ?>
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddakuntrans&idj=<?php echo $data['JOURNAL_TRANSAKSI_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >tambah akun</a>
			</td>
        </tr>
        <? while($dat_mastertransaksi_detail = mysql_fetch_array($get_mastertransaksi_detail)){
			?>
			<tr>
			<td align="center">&nbsp;</td>
			<td align="center"><?php echo $dat_mastertransaksi_detail['KODE_AKUN']; ?></td>
			<td><?php echo $dat_mastertransaksi_detail['NAMA_AKUN']; ?></td>
			<td align="center"><?php echo (($dat_mastertransaksi_detail['POS_AKUN'] == 'D') ? 'Debet' : 'Kredit'); ?></td>
			<td><?php echo $dat_mastertransaksi_detail['DESKRIPSI']; ?></td>
			<td align="center">
				<a href="#" onclick="window.open('index.php?popup=keuanganformaddakun&prn=<?php echo $data['KODE_AKUN']; ?>&id=<?php echo $dat_mastertransaksi_detail['AKUN_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >ubah</a>
				<a href="index.php?link=<?php echo $_REQUEST['link'] . '&idk=' . $dat_mastertransaksi_detail['AKUN_ID'] . '&nmk=' . $dat_mastertransaksi_detail['NAMA_AKUN']; ?>">hapus</a>
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
			<td align="center"><a href="#" onclick="window.open('index.php?popup=keuanganformaddtransaksi','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=500')" >tambah trans</a></td>
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