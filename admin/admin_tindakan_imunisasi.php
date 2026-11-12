<?php
$searchkey = '';

$kode_tarif = '';
$imunisasi ='';
$ekg ='';
$klaim = '';
$persediaan_1 = '';
$persediaan_2 = '';
$persediaan_3 = '';
$persediaan_4 = '';

if(isset($_POST['simpan'])){
	$kode_tarif = $_POST['kode_tarif'];
	$imunisasi = $_POST['imunisasi'];
	if(isset($_POST['ekg'])) $ekg = $_POST['ekg'];
	if(isset($_POST['klaim'])) $klaim = $_POST['klaim'];
	$persediaan_1 = $_POST['persediaan_1'];
	$persediaan_2 = $_POST['persediaan_2'];
	$persediaan_3 = $_POST['persediaan_3'];
	$persediaan_4 = $_POST['persediaan_4'];
			
	$arr_kode_tarif = explode('--',$kode_tarif);
	if(sizeof($arr_kode_tarif) == 2) $kode_tarif = $arr_kode_tarif[0];
	
	$arr_persediaan_1 = explode('--',$persediaan_1);
	if(sizeof($arr_persediaan_1) == 2) $persediaan_1 = $arr_persediaan_1[0];
	
	$arr_persediaan_2 = explode('--',$persediaan_2);
	if(sizeof($arr_persediaan_2) == 2) $persediaan_2 = $arr_persediaan_2[0];
	
	$arr_persediaan_3 = explode('--',$persediaan_3);
	if(sizeof($arr_persediaan_3) == 2) $persediaan_3 = $arr_persediaan_3[0];
	
	$arr_persediaan_4 = explode('--',$persediaan_4);
	if(sizeof($arr_persediaan_4) == 2) $persediaan_4 = $arr_persediaan_4[0];
	
	$sql_tarif = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '"
					AND ST_AKTIF = "1"';
	$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
	$dat_tarif = mysql_fetch_assoc($get_tarif);
	$tarif_id = $dat_tarif['TARIF_ID'];	
	
	$persediaan = '';
	if($persediaan_1 != '') $persediaan .= $persediaan_1 . ',';
	if($persediaan_2 != '') $persediaan .= $persediaan_2 . ',';
	if($persediaan_3 != '') $persediaan .= $persediaan_3 . ',';
	if($persediaan_4 != '') $persediaan .= $persediaan_4 . ',';
	
	if($persediaan != ''){
		$persediaan = substr($persediaan,0,strlen($persediaan) - 1);
	}else{
		$persediaan = 'NULL';
	}
	
	mysql_query('UPDATE m_tarif SET IMUNISASI = "' . $imunisasi . '",
					UNIT_ID = "' . $ekg . '",
					TDK_KLAIM = "' . $klaim . '",
					PERSEDIAAN = "' . $persediaan . '"
					WHERE TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());			
	$kode_tarif = '';
	$imunisasi ='';
	$ekg ='';
	$klaim = '';
	$persediaan_1 = '';
	$persediaan_2 = '';
	$persediaan_3 = '';
	$persediaan_4 = '';
	$msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['idx'])) {
	$tarif_id = $_GET['idx'];
    mysql_query('UPDATE m_tarif SET IMUNISASI = NULL,
					UNIT_ID = NULL,
					TDK_KLAIM = NULL,
					PERSEDIAAN = NULL
					WHERE TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

if (isset($_GET['idd'])) {
    $id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}	
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#tarif").autocomplete("index.php?autocomp=autocompadmintarif",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#persediaan_1").autocomplete("index.php?autocomp=autocompadminfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#persediaan_2").autocomplete("index.php?autocomp=autocompadminfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#persediaan_3").autocomplete("index.php?autocomp=autocompadminfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#persediaan_4").autocomplete("index.php?autocomp=autocompadminfarmasi",{width: 450});
    });
