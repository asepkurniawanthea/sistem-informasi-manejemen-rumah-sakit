<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$pemberian_obat_id = $_POST['pemberian_obat_id'];
		$dokter = $_POST['dokter'];
		$nama_obat = $_POST['nama_obat'];
		$dosis = $_POST['dosis'];
		$aturan_pakai = $_POST['aturan_pakai'];
		$keterangan = $_POST['keterangan'];
		
		if((!empty($dokter) and $dokter > 0) or !empty($nama_obat) or !empty($dosis) or !empty($aturan_pakai) or !empty($keterangan)){
			if(empty($pemberian_obat_id)){
				mysql_query('INSERT INTO t_irna_askep_pemberian_obat(IRNA_ID,DOKTER,PERSEDIAAN_ID,NAMA_OBAT,DOSIS,ATURAN_PAKAI,KETERANGAN,USER_ASKEP)
							VALUES("' . $irna_id . '","' . $dokter . '","","' . $nama_obat . '","' . $dosis . '","' . $aturan_pakai . '",
							"' . $keterangan . '","' . $user_name . '")') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_irna_askep_pemberian_obat SET DOKTER = "' . $dokter . '",PERSEDIAAN_ID = "",NAMA_OBAT = "' . $nama_obat . '",
							DOSIS = "' . $dosis . '",ATURAN_PAKAI = "' . $aturan_pakai . '",KETERANGAN = "' . $keterangan . '",USER_ASKEP = "' . $user_name . '"
							WHERE PEMBERIAN_OBAT_ID = "' . $pemberian_obat_id . '"') or die(mysql_error());	
			}
		}	
		
		$tanggal = '';
		for($i=1;$i<6;$i++){
			if(isset($_POST['tanggal_' . $i])) {
				$tanggal = $tanggal . $_POST['tanggal_' . $i] . '|';
			}else{
				$tanggal = $tanggal . '|';
			}	
		}

		$jam = '';
		for($i=1;$i<21;$i++){
			if(isset($_POST['jam_' . $i])) {
				$jam = $jam . $_POST['jam_' . $i] . '|';
			}else{
				$jam = $jam . '|';
			}	
		}

		$farmasi = '';
		for($i=1;$i<6;$i++){
			if(isset($_POST['farmasi_' . $i])) {
				$farmasi = $farmasi . $_POST['farmasi_' . $i] . '|';
			}else{
				$farmasi = $farmasi . '|';
			}	
		}	
		
		$entry_data = '';
		for($i=1;$i<6;$i++){
			if(isset($_POST['entry_data_' . $i])) {
				$entry_data = $entry_data . $_POST['entry_data_' . $i] . '|';
			}else{
				$entry_data = $entry_data . '|';
			}	
		}	
		
		$perawat = '';
		for($i=1;$i<21;$i++){
			if(isset($_POST['perawat_' . $i])) {
				$perawat = $perawat . $_POST['perawat_' . $i] . '|';
			}else{
				$perawat = $perawat . '|';
			}	
		}	
		
		$harga = '';
		for($i=1;$i<6;$i++){
			if(isset($_POST['harga_' . $i])) {
				$harga = $harga . $_POST['harga_' . $i] . '|';
			}else{
				$harga = $harga . '|';
			}	
		}	
		
		$catatan = $_POST['catatan'];
		
		mysql_query('UPDATE t_irna_askep_pemberian_obat SET TANGGAL = "' . $tanggal . '",JAM = "' . $jam . '",FARMASI = "' . $farmasi . '",
					ENTRY_DATA = "' . $entry_data . '",PERAWAT = "' . $perawat . '",HARGA = "' . $harga . '",CATATAN = "' . $catatan . '",
					USER_ASKEP = "' . $user_name . '" WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
					
		$cn_obat = $_POST['cn_obat'];
		if($cn_obat > 1){
			$c = 1;
			while($c < $cn_obat){
				$id = $_POST['pemberian_obat_id_' . $c];
				$jadwal = '';
				for($d=1;$d<21;$d++){
					if(isset($_POST['jadwal_' . $c . '_' . $d])) {
						$jadwal = $jadwal . $_POST['jadwal_' . $c . '_' . $d] . '|';
					}else{
						$jadwal = $jadwal . '|';
					}	
				}
				
				mysql_query('UPDATE t_irna_askep_pemberian_obat SET JADWAL = "' . $jadwal . '",USER_ASKEP = "' . $user_name . '" 
						WHERE PEMBERIAN_OBAT_ID = "' . $id . '"') or die(mysql_error());	
			$c++; }
		}
?>
<script language="JavaScript" >
	alert('Simpan Data Pemberian Obat Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=ctpo&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>