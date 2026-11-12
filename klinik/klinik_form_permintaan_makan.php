<?php
if(isset($_POST['simpan'])){
	include('klinik/klinik_save_permintaan_makan.php');
}

$nomr = '';
if (isset($_SESSION['klinikpermintaanmakan_nomr']))
	$nomr = $_SESSION['klinikpermintaanmakan_nomr'];

if (isset($_GET['nomr'])) {
	$nomr = $_GET['nomr'];
	$_SESSION['klinikpermintaanmakan_nomr'] = $nomr;
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
            <td width="20%">Nomor MR</td>
            <td width="30%"><input type="text" name="nomr" id="nomr" class="text_dt" style="width:200px;" value="<?php echo $nomr; ?>" /></td>
			<td><input type="submit" value="cari" class="myButton" /></td>
        </tr>
    </table>
	<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</div>
</form>
<?php } ?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="form_makan" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
       <th>No</th>
       <th>Nomor MR</th>      
		<th>Nama Pasien</th>
		<th>Tgl Lahir</th>
       <th>Diagnosa</th>
		<th>Alergi</th>
		<th>Diet</th>
		<th>Vegetarian</th>
		<th>Puasa</th>
		<th>Bentuk Makan</th>
		<th>Waktu Makan</th>
    </tr>
<?php
if(!isset($_GET['idm'])){
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,m_pasien.NAMA_PASIEN,
		m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
		t_makan.DIAGNOSA,
		t_makan.ALERGI,
		t_makan.DIET,
		t_makan.VEGETARIAN,
		t_makan.PUASA,
		GROUP_CONCAT(t_irja_diagnosa.DIAGNOSA SEPARATOR "||") AS DIAGNOSA_PAM,
		GROUP_CONCAT(t_irja_alergi.ALERGI SEPARATOR "||") AS ALERGI_PAM,
		t_makan.JENIS_MAKAN,
		t_makan.WAKTU_MAKAN,
		"" AS TANGGAL_PERMINTAAN
		FROM db_simrs.t_irja
		INNER JOIN db_simrs.m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
		LEFT JOIN db_simrs.t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		LEFT JOIN db_simrs.t_irja_alergi ON (t_irja.IRJA_ID = t_irja_alergi.IRJA_ID)
		LEFT JOIN db_inventorirs.t_gizi_permintaan_makan_rajal t_makan ON (t_irja.IRJA_ID = t_makan.RAJAL_ID
			AND t_makan.GIZI_PERMINTAAN_ID = (
				SELECT MAX(t_mx.GIZI_PERMINTAAN_ID) FROM db_inventorirs.t_gizi_permintaan_makan_rajal t_mx
				WHERE t_mx.RAJAL_ID = t_irja.IRJA_ID
			)
		)
		WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL	
		AND t_irja.PASIEN_KELUAR IS NULL AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
		' . (($nomr != '') ? 'AND t_irja.NOMR = "' . $nomr . '"' : '') . '
		GROUP BY t_irja.IRJA_ID
		ORDER BY m_pasien.NAMA_PASIEN';	
}else{
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,m_pasien.NAMA_PASIEN,
		m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
		t_makan.DIAGNOSA,
		t_makan.ALERGI,
		t_makan.DIET,
		t_makan.VEGETARIAN,
		t_makan.PUASA,
		GROUP_CONCAT(t_irja_diagnosa.DIAGNOSA SEPARATOR "||") AS DIAGNOSA_PAM,
		GROUP_CONCAT(t_irja_alergi.ALERGI SEPARATOR "||") AS ALERGI_PAM,
		t_makan.JENIS_MAKAN,
		t_makan.WAKTU_MAKAN,
		DATE_FORMAT(t_makan.TANGGAL_PERMINTAAN,"%d-%m-%Y") AS TANGGAL_PERMINTAAN
		FROM db_simrs.t_irja
		INNER JOIN db_simrs.m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
		LEFT JOIN db_simrs.t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		LEFT JOIN db_simrs.t_irja_alergi ON (t_irja.IRJA_ID = t_irja_alergi.IRJA_ID)
		LEFT JOIN db_inventorirs.t_gizi_permintaan_makan_rajal t_makan ON (t_irja.IRJA_ID = t_makan.RAJAL_ID)
		WHERE t_makan.GIZI_PERMINTAAN_ID = "' . $_GET['idm'] . '"';
}	
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());	
$no = 1;
while($dat_pasien = mysql_fetch_array($get_pasien)){ ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo formatNomr($dat_pasien['NOMR']); ?></td>
		<td><?php echo $dat_pasien['NAMA_PASIEN']; ?></td>
		<td><?php echo changeDateFormat($dat_pasien['TGL_LAHIR']) . ' [' . $dat_pasien['JNS_KELAMIN'] . ']'; ?></td>
		<td><?php 
			$x_diagnosa = $dat_pasien['DIAGNOSA']; 
			if($x_diagnosa == '') $x_diagnosa = $dat_pasien['DIAGNOSA_PAM'];
			$arr_diagnosa = explode('||',$x_diagnosa);
			$i = 1;
			while($i < 6){
				echo '<input type="text" name="diag_' . $no . '_' . $i . '" value="' . (isset($arr_diagnosa[$i-1]) ? $arr_diagnosa[$i-1] : '') . '" class="text_dt" style="width:150px;"/><br/>';
				$i++;
			}
		?></td>
		<td><?php 
			$x_alergi = $dat_pasien['ALERGI']; 
			if($x_alergi == '') $x_alergi = $dat_pasien['ALERGI_PAM'];
			$arr_alergi = explode('||',$x_alergi);
			$i = 1;
			while($i < 6){
				echo '<input type="text" name="alergi_' . $no . '_' . $i . '" value="' . (isset($arr_alergi[$i-1]) ? $arr_alergi[$i-1] : '') . '" class="text_dt" style="width:150px;"/><br/>';
				$i++;
			}
		?></td>
		<td><?php 
			$x_diet = $dat_pasien['DIET']; 
			$arr_diet = explode('||',$x_diet);
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
						echo '<option value="' . $row . '" ' . (($dat_pasien['JENIS_MAKAN'] == $row) ? 'selected' : '') . '>' . $row . '</option>';
					}
				?>
			</select>
			<input type="hidden" name="idx_<?php echo $no; ?>" value="<?php echo $dat_pasien['IRJA_ID']; ?>" />
			<input type="hidden" name="permintaan_id" value="<?php echo ((isset($_GET['idm'])) ? $_GET['idm']:''); ?>" />
		</td>
		<td align="center">
			<?php
				$arr_waktu_makan = explode(':',$dat_pasien['WAKTU_MAKAN']);
				$jam = '';
				if(isset($arr_waktu_makan[0])) $jam = $arr_waktu_makan[0];
				$menit = '';
				if(isset($arr_waktu_makan[1])) $menit = $arr_waktu_makan[1];
			?>
			<select name="jam_<?php echo $no; ?>" id="jam_makan<?php echo $no; ?>" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit_<?php echo $no; ?>" id="menit_makan<?php echo $no; ?>" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>
			<input type="hidden" name="tgl_permintaan_<?php echo $no; ?>" value="<?php echo $dat_pasien['TANGGAL_PERMINTAAN']; ?>" />
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
	<a href="index.php?link=8f30fb90f37b4942e3e528cb5ceb02aa">
	<input type="button" value="selesai" class="myButton" />
	</a>
	</td>
</tr>
</table>
</div>
</form>	
</div>
</div>		