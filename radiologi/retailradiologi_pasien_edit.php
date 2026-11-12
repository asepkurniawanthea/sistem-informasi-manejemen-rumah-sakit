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
<div style=" width:250px; float:left; text-indent:5px; " align="left">Nomor Id Retail</div>
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

<div style=" width:250px; float:left; text-indent:5px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
<!--<textarea name="diagnosa" id="diagnosa" class="text_dt3" ><?php echo $diagnosa; ?></textarea>-->
	<textarea name="alamat" id="alamat" value="" class="text_dt3"><?php echo $alamat; ?></textarea>
</div>
<br></br><br></br>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br>

