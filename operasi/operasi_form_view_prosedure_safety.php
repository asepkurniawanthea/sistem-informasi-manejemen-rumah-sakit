<?php
$select_safty='SELECT t_operasi_prosedure_safety.PROCEDURE_SAFETY_ID,
					t_operasi_prosedure_safety.KELENGKAPAN_TIM,t_operasi_prosedure_safety.PERAN_TIM,
					t_operasi_prosedure_safety.ANTIBIOTIK_PROPILAKSIS,
					DATE_FORMAT(t_operasi_prosedure_safety.DIBERIKAN_JAM,"%H") AS DIBERIKAN_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.DIBERIKAN_JAM,"%i") AS DIBERIKAN_MENIT,
					t_operasi_prosedure_safety.ANTISIPASI_KRITIS,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_MULAI,"%H") AS ANTISIPASI_KRITIS_MULAI_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_MULAI,"%i") AS ANTISIPASI_KRITIS_MULAI_MENIT,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_SELESAI,"%H") AS ANTISIPASI_KRITIS_SELESAI_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_SELESAI,"%i") AS ANTISIPASI_KRITIS_SELESAI_MENIT,
					t_operasi_prosedure_safety.ANTISIPASI_KRITIS2,
					t_operasi_prosedure_safety.CEK_STERILISASI,t_operasi_prosedure_safety.KESIAPAN_PERALATAN,
					t_operasi_prosedure_safety.FOTO_RADIOLOGI,t_operasi_prosedure_safety.KETERANGAN,t_operasi_prosedure_safety.PERAWAT,
					t_operasi_prosedure_safety.JNS_ANTIBIOTIK,t_operasi_prosedure_safety.KET_KESIAPAN_PERALATAN
					FROM t_operasi_prosedure_safety
				WHERE t_operasi_prosedure_safety.OPERASI_ID = "' . $idx . '"';
	$query_safty=mysql_query($select_safty) or die(mysql_error());
	$row_safty=mysql_fetch_assoc($query_safty);
	
	$procedure_safety_id = $row_safty['PROCEDURE_SAFETY_ID'];
	$kelengkapan_tim = $row_safty['KELENGKAPAN_TIM'];
	$peran_tim = $row_safty['PERAN_TIM'];
	$antibiotik_propilaksis = $row_safty['ANTIBIOTIK_PROPILAKSIS'];
	$diberikan_jam = $row_safty['DIBERIKAN_JAM'];
	$diberikan_menit = $row_safty['DIBERIKAN_MENIT'];
	$antisipasi_kritis = $row_safty['ANTISIPASI_KRITIS'];
	$antisipasi_kritis_mulai_jam = $row_safty['ANTISIPASI_KRITIS_MULAI_JAM'];
	$antisipasi_kritis_mulai_menit = $row_safty['ANTISIPASI_KRITIS_MULAI_MENIT'];
	$antisipasi_kritis_selesai_jam = $row_safty['ANTISIPASI_KRITIS_SELESAI_JAM'];
	$antisipasi_kritis_selesai_menit = $row_safty['ANTISIPASI_KRITIS_SELESAI_MENIT'];
	$antisipasi_kritis2 = $row_safty['ANTISIPASI_KRITIS2'];
	$cek_sterilisasi = $row_safty['CEK_STERILISASI'];
	$kesiapan_peralatan = $row_safty['KESIAPAN_PERALATAN'];
	$foto_radiologi = $row_safty['FOTO_RADIOLOGI'];
	$keterangan = $row_safty['KETERANGAN'];
	$perawat = $row_safty['PERAWAT'];
	$jns_antibiotik = $row_safty['JNS_ANTIBIOTIK'];
	$ket_kesiapan_peralatan = $row_safty['KET_KESIAPAN_PERALATAN'];
