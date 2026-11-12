<?php
if(isset($_GET['idx'])){
$peminjaman_buku_id = $_GET['idx']; 
$nomr = '';
$nama_peminjam = '';
$nik = '';
$no_telepon = '';
$instansi = '';
$tgl_pinjam = '';
$ket_pinjam = '';

$tgl_kembali = '';
$ket_kembali = '';

$sql = 'SELECT * FROM t_rm_peminjaman_buku';
$get = mysql_query($sql) or die(mysql_error());	
$dat = mysql_fetch_assoc($get);

$nomr = $dat['NOMR'];
$nama_peminjam = $dat['NAMA_PEMINJAM'];
$nik = $dat['NIK'];
$no_telepon = $dat['NO_TELEPON'];
$instansi = $dat['INSTANSI'];
$tgl_pinjam = $dat['TGL_PINJAM'];
$ket_pinjam = $dat['KET_PINJAM'];

if (isset($_POST['peminjaman_buku_id']))
    include('rekammedik/rm_save_pengembalian.php');
?>
<form name="peminjamanbuku" method="post" action="<?php echo currentUrl(); ?>" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <input type="hidden" name="peminjaman_buku_id" id="peminjaman_buku_id" value="<?php echo $peminjaman_buku_id; ?>" />
    <table class="tableform" width="80%" border="0">
		<tr><td>Nomor MR</td><td><?php echo formatNomr($nomr); ?></td></tr>
        <tr><td>Nama Peminjam</td><td><?php echo $nama_peminjam; ?></td></tr>
        <tr><td>NIK</td><td><?php echo $nik; ?></td></tr>
        <tr><td>Nomor Telepon</td><td><?php echo $no_telepon; ?></td></tr>
        <tr><td>Instansi</td><td><?php echo $instansi; ?></td></tr>
        <tr><td>Tanggal</td><td><?php echo $tgl_pinjam; ?></td></tr>
        <tr><td>Keterangan Peminjaman</td><td><?php echo $ket_pinjam; ?></td></tr>
		<tr><td>Tanggal Pengembalian</td><td><input type="text" name="tgl_kembali" id="tgl_pinjam" value="<?php echo $tgl_kembali; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar4')"/></td></tr>
        <tr><td>Keterangan Pengembalian</td><td><textarea name="ket_kembali" id="ket_kembali" style="width:328px;" rows="5" class="text_dt2" ><?php echo $ket_kembali; ?></textarea></td></tr>
		<tr><td colspan="2" align="right">
		<a href="index.php?link=<?php echo md5('rmpeminjaman'); ?>" /><input type="button" value="batal" class="myButton1" /></a>
		<input type="submit" value="simpan" class="myButton1" /></td></tr>
		</table>
</div>	
</form>	
<?php } ?>