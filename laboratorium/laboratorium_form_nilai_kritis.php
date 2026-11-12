<?php
$nilai_kritis_id = '';
$ch_report = '';
$nama_periksaan = '';
$nilai_mulai = '';
$nilai_sampai = '';	

if (isset($_GET['idg'])) include('laboratorium/laboratorium_del_add_nilai_kritis.php');	

if(isset($_GET['idx'])){
	$nilai_kritis_id = $_GET['idx'];
	$qry_nilai_kritis = 'SELECT NILAI_KRITIS_MULAI,NILAI_KRITIS_SAMPAI,CH_REPORT,
						NAMA_PEMERIKSAAN
						FROM m_nilai_kritis_laboratorium
						WHERE NILAI_KRITIS_ID = "' . $nilai_kritis_id . '"';
	$get_nilai_kritis = mysql_query($qry_nilai_kritis) or die(mysql_error());
	$dat_nilai_kritis = mysql_fetch_assoc($get_nilai_kritis);
	$ch_report = $dat_nilai_kritis['CH_REPORT'];
	$nama_periksaan = $dat_nilai_kritis['NAMA_PEMERIKSAAN'];
	$nilai_mulai = $dat_nilai_kritis['NILAI_KRITIS_MULAI'];
	$nilai_sampai = $dat_nilai_kritis['NILAI_KRITIS_SAMPAI'];
}	

if(isset($_POST['simpan'])){
	$nilai_kritis_id = $_POST['nilai_kritis_id'];
	$ch_report = $_POST['ch_report'];
	$nama_periksaan = $_POST['pemeriksaan'];
	$nilai_mulai = $_POST['nilai_mulai'];
	$nilai_sampai = $_POST['nilai_sampai'];
	$_err = '';
	if(empty($ch_report)) $_err .= 'Group Pemeriksaan Harus Diisi \n'; 
	if(empty($nama_periksaan)) $_err .= 'Pemeriksaan Harus Diisi \n'; 
	if(empty($nilai_mulai)) $_err .= 'Nilai Kritis Harus Diisi \n'; 
	if(empty($nilai_sampai)) $_err .= 'Nilai Kritis Harus Diisi \n';
	if($_err == ''){
		if(empty($nilai_kritis_id)){
			mysql_query('INSERT INTO m_nilai_kritis_laboratorium(
						NILAI_KRITIS_MULAI,NILAI_KRITIS_SAMPAI,CH_REPORT,
						NAMA_PEMERIKSAAN) VALUES(
						"' . $nilai_mulai . '","' . $nilai_sampai . '",
						"' . $ch_report . '","' . $nama_periksaan . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE m_nilai_kritis_laboratorium
						SET NILAI_KRITIS_MULAI = "' . $nilai_mulai . '",
						NILAI_KRITIS_SAMPAI = "' . $nilai_sampai . '",
						CH_REPORT = "' . $ch_report . '",
						NAMA_PEMERIKSAAN = "' . $nama_periksaan . '"
						WHERE NILAI_KRITIS_ID = "' . $nilai_kritis_id . '"') or die(mysql_error());
		}	
		$nilai_kritis_id = '';
		$ch_report = '';
		$nama_periksaan = '';
		$nilai_mulai = '';
		$nilai_sampai = '';	
		echo '<script>';
		echo 'window.location = "' . currentUrl() . '"';
		echo '</script>';
	}else{
		$msg_info = $_err;
	}	
}		
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <form name="searchicd" method="post" >
    <table class="tableform" border="0" >
        <tr>
            <td>Group Pemeriksaan</td>
            <td><select name="ch_report" id="pemeriksaan_group" class="text_dt" onchange="javascript: MyAjaxRequest('sl_pemeriksaan','index.php?ajaxrequest=pemeriksaanlab&group=' + this.value);return false;">
			<option value="">-</option>
			<?php
			$sql_group = 'SELECT DISTINCT CH_REPORT FROM m_tarif_pemeriksaan WHERE LENGTH(CH_REPORT) > 0';
			$get_group = mysql_query($sql_group) or die(mysql_error());
			while($dat_group = mysql_fetch_array($get_group)){ ?>
				<option value="<?php echo $dat_group['CH_REPORT']; ?>" <?php if($dat_group['CH_REPORT'] == $ch_report) echo 'selected="selected"'; ?>  
				><?php echo $dat_group['CH_REPORT']; ?></option>
			<?php } ?>
			</select></td>
        </tr>
		<tr>
            <td>Pemeriksaan</td>
            <td><div id="sl_pemeriksaan" >
			<select name="pemeriksaan" class="text_dt" onchange="javascript: MyAjaxRequest('itm_pemeriksaan','index.php?ajaxrequest=itempemeriksaanlab&group=' + document.getElementById('pemeriksaan_group').value + '&periksa=' + this.value);return false;">
			<option value="">-</option>
			<?php
			$sql_pemeriksaan = 'SELECT DISTINCT CONCAT(NAMA_PEMERIKSAAN_GROUP," ",NAMA_PEMERIKSAAN) AS NAMA_PEMERIKSAAN  FROM m_tarif_pemeriksaan WHERE CH_REPORT = "' . $ch_report . '"';
			$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
			while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){ ?>
				<option value="<?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?>" <?php if($dat_pemeriksaan['NAMA_PEMERIKSAAN'] == $nama_periksaan) echo 'selected="selected"'; ?>  
				><?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?></option>
			<?php } ?>
			</select></div></td>
        </tr>
		<tr>
            <td>Nilai Kritis Mulai</td>
            <td><input type="text" name="nilai_mulai" class="text_dt" value="<?php echo $nilai_mulai; ?>" /></td>
        </tr>
		<tr>
            <td>Sampai Dengan</td>
            <td><input type="text" name="nilai_sampai" class="text_dt" value="<?php echo $nilai_sampai; ?>" /></td>
        </tr>
        <tr>
            <td><div id="pr"></div></td>
            <td align="right"><input type="submit" name="simpan" value="simpan" class="myButton" />
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="nilai_kritis_id" value="<?php echo $nilai_kritis_id; ?>" />
</form>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table border="1" class="tableData" id="tfhover">
	<tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Group Pemeriksaan</th>
		<th rowspan="2">Pemeriksaan</th>
	    <th colspan="2">Nilai Kritis</th>
		<th rowspan="2">Option</th>
	</tr>
	<tr>
	  <th>Mulai</th>
      <th>Sampai Dengan</th>
  </tr>
