<?php   
	$sm = true;
    if ($nama_pemeriksaan_group != $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']) {
        $nama_pemeriksaan_group = $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'];
        $sm = false;
    }

    if (!empty($dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) { ?>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?></strong></td>
            <?php if($dat_diagnosa['REPORT_FORMAT'] == '2'){ ?>
			<td>
				<table width="100%" class="bta">
					<tr>
						<td width="20%" align="center">Bi</td>
						<td width="20%" align="center">Mi</td>
						<td width="20%" align="center">S (%)</td>
						<td width="20%" align="center">F (%)</td>
						<td width="20%" align="center">G (%)</td>
					</tr>
				</table>	
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	<?php }else{ ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	<?php } ?>
        </tr>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?>
			<input type="hidden" name="report_ch<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['CH_REPORT']; ?>" />
			<input type="hidden" name="pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="tarif_pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="report_format<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['REPORT_FORMAT']; ?>" />
			<input type="hidden" name="penunjang_tarif_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_ID']; ?>" /></td>
			<td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN'] . (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?>&nbsp;
			<?php if(cekNilaiRujukan($dat_diagnosa['HASIL_DIAGNOSA'],$dat_diagnosa['NILAI_RUJUKAN']) == false) echo '<font color="#FF0000">***</font>'; ?></td>
			<?php $hasil_diagnosa_array = explode('|!|',$dat_diagnosa['HASIL_DIAGNOSA']); 
			if($dat_diagnosa['REPORT_FORMAT'] == '2' or count($hasil_diagnosa_array) == 5){ 
				$hasil_diagnosa_a = '';
				$hasil_diagnosa_b = '';
				$hasil_diagnosa_c = '';
				$hasil_diagnosa_d = '';
				$hasil_diagnosa_e = '';
				if(count($hasil_diagnosa_array) == 5){
					$hasil_diagnosa_a = $hasil_diagnosa_array[0];
					$hasil_diagnosa_b = $hasil_diagnosa_array[1];
					$hasil_diagnosa_c = $hasil_diagnosa_array[2];
					$hasil_diagnosa_d = $hasil_diagnosa_array[3];
					$hasil_diagnosa_e = $hasil_diagnosa_array[4];
				} ?>
			<td><table width="100%" border="0">
					<tr>
					<td width="20%"><input type="text" name="diagnosa_a<?php echo $id_counter; ?>" id="diagnosa_a<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_a; ?>" class="text_dt" size="10" /></td>
					<td width="20%"><input type="text" name="diagnosa_b<?php echo $id_counter; ?>" id="diagnosa_b<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_b; ?>" class="text_dt" size="10" /></td>
					<td width="20%"><input type="text" name="diagnosa_c<?php echo $id_counter; ?>" id="diagnosa_c<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_c; ?>" class="text_dt" size="10" /></td>
					<td width="20%"><input type="text" name="diagnosa_d<?php echo $id_counter; ?>" id="diagnosa_d<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_d; ?>" class="text_dt" size="10" /></td>
					<td width="20%"><input type="text" name="diagnosa_e<?php echo $id_counter; ?>" id="diagnosa_e<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_e; ?>" class="text_dt" size="10" /></td>
					</tr>
				</table></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
					<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
						<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
					<?php } ?></td>		
			<?php }else if($dat_diagnosa['REPORT_FORMAT'] == '1' and $dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
			<td><textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt9"/><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
				<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
						<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
				<?php } ?></td>
			<?php }else if($dat_diagnosa['REPORT_FORMAT'] == '1' and $dat_diagnosa['TEXT_HASIL'] == ''){ ?>
			<td><input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" size="70" /></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
				<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
						<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
				<?php } ?></td>		
			<?php } ?>
        </tr>
    <?php } else { ?> 
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?>
			<input type="hidden" name="report_ch<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['CH_REPORT']; ?>" />
			<input type="hidden" name="pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="tarif_pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="report_format<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['REPORT_FORMAT']; ?>" />
			<input type="hidden" name="penunjang_tarif_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_ID']; ?>" /></td>
			<td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN'] . (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?>&nbsp;
				<?php if(cekNilaiRujukan($dat_diagnosa['HASIL_DIAGNOSA'],$dat_diagnosa['NILAI_RUJUKAN']) == false) echo '<font color="#FF0000">***</font>'; ?></td>
			<?php $hasil_diagnosa_array = explode('|!|',$dat_diagnosa['HASIL_DIAGNOSA']); 
			if($dat_diagnosa['REPORT_FORMAT'] == '2' or count($hasil_diagnosa_array) == 5){ 
				$hasil_diagnosa_a = '';
				$hasil_diagnosa_b = '';
				$hasil_diagnosa_c = '';
				$hasil_diagnosa_d = '';
				$hasil_diagnosa_e = '';
				
				if(count($hasil_diagnosa_array) == 5){
					$hasil_diagnosa_a = $hasil_diagnosa_array[0];
					$hasil_diagnosa_b = $hasil_diagnosa_array[1];
					$hasil_diagnosa_c = $hasil_diagnosa_array[2];
					$hasil_diagnosa_d = $hasil_diagnosa_array[3];
					$hasil_diagnosa_e = $hasil_diagnosa_array[4];
				} ?>
			<td>
				<table width="100%" border="0">
					<tr>
					<td><input type="text" name="diagnosa_a<?php echo $id_counter; ?>" id="diagnosa_a<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_a; ?>" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_b<?php echo $id_counter; ?>" id="diagnosa_b<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_b; ?>" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_c<?php echo $id_counter; ?>" id="diagnosa_c<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_c; ?>" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_d<?php echo $id_counter; ?>" id="diagnosa_d<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_d; ?>" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_e<?php echo $id_counter; ?>" id="diagnosa_e<?php echo $id_counter; ?>" value="<?php echo $hasil_diagnosa_e; ?>" class="text_dt" size="10" /></td>
					</tr>
				</table></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
				<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
					<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
				<?php } ?></td>		
			<?php }else if($dat_diagnosa['REPORT_FORMAT'] == '1' and $dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
			<td><textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt9"/><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
				<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
						<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
				<?php } ?></td>
			<?php }else if($dat_diagnosa['REPORT_FORMAT'] == '1' and $dat_diagnosa['TEXT_HASIL'] == ''){ ?>
			<td><input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" size="70" /></td>
			<td><input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" />
				<select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
					<option value=""> -- </option>
					<?php $rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
					if(empty($rujukan)) $rujukan = setNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$umur_daftar);
					echo getNilaiRujukanLab($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN'],$jns_kelamin,$rujukan); ?>
				</select></td>
			<td><?php echo getNilaiKritisLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); ?></td>
			<td><?php $methode = $dat_diagnosa['METHODE'];
				if(empty($methode)) $methode = getMethodeLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $methode; ?>
				<input type="hidden" name="methode<?php echo $id_counter; ?>" value="<?php echo $methode; ?>" /></td>
			<td align="center"><a href="#" onclick="javascript: riwayat('<?php echo $dat_diagnosa['CH_REPORT']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >riwayat</a>
				<?php if(!empty($dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID'])){ ?>
						<a href="#" onclick="javascript: hapus_hasil('<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>','<?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?>'); return false;" >hapus</a>
				<?php } ?></td>		
			<?php } ?>
        </tr>	
    <?php } ?>