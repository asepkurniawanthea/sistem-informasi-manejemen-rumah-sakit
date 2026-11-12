<?php
	$select_percsedasi='SELECT t_operasi_perencanaan_sedasi.ID_PERENCANAAN_SEDASI,
					t_operasi_perencanaan_sedasi.SEDASI,t_operasi_perencanaan_sedasi.KET_SEDASI,t_operasi_perencanaan_sedasi.GA,
					t_operasi_perencanaan_sedasi.KET_GA,t_operasi_perencanaan_sedasi.REGIONAL,t_operasi_perencanaan_sedasi.LAIN_LAIN,
					t_operasi_perencanaan_sedasi.KET_LAIN_LAIN,t_operasi_perencanaan_sedasi.TEHNIK_KHUSUS,t_operasi_perencanaan_sedasi.MONITORING,
					t_operasi_perencanaan_sedasi.KET_MONITORING_EKG_LEAD,t_operasi_perencanaan_sedasi.KET_MONITORING_CVP,
					t_operasi_perencanaan_sedasi.KET_MONITORING_ARTERI_LINE,t_operasi_perencanaan_sedasi.ALAT_KHUSUS,
					t_operasi_perencanaan_sedasi.KET_ALAT_KHUSUS_LAIN_LAIN,t_operasi_perencanaan_sedasi.PASCA_ANESTESI,
					t_operasi_perencanaan_sedasi.KET_PASCA_ANESTESI_APS,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%d/%m/%Y") AS PRA_ANESTESI_MULAI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%H") AS PRA_ANESTESI_MULAI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%i") AS PRA_ANESTESI_MULAI_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%d/%m/%Y") AS PRA_ANESTESI_MEDIKASI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%H") AS PRA_ANESTESI_MEDIKASI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%i") AS PRA_ANESTESI_MEDIKASI_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%d/%m/%Y") AS PRA_ANESTESI_KAMAR_BEDAH_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%H") AS PRA_ANESTESI_KAMAR_BEDAH_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%i") AS PRA_ANESTESI_KAMAR_BEDAH_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%d/%m/%Y") AS PRA_ANESTESI_REN_OPERASI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%H") AS PRA_ANESTESI_REN_OPERASI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%i") AS PRA_ANESTESI_REN_OPERASI_MENIT,
					t_operasi_perencanaan_sedasi.CATATAN_PRA_ANESTESI,
					t_operasi_perencanaan_sedasi.DOKTER_DPJP_ANESTESI,t_operasi_perencanaan_sedasi.KET_REGIONAL
					FROM t_operasi_perencanaan_sedasi
					WHERE t_operasi_perencanaan_sedasi.ID_OPERASI = "' . $idx . '"';
	$query_percsedasi=mysql_query($select_percsedasi) or die(mysql_error());
	$row_percsedasi=mysql_fetch_array($query_percsedasi);	
	
	$id_perencanaan_sedasi = $row_percsedasi['ID_PERENCANAAN_SEDASI'];
	$sedasi = $row_percsedasi['SEDASI'];
	$ket_sedasi = $row_percsedasi['KET_SEDASI'];
	$ga = $row_percsedasi['GA'];
	$ket_ga = $row_percsedasi['KET_GA'];
	$regional = $row_percsedasi['REGIONAL'];
	$ket_regional = $row_percsedasi['KET_REGIONAL'];
	$lain_lain = $row_percsedasi['LAIN_LAIN'];
	$ket_lain_lain = $row_percsedasi['KET_LAIN_LAIN'];
	$tehnik_khusus = $row_percsedasi['TEHNIK_KHUSUS'];
	$monitoring = $row_percsedasi['MONITORING'];
	$ket_monitoring_ekg_lead = $row_percsedasi['KET_MONITORING_EKG_LEAD'];
	$ket_monitoring_cvp = $row_percsedasi['KET_MONITORING_CVP'];
	$ket_monitoring_arteri_line = $row_percsedasi['KET_MONITORING_ARTERI_LINE'];
	$alat_khusus = $row_percsedasi['ALAT_KHUSUS'];
	$ket_alat_khusus_lain_lain = $row_percsedasi['KET_ALAT_KHUSUS_LAIN_LAIN'];
	$pasca_anestesi = $row_percsedasi['PASCA_ANESTESI'];
	$ket_pasca_anestesi_aps = $row_percsedasi['KET_PASCA_ANESTESI_APS'];
	$pra_anestesi_mulai_tanggal = $row_percsedasi['PRA_ANESTESI_MULAI_TANGGAL'];
	$pra_anestesi_mulai_jam = $row_percsedasi['PRA_ANESTESI_MULAI_JAM'];
	$pra_anestesi_mulai_menit = $row_percsedasi['PRA_ANESTESI_MULAI_MENIT'];
	$pra_anestesi_medikasi_tanggal = $row_percsedasi['PRA_ANESTESI_MEDIKASI_TANGGAL'];
	$pra_anestesi_medikasi_jam = $row_percsedasi['PRA_ANESTESI_MEDIKASI_JAM'];
	$pra_anestesi_medikasi_menit = $row_percsedasi['PRA_ANESTESI_MEDIKASI_MENIT'];
	$pra_anestesi_kamar_bedah_tanggal = $row_percsedasi['PRA_ANESTESI_KAMAR_BEDAH_TANGGAL'];
	$pra_anestesi_kamar_bedah_jam = $row_percsedasi['PRA_ANESTESI_KAMAR_BEDAH_JAM'];
	$pra_anestesi_kamar_bedah_menit = $row_percsedasi['PRA_ANESTESI_KAMAR_BEDAH_MENIT'];
	$pra_anestesi_ren_operasi_tanggal = $row_percsedasi['PRA_ANESTESI_REN_OPERASI_TANGGAL'];
	$pra_anestesi_ren_operasi_jam = $row_percsedasi['PRA_ANESTESI_REN_OPERASI_JAM'];
	$pra_anestesi_ren_operasi_menit = $row_percsedasi['PRA_ANESTESI_REN_OPERASI_MENIT'];
	$catatan_pra_anestesi = $row_percsedasi['CATATAN_PRA_ANESTESI'];
	$dokter_dpjp_anestesi = $row_percsedasi['DOKTER_DPJP_ANESTESI'];

