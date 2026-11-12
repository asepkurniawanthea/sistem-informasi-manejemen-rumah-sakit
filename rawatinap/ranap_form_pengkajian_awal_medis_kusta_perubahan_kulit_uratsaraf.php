<?php
$qry_pasien = 'SELECT IRJA_ID,TANDA_PERUBAHAN_KULIT_SARAF,CATATAN_TANDA_PERUBAHAN_KULIT_SARAF,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_irja_pengkajian_awal_medis_kusta
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$tanda_perubahan_kulit_saraf = $dat_pasien['TANDA_PERUBAHAN_KULIT_SARAF'];
$catatan_perubahan_kulit_saraf = $dat_pasien['CATATAN_TANDA_PERUBAHAN_KULIT_SARAF'];
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
            <td valign="top" colspan="8">Berilah tanda-tanda kelainan pada gambar tubuh ini &nbsp;&nbsp;:</td>
        </tr>
	   <tr>
			<td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5" align="center">
				<canvas id="canvas" style="border:5px;"></canvas>
				<button type="button" class="button clear" onclick="undoCanvas();" style="width:770px;">Undo</button>
				<button type="button" class="button clear" onclick="clearCanvas();" style="width:120px;">Clear</button>
				<br/><br/>
				<table border="0">
					<tr>
						<td><input type="radio" name="simbol" id="simbol_1" value="1" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_1_ket.jpg" width="20px" height="20px">&nbsp;Hypo Pigmentasi</td>
						<td><input type="radio" name="simbol" id="simbol_2" value="2" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_2_ket.jpg" width="20px" height="20px">&nbsp;Hypo/ Anaesthesia</td>
						<td><input type="radio" name="simbol" id="simbol_3" value="3" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_3_ket.jpg" width="20px" height="20px">&nbsp;Kelainan di kulit dengan batas tegas<br/></td>
					</tr>	
					<tr>
						<td colspan="3"><input type="radio" name="simbol" id="simbol_4" value="4" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_4_ket.jpg" width="20px" height="20px">&nbsp;Kelainan kulit dengan hypo Pigmentasi dan Hypo/ Anaesthesia dengan batas tegas<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_5" value="5" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_5_ket.jpg" width="20px" height="20px">&nbsp;Kelainan di kulit difus dan rata</td>
						<td><input type="radio" name="simbol" id="simbol_6" value="6" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_6_ket.jpg" width="20px" height="20px">&nbsp;Infeksi yang difus</td>
						<td><input type="radio" name="simbol" id="simbol_7" value="7" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_7_ket.jpg" width="20px" height="20px">&nbsp;Tonjolan (Papel, Nodule)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_8" value="8" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_8_ket.jpg" width="20px" height="20px">&nbsp;Penebalan urat saraf</td>
						<td><input type="radio" name="simbol" id="simbol_9" value="9" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_9_ket.jpg" width="20px" height="20px">&nbsp;Alis mata rontok (Madarosis)</td>
						<td><input type="radio" name="simbol" id="simbol_10" value="10" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_10_ket.jpg" width="20px" height="20px">&nbsp;Hidung pelana (Penyok)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_11" value="11" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_11_ket.jpg" width="20px" height="20px">&nbsp;Kontraktur</td>
						<td colspan="2"><input type="radio" name="simbol" id="simbol_12" value="12" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_12_ket.jpg" width="20px" height="20px">&nbsp;Hilangnya jari-jari atau bagian dari anggota gerak (Mutilasi)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_13" value="13" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_13_ket.jpg" width="20px" height="20px">&nbsp;Atrophy otot</td>
						<td><input type="radio" name="simbol" id="simbol_14" value="14" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_14_ket.jpg" width="20px" height="20px">&nbsp;Ulkus Trophis</td>
						<td><input type="radio" name="simbol" id="simbol_15" value="15" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_15_ket.jpg" width="20px" height="20px">&nbsp;Drop foot, Wrist drop</td>
					</tr>
					<tr>
						<td colspan="2"><input type="radio" name="simbol" id="simbol_16" value="16" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_16_ket.jpg" width="20px" height="20px">&nbsp;Pembesaran buah dada pada penderita laki-laki (Ginaccomasti)</td>
						<td><input type="radio" name="simbol" id="simbol_17" value="17" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_17_ket.jpg" width="20px" height="20px">&nbsp;Perut bekas infiltrat (sigaret paper) yang tidak aktif lagi</td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_18" value="18" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_18_ket.jpg" width="20px" height="20px">&nbsp;Pembesaran Testis</td>
						<td><input type="radio" name="simbol" id="simbol_19" value="19" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_19_ket.jpg" width="20px" height="20px">&nbsp;Logof talmus</td>
						<td><input type="radio" name="simbol" id="simbol_20" value="20" checked />&nbsp;Bebas</td>
					</tr>
				</table>
				<br/>
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Catatan</td>
			<td valign="top">:</td>
			<td colspan="5" align="center"><textarea name="catatan_perubahan_kulit_saraf" id="catatan_perubahan_kulit_saraf" class="text_dt11" style="height:200px;width:896px;"><?php echo $catatan_perubahan_kulit_saraf; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
		<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID'] and $irja_final == ''){ ?>
		<td colspan="8" align="right" ><input type="button" value="simpan" class="myButton1" onclick="simpan();" />
		<?php } ?>
		</td>
        </tr>
    </table>
