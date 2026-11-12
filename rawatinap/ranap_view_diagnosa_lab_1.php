<?php
                        $sm = true;
                            if ($nama_pemeriksaan_group != $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']) {
                                $nama_pemeriksaan_group = $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'];
                                $sm = false;
                            }

                            if ($dat_diagnosa['CH_LEVEL'] != '1' and !empty($dat_diagnosa['NAMA_PEMERIKSAAN_GROUP'])
                                    and $sm == false) {
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><strong><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN_GROUP']; ?></strong></td>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?php echo $z; ?></td>
                                    <td><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></td>
                                    <td><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></td>
                                    <td><?php echo $dat_diagnosa['SATUAN']; ?></td>
                                    <td><?php $rujukan_array = explode('|', $dat_diagnosa['NILAI_RUJUKAN']);
									if (count($rujukan_array) > 1) {
										$c = 0;
										while ($c < count($rujukan_array)) {
											$nilai_rujukan = $rujukan_array[$c];
											$nilai_rujukan = str_replace('<=',utf8_encode('&#8804;'),$nilai_rujukan);
											echo $nilai_rujukan . '<br />';
											$c++;
										}
									} else {
										$nilai_rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
										$nilai_rujukan = str_replace('<=',utf8_encode('&#8804;'),$nilai_rujukan);
										echo $nilai_rujukan;
									} ?></td>
                                </tr>
                            <?php } else { ?> 
                                <tr>
                                    <td><?php echo $z; ?></td>
                                    <?php if ($dat_diagnosa['CH_LEVEL'] == '1') { ?>
                                        <td><strong><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></strong></td>
                                    <?php } else { ?>
                                        <td><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></td>
                                    <td><?php echo $dat_diagnosa['SATUAN']; ?></td>
                                    <td><?php
											$rujukan_array = explode('|', $dat_diagnosa['NILAI_RUJUKAN']);
											if (count($rujukan_array) > 1) {
												$c = 0;
												while ($c < count($rujukan_array)) {
													$nilai_rujukan = $rujukan_array[$c];
													$nilai_rujukan = str_replace('<=',utf8_encode('&#8804;'),$nilai_rujukan);
													echo $nilai_rujukan . '<br />';
													$c++;
												}
											} else {
												$nilai_rujukan = $dat_diagnosa['NILAI_RUJUKAN'];
												$nilai_rujukan = str_replace('<=',utf8_encode('&#8804;'),$nilai_rujukan);
												echo $nilai_rujukan;
											} ?></td>
                                </tr>	
                                <?php
                            } 
							?>