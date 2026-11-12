<?php 
$irna_id = $_GET['idx'];
if (isset($_GET['idc']))
    include('askep/askep_del_add_pelaporan_eso_obat.php');
if (isset($_POST['irna_id'])) 
	include('askep/askep_save_pelaporan_eso.php');

$qry_askep = 'SELECT PELAPORAN_ESO_ID,PENYAKIT_UTAMA,KESUDAHAN_PENYAKIT_UTAMA,PENYAKIT_LAIN_MENYERTAI,
			DATE_FORMAT(TANGGAL_MULAI_TERJADI,"%d/%m/%Y") AS TANGGAL_MULAI_TERJADI,
			DATE_FORMAT(TANGGAL_KESUDAHAN_ESO,"%d/%m/%Y") AS TANGGAL_KESUDAHAN_ESO,
			BENTUK_ESO,DATA_LABORATORIUM,KESUDAHAN_ESO,REAKSI_ESO,TINDAKAN,REAKSI_HILANG,REAKSI_TIMBUL,
			ALGHORITMA_NARANJO,PERAWAT,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL
			FROM t_irna_askep_pelaporan_eso
			WHERE PELAPORAN_ESO_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$pelaporan_eso_id = $dat_askep['PELAPORAN_ESO_ID'];
$penyakit_utama = $dat_askep['PENYAKIT_UTAMA'];
$kesudahan_penyakit_utama = $dat_askep['KESUDAHAN_PENYAKIT_UTAMA'];
$penyakit_lain_menyertai = $dat_askep['PENYAKIT_LAIN_MENYERTAI'];
$tanggal_mulai_terjadi = $dat_askep['TANGGAL_MULAI_TERJADI'];
$bentuk_eso = $dat_askep['BENTUK_ESO'];
$data_laboratorium = $dat_askep['DATA_LABORATORIUM'];
$kesudahan_eso = $dat_askep['KESUDAHAN_ESO'];
$tanggal_kesudahan_eso = $dat_askep['TANGGAL_KESUDAHAN_ESO'];
$reaksi_eso = $dat_askep['REAKSI_ESO'];
$tindakan = $dat_askep['TINDAKAN'];
$reaksi_hilang = $dat_askep['REAKSI_HILANG'];
$reaksi_timbul = $dat_askep['REAKSI_TIMBUL'];
$alghoritma_naranjo = $dat_askep['ALGHORITMA_NARANJO'];
$tanggal = $dat_askep['TANGGAL'];
$perawat = $dat_askep['PERAWAT'];

$arr_penyakit_lain_menyertai = explode('|',$penyakit_lain_menyertai);
$arr_alghoritma_naranjo = explode('|',$alghoritma_naranjo);

$eso_obat_id ='';
$nama_obat ='';
$bentuk_sediaan ='';
$nomor_batch ='';
$obat_dicurigai ='';
$cara_pemberian ='';
$tanggal_akhir_pemberian ='';
$indikasi_penggunaan ='';

if(isset($_GET['idce'])){
$sql_ubah = 'SELECT ESO_OBAT_ID,PELAPORAN_ESO_ID,KODE_OBAT,NAMA_OBAT,
			BENTUK_SEDIAAN,NOMOR_BATCH,OBAT_DICURIGAI,CARA_PEMBERIAN,
			DATE_FORMAT(TANGGAL_AKHIR_PEMBERIAN,"%d/%m/%Y") AS TANGGAL_AKHIR_PEMBERIAN,
			INDIKASI_PENGGUNAAN
			FROM t_irna_askep_pelaporan_eso_obat
			WHERE ESO_OBAT_ID = "' . $_GET['idce'] . '"';
$get_ubah = mysql_query($sql_ubah) or die(mysql_error());		
$dat_ubah = mysql_fetch_assoc($get_ubah);						
$eso_obat_id = $dat_ubah['ESO_OBAT_ID'];
$nama_obat = $dat_ubah['NAMA_OBAT'];
$bentuk_sediaan = $dat_ubah['BENTUK_SEDIAAN'];
$nomor_batch = $dat_ubah['NOMOR_BATCH'];
$obat_dicurigai = $dat_ubah['OBAT_DICURIGAI'];
$cara_pemberian = $dat_ubah['CARA_PEMBERIAN'];
$tanggal_akhir_pemberian = $dat_ubah['TANGGAL_AKHIR_PEMBERIAN'];
$indikasi_penggunaan = $dat_ubah['INDIKASI_PENGGUNAAN'];
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("#obat").autocomplete("index.php?autocomp=autocompaskepfarmasi",{width: 450});
});
	
