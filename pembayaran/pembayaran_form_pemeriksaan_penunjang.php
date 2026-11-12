<?php 
if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];

$kasir = '';
if(isset($_GET['kasir'])) $kasir = $_GET['kasir'];

$unit_id = '';
$ruang_id = '';
$kelas_rawat = '';

if($ord == 'irj'){
	$qry_pasien = 'SELECT t_irja.IRJA_ID AS PENUNJANG_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_irja.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI,t_irja.UNIT_ID,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,t_irja.JENIS_BAYAR_ID,t_irja.UNIT_ID,t_irja.PEGAWAI_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'irn'){
$qry_pasien = 'SELECT t_irna.IRNA_ID AS PENUNJANG_ID,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_irna.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," /Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI,t_irna.RUANG_ID,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,t_irna.JENIS_BAYAR_ID,t_irna.KELAS_RAWAT,
				t_irna.PEGAWAI_ID
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'aps'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NIK AS NOMR,DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.JENIS_BAYAR_ID
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';	
}		
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

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

if($ord == 'irj')$unit_id = $dat_pasien['UNIT_ID'];
if($ord == 'irn'){ 
	$ruang_id = $dat_pasien['RUANG_ID'];
	$kelas_rawat = $dat_pasien['KELAS_RAWAT'];
	$unit_id = $dat_pasien['RUANG_ID'];
}
$pegawai_id = $dat_pasien['PEGAWAI_ID'];

if (isset($_POST['penunjang_id']))
    include('pembayaran/pembayaran_save_penunjang.php');

if (isset($_GET['idk']))
    include('pembayaran/pembayaran_del_add_penunjang.php');

$penunjang_id = $_GET['idx'];
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
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pembayaran/pembayaran_tmp_penunjang.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=kasiraddpemeriksaanpenunjang&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&grp=15&unit_id=<?php echo $unit_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="nomr" value="<?php echo $nomr; ?>" />
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
			<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas_rawat; ?>" />
			<input type="hidden" name="ord" value="<?php echo $ord; ?>" />
			<input type="hidden" name="kasir" value="<?php echo $kasir; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php if($ord == 'irj'){ 
			if($kasir == 'kusta'){ ?>
			<a href="index.php?link=<?php echo md5('pembayarandetailbayarkusta'); ?>&ord=<?php echo $ord; ?>&idx=<?php echo $penunjang_id; ?>&kasir=<?php echo $kasir; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			<?php }else if($kasir == 'umum'){ ?>
			<a href="index.php?link=<?php echo md5('pembayarandetailbayarpoliklinik'); ?>&ord=<?php echo $ord; ?>&idx=<?php echo $penunjang_id; ?>&kasir=<?php echo $kasir; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			<?php }else if($kasir == 'igd'){ ?>
			<a href="index.php?link=<?php echo md5('pembayarandetailbayarigd'); ?>&ord=<?php echo $ord; ?>&idx=<?php echo $penunjang_id; ?>&kasir=<?php echo $kasir; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			<?php } }else if($ord == 'irn'){ ?>
			<a href="index.php?link=<?php echo md5('pembayarandetailbayarrawatinap'); ?>&ord=<?php echo $ord; ?>&idx=<?php echo $penunjang_id; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			<?php } ?>
			</td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>