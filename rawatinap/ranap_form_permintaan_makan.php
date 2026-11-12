<?php
if(isset($_POST['simpan'])){
	include('rawatinap/ranap_save_permintaan_makan.php');
}

$ruang_id = '';
if (isset($_SESSION['ranappermintaanmakan_ruang_id']))
	$ruang_id = $_SESSION['ranappermintaanmakan_ruang_id'];

if (isset($_GET['ruang_id'])) {
	$ruang_id = $_GET['ruang_id'];
	$_SESSION['ranappermintaanmakan_ruang_id'] = $ruang_id;
}

$nomr = '';
if (isset($_SESSION['ranappermintaanmakan_nomr']))
	$nomr = $_SESSION['ranappermintaanmakan_nomr'];

if (isset($_GET['nomr'])) {
	$nomr = $_GET['nomr'];
	$_SESSION['ranappermintaanmakan_nomr'] = $nomr;
}

$arr_bentuk_makan = array('Nasi','Nasi Tim','Bubur','Bubur Saring','Bubur Sumsum','Bubur Susu','Cair','Kentang','Puasa','Sufor');	
if(!isset($_GET['idm'])){
?>
<form name="search" method="get" >
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
     <table border="0" class="tableform" width="700">
		<tr>
            <td width="20%">Ruang Rawat</td>
            <td width="30%"><select name="ruang_id" id="ruang_id" class="text_dt" style="width:210px;" onchange="get_makan(); return false;" >
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
            <td width="20%">Nomor MR</td>
            <td width="30%"><input type="text" name="nomr" id="nomr" class="text_dt" style="width:200px;" value="<?php echo $nomr; ?>" /></td>
			<td><input type="submit" value="cari" class="myButton" /></td>
        </tr>
    </table>
	<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</div>
</form>
<?php } ?>
<form name="form_makan" method="post">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Nomor MR</th>      
        <th>Nama Pasien</th>
		 <th>Tgl Lahir</th>
		 <th>Ruang</th>
		 <th>Kamar</th>
        <th>Diagnosa</th>
		 <th>Alergi</th>
		 <th>Diet</th>
		 <th>Vegetarian</th>
		 <th>Puasa</th>
		 <th>Bentuk Makan</th>
    </tr>