function get_satuan(resep){
	$.ajax({
		type: 'GET',
		url: 'index.php?ajaxrequest=kliniksatuanresep&resep=' + resep,
		data: {x : 'x'},
		async: false,
		cache: false,
		success: function(data) {					
			$('#satuan').val(data);	
	},});
}	
</script>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="pelaporan_eso_id" id="pelaporan_eso_id" value="<?php echo $pelaporan_eso_id; ?>" />
<table border="0" width="100%">
<tr>
	<td colspan="3">PASIEN</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Penyakit Utama</td>
	<td><textarea name="penyakit_utama" id="penyakit_utama" class="text_dt2"><?php echo $penyakit_utama; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Kesudahan Penyakit Utama</td>
	<td>
		<input type="radio" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="1" <?php if($kesudahan_penyakit_utama=='1') echo 'checked="checked"'; ?> />&nbsp;Sembuh
		<input type="radio" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="2" <?php if($kesudahan_penyakit_utama=='2') echo 'checked="checked"'; ?> />&nbsp;Meninggal
		<input type="radio" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="3" <?php if($kesudahan_penyakit_utama=='3') echo 'checked="checked"'; ?> />&nbsp;Sembuh dengan gejala sisa
		<input type="radio" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="4" <?php if($kesudahan_penyakit_utama=='4') echo 'checked="checked"'; ?> />&nbsp;Belum sembuh
		<input type="radio" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="5" <?php if($kesudahan_penyakit_utama=='5') echo 'checked="checked"'; ?> />&nbsp;Tidak tahu
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Penyakit/ kondisi lain yang menyertai</td>
	<td>
		<input type="checkbox" name="penyakit_lain_menyertai_1" id="penyakit_lain_menyertai_1" value="1" <?php if(isset($arr_penyakit_lain_menyertai[0]) and $arr_penyakit_lain_menyertai[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Gangguan ginjal
		<input type="checkbox" name="penyakit_lain_menyertai_2" id="penyakit_lain_menyertai_2" value="1" <?php if(isset($arr_penyakit_lain_menyertai[1]) and $arr_penyakit_lain_menyertai[1]=='1') echo 'checked="checked"'; ?> />&nbsp;Gangguan hati
		<input type="checkbox" name="penyakit_lain_menyertai_3" id="penyakit_lain_menyertai_3" value="1" <?php if(isset($arr_penyakit_lain_menyertai[2]) and $arr_penyakit_lain_menyertai[2]=='1') echo 'checked="checked"'; ?> />&nbsp;Alergi
		<input type="checkbox" name="penyakit_lain_menyertai_4" id="penyakit_lain_menyertai_4" value="1" <?php if(isset($arr_penyakit_lain_menyertai[3]) and $arr_penyakit_lain_menyertai[3]=='1') echo 'checked="checked"'; ?> />&nbsp;Kondisi medis lainnya
		<input type="checkbox" name="penyakit_lain_menyertai_5" id="penyakit_lain_menyertai_5" value="1" <?php if(isset($arr_penyakit_lain_menyertai[4]) and $arr_penyakit_lain_menyertai[4]=='1') echo 'checked="checked"'; ?> />&nbsp;Faktor industri, pertanian, kimia<br />
		<input type="checkbox" name="penyakit_lain_menyertai_6" id="penyakit_lain_menyertai_6" value="1" <?php if(isset($arr_penyakit_lain_menyertai[5]) and $arr_penyakit_lain_menyertai[5]=='1') echo 'checked="checked"'; ?> />&nbsp;Lain-lain
		<input type="text" name="penyakit_lain_menyertai_7" id="penyakit_lain_menyertai_7" value="<?php if(isset($arr_penyakit_lain_menyertai[5])) echo $arr_penyakit_lain_menyertai[5]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">EFEK SAMPING OBAT (ESO)</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>Saat/ tanggal mulai terjadi</td>
	<td><input type="text" name="tanggal_mulai_terjadi" id="tgl_edu_1" value="<?php echo $tanggal_mulai_terjadi; ?>" class="text_dt" /><img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Bentuk/ manifesto E.S.O yang terjadi</td>
	<td><textarea name="bentuk_eso" id="bentuk_eso" class="text_dt2"><?php echo $bentuk_eso; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Data laboratorium (jika ada)</td>
	<td><textarea name="data_laboratorium" id="data_laboratorium" class="text_dt2"><?php echo $data_laboratorium; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Kesudahan E.S.O</td>
	<td><input type="text" name="tanggal_kesudahan_eso" id="tgl_edu_2" value="<?php echo $tanggal_kesudahan_eso; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
	<input type="radio" name="kesudahan_eso" id="kesudahan_eso" value="1" <?php if($kesudahan_eso=='1') echo 'checked="checked"'; ?> />&nbsp;Sembuh
	<input type="radio" name="kesudahan_eso" id="kesudahan_eso" value="2" <?php if($kesudahan_eso=='2') echo 'checked="checked"'; ?> />&nbsp;Meninggal
	<input type="radio" name="kesudahan_eso" id="kesudahan_eso" value="3" <?php if($kesudahan_eso=='3') echo 'checked="checked"'; ?> />&nbsp;Sembuh dengan gejala sisa
	<input type="radio" name="kesudahan_eso" id="kesudahan_eso" value="4" <?php if($kesudahan_eso=='4') echo 'checked="checked"'; ?> />&nbsp;Belum sembuh
	<input type="radio" name="kesudahan_eso" id="kesudahan_eso" value="5" <?php if($kesudahan_eso=='5') echo 'checked="checked"'; ?> />&nbsp;Tidak tahu
	</td>
</tr>
<tr>	
	<td>&nbsp;</td>
    <td>Reaksi E.S.O yang pernah dialami</td>
	<td><textarea name="reaksi_eso" id="reaksi_eso" class="text_dt2"><?php echo $reaksi_eso; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tindakan yang telah dilakukan untuk mengatasi reaksi E.S.O</td>
	<td><textarea name="tindakan" id="tindakan" class="text_dt2"><?php echo $tindakan; ?></textarea></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">OBAT</td>
</tr>
<tr>
	<td colspan="3">
		<table width="100%" class="tableData">
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Nama Obat Yang Diberikan<br />(nama dagang/ pabrik)</th>
				<th rowspan="2">Bentuk Sediaan</th>
				<th rowspan="2">Nomor Batch</th>
				<th rowspan="2">Obat Yang<br />Dicurigai</th>
				<th colspan="2">Pemberian</th>
				<th rowspan="2">Indikasi Penggunaan</th>
				<th rowspan="2">Option</th>
			</tr>
			<tr>
			  <th>Cara</th>
			  <th>Tgl. Akhir</th>
			</tr>
			<?php
				$sql_obat = 'SELECT ESO_OBAT_ID,PELAPORAN_ESO_ID,KODE_OBAT,NAMA_OBAT,BENTUK_SEDIAAN,NOMOR_BATCH,OBAT_DICURIGAI,
							CARA_PEMBERIAN,TANGGAL_AKHIR_PEMBERIAN,INDIKASI_PENGGUNAAN
							FROM t_irna_askep_pelaporan_eso_obat
							WHERE PELAPORAN_ESO_ID = "' . $irna_id . '"';
				$get_obat = mysql_query($sql_obat) or die(mysql_error());
				$i = 1;
				while($dat_obat = mysql_fetch_array($get_obat)){	
			?>
				<tr>
				<td align="center"><?php echo $i; ?></td>
				<td><?php echo $dat_obat['NAMA_OBAT']; ?></td>
				<td><?php echo $dat_obat['BENTUK_SEDIAAN']; ?></td>
				<td><?php echo $dat_obat['NOMOR_BATCH']; ?></td>
				<td align="center"><?php if($dat_obat['OBAT_DICURIGAI'] == '1') echo '&radic;'; ?></td>
				<td><?php echo $dat_obat['CARA_PEMBERIAN']; ?></td>
				<td><?php echo $dat_obat['TANGGAL_AKHIR_PEMBERIAN']; ?></td>
				<td><?php echo $dat_obat['INDIKASI_PENGGUNAAN']; ?></td>
				<td width="75px">
				<a href="<?php echo currentUrl(); ?>&idce=<?php echo $dat_obat['ESO_OBAT_ID']; ?>&nmce=<?php echo $dat_obat['NAMA_OBAT']; ?>" >ubah</a>
				<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_obat['ESO_OBAT_ID']; ?>&nmc=<?php echo $dat_obat['NAMA_OBAT']; ?>" >hapus</a>
				</td>
				</tr>
			<?php
				$i++; }
			?>
			<tr>
				<td colspan="2">
				<input type="hidden" name="eso_obat_id" value="<?php echo $eso_obat_id; ?>" />
				<input type="text" name="nama_obat" id="obat" value="<?php echo $nama_obat; ?>" class="text_dt" style="width:200px;" onblur="get_satuan(this.value); return false;" /></td>
				<td><input type="text" name="bentuk_sediaan" id="satuan" value="<?php echo $bentuk_sediaan; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="nomor_batch" value="<?php echo $nomor_batch; ?>" class="text_dt" style="width:100px;" /></td>
				<td align="center"><input type="checkbox" name="obat_dicurigai" value="1" <?php if($obat_dicurigai == '1') echo 'checked="checked"'; ?> /></td>
				<td><input type="text" name="cara_pemberian" value="<?php echo $cara_pemberian; ?>" class="text_dt" style="width:200px;" /></td>
				<td><input type="text" name="tanggal_akhir_pemberian" id="tgl_edu_4" value="<?php echo $tanggal_akhir_pemberian; ?>" class="text_dt" style="width:70px;" />
				<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
				<td colspan="2"><input type="text" name="indikasi_penggunaan" value="<?php echo $indikasi_penggunaan; ?>" class="text_dt" style="width:200px;" /></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Apakah reaksi E.S.O hilang setelah obat dihentikan</td>
	<td>
		<input type="radio" name="reaksi_hilang" id="reaksi_hilang" value="1" <?php if($reaksi_hilang=='1') echo 'checked="checked"'; ?> />&nbsp;Ya
		<input type="radio" name="reaksi_hilang" id="reaksi_hilang" value="2" <?php if($reaksi_hilang=='2') echo 'checked="checked"'; ?> />&nbsp;Tidak
		<input type="radio" name="reaksi_hilang" id="reaksi_hilang" value="3" <?php if($reaksi_hilang=='3') echo 'checked="checked"'; ?> />&nbsp;Tidak tahu
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Apakah reaksi E.S.O yang sama timbul sewaktu obat<br />yang dicurigai digunakan kembali</td>
	<td>
		<input type="radio" name="reaksi_timbul" id="reaksi_timbul" value="1" <?php if($reaksi_timbul=='1') echo 'checked="checked"'; ?> />&nbsp;Ya
		<input type="radio" name="reaksi_timbul" id="reaksi_timbul" value="2" <?php if($reaksi_timbul=='2') echo 'checked="checked"'; ?> />&nbsp;Tidak
		<input type="radio" name="reaksi_timbul" id="reaksi_timbul" value="3" <?php if($reaksi_timbul=='3') echo 'checked="checked"'; ?> />&nbsp;Tidak tahu
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">ALGORITMA NARANJO</td>
</tr>
<tr>
	<td colspan="3">
	<table class="tableData">
	<tr>
		<th width="40px">No</th>
		<th>Pertanyaan</th>
		<th width="100px">Ya</th>
		<th width="100px">Tidak</th>
		<th width="100px">Tidak<br />Diketahui</th>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Apakah ada laporan efek samping obat yang serupa ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="1" <?php if(isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='1') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="2" <?php if(isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='2') echo 'checked="checked"'; ?> />&nbsp;0</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="3" <?php if(isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Apakah ada laporan efek samping obat yang serupa yang dicurigai ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="1" <?php if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='1') echo 'checked="checked"'; ?> />&nbsp;2</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="2" <?php if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='2') echo 'checked="checked"'; ?> />&nbsp;-1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="3" <?php if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">3</td>
		<td>Apakah efek samping obat membaik setelah obat dihentikan atau obat antagonis khusus diberikan ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="1" <?php if(isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='1') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="2" <?php if(isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='2') echo 'checked="checked"'; ?> />&nbsp;0</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="3" <?php if(isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">4</td>
		<td>Apakah efek samping terjadi berulang setelah obat diberikan kembali ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="1" <?php if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='1') echo 'checked="checked"'; ?> />&nbsp;2</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="2" <?php if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='2') echo 'checked="checked"'; ?> />&nbsp;-1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="3" <?php if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">5</td>
		<td>Apakah ada alternatif penyebab yang dapat menjelaskan yang kemungkinan terjadi efek samping obat ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="1" <?php if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='1') echo 'checked="checked"'; ?> />&nbsp;-1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="2" <?php if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='2') echo 'checked="checked"'; ?> />&nbsp;2</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="3" <?php if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">6</td>
		<td>Apakah efek samping obat muncul kembali ketika pasebo diberikan ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="1" <?php if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='1') echo 'checked="checked"'; ?> />&nbsp;-1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="2" <?php if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='2') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="3" <?php if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">7</td>
		<td>Apakah obat yang dicurigai terdeteksi di dalam darah atau cairan tubuh lainnya dengan konsentrasi yang toksit ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="1" <?php if(isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='1') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="2" <?php if(isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='2') echo 'checked="checked"'; ?> />&nbsp;0</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="3" <?php if(isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">8</td>
		<td>Apakah efek samping obat bertambah parah ketika dosis obat ditingkatkan atau bertambah ringan ketika obat diturunkan dosisnya ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="1" <?php if(isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='1') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="2" <?php if(isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='2') echo 'checked="checked"'; ?> />&nbsp;0</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="3" <?php if(isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">9</td>
		<td>Apakah pasien pernah mengalami efek samping obat yang sama atau obat yang mirip sebelumnya ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="1" <?php if(isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='1') echo 'checked="checked"'; ?> />&nbsp;1</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="2" <?php if(isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='2') echo 'checked="checked"'; ?> />&nbsp;0</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="3" <?php if(isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='3') echo 'checked="checked"'; ?> />&nbsp;0</td>
	</tr>
	<tr>
		<td align="center">10</td>
		<td>Apakah efek samping obat bisa dikonfirmasikan dengan bukti yang objektif ?</td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="1" <?php if(isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='1') echo 'checked="checked"'; ?> /></td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="2" <?php if(isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='2') echo 'checked="checked"'; ?> /></td>
		<td align="center"><input type="radio" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="3" <?php if(isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='3') echo 'checked="checked"'; ?> /></td>
	</tr>
<?php
$total_skor = 0;
if(isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='1') $total_skor = $total_skor + 1;

if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='1') $total_skor = $total_skor + 2;
if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='2') $total_skor = $total_skor - 1;

