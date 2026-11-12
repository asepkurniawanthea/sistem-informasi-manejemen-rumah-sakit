<?php 
if(isset($_GET['idx'])){
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, 
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,m_ruang.NAMA_RUANG,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.UNIT_ID,
				t_irna.RUANG_ID,
				CASE WHEN t_irna.IRNA_ID IS NOT NULL THEN jmn_1.NAMA_JAMINAN
					ELSE jmn_2.NAMA_JAMINAN END AS NAMA_JAMINAN,
				CASE WHEN t_irna.IRNA_ID IS NOT NULL THEN jmn_1.JAMINAN_ID
					ELSE jmn_2.JAMINAN_ID END AS JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_jaminan jmn_2 ON (t_irja.JENIS_BAYAR_ID = jmn_2.JAMINAN_ID)
				LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_irna.ST_BATAL IS NULL
				AND t_irna.PASIEN_MASUK IS NOT NULL)
				LEFT JOIN m_jaminan jmn_1 ON (t_irna.JENIS_BAYAR_ID = jmn_1.JAMINAN_ID)
				LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

if(isset($_GET['dl'])){
	mysql_query('UPDATE t_deposit SET ST_BATAL = "1",
		USER_KASIR = "' . currentUser() . '"
		WHERE DEPOSIT_ID = "' . $_GET['dl'] . '"') or die(mysql_error());
	echo '<script language="JavaScript" > ';
	echo 'alert("Data Deposit Berhasil Dibatalkan."); ';
    echo 'window.location = "index.php?link=6c19828ebd5fe4845aef9c025927fed5&idx=' . $_GET['idx'] . '"; ';
	echo '</script>';		
}

if(isset($_POST['simpan'])){
	$no_bayar = getNomorHarian('Kasir');
	$potongan = getCashPotongan($_POST['kode_cash']);
	mysql_query('INSERT INTO t_deposit (RAWAT_ID,TGL_DEPOSIT,NO_PEMBAYARAN,JUMLAH_DEPOSIT,USER_KASIR,
			SHIFT,KETERANGAN,KODE_CASH,PERC_POTONGAN,KODE_REKENING)
			VALUES ("' . $idx . '",NOW(),"' . $no_bayar . '","' . $_POST['deposit'] . '","' . currentUser() . '",
			"' . $_SESSION['SES_SIMRS_SHIFT'] . '","' . $_POST['keterangan'] . '","' . $_POST['kode_cash'] . '",
			"' . $potongan . '","' . $_POST['kode_rekening'] . '")') or die(mysql_error());
	
	echo '<script language="JavaScript" > ';
	echo 'alert("Data Deposit Berhasil Disimpan."); ';
    echo 'window.location = "' . currentUrl() . '"; ';
	echo '</script>';	
}

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableData" border="1">
	<tr>
		<th width="50px">No</th>
		<th width="150px">Tanggal</th>
		<th width="150px">Kwitansi</th>
		<th width="100px">Pembayaran</th>
		<th width="100px">Rekening</th>
		<th width="150px">Jumlah</th>
		<th>Keterangan</th>
		<th width="150px">Register</th>
		<th width="100px">Option</th>
	</tr>
	<?php
		$sql_deposit = 'SELECT DEPOSIT_ID,RAWAT_ID,DATE_FORMAT(TGL_DEPOSIT,"%d/%m/%Y %H:%i:%s") AS TGL_DEPOSIT,
				NO_PEMBAYARAN,JUMLAH_DEPOSIT,USER_KASIR,SHIFT,ST_BATAL,KETERANGAN,KODE_CASH,PERC_POTONGAN,KODE_REKENING
				FROM t_deposit
				WHERE RAWAT_ID = "' . $idx . '"
				ORDER BY TGL_DEPOSIT';
		$get_deposit = mysql_query($sql_deposit) or die(mysql_error());
		$no = 1;
		$total = 0;
		while($dat_deposit = mysql_fetch_array($get_deposit)){ ?>
			<tr>
				<td align="center"><?php echo $no; ?></td>
				<td align="center"><?php echo $dat_deposit['TGL_DEPOSIT']; ?></td>
				<td align="center"><?php echo $dat_deposit['NO_PEMBAYARAN']; ?></td>
				<td align="center"><?php echo $dat_deposit['KODE_CASH']; ?></td>
				<td align="center"><?php echo $dat_deposit['KODE_REKENING']; ?></td>
				<td align="right"><?php echo currFormat($dat_deposit['JUMLAH_DEPOSIT']); ?></td>
				<td><?php echo $dat_deposit['KETERANGAN']; ?></td>
				<td><?php echo $dat_deposit['USER_KASIR']; ?></td>
				<td align="center"><?php if($dat_deposit['ST_BATAL'] == '') { 
						echo '<input type="button" class="myButton" value="batal" onclick="batal(' . $dat_deposit['DEPOSIT_ID'] . ',' . $dat_deposit['NO_PEMBAYARAN'] . ')" />'; 
					}else{
						echo 'Batal';
					}?></td>
			</tr>
		<?php 
			if($dat_deposit['ST_BATAL'] == '') $total += $dat_deposit['JUMLAH_DEPOSIT']; 
			$no++; 
		} ?>
		<tr>
			<td colspan="5" align="center">Total</td>
			<td align="right" ><?php echo currFormat($total); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">
			<?php if($total > 0){ ?>
			<input type="button" class="myButton" value="print" onclick="print();" />
			<?php } ?></td>
		</tr>
</table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tambah Deposit</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="deposit"
	value="0" class="text_dt" style="text-align:right;"/></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Keterangan</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><textarea name="keterangan"
	class="text_dt2" ></textarea></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br><br><br><br><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<?php
	echo '<select id="kode_cash" name="kode_cash" class="text_dt" style="width:60px;" >';
	foreach ($arr_cash as $row) {
		echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
	}
	echo '</select>&nbsp;';

	echo '<select id="kode_rekening" name="kode_rekening" class="text_dt" style="width:60px;" >';
	echo '<option value=""> - </option>';
	foreach ($arr_rekening as $row) {
		echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
	}
	echo '</select>&nbsp;&nbsp;'; ?>
	<input type="submit" name="simpan"
	value="simpan" class="myButton" />
	<a href="index.php?link=68245cddee7fd4516b2747e590f50caf">
	<input type="button" value="selesai" class="myButton" /></a></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>	
</form>
</div>
</div>
<script language="JavaScript" >
function batal(id,no){
	if(confirm('Batalkan ' + no + '?')){
		window.location = "index.php?link=6c19828ebd5fe4845aef9c025927fed5&idx=<?php echo $_GET['idx']; ?>&dl=" + id;
	}
}

function print(){
	window.open('http://localhost/nsimrs_print/print_deposit.php?idx=<?php echo $idx; ?>&userkasir=<?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');		
}	
</script>
<?php } ?>