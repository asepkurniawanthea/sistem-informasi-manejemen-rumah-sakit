<?php 
if(isset($_GET['idx']) and isset($_GET['no'])){
$idx = $_GET['idx'];
$penunjang_id = $_GET['idx'];
$no = $_GET['no'];
$unit_id = '';

$un = '';
$in = '';
$do = '';
$al = '';
$te = '';
$ta = '';
$di = '';

if (isset($_GET['un'])) $un = $_GET['un'];
if (isset($_GET['in'])) $in = $_GET['in'];
if (isset($_GET['do'])) $do = $_GET['do'];
if (isset($_GET['al'])) $al = $_GET['al'];
if (isset($_GET['te'])) $te = $_GET['te'];
if (isset($_GET['ta'])) $ta = $_GET['ta'];	
if (isset($_GET['di'])) $di = $_GET['di'];	

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
$asal_pasien = 'APS';
$jaminan = 'Umum';

if (isset($_POST['penunjang_id']))
    include('pendaftaran/pendaftaran_save_add_aps_edit.php');

if (isset($_GET['idk']))
    include('pendaftaran/pendaftaran_del_add_aps_edit.php');
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Id APS</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(strlen($nomr) > 6) { echo $nomr; }else{ echo formatNomr($nomr); } ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($nama_pasien==''){
				echo "-"; 
			} else {			
				echo $nama_pasien;
			}
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_lahir; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($tgl_lahir==''){
				echo "-"; 
			} else {			
				echo getUmurDaftar($tgl_lahir,$tgl_daftar);
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Umur</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($alamat==''){
				echo "-"; 
			} else {			
				echo $alamat;
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php 
			if ($nik==''){
				echo "-"; 
			} else {			
				echo $nik;
			}
			 
		?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Pasien</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
   	<!------------------------------------------------------------------------------------->
    </div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pendaftaran/pendaftaran_tmp_pemeriksaan_aps_edit.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=pendaftaranaddpemeriksaanapsedit&idx=<?php echo $penunjang_id; ?>&grp=15&unit_id=<?php echo $unit_id; ?>&no=<?php echo $no; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="un" value="<?php echo $un; ?>" />
			<input type="hidden" name="in" value="<?php echo $in; ?>" />
			<input type="hidden" name="do" value="<?php echo $do; ?>" />
			<input type="hidden" name="al" value="<?php echo $al; ?>" />
			<input type="hidden" name="te" value="<?php echo $te; ?>" />
			<input type="hidden" name="ta" value="<?php echo $ta; ?>" />
			<input type="hidden" name="di" value="<?php echo $di; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="index.php?link=<?php echo md5('pendaftaranformeditdaftaraps'); ?>&idx=<?php echo $penunjang_id; ?>&no=<?php echo $no; ?>&un=<?php echo $un; ?>&in=<?php echo $in; ?>&do=<?php echo $do; ?>&al=<?php echo $al; ?>&te=<?php echo $te; ?>&ta=<?php echo $ta; ?>&di=<?php echo $di; ?>" ><input type="button" value="selesai" class="myButton" /></a>
			</td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>