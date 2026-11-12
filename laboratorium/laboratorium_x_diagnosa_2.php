<?php
    $sm = true;
    if ($nama_pemeriksaan_group != $dat_pemeriksaan_item['NAMA_PEMERIKSAAN_GROUP']) {
        $nama_pemeriksaan_group = $dat_pemeriksaan_item['NAMA_PEMERIKSAAN_GROUP'];
        $sm = false;
    }

    if (!empty($dat_pemeriksaan_item['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) { ?>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td><strong><?php echo $dat_pemeriksaan_item['NAMA_PEMERIKSAAN_GROUP']; ?></strong></td>
            <?php if($dat_pemeriksaan_item['REPORT_FORMAT'] == '2'){ ?>
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
			<?php }else{ ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php } ?>
        </tr>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?></td>
            <td><?php echo (($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_pemeriksaan_item['NAMA_PEMERIKSAAN'] .(($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
            <?php if($dat_pemeriksaan_item['REPORT_FORMAT'] == '2'){  ?>
			<td>
				<table width="100%" border="0">
					<tr>
						<td  width="20%"><input type="text" name="diagnosa_a" id="diagnosa_a" value="" class="text_dt" size="10" /></td>
						<td  width="20%"><input type="text" name="diagnosa_b" id="diagnosa_b" value="" class="text_dt" size="10" /></td>
						<td  width="20%"><input type="text" name="diagnosa_c" id="diagnosa_c" value="" class="text_dt" size="10" /></td>
						<td  width="20%"><input type="text" name="diagnosa_d" id="diagnosa_d" value="" class="text_dt" size="10" /></td>
						<td  width="20%"><input type="text" name="diagnosa_e" id="diagnosa_e" value="" class="text_dt" size="10" /></td>
					</tr>
				</table>	
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>		
			<?php }else{ ?>
			<td><?php if($dat_pemeriksaan_item['TEXT_HASIL'] == '1'){ ?>
					<textarea name="diagnosa" id="diagnosa" class="text_dt5" style="height:150px;"/></textarea>
				<?php }else{ ?>
					<input type="text" name="diagnosa" id="diagnosa" value="" class="text_dt" size="90" />
				<?php } ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>		
			<?php } ?>
        </tr>
        <?php } else { ?> 
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?></td>
            <td><?php echo (($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_pemeriksaan_item['NAMA_PEMERIKSAAN'] .(($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
            <?php if($dat_pemeriksaan_item['REPORT_FORMAT'] == '2'){ ?>
			<td>
				<table width="100%" border="0">
				<tr>
					<td><input type="text" name="diagnosa_a" id="diagnosa_a" value="" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_b" id="diagnosa_b" value="" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_c" id="diagnosa_c" value="" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_d" id="diagnosa_d" value="" class="text_dt" size="10" /></td>
					<td><input type="text" name="diagnosa_e" id="diagnosa_e" value="" class="text_dt" size="10" /></td>
				</tr>
				</table>	
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>		
			<?php }else{ ?>
			<td><?php if($dat_pemeriksaan_item['TEXT_HASIL'] == '1'){ ?>
					<textarea name="diagnosa" id="diagnosa" class="text_dt5" style="height:150px;"/></textarea>
				<?php }else{ ?>
					<input type="text" name="diagnosa" id="diagnosa" value="" class="text_dt" size="90" />
				<?php } ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>		
			<?php } ?>
        </tr>	
    <?php } ?>