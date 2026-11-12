function klaim_baru(nomorkartu,nomorsep,nomormr,namapasien,tgllahir,jnskel,idx,jnsrawat,mh){
	$('#loader').css({'display': 'inline-block'});
	
	var _namapasien = namapasien.replace("`", "'");
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=new_claim&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_kartu	: nomorkartu,
			nomor_sep	: nomorsep,
			nomor_rm	: nomormr,
			nama_pasien	: _namapasien,
			tgl_lahir	: tgllahir + ' 12:00:00',
			gender		: jnskel,
			idx_rawat	: idx,
			jns_rawat	: jnsrawat
		},
		cache: false,
		success: function(data) {
			alert(data);				
			$('#loader').css({'display': 'none'});
			location.reload();
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function update_pasien(mh){
	if(confirm('Update Data Pasien Di E-Klaim ?')){
		$('#loader').css({'display': 'inline-block'});
		
		var nomor_rm_claim = $('#nomr_claim').val();
		$.ajax({
			url: '/nsimrs/index.php?inacbg=1&method=update_patient&svrmh=' + mh + '&nomor_rm=' + nomor_rm_claim,
			type: 'POST',
			data: {
				nomor_kartu	: $('#nomor_kartu').val(),
				nomor_rm	: $('#nomor_rm').val(),
				nama_pasien	: $('#nama_pasien').val(),
				tgl_lahir	: $('#tgl_lahir').val(),
				gender		: $('#gender').val(),
				nomor_sep	: $('#nomor_sep').val(),
				idx_rawat	: $('#idx_rawat').val(),
				jns_rawat	: $('#jns_rawat').val()
			},
			success: function(data) {
				alert(data);
				$('#loader').css({'display': 'none'});
			},
			error: function() {
				alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
				$('#loader').css({'display': 'none'});
			},
			timeout: 60000
		});
	}	
}

function hapus_pasien(nosep,nomormr,idx,jnsrawat,mh){
	var codernik = prompt('Hapus Data Pasien Di E-Klaim ? \n Masukan NIK Coder'); 
	if(codernik.length != 0){
		$('#loader').css({'display': 'inline-block'});
		
		$.ajax({
			url: '/nsimrs/index.php?inacbg=1&method=delete_patient&svrmh=' + mh,
			type: 'POST',
			data: {
				nomor_rm	: nomormr,
				coder_nik	: codernik,
				idx_rawat	: idx,
				jns_rawat	: jnsrawat
			},
			success: function(data) {
				alert(data);
				$('#loader').css({'display': 'none'});
			},
			error: function() {
				alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
				$('#loader').css({'display': 'none'});
			},
			timeout: 60000
		});
	}	
}

function klaim_update(mh){
	$('#loader').css({'display': 'inline-block'});
	
	var nomor_sep_claim = $('#nomor_sep_lama').val();
	var vpemulasaraan_jenazah = '0';
	var vkantong_jenazah 	= '0';
	var vpeti_jenazah 		= '0';
	var vplastik_erat 		= '0';
	var vdesinfektan_jenazah = '0';
	var vmobil_jenazah 		= '0';
	var vdesinfektan_mobil_jenazah = '0';
	var vcovid19_cc_ind 		= '0';
	
	if($('#pemulasaraan_jenazah').is(':checked')){
		vpemulasaraan_jenazah = '1';
	}
	if($('#kantong_jenazah').is(':checked')){
		vkantong_jenazah = '1';
	}
	if($('#peti_jenazah').is(':checked')){
		vpeti_jenazah = '1';
	}
	if($('#plastik_erat').is(':checked')){
		vplastik_erat = '1';
	}
	if($('#desinfektan_jenazah').is(':checked')){
		vdesinfektan_jenazah = '1';
	}
	if($('#mobil_jenazah').is(':checked')){
		vmobil_jenazah = '1';
	}
	if($('#desinfektan_mobil_jenazah').is(':checked')){
		vdesinfektan_mobil_jenazah = '1';
	}
	if($('#covid19_cc_ind').is(':checked')){
		vcovid19_cc_ind = '1';
	}	
			
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=set_claim_data&svrmh=' + mh + '&nomor_sep=' + nomor_sep_claim,
		type: 'POST',
		data: {
			nomor_sep			: $('#nomor_sep').val(),
			nomor_kartu			: $('#nomor_kartu').val(),
			tgl_masuk			: $('#tgl_masuk').val(),
			tgl_pulang			: $('#tgl_pulang').val(),
			jenis_rawat			: $('#jenis_rawat').val(),
			kelas_rawat			: $('#kelas_rawat').val(),
			adl_sub_acute		: $('#adl_sub_acute').val(),
			adl_chronic			: $('#adl_chronic').val(),
			icu_indikator		: $('#icu_indikator').val(),
			icu_los				: $('#icu_los').val(),
			ventilator_hour		: $('#ventilator_hour').val(),
			upgrade_class_ind	: $('#upgrade_class_ind').val(),
			upgrade_class_class	: $('#upgrade_class_class').val(),
			upgrade_class_los	: $('#upgrade_class_los').val(),
			add_payment_pct		: $('#add_payment_pct').val(),
			birth_weight		: $('#birth_weight').val(),
			discharge_status	: $('#discharge_status').val(),
			diagnosa			: $('#diagnosa').val(),
			procedure			: $('#procedure').val(),
			tarif_rs			: {prosedur_non_bedah : $('#prosedur_non_bedah').val(), 
									prosedur_bedah : $('#prosedur_bedah').val(),
									konsultasi : $('#konsultasi').val(),
									tenaga_ahli : $('#tenaga_ahli').val(),
									keperawatan : $('#keperawatan').val(),
									penunjang : $('#penunjang').val(),
									radiologi : $('#radiologi').val(),
									laboratorium : $('#laboratorium').val(),
									pelayanan_darah : $('#pelayanan_darah').val(),
									rehabilitasi : $('#rehabilitasi').val(),
									kamar : $('#kamar').val(),
									rawat_intensif : $('#rawat_intensif').val(),
									obat : $('#obat').val(),
									obat_kronis : $('#obat_kronis').val(),      
									obat_kemoterapi : $('#obat_kemoterapi').val(),
									alkes : $('#alkes').val(),
									bmhp : $('#bmhp').val(),
									sewa_alat : $('#sewa_alat').val()
								},
			pemulasaraan_jenazah : vpemulasaraan_jenazah,
			kantong_jenazah 	: vkantong_jenazah,
			peti_jenazah 		: vpeti_jenazah,
			plastik_erat 		: vplastik_erat,
			desinfektan_jenazah : vdesinfektan_jenazah,
			mobil_jenazah 		: vmobil_jenazah,
			desinfektan_mobil_jenazah : vdesinfektan_mobil_jenazah,
			covid19_status_cd 	: $('#covid19_status_cd').val(),
			nomor_kartu_t 		: $('#nomor_kartu_t').val(),
			episodes 			: $('#episodes').val(),
			covid19_cc_ind 		: vcovid19_cc_ind,					
			tarif_poli_eks		: $('#tarif_poli_eks').val(),
			nama_dokter			: $('#nama_dokter').val(),
			kode_tarif			: $('#kode_tarif').val(),
			payor_id			: $('#payor_id').val(),
			payor_cd			: $('#payor_cd').val(),
			cob_cd				: $('#cob_cd').val(),
			coder_nik			: $('#coder_nik').val(),
			idx_rawat			: $('#idx_rawat').val(),
			jns_rawat			: $('#jns_rawat').val(),
			jns_bayar			: $('#jns_bayar').val(),
			tarif_rsx			: $('#tarif_rs').val()
		},
		success: function(data) {
			alert(data);
			$('#loader').css({'display': 'none'});
			opener.location.reload();
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function grouping_st1(nosep,idx,jnsrawat,mh){
	$('#loader').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=grouper&stage=1&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: nosep,
			idx_rawat	: idx,
			jns_rawat	: jnsrawat
		},
		success: function(data) {
			var arr_data = data.split('|'); 
			
			if(arr_data.length == 2){
				alert(arr_data[0]);
				document.getElementById("rs_grouping1").innerHTML= arr_data[1];
				opener.location.reload();
			}else{
				alert(data);
			}
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function grouping_st2(mh){
	$('#loader2').css({'display': 'inline-block'});
	
	var sco_cn = $('#sco_cn').val();
	if(sco_cn == ''){
		alert('Special Cmg Option Tidak Ada.');
		$('#loader2').css({'display': 'none'});
	}else{
	
		var spo = '';
		$("input:checkbox[name=sco]:checked").each(function(){
			spo += $(this).val() + '#';
		});
		
		if(spo == ''){
			alert('Special Cmg Option Tidak Ada Yang Dipilih.');
			$('#loader2').css({'display': 'none'});
		}else{
		
			var special_co = spo.substr(0,spo.length - 1);
			
			$.ajax({
				url: '/nsimrs/index.php?inacbg=1&method=grouper&stage=2&svrmh=' + mh,
				type: 'POST',
				data: {
					nomor_sep	: $('#nomor_sep').val(),
					special_cmg : special_co,
					idx_rawat	: $('#idx_rawat').val(),
					jns_rawat	: $('#jns_rawat').val()
				},
				success: function(data) {
					var arr_data = data.split('|'); 
			
					if(arr_data.length == 2){
						alert(arr_data[0]);
						document.getElementById("rs_grouping2").innerHTML= arr_data[1];
						opener.location.reload();
					}else{
						alert(data);
					}
					$('#loader2').css({'display': 'none'});
				},
				error: function() {
					alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
					$('#loader2').css({'display': 'none'});
				},
				timeout: 60000
			});
		}	
	}	
}

function klaim_final(mh){
	$('#loader3').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=claim_final&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: $('#nomor_sep').val(),
			coder_nik	: $('#coder_nik').val(),
			idx_rawat	: $('#idx_rawat').val(),
			jns_rawat	: $('#jns_rawat').val()
		},
		success: function(data) {
			alert(data);
			opener.location.reload();
			$('#loader3').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader3').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function klaim_reedit(nosep,idx,jnsrawat,mh){
	$('#loader').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=reedit_claim&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: nosep,
			idx_rawat	: idx,
			jns_rawat	: jnsrawat
		},
		success: function(data) {
			alert(data);
			location.reload();
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function send_data(nosep,idx,jnsrawat,mh){
	$('#loader').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=send_claim_individual&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: nosep,
			idx_rawat	: idx,
			jns_rawat	: jnsrawat
		},
		success: function(data) {
			alert(data);
			location.reload();
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function klaim_detail(nosep,mh,idx,jnsrawat){
	$('#loader3').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=get_claim_data&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: nosep,
			idx_rawat	: idx,
			jns_rawat	: jnsrawat
		},
		success: function(data) {
			var elem_detail = document.getElementById('klaim_detail');
			if (elem_detail != null){
			
				var arr_data = data.split('|'); 
				
				if(arr_data.length == 2){
					alert(arr_data[0]);
					document.getElementById("klaim_detail").innerHTML= arr_data[1];
				}else{
					alert(data);
				}
			}	

			$('#loader3').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader3').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function klaim_status(nosep,mh){
	$('#loader').css({'display': 'inline-block'});
	
	$.ajax({
		url: '/nsimrs/index.php?inacbg=1&method=get_claim_status&svrmh=' + mh,
		type: 'POST',
		data: {
			nomor_sep	: nosep
		},
		success: function(data) {
			alert(data);
			$('#loader').css({'display': 'none'});
		},
		error: function() {
			alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
			$('#loader').css({'display': 'none'});
		},
		timeout: 60000
	});
}

function hapus_klaim(nosep,mh,idx,jnsrawat){
	var codernik = prompt('Hapus Data Klaim Di E-Klaim ? \n Masukan NIK Coder'); 
	if(codernik.length != 0){
		$('#loader').css({'display': 'inline-block'});
		
		$.ajax({
			url: '/nsimrs/index.php?inacbg=1&method=delete_claim&svrmh=' + mh,
			type: 'POST',
			data: {
				nomor_sep	: nosep,
				coder_nik	: codernik,
				idx_rawat	: idx,
				jns_rawat	: jnsrawat
			},
			success: function(data) {
				alert(data);
				location.reload();
				$('#loader').css({'display': 'none'});
			},
			error: function() {
				alert('Gagal.\nSilahkan Cek Koneksi Ke Server');
				$('#loader').css({'display': 'none'});
			},
			timeout: 60000
		});
	}	
}