</script>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="tarif_pemeriksaan_id" id="tarif_pemeriksaan_id" value="<?php echo $tarif_pemeriksaan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="" />
    <table width="60%" class="tableform">
	<tr>
		<td width="230px">Kode Tarif</td>
		<td><input type="text" name="kode_tarif" id="tarif" value="<?php echo $kode_tarif; ?>"  class="text_dt" style="width:450px;" /></td>
	</tr>
	<tr>
		<td>Imunisasi</td>
		<td>
		<select name="imunisasi" id="imunisasi" class="text_dt" style="width:210px;" />
		<option value="" >-</option>
		<option value="1" >BCG</option>
		<option value="2" >DPT</option>
		<option value="3" >Campak</option>
		<option value="4" >Polio</option>
		<option value="5" >Tetanus Formal Toxoid</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Tindakan Penunjang EKG/EEG/USG</td>
		<td><input type="checkbox" name="ekg" value="52" /></td>
	</tr>
	<tr>
		<td>Tidak Klaim</td>
		<td><input type="checkbox" name="klaim" value="1" /></td>
	</tr>
	<tr>
		<td width="230px">Persediaan</td>
		<td><input type="text" name="persediaan_1" id="persediaan_1" value="<?php echo $persediaan_1; ?>"  class="text_dt" style="width:450px;" /></td>
	</tr>
	<tr>
		<td width="230px">&nbsp;</td>
		<td><input type="text" name="persediaan_2" id="persediaan_2" value="<?php echo $persediaan_2; ?>"  class="text_dt" style="width:450px;" /></td>
	</tr>
	<tr>
		<td width="230px">&nbsp;</td>
		<td><input type="text" name="persediaan_3" id="persediaan_3" value="<?php echo $persediaan_3; ?>"  class="text_dt" style="width:450px;" /></td>
	</tr>
	<tr>
		<td width="230px">&nbsp;</td>
		<td><input type="text" name="persediaan_4" id="persediaan_4" value="<?php echo $persediaan_4; ?>"  class="text_dt" style="width:450px;" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" name="simpan" value="simpan" class="myButton" /></td> 
	</tr>
</table>
</form>

<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <input type="text" name="searchkey"  class="text_dt" style="width:200px;" id="searchkey" value="<?php echo $searchkey; ?>" />&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
			<th>Group Tarif</th>
			<th width="70">Kode</th>
			<th>Nama Tarif</th>
			<th width="70">Imunisasi</th>
			<th width="70">EKG/EEG/USG</th>
			<th width="70">Tidak Klaim</th>
			<th>Persediaan</th>
			<th width="50">Action</th></tr>
        <?php
        $sql = 'SELECT m_tarif_group.NAMA_TARIF_GROUP,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
				CASE WHEN m_tarif.ST_AKTIF = "1" THEN "&radic;" END AS ST_AKTIF,
				m_tarif.TAHUN_UPDATE,
				CASE WHEN m_tarif.IMUNISASI = "1" THEN "BCG"
					WHEN m_tarif.IMUNISASI = "2" THEN "DPT"
					WHEN m_tarif.IMUNISASI = "3" THEN "Campak"
					WHEN m_tarif.IMUNISASI = "4" THEN "Polio"
					WHEN m_tarif.IMUNISASI = "5" THEN "Tetanus Formal Toxoid"
				END AS IMUNISASI,m_tarif.TARIF_ID,m_tarif.UNIT_ID,
				m_tarif.TDK_KLAIM,m_tarif.PERSEDIAAN		
				FROM m_tarif_group
				INNER JOIN m_tarif ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE (m_tarif.IMUNISASI > 0
				OR m_tarif.UNIT_ID = 52
				OR m_tarif.TDK_KLAIM = "1"
				OR m_tarif.PERSEDIAAN IS NOT NULL)
				AND m_tarif.ST_AKTIF = "1"';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td>' . $dat['NAMA_TARIF_GROUP'] . '</td>';
			echo '<td align="center">' . $dat['KODE_TARIF'] . '</td>';
			echo '<td>' . $dat['NAMA_TARIF'] . '</td>';
			echo '<td align="center">' . $dat['IMUNISASI'] . '</td>';
			echo '<td align="center">' . (($dat['UNIT_ID'] == '52') ? '&radic;' : '') . '</td>';
			echo '<td align="center">' . (($dat['TDK_KLAIM'] == '1') ? '&radic;' : '') . '</td>';
			echo '<td>' . $dat['PERSEDIAAN'] . '</td>';
            echo '<td align="center"><a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['TARIF_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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