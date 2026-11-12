<?php
include('shared/array_filter_report_tarif.php');
$arr_visite = getStringArrayFilter('visite');
 
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,m_pasien.NAMA_PASIEN,
			DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
			DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			m_pasien.JNS_KELAMIN,m_pegawai.NAMA_PEGAWAI AS DPJP_UTAMA,
			m_pegawai1.NAMA_PEGAWAI AS DPJP_PENDAMPING_1,
			m_pegawai2.NAMA_PEGAWAI AS DPJP_PENDAMPING_2,
			m_pegawai3.NAMA_PEGAWAI AS DPJP_PENDAMPING_3,
			m_ruang.NAMA_RUANG,m_ruang.RUANG_ID
			FROM t_irna
			INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai1 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai1.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID_2 = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_irna.PEGAWAI_RAWAT_ID_3 = m_pegawai3.PEGAWAI_ID)
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_masuk = $dat_pasien['TGL_MASUK'];
$tgl_keluar = $dat_pasien['TGL_KELUAR'];
$tgl_skr = $dat_pasien['TGL_SKR'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];

$dpjp_1 = $dat_pasien['DPJP_UTAMA'];
$dpjp_2 = $dat_pasien['DPJP_PENDAMPING_1'];
$dpjp_3 = $dat_pasien['DPJP_PENDAMPING_2'];
$dpjp_4 = $dat_pasien['DPJP_PENDAMPING_3'];
$nama_ruang = $dat_pasien['NAMA_RUANG'];
$ruang_id = $dat_pasien['RUANG_ID'];
?>
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
		<table border="0" width="80%">
<tr>
	<td colspan="5"><strong>DATA PASIEN</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Nama Pasien</td>
	<td><input type="text" name="nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>" class="text_dt" style="width:300px;" /></td>
    <td width="200px">No. Rekam Medik</td>
	<td><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Tanggal Lahir</td>
	<td><input type="text" name="tgl_lahir" id="tgl_lahir" value="<?php echo $tgl_lahir; ?>" class="text_dt" /></td>
    <td width="200px">Jenis Kelamin</td>
	<td><input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if($jns_kelamin=='L') echo 'checked="checked"'; ?> />&nbsp;Laki-laki
		<input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if($jns_kelamin=='P') echo 'checked="checked"'; ?> />&nbsp;Perempuan</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Tanggal Masuk</td>
	<td><input type="text" name="tgl_masuk" id="tgl_masuk" value="<?php echo $tgl_masuk; ?>" class="text_dt" /></td>
    <td width="200px">Tanggal Keluar</td>
	<td><input type="text" name="tgl_keluar" id="tgl_keluar" value="<?php echo $tgl_keluar; ?>" class="text_dt" /></td>
