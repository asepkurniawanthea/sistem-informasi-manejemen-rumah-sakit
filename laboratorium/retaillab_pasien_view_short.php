<?php if(currentModul() != 'laboratorium'){ ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php if(strlen($nomr) == 6){ ?>
Nomor Medical Record
<?php }else{ ?>
Nomor Id APS
<?php } ?></div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<?php if(strlen($nomr) == 6){
		echo formatNoMR($nomr); 
		}else{
		echo $nomr; } ?>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $nama_pasien; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(!empty($tgl_lahir)){ echo $tgl_lahir; }else{ echo '-'; } ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $umur; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Umur</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($alamat)){ echo $alamat; }else{ echo '-'; } ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(!empty($nik)){ echo $nik; }else{ echo '-'; } ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($jns_pembayaran)){ echo $jns_pembayaran; }else{ echo '-'; } ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
<?php }else{ ?>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php if(strlen($nomr) == 6){ ?>
Nomor Medical Record
<?php }else{ ?>
Nomor Id Penunjang
<?php } ?></div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left">
	<?php if(strlen($nomr) == 6){
		echo formatNoMR($nomr); 
		}else{
		echo $nomr; } ?>
</div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $nama_pasien; ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(!empty($tgl_lahir)){ echo $tgl_lahir; }else{ echo '-'; } ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Kelamin</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:450px; float:left; text-indent:5px; " align="left"><?php if(!empty($alamat)){ echo $alamat; }else{ echo '-'; } ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($no_telepon)){ echo $no_telepon; }else{ echo '-'; } ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Telepon</div><br><br>

<div style=" width:250px; float:left; text-indent:25px; " align="left">KTP/SIM/Passport/NIK</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(!empty($nik)){ echo $nik; }else{ echo '-'; } ?></div>
<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php if(!empty($jns_pembayaran)){ echo $jns_pembayaran; }else{ echo '-'; } ?></div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
<?php } ?>