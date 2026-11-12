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
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?></td>
            <td><?php echo (($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_pemeriksaan_item['NAMA_PEMERIKSAAN'] .(($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
            <td><?php if($dat_pemeriksaan_item['TEXT_HASIL'] == '1'){ ?>
					<textarea name="diagnosa" id="diagnosa" class="text_dt5" style="height:150px;"/></textarea>
				<?php }else{ ?>
					<input type="text" name="diagnosa" id="diagnosa" value="" class="text_dt" size="90" />
				<?php } ?></td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
		</tr>
    <?php } else { ?> 
        <tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center" width="20"><?php echo $z; ?></td>
            <td><?php echo (($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '<strong>' : '') . $dat_pemeriksaan_item['NAMA_PEMERIKSAAN'] .(($dat_pemeriksaan_item['CH_LEVEL'] == '1') ? '</strong>' : ''); ?></td>
            <td><?php if($dat_pemeriksaan_item['TEXT_HASIL'] == '1'){ ?>
					<textarea name="diagnosa" id="diagnosa" class="text_dt5" style="height:150px;"/></textarea>
				<?php }else{ ?>
					<input type="text" name="diagnosa" id="diagnosa" value="" class="text_dt" size="90" />
				<?php } ?></td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
		</tr>	
    <?php } ?>