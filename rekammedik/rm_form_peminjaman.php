<?php
$nomr = '';
$nama_peminjam = '';
$nik = '';
$no_telepon = '';
$instansi = '';
$tgl_pinjam = '';
$ket_pinjam = '';

if (isset($_POST['peminjaman_buku_id']))
    include('rekammedik/rm_save_peminjaman.php');
?>
<form name="peminjamanbuku" method="post" action="<?php echo currentUrl(); ?>" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <input type="hidden" name="peminjaman_buku_id" id="peminjaman_buku_id" value="<?php echo $peminjaman_buku_id; ?>" />
    <table class="tableform" width="80%" border="0">
		<tr><td>Nomor MR</td><td><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" size="40" class="text_dt" /></td></tr>
        <tr><td>Nama Peminjam</td><td><input type="text" name="nama_peminjam" id="nama_peminjam" value="<?php echo $nama_peminjam; ?>" size="40" class="text_dt" /></td></tr>
        <tr><td>NIK</td><td><input type="text" name="nik" id="nik" value="<?php echo $nik; ?>" size="20" class="text_dt" /></td></tr>
        <tr><td>Nomor Telepon</td><td><input type="text" name="no_telepon" id="no_telepon" value="<?php echo $no_telepon; ?>" size="20" class="text_dt" /></td></tr>
        <tr><td>Instansi</td><td><input type="text" name="instansi" id="instansi" value="<?php echo $instansi; ?>" size="30" class="text_dt" /></td></tr>
        <tr><td>Tanggal Peminjaman</td><td><input type="text" name="tgl_pinjam" id="tgl_pinjam" value="<?php echo $tgl_pinjam; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar4')"/></td></tr>
        <tr><td>Keterangan Peminjaman</td><td><textarea name="ket_pinjam" id="ket_pinjam" style="width:328px;" rows="5" class="text_dt2" ><?php echo $ket_pinjam; ?></textarea></td></tr>
		<tr><td colspan="2" align="right">
		<a href="index.php?link=<?php echo md5('rmpeminjaman'); ?>" /><input type="button" value="batal" class="myButton1" /></a>
		<input type="submit" value="simpan" class="myButton1" /></td></tr>
		</table>
</div>	
</form>	