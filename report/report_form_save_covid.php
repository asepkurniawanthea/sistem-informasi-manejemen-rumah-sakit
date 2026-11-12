<?php
//-----variabel baru

$riwayat_pekerjaan = $_POST['riwayat_pekerjaan'];
$severity_level = $_POST['severity_level'];
$varian = $_POST['varian'];
$komorbid = $_POST['komorbid'];
$hasil_rontgen = $_POST['hasil_rontgen'];
$hasil_sgtf = $_POST['hasil_sgtf'];
$terapi = $_POST['terapi'];
$tgl_masuk_rs = $_POST['tgl_masuk_rs'];
$tgl_masukicu = $_POST['tgl_masukicu'];
$status_pasien = $_POST['status_pasien'];
$los = $_POST['los'];
$status_vaksin = $_POST['status_vaksin'];
$tgl_vaksin = $_POST['tgl_vaksin'];
$tgl_ambil_wgs = $_POST['tgl_ambil_wgs'];
$tgl_kirim_wgs = $_POST['tgl_kirim_wgs'];
$tgl_hasil_wgs = $_POST['tgl_hasil_wgs'];
$hasil_wgs = $_POST['hasil_wgs'];
//------
$pasien_id = $dat_pasien['PASIEN_ID'];
$irna_id = $dat_pasien['IRNA_ID'];
$ruang_id = $dat_pasien['RUANG_ID'];
$ruang_rawat = $dat_pasien['NAMA_RUANG'];
$irna_lapor_covid_id = $_POST['irna_lapor_covid_id'];
$nama_pasien = $_POST['nama_pasien'];
$tgl_lahir = $_POST['tgl_lahir'];
if(isset($_POST['jns_kelamin'])) $jns_kelamin = $_POST['jns_kelamin'];

$_err = '';

$st_save = true;

   if (!empty($_POST['irna_lapor_covid_id'])) {
     
        $st_save = mysql_query('UPDATE t_irna_laporan_covid SET RIWAYAT_PEKERJAAN = "' . $riwayat_pekerjaan . '",JNS_KELAMIN = "' . $jns_kelamin . '",
            RIWAYAT_PEKERJAAN = "' . $riwayat_pekerjaan . '",SEVERITY_LEVEL = "' . $severity_level . '",VARIAN = "' . $varian . '",KOMORBID = "' . $komorbid . '",
            HASIL_RONTGEN = "' . $hasil_rontgen . '",HASIL_SGTF = "' . $hasil_sgtf .'",TERAPI = "' . $terapi .'",TGL_MASUK = str_to_date("' . $tgl_masuk_rs . '","%d/%m/%Y"),
            TGL_ICU = str_to_date("' . $tgl_masukicu . '","%d/%m/%Y"),STATUS_PASIEN = "' . $status_pasien . '",LOS = "' . $los . '",STATUS_VAKSIN = "' . $status_vaksin . '",TGL_VAKSIN = str_to_date("' . $tgl_vaksin . '","%d/%m/%Y"),
            TGL_AMBIL_WGS = str_to_date("' . $tgl_ambil_wgs . '","%d/%m/%Y"),TGL_KIRIM_WGS = str_to_date("' . $tgl_kirim_wgs . '","%d/%m/%Y"),TGL_KELUAR_WGS = str_to_date("' . $tgl_hasil_wgs . '","%d/%m/%Y"),HASIL_WGS = "' . $hasil_wgs . '"
            WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
        
        } else {
		

            $st_save = mysql_query('INSERT INTO t_irna_laporan_covid (IRNA_ID,RUANG_ID,PASIEN_ID,NAMA_RUANG,NAMA_PASIEN,USIA,
                                    JNS_KELAMIN,RIWAYAT_PEKERJAAN,SEVERITY_LEVEL,VARIAN,KOMORBID,HASIL_RONTGEN,HASIL_SGTF,TERAPI,
                                    TGL_MASUK,TGL_ICU,STATUS_PASIEN,LOS,STATUS_VAKSIN,TGL_VAKSIN,TGL_AMBIL_WGS,TGL_KIRIM_WGS,
                                    TGL_KELUAR_WGS,HASIL_WGS) 
                                    VALUES ("' . $irna_id . '","' .$ruang_id. '","' . $pasien_id . '","' . $ruang_rawat . '","' . strtoupper($nama_pasien) . '",' . fieldDate($tgl_lahir) . ',
                                    "' . $jns_kelamin . '","' . $riwayat_pekerjaan . '","' . $severity_level . '","' . $varian . '","' . $komorbid . '","' . $hasil_rontgen . '","' . $hasil_sgtf .'","' . $terapi .'",
                                    str_to_date("' . $tgl_masuk_rs . '","%d/%m/%Y"),str_to_date("' . $tgl_masukicu . '","%d/%m/%Y"),"' . $status_pasien . '","' . $los . '","' . $status_vaksin . '",str_to_date("' . $tgl_vaksin . '","%d/%m/%Y"),
                                    str_to_date("' . $tgl_ambil_wgs . '","%d/%m/%Y"),str_to_date("' . $tgl_kirim_wgs . '","%d/%m/%Y"),str_to_date("' . $tgl_hasil_wgs . '","%d/%m/%Y"),"' . $hasil_wgs . '")') or die(mysql_error());
        }
        /*if ($st_save) {
            if (empty($irna_lapor_covid_id)) {
                $rsl = mysql_query('SELECT IRNA_LAPOR_COVID_ID FROM t_irna_laporan_covid_id ORDER BY IRNA_LAPOR_COVID_ID DESC LIMIT 1');
                $get = mysql_fetch_assoc($rsl);
                $irna_lapor_covid_id = $get['IRNA_LAPOR_COVID_ID'];
            }
        }*/

    if (empty($_err)) {
        ?>
        <script language="JavaScript" >
            window.location = "index.php?link=593ead4bbdd314afbcc7ac148cd9fa94&&idx=";
        </script> 
        <?php
    } else {
    $msg_info = $_err;
    
    }
    ?>