if(isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='1') $total_skor = $total_skor + 1;

if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='1') $total_skor = $total_skor + 2;
if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='2') $total_skor = $total_skor - 1;

if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='1') $total_skor = $total_skor - 1;
if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='2') $total_skor = $total_skor + 2;

if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='1') $total_skor = $total_skor - 1;
if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='2') $total_skor = $total_skor + 1;

if(isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='1') $total_skor = $total_skor + 1;
if(isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='1') $total_skor = $total_skor + 1;
if(isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='1') $total_skor = $total_skor + 1;
?>	
	<tr>
		<td align="center" colspan="2">Total Skor</td>
		<td align="center" colspan="3"><?php echo $total_skor; ?></td>
	</tr>
	</table>
	</td>
</tr>
</table>
<table border="0" width="100%">
<tr>
	<td>&nbsp;</td>
    <td width="260px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal</td><td><input type="text" name="tanggal" id="tgl_edu_3" value="<?php echo $tanggal; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Perawat</td>
	<td><select name="perawat" id="perawat" class="text_dt">
		<option> - </option>
		<?php if(empty($perawat)) $perawat = $_SESSION["SES_SIMRS_PEGAWAI_ID"]; 
		echo getPerawat($perawat); ?>
		</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td align="right"><input type="submit" value="simpan" class="myButton" /></td>
</tr>		
</table>
</form> 