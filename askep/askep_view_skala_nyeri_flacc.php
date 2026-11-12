<?php
$irna_id = $_GET['idx'];

$sql_flacc = 'SELECT t_irna_askep_flacc_scale.FLACC_SCALE_ID,t_irna_askep_flacc_scale.MUKA,t_irna_askep_flacc_scale.KAKI,
				t_irna_askep_flacc_scale.AKTIVITAS,t_irna_askep_flacc_scale.MENANGIS,t_irna_askep_flacc_scale.RESPON_TUBUH,
				t_irna_askep_flacc_scale.PERAWAT,t_irna_askep_flacc_scale.TANGGAL,t_irna_askep_flacc_scale.USER_ASKEP
				FROM t_irna_askep_flacc_scale
				WHERE t_irna_askep_flacc_scale.FLACC_SCALE_ID = "' . $_GET['idx'] . '"';
$get_flacc = mysql_query($sql_flacc) or die(mysql_error());
$dat_flacc = mysql_fetch_array($get_flacc);

$flacc_scale_id = $dat_flacc['FLACC_SCALE_ID'];
$muka = explode('|',$dat_flacc['MUKA']);
$kaki = explode('|',$dat_flacc['KAKI']);
$aktivitas = explode('|',$dat_flacc['AKTIVITAS']);
$menangis = explode('|',$dat_flacc['MENANGIS']);
$respon_tubuh = explode('|',$dat_flacc['RESPON_TUBUH']);
$perawat = explode('|',$dat_flacc['PERAWAT']);
$tanggal = explode('|',$dat_flacc['TANGGAL']);
?>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="flacc_scale_id" value="<?php echo $flacc_scale_id; ?>" />
	<table align="center" class="tableData">
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Parameter</th>
			<th>Skala</th>		
			<th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
			<th width="130px">Skor</th>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">FACE/ MUKA</td>			
			<td>0. Tidak ada ekspresi</td>
		    <td align="center"><input type="radio" name="muka_1" value="0" <?php if(isset($muka[0]) and $muka[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_2" value="0" <?php if(isset($muka[1]) and $muka[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_3" value="0" <?php if(isset($muka[2]) and $muka[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_4" value="0" <?php if(isset($muka[3]) and $muka[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_5" value="0" <?php if(isset($muka[4]) and $muka[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="muka_6" value="0" <?php if(isset($muka[5]) and $muka[5] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>1. Sesekali meringis</td>
		    <td align="center"><input type="radio" name="muka_1" value="1" <?php if(isset($muka[0]) and $muka[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_2" value="1" <?php if(isset($muka[1]) and $muka[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_3" value="1" <?php if(isset($muka[2]) and $muka[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_4" value="1" <?php if(isset($muka[3]) and $muka[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_5" value="1" <?php if(isset($muka[4]) and $muka[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="muka_6" value="1" <?php if(isset($muka[5]) and $muka[5] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Mengatupkan rahang</td>
		    <td align="center"><input type="radio" name="muka_1" value="2" <?php if(isset($muka[0]) and $muka[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_2" value="2" <?php if(isset($muka[1]) and $muka[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_3" value="2" <?php if(isset($muka[2]) and $muka[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_4" value="2" <?php if(isset($muka[3]) and $muka[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="muka_5" value="2" <?php if(isset($muka[4]) and $muka[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="muka_6" value="2" <?php if(isset($muka[5]) and $muka[5] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">LEGS/ KAKI</td>			
			<td>0. Posisi normal atau santai</td>
		    <td align="center"><input type="radio" name="kaki_1" value="0" <?php if(isset($kaki[0]) and $kaki[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_2" value="0" <?php if(isset($kaki[1]) and $kaki[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_3" value="0" <?php if(isset($kaki[2]) and $kaki[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_4" value="0" <?php if(isset($kaki[3]) and $kaki[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_5" value="0" <?php if(isset($kaki[4]) and $kaki[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="kaki_6" value="0" <?php if(isset($kaki[5]) and $kaki[5] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>1. Tidak nyaman/ tidak dapat istirahat, isah, tegang</td>
		    <td align="center"><input type="radio" name="kaki_1" value="1" <?php if(isset($kaki[0]) and $kaki[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_2" value="1" <?php if(isset($kaki[1]) and $kaki[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_3" value="1" <?php if(isset($kaki[2]) and $kaki[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_4" value="1" <?php if(isset($kaki[3]) and $kaki[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_5" value="1" <?php if(isset($kaki[4]) and $kaki[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="kaki_6" value="1" <?php if(isset($kaki[5]) and $kaki[5] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Menendang, kaki diangkat keatas sengaja tidak bergerak</td>
		    <td align="center"><input type="radio" name="kaki_1" value="2" <?php if(isset($kaki[0]) and $kaki[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_2" value="2" <?php if(isset($kaki[1]) and $kaki[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_3" value="2" <?php if(isset($kaki[2]) and $kaki[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_4" value="2" <?php if(isset($kaki[3]) and $kaki[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kaki_5" value="2" <?php if(isset($kaki[4]) and $kaki[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="kaki_6" value="2" <?php if(isset($kaki[5]) and $kaki[5] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ACTIVITY/ AKTIVITAS</td>			
			<td>0. Mudah berbaring dengan tenang</td>
		    <td align="center"><input type="radio" name="aktivitas_1" value="0" <?php if(isset($aktivitas[0]) and $aktivitas[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_2" value="0" <?php if(isset($aktivitas[1]) and $aktivitas[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_3" value="0" <?php if(isset($aktivitas[2]) and $aktivitas[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_4" value="0" <?php if(isset($aktivitas[3]) and $aktivitas[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_5" value="0" <?php if(isset($aktivitas[4]) and $aktivitas[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="aktivitas_6" value="0" <?php if(isset($aktivitas[5]) and $aktivitas[5] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>1. Menggeliat dengan tegang</td>
		    <td align="center"><input type="radio" name="aktivitas_1" value="1" <?php if(isset($aktivitas[0]) and $aktivitas[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_2" value="1" <?php if(isset($aktivitas[1]) and $aktivitas[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_3" value="1" <?php if(isset($aktivitas[2]) and $aktivitas[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_4" value="1" <?php if(isset($aktivitas[3]) and $aktivitas[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_5" value="1" <?php if(isset($aktivitas[4]) and $aktivitas[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="aktivitas_6" value="1" <?php if(isset($aktivitas[5]) and $aktivitas[5] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Melengkung, kaku</td>
		    <td align="center"><input type="radio" name="aktivitas_1" value="2" <?php if(isset($aktivitas[0]) and $aktivitas[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_2" value="2" <?php if(isset($aktivitas[1]) and $aktivitas[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_3" value="2" <?php if(isset($aktivitas[2]) and $aktivitas[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_4" value="2" <?php if(isset($aktivitas[3]) and $aktivitas[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="aktivitas_5" value="2" <?php if(isset($aktivitas[4]) and $aktivitas[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="aktivitas_6" value="2" <?php if(isset($aktivitas[5]) and $aktivitas[5] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">CRY/ MENANGIS</td>			
			<td>0. Tidak menangis</td>
		    <td align="center"><input type="radio" name="menangis_1" value="0" <?php if(isset($menangis[0]) and $menangis[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="0" <?php if(isset($menangis[1]) and $menangis[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="0" <?php if(isset($menangis[2]) and $menangis[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="0" <?php if(isset($menangis[3]) and $menangis[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="0" <?php if(isset($menangis[4]) and $menangis[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="menangis_6" value="0" <?php if(isset($menangis[5]) and $menangis[5] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>1. Mengerang/ merintih</td>
		    <td align="center"><input type="radio" name="menangis_1" value="1" <?php if(isset($menangis[0]) and $menangis[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="1" <?php if(isset($menangis[1]) and $menangis[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="1" <?php if(isset($menangis[2]) and $menangis[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="1" <?php if(isset($menangis[3]) and $menangis[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="1" <?php if(isset($menangis[4]) and $menangis[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="menangis_6" value="1" <?php if(isset($menangis[5]) and $menangis[5] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Menangis terus sampai menjerit</td>
		    <td align="center"><input type="radio" name="menangis_1" value="2" <?php if(isset($menangis[0]) and $menangis[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="2" <?php if(isset($menangis[1]) and $menangis[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="2" <?php if(isset($menangis[2]) and $menangis[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="2" <?php if(isset($menangis[3]) and $menangis[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="2" <?php if(isset($menangis[4]) and $menangis[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="menangis_6" value="2" <?php if(isset($menangis[5]) and $menangis[5] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">CONSATABILITY/ RESPON TUBUH</td>			
			<td>0. Santai</td>
		    <td align="center"><input type="radio" name="respon_tubuh_1" value="0" <?php if(isset($respon_tubuh[0]) and $respon_tubuh[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_2" value="0" <?php if(isset($respon_tubuh[1]) and $respon_tubuh[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_3" value="0" <?php if(isset($respon_tubuh[2]) and $respon_tubuh[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_4" value="0" <?php if(isset($respon_tubuh[3]) and $respon_tubuh[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_5" value="0" <?php if(isset($respon_tubuh[4]) and $respon_tubuh[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="respon_tubuh_6" value="0" <?php if(isset($respon_tubuh[5]) and $respon_tubuh[5] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>1. Mudah terangsang dengan sentuhan</td>
		    <td align="center"><input type="radio" name="respon_tubuh_1" value="1" <?php if(isset($respon_tubuh[0]) and $respon_tubuh[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_2" value="1" <?php if(isset($respon_tubuh[1]) and $respon_tubuh[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_3" value="1" <?php if(isset($respon_tubuh[2]) and $respon_tubuh[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_4" value="1" <?php if(isset($respon_tubuh[3]) and $respon_tubuh[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_5" value="1" <?php if(isset($respon_tubuh[4]) and $respon_tubuh[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="respon_tubuh_6" value="1" <?php if(isset($respon_tubuh[5]) and $respon_tubuh[5] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Mudah terangsang tanpa sentuhan</td>
		    <td align="center"><input type="radio" name="respon_tubuh_1" value="2" <?php if(isset($respon_tubuh[0]) and $respon_tubuh[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_2" value="2" <?php if(isset($respon_tubuh[1]) and $respon_tubuh[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_3" value="2" <?php if(isset($respon_tubuh[2]) and $respon_tubuh[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_4" value="2" <?php if(isset($respon_tubuh[3]) and $respon_tubuh[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="respon_tubuh_5" value="2" <?php if(isset($respon_tubuh[4]) and $respon_tubuh[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="respon_tubuh_6" value="2" <?php if(isset($respon_tubuh[5]) and $respon_tubuh[5] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<?php
		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		$total_skor_6 = 0;
		if(!empty($flacc_scale_id)){
			$total_skor_1 = $muka[0] + $kaki[0] + $aktivitas[0] + $menangis[0] + $respon_tubuh[0];
			$total_skor_2 = $muka[1] + $kaki[1] + $aktivitas[1] + $menangis[1] + $respon_tubuh[1];
			$total_skor_3 = $muka[2] + $kaki[2] + $aktivitas[2] + $menangis[2] + $respon_tubuh[2];
			$total_skor_4 = $muka[3] + $kaki[3] + $aktivitas[3] + $menangis[3] + $respon_tubuh[3];
			$total_skor_5 = $muka[4] + $kaki[4] + $aktivitas[4] + $menangis[4] + $respon_tubuh[4];
			$total_skor_6 = $muka[5] + $kaki[5] + $aktivitas[5] + $menangis[5] + $respon_tubuh[5];
		}	
		?>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center"><?php echo $total_skor_1; ?></td>
		    <td align="center"><?php echo $total_skor_2; ?></td>
		    <td align="center"><?php echo $total_skor_3; ?></td>
		    <td align="center"><?php echo $total_skor_4; ?></td>
		    <td align="center"><?php echo $total_skor_5; ?></td>
			<td align="center"><?php echo $total_skor_6; ?></td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center"><select name="perawat_1" id="perawat_1" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[0])) $xperawat = $perawat[0]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_2" id="perawat_2" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[1])) $xperawat = $perawat[1]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_3" id="perawat_3" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[2])) $xperawat = $perawat[2]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_4" id="perawat_4" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[3])) $xperawat = $perawat[3]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_5" id="perawat_5" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[4])) $xperawat = $perawat[4]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_6" id="perawat_6" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[5])) $xperawat = $perawat[5]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TANGGAL</td>
		    <td><input type="text" name="tanggal_1" id="tgl_edu_1" value="<?php if(isset($tanggal[0])) echo $tanggal[0]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
		    <td><input type="text" name="tanggal_2" id="tgl_edu_2" value="<?php if(isset($tanggal[1])) echo $tanggal[1]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
		    <td><input type="text" name="tanggal_3" id="tgl_edu_3" value="<?php if(isset($tanggal[2])) echo $tanggal[2]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
		    <td><input type="text" name="tanggal_4" id="tgl_edu_4" value="<?php if(isset($tanggal[3])) echo $tanggal[3]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
		    <td><input type="text" name="tanggal_5" id="tgl_edu_5" value="<?php if(isset($tanggal[4])) echo $tanggal[4]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></td>
			<td><input type="text" name="tanggal_6" id="tgl_edu_6" value="<?php if(isset($tanggal[5])) echo $tanggal[5]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu6')"/></td>
		</tr>
		<tr>
			<td colspan="13" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
<tr>
			<td colspan="2">Keterangan :<br />
			skor 0 : tidak nyeri<br />
			skor 1-3 : nyeri ringan<br />
			skor 4-6 : nyeri sedang<br />
			skor 7-10 : nyeri berat
			</td>
			<td colspan="11" valign="top">
			* Untuk anak umur kurang dari 3 tahun
			</td>
		</tr>		
    </table>
</form>