if (isset($_POST['simpan']))
    include('operasi/operasi_save_perencanaan_sedasi.php');
?>
<form name="formperiksaoperasi" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="id_perencanaan_sedasi" value="<?php echo $id_perencanaan_sedasi; ?>" />
	<input type="hidden" name="operasi_id" value="<?php echo $idx; ?>" />
	<table border="0" cellpadding="0" cellspacing="0" align="center" style="position:static; " width="80%">
		<tr>
			<td width="5" colspan="2" valign="top" nowrap>
				<div style="width:5%; float:left;">
					<table border="0">					
						<tr>
							<td rowspan="4" style="padding-top:5px; " valign="top">Teknik Anestesia dan Sedasi</td>
							<td><input name="sedasi" id="sedasi" value="1" type="checkbox" <?php if($sedasi =='1') echo 'checked="checked"';  ?>>&nbsp;Sedasi</td>
							<td><input type="text" name="ket_sedasi" id="ket_sedasi" size="77" class="text_dt" value="<?php echo $ket_sedasi; ?>"/></td>
						</tr>
						<tr>
							<td><input name="ga" id="ga" value="1" type="checkbox" <?php if($ga =='1') echo 'checked="checked"'; ?>>&nbsp;GA</td>
							<td><input type="text" name="ket_ga" id="ket_ga" size="77" class="text_dt" value="<?php echo $ket_ga; ?>"/></td>
						</tr>
						<tr>
							<td><input name="regional" id="regional" value="1" type="checkbox" <?php if($regional == '1') echo 'checked="checked"'; ?>>&nbsp;Regional </td>
							<td>
								<input name="ket_regional" id="regional" value="1" type="radio" <?php if($ket_regional=='1') echo 'checked="checked"'; ?>>&nbsp;Spinal&nbsp;
								<input name="ket_regional" id="regional" value="2" type="radio" <?php if($ket_regional=='2') echo 'checked="checked"'; ?>>&nbsp;Epidural&nbsp;	
								<input name="ket_regional" id="regional" value="3" type="radio" <?php if($ket_regional=='3') echo 'checked="checked"'; ?>>&nbsp;Klaudal&nbsp;
								<input name="ket_regional" id="regional" value="4" type="radio" <?php if($ket_regional=='4') echo 'checked="checked"'; ?>>&nbsp;Blok Perifer&nbsp;															
							</td>
						</tr>
						<tr>
							<td><input name="lain_lain" id="lain_lain" value="1" type="checkbox" <?php if($lain_lain=='1') echo 'checked="checked"'; ?>>&nbsp;Lain-lain</td>
							<td><input type="text" name="ket_lain_lain" id="ket_lain_lain" size="77" class="text_dt" value="<?php echo $ket_lain_lain;?>"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top">Tehnik Khusus</td>
							<td colspan="2">
								<input name="tehnik_khusus" value="1" type="radio" <?php if($tehnik_khusus=='1') echo 'checked="checked"'; ?>>&nbsp;Hipotensi&nbsp;&nbsp;
								<input name="tehnik_khusus" value="2" type="radio" <?php if($tehnik_khusus=='2') echo 'checked="checked"'; ?>>&nbsp;Ventilasi Satu Paru&nbsp;&nbsp;
								<input name="tehnik_khusus" value="3" type="radio" <?php if($tehnik_khusus=='3') echo 'checked="checked"'; ?>>&nbsp;TCI&nbsp;&nbsp;
								<input name="tehnik_khusus" value="4" type="radio" <?php if($tehnik_khusus=='4') echo 'checked="checked"'; ?>>&nbsp;Lain-lain&nbsp;&nbsp;
							</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>	
						<tr>
							<td  style="padding-top:5px; " valign="top">Monitoring</td>
							<td><input name="monitoring" value="1" type="radio" <?php if($monitoring=='1') echo 'checked="checked"'; ?>>&nbsp;EKG Lead</td>
							<td><input type="text" name="ket_monitoring_ekg_lead" id="ket_monitoring_ekg_lead" size="77" class="text_dt" value="<?php echo $ket_monitoring_ekg_lead;?>"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">
								<input name="monitoring" value="2" type="radio" <?php if($monitoring=='2') echo 'checked="checked"'; ?>>&nbsp;SpO2&nbsp;&nbsp;
								<input name="monitoring" value="3" type="radio" <?php if($monitoring=='3') echo 'checked="checked"'; ?>>&nbsp;NIBP&nbsp;&nbsp;
								<input name="monitoring" value="4" type="radio" <?php if($monitoring=='4') echo 'checked="checked"'; ?>>&nbsp;Temp&nbsp;&nbsp;
								<input name="monitoring" value="5" type="radio" <?php if($monitoring=='5') echo 'checked="checked"'; ?>>&nbsp;Lain-lain&nbsp;&nbsp;<br>
							</td>
						</tr>
						<tr>	
							<td>&nbsp;</td>
							<td><input name="monitoring" value="6" type="radio" <?php if($monitoring=='6') echo 'checked="checked"'; ?>>&nbsp;CVP</td>
							<td><input type="text" name="ket_monitoring_cvp" id="ket_monitoring_cvp" size="77" class="text_dt" value="<?php echo $ket_monitoring_cvp;?>"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input name="monitoring" value="7" type="radio" <?php if($monitoring=='7') echo 'checked="checked"'; ?>>&nbsp;Arteri line</td>
							<td><input type="text" name="ket_monitoring_arteri_line" id="ket_monitoring_arteri_line" size="77" class="text_dt" value="<?php echo $ket_monitoring_arteri_line;?>"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>	
							<td colspan="2"><input name="monitoring" value="8" type="radio" <?php if($monitoring=='8') echo 'checked="checked"'; ?>>&nbsp;EtCO2&nbsp;&nbsp;
								<input name="monitoring" value="9" type="radio" <?php if($monitoring=='9') echo 'checked="checked"'; ?>>&nbsp;BIS&nbsp;&nbsp;</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>	
						<tr>
							<td  style="padding-top:5px; " valign="top">Alat Khusus</td>
							<td colspan="2">
								<input name="alat_khusus" value="1" type="radio" <?php if($alat_khusus=='1') echo 'checked="checked"'; ?>>&nbsp;Bronchoscopy&nbsp;&nbsp;
								<input name="alat_khusus" value="2" type="radio" <?php if($alat_khusus=='2') echo 'checked="checked"'; ?>>&nbsp;Glidescope&nbsp;&nbsp;
								<input name="alat_khusus" value="3" type="radio" <?php if($alat_khusus=='3') echo 'checked="checked"'; ?>>&nbsp;USG&nbsp;&nbsp;</td>
						</tr>
						<tr>		
							<td>&nbsp;</td>		
							<td><input name="alat_khusus" value="4" type="radio" <?php if($alat_khusus=='4') echo 'checked="checked"'; ?>>&nbsp;Lain-lain</td>							
							<td><input type="text" name="ket_alat_khusus_lain_lain" id="ket_alat_khusus_lain_lain" size="77" class="text_dt" value="<?php echo $ket_alat_khusus_lain_lain;?>"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top" rowspan="4">Perawatan Pasca Anestesia</td>
							<td colspan="2"><input name="pasca_anestesi"  value="1" type="radio" <?php if($pasca_anestesi=='1') echo 'checked="checked"'; ?>>&nbsp;Rawat Inap&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td colspan="2"><input name="pasca_anestesi" value="2" type="radio" <?php if($pasca_anestesi=='2') echo 'checked="checked"'; ?>>&nbsp;Rawat Jalan&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td colspan="2"><input name="pasca_anestesi" value="3" type="radio" <?php if($pasca_anestesi=='3') echo 'checked="checked"'; ?>>&nbsp;Rawat Khusus&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td><input name="pasca_anestesi" id="pasca_anetesi1" value="4" type="radio" <?php if($pasca_anestesi=='4') echo 'checked="checked"'; ?>>&nbsp;APS &nbsp;&nbsp;<br></td>
							<td><input name="ket_pasca_anestesi_aps" id="ket_pasca_anestesi_aps" type="text" size="77" class="text_dt" value="<?php echo $ket_pasca_anestesi_aps; ?>"></td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top" rowspan="4">Persiapan Pra Anestesia</td>
							<td>Puasa Mulai&nbsp;</td>
							<td>&nbsp;Jam&nbsp;<select name="pra_anestesi_mulai_jam" id="pra_anestesi_mulai_jam" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($pra_anestesi_mulai_jam); ?>
												</select>
												<select name="pra_anestesi_mulai_menit" id="pra_anestesi_mulai_menit" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($pra_anestesi_mulai_menit); ?>
												</select>
								&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="pra_anestesi_mulai_tanggal" id="puasa_mulai_1" type="text" size="8" class="text_dt" value="<?php echo $pra_anestesi_mulai_tanggal; ?>"><img align="top" src="image/date.png" border="0"  onclick="showCal('CalendarO1')"/></td>								
						</tr>
						<tr>							
							<td>Pre Medikasi&nbsp;</td>
							<td>&nbsp;Jam&nbsp;<select name="pra_anestesi_medikasi_jam" id="pra_anestesi_medikasi_jam" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($pra_anestesi_medikasi_jam); ?>
												</select>
												<select name="pra_anestesi_medikasi_menit" id="pra_anestesi_medikasi_menit" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($pra_anestesi_medikasi_menit); ?>
												</select>
								&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="pra_anestesi_medikasi_tanggal" id="pre_medikasi_1" type="text" size="8" class="text_dt" value="<?php echo $pra_anestesi_medikasi_tanggal; ?>"><img align="top" src="image/date.png" border="0"  onclick="showCal('CalendarO2')"/></td>								
						</tr>
						<tr>							
							<td>Transportasi ke Kamar Bedah&nbsp;							
							</td>
							<td>&nbsp;Jam&nbsp;<select name="pra_anestesi_kamar_bedah_jam" id="pra_anestesi_kamar_bedah_jam" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($pra_anestesi_kamar_bedah_jam); ?>
												</select>
												<select name="pra_anestesi_kamar_bedah_menit" id="pra_anestesi_kamar_bedah_menit" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($pra_anestesi_kamar_bedah_menit); ?>
												</select>
								&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="pra_anestesi_kamar_bedah_tanggal" id="kamar_bedah_1" type="text" size="8" class="text_dt" value="<?php echo $pra_anestesi_kamar_bedah_tanggal; ?>"><img align="top" src="image/date.png" border="0"  onclick="showCal('CalendarO3')"/></td>								
						</tr>
						<tr>							
							<td>Rencana Operasi&nbsp;</td>
							<td>&nbsp;Jam&nbsp;<select name="pra_anestesi_ren_operasi_jam" id="pra_anestesi_ren_operasi_jam" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($pra_anestesi_ren_operasi_jam); ?>
												</select>
												<select name="pra_anestesi_ren_operasi_menit" id="pra_anestesi_ren_operasi_menit" style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($pra_anestesi_ren_operasi_menit); ?>
												</select>
								&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="pra_anestesi_ren_operasi_tanggal" id="rencana_operasi_1" type="text" size="8" class="text_dt" value="<?php echo $pra_anestesi_ren_operasi_tanggal; ?>"><img align="top" src="image/date.png" border="0"  onclick="showCal('CalendarO4')"/>
							</td>								
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td>Catatan Persiapan Pra Anestesia&nbsp;</td>							
							<td colspan="3">	
								<textarea name="catatan_pra_anestesi" id="catatan_pra_anestesi" cols="80" rows="5" class="text_dt2" style="margin:5px; "><?php echo $catatan_pra_anestesi;?></textarea>							
							</td>								
						</tr>
						<tr>
							<td>DPJP Anestesiologi</td>
							<td colspan="3"><select name="dokter_dpjp_anestesi" id="dokter_dpjp_anestesi" style="width:228px;" class="text_dt" >
												<option value=""></option>
												<?php echo getDokter($dokter_dpjp_anestesi); ?>
											</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>							
							<td colspan="3" align="right">	
								&nbsp;
							</td>								
						</tr>	
						<tr>
							<td>&nbsp;</td>							
							<td colspan="3" align="right">	
								<?php if(!empty($id_perencanaan_sedasi)){ ?>
								<input type="button" value="print perencanaan anestesi" class="myButton1" />
								<?php } ?>
								<input name="simpan" type="submit" class="myButton1" value="Simpan">
							</td>								
						</tr>	
					</table>					
				</div>			
			</td>			
		</tr>		
		<tr>
			<td colspan="2" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
    </table>
</form>