<?php 
	$qry_nilai_kritis = 'SELECT m_nilai_kritis_laboratorium.NILAI_KRITIS_ID,m_nilai_kritis_laboratorium.NILAI_KRITIS_MULAI,
				m_nilai_kritis_laboratorium.NILAI_KRITIS_SAMPAI,m_nilai_kritis_laboratorium.CH_REPORT,
				m_nilai_kritis_laboratorium.NAMA_PEMERIKSAAN
				FROM m_nilai_kritis_laboratorium
				ORDER BY m_nilai_kritis_laboratorium.CH_REPORT,m_nilai_kritis_laboratorium.NAMA_PEMERIKSAAN';
	$get_nilai_kritis = mysql_query($qry_nilai_kritis) or die(mysql_error());
	$no = 1;
	while($dat_nilai_kritis = mysql_fetch_array($get_nilai_kritis)){ ?>
		<tr>
			<td align="center"><?php echo $no; ?></td>
			<td><?php echo $dat_nilai_kritis['CH_REPORT']; ?></td>
			<td><?php echo $dat_nilai_kritis['NAMA_PEMERIKSAAN']; ?></td>
			<td align="center"><?php echo $dat_nilai_kritis['NILAI_KRITIS_MULAI']; ?></td>
			<td align="center"><?php echo $dat_nilai_kritis['NILAI_KRITIS_SAMPAI']; ?></td>
			<td align="center">
			<a href="<?php echo currentUrl(); ?>&idx=<?php echo $dat_nilai_kritis['NILAI_KRITIS_ID']; ?>" >ubah</a>
			<a href="<?php echo currentUrl(); ?>&idg=<?php echo $dat_nilai_kritis['NILAI_KRITIS_ID']; ?>&nmg=<?php echo $dat_nilai_kritis['NAMA_PEMERIKSAAN']; ?>" >hapus</a>
			</td>
		</tr>		
<?php $no++;	
	}	
?>  
</table>
</div>
