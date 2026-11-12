<?php

$popup = $_GET['popup'];
if ($popup == 'klinikformdiagnosa') {
    include('klinik/klinik_form_add_diagnosa.php');
    die();
}

if ($popup == 'ranapformdiagnosa') {
    include('rawatinap/ranap_form_add_diagnosa.php');
    die();
}

if ($popup == 'ranapformdiagnosagigi') {
    include('rawatinap/ranap_form_add_diagnosa_gigi.php');
    die();
}

if ($popup == 'klinikformtindakan') {
    include('klinik/klinik_form_add_tindakan.php');
    die();
}

if ($popup == 'klinikformresep') {
    include('klinik/klinik_form_add_resep.php');
    die();
}

if ($popup == 'klinikformpelaksana') {
    include('klinik/klinik_form_pelaksana_tindakan.php');
    die();
}

if ($popup == 'shift') {
    include('shared/shift.php');
    die();
}

if ($popup == 'ubahpassword') {
    include('shared/ubah_password.php');
    die();
}

if ($popup == 'rmformkirim') {
    include('rekammedik/rm_form_tracer_kirim.php');
    die();
}

if ($popup == 'rmformterima') {
    include('rekammedik/rm_form_tracer_terima.php');
    die();
}

if ($popup == 'rmformterimaunit') {
    include('rekammedik/rm_form_tracer_terima_unit.php');
    die();
}

if ($popup == 'kasirformtindakan') {
    include('pembayaran/pembayaran_form_add_tindakan.php');
    die();
}
if ($popup == 'kasirformtindakanigd') {
    include('pembayaran/pembayaran_form_add_tindakan_igd.php');
    die();
}
if ($popup == 'kasirformtindakanirna') {
    include('pembayaran/pembayaran_form_add_tindakan_irna.php');
    die();
}
if ($popup == 'rmformdiagnosa') {
    include('rekammedik/rm_form_add_diagnosa.php');
    die();
}

if ($popup == 'klinikformlaboratorium') {
    include('klinik/klinik_form_add_laboratorium.php');
    die();
}
if ($popup == 'klinikformradiologi') {
    include('klinik/klinik_form_add_radiologi.php');
    die();
}
if ($popup == 'kasiraddpemeriksaanpenunjang') {
    include('pembayaran/pembayaran_form_add_penunjang.php');
    die();
}
if ($popup == 'klinikformviewlaboratorium') {
    include('klinik/klinik_view_diagnosa_laboratorium.php');
    die();
}
if ($popup == 'ranapformdiagnosa') {
    include('rawatinap/ranap_form_add_diagnosa.php');
    die();
}

if ($popup == 'ranapformhapusdiagnosa') {
    include('rawatinap/ranap_form_add_hapus_diagnosa.php');
    die();
}

if ($popup == 'ranapformtindakan') {
    include('rawatinap/ranap_form_add_tindakan.php');
    die();
}
if ($popup == 'ranapformpelaksana') {
    include('rawatinap/ranap_form_pelaksana_tindakan.php');
    die();
}
if ($popup == 'ranapformlaboratorium') {
    include('rawatinap/ranap_form_add_laboratorium.php');
    die();
}
if ($popup == 'ranapformviewlaboratorium') {
    include('rawatinap/ranap_view_diagnosa_laboratorium.php');
    die();
}

if ($popup == 'ranapformradiologi') {
    include('rawatinap/ranap_form_add_radiologi.php');
    die();
}

if ($popup == 'ranapformresep') {
    include('rawatinap/ranap_form_add_resep.php');
    die();
}

if ($popup == 'klinikformeditresep') {
    include('klinik/klinik_form_edit_add_resep.php');
    die();
}

if ($popup == 'ranapformeditresep') {
    include('rawatinap/ranap_form_edit_add_resep.php');
    die();
}
if ($popup == 'pendaftaranformaddpenunjang') {
    include('pendaftaran/pendaftaran_form_add_penunjang.php');
    die();
}

if ($popup == 'klinikformpenunjang') {
    include('klinik/klinik_form_add_penunjang.php');
    die();
}

if ($popup == 'ranapformpenunjang') {
    include('rawatinap/ranap_form_add_penunjang.php');
    die();
}

if ($popup == 'klinikformviewpenunjang') {
    include('klinik/klinik_view_diagnosa_penunjang.php');
    die();
}
if ($popup == 'ranapformviewpenunjang') {
    include('ranap/ranap_view_diagnosa_penunjang.php');
    die();
}

if ($popup == 'pendaftaranaddpemeriksaanpenunjang') {
    include('pendaftaran/pendaftaran_form_add_penunjang.php');
    die();
}