?>
	<table border="0" width="80%">
		<tr>
			<td width="5" colspan="2" valign="top" nowrap>Kelengkapan Tim Tindakan</td>
			<td>&nbsp;</td>	
			<td><input name="kelengkapan_tim" value="1" type="radio" <?php if($kelengkapan_tim=='1') { echo 'checked="checked"'; } ?>>&nbsp;Lengkap
					<input name="kelengkapan_tim" value="2" type="radio" <?php if($kelengkapan_tim=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak Lengkap</td>
		</tr>
		<tr>
			<td width="5" colspan="2" valign="top" nowrap>Menyebutkan nama dan peran tim</td>
					<td>&nbsp;</td>
					<td>	
					<input name="peran_tim" value="1" type="checkbox" <?php if($peran_tim=='1') { echo 'checked="checked"'; } ?>>&nbsp;Menyebutkan secara verbal<br>
					<table>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Tanggal Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Nama Lengkap dan Tanggal Lahir</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Prosedur Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Tempat Dilakukan Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Inform Consen</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>							
			<td width="5" colspan="2" valign="top" nowrap>Antibiotik Propilaksis sudah diberikan 60 menit sebelumnya ?</td>
				<td>&nbsp;</td>
				<td>
					<input name="antibiotik_propilaksis" id="antibiotik_1" value="1" type="radio" <?php if($antibiotik_propilaksis=='1') { echo 'checked="checked"'; } ?>>&nbsp;Tidak
					<input name="antibiotik_propilaksis" id="antibiotik_2" value="2" type="radio" <?php if($antibiotik_propilaksis=='2') { echo 'checked="checked"'; } ?>>&nbsp;Ya, &nbsp;Jenis&nbsp;
					<input name="jns_antibiotik" id="jns_antibiotik" type="text" class="text_dt" size="50" value="<?php echo $jns_antibiotik; ?>">
					<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diberikan Jam&nbsp;&nbsp;
					<select name="diberikan_jam" id="diberikan_jam" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getJam($diberikan_jam); ?>
					</select>
					<select name="diberikan_menit" id="diberikan_menit" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getMenit($diberikan_menit); ?>
					</select>
			</td>		
		</tr>
		<tr>							
			<td width="5" colspan="2" nowrap>Mengantisipasi Peristiwa Kritis</td>	
			<td>Dokter&nbsp;:&nbsp;&nbsp;</td>
			<td>&nbsp;</td>	
		</tr>	
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Tindakan yang dilakukan beresiko tinggi ?&nbsp;<input name="antisipasi_kritis" value="1" type="radio" <?php if($antisipasi_kritis=='1') { echo 'checked="checked"'; } ?>>&nbsp;Ya&nbsp;&nbsp;
				<input name="antisipasi_kritis" value="2" type="radio" <?php if($antisipasi_kritis=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Berapa lama tindakan ini akan di lakukan ?&nbsp;Mulai&nbsp;<select name="antisipasi_kritis_mulai_jam" id="antisipasi_kritis_mulai_jam" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getJam($antisipasi_kritis_mulai_jam); ?>
					</select>
					<select name="antisipasi_kritis_mulai_menit" id="antisipasi_kritis_mulai_menit" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getMenit($antisipasi_kritis_mulai_menit); ?>
					</select>&nbsp;&nbsp;Sd&nbsp;
					<select name="antisipasi_kritis_selesai_jam" id="antisipasi_kritis_selesai_jam" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getJam($antisipasi_kritis_selesai_jam); ?>
					</select>
					<select name="antisipasi_kritis_selesai_menit" id="antisipasi_kritis_selesai_menit" style="width:50px;" class="text_dt" >
						<option value=""></option>
						<?php echo getMenit($antisipasi_kritis_selesai_menit); ?>
					</select></td>
		</tr>		
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Sudah di Antisipasi Perdarahan ?&nbsp;<input name="antisipasi_kritis2" value="1" type="radio"  <?php if($antisipasi_kritis2=='1') { echo 'checked="checked"'; } ?>>&nbsp;Ya&nbsp;&nbsp;<input name="antisipasi_kritis2" value="2" type="radio" <?php if($antisipasi_kritis2=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak</td>
		</tr>			
		<tr>							
			<td width="5" colspan="2" nowrap>&nbsp;</td>	
			<td>Perawat&nbsp;:&nbsp;&nbsp;</td>
			<td>&nbsp;</td>	
		</tr>	
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Sudah mengecek sterilisasi alat (melalui indicator sterilisasi) ? &nbsp;<input name="cek_sterilisasi" value="1" type="radio" <?php if($cek_sterilisasi=='1') { echo 'checked="checked"'; } ?>>&nbsp;Ya&nbsp;&nbsp;
			<input name="cek_sterilisasi" value="2" type="radio" <?php if($cek_sterilisasi=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah ada kesiapan peralatan yang harus diperhatikan ?&nbsp;&nbsp;<input name="kesiapan_peralatan" id="cek_kesiapan1" value="1" type="radio" <?php if($kesiapan_peralatan=='1') { echo 'checked="checked"'; } ?>>&nbsp;Ya&nbsp;&nbsp;<input name="kesiapan_peralatan" value="2" id="cek_kesiapan2" type="radio" <?php if($kesiapan_peralatan=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak<br>						
			Jika Ya, sebutkan &nbsp;&nbsp; <input type="text" name="ket_kesiapan_peralatan" id="kesiapan1" size="70" class="text_dt" value="<?php echo $ket_kesiapan_peralatan; ?>"> 
			</td>
		</tr>		
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Foto Radiologi yang penting sudah dipasang ?&nbsp;<input name="foto_radiologi" value="1" type="radio" <?php if($foto_radiologi=='1') { echo 'checked="checked"'; } ?>>&nbsp;Dipasang&nbsp;&nbsp;<input name="foto_radiologi" value="2" type="radio" <?php if($foto_radiologi=='2') { echo 'checked="checked"'; } ?>>&nbsp;Tidak dipasang</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Hal yang harus di perhatikan :&nbsp;<br><textarea name="keterangan" id="keterangan" cols="80" rows="5" class="text_dt2" style="margin:5px; "><?php echo $keterangan; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="4" align="right" style="font-size:15px; ">
			&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">Perawat Penanggungjawab</td>
			<td>&nbsp;</td>
			<td><select name="perawat" id="perawat" style="width:335px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaPenunjang($perawat, '56'); ?>
                </select></td>
		</tr>	
    </table>
</form> 
