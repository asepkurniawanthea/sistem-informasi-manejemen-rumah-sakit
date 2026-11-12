<?php
	$select_pertj='SELECT t_operasi_persetujuan_dokter.PERSETUJUAN_DOKTER_ID,
				DATE_FORMAT(t_operasi_persetujuan_dokter.TANGGAL_PERSETUJUAN,"%d/%m/%Y") AS TANGGAL_PERSETUJUAN,
				t_operasi_persetujuan_dokter.PEMBERI_INFORMASI,
				t_operasi_persetujuan_dokter.PENERIMA_INFORMASI,t_operasi_persetujuan_dokter.NAMA_PENERIMA_INFORMASI,
				t_operasi_persetujuan_dokter.ALAMAT,t_operasi_persetujuan_dokter.JNS_KEL,t_operasi_persetujuan_dokter.UMUR,
				t_operasi_persetujuan_dokter.DIAG_WD_DD,t_operasi_persetujuan_dokter.DASAR_DIAG,t_operasi_persetujuan_dokter.TIND_DOKTER,
				t_operasi_persetujuan_dokter.TIND_DOKTER_SEKUNDER,t_operasi_persetujuan_dokter.INDIKASI_TINDK,
				t_operasi_persetujuan_dokter.TATA_CARA,t_operasi_persetujuan_dokter.TUJUAN,t_operasi_persetujuan_dokter.RESIKO,
				t_operasi_persetujuan_dokter.KOMPLIKASI,t_operasi_persetujuan_dokter.PRONOSIS,t_operasi_persetujuan_dokter.ALT_RESIKO,
				t_operasi_persetujuan_dokter.PENYELAMATAN_PASIEN,t_operasi_persetujuan_dokter.LAIN_LAIN,
				t_operasi_persetujuan_dokter.TIND_DOKTER1,t_operasi_persetujuan_dokter.SAKSI_1,t_operasi_persetujuan_dokter.SAKSI_2,
				t_operasi_persetujuan_dokter.PERSETUJUAN
				FROM t_operasi_persetujuan_dokter
				WHERE t_operasi_persetujuan_dokter.OPERASI_ID = "' . $idx . '"';
	$query_pertj=mysql_query($select_pertj) or die(mysql_error());
	$row_pertj=mysql_fetch_assoc($query_pertj);
	
	$persetujuan_dokter_id = $row_pertj['PERSETUJUAN_DOKTER_ID'];
	$tanggal_persetujuan = $row_pertj['TANGGAL_PERSETUJUAN'];
	$pemberi_informasi = $row_pertj['PEMBERI_INFORMASI'];
	$penerima_informasi = $row_pertj['PENERIMA_INFORMASI'];
	$nama_penerima_informasi = $row_pertj['NAMA_PENERIMA_INFORMASI'];
	$alamat = $row_pertj['ALAMAT'];
	$jns_kel = $row_pertj['JNS_KEL'];
	$umur = $row_pertj['UMUR'];
	$diag_wd_dd = $row_pertj['DIAG_WD_DD'];
	$dasar_diag = $row_pertj['DASAR_DIAG'];
	$tind_dokter = $row_pertj['TIND_DOKTER'];
	$tind_dokter_sekunder = $row_pertj['TIND_DOKTER_SEKUNDER'];
	$indikasi_tindk = $row_pertj['INDIKASI_TINDK'];
	$tata_cara = $row_pertj['TATA_CARA'];
	$tujuan = $row_pertj['TUJUAN'];
	$resiko = $row_pertj['RESIKO'];
	$komplikasi = $row_pertj['KOMPLIKASI'];
	$pronosis = $row_pertj['PRONOSIS'];
	$alt_resiko = $row_pertj['ALT_RESIKO'];
	$penyelamatan_pasien = $row_pertj['PENYELAMATAN_PASIEN'];
	$lain_lain = $row_pertj['LAIN_LAIN'];
	$tind_dokter1 = $row_pertj['TIND_DOKTER1'];
	$saksi_1 = $row_pertj['SAKSI_1'];
	$saksi_2 = $row_pertj['SAKSI_2'];
	$setuju = explode('|',$row_pertj['PERSETUJUAN']);
	
