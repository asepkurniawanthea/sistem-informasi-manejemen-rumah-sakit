<?php
function parse_upload_file_gaji($tahun,$bulan,$file,$filename){
	global $app_path;
	ini_set('memory_limit', '1024M');
	
		$log = '';
		$s_import = true;
		$jrow = 0;
		
		require_once($app_path . 'nsimrs/lib/phpexcel/classes/PHPExcel.php');
		$excelReader = PHPExcel_IOFactory::createReaderForFile($file);
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings);
		$sheetnames = $excelReader->listWorksheetNames($file);
		if(isset($sheetnames[0])) $excelReader->setLoadSheetsOnly($sheetnames[0]);
		$excelReader->setReadDataOnly(true);
		$objPHPExcel = $excelReader->load($file);
		
		$worksheetData = $objPHPExcel->getSheetNames();
		foreach($worksheetData as $vSheet){
			$objPHPExcel->setActiveSheetIndexByName($vSheet);
			$objWorksheet = $objPHPExcel->getActiveSheet();
						
			$sheetStatus = $objWorksheet->getSheetState();
			if($sheetStatus != 'hidden'){
					
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();	
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					
				$starrow=2;
				$lastrows=0;
				for($row=$starrow; $row < $highestRow + 1; ++$row){
					$nip = $objWorksheet->getCell('A'.$row)->getValue();
					if($nip=='') break;
					//validasi
					
					/* $col_b 	= $objWorksheet->getCell('B'.$row)->getValue();
					$col_c 	= $objWorksheet->getCell('C'.$row)->getValue();
					$col_d 	= $objWorksheet->getCell('D'.$row)->getValue();
					$col_e 	= $objWorksheet->getCell('E'.$row)->getValue();
					$col_f 	= $objWorksheet->getCell('F'.$row)->getValue();
					$col_g 	= $objWorksheet->getCell('G'.$row)->getValue();
					$col_h 	= $objWorksheet->getCell('H'.$row)->getValue();
					$col_i 	= $objWorksheet->getCell('I'.$row)->getValue();
					$col_j 	= $objWorksheet->getCell('J'.$row)->getValue();
					$col_k 	= $objWorksheet->getCell('K'.$row)->getValue();
					$col_l 	= $objWorksheet->getCell('L'.$row)->getValue();
					if(strstr($col_l,'=')==true) {
						$col_l = $objWorksheet->getCell('L'.$row)->getOldCalculatedValue();
					}
					$col_m 	= $objWorksheet->getCell('M'.$row)->getValue();
					$col_n 	= $objWorksheet->getCell('N'.$row)->getValue();
					$col_o 	= $objWorksheet->getCell('O'.$row)->getValue();
					$col_p 	= $objWorksheet->getCell('P'.$row)->getValue();
					$col_q 	= $objWorksheet->getCell('Q'.$row)->getValue();
					$col_r 	= $objWorksheet->getCell('R'.$row)->getValue();
					$col_s 	= $objWorksheet->getCell('S'.$row)->getValue();
					$col_t 	= $objWorksheet->getCell('T'.$row)->getValue();
					if(strstr($col_t,'=')==true) {
						$col_t = $objWorksheet->getCell('T'.$row)->getOldCalculatedValue();
					}
					$col_u 	= $objWorksheet->getCell('U'.$row)->getValue();
					if(strstr($col_u,'=')==true) {
						$col_u = $objWorksheet->getCell('U'.$row)->getOldCalculatedValue();
					} */
						
				$lastrows++;
				}
						
			}
		}// end loop sheet and validate	
			
		//start import
		if($s_import){
			mysql_query('DELETE FROM db_sdm.r_gaji WHERE TAHUN = "' . $tahun . '" AND BULAN = "' . $bulan . '"') or die(mysql_error());
			
			foreach($worksheetData as $vSheet){
				$objPHPExcel->setActiveSheetIndexByName($vSheet);
				$objWorksheet = $objPHPExcel->getActiveSheet();
					
				$sheetStatus = $objWorksheet->getSheetState();
				if($sheetStatus != 'hidden'){	
					
					$highestRow = $objWorksheet->getHighestRow();
					$highestColumn = $objWorksheet->getHighestColumn();	
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						
					$starrow=2;
					$lastrows=0;
					$qry_1 = 'INSERT INTO db_sdm.r_gaji(TAHUN,BULAN,NIP,NAMA_PEGAWAI,GAJI_POKOK,TUNJANGAN_ISTERI_SUAMI,
						TUNJANGAN_ANAK,TUNJANGAN_STRUKTUR,TUNJANGAN_WIL_TERPENCIL,TUNJANGAN_TAMB_UMUM,BULAT,
						TUNJANGAN_BERAS,TUNJANGAN_PAJAK,JUMLAH_PENGHASILAN,POTONGAN_BERAS,WP,PPH,SEWA_RUMAH,
						TUNGGAKAN,POTONGAN_LAIN,TAPE_RUM,JUMLAH_POTONGAN,GAJI_BERSIH,TGL_UPDATE)
						VALUES ';
					$qry_ref_1 = 'INSERT IGNORE INTO db_sdm.r_pegawai_ori(NIP,NAMA_PEGAWAI,KUNCI)
						VALUES ';
					$tanggal = getNow();
					
					$qry_2 = '';
					$qry_ref_2 = '';					
					$xrow = 1;						
					for($row=$starrow; $row < $highestRow + 1; ++$row){
					
						$nip = $objWorksheet->getCell('A'.$row)->getValue();
						if($nip != ''){
							$col_b 	= $objWorksheet->getCell('B'.$row)->getValue();
							$col_c 	= $objWorksheet->getCell('C'.$row)->getValue();
							$col_d 	= $objWorksheet->getCell('D'.$row)->getValue();
							$col_e 	= $objWorksheet->getCell('E'.$row)->getValue();
							$col_f 	= $objWorksheet->getCell('F'.$row)->getValue();
							$col_g 	= $objWorksheet->getCell('G'.$row)->getValue();
							$col_h 	= $objWorksheet->getCell('H'.$row)->getValue();
							$col_i 	= $objWorksheet->getCell('I'.$row)->getValue();
							$col_j 	= $objWorksheet->getCell('J'.$row)->getValue();
							$col_k 	= $objWorksheet->getCell('K'.$row)->getValue();
							$col_l 	= $objWorksheet->getCell('L'.$row)->getValue();
							if(strstr($col_l,'=')==true) {
								$col_l = $objWorksheet->getCell('L'.$row)->getOldCalculatedValue();
							}
							$col_m 	= $objWorksheet->getCell('M'.$row)->getValue();
							$col_n 	= $objWorksheet->getCell('N'.$row)->getValue();
							$col_o 	= $objWorksheet->getCell('O'.$row)->getValue();
							$col_p 	= $objWorksheet->getCell('P'.$row)->getValue();
							$col_q 	= $objWorksheet->getCell('Q'.$row)->getValue();
							$col_r 	= $objWorksheet->getCell('R'.$row)->getValue();
							$col_s 	= $objWorksheet->getCell('S'.$row)->getValue();
							$col_t 	= $objWorksheet->getCell('T'.$row)->getValue();
							if(strstr($col_t,'=')==true) {
								$col_t = $objWorksheet->getCell('T'.$row)->getOldCalculatedValue();
							}
							$col_u 	= $objWorksheet->getCell('U'.$row)->getValue();
							if(strstr($col_u,'=')==true) {
								$col_u = $objWorksheet->getCell('U'.$row)->getOldCalculatedValue();
							}
							
							$nip = str_replace(array("'",'"','\\'),array('','',''),$nip);
							$col_b = str_replace(array("'",'"','\\'),array('','',''),$col_b);
							$col_c = str_replace(array("'",'"','\\'),array('','',''),$col_c);
							$col_d = str_replace(array("'",'"','\\'),array('','',''),$col_d);
							$col_e = str_replace(array("'",'"','\\'),array('','',''),$col_e);
							$col_f = str_replace(array("'",'"','\\'),array('','',''),$col_f);
							$col_g = str_replace(array("'",'"','\\'),array('','',''),$col_g);
							$col_h = str_replace(array("'",'"','\\'),array('','',''),$col_h);
							$col_i = str_replace(array("'",'"','\\'),array('','',''),$col_i);
							$col_j = str_replace(array("'",'"','\\'),array('','',''),$col_j);
							$col_k = str_replace(array("'",'"','\\'),array('','',''),$col_k);
							$col_l = str_replace(array("'",'"','\\'),array('','',''),$col_l);
							$col_m = str_replace(array("'",'"','\\'),array('','',''),$col_m);
							$col_o = str_replace(array("'",'"','\\'),array('','',''),$col_o);
							$col_p = str_replace(array("'",'"','\\'),array('','',''),$col_p);
							$col_q = str_replace(array("'",'"','\\'),array('','',''),$col_q);
							$col_r = str_replace(array("'",'"','\\'),array('','',''),$col_r);
							$col_s = str_replace(array("'",'"','\\'),array('','',''),$col_s);
							$col_t = str_replace(array("'",'"','\\'),array('','',''),$col_t);
							$col_u = str_replace(array("'",'"','\\'),array('','',''),$col_u);
							
							$qry_2 = $qry_2 . '("' . $tahun . '","' . $bulan . '","' . $nip . '","' . $col_b . '",
									"' . $col_c . '","' . $col_d . '","' . $col_e . '","' . $col_f . '","' . $col_g . '",
									"' . $col_h . '","' . $col_i . '","' . $col_j . '","' . $col_k . '","' . $col_l . '",
									"' . $col_m . '","' . $col_n . '","' . $col_o . '","' . $col_p . '","' . $col_q . '",
									"' . $col_r . '","' . $col_s . '","' . $col_t . '","' . $col_u . '",
									"' . $tanggal . '"),';
							$qry_ref_2 = $qry_ref_2 . '("' . $nip . '","' . $col_b . '",MD5("' . $nip . '")),';
									
							if($xrow==100){
								$qry_2 = substr($qry_2, 0, strlen($qry_2) - 1);
								$qry = $qry_1 . $qry_2;
								mysql_query($qry) or die(mysql_error());
								$qry_2 = '';	
								
								$qry_ref_2 = substr($qry_ref_2, 0, strlen($qry_ref_2) - 1);
								$qry_ref = $qry_ref_1 . $qry_ref_2;
								mysql_query($qry_ref) or die(mysql_error());
								$qry_ref_2 = '';	
								
								$xrow = 1;
							}
							$xrow++;
							$jrow++;
						}
					}
								
					if($qry_2 != ''){
						$qry_2 = substr($qry_2, 0, strlen($qry_2) - 1);
						$qry = $qry_1 . $qry_2;
						mysql_query($qry) or die(mysql_error());
						
						$qry_ref_2 = substr($qry_ref_2, 0, strlen($qry_ref_2) - 1);
						$qry_ref = $qry_ref_1 . $qry_ref_2;
						mysql_query($qry_ref) or die(mysql_error());	
					}
								
				}	
			 }

		}//end import
			
			if($log != ''){
				$xlog = substr($log,0,strlen($log) - 2) . '.';	
					$xmsg = '0|' . $xlog;
			}else{
					$xmsg = "1|: $jrow Rows.";
			}
		
		$objPHPExcel->disconnectWorksheets();
		unset ($objPHPExcel);
		return $xmsg;		
}
?>