var dataPeserta;
var optGetPeserta;

function pad(n){
	return n < 10 ? '0' + n : n
}

function ISODateString() {	
	var d = new Date();
	
	return d.getUTCFullYear() + '-'
		+ pad(d.getMonth() + 1) + '-'
		+ pad(d.getDate()) + ' '
		+ pad(d.getHours()) + ':'
		+ pad(d.getMinutes()) + ':'
		+ pad(d.getSeconds())
}

function ISODateConvert(d) {
	var r = d.split('/');
	return r[2] + '-' + r[1] + '-' + r[0];
}

function SIMRSDateConvert(d) {
	var r = d.match(/^\s*([0-9]+)\s*-\s*([0-9]+)\s*-\s*([0-9]+)(.*)$/);
	return r[3] + '/' + r[2] + '/' + r[1];
}

function getPeserta(opt, jns_rawat) {
	$('#pesertaDetail').css({'display': 'none'});
	$('#loader').css({'display': 'inline-block'});
	
	optGetPeserta = opt;
	
 	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request	: 'getPeserta',
			option	: opt,
			no_peserta : $('#no_peserta').val()
		},
		success: function(data) {
		
		var kode = data.metaData.code;
		var message = data.metaData.message;
		
		if(message == 'OK'){
			dataPeserta	= data.response.peserta;
			
			$('#no_peserta').val(dataPeserta.noKartu);
			$('#nama_pasien').val(dataPeserta.nama);
			$('#tgl_lahir').val(SIMRSDateConvert(dataPeserta.tglLahir));
			$('input[name="jns_kelamin"][value="' + dataPeserta.sex + '"]').attr('checked', 'checked');
			$('#jkn_kd_pkk').val(dataPeserta.provUmum.kdProvider);
			$('#jkn_nama_pkk').val(dataPeserta.provUmum.nmProvider);
						
			if (jns_rawat == 1) {
				$('#jkn_kls_rawat').val(dataPeserta.hakKelas.kode);
			} else {
				$('#jkn_kls_rawat').val(3);
			}
			
			$('#jkn_pbi_nonpbi').val(dataPeserta.jenisPeserta.keterangan);
			
			$('#tgl_lahir').focus();
			$('#umur').html('');
			$('#pasien_jkn').val(1);
			
			$('#pesertaDetail').css({'display': 'inline-block'});
		}else{
			alert(message);
		}	
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal mendapatkan data peserta.\nSilahkan cek no kartu atau koneksi');
			$('#loader').css({'display': 'none'});
		},
		timeout: 15000
	});
}

function showPeserta() {
	var no_peserta = $('#no_peserta').val();
	window.open('index.php?popup=seppesertadetail&no_peserta=' + no_peserta + '&opt=' + optGetPeserta,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=500,height=600');
}

function getDetailPeserta(opt,no_peserta) {
	$('#loader').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		async : false,
		data: {
			request	: 'getDetail',
			option	: opt,
			no_peserta : no_peserta
		},
		success: function(data) {
			document.getElementById("peserta_detail").innerHTML= data;
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal mendapatkan data peserta.\nSilahkan cek no kartu atau koneksi');
			$('#loader').css({'display': 'none'});
		},
		timeout: 15000
	});
}

