<?php
$ruang_id = '';
$nama_ruang = '';
$kelas = '';
$jml_tmp_tidur = '';
$jns_rawat = '';
$jns_rawat_detail = '';
$deskripsi = '';
$kode_ruang = '';
$kode_ruang_yankes = '';
$aktif = '';
$bangsal = '';
$kusta = '';

if (isset($_POST['ruang_id'])) {
    $ruang_id = $_POST['ruang_id'];
    $nama_ruang = $_POST['nama_ruang'];
    $kelas = $_POST['kelas'];
	$jml_tmp_tidur = $_POST['jml_tmp_tidur'];
	$jns_rawat = $_POST['jns_rawat'];
	//$jns_rawat_detail = $_POST['jns_rawat_detail'];
	$deskripsi = $_POST['deskripsi'];
	$kode_ruang = $_POST['kode_ruang'];
	$kode_ruang_yankes = $_POST['kode_ruang_yankes'];
	$bangsal = $_POST['bangsal'];
    if (isset($_POST['kusta']))
        $kusta = '1';
	if (isset($_POST['aktif']))
        $aktif = '1';
    if (!empty($ruang_id)) {
        mysql_query('UPDATE m_ruang SET NAMA_RUANG = "' . $nama_ruang . '",KELAS_RAWAT = "' . $kelas . '",JML_TMP_TIDUR = "' . $jml_tmp_tidur . '" ,
					JNS_PERAWATAN = "' . $jns_rawat . '",DESKRIPSI = "' . $deskripsi . '", ST_AKTIF= "' . $aktif . '",
					JNS_PERAWATAN_DETAIL = "' . $jns_rawat_detail . '",BANGSAL = "' . $bangsal . '",
					KODE_RUANG_BPJS = "' . $kode_ruang . '",KODE_RUANG_YANKES = "' . $kode_ruang_yankes . '",
					KUSTA = "' . $kusta . '"
					WHERE RUANG_ID = "' . $ruang_id . '"') or die(mysql_error());
    } else {
		mysql_query('INSERT INTO m_ruang (NAMA_RUANG,KELAS_RAWAT,JML_TMP_TIDUR,JNS_PERAWATAN,DESKRIPSI,ST_AKTIF,
					JNS_PERAWATAN_DETAIL,BANGSAL,KODE_RUANG_BPJS,KODE_RUANG_YANKES,KUSTA) VALUES 
					("' . $nama_ruang . '","' . $kelas . '","' . $jml_tmp_tidur . '","' . $jns_rawat . '","' . $deskripsi . '","' . $aktif . '",
					"' . $jns_rawat_detail . '","' . $bangsal . '","' . $kode_ruang . '","' . $kode_ruang_yankes . '",
					"' . $kusta . '")') or die(mysql_error());
    }
    $ruang_id = '';
	$nama_ruang = '';
	$kelas = '';
	$jml_tmp_tidur = '';
	$jns_rawat = '';
	$bangsal = '';
	$jns_rawat_detail = '';
	$deskripsi = '';
	$kode_ruang = '';
	$kode_ruang_yankes = '';
	$aktif = '';
	$kusta = '';

    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $ruang_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_ruang WHERE RUANG_ID = ' . $ruang_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $nama_ruang = $dat['NAMA_RUANG'];
    $kelas = $dat['KELAS_RAWAT'];
    $jml_tmp_tidur = $dat['JML_TMP_TIDUR'];
	$jns_rawat = $dat['JNS_PERAWATAN'];
	$jns_rawat_detail = $dat['JNS_PERAWATAN_DETAIL'];
	$bangsal = $dat['BANGSAL'];
	$deskripsi = $dat['DESKRIPSI'];
	$kode_ruang = $dat['KODE_RUANG_BPJS'];
	$kode_ruang_yankes = $dat['KODE_RUANG_YANKES'];
	$aktif = $dat['ST_AKTIF'];
	$kusta = $dat['KUSTA'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_ruang WHERE RUANG_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND BANGSAL LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $user_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $user_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $user_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="ruang_id" id="ruang_id" value="<?php echo $ruang_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Bangsal - Nama Ruang</td><td colspan="3"><input name="bangsal" type="text" id="bangsal"  class="text_dt" value="<?php echo $bangsal; ?>" size="20" />-<input name="nama_ruang" type="text" id="nama_ruang"  class="text_dt" value="<?php echo $nama_ruang; ?>" size="40" /></td></tr>
        <tr><td>Kelas Rawat</td><td>
		<select name="kelas" id="kelas" class="text_dt">
		<?php
			$sql_kelas = 'SELECT * FROM m_kelas_rawat ORDER BY URUT';
			$get_kelas = mysql_query($sql_kelas) or die(mysql_error);
			while($dat_kelas = mysql_fetch_array($get_kelas)){
			?>
			<option value="<?php echo $dat_kelas['KELAS_RAWAT']; ?>" <?php if ($kelas == $dat_kelas['KELAS_RAWAT']) echo 'selected="selected"'; ?>><?php echo $dat_kelas['KELAS_RAWAT']; ?></option>
			<?php
			}	
		?>	
		</select>
		</td>
		<td width="150">Jumlah Tempat Tidur</td><td><input name="jml_tmp_tidur" type="text" id="jml_tmp_tidur"  class="text_dt" value="<?php echo $jml_tmp_tidur; ?>" size="10" /></td></tr>
		<tr><td>Jenis Perawatan</td><td colspan="3"><input name="jns_rawat" type="text" id="jns_rawat"  class="text_dt" value="<?php echo $jns_rawat; ?>" size="40" /></td></tr>
		<tr><td>Deskripsi</td><td colspan="3"><input name="deskripsi" type="text" id="deskripsi"  class="text_dt" value="<?php echo $deskripsi; ?>" size="60" /></td></tr>
		 <tr><td>&nbsp;</td><td>Kusta&nbsp;&nbsp;<input type="checkbox" name="kusta" value="1" <?php if ($kusta == '1') echo 'checked="checked"'; ?>/></td>
		<tr><td>Id Ruang Applicare</td><td colspan="3"><input name="kode_ruang" type="text" id="kode_ruang"  class="text_dt" value="<?php echo $kode_ruang; ?>" size="20" /></td></tr>
		<tr><td>Id Ruang Yankes</td><td colspan="3"><input name="kode_ruang_yankes" type="text" id="kode_ruang_yankes"  class="text_dt" value="<?php echo $kode_ruang_yankes; ?>" size="20" /></td></tr>
        <tr><td>&nbsp;</td><td>Aktif&nbsp;&nbsp;<input type="checkbox" name="aktif" value="1" <?php if ($aktif == '1') echo 'checked="checked"'; ?>/></td>
		<td align="right" colspan="2"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>
<br />
<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
				<select name="searchkey" id="searchkey" class="text_dt">
                    <option> - </option>
                    <?php $get_prop = mysql_query('SELECT DISTINCT BANGSAL FROM m_ruang WHERE ST_AKTIF = "1" ORDER BY BANGSAL');
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['BANGSAL']; ?>" <?php if ($searchkey == $dat_prop['BANGSAL']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['BANGSAL']; ?></option>
					<?php } ?>
                </select>&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="10">Id</th>
			<th>Bangsal - Nama Ruang</th>
			<th>Kelas</th>
			<th>Perawatan</th>
			<th>Deskripsi</th>
			<th>Kusta</th>
			<th>Id Ruang<br/>Applicare</th>
			<th>Id Ruang<br/>Yankes</th>
			<th>Tmp Tidur</th>
			<th>Jml Isi</th>
			<!--<th>Aktif</th>-->
			<th>Option</th>
		</tr>
        <?php
        $sql = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.JML_TMP_TIDUR,m_ruang.JNS_PERAWATAN,
				m_ruang.DESKRIPSI,COUNT(t_irna.IRNA_ID) AS JML_TMP_TIDUR_ISI,
				CASE WHEN m_ruang.ST_AKTIF = "1" THEN "&radic;" END AS AKTIF,
				m_ruang.BANGSAL,m_ruang.KODE_RUANG_BPJS,m_ruang.KODE_RUANG_YANKES,
				m_ruang.KUSTA
				FROM m_ruang
				LEFT JOIN t_irna ON (m_ruang.RUANG_ID = t_irna.RUANG_ID AND t_irna.ST_PULANG IS NULL AND t_irna.ST_BATAL IS NULL AND t_irna.NO_PENDAFTARAN IS NOT NULL) 
				WHERE 1 ' . $sql_search . ' 
				AND m_ruang.ST_AKTIF = "1"
				GROUP BY m_ruang.RUANG_ID
				ORDER BY NAMA_RUANG,KELAS_RAWAT';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['RUANG_ID'] . '</td>';
            echo '<td>' . str_replace('R.R.','',$dat['BANGSAL']) . ' - ' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td>' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td>' . $dat['JNS_PERAWATAN'] . '</td>';
			echo '<td>' . $dat['DESKRIPSI'] . '</td>';
			echo '<td>' . (($dat['KUSTA'] == '1') ? '&radic;' : '') . '</td>';
			echo '<td>' . $dat['KODE_RUANG_BPJS'] . '</td>';
			echo '<td>' . $dat['KODE_RUANG_YANKES'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_ISI'] . '</td>';
            //echo '<td align="center">' . $dat['AKTIF'] . '</td>';
            echo '<td align="center" width="100"><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['RUANG_ID'] . '&searchkey=' . $searchkey . '">edit</a></td></tr>';
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
									Total Jumlah Bed :
									<?php
										$sql_kamar = 'SELECT SUM(JML_TMP_TIDUR) AS JML FROM m_ruang
											WHERE ST_AKTIF = "1"';
										$get_kamar = mysql_query($sql_kamar) or die(mysql_error());
										$dat_kamar = mysql_fetch_assoc($get_kamar);
										echo $dat_kamar['JML'];	
									?>	
								</td>
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