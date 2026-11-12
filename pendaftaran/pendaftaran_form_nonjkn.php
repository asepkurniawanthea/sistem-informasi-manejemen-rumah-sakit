<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#kd_lokasi_kecelakaan_propinsi_j").autocomplete("index.php?sep=1&ref=propinsi",{width: 380});
		jQuery("#kd_lokasi_kecelakaan_kota_j").autocomplete("index.php?sep=1&ref=kota",{width: 380,
			extraParams : {
				propinsi : function(){
					return $('#kd_lokasi_kecelakaan_propinsi_j').val();
				}
		}});
		jQuery("#kd_lokasi_kecelakaan_kecamatan_j").autocomplete("index.php?sep=1&ref=kecamatan",{width: 380,
			extraParams : {
				kota : function(){
					return $('#kd_lokasi_kecelakaan_kota_j').val();
				}
		}});
	
	});
</script>
 <?php if($unit_id == '61' or $_GET['link'] == '6a6f6f85bff9c9d8479eb0d6d231a269'){ ?>
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
					echo '<select name="unit_id" id="unit_id" style="width:228px;" class="text_dt"';	
					if($pasien == 'mcu' or $_GET['link'] == '6a6f6f85bff9c9d8479eb0d6d231a269') {
						echo '>';
						echo '<option value=""> - </option>';
						$sql_mcu = 'SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"
								AND ST_AKTIF = "1"';
						$get_mcu = mysql_query($sql_mcu) or die(mysql_error());
						while($dat_mcu = mysql_fetch_array($get_mcu)){
							echo '<option value="' . $dat_mcu['TARIF_ID'] . '" ' . (($unit_id == $dat_mcu['TARIF_ID']) ? 'selected="selected"' : '') . '>' . $dat_mcu['NAMA_TARIF'] . '</option>';
						}
					} else if($pasien == 'online') { ?> onchange="javascript : MyAjaxRequest('cdokter','index.php?ajaxrequest=cdokter&unit_id=' + <?php echo (($unit_id == '61') ? $unit_id : 'this.value'); ?>);return false;">
							<?php
							echo '<option value=""> - </option>';
							echo getUnit('umum',$unit_id);
							$sql_mcu = 'SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"
								AND ST_AKTIF = "1"';
							$get_mcu = mysql_query($sql_mcu) or die(mysql_error());
							while($dat_mcu = mysql_fetch_array($get_mcu)){
								echo '<option value="' . $dat_mcu['TARIF_ID'] . '" ' . (($unit_id == $dat_mcu['TARIF_ID']) ? 'selected="selected"' : '') . '>' . $dat_mcu['NAMA_TARIF'] . '</option>';
							}
							
					}else{		
						if(stripos($pasien,'umum')!== false){ ?> onchange="javascript : MyAjaxRequest('cdokter','index.php?ajaxrequest=cdokter&unit_id=' + this.value);return false;">
							<option value=""> - </option>
				<?php 	}else{
							echo '>';
						}
						echo getUnit($pasien,$unit_id);
					} 
				} else if(isset($pasien) and $pasien == 'rawatinap'){ ?>
					<select name="ruang_id" id="ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur','index.php?ajaxrequest=ctmptidur&ruang_id=' + this.value);return false;" >
						<option value=""> - </option>
						<?php echo getRuangRawat($ruang_id); ?>
				<?php } else if(isset($pasien) and $pasien == 'penunjang'){ ?>
						<select name="unit_id" id="unit_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('tableTmp','index.php?ajaxrequest=pendaftarantmptindakan&unit_id=' + this.value + '&rawat_id=<?php echo $rawat_id; ?>&tgl_daftar=<?php echo getDateSkr(); ?>&tgl_daftar_rujuk=<?php echo $tgl_daftar_rujuk; ?>&nomr=<?php echo $nomr; ?>');MyAjaxRequest('cpelaksana2','index.php?ajaxrequest=pendaftaranpelaksanapenunjang&unit_id=' + this.value);ubah_formdaftar(document.getElementById('jenis_bayar_id').value,this.value);return false;" >
							<option value=""> - </option>
							<?php //if ($unit_id_rujuk == '34') { ?>
							<?php echo getUnit('pnj', $unit_id); ?>
							<?php //} else { ?>
							<!--<option value="45" <?php if($unit_id == '45') echo 'selected="selected"'; ?>>Laboratorium</option>
							<option value="17" <?php if($unit_id == '17') echo 'selected="selected"'; ?>>Radiologi</option>
							<option value="52" <?php if($unit_id == '52') echo 'selected="selected"'; ?>>R. Tindakan EKG/EEG/USG</option>
							<option value="18" <?php if($unit_id == '18') echo 'selected="selected"'; ?>>Gizi</option>-->
							<?php //} ?>
				<?php } else if(isset($pasien) and $pasien == 'operasi'){ ?>			
				<select name="unit_id" id="unit_id" style="width:228px;" class="text_dt">
				<option value="56">Kamar Operasi</option>
				<?php } ?>
                </select>
			</div>
			<div style=" width:300px; float:right; text-indent:5px; " align="left">
			<?php if(isset($pasien) and $pasien != 'penunjang'){ ?>
			<div id="cdokter" >
			<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php if(isset($pasien) and $pasien != 'rawatinap' and $pasien != 'operasi'){ 
						if($pasien == 'igd' or $pasien == 'kusta'){ 
							echo getDokter($pegawai_id,$unit_id_daftar);
						}else if($pasien == 'mcu'){
							echo getDokter($pegawai_id,'61');	
						}else{
							echo getDokter($pegawai_id,$unit_id);
						} 
					}else if(isset($pasien) and $pasien == 'rawatinap'){	?>
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
				<div id="cpelaksana2">
                    <select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                        <option value=""> - </option>
                        <?php echo getPelaksanaPenunjang($pegawai_id, $unit_id); ?>
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
				<div id="ctmptidur">
				<select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
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
				<select name="kelas_rawat" id="kelas_rawat" style="width:128px;" class="text_dt">
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
       
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="no_sep" id="no_sep" class="text_dt" value="<?php echo $no_sep; ?>" size="34" />
			</div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>            
        
			<?php if(isset($pasien) and $pasien != 'rawatinap' and $pasien != 'penunjang' and $pasien != 'operasi'){ ?>
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Pasien</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="asal_pasien_id" id="asal_pasien_id" style="width:228px;" class="text_dt">
                    <option value=""> - </option>
                    <?php echo getAsalPasien($asal_pasien_id); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="ket_asal_pasien" id="ket_asal_pasien" class="text_dt" value="<?php echo $ket_asal_pasien; ?>" size="34" />
			</div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px;" align="left">Keterangan Asal Pasien</div><br><br>
			<?php } ?>
			
			<?php if(isset($pasien) and (stripos($pasien,'igd')!== false or $pasien == 'rawatinap')){ ?>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Pasien Kecelakaan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
					<select name="pasien_kecelakaan_j" id="pasien_kecelakaan_j" style="width:228px;" class="text_dt">
						<option value=""> - </option>
						<option value="1" <?php if($pasien_kecelakaan == '1') echo 'selected="selected"'; ?> >Darat</option>
						<option value="2" <?php if($pasien_kecelakaan == '2') echo 'selected="selected"'; ?> >Perairan</option>
						<option value="3" <?php if($pasien_kecelakaan == '3') echo 'selected="selected"'; ?> >Udara</option>
					</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="tgl_kejadian_kecelakaan_j" id="tgl_kejadian2" value="<?php echo $tgl_kejadian_kecelakaan; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar110')"/></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">Tanggal Kejadian</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Lokasi Kecelakaan, Propinsi</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_propinsi_j" id="kd_lokasi_kecelakaan_propinsi_j" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_propinsi . '--' . $nama_lokasi_kecelakaan_propinsi; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_kota_j" id="kd_lokasi_kecelakaan_kota_j" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_kota . '--' . $nama_lokasi_kecelakaan_kota; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Kota/ Kabupaten</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kecamatan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input name="kd_lokasi_kecelakaan_kecamatan_j" id="kd_lokasi_kecelakaan_kecamatan_j" class="text_dt" value="<?php echo $kd_lokasi_kecelakaan_kecamatan . '--' . $nama_lokasi_kecelakaan_kecamatan; ?>" size="34" />
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input name="keterangan_kecelakaan_j" id="keterangan_kecelakaan_j" class="text_dt" value="<?php echo $keterangan_kecelakaan; ?>" size="34"/>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Keterangan Kecelakaan</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kasus Polisi</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="kasus_polisi_j" value="1" <?php if($kasus_polisi == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">&nbsp;</div><br><br>
				<?php } ?>