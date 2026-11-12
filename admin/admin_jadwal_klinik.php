<?php
if(isset($_POST['simpan'])){
	$rowcnt = $_POST['rowcnt'];
	$y = 1;
	while($y < $rowcnt){
		$unit_id = $_POST['unit_id_'. $y];
		mysql_query('DELETE FROM t_klinik_jadwal WHERE UNIT_ID = "' . $unit_id .'"') or die(mysql_error());
			if(isset($_POST['minggu_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("0","' . $unit_id . '","' . $_POST['buka_minggu_'. $y] . '","' . $_POST['tutup_minggu_'. $y] . '","' . $_POST['kuota_minggu_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['senin_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("1","' . $unit_id . '","' . $_POST['buka_senin_'. $y] . '","' . $_POST['tutup_senin_'. $y] . '","' . $_POST['kuota_senin_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['selasa_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("2","' . $unit_id . '","' . $_POST['buka_selasa_'. $y] . '","' . $_POST['tutup_selasa_'. $y] . '","' . $_POST['kuota_selasa_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['rabu_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("3","' . $unit_id . '","' . $_POST['buka_rabu_'. $y] . '","' . $_POST['tutup_rabu_'. $y] . '","' . $_POST['kuota_rabu_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['kamis_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("4","' . $unit_id . '","' . $_POST['buka_kamis_'. $y] . '","' . $_POST['tutup_kamis_'. $y] . '","' . $_POST['kuota_kamis_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['jumat_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("5","' . $unit_id . '","' . $_POST['buka_jumat_'. $y] . '","' . $_POST['tutup_jumat_'. $y] . '","' . $_POST['kuota_jumat_'. $y] . '")') or die(mysql_error());
			}
			if(isset($_POST['sabtu_'. $y])){
				mysql_query('INSERT INTO t_klinik_jadwal(HARI_ID,UNIT_ID,JAM_MULAI_LAYANAN,JAM_SELESAI_LAYANAN,KUOTA) VALUES("6","' . $unit_id . '","' . $_POST['buka_sabtu_'. $y] . '","' . $_POST['tutup_sabtu_'. $y] . '","' . $_POST['kuota_sabtu_'. $y] . '")') or die(mysql_error());
			}
		$y++;
	}
}

$sql_jadwal = 'SELECT UNIT_ID, NAMA_UNIT, MAX(MINGGU) AS MINGGU, MAX(SENIN) AS SENIN, MAX(SELASA) AS SELASA,
		MAX(RABU) AS RABU,MAX(KAMIS) AS KAMIS,MAX(JUMAT) AS JUMAT,MAX(SABTU) AS SABTU,
		MAX(KUOTA_MINGGU) AS KUOTA_MINGGU, 
		MAX(KUOTA_SENIN) AS KUOTA_SENIN, 
		MAX(KUOTA_SELASA) AS KUOTA_SELASA, 
		MAX(KUOTA_RABU) AS KUOTA_RABU, 
		MAX(KUOTA_KAMIS) AS KUOTA_KAMIS, 
		MAX(KUOTA_JUMAT) AS KUOTA_JUMAT, 
		MAX(KUOTA_SABTU) AS KUOTA_SABTU, 
		MAX(BUKA_MINGGU) AS BUKA_MINGGU, 
		MAX(BUKA_SENIN) AS BUKA_SENIN, 
		MAX(BUKA_SELASA) AS BUKA_SELASA, 
		MAX(BUKA_RABU) AS BUKA_RABU, 
		MAX(BUKA_KAMIS) AS BUKA_KAMIS, 
		MAX(BUKA_JUMAT) AS BUKA_JUMAT, 
		MAX(BUKA_SABTU) AS BUKA_SABTU, 
		MAX(TUTUP_MINGGU) AS TUTUP_MINGGU, 
		MAX(TUTUP_SENIN) AS TUTUP_SENIN, 
		MAX(TUTUP_SELASA) AS TUTUP_SELASA, 
		MAX(TUTUP_RABU) AS TUTUP_RABU, 
		MAX(TUTUP_KAMIS) AS TUTUP_KAMIS, 
		MAX(TUTUP_JUMAT) AS TUTUP_JUMAT, 
		MAX(TUTUP_SABTU) AS TUTUP_SABTU
		FROM (
			SELECT m_unit.UNIT_ID,
			m_unit.NAMA_UNIT,
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN "1" END AS MINGGU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 1 THEN "1" END AS SENIN,
			CASE WHEN t_klinik_jadwal.HARI_ID = 2 THEN "1" END AS SELASA,
			CASE WHEN t_klinik_jadwal.HARI_ID = 3 THEN "1" END AS RABU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 4 THEN "1" END AS KAMIS,
			CASE WHEN t_klinik_jadwal.HARI_ID = 5 THEN "1" END AS JUMAT,
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN "1" END AS SABTU,
			
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.KUOTA END AS KUOTA_MINGGU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 1 THEN t_klinik_jadwal.KUOTA END AS KUOTA_SENIN,
			CASE WHEN t_klinik_jadwal.HARI_ID = 2 THEN t_klinik_jadwal.KUOTA END AS KUOTA_SELASA,
			CASE WHEN t_klinik_jadwal.HARI_ID = 3 THEN t_klinik_jadwal.KUOTA END AS KUOTA_RABU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 4 THEN t_klinik_jadwal.KUOTA END AS KUOTA_KAMIS,
			CASE WHEN t_klinik_jadwal.HARI_ID = 5 THEN t_klinik_jadwal.KUOTA END AS KUOTA_JUMAT,
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.KUOTA END AS KUOTA_SABTU,
			
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_MINGGU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 1 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_SENIN,
			CASE WHEN t_klinik_jadwal.HARI_ID = 2 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_SELASA,
			CASE WHEN t_klinik_jadwal.HARI_ID = 3 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_RABU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 4 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_KAMIS,
			CASE WHEN t_klinik_jadwal.HARI_ID = 5 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_JUMAT,
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.JAM_MULAI_LAYANAN END AS BUKA_SABTU,
			
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_MINGGU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 1 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_SENIN,
			CASE WHEN t_klinik_jadwal.HARI_ID = 2 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_SELASA,
			CASE WHEN t_klinik_jadwal.HARI_ID = 3 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_RABU,
			CASE WHEN t_klinik_jadwal.HARI_ID = 4 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_KAMIS,
			CASE WHEN t_klinik_jadwal.HARI_ID = 5 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_JUMAT,
			CASE WHEN t_klinik_jadwal.HARI_ID = 0 THEN t_klinik_jadwal.JAM_SELESAI_LAYANAN END AS TUTUP_SABTU
			
			FROM m_unit
			LEFT JOIN t_klinik_jadwal 
			ON (m_unit.UNIT_ID = t_klinik_jadwal.UNIT_ID) 
			WHERE m_unit.IRJA IS NOT NULL
		) t_jadwal
		GROUP BY UNIT_ID, NAMA_UNIT
		ORDER BY NAMA_UNIT';
$get_jadwal = mysql_query($sql_jadwal) or die(mysql_error());		
$x = 1;
?>
<br />
<br />
<form name="form2" method="post">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />	
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="200" rowspan="2">Unit/Klinik</th>
			<th colspan="2">Minggu</th>
			<th colspan="2">Senin</th>
			<th colspan="2">Selasa</th>
			<th colspan="2">Rabu</th>
			<th colspan="2">Kamis</th>
			<th colspan="2">Jumat</th>
			<th colspan="2">Sabtu</th>
			</tr>
        <tr>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
          <th>Ada<br />Kuota</th>
          <th>Buka<br />Tutup</th>
        </tr>
        <?php
        while ($dat_jadwal = mysql_fetch_array($get_jadwal)) {
            echo '<tr>';
            echo '<td rowspan="2"><input type="hidden" name="unit_id_' . $x . '" value="' . $dat_jadwal['UNIT_ID'] . '" />' . $dat_jadwal['NAMA_UNIT'] . '</td>';
            ?>
			<td align="center"><input type="checkbox" name="minggu_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['MINGGU'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_minggu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_MINGGU']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="senin_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['SENIN'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_senin_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_SENIN']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="selasa_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['SELASA'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_selasa_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_SELASA']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="rabu_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['RABU'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_rabu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_RABU']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="kamis_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['KAMIS'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_kamis_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_KAMIS']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="jumat_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['JUMAT'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_jumat_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_JUMAT']; ?>" class="text_dt" style="width:60px;" /></td>
		    <td align="center"><input type="checkbox" name="sabtu_<?php echo $x; ?>" value="1" <?php if(!empty($dat_jadwal['SABTU'])) echo 'checked="checked"'; ?> /></td>
		    <td><input type="text" name="buka_sabtu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['BUKA_SABTU']; ?>" class="text_dt" style="width:60px;" /></td>
		</tr>
		<tr>
		  <td><input type="text" name="kuota_minggu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_MINGGU']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_minggu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_MINGGU']; ?>" class="text_dt" style="width:60px;" /></td>
		  <td><input type="text" name="kuota_senin_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_SENIN']; ?>" class="text_dt" style="width:40px;" /></td>
		  <td><input type="text" name="tutup_senin_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_SENIN']; ?>" class="text_dt" style="width:60px;" /></td>
          <td><input type="text" name="kuota_selasa_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_SELASA']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_selasa_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_SELASA']; ?>" class="text_dt" style="width:60px;" /></td>
          <td><input type="text" name="kuota_rabu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_RABU']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_rabu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_RABU']; ?>" class="text_dt" style="width:60px;" /></td>
          <td><input type="text" name="kuota_kamis_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_KAMIS']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_kamis_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_KAMIS']; ?>" class="text_dt" style="width:60px;" /></td>
          <td><input type="text" name="kuota_jumat_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_JUMAT']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_jumat_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_JUMAT']; ?>" class="text_dt" style="width:60px;" /></td>
          <td><input type="text" name="kuota_sabtu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['KUOTA_SABTU']; ?>" class="text_dt" style="width:40px;" /></td>
          <td><input type="text" name="tutup_sabtu_<?php echo $x; ?>" value="<?php echo $dat_jadwal['TUTUP_SABTU']; ?>" class="text_dt" style="width:60px;" /></td>
		</tr>
			<?php
        $x++;
		}
        ?>
    </table>
	<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >                      
								<input type="hidden" name="rowcnt" value="<?php echo $x; ?>" />
								<input type="submit" name="simpan" value="simpan" class="myButton1" /> 
                </td>
            </tr>
    </table>
</form>