function createSEP(jns_rawat) {
	$('#loader').css({'display': 'block'});
	
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		async : false,
		data: {
			request : 'noSkdp'
		},
		success: function(data) {
			$('#jkn_nosurat_skdp').val(data);
		},
		timeout: 10000
	});
	
	var diag 					= $('#jkn_diagnosa').val().split('--');
	var faskes 					= $('#jkn_kd_pkk').val().split('--');
	var tgl_rujuk				= null;
	var polirs					= '50';
	var cobn 					= '0';
	var katarakn 				= '0';
	
	var pasien_kecelakaan		= '0';
	var tgl_kejadian			= null;
	var suplesi_n				= '0';
	var nosep_suplesi			= '';
	var lokasi_kecelakaan_prop	= '';
	var lokasi_kecelakaan_kab	= '';
	var lokasi_kecelakaan_kec	= '';
	var ket_kecelakaan			= '';
	var penjamin_s				= '';
	
	var dokter_skdp				= $('#jkn_dpjp_skdp').val().split('--');
	
	if($('input[name="jkn_cob"]').attr('checked')) cobn = '1';
	if($('input[name="jkn_katarak"]').attr('checked')) katarakn = '1';
	
	tgl_rujuk	= ISODateConvert($('#tgl_minta').val());
	
	if(jns_rawat == 2) {
		polirs	= $('#jkn_unit_id').val();
	}
	
	if ($('#pasien_kecelakaan').length > 0){
		var pk = $('#pasien_kecelakaan').val();
		if(pk !== ''){
			pasien_kecelakaan = '1';
			tgl_kejadian	= ISODateConvert($('#tgl_kejadian1').val()) + ' 12:00:00';
			if($('input[name="jkn_suplesi"]').attr('checked')) suplesi_n = '1';
			nosep_suplesi = $('#jkn_nosep_suplesi').val();
			
			var arr_lokasi_kec_prop = $('#kd_lokasi_kecelakaan_propinsi').val();
			var arr_lokasi_kec_kab = $('#kd_lokasi_kecelakaan_kota').val();
			var arr_lokasi_kec_kec = $('#kd_lokasi_kecelakaan_kecamatan').val();
			
			lokasi_kecelakaan_prop	= arr_lokasi_kec_prop[0];
			lokasi_kecelakaan_kab	= arr_lokasi_kec_kab[0];
			lokasi_kecelakaan_kec	= arr_lokasi_kec_kec[0];
			
			ket_kecelakaan = $('#keterangan_kecelakaan').val();
		
			var penjamin_r	= '';
			if($('input[name="jkn_penjamin_1"]').attr('checked')) penjamin_r += '1,'; 
			if($('input[name="jkn_penjamin_2"]').attr('checked')) penjamin_r += '2,'; 
			if($('input[name="jkn_penjamin_3"]').attr('checked')) penjamin_r += '3,'; 
			if($('input[name="jkn_penjamin_4"]').attr('checked')) penjamin_r += '4,'; 
			if(penjamin_r.length > 0){
				penjamin_s = penjamin_r.substr(0,penjamin_r.length - 1);
			}
		}	
	}
		
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request			: 'createSEP',
			noKartu			: $('#no_peserta').val(),
			tglSep			: ISODateConvert($('#tgl_daftar').val()) + ' 12:00:00',
			ppkPelayanan	: '',
			jnsPelayanan 	: jns_rawat,
			klsRawat		: $('#jkn_kls_rawat').val(),
			noMR			: $('#nomr').val(),
			rujukan			: {
								asalRujukan : $('#jkn_asal_rujukan').val(),
								tglRujukan	: tgl_rujuk,	
								noRujukan	: $('#jkn_no_rujuk').val(),
								ppkRujukan	: faskes[0]
			},
			catatan			: $('#jkn_catatan').val(),
			diagAwal		: diag[0],
			poli			: {
								tujuan		: polirs,
								eksekutif	: '0'
			},
			cob				: {
								cob 		: cobn
			},
			katarak			: {
								katarak 	: katarakn
			},
			jaminan			: {
								lakaLantas	: pasien_kecelakaan,
								penjamin	: {
												penjamin 	: penjamin_s,
												tglKejadian : tgl_kejadian,
												keterangan 	: ket_kecelakaan,
												suplesi : {
													suplesi : suplesi_n,
													noSepSuplesi : nosep_suplesi,
													lokasiLaka	: {
														kdPropinsi 	: lokasi_kecelakaan_prop,
														kdKabupaten : lokasi_kecelakaan_kab,
														kdKecamatan : lokasi_kecelakaan_kec
													}
												}
								}
			},
			skdp			: {
								noSurat 	: $('#jkn_nosurat_skdp').val(),
								kodeDPJP 	: dokter_skdp[0]
			},
			noTelp			: $('#jkn_no_telp').val(),
			user			: ''
			
		},
		success: function(data) {
			
			if (data.metaData.code == '200') {
				$('#jkn_no_sep').val(data.response.sep.noSep);
			}else if (data.metaData.code == '800') {	
				var resmessage = data.metaData.message; 
				var submessage = 'telah mendapat Pelayanan R.Inap';
				if (resmessage.indexOf(submessage) !== -1) {	
					if(confirm(data.metaData.message + '.\nPulangkan Pasien Sekarang?')){
						var tgl_pulang = prompt('Masukan Tanggal Pulang Pasien (dd/mm/yyyy)');
						updatePulangPaksa(data.metaData.message, ISODateConvert(tgl_pulang) + ' 12:00:00', jns_rawat);	
					}
				}else{
					alert(data.metaData.message);
				}
			} else {
				alert(data.metaData.message);
			}
			$('#loader').css({'display': 'none'});
		},
		error: function($data) {
			alert('Gagal membuat SEP.\nSilahkan cek koneksi ke server BPJS');
			$('#loader').css({'display': 'none'});
		},
		timeout: 10000
	});
}

