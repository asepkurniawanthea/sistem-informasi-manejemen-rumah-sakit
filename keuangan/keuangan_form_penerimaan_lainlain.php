<?php
$penerimaan_id = '';
$tanggal = '';
$jenis_instansi = 'Perorangan';
$nama_instansi = '';
$pic ='';
$telepon = '';
$keterangan = '';
$no_pembayaran = '';

if (isset($_GET['idk'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&id=<?php echo $_GET['id']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&id=<?php echo $_GET['id']; ?>";
		}
    </script>
    <?php
	}
	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM db_simkeu.r_penerimaan_lainlain_tarif 
		WHERE PENERIMAAN_LAINLAIN_TARIF_ID = "' . $_GET['idk'] . '"');
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&id=<?php echo $_GET['id']; ?>";
    </script>
    <?php
	}
}

if(isset($_POST['penerimaan_id'])){
	$tanggal = $_POST['tanggal'];
	if($tanggal == '') $tanggal = date('d/m/Y');
	if($_POST['penerimaan_id'] == ''){
		$nomor = getNomorBulanan('PENERIMAANLAINLAIN');
		mysql_query('INSERT INTO db_simkeu.r_penerimaan_lainlain(
			TANGGAL,JENIS_INSTANSI,NAMA_INSTANSI,PIC,TELEPON,
			KETERANGAN,NO_TARIF,USER_UNIT,UNIT) VALUES(
			STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
			"' . $_POST['jenis_instansi'] . '","' . $_POST['nama_instansi'] . '",
			"' . $_POST['pic'] . '","' . $_POST['telepon'] . '",
			"' . $_POST['keterangan'] . '","' . $nomor . '","' . $user_name . '",
			"' . $_SESSION['SES_SIMRS_MODUL_ID'] . '")') or die(mysql_error());
		$sql_id = 'SELECT PENERIMAAN_LAINLAIN_ID
				FROM db_simkeu.r_penerimaan_lainlain
				ORDER BY PENERIMAAN_LAINLAIN_ID DESC LIMIT 1';
		$get_id = mysql_query($sql_id) or die(mysql_error());		
		$dat_id = mysql_fetch_assoc($get_id);
		$penerimaan_id = $dat_id['PENERIMAAN_LAINLAIN_ID'];
		echo '<script language="JavaScript" >';
		//echo 'alert("Data Pembayaran Telah Disimpan.");';
		echo 'window.location = "index.php?link=78cbd64fe5af657357bebe8e68cf2d38&id=' . $penerimaan_id . '"';
		echo '</script>';
	}else{

		if(currentModul() != 'kasir'){
			mysql_query('UPDATE db_simkeu.r_penerimaan_lainlain
					SET TANGGAL = STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
					JENIS_INSTANSI = "' . $_POST['jenis_instansi'] . '",
					NAMA_INSTANSI = "' . $_POST['nama_instansi'] . '",
					PIC = "' . $_POST['pic'] . '",
					TELEPON = "' . $_POST['telepon'] . '",
					KETERANGAN = "' . $_POST['keterangan'] . '",
					USER_UNIT = "' . $user_name . '"
					WHERE PENERIMAAN_LAINLAIN_ID = "' . $_POST['penerimaan_id'] . '"') or die(mysql_error());
		}else{
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_POST['pl_ch']);

			mysql_query('UPDATE db_simkeu.r_penerimaan_lainlain
					SET NO_PEMBAYARAN = "' . $no_bayar . '",
					REGISTER = "' . $user_name . '",
					KODE_CASH = "' . $_POST['pl_ch'] . '",
					PERC_POTONGAN = "' . $potongan . '",
					KODE_REKENING = "' . $_POST['pl_rk'] . '",
					TANGGAL = NOW() 
					WHERE PENERIMAAN_LAINLAIN_ID = "' . $_POST['penerimaan_id'] . '"') or die(mysql_error());
		}	
		echo '<script language="JavaScript" >';
		echo 'alert("Data Pembayaran Telah Disimpan.");';
		echo '</script>';			
	}
}

if(isset($_GET['id'])){
	$penerimaan_id = $_GET['id'];	
	$sql_penerimaan = 'SELECT PENERIMAAN_LAINLAIN_ID,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,
					JENIS_INSTANSI,NAMA_INSTANSI,PIC,
					TELEPON,KETERANGAN,NO_TARIF,REGISTER,
					NO_PEMBAYARAN
					FROM db_simkeu.r_penerimaan_lainlain
					WHERE PENERIMAAN_LAINLAIN_ID = "' . $penerimaan_id . '"';
	$get_penerimaan = mysql_query($sql_penerimaan) or die(mysql_error());
	$dat_penerimaan = mysql_fetch_assoc($get_penerimaan);
	$tanggal = $dat_penerimaan['TANGGAL'];
	$jenis_instansi = $dat_penerimaan['JENIS_INSTANSI'];
	$nama_instansi = $dat_penerimaan['NAMA_INSTANSI'];
	$pic =$dat_penerimaan['PIC'];
	$telepon = $dat_penerimaan['TELEPON'];
	$keterangan = $dat_penerimaan['KETERANGAN'];
	$no_pembayaran = $dat_penerimaan['NO_PEMBAYARAN'];
}

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="search" id="pnm" method="post" >
    <input type="hidden" name="penerimaan_id" id="penerimaan_id" value="<?php echo $penerimaan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table class="tableform" border="0" width="80%">
		<tr><td>Tanggal</td>
        <td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" size="15" class="text_dt" readonly />
            <!--<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>--></td>
		<td>PIC/ Nama</td>
        <td><input type="text" name="pic" id="pic" value="<?php echo $pic; ?>" size="35" class="text_dt" /></td></tr>
		<tr><td>Jenis</td>
            <td><!--<input type="text" name="jenis_instansi" id="jenis_instansi" value="<?php echo $jenis_instansi; ?>" size="35" class="text_dt" />-->
				<input type="radio" name="jenis_instansi" value="Perorangan" <?php if($jenis_instansi == 'Perorangan') echo 'checked'; ?> />&nbsp;Perorangan
				<input type="radio" name="jenis_instansi" value="Lembaga" <?php if($jenis_instansi == 'Lembaga') echo 'checked'; ?> />&nbsp;Lembaga
			</td>
        <td>Telepon</td>
        <td><input type="text" name="telepon" id="telepon" value="<?php echo $telepon; ?>" size="35" class="text_dt" /></td>
		</tr>
		<tr><td valign="top">Nama Instansi</td>
            <td valign="top"><input type="text" name="nama_instansi" id="nama_instansi" value="<?php echo $nama_instansi; ?>" size="35" class="text_dt" /></td>
        <td valign="top">Keterangan</td>
        <td><textarea name="keterangan" id="keterangan" class="text_dt3"><?php echo $keterangan; ?></textarea></td>
		</tr>
    </table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="30">No</th>
			<th>Nama Tarif</th>
			<th>Group</th>
			<th>Jumlah</th>
			<th>Satuan</th>
			<th>Harga</th>
			<?php if(currentModul() != 'kasir'){ ?>
			<th width="70">Action</th>
			<?php } ?>
		</tr>
        <?php
        if(isset($_GET['id'])){
			$sql_penerimaan_detail = 'SELECT pnm.PENERIMAAN_LAINLAIN_TARIF_ID,
				pnm.PENERIMAAN_LAINLAIN_ID,pnm.TARIF_ID,pnm.KUANTITI,
				mtr.NAMA_TARIF,pnm.KUANTITI * mtr.TARIF_NON_KELAS AS HARGA,mtrg.NAMA_TARIF_GROUP,
				mtr.SATUAN
				FROM db_simkeu.r_penerimaan_lainlain_tarif pnm
				INNER JOIN db_simrs.m_tarif mtr
				ON (pnm.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg
				ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE pnm.PENERIMAAN_LAINLAIN_ID = "' . $penerimaan_id . '"';
			$get_penerimaan_detail = mysql_query($sql_penerimaan_detail) or die(mysql_error());
			$no = 1;
			while ($dat_penerimaan_detail = mysql_fetch_array($get_penerimaan_detail)) {
			?>	
            <tr>
            <td align="center"><?php echo $no; ?></td>
			<td><?php echo $dat_penerimaan_detail['NAMA_TARIF']; ?></td>
			<td><?php echo $dat_penerimaan_detail['NAMA_TARIF_GROUP']; ?></td>
			<td align="right"><?php echo $dat_penerimaan_detail['KUANTITI']; ?></td>
			<td><?php echo $dat_penerimaan_detail['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat_penerimaan_detail['HARGA']); ?></td>
            <?php if(currentModul() != 'kasir' and $no_pembayaran == ''){ ?>
            <td align="center"><a href="index.php?link=<?php echo $_REQUEST['link'] . '&id=' . $penerimaan_id . '&idk=' . $dat_penerimaan_detail['PENERIMAAN_LAINLAIN_TARIF_ID'] . '&nmk=' . $dat_penerimaan_detail['NAMA_TARIF']; ?>">hapus</a></td>
			<?php } ?>
			</tr>
        <?php $no++; } 
		} ?>
    </table>
	<table border="0" width="100%">
		<?php if(currentModul() != 'kasir'){ ?>
		<tr><td align="right">
		<?php if(isset($_GET['id'])){ 
			$grp_tarif = 'x';
			if($_SESSION['SES_SIMRS_MODUL_ID'] == '111') $grp_tarif = '106';
			if($_SESSION['SES_SIMRS_MODUL_ID'] == '7') $grp_tarif = '105';
			if($_SESSION['SES_SIMRS_MODUL_ID'] == '110') $grp_tarif = '104';
		?>
		<a href="#" onclick="window.open('index.php?popup=keuanganformtarif&idx=<?php echo $penerimaan_id; ?>&grp=<?php echo $grp_tarif; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" >
		<input type="button" value="tambah tarif" class="myButton1" /></a>
		<?php } ?>
		</td></tr>
		<?php } ?>
		<tr><td align="right">
			<?php if(currentModul() != 'kasir'){
				if($no_pembayaran == ''){
					$vl_simpan = 'simpan'; 
					if(!isset($_GET['id'])) $vl_simpan = 'tambah tarif'; ?>
						<input type="button" value="<?php echo $vl_simpan; ?>" name="simpan" class="myButton1" onclick="simpan_submit();" />
			<?php } 
				}else{ 
					if($no_pembayaran == ''){
						echo '<select name="pl_ch" id="pl_ch" class="text_dt" style="width:60px;" >';
						foreach ($arr_cash as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;';

						echo '<select name="pl_rk" id="pl_rk" class="text_dt" style="width:60px;" >';
						echo '<option value=""> - </option>';
						foreach ($arr_rekening as $row) {
							echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
						}
						echo '</select>&nbsp;&nbsp;'; ?>
						<input type="button" value="bayar" name="simpan" class="myButton1" onclick="simpan_submit();" />
					<?php }else{ ?>
						<input type="button" value="print" name="print" class="myButton1" onclick="print_kwitansi();" />&nbsp;
						<input type="button" value="batal" name="batal" class="myButton1" onclick="batal_bayar();" />&nbsp;
						<select name="batal_jns" id="batal_jns" class="text_dt" >
						<option value=""></option>
						<?php foreach(getJenisBatalBayar() as $key=>$val){ ?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php } ?>
						</select>&nbsp;
					<?php }	
				}
			?>	
		<a href="index.php?link=90e0818112546f5040a1b69148985bc0"><input type="button" value="selesai" class="myButton1" /></a></td></tr>
	</table>
</form>	
</div>	
<script language="JavaScript" >
	function print_kwitansi(){
		window.open('http://localhost/nsimrs_print/print_pembayaran_lain_lain.php?idx=<?php echo $penerimaan_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	}

	function simpan_submit(){
		<?php if(currentModul() == 'kasir'){ ?>
			var kode_cash = document.getElementById("pl_ch").value;
 			var kode_rekening = document.getElementById("pl_rk").value;
 			if(confirm("Bayar : " + kode_cash + " \n" + "Rekening : " + kode_rekening)){
 				document.getElementById('pnm').submit();
 			}		
		<?php }else{ ?>	
			document.getElementById('pnm').submit();
		<? } ?> 
	}

	function batal_bayar(){
		var jns_batal = document.getElementById("batal_jns").value;
		if(jns_batal == ''){
			alert('Pilih Jenis Batal.');
		}else{	
			if(confirm('Dibatalkan ?')){
				MyAjaxRequest('bayar','index.php?ajaxrequest=batalbayarlainlain&idx=<?php echo $penerimaan_id; ?>&st=' + jns_batal);	
				alert('Simpan Data Pembatalan Berhasil.');
				window.location = '<?php echo currentURl(); ?>';
			}	
	}	
}
</script>
</div>