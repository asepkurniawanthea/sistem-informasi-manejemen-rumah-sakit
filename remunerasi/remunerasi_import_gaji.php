<?php
include('remunerasi/remunerasi_import_gaji_p.php');
include('remunerasi/remunerasi_import_gaji_p_makan.php');
include('remunerasi/remunerasi_import_gaji_p_remun.php');

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
	
	if(!empty($_FILES)){
		if(count($_FILES['file_gaji']) > 0) {
			$msg_s = '';
			$msg = '';
			$upload_t = 0;
			$upload_f = 0;
			$upload = 0;

			foreach($_FILES['file_gaji']['tmp_name'] as $key => $tmp_name ){
				$file_name = $_FILES['file_gaji']['name'][$key];
				$file_size =$_FILES['file_gaji']['size'][$key];
				$file_tmp =$_FILES['file_gaji']['tmp_name'][$key];
				$file_type=$_FILES['file_gaji']['type'][$key];
					
				$x_file = $upload_lap_gaji_path . basename($file_name);
				$x_filename = $file_name;
					
				if (move_uploaded_file($file_tmp, $x_file)) {
						
						if($_POST['dokumen'] == 'gaji') $result = parse_upload_file_gaji($_POST['tahun'],$_POST['bulan'],$x_file,$x_filename);
						if($_POST['dokumen'] == 'makan') $result = parse_upload_file_makan($_POST['tahun'],$_POST['bulan'],$x_file,$x_filename);
						if($_POST['dokumen'] == 'remunerasi') $result = parse_upload_file_remunerasi($_POST['tahun'],$_POST['bulan'],$x_file,$x_filename);
						$v_result = explode('|',$result);
						$status_u = $v_result[0];
						$proses_u = $v_result[1];
						
						if($status_u == '1'){
							$msg_s = $msg_s . ' ' . $x_filename . ' Berhasil Import "' . $proses_u . '" \n ';
							$upload_t++;	
						}else{
							$msg_s = $msg_s . ' ' . $x_filename . ' Gagal Import "' . $proses_u . '" \n ';
							$upload_f++;	
						}	
						$upload++;
						
				}
			}
			$msg_info = $upload . ' File Telah Diupload, ' . $upload_t . ' Berhasil, ' . $upload_f . ' Gagal. \n ' . $msg_s; 
				
		}
	}	
}

$dokumen = '';
if (isset($_SESSION['remunerasi_upload_gaji_dokumen']))
    $dokumen = $_SESSION['remunerasi_upload_gaji_dokumen'];

$tahun = '';
if (isset($_SESSION['remunerasi_upload_gaji_tahun']))
    $tahun = $_SESSION['remunerasi_upload_gaji_tahun'];

$bulan = '';
if (isset($_SESSION['remunerasi_upload_gaji_bulan']))
    $bulan = $_SESSION['remunerasi_upload_gaji_bulan'];

if (isset($_POST['dokumen'])) {
    $dokumen = $_POST['dokumen'];
	$_SESSION['remunerasi_upload_gaji_dokumen'] = $dokumen;
}

if (isset($_POST['tahun'])) {
    $tahun = $_POST['tahun'];
	$_SESSION['remunerasi_upload_gaji_tahun'] = $tahun;
}

if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];
	$_SESSION['remunerasi_upload_gaji_bulan'] = $bulan;
}
?>
<div style=" height:auto; padding:15px; ">
<form name="formgaji" id="formgaji" action="<?php echo currentURL(); ?>" method="post" enctype="multipart/form-data">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Dokumen</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="dokumen" id="dokumen" style="width:150px;" class="text_dt" >
                    <option value=""> - </option>
					<option value="gaji" <?php if($dokumen == 'gaji') echo 'selected'; ?>>Gaji</option>
					<option value="makan" <?php if($dokumen == 'makan') echo 'selected'; ?>>Uang Makan</option>
					<option value="remunerasi" <?php if($dokumen == 'remunerasi') echo 'selected'; ?>>Remunerasi</option>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Tahun</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="tahun" id="tahun" style="width:150px;" class="text_dt" >
                    <option value=""> - </option>
					<option value="2020" <?php if($tahun == '2020') echo 'selected'; ?>>2020</option>
					<option value="2021" <?php if($tahun == '2021') echo 'selected'; ?>>2021</option>
					<option value="2022" <?php if($tahun == '2022') echo 'selected'; ?>>2022</option>
					<option value="2023" <?php if($tahun == '2023') echo 'selected'; ?>>2023</option>
					<option value="2024" <?php if($tahun == '2024') echo 'selected'; ?>>2024</option>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Bulan</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="bulan" id="bulan" style="width:150px;" class="text_dt" >
                    <option value=""> - </option>
					<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
					<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
					<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
					<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
					<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
					<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
					<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
					<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
					<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
					<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
					<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>Nopember</option>
					<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
		<div style=" width:250px; float:left; text-indent:25px; " align="left">File</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="file" name="file_gaji[]" id="file_gaji" />
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>		
	</div>	
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<div style=" width:200px; float:left; text-indent:25px;" align="left">&nbsp;</div>
			<div style=" width:60px; float:left;">&nbsp;&nbsp;&nbsp;</div>
			<div style=" width:250px; float:left; text-indent:15px; " align="left">
			</div>
			<input type="button" value="upload" class="myButton1" onclick="upload();" />
			<input type="button" value="lihat" class="myButton1" onclick="lihat();" />
	</div>
</form>
</div>	
<script type="text/javascript">
function upload(){
	var c = jQuery('#file_gaji')[0].files.length;
	if(c > 0){
		var f_true = true;
		for(var i = 0; i < c; ++i){
			var _v = jQuery('#file_gaji')[0].files[i].name;
			var _x = _v.split('.');
			var _i = _x.length - 1;
			var _ex = _x[_i];
			if((_ex != 'XLS') && (_ex != 'XLSX') && (_ex != 'xls') && (_ex != 'xlsx')){
				f_true = false;
			}
		}
		
		var d = document.getElementById("dokumen");
		var t = document.getElementById("tahun");
		var b = document.getElementById("bulan");
		var dokumen	= d.options[d.selectedIndex].value;
		var tahun = t.options[t.selectedIndex].value;
		var bulan = b.options[b.selectedIndex].value;

		if((tahun == '') || (bulan == '') || (dokumen == '')){
			f_true = false;
		}
					
		if(f_true == false){
			alert('File yang diijinkan XLS atau XLSX, Jenis Dokumen,Tahun dan Bulan harus diisi');
		}else{
			$.ajax({
				type: 'POST',
				url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekuploadgaji',
				data: { xdokumen : dokumen, xtahun : tahun, xbulan : bulan},
				cache: false,
				success: function(data) {
					if (data.length > 0){
						if(data == 0){
							jQuery('#formgaji').submit();	
						}else{
							 if(confirm('Data ' + dokumen.toUpperCase() + ' Tahun ' + tahun + ', Bulan ' + bulan + ' pernah diupload, lanjutkan ?') == true){
								jQuery('#formgaji').submit();		
							 } 
						}
					}	
				}
			});
		}
	}		
}

function lihat(){
	var t = document.getElementById("tahun");
	var b = document.getElementById("bulan");
	var tahun = t.options[t.selectedIndex].value;
	var bulan = b.options[b.selectedIndex].value;
	
	window.open("index.php?link=44211cfcb69dc993ab09d09b301961f1&tahun=" + tahun + "&bulan=" + bulan);
}
</script>