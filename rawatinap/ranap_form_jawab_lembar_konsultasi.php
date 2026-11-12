<?php if(isset($_GET['idx']) and isset($_GET['rwt']) and isset($_GET['ksl'])){

$idx = $_GET['idx'];
$rwt = $_GET['rwt'];
$ksl = $_GET['ksl'];

if($rwt == '1'){
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
		m_jaminan.NAMA_JAMINAN,"" AS NO_TMP_TIDUR,
		m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
		m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
		DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,
		"" AS KELAS_RAWAT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
		m_unit.NAMA_UNIT AS NAMA_RUANG
		FROM t_irja
		INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
		INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
		INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
		WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
		
	$qry_konsul = 'SELECT t_irja_lembar_konsul.IRJA_KONSUL_ID AS IRNA_KONSUL_ID,t_irja_lembar_konsul.IRJA_ID,
		t_irja_lembar_konsul.PEGAWAI_ID,t_irja_lembar_konsul.SEBAB_KONSUL,t_irja_lembar_konsul.HASIL_KONSUL,
		t_irja_lembar_konsul.TGL_ASSESMENT_JAWAB,m_pegawai.NAMA_PEGAWAI
		FROM t_irja_lembar_konsul
		LEFT JOIN m_pegawai 
		ON (t_irja_lembar_konsul.PEGAWAI_ID_PENGIRIM = m_pegawai.PEGAWAI_ID)
		WHERE t_irja_lembar_konsul.IRJA_KONSUL_ID = "' . $ksl . '"
		AND t_irja_lembar_konsul.IRJA_ID = "' . $idx . '"';	
		
	if(isset($_POST['id_konsul'])){
		mysql_query('UPDATE t_irja_lembar_konsul 
			SET HASIL_KONSUL = "' . $_POST['hasil_konsul'] . '",
			TGL_ASSESMENT_JAWAB = NOW(),
			REGISTER = "' . $user_name . '"
			WHERE IRJA_KONSUL_ID = "' . $_POST['id_konsul'] . '"') or die(mysql_error());
		?>
		<script language="JavaScript" >
        alert('Simpan Data Lembar Konsul Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php	
	}		
		
}else{	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
		m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
		m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
		m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
		DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,
		m_ruang.KELAS_RAWAT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
		m_ruang.NAMA_RUANG
		FROM t_irna
		INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
		INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
		INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
		INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
		WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
	
	$qry_konsul = 'SELECT t_irna_lembar_konsul.IRNA_KONSUL_ID,t_irna_lembar_konsul.IRNA_ID,
		t_irna_lembar_konsul.PEGAWAI_ID,t_irna_lembar_konsul.SEBAB_KONSUL,t_irna_lembar_konsul.HASIL_KONSUL,
		t_irna_lembar_konsul.TGL_ASSESMENT_JAWAB,m_pegawai.NAMA_PEGAWAI
		FROM t_irna_lembar_konsul
		LEFT JOIN m_pegawai 
		ON (t_irna_lembar_konsul.PEGAWAI_ID_PENGIRIM = m_pegawai.PEGAWAI_ID)
		WHERE t_irna_lembar_konsul.IRNA_KONSUL_ID = "' . $ksl . '"	
		AND t_irna_lembar_konsul.IRNA_ID = "' . $idx . '"';	
		
	if(isset($_POST['id_konsul'])){
		mysql_query('UPDATE t_irna_lembar_konsul 
			SET HASIL_KONSUL = "' . $_POST['hasil_konsul'] . '",
			TGL_ASSESMENT_JAWAB = NOW(),
			REGISTER = "' . $user_name . '"
			WHERE IRNA_KONSUL_ID = "' . $_POST['id_konsul'] . '"') or die(mysql_error());
			
			?>
			<script language="JavaScript" >
			alert('Simpan Data Lembar Konsul Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
			</script>
			<?php	
	}	
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

$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
$kelas_rawat = $dat_pasien['KELAS_RAWAT'];
$tmp_tidur = $dat_pasien['NO_TMP_TIDUR'];
if($tmp_tidur == '') $tmp_tidur = '-';
$nama_ruang = $dat_pasien['NAMA_RUANG'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;	

$get_konsul = mysql_query($qry_konsul) or die(mysql_error());
$dat_konsul = mysql_fetch_assoc($get_konsul);
$id_konsul = $dat_konsul['IRNA_KONSUL_ID'];
$sebab_konsul = $dat_konsul['SEBAB_KONSUL'];
$hasil_konsul = $dat_konsul['HASIL_KONSUL'];
$dokter = $dat_konsul['PEGAWAI_ID'];	
$tgl_jawab = $dat_konsul['TGL_ASSESMENT_JAWAB'];	
$dokter_pengirim = $dat_konsul['NAMA_PEGAWAI'];	
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php include('pasien/pasien_view_short.php'); ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat/ Kelas</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_ruang . '/ ' . $kelas_rawat; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tmp_tidur; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Tempat Tidur</div><br><br>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="formrujukan" id="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="id_konsul" id="id_konsul" value="<?php echo $id_konsul; ?>" />
    <table border="0" width="96%">
		<?php if($id_konsul != ''){ ?>
		<tr>
			<td valign="top">Dokter Pengirim</td>
            <td colspan="2">
				: <?php echo $dokter_pengirim ; ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td valign="top">Sebab - sebab diadakannya konsultasi</td>
            <td colspan="2">: <?php echo $sebab_konsul; ?></td>
		</tr>
		<tr>
			<td valign="top">Hasil dan saran konsultasi</td>
            <td colspan="2"><textarea name="hasil_konsul" class="text_dt10" style="height:250px;"  /><?php echo $hasil_konsul; ?></textarea></td>
		</tr>
        <tr>
            <td colspan="2" align="right">&nbsp;</td>
			<td><input type="button" value="simpan" onclick="simpan();" class="myButton1" />&nbsp;&nbsp;
			<input type="button" value="selesai" onclick="selesai();" class="myButton1" />
			</td>
        </tr>
    </table>
</form>
</div>
</div>
<script language="javascript" type="text/javascript">
function simpan(){	
	$('#formrujukan').submit();	
}

function selesai(){	
	window.location = "index.php?link=315b0338939fc4a64bd24fbbed5f934c";
}		
</script>
<?php } ?>
