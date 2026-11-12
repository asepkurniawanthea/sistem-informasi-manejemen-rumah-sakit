<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Penanggung Jawab</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php 
			if ($p_jawab_nama==''){;
				echo "-"; 
			} else {
				echo $p_jawab_nama;	
			}
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php
			if ($p_jawab_no_telp==''){;
				echo "-"; 
			} else {
				echo $p_jawab_no_telp;	
			}  
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Telepon</div><br><br>
<!---->
<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php  
			if ($p_jawab_alamat==''){;
				echo "-"; 
			} else {
				echo $p_jawab_alamat;	
			} 
		
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($p_jawab_alamat_rt==''){;
				echo "-"; 
			} else {
				echo $p_jawab_alamat_rt . '/' . $p_jawab_alamat_rw;	
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
			if ($p_jawab_propinsi_id==''){;
				echo "-"; 
			} else {
				echo $p_jawab_propinsi_id;	
			}  
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php
			if ($p_jawab_kota_id==''){;
				echo "-"; 
			} else {
				echo $p_jawab_kota_id;	
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
			if ($p_jawab_kecamatan_id==''){;
				echo "-"; 
			} else {
				echo $p_jawab_kecamatan_id;	
			}
?>
</div>		
<div style=" width:250px; float:right; text-indent:25px; " align="left">
<?php 
			if ($p_jawab_kelurahan_id==''){;
				echo "-"; 
			} else {
				echo $p_jawab_kelurahan_id;	
			}
?>
</div>
<div style=" width:20px; float:right; ">:</div>
<div style=" width:250px; float:right; text-indent:25px; " align="left">Kelurahan</div><br><br>
<!---->

<div style=" width:250px; float:left; text-indent:25px; " align="left">Hubungan Dengan Pasien</div>
<div style=" width:20px; float:left; ">:</div>
<div style=" width:250px; float:left; text-indent:25px; " align="left">
<?php
			if ($p_jawab_hubungan==''){;
				echo "-"; 
			} else {
				echo $p_jawab_hubungan;	
			}
?>
</div><br>