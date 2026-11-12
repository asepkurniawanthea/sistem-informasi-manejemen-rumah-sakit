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
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?>
			<input type="hidden" name="report_ch<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['CH_REPORT']; ?>" />
			<input type="hidden" name="pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="tarif_pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="penunjang_tarif_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_ID']; ?>" /></td>
			<td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN']. (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?>&nbsp;
				<?php if(cekNilaiRujukan($dat_diagnosa['HASIL_DIAGNOSA'],$dat_diagnosa['NILAI_RUJUKAN']) == false) echo '<font color="#FF0000">***</font>'; ?></td>
			<td><?php if($dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] == 'Widal'){ ?>
				<select name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" style="width:240px;" class="text_dt">
					<option value="" > - </option>
					<option value="negatif" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == 'negatif') echo 'selected="selected"'; ?>>negatif</option>
					<option value="+ 1/160" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/160') echo 'selected="selected"'; ?>>+ 1/160</option>
					<option value="+ 1/320" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/320') echo 'selected="selected"'; ?>>+ 1/320</option>
					<option value="+ 1/640" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/640') echo 'selected="selected"'; ?>>+ 1/640</option>
					<option value="+ 1/1280" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/1280') echo 'selected="selected"'; ?>>+ 1/1280</option>
				</select>
				<?php }else if($dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
				<textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt8"/><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea>
				<?php }else{ ?>
				<input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" style="width:235px;" />
                <?php } ?></td>
			<td><?php $satuan = $dat_diagnosa['SATUAN'];
				if(empty($satuan)) $satuan = getSatuanLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']); 
				echo $satuan; ?>
				<input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" /></td>
            <td><select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
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
        </tr>
    <?php } else { ?> 
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?>
			<input type="hidden" name="report_ch<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['CH_REPORT']; ?>" />
			<input type="hidden" name="pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="tarif_pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="penunjang_tarif_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_ID']; ?>" /></td>
            <td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN'] . (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?>&nbsp;
				<?php if(cekNilaiRujukan($dat_diagnosa['HASIL_DIAGNOSA'],$dat_diagnosa['NILAI_RUJUKAN']) == false) echo '<font color="#FF0000">***</font>'; ?></td>
            <td><?php if($dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] == 'Widal'){ ?>
				<select name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" style="width:240px;" class="text_dt">
					<option value="" > - </option>
					<option value="negatif" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == 'negatif') echo 'selected="selected"'; ?>>negatif</option>
					<option value="+ 1/160" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/160') echo 'selected="selected"'; ?>>+ 1/160</option>
					<option value="+ 1/320" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/320') echo 'selected="selected"'; ?>>+ 1/320</option>
					<option value="+ 1/640" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/640') echo 'selected="selected"'; ?>>+ 1/640</option>
					<option value="+ 1/1280" <?php if($dat_diagnosa['HASIL_DIAGNOSA'] == '+ 1/1280') echo 'selected="selected"'; ?>>+ 1/1280</option>
				</select>
				<?php }else if($dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
				<textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt8"/><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea>
				<?php }else{ ?>
				<input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" style="width:235px;" /></td>
                <?php } ?></td>
			<td><?php $satuan = $dat_diagnosa['SATUAN'];
				if(empty($satuan)) $satuan = getSatuanLaboratorium($dat_diagnosa['CH_REPORT'],$dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'] . ' ' . $dat_diagnosa['NAMA_PEMERIKSAAN']);
				echo $satuan; ?>
				<input type="hidden" name="satuan<?php echo $id_counter; ?>" value="<?php echo $satuan; ?>" /></td>
            <td><select name="rujukan<?php echo $id_counter; ?>" class="text_dt" style="width:200px;" >
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
        </tr>	
<?php } ?>