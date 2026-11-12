<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Penanggung Jawab</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="p_jawab_nama" id="p_jawab_nama" class="text_dt" value="<?php echo $p_jawab_nama; ?>" size="34" />
</div>
<div style=" width:300px; float:right; text-indent:5px; " align="left">
	<select name="p_jawab_propinsi_id" id="p_jawab_propinsi_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('chkota','index.php?ajaxrequest=chkota&propinsi_id=' + this.value);return false;">
		<option value=""> - </option>
			<?php echo getPropinsi($p_jawab_propinsi_id); ?>
	</select>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Propinsi</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="p_jawab_alamat" id="p_jawab_alamat" class="text_dt" value="<?php echo $p_jawab_alamat; ?>" size="34" />
</div>
<div style=" width:300px; float:right; text-indent:5px; " align="left">
	<div id="chkota" >
		<select name="p_jawab_kota_id" id="p_jawab_kota_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('chkecamatan','index.php?ajaxrequest=chkecamatan&kota_id=' + this.value);return false;">
			<option value=""> - </option>
				<?php echo getKota($p_jawab_propinsi_id, $p_jawab_kota_id); ?>
		</select>
	</div>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kab /Kota</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Rt/Rw</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="p_jawab_alamat_rt" id="p_jawab_alamat_rt" class="text_dt" value="<?php echo $p_jawab_alamat_rt; ?>" size="8" />/
	<input type="text" name="p_jawab_alamat_rw" id="p_jawab_alamat_rw" class="text_dt" value="<?php echo $p_jawab_alamat_rw; ?>" size="8" />
</div>

<div style=" width:300px; float:right; text-indent:5px; " align="left">
	<div id="chkecamatan" >
		<select name="p_jawab_kecamatan_id" id="p_jawab_kecamatan_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('chkelurahan','index.php?ajaxrequest=chkelurahan&kecamatan_id=' + this.value);return false;">
			<option value=""> - </option>
				<?php echo getKecamatan($p_jawab_kota_id, $p_jawab_kecamatan_id); ?>
		</select>
	</div>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kecamatan</div><br><br>


<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Telepon</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<input type="text" name="p_jawab_no_telp" id="p_jawab_no_telp" class="text_dt" value="<?php echo $p_jawab_no_telp; ?>" size="20" />
</div>




<div style=" width:300px; float:right; text-indent:5px; " align="left">
	<div id="chkelurahan" >
		<select name="p_jawab_kelurahan_id" id="p_jawab_kelurahan_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
				<?php echo getKelurahan($p_jawab_kecamatan_id, $p_jawab_kelurahan_id); ?>
		</select>
	</div>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kelurahan</div><br><br>


<div style=" width:250px; float:left; text-indent:25px; " align="left">Hubungan Dengan Pasien</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">	
		<input type="text" name="p_jawab_hubungan" id="p_jawab_hubungan" class="text_dt" value="<?php echo $p_jawab_hubungan; ?>" size="34" />
	
</div>
<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
<div style=" width:20px; float:right; ">&nbsp;</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
