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
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?>
			<input type="hidden" name="report_ch<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['CH_REPORT']; ?>" />
			<input type="hidden" name="pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="tarif_pemeriksaan_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['TARIF_PEMERIKSAAN_ID']; ?>" />
			<input type="hidden" name="penunjang_tarif_id<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['PENUNJANG_TARIF_ID']; ?>" /></td>
			<td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN'] . (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
            <td><?php if($dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
				<textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt5" ><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea> 
				<?php }else{ ?>
				<input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" size="90" />
				<?php } ?>
				<input type="hidden" name="rujukan<?php echo $id_counter; ?>" value="" />
				<input type="hidden" name="satuan<?php echo $id_counter; ?>" value="" /></td>
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
			<td><?php echo (($dat_diagnosa['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_diagnosa['NAMA_PEMERIKSAAN'] . (($dat_diagnosa['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
			<td><?php if($dat_diagnosa['TEXT_HASIL'] == '1'){ ?>
				<textarea name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" class="text_dt5" ><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></textarea> 
				<?php }else{ ?>
				<input type="text" name="diagnosa<?php echo $id_counter; ?>" id="diagnosa<?php echo $id_counter; ?>" value="<?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?>" class="text_dt" size="90" />
				<?php } ?>
				<input type="hidden" name="rujukan<?php echo $id_counter; ?>" value="" />
				<input type="hidden" name="satuan<?php echo $id_counter; ?>" value="" /></td>
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