if (isset($_POST['simpan'])) include('operasi/operasi_save_persetujuan_dokter.php');
?>
<form name="formedit" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="persetujuan_dokter_id" value="<?php echo $persetujuan_dokter_id; ?>" />
	<input type="hidden" name="operasi_id" value="<?php echo $idx; ?>" />
	<table border="0" width="80%">
		<tr>
			<td width="385">Pemberi Informasi</td>
			<td><select name="pemberi_informasi" id="pemberi_informasi" style="width:335px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaPenunjang($pemberi_informasi, '56'); ?>
                </select></td>
		</tr>
		<tr>
			<td>Penerima Informasi/Pemberi Persetujuan</td>
			<td><input type="text" name="penerima_informasi" value="<?php echo $penerima_informasi; ?>" style="width:328px;" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Nama Penerima Informasi</td>
			<td><input type="text" name="nama_penerima_informasi" value="<?php echo $nama_penerima_informasi; ?>" style="width:328px;" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><input type="text" name="alamat" value="<?php echo $alamat; ?>" style="width:528px;" class="text_dt" /></td>
		</tr>	
		<tr>
			<td>Jenis Kelamin</td>
			<td><input type="radio" name="jns_kel" value="L" <?php if($jns_kel=='L') { echo 'checked'; } ?>>Laki-laki&nbsp;&nbsp;<input type="radio" name="jns_kel" value="P" <?php if($jns_kel=='P') { echo 'checked'; } ?>>Perempuan</td>
		</tr>	
		<tr>
			<td>Umur</td>
			<td><input type="text" name="umur" value="<?php echo $umur; ?>" size="15" class="text_dt" />&nbsp;tahun</td>
		</tr>	
		<tr>
			<td>Saksi 1</td>
			<td><input type="text" name="saksi_1" value="<?php echo $saksi_1; ?>" style="width:328px;" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Saksi 2</td>
			<td><input type="text" name="saksi_2" value="<?php echo $saksi_2; ?>" style="width:328px;" class="text_dt" /></td>
		</tr>		
		<tr>
			<td>Tindakan</td>
			<td><input type="text" name="tind_dokter1" value="<?php echo $tind_dokter1; ?>" style="width:328px;" class="text_dt" /></td>
		</tr>
		<tr>
			<td>Tanggal Persetujuan</td>
			<td><input type="text" name="tanggal_persetujuan" id="tgl_1" value="<?php echo $tanggal_persetujuan; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">PEMBERIAN INFORMASI :</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<table align="center" width="100%" class="tableData" >
					<tr style="background-color:#b4df5b; ">
						<th width="5">No</th>
						<th style="text-align:left; ">Jenis Informasi</th>
						<th style="text-align:left; padding-left:15px;">Isi Informasi</th>
						<th align="center">Setuju (&radic;)</th>
					</tr>
					<tr>
						<td align="center">1.</td>
						<td style="text-indent:5px; " nowrap>Diagnosis (WD/DD)</td>
						<td style="text-indent:5px; "><input type="text" name="diag_wd_dd" id="diag_wd_dd" style="width:528px;" class="text_dt" value="<?php echo $diag_wd_dd;?>"/></td>
						<td align="center"><input type="checkbox" name="setuju_1" value="1" <?php if(isset($setuju[0]) and $setuju[0] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">2.</td>
						<td style="text-indent:5px; " nowrap>Dasar Diagnosis</td>
						<td style="text-indent:5px; "><input type="text" name="dasar_diag" id="dasar_diag" style="width:528px;" class="text_dt" value="<?php echo $dasar_diag;?>"/></td>
						<td align="center"><input type="checkbox" name="setuju_2" value="1" <?php if(isset($setuju[1]) and $setuju[1] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center" valign="top">3.</td>
						<td style="text-indent:5px; " nowrap valign="top">Tindakan Kedokteran</td>
						<td style="text-indent:0px; ">
							<textarea name="tind_dokter" id="tind_dokter" cols="80" rows="5" class="text_dt2" style="margin:5px; "><?php echo $tind_dokter;?></textarea>
							<textarea name="tind_dokter_sekunder" id="tind_dokter_sekunder" cols="80" rows="5" class="text_dt2" style="margin-left:5px; "><?php echo $tind_dokter_sekunder;?></textarea>													
						</td>
						<td align="center"><input type="checkbox" name="setuju_3" value="1" <?php if(isset($setuju[2]) and $setuju[2] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">4.</td>
						<td style="text-indent:5px; " nowrap>Indikasi Tindakan </td>
						<td style="text-indent:5px; "><input type="text" name="indikasi_tindk" id="indikasi_tindk" style="width:528px;" class="text_dt" value="<?php echo $indikasi_tindk;?>"/></td>
						<td align="center"><input type="checkbox" name="setuju_4" value="1" <?php if(isset($setuju[3]) and $setuju[3] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">5.</td>
						<td style="text-indent:5px; " nowrap>Tata Cara</td>
						<td style="text-indent:5px; ">
							<input type="radio" name="tata_cara" value="1" <?php if($tata_cara=='1') { echo 'checked'; } ?>>&nbsp;Tipe Sedasi/Anasthesia
							<input type="radio" name="tata_cara" value="2" <?php if($tata_cara=='2') { echo 'checked'; } ?>>&nbsp;Uraian singkat prosedur dan tahapan yang penting
						</td>
						<td align="center"><input type="checkbox" name="setuju_5" value="1" <?php if(isset($setuju[4]) and $setuju[4] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center" >6.</td>
						<td style="text-indent:5px; " nowrap>Tujuan</td>
						<td style="text-indent:5px; "><input type="text" name="tujuan" id="tujuan" style="width:528px;" class="text_dt" value="<?php echo $tujuan;?>" /></td>
						<td align="center"><input type="checkbox" name="setuju_6" value="1" <?php if(isset($setuju[5]) and $setuju[5] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center" >7.</td>
						<td style="text-indent:5px; " nowrap >Resiko</td>
						<td style="text-indent:5px; "><input type="text" name="resiko" id="resiko" style="width:528px;" class="text_dt" value="<?php echo $resiko;?>"/></td>
						<td align="center"><input type="checkbox" name="setuju_7" value="1" <?php if(isset($setuju[6]) and $setuju[6] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center" >8.</td>
						<td style="text-indent:5px; " nowrap >Komplikasi</td>
						<td style="text-indent:5px; "><input type="text" name="komplikasi" id="komplikasi" style="width:528px;" class="text_dt" value="<?php echo $komplikasi;?>" /></td>
						<td align="center"><input type="checkbox" name="setuju_8" value="1" <?php if(isset($setuju[7]) and $setuju[7] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center" valign="top">9.</td>
						<td valign="top" style="text-indent:5px; ">
							Pronosis :<br /><br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prognosis Vital, Prognosis Fungsi dan Prognosis<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kesembuhan
						</td>
						<td style="text-indent:5px; " valign="top"><textarea name="pronosis" id="pronosis" cols="80" rows="5" class="text_dt2" ><?php echo $pronosis;?></textarea></td>
						<td align="center"><input type="checkbox" name="setuju_9" value="1" <?php if(isset($setuju[8]) and $setuju[8] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">10.</td>
						<td style="text-indent:5px; " nowrap>Alternatif & Resiko</td>
						<td style="text-indent:5px; ">
							<input type="checkbox" name="alt_resiko" value="1" <?php if($alt_resiko=='1') { echo 'checked'; } ?> >&nbsp;Pilihan Pengobatan/Penatalaksanaan							
						</td>
						<td align="center"><input type="checkbox" name="setuju_10" value="1" <?php if(isset($setuju[9]) and $setuju[9] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">11.</td>
						<td style="text-indent:5px; " nowrap>Hal Lain yang akan dilakukan untuk menyelamatkan pasien</td>
						<td style="text-indent:5px; ">
							<input type="radio" name="penyelamatan_pasien" value="1" <?php if($penyelamatan_pasien=='1') { echo 'checked'; } ?>>&nbsp;Perluasan Tindakan
							<input type="radio" name="penyelamatan_pasien" value="2" <?php if($penyelamatan_pasien=='2') { echo 'checked'; } ?>>&nbsp;Konsultasi Selama Tindakan							
							<input type="radio" name="penyelamatan_pasien" value="3" <?php if($penyelamatan_pasien=='3') { echo 'checked'; } ?>>&nbsp;Resusitasi
						</td>
						<td align="center"><input type="checkbox" name="setuju_11" value="1" <?php if(isset($setuju[10]) and $setuju[10] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td align="center">&nbsp;</td>
						<td style="text-indent:5px; " nowrap valign="top">Lain-lain </td>
						<td style="text-indent:5px; ">
							<textarea name="lain_lain" id="lain_lain" cols="80" rows="5" class="text_dt2" style="margin:5px; "><?php echo $lain_lain;?></textarea>
						</td>
						<td align="center"><input type="checkbox" name="setuju_12" value="1" <?php if(isset($setuju[11]) and $setuju[11] == '1') echo 'checked="checked"'; ?> /></td>
					</tr>
					<tr>
						<td colspan="4" align="center">&nbsp;</td>
					</tr>
				</table>						
			</td>
		</tr>		
		<tr>
			<td colspan="2" align="right" ">
			<?php if(!empty($persetujuan_dokter_id)){ ?>
			<input type="button" value="print formulir persetujuan" class="myButton1" />
			<?php } ?>
			<input name="simpan" type="submit" class="myButton1" value="Simpan"></td>
		</tr>		
    </table>
</form>