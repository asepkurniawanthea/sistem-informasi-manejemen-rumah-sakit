<?php 
if(isset($_GET['idx']) and isset($_GET['un']) and isset($_GET['pu']) and isset($_GET['no'])){
$idx = $_GET['idx'];
$unit_id = '';
$un = $_GET['un'];
$pu = $_GET['pu'];
$se = $_GET['se'];
$tg = $_GET['tg'];
$by = $_GET['by'];
$ps = $_GET['ps'];
$no = $_GET['no'];

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

$unit_id = $dat_pasien['UNIT_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];

if (isset($_POST['penunjang_id']))
    include('pendaftaran/pendaftaran_save_add_penunjang_edit.php');

if (isset($_GET['idk']))
    include('pendaftaran/pendaftaran_del_add_penunjang_edit.php');

$penunjang_id = $_GET['idx'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik</div>
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
        <?php include('pendaftaran/pendaftaran_tmp_pemeriksaan_penunjang_edit.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=pendaftaranaddpemeriksaanpenunjangedit&idx=<?php echo $penunjang_id; ?>&grp=15&unit_id=<?php echo $unit_id; ?>&no=<?php echo $no; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="nomr" value="<?php echo $nomr; ?>" />
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
			<input type="hidden" name="un" value="<?php echo $un; ?>" />
			<input type="hidden" name="pu" value="<?php echo $pu; ?>" />
			<input type="hidden" name="se" value="<?php echo $se; ?>" />
			<input type="hidden" name="tg" value="<?php echo $tg; ?>" />
			<input type="hidden" name="by" value="<?php echo $by; ?>" />
			<input type="hidden" name="ps" value="<?php echo $ps; ?>" />
			<input type="hidden" name="no" value="<?php echo $no; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="index.php?link=<?php echo md5('pendaftaranformeditdaftarpenunjang'); ?>&idx=<?php echo $penunjang_id; ?>&un=<?php echo $un; ?>&pu=<?php echo $pu; ?>&se=<?php echo $se; ?>&tg=<?php echo $tg; ?>&by=<?php echo $by; ?>&ps=<?php echo $ps; ?>&no=<?php echo $no; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			</td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>