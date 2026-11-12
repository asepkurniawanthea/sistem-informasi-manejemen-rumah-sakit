<?php
if (!isset($_GET['import'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("Import Data SIMRS?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&import=1";
        }
    </script>
    <?php
}
if (isset($_GET['import'])) {
	//mysql_query('DELETE FROM m_pasien') or die(mysql_error());
	mysql_query('DELETE FROM t_irja') or die(mysql_error());
	mysql_query('DELETE FROM t_irja_diagnosa') or die(mysql_error());
	mysql_query('DELETE FROM t_irja_resep') or die(mysql_error());
	mysql_query('DELETE FROM t_irja_tarif') or die(mysql_error());
	mysql_query('DELETE FROM t_rm_peminjaman_buku') or die(mysql_error());
	mysql_query('DELETE FROM t_rm_tracer') or die(mysql_error());
	
	$connect_2 = mysql_connect($hostname_2, $username_2, $password_2) or die(mysql_error());
	mysql_select_db($database_2, $connect_2) or die(mysql_error());
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA,m_pasien.PARENT_NOMR,m_pasien.TEMPAT,DATE_FORMAT(m_pasien.TGLLAHIR,"%d/%m/%Y") AS TGLLAHIR,
					m_pasien.JENISKELAMIN,m_pasien.ALAMAT,m_pasien.KELURAHAN,
					m_pasien.KDKECAMATAN,m_pasien.KOTA,m_pasien.KDPROVINSI,m_pasien.NOTELP,m_pasien.NOKTP,m_pasien.SUAMI_ORTU,m_pasien.PEKERJAAN,
					m_pasien.STATUS,m_pasien.AGAMA,m_pasien.PENDIDIKAN,m_pasien.ALAMAT_KTP,m_pasien.PARENT_NOMR,
					m_pasien.IBUKANDUNG,CASE WHEN CONVERT(NOMR, SIGNED) < 600000 THEN "1" END AS ST_KHUSUS	 
					FROM m_pasien LIMIT 1';
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$total_row = mysql_num_rows($get_pasien);	
    ?>
	<table width="300" border="0">
		<tr>
			<td align="center"><div id="data" ><strong>Import Data Pasien</strong></div></td>
		</tr>
		<tr>
			<td align="center"><div id="total" >Total Data : <?php echo currFormat($total_row);?></div></td>
		</tr>
		<tr>
			<td align="center"><div id="progress" >Progres : 0 [0%]</div></td>
		</tr>
	</table>
    <?php
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
	$progress = 1;
	while($dat_pasien = mysql_fetch_array($get_pasien)){
		$nama_pasien = str_replace('"',"\'",$dat_pasien['NAMA']);
		$nama_pasien = str_replace("'","\'",$nama_pasien);
		$alamat = str_replace('"',"\'",$dat_pasien['ALAMAT']);
		$alamat = str_replace("'","\'",$alamat);
		$nama_ibu = str_replace('"',"\'",$dat_pasien['IBUKANDUNG']);
		$nama_ibu = str_replace("'","\'",$nama_ibu);
		$nama_suami = str_replace('"',"\'",$dat_pasien['SUAMI_ORTU']);
		$nama_suami = str_replace("'","\'",$nama_suami);
		
		/*mysql_query('INSERT INTO m_pasien(NOMR,PARENT_NOMR,NAMA_PASIEN,TMP_LAHIR,
								TGL_LAHIR,JNS_KELAMIN,ST_KAWIN,AGAMA_ID,PENDIDIKAN_ID,
								PEKERJAAN,ALAMAT,ALAMAT_RT,ALAMAT_RW,KELURAHAN_ID,
								KECAMATAN_ID,KOTA_ID,PROPINSI_ID,KODE_POS,
								NO_TELEPON,NAMA_IBU,NAMA_AYAH,NAMA_SUAMI_ISTERI,
								NIK,KHUSUS)
								VALUES(
								"' . $dat_pasien['NOMR'] . '","' . $dat_pasien['PARENT_NOMR'] . '","' . $nama_pasien . '","' . $dat_pasien['TEMPAT'] . '",
								' . fieldDate($dat_pasien['TGLLAHIR']) . ',"' . $dat_pasien['JENISKELAMIN'] . '","' . $dat_pasien['STATUS'] . '","' . $dat_pasien['AGAMA'] . '",
								"' . $dat_pasien['PENDIDIKAN'] . '","' . $dat_pasien['PEKERJAAN'] . '","' . $alamat . '",NULL, NULL,
								"' . $dat_pasien['KELURAHAN'] . '","' . $dat_pasien['KDKECAMATAN'] . '","' . $dat_pasien['KOTA'] . '",
								"' . $dat_pasien['KDPROVINSI'] . '",NULL,"' . $dat_pasien['NOTELP'] . '","' . $nama_ibu . '",
								NULL,"' . $nama_suami . '","' . $dat_pasien['NOKTP'] . '","' . $dat_pasien['ST_KHUSUS'] . '")') or die(mysql_error());	
								*/
			
		$perc_progress = ($progress / $total_row) * 100;
	?>
	<script type="text/javascript">
        document.getElementById("progress").innerHTML = "Progres : <?php echo currFormat($progress) . ' [' .round($perc_progress); ?>%]";
    </script>
	<?php
	$progress++; }
	?>
	<script type="text/javascript">
        document.getElementById("data").innerHTML = "<strong>Import Data Rawat Jalan</strong>";
		document.getElementById("total").innerHTML = "Total Data : 0";
		document.getElementById("progress").innerHTML = "Progres : 0 [0%]";
    </script>
	<?php
	$connect_2 = mysql_connect($hostname_2, $username_2, $password_2) or die(mysql_error());
	mysql_select_db($database_2, $connect_2) or die(mysql_error());
	$qry_irja = 'SELECT t_pendaftaran.NOMR,DATE_FORMAT(t_pendaftaran.TGLREG,"%d/%m/%Y") AS TGLREG,t_pendaftaran.KDDOKTER,t_pendaftaran.KDPOLY,t_pendaftaran.KDRUJUK,
				t_pendaftaran.KDCARABAYAR,t_pendaftaran.SHIFT,
				t_pendaftaran.PASIENBARU,t_pendaftaran.IDXDAFTAR,t_pendaftaran.MINTA_RUJUKAN,
				t_pendaftaran.NO_SKP,t_pendaftaran.NOKARTU
				FROM t_pendaftaran';
	$get_irja = mysql_query($qry_irja) or die(mysql_error());
	$total_row = mysql_num_rows($get_irja);
	?>
	<script type="text/javascript">
		document.getElementById("total").innerHTML = "Total Data : <?php echo currFormat($total_row); ?>";
    </script>
	<?php
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
	$progress = 1;
	$nomor = getNomorBulanan('IRJA');
	while($dat_irja = mysql_fetch_array($get_irja)){
		mysql_query('INSERT INTO t_irja(IRJA_ID,NOMR,TANGGAL_DAFTAR,ST_BARU,UNIT_ID,PEGAWAI_ID,MT_RUJUKAN,JENIS_BAYAR_ID,
					NO_PESERTA,NO_SEP,ASAL_PASIEN_ID,NO_PENDAFTARAN,SHIFT_ID)
					VALUES(
					"' . $dat_irja['IDXDAFTAR'] . '","' . $dat_irja['NOMR'] . '",' . fieldDate($dat_irja['TGLREG']) . ',NULL,"' . $dat_irja['KDPOLY'] . '",
					"' . $dat_irja['KDDOKTER'] . '","' . $dat_irja['MINTA_RUJUKAN'] . '","' . $dat_irja['KDCARABAYAR'] . '","' . $dat_irja['NOKARTU'] . '",
					"' . $dat_irja['NO_SKP'] . '","' . $dat_irja['KDRUJUK'] . '","' . $nomor . '","' . $dat_irja['SHIFT'] . '")') or die(mysql_error());	
			
		$perc_progress = ($progress / $total_row) * 100;
	?>
	<script type="text/javascript">
        document.getElementById("progress").innerHTML = "Progres : <?php echo currFormat($progress) . ' [' .round($perc_progress); ?>%]";
    </script>
	<?php
	$progress++; }
	?>
	<script language="JavaScript" >
		alert("Import Data Selesai.");
        window.location = "index.php?menu=tr";
    </script>
	<?php
}else{
?>
 <script language="JavaScript" >
        window.location = "index.php?menu=tr";
    </script>
<?php } ?>	