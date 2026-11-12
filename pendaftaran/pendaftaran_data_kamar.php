<?php
$searchkey = '';
if (isset($_SESSION['pendaftaransearchkamar_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchkamar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchkamar_searchkey'] = $searchkey;
}
?>	
<form name="search" method="get" action="index.php">
   <table class="tableform" border="0" >
        <tr>
            <td>Nama Kamar/ Ruang</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />	
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="10" rowspan="2">No</th>
			<th rowspan="2">Nama Ruang</th>
			<th rowspan="2">Kelas</th>
			<th rowspan="2">Perawatan</th>
			<th rowspan="2">Deskripsi</th>
			<th colspan="4">Tempat Tidur</th>
			<th colspan="3">Terisi</th>
			<th colspan="3">Booking</th>
			<th rowspan="2">Ketersediaan</th>
		</tr>
        <tr>
		  <th>Jumlah</th>		
          <th>Lk</th>
          <th>Pr</th>
          <th>Lk/Pr</th>
		  <th>Jumlah</th>		
          <th>Lk</th>
          <th>Pr</th>
		  <th>Jumlah</th>
		  <th>Lk</th>
          <th>Pr</th>
		  <!--<th>Jumlah</th>
		  <th>Lk</th>
          <th>Pr</th>-->
        </tr>
        <?php
        $sql = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
							m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,m_ruang.JML_TMP_TIDUR,
							SUM(t_ruang.JML_TMP_TIDUR_LK) AS JML_TMP_TIDUR_LK,
							SUM(t_ruang.JML_TMP_TIDUR_PR) AS JML_TMP_TIDUR_PR,
							SUM(t_ruang.JML_TMP_TIDUR_LKPR) AS JML_TMP_TIDUR_LKPR,
							SUM(t_ruang.JML_TMP_TIDUR_ISI_LK) AS JML_TMP_TIDUR_ISI_LK,
							SUM(t_ruang.JML_TMP_TIDUR_ISI_PR) AS JML_TMP_TIDUR_ISI_PR,
							SUM(t_ruang.JML_TMP_TIDUR_BOOKING_LK) AS JML_TMP_TIDUR_BOOKING_LK,
							SUM(t_ruang.JML_TMP_TIDUR_BOOKING_PR) AS JML_TMP_TIDUR_BOOKING_PR
							FROM m_ruang
							LEFT JOIN (
								SELECT m_ruang_detail.RUANG_ID,
								CASE WHEN m_ruang_detail.LK_PR = "LK" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_LK,
								CASE WHEN m_ruang_detail.LK_PR = "PR" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_PR,
								CASE WHEN m_ruang_detail.LK_PR = "LKPR" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_LKPR,
								0 AS JML_TMP_TIDUR_ISI_LK,
								0 AS JML_TMP_TIDUR_ISI_PR,
								0 AS JML_TMP_TIDUR_BOOKING_LK,
								0 AS JML_TMP_TIDUR_BOOKING_PR
								FROM m_ruang_detail								
								UNION ALL
								SELECT t_irna.RUANG_ID,
								0 AS JML_TMP_TIDUR_LK,
								0 AS JML_TMP_TIDUR_PR,
								0 AS JML_TMP_TIDUR_LKPR,
								CASE WHEN m_pasien.JNS_KELAMIN = "L" AND t_irna.PASIEN_MASUK IS NOT NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_ISI_LK,
								CASE WHEN m_pasien.JNS_KELAMIN = "P" AND t_irna.PASIEN_MASUK IS NOT NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_ISI_PR,
								CASE WHEN m_pasien.JNS_KELAMIN = "L" AND t_irna.PASIEN_MASUK IS NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_BOOKING_LK,
								CASE WHEN m_pasien.JNS_KELAMIN = "P" AND t_irna.PASIEN_MASUK IS NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_BOOKING_PR
								FROM t_irna
								INNER JOIN m_pasien
								ON (t_irna.NOMR = m_pasien.NOMR)
								WHERE t_irna.ST_PULANG IS NULL 
								AND t_irna.ST_BATAL IS NULL 
								AND t_irna.NO_PENDAFTARAN IS NOT NULL
							) t_ruang
							ON (m_ruang.RUANG_ID = t_ruang.RUANG_ID)
							WHERE m_ruang.ST_AKTIF = "1"';

				if(!empty($searchkey)){
					$searchkey = str_replace(' ', '%', $searchkey);
					$sql = $sql . ' AND m_ruang.NAMA_RUANG LIKE "%' . $searchkey . '%"';
				}

				$sql = $sql . ' 
							GROUP BY m_ruang.RUANG_ID
							ORDER BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT';
		$no = 0;		
        $pager = new PS_Pagination($connect, $sql, 15, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
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
			$nomor = ($hal * 15) + $no;
			
			$jumlah_kamar_lk = $dat['JML_TMP_TIDUR_LK'];
			$jumlah_kamar_pr = $dat['JML_TMP_TIDUR_PR'];
			$jumlah_kamar_lkpr = $dat['JML_TMP_TIDUR_LKPR'];
									
			$jumlah_pasien_lk = $dat['JML_TMP_TIDUR_ISI_LK'];
			$jumlah_pasien_pr = $dat['JML_TMP_TIDUR_ISI_PR'];
			
			$tersedia = $dat['JML_TMP_TIDUR'] - ($dat['JML_TMP_TIDUR_ISI_LK'] + $dat['JML_TMP_TIDUR_ISI_PR'] + $dat['JML_TMP_TIDUR_BOOKING_LK'] + $dat['JML_TMP_TIDUR_BOOKING_PR']);
									
			$tersedia_kamar_lk = 0;
			$tersedia_kamar_pr = 0;
									
			if($jumlah_kamar_lkpr == 0){
									
				$tersedia_kamar_lk = $jumlah_kamar_lk - $jumlah_pasien_lk;
				$tersedia_kamar_pr = $jumlah_kamar_pr - $jumlah_pasien_pr;
									
			}else if($jumlah_kamar_lkpr > 0 and $jumlah_kamar_lk == 0 and $jumlah_kamar_pr == 0){
										
				$jumlah_pasien_lkpr = $jumlah_pasien_lk + $jumlah_pasien_pr;
				if($jumlah_pasien_lkpr >= $jumlah_kamar_lkpr){
					$tersedia_kamar_lk = 0;
					$tersedia_kamar_pr = 0;
				}else{
					$tersedia_kamar_lk = $jumlah_kamar_lkpr - $jumlah_pasien_lkpr;
					$tersedia_kamar_pr = $jumlah_kamar_lkpr - $jumlah_pasien_lkpr;
				}	
									
			}else if($jumlah_kamar_lkpr > 0 and ($jumlah_kamar_lk > 0 or $jumlah_kamar_pr > 0)){
										
				if($jumlah_pasien_lk < $jumlah_kamar_lk) $tersedia_kamar_lk += $jumlah_kamar_lk - $jumlah_pasien_lk;
				if($jumlah_pasien_pr < $jumlah_kamar_pr) $tersedia_kamar_pr += $jumlah_kamar_pr - $jumlah_pasien_pr; 	
										
				$sisa_pasien_lk = 0;
				$sisa_pasien_pr = 0;
				if($jumlah_pasien_lk > $jumlah_kamar_lk) $sisa_pasien_lk += $jumlah_pasien_lk - $jumlah_kamar_lk;
				if($jumlah_pasien_pr > $jumlah_kamar_pr) $sisa_pasien_pr += $jumlah_pasien_pr - $jumlah_kamar_pr;

				if($jumlah_kamar_lkpr > ($sisa_pasien_lk + $sisa_pasien_pr)) {
					$tersedia_kamar_lk += $jumlah_kamar_lkpr - ($sisa_pasien_lk + $sisa_pasien_pr);
					$tersedia_kamar_pr += $jumlah_kamar_lkpr - ($sisa_pasien_lk + $sisa_pasien_pr);
				}
										
			}
	
            echo '<tr>';
            echo '<td align="center">' . $nomor . '</td>';
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td>' . $dat['JNS_PERAWATAN'] . '</td>';
			echo '<td>' . $dat['DESKRIPSI'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_PR'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_LKPR'] . '</td>';
			echo '<td align="right">' . ($dat['JML_TMP_TIDUR_ISI_LK'] + $dat['JML_TMP_TIDUR_ISI_PR']) . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_ISI_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_ISI_PR'] . '</td>';
			echo '<td align="right">' . ($dat['JML_TMP_TIDUR_BOOKING_LK'] + $dat['JML_TMP_TIDUR_BOOKING_PR']) . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_BOOKING_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_BOOKING_PR'] . '</td>';
			echo '<td align="right">' . (($tersedia > 0) ? $tersedia : 0) . '</td>';
			//echo '<td align="right">' . (($tersedia_kamar_lk > 0) ? $tersedia_kamar_lk : 0) . '</td>';
			//echo '<td align="right">' . (($tersedia_kamar_pr > 0) ? $tersedia_kamar_pr : 0) . '</td>';
			echo '</tr>';
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
<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="xlsfile" value="pendaftaran/xls_rekap_data_kamar.php" />
            <input type="hidden" name="xlsname" value="rpt_data_kamar.xls" />            
        </form>		