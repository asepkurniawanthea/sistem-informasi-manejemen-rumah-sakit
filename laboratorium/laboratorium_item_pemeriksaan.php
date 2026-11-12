<?php
$pemeriksaan_group = '';
if (isset($_SESSION['labgroupitem_pemeriksaan_group']))
		$pemeriksaan_group = $_SESSION['labgroupitem_pemeriksaan_group'];

if (isset($_POST['pemeriksaan_group'])) {
    $pemeriksaan_group = $_POST['pemeriksaan_group'];
	$_SESSION['labgroupitem_pemeriksaan_group'] = $pemeriksaan_group;
}

$pemeriksaan = '';
if (isset($_SESSION['labitem_pemeriksaan']))
		$pemeriksaan = $_SESSION['labitem_pemeriksaan'];

if (isset($_POST['pemeriksaan'])) {
    $pemeriksaan = $_POST['pemeriksaan'];
	$_SESSION['labitem_pemeriksaan'] = $pemeriksaan;
}

$jenis_laporan_lab = getJenisLaporanLab();
?>
<form name="searchicd" method="post" >
    <table class="tableform" border="0" >
        <tr>
            <td>Group Tarif</td>
            <td><select name="pemeriksaan_group" id="pemeriksaan_group" class="text_dt" onchange="javascript: MyAjaxRequest('sl_pemeriksaan','index.php?ajaxrequest=pemeriksaanlabitem&group=' + this.value + '&pemeriksaan=<?php echo $pemeriksaan; ?>');return false;" style="width:320px;">
			<option value=""> -- </option>
			<?php
			$sql_group = 'SELECT KODE_TARIF_GROUP,NAMA_TARIF_GROUP FROM m_tarif_group 
						WHERE LABORATORIUM = "1" OR LABORATORIUM_CITO = "1"
						ORDER BY NAMA_TARIF_GROUP';
			$get_group = mysql_query($sql_group) or die(mysql_error());
			while($dat_group = mysql_fetch_array($get_group)){ ?>
				<option value="<?php echo $dat_group['KODE_TARIF_GROUP']; ?>" <?php if($dat_group['KODE_TARIF_GROUP'] == $pemeriksaan_group) echo 'selected="selected"'; ?>  
				><?php echo $dat_group['NAMA_TARIF_GROUP']; ?></option>
			<?php } ?>
			</select></td>
        </tr>
		<tr>
            <td>Nama Tarif</td>
            <td><div id="sl_pemeriksaan" >
			<select name="pemeriksaan" class="text_dt" style="width:320px;">
			<option value=""> -- </option>
			</select>
			</div></td>
        </tr>
        <tr>
            <td><div id="pr"></div></td>
            <td align="right"><input type="submit" name="buka" value="tampilkan" class="myButton" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<div class="div_menu" style=" height:auto; position:relative; padding:5px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formlab" method="post" >
