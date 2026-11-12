<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jkn_diagnosa").autocomplete("index.php?autocomp=autocompjkndiagnosa",{width: 380});
		jQuery("#jkn_kd_pkk").autocomplete("index.php?sep=1&ref=faskes",{width: 380,
			extraParams : {
				jns : function(){
					return $('#jkn_asal_rujukan').val();
				}
		}});
		jQuery("#kd_lokasi_kecelakaan_propinsi").autocomplete("index.php?sep=1&ref=propinsi",{width: 380});
		jQuery("#kd_lokasi_kecelakaan_kota").autocomplete("index.php?sep=1&ref=kota",{width: 380,
			extraParams : {
				propinsi : function(){
					return $('#kd_lokasi_kecelakaan_propinsi').val();
				}
		}});
		jQuery("#kd_lokasi_kecelakaan_kecamatan").autocomplete("index.php?sep=1&ref=kecamatan",{width: 380,
			extraParams : {
				kota : function(){
					return $('#kd_lokasi_kecelakaan_kota').val();
				}
		}});
		jQuery("#jkn_dpjp_skdp").autocomplete("index.php?sep=1&ref=dpjp&pelayanan=<?php echo $jns_rawat; ?>",{width: 380,
			extraParams : {
				spesialisasi : function(){
					return $('#spesialisasi_dpjp').val();
				}
		}});
		
    $.ajax({
		url: '/nsimrs/index.php?sep=1&ref=spesialis',
		type: 'POST',
		dataType: 'json',
		async : false,
		success: function(data) {
			if (data.metaData.code == '200') {
				var arrdata = data.response.list;
				var select = document.getElementById('spesialisasi_dpjp');
				for(var i in arrdata)
				{
					var opt = document.createElement('option');
						opt.value = arrdata[i].kode;
						opt.innerHTML = arrdata[i].nama;
						select.appendChild(opt);
				}
				select.value = '<?php echo $jkn_spesialis_dpjp_skdp; ?>';
			} 
		},
		error: function() {
		},
		timeout: 10000
	});
	
	$.ajax({
		url: '/nsimrs/index.php?sep=1',
		type: 'POST',
		data: {
				request	: 'getListNorujukan',
				no_peserta : '<?php echo $no_peserta; ?>'
			},
		dataType: 'json',
		async : false,
		success: function(data) {
			if(data.length > 0){
				if(data.length == 1){
					$('#jkn_no_rujuk').val(data);
				}else{
					arr_data = '<option value="">-</option>';
					for(var i in data)
					{
						arr_data = arr_data + '<option value="' + data[i] + '">' + data[i] + '</option>'; 
					}
					
					$("#jkn_no_rujuk").replaceWith('<select id="jkn_no_rujuk" name="jkn_no_rujuk" class="text_dt" style="width:167px;">' + arr_data + '</select>');
				}
			}
		},
		error: function() {
		},
		timeout: 10000
	});
	
	});