function updateSEP(jns_rawat) {
	$('#loader').css({'display': 'block'});
	
	var diag 					= $('#jkn_diagnosa').val().split('--');
	var faskes 					= $('#jkn_kd_pkk').val().split('--');
	var tgl_rujuk				= null;
	var polirs					= '50';
	var cobn 					= '0';
	var katarakn 				= '0';
	
	var pasien_kecelakaan		= '0';
	var tgl_kejadian			= null;
	var suplesi_n				= '0';
	var nosep_suplesi			= '';
	var lokasi_kecelakaan_prop	= '';
	var lokasi_kecelakaan_kab	= '';
	var lokasi_kecelakaan_kec	= '';
	var ket_kecelakaan			= '';
	var penjamin_s				= '';
	
	var dokter_skdp				= $('#jkn_dpjp_skdp').val().split('--');
	
	if($('input[name="jkn_cob"]').attr('checked')) cobn = '1';
	if($('input[name="jkn_katarak"]').attr('checked')) katarakn = '1';
	
	tgl_rujuk	= ISODateConvert($('#tgl_minta').val()) + ' 12:00:00';
	
	if(jns_rawat == 2) {
		polirs	= $('#jkn_unit_id').val();
	}
	
	if ($('#pasien_kecelakaan').length > 0){
		var pk = $('#pasien_kecelakaan').val();
		if(pk !== ''){
			pasien_kecelakaan = '1';
			tgl_kejadian	= ISODateConvert($('#tgl_kejadian1').val()) + ' 12:00:00';
			if($('input[name="jkn_suplesi"]').attr('checked')) suplesi_n = '1';
			nosep_suplesi = $('#jkn_nosep_suplesi').val();
			
			var arr_lokasi_kec_prop = $('#kd_lokasi_kecelakaan_propinsi').val();
			var arr_lokasi_kec_kab = $('#kd_lokasi_kecelakaan_kota').val();
			var arr_lokasi_kec_kec = $('#kd_lokasi_kecelakaan_kecamatan').val();
			
			lokasi_kecelakaan_prop	= arr_lokasi_kec_prop[0];
			lokasi_kecelakaan_kab	= arr_lokasi_kec_kab[0];
			lokasi_kecelakaan_kec	= arr_lokasi_kec_kec[0];
			
			ket_kecelakaan = $('#keterangan_kecelakaan').val();
		
			var penjamin_r	= '';
			if($('input[name="jkn_penjamin_1"]').attr('checked')) penjamin_r += '1,'; 
			if($('input[name="jkn_penjamin_2"]').attr('checked')) penjamin_r += '2,'; 
			if($('input[name="jkn_penjamin_3"]').attr('checked')) penjamin_r += '3,'; 
			if($('input[name="jkn_penjamin_4"]').attr('checked')) penjamin_r += '4,'; 
			if(penjamin_r.length > 0){
				penjamin_s = penjamin_r.substr(0,penjamin_r.length - 1);
			}
		}	
	}
		
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request			: 'updateSEP',
			noSep			: $('#jkn_no_sep').val(),
			klsRawat		: $('#jkn_kls_rawat').val(),
			noMR			: $('#nomr').val(),
			rujukan			: {
								asalRujukan : $('#jkn_asal_rujukan').val(),
								tglRujukan	: tgl_rujuk,	
								noRujukan	: $('#jkn_no_rujuk').val(),
								ppkRujukan	: faskes[0]
			},
			catatan			: $('#jkn_catatan').val(),
			diagAwal		: diag[0],
			poli			: {
								tujuan		: polirs,
								eksekutif	: '0'
			},
			cob				: {
								cob 		: cobn
			},
			katarak			: {
								katarak 	: katarakn
			},
			jaminan			: {
								lakaLantas	: pasien_kecelakaan,
								penjamin	: {
												penjamin 	: penjamin_s,
												tglKejadian : tgl_kejadian,
												keterangan 	: ket_kecelakaan,
												suplesi : {
													suplesi : suplesi_n,
													noSepSuplesi : nosep_suplesi,
													lokasiLaka	: {
														kdPropinsi 	: lokasi_kecelakaan_prop,
														kdKabupaten : lokasi_kecelakaan_kab,
														kdKecamatan : lokasi_kecelakaan_kec
													}
												}
								}
			},
			skdp			: {
								noSurat 	: $('#jkn_nosurat_skdp').val(),
								kodeDPJP 	: dokter_skdp[0]
			},
			noTelp			: $('#jkn_no_telp').val(),
			user			: ''
			
		},
		success: function(data) {
			
			if (data.metaData.code == '200') {
				$('#jkn_no_sep').val(data.response);
			} else {
				alert(data.metaData.message);
			}
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal membuat SEP.\nSilahkan cek koneksi ke server BPJS');
			$('#loader').css({'display': 'none'});
		},
		timeout: 10000
	});
}

