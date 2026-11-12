<?php if(isset($_GET['idx']) and isset($_GET['no'])){ 

$penunjang_id = $_GET['no'];
$sql_penunjang = 'SELECT "1" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.NAMA_UNIT,t_ipenunjang_tarif.NO_SJP,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.NO_PESERTA,
					m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.TANGGAL_DAFTAR,t_ipenunjang_tarif.JENIS_BAYAR_ID
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ" 
					UNION
					SELECT "2" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID AS PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.NAMA_UNIT,t_ipenunjang_tarif.NO_SJP,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.NO_PESERTA,
					m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.TANGGAL_DAFTAR,t_ipenunjang_tarif.JENIS_BAYAR_ID
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"';
$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
$dat_penunjang = mysql_fetch_assoc($get_penunjang);
$unit_id = $dat_penunjang['NAMA_UNIT'];
$no_sjp = $dat_penunjang['NO_SJP'];
$pemeriksa = $dat_penunjang['NAMA_PEMERIKSA'];
$st_periksa = $dat_penunjang['ST_PERIKSA'];
$jns_pnj = $dat_penunjang['JNS'];
$no_sep = $dat_penunjang['NO_SEP'];

$jaminan = $dat_penunjang['NAMA_JAMINAN'];
$no_peserta = $dat_penunjang['NO_PESERTA'];
$tgl_daftar = changeDateFormat($dat_penunjang['TANGGAL_DAFTAR']);
$jenis_bayar_id = $dat_penunjang['JENIS_BAYAR_ID'];

$rawat_id = $_GET['idx'];
$sql_kunjungan = 'SELECT t_irja.*,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					WHERE IRJA_ID = "' . $rawat_id . '"';
$get_kunjungan = mysql_query($sql_kunjungan);
$dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
$asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
$unit = $dat_kunjungan['NAMA_UNIT'];
$asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
    
$nomr = $dat_kunjungan['NOMR'];
	
$sql_diagnosa = 'SELECT CONCAT(t_irja_diagnosa.ICD_CODE," ",t_irja_diagnosa.DIAGNOSA) AS DIAGNOSA
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0';
$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
$dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
$diagnosa_awal = $dat_diagnosa['DIAGNOSA'];	

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
?>
<div style=" height:auto; padding:15px; ">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dokter; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Asal Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Kiriman Dari</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Penunjang Tujuan</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit_id; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php if(!empty($pemeriksa)){ echo $pemeriksa; }else{ echo '&nbsp;'; } ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Pemeriksa</div><br><br>
    <!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php 
			if ($no_peserta==''){
				echo "-"; 
			} else {			
				echo $no_peserta;
			}
			 
		?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php 
			if ($no_sep==''){
				echo "-"; 
			} else {			
				echo $no_sep;
			}
			 
		?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $no_sjp; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor SJP</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa Awal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:750px; float:left; text-indent:5px; " align="left">
		<?php echo $diagnosa_awal; ?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;
	</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableData" id="tfhover" >
        <?php include('pendaftaran/pendaftaran_tmp_view_penunjang.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<?php if($_GET['opt'] != '1'){ ?>
			<a href="#" onclick="javascript : cetak_karcis(<?php echo $_GET['no']; ?>,<?php echo $jns_pnj; ?>); return false;" ><input type="button" value="cetak karcis" class="myButton" /></a>
			<?php } if($_SESSION['SES_SIMRS_ADMIN'] == '1' and $_GET['opt'] != '1' and $st_periksa != '1'){ ?>
			<a href="#" onclick="javascript : ubah_pendaftaran(<?php echo $_GET['idx']; ?>,<?php echo $_GET['no']; ?>); return false;" ><input type="button" value="ubah" class="myButton" /></a>
			<?php } if($_GET['opt'] == '1'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranbarupenunjang'); ?>" ><input type="button" value="tutup" class="myButton" /></a>
			<?php }else{ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>" ><input type="button" value="tutup" class="myButton" /></a>
			<?php } ?>	
			
<div id="batal"></div>
</div>
</div>
<script language="JavaScript" >
function ubah_pendaftaran(idx,no){
	window.location = "index.php?link=<?php echo md5('pendaftaranformeditdaftarpenunjang'); ?>&idx=<?php echo $_GET['idx']; ?>&no=<?php echo $_GET['no']; ?>";			
}
function cetak_karcis(no,jns){
	var p_sjp = 'no';
	var p_sep = 'no';
	if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
	}
		
	<?php if($jenis_bayar_id == '12'){ ?>
		if(confirm('Print Juga SEP?')){
			p_sep = 'yes';
		}
	<?php } ?>
		
	window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=1&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}	
</script> 
<?php } ?>