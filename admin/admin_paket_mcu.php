<?php
$tarif_id = '';
$kode_tarif = '';
$nama_tarif = '';
$unit = '';
$diskon = '';
$group_paket = '';
$kode_tarif_mn = '';
$mapping_lis = '';

if (isset($_POST['tarif_id'])) {
    $tarif_id = $_POST['tarif_id'];
    $kode_tarif = $_POST['kode_tarif'];
    $nama_tarif = $_POST['nama_tarif'];
	$unit = $_POST['unit']; 
	$diskon = $_POST['diskon'];
	$group_paket = $_POST['group_paket'];
	$kode_tarif_mn = $_POST['kode_tarif_mn'];
	$mapping_lis = $_POST['kode_mapping'];
   
    if (!empty($tarif_id)) {
        mysql_query('UPDATE m_tarif SET KODE_TARIF = "' . $kode_tarif . '",
			NAMA_TARIF = "' . $nama_tarif . '",UNIT_ID = "' . $unit . '",
			KODE_TARIF_LAB = "' . $mapping_lis . '"
			WHERE TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());		
    } else {
		mysql_query('INSERT INTO m_tarif (KODE_TARIF,NAMA_TARIF,KODE_TARIF_GROUP,MCU,UNIT_ID,KODE_TARIF_LAB) 
				VALUES ("' . $kode_tarif . '","' . $nama_tarif . '","120","1","' . $unit . '","' . $mapping_lis . '")') or die(mysql_error());
    }
	
	mysql_query('UPDATE m_tarif SET DISKON = "' . $diskon . '",
				GROUP_PAKET_MCU = "' . $group_paket . '"
				WHERE KODE_TARIF = "' . $kode_tarif_mn . '"
				AND ST_AKTIF = "1"') or die(mysql_error());	
				
	if($unit == '17' or $unit == '45'){
		mysql_query('DELETE FROM m_tarif_pemeriksaan WHERE KODE_TARIF = "' . $kode_tarif . '"') or die(mysql_error());	
		mysql_query('INSERT INTO m_tarif_pemeriksaan (KODE_TARIF,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN) VALUES 
					("' . $kode_tarif . '","' . $nama_tarif . '","' . $nama_tarif . '")') or die(mysql_error());
	}			
	
    $tarif_id = '';
	$kode_tarif = '';
	$nama_tarif = '';
	$unit = '';
	$mapping_lis = '';
	$diskon = '';

    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $tarif_id = $_GET['ide'];
    $sql = 'SELECT TARIF_ID,KODE_TARIF,NAMA_TARIF, 
			UNIT_ID,KODE_TARIF_LAB
			FROM m_tarif
			WHERE TARIF_ID = "' . $tarif_id . '"';
    $get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $kode_tarif = $dat['KODE_TARIF'];
    $nama_tarif = $dat['NAMA_TARIF'];
    $unit = $dat['UNIT_ID'];
	$mapping_lis = $dat['KODE_TARIF_LAB'];
	$kode_tarif_mn = substr($kode_tarif,3,6);
	
	$sql = 'SELECT DISKON,GROUP_PAKET_MCU FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_mn . '"
		AND ST_AKTIF = "1"';
	$get = mysql_query($sql);
    $dat = mysql_fetch_assoc($get);
    $diskon = $dat['DISKON'];
	$group_paket = $dat['GROUP_PAKET_MCU'];	
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM m_tarif WHERE TARIF_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
}

if (isset($_GET['idd'])) {
    $idd = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $idd; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $idd; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="tarif_id" id="tarif_id" value="<?php echo $tarif_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Kode Tarif</td><td colspan="3"><input name="kode_tarif" type="text" id="kode_tarif"  class="text_dt" value="<?php echo $kode_tarif; ?>" size="20" /></td></tr>
        <tr><td>Nama</td><td colspan="3"><input name="nama_tarif" type="text" id="nama_tarif"  class="text_dt" value="<?php echo $nama_tarif; ?>" size="40" /></td></tr>
		<tr><td>Unit</td><td>
		<select name="unit" id="unit" class="text_dt">
			<option value=""> - </option>
			<option value="61" <?php if($unit == '61') echo 'selected'; ?> >R. MCU</option>
			<option value="45" <?php if($unit == '45') echo 'selected'; ?> >Laboratorium</option>
			<option value="17" <?php if($unit == '17') echo 'selected'; ?> >Radiologi</option>
			<option value="52" <?php if($unit == '52') echo 'selected'; ?> >R. Tindakan EKG/EEG/USG</option>
		</select>
		</td>
		<td width="150">&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td>Group Paket</td><td colspan="3">
		<select name="group_paket" id="group_paket" class="text_dt">
			<option value=""> - </option>
			<option value="Paket Office" <?php if($group_paket == 'Paket Office') echo 'selected'; ?> >Paket Office</option>
			<option value="Paket Non Office" <?php if($group_paket == 'Paket Non Office') echo 'selected'; ?> >Paket Non Office</option>
            <option value="Paket Pra Nikah" <?php if($group_paket == 'Paket Pra Nikah') echo 'selected'; ?> >Paket Pra Nikah</option>
			<option value="Paket General" <?php if($group_paket == 'Paket General') echo 'selected'; ?> >Paket General</option>
			<option value="Paket Umroh" <?php if($group_paket == 'Paket Umroh') echo 'selected'; ?> >Paket Umroh</option>
			<option value="Paket Vaksin" <?php if($group_paket == 'Paket Vaksin') echo 'selected'; ?> >Paket Vaksin</option>
			<option value="Paket Keterangan Sehat" <?php if($group_paket == 'Keterangan Sehat') echo 'selected'; ?> >Keterangan Sehat</option>
		</select>
		</td></tr>
		<tr><td>Paket</td><td colspan="3">
		<select name="kode_tarif_mn" id="kode_tarif_mn" class="text_dt">
			<option> - </option>
                    <?php $get_prop = mysql_query('SELECT KODE_TARIF,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120" AND ST_AKTIF = "1" ORDER BY NAMA_TARIF');
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['KODE_TARIF']; ?>" <?php if ($kode_tarif_mn == $dat_prop['KODE_TARIF']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['NAMA_TARIF']; ?></option>
					<?php } ?>
		</select>
		</td></tr>
		<tr><td>Mapping LIS</td><td colspan="3">
		<select name="kode_mapping" class="text_dt" style="width:290px;" >
					<option value=""> -- </option>
					<?php 
						$sql_mapping = 'SELECT KODE_PEMERIKSAAN_LAB,NAMA_PEMERIKSAAN_LAB FROM m_tarif_pemeriksaan_lab
							ORDER BY NAMA_PEMERIKSAAN_LAB';
						$get_mapping = mysql_query($sql_mapping) or die(mysql_error());	
						while($dat_mapping = mysql_fetch_array($get_mapping)){
						$selected = '';
						if($dat_mapping['KODE_PEMERIKSAAN_LAB'] == $mapping_lis) $selected = 'selected';	
					?>
						<option value="<?php echo $dat_mapping['KODE_PEMERIKSAAN_LAB']; ?>" <?php echo $selected; ?> ><?php echo $dat_mapping['KODE_PEMERIKSAAN_LAB'] . ' -- ' . $dat_mapping['NAMA_PEMERIKSAAN_LAB']; ?></option>
					<?php } ?>
					</select>
		</td></tr>
		<tr><td>Diskon</td><td><input name="diskon" type="text" id="diskon"  class="text_dt" value="<?php echo $diskon; ?>" size="20" /></td>
		<td width="150">&nbsp;</td><td>&nbsp;</td></tr>
		<td width="150">&nbsp;</td><td colspan="3">&nbsp;</td></tr>
		<td align="right" colspan="4"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</form>
<br />
<form name="form2" method="get" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
				<select name="searchkey" id="searchkey" class="text_dt">
                    <option> - </option>
                    <?php $get_prop = mysql_query('SELECT KODE_TARIF,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120" AND ST_AKTIF = "1" ORDER BY NAMA_TARIF');
                    while ($dat_prop = mysql_fetch_array($get_prop)) {
                        ?>
                        <option value="<?php echo $dat_prop['KODE_TARIF']; ?>" <?php if ($searchkey == $dat_prop['KODE_TARIF']) echo 'selected="selected"'; ?>>
                        <?php echo $dat_prop['NAMA_TARIF']; ?> (<?php echo $dat_prop['KODE_TARIF']; ?>)</option>
					<?php } ?>
                </select>&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="10">Id</th>
			<th>Kode</th>
			<th>Group</th>
			<th>Paket</th>
			<th>Tarif</th>
			<th>MCU</th>
			<th>Laboratorium</th>
			<th>Radiologi</th>
			<th>R. Tindakan EKG/EEG/USG</th>
			<th>Option</th>
		</tr>
        <?php
        $sql = 'SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF, 
				CASE WHEN m_tarif.UNIT_ID = "45" THEN "&radic;" END AS LABORATORIUM,
				CASE WHEN m_tarif.UNIT_ID = "17" THEN "&radic;" END AS RADIOLOGI,
				CASE WHEN m_tarif.UNIT_ID = "52" THEN "&radic;" END AS TINDAKAN,
				CASE WHEN m_tarif.UNIT_ID = "61" THEN "&radic;" END AS MCU,
				mtr.NAMA_TARIF AS NAMA_PAKET,
				mtr.GROUP_PAKET_MCU,
				LEFT(REPLACE(m_tarif.KODE_TARIF,"MCU",""),6) AS KODE_TARIF2
				FROM m_tarif
				LEFT JOIN (
					SELECT KODE_TARIF,NAMA_TARIF,GROUP_PAKET_MCU
					FROM m_tarif 
					WHERE KODE_TARIF_GROUP = "120" AND ST_AKTIF = "1"
				) mtr
				ON (LEFT(REPLACE(m_tarif.KODE_TARIF,"MCU",""),6) = mtr.KODE_TARIF) 
				WHERE m_tarif.KODE_TARIF LIKE "MCU' . $searchkey . '%"
				AND m_tarif.MCU = "1"
				ORDER BY m_tarif.KODE_TARIF';
        $pager = new PS_Pagination($connect, $sql, 20, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr>';
            echo '<td align="center">' . $dat['TARIF_ID'] . '</td>';
            echo '<td align="center">' . $dat['KODE_TARIF'] . '</td>';
			echo '<td>' . $dat['GROUP_PAKET_MCU'] . '</td>';
			echo '<td>' . $dat['NAMA_PAKET'] . '</td>';
			echo '<td>' . $dat['NAMA_TARIF'] . '</td>';
			echo '<td align="center">' . $dat['MCU'] . '</td>';
			echo '<td align="center">' . $dat['LABORATORIUM'] . '</td>';
			echo '<td align="center">' . $dat['RADIOLOGI'] . '</td>';
			echo '<td align="center">' . $dat['TINDAKAN'] . '</td>';
            echo '<td align="center" width="100"><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['TARIF_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;&nbsp;<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['TARIF_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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
<script>