function deleteSEP(no_sep) {
	if ($('input[name="st_batal"]').is(':checked')) {
		if (!$('input[name="keterangan_batal"]').val()) {
			alert('Keterangan pembatalan harus diisi');
			return 0;
		}
	} else {
		$('form[name="pendaftaranedit"]').submit();
		return 0;
	}
	
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request		: 'deleteSEP',
			noSep		: no_sep,
			user		: ''
		},
		success: function(data) {
			if (data.metaData.code == '200') {
				$('form[name="pendaftaranedit"]').submit();
			} else {
				var r = confirm(data.metaData.message + '. Lanjutkan?');
				if (r == true){
					$('form[name="pendaftaranedit"]').submit();
				}else{
					return false;
				}	
			}
		},
		error: function() {
			alert('Gagal menghapus SEP.\nSilahkan cek koneksi ke server BPJS');
		},
		timeout: 10000
	});
}

function updatePulang(no_sep, tgl_pulang, alr) {
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request		: 'updatePulang',
			noSep		: no_sep,
			tglPulang 	: tgl_pulang,
            user 		: ''
		},
		success: function(data) {
			if(alr == 1){
				alert(data.metadata.message);
			}	
		},
		error: function() {
			alert('Gagal memperbarui tanggal pulang pasien.\nSilahkan cek koneksi ke server BPJS');
		},
		timeout: 10000
	});
}

function updatePulangPaksa(no_sep, tgl_pulang, jns_rawat) {
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request		: 'updatePulangPaksa',
			noSep		: no_sep,
			tglPlg 		: tgl_pulang,
            user 		: ''
		},
		success: function(data) {
			if (data.metadata.code == '200') {
				alert('Pemulangan Pasien Berhasil.\nSilahkan Buat Lagi SEP.');
			}else{
				alert(data.metadata.message);
			}	
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal memperbarui tanggal pulang pasien.\nSilahkan cek koneksi ke server BPJS');
			$('#loader').css({'display': 'none'});
		},
		timeout: 10000
	});
}

function showRujukan() {
	var no_rujukan = $('#jkn_no_rujuk').val();
	if(no_rujukan != ''){
		$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		async : false,
		data: {
			request	: 'getRujukan',
			nomor_rujuk : no_rujukan
		},
		success: function(data) {
			var json_data =  JSON.parse(data);
			if(json_data.metaData.code == '200'){
				var json_rujukan = json_data.response.rujukan;
				var tglrujukan = json_rujukan.tglKunjungan;
				var arr_tglrujukan = tglrujukan.split('-');
				
				$('#tgl_minta').val(arr_tglrujukan[2] + '/' + arr_tglrujukan[1] + '/' + arr_tglrujukan[0]);
				$('#jkn_kd_pkk').val(json_rujukan.provPerujuk.kode + '--' + json_rujukan.provPerujuk.nama);
				$('#jkn_diagnosa').val(json_rujukan.diagnosa.kode + '--' + json_rujukan.diagnosa.nama);
				$('#jkn_catatan').val(json_rujukan.diagnosa.keluhan);
				window.open('index.php?popup=jknrujukandetail&no_rujukan=' + no_rujukan,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=500,height=600');
			}else{
				alert(json_data.metaData.message);
			}
			
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal mendapatkan data rujukan.\nSilahkan cek nomor rujukan atau koneksi');
			$('#loader').css({'display': 'none'});
		},
		timeout: 15000
		});
	}else{
		alert('Nomor rujukan belum diisi.');
	}	
}

function getPeserta_siijapin(noKartu) {
	$('#pesertaDetail').css({'display': 'none'});
	$('#loader').css({'display': 'inline-block'});
	
 	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		dataType: 'json',
		async : false,
		data: {
			request	: 'getPeserta',
			option	: '1',
			no_peserta : noKartu
		},
		success: function(data) {
		
		var kode = data.metaData.code;
		var message = data.metaData.message;
		
		if(message == 'OK'){
			dataPeserta	= data.response.peserta;
			$('#jkn_kd_pkk').val(dataPeserta.provUmum.kdProvider + '--' + dataPeserta.provUmum.nmProvider);
			$('#jkn_kls_rawat').val(3);			
			$('#jkn_pbi_nonpbi').val(dataPeserta.jenisPeserta.keterangan);
		}else{
			alert(message);
		}	
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal mendapatkan data peserta.\nSilahkan cek no kartu atau koneksi');
			$('#loader').css({'display': 'none'});
		},
		timeout: 15000
	});
}