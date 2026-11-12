<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	$kondisi_pasien = array('kp_kesadaran'=>((isset($_POST['kp_kesadaran'])) ? $_POST['kp_kesadaran'] : ''),
				'kp_gcs_e'=>replace_quote($_POST['kp_gcs_e']),
				'kp_gcs_m'=>replace_quote($_POST['kp_gcs_m']),
				'kp_gcs_v'=>replace_quote($_POST['kp_gcs_v']),
				'kp_td'=>replace_quote($_POST['kp_td']),
				'kp_nadi'=>replace_quote($_POST['kp_nadi']),
				'kp_nafas'=>replace_quote($_POST['kp_nafas']),
				'kp_suhu'=>replace_quote($_POST['kp_suhu']),
				'kp_oksigen'=>replace_quote($_POST['kp_oksigen']),
				'kp_cairan'=>replace_quote($_POST['kp_cairan']),
				'kp_transfusi'=>replace_quote($_POST['kp_transfusi']),
				'kp_cateter'=>replace_quote($_POST['kp_cateter']),
				'kp_cateter_ke'=>replace_quote($_POST['kp_cateter_ke']),
				'kp_cateter_tgl'=>replace_quote($_POST['kp_cateter_tgl']),
				'kp_cateter_pkl'=>replace_quote($_POST['kp_cateter_pkl']));
	$kondisi_pasien = json_encode($kondisi_pasien);			
	$kondisi_pasien = str_replace('"','|',$kondisi_pasien);
	
	$kondisi_pasien_selama_transfer = array('kpst_kesadaran'=>((isset($_POST['kpst_kesadaran'])) ? $_POST['kpst_kesadaran'] : ''),
				'kpst_gcs_e'=>replace_quote($_POST['kpst_gcs_e']),
				'kpst_gcs_m'=>replace_quote($_POST['kpst_gcs_m']),
				'kpst_gcs_v'=>replace_quote($_POST['kpst_gcs_v']),
				'kpst_td'=>replace_quote($_POST['kpst_td']),
				'kpst_nadi'=>replace_quote($_POST['kpst_nadi']),
				'kpst_nafas'=>replace_quote($_POST['kpst_nafas']),
				'kpst_suhu'=>replace_quote($_POST['kpst_suhu']));	
	$kondisi_pasien_selama_transfer = json_encode($kondisi_pasien_selama_transfer);	
	$kondisi_pasien_selama_transfer = str_replace('"','|',$kondisi_pasien_selama_transfer);	
	
	
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_transfer_pasien (IRJA_TRANSFER_ID,INTERNAL_EKSTERNAL,PENERIMA,UNIT_PENERIMA,
				ALAMAT,TELEPON,ALASAN_MASUK,
				ALASAN_TRANSFER,KETERANGAN,INPUS,OBAT,TINDAKAN,KONDISI_PASIEN,DIET,MOBILISASI,EDUKASI,CARA_TRANSPORTASI,
				KONDISI_PASIEN_SELAMA_TRANSFER,HASIL_LABORATORIUM,HASIL_RADIOLOGI,HASIL_PENUNJANG,OBAT_PARENTERAL,OBAT_ORAL,
				BARANG_LAIN,TGL_ASSESMENT,REGISTER,KONTAK) 
				VALUES ("' . $_POST['irja_id'] . '","I","' . $_POST['penerima'] . '","' . $_POST['unit_penerima'] . '",
				"' . replace_quote($_POST['alamat']) . '","' . $_POST['telepon'] . '",
				"' . replace_quote($_POST['alasan_masuk']) . '",
				"' . ((isset($_POST['alasan_transfer'])) ? $_POST['alasan_transfer'] : '') . '",
				"' . replace_quote($_POST['keterangan']) . '","' . replace_quote($_POST['inpus']) . '",
				"' . replace_quote($_POST['obat']) . '","' . replace_quote($_POST['tindakan']) . '",
				"' . $kondisi_pasien . '","' . replace_quote($_POST['diet']) . '",
				"' . replace_quote($_POST['mobilisasi']) . '","' . replace_quote($_POST['edukasi']) . '",
				"' . ((isset($_POST['cara_transportasi'])) ? $_POST['cara_transportasi'] : '') . '",
				"' . $kondisi_pasien_selama_transfer . '","' . replace_quote($_POST['hasil_laboratorium']) . '",
				"' . replace_quote($_POST['hasil_radiologi']) . '","' . replace_quote($_POST['hasil_penunjang']) . '",
				"' . replace_quote($_POST['obat_parenteral']) . '","' . replace_quote($_POST['obat_oral']) . '",
				"' . replace_quote($_POST['barang_lain']) . '",NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . $_POST['kontak'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_transfer_pasien 
				SET PENERIMA = "' . $_POST['penerima'] . '",
				UNIT_PENERIMA = "' . $_POST['unit_penerima'] . '",
				ALAMAT = "' . replace_quote($_POST['alamat']) . '",
				TELEPON = "' . $_POST['telepon'] . '",
				ALASAN_MASUK = "' . replace_quote($_POST['alasan_masuk']) . '",
				ALASAN_TRANSFER = "' . ((isset($_POST['alasan_transfer'])) ? $_POST['alasan_transfer'] : '') . '",
				KETERANGAN = "' . replace_quote($_POST['keterangan']) . '",
				INPUS = "' . replace_quote($_POST['inpus']) . '",
				OBAT = "' . replace_quote($_POST['obat']) . '",
				TINDAKAN = "' . replace_quote($_POST['tindakan']) . '",
				KONDISI_PASIEN = "' . $kondisi_pasien . '",
				DIET = "' . replace_quote($_POST['diet']) . '",
				MOBILISASI = "' . replace_quote($_POST['mobilisasi']) . '",
				EDUKASI = "' . replace_quote($_POST['edukasi']) . '",
				CARA_TRANSPORTASI = "' . ((isset($_POST['cara_transportasi'])) ? $_POST['cara_transportasi'] : '') . '",
				KONDISI_PASIEN_SELAMA_TRANSFER = "' . $kondisi_pasien_selama_transfer . '",
				HASIL_LABORATORIUM = "' . replace_quote($_POST['hasil_laboratorium']) . '",
				HASIL_RADIOLOGI = "' . replace_quote($_POST['hasil_radiologi']) . '",
				HASIL_PENUNJANG = "' . replace_quote($_POST['hasil_penunjang']) . '",
				OBAT_PARENTERAL = "' . replace_quote($_POST['obat_parenteral']) . '",
				OBAT_ORAL = "' . replace_quote($_POST['obat_oral']) . '",
				BARANG_LAIN = "' . replace_quote($_POST['barang_lain']) . '",
				KONTAK = "' . $_POST['kontak'] . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_TRANSFER_ID = "' . $_POST['irja_id'] . '"
				AND INTERNAL_EKSTERNAL = "I"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Transfer Internal Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_TRANSFER_ID,PENERIMA,UNIT_PENERIMA,ALAMAT,TELEPON,ALASAN_MASUK,ALASAN_TRANSFER,
			KETERANGAN,INPUS,OBAT,TINDAKAN,KONDISI_PASIEN,DIET,MOBILISASI,EDUKASI,CARA_TRANSPORTASI,
			KONDISI_PASIEN_SELAMA_TRANSFER,HASIL_LABORATORIUM,HASIL_RADIOLOGI,HASIL_PENUNJANG,OBAT_PARENTERAL,
			OBAT_ORAL,BARANG_LAIN,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			REGISTER,KONTAK
			FROM t_irja_transfer_pasien
			WHERE IRJA_TRANSFER_ID = "' . $_GET['idx'] . '"
			AND INTERNAL_EKSTERNAL = "I"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_TRANSFER_ID'];
$penerima = $dat_pasien['PENERIMA'];
$unit_penerima = $dat_pasien['UNIT_PENERIMA'];
$alamat = $dat_pasien['ALAMAT'];
$telepon = $dat_pasien['TELEPON'];
$kontak = $dat_pasien['KONTAK'];
$alasan_masuk = $dat_pasien['ALASAN_MASUK'];
$alasan_transfer = $dat_pasien['ALASAN_TRANSFER'];
$keterangan = $dat_pasien['KETERANGAN'];
$inpus = $dat_pasien['INPUS'];
$obat = $dat_pasien['OBAT'];
$tindakan = $dat_pasien['TINDAKAN'];

$kondisi_pasien = str_replace('|','"',$dat_pasien['KONDISI_PASIEN']);
$kondisi_pasien = preg_replace('/\r|\n/','\n',trim($kondisi_pasien));
$kondisi_pasien = json_decode($kondisi_pasien,true);

$diet = $dat_pasien['DIET'];
$mobilisasi = $dat_pasien['MOBILISASI'];
$edukasi = $dat_pasien['EDUKASI'];
$cara_transportasi = $dat_pasien['CARA_TRANSPORTASI'];

$kondisi_pasien_selama_transfer = str_replace('|','"',$dat_pasien['KONDISI_PASIEN_SELAMA_TRANSFER']);
$kondisi_pasien_selama_transfer = preg_replace('/\r|\n/','\n',trim($kondisi_pasien_selama_transfer));
$kondisi_pasien_selama_transfer = json_decode($kondisi_pasien_selama_transfer,true);

$hasil_laboratorium = $dat_pasien['HASIL_LABORATORIUM'];
$hasil_radiologi = $dat_pasien['HASIL_RADIOLOGI'];
$hasil_penunjang = $dat_pasien['HASIL_PENUNJANG'];
$obat_parenteral = $dat_pasien['OBAT_PARENTERAL'];
$obat_oral = $dat_pasien['OBAT_ORAL'];
$barang_lain = $dat_pasien['BARANG_LAIN'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $_GET['idx'] . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$d=0;
$diagnosa = array();
while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
	$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
$d++;
}
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">PENERIMA</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Nama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="penerima" value="<?php echo $penerima; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Di Unit</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="unit_penerima" value="<?php echo $unit_penerima; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alamat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alamat" class="text_dt10" ><?php echo $alamat; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Telepon</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="telepon" value="<?php echo $telepon; ?>" class="text_dt" style="width:228px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Kontak Person</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="kontak" value="<?php echo $kontak; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Alasan Masuk RS</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alasan_masuk" class="text_dt10" ><?php echo $alasan_masuk; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Alasan Transfer</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="radio" name="alasan_transfer" value="1" <?php if($alasan_transfer == '1') echo 'checked'; ?> />&nbsp;Perlu Fasilitas lebih baik&nbsp;&nbsp;&nbsp;
					<input type="radio" name="alasan_transfer" value="2" <?php if($alasan_transfer == '2') echo 'checked'; ?> />&nbsp;Permintaan sendiri&nbsp;&nbsp;&nbsp;
					<input type="radio" name="alasan_transfer" value="3" <?php if($alasan_transfer == '3') echo 'checked'; ?> />&nbsp;Perlu perawatan lebih baik&nbsp;&nbsp;&nbsp;
					<input type="radio" name="alasan_transfer" value="4" <?php if($alasan_transfer == '4') echo 'checked'; ?> />&nbsp;Perlu perawatan di ruang intensif
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Keterangan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="keterangan" class="text_dt10" ><?php echo $keterangan; ?></textarea></td>
        </tr>
		<tr>
			<td colspan="8">Prosedure/ Tindakan yang sudah dilakukan</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Infus</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="inpus" class="text_dt10" ><?php echo $inpus; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Obat</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="obat" class="text_dt10" ><?php echo $obat; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Tindakan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="tindakan" class="text_dt10" ><?php echo $tindakan; ?></textarea></td>
		</tr>	
		<tr>
			<td colspan="8">Kondisi Pasien Saat Transfer</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kesadaran</td>
			<td>:</td>
			<td colspan="5">
				<input type="radio" name="kp_kesadaran" value="1" <?php echo ((isset($kondisi_pasien['kp_kesadaran']) and $kondisi_pasien['kp_kesadaran'] == '1') ? 'checked' : ''); ?> />&nbsp;CM&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kp_kesadaran" value="2" <?php echo ((isset($kondisi_pasien['kp_kesadaran']) and $kondisi_pasien['kp_kesadaran'] == '2') ? 'checked' : ''); ?> />&nbsp;Apatis&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kp_kesadaran" value="3" <?php echo ((isset($kondisi_pasien['kp_kesadaran']) and $kondisi_pasien['kp_kesadaran'] == '3') ? 'checked' : ''); ?> />&nbsp;Delirium&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kp_kesadaran" value="4" <?php echo ((isset($kondisi_pasien['kp_kesadaran']) and $kondisi_pasien['kp_kesadaran'] == '4') ? 'checked' : ''); ?> />&nbsp;Sopor</td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>GCS</td>
			<td>:</td>
			<td colspan="5">
				E&nbsp;<input type="text" name="kp_gcs_e" value="<?php echo ((isset($kondisi_pasien['kp_gcs_e'])) ? $kondisi_pasien['kp_gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="kp_gcs_m" value="<?php echo ((isset($kondisi_pasien['kp_gcs_m'])) ? $kondisi_pasien['kp_gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="kp_gcs_v" value="<?php echo ((isset($kondisi_pasien['kp_gcs_v'])) ? $kondisi_pasien['kp_gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="220px"><input type="text" name="kp_td" value="<?php echo ((isset($kondisi_pasien['kp_td'])) ? $kondisi_pasien['kp_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Nadi</td>
			<td>:</td>
			<td><input type="text" name="kp_nadi" value="<?php echo ((isset($kondisi_pasien['kp_nadi'])) ? $kondisi_pasien['kp_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="kp_nafas" value="<?php echo ((isset($kondisi_pasien['kp_nafas'])) ? $kondisi_pasien['kp_nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="kp_suhu" value="<?php echo ((isset($kondisi_pasien['kp_suhu'])) ? $kondisi_pasien['kp_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Penggunaan Oksigen</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="kp_oksigen" value="<?php echo ((isset($kondisi_pasien['kp_oksigen'])) ? $kondisi_pasien['kp_oksigen'] : ''); ?>" class="text_dt" >&nbsp;L/menit</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Cairan Parenteral</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="kp_cairan" value="<?php echo ((isset($kondisi_pasien['kp_cairan'])) ? $kondisi_pasien['kp_cairan'] : ''); ?>" class="text_dt" >&nbsp;cc/24 jam</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Transfusi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="kp_transfusi" value="<?php echo ((isset($kondisi_pasien['kp_transfusi'])) ? $kondisi_pasien['kp_transfusi'] : ''); ?>" class="text_dt" >&nbsp;cc</td>
        </tr>
		<tr>
			<td td valign="top" colspan="2" >Pengunaan Cateter</td>
			<td>:</td>
			<td colspan="5">
				<input type="radio" name="kp_cateter" value="1" <?php echo ((isset($kondisi_pasien['kp_cateter']) and $kondisi_pasien['kp_cateter'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kp_cateter" value="2" <?php echo ((isset($kondisi_pasien['kp_cateter']) and $kondisi_pasien['kp_cateter'] == '2') ? 'checked' : ''); ?> />&nbsp;Tidak,&nbsp;&nbsp;&nbsp;
			pemakaian ke&nbsp;<input type="text" name="kp_cateter_ke" value="<?php echo ((isset($kondisi_pasien['kp_cateter_ke'])) ? $kondisi_pasien['kp_cateter_ke'] : ''); ?>" class="text_dt" style="width:80px;" >&nbsp;&nbsp;&nbsp;
			tanggal&nbsp;<input type="text" name="kp_cateter_tgl" value="<?php echo ((isset($kondisi_pasien['kp_cateter_tgl'])) ? $kondisi_pasien['kp_cateter_tgl'] : ''); ?>" class="text_dt" style="width:80px;" >&nbsp;&nbsp;&nbsp;
			pukul&nbsp;<input type="text" name="kp_cateter_pkl" value="<?php echo ((isset($kondisi_pasien['kp_cateter_pkl'])) ? $kondisi_pasien['kp_cateter_pkl'] : ''); ?>" class="text_dt" style="width:80px;" >
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Diet</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="diet" class="text_dt10" ><?php echo $diet; ?></textarea></td>
        </tr>	
		<tr>
            <td valign="top" colspan="2" width="200px;">Mobilisasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="mobilisasi" class="text_dt10" ><?php echo $mobilisasi; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Edukasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="edukasi" class="text_dt10" ><?php echo $edukasi; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Cara Transportasi</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="radio" name="cara_transportasi" value="1" <?php if($cara_transportasi == '1') echo 'checked'; ?> />&nbsp;Kendaraan Umum&nbsp;&nbsp;&nbsp;
					<input type="radio" name="cara_transportasi" value="2" <?php if($cara_transportasi == '2') echo 'checked'; ?> />&nbsp;Kendaraan Pribadi&nbsp;&nbsp;&nbsp;
					<input type="radio" name="cara_transportasi" value="3" <?php if($cara_transportasi == '3') echo 'checked'; ?> />&nbsp;Ambulance RS&nbsp;&nbsp;&nbsp;
					<input type="radio" name="cara_transportasi" value="4" <?php if($cara_transportasi == '4') echo 'checked'; ?> />&nbsp;Ambulance 118&nbsp;&nbsp;&nbsp;
					<input type="radio" name="cara_transportasi" value="5" <?php if($cara_transportasi == '5') echo 'checked'; ?> />&nbsp;Kursi Roda/ Brankard
			</td>
        </tr>
		<tr>
			<td colspan="8">Kondisi Pasien Selama Transfer</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kesadaran</td>
			<td>:</td>
			<td colspan="5">
				<input type="radio" name="kpst_kesadaran" value="1" <?php echo ((isset($kondisi_pasien_selama_transfer['kpst_kesadaran']) and $kondisi_pasien_selama_transfer['kpst_kesadaran'] == '1') ? 'checked' : ''); ?> />&nbsp;CM&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kpst_kesadaran" value="2" <?php echo ((isset($kondisi_pasien_selama_transfer['kpst_kesadaran']) and $kondisi_pasien_selama_transfer['kpst_kesadaran'] == '2') ? 'checked' : ''); ?> />&nbsp;Apatis&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kpst_kesadaran" value="3" <?php echo ((isset($kondisi_pasien_selama_transfer['kpst_kesadaran']) and $kondisi_pasien_selama_transfer['kpst_kesadaran'] == '3') ? 'checked' : ''); ?> />&nbsp;Delirium&nbsp;&nbsp;&nbsp;
				<input type="radio" name="kpst_kesadaran" value="4" <?php echo ((isset($kondisi_pasien_selama_transfer['kpst_kesadaran']) and $kondisi_pasien_selama_transfer['kpst_kesadaran'] == '4') ? 'checked' : ''); ?> />&nbsp;Sopor</td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>GCS</td>
			<td>:</td>
			<td colspan="5">
				E&nbsp;<input type="text" name="kpst_gcs_e" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_gcs_e'])) ? $kondisi_pasien_selama_transfer['kpst_gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="kpst_gcs_m" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_gcs_m'])) ? $kondisi_pasien_selama_transfer['kpst_gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="kpst_gcs_v" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_gcs_v'])) ? $kondisi_pasien_selama_transfer['kpst_gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="220px"><input type="text" name="kpst_td" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_td'])) ? $kondisi_pasien_selama_transfer['kpst_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Nadi</td>
			<td>:</td>
			<td><input type="text" name="kpst_nadi" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_nadi'])) ? $kondisi_pasien_selama_transfer['kpst_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="kpst_nafas" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_nafas'])) ? $kondisi_pasien_selama_transfer['kpst_nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="kpst_suhu" value="<?php echo ((isset($kondisi_pasien_selama_transfer['kpst_suhu'])) ? $kondisi_pasien_selama_transfer['kpst_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>
			<td colspan="8">Barang Yang Disertakan Saat Transfer</td>
		</tr>
        <tr>
            <td valign="top" colspan="2">Hasil Laboratorium</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_laboratorium" class="text_dt11" ><?php echo $hasil_laboratorium; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Hasil Radiologi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_radiologi" class="text_dt11" ><?php echo $hasil_radiologi; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Hasil Pemeriksaan Penunjang lainnya</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_penunjang" class="text_dt11" ><?php echo $hasil_penunjang; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Obat Parenteral</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="obat_parenteral" class="text_dt11" ><?php echo $obat_parenteral; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Obat Oral</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="obat_oral" class="text_dt11" ><?php echo $obat_oral; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Barang lainnya</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="barang_lain" class="text_dt11" ><?php echo $barang_lain; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "45"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			</td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formperiksa').submit();
}	
</script>