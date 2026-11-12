<?php 
if(isset($_GET['idx'])){
$irja_id = $_GET['idx'];

$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,m_unit.NAMA_UNIT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
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

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$unit_id = $dat_pasien['UNIT_ID'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

if (isset($_POST['irja_id']))
    include('pembayaran/pembayaran_save_tindakan.php');

if (isset($_GET['idk']))
    include('pembayaran/pembayaran_del_add_tindakan.php');

$irja_id = $_GET['idx'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
   <div style=" width:250px; float:left; text-indent:25px; " align="left">Poliklinik</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('pembayaran/pembayaran_tmp_tindakan.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	<?php 
			$kasir = 'umum'; 
			$link = 'pembayarandetailbayarpoliklinik';
			if(isset($_GET['kasir'])){
				$kasir = $_GET['kasir'];
				if($kasir == 'igd') $link = 'pembayarandetailbayarigd';
				if($kasir == 'kusta') $link = 'pembayarandetailbayarkusta';
			}
	?>
	<table width="100%">	
		<tr>
            <td colspan="7" align="right">
			<?php if($kasir == 'igd'){ ?>
			<a href="#" onclick="window.open('index.php?popup=kasirformtindakanigd&idx=<?php echo $irja_id; ?>&grp=10','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<?php } else { ?>
			<?php if($unit_id == '54'){ ?>
			<a href="#" onclick="window.open('index.php?popup=kasirformtindakan&idx=<?php echo $irja_id; ?>&grp=94&unit_id=<?php echo $unit_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>	
			<?php }else{ ?>
			<a href="#" onclick="window.open('index.php?popup=kasirformtindakan&idx=<?php echo $irja_id; ?>&grp=03&unit_id=<?php echo $unit_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<?php } ?>
			<?php } ?>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="index.php?link=<?php echo md5($link); ?>&kasir=<?php echo $kasir; ?>&idx=<?php echo $irja_id; ?>" ><input type="button" value="selesai" class="myButton" /></a></td>	
        </tr>
	</table>	
</form>
</div>
</div>
<?php } ?>