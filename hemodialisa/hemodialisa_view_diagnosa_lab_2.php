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
                                    <?php if($dat_diagnosa['REPORT_FORMAT'] == '2'){ ?>
									<td align="center">Bi</td>
									<td align="center">Mi</td>
									<td align="center">S (%)</td>
									<td align="center">F (%)</td>
									<td align="center">G (%)</td>
									<td>&nbsp;</td>
									<?php }else{ ?>
									<td colspan="5">&nbsp;</td>
									<td>&nbsp;</td>
									<?php } ?>
									<td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?php echo $z; ?></td>
                                    <td><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></td>
                                    <?php if($dat_diagnosa['REPORT_FORMAT'] == '2'){ 
									$hasil_diagnosa_a = '';
									$hasil_diagnosa_b = '';
									$hasil_diagnosa_c = '';
									$hasil_diagnosa_d = '';
									$hasil_diagnosa_e = '';
									$hasil_diagnosa_array = explode('|!|',$dat_diagnosa['HASIL_DIAGNOSA']);
									if(count($hasil_diagnosa_array) == 5){
										$hasil_diagnosa_a = $hasil_diagnosa_array[0];
										$hasil_diagnosa_b = $hasil_diagnosa_array[1];
										$hasil_diagnosa_c = $hasil_diagnosa_array[2];
										$hasil_diagnosa_d = $hasil_diagnosa_array[3];
										$hasil_diagnosa_e = $hasil_diagnosa_array[4];
									} ?>
									<td><?php echo $hasil_diagnosa_a; ?></td>
									<td><?php echo $hasil_diagnosa_b; ?></td>
									<td><?php echo $hasil_diagnosa_c; ?></td>
									<td><?php echo $hasil_diagnosa_d; ?></td>
									<td><?php echo $hasil_diagnosa_e; ?></td>
									<?php }else{ ?>
									<td colspan="5"><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></td>
                                    <?php } ?>
									<td><?php $nilai_rujukan_array = explode('|',$dat_diagnosa['NILAI_RUJUKAN']);
											if(count($nilai_rujukan_array) > 1) echo $nilai_rujukan_array[1]; ?></td>
									<td><?php echo $dat_diagnosa['METHODE']; ?></td>		
                                </tr>
                            <?php } else { ?> 
                                <tr>
                                    <td><?php echo $z; ?></td>
                                    <?php if ($dat_diagnosa['CH_LEVEL'] == '1') { ?>
                                        <td><strong><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></strong></td>
                                    <?php } else { ?>
                                        <td><?php echo $dat_diagnosa['NAMA_PEMERIKSAAN']; ?></td>
                                    <?php } ?>
                                    <?php if($dat_diagnosa['REPORT_FORMAT'] == '2'){ 
									$hasil_diagnosa_a = '';
									$hasil_diagnosa_b = '';
									$hasil_diagnosa_c = '';
									$hasil_diagnosa_d = '';
									$hasil_diagnosa_e = '';
									$hasil_diagnosa_array = explode('|!|',$dat_diagnosa['HASIL_DIAGNOSA']);
									if(count($hasil_diagnosa_array) == 5){
										$hasil_diagnosa_a = $hasil_diagnosa_array[0];
										$hasil_diagnosa_b = $hasil_diagnosa_array[1];
										$hasil_diagnosa_c = $hasil_diagnosa_array[2];
										$hasil_diagnosa_d = $hasil_diagnosa_array[3];
										$hasil_diagnosa_e = $hasil_diagnosa_array[4];
									} ?>
									<td><?php echo $hasil_diagnosa_a; ?></td>
									<td><?php echo $hasil_diagnosa_b; ?></td>
									<td><?php echo $hasil_diagnosa_c; ?></td>
									<td><?php echo $hasil_diagnosa_d; ?></td>
									<td><?php echo $hasil_diagnosa_e; ?></td>
									
									<?php }else{ ?>
									<td colspan="5"><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></td>
                                    <?php } ?>
                                    <td><?php $nilai_rujukan_array = explode('|',$dat_diagnosa['NILAI_RUJUKAN']);
											if(count($nilai_rujukan_array) > 1) echo $nilai_rujukan_array[1]; ?></td>
									<td><?php echo $dat_diagnosa['METHODE']; ?></td>		
                                </tr>	
                                <?php
                            } 
									
							?>