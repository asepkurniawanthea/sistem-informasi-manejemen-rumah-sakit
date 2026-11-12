<?php

$autocomp = $_GET['autocomp'];
if ($autocomp == 'autocomppendaftaranpekerjaan') {
    include('pendaftaran/pendaftaran_autocomp_pekerjaan.php');
    die();
}
if ($autocomp == 'autocomppendaftarantmplahir') {
    include('pendaftaran/pendaftaran_autocomp_tmp_lahir.php');
    die();
}

if ($autocomp == 'autocompklinikdiagnosa') {
    include('klinik/klinik_autocomp_icd_x.php');
    die();
}

if ($autocomp == 'autocompkliniktindakan') {
    include('klinik/klinik_autocomp_tarif.php');
    die();
}
if ($autocomp == 'autocompkasirtindakan') {
    include('pembayaran/pembayaran_autocomp_tarif.php');
    die();
}
if ($autocomp == 'autocompkasirtindakanigd') {
    include('pembayaran/pembayaran_autocomp_tarif_igd.php');
    die();
}
if ($autocomp == 'autocompkasirtindakanirna') {
    include('pembayaran/pembayaran_autocomp_tarif_irna.php');
    die();
}
if ($autocomp == 'rmicd10') {
    include('rekammedik/rm_autocomp_icd.php');
    die();
}
if ($autocomp == 'rmicd9') {
    include('rekammedik/rm_autocomp_icdcm.php');
    die();
}

if ($autocomp == 'autocompkliniklaboratorium') {
    include('klinik/klinik_autocomp_laboratorium.php');
    die();
}
if ($autocomp == 'autocompklinikradiologi') {
    include('klinik/klinik_autocomp_radiologi.php');
    die();
}

if ($autocomp == 'autocompklinikfarmasi') {
    include('klinik/klinik_autocomp_farmasi.php');
    die();
}

if ($autocomp == 'autocompklinikfarmasidosis') {
    include('klinik/klinik_autocomp_farmasi_dosis.php');
    die();
}

if ($autocomp == 'autocompklinikfarmasijumlah') {
    include('klinik/klinik_autocomp_farmasi_jumlah.php');
    die();
}
if ($autocomp == 'autocompkasirpenunjang') {
    include('pembayaran/pembayaran_autocomp_penunjang.php');
    die();
}
if ($autocomp == 'autocomplaboratoriumdiagnosa') {
    include('laboratorium/laboratorium_autocomp_diagnosa.php');
    die();
}
if ($autocomp == 'autocomplaboratoriumspesimen') {
    include('laboratorium/laboratorium_autocomp_spesimen.php');
    die();
}
if ($autocomp == 'autocompranaptindakanirna') {
    include('rawatinap/ranap_autocomp_tarif.php');
    die();
}

if ($autocomp == 'autocompranapfarmasi') {
    include('rawatinap/ranap_autocomp_farmasi.php');
    die();
}

if ($autocomp == 'autocompranapfarmasidosis') {
    include('rawatinap/ranap_autocomp_farmasi_dosis.php');
    die();
}

if ($autocomp == 'autocompranapfarmasijumlah') {
    include('rawatinap/ranap_autocomp_farmasi_jumlah.php');
    die();
}
if ($autocomp == 'autocomppendaftaranpenunjang') {
    include('pendaftaran/pendaftaran_autocomp_penunjang.php');
    die();
}

if ($autocomp == 'autocompranapdiagnosa') {
    include('rawatinap/ranap_autocomp_icd_x.php');
    die();
}

if ($autocomp == 'autocompklinikpenunjang') {
    include('klinik/klinik_autocomp_penunjang.php');
    die();
}
if ($autocomp == 'autocompjkndiagnosa') {
    include('pendaftaran/pendaftaran_autocomp_diagnosa.php');
    die();
}
if ($autocomp == 'autocompranapobat') {
    include('rawatinap/ranap_autocomp_obat.php');
    die();
}
if ($autocomp == 'autocompranapkeluarmasuk') {
    include('rawatinap/ranap_autocomp_keluar_masuk.php');
    die();
}
if ($autocomp == 'autocompranaplaboratorium') {
    include('rawatinap/ranap_autocomp_laboratorium.php');
    die();
}
if ($autocomp == 'autocompranapradiologi') {
    include('rawatinap/ranap_autocomp_radiologi.php');
    die();
}
if ($autocomp == 'autocompranappenunjang') {
    include('rawatinap/ranap_autocomp_penunjang.php');
    die();
}

if ($autocomp == 'autocompranapdosispemberianobat') {
    include('rawatinap/ranap_autocomp_pemberian_obat_dosis.php');
    die();
}

if ($autocomp == 'autocompranapstatusdosispemberianobat') {
    include('rawatinap/ranap_autocomp_pemberian_obat_status_dosis.php');
    die();
}

if ($autocomp == 'autocompoperasitindakan') {
    include('operasi/operasi_autocomp_tarif.php');
    die();
}

if ($autocomp == 'autocompklinikfarmasialergi') {
    include('klinik/klinik_autocomp_farmasi_alergi.php');
    die();
}

if ($autocomp == 'autocomphemodialisafarmasi') {
    include('hemodialisa/hemodialisa_autocomp_farmasi.php');
    die();
}

if ($autocomp == 'autocomphemodialisafarmasidosis') {
    include('hemodialisa/hemodialisa_autocomp_farmasi_dosis.php');
    die();
}
if ($autocomp == 'autocomphemodialisafarmasijumlah') {
    include('hemodialisa/hemodialisa_autocomp_farmasi_jumlah.php');
    die();
}

if ($autocomp == 'autocompranapfarmasialergi') {
    include('rawatinap/ranap_autocomp_farmasi_alergi.php');
    die();
}

if ($autocomp == 'autocompaskepfarmasi') {
    include('askep/askep_autocomp_farmasi.php');
    die();
}

if ($autocomp == 'autocompadmintarif') {
    include('admin/admin_autocomp_tarif.php');
    die();
}

if ($autocomp == 'autocompmutu') {
	include('indikator_mutu/mutu_autocomplete.php');
    die();
}

if ($autocomp == 'autocompranapdiet') {
	include('rawatinap/ranap_autocomp_diet.php');
    die();
}

if ($autocomp == 'autocompranapdiagnosagizi') {
	include('rawatinap/ranap_autocomp_diagnosa.php');
    die();
}

if ($autocomp == 'autocompadminfarmasi') {
	include('admin/admin_autocomp_farmasi.php');
    die();
}

if ($autocomp == 'mspegawai') {
	include('remunerasi/remunerasi_autocomp_pegawai.php');
    die();
}

if ($autocomp == 'autocompresumemedisdiagnosa') {
    include('rawatinap/ranap_autocomp_rm_icd_x.php');
    die();
}
?>