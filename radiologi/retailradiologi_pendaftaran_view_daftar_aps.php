<?php if(isset($_GET['idx']) and isset($_GET['no'])){ 

$penunjang_id = $_GET['idx'];
$sql_penunjang = 'SELECT "1" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.NAMA_UNIT,t_ipenunjang_tarif.NO_SJP,t_ipenunjang.PENGIRIM,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.NO_PESERTA,
					m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.TANGGAL_DAFTAR,t_ipenunjang_tarif.JENIS_BAYAR_ID,
					t_ipenunjang.NO_PASIEN_PENUNJANG,t_ipenunjang.NAMA_PASIEN,t_ipenunjang.TGL_LAHIR,
					t_ipenunjang.JNS_KELAMIN,t_ipenunjang.ALAMAT,t_ipenunjang.NIK,
					t_ipenunjang.INSTANSI_PENGIRIM,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang.DIAGNOSA_PENGIRIM,t_ipenunjang.TANGGAL_PERMINTAAN,
					t_ipenunjang.ALAMAT_INSTANSI_PENGIRIM,t_ipenunjang.NO_TELP_INSTANSI_PENGIRIM
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
					AND t_ipenunjang.JNS_ORDER = "APS" ';
$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
$dat_penunjang = mysql_fetch_assoc($get_penunjang);
$unit_id = $dat_penunjang['NAMA_UNIT'];
$unit_penunjang_id = $dat_penunjang['UNIT_PENUNJANG_ID'];
$no_sjp = $dat_penunjang['NO_SJP'];
$pemeriksa = $dat_penunjang['NAMA_PEMERIKSA'];
$st_periksa = $dat_penunjang['ST_PERIKSA'];
$jns_pnj = $dat_penunjang['JNS'];
$no_sep = $dat_penunjang['NO_SEP'];

$jaminan = $dat_penunjang['NAMA_JAMINAN'];
$no_peserta = $dat_penunjang['NO_PESERTA'];
$tgl_daftar = changeDateFormat($dat_penunjang['TANGGAL_DAFTAR']);
$jenis_bayar_id = $dat_penunjang['JENIS_BAYAR_ID'];

$nomr = $dat_penunjang['NO_PASIEN_PENUNJANG'];
$nama_pasien = $dat_penunjang['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_penunjang['TGL_LAHIR']);
$jns_kelamin = $dat_penunjang['JNS_KELAMIN'];
$alamat = $dat_penunjang['ALAMAT'];
$nik = $dat_penunjang['NIK'];			

$dokter = $dat_penunjang['PENGIRIM'];			
$unit = $dat_penunjang['INSTANSI_PENGIRIM'];
$diagnosa_awal = $dat_penunjang['DIAGNOSA_PENGIRIM'];
$alamat_instansi = $dat_penunjang['ALAMAT_INSTANSI_PENGIRIM'];
$phone_instansi = $dat_penunjang['NO_TELP_INSTANSI_PENGIRIM'];
$tgl_permintaan = changeDateFormat($dat_penunjang['TANGGAL_PERMINTAAN']);
$asal_pasien_id = '1';
$asal_pasien = 'APS';
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Instansi Pengirim</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $dokter; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter Pengirim</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $alamat_instansi; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $phone_instansi; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Telepon</div><br><br>
   	<!------------------------------------------------------------------------------------->

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa Awal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $diagnosa_awal; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $tgl_permintaan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Permintaan</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Penunjang Tujuan</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit_id; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
    <!------------------------------------------------------------------------------------->
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableData" id="tfhover" >
        <?php include('radiologi/retailradiologi_pendaftaran_tmp_view_daftar_aps.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
<?php if(!isset($_GET['opt'])){ ?>
		<a href="index.php?link=9a90b08d47cd026d1a0c36e46f0ec7bc&" ><input type="button" value="tutup" class="myButton" /></a>	
	<?php }else{  
			if($st_periksa != '1'){ ?>
			<a href="#" onclick="javascript : ubah_pendaftaran(<?php echo $_GET['idx']; ?>,<?php echo $_GET['no']; ?>); return false;" ><input type="button" value="ubah" class="myButton" /></a>
			<?php } ?>
			<a href="index.php?link=9a90b08d47cd026d1a0c36e46f0ec7bc&" ><input type="button" value="tutup" class="myButton" /></a>
	<?php } ?>
	
<div id="batal"></div>
</div>
</div>
<script language="JavaScript" >
function ubah_pendaftaran(idx,no){
	window.location = "index.php?link=a186d4829d6b93ed8fac4f401b71317e&&idx=<?php echo $_GET['idx']; ?>&no=<?php echo $_GET['no']; ?>";			
}
</script>
<?php } ?>