<?php if(isset($_GET['idx'])){

$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,
				m_ruang.KELAS_RAWAT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,m_pegawai2.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT,
				m_ruang.NAMA_RUANG,t_irna.KELAS_JAMINAN,t_irna.DEWASA_ANAK_BAYI,t_irna.BANGSA,
				m_pegawai3.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT_2,m_pegawai4.NAMA_PEGAWAI AS NAMA_DOKTER_RAWAT_3,
				m_ruang.BANGSAL,t_irna.NO_RAWAT,t_irna.NEW_RM,t_irna.PAM,
				t_irna.PASIEN_PULANG_ID,t_irna.ST_PULANG,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y") PASIEN_MASUK_RG,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y") PASIEN_KELUAR_RG,
				m_pegawai5.NAMA_PEGAWAI AS NAMA_DOKTER_RJ,
				t_irna.PEGAWAI_RAWAT_ID,t_irna.PEGAWAI_RAWAT_ID_2,t_irna.PEGAWAI_RAWAT_ID_3,
				t_irna.PEGAWAI_RAWAT_ID_4,t_irna.PEGAWAI_RAWAT_ID_5,t_irna.PEGAWAI_RAWAT_ID_6,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK_RS,
				t_irja.UNIT_ID AS PASIEN_MASUK_UN
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_irna.PEGAWAI_RAWAT_ID_2 = m_pegawai3.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai4 ON (t_irna.PEGAWAI_RAWAT_ID_3 = m_pegawai4.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai5 ON (t_irja.PEGAWAI_ID = m_pegawai5.PEGAWAI_ID)
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
if($tmp_tidur == '') $tmp_tidur = '-';
$nama_ruang = $dat_pasien['NAMA_RUANG'];
$bangsal = $dat_pasien['BANGSAL'];

$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$kasus_polisi = $dat_pasien['KASUS_POLISI'];
$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$nama_dokter_rawat = $dat_pasien['NAMA_DOKTER_RAWAT'];
$nama_dokter_rawat_2 = $dat_pasien['NAMA_DOKTER_RAWAT_2'];
$nama_dokter_rawat_3 = $dat_pasien['NAMA_DOKTER_RAWAT_3'];

$kelas_jaminan = $dat_pasien['KELAS_JAMINAN'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar) . ' tt. ' . $tgl_daftar;
$usia = $dat_pasien['DEWASA_ANAK_BAYI'];
$bangsa = $dat_pasien['BANGSA'];

$irna_final = $dat_pasien['NO_RAWAT'];
$new_rm = $dat_pasien['NEW_RM'];
$pam = $dat_pasien['PAM'];
$pasien_pulang_id = $dat_pasien['PASIEN_PULANG_ID'];
$status_pulang = $dat_pasien['ST_PULANG'];
$pasien_masuk_un = $dat_pasien['PASIEN_MASUK_UN'];
$pasien_masuk_rs = $dat_pasien['PASIEN_MASUK_RS'];
$pasien_masuk_rg = $dat_pasien['PASIEN_MASUK_RG'];
$pasien_keluar_rg = $dat_pasien['PASIEN_KELUAR_RG'];
$nama_dokter_rj = $dat_pasien['NAMA_DOKTER_RJ'];

$dokter_pjawab = $dat_pasien['PEGAWAI_ID'];
$dokter_prawat = $dat_pasien['PEGAWAI_RAWAT_ID'];
$dokter_prawat_2 = $dat_pasien['PEGAWAI_RAWAT_ID_2'];
$dokter_prawat_3 = $dat_pasien['PEGAWAI_RAWAT_ID_3'];
$dokter_prawat_4 = $dat_pasien['PEGAWAI_RAWAT_ID_4'];
$dokter_prawat_5 = $dokter_prawat_6 = $dat_pasien['PEGAWAI_RAWAT_ID_6'];

$arr_dokter_rawat = array('0');
if($dokter_pjawab != '') array_push($arr_dokter_rawat,$dokter_pjawab);
if($dokter_prawat != '') array_push($arr_dokter_rawat,$dokter_prawat);
if($dokter_prawat_2 != '') array_push($arr_dokter_rawat,$dokter_prawat_2);
if($dokter_prawat_3 != '') array_push($arr_dokter_rawat,$dokter_prawat_3);
if($dokter_prawat_4 != '') array_push($arr_dokter_rawat,$dokter_prawat_4);
if($dokter_prawat_5 != '') array_push($arr_dokter_rawat,$dokter_prawat_5);
if($dokter_prawat_6 != '') array_push($arr_dokter_rawat,$dokter_prawat_6);
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
<?php
if($_SESSION['SES_SIMRS_BANGSAL'] == ''){
	include('rawatinap/ranap_form_pasien_periksa_menu.php');
}else{
	if($_SESSION['SES_SIMRS_BANGSAL'] == $bangsal){
		include('rawatinap/ranap_form_pasien_periksa_menu.php');
	}
}	
?>
</div>
<script language="javascript" type="text/javascript">
var _haschange = false;

$('form :input').change(function(){
   _haschange = true;
});

window.addEventListener('beforeunload',(event) => {
    if (_haschange) {
        event.preventDefault();
    }
});

function false_kan(){
	_haschange = false;
}

function view_askep(){
	window.open("index.php?link=7c0543a384f13f8d8baeb8ae576b2883&idx=<?php echo $_GET['idx']; ?>","Asuhan Keperawatan");
}

function push_session(){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/sessions/index.php',
		data: { ids : '1' },
		cache: false,
		async : false,
		success: function(json) {			
		},
		error: function (request, status, error) {
	
		}
	});
}	

setInterval(function(){ 
	push_session();
}, 60000);
</script>
<?php } ?>