</form>
<script>
<?php if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
	or $pegawai_id != $_SESSION['SES_SIMRS_PEGAWAI_ID'] ){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>
const canvas = document.querySelector('canvas');
var context = canvas.getContext('2d'); 
var cPushArray = new Array();
var cStep = -1;

var img1 = new Image();
img1.src = "edoc_rekammedik/new/kusta/kusta_1.png";

var img2 = new Image();
img2.src = "edoc_rekammedik/new/kusta/kusta_2.png";

var img3 = new Image();
img3.src = "edoc_rekammedik/new/kusta/kusta_3.png";

var img4 = new Image();
img4.src = "edoc_rekammedik/new/kusta/kusta_4.png";

var img5 = new Image();
img5.src = "edoc_rekammedik/new/kusta/kusta_5.png";

var img6 = new Image();
img6.src = "edoc_rekammedik/new/kusta/kusta_6.png";

var img7 = new Image();
img7.src = "edoc_rekammedik/new/kusta/kusta_7.png";

var img8 = new Image();
img8.src = "edoc_rekammedik/new/kusta/kusta_8.png";

var img9 = new Image();
img9.src = "edoc_rekammedik/new/kusta/kusta_9.png";

var img10 = new Image();
img10.src = "edoc_rekammedik/new/kusta/kusta_10.png";

var img11 = new Image();
img11.src = "edoc_rekammedik/new/kusta/kusta_11.png";

var img12 = new Image();
img12.src = "edoc_rekammedik/new/kusta/kusta_12.png";

var img13 = new Image();
img13.src = "edoc_rekammedik/new/kusta/kusta_13.png";

var img14 = new Image();
img14.src = "edoc_rekammedik/new/kusta/kusta_14.png";

var img15 = new Image();
img15.src = "edoc_rekammedik/new/kusta/kusta_15.png";

var img16 = new Image();
img16.src = "edoc_rekammedik/new/kusta/kusta_16.png";

var img17 = new Image();
img17.src = "edoc_rekammedik/new/kusta/kusta_17.png";

var img18 = new Image();
img18.src = "edoc_rekammedik/new/kusta/kusta_18.png";

var img19 = new Image();
img19.src = "edoc_rekammedik/new/kusta/kusta_19.png";

function clearCanvas(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context.drawImage(img_ori,0,0); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pengkajian_awal_medis_kusta_perubahan_kulit_d_urat_saraf.jpg";
		cPush();
	}	
}

function cPush() {
    cStep++;
	if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(canvas.toDataURL());
}

