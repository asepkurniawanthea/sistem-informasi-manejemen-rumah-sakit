<?php
$peminjaman_buku_id = '';
$nomr = '';
$st_pegawai = '';
$pegawai_id = '';
$nama_peminjam = '';
$nik = '';
$no_telepon = '';
$instansi = '';
$ket_peminjam = '';
$tgl_pinjam = '';
$ket_pinjam = '';
$tgl_kembali = '';
$ket_kembali = '';

if (isset($_GET['idxp'])) {
    $peminjaman_buku_id = $_GET['idxp'];
    $sql_pinjam = 'SELECT t_rm_peminjaman_buku.PEMINJAMAN_BUKU_ID,t_rm_peminjaman_buku.NOMR,t_rm_peminjaman_buku.ST_PEGAWAI,
					t_rm_peminjaman_buku.PEGAWAI_ID,t_rm_peminjaman_buku.NAMA_PEMINJAM,t_rm_peminjaman_buku.NIK,
					t_rm_peminjaman_buku.NO_TELEPON,t_rm_peminjaman_buku.INSTANSI,t_rm_peminjaman_buku.KET_PEMINJAM,
					DATE_FORMAT(t_rm_peminjaman_buku.TGL_PINJAM,"%d-%m-%Y %H:%i:%s") AS TGL_PINJAM,
					t_rm_peminjaman_buku.KET_PINJAM,DATE_FORMAT(t_rm_peminjaman_buku.TGL_KEMBALI,"%d-%m-%Y %H:%i:%s") AS TGL_KEMBALI,
					t_rm_peminjaman_buku.KET_KEMBALI,m_pegawai.NAMA_PEGAWAI
					FROM t_rm_peminjaman_buku
					LEFT JOIN m_pegawai ON (t_rm_peminjaman_buku.PEGAWAI_ID = m_pegawai.PEGAWAI_ID) 
					WHERE PEMINJAMAN_BUKU_ID = "' . $peminjaman_buku_id . '"';
    $get_pinjam = mysql_query($sql_pinjam);
    $dat_pinjam = mysql_fetch_assoc($get_pinjam);
    $nomr = $dat_pinjam['NOMR'];
    $st_pegawai = $dat_pinjam['ST_PEGAWAI'];
    $pegawai_id = $dat_pinjam['NAMA_PEGAWAI'];
    $nama_peminjam = $dat_pinjam['NAMA_PEMINJAM'];
    $nik = $dat_pinjam['NIK'];
    $no_telepon = $dat_pinjam['NO_TELEPON'];
    $instansi = $dat_pinjam['INSTANSI'];
    $ket_peminjam = $dat_pinjam['KET_PEMINJAM'];
    $tgl_pinjam = $dat_pinjam['TGL_PINJAM'];
    $ket_pinjam = $dat_pinjam['KET_PINJAM'];
    $tgl_kembali = $dat_pinjam['TGL_KEMBALI'];
    $ket_kembali = $dat_pinjam['KET_KEMBALI'];
}
?>
<div style=" height:auto; padding:15px; ">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
    <div style=" width:20px; float:left; ">:</div>
    <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMR($nomr); ?></div><br><br>

    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Peminjam (Pegawai)</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $pegawai_id; ?></div><br><br>
	 
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Bukan Pegawai</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if ($st_pegawai == '1') echo 'Ya'; ?></div><br><br>	
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Peminjam</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_peminjam; ?></div><br><br>	
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nik; ?></div><br><br>
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Telepon</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $no_telepon; ?></div><br><br>	
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $instansi; ?></div><br><br>
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Ket. Peminjam</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $ket_peminjam; ?></div><br><br>	
    
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Peminjaman</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_pinjam; ?></div><br><br>
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Ket. Peminjaman</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $ket_pinjam; ?></div><br><br>
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Pengembalian</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_kembali; ?></div><br><br>
	
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Ket. Pengembalian</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $ket_kembali; ?></div><br><br>
</div>
    <div align="right" class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">	
	<a href="index.php?link=<?php echo md5('rmpeminjaman'); ?>&searchkey=<?php echo $nomr; ?>" /><input type="button" value="Ok" class="myButton" />
</div>
</table>

</div>