if ($popup == 'pendaftaranaddpemeriksaanpenunjang') {
    include('pendaftaran/pendaftaran_form_add_penunjang.php');
    die();
}
if ($popup == 'pendaftaranformtindakan') {
    include('pendaftaran/pendaftaran_form_add_tindakan.php');
    die();
}
if ($popup == 'klinikformviewradiologi') {
    include('klinik/klinik_view_diagnosa_radiologi.php');
    die();
}
if ($popup == 'laboratoriumformriwayat') {
    include('laboratorium/laboratorium_view_riwayat.php');
    die();
}

if ($popup == 'klinikriwayatlaboratorium') {
    include('klinik/klinik_laboratorium_view_riwayat.php');
    die();
}

if ($popup == 'ranapformperkembangan') {
    include('rawatinap/ranap_form_add_perkembangan.php');
    die();
}

if ($popup == 'ranapformeditperkembangan') {
    include('rawatinap/ranap_form_edit_perkembangan.php');
    die();
}

if ($popup == 'ranapformeditpemeriksaanfisik') {
    include('rawatinap/ranap_form_edit_pemeriksaan_fisik.php');
    die();
}

if ($popup == 'ranapformpemeriksaanfisik') {
    include('rawatinap/ranap_form_add_pemeriksaan_fisik.php');
    die();
}
if ($popup == 'ranapformpemberianobat') {
    include('rawatinap/ranap_form_add_pemberian_obat.php');
    die();
}
if ($popup == 'ranapformeditpemberianobat') {
    include('rawatinap/ranap_form_edit_add_pemberian_obat.php');
    die();
}
if ($popup == 'ranapformcatatankeluarmasuk') {
    include('rawatinap/ranap_form_add_catatan_keluar_masuk.php');
    die();
}

if ($popup == 'ranapformeditcatatankeluarmasuk') {
    include('rawatinap/ranap_form_edit_add_catatan_keluar_masuk.php');
    die();
}

if ($popup == 'rmformtindakan') {
    include('rekammedik/rm_form_add_tindakan.php');
    die();
}
if ($popup == 'rmformpenunjang') {
    include('rekammedik/rm_form_add_penunjang.php');
    die();
}

if ($popup == 'klinikformpenunjangekg') {
    include('klinik/klinik_form_add_penunjang_ekg.php');
    die();
}
if ($popup == 'klinikformviewpenunjangekg') {
    include('klinik/klinik_view_diagnosa_penunjang_ekg.php');
    die();
}	

if ($popup == 'penunjangformtindakan') {
    include('penunjang/penunjang_form_add_tindakan.php');
    die();
}

if ($popup == 'pendaftaranaddpemeriksaanpenunjangedit') {
    include('pendaftaran/pendaftaran_form_add_penunjang_edit.php');
    die();
}

if ($popup == 'pendaftaranaddpemeriksaanapsedit') {
    include('pendaftaran/pendaftaran_form_add_aps_edit.php');
    die();
}

if ($popup == 'ranapformpenunjangekg') {
    include('rawatinap/ranap_form_add_penunjang_ekg.php');
    die();
}

if ($popup == 'askepformdiagnosa') {
    include('askep/askep_form_add_diagnosa.php');
    die();
}

if ($popup == 'pendaftaranaddpemeriksaanpenunjangaps') {
    include('pendaftaran/pendaftaran_form_add_penunjang_aps.php');
    die();
}

if ($popup == 'retailradiologipendaftaranaddpemeriksaanpenunjangaps') {
    include('radiologi/retailradiologi_pendaftaran_form_add_penunjang_aps.php');
    die();
}

if ($popup == 'retaillabpendaftaranaddpemeriksaanpenunjangaps') {
    include('laboratorium/retaillab_pendaftaran_form_add_penunjang_aps.php');
    die();
}

if ($popup == 'rmformdiagnosairna') {
    include('rekammedik/rm_form_add_diagnosa_irna.php');
    die();
}

if ($popup == 'rmformtindakanirna') {
    include('rekammedik/rm_form_add_tindakan_irna.php');
    die();
}

if ($popup == 'rmformpenunjangirna') {
    include('rekammedik/rm_form_add_penunjang_irna.php');
    die();
}

if ($popup == 'operasiformtindakan') {
    include('operasi/operasi_form_add_tindakan.php');
    die();
}

if ($popup == 'klinikformalergi') {
    include('klinik/klinik_form_add_alergi.php');
    die();
}

