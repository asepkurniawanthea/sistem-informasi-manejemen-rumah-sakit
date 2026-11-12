<?php 
if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];

$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_PERMINTAAN,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,"" AS TANGGAL_BAYAR,
				"" AS NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				"" AS ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.JENIS_BAYAR_ID
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang.NO_ORDER IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';	
		
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
$nama_pegawai = $dat_pasien['NAMA_PEGAWAI'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

if (isset($_POST['penunjang_id']))
    include('pembayaran/pembayaran_save_penunjang_aps.php');

if (isset($_GET['idk']))
    include('pembayaran/pembayaran_del_aps_add_penunjang.php');

$penunjang_id = $_GET['idx'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Instansi/Dokter</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit . ' /' . $nama_pegawai; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Permintaan</div><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pembayaran/pembayaran_tmp_aps_penunjang.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=kasiraddpemeriksaanpenunjang&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&grp=15','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=605,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			</td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>