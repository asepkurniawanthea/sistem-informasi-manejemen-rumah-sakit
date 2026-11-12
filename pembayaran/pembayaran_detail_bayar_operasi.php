<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];

$qry_pasien = 'SELECT t_operasi.OPERASI_ID,t_operasi.NOMR,t_operasi.PEGAWAI_PELAKSANA_ID,
				"" AS RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.JENIS_BAYAR_ID,t_operasi.KELAS_RAWAT,
				t_irja.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,
				m_unit.NAMA_UNIT AS NAMA_RUANG,"" AS KELAS_JAMINAN,t_operasi.RAWAT_ID,
				t_operasi.ST_MASUK,t_irja.UNIT_ID
				FROM t_operasi
				INNER JOIN t_irja ON (t_irja.IRJA_ID = t_operasi.RAWAT_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $_GET['idx'] . '"';				

$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$pegawai_id = $dat_pasien['NAMA_DOKTER'];
$nama_unit = $dat_pasien['NAMA_RUANG'];
$tgl_daftar = $dat_pasien['TANGGAL_OPERASI'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$rawat_id = $dat_pasien['RAWAT_ID'];

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=dd089db9eb2173dfef5852adf6c881b0');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php

$sql_tarif_operasi  = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
							END 
					END)
				) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
				t_operasi_tarif.KODE_CASH,t_operasi_tarif.KODE_REKENING
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.OPERASI_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1")
				GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';		
$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
					t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
					t_ipenunjang_tarif.KODE_CASH,t_ipenunjang_tarif.KODE_REKENING
					FROM t_ipenunjang 
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ipenunjang.OPERASI_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "ORJ"	
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
					t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
					t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
					ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	
$bayar_total = 0;				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th width="20px">No</th>
	<th width="100px">No Kwitansi</th>
	<th width="70px">Tanggal</th>
	<th colspan="2">Tindakan/ Pemeriksaan</th>
	<th width="70px">Jumlah</th>
	<th width="90px">Satuan</th>
	<th width="100px">Harga</th>
	<th width="100px">Pembayaran</th>
	<th width="150px">Register</th>
	<th width="100px">Status</th>
  </tr>