</tr>
<?php
$qry_ruang = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d-%m-%Y %H:%i:%s") AS TANGGAL_UPDATE,
			 m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,m_pegawai2.NAMA_PEGAWAI AS PERAWAT_1, 
			 m_pegawai3.NAMA_PEGAWAI AS PERAWAT_2,m_pegawai4.NAMA_PEGAWAI AS PERAWAT_3
			 FROM t_irna_log
			 LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
			 LEFT JOIN m_pegawai ON (t_irna_log.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			 LEFT JOIN m_pegawai m_pegawai2 ON (t_irna_log.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
			 LEFT JOIN m_pegawai m_pegawai3 ON (t_irna_log.PEGAWAI_RAWAT_ID_2 = m_pegawai3.PEGAWAI_ID)
			 LEFT JOIN m_pegawai m_pegawai4 ON (t_irna_log.PEGAWAI_RAWAT_ID_3 = m_pegawai4.PEGAWAI_ID)
			 WHERE t_irna_log.IRNA_ID = "' . $idx . '"
			 AND t_irna_log.JNS_UPDATE = "R"
			 AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
			 AND t_irna_log.RUANG_ID_BARU IS NOT NULL
			 AND t_irna_log.TANGGAL_KELUAR IS NOT NULL
			 ORDER BY t_irna_log.TANGGAL_UPDATE';
$get_ruang = mysql_query($qry_ruang) or die(mysql_error());
if(mysql_num_rows($get_ruang) > 0){
	while($dat_ruang = mysql_fetch_array($get_ruang)){
		?>
			<tr>
				<td>&nbsp;</td>
				<td width="200px">Ruang Rawat</td>
				<td><input type="text" name="ruang" id="ruang" value="<?php echo $dat_ruang['NAMA_RUANG']; ?>" class="text_dt" style="width:300px;" /></td>
				<td width="200px">Keluar Ruang</td>
				<td><input type="text" name="tgl_keluar" id="tgl_keluar" value="<?php echo $dat_ruang['TANGGAL_UPDATE']; ?>" class="text_dt" style="width:300px;" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td width="200px">DPJP Utama</td>
				<td><input type="text" name="dpjp_1" id="dpjp_1" value="<?php echo $dat_ruang['NAMA_PEGAWAI']; ?>" class="text_dt" style="width:300px;" /></td>
				<td width="200px">DPJP Pendamping 1</td>
				<td><input type="text" name="dpjp_2" id="dpjp_2" value="<?php echo $dat_ruang['PERAWAT_1']; ?>" class="text_dt" style="width:300px;" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td width="200px">DPJP Pendamping 2</td>
				<td><input type="text" name="dpjp_3" id="dpjp_3" value="<?php echo $dat_ruang['PERAWAT_2']; ?>" class="text_dt" style="width:300px;" /></td>
				<td width="200px">DPJP Pendamping 3</td>
				<td><input type="text" name="dpjp_4" id="dpjp_4" value="<?php echo $dat_ruang['PERAWAT_3']; ?>" class="text_dt" style="width:300px;" /></td>
			</tr>
		<?php
	}
}			 
?>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Ruang Rawat</td>
	<td><input type="text" name="ruang" id="ruang" value="<?php echo $nama_ruang; ?>" class="text_dt" style="width:300px;" /></td>
	<td width="200px">Keluar Ruang</td>
	<td><input type="text" name="tgl_keluar" id="tgl_keluar" value="<?php echo $tgl_keluar; ?>" class="text_dt" style="width:300px;" /></td>
</tr>			 
<tr>
	<td>&nbsp;</td>
	<td width="200px">DPJP Utama</td>
	<td><input type="text" name="dpjp_1" id="dpjp_1" value="<?php echo $dpjp_1; ?>" class="text_dt" style="width:300px;" /></td>
    <td width="200px">DPJP Pendamping 1</td>
	<td><input type="text" name="dpjp_2" id="dpjp_2" value="<?php echo $dpjp_2; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">DPJP Pendamping 2</td>
	<td><input type="text" name="dpjp_3" id="dpjp_3" value="<?php echo $dpjp_3; ?>" class="text_dt" style="width:300px;" /></td>
    <td width="200px">DPJP Pendamping 3</td>
	<td><input type="text" name="dpjp_4" id="dpjp_4" value="<?php echo $dpjp_4; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr>
	<td colspan="5">
	<table border="1" class="tableData" id="tfhover" >
    <tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Hari Rawat (Ke)</th>
		<th rowspan="2">Dokter Visite</th>
        <th colspan="2">Waktu Visite</th>
        <th rowspan="2">Keterangan</th>
		<th rowspan="2">Action</th>
    </tr>
    <tr>
      <th>< 11.00</th>
	  <th>> 11.00</th>
    </tr>
<?php
	$x = 1;
	$y = 1;
	$tanggal = '';
	$tgl2 = $tgl_keluar;
	if($tgl_keluar == '' or $tgl_keluar == '00/00/0000') $tgl2 = $dat_pasien['TGL_SKR']; 
		$qry_visite = 'SELECT DATE_FORMAT(vdate.SELECTED_DATE,"%d/%m/%Y") AS SELECTED_DATE,
					tvisite.JAM_TARIF,tvisite.NAMA_TARIF,tvisite.NAMA_PEGAWAI,tvisite.NAMA_PELAKSANA,
					tvisite.PEGAWAI_ID,tvisite.PELAKSANA_ID
					FROM (SELECT ADDDATE("1970-01-01",T4.I*10000 + T3.I*1000 + T2.I*100 + T1.I*10 + T0.I) SELECTED_DATE FROM
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T0,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T1,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T2,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T3,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T4
					) vdate
					LEFT JOIN (
						SELECT STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_TARIF,
						DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%H:%i") AS JAM_TARIF,
						m_tarif.NAMA_TARIF,m_pegawai.NAMA_PEGAWAI,
						m_pegawai1.NAMA_PEGAWAI AS NAMA_PELAKSANA,
						m_pegawai.PEGAWAI_ID,m_pegawai1.PEGAWAI_ID AS PELAKSANA_ID
						FROM t_irna_tarif
						INNER JOIN m_tarif 
						ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
						LEFT JOIN m_pegawai 
						ON (t_irna_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						LEFT JOIN m_pegawai m_pegawai1 
						ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai1.PEGAWAI_ID)
						WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND (t_irna_tarif.ST_BAYAR = "" OR t_irna_tarif.ST_BAYAR = "Lunas") 
						AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_visite . ')						
					) tvisite 
					ON (vdate.SELECTED_DATE = tvisite.TGL_TARIF)
				WHERE vdate.SELECTED_DATE
				BETWEEN STR_TO_DATE("' . $tgl_masuk . '","%d/%m/%Y") 
				AND STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y")';
	$get_visite = mysql_query($qry_visite) or die(mysql_error());
	while($dat_visite = mysql_fetch_array($get_visite)){
		?>
		<tr>
		<td align="center"><?php echo $x; ?></td>
		<td><?php if($dat_visite['SELECTED_DATE'] != $tanggal){ 
					$tanggal = $dat_visite['SELECTED_DATE'];
					echo $dat_visite['SELECTED_DATE'] . ' -' . $y; 
					$y++;	
				} ?></td>
		<td><?php $dokter = trim($dat_visite['NAMA_PELAKSANA']);
			if($dokter == '') $dokter = $dat_visite['NAMA_PEGAWAI'];
			echo $dokter; ?></td>
		<?php
			$jam_visite_1 = '';
			$jam_visite_2 = '';
			$arr_waktu_visite = explode(':',$dat_visite['JAM_TARIF']);
			if(sizeof($arr_waktu_visite) == 2){
				$waktu_visite = ($arr_waktu_visite[0] * 60) + $arr_waktu_visite[1];
				if($waktu_visite <= 660) $jam_visite_1 =  $dat_visite['JAM_TARIF'];	
				if($waktu_visite > 660) $jam_visite_2 =  $dat_visite['JAM_TARIF'];	
			}	
		?>	
        <td align="center"><?php echo $jam_visite_1; ?></td>
		<td align="center"><?php echo $jam_visite_2; ?></td>
        <td><input type="text" name="keterangan<?php echo $x; ?>" id="keterangan<?php echo $x; ?>"
			class="text_dt" size="60" /></td>
		<td>
		<?php $dokter_id = $dat_visite['PELAKSANA_ID'];
			if($dokter_id == '') $dokter_id = $dat_visite['PEGAWAI_ID']; 
			if($dat_visite['JAM_TARIF'] != ''){ ?>
			<a href='#' onclick='simpan(<?php echo $dokter_id . ',' . $idx . ',"' . $dat_visite['SELECTED_DATE'] . ' ' . $dat_visite['JAM_TARIF'] . '",' . $ruang_id . ',' . $x; ?>)' >simpan</a>
			<?php } ?>
			</td>	
		</tr>
	<?php $x++; }	
?>	
</table>
	</td>
</tr>
<tr><td colspan="5">&nbsp;</td></tr>	
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td colspan="3" align="right">
		<a href="index.php?link=8539cfc3e5c90973532cccd9455a664f">
		<input type="button" value="tutup" class="myButton" />
		</a></td>
</tr>		
</table>	
</div>
</div> 
<script>
function simpan(pg,idx,tg,rg,dt){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=visitharianpasieniri',
		type: 'POST',
		async : false,
		data: {
			dokter	: pg,
			id	: idx,
			tanggal	: tg,
			ruang	: rg,
			keterangan : document.getElementById('keterangan' + dt).value
		},
		success: function(data) {
			alert(data);
		},
		timeout: 60
	});
}
</script>