<?php
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,
				m_ruang.KELAS_RAWAT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,m_pegawai2.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
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
$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
$ruang_id = $dat_pasien['RUANG_ID'];
$kelas_rawat = $dat_pasien['KELAS_RAWAT'];
$tmp_tidur = $dat_pasien['NO_TMP_TIDUR'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kasus_polisi = $dat_pasien['KASUS_POLISI'];
$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$nama_dokter_rawat = $dat_pasien['NAMA_DOKTER_RAWAT'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;
?>
<div style=" height:auto; padding:15px; padding-bottom:0px;">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php include('pasien/pasien_view_short.php'); ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tmp_tidur; ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $kelas_rawat; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kelas Rawat</div><br><br>
</div>
<?php
$pasien_pulang_id = '';
$ket_pasien_pulang = '';
$minta_rujukan = '';
$selesai = '';
$rujukan_unit_id = '';

$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%H") AS JAM_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%i") AS MENIT_KELUAR,
				t_irna.PASIEN_PULANG_ID,t_irna.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
				t_irna.KEADAAN_PULANG_ID
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$tanggal_pulang = $dat_pasien['TANGGAL_KELUAR'];
$pasien_pulang_id = $dat_pasien['PASIEN_PULANG_ID'];
$ket_pasien_pulang = $dat_pasien['KET_PASIEN_PULANG'];
$pasien_keadaan_pulang_id = $dat_pasien['KEADAAN_PULANG_ID'];
if($dat_pasien['NO_RAWAT'] != '') $selesai = '1';

$tgl_keluar = date('d/m/Y');
$jam_keluar = date('H');
$menit_keluar = date('i');

if(!empty($tanggal_pulang)){
	$tgl_keluar = $dat_pasien['TANGGAL_KELUAR'];
	$jam_keluar = $dat_pasien['JAM_KELUAR'];
	$menit_keluar = $dat_pasien['MENIT_KELUAR'];
}

if (isset($_POST['irna_id']))
    include('pendaftaran/pendaftaran_ranap_save_pulang.php');

?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="search" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Pulang</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_keluar" id="tgl_2" class="text_dt" value="<?php echo $tgl_keluar; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
			<select name="jam_keluar" id="jam_keluar" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_keluar); ?>
			</select>
			<select name="menit_keluar" id="menit_keluar" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_keluar); ?>
			</select></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Cara Pulang</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="pasien_pulang_id" id="pasien_pulang_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPulangRanap($pasien_pulang_id); ?>
                </select></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>		
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Keadaan Pulang</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="pasien_keadaan_pulang_id" id="pasien_keadaan_pulang_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getKeadaanPulangRanap($pasien_keadaan_pulang_id); ?>
                </select></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>				
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Keterangan</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><textarea name="ket_pasien_pulang" class="text_dt3"><?php echo $ket_pasien_pulang; ?> </textarea></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
			<br><br><br><br><br>	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:left; ">&nbsp;</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="submit" value="simpan" class="myButton1" />&nbsp;
			<a href="index.php?link=<?php echo md5('pendaftaranlistrawat'); ?>" ><input type="button" value="tutup" class="myButton1" /></a></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>					
</form>
</div>

