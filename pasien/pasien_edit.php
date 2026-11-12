<?php if(!isset($aps)){ ?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">Nomor Medical Record</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="nomr" id="nomr" class="text_dt" value="<?php echo $nomr; ?>" size="10" readonly="readonly" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>

<!-- SEP BRIDGING START -->
<div style=" width:250px; float:left; text-indent:5px; " align="left">Nomor Peserta BPJS</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left">
	<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="22" />
	<input type="hidden" name="jkn_kd_pkk" id="jkn_kd_pkk" value="<?php if(isset($jkn_kd_pkk)) echo $jkn_kd_pkk; ?>" />
	<input type="hidden" name="jkn_nama_pkk" id="jkn_nama_pkk" value="<?php if(isset($jkn_nama_pkk)) echo $jkn_nama_pkk; ?>" />
	<input type="hidden" name="jkn_pbi_nonpbi" id="jkn_pbi_nonpbi" value="<?php if(isset($jkn_pbi_nonpbi)) echo $jkn_pbi_nonpbi; ?>" />
	<input type="hidden" name="jkn_kls_rawat" id="jkn_kls_rawat" value="<?php if(isset($jkn_kls_rawat)) echo $jkn_kls_rawat; ?>" />
	<input type="hidden" name="pasien_jkn" id="pasien_jkn" value="<?php if(isset($pasien_jkn)) echo $pasien_jkn; ?>" />
	<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
	<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
	<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
	<image src="/nsimrs/sep/image/loading_circle_green.gif" width="22" height="22" align="top" border="0" id="loader" style="display:none" />
</div>
<!-- SEP BRIDGING END -->

<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<?php }else{ ?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">Nomor Id APS</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="no_penunjang" id="no_penunjang" class="text_dt" value="<?php echo $no_penunjang; ?>" size="20" readonly="readonly" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<?php } ?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">Nama Pasien</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="hidden" name="khusus" id="khusus" value="<?php echo $khusus; ?>" />
	<input type="text" name="nama_pasien" id="nama_pasien" class="text_dt" value="<?php echo $nama_pasien; ?>" size="51" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Tempat/Tanggal Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:220px; float:left; text-indent:5px; " align="left">
	<input type="text" name="tmp_lahir" id="tmp_lahir" class="text_dt" value="<?php echo $tmp_lahir; ?>" size="30" />
</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left">
	/&nbsp;<input type="text" name="tgl_lahir" id="tgl_lahir" class="text_dt" value="<?php echo $tgl_lahir; ?>" size="15" onblur="javascript : MyAjaxRequest('umur','index.php?ajaxrequest=umur&tgl_lahir=' + this.value);return false;" />
    <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar1')"/> dd/mm/yyyy
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Umur</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left"><div id="umur" style="color:#FF0000"><?php echo getUmur($tgl_lahir); ?></div></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Jenis Kelamin </div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if($jns_kelamin == 'L') echo 'checked="checked"'; ?>/>
	&nbsp;Laki-laki&nbsp;&nbsp;
	<input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if($jns_kelamin == 'P') echo 'checked="checked"'; ?> />
	&nbsp;Perempuan
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Agama </div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<select name="agama_id" id="agama_id" style="width:203px;" class="text_dt">
            <option value=""> - </option>
            <?php echo getAgama($agama_id); ?>
        </select>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>

<div style=" width:250px; float:left; text-indent:5px; " align="left">Nama Ibu Kandung</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="nama_ibu" id="nama_ibu" value="<?php echo $nama_ibu; ?>" size="30" class="text_dt" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br><br><br>

<div style=" width:250px; float:left; text-indent:5px; " align="left">Status Perkawinan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left">
	<input type="radio" name="st_kawin" id="st_kawin" value="1" <?php if($st_kawin == '1') echo 'checked="checked"'; ?> />
	&nbsp;Belum Kawin&nbsp;&nbsp;
	<input type="radio" name="st_kawin" id="st_kawin" value="2" <?php if($st_kawin == '2') echo 'checked="checked"'; ?> />
	&nbsp;Kawin&nbsp;&nbsp;<input type="radio" name="st_kawin" id="st_kawin" value="3" <?php if($st_kawin == '3') 
	echo 'checked="checked"'; ?> />&nbsp;Janda/Duda
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Pendidikan Terakhir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<select name="pendidikan_id" id="pendidikan_id" style="width:203px;" class="text_dt">
            <option value=""> - </option>
            <?php echo getPendidikan($pendidikan_id); ?>
        </select>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>


<div style=" width:250px; float:left; text-indent:5px; " align="left">Pekerjaan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="pekerjaan" id="pekerjaan" size="30" value="<?php echo $pekerjaan; ?>" class="text_dt" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:5px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="alamat" id="alamat" value="<?php echo $alamat; ?>" size="51" class="text_dt" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="kode_pos" id="kode_pos" value="<?php echo $kode_pos; ?>" size="8" class="text_dt" /> 
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">Kode Pos</div><br><br>


<div style=" width:250px; float:left; text-indent:5px; " align="left">Rt/Rw</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="alamat_rt" id="alamat_rt" value="<?php echo $alamat_rt; ?>" size="8" class="text_dt" />/<input type="text" name="alamat_rw" id="alamat_rw" value="<?php echo $alamat_rw; ?>" size="8" class="text_dt" />
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="no_telepon" id="no_telepon" value="<?php echo $no_telepon; ?>" size="20" class="text_dt" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">Nomor Telepon</div><br><br>

<div style=" width:250px; float:left; text-indent:5px; " align="left">Propinsi</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<select name="propinsi_id" id="propinsi_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('ckota','index.php?ajaxrequest=ckota&propinsi_id=' + this.value);return false;">
            <option value=""> - </option>
            <?php echo getPropinsi($propinsi_id); ?>
        </select>  
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="nama_suami_isteri" id="nama_suami_isteri" value="<?php echo $nama_suami_isteri; ?>" size="30" class="text_dt" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">Nama Suami /Isteri</div><br><br>

<div style=" width:250px; float:left; text-indent:5px; " align="left">Kab /Kota</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<div id="ckota" ><select name="kota_id" id="kota_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('ckecamatan','index.php?ajaxrequest=ckecamatan&kota_id=' + this.value);return false;" >
                <option value=""> - </option>
                <?php echo getKota($propinsi_id, $kota_id); ?>
            </select></div>
</div>

<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="nama_ayah" id="nama_ayah" value="<?php echo $nama_ayah; ?>" size="30" class="text_dt" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">Nama Ayah Kandung</div><br><br>

<div style=" width:250px; float:left; text-indent:5px; " align="left">Kecamatan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<div id="ckecamatan" ><select name="kecamatan_id" id="kecamatan_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('ckelurahan','index.php?ajaxrequest=ckelurahan&kecamatan_id=' + this.value);return false;">
                <option value=""> - </option>
                <?php echo getKecamatan($kota_id, $kecamatan_id); ?>
            </select></div>  
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<input type="text" name="nik" id="nik" value="<?php echo $nik; ?>" size="30" class="text_dt" />
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">NIK</div><br><br>


<div style=" width:250px; float:left; text-indent:5px; " align="left">Kelurahan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<div id="ckelurahan" ><select name="kelurahan_id" id="kelurahan_id" class="text_dt" style="width:228px;">
                <option value=""> - </option>
                <?php echo getKelurahan($kecamatan_id, $kelurahan_id); ?>
            </select></div>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br>