<table border="0" width="100%">
<?php 
$nama_permintaan = '';
if($pemeriksaan == ''){
	mysql_query('DELETE FROM x_pemeriksaan_lab') or die(mysql_error());
}
if(isset($_POST['buka'])){ 
	mysql_query('DELETE FROM x_pemeriksaan_lab') or die(mysql_error());
	mysql_query('INSERT INTO x_pemeriksaan_lab(TARIF_PEMERIKSAAN_ID,KODE_TARIF,CH_LEVEL,CH_REPORT,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN_GROUP,
			NAMA_PEMERIKSAAN,REPORT_FORMAT,REPORT_ORDER,SATUAN,NILAI_RUJUKAN,FORM_HASIL,TEXT_HASIL)
			SELECT TARIF_PEMERIKSAAN_ID,KODE_TARIF,CH_LEVEL,CH_REPORT,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN_GROUP,
			NAMA_PEMERIKSAAN,REPORT_FORMAT,REPORT_ORDER,SATUAN,NILAI_RUJUKAN,FORM_HASIL,TEXT_HASIL
			FROM m_tarif_pemeriksaan
			WHERE KODE_TARIF = "' . $pemeriksaan . '"') or die(mysql_error());
}
if(isset($_POST['simpan'])){
		if($_POST['nama_permintaan'] == ''){
			$msg_info = 'Nama Permintaan Laboratorium Belum Diisi.';
		}else{
			if(isset($_POST['tambah_baru'])){
				$clb = '';
				if(isset($_POST['ch_level_baru'])) $clb = $_POST['ch_level_baru']; 
				$thb = '';
				if(isset($_POST['text_hasil_baru'])) $thb = $_POST['text_hasil_baru']; 
				mysql_query('INSERT INTO x_pemeriksaan_lab(KODE_TARIF,CH_LEVEL,CH_REPORT,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN_GROUP,
					NAMA_PEMERIKSAAN,REPORT_FORMAT,REPORT_ORDER,SATUAN,NILAI_RUJUKAN,FORM_HASIL,TEXT_HASIL)
					VALUES("' . $_POST['kode_tarif'] . '","' . $clb . '","' . $_POST['ch_report_baru'] . '",
					"' . $_POST['nama_permintaan'] . '","' . $_POST['pemeriksaan_group_baru'] . '","' . $_POST['nama_pemeriksaan_baru'] . '",
					"' . $_POST['report_format_baru'] . '","' . $_POST['report_order_baru'] . '","","","' . $_POST['form_hasil_baru'] . '",
					"' . $thb . '")') or die(mysql_error());
			}
			$cn_item = $_POST['cn_item'];
			$y=1;
			while($y < $cn_item){
				$chl = '';
				if(isset($_POST['ch_level' . $y])) $chl = $_POST['ch_level' . $y]; 
				$txh = '';
				if(isset($_POST['text_hasil' . $y])) $txh = $_POST['text_hasil' . $y]; 
					
					if(isset($_POST['hapus' . $y])){
						mysql_query('DELETE FROM x_pemeriksaan_lab WHERE PEMERIKSAAN_LAB_ID = "' . $_POST['lab_id' . $y] . '"') or die(mysql_error());	
					}else{	
						mysql_query('UPDATE x_pemeriksaan_lab SET KODE_TARIF = "' . $_POST['kode_tarif'] . '",
							CH_LEVEL = "' . $chl . '",CH_REPORT = "' . $_POST['ch_report' . $y] . '",
							NAMA_PEMERIKSAAN_ORDER = "' . $_POST['nama_permintaan'] . '",
							NAMA_PEMERIKSAAN_GROUP = "' . $_POST['pemeriksaan_group' . $y] . '",
							NAMA_PEMERIKSAAN = "' . $_POST['nama_pemeriksaan' . $y] . '",
							REPORT_FORMAT = "' . $_POST['report_format' . $y] . '",
							REPORT_ORDER = "' . $_POST['report_order' . $y] . '",SATUAN = "",
							NILAI_RUJUKAN = "",FORM_HASIL = "' . $_POST['form_hasil' . $y] . '",
							TEXT_HASIL = "' . $txh . '"
							WHERE PEMERIKSAAN_LAB_ID = "' . $_POST['lab_id' . $y] . '"') or die(mysql_error());	
					}		
			$y++;
			}
		}
}
if(isset($_POST['apply'])){
	$sql_apply = 'SELECT * FROM x_pemeriksaan_lab WHERE KODE_TARIF = "' . $pemeriksaan . '"';
	$get_apply = mysql_query($sql_apply) or die(mysql_error());
	while($dat_apply = mysql_fetch_array($get_apply)){
		$tarif_pemeriksaan_id = $dat_apply['TARIF_PEMERIKSAAN_ID'];
		if($tarif_pemeriksaan_id == ''){
			mysql_query('INSERT INTO m_tarif_pemeriksaan(KODE_TARIF,CH_LEVEL,CH_REPORT,NAMA_PEMERIKSAAN_ORDER,NAMA_PEMERIKSAAN_GROUP,
					NAMA_PEMERIKSAAN,REPORT_FORMAT,REPORT_ORDER,SATUAN,NILAI_RUJUKAN,FORM_HASIL,TEXT_HASIL)
					VALUES("' . $dat_apply['KODE_TARIF'] . '","' . $dat_apply['CH_LEVEL'] . '","' . $dat_apply['CH_REPORT'] . '",
					"' . $dat_apply['NAMA_PEMERIKSAAN_ORDER'] . '","' . $dat_apply['NAMA_PEMERIKSAAN_GROUP'] . '",
					"' . $dat_apply['NAMA_PEMERIKSAAN'] . '","' . $dat_apply['REPORT_FORMAT'] . '","' . $dat_apply['REPORT_ORDER'] . '",
					"' . $dat_apply['SATUAN'] . '","' . $dat_apply['NILAI_RUJUKAN'] . '","' . $dat_apply['FORM_HASIL'] . '",
					"' . $dat_apply['TEXT_HASIL'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE m_tarif_pemeriksaan SET KODE_TARIF = "' . $dat_apply['KODE_TARIF'] . '",
						CH_LEVEL = "' . $dat_apply['CH_LEVEL'] . '",
						CH_REPORT = "' . $dat_apply['CH_REPORT'] . '",
						NAMA_PEMERIKSAAN_ORDER = "' . $dat_apply['NAMA_PEMERIKSAAN_ORDER'] . '",
						NAMA_PEMERIKSAAN_GROUP = "' . $dat_apply['NAMA_PEMERIKSAAN_GROUP'] . '",
						NAMA_PEMERIKSAAN = "' . $dat_apply['NAMA_PEMERIKSAAN'] . '",
						REPORT_FORMAT = "' . $dat_apply['REPORT_FORMAT'] . '",
						REPORT_ORDER = "' . $dat_apply['REPORT_ORDER'] . '",
						SATUAN = "' . $dat_apply['SATUAN'] . '",
						NILAI_RUJUKAN = "' . $dat_apply['NILAI_RUJUKAN'] . '",
						FORM_HASIL = "' . $dat_apply['FORM_HASIL'] . '",
						TEXT_HASIL = "' . $dat_apply['TEXT_HASIL'] . '"
						WHERE TARIF_PEMERIKSAAN_ID = "' . $tarif_pemeriksaan_id . '"') or die(mysql_error());
		}
	}
	$_SESSION['labitem_pemeriksaan'] = '';
	?>
	<script>
		alert("Setingan Telah Diterapkan.");
		window.location = "<?php echo currentUrl(); ?>";
	</script>
	<?php
}
$sql_pemeriksaan = 'SELECT * FROM x_pemeriksaan_lab 
				WHERE KODE_TARIF = "' . $pemeriksaan . '"	
				ORDER BY CH_REPORT,NAMA_PEMERIKSAAN_GROUP,REPORT_ORDER';
$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
$dat_pemeriksaan = mysql_fetch_assoc($get_pemeriksaan);
$nama_permintaan = $dat_pemeriksaan['NAMA_PEMERIKSAAN_ORDER']; 	
if(mysql_num_rows($get_pemeriksaan) > 0) mysql_data_seek($get_pemeriksaan,0);		
?>
<tr><td>Nama Permintaan Laboratorium : <input type="text" name="nama_permintaan" class="text_dt" style="width:320px;" value="<?php echo $nama_permintaan; ?>" />
<input type="hidden" name="kode_tarif" value="<?php echo $pemeriksaan; ?>" /></td></tr>
<tr><td>
<table border="1" class="tableData" id="tfhover">
    <tr>
		<th>Bentuk<br />Form Hasil</th>
		<th>Header</th>
		<th>Group</th>
		<th>Pemeriksaan</th>
		<th>Hurup Tebal</th>
		<th>Text Panjang</th>
		<th>Urutan<br />Pada Form</th>
		<th>Isian<br />Form Hasil 2</th>
		<th>Option</th>
	</tr>
<?php 
$x=1;
while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){ ?>
		<tr>
		<td align="center"><input type="hidden" name="lab_id<?php echo $x; ?>" value="<?php echo $dat_pemeriksaan['PEMERIKSAAN_LAB_ID']; ?>" />
		<select name="form_hasil<?php echo $x; ?>" class="text_dt" style="width:50px;" >
		<option value=""> -- </option>
		<option value="1" <?php if($dat_pemeriksaan['FORM_HASIL'] == '1') echo 'selected="selected"'; ?>>1 (4 Kolom > Jenis Pemeriksaan,Hasil,Satuan,Nilai Rujukan)</option>
		<option value="2" <?php if($dat_pemeriksaan['FORM_HASIL'] == '2') echo 'selected="selected"'; ?>>2 (3 Kolom > Jenis Pemeriksaan,Hasil,Nilai Rujukan)</option>
		<option value="3" <?php if($dat_pemeriksaan['FORM_HASIL'] == '3') echo 'selected="selected"'; ?>>3 (2 Kolom > Jenis Pemeriksaan,Hasil)</option>
		</select></td>
		<td><select name="ch_report<?php echo $x; ?>" class="text_dt" style="width:220px;" >
		<option value=""> -- </option>
		<?php for($i=0;$i<sizeof($jenis_laporan_lab);$i++){ ?>
		<option value="<?php echo $jenis_laporan_lab[$i]; ?>" <?php if($dat_pemeriksaan['CH_REPORT'] == $jenis_laporan_lab[$i]) echo 'selected="selected"'; ?>><?php echo $jenis_laporan_lab[$i]; ?></option>
		<?php } ?>
		</select></td>
		<td><input type="text" name="pemeriksaan_group<?php echo $x; ?>" class="text_dt" style="width:220px;" value="<?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN_GROUP']; ?>" /></td>
		<td><input type="text" name="nama_pemeriksaan<?php echo $x; ?>" class="text_dt" style="width:220px;" value="<?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?>" /></td>
		<td align="center"><input type="checkbox" name="ch_level<?php echo $x; ?>" value="1" <?php if($dat_pemeriksaan['CH_LEVEL']=='1') echo 'checked="checked"'; ?>/></td>
		<td align="center"><input type="checkbox" name="text_hasil<?php echo $x; ?>" value="1" <?php if($dat_pemeriksaan['TEXT_HASIL']=='1') echo 'checked="checked"'; ?>/></td>
		<td align="center"><input type="text" name="report_order<?php echo $x; ?>" class="text_dt" style="width:50px;text-align:right;" value="<?php echo $dat_pemeriksaan['REPORT_ORDER']; ?>" /></td>
		<td align="center"><select name="report_format<?php echo $x; ?>" class="text_dt" style="width:50px;" >
		<option value=""> -- </option>
		<option value="1" <?php if($dat_pemeriksaan['REPORT_FORMAT'] == '1') echo 'selected="selected"'; ?>>1 (1 Kolom)</option>
		<option value="2" <?php if($dat_pemeriksaan['REPORT_FORMAT'] == '2') echo 'selected="selected"'; ?>>2 (5 Kolom > Bi,Mi,S%,F%,G%)</option>
		</select></td>
		<td><?php if($dat_pemeriksaan['TARIF_PEMERIKSAAN_ID'] == ''){ ?>
		<input type="checkbox" name="hapus<?php echo $x; ?>" value="1" />hapus<?php } ?></td>
		</tr>
<?php	$x++; } ?>
<tr>
	<td align="center"><input type="hidden" name="cn_item" value="<?php echo $x; ?>" />
	<select name="form_hasil_baru" class="text_dt" style="width:50px;" >
	<option value=""> -- </option>
	<option value="1">1 (4 Kolom > Jenis Pemeriksaan,Hasil,Satuan,Nilai Rujukan)</option>
	<option value="2">2 (3 Kolom > Jenis Pemeriksaan,Hasil,Nilai Rujukan)</option>
	<option value="3">3 (2 Kolom > Jenis Pemeriksaan,Hasil)</option>
	</select></td>
	<td><select name="ch_report_baru" class="text_dt" style="width:220px;" >
	<option value=""> -- </option>
	<?php for($i=0;$i<sizeof($jenis_laporan_lab);$i++){ ?>
		<option value="<?php echo $jenis_laporan_lab[$i]; ?>" <?php if($dat_pemeriksaan['CH_REPORT'] == $jenis_laporan_lab[$i]) echo 'selected="selected"'; ?>><?php echo $jenis_laporan_lab[$i]; ?></option>
	<?php } ?>
	</select></td>
	<td><input type="text" name="pemeriksaan_group_baru" class="text_dt" style="width:220px;" value="" /></td>
	<td><input type="text" name="nama_pemeriksaan_baru" class="text_dt" style="width:220px;" value="" /></td>
	<td align="center"><input type="checkbox" name="ch_level_baru" value="1" /></td>
	<td align="center"><input type="checkbox" name="text_hasil_baru" value="1" /></td>
	<td align="center"><input type="text" name="report_order_baru" class="text_dt" style="width:50px;text-align:right;" value="" /></td>
	<td align="center"><select name="report_format_baru" class="text_dt" style="width:50px;" >
	<option value=""> -- </option>
	<option value="1" >1 (1 Kolom)</option>
	<option value="2" >2 (5 Kolom > Bi,Mi,S%,F%,G%)</option>
	</select></td>
	<td><input type="checkbox" name="tambah_baru" value="1" />tambah</td>
</tr>	
</table>
</td></tr>
<tr><td align="right"><input type="submit" name="simpan" value="simpan" class="myButton" /></td></tr>
</table>
</form>			
</div>
<?php if(mysql_num_rows($get_pemeriksaan) > 0){ ?>
<div class="div_menu" style=" height:auto; position:relative; padding:5px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table border="0" width="100%">
<tr><td>Preview : </td></tr>
<tr><td>
<?php 
mysql_data_seek($get_pemeriksaan,0);
$dat_pemeriksaan = mysql_fetch_assoc($get_pemeriksaan);
$form_hasil = $dat_pemeriksaan['FORM_HASIL'];
$sql_pemeriksaan = 'SELECT DISTINCT CH_REPORT FROM x_pemeriksaan_lab ORDER BY CH_REPORT,NAMA_PEMERIKSAAN_GROUP,REPORT_ORDER';
$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
?>
<!-- preview -->
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<?php if($form_hasil == '1'){ ?>
	<th width="20">No</th>
	<th colspan="3">Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
	<th width="80">Satuan</th>
	<th width="150">Nilai Rujukan</th>
	<?php }else if($form_hasil == '2'){ ?>
	<th width="20">No</th>
	<th colspan="3">Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
	<th width="150">Nilai Rujukan</th>
	<?php }else if($form_hasil == '3'){ ?>
	<th width="20">No</th>
	<th colspan="3" >Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
 	<?php } ?>
	<th width="100">Metode</th>
	<th width="104">Option</th>
  </tr>
<?php
	$i = 1;
	$x = 1;
	$id_counter = 1;
	while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){
		?>
		<tr>
		<?php if($form_hasil == '1'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_pemeriksaan['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php }else if($form_hasil == '2'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_pemeriksaan['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php }else if($form_hasil == '3'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_pemeriksaan['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<?php } ?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
	<?php $sql_pemeriksaan_item = 'SELECT * FROM x_pemeriksaan_lab 
								WHERE CH_REPORT = "' . $dat_pemeriksaan['CH_REPORT'] . '"
								ORDER BY CH_REPORT,NAMA_PEMERIKSAAN_GROUP,REPORT_ORDER';		
        $get_pemeriksaan_item = mysql_query($sql_pemeriksaan_item) or die(mysql_error());
		$z = 1;
        $nama_pemeriksaan_group = '';
		while ($dat_pemeriksaan_item = mysql_fetch_array($get_pemeriksaan_item)) {
				if ($form_hasil == '1') {
                    include('laboratorium/laboratorium_x_diagnosa_1.php');
                } else if ($form_hasil == '2') {
                    include('laboratorium/laboratorium_x_diagnosa_2.php');
                } else if ($form_hasil == '3') {
                    include('laboratorium/laboratorium_x_diagnosa_3.php');
                }
		$z++;
		$id_counter++;
        }		
$i++; 
} ?>	
</table>
<!-- end preview -->
</td></tr>
<tr><td align="right">
<form name="frmterapkan" id="frmterapkan" method="post">
<input type="hidden" name="apply" value="1" />
<input type="button" name="terapkan" value="terapkan" class="myButton" onclick="JavaScript : terapkan_lab();" />
</form></td></tr>
</table>
</div>
<?php } ?>
<br />
<a href="#" style="color:#FF0000; " onclick="window.open('/nsimrs/manual/manual-laboratorium-item_pemeriksaan.pdf');"><i>* download manual pengisian item pemeriksaan</i></a> 
<script>
MyAjaxRequest('sl_pemeriksaan','index.php?ajaxrequest=pemeriksaanlabitem&group=<?php echo $pemeriksaan_group; ?>&pemeriksaan=<?php echo $pemeriksaan; ?>');

function terapkan_lab(){
	if(confirm('Yakin Terapkan ?')){
	  document.getElementById('frmterapkan').submit();
	}	
}
</script>