<?php
	$i = 1;
	while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
		$harga = 0;
		$status = $dat_tarif_operasi['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_operasi['HARGA'];
		$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$operasi_id = $dat_tarif_operasi['OPERASI_ID'];					
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_operasi['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['TGL_TARIF']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_operasi['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_operasi['NAMA_JAMINAN']; 
		if($dat_tarif_operasi['KODE_CASH'] != '') echo ' /' . $dat_tarif_operasi['KODE_CASH'];
		if($dat_tarif_operasi['KODE_REKENING'] != '') echo ' /' . $dat_tarif_operasi['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_operasi['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_operasi_detail  = 'SELECT t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
							ELSE	
								CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								END 
							END AS TARIF_NON_KELAS
							FROM t_operasi_tarif
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_operasi.OPERASI_ID = "' . $idx . '" 
							AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
							AND t_operasi_tarif.NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"
							GROUP BY t_operasi_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_operasi_detail = mysql_query($sql_tarif_operasi_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_operasi_detail = mysql_fetch_array($get_tarif_operasi_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['NAMA_TARIF'] . ' (' . $dat_tarif_operasi_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_operasi_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_operasi_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_operasi_detail['TARIF_NON_KELAS'] * $dat_tarif_operasi_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php $y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
								echo '<select id="op_ch_' . $dat_tarif_operasi['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
								foreach ($arr_cash as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;';

								echo '<select id="op_rk_' . $dat_tarif_operasi['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
								echo '<option value=""> - </option>';
								foreach ($arr_rekening as $row) {
									echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
								}
								echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>,<?php echo $harga; ?>);return false;" />
					<?php } else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_operasi(<?php echo $operasi_id; ?>,<?php echo $dat_tarif_operasi['NO_TARIF']; ?>);return false;"/>&nbsp;
					<select name="batal_opr_<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" id="batal_opr_<?php echo $dat_tarif_operasi['NO_TARIF']; ?>" class="text_dt" >
					<option value=""></option>
					<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					</select>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
	
	while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
		$harga = 0;
		$status = $dat_tarif_penunjang['ST_BAYAR'];
		if($status != 'Batal') $harga = $dat_tarif_penunjang['HARGA'];
		$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
		$bayar_total = $bayar_total + $harga;
		$jnsorder = $dat_tarif_penunjang['JNS_ORDER'];
		?>
		<tr>
		<td align="center"><?php echo $i; ?></td>
		<td align="center"><!--<input type="checkbox" name="tp<?php echo $t; ?>" id="tp<?php echo $t; ?>" value="p-<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>" <?php if($status == 'Batal') echo 'disabled="disabled"'; ?> />&nbsp;--><?php echo $dat_tarif_penunjang['NO_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['TANGGAL_DAFTAR']; ?></td>
		<td colspan="5"><?php echo $dat_tarif_penunjang['DESKRIPSI']; ?></td>
		<td align="center"><?php echo $dat_tarif_penunjang['NAMA_JAMINAN'];
		if($dat_tarif_penunjang['KODE_CASH'] != '') echo ' /' . $dat_tarif_penunjang['KODE_CASH'];
		if($dat_tarif_penunjang['KODE_REKENING'] != '') echo ' /' . $dat_tarif_penunjang['KODE_REKENING']; ?></td>
		<td><?php echo $dat_tarif_penunjang['USER_KASIR']; ?></td>
		<td align="center"><?php echo $status; ?></td>
		</tr>
		<?php 
			$sql_tarif_detail  = 'SELECT t_ipenunjang_tarif.TARIF_ID,COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
							CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.OPERASI_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"
							AND t_ipenunjang.JNS_ORDER = "ORJ"
							GROUP BY t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS
							ORDER BY m_tarif_group.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());				
			$y = 1;
			while($dat_tarif_penunjang_detail = mysql_fetch_array($get_tarif_detail)){
			?>
			<tr>
			<td colspan="3" align="center">&nbsp;</td>
			<td width="20" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['NAMA_TARIF'] . ' (' . $dat_tarif_penunjang_detail['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo $dat_tarif_penunjang_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_tarif_penunjang_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_tarif_penunjang_detail['TARIF_NON_KELAS'] * $dat_tarif_penunjang_detail['KUANTITI']); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			</tr>
		<?php $y++; }
		?>
			<tr>
				<td colspan="8" align="right">Total Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($harga); ?></td>
				<td colspan="3" align="center"><?php if($status != 'Batal'){ 
					if($no_bayar == ''){ 
							echo '<select id="pn_ch_' . $dat_tarif_penunjang['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
							foreach ($arr_cash as $row) {
								echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
							}
							echo '</select>&nbsp;';

							echo '<select id="pn_rk_' . $dat_tarif_penunjang['NO_TARIF'] . '" class="text_dt" style="width:60px;" >';
							echo '<option value=""> - </option>';
							foreach ($arr_rekening as $row) {
								echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
							}
							echo '</select>&nbsp;&nbsp;';
					?>
					<input type="button" class="myButton" value="bayar" onclick="javascript : bayar_penunjang(<?php echo $rawat_id; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>,<?php echo $harga; ?>,'orj');return false;" />
					<?php } else { ?>
					<input type="button" class="myButton" value="print" onclick="javascript : print_kwitansi_penunjang(<?php echo $rawat_id; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>);return false;" />&nbsp;
					<input type="button" class="myButton" value="batal" onclick="javascript : batal_bayar_penunjang(<?php echo $rawat_id; ?>,<?php echo $dat_tarif_penunjang['NO_TARIF']; ?>);return false;"/>
				<?php } } ?></td>
			</tr>
		<?php
	$i++;
	}
?>  
</table>
</div>
</div>
<div id="bayar"></div>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}
function bayar_penunjang(idx,no,harga,ord){
 var kode_cash = document.getElementById("pn_ch_" + no).value;
 var kode_rekening = document.getElementById("pn_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayarpenunjang&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ord=' + ord + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}
function print_kwitansi_penunjang(idx,no){
 window.open('http://localhost/nsimrs_print/print_pembayaran_penunjang.php?idx=' + idx + '&no=' + no + '&ord=irj','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
function batal_bayar_penunjang(idx, no,jn){
	if(confirm(no +' Dibatalkan ?')){
		MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarpenunjang&idx=' + idx + '&no=' + no + '&jn=' + jn);	
		alert('Simpan Data Pembatalan Berhasil.');
		window.location = '<?php echo currentURl(); ?>';
	}	
}
function bayar_operasi(idx,no,harga){
 var kode_cash = document.getElementById("op_ch_" + no).value;
 var kode_rekening = document.getElementById("op_rk_" + no).value;
 if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){	
 	MyAjaxRequest('bayar','index.php?ajaxrequest=bayaroperasi&idx=' + idx + '&no=' + no + '&jm=' + harga + '&ch=' + kode_cash + '&rk=' + kode_rekening);
 	alert('Simpan Data Pembayaran Berhasil.');
 	window.location = "<?php echo currentURl(); ?>";
 }
}
function print_kwitansi_operasi(idx,no){
	window.open('http://localhost/nsimrs_print/print_pembayaran_operasi.php?idx=' + idx + '&no=' + no,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
function batal_bayar_operasi(idx, no){
	var jns_batal = document.getElementById("batal_opr_" + no).value;
	if(jns_batal == ''){
		alert('Pilih Jenis Batal.');
	}else{
		if(confirm(no +' Dibatalkan ?')){
			MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayaroperasi&idx=' + idx + '&no=' + no + '&st=' + jns_batal);	
			alert('Simpan Data Pembatalan Berhasil.');
			window.location = '<?php echo currentURl(); ?>';
		}	
	}	
}
</script> 
<?php } ?>