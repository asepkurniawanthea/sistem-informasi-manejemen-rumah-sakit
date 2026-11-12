<?php 
if(isset($_GET['idx'])){
$idx = $_GET['idx'];

$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_irja.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI,t_irja.UNIT_ID,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,t_irja.JENIS_BAYAR_ID,t_irja.UNIT_ID,t_irja.PEGAWAI_ID,
				t_irja.IRJA_ID,DATE_FORMAT(NOW(),"%d/%m/%Y") AS TANGGAL_SKR
				FROM t_irja
				INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID) 
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$rawat_id = $dat_pasien['IRJA_ID'];
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
$tgl_sekarang = $dat_pasien['TANGGAL_SKR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

$unit_id = $dat_pasien['UNIT_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];

$sql_penunjang = 'SELECT NAMA_UNIT FROM m_unit WHERE UNIT_ID = "' . $_SESSION['unit_id_' . $rawat_id] . '"';
$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
$dat_penunjang = mysql_fetch_assoc($get_penunjang);
$nama_penunjang_tujuan = $dat_penunjang['NAMA_UNIT'];

$sql_jaminan = 'SELECT NAMA_JAMINAN FROM m_jaminan WHERE JAMINAN_ID = "' . $_SESSION['jenis_bayar_id_' . $rawat_id] . '"';
$get_jaminan = mysql_query($sql_jaminan) or die(mysql_error());
$dat_jaminan = mysql_fetch_assoc($get_jaminan);
$nama_jaminan_tujuan = $dat_jaminan['NAMA_JAMINAN'];

if (isset($_POST['penunjang_id']))
    include('pendaftaran/pendaftaran_save_add_penunjang.php');

if (isset($_GET['idk']))
    include('pendaftaran/pendaftaran_del_add_penunjang.php');
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Penunjang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_penunjang_tujuan; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_jaminan_tujuan; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
	<input type="hidden" name="rawat_id" id="rawat_id" value="<?php echo $rawat_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pendaftaran/pendaftaran_tmp_pemeriksaan_penunjang.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<?php $grp_tarif = '';
			if($_SESSION['unit_id_' . $rawat_id] == '17') $grp_tarif = '31';
			if($_SESSION['unit_id_' . $rawat_id] == '45') $grp_tarif = '15';
			if($_SESSION['unit_id_' . $rawat_id] == '18') $grp_tarif = '06';	
			if($_SESSION['unit_id_' . $rawat_id] == '31') $grp_tarif = '41';
			if($_SESSION['unit_id_' . $rawat_id] == '40') $grp_tarif = '45';
			if($_SESSION['unit_id_' . $rawat_id] == '41') $grp_tarif = '39';	
			if($_SESSION['unit_id_' . $rawat_id] == '42') $grp_tarif = '44';
			if($_SESSION['unit_id_' . $rawat_id] == '47') $grp_tarif = '46';	?>
			<a href="#" onclick="window.open('index.php?popup=pendaftaranaddpemeriksaanpenunjang&idx=<?php echo $penunjang_id; ?>&grp=<?php echo $grp_tarif; ?>&unit_id=<?php echo $_SESSION['unit_id_' . $rawat_id]; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="nomr" value="<?php echo $nomr; ?>" />
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			</td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>