<?php
if(!isset($_GET['idm'])){
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,m_pasien.NAMA_PASIEN,
		m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
		t_irna.NO_TMP_TIDUR,t_irna.RUANG_ID,
		GROUP_CONCAT(t_irna_diagnosa.DIAGNOSA SEPARATOR "||") AS DIAGNOSA,
		GROUP_CONCAT(t_irna_alergi.ALERGI SEPARATOR "||") AS ALERGI,
		t_gizi_permintaan_makan_ranap.DIET,
		t_gizi_permintaan_makan_ranap.VEGETARIAN,
		t_gizi_permintaan_makan_ranap.PUASA,
		t_gizi_permintaan_makan_ranap.JENIS_MAKAN,
		t_gizi_permintaan_makan_ranap.KAMAR
		FROM db_simrs.t_irna
		INNER JOIN db_simrs.m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
		INNER JOIN db_simrs.m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
		LEFT JOIN db_simrs.t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
		LEFT JOIN db_simrs.t_irna_alergi ON (t_irna.IRNA_ID = t_irna_alergi.IRNA_ID)
		LEFT JOIN db_inventorirs.t_gizi_permintaan_makan_ranap ON (t_irna.IRNA_ID = t_gizi_permintaan_makan_ranap.RANAP_ID)
		WHERE t_irna.PASIEN_MASUK IS NOT NULL AND t_irna.ST_BATAL IS NULL	
		AND t_irna.ST_PULANG IS NULL
		' . (($ruang_id != '') ? 'AND m_ruang.BANGSAL = "' . $ruang_id . '"' : '') . '
		' . (($nomr != '') ? 'AND t_irna.NOMR = "' . $nomr . '"' : '') . '
		GROUP BY t_irna.IRNA_ID
		ORDER BY m_pasien.NAMA_PASIEN';
}else{
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,m_pasien.NAMA_PASIEN,
		m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
		t_irna.NO_TMP_TIDUR,t_irna.RUANG_ID,
		t_gizi_permintaan_makan_ranap.DIAGNOSA,
		t_gizi_permintaan_makan_ranap.ALERGI,
		t_gizi_permintaan_makan_ranap.DIET,
		t_gizi_permintaan_makan_ranap.VEGETARIAN,
		t_gizi_permintaan_makan_ranap.PUASA,
		t_gizi_permintaan_makan_ranap.JENIS_MAKAN,
		t_gizi_permintaan_makan_ranap.KAMAR
		FROM db_simrs.t_irna
		INNER JOIN db_simrs.m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
		INNER JOIN db_simrs.m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
		LEFT JOIN db_inventorirs.t_gizi_permintaan_makan_ranap ON (t_irna.IRNA_ID = t_gizi_permintaan_makan_ranap.RANAP_ID)
		WHERE t_irna.IRNA_ID = "' . $_GET['idm'] . '"';
}	
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());	
$no = 1;
while($dat_pasien = mysql_fetch_array($get_pasien)){ ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo formatNomr($dat_pasien['NOMR']); ?></td>
		<td><?php echo $dat_pasien['NAMA_PASIEN']; ?></td>
		<td><?php echo changeDateFormat($dat_pasien['TGL_LAHIR']) . ' [' . $dat_pasien['JNS_KELAMIN'] . ']'; ?></td>
		<td><?php echo $dat_pasien['NAMA_RUANG'] . ' Kelas ' . $dat_pasien['KELAS_RAWAT'] . ' No ' . $dat_pasien['NO_TMP_TIDUR']; ?></td>
		<td><input type="text" name="kmr_<?php echo $no; ?>" class="text_dt" value="<?php echo $dat_pasien['KAMAR']; ?>" style="width:100px;"></td>
		<td><?php 
			$arr_diagnosa = explode('||',$dat_pasien['DIAGNOSA']);
			$i = 1;
			while($i < 6){
				echo '<input type="text" name="diag_' . $no . '_' . $i . '" value="' . (isset($arr_diagnosa[$i-1]) ? $arr_diagnosa[$i-1] : '') . '" class="text_dt" style="width:150px;"/><br/>';
				$i++;
			}
		?></td>
		<td><?php 
			$arr_alergi = explode('||',$dat_pasien['ALERGI']);
			$i = 1;
			while($i < 6){
				echo '<input type="text" name="alergi_' . $no . '_' . $i . '" value="' . (isset($arr_alergi[$i-1]) ? $arr_alergi[$i-1] : '') . '" class="text_dt" style="width:150px;"/><br/>';
				$i++;
			}
		?></td>
		<td><?php 
			$arr_diet = explode('||',$dat_pasien['DIET']);
			$i = 1;
			while($i < 6){
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function() {';
				echo 'jQuery("#diet_' . $no . '_' . $i . '").autocomplete("index.php?autocomp=autocompranapdiet",{width: 205});';
				echo '});';
				echo '</script>';
				echo '<input type="text" id="diet_' . $no . '_' . $i . '" name="diet_' . $no . '_' . $i . '" value="' . (isset($arr_diet[$i-1]) ? $arr_diet[$i-1] : '') . '" class="text_dt" style="width:150px;"/><br/>';
				$i++;
			}
		?></td>
		<td align="center">
			<input type="checkbox" id="veg_<?php echo $no; ?>" name="veg_<?php echo $no; ?>" value="1" <?php if($dat_pasien['VEGETARIAN'] == '1') echo 'checked'; ?> />
		</td>
		<td align="center">
			<input type="checkbox" id="puasa_<?php echo $no; ?>" name="puasa_<?php echo $no; ?>" value="1" <?php if($dat_pasien['PUASA'] == '1') echo 'checked'; ?> />
		</td>
		<td>
			<select name="mkn_<?php echo $no; ?>" class="text_dt">
				<option value="">-</option>
				<?php 
					foreach($arr_bentuk_makan as $row){
						echo '<option value="' . $row . '" ' . (($dat_pasien['JENIS_MAKAN'] == $row) ? 'selected' : '') .  '>' . $row . '</option>';
					}
				?>
			</select>
			<input type="hidden" name="idx_<?php echo $no; ?>" value="<?php echo $dat_pasien['IRNA_ID']; ?>" />
			<input type="hidden" name="rng_<?php echo $no; ?>" value="<?php echo $dat_pasien['RUANG_ID']; ?>" />
			<input type="hidden" name="tdr_<?php echo $no; ?>" value="<?php echo $dat_pasien['NO_TMP_TIDUR']; ?>" />
		</td>
	</tr>
<?php $no++; } ?>	
</table>
<input type="hidden" name="cn_no" value="<?php echo $no; ?>" />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%">
<tr>
	<td align="right" colspan="11"><input type="submit" name="simpan" value="simpan" class="myButton" />
	<a href="index.php?link=b9dd8bbfb4bfd7464009e8db36368a07">
	<input type="button" value="selesai" class="myButton" />
	</a>
	</td>
</tr>
</table>
</div>
</form>
</div>
</div>		