<?php
function parse_upload_file_makan($tahun,$bulan,$file,$filename){
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
					if(strstr($col_e,'=')==true) {
						$col_e = $objWorksheet->getCell('E'.$row)->getOldCalculatedValue();
					} */
						
				$lastrows++;
				}
						
			}
		}// end loop sheet and validate	
			
		//start import
		if($s_import){
			mysql_query('DELETE FROM db_sdm.r_uang_makan WHERE TAHUN = "' . $tahun . '" AND BULAN = "' . $bulan . '"') or die(mysql_error());
			
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
					$qry_1 = 'INSERT INTO db_sdm.r_uang_makan(TAHUN,BULAN,NIP,NAMA_PEGAWAI,UANG_MAKAN,PAJAK,
						UANG_MAKAN_BERSIH,TGL_UPDATE)
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
							if(strstr($col_e,'=')==true) {
								$col_e = $objWorksheet->getCell('E'.$row)->getOldCalculatedValue();
							}
							
							$nip = str_replace(array("'",'"','\\'),array('','',''),$nip);
							$col_b = str_replace(array("'",'"','\\'),array('','',''),$col_b);
							$col_c = str_replace(array("'",'"','\\'),array('','',''),$col_c);
							$col_d = str_replace(array("'",'"','\\'),array('','',''),$col_d);
							$col_e = str_replace(array("'",'"','\\'),array('','',''),$col_e);
										
							$qry_2 = $qry_2 . '("' . $tahun . '","' . $bulan . '","' . $nip . '","' . $col_b . '",
									"' . $col_c . '","' . $col_d . '","' . $col_e . '",
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