function undoCanvas(){
	if (cStep > 0) {
        cStep--;
		var canvasPic = new Image();
		canvasPic.onload = function(){
			context.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray[cStep - 1];
    }
}	

function load(){
	canvas.width = 896; 
	canvas.height = 731; 
	
	var img_def = new Image();
	img_def.onload = function(){
		context.drawImage(img_def,0,0); // Or at whatever offset you like
	};
	<?php if(trim($tanda_perubahan_kulit_saraf) != '') { ?>
		img_def.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pengkajian_awal_medik_kusta/<?php echo $tanda_perubahan_kulit_saraf; ?>';
	<?php }else{ ?>	
		img_def.src = 'edoc_rekammedik/new/pengkajian_awal_medis_kusta_perubahan_kulit_d_urat_saraf.jpg';
	<?php } ?>
}

function simpan(){
	_haschange = false;
	
	var image = canvas.toDataURL("image/jpg");	
	var xcatatan = $('#catatan_perubahan_kulit_saraf').val();
	var vcatatan = xcatatan.replace('"', "'");
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=klinikaddperubahankulitsaraf',
			data: { img: image,
				idx : '<?php echo $idx; ?>',
				irja_id : '<?php echo $irja_id; ?>',
				nomr : '<?php echo $nomr; ?>',
				catatan : vcatatan,
				xfinal : $('#ls_final').val(),
				xassesment : $('#ls_assesment').val(),
				skr : $('#tgl_skr').val()
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){
					alert(data);
					window.location = "<?php echo currentURl(); ?>";	
				}	
				
			},});	
}

function setGambar(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
	
    if(cStep < 0){
		cPush();
	}	
	
	if (document.getElementById('simbol_1').checked){
		context.drawImage(img1,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_2').checked){
		context.drawImage(img2,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_3').checked){
		context.drawImage(img3,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_4').checked){
		context.drawImage(img4,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_5').checked){
		context.drawImage(img5,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_6').checked){
		context.drawImage(img6,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_7').checked){
		context.drawImage(img7,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_8').checked){
		context.drawImage(img8,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_8').checked){
		context.drawImage(img8,x-10,y-10,30,30);
	}
	if (document.getElementById('simbol_9').checked){
		context.drawImage(img9,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_10').checked){
		context.drawImage(img10,x-10,y-10,30,30);
	}
	if (document.getElementById('simbol_11').checked){
		context.drawImage(img11,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_12').checked){
		context.drawImage(img12,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_13').checked){
		context.drawImage(img13,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_14').checked){
		context.drawImage(img14,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_15').checked){
		context.drawImage(img15,x-10,y-10,35,35);
	}
	if (document.getElementById('simbol_16').checked){
		context.drawImage(img16,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_17').checked){
		context.drawImage(img17,x-10,y-10,35,35);
	}
	if (document.getElementById('simbol_18').checked){
		context.drawImage(img18,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_19').checked){
		context.drawImage(img19,x-10,y-10,50,50);
	}	
	cPush();
}

function Draw(x, y, isDown) {
    if (isDown) {
        context.beginPath();
        context.strokeStyle = 'red';
        context.lineWidth = 3;
        context.lineJoin = "round";
        context.moveTo(lastX, lastY);
        context.lineTo(x, y);
        context.closePath();
        context.stroke();
    }
    lastX = x;
    lastY = y;
}

canvas.addEventListener('mousedown', function(e) {
	if (document.getElementById('simbol_20').checked){
		mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    }else{
		setGambar(canvas, e)
	}	
})

canvas.addEventListener('mousemove', function(e) {
	if (mousePressed) {
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }	
})

canvas.addEventListener('mouseup', function(e) {
	if (mousePressed) {
        mousePressed = false;
        cPush();
    }	
})

canvas.addEventListener('mouseleave', function(e) {
	if (mousePressed) {
		mousePressed = false;
        cPush();
	}	
})

load();
</script>