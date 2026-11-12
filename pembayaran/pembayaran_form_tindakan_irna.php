<?php 
if(isset($_GET['idx'])){
$irna_id = $_GET['idx'];

$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,m_ruang.NAMA_RUANG,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.JENIS_BAYAR_ID,t_irna.KELAS_RAWAT,t_irna.KELAS_JAMINAN
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
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

$irna_id = $dat_pasien['IRNA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_RUANG'] . ' /Kelas ' . $dat_pasien['KELAS_RAWAT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kelas = $dat_pasien['KELAS_RAWAT'];
$ruang_id = $dat_pasien['RUANG_ID'];
$kelas_jaminan = $dat_pasien['KELAS_JAMINAN'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

if (isset($_POST['irna_id']))
    include('pembayaran/pembayaran_save_tindakan_irna.php');

if (isset($_GET['idk']))
    include('pembayaran/pembayaran_del_add_tindakan_irna.php');

$irna_id = $_GET['idx'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pembayaran/pembayaran_tmp_tindakan_irna.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=kasirformtindakanirna&idx=<?php echo $irna_id; ?>&kelas=<?php echo $kelas; ?>&grp=51','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas; ?>" />
			<input type="hidden" name="kelas_jaminan" value="<?php echo $kelas_jaminan; ?>" />
			<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="index.php?link=<?php echo md5('pembayarandetailbayarrawatinap'); ?>&idx=<?php echo $irna_id; ?>" ><input type="button" value="selesai" class="myButton" /></a></td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>