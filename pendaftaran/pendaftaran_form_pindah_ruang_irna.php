<?php
$irna_id = '';
$nomr = '';
$ruang_id = '';
$tmp_tidur = '';
$pegawai_id = '';
$keterangan_pindah = '';

if (isset($_GET['idx'])) {
    $irna_id = $_GET['idx'];
    $sql_rawat = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.RUANG_ID,
				t_irna.NO_TMP_TIDUR,t_irna.PEGAWAI_ID
				FROM t_irna 
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
    $get_rawat = mysql_query($sql_rawat);
    $dat_rawat = mysql_fetch_assoc($get_rawat);
    
	$ruang_id = $dat_rawat['RUANG_ID'];
	$pegawai_id = $dat_rawat['PEGAWAI_ID']; 
    $tmp_tidur = $dat_rawat['NO_TMP_TIDUR'];	
	$nomr = $dat_rawat['NOMR'];
}

if (isset($_POST['irna_id'])) {
    include('pendaftaran/pendaftaran_save_pindah_ruang_irna.php');
}
?>
<div style=" height:auto; padding:15px;">
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
			
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="ruang_id" id="ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur','index.php?ajaxrequest=ctmptidur&ruang_id=' + this.value);return false;" 
			<?php if(!empty($pasien_masuk)) echo 'disabled="disabled"'; ?> >
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
			</select>
			</div>
			<div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cdokter">
			<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_id); ?>
			</select>
			</div>
			</div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter Penanggungjawab</div><br><br> 

			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<div id="ctmptidur">
				<select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" 
				<?php if(!empty($pasien_masuk)) echo 'disabled="disabled"'; ?> >
					<option value=""> - </option>
					<?php echo getTempatTidur($ruang_id,$tmp_tidur); ?>
				</select>
			</div>	
			</div>
			<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>  
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Keterangan</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="keterangan_pindah" value="<?php echo $keterangan_pindah; ?>" class="text_dt" size="60"  />
			</div>
			<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>  
</div>

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;  " align="right">
<a href="index.php?link=<?php echo md5('pendaftaranlistrawat'); ?>" >
<input type="button" value="batal" class="myButton" /></a>
<input type="submit" value="simpan" class="myButton1" />
<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
</div>
</form>
</div>