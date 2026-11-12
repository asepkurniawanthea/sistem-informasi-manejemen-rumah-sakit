<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if (formatNoMR($nomr)==''){
				echo "-"; 
			} else {
				echo formatNoMR($nomr);	
			} 		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($nama_pasien==''){
				echo "-"; 
			} else if ($nama_pasien==' '){ 
				echo "-";
			} else {
				echo $nama_pasien;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Tempat Lahir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($tmp_lahir==''){
				echo "-"; 
			} else {
				echo $tmp_lahir;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($tgl_lahir==''){
				echo "-"; 
			} else {
				echo $tgl_lahir;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Lahir</div><br><br>


<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if (jenisKelamin($jns_kelamin)==''){;
				echo "-"; 
			} else {
				echo jenisKelamin($jns_kelamin);	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if (statusKawin($st_kawin)==''){;
				echo "-"; 
			} else {
				echo statusKawin($st_kawin);	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Status Perkawinan</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Agama</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($agama_id==''){;
				echo "-"; 
			} else {
				echo $agama_id;	
			} 
		
?>
</div><br><br>		

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Pendidikan Terakhir</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($pendidikan_id==''){;
				echo "-"; 
			} else {
				echo $pendidikan_id;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($pekerjaan_id==''){;
				echo "-"; 
			} else {
				echo $pekerjaan_id;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Pekerjaan</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($alamat==''){;
				echo "-"; 
			} else {
				echo $alamat;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($alamat_rt . '/' . $alamat_rw==''){;
				echo "-"; 
			} else {
				echo $alamat_rt . '/' . $alamat_rw;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Rt/Rw</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Propinsi</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($propinsi_id==''){;
				echo "-"; 
			} else {
				echo $propinsi_id;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($kota_id==''){;
				echo "-"; 
			} else {
				echo $kota_id;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kab /Kota</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Kecamatan</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($kecamatan_id==''){;
				echo "-"; 
			} else {
				echo $kecamatan_id;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($kelurahan_id==''){;
				echo "-"; 
			} else {
				echo $kelurahan_id;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kelurahan</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Kode Pos</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($kode_pos==''){;
				echo "-"; 
			} else {
				echo $kode_pos;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($no_telepon==''){;
				echo "-"; 
			} else {
				echo $no_telepon;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Telepon</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Ibu Kandung</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($nama_ibu==''){;
				echo "-"; 
			} else {
				echo $nama_ibu;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($nama_ayah==''){;
				echo "-"; 
			} else {
				echo $nama_ayah;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Ayah Kandung</div><br><br>

<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Suami / Isteri</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($nama_suami_isteri==''){;
				echo "-"; 
			} else {
				echo $nama_suami_isteri;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($nik==''){;
				echo "-"; 
			} else {
				echo $nik;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">NIK</div><br>