</script>
<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Rujukan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_tgl_rujuk" id="tgl_minta" value="<?php echo $jkn_tgl_rujuk; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<div style="float:left;">
				<input type="text" name="jkn_no_rujuk" id="jkn_no_rujuk" class="text_dt" value="<?php echo $jkn_no_rujuk; ?>" style="width:167px;" />
				</div>
				<div style="float:left;">
				<button type="button" onClick="showRujukan()" class="myButton1">detail</button>
				</div>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Rujukan</div><br><br> 

				<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Faskes</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jkn_asal_rujukan" id="jkn_asal_rujukan" style="width:228px;" class="text_dt" >
				<option value="1" <?php if($jkn_asal_rujukan == '1' or $jkn_asal_rujukan == '') echo 'selected="selected"'; ?>>Faskes 1</option>
				<option value="2" <?php if($jkn_asal_rujukan == '2') echo 'selected="selected"'; ?>>Faskes 2</option>
				</select>
				</div>			
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_kd_pkk" id="jkn_kd_pkk" value="<?php echo $jkn_kd_pkk . '--' . $jkn_nama_pkk; ?>" size="34" class="text_dt" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Faskes</div><br><br>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="jkn_diagnosa" id="jkn_diagnosa" class="text_dt" value="<?php echo $jkn_diagnosa . '--' . $jkn_nama_diagnosa; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="jkn_catatan" id="jkn_catatan" class="text_dt" value="<?php echo $jkn_catatan; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Catatan</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kelas Peserta</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_kls_rawat" id="jkn_kls_rawat" class="text_dt" value="3" size="15" readonly="readonly" />
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_pbi_nonpbi" id="jkn_pbi_nonpbi" class="text_dt" value="<?php echo $jkn_pbi_nonpbi; ?>" size="34" readonly="readonly" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Peserta</div><br><br>
				
				<?php if($unit_id == '61'){ ?>
					<div style=" width:250px; float:left; text-indent:25px; " align="left">Keterangan Klinik Tujuan</div>
					<div style=" width:20px; float:left; ">:</div>
					<div style=" width:250px; float:left; text-indent:5px; " align="left">MEDICAL CHECKUP</div>
					<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
					<div style=" width:20px; float:right; ">&nbsp;</div>
					<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
				<?php } ?>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Unit Tujuan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<?php if(isset($pasien) and $pasien != 'rawatinap' and $pasien != 'penunjang' and $pasien != 'operasi'){ 
						echo '<select name="jkn_unit_id" id="jkn_unit_id" style="width:228px;" class="text_dt" ';
						if($pasien == 'mcu') {
							echo '>';
							echo '<option value=""> - </option>';
							$sql_mcu = 'SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"
								AND ST_AKTIF = "1"';
							$get_mcu = mysql_query($sql_mcu) or die(mysql_error());
							while($dat_mcu = mysql_fetch_array($get_mcu)){
								echo '<option value="' . $dat_mcu['TARIF_ID'] . '" ' . (($jkn_unit_id == $dat_mcu['TARIF_ID']) ? 'selected="selected"' : '') . '>' . $dat_mcu['NAMA_TARIF'] . '</option>';
							}
						} else if($pasien == 'online') { ?> onchange="javascript : MyAjaxRequest('cdokter2','index.php?ajaxrequest=cdokterjkn&unit_id=' + <?php echo (($unit_id == '61') ? $unit_id : 'this.value'); ?>);return false;">
							<?php
							echo '<option value=""> - </option>';
							echo getUnit('umum',$jkn_unit_id);
							$sql_mcu = 'SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"
								AND ST_AKTIF = "1"';
							$get_mcu = mysql_query($sql_mcu) or die(mysql_error());
							while($dat_mcu = mysql_fetch_array($get_mcu)){
								echo '<option value="' . $dat_mcu['TARIF_ID'] . '" ' . (($jkn_unit_id == $dat_mcu['TARIF_ID']) ? 'selected="selected"' : '') . '>' . $dat_mcu['NAMA_TARIF'] . '</option>';
							}
						}else{	
							if(stripos($pasien,'umum') !== false){ ?> onchange="javascript : MyAjaxRequest('cdokter2','index.php?ajaxrequest=cdokterjkn&unit_id=' + this.value);return false;">
								<option value=""> - </option>
				<?php 		}else{ 
								echo '>';
							}
							echo getUnit($pasien,$jkn_unit_id);
						} 
					} else if(isset($pasien) and $pasien == 'rawatinap'){ ?>
						<select name="jkn_ruang_id" id="jkn_ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur2','index.php?ajaxrequest=ctmptidurjkn&ruang_id=' + this.value);return false;" >
						<option value=""> - </option>
						<?php echo getRuangRawat($ruang_id); ?>
					<?php } else if(isset($pasien) and $pasien == 'penunjang'){ ?>
							<select name="jkn_unit_id" id="jkn_unit_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('tableTmp','index.php?ajaxrequest=pendaftarantmptindakan&unit_id=' + this.value + '&rawat_id=<?php echo $rawat_id; ?>&tgl_daftar=<?php echo getDateSkr(); ?>&tgl_daftar_rujuk=<?php echo $tgl_daftar_rujuk; ?>&nomr=<?php echo $nomr; ?>');MyAjaxRequest('cpelaksana','index.php?ajaxrequest=pendaftaranpelaksanapenunjangjkn&unit_id=' + this.value);ubah_formdaftar(document.getElementById('jenis_bayar_id').value,this.value);return false;" >
							<option value=""> - </option>
							<?php //if ($unit_id_rujuk == '34') { ?>
							<?php echo getUnit('pnj', $jkn_unit_id); ?>
							<?php //} else { ?>
							<!--<option value="45" <?php if($jkn_unit_id == '45') echo 'selected="selected"'; ?>>Laboratorium</option>
							<option value="17" <?php if($jkn_unit_id == '17') echo 'selected="selected"'; ?>>Radiologi</option>
							<option value="52" <?php if($jkn_unit_id == '52') echo 'selected="selected"'; ?>>R. Tindakan EKG/EEG/USG</option>
							<option value="18" <?php if($jkn_unit_id == '18') echo 'selected="selected"'; ?>>Gizi</option>-->
							<?php //} ?>
					<?php } else if(isset($pasien) and $pasien == 'operasi'){ ?>
						<select name="jkn_unit_id" id="jkn_unit_id" style="width:228px;" class="text_dt">
						<option value="56">Kamar Operasi</option>
				<?php } ?>
                </select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<?php if(isset($pasien) and $pasien != 'penunjang'){ ?>
				<div id="cdokter2">
				<select name="jkn_pegawai_id" id="jkn_pegawai_id" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<?php if(isset($pasien) and $pasien != 'rawatinap' and $pasien != 'operasi'){ 
						if($pasien == 'igd' or $pasien == 'kusta'){ 
							echo getDokter($pegawai_id,$unit_id_daftar);
						}else if($pasien == 'mcu'){
							echo getDokter($pegawai_id,'61');
						}else{
							echo getDokter($pegawai_id,$jkn_unit_id);
						} 
					}else if(isset($pasien) and $pasien == 'rawatinap'){ ?>
					<option value=""> - </option>
					<?php echo getDokterRanap($pegawai_id); 
					}else if(isset($pasien) and $pasien == 'operasi'){	?>
					<option value=""> - </option>
					<?php echo getDokter($pegawai_id);
					}
					?>
				</select>
				</div>
				<?php }else{ ?>
				<div id="cpelaksana">
                    <select name="jkn_pegawai_id" id="jkn_pegawai_id" style="width:228px;" class="text_dt" >
                        <option value=""> - </option>
                        <?php echo getPelaksanaPenunjang($pegawai_id, $jkn_unit_id); ?>
                    </select>
                </div>	
				<?php } ?>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter/ Pemeriksa</div><br><br> 
				
				<?php if(isset($pasien) and $pasien == 'rawatinap'){ ?>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<div id="ctmptidur2">
				<select name="jkn_tmp_tidur" id="jkn_tmp_tidur" style="width:128px;" class="text_dt" >
					<option value=""> - </option>
					<?php echo getTempatTidur($ruang_id,$tmp_tidur); ?>
				</select>
				</div>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kelas Rawat</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jkn_kelas_rawat" id="jkn_kelas_rawat" style="width:128px;" class="text_dt">
						<option value=""> - </option>
						<option value="3" <?php if($kelas_rawat == '3') echo 'selected="selected"'; ?> >3</option>
						<option value="2" <?php if($kelas_rawat == '2') echo 'selected="selected"'; ?> >2</option>
						<option value="1" <?php if($kelas_rawat == '1') echo 'selected="selected"'; ?> >1</option>
						<option value="VIP" <?php if($kelas_rawat == 'VIP') echo 'selected="selected"'; ?> >VIP</option>
						<option value="VVIP" <?php if($kelas_rawat == 'VVIP') echo 'selected="selected"'; ?> >VVIP</option>
					</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
				<?php } ?>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">COB</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="jkn_cob" id="jkn_cob" value="1" <?php if($jkn_cob == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="checkbox" name="jkn_katarak" id="jkn_katarak" value="1" <?php if($jkn_katarak == '1') echo 'checked="checked"'; ?> />&nbsp;Ya
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">Katarak</div><br><br>

				<?php if(isset($pasien) and (stripos($pasien,'igd') !== false or $pasien == 'rawatinap')){ ?>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Pasien Kecelakaan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
					<select name="pasien_kecelakaan" id="pasien_kecelakaan" style="width:228px;" class="text_dt">
						<option value=""> - </option>
						<option value="1" <?php if($pasien_kecelakaan == '1') echo 'selected="selected"'; ?> >Darat</option>
						<option value="2" <?php if($pasien_kecelakaan == '2') echo 'selected="selected"'; ?> >Perairan</option>
						<option value="3" <?php if($pasien_kecelakaan == '3') echo 'selected="selected"'; ?> >Udara</option>
					</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="tgl_kejadian_kecelakaan" id="tgl_kejadian1" value="<?php echo $tgl_kejadian_kecelakaan; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar100')"/></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">Tanggal Kejadian</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Suplesi</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="jkn_suplesi" id="jkn_suplesi" value="1" <?php if($jkn_suplesi == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_nosep_suplesi" id="jkn_nosep_suplesi" class="text_dt" value="<?php echo $jkn_nosep_suplesi; ?>" size="34" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">Nomor SEP Suplesi</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Lokasi Kecelakaan, Propinsi</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_propinsi" id="kd_lokasi_kecelakaan_propinsi" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_propinsi . '--' . $nama_lokasi_kecelakaan_propinsi; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_kota" id="kd_lokasi_kecelakaan_kota" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_kota . '--' . $nama_lokasi_kecelakaan_kota; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Kota/ Kabupaten</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kecamatan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_kecamatan" id="kd_lokasi_kecelakaan_kecamatan" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_kecamatan . '--' . $nama_lokasi_kecelakaan_kecamatan; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="keterangan_kecelakaan" id="keterangan_kecelakaan" class="text_dt" value="<?php echo $keterangan_kecelakaan; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Keterangan Kecelakaan</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Penjamin</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:350px; float:left; text-indent:5px; " align="left">
					<input type="checkbox" name="jkn_penjamin_1" id="jkn_penjamin_1" value="1" 
					<?php if($jkn_penjamin_1 == '1') echo 'checked="checked"'; ?> />&nbsp;Jasa Raharja&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_2" id="jkn_penjamin_2" value="2" 
					<?php if($jkn_penjamin_2 == '2') echo 'checked="checked"'; ?> />&nbsp;BPJS TK&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_3" id="jkn_penjamin_3" value="3" 
					<?php if($jkn_penjamin_3 == '3') echo 'checked="checked"'; ?> />&nbsp;Taspen&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_4" id="jkn_penjamin_4" value="4" 
					<?php if($jkn_penjamin_4 == '4') echo 'checked="checked"'; ?> />&nbsp;ASABRI</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">&nbsp;</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kasus Polisi</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="kasus_polisi" value="1" <?php if($kasus_polisi == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">&nbsp;</div><br><br>
				<?php } ?>	
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Surat SKDP</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="jkn_nosurat_skdp" id="jkn_nosurat_skdp" class="text_dt" value="<?php echo $jkn_nosurat_skdp; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Spesialisasi DPJP</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="spesialisasi_dpjp" id="spesialisasi_dpjp" style="width:228px;" class="text_dt" >
				<option value="">--</option>
				</select>
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="jkn_dpjp_skdp" id="jkn_dpjp_skdp" class="text_dt" value="<?php echo $jkn_dpjp_skdp . '--' . $jkn_nama_dpjp_skdp; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">DPJP</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:350px; float:left; text-indent:5px; " align="left">
					<div style="float:left;">
					<input type="text" name="jkn_no_sep" id="jkn_no_sep" class="text_dt" value="<?php echo $no_sep; ?>" size="26" />
					</div>
					<div id="csep" style="float:left;">	
					<button type="button" onClick="createSEP(<?php echo $jns_rawat; ?>)" class="myButton1">buat</button>
					<?php
						$arr_menu_skr = json_decode($_SESSION['SES_SIMRS_MENU'],true);
						$link_id_skr = $_REQUEST['link'];
						$nama_menu_skr = '';
						foreach ($arr_menu_skr as $row_menu_skr) {
							if($row_menu_skr[1] == $link_id_skr) {
								$nama_menu_skr = $row_menu_skr[2];
								break;
							}	
						}
						if(stripos($nama_menu_skr,'edit') !== false){
							echo '<button type="button" onClick="updateSEP(' . $jns_rawat . ')" class="myButton1">update</button>';
						};
					?>
					</div>
				</div>
				<div style=" width:250px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:300px; float:right; text-indent:25px; " align="left"><image id="loader" src="/nsimrs/sep/image/loading_bar_green.gif" style="display:none" /></div><br><br>       