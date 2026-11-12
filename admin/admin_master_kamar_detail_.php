<?php
$ruang_detail_id = '';
$no_tmp_tidur = '';
$ruang_id = '';
$lk_pr = '';
$dw_an_by = '';

if (isset($_POST['ruang_detail_id'])) {
    $ruang_detail_id = $_POST['ruang_detail_id'];
    $no_tmp_tidur = $_POST['no_tmp_tidur'];
    $ruang_id = $_POST['ruang_id'];
	if(isset($_POST['lk_pr_1'])) $lk_pr = $lk_pr . $_POST['lk_pr_1'];
	if(isset($_POST['lk_pr_2'])) $lk_pr = $lk_pr . $_POST['lk_pr_2'];
	if(isset($_POST['dw_an_by_1'])) $dw_an_by = $dw_an_by . $_POST['dw_an_by_1'];
	if(isset($_POST['dw_an_by_2'])) $dw_an_by = $dw_an_by . $_POST['dw_an_by_2'];
	if(isset($_POST['dw_an_by_3'])) $dw_an_by = $dw_an_by . $_POST['dw_an_by_3'];
    if (!empty($ruang_detail_id)) {
        mysql_query('UPDATE m_ruang_detail SET NO_TMP_TIDUR = "' . $no_tmp_tidur . '",
					RUANG_ID = "' . $ruang_id . '",
					LK_PR = "' . $lk_pr . '",
					DW_AN_BY = "' . $dw_an_by . '" 
					WHERE RUANG_DETAIL_ID = "' . $ruang_detail_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO m_ruang_detail (NO_TMP_TIDUR,RUANG_ID,LK_PR,DW_AN_BY) 
					VALUES ("' . $no_tmp_tidur . '","' . $ruang_id . '","' . $lk_pr . '","' . $dw_an_by . '")') or die(mysql_error());
		$sql_id = 'SELECT MAX(RUANG_DETAIL_ID) AS MAX_RUANG 
					FROM m_ruang_detail
					WHERE RUANG_ID = "' . $ruang_id . '"';
		$get_id = mysql_query($sql_id) or die(mysql_error());
		$dat_id = mysql_fetch_assoc($get_id);
		$ruang_detail_id = $dat_id['MAX_RUANG']; 	
    }
	
	mysql_query('DELETE FROM m_ruang_detail_tipe_pasien WHERE RUANG_DETAIL_ID = "' . $ruang_detail_id . '"') or die(mysql_error());
	
	$y = 1;
	while($y < 30){
		if(isset($_POST['type_pasien' . $y])){
			$vl = $_POST['type_pasien' . $y];
			mysql_query('INSERT INTO m_ruang_detail_tipe_pasien(RUANG_DETAIL_ID,TIPE_PASIEN_ID)
						VALUES("' . $ruang_detail_id . '","' . $vl . '")') or die(mysql_error());
		}
	$y++;
	}
	
    $ruang_detail_id = '';
    $no_tmp_tidur = '';
    $ruang_id = '';
	$lk_pr = '';
	$dw_an_by = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $ruang_detail_id = $_GET['ide'];
    $sql = 'SELECT * FROM m_ruang_detail WHERE RUANG_DETAIL_ID = ' . $ruang_detail_id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $no_tmp_tidur = $dat['NO_TMP_TIDUR'];
    $ruang_id = $dat['RUANG_ID'];
	$lk_pr = $dat['LK_PR'];
	$dw_an_by = $dat['DW_AN_BY'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_ruang_detail WHERE RUANG_DETAIL_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND CONCAT(m_ruang_detail.NO_TMP_TIDUR, m_ruang.NAMA_RUANG, m_ruang.KELAS_RAWAT) LIKE "%' . $searchkey . '%"';
}

if (isset($_GET['idd'])) {
    $ruang_detail_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $ruang_detail_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $ruang_detail_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="ruang_detail_id" id="ruang_detail_id" value="<?php echo $ruang_detail_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table class="tableform" border="0" width="750">
        <tr><td>Nomor Tempat Tidur</td>
            <td colspan="2"><input type="text" name="no_tmp_tidur" id="no_tmp_tidur" value="<?php echo $no_tmp_tidur; ?>" class="text_dt" size="30" /></td>
        </tr>
		<tr><td>Untuk Pasien</td>
			<td width="120">Jenis Kelamin :</td>
            <td>Laki - laki<input type="checkbox" name="lk_pr_1" value="LK" <?php if (strpos($lk_pr, 'LK') !== false) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;&nbsp;
			Perempuan<input type="checkbox" name="lk_pr_2" value="PR" <?php if (strpos($lk_pr, 'PR') !== false) echo 'checked="checked"'; ?> >
			</td>
        </tr>
		<tr><td>&nbsp;</td>
			<td>Umur :</td>
            <td>Dewasa<input type="checkbox" name="dw_an_by_1" value="DW" <?php if (strpos($dw_an_by, 'DW') !== false) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;&nbsp;
			Anak<input type="checkbox" name="dw_an_by_2" value="AN" <?php if (strpos($dw_an_by, 'AN') !== false) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;&nbsp;
			Bayi<input type="checkbox" name="dw_an_by_3" value="BY" <?php if (strpos($dw_an_by, 'BY') !== false) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
        </tr>
		<tr><td>&nbsp;</td>
			<td valign="top">Tipe Perawatan :</td>
            <td>
				<?php
					$arr_tipe_pasien = array();
					if(!empty($ruang_detail_id)){
						$sql_tipe = 'SELECT TIPE_PASIEN_ID FROM m_ruang_detail_tipe_pasien WHERE RUANG_DETAIL_ID = "' . $ruang_detail_id . '"';	
						$get_tipe = mysql_query($sql_tipe) or die(mysql_error());
						while($dat_tipe = mysql_fetch_array($get_tipe)){
							$arr_tipe_pasien[$dat_tipe['TIPE_PASIEN_ID']] = $dat_tipe['TIPE_PASIEN_ID']; 
						}	
					}
					
					$sql_pasien = 'SELECT * FROM m_tipe_pasien';
					$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
					$x = 1;
					$i = 1;
					while($dat_pasien = mysql_fetch_array($get_pasien)){
						echo $dat_pasien['TIPE_PASIEN'];
						?>
						<input type="checkbox" name="type_pasien<?php echo $i; ?>" value="<?php echo $dat_pasien['TIPE_PASIEN_ID']; ?>" 
						<?php
						if(isset($arr_tipe_pasien[$dat_pasien['TIPE_PASIEN_ID']])) echo 'checked="checked"';
						echo '/>&nbsp;&nbsp;&nbsp;&nbsp;';
						if($x == 3){
							echo '<br />';
							$x = 0;
						}
					$x++; 
					$i++;
					}
				?>
			</td>
        </tr>
		<tr><td>Ruang Rawat</td>
            <td colspan="2"><select name="ruang_id" id="ruang_id" class="text_dt">
                    <option> - </option>
                    <?php $get_prop = mysql_query('SELECT * FROM m_ruang WHERE ST_AKTIF = "1" ORDER BY NAMA_RUANG');
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['RUANG_ID']; ?>" <?php if ($ruang_id == $dat_prop['RUANG_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['NAMA_RUANG'] . ' KELAS ' . $dat_prop['KELAS_RAWAT']; ?></option>
<?php } ?>
                </select></td>
        </tr>
        <tr><td colspan="3" align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>
<form name="form2" method="post" action="index.php">
        <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <select name="searchkey" id="searchkey" class="text_dt">
                    <option> - </option>
                    <?php mysql_data_seek($get_prop,0);
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['RUANG_ID']; ?>" <?php if ($searchkey == $dat_prop['RUANG_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['NAMA_RUANG'] . ' (' . $dat_prop['KELAS_RAWAT'] . ')'; ?></option>
<?php } ?>
                </select>&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">

        <tr>
            <th width="10">Id</th><th>Ruang Rawat</th><th>Deskripsi</th>
			<th>Lk - Pr</th><th>Dw - An - By</th>
			<th>Tipe Perawatan</th>
			<th width="100">Nomor Tempat Tidur</th><th width="100">Action</th></tr>
        <?php
        $sql = 'SELECT m_ruang_detail.RUANG_DETAIL_ID,m_ruang_detail.NO_TMP_TIDUR,m_ruang_detail.RUANG_ID,CONCAT(m_ruang.NAMA_RUANG, " Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				COUNT(t_irna.IRNA_ID) AS JML_TMP_TIDUR_ISI,
				m_ruang.DESKRIPSI,m_ruang_detail.LK_PR,m_ruang_detail.DW_AN_BY
				FROM m_ruang_detail
				INNER JOIN m_ruang ON (m_ruang_detail.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN t_irna ON (m_ruang_detail.RUANG_ID = t_irna.RUANG_ID 
						AND t_irna.ST_PULANG IS NULL 
						AND t_irna.ST_BATAL IS NULL AND t_irna.NO_PENDAFTARAN IS NOT NULL)
				WHERE m_ruang.ST_AKTIF = "1"		
								' . $sql_search . '		
				GROUP BY m_ruang_detail.RUANG_DETAIL_ID,m_ruang_detail.NO_TMP_TIDUR,m_ruang_detail.RUANG_ID,CONCAT(m_ruang.NAMA_RUANG, " Kelas",m_ruang.KELAS_RAWAT)
				ORDER BY NAMA_RUANG, NO_TMP_TIDUR';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['RUANG_DETAIL_ID'] . '</td>';
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
			echo '<td>' . $dat['DESKRIPSI'] . '</td>';
			echo '<td align="center">' . $dat['LK_PR'] . '</td>';
			echo '<td align="center">' . $dat['DW_AN_BY'] . '</td><td>';
			
			$sql_tipe_perawatan = 'SELECT m_tipe_pasien.TIPE_PASIEN
								FROM m_ruang_detail_tipe_pasien
								INNER JOIN m_tipe_pasien ON (m_ruang_detail_tipe_pasien.TIPE_PASIEN_ID = m_tipe_pasien.TIPE_PASIEN_ID)
								WHERE RUANG_DETAIL_ID = "' . $dat['RUANG_DETAIL_ID'] . '"';
			$get_tipe_perawatan = mysql_query($sql_tipe_perawatan) or die(mysql_error());
			$tipe_rawat = '';
			while($tp = mysql_fetch_array($get_tipe_perawatan)){
				$tipe_rawat = $tipe_rawat . $tp['TIPE_PASIEN'] . ', ';
			}
			$tipe_rawat = substr($tipe_rawat,0,strlen($tipe_rawat) - 2);
			echo $tipe_rawat;	
			echo '</td><td align="center">' . $dat['NO_TMP_TIDUR'] . '</td>';
			$isi = '';
			if($dat['JML_TMP_TIDUR_ISI'] > 0) $isi = '&radic;';
            echo '<td align="center"><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['RUANG_DETAIL_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['RUANG_DETAIL_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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