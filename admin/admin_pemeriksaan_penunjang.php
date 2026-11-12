<?php
$tarif_pemeriksaan_id = '';
$kode_tarif ='';
$ch_level ='';
$ch_report ='';
$nama_pemeriksaan_order ='';
$nama_pemeriksaan_group ='';
$nama_pemeriksaan ='';
$report_format ='';
$report_order ='';
$satuan ='';
$nilai_rujukan ='';
$form_hasil ='';
$text_hasil ='';

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND (NAMA_PEMERIKSAAN LIKE "%' . $searchkey . '%" OR NAMA_PEMERIKSAAN_ORDER LIKE "%' . $searchkey . '%") ';
}

if(isset($_POST['simpan'])){
	$tarif_pemeriksaan_id = $_POST['tarif_pemeriksaan_id'];
	$kode_tarif = $_POST['kode_tarif'];
	$arr_kode_tarif = explode('--',$kode_tarif);
	if(sizeof($arr_kode_tarif) == 2) $kode_tarif = $arr_kode_tarif[0];
	$ch_level = '';
	if(isset($_POST['ch_level'])) $ch_level = $_POST['ch_level'];
	$ch_report = $_POST['ch_report'];
	$nama_pemeriksaan_order = $_POST['nama_pemeriksaan_order'];
	$nama_pemeriksaan_group = $_POST['nama_pemeriksaan_group'];
	$nama_pemeriksaan = $_POST['nama_pemeriksaan'];
	$report_format = $_POST['report_format'];
	$report_order = $_POST['report_order'];
	$form_hasil = $_POST['form_hasil'];
	$text_hasil = $_POST['text_hasil'];
	
	if(empty($tarif_pemeriksaan_id)){
		mysql_query('INSERT INTO m_tarif_pemeriksaan (KODE_TARIF,CH_LEVEL,CH_REPORT,NAMA_PEMERIKSAAN_ORDER,
					NAMA_PEMERIKSAAN_GROUP,NAMA_PEMERIKSAAN,REPORT_FORMAT,REPORT_ORDER,FORM_HASIL,TEXT_HASIL) 
					VALUES ("'.$kode_tarif.'","'.$ch_level.'","'.$ch_report.'","'.$nama_pemeriksaan_order.'",
					"'.$nama_pemeriksaan_group.'","'.$nama_pemeriksaan.'","'.$report_format.'",
					"'.$report_order.'","'.$form_hasil.'","'.$text_hasil.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE m_tarif_pemeriksaan SET KODE_TARIF = "'.$kode_tarif.'",CH_LEVEL = "'.$ch_level.'",
					CH_REPORT = "'.$ch_report.'",NAMA_PEMERIKSAAN_ORDER = "'.$nama_pemeriksaan_order.'",
					NAMA_PEMERIKSAAN_GROUP = "'.$nama_pemeriksaan_group.'",
					NAMA_PEMERIKSAAN = "'.$nama_pemeriksaan.'",REPORT_FORMAT = "'.$report_format.'",
					REPORT_ORDER = "'.$report_order.'",FORM_HASIL = "'.$form_hasil.'",
					TEXT_HASIL = "'.$text_hasil.'"
					WHERE TARIF_PEMERIKSAAN_ID = "'.$tarif_pemeriksaan_id.'"') or die(mysql_error());
	}
	
	$tarif_pemeriksaan_id = '';
	$kode_tarif ='';
	$ch_level ='';
	$ch_report ='';
	$nama_pemeriksaan_order ='';
	$nama_pemeriksaan_group ='';
	$nama_pemeriksaan ='';
	$report_format ='';
	$report_order ='';
	$satuan ='';
	$nilai_rujukan ='';
	$form_hasil ='';
	$text_hasil ='';
	$msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $id = $_GET['ide'];
    $sql = 'SELECT * FROM m_tarif_pemeriksaan WHERE TARIF_PEMERIKSAAN_ID = ' . $id;
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $tarif_pemeriksaan_id = $dat['TARIF_PEMERIKSAAN_ID'];
	$kode_tarif = $dat['KODE_TARIF'];
	$ch_level = $dat['CH_LEVEL'];
	$ch_report = $dat['CH_REPORT'];
	$nama_pemeriksaan_order = $dat['NAMA_PEMERIKSAAN_ORDER'];
	$nama_pemeriksaan_group = $dat['NAMA_PEMERIKSAAN_GROUP'];
	$nama_pemeriksaan = $dat['NAMA_PEMERIKSAAN'];
	$report_format = $dat['REPORT_FORMAT'];
	$report_order = $dat['REPORT_ORDER'];
	$form_hasil = $dat['FORM_HASIL'];
	$text_hasil = $dat['TEXT_HASIL'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_tarif_pemeriksaan WHERE TARIF_PEMERIKSAAN_ID = ' . $_GET['idx']) or die(mysql_error());
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
</script>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="tarif_pemeriksaan_id" id="tarif_pemeriksaan_id" value="<?php echo $tarif_pemeriksaan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table width="70%" class="tableform">
	<tr>
		<td>Kode Tarif</td>
		<td width="200px"><input type="text" name="kode_tarif" id="tarif" value="<?php echo $kode_tarif; ?>"  class="text_dt" style="width:200px;" /></td>
		<td>Nama Permintaan</td>
		<td width="200px"><input type="text" name="nama_pemeriksaan_order" id="nama_pemeriksaan_order" value="<?php echo $nama_pemeriksaan_order; ?>"  class="text_dt" style="width:200px;" /></td>
	</tr>
	<tr>
		<td>Bentuk Report</td>
		<td width="200px">
		<select name="ch_report" id="ch_report" class="text_dt" style="width:210px;" />
		<?php $qry = 'SELECT DISTINCT CH_REPORT 
					FROM m_tarif_pemeriksaan
					ORDER BY CH_REPORT';
			$get = mysql_query($qry) or die(mysql_error());
			while($dat = mysql_fetch_array($get)){	
		?>
			<option value="<?php echo $dat['CH_REPORT']; ?>" <?php if($ch_report == $dat['CH_REPORT']) echo 'selected="selected"'; ?> ><?php echo $dat['CH_REPORT']; ?></option>
		<?php } ?>
		</select>
		</td>
		<td>Tanpa Group</td><td width="200px">
			<input type="checkbox" name="ch_level" id="ch_level" value="1" <?php if($ch_level == '1') echo 'checked="checked"'; ?> />
		</td>
	</tr>
	<tr>
		<td>Nama Pemeriksaan Group</td><td width="200px"><input type="text" name="nama_pemeriksaan_group" id="nama_pemeriksaan_group" value="<?php echo $nama_pemeriksaan_group; ?>"  class="text_dt" style="width:200px;" /></td>
		<td>Nama Pemeriksaan</td><td width="200px"><input type="text" name="nama_pemeriksaan" id="nama_pemeriksaan" value="<?php echo $nama_pemeriksaan; ?>"  class="text_dt" style="width:200px;" /></td>
	</tr>
<tr>
	<td>Urutan</td><td width="200px"><input type="text" name="report_order" id="report_order" value="<?php echo $report_order; ?>"  class="text_dt" style="width:100px;" /></td>
    <td>Format</td><td width="200px"><input type="text" name="report_format" id="report_format" value="<?php echo $report_format; ?>"  class="text_dt" style="width:100px;" /></td>
</tr>
<tr>
    <td>Report</td><td width="200px"><input type="text" name="form_hasil" id="form_hasil" value="<?php echo $form_hasil; ?>"  class="text_dt" style="width:100px;" /></td>
	<td>Text</td><td width="200px"><input type="text" name="text_hasil" id="text_hasil" value="<?php echo $text_hasil; ?>"  class="text_dt" style="width:100px;" /></td>
</tr>
<tr>
   <td colspan="4" align="right"><input type="submit" name="simpan" value="simpan" class="myButton" /></td> 
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
            <th>Jenis Tarif</th>
			<th>Bentuk Report</th>
			<th>Urutan</th>
			<th>Nama Permintaan</th>
			<th>Group</th>
			<th>Tanpa<br />Group</th>
			<th>Pemeriksaan</th>
			<th>Kode Tarif</th>
			<th>Report</th>
			<th>Format</th>
			<th>Text</th>
			<th width="90">Action</th></tr>
        <?php
        $sql = 'SELECT * FROM (SELECT m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.KODE_TARIF,
				CASE WHEN m_tarif_pemeriksaan.CH_LEVEL = "1" THEN "&radic;" END AS CH_LEVEL,m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,
				m_tarif_pemeriksaan.REPORT_FORMAT,m_tarif_pemeriksaan.REPORT_ORDER,m_tarif_pemeriksaan.FORM_HASIL,m_tarif_pemeriksaan.TEXT_HASIL,
				tarif.NAMA_TARIF,tarif.TARIF_GROUP
				FROM m_tarif_pemeriksaan
				INNER JOIN (
					SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
					CASE WHEN m_tarif_group.LABORATORIUM = "1" THEN "Laboratorium"
						WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN "Laboratorium Cito"
						WHEN m_tarif_group.RADIOLOGI = "1" THEN "Radiologi"
						WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN "Radiologi Cito"
						WHEN m_tarif_group.PENUNJANG = "1" THEN "Penunjang Lain"
					END AS TARIF_GROUP
					FROM m_tarif
					INNER JOIN m_tarif_group 
					ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE m_tarif.ST_AKTIF = "1"
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1" 
					OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
					OR m_tarif_group.PENUNJANG = "1")
				) tarif 
				ON (m_tarif_pemeriksaan.KODE_TARIF = tarif.KODE_TARIF)
				) t_pemeriksaan
				WHERE 1 ' . $sql_search . '
				ORDER BY TARIF_GROUP,CH_REPORT,REPORT_ORDER,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN_GROUP,NAMA_PEMERIKSAAN';
        $pager = new PS_Pagination($connect, $sql, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td>' . $dat['TARIF_GROUP'] . '</td>';
			echo '<td>' . $dat['CH_REPORT'] . '</td>';
			echo '<td align="center">' . $dat['REPORT_ORDER'] . '</td>';
			echo '<td>' . $dat['NAMA_PEMERIKSAAN_ORDER'] . '</td>';
			echo '<td>' . $dat['NAMA_PEMERIKSAAN_GROUP'] . '</td>';
			echo '<td align="center">' . $dat['CH_LEVEL'] . '</td>';
			echo '<td>' . $dat['NAMA_PEMERIKSAAN'] . '</td>';
			echo '<td align="center">' . $dat['KODE_TARIF'] . '</td>';
			echo '<td align="center">' . $dat['FORM_HASIL'] . '</td>';
			echo '<td align="center">' . $dat['REPORT_FORMAT'] . '</td>';
			echo '<td align="center">' . $dat['TEXT_HASIL'] . '</td>';
            echo '<td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['TARIF_PEMERIKSAAN_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;
			<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['TARIF_PEMERIKSAAN_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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