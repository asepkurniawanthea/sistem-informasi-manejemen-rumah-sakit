<?php
if(isset($_POST['simpan'])){
	$cn_row = $_POST['cn_row'];
	$ruang_id = $_POST['ruang_id'];
	if($ruang_id != '' and $cn_row > 0){
		
		mysql_query('DELETE FROM m_ruang_detail WHERE RUANG_ID = "' . $ruang_id . '"');
		$x = 1;
		while($x <= $cn_row){
				mysql_query('INSERT INTO m_ruang_detail (RUANG_ID,NO_TMP_TIDUR,LK_PR,DW_AN_BY,URUTAN,KODE_TIPE_PASIEN)
					VALUE("' . $ruang_id . '",
					"' . $_POST['nomor_ruang_' . $x] . '",
					"' . ((isset($_POST['lkpr_' . $x])) ? $_POST['lkpr_' . $x] : '') . '",
					"' . ((isset($_POST['dwanby_' . $x])) ? $_POST['dwanby_' . $x] : '') . '",
					"' . $x . '",
					"' . $_POST['perawatan_' . $x] . '")') or die(mysql_error());
		$x++;
		}
	$msg_info = 'Simpan Data Berhasil.';
	}
}

$searchkey = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
}

$arr_tipe_pasien = array();
$sql = 'SELECT * FROM m_tipe_pasien ORDER BY TIPE_PASIEN';
$get = mysql_query($sql) or die(mysql_error());
$j = 0;
while($dat = mysql_fetch_array($get)){
	$arr_tipe_pasien[$dat['KODE_PASIEN']] = $dat['TIPE_PASIEN'];
}

$sql = 'SELECT * FROM m_ruang WHERE ST_AKTIF = "1" ORDER BY BANGSAL,NAMA_RUANG,KELAS_RAWAT';
$get = mysql_query($sql) or die(mysql_error());
?>
<br/>
<form name="form2" method="post" action="index.php">
<input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="left">&nbsp;&nbsp;Ruang Rawat :&nbsp;
			<select name="searchkey" id="searchkey" class="text_dt">
                    <option value=""> - </option>
                    <?php while ($dat = mysql_fetch_array($get)) {
                        ?>
                        <option value="<?php echo $dat['RUANG_ID']; ?>" <?php if ($searchkey == $dat['RUANG_ID']) echo 'selected="selected"'; ?>>
                        <?php echo $dat['NAMA_RUANG'] . ' (' . $dat['KELAS_RAWAT'] . ')'; ?></option>
					<?php } ?>
                </select>&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">

        <tr>
            <th width="10">Id</th>
			<th>Nomor Tempat Tidur</th>
			<th>Lk-Pr</th>
			<th>Dw-An-By</th>
			<th>Tipe Perawatan</th>
		</tr>
        <?php
		$jumlah_ruang = 0;
		mysql_data_seek($get,0);
		if($searchkey != ''){
			$sql_bed = 'SELECT JML_TMP_TIDUR FROM m_ruang WHERE RUANG_ID = "' . $searchkey . '"';
			$get_bed = mysql_query($sql_bed) or die(mysql_error());
			$dat_bed = mysql_fetch_assoc($get_bed);
			$jumlah_ruang = $dat_bed['JML_TMP_TIDUR'];
		
			$urut_ruang = 1;
			while ($urut_ruang <= $jumlah_ruang) { ?>
				<tr>
					<?php 
						$sql_detail = 'SELECT * FROM m_ruang_detail WHERE RUANG_ID = "' . $searchkey . '" AND URUTAN = "' . $urut_ruang . '"';
						$get_ruang = mysql_query($sql_detail) or die(mysql_error());
						$dat_ruang = mysql_fetch_assoc($get_ruang);
						$id = $dat_ruang['RUANG_DETAIL_ID'];
						$nomor_ruang = $dat_ruang['NO_TMP_TIDUR'];
						$lk_pr = $dat_ruang['LK_PR'];
						$dw_an_by = $dat_ruang['DW_AN_BY'];
						$perawatan = $dat_ruang['KODE_TIPE_PASIEN'];
						
					?>
					<td><?php echo $id; ?></td>
					<td><input type="text" name="nomor_ruang_<?php echo $urut_ruang; ?>" 
					value="<?php echo (($nomor_ruang == '') ? substr('000',0, 3 - strlen($urut_ruang)) . $urut_ruang : $nomor_ruang); ?>" class="text_dt" /></td>
					<td>
						<input type="radio" name="lkpr_<?php echo $urut_ruang; ?>" value="LK" <?php if($lk_pr == 'LK') echo 'checked'; ?> />&nbsp;Laki-laki
						<input type="radio" name="lkpr_<?php echo $urut_ruang; ?>" value="PR" <?php if($lk_pr == 'PR') echo 'checked'; ?> />&nbsp;Perempuan
					</td>
					<td>
						<input type="radio" name="dwanby_<?php echo $urut_ruang; ?>" value="DW" <?php if($dw_an_by == 'DW') echo 'checked'; ?> />&nbsp;Dewasa
						<input type="radio" name="dwanby_<?php echo $urut_ruang; ?>" value="AN" <?php if($dw_an_by == 'AN') echo 'checked'; ?>  />&nbsp;Anak
						<input type="radio" name="dwanby_<?php echo $urut_ruang; ?>" value="BY" <?php if($dw_an_by == 'BY') echo 'checked'; ?>  />&nbsp;Bayi
					</td>
					<td><select name="perawatan_<?php echo $urut_ruang; ?>" class="text_dt" >
						<option value="">-</option>
						<?php foreach($arr_tipe_pasien as $key=>$value){ ?>
							<option value="<?php echo $key; ?>" <?php if($perawatan == $key) echo 'selected'; ?> ><?php echo $value; ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
			<?php 
			$urut_ruang++;	
			}
		}	
        ?>
	<tr>
		<td colspan="5" align="right"><input type="submit" name="simpan" value="simpan" class="myButton" /></td>
	</tr>	
    </table>
<input type="hidden" name="cn_row" value="<?php echo $jumlah_ruang; ?>" /> 	
<input type="hidden" name="ruang_id" value="<?php echo $searchkey; ?>" /> 	
</form>