if ($popup == 'klinikformpenunjanghemodialisa') {
    include('klinik/klinik_form_add_penunjang_hemodialisa.php');
    die();
}

if ($popup == 'ranapformpenunjanghmd') {
    include('rawatinap/ranap_form_add_penunjang_hemodialisa.php');
    die();
}

if ($popup == 'hemodialisaformdiagnosa') {
    include('hemodialisa/hemodialisa_form_add_diagnosa.php');
    die();
}
if ($popup == 'hemodialisaformtindakan') {
    include('hemodialisa/hemodialisa_form_add_tindakan.php');
    die();
}
if ($popup == 'hemodialisaformpelaksana') {
    include('hemodialisa/hemodialisa_form_pelaksana_tindakan.php');
    die();
}
if ($popup == 'hemodialisaformlaboratorium') {
    include('hemodialisa/hemodialisa_form_add_laboratorium.php');
    die();
}
if ($popup == 'hemodialisaformradiologi') {
    include('hemodialisa/hemodialisa_form_add_radiologi.php');
    die();
}
if ($popup == 'hemodialisaformpenunjangekg') {
    include('hemodialisa/hemodialisa_form_add_penunjang_ekg.php');
    die();
}
if ($popup == 'hemodialisaformresep') {
    include('hemodialisa/hemodialisa_form_add_resep.php');
    die();
}
if ($popup == 'hemodialisaformeditresep') {
    include('hemodialisa/hemodialisa_form_edit_add_resep.php');
    die();
}
if ($popup == 'hemodialisaformalergi') {
    include('hemodialisa/hemodialisa_form_add_alergi.php');
    die();
}

if ($popup == 'rawatinapformalergi') {
    include('rawatinap/ranap_form_add_alergi.php');
    die();
}

if ($popup == 'inacbgformupdateklaim') {
    include('inacbg/inacbg_eklaim_update.php');
    die();
}

if ($popup == 'inacbgformupdateklaimperruangan') {
    include('inacbg/inacbg_eklaim_update_perruangan.php');
    die();
}

if ($popup == 'inacbgformupdatepasien') {
    include('inacbg/inacbg_eklaim_pasien_update.php');
    die();
}

if ($popup == 'inacbgformgrouping') {
    include('inacbg/inacbg_eklaim_grouping.php');
    die();
}

if ($popup == 'inacbgformdetailklaim') {
    include('inacbg/inacbg_eklaim_detail.php');
    die();
}

if ($popup == 'ranapformterapipulang') {
    include('rawatinap/ranap_form_terapi_pulang.php');
    die();
}

if ($popup == 'ranapformrekonsiliasiobat') {
    include('rawatinap/ranap_form_add_rekonsiliasi_obat.php');
    die();
}

if ($popup == 'seppesertadetail') {
    include('sep/sep_peserta_detail.php');
    die();
}

if ($popup == 'keuanganformtarif') {
    include('keuangan/keuangan_form_add_tarif.php');
    die();
}

if ($popup == 'keuanganformaddakun') {
    include('keuangan/keuangan_form_add_akun.php');
    die();
}

if ($popup == 'keuanganformaddtransaksi') {
    include('keuangan/keuangan_form_add_transaksi.php');
    die();
}

if ($popup == 'operasiformlaboratorium') {
    include('operasi/operasi_form_add_laboratorium.php');
    die();
}

if ($popup == 'operasiformradiologi') {
    include('operasi/operasi_form_add_radiologi.php');
    die();
}

if ($popup == 'ranapriwayatlaboratorium') {
    include('rawatinap/ranap_laboratorium_view_riwayat.php');
    die();
}

if ($popup == 'hemodialisaformviewlaboratorium') {
    include('hemodialisa/hemodialisa_view_diagnosa_laboratorium.php');
    die();
}

if ($popup == 'hemodialisariwayatlaboratorium') {
    include('hemodialisa/hemodialisa_laboratorium_view_riwayat.php');
    die();
}

if ($popup == 'operasiformviewlaboratorium') {
    include('operasi/operasi_view_diagnosa_laboratorium.php');
    die();
}

if ($popup == 'operasiriwayatlaboratorium') {
    include('operasi/operasi_laboratorium_view_riwayat.php');
    die();
}

if ($popup == 'jknrujukandetail') {
    include('sep/sep_rujukan_detail.php');
    die();
}

if ($popup == 'laboratoriumformaddpemeriksaan') {
    include('laboratorium/laboratorium_form_add_pemeriksaan.php');
    die();
}

if ($popup == 'operasiformresep') {
    include('operasi/operasi_form_add_resep.php');
    die();
}
?>