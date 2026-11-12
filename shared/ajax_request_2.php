<?php
if (isset($_GET['ajaxrequest'])) {
    $ajaxrequest = $_GET['ajaxrequest'];
    switch ($ajaxrequest) {
        case 'ckota' :
            ?>
            <select name="kota_id" id="kota_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('ckecamatan','index.php?ajaxrequest=ckecamatan&kota_id=' + this.value);return false;">
                <option value=""> - </option>
                <?php echo getKota($_GET['propinsi_id'], ''); ?>
            </select>
            <?php
            break;
        case 'ckecamatan' :
            ?>
            <select name="kecamatan_id" id="kecamatan_id" class="text_dt" style="width:228px;"  onchange="javascript : MyAjaxRequest('ckelurahan','index.php?ajaxrequest=ckelurahan&kecamatan_id=' + this.value);return false;">
                <option value=""> - </option>
                <?php echo getKecamatan($_GET['kota_id'], ''); ?>
            </select>
            <?php
            break;
        case 'ckelurahan' :
            ?>
            <select name="kelurahan_id" id="kelurahan_id" class="text_dt" style="width:228px;" >
                <option value=""> - </option>
                <?php echo getKelurahan($_GET['kecamatan_id'], ''); ?>
            </select>
            <?php
            break;
        case 'chkota' :
            ?>
            <select name="p_jawab_kota_id" id="p_jawab_kota_id" class="text_dt" style="width:228px;" onchange="javascript : MyAjaxRequest('chkecamatan','index.php?ajaxrequest=chkecamatan&kota_id=' + this.value);return false;">
                <option value=""> - </option>
                <?php echo getKota($_GET['propinsi_id'], ''); ?>
            </select>
            <?php
            break;
        case 'chkecamatan' :
            ?>
            <select name="p_jawab_kecamatan_id" id="p_jawab_kecamatan_id" class="text_dt" style="width:228px;"  onchange="javascript : MyAjaxRequest('chkelurahan','index.php?ajaxrequest=chkelurahan&kecamatan_id=' + this.value);return false;">
                <option value=""> - </option>
                <?php echo getKecamatan($_GET['kota_id'], ''); ?>
            </select>
            <?php
            break;
        case 'chkelurahan' :
            ?>
            <select name="p_jawab_kelurahan_id" id="p_jawab_kelurahan_id" class="text_dt" style="width:228px;" >
                <option value=""> - </option>
                <?php echo getKelurahan($_GET['kecamatan_id'], ''); ?>
            </select>
            <?php
            break;
        case 'umur' :
            echo getUmur($_GET['tgl_lahir']);
            break;
        case 'cruang' :
            ?>
            <select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;" class="text_dt" >
                <option value=""> - </option>
                <?php echo getRuangx($_GET['unit_id'], ''); ?>
            </select>
            <?php
            break;
		case 'ckecamatanadmin' :
            ?>
            <select <select name="kecamatan_id" id="kecamatan_id" class="text_dt">
                    <option> - </option>
                   <?php echo getKecamatan($_GET['kota_id'], ''); ?>
                </select>
            <?php
            break;
		case 'cdokter' :
			?>
            <select name="pegawai_id" id="pegawai_id" class="text_dt" style="width:228px;" class="text_dt" >
                <option value=""> - </option>
                <?php  $unit_id = $_GET['unit_id'];
					if(stripos($unit_id,'mcu') !== false) $unit_id = '38';
					$sql = 'SELECT m_pegawai.NAMA_PEGAWAI,t_dokter_jaga.UNIT_ID,t_dokter_jaga.PEGAWAI_ID,
							m_pegawai_tipe.KET_TIPE_PEGAWAI
							FROM m_pegawai
							INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
							INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)
							WHERE t_dokter_jaga.UNIT_ID = "' . $unit_id . '"';
					$get = mysql_query($sql) or die(mysql_error());
					while($data = mysql_fetch_array($get)){
						if(!isset($_GET['pegawai_id'])){
							if($data['NAMA_PEGAWAI'] != '-'){
								?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($_GET['unit_id'],$data['PEGAWAI_ID'],cekCurrentDay())) echo 'selected="selected"'; ?>><?php echo $data['NAMA_PEGAWAI']; ?></option>
								<?php
								}else{ ?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($_GET['unit_id'],$data['PEGAWAI_ID'],cekCurrentDay())) echo 'selected="selected"'; ?>>[<?php echo $data['KET_TIPE_PEGAWAI']; ?>]</option>
								<?php }
						}else{
							if($data['NAMA_PEGAWAI'] != '-'){
								?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php  if($data['PEGAWAI_ID'] == $_GET['pegawai_id']) echo 'selected="selected"'; ?>><?php echo $data['NAMA_PEGAWAI']; ?></option>
								<?php
								}else{ ?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php  if($data['PEGAWAI_ID'] == $_GET['pegawai_id']) echo 'selected="selected"'; ?>>[<?php echo $data['KET_TIPE_PEGAWAI']; ?>]</option>
								<?php }
						}		
					}
				?>
            </select>
            <?php
            break;
		case 'cdokterjkn' :
			?>
            <select name="jkn_pegawai_id" id="jkn_pegawai_id" class="text_dt" style="width:228px;" class="text_dt" >
                <option value=""> - </option>
                <?php  $unit_id = $_GET['unit_id'];
					if(stripos($unit_id,'mcu') !== false) $unit_id = '38';
					$sql = 'SELECT m_pegawai.NAMA_PEGAWAI,t_dokter_jaga.UNIT_ID,t_dokter_jaga.PEGAWAI_ID,
							m_pegawai_tipe.KET_TIPE_PEGAWAI
							FROM m_pegawai
							INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
							INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)
							WHERE t_dokter_jaga.UNIT_ID = "' . $unit_id . '"';
					$get = mysql_query($sql) or die(mysql_error());
					while($data = mysql_fetch_array($get)){
					 if(!isset($_GET['pegawai_id'])){
							if($data['NAMA_PEGAWAI'] != '-'){
								?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($_GET['unit_id'],$data['PEGAWAI_ID'],cekCurrentDay())) echo 'selected="selected"'; ?>><?php echo $data['NAMA_PEGAWAI']; ?></option>
								<?php
								}else{ ?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php if(cekDokterJadwal($_GET['unit_id'],$data['PEGAWAI_ID'],cekCurrentDay())) echo 'selected="selected"'; ?>>[<?php echo $data['KET_TIPE_PEGAWAI']; ?>]</option>
								<?php }
						}else{
							if($data['NAMA_PEGAWAI'] != '-'){
								?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php  if($data['PEGAWAI_ID'] == $_GET['pegawai_id']) echo 'selected="selected"'; ?>><?php echo $data['NAMA_PEGAWAI']; ?></option>
								<?php
								}else{ ?>
								<option value="<?php echo $data['PEGAWAI_ID']; ?>" <?php  if($data['PEGAWAI_ID'] == $_GET['pegawai_id']) echo 'selected="selected"'; ?>>[<?php echo $data['KET_TIPE_PEGAWAI']; ?>]</option>
								<?php }
						}	
					}
				?>
            </select>
            <?php
            break;	
		case 'cnopeserta' :
            $sql_no_peserta = 'SELECT NO_PESERTA FROM t_irja WHERE NOMR = "' . $_GET['nomr'] . '"
								AND JENIS_BAYAR_ID = "' . $_GET['jenis_bayar_id'] . '"
								AND IRJA_ID <> "' . $_GET['idx'] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
			$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
			$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
			if(mysql_num_rows($get_no_peserta) > 0){
			?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NO_PESERTA']; ?>" size="34" />
			<?php
			}else{
				if($_GET['jenis_bayar_id'] == '9'){
					$sql_no_peserta = 'SELECT NIK FROM m_pasien WHERE NOMR = "' . $_GET['nomr'] . '"';
					$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
					$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
					?>
					<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NIK']; ?>" size="34" />
					<?php
				}else{
				?>
				<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="" size="34" />
				<?php
				}
			}
            break;
			
		case 'cnopesertaranap' :
            
			$xno_peserta = '';
			$sql_no_peserta = 'SELECT NO_PESERTA FROM t_irja WHERE NOMR = "' . $_GET['nomr'] . '"
								AND JENIS_BAYAR_ID = "' . $_GET['jenis_bayar_id'] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
			$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
			$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
			if(mysql_num_rows($get_no_peserta) > 0){
				$xno_peserta = $dat_no_peserta['NO_PESERTA']; 	
			}else{
				if($_GET['jenis_bayar_id'] == '9'){
					$sql_no_peserta = 'SELECT NIK FROM m_pasien WHERE NOMR = "' . $_GET['nomr'] . '"';
					$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
					$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
					$xno_peserta = $dat_no_peserta['NIK']; 	
				}
			}
			if($_GET['jenis_bayar_id'] == '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<br />
			<button type="button" onClick="getPeserta(1)" class="myButton1">cari kartu</button>
			<button type="button" onClick="getPeserta(2)" class="myButton1">cari ktp</button>
			<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
			<?php }else{ ?> 
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<?php }
            break;		
			
		case 'cnopesertarujuk' :
            
			$xno_peserta = '';
			$sql_no_peserta = 'SELECT NO_PESERTA FROM t_irja WHERE NOMR = "' . $_GET['nomr'] . '"
								AND JENIS_BAYAR_ID = "' . $_GET['jenis_bayar_id'] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
			$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
			$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
			if(mysql_num_rows($get_no_peserta) > 0){
				$xno_peserta = $dat_no_peserta['NO_PESERTA']; 	
			}else{
				if($_GET['jenis_bayar_id'] == '9'){
					$sql_no_peserta = 'SELECT NIK FROM m_pasien WHERE NOMR = "' . $_GET['nomr'] . '"';
					$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
					$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
					$xno_peserta = $dat_no_peserta['NIK']; 	
				}
			}
			
			if($_GET['jenis_bayar_id'] == '12' and $_GET['jenis_bayar_id_rujuk'] != '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<br />
			<button type="button" onClick="getPeserta(1)" class="myButton1">cari kartu</button>
			<button type="button" onClick="getPeserta(2)" class="myButton1">cari ktp</button>
			<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
			<?php }else{ ?> 
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<?php }
            break;			

		case 'cnopesertapenunjang' :
				if(!empty($_GET['no_peserta'])){
					if($_GET['jns_bayar'] == '12'){
						?>
							<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $_GET['no_peserta']; ?>" size="34" />
							<br />
							&nbsp;&nbsp;<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
							<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
							<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
						<?php
					}else{
						?>
							<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $_GET['no_peserta']; ?>" size="34" />
						<?php
					}
				}else{
                $sql_no_peserta = 'SELECT NO_PESERTA FROM t_irja WHERE NOMR = "' . $_GET['nomr'] . '"
								AND JENIS_BAYAR_ID = "' . $_GET['jns_bayar'] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
                $get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
                $dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
                if (mysql_num_rows($get_no_peserta) > 0) {
                    if($_GET['jns_bayar'] == '12'){
						?>
						<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NO_PESERTA']; ?>" size="34" />
						<br />
						&nbsp;&nbsp;<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
						<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
						<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
						<?php
					}else{
					?>
						<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NO_PESERTA']; ?>" size="34" />
                    <?php }
                } else {
                    if ($_GET['jns_bayar'] == '9') {
                        $sql_no_peserta = 'SELECT NIK FROM m_pasien WHERE NOMR = "' . $_GET['nomr'] . '"';
                        $get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
                        $dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
                        ?>
                        <input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NIK']; ?>" size="34" />
                        <?php
                    }else if ($_GET['jns_bayar'] == '12') {
					?>
						<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $dat_no_peserta['NO_PESERTA']; ?>" size="34" />
						<br />
						&nbsp;&nbsp;<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
						<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
						<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
					<?php
					} else {
                        ?>
                        <input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="" size="34" />
                        <?php
                    }
                }
				}
                break;
			
		case 'bayarirja' :
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

            mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '" 
						WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
				
			break;	
			
		case 'bayarmcunew' :
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

            mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			
			$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
			AND JNS_ORDER = "IRJ"';
			$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
			while($dat_penunjang = mysql_fetch_array($get_penunjang)){
					$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TANGGAL_BAYAR = NOW(),
						ST_BAYAR = "Lunas",SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}			
					
			break;		
			
		case 'batalbayarirja' :
			mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
						SHIFT_ID = NULL,USER_KASIR = "' . currentUser() . '",
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
						ST_BATAL = "' . $_GET['st'] . '"		
						WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
		
			break;
			
		case 'batalbayarmcu' :
			mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
						SHIFT_ID = NULL,USER_KASIR = "' . currentUser() . '",
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
						ST_BATAL = "' . $_GET['st'] . '"		
						WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			
			$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
							AND JNS_ORDER = "IRJ"';
			$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
			while($dat_penunjang = mysql_fetch_array($get_penunjang)){
					$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = NULL,TANGGAL_BAYAR = NULL,
						ST_BAYAR = NULL,SHIFT_KASIR = NULL,USER_KASIR = "' . currentUser() . '",
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
						ST_BATAL_BAYAR = "' . $_GET['st'] . '"	
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
			
			break;	
			
		case 'klinikformaadtindakan' :
			
				$sql_cek_mcu = 'SELECT KODE_TARIF,KODE_TARIF_GROUP FROM m_tarif WHERE TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_cek_mcu = mysql_query($sql_cek_mcu) or die(mysql_error());
				$dat_cek_mcu = mysql_fetch_assoc($get_cek_mcu);
				if($dat_cek_mcu['KODE_TARIF_GROUP'] != '170'){
					$deskripsi = 'Tindakan Di Poliklinik';
					if(currentModul() == 'igd') $deskripsi = 'Tindakan Di IGD';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"' . $deskripsi . '")') or die(mysql_error());
				}else{
					//tindakan paket MCU
					$arr_mcu_s = '"00000",';
					$arr_mcu_s .= '"' . $dat_cek_mcu['KODE_TARIF'] . '",';
					$sql = 'SELECT KODE_TARIF FROM m_tarif WHERE KODE_TARIF LIKE "CVD' . $dat_cek_mcu['KODE_TARIF'] . '%"';
					$get = mysql_query($sql) or die(mysql_error());
					while($dat = mysql_fetch_array($get)){
						$arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",'; 
					}
					$arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
					
					$arr_tindakan = array();
					$arr_laboratorium = array();	
					$arr_radiologi = array();
					$arr_ekgusg = array();		
					
					$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
								m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
								m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
								FROM m_tarif
								INNER JOIN m_tarif_group 
								ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
								WHERE m_tarif.KODE_TARIF IN (' . $arr_mcu_s . ') 
								AND (m_tarif.MCU = "1" OR m_tarif.ST_AKTIF = "1")') or die(mysql_error());			
			
					while($dat_tarif = mysql_fetch_array($get_tarif)){
						if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
							and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
							and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
							
						if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
							or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
						if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
							or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
						if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
					}
					
					$no_bayar = 'NULL';
					$st_bayar = 'NULL';
					if($dat_cek_no_klinik['JENIS_BAYAR_ID'] <> '1'){
						$no_bayar = '"' . getNomorHarian('Kasir') . '"';
						$st_bayar = '"Lunas"';
					}
					$nomor = getNomorHarian('Tarif');
					$tgl_tarif = 'STR_TO_DATE("' . getDatetimeSkr() . '","%d/%m/%Y %H:%i:%s")';	
					$nomor_order = getNomorBulanan('IPENUNJANG');
					$no_sjp = getNomorHarian('SJP');
					
					if(sizeof($arr_tindakan) > 0){
						foreach($arr_tindakan as $tarif){
						$kuantiti = 0;
						if($tarif == $_GET['tarif_id']) $kuantiti = '1';	
							mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
									DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
									VALUES("' . $_GET['irja_id'] . '",' . $tgl_tarif . ',"' . $tarif . '","' . $kuantiti . '","' . $nomor . '",
									' . $no_bayar . ',"Paket Skrining Covid-19",' . $st_bayar . ',"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '",
									"' . currentUser() . '",NULL)') or die(mysql_error());	
						}
					}	
			
					if(sizeof($arr_laboratorium) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"LAB","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_laboratorium as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "45",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
			
					if(sizeof($arr_radiologi) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"RAD","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_radiologi as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
			
					if(sizeof($arr_ekgusg) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"EKG","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_ekgusg as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "52",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
					//end tindakan paket COVID-19
				}	
			echo 'ok';
			
			break;
			
		case 'klinikformaadtindakanauto' :
			
			$tindakan_array = explode('--', $_GET['tarif_id']);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$deskripsi = 'Tindakan Di Poliklinik';
					if(currentModul() == 'igd') $deskripsi = 'Tindakan Di IGD';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $dat_tarif_id['TARIF_ID'] . '",1,"' . $deskripsi . '")') or die(mysql_error());	
				}
			}
			break;	
			
		case 'kasirformaadtindakan' :
			mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"Tindakan (Kasir)")') or die(mysql_error());
			break;

		case 'kasirformaadtindakanauto' :
			$tindakan_array = explode('--', $_GET['tarif_id']);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $dat_tarif_id['TARIF_ID'] . '",1,"Tindakan (Kasir)")') or die(mysql_error());	
				}
			}
			break;			
			
		case 'umur' :
			echo getUmur($_GET['tgl_lahir']);
            break;
			
		case 'bayarfarmasi' :
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
					SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					NO_PEMBAYARAN = "' . $no_bayar . '",
					TANGGAL_BAYAR = NOW(),
					KODE_CASH = "' . $_GET['ch'] . '",
					PERC_POTONGAN = "' . $potongan . '",
					KODE_REKENING = "' . $_GET['rk'] . '",
					APS_MASUK = "' . $_SESSION['SES_SIMRS_SHIFT_KASIR'] . '"	
					WHERE FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '" 
					AND NO_PENGELUARAN = "' . $_GET['no'] . '"') or die(mysql_error());
			break;
			
		case 'batalbayarfarmasi' :
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
					SHIFT_PEMBAYARAN = NULL,
					NO_PEMBAYARAN = NULL,
					TANGGAL_BAYAR = NULL,
					KODE_CASH = NULL,
					PERC_POTONGAN = 0,
					KODE_REKENING = NULL,
					ST_BATAL_BAYAR = "' . $_GET['st'] . '" 	
					WHERE FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '" 
					AND NO_PENGELUARAN = "' . $_GET['no'] . '"') or die(mysql_error());

			break;
			
		 case 'ctmptidur' :
			$sql_tmp_tidur = 'SELECT COUNT(t_irna.IRNA_ID) AS ISI,m_ruang_detail.NO_TMP_TIDUR
							FROM m_ruang_detail
							LEFT JOIN t_irna ON (t_irna.NO_TMP_TIDUR = m_ruang_detail.NO_TMP_TIDUR AND t_irna.ST_PULANG IS NULL)
							WHERE m_ruang_detail.RUANG_ID = "' . $_GET['ruang_id'] . '"
							GROUP BY m_ruang_detail.NO_TMP_TIDUR';
			$get_tmp_tidur = mysql_query($sql_tmp_tidur) or die(mysql_error());				
            ?>
            <select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
                <?php while($dat_tmp_tidur = mysql_fetch_array($get_tmp_tidur)){  ?>
					<option value="<?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?>"><?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?></option>
				<?php }  ?>
            </select>
            <?php
            break;
			
		case 'ctmptidurjkn' :
			$sql_tmp_tidur = 'SELECT COUNT(t_irna.IRNA_ID) AS ISI,m_ruang_detail.NO_TMP_TIDUR
							FROM m_ruang_detail
							LEFT JOIN t_irna ON (t_irna.NO_TMP_TIDUR = m_ruang_detail.NO_TMP_TIDUR AND t_irna.ST_PULANG IS NULL)
							WHERE m_ruang_detail.RUANG_ID = "' . $_GET['ruang_id'] . '"
							GROUP BY m_ruang_detail.NO_TMP_TIDUR';
			$get_tmp_tidur = mysql_query($sql_tmp_tidur) or die(mysql_error());				
            ?>
            <select name="jkn_tmp_tidur" id="jkn_tmp_tidur" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
                <?php while($dat_tmp_tidur = mysql_fetch_array($get_tmp_tidur)){ 
				if($dat_tmp_tidur['ISI'] == 0){ ?>
					<option value="<?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?>"><?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?></option>
				<?php } } ?>
            </select>
            <?php
            break;
	

		case 'pasienpulang' :
			$shift = 'NULL';
			if(isset($_SESSION['SES_SIMRS_SHIFT'])) $shift =  '"' . $_SESSION['SES_SIMRS_SHIFT'] . '"';
			mysql_query('UPDATE t_irna SET ST_PULANG = "1",USER_KASIR = "' . currentUser() . '",
						PASIEN_KELUAR = NOW(),SHIFT_ID_PULANG = ' . $shift . '
						WHERE IRNA_ID = "' . $_GET['idx'] .'"') or die(mysql_error());
			$sql_cek_no_ranap = 'SELECT NOMR,RUANG_ID,PEGAWAI_ID,PEGAWAI_RAWAT_ID,JENIS_BAYAR_ID,
							DATE_FORMAT(PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK
							FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
			$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
			$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);			
			mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
						RUANG_ID_ASAL,PEGAWAI_ID,PEGAWAI_RAWAT_ID,
						KETERANGAN_PINDAH,JENIS_BAYAR_ID,TANGGAL_KELUAR,LAMA_DIRAWAT)
						VALUES("' . $_GET['idx'] . '","' . $dat_cek_no_ranap['NOMR'] . '",NOW(),"R",
						"' . $dat_cek_no_ranap['RUANG_ID'] . '","' . $dat_cek_no_ranap['PEGAWAI_ID'] . '",
						"' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID'] . '","Pasien Keluar",
						"' . $dat_cek_no_ranap['JENIS_BAYAR_ID'] . '",NOW(),
						DATEDIFF(NOW(),STR_TO_DATE("' . $dat_cek_no_ranap['TANGGAL_MASUK'] . '","%d/%m/%Y %H:%i:%s")) + 1)') or die(mysql_error());				
            break;	
		
		case 'kasirformaadtindakanirna' :
			mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT) VALUES("' . $_GET['irna_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"Tindakan (Kasir)","' . $_GET['kelas'] . '")') or die(mysql_error());
			break;
		
		case 'kasirformaadtindakanirnaauto' :
			$tindakan_array = explode('--', $_GET['tarif_id']);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT) VALUES("' . $_GET['irna_id'] . '",NOW(),"' . $dat_tarif_id['TARIF_ID'] . '",1,"Tindakan (Kasir)","' . $_GET['kelas'] . '")') or die(mysql_error());	
				}
			}
			break;
		case 'bayarirna' :
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

            mysql_query('UPDATE t_irna_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE IRNA_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			break;
		case 'batalbayarirna' :
			mysql_query('UPDATE t_irna_tarif SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
						SHIFT_ID = NULL,USER_KASIR = "' . currentUser() . '",
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL  
						WHERE IRNA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			break;
				
		case 'klinikformaadlaboratorium' :
			
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"LAB","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			echo 'ok';
			
			break;
		
		case 'bayarpenunjang' :
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

			if(strtoupper($_GET['ord']) == 'APS'){
				$penunjang_id = $_GET['idx'];
				mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '",
						APS_MASUK = "' . $_SESSION['SES_SIMRS_SHIFT_KASIR'] . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}else{
				$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"';
				$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
				while($dat_penunjang = mysql_fetch_array($get_penunjang)){
					$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '" 
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
				}
			}
				
		break;
			
		case 'batalbayarpenunjang' :
				$sql_order = 'SELECT t_ipenunjang.JNS_ORDER 
						FROM t_ipenunjang 
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						WHERE t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"';
				$get_order = mysql_query($sql_order) or die(mysql_error());			
				$dat_order = mysql_fetch_assoc($get_order);
				
				if($dat_order['JNS_ORDER'] == 'APS'){
					$penunjang_id = $_GET['idx'];
					mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = NULL,TANGGAL_BAYAR = NULL,ST_BAYAR = NULL,
						SHIFT_KASIR = NULL,USER_KASIR = "' . currentUser() . '",
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
						APS_MASUK = NULL,ST_BATAL_BAYAR = "' . $_GET['st'] . '"	 
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
				}else{
					$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
							AND JNS_ORDER = "' . $dat_order['JNS_ORDER'] . '"';
					$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
					while($dat_penunjang = mysql_fetch_array($get_penunjang)){
						$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
						mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = NULL,TANGGAL_BAYAR = NULL,ST_BAYAR = NULL,
							SHIFT_KASIR = NULL,USER_KASIR = "' . currentUser() . '",
							KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
							ST_BATAL_BAYAR = "' . $_GET['st'] . '"	 	
							WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					}
				}
				
            break;
			
		case 'penunjangformaadperiksa' :
			mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $_GET['penunjang_id'] . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());	
			break;
			
		case 'klinikformaadradiologi' :
			
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"RAD","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			echo 'ok';
			
			break;	

		case 'tambahtarif' :
			$tahun_y = $_GET['tahun'];
			$sql_cek_tahun_x = 'SELECT TAHUN_UPDATE FROM m_tarif ORDER BY TAHUN_UPDATE DESC LIMIT 1';
			$get_cek_tahun_x = mysql_query($sql_cek_tahun_x) or die(mysql_error());
			$dat_cek_tahun_x = mysql_fetch_assoc($get_cek_tahun_x);
			$tahun_x = $dat_cek_tahun_x['TAHUN_UPDATE']; 
			$sql_cek_tahun = 'SELECT TAHUN_UPDATE FROM m_tarif WHERE TAHUN_UPDATE = "' . $_GET['tahun'] . '"';
			$get_cek_tahun = mysql_query($sql_cek_tahun) or die(mysql_error());
			if(mysql_num_rows($get_cek_tahun) == 0){
				mysql_query('INSERT INTO m_tarif(KODE_TARIF,NAMA_TARIF,SATUAN,KODE_TARIF_GROUP,JASA_SARANA,
							JASA_DOKTER,JASA_RS,JASA_PELAYANAN,TARIF_NON_KELAS,TARIF_KELAS_3,TARIF_KELAS_2,
							TARIF_KELAS_1,TARIF_KELAS_UTAMA,
							ICD_CODE,TAHUN_UPDATE,USER_ADMIN,
							USER_RM) 
							SELECT KODE_TARIF,NAMA_TARIF,SATUAN,KODE_TARIF_GROUP,JASA_SARANA,
							JASA_DOKTER,JASA_RS,JASA_PELAYANAN,TARIF_NON_KELAS,TARIF_KELAS_3,TARIF_KELAS_2,
							TARIF_KELAS_1,TARIF_KELAS_UTAMA,
							ICD_CODE,"' . $_GET['tahun'] . '","' . currentUser() . '",USER_RM
							FROM m_tarif WHERE TAHUN_UPDATE = "' . $tahun_x . '"') or die(mysql_error());
			}
			break;
			
		case 'aktifkantarif' :
			mysql_query('UPDATE m_tarif SET ST_AKTIF = NULL') or die(mysql_error());
			mysql_query('UPDATE m_tarif SET ST_AKTIF = "1" WHERE TAHUN_UPDATE = "' . $_GET['tahun'] . '"') or die(mysql_error());
			break;
			
		case 'kasirformaddpenunjang' :
		
				$sql_unit = 'SELECT CASE WHEN m_tarif_group.LABORATORIUM = "1" THEN "45"
								 WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN "45"
								 WHEN m_tarif_group.RADIOLOGI = "1" THEN "17"
								 WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN "17"
								 WHEN m_tarif_group.UNIT_ID IS NOT NULL THEN m_tarif_group.UNIT_ID
								 WHEN m_tarif.UNIT_ID IS NOT NULL THEN m_tarif.UNIT_ID END AS UNIT_ID
						FROM m_tarif
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 	
				
				if($_GET['ord'] != 'aps'){
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" AND t_ipenunjang.JNS_PENUNJANG = "PNJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['penunjang_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.DESKRIPSI IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","' . strtoupper($_GET['ord']) . '","' . $_GET['penunjang_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['penunjang_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.DESKRIPSI IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"' . $unit_id . '")') or die(mysql_error());
				}else{
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $_GET['penunjang_id'] . '","' . $_GET['tarif_id'] . '",1,"' . $unit_id . '")') or die(mysql_error());
				}
				
				echo 'ok';
			break;
			
		case 'kasirformaddpenunjangauto' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
				$sql_unit = 'SELECT CASE WHEN m_tarif_group.LABORATORIUM = "1" THEN "45"
								 WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN "45"
								 WHEN m_tarif_group.RADIOLOGI = "1" THEN "17"
								 WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN "17"
								 WHEN m_tarif_group.UNIT_ID IS NOT NULL THEN m_tarif_group.UNIT_ID
								 WHEN m_tarif.UNIT_ID IS NOT NULL THEN m_tarif.UNIT_ID END AS UNIT_ID
						FROM m_tarif
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 		
					
				if($_GET['ord'] != 'aps'){
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" AND t_ipenunjang.JNS_PENUNJANG = "PNJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['penunjang_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","' . strtoupper($_GET['ord']) . '","' . $_GET['penunjang_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['penunjang_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,"' . $unit_id . '")') or die(mysql_error());
				}else{
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $_GET['penunjang_id'] . '","' . $tarif_id . '",1,"' . $unit_id . '")') or die(mysql_error());
				}
				}
			}
				echo 'ok';	
			break;
			
			case 'klinikdelracikan' :
				mysql_query('DELETE FROM t_irja_resep_racikan WHERE IRJA_RESEP_RACIKAN_ID = "' . $_GET['racikan_id'] . '"') or die(mysql_error());
				
				$sql_racikan = 'SELECT  t_irja_resep_racikan.IRJA_RESEP_RACIKAN_ID,t_irja_resep_racikan.IRJA_RESEP_ID,
					t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH
					FROM t_irja_resep_racikan WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $_GET['resep_id'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){				
				?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<?php while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
					<td><?php echo $dat_racikan['RESEP']; ?></td>
					<td width="100"><?php echo $dat_racikan['JUMLAH']; ?></td>
					<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=klinikdelracikan&racikan_id=<?php echo $dat_racikan['IRJA_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['IRJA_RESEP_ID']; ?>');return false;" >hapus</a></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3" align="right"><input type="button" value="selesai racikan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
				</tr>
				</table>
				</div>
				<?php }
			break;
			
			case 'klinikdiagnosagigi' :
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['idx'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_GET['idx'] . '"
								ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
					$get_order = mysql_query($qry_order);
					$dat_order = mysql_fetch_assoc($get_order);
					$diagnosa_order = 0;
					if (mysql_num_rows($get_order) > 0)
						$diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
        
						mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE)
								VALUES("' . $_GET['idx'] . '","' . $diagnosa_order . '","' . $_GET['diagnosa'] . '",NULL)') or die(mysql_error());	
				}			
			break;
			
			case 'klinikdiagnosakusta' :
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['idx'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_GET['idx'] . '"
								ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
					$get_order = mysql_query($qry_order);
					$dat_order = mysql_fetch_assoc($get_order);
					$diagnosa_order = 0;
					if (mysql_num_rows($get_order) > 0)
						$diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
        
						mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE)
								VALUES("' . $_GET['idx'] . '","' . $diagnosa_order . '","' . $_GET['diagnosa'] . '","' . $_GET['icd'] . '")') or die(mysql_error());	
				}			
			break;
			
			case 'ranapformaadtindakanirna' :
								
					$sql_cek_mcu = 'SELECT KODE_TARIF,KODE_TARIF_GROUP FROM m_tarif WHERE TARIF_ID = "' . $_GET['tarif_id'] . '"';
					$get_cek_mcu = mysql_query($sql_cek_mcu) or die(mysql_error());
					$dat_cek_mcu = mysql_fetch_assoc($get_cek_mcu);
					if($dat_cek_mcu['KODE_TARIF_GROUP'] != '170'){
						mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,
							DESKRIPSI,KELAS_RAWAT,RUANG_ID,PEGAWAI_ID) 
							VALUES("' . $_GET['irna_id'] . '","' . $_GET['tarif_id'] . '",1,"Tindakan (Ruang Rawat)",
							"' . $_GET['kelas'] . '","' . $_GET['ruang'] . '","' . $_GET['pegawai'] . '")') or die(mysql_error());
					}else{
						//tindakan paket COVID-19
						$arr_mcu_s = '"00000",';
						$arr_mcu_s .= '"' . $dat_cek_mcu['KODE_TARIF'] . '",';
						$sql = 'SELECT KODE_TARIF FROM m_tarif WHERE KODE_TARIF LIKE "CVD' . $dat_cek_mcu['KODE_TARIF'] . '%"';
						$get = mysql_query($sql) or die(mysql_error());
						while($dat = mysql_fetch_array($get)){
							$arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",'; 
						}
						$arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
					
						$arr_tindakan = array();
						$arr_laboratorium = array();	
						$arr_radiologi = array();
						$arr_ekgusg = array();		
					
						$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
								m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
								m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
								FROM m_tarif
								INNER JOIN m_tarif_group 
								ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
								WHERE m_tarif.KODE_TARIF IN (' . $arr_mcu_s . ') 
								AND (m_tarif.MCU = "1" OR m_tarif.ST_AKTIF = "1")') or die(mysql_error());		
			
						while($dat_tarif = mysql_fetch_array($get_tarif)){
							if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
								and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
								and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
							
							if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
								or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
							if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
								or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
							if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
						}
			
						if(sizeof($arr_tindakan) > 0){
							foreach($arr_tindakan as $tarif){
								$kuantiti = '0';
								if($tarif == $_GET['tarif_id']) $kuantiti = '1';
								mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,
									DESKRIPSI,KELAS_RAWAT,RUANG_ID,PEGAWAI_ID) 
									VALUES("' . $_GET['irna_id'] . '","' . $tarif . '","' . $kuantiti . '","Paket Skrining Covid-19",
									"' . $_GET['kelas'] . '","' . $_GET['ruang'] . '","' . $_GET['pegawai'] . '")') or die(mysql_error());			
							}
						}	
			
						if(sizeof($arr_laboratorium) > 0){
							mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,MCU,DESKRIPSI) VALUES(
								"LAB","IRN","' . $_GET['irna_id'] . '","' . $_GET['tarif_id'] . '","Paket Skrining Covid-19")') or die(mysql_error());
							$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
									AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" 
									AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.MCU = "' . $_GET['tarif_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
							$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
							$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
							$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];					
										
							foreach($arr_laboratorium as $tarif){
								mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) 
									VALUES("' . $penunjang_id . '","' . $tarif . '",0)') or die(mysql_error());	
							}
						}
			
						if(sizeof($arr_radiologi) > 0){
							mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,MCU,DESKRIPSI) VALUES(
								"RAD","IRN","' . $_GET['irna_id'] . '","' . $_GET['tarif_id'] . '","Paket Skrining Covid-19")') or die(mysql_error());
							$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" 
									AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" 
									AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.MCU = "' . $_GET['tarif_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
							$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
							$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
							$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];					
										
							foreach($arr_radiologi as $tarif){
								mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) 
									VALUES("' . $penunjang_id . '","' . $tarif . '",0)') or die(mysql_error());	
							}
						}
			
						if(sizeof($arr_ekgusg) > 0){
							mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,MCU,DESKRIPSI) VALUES(
								"EKG","IRN","' . $_GET['irna_id'] . '","' . $_GET['tarif_id'] . '","Paket Skrining Covid-19")') or die(mysql_error());
							$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" 
									AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" 
									AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.MCU = "' . $_GET['tarif_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
							$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
							$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
							$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];					
										
							foreach($arr_ekgusg as $tarif){
								mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) 
									VALUES("' . $penunjang_id . '","' . $tarif . '",0)') or die(mysql_error());	
							}
						}
					//end tindakan paket COVID-19
					}	
			echo 'ok';
			
			break;
			
			case 'ranapformaadtindakanirnaauto' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
					if(mysql_num_rows($get_tarif_id) > 0){
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,RUANG_ID,PEGAWAI_ID) VALUES("' . $_GET['irna_id'] . '","' . $dat_tarif_id['TARIF_ID'] . '",1,"Tindakan (Ruang Rawat)","' . $_GET['kelas'] . '","' . $_GET['ruang'] . '","' . $_GET['pegawai'] . '")') or die(mysql_error());	
					}
				}
				echo 'ok';	
			break;
			
			case 'ranapformaadlaboratorium' :
							
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"LAB","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			echo 'ok';
			
			break;
			
			case 'ranapformaadradiologi' :
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"RAD","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			echo 'ok';
			
			break;	
			
			case 'pendaftaranformaddpenunjang' :
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $_GET['penunjang_id'] . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			break;
			
		case 'pendaftaranformaddpenunjangauto' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $_GET['penunjang_id'] . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			}	
			break;
			
		case 'klinikformaadpenunjang' :
						
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				
				$sql_unit = 'SELECT m_tarif_group.UNIT_ID
							FROM m_tarif
							INNER JOIN m_tarif_group 
							ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE m_tarif.TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) 
					VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"' . $unit_id . '")') or die(mysql_error());
			
			echo 'ok';
			
			break;
			
		case 'ranapformaadpenunjang' :
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				
				$sql_unit = 'SELECT m_tarif_group.UNIT_ID
							FROM m_tarif
							INNER JOIN m_tarif_group 
							ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE m_tarif.TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) 
					VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"' . $unit_id . '")') or die(mysql_error());
			
			echo 'ok';
			
			break;	

		case 'klinikformaadlaboratoriumauto' :
				
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"LAB","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			 }
			
			break;		
			
			case 'klinikformaadradiologiauto' :
			
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"RAD","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			 }
			
			break;	
			
			case 'klinikformaadpenunjangauto' :
				
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				
				$sql_unit = 'SELECT m_tarif_group.UNIT_ID
							FROM m_tarif
							INNER JOIN m_tarif_group 
							ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE m_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) 
					VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,"' . $unit_id . '")') or die(mysql_error());
				}
			 }
		
			break;
			
			case 'totalpenunjang' :
			if(!isset($_SESSION['nilai_bayar'])) $_SESSION['nilai_bayar'] = 0;
			if($_GET['opt'] == 1) $_SESSION['nilai_bayar'] = $_SESSION['nilai_bayar'] + $_GET['nilai'];
			if($_GET['opt'] == 2) $_SESSION['nilai_bayar'] = $_SESSION['nilai_bayar'] - $_GET['nilai'];
			echo 'Total Rp.&nbsp;&nbsp;' . currFormat($_SESSION['nilai_bayar']);
			break;
			
			case 'pendaftaranformaadpenunjangdaftar' :
				$penunjang_id = $_GET['irja_id'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
				echo 'ok';
				
			break;
			
			case 'laboratoriumstdiagnosa' :
				if($_GET['opt'] == 1){
										
					if($_GET['ord'] != 'aps'){					
						mysql_query('UPDATE t_ipenunjang_tarif JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.ST_DIAGNOSA = "1"
								WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['id'] . '" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
								AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_ipenunjang_tarif JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.ST_DIAGNOSA = "1"
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['id'] . '" AND t_ipenunjang.JNS_ORDER = "APS"
								AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					}
				
				}
				if($_GET['opt'] == 2){
					if($_SESSION['SES_SIMRS_ADMIN'] == 1){
						
						if($_GET['ord'] != 'aps'){					
						mysql_query('UPDATE t_ipenunjang_tarif JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.ST_DIAGNOSA = NULL
								WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['id'] . '" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
								AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_ipenunjang_tarif JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.ST_DIAGNOSA = NULL
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['id'] . '" AND t_ipenunjang.JNS_ORDER = "APS"
								AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					}
					
					}	
				}
			break;
			
			case 'pendaftaranformaadtindakan' :
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"Tindakan (Pendaftaran)")') or die(mysql_error());
			break;
			
			case 'pendaftarantmptindakan' :
				/*$rawat_id = $_GET['rawat_id'];
				$nomr = $_GET['nomr'];
				?>
				<table class="tableData" id="tfhover" >
				<?php include('pendaftaran/pendaftaran_tmp_penunjang.php'); ?>
				<tr>
				<td colspan="6" align="right"><div id="total">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total);?></div></td>
				<td colspan="4">&nbsp;</td>
				</tr>
				</table>
				<input type="hidden" name="cnt_p" value="<?php echo $i; ?>" />
				<?php */
				
				$unit_id = $_GET['unit_id'];
				$rawat_id = $_GET['rawat_id'];
				$tgl_daftar = $_GET['tgl_daftar'];
				$tgl_daftar_rujuk = $_GET['tgl_daftar_rujuk'];
				$nomr = $_GET['nomr'];
				?>
				<table class="tableData" id="tfhover" >
				<?php include('pendaftaran/pendaftaran_tmp_penunjang.php'); ?>
				<tr>
				<td colspan="5" align="right"><div id="total">Total Rp.&nbsp;&nbsp;0</div></td>
				<td colspan="4">&nbsp;</td>
				</tr>
				</table>
				<input type="hidden" name="cnt_p" value="<?php echo $i; ?>" />
				<?php
			break;	
			
			case 'pendaftaranpelaksanapenunjang' :
				$unit_id = $_GET['unit_id'];
				?>
				<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<?php echo getPelaksanaPenunjang('',$unit_id); ?>
				</select>
				<?php
			break;
			
			case 'pendaftaranpelaksanapenunjangjkn' :
				$unit_id = $_GET['unit_id'];
				?>
				<select name="jkn_pegawai_id" id="jkn_pegawai_id" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<?php echo getPelaksanaPenunjang('',$unit_id); ?>
				</select>
				<?php
			break;
			
			case 'cnopesertaedit' :
            
			$xno_peserta = '';
			$sql_no_peserta = 'SELECT NO_PESERTA FROM t_irja WHERE NOMR = "' . $_GET['nomr'] . '"
								AND JENIS_BAYAR_ID = "' . $_GET['jenis_bayar_id'] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
			$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
			$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
			if(mysql_num_rows($get_no_peserta) > 0){
				$xno_peserta = $dat_no_peserta['NO_PESERTA']; 	
			}else{
				if($_GET['jenis_bayar_id'] == '9'){
					$sql_no_peserta = 'SELECT NIK FROM m_pasien WHERE NOMR = "' . $_GET['nomr'] . '"';
					$get_no_peserta = mysql_query($sql_no_peserta) or die(mysql_error());
					$dat_no_peserta = mysql_fetch_assoc($get_no_peserta);
					$xno_peserta = $dat_no_peserta['NIK']; 	
				}
			}
			if($_GET['jenis_bayar_id'] == '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<button type="button" onClick="getPeserta(1)" class="myButton1">cari kartu</button>
			<button type="button" onClick="getPeserta(2)" class="myButton1">cari ktp</button>
			<?php }else{ ?> 
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $xno_peserta; ?>" size="34" />
			<?php }
            break;	
			
			case 'tampilnosep' :
			$xno_sep = '';
			if($_GET['opt'] == 1){
				if($_GET['jns'] == $_GET['jns_a']){
					$sqlsep = 'SELECT t_irja.NO_SEP FROM t_irja WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
					$getsep = mysql_query($sqlsep) or die(mysql_error());
					$datsep = mysql_fetch_assoc($getsep);
					$xno_sep = $datsep['NO_SEP']; 
				}
				?>
				<input type="text" name="jkn_no_sep" id="jkn_no_sep" class="text_dt" value="<?php echo $xno_sep; ?>" size="25" />
				<button type="button" onClick="createSEP(2)" class="myButton1">buat</button>
				<button type="button" onClick="updateSEP(2)" class="myButton1">update</button>
				<?php
			}else if($_GET['opt'] == 2){
				if($_GET['jns'] == $_GET['jns_a']){
					$sqlsep = 'SELECT t_irja.NO_SEP FROM t_irja WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
					$getsep = mysql_query($sqlsep) or die(mysql_error());
					$datsep = mysql_fetch_assoc($getsep);
					$xno_sep = $datsep['NO_SEP']; 
				}
				?>
				<input type="text" name="no_sep" id="no_sep" class="text_dt" value="<?php echo $xno_sep; ?>" size="34" />
				<?php
			}
			
			break;
			
			case 'tampilnosepranap' :
			$xno_sep = '';
			if($_GET['opt'] == 1){
				if($_GET['jns'] == $_GET['jns_a']){
					$sqlsep = 'SELECT t_irna.NO_SEP FROM t_irna WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
					$getsep = mysql_query($sqlsep) or die(mysql_error());
					$datsep = mysql_fetch_assoc($getsep);
					$xno_sep = $datsep['NO_SEP']; 
				}
				?>
				<input type="text" name="jkn_no_sep" id="jkn_no_sep" class="text_dt" value="<?php echo $xno_sep; ?>" size="25" />
				<button type="button" onClick="createSEP(1)" class="myButton1">buat</button>
				<button type="button" onClick="updateSEP(1)" class="myButton1">update</button>
				<?php
			}else if($_GET['opt'] == 2){
				if($_GET['jns'] == $_GET['jns_a']){
					$sqlsep = 'SELECT t_irja.NO_SEP FROM t_irja WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
					$getsep = mysql_query($sqlsep) or die(mysql_error());
					$datsep = mysql_fetch_assoc($getsep);
					$xno_sep = $datsep['NO_SEP']; 
				}
				?>
				<input type="text" name="no_sep" id="no_sep" class="text_dt" value="<?php echo $xno_sep; ?>" size="34" />
				<?php
			}
			
			break;
			
			case 'batalpendaftaranpenunjang' :
				$sql_penunjang = 'SELECT ti.RAWAT_ID,ti.NO_ORDER,tt.UNIT_PENUNJANG_ID 
					FROM t_ipenunjang ti
					INNER JOIN t_ipenunjang_tarif tt 
					ON (ti.PENUNJANG_ID = tt.PENUNJANG_ID)
					WHERE NO_SJP = "' . $_GET['no'] . '"';
				$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());	
				$dat_penunjang = mysql_fetch_assoc($get_penunjang);
				
				mysql_query('UPDATE t_ipenunjang_tarif SET ST_BATAL = "1" WHERE NO_SJP = "' . $_GET['no'] . '"') or die(mysql_error());
				
				if($dat_penunjang['UNIT_PENUNJANG_ID'] == '45'){
					include('lis/simrs2lis.php');
					lis_cancel_order($dat_penunjang['RAWAT_ID'],$dat_penunjang['NO_ORDER']);
				}	
			break;
			
			case 'pemeriksaanlab' :
			?>
				<select name="pemeriksaan" class="text_dt" onchange="javascript: MyAjaxRequest('itm_pemeriksaan','index.php?ajaxrequest=itempemeriksaanlab&group=' + document.getElementById('pemeriksaan_group').value + '&periksa=' + this.value);return false;" >
				<?php
				$sql_pemeriksaan = 'SELECT DISTINCT CONCAT(NAMA_PEMERIKSAAN_GROUP," ",NAMA_PEMERIKSAAN) AS NAMA_PEMERIKSAAN FROM m_tarif_pemeriksaan WHERE CH_REPORT = "' . $_GET['group'] . '"';
				$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
				while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){ ?>
					<option value="<?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?>" ><?php echo $dat_pemeriksaan['NAMA_PEMERIKSAAN']; ?></option>
				<?php } ?>
			</select>
			<?php
			break;
			
			case 'itempemeriksaanlab' :
			$qry_rujukan = 'SELECT m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID,m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,m_nilai_rujukan_laboratorium.UMUR_HARI,
				m_nilai_rujukan_laboratorium.NILAI_RUJUKAN,m_nilai_rujukan_laboratorium.JNS_KELAMIN_LK,
				m_nilai_rujukan_laboratorium.JNS_KELAMIN_PR,m_nilai_rujukan_laboratorium.SATUAN,
				m_nilai_rujukan_laboratorium.CH_REPORT,m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN,
				m_nilai_rujukan_laboratorium.METHODE,m_nilai_rujukan_laboratorium.LABEL_UMUR
				FROM m_nilai_rujukan_laboratorium
				WHERE m_nilai_rujukan_laboratorium.CH_REPORT = "' . $_GET['group'] . '"
				AND m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN = "' . $_GET['periksa'] . '"
				ORDER BY m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,m_nilai_rujukan_laboratorium.UMUR_HARI';
			$get_rujukan = mysql_query($qry_rujukan) or die(mysql_error());
			?>
			<table border="1" class="tableData" id="tfhover" >
				<tr>
					<th>No</th>
					<th>Keterangan Umur</th>
					<th>Umur Tahun</th>
					<th>Umur Bulan</th>
					<th>Umur Hari</th>
					<th>Laki-laki</th>
					<th>Perempuan</th>
					<th>Satuan</th>
					<th>Nilai Rujukan</th>
					<th>Methode</th>
					<th>Option</th>
				</tr>
			<?
					$no = 1;
					while ($dat_rujukan = mysql_fetch_array($get_rujukan)) {
						$id = $dat_rujukan['NILAI_RUJUKAN_ID'];
						?>
						<tr>
							<td width="20" align="center"><?php echo $no; ?></td>
							<td><?php echo $dat_rujukan['LABEL_UMUR']; ?></td>
							<td align="right"><?php echo $dat_rujukan['UMUR_TAHUN']; ?></td>
							<td align="right"><?php echo $dat_rujukan['UMUR_BULAN']; ?></td>
							<td align="right"><?php echo $dat_rujukan['UMUR_HARI']; ?></td>
							<td align="center"><?php if($dat_rujukan['JNS_KELAMIN_LK'] == '1') echo '&radic;'; ?></td>
							<td align="center"><?php if($dat_rujukan['JNS_KELAMIN_PR'] == '1') echo '&radic;'; ?></td>
							<td><?php echo $dat_rujukan['SATUAN']; ?></td>
							<td><?php echo $dat_rujukan['NILAI_RUJUKAN']; ?></td>
							<td><?php echo $dat_rujukan['METHODE']; ?></td>
							<td width="80" align="center"><a href="index.php?link=<?php echo md5('laboratoriumformaddnilairujukan'); ?>&idx=<?php echo $id; ?>&pemeriksaan_group=<?php echo $dat_rujukan['CH_REPORT']; ?>&pemeriksaan=<?php echo $dat_rujukan['NAMA_PEMERIKSAAN']; ?>">edit</a>
							<a href="index.php?link=471c9e301765cb7d6c98bc74f71d623c&idd=<?php echo $id; ?>">hapus</a></td>
						</tr>
						<?
					$no++; }
					?>
				</table>
			<?php
			break;
			
			case 'pendaftaranformaadpenunjangdaftarauto' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
				
					$penunjang_id = $_GET['irja_id'];
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			}
				echo 'ok';
			break;
			
			case 'getdicomimage' :
				$id = $_GET['id'];
				$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
								WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $id . '"';
				$get_photo = mysql_query($sql_photo) or die(mysql_error());
				if(mysql_num_rows($get_photo) > 0){
					echo '<table width="100%" class="bta">';
						while($dat_photo = mysql_fetch_array($get_photo)){
							echo '<tr><td align="center">';
							echo '<img src="http://' . $_SERVER['SERVER_NAME'] . '/radiologi/assets/radiologi/jpeg/thumbnail/' . $dat_photo['PHOTO_FILE'] . '.jpg" height="120" >';
							echo '</td></tr>';
						}
					echo '</table>';
				}
			break;
			
			case 'formsebabkematian' :
				include('rawatinap/form_sebab_kematian.php');
			break;
			
			case 'kliniksatuanresep' :
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
		
			$resep = '';
			$resep_array = explode('[',$_GET['resep']);
			if(count($resep_array) > 1){
				$resep = $resep_array[0];
			}else{
				$resep = $_GET['resep'];
			}
			
			$sql = 'SELECT m_persediaan_farmasi.SATUAN
					FROM m_persediaan_farmasi
					WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN = "' . $resep . '"';
			$get = mysql_query($sql) or die(mysql_error());
			$dat = mysql_fetch_assoc($get);
			echo $dat['SATUAN'];
			break;
			
			case 'klinikdeltemplateracikan' :
				mysql_query('DELETE FROM t_irja_template_resep_racikan WHERE IRJA_TEMPLATE_RESEP_RACIKAN_ID = "' . $_GET['racikan_id'] . '"') or die(mysql_error());
				
				$sql_racikan = 'SELECT t_irja_template_resep_racikan.IRJA_TEMPLATE_RESEP_RACIKAN_ID,
							t_irja_template_resep_racikan.RESEP,t_irja_template_resep_racikan.PERSEDIAAN_ID,t_irja_template_resep_racikan.JUMLAH_KELUAR,
							t_irja_template_resep_racikan.SATUAN,t_irja_template_resep_racikan.FORMULARIUM,t_irja_template_resep_racikan.FORMULARIUM_NASIONAL
							FROM t_irja_template_resep_racikan
							WHERE t_irja_template_resep_racikan.IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){				
				?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
					<td width="20px" align="center"><?php echo $zx; ?></td>
					<td><?php echo $dat_racikan['RESEP']; ?></td>
					<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
					<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=klinikdeltemplateracikan&racikan_id=<?php echo $dat_racikan['IRJA_TEMPLATE_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['IRJA_TEMPLATE_RESEP_ID']; ?>');return false;" >hapus</a></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4" align="right"><input type="button" value="simpan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
				</tr>
				</table>
				</div>
				<?php }
			break;
			
			case 'klinikdeltemplateresep' :
				mysql_query('DELETE FROM t_irja_template_resep WHERE IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				mysql_query('DELETE FROM t_irja_template_resep_racikan WHERE IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				
				$searchkey = '';
				if (isset($_SESSION['kliniktemplateresep_searchkey'])) $searchkey = $_SESSION['kliniktemplateresep_searchkey'];
				
				$arr_nama_racikan = getResepNamaRacikan();
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();

				$qry_resep = 'SELECT * FROM t_irja_template_resep
							WHERE PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
							AND RACIKAN = "1"';
				if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irja_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
				$get_resep = mysql_query($qry_resep) or die(mysql_error());
				?>
				<table class="tableData" id="tfhover">
				<tr>
					<th width="30">No</th>
					<th>Nama Resep</th>
					<th>Nama Racikan</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Form RS</th>
					<th>Form Nas</th>
					<th width="100">Option</th>
				</tr>
			<?php
			$i = 1;
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				?>
				<tr>
					<td align="center"><?php echo $i; ?></td>
					<td><?php echo $dat_resep['NAMA_RESEP']; ?></td>
					<td><?php $arr_nmr = explode('|',$dat_resep['NAMA_RACIKAN']);
									$nmr = '';
									foreach($arr_nmr as $row){
										if(is_numeric($row)){
											$nmr .= $arr_nama_racikan[$row] . ',';
										}else{
											$nmr .= $row . ',';
										}
									}
									echo substr($nmr,0,strlen($nmr)-1); ?></td>
					<td><?php $arr_atp = explode('|',$dat_resep['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
					<td>
					<?php $arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?>
					</td>
					<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center"><a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['IRJA_TEMPLATE_RESEP_ID']; ?>'); open_location(); return false;" >hapus</a></td>
				</tr>
				<?php
						$sql_racikan = 'SELECT * FROM t_irja_template_resep_racikan
										WHERE IRJA_TEMPLATE_RESEP_ID = "' . $dat_resep['IRJA_TEMPLATE_RESEP_ID'] . '"';
						$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
						while($dat_racikan = mysql_fetch_array($get_racikan)){
						?>
						 <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php echo $dat_racikan['RESEP']; ?></td>
							<td><?php echo $dat_racikan['JUMLAH_KELUAR']; ?></td>
							<td><?php echo $dat_racikan['SATUAN']; ?></td>
							<td align="center"><?php if($dat_racikan['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
							<td align="center"><?php if($dat_racikan['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
							<td align="center">&nbsp;</td>
						</tr>
						<?php
						}	
					$i++; }
			?>
			</table>
			<?php 
			
			break;
			
			case 'klinikreseptemplateadd' :
					
				$sql = 'SELECT t_irja_template_resep.NAMA_RESEP,t_irja_template_resep.DOSIS,t_irja_template_resep.GENERIK,
						t_irja_template_resep.PSIKOTROPIKA,t_irja_template_resep.SATUAN_DOSIS,t_irja_template_resep.WAKTU_PAKAI
						FROM t_irja_template_resep
						WHERE t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($get) > 0){
					$dat = mysql_fetch_assoc($get);
					mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
						SATUAN_DOSIS,WAKTU_PAKAI)
						VALUES("' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_RESEP'] . '","' . $dat['DOSIS'] . '",
								"1","' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '",
								"' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '")') or die(mysql_error());
					$sql_id = 'SELECT IRJA_RESEP_ID FROM t_irja_resep WHERE IRJA_ID = "' . $_GET['idx'] . '"
							ORDER BY IRJA_RESEP_ID DESC';
					$get_id = mysql_query($sql_id) or die(mysql_error());
					$dat_id = mysql_fetch_assoc($get_id);
					$resep_id = $dat_id['IRJA_RESEP_ID']; 
					
					$sql_detail = 'SELECT t_irja_template_resep_racikan.RESEP,t_irja_template_resep_racikan.PERSEDIAAN_ID,
									t_irja_template_resep_racikan.JUMLAH_KELUAR,t_irja_template_resep_racikan.SATUAN,
									t_irja_template_resep_racikan.FORMULARIUM,t_irja_template_resep_racikan.FORMULARIUM_NASIONAL
									FROM t_irja_template_resep_racikan
									WHERE t_irja_template_resep_racikan.IRJA_TEMPLATE_RESEP_ID ="' . $_GET['resep'] . '"';
					$get_detail = mysql_query($sql_detail) or die(mysql_error());
					while($dat_detail = mysql_fetch_array($get_detail)){
						
						$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
						mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
						$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat_detail['PERSEDIAAN_ID'] . '"';	
						$get_harga = mysql_query($sql_harga) or die(mysql_error());
						$dat_harga = mysql_fetch_assoc($get_harga);
						$harga_jual = $dat_harga['HARGA_JUAL']; 
						
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
						
						mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,
								HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) VALUES("' . $resep_id . '","' . $dat_detail['RESEP'] . '",
								"' . $dat_detail['JUMLAH_KELUAR'] . '","' . $dat_detail['PERSEDIAAN_ID'] . '","' . $dat_detail['JUMLAH_KELUAR'] . '",
								"' . $dat_detail['SATUAN'] . '","' . $harga_jual . '","' . $dat_detail['FORMULARIUM'] . '",
								"' . $dat_detail['FORMULARIUM_NASIONAL'] . '")') or die(mysql_error());
					}
				}
				
			break;
			
			case 'rmtambahfile' :
			?>
				<a href="index.php?link=<?php echo md5('rmuploadrekammedikadd'); ?>&nomr=<?php echo $_GET['nomr']; ?>">
				<input name="upload" type="submit" class="myButton" value="upload" />
				</a>
			<?php	
			break;
			
			case 'rmformaadtindakan' :
			if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				$deskripsi = 'Tindakan (MR)';
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI,ST_BAYAR) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"' . $deskripsi . '","Lunas")') or die(mysql_error());
			}
			break;
			
			case 'rmformaadtindakanirna' :
			if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				$deskripsi = 'Tindakan (MR)';
				mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI,ST_BAYAR,RUANG_ID,KELAS_RAWAT) 
							VALUES("' . $_GET['irna_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"' . $deskripsi . '","Lunas",
							"' . $_GET['ruang'] . '","' . $_GET['kelas'] . '")') or die(mysql_error());
			}
						
			break;
			
			case 'rmformaadpenunjang' :
			if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,DESKRIPSI) VALUES(
								"PNJ","IRJ","' . $_GET['irja_id'] . '","Penunjang (MR)")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_BAYAR) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"Lunas")') or die(mysql_error());
			}
			break;	
			
			case 'rmformaadpenunjangirna' :
			if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,DESKRIPSI) VALUES(
								"PNJ","IRN","' . $_GET['irna_id'] . '","Penunjang (MR)")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_BAYAR) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"Lunas")') or die(mysql_error());
			}
			break;	
			
			case 'casemixirjamon' :
				$tgl_1 = $_POST['tgl_1'];
				$tgl_2 = $_POST['tgl_2'];
				$rows = $_POST['vrows'];
				
				$tgl_filter_1 = fieldDate($tgl_1);
				if (empty($tgl_1)) 
					$tgl_filter_1 = 'CURRENT_DATE()';

				$tgl_filter_2 = fieldDate($tgl_2);
				if (empty($tgl_2)) 
					$tgl_filter_2 = $tgl_filter_1;
				
				$sql = 'SELECT t_trans.IRJA_ID,
					t_trans.NOMR,
					m_pasien.NAMA_PASIEN,
					m_pasien.JNS_KELAMIN,
					m_pasien.TGL_LAHIR,
					m_unit.NAMA_UNIT AS POLIKLINIK,
					m_pegawai.NAMA_PEGAWAI AS DOKTER,
					m_jaminan.NAMA_JAMINAN AS JAMINAN,
					t_trans.DIAGNOSA_1,
					t_trans.DIAGNOSA_2,
					t_trans.DIAGNOSA_3,
					SUM(t_trans.TARIF) AS TARIF,
					SUM(t_trans.TARIF_PENUNJANG) AS TARIF_PENUNJANG,
					SUM(t_trans.TARIF_FARMASI) AS TARIF_FARMASI,
					MIN(t_cbg_tarif.TARIF_CBG) AS TARIF_INACBGS,
					t_cbg_tarif_mon_irja.CBG_IRJA_ID,
					t_cbg_tarif_mon_irja.ST_MON
				FROM 
					(
						SELECT t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 0 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_1,
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 1 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_2,
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 2 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_3,
							0 AS TARIF,
							0 AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
						WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL 
						GROUP BY t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID,	
							t_irja.PEGAWAI_ID,	
							t_irja.JENIS_BAYAR_ID	
						
						UNION					
						
						SELECT t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							SUM(m_tarif.TARIF_NON_KELAS * t_irja_tarif.KUANTITI) AS TARIF,
							0 AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_tarif ON (
								t_irja.IRJA_ID = t_irja_tarif.IRJA_ID
								AND (t_irja_tarif.ST_BAYAR != "Batal"
								OR t_irja_tarif.ST_BAYAR IS NULL)
							)
							INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL 
						GROUP BY t_irja.IRJA_ID
						
						UNION
						
						SELECT t_irja.IRJA_ID, 
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							0 AS TARIF,
							SUM(m_tarif.TARIF_NON_KELAS * t_ipenunjang_tarif.KUANTITI) AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID AND t_ipenunjang.JNS_ORDER = "IRJ")
							INNER JOIN t_ipenunjang_tarif ON (
							t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID
								AND (t_ipenunjang_tarif.ST_BAYAR != "Batal"
								OR t_ipenunjang_tarif.ST_BAYAR IS NULL)
						)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE  t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
								AND t_irja.NO_PENDAFTARAN IS NOT NULL
								AND t_irja.ST_BATAL IS NULL 
								AND t_irja.PASIEN_MASUK IS NOT NULL 
						GROUP BY t_irja.IRJA_ID
						
						UNION
						
						SELECT t_irja.IRJA_ID, 
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							0 AS TARIF,
							0 AS TARIF_PENUNJANG,
							SUM(t_irja_resep.HARGA * t_irja_resep.JUMLAH_KELUAR) AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_resep ON (t_irja.IRJA_ID = t_irja_resep.IRJA_ID)
							WHERE  t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
								AND t_irja.NO_PENDAFTARAN IS NOT NULL
								AND t_irja.ST_BATAL IS NULL 
								AND t_irja.PASIEN_MASUK IS NOT NULL 
						GROUP BY t_irja.IRJA_ID							
							) t_trans
						INNER JOIN m_pasien ON (t_trans.NOMR = m_pasien.NOMR)
						INNER JOIN m_unit ON (t_trans.POLIKLINIK = m_unit.UNIT_ID)
						INNER JOIN m_pegawai ON (t_trans.DOKTER = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_jaminan ON (t_trans.JAMINAN = m_jaminan.JAMINAN_ID)
						LEFT JOIN t_cbg_tarif ON (t_trans.DIAGNOSA_1 = t_cbg_tarif.DIAGNOSA_UTAMA
							AND t_trans.DIAGNOSA_2 = t_cbg_tarif.DIAGNOSA_SEKUNDER_1 AND t_trans.DIAGNOSA_3 = t_cbg_tarif.DIAGNOSA_SEKUNDER_2
							AND t_trans.JNS_RAWAT = t_cbg_tarif.JNS_RAWAT AND t_trans.KELAS_RS = t_cbg_tarif.KELAS_RS
							AND t_trans.KELAS_RAWAT = t_cbg_tarif.KELAS_RAWAT)
						LEFT JOIN t_cbg_tarif_mon_irja ON (t_trans.IRJA_ID = t_cbg_tarif_mon_irja.IRJA_ID) 
						GROUP BY t_trans.IRJA_ID,t_trans.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,m_pasien.TGL_LAHIR,
							m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN
						ORDER BY t_trans.IRJA_ID';
				$get = mysql_query($sql) or die(mysql_error());
				$i = $rows;
				while($dat = mysql_fetch_array($get)){
					
					$tarif_rs = $dat['TARIF'] + $dat['TARIF_PENUNJANG'] + $dat['TARIF_FARMASI']; 
					$tarif_cbg = $dat['TARIF_INACBGS'];
					$mon_id = $dat['CBG_IRJA_ID'];
					$mon_st = $dat['ST_MON'];
					$irja_id = $dat['IRJA_ID'];
					
					if($tarif_cbg > 0 and $tarif_rs > $tarif_cbg){ 
						if(empty($mon_id)){
							mysql_query('INSERT INTO t_cbg_tarif_mon_irja(IRJA_ID,ST_MON)
										VALUES("' . $irja_id . '","1")') or die(mysql_error());
						}else{
							if($mon_st == '0'){
								mysql_query('UPDATE t_cbg_tarif_mon_irja
											SET ST_MON = "1"
											WHERE CBG_IRJA_ID = "' . $mon_id . '"') or die(mysql_error());
							}
						}
						
						if($mon_st == '0' or empty($mon_id)){
							echo '<tr>';
							echo '<td align="center">' . $i . '</td>';
							echo '<td align="center">' . formatNomr($dat['NOMR']) . '</td>';
							echo '<td>' . $dat['NAMA_PASIEN'] . '</td>';
							echo '<td align="center">' . $dat['JNS_KELAMIN'] . '</td>';
							echo '<td align="center">' . changeDateFormat($dat['TGL_LAHIR']) . '</td>';
							echo '<td>' . $dat['POLIKLINIK'] . '</td>';
							echo '<td>' . $dat['DOKTER'] . '</td>';
							echo '<td>' . $dat['JAMINAN'] . '</td>';
							$diagnosa = $dat['DIAGNOSA_1'];
							if(!empty($dat['DIAGNOSA_2']))
								$diagnosa = $diagnosa . ', ' . $dat['DIAGNOSA_2'];
							if(!empty($dat['DIAGNOSA_3']))
								$diagnosa = $diagnosa . ', ' . $dat['DIAGNOSA_3'];	
							echo '<td>' . $diagnosa . '</td>';
							echo '<td align="right">' . currFormat($dat['TARIF']) . '</td>';
							echo '<td align="right">' . currFormat($dat['TARIF_PENUNJANG']) . '</td>';
							echo '<td align="right">' . currFormat($dat['TARIF_FARMASI']) . '</td>';
							echo '<td align="right">' . currFormat($dat['TARIF_INACBGS']) . '</td>';
							echo '<td>' . $dat['USER_CASEMIX'] . '</td>';
							echo '<td><a href="index.php?link=' . md5('klinikformpasienperiksa') . '&idx=' . $dat_monitor['IRJA_ID'] . '" >buka</a></td>';
							echo '</tr>';
						$i++; 
						}
					}	
				}
				
			break;
			
			case 'klinikdeltemplateobat' :
				mysql_query('DELETE FROM t_irja_template_resep WHERE IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();
				
				$sql_racikan = 'SELECT * FROM t_irja_template_resep
						WHERE NO_TEMPLATE = "' . $_GET['no_resep'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){ ?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<tr>
					<th>No</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Option</th>
				</tr>
			<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
			<tr>
				<td width="20px" align="center"><?php echo $zx; ?></td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
				<td width="100"><?php $arr_atp = explode('|',$dat_racikan['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_racikan['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
				<td width="100"><?php $arr_wkp = explode('|',$dat_racikan['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?></td>
				<td align="center"><?php if($dat_racikan['GENERIK'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($dat_racikan['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
				<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=klinikdeltemplateobat&resep_id=<?php echo $dat_racikan['IRJA_TEMPLATE_RESEP_ID']; ?>&no_resep=<?php echo $dat_racikan['NO_TEMPLATE']; ?>');return false;" >hapus</a></td>
			</tr>
			<?php $zx++; } ?>
			<tr>
				<td colspan="8" align="right"><input type="button" value="selesai" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
			</tr>
			</table>
			</div>
				<?php }
			
			break;
			
			case 'klinikdeltemplateresepobat' :
				
				mysql_query('DELETE FROM t_irja_template_resep WHERE NO_TEMPLATE = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				$searchkey = '';
				if (isset($_SESSION['kliniktemplateresep_searchkey'])) $searchkey = $_SESSION['kliniktemplateresep_searchkey'];
				
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();

				$qry_resep = 'SELECT t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID,t_irja_template_resep.NAMA_RESEP,
					t_irja_template_resep.DOSIS,t_irja_template_resep.GENERIK,
					t_irja_template_resep.PSIKOTROPIKA,t_irja_template_resep.NO_TEMPLATE,
					t_irja_template_resep.RESEP,t_irja_template_resep.JUMLAH_KELUAR,t_irja_template_resep.SATUAN,
					t_irja_template_resep.FORMULARIUM,t_irja_template_resep.FORMULARIUM_NASIONAL,
					t_irja_template_resep.SATUAN_DOSIS,t_irja_template_resep.WAKTU_PAKAI
					FROM t_irja_template_resep
					WHERE t_irja_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
					AND t_irja_template_resep.RACIKAN IS NULL';
				if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irja_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
				$qry_resep = $qry_resep . ' ORDER BY t_irja_template_resep.NO_TEMPLATE,t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID';
				$get_resep = mysql_query($qry_resep) or die(mysql_error());
				?>
				<table class="tableData" id="tfhover">
				<tr>
					<th width="30">No</th>
					<th>Nama Resep</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Form RS</th>
					<th>Form Nas</th>
					<th width="100">Option</th>
				</tr>
				<?php
			$i = 1;
			$no_resepx = '';
			$no_resepy = '';
			$no_resep = '';
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				?>
				<tr>
					<td align="center"><?php if($no_resepy != $dat_resep['NO_TEMPLATE']){
									$no_resepy = $dat_resep['NO_TEMPLATE'];
									echo $i;  
									$i++;
							} ?></td>
					<td><?php if($no_resep != $dat_resep['NO_TEMPLATE']){
									echo $dat_resep['NAMA_RESEP'];  
									$no_resep = $dat_resep['NO_TEMPLATE'];
							} ?></td>
					<td><?php echo $dat_resep['RESEP']; ?></td>
					<td align="right"><?php echo $dat_resep['JUMLAH_KELUAR']; ?></td>
					<td><?php echo $dat_resep['SATUAN']; ?></td>
					<td><?php $arr_atp = explode('|',$dat_resep['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
					<td>
					<?php $arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?>
					</td>
					<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
					<td align="center">
						<?php if($no_resepx != $dat_resep['NO_TEMPLATE']){ 
							$no_resepx = $dat_resep['NO_TEMPLATE']; ?>
						<a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['NO_TEMPLATE']; ?>'); open_location(); return false;" >hapus</a>
						<?php } ?>
						</td>
				</tr>
				<?php } ?>
			</table>
			<?php
			
			break;
			
			case 'klinikreseptemplateaddobat' :
					
				$sql = 'SELECT t_irja_template_resep.RESEP,t_irja_template_resep.PERSEDIAAN_ID,
									t_irja_template_resep.JUMLAH_KELUAR,t_irja_template_resep.SATUAN,
									t_irja_template_resep.FORMULARIUM,t_irja_template_resep.FORMULARIUM_NASIONAL,
									t_irja_template_resep.DOSIS,t_irja_template_resep.GENERIK,t_irja_template_resep.PSIKOTROPIKA,
									t_irja_template_resep.SATUAN_DOSIS,t_irja_template_resep.WAKTU_PAKAI
									FROM t_irja_template_resep
									WHERE t_irja_template_resep.NO_TEMPLATE ="' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				while ($dat = mysql_fetch_assoc($get)){
					$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
					$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat['PERSEDIAAN_ID'] . '"';	
					$get_harga = mysql_query($sql_harga) or die(mysql_error());
					$dat_harga = mysql_fetch_assoc($get_harga);
					$harga_jual = $dat_harga['HARGA_JUAL']; 
						
					$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
					mysql_select_db($database, $connect) or die(mysql_error());
						
					mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,PSIKOTROPIKA,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['RESEP'] . '","' . $dat['DOSIS'] . '","' . $dat['JUMLAH_KELUAR'] . '",
							"' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $harga_jual . '","' . $dat['FORMULARIUM'] . '",
							"' . $dat['FORMULARIUM_NASIONAL'] . '","' . $dat['SATUAN_DOSIS'] . '",
							"' . $dat['WAKTU_PAKAI'] . '","' . $dat['JUMLAH_KELUAR'] . '")') or die(mysql_error());								
						
					}
				
			break;
			
			case 'tanggaldaftarskr' :
				echo getDateSkr();
			break;
			
			case 'klinikresepcopy' :
				if(isset($_GET['idx']) and isset($_GET['idx2'])){
								
						$qry = 'SELECT t_irja_resep.IRJA_ID,t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
							t_irja_resep.NO_RESEP,t_irja_resep.ST_RESEP,t_irja_resep.IRJA_RESEP_ID,
							t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
							t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
							t_irja_resep.JUMLAH_KELUAR,t_irja_resep.HARGA,t_irja_resep.PERSEDIAAN_ID,
							t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
							FROM t_irja_resep
							WHERE IRJA_ID = "' . $_GET['idx2'] . '" AND t_irja_resep.RESEP IS NOT NULL
							ORDER BY t_irja_resep.NO_RESEP';
						$get = mysql_query($qry) or die(mysql_error());
						while($dat = mysql_fetch_array($get)){
							
							$irja_resep_id = $dat['IRJA_RESEP_ID'];
							$resep = $dat['RESEP'];
							$dosis = $dat['DOSIS'];
							$jumlah = $dat['JUMLAH'];
							$racikan = $dat['RACIKAN'];
							$generik = $dat['GENERIK'];
							$psikotropika = $dat['PSIKOTROPIKA'];
							$persediaan_id = $dat['PERSEDIAAN_ID'];
							$jumlah_keluar = $dat['JUMLAH_KELUAR'];
							$satuan = $dat['SATUAN'];
							$satuan_dosis = $dat['SATUAN_DOSIS'];
							$waktu_pakai = $dat['WAKTU_PAKAI'];
							
							$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
							mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
							$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
									m_persediaan_farmasi.FORMULARIUM_NASIONAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $persediaan_id . '"';	
							$get_harga = mysql_query($sql_harga) or die(mysql_error());
							$dat_harga = mysql_fetch_assoc($get_harga);
							$harga = $dat_harga['HARGA_JUAL'];
							$formularium = $dat_harga['FORMULARIUM'];						 
							$formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
							$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
							mysql_select_db($database, $connect) or die(mysql_error());
							
							mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,RACIKAN,GENERIK,PSIKOTROPIKA,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,
										SATUAN_DOSIS,WAKTU_PAKAI)
										VALUES("' . $_GET['idx'] . '",NOW(),"' . $resep . '","' . $dosis . '","' . $jumlah . '","' . $racikan . '","' . $generik . '","' . $psikotropika . '",
										"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
										"' . $formularium . '","' . $formularium_nasional . '",
										"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
							if($racikan == '1'){
								$sql_resep_id = 'SELECT t_irja_resep.IRJA_RESEP_ID FROM t_irja_resep
												WHERE t_irja_resep.IRJA_ID = "' . $_GET['idx'] . '"
												ORDER BY t_irja_resep.IRJA_RESEP_ID DESC LIMIT 1';
								$get_resep_id = mysql_query($sql_resep_id) or die(mysql_error());
								$dat_resep_id = mysql_fetch_assoc($get_resep_id);
								$resep_id = $dat_resep_id['IRJA_RESEP_ID']; 	
								
								$sql_racikan = 'SELECT t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,t_irja_resep_racikan.PERSEDIAAN_ID,
											t_irja_resep_racikan.JUMLAH_KELUAR,t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.HARGA,
											t_irja_resep_racikan.FORMULARIUM,t_irja_resep_racikan.FORMULARIUM_NASIONAL
											FROM t_irja_resep_racikan
											WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $irja_resep_id . '"';
								$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
								while($dat_racikan = mysql_fetch_array($get_racikan)){
									
									$racikan_resep = $dat_racikan['RESEP']; 
									$racikan_jumlah = $dat_racikan['JUMLAH']; 
									$racikan_persediaan_id = $dat_racikan['PERSEDIAAN_ID']; 
									$racikan_jumlah_keluar = $dat_racikan['JUMLAH_KELUAR']; 
									$racikan_satuan = $dat_racikan['SATUAN']; 
									
									$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
									mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
									$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
										m_persediaan_farmasi.FORMULARIUM_NASIONAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $racikan_persediaan_id . '"';	
									$get_harga = mysql_query($sql_harga) or die(mysql_error());
									$dat_harga = mysql_fetch_assoc($get_harga);
									$racikan_harga = $dat_harga['HARGA_JUAL'];
									$racikan_formularium = $dat_harga['FORMULARIUM'];						 
									$racikan_formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
									$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
									mysql_select_db($database, $connect) or die(mysql_error());
								
									mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
										VALUES("' . $resep_id . '","' . $racikan_resep . '","' . $racikan_jumlah . '",
										"' . $racikan_persediaan_id . '","' . $racikan_jumlah_keluar . '","' . $racikan_satuan . '","' . $racikan_harga . '",
										"' . $racikan_formularium . '","' . $racikan_formularium_nasional . '")') or die(mysql_error()); 
								
								}	
							}
						}	
				}
			break;
			
			case 'kunjunganpenunjangrehabmedik' :
					$sql = 'SELECT DISTINCT DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
							AND t_ipenunjang.JNS_ORDER = "IRJ"	
							AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
							AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
							AND (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = 31 OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = 40
							OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = 41 OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = 47	
							OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = 51)
							GROUP BY DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y")';
					$get = mysql_query($sql) or die(mysql_error);
					echo mysql_num_rows($get);	
			break;
				
			case 'klinikformaadpenunjangekg' :
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"EKG","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			echo 'ok';
			
			break;		
			
			case 'penunjangformaddtindakan' :
			
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID,NO_SJP) VALUES("' . $_GET['p_id'] . '","' . $_GET['tarif_id'] . '",1,"' . $_GET['unit_id'] . '","' . $_GET['no_tarif'] . '")') or die(mysql_error());
				echo 'ok';
				
			break;
			
			case 'pengembalianfarmasi' :
			$no_bayar = getNomorHarian('Kasir');
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			mysql_query('UPDATE t_farmasi_apotik_pengembalian_resep SET USER_PEMBAYARAN = "' . currentUser() . '",
					SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					NO_PEMBAYARAN = "' . $no_bayar . '",
					TANGGAL_BAYAR = NOW()
					WHERE NO_PENGEMBALIAN = "' . $_GET['no'] . '"') or die(mysql_error());
			break;
			
			case 'batalpengembalianfarmasi' :
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			mysql_query('UPDATE t_farmasi_apotik_pengembalian_resep SET USER_PEMBAYARAN = "' . currentUser() . '",
					SHIFT_PEMBAYARAN = NULL,
					NO_PEMBAYARAN = NULL,
					TANGGAL_BAYAR = NULL
					WHERE NO_PENGEMBALIAN = "' . $_GET['no'] . '"') or die(mysql_error());
			break;	
			
			case 'pendaftarantmpedittindakan' :
				$unit_id = $_GET['unit_id'];
				$rawat_id = $_GET['rawat_id'];
				$tgl_daftar = $_GET['tgl_daftar'];
				$tgl_daftar_rujuk = $_GET['tgl_daftar_rujuk'];
				$nomr = $_GET['nomr'];
				$no_tarif = $_GET['no'];
				?>
				<table class="tableData" id="tfhover" >
				<?php include('pendaftaran/pendaftaran_tmp_edit_penunjang.php'); ?>
				<tr>
				<td colspan="5" align="right"><div id="total">Total Rp.&nbsp;&nbsp;0</div></td>
				<td colspan="4">&nbsp;</td>
				</tr>
				</table>
				<input type="hidden" name="cnt_p" value="<?php echo $i; ?>" />
				<?php
			break;
			
			case 'pendaftaranformaadpenunjangdaftaredit' :
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID
									FROM t_ipenunjang_tarif
									WHERE t_ipenunjang_tarif.NO_SJP = "' . $_GET['nomor'] . '"';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,NO_SJP) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"' . $_GET['nomor'] . '")') or die(mysql_error());
				echo 'ok';
			break;
			
			case 'pendaftaranformaadpenunjangdaftarautoedit' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
				
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID
									FROM t_ipenunjang_tarif
									WHERE t_ipenunjang_tarif.NO_SJP = "' . $_GET['nomor'] . '"';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,NO_SJP) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,"' . $_GET['nomor'] . '")') or die(mysql_error());
				}
			}	
			break;	
			
			case 'update_sttracer' :
			
				mysql_query('UPDATE t_irja SET PRINT_TRACER = "1" WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
				
			break;
			
			case 'pendaftaranformaadapsdaftaredit' :
				$penunjang_id = $_GET['irja_id'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,NO_SJP) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1,"' . $_GET['nomor'] . '")') or die(mysql_error());
			break;
			
			case 'pendaftaranformaadpenunjangdaftarautoedit' :
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
				
					$penunjang_id = $_GET['irja_id'];
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,NO_SJP) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,"' . $_GET['nomor'] . '")') or die(mysql_error());
				}	
				}
				echo 'ok';	
			break;
			
			case 'ranapformaadlaboratoriumauto' :
				
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"LAB","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			 }
			
			break;	

			case 'ranapformaadradiologiauto' :
				
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
					
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"RAD","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_id . '",1)') or die(mysql_error());
				}
			 }
			
			break;		
			
			case 'ranapformaadpenunjangauto' :
							
				$tindakan_array = explode('--', $_GET['tarif_id']);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID']; 
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"PNJ","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				
				$sql_unit = 'SELECT m_tarif_group.UNIT_ID
							FROM m_tarif
							INNER JOIN m_tarif_group 
							ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE m_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) 
					VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,"' . $unit_id . '")') or die(mysql_error());
				}
			 }
			
			break;
			
			case 'ranapformaadpenunjangekg' :
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"EKG","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
				echo 'ok';
			
			break;	
			
			case 'cdiagnosa' :
			?>
			<select name="diagnosa" style="width:500px;" class="text_dt" onchange="javascript : MyAjaxRequest('cgejala','index.php?ajaxrequest=cgejala&diagnosa_id=' + this.value);MyAjaxRequest('cetiologi','index.php?ajaxrequest=cetiologi&diagnosa_id=' + this.value);return false;" />
			<option value=""> - </option>
			<?php
			$domain = $_GET['domain_id'];
			$domain_arr = explode('-',$domain);
			$domain_x = str_replace('Domain','',$domain_arr[0]);
			$domain = trim($domain_x);	
			$sql_diagnosa = 'SELECT m_askep_diagnosis.ID_DIAGNOSIS,m_askep_diagnosis.ID_DOMAIN,
							m_askep_diagnosis.KODE_DIAGNOSIS,m_askep_diagnosis.NAMA_DIAGNOSIS
							FROM m_askep_diagnosis
							WHERE m_askep_diagnosis.ID_DOMAIN = "' . $domain . '"
							ORDER BY m_askep_diagnosis.NAMA_DIAGNOSIS';
				$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
				while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
					echo '<option value="' . $dat_diagnosa['KODE_DIAGNOSIS'] . ' - ' . $dat_diagnosa['NAMA_DIAGNOSIS'] . '">' . $dat_diagnosa['KODE_DIAGNOSIS'] . ' - ' . $dat_diagnosa['NAMA_DIAGNOSIS'] . '</option>';
				}	
			?>
			</select>
			<?php	
			break;	
			
			case 'cgejala' :
			?>
			<select name="gejala" style="width:500px;" class="text_dt" />
			<option value=""> - </option>
			<?php
			$diagnosa = $_GET['diagnosa_id'];
			$diagnosa_arr = explode('-',$diagnosa);
			$diagnosa = trim($diagnosa_arr[0]);	
			$sql_gejala = 'SELECT m_askep_gejala.ID_GEJALA,m_askep_gejala.NAMA_GEJALA,
							m_askep_diagnosis.KODE_DIAGNOSIS
							FROM m_askep_diagnosis
							INNER JOIN m_askep_gejala ON (m_askep_diagnosis.ID_DIAGNOSIS = m_askep_gejala.ID_DIAGNOSIS)
							WHERE m_askep_diagnosis.KODE_DIAGNOSIS = "' . $diagnosa . '"
							ORDER BY m_askep_gejala.NAMA_GEJALA';
				$get_gejala = mysql_query($sql_gejala) or die(mysql_error());
				while($dat_gejala = mysql_fetch_array($get_gejala)){
					echo '<option value="' . $dat_gejala['NAMA_GEJALA'] . '">' . $dat_gejala['NAMA_GEJALA'] . '</option>';
				}	
			?>
			</select>
			<?php	
			break;	
			
			case 'cetiologi' :
			?>
			<select name="etiologi" style="width:500px;" class="text_dt" />
			<option value=""> - </option>
			<?php
			$diagnosa = $_GET['diagnosa_id'];
			$diagnosa_arr = explode('-',$diagnosa);
			$diagnosa = trim($diagnosa_arr[0]);	
			$sql_etiologi = 'SELECT m_askep_etiologi.ID_ETIOLOGI,m_askep_etiologi.NAMA_ETIOLOGI,
							 m_askep_diagnosis.KODE_DIAGNOSIS
							 FROM m_askep_diagnosis
							INNER JOIN m_askep_etiologi ON (m_askep_diagnosis.ID_DIAGNOSIS = m_askep_etiologi.ID_DIAGNOSIS)
							WHERE m_askep_diagnosis.KODE_DIAGNOSIS = "' . $diagnosa . '"
							ORDER BY m_askep_etiologi.NAMA_ETIOLOGI';
				$get_etiologi = mysql_query($sql_etiologi) or die(mysql_error());
				while($dat_etiologi = mysql_fetch_array($get_etiologi)){
					echo '<option value="' . $dat_etiologi['NAMA_ETIOLOGI'] . '">' . $dat_etiologi['NAMA_ETIOLOGI'] . '</option>';
				}	
			?>
			</select>
			<?php	
			break;	
			
			case 'cekpendaftaranformaadpenunjangdaftar' :
			
			$irja_id = $_POST['xirja_id'];
			$tarif_id = $_POST['xtarif_id'];
				
			$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif 
							ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND t_ipenunjang.JNS_PENUNJANG = "PNJ" 
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.DESKRIPSI = "Penunjang (Pendaftaran)"';
			$get_cek = mysql_query($sql_cek) or die(mysql_error());
			$dat_cek = mysql_fetch_assoc($get_cek);
			
			echo $dat_cek['JML']; 	
			
			break;
			
			case 'cekpendaftaranformaadpenunjangdaftarauto' :
			
			$irja_id = $_POST['xirja_id'];
			$tarif_id = $_POST['xtarif_id'];
			
			$tindakan_array = explode('--', $tarif_id);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID'];
			
						$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif 
							ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND t_ipenunjang.JNS_PENUNJANG = "PNJ"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.DESKRIPSI = "Penunjang (Pendaftaran)"';
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
				}
			}		
			
			break;
			
			case 'cekpendaftaranformaadpenunjangdaftaredit' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$nomor = $_POST['xnomor'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang_tarif.NO_SJP = "' . $nomor . '")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekpendaftaranformaadpenunjangdaftaredit' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$nomor = $_POST['xnomor'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang_tarif.NO_SJP = "' . $nomor . '")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekpendaftaranformaadpenunjangdaftareditauto' :
			
			$irja_id = $_POST['xirja_id'];
			$tarif_id = $_POST['xtarif_id'];
			$nomor = $_POST['xnomor'];
			
			$tindakan_array = explode('--', $tarif_id);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID'];
			
						$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang_tarif.NO_SJP = "' . $nomor . '")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
				}
			}

			break;	
			
			case 'cekkasirformaddpenunjang' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				
				if($ord == 'aps'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "APS" 
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '"
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
				}				
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekkasirformaddpenunjangauto' :
			
			$irja_id = $_POST['xirja_id'];
			$tarif_id = $_POST['xtarif_id'];
			$ord = $_POST['xord'];
			
			$tindakan_array = explode('--', $tarif_id);
			if(count($tindakan_array) >= 2){
				$kode_tindakan = $tindakan_array[0];
				$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
				$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
				if(mysql_num_rows($get_tarif_id) > 0){	
					$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
					$tarif_id = $dat_tarif_id['TARIF_ID'];
			
						if($ord == 'aps'){
							$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "APS" 
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
							}else{
								$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '"
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';
							}		
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
				}
			}
			
			break;
			
			case 'cekkasirformaadtindakan' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
							FROM t_irja_tarif
							INNER JOIN m_tarif
							ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group
							ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
							AND m_tarif_group.KODE_TARIF_GROUP <> "01"  
							AND t_irja_tarif.NO_TARIF IS NULL 
							AND t_irja_tarif.DESKRIPSI = "Tindakan (Kasir)"
							AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"';
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekpendaftaranformaddpenunjangaps' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "APS" 
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'pendaftaranformaddpenunjangaps' :
		
				$sql_unit = 'SELECT CASE WHEN m_tarif_group.LABORATORIUM = "1" THEN "45"
								 WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN "45"
								 WHEN m_tarif_group.RADIOLOGI = "1" THEN "17"
								 WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN "17"
								 WHEN m_tarif_group.UNIT_ID IS NOT NULL THEN m_tarif_group.UNIT_ID
								 WHEN m_tarif.UNIT_ID IS NOT NULL THEN m_tarif.UNIT_ID END AS UNIT_ID
						FROM m_tarif
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_unit = mysql_query($sql_unit) or die(mysql_error());
				$dat_unit = mysql_fetch_assoc($get_unit);
				$unit_id = $dat_unit['UNIT_ID']; 	
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $_GET['penunjang_id'] . '","' . $_GET['tarif_id'] . '",1,"' . $unit_id . '")') or die(mysql_error());
				
				echo 'ok';
			break;
			
			case 'cekpendaftaranformaddpenunjangapsauto' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
								FROM t_ipenunjang
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "APS" 
								AND t_ipenunjang.DESKRIPSI IS NULL AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
					}
				}		
			break;
			
			case 'pendaftaranformaddpenunjangapsauto' :

				$tarif_id = $_GET['tarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_unit = 'SELECT CASE WHEN m_tarif_group.LABORATORIUM = "1" THEN "45"
								 WHEN m_tarif_group.LABORATORIUM_CITO = "1" THEN "45"
								 WHEN m_tarif_group.RADIOLOGI = "1" THEN "17"
								 WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN "17"
								 WHEN m_tarif_group.UNIT_ID IS NOT NULL THEN m_tarif_group.UNIT_ID
								 WHEN m_tarif.UNIT_ID IS NOT NULL THEN m_tarif.UNIT_ID END AS UNIT_ID
						FROM m_tarif
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.TARIF_ID = "' . $tarif_id . '"';
						$get_unit = mysql_query($sql_unit) or die(mysql_error());
						$dat_unit = mysql_fetch_assoc($get_unit);
						$unit_id = $dat_unit['UNIT_ID']; 	
				
						mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,UNIT_PENUNJANG_ID) VALUES("' . $_GET['penunjang_id'] . '","' . $tarif_id . '",1,"' . $unit_id . '")') or die(mysql_error());
					}
				}	
				echo 'ok';
			break;
			
			case 'cekpendaftaranformaddpenunjangapsedit' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$nomor = $_POST['xnomor'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "APS" 
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang_tarif.NO_SJP = "' . $nomor . '")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekkasirformaadtindakanirna' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JML
							FROM t_irna_tarif
							WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '"
							AND t_irna_tarif.NO_TARIF IS NULL AND t_irna_tarif.DESKRIPSI = "Tindakan (Kasir)"
							AND t_irna_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekkasirformaadtindakanirnaauto' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_cek = 'SELECT COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JML
							FROM t_irna_tarif
							WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '"
							AND t_irna_tarif.NO_TARIF IS NULL AND t_irna_tarif.DESKRIPSI = "Tindakan (Kasir)"
							AND t_irna_tarif.TARIF_ID = "' . $tarif_id . '"';			
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
					}		
				}
			
			break;
			
			case 'cekranapformaadlaboratorium' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER IS NULL
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Laboratorium (Ruang Rawat)")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekranapformaadradiologi' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER IS NULL
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Radiologi (Ruang Rawat)")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekranapformaadtindakanirna' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JML
							FROM t_irna_tarif
							WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '" AND t_irna_tarif.NO_TARIF IS NULL
							AND t_irna_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekranapformaadpenunjang' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND t_ipenunjang.JNS_ORDER = "IRN" 
							AND m_tarif_group.PENUNJANG = "1"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekranapformaadpenunjangekg' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND t_ipenunjang.JNS_ORDER = "IRN" 
							AND m_tarif.UNIT_ID = "52"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekpenunjangformaddtindakan' :
				
				$p_id = $_POST['xp_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				$no = $_POST['xno'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $p_id . '"
							AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND t_ipenunjang_tarif.NO_SJP = "' . $no . '"
							AND (m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" OR m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '")
							AND t_ipenunjang_tarif.NO_TARIF IS NULL
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			
			case 'cekranapformaadtindakanirnaauto' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_cek = 'SELECT COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JML
							FROM t_irna_tarif
							WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '" AND t_irna_tarif.NO_TARIF IS NULL
							AND t_irna_tarif.TARIF_ID = "' . $tarif_id . '"';			
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
					}			
				}
			break;
			
			case 'cekklinikformaadtindakan' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
							FROM t_irja_tarif
							WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
							AND (t_irja_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_irja_tarif.DESKRIPSI <> "Konsultasi"
							OR t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik")
							AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_irja_tarif.NO_TARIF IS NULL';				
				}else{
					$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
							FROM t_irja_tarif
							WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
							AND (t_irja_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_irja_tarif.DESKRIPSI <> "Konsultasi"
							OR t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik")
							AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"';				
				}
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekklinikformaadtindakanauto' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
							FROM t_irja_tarif
							WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
							AND (t_irja_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_irja_tarif.DESKRIPSI <> "Konsultasi"
							OR t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik")
							AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"';			
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML']; 
					}	
				}
				
			break;
			
			case 'cekklinikformaadlaboratorium' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekklinikformaadradiologi' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				}else{	
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekklinikformaadpenunjang' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif_group.PENUNJANG = "1"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				}else{	
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif_group.PENUNJANG = "1"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'cekklinikformaadpenunjangekg' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif.UNIT_ID = "52"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';				
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif.UNIT_ID = "52"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'irnadetailkeluarmasukruang' :
				$ruang_id = $_POST['ruang_id'];
				$tanggal = $_POST['tanggal'];
				
				$tgl_filter = fieldDate($tanggal);
				if (empty($tanggal)) {
					$tgl_filter = 'CURRENT_DATE()';
				}
				
				$sql_log_ranap = 'SELECT t_irna_log.IRNA_ID,t_irna_log.NOMR,t_irna_log.TANGGAL_UPDATE,
								m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,
								"Masuk" AS ST
								FROM t_irna_log
								INNER JOIN m_ruang ON (t_irna_log.RUANG_ID_BARU = m_ruang.RUANG_ID)
								INNER JOIN m_pasien ON (t_irna_log.NOMR = m_pasien.NOMR)
								WHERE STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter . '
								AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"
								AND t_irna_log.JNS_UPDATE = "R"
								UNION
								SELECT t_irna_log.IRNA_ID,t_irna_log.NOMR,t_irna_log.TANGGAL_UPDATE,
								m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,
								"Keluar" AS ST
								FROM t_irna_log
								INNER JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
								INNER JOIN m_pasien ON (t_irna_log.NOMR = m_pasien.NOMR)
								WHERE STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter . '
								AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"
								AND t_irna_log.JNS_UPDATE = "R"';
				$get_log_ranap = mysql_query($sql_log_ranap) or die(mysql_error());		
				?>
				<table class="tableData" width="100%">
				<?php $i = 1; while($dat_log_ranap = mysql_fetch_array($get_log_ranap)){
					?>
						<tr>
							<td width="94px;">&nbsp;</td>
							<td align="center" width="20px;"><?php echo $i; ?></td>
							<td align="center" width="120px;"><?php echo $dat_log_ranap['TANGGAL_UPDATE']; ?></td>
							<td align="center" width="120px;"><?php echo $dat_log_ranap['ST']; ?></td>
							<td align="center" width="120px;"><?php echo formatNomr($dat_log_ranap['NOMR']); ?></td>
							<td><?php echo $dat_log_ranap['NAMA_PASIEN']; ?></td>
							<td align="center" width="120px;"><?php echo $dat_log_ranap['TGL_LAHIR']; ?></td>
							<td align="center" width="120px;" ><?php echo jenisKelamin($dat_log_ranap['JNS_KELAMIN']); ?></td>
							<td><?php echo $dat_log_ranap['ALAMAT']; ?></td>
						</tr>
					<?php
				$i++; } ?>
				</table>
				<?php	
			break;
			
			case 'laboratoriumhapushasil' :
				
				$idx = $_GET['idx'];			
				$sql = 'DELETE FROM t_ipenunjang_tarif_pemeriksaan WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';			
				mysql_query($sql) or die(mysql_error());
				
			break;
			
			case 'cekoperasiformaadtindakan' :
				
				$operasi_id = $_POST['xoperasi_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_operasi_tarif.OPERASI_TARIF_ID) AS JML
							FROM t_operasi_tarif
							WHERE t_operasi_tarif.OPERASI_ID = "' . $operasi_id . '" AND t_operasi_tarif.NO_TARIF IS NULL
							AND t_operasi_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'operasiformaadtindakan' :
				$sql_cek_no_rawat = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['operasi_id'] . '"';
				$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
				$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
				if (empty($dat_cek_no_rawat['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					mysql_query('INSERT INTO t_operasi_tarif(OPERASI_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,PEGAWAI_ID) VALUES("' . $_GET['operasi_id'] . '","' . $_GET['tarif_id'] . '",1,"Tindakan (Kamar Operasi)","' . $_GET['kelas'] . '","' . $_GET['pegawai'] . '")') or die(mysql_error());
				}
			echo 'ok';		
			break;
			
			case 'cekoperasiformaadtindakanauto' :
				
				$operasi_id = $_POST['xoperasi_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						$sql_cek = 'SELECT COUNT(t_operasi_tarif.OPERASI_TARIF_ID) AS JML
							FROM t_operasi_tarif
							WHERE t_operasi_tarif.OPERASI_ID = "' . $operasi_id . '" AND t_operasi_tarif.NO_TARIF IS NULL
							AND t_operasi_tarif.TARIF_ID = "' . $tarif_id . '"';			
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML'];
					}			
				}
			break;
			
			case 'operasiformaadtindakanauto' :
				$sql_cek_no_rawat = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['operasi_id'] . '"';
				$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
				$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
				if (empty($dat_cek_no_rawat['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$tindakan_array = explode('--', $_GET['tarif_id']);
					if(count($tindakan_array) >= 2){
						$kode_tindakan = $tindakan_array[0];
						$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
						$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
						if(mysql_num_rows($get_tarif_id) > 0){
							$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
							mysql_query('INSERT INTO t_operasi_tarif(OPERASI_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,PEGAWAI_ID) VALUES("' . $_GET['operasi_id'] . '","' . $dat_tarif_id['TARIF_ID'] . '",1,"Tindakan (Kamar Operasi)","' . $_GET['kelas'] . '","' . $_GET['pegawai'] . '")') or die(mysql_error());	
						}
					}
				}
				echo 'ok';	
			break;
			
			case 'bayaroperasi' :
			
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

            mysql_query('UPDATE t_operasi_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '" 	
						WHERE OPERASI_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			break;
			
			case 'batalbayaroperasi' :
			mysql_query('UPDATE t_operasi_tarif SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
						SHIFT_ID = NULL,USER_KASIR = "' . currentUser() . '" ,
						KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
						ST_BATAL_BAYAR = "' . $_GET['st'] . '"		
						WHERE OPERASI_ID = "' . $_GET['idx'] . '" AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
						
            break;
			
			case 'bayarmcu' :
			$no_bayar = getNomorHarian('Kasir');
            mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '" 
						WHERE IRJA_ID = "' . $_GET['idx'] . '" 
						OR IRJA_ID = (SELECT x.IRJA_ID FROM t_irja x WHERE x.NO_PENDAFTARAN = "' . $_GET['no'] . '"
						AND x.IRJA_ID <> "' . $_GET['idx'] . '")') or die(mysql_error());
			
			$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" AND JNS_ORDER = "IRJ"';
			$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
			while($dat_penunjang = mysql_fetch_array($get_penunjang)){
				$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '" 
						WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
			}			
			break;
			
			case 'detailrmfile' :
			
			$xrawat_id = $_POST['rawat_id'];
			$jns_perawatan = substr($xrawat_id,0,2);
			$rawat_id = substr($xrawat_id,2,strlen($xrawat_id) - 2);
			$ext_sql = '';
			if($jns_perawatan == 'RJ') {
				$jns_perawatan = '1';
				$ext_sql = 'AND m_rm_jenis_dokumen.IRJA = "1"';
			}	
			if($jns_perawatan == 'RI') {
				$jns_perawatan = '2';
				$ext_sql = 'AND m_rm_jenis_dokumen.IRNA = "1"';
			}	
				
			$sql = 'SELECT CASE WHEN LENGTH(t_rm_dokumen_file.NAMA_PENUNJANG) > 0
						THEN t_rm_dokumen_file.NAMA_PENUNJANG 
						ELSE m_rm_jenis_dokumen.JENIS_DOKUMEN END AS JENIS_DOKUMEN,
					t_rm_dokumen_file.RAWAT_ID,
					t_rm_dokumen_file.JNS_PERAWATAN,t_rm_dokumen_file.NAMA_FILE,
					t_rm_dokumen_file.KETERANGAN,t_rm_dokumen_file.USER_UPLOAD,
					t_rm_dokumen_file.FILE_ID,t_rm_dokumen_file.ST_SISTEM
					FROM t_rm_dokumen_file
					INNER JOIN m_rm_jenis_dokumen 
					ON (t_rm_dokumen_file.JENIS_DOKUMEN_ID = m_rm_jenis_dokumen.JENIS_DOKUMEN_ID)
					WHERE t_rm_dokumen_file.RAWAT_ID = "' . $rawat_id . '"
					AND t_rm_dokumen_file.JNS_PERAWATAN = "' . $jns_perawatan . '"
					' . $ext_sql . ' ORDER BY m_rm_jenis_dokumen.LIST_ORDER';
			$get = mysql_query($sql) or die(mysql_error()); 
			$row = mysql_num_rows($get); ?>
			<table class="tableData">
			<?php $i = 0;
			while($dat = mysql_fetch_array($get)){
				$i++; ?>	
					<tr>
					<td width="257px" align="right"><i><?php echo $i; ?></i>&nbsp;</td>
					<td><i><?php echo $dat['JENIS_DOKUMEN']; ?></i></td>	
					<td align="center" width="80px">
					<a href="#" onclick="window.open('index.php?flex=<?php echo $dat['FILE_ID']; ?>', '_blank');" >lihat</a>
					</td>	
					</tr>
				<?php	}  ?>
			</table> 
            <?php 
			break;

			case 'cekklinikformaadpenunjanghemodialisa' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				if(currentModul() == 'igd'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif.UNIT_ID = "55"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
							AND m_tarif.UNIT_ID = "55"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;	
			
			case 'klinikformaadpenunjanghemodialisa' :
			$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"HMD","IRJ","' . $_GET['irja_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			}
			echo 'ok';
			
			break;

			case 'cekranapformaadpenunjanghmd' :
				
				$irna_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND t_ipenunjang.JNS_ORDER = "IRN" 
							AND m_tarif.UNIT_ID = "55"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.NO_ORDER IS NULL';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;	
			
			case 'ranapformaadpenunjanghmd' :
			$sql_cek_no_klinik = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $_GET['irna_id'] . '"';
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"HMD","IRN","' . $_GET['irna_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRN"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irna_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			}
				echo 'ok';
			
			break;

			case 'cekhemodialisaformaadtindakan' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$jns_order = $_POST['xord'];
				
				if(!empty($jns_order)){
					$sql_cek = 'SELECT COUNT(t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS JML
							FROM t_hemodialisa_tarif
							WHERE t_hemodialisa_tarif.HEMODIALISA_ID = "' . $irja_id . '"
							AND (t_hemodialisa_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_hemodialisa_tarif.DESKRIPSI <> "Konsultasi"
							OR t_hemodialisa_tarif.DESKRIPSI = "Tindakan Di Polilinik")
							AND t_hemodialisa_tarif.TARIF_ID = "' . $tarif_id . '"';				
				}else{
					$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
							FROM t_irja_tarif
							WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
							AND (t_irja_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_irja_tarif.DESKRIPSI <> "Konsultasi"
							OR t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik")
							AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"';				
				}
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;	
			
			case 'hemodialisaformaadtindakan' :
			
			if(empty($_GET['ord'])){
				$sql_cek_mcu = 'SELECT KODE_TARIF,KODE_TARIF_GROUP FROM m_tarif WHERE TARIF_ID = "' . $_GET['tarif_id'] . '"';
				$get_cek_mcu = mysql_query($sql_cek_mcu) or die(mysql_error());
				$dat_cek_mcu = mysql_fetch_assoc($get_cek_mcu);
				if($dat_cek_mcu['KODE_TARIF_GROUP'] != '170'){
					$deskripsi = 'Tindakan Di Poliklinik';
					if(currentModul() == 'igd') $deskripsi = 'Tindakan Di IGD';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"' . $deskripsi . '")') or die(mysql_error());
				}else{
					//tindakan paket MCU
					$arr_mcu_s = '"00000",';
					$arr_mcu_s .= '"' . $dat_cek_mcu['KODE_TARIF'] . '",';
					$sql = 'SELECT KODE_TARIF FROM m_tarif WHERE KODE_TARIF LIKE "CVD' . $dat_cek_mcu['KODE_TARIF'] . '%"';
					$get = mysql_query($sql) or die(mysql_error());
					while($dat = mysql_fetch_array($get)){
						$arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",'; 
					}
					$arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
					
					$arr_tindakan = array();
					$arr_laboratorium = array();	
					$arr_radiologi = array();
					$arr_ekgusg = array();		
					
					$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
								m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
								m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
								FROM m_tarif
								INNER JOIN m_tarif_group 
								ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
								WHERE m_tarif.KODE_TARIF IN (' . $arr_mcu_s . ') 
								AND (m_tarif.MCU = "1" OR m_tarif.ST_AKTIF = "1")') or die(mysql_error());			
			
					while($dat_tarif = mysql_fetch_array($get_tarif)){
						if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
							and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
							and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
							
						if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
							or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
						if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
							or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
						if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
					}
					
					$no_bayar = 'NULL';
					$st_bayar = 'NULL';
					if($dat_cek_no_klinik['JENIS_BAYAR_ID'] <> '1'){
						$no_bayar = '"' . getNomorHarian('Kasir') . '"';
						$st_bayar = '"Lunas"';
					}
					$nomor = getNomorHarian('Tarif');
					$tgl_tarif = 'STR_TO_DATE("' . getDatetimeSkr() . '","%d/%m/%Y %H:%i:%s")';	
					$nomor_order = getNomorBulanan('IPENUNJANG');
					$no_sjp = getNomorHarian('SJP');
					
					if(sizeof($arr_tindakan) > 0){
						foreach($arr_tindakan as $tarif){
						$kuantiti = 0;
						if($tarif == $_GET['tarif_id']) $kuantiti = '1';	
							mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
									DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
									VALUES("' . $_GET['irja_id'] . '",' . $tgl_tarif . ',"' . $tarif . '","' . $kuantiti . '","' . $nomor . '",
									' . $no_bayar . ',"Paket Skrining Covid-19",' . $st_bayar . ',"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '",
									"' . currentUser() . '",NULL)') or die(mysql_error());	
						}
					}	
			
					if(sizeof($arr_laboratorium) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"LAB","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_laboratorium as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "45",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
			
					if(sizeof($arr_radiologi) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"RAD","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_radiologi as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
			
					if(sizeof($arr_ekgusg) > 0){
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
										NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
										"EKG","IRJ","' . $_GET['irja_id'] . '","' . $nomor_order . '","Paket Skrining Covid-19",
										"' . $dat_cek_no_klinik['PEGAWAI_ID'] . '","' . $dat_cek_no_klinik['NOMR'] . '",
										' . $tgl_tarif . ',"' . $dat_cek_no_klinik['UNIT_ID'] . '","' . currentUser() . '",
										"' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '","' . $_GET['tarif_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
											FROM t_ipenunjang 
											WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" 
											AND t_ipenunjang.JNS_ORDER = "IRJ"
											AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
											AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
											ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
										
						foreach($arr_ekgusg as $tarif){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
								VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
						}
						mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
							UNIT_PENUNJANG_ID = "52",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . currentUser() . '",
							JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
					}
					//end tindakan paket COVID-19
				}
			}else{
				$deskripsi = 'Tindakan Di Hemodialisa';
				mysql_query('INSERT INTO t_hemodialisa_tarif(HEMODIALISA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $_GET['tarif_id'] . '",1,"' . $deskripsi . '")') or die(mysql_error());	
			}	
			
			echo 'ok';
			
			break;
			
			case 'cekhemodialisaformaadtindakanauto' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$jns_order = $_POST['xord'];
				
				$tindakan_array = explode('--', $tarif_id);
				if(count($tindakan_array) >= 2){
					$kode_tindakan = $tindakan_array[0];
					$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
					$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
				
					if(mysql_num_rows($get_tarif_id) > 0){	
						$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
						$tarif_id = $dat_tarif_id['TARIF_ID'];
				
						if(empty($jns_order)){
							$sql_cek = 'SELECT COUNT(t_irja_tarif.IRJA_TARIF_ID) AS JML
								FROM t_irja_tarif
								WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
								AND (t_irja_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_irja_tarif.DESKRIPSI <> "Konsultasi"
								OR t_irja_tarif.DESKRIPSI = "Tindakan Di Polilinik")
								AND t_irja_tarif.TARIF_ID = "' . $tarif_id . '"';			
						}else{
							$sql_cek = 'SELECT COUNT(t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS JML
								FROM t_hemodialisa_tarif
								WHERE t_hemodialisa_tarif.HEMODIALISA_ID = "' . $irja_id . '"
								AND (t_hemodialisa_tarif.DESKRIPSI <> "Karcis & Konsultasi" OR t_hemodialisa_tarif.DESKRIPSI <> "Konsultasi"
								OR t_hemodialisa_tarif.DESKRIPSI = "Tindakan Di Polilinik")
								AND t_hemodialisa_tarif.TARIF_ID = "' . $tarif_id . '"';			
						}		
						$get_cek = mysql_query($sql_cek) or die(mysql_error());
						$dat_cek = mysql_fetch_assoc($get_cek);
			
						echo $dat_cek['JML']; 
					}	
				}
				
			break;
			
			case 'hemodialisaformaadtindakanauto' :
			
			if(empty($_GET['ord'])){
					
					$tindakan_array = explode('--', $_GET['tarif_id']);
					if(count($tindakan_array) >= 2){
						$kode_tindakan = $tindakan_array[0];
						$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
						$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
						if(mysql_num_rows($get_tarif_id) > 0){
							$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
							$deskripsi = 'Tindakan Di Polilinik';
							mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $dat_tarif_id['TARIF_ID'] . '",1,"' . $deskripsi . '")') or die(mysql_error());	
						}
					}
			}else{
									
					$tindakan_array = explode('--', $_GET['tarif_id']);
					if(count($tindakan_array) >= 2){
						$kode_tindakan = $tindakan_array[0];
						$sql_tarif_id = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tindakan . '" AND ST_AKTIF = "1"';
						$get_tarif_id = mysql_query($sql_tarif_id) or die(mysql_error());
						if(mysql_num_rows($get_tarif_id) > 0){
							$dat_tarif_id = mysql_fetch_assoc($get_tarif_id);
							$deskripsi = 'Tindakan Di Polilinik';
							mysql_query('INSERT INTO t_hemodialisa_tarif(HEMODIALISA_ID,TGL_TARIF,TARIF_ID,KUANTITI,DESKRIPSI) VALUES("' . $_GET['irja_id'] . '",NOW(),"' . $dat_tarif_id['TARIF_ID'] . '",1,"' . $deskripsi . '")') or die(mysql_error());	
						}
					}
			}	
			
			break;	
			
			case 'cekhemodialisaformaadlaboratorium' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				$idxord = $_POST['xidxord'];
				
				if($ord == 'IRJ'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID IS NULL';			
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idxord . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'hemodialisaformaadlaboratorium' :
			
			if($_GET['ord'] == 'IRJ'){
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID IS NULL';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"LAB","' . $_GET['ord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			
			}else{
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,HEMODIALISA_ID) VALUES(
								"LAB","' . $_GET['ord'] . '","' . $_GET['idxord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			}	
	
			echo 'ok';
			
			break;
			
			case 'cekhemodialisaformaadradiologi' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				$idxord = $_POST['xidxord'];
				
				if($ord == 'IRJ'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID IS NULL';			
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idxord . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'hemodialisaformaadradiologi' :
			
			if($_GET['ord'] == 'IRJ'){
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID IS NULL';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"RAD","' . $_GET['ord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
				}
			}else{
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,HEMODIALISA_ID) VALUES(
								"RAD","' . $_GET['ord'] . '","' . $_GET['idxord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
				}
			}	
	
			echo 'ok';
			
			break;	
			
			case 'cekhemodialisaformaadpenunjangekg' :
				
				$irja_id = $_POST['xirja_id'];
				$tarif_id = $_POST['xtarif_id'];
				$ord = $_POST['xord'];
				$idxord = $_POST['xidxord'];
				
				if($ord == 'IRJ'){
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND m_tarif.UNIT_ID = "52"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID IS NULL';			
				}else{
					$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idxord . '" AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
							AND m_tarif.UNIT_ID = "52"
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"
							AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"';			
				}			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 
				
			break;
			
			case 'hemodialisaformaadpenunjangekg' :
			
			if($_GET['ord'] == 'IRJ'){
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID IS NULL';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID) VALUES(
								"EKG","' . $_GET['ord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
				}
			}else{
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$penunjang_id = '';
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
					if(mysql_num_rows($get_penunjang_order) > 0){
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
					}else{
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,HEMODIALISA_ID) VALUES(
								"EKG","' . $_GET['ord'] . '","' . $_GET['idxord'] . '","' . $_GET['irja_id'] . '")') or die(mysql_error());
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.RAWAT_ID = "' . $_GET['idxord'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									AND t_ipenunjang.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
					}
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
				}
			}	
	
			echo 'ok';
			
			break;	
			
			case 'hemodialisareseptemplateadd' :
			
				$jns_order = $_GET['ord'];
	
				$sql = 'SELECT t_hemodialisa_template_resep.NAMA_RESEP,t_hemodialisa_template_resep.DOSIS,t_hemodialisa_template_resep.GENERIK,
						t_hemodialisa_template_resep.PSIKOTROPIKA
						FROM t_hemodialisa_template_resep
						WHERE t_hemodialisa_template_resep.HEMODIALISA_TEMPLATE_RESEP_ID = "' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($get) > 0){
					$dat = mysql_fetch_assoc($get);
					mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA)
						VALUES("' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_RESEP'] . '","' . $dat['DOSIS'] . '",
								"1","' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '")') or die(mysql_error());
					$sql_id = 'SELECT IRJA_RESEP_ID FROM t_irja_resep WHERE IRJA_ID = "' . $_GET['idx'] . '"
							ORDER BY IRJA_RESEP_ID DESC';
					$get_id = mysql_query($sql_id) or die(mysql_error());
					$dat_id = mysql_fetch_assoc($get_id);
					$resep_id = $dat_id['IRJA_RESEP_ID']; 
					
					$sql_detail = 'SELECT t_hemodialisa_template_resep_racikan.RESEP,t_hemodialisa_template_resep_racikan.PERSEDIAAN_ID,
									t_hemodialisa_template_resep_racikan.JUMLAH_KELUAR,t_hemodialisa_template_resep_racikan.SATUAN,
									t_hemodialisa_template_resep_racikan.FORMULARIUM,t_hemodialisa_template_resep_racikan.FORMULARIUM_NASIONAL
									FROM t_hemodialisa_template_resep_racikan
									WHERE t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_ID ="' . $_GET['resep'] . '"';
					$get_detail = mysql_query($sql_detail) or die(mysql_error());
					while($dat_detail = mysql_fetch_array($get_detail)){
						
						$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
						mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
						$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat_detail['PERSEDIAAN_ID'] . '"';	
						$get_harga = mysql_query($sql_harga) or die(mysql_error());
						$dat_harga = mysql_fetch_assoc($get_harga);
						$harga_jual = $dat_harga['HARGA_JUAL']; 
						
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
						
						mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,
								HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) VALUES("' . $resep_id . '","' . $dat_detail['RESEP'] . '",
								"' . $dat_detail['JUMLAH_KELUAR'] . '","' . $dat_detail['PERSEDIAAN_ID'] . '","' . $dat_detail['JUMLAH_KELUAR'] . '",
								"' . $dat_detail['SATUAN'] . '","' . $harga_jual . '","' . $dat_detail['FORMULARIUM'] . '",
								"' . $dat_detail['FORMULARIUM_NASIONAL'] . '")') or die(mysql_error());
					}
				}
				
			break;
			
			case 'hemodialisadeltemplateobat' :
				mysql_query('DELETE FROM t_hemodialisa_template_resep WHERE HEMODIALISA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				
				$sql_racikan = 'SELECT t_hemodialisa_template_resep.HEMODIALISA_TEMPLATE_RESEP_ID,
				t_hemodialisa_template_resep.RESEP,t_hemodialisa_template_resep.PERSEDIAAN_ID,t_hemodialisa_template_resep.JUMLAH_KELUAR,
				t_hemodialisa_template_resep.SATUAN,t_hemodialisa_template_resep.FORMULARIUM,t_hemodialisa_template_resep.FORMULARIUM_NASIONAL
				FROM t_hemodialisa_template_resep
				WHERE t_hemodialisa_template_resep.NO_TEMPLATE = "' . $_GET['no_resep'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){				
				?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
					<td width="20px" align="center"><?php echo $zx; ?></td>
					<td><?php echo $dat_racikan['RESEP']; ?></td>
					<td width="100"><?php echo $dat_racikan['JUMLAH']; ?></td>
					<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=hemodialisadeltemplateobat&resep_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_ID']; ?>&no_resep=<?php echo $dat_racikan['NO_TEMPLATE']; ?>');return false;" >hapus</a></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3" align="right"><input type="button" value="simpan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
				</tr>
				</table>
				</div>
				<?php }
			break;
			
			case 'hemodialisadeltemplateracikan' :
				mysql_query('DELETE FROM t_hemodialisa_template_resep_racikan WHERE HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID = "' . $_GET['racikan_id'] . '"') or die(mysql_error());
				
				$sql_racikan = 'SELECT t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID,
							t_hemodialisa_template_resep_racikan.RESEP,t_hemodialisa_template_resep_racikan.PERSEDIAAN_ID,t_hemodialisa_template_resep_racikan.JUMLAH_KELUAR,
							t_hemodialisa_template_resep_racikan.SATUAN,t_hemodialisa_template_resep_racikan.FORMULARIUM,t_hemodialisa_template_resep_racikan.FORMULARIUM_NASIONAL
							FROM t_hemodialisa_template_resep_racikan
							WHERE t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){				
				?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
					<td width="20px" align="center"><?php echo $zx; ?></td>
					<td><?php echo $dat_racikan['RESEP']; ?></td>
					<td width="100"><?php echo $dat_racikan['JUMLAH']; ?></td>
					<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=hemodialisadeltemplateracikan&racikan_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_ID']; ?>');return false;" >hapus</a></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3" align="right"><input type="button" value="simpan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
				</tr>
				</table>
				</div>
				<?php }
			break;
			
			case 'bayarhemodialisa' :
			
			$no_bayar = getNomorHarian('Kasir');
			$potongan = getCashPotongan($_GET['ch']);

			mysql_query('UPDATE t_hemodialisa_tarif 
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
					SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
					KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
					WHERE t_hemodialisa.RAWAT_ID = "' . $_GET['idx'] . '" 
					AND t_hemodialisa.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" 
					AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
		
			break;
			
			case 'batalbayarhemodialisa' :
				mysql_query('UPDATE t_hemodialisa_tarif 
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
					SHIFT_KASIR = NULL,USER_KASIR = "' . currentUser() . '",
					KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
					ST_BATAL_BAYAR = "' . $_GET['st'] . '"		
					WHERE t_hemodialisa.RAWAT_ID = "' . $_GET['idx'] . '" 
					AND t_hemodialisa.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" 
					AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());					
            break;
			
			case 'batalbayarambulance' :
				mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = NULL,TGL_BAYAR = NULL,ST_BAYAR = NULL,
							SHIFT_ID = NULL,USER_KASIR = "' . currentUser() . '",
							KODE_CASH = NULL,PERC_POTONGAN = 0,KODE_REKENING = NULL,
							ST_BATAL = "' . $_GET['st'] . '"
							WHERE RAWAT_ID = "' . $_GET['idx'] . '" AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
							AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
							
            break;
			
			case 'bayarambulance' :
				$no_bayar = getNomorHarian('Kasir');
				$potongan = getCashPotongan($_GET['ch']);

				mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '", 
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '" 
							WHERE RAWAT_ID = "' . $_GET['idx'] . '" AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
							AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			break;	
			
			case 'cjenisdocumen' :
				?>
				<select name="jns_dokumen" style="width:400px;" class="text_dt">
				<option value="" ></option>
				<?php 
					$sql_filter = '';
					$rawat = substr($_GET['rawat'],0,2);
					if($rawat == 'RJ') $sql_filter = 'WHERE IRJA = "1"';
					if($rawat == 'RI') $sql_filter = 'WHERE IRNA = "1"';
					$sql_dokumen = 'SELECT JENIS_DOKUMEN_ID,JENIS_DOKUMEN
										FROM m_rm_jenis_dokumen
										' . $sql_filter . '
										ORDER BY JENIS_DOKUMEN';
					$get_dokumen = mysql_query($sql_dokumen) or die(mysql_error());
					while($dat_dokumen = mysql_fetch_array($get_dokumen)){
						$slc_dokumen = '';
						if($jns_dokumen == $dat_dokumen['JENIS_DOKUMEN_ID']) $slc_dokumen = 'selected="selected"'; 
							echo '<option value="' . $dat_dokumen['JENIS_DOKUMEN_ID'] . '" ' . $slc_dokumen . ' >' . $dat_dokumen['JENIS_DOKUMEN'] . '</option>';
					}	
				?>
				</select>
				<?php
			break;
			
			case 'bospublish' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
				
				if($_GET['opt'] == 1){
										
					if($_GET['data'] == 'layanankes'){					
						mysql_query('UPDATE bos_layanan_kesehatan SET PUBLISH = "1" WHERE LAYANAN_KESEHATAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'penerimaan'){					
						mysql_query('UPDATE bos_keuangan_penerimaan SET PUBLISH = "1" WHERE KEUANGAN_PENERIMAAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'pengeluaran'){					
						mysql_query('UPDATE bos_keuangan_pengeluaran SET PUBLISH = "1" WHERE KEUANGAN_PENGELUARAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'saldo'){					
						mysql_query('UPDATE bos_keuangan_saldo SET PUBLISH = "1" WHERE KEUANGAN_SALDO_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
				
				}
				if($_GET['opt'] == 2){
						
					if($_GET['data'] == 'layanankes'){					
						mysql_query('UPDATE bos_layanan_kesehatan SET PUBLISH = NULL WHERE LAYANAN_KESEHATAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'penerimaan'){					
						mysql_query('UPDATE bos_keuangan_penerimaan SET PUBLISH = NULL WHERE KEUANGAN_PENERIMAAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'pengeluaran'){					
						mysql_query('UPDATE bos_keuangan_pengeluaran SET PUBLISH = NULL WHERE KEUANGAN_PENGELUARAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
					
					if($_GET['data'] == 'saldo'){					
						mysql_query('UPDATE bos_keuangan_saldo SET PUBLISH = NULL WHERE KEUANGAN_SALDO_ID = "' . $_GET['id'] . '"') or die(mysql_error());
					}
				
				}
			break;
			
			case 'menumakan' :
			
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			?>
			<select name="menu_makan" style="width:480px;" class="text_dt">
			<?php
				$sql_menu = 'SELECT m_menu_gizi_detail.MENU_GIZI_DETAIL_ID, 
							m_menu_gizi_detail.MENU_MAKAN
							FROM m_menu_gizi
							INNER JOIN m_menu_gizi_detail 
							ON (m_menu_gizi.MENU_GIZI_ID = m_menu_gizi_detail.MENU_GIZI_ID)
							WHERE m_menu_gizi.HARI = "' . $_GET['hari'] . '"
							AND m_menu_gizi.KELAS_RAWAT = "' . $_GET['kelas'] . '"
							AND m_menu_gizi.WAKTU = "' . $_GET['waktu'] . '"';
				$get_menu = mysql_query($sql_menu) or die(mysql_error());
				while($dat_menu = mysql_fetch_array($get_menu)){
					echo '<option value="' . $dat_menu['MENU_GIZI_DETAIL_ID'] . '" >' . $dat_menu['MENU_MAKAN'] . '</option>';
				}	
			?>	
			</select>	
			<?php
			
			break;
			
			case 'getpasienrawat' :
			?>
			<table border="1" class="tableData" id="tfhover" >
				<tr>
					<th>No</th>
					<th>Daftar</th>
					<th>Nomor MR</th>
					<th>Nama Pasien</th>
					<th>Tanggal Lahir</th>
					<th>Jenis Kelamin</th>
					<th>Pembayaran</th>
					<th>Ruang</th>
					<th>Kelas</th>
					<th>Tmp Tidur</th>
					<th>Dokter</th>
					<th>Option</th>
				</tr>
			<?php
				$sql_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
					m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
					m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
					t_irna.USER_IRNA,m_pegawai.NAMA_PEGAWAI,t_irna.NO_RAWAT,
					m_ruang.KELAS_RAWAT,t_irna.ST_PINDAH,t_irna.PASIEN_MASUK
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
					LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL	
					AND m_ruang.BANGSAL = "' . $_GET['ruang'] . '" AND t_irna.ST_PULANG IS NULL';
				$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
				$x = 1;
				while($dat_pasien = mysql_fetch_array($get_pasien)){
				?>	
					<tr>
						<td align="center"><?php echo $x; ?></td>
						<td align="center"><?php echo $dat_pasien['TANGGAL_DAFTAR']; ?></td>
						<td align="center"><?php echo formatNoMR($dat_pasien['NOMR']); ?></td>
						<td><?php echo $dat_pasien['NAMA_PASIEN']; ?></td>
						<td align="center"><?php echo changeDateFormat($dat_pasien['TGL_LAHIR']); ?></td>
						<td><?php echo jenisKelamin($dat_pasien['JNS_KELAMIN']); ?></td>
						<td><?php echo $dat_pasien['NAMA_JAMINAN']; ?></td>
						<td><?php echo $dat_pasien['NAMA_RUANG']; ?></td>
						<td align="center"><?php echo $dat_pasien['KELAS_RAWAT']; ?></td>
						<td align="center"><?php echo $dat_pasien['NO_TMP_TIDUR']; ?></td>
						<td><?php echo $dat_pasien['NAMA_PEGAWAI']; ?></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="<?php echo $dat_pasien['IRNA_ID']; ?>" checked="checked" />
						</td>
					</tr>
				<?php
				$x++;
				}	
			?>
			<tr>
				<td colspan="12" align="right"><input type="submit" name="simpan" value="simpan" class="myButton1" /></td>
			</tr>	
			</table>
			<input type="hidden" name="cnpasien" value="<?php echo $x-1; ?>" />
			<?php
			
			break;
			
			case 'cusersharing' :
				$instansi_arr = explode('-',$_GET['modul']);
				$app = $instansi_arr[0];
				$instansi = $instansi_arr[1];
				
				$sql = 'SELECT * FROM (SELECT db_simrs.m_pegawai.NAMA_PEGAWAI,db_simrs.m_app_user.NAMA_USER
						FROM db_simrs.m_app_user
						INNER JOIN db_simrs.m_pegawai 
						ON (db_simrs.m_app_user.PEGAWAI_ID = db_simrs.m_pegawai.PEGAWAI_ID)
						WHERE m_app_user.MODUL_ID = "' . $instansi . '"
						AND "1" = "' . $app . '"
						UNION ALL
						SELECT db_inventorirs.m_pegawai.NAMA_PEGAWAI,db_inventorirs.m_app_user.NAMA_USER
						FROM db_inventorirs.m_app_user
						INNER JOIN db_inventorirs.m_pegawai 
						ON (db_inventorirs.m_app_user.PEGAWAI_ID = db_inventorirs.m_pegawai.PEGAWAI_ID)
						WHERE db_inventorirs.m_app_user.MODUL_ID = "' . $instansi . '"
						AND "2" = "' . $app . '")
						t ORDER BY NAMA_PEGAWAI';
				$get = mysql_query($sql) or die(mysql_error());
				$x = 1;	
				while($dat = mysql_fetch_array($get)){
				?>
					<input type="checkbox" name="user_<?php echo $x; ?>" value="<?php echo $dat['NAMA_USER']?>" checked="checked" class="u" /><?php echo $dat['NAMA_PEGAWAI']; ?>&nbsp;&nbsp;	
					<?php
				$x++;
				}	
				?>
				<br />
				<a href="#" id="custom_button1" onclick="checkall();" >check all</a> | <a href="#" id="custom_button2" onclick="uncheckall();">uncheck all</a>
				<input type="hidden" name="cn_user" value="<?php echo $x-1; ?>" />	
				<?php
			break;
			
			case 'msgtidakaktif' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
				
				if($_GET['opt'] == 1){
					mysql_query('UPDATE msg_broadcast SET ST_MESSAGE = "1" WHERE NO_MESSAGE = "' . $_GET['id'] . '"') or die(mysql_error());
				}
				
				if($_GET['opt'] == 2){
					mysql_query('UPDATE msg_broadcast SET ST_MESSAGE = "" WHERE NO_MESSAGE = "' . $_GET['id'] . '"') or die(mysql_error());
				}
				
			break;
			
			case 'followup' :
			
			$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
			mysql_select_db($database_4, $connect_4) or die(mysql_error());
				
				if($_GET['opt'] == 1){
					mysql_query('UPDATE t_saran_pengaduan SET FOLLOW_UP = NOW() WHERE SARAN_PENGADUAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
				}
				
				if($_GET['opt'] == 2){
					mysql_query('UPDATE t_saran_pengaduan SET FOLLOW_UP = NULL WHERE SARAN_PENGADUAN_ID = "' . $_GET['id'] . '"') or die(mysql_error());
				}
				
			break;
			
			case 'pemeriksaanlabitem' :
			?>
				<select name="pemeriksaan" class="text_dt" style="width:320px;">
				<?php
				$sql_pemeriksaan = 'SELECT KODE_TARIF,NAMA_TARIF,MCU FROM m_tarif
						WHERE KODE_TARIF_GROUP = "' . $_GET['group']  . '"
						AND (ST_AKTIF = "1" OR MCU = "1")';
				$get_pemeriksaan = mysql_query($sql_pemeriksaan) or die(mysql_error());
				while($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)){ ?>
					<option value="<?php echo $dat_pemeriksaan['KODE_TARIF']; ?>" 
					<?php if($_GET['pemeriksaan'] == $dat_pemeriksaan['KODE_TARIF']) echo 'selected="selected"'; ?> 
					><?php $nama_tarif = $dat_pemeriksaan['NAMA_TARIF'];
						if($dat_pemeriksaan['MCU'] == '1') $nama_tarif .= ' (MCU)';
						echo $nama_tarif; ?></option>
				<?php } ?>
			</select>
			<?php
			break;
			
			case 'cekkeuanganformaadtarif' :
				
				$penerimaan_id = $_POST['xpenerimaan_id'];
				$tarif_id = $_POST['xtarif_id'];
				$sql_cek = 'SELECT COUNT(pnml.PENERIMAAN_LAINLAIN_TARIF_ID) AS JML
							FROM db_simkeu.r_penerimaan_lainlain pnm
							INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnml 
							ON (pnm.PENERIMAAN_LAINLAIN_ID = pnml.PENERIMAAN_LAINLAIN_ID)
							WHERE pnm.PENERIMAAN_LAINLAIN_ID = "' . $penerimaan_id . '" 
							AND pnml.TARIF_ID = "' . $tarif_id . '"';	
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'keuanganformaadtarif' :
			
			$penerimaan_id = $_GET['penerimaan_id'];
			$tarif_id = $_GET['tarif_id'];
			$qty = $_GET['qty'];
					
			mysql_query('INSERT INTO db_simkeu.r_penerimaan_lainlain_tarif(
						PENERIMAAN_LAINLAIN_ID,TARIF_ID,KUANTITI)
						VALUES("' . $penerimaan_id . '","' . $tarif_id . '",' . $qty . ')') or die(mysql_error());
			echo 'ok';			
			
			break;
			
			case 'cekoperasiformaadlaboratorium' :
				
				$operasi_id = $_POST['xoperasi_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.OPERASI_ID = "' . $operasi_id . '" 
							AND t_ipenunjang.NO_ORDER IS NULL
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Laboratorium (Kamar Operasi)")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'operasiformaadlaboratorium' :
				$sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['operasi_id'] . '"';
				$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
				$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
			if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.OPERASI_ID = "' . $_GET['operasi_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,OPERASI_ID) VALUES(
								"LAB","' . $_GET['ord'] . '","' . $_GET['rawat_id'] . '","' . $_GET['operasi_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.OPERASI_ID = "' . $_GET['operasi_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			}
			echo 'ok';
			
			break;
			
			case 'cekoperasiformaadradiologi' :
				
				$operasi_id = $_POST['xoperasi_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.OPERASI_ID = "' . $operasi_id . '" AND t_ipenunjang.NO_ORDER IS NULL
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Radiologi (Kamar Operasi)")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'operasiformaadradiologi' :
				$sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['operasi_id'] . '"';
				$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
				$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
			if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				
				$penunjang_id = '';
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.OPERASI_ID = "' . $_GET['operasi_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());
				if(mysql_num_rows($get_penunjang_order) > 0){
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID']; 
				}else{
					mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,OPERASI_ID) VALUES(
								"RAD","' . $_GET['ord'] . '","' . $_GET['rawat_id'] . '","' . $_GET['operasi_id'] . '")') or die(mysql_error());
					$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $_GET['ord'] . '"
									AND t_ipenunjang.OPERASI_ID = "' . $_GET['operasi_id'] . '" AND t_ipenunjang.NO_ORDER IS NULL
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
					$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
					$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
					$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				}
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $_GET['tarif_id'] . '",1)') or die(mysql_error());
			}
			echo 'ok';
			
			break;
			
			case 'identifikasiirjigd' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$id = $_POST['idx'];
			$fl = $_POST['field'];
			$dt = $_POST['dtx'];
			$un = $_POST['unt'];
			$arr_id = explode('|',$id);
			if($fl == 'tndk') $fieldname = 'SEBELUM_TINDAKAN'; 
			if($fl == 'pmob') $fieldname = 'SEBELUM_PEMBERIAN_OBAT'; 
			if($fl == 'trfs') $fieldname = 'SEBELUM_TRANSFUSI'; 
				
			if($arr_id[1] == ''){
				$get_id = mysql_query('SELECT KEPATUHAN_IDENTIFIKASI_ID 
							FROM mutu_kepatuhan_identifikasi_irj_igd 
							WHERE RAWAT_ID = "' . $arr_id[0] . '"') or die(mysql_error());
				$dat_id = mysql_fetch_assoc($get_id);
				if($dat_id['KEPATUHAN_IDENTIFIKASI_ID'] == ''){
					mysql_query('INSERT INTO mutu_kepatuhan_identifikasi_irj_igd(
								RAWAT_ID,UNIT_ID,' . $fieldname . ',PENGUMPUL_DATA,TGL_OBSERVASI)
								VALUES("' . $arr_id[0] . '","' . $un . '",
								"' . $arr_id[2] . '","' . currentUser() . '",
								STR_TO_DATE("' . $dt . '","%d/%m/%Y"))') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kepatuhan_identifikasi_irj_igd
						SET ' . $fieldname . ' = "' . $arr_id[2] . '",
						UNIT_ID = "' . $un . '", 
						PENGUMPUL_DATA = "' . currentUser() . '",
						TGL_OBSERVASI = STR_TO_DATE("' . $dt . '","%d/%m/%Y")
						WHERE KEPATUHAN_IDENTIFIKASI_ID = "' . $dat_id['KEPATUHAN_IDENTIFIKASI_ID'] . '"') or die(mysql_error());
				}	
			}else{
				mysql_query('UPDATE mutu_kepatuhan_identifikasi_irj_igd
						SET ' . $fieldname . ' = "' . $arr_id[2] . '",
						UNIT_ID = "' . $un . '", 
						PENGUMPUL_DATA = "' . currentUser() . '",
						TGL_OBSERVASI = STR_TO_DATE("' . $dt . '","%d/%m/%Y")
						WHERE KEPATUHAN_IDENTIFIKASI_ID = "' . $arr_id[1] . '"') or die(mysql_error());
			}	
			echo currentUser();
			
			break;
			
			case 'identifikasiiri' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$id = $_POST['idx'];
			$tndk = $_POST['tndk'];
			$pmob = $_POST['pmob'];
			$pspl = $_POST['pspl'];
			$pnts = $_POST['pnts'];
			$trfs = $_POST['trfs'];
			$tgl = $_POST['tgl'] . ' ' . date('H:i:s');
							
			/*$get_id = mysql_query('SELECT KEPATUHAN_IDENTIFIKASI_ID 
							FROM mutu_kepatuhan_identifikasi_iri 
							WHERE RAWAT_ID = "' . $id . '"
							AND TGL_OBSERVASI = STR_TO_DATE("' . $tgl . '","%d/%m/%Y")') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){*/
				mysql_query('INSERT INTO mutu_kepatuhan_identifikasi_iri(
								RAWAT_ID,RUANG_ID,SEBELUM_TINDAKAN,SEBELUM_PEMBERIAN_OBAT,
								SEBELUM_PENGAMBILAN_SAMPLE,SEBELUM_PEMBERIAN_NUTRISI,
								SEBELUM_TRANSFUSI,PENGUMPUL_DATA,TGL_OBSERVASI)
								VALUES("' . $id . '",NULL,"' . $tndk . '",
								"' . $pmob . '","' . $pspl . '","' . $pnts . '",
								"' . $trfs . '","' . currentUser() . '",
								STR_TO_DATE("' . $tgl . '","%d/%m/%Y %H:%i:%s"))') or die(mysql_error());
			/*}else{
				mysql_query('UPDATE mutu_kepatuhan_identifikasi_iri
							SET SEBELUM_TINDAKAN = "' . $tndk . '",
							SEBELUM_PEMBERIAN_OBAT = "' . $pmob . '",
							SEBELUM_PENGAMBILAN_SAMPLE = "' . $pspl . '",
							SEBELUM_PEMBERIAN_NUTRISI = "' . $pnts . '",
							SEBELUM_TRANSFUSI = "' . $trfs . '",
							PENGUMPUL_DATA = "' . currentUser() . '"
							WHERE RAWAT_ID = "' . $id . '"
							AND TGL_OBSERVASI = STR_TO_DATE("' . $tgl . '","%d/%m/%Y")') or die(mysql_error());
			}*/	
			
			echo 'Data telah disimpan.';
			
			break;
			
			case 'identifikasipenunjang' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$id = $_POST['idx'];
			$fl = $_POST['field'];
			$dt = $_POST['dtx'];
			$arr_id = explode('|',$id);
							
			if($arr_id[1] == ''){
				$get_id = mysql_query('SELECT KEPATUHAN_IDENTIFIKASI_ID 
							FROM mutu_kepatuhan_identifikasi_ipenunjang 
							WHERE RAWAT_ID = "' . $arr_id[0] . '"
							AND UNIT_ID = "' . $arr_id[2] . '"
							AND JNS_ORDER = "' . $arr_id[3] . '"
							AND NO_ORDER = "' . $arr_id[4] . '"') or die(mysql_error());
				$dat_id = mysql_fetch_assoc($get_id);
				if($dat_id['KEPATUHAN_IDENTIFIKASI_ID'] == ''){
					mysql_query('INSERT INTO mutu_kepatuhan_identifikasi_ipenunjang(
								RAWAT_ID,UNIT_ID,JNS_ORDER,NO_ORDER,SEBELUM_TINDAKAN,
								PENGUMPUL_DATA,TGL_OBSERVASI)
								VALUES("' . $arr_id[0] . '","' . $arr_id[2] . '",
								"' . $arr_id[3] . '","' . $arr_id[4] . '",
								"' . $arr_id[5] . '","' . currentUser() . '",
								STR_TO_DATE("' . $dt . '","%d/%m/%Y"))') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kepatuhan_identifikasi_ipenunjang
						SET SEBELUM_TINDAKAN = "' . $arr_id[5] . '",
						PENGUMPUL_DATA = "' . currentUser() . '",
						TGL_OBSERVASI = STR_TO_DATE("' . $dt . '","%d/%m/%Y")
						WHERE KEPATUHAN_IDENTIFIKASI_ID = "' . $dat_id['KEPATUHAN_IDENTIFIKASI_ID'] . '"') or die(mysql_error());
				}	
			}else{
				mysql_query('UPDATE mutu_kepatuhan_identifikasi_ipenunjang
						SET SEBELUM_TINDAKAN = "' . $arr_id[5] . '",
						PENGUMPUL_DATA = "' . currentUser() . '",
						TGL_OBSERVASI = STR_TO_DATE("' . $dt . '","%d/%m/%Y")
						WHERE KEPATUHAN_IDENTIFIKASI_ID = "' . $arr_id[1] . '"') or die(mysql_error());
			}	
			echo currentUser();
			
			break;
			
			case 'jamlaporlaboratorium' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$idx = $_POST['idx'];
			$nomr = $_POST['nomr'];
			$tarif = $_POST['tarif'];
			$form = $_POST['form'];
			$tglhasil = $_POST['tglhasil'];
			$tgllapor = $_POST['tgllapor'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT WAKTU_LAPOR_ID 
							FROM mutu_waktu_lapor_hasil_laboratorium 
							WHERE RAWAT_ID = "' . $idx . '"
							AND NO_TARIF = "' . $tarif . '"
							AND FORM_HASIL = "' . $form . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_waktu_lapor_hasil_laboratorium(
					RAWAT_ID,NOMR,NO_TARIF,FORM_HASIL,TGL_HASIL,TGL_LAPOR,PENGUMPUL_DATA,
					KETERANGAN) VALUES("' . $idx . '","' . $nomr . '","' . $tarif . '",
					"' . $form . '",STR_TO_DATE("' . $tglhasil . '","%d/%m/%Y %H:%i"),
					STR_TO_DATE("' . $tgllapor . '","%d/%m/%Y %H:%i"),
					"' . currentUser() . '","' . $keterangan . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_waktu_lapor_hasil_laboratorium
						SET TGL_HASIL = STR_TO_DATE("' . $tglhasil . '","%d/%m/%Y %H:%i"),
						TGL_LAPOR = STR_TO_DATE("' . $tgllapor . '","%d/%m/%Y %H:%i"),
						PENGUMPUL_DATA = "' . currentUser() . '",
						KETERANGAN = "' . $keterangan . '"
						WHERE RAWAT_ID = "' . $idx . '"
						AND NO_TARIF = "' . $tarif . '"
						AND FORM_HASIL = "' . $form . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'paketobat' :
			
			$arr_aturan_pakai = getResepAturanPakai();
			$arr_satuan_resep = getResepSatuan();
			$arr_waktu_pakai = getResepWaktuPakai();
			$arr_nama_racikan = getResepNamaRacikan();
			
			$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect) or die(mysql_error());
			echo '<form name="form_paket" id="form_paket">';
			echo '<table class="tableData" border="0" width="100%">';
			$sql_paket_obat = 'SELECT t_paket_obat_detail.PAKET_OBAT_DETAIL_ID,
								t_paket_obat_detail.PAKET_OBAT_ID,t_paket_obat_detail.PERSEDIAAN_ID,
								t_paket_obat_detail.JUMLAH,t_paket_obat_detail.SATUAN,t_paket_obat_detail.DOSIS,
								t_paket_obat_detail.SATUAN_DOSIS,t_paket_obat_detail.WAKTU_PAKAI,
								t_paket_obat_detail.FORM_RS,t_paket_obat_detail.FORM_NAS,
								t_paket_obat_detail.GENERIK,m_persediaan_farmasi.NAMA_PERSEDIAAN
								FROM t_paket_obat_detail
								INNER JOIN m_persediaan_farmasi 
								ON (t_paket_obat_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
								WHERE t_paket_obat_detail.PAKET_OBAT_ID = "' . $_GET['idx'] . '"';
			$get_paket_obat = mysql_query($sql_paket_obat) or die(mysql_error());
			$no = 1;
			while($dat_paket_obat = mysql_fetch_array($get_paket_obat)){ ?>
				<tr>
				<td width="10"><?php echo $no; ?></td>
				<td><?php echo $dat_paket_obat['NAMA_PERSEDIAAN']; ?></td>
				<td width="60" align="right"><?php echo $dat_paket_obat['JUMLAH']; ?></td>
				<td width="80"><?php echo $dat_paket_obat['SATUAN']; ?></td>
				<td width="220"><?php $arr_atp = explode('|',$dat_paket_obat['DOSIS']);
								$atp = '';
								foreach($arr_atp as $row){
									if(is_numeric($row)){
										$atp .= $arr_aturan_pakai[$row] . ',';
									}else{
										$atp .= $row . ',';
									}
								}
								echo substr($atp,0,strlen($atp)-1);
										
								$arr_str = explode('|',$dat_paket_obat['SATUAN_DOSIS']);
								$str = '';
								foreach($arr_str as $row){
									if(is_numeric($row)){
										$str .= $arr_satuan_resep[$row] . ',';
									}else{
										$str .= $row . ',';
									}
								}
								echo ' ' . substr($str,0,strlen($str)-1);
					?></td>
				<td width="220"><?php $arr_wkp = explode('|',$dat_paket_obat['WAKTU_PAKAI']);
						$wkp = '';
						foreach($arr_wkp as $row){
							if(is_numeric($row)){
								$wkp .= $arr_waktu_pakai[$row] . ',';
							}else{
								$wkp .= $row . ',';
							}
						}
						$wkp = substr($wkp,0,strlen($wkp)-1);
						echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
					?></td>
				<td width="50" align="center"><input type="checkbox" name="id_<?php echo $no; ?>" value="<?php echo $dat_paket_obat['PAKET_OBAT_DETAIL_ID']; ?>" checked /></td>
				</tr>
			<?php $no++; }	
			$no = $no - 1;
			echo '<tr>
				<td colspan="7" align="right"><input type="button" value="tambah" class="myButton1" 
				onclick="add_paket(' . $no . '); return false;" /></td>
			</tr>';
			echo '</table>';
			echo '</form>';
			
			break;
			
			case 'klinikaddpaketobat' :
					
					$arr_paket_obat = '';
					$cn = $_GET['cn'];
					$i = 1;
					while($i <= $cn){
						if(isset($_POST['id_' . $i])){
							$arr_paket_obat .= $_POST['id_' . $i] . ',';
						}
					$i++;
					}
					$arr_paket_obat .= '0';
					
					$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect) or die(mysql_error());
					
					$sql_paket_obat = 'SELECT pk.PAKET_OBAT_DETAIL_ID,pk.PAKET_OBAT_ID,
								pk.PERSEDIAAN_ID,pk.JUMLAH,pk.SATUAN,pk.DOSIS,pk.SATUAN_DOSIS,
								pk.WAKTU_PAKAI,pk.FORM_RS,pk.FORM_NAS,pk.GENERIK,fr.HARGA_JUAL,
								fr.NAMA_PERSEDIAAN
								FROM t_paket_obat_detail pk
								INNER JOIN m_persediaan_farmasi fr
								ON (pk.PERSEDIAAN_ID = fr.PERSEDIAAN_ID)
								WHERE PAKET_OBAT_DETAIL_ID IN (' . $arr_paket_obat . ')';
					$get_paket_obat = mysql_query($sql_paket_obat) or die(mysql_error());
					if(mysql_num_rows($get_paket_obat) > 0){
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
					
						while($dat = mysql_fetch_array($get_paket_obat)){
							mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							PAKET_OBAT_ID,JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_PERSEDIAAN'] . '","' . $dat['DOSIS'] . '",
							"' . $dat['JUMLAH'] . '","' . $dat['GENERIK'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $dat['HARGA_JUAL'] . '","' . $dat['FORM_RS'] . '",
							"' . $dat['FORM_NAS'] . '","' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '",
							"' . $dat['PAKET_OBAT_ID'] . '","' . $dat['JUMLAH'] . '")') or die(mysql_error());
						}
					}
			
			echo '1';
			
			break;
			
			case 'hemodialisaresepcopy' :
				if(isset($_GET['idx']) and isset($_GET['idx2'])){
					$idx = $_GET['idx'];					
					$idx2 = $_GET['idx2'];					
					$ord = $_GET['ord'];					
					$ord2 = $_GET['ord2'];
				
						if($ord2 == 'IRJA'){
							$qry = 'SELECT t_irja_resep.IRJA_ID,t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
								t_irja_resep.NO_RESEP,t_irja_resep.ST_RESEP,t_irja_resep.IRJA_RESEP_ID,
								t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
								t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
								t_irja_resep.JUMLAH_KELUAR,t_irja_resep.HARGA,t_irja_resep.PERSEDIAAN_ID,
								t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
								FROM t_irja_resep
								WHERE IRJA_ID = "' . $idx2 . '" AND t_irja_resep.RESEP IS NOT NULL
								ORDER BY t_irja_resep.NO_RESEP';
						}else{
							$qry = 'SELECT t_hemodailisa_resep.HEMODIALISA_ID,t_hemodailisa_resep.RESEP,t_hemodailisa_resep.RACIKAN,t_hemodailisa_resep.GENERIK,
								t_hemodailisa_resep.NO_RESEP,t_hemodailisa_resep.ST_RESEP,t_hemodailisa_resep.HEMODIALISA_RESEP_ID AS IRJA_RESEP_ID,
								t_hemodailisa_resep.DOSIS,t_hemodailisa_resep.JUMLAH,t_hemodailisa_resep.PSIKOTROPIKA,
								t_hemodailisa_resep.SATUAN,t_hemodailisa_resep.FORMULARIUM,t_hemodailisa_resep.FORMULARIUM_NASIONAL,
								t_hemodailisa_resep.JUMLAH_KELUAR,t_hemodailisa_resep.HARGA,t_hemodailisa_resep.PERSEDIAAN_ID,
								t_hemodailisa_resep.SATUAN_DOSIS,t_hemodailisa_resep.WAKTU_PAKAI
								FROM t_hemodailisa_resep
								WHERE HEMODIALISA_ID = "' . $idx2 . '" AND t_hemodailisa_resep.RESEP IS NOT NULL
								ORDER BY t_hemodailisa_resep.NO_RESEP';
						}		
						$get = mysql_query($qry) or die(mysql_error());
						while($dat = mysql_fetch_array($get)){
							
							$irja_resep_id = $dat['IRJA_RESEP_ID'];
							$resep = $dat['RESEP'];
							$dosis = $dat['DOSIS'];
							$jumlah = $dat['JUMLAH'];
							$racikan = $dat['RACIKAN'];
							$generik = $dat['GENERIK'];
							$psikotropika = $dat['PSIKOTROPIKA'];
							$persediaan_id = $dat['PERSEDIAAN_ID'];
							$jumlah_keluar = $dat['JUMLAH_KELUAR'];
							$satuan = $dat['SATUAN'];
							$satuan_dosis = $dat['SATUAN_DOSIS'];
							$waktu_pakai = $dat['WAKTU_PAKAI'];
							
							$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
							mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
							$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
									m_persediaan_farmasi.FORMULARIUM_NASIONAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $persediaan_id . '"';	
							$get_harga = mysql_query($sql_harga) or die(mysql_error());
							$dat_harga = mysql_fetch_assoc($get_harga);
							$harga = $dat_harga['HARGA_JUAL'];
							$formularium = $dat_harga['FORMULARIUM'];						 
							$formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
							$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
							mysql_select_db($database, $connect) or die(mysql_error());
							
							if(empty($ord)){
								mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,RACIKAN,GENERIK,PSIKOTROPIKA,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,
										SATUAN_DOSIS,WAKTU_PAKAI)
										VALUES("' . $_GET['idx'] . '",NOW(),"' . $resep . '","' . $dosis . '","' . $jumlah . '","' . $racikan . '","' . $generik . '","' . $psikotropika . '",
										"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
										"' . $formularium . '","' . $formularium_nasional . '",
										"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
							}else{
								mysql_query('INSERT INTO t_hemodailisa_resep(HEMODIALISA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,RACIKAN,GENERIK,PSIKOTROPIKA,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,
										SATUAN_DOSIS,WAKTU_PAKAI)
										VALUES("' . $_GET['idx'] . '",NOW(),"' . $resep . '","' . $dosis . '","' . $jumlah . '","' . $racikan . '","' . $generik . '","' . $psikotropika . '",
										"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
										"' . $formularium . '","' . $formularium_nasional . '",
										"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
							}			
							if($racikan == '1'){
								if(empty($ord)){
									$sql_resep_id = 'SELECT t_irja_resep.IRJA_RESEP_ID FROM t_irja_resep
													WHERE t_irja_resep.IRJA_ID = "' . $_GET['idx'] . '"
													ORDER BY t_irja_resep.IRJA_RESEP_ID DESC LIMIT 1';
								}else{
									$sql_resep_id = 'SELECT t_hemodialisa_resep.HEMODIALISA_RESEP_ID AS IRJA_RESEP_ID 
													FROM t_hemodialisa_resep
													WHERE t_hemodialisa_resep.HEMODIALISA_ID = "' . $_GET['idx'] . '"
													ORDER BY t_hemodialisa_resep.HEMODIALISA_RESEP_ID DESC LIMIT 1';
								}					
								$get_resep_id = mysql_query($sql_resep_id) or die(mysql_error());
								$dat_resep_id = mysql_fetch_assoc($get_resep_id);
								$resep_id = $dat_resep_id['IRJA_RESEP_ID']; 	
								
								if($ord2 == 'IRJA'){
									$sql_racikan = 'SELECT t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,t_irja_resep_racikan.PERSEDIAAN_ID,
											t_irja_resep_racikan.JUMLAH_KELUAR,t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.HARGA,
											t_irja_resep_racikan.FORMULARIUM,t_irja_resep_racikan.FORMULARIUM_NASIONAL
											FROM t_irja_resep_racikan
											WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $irja_resep_id . '"';
								}else{
									$sql_racikan = 'SELECT t_hemodailisa_resep_racikan.RESEP,t_hemodailisa_resep_racikan.JUMLAH,t_hemodailisa_resep_racikan.PERSEDIAAN_ID,
											t_hemodailisa_resep_racikan.JUMLAH_KELUAR,t_hemodailisa_resep_racikan.SATUAN,t_hemodailisa_resep_racikan.HARGA,
											t_hemodailisa_resep_racikan.FORMULARIUM,t_hemodailisa_resep_racikan.FORMULARIUM_NASIONAL
											FROM t_hemodailisa_resep_racikan
											WHERE t_hemodailisa_resep_racikan.IRJA_RESEP_ID = "' . $irja_resep_id . '"';
								}			
								$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
								while($dat_racikan = mysql_fetch_array($get_racikan)){
									
									$racikan_resep = $dat_racikan['RESEP']; 
									$racikan_jumlah = $dat_racikan['JUMLAH']; 
									$racikan_persediaan_id = $dat_racikan['PERSEDIAAN_ID']; 
									$racikan_jumlah_keluar = $dat_racikan['JUMLAH_KELUAR']; 
									$racikan_satuan = $dat_racikan['SATUAN']; 
									
									$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
									mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
									$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
										m_persediaan_farmasi.FORMULARIUM_NASIONAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $racikan_persediaan_id . '"';	
									$get_harga = mysql_query($sql_harga) or die(mysql_error());
									$dat_harga = mysql_fetch_assoc($get_harga);
									$racikan_harga = $dat_harga['HARGA_JUAL'];
									$racikan_formularium = $dat_harga['FORMULARIUM'];						 
									$racikan_formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
									$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
									mysql_select_db($database, $connect) or die(mysql_error());
								
									if(empty($ord)){
										mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,
											PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
											VALUES("' . $resep_id . '","' . $racikan_resep . '","' . $racikan_jumlah . '",
											"' . $racikan_persediaan_id . '","' . $racikan_jumlah_keluar . '","' . $racikan_satuan . '","' . $racikan_harga . '",
											"' . $racikan_formularium . '","' . $racikan_formularium_nasional . '")') or die(mysql_error()); 
									}else{
										mysql_query('INSERT INTO t_hemodailisa_resep_racikan(HEMODIALISA_RESEP_ID,RESEP,JUMLAH,
											PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
											VALUES("' . $resep_id . '","' . $racikan_resep . '","' . $racikan_jumlah . '",
											"' . $racikan_persediaan_id . '","' . $racikan_jumlah_keluar . '","' . $racikan_satuan . '","' . $racikan_harga . '",
											"' . $racikan_formularium . '","' . $racikan_formularium_nasional . '")') or die(mysql_error()); 
									}		
								}	
							}
						}		
				}
			break;
			
			case 'hemodialisaaddpaketobat' :
				$idx = $_GET['idx'];
				$ord = $_GET['ord'];						
					
					$arr_paket_obat = '';
					$cn = $_GET['cn'];
					$i = 1;
					while($i <= $cn){
						if(isset($_POST['id_' . $i])){
							$arr_paket_obat .= $_POST['id_' . $i] . ',';
						}
					$i++;
					}
					$arr_paket_obat .= '0';
					
					$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect) or die(mysql_error());
					
					$sql_paket_obat = 'SELECT pk.PAKET_OBAT_DETAIL_ID,pk.PAKET_OBAT_ID,
								pk.PERSEDIAAN_ID,pk.JUMLAH,pk.SATUAN,pk.DOSIS,pk.SATUAN_DOSIS,
								pk.WAKTU_PAKAI,pk.FORM_RS,pk.FORM_NAS,pk.GENERIK,fr.HARGA_JUAL,
								fr.NAMA_PERSEDIAAN
								FROM t_paket_obat_detail pk
								INNER JOIN m_persediaan_farmasi fr
								ON (pk.PERSEDIAAN_ID = fr.PERSEDIAAN_ID)
								WHERE PAKET_OBAT_DETAIL_ID IN (' . $arr_paket_obat . ')';
					$get_paket_obat = mysql_query($sql_paket_obat) or die(mysql_error());
					if(mysql_num_rows($get_paket_obat) > 0){
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
					
						while($dat = mysql_fetch_array($get_paket_obat)){
							if(empty($ord)){
								mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,
								PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
								PAKET_OBAT_ID,JUMLAH_KELUAR) VALUES(
								"' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_PERSEDIAAN'] . '","' . $dat['DOSIS'] . '",
								"' . $dat['JUMLAH'] . '","' . $dat['GENERIK'] . '","' . $dat['PERSEDIAAN_ID'] . '",
								"' . $dat['SATUAN'] . '","' . $dat['HARGA_JUAL'] . '","' . $dat['FORM_RS'] . '",
								"' . $dat['FORM_NAS'] . '","' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '",
								"' . $dat['PAKET_OBAT_ID'] . '","' . $dat['JUMLAH'] . '")') or die(mysql_error());
							}else{
								mysql_query('INSERT INTO t_hemodialisa_resep(HEMODIALISA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,
								PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
								PAKET_OBAT_ID,JUMLAH_KELUAR) VALUES(
								"' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_PERSEDIAAN'] . '","' . $dat['DOSIS'] . '",
								"' . $dat['JUMLAH'] . '","' . $dat['GENERIK'] . '","' . $dat['PERSEDIAAN_ID'] . '",
								"' . $dat['SATUAN'] . '","' . $dat['HARGA_JUAL'] . '","' . $dat['FORM_RS'] . '",
								"' . $dat['FORM_NAS'] . '","' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '",
								"' . $dat['PAKET_OBAT_ID'] . '","' . $dat['JUMLAH'] . '")') or die(mysql_error());
							}	
						}
					}
			
			echo '1';
			
			break;
			
			case 'hemodialisareseptemplateadd' :
				$idx = $_GET['idx'];
				$ord = $_GET['ord'];						
				
				if(empty($ord)){
					$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $idx . '"';	
				}else{
					$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $idx . '"';	
				}
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				
				if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
				$sql = 'SELECT t_irja_template_resep.NAMA_RESEP,t_irja_template_resep.DOSIS,t_irja_template_resep.GENERIK,
						t_irja_template_resep.PSIKOTROPIKA,t_irja_template_resep.SATUAN_DOSIS,t_irja_template_resep.WAKTU_PAKAI
						FROM t_irja_template_resep
						WHERE t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID = "' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($get) > 0){
					$dat = mysql_fetch_assoc($get);
					if(empty($ord)){
						mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
								SATUAN_DOSIS,WAKTU_PAKAI)
								VALUES("' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_RESEP'] . '","' . $dat['DOSIS'] . '",
								"1","' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '",
								"' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '")') or die(mysql_error());
						$sql_id = 'SELECT IRJA_RESEP_ID FROM t_irja_resep WHERE IRJA_ID = "' . $_GET['idx'] . '"
								ORDER BY IRJA_RESEP_ID DESC';
					}else{
						mysql_query('INSERT INTO t_hemodialisa_resep(HEMODIALISA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
								SATUAN_DOSIS,WAKTU_PAKAI)
								VALUES("' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_RESEP'] . '","' . $dat['DOSIS'] . '",
								"1","' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '",
								"' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '")') or die(mysql_error());
						$sql_id = 'SELECT HEMODIALISA_RESEP_ID AS IRJA_RESEP_ID FROM t_hemodialisa_resep WHERE HEMODIALISA_ID = "' . $_GET['idx'] . '"
								ORDER BY HEMODIALISA_RESEP_ID DESC';
					}			
					$get_id = mysql_query($sql_id) or die(mysql_error());
					$dat_id = mysql_fetch_assoc($get_id);
					$resep_id = $dat_id['IRJA_RESEP_ID']; 
					
					$sql_detail = 'SELECT t_irja_template_resep_racikan.RESEP,t_irja_template_resep_racikan.PERSEDIAAN_ID,
									t_irja_template_resep_racikan.JUMLAH_KELUAR,t_irja_template_resep_racikan.SATUAN,
									t_irja_template_resep_racikan.FORMULARIUM,t_irja_template_resep_racikan.FORMULARIUM_NASIONAL
									FROM t_irja_template_resep_racikan
									WHERE t_irja_template_resep_racikan.IRJA_TEMPLATE_RESEP_ID ="' . $_GET['resep'] . '"';
					$get_detail = mysql_query($sql_detail) or die(mysql_error());
					while($dat_detail = mysql_fetch_array($get_detail)){
						
						$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
						mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
						$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat_detail['PERSEDIAAN_ID'] . '"';	
						$get_harga = mysql_query($sql_harga) or die(mysql_error());
						$dat_harga = mysql_fetch_assoc($get_harga);
						$harga_jual = $dat_harga['HARGA_JUAL']; 
						
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
						
						if(empty($ord)){
							mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,
									HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) VALUES("' . $resep_id . '","' . $dat_detail['RESEP'] . '",
									"' . $dat_detail['JUMLAH_KELUAR'] . '","' . $dat_detail['PERSEDIAAN_ID'] . '","' . $dat_detail['JUMLAH_KELUAR'] . '",
									"' . $dat_detail['SATUAN'] . '","' . $harga_jual . '","' . $dat_detail['FORMULARIUM'] . '",
									"' . $dat_detail['FORMULARIUM_NASIONAL'] . '")') or die(mysql_error());
						}else{
							mysql_query('INSERT INTO t_hemodialisa_resep_racikan(HEMODIALISA_RESEP_ID,RESEP,JUMLAH,PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,
									HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) VALUES("' . $resep_id . '","' . $dat_detail['RESEP'] . '",
									"' . $dat_detail['JUMLAH_KELUAR'] . '","' . $dat_detail['PERSEDIAAN_ID'] . '","' . $dat_detail['JUMLAH_KELUAR'] . '",
									"' . $dat_detail['SATUAN'] . '","' . $harga_jual . '","' . $dat_detail['FORMULARIUM'] . '",
									"' . $dat_detail['FORMULARIUM_NASIONAL'] . '")') or die(mysql_error());
						}			
					}
				}
				}
				
			break;
			
			case 'hemodialisareseptemplateaddobat' :
				$idx = $_GET['idx'];
				$ord = $_GET['ord'];						
	
				$sql = 'SELECT t_irja_template_resep.RESEP,t_irja_template_resep.PERSEDIAAN_ID,
									t_irja_template_resep.JUMLAH_KELUAR,t_irja_template_resep.SATUAN,
									t_irja_template_resep.FORMULARIUM,t_irja_template_resep.FORMULARIUM_NASIONAL,
									t_irja_template_resep.DOSIS,t_irja_template_resep.GENERIK,t_irja_template_resep.PSIKOTROPIKA,
									t_irja_template_resep.SATUAN_DOSIS,t_irja_template_resep.WAKTU_PAKAI
									FROM t_irja_template_resep
									WHERE t_irja_template_resep.NO_TEMPLATE ="' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				while ($dat = mysql_fetch_assoc($get)){
					$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
					$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat['PERSEDIAAN_ID'] . '"';	
					$get_harga = mysql_query($sql_harga) or die(mysql_error());
					$dat_harga = mysql_fetch_assoc($get_harga);
					$harga_jual = $dat_harga['HARGA_JUAL']; 
						
					$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
					mysql_select_db($database, $connect) or die(mysql_error());
						
					if(empty($ord)){	
						mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,PSIKOTROPIKA,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['RESEP'] . '","' . $dat['DOSIS'] . '","' . $dat['JUMLAH_KELUAR'] . '",
							"' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $harga_jual . '","' . $dat['FORMULARIUM'] . '",
							"' . $dat['FORMULARIUM_NASIONAL'] . '","' . $dat['SATUAN_DOSIS'] . '",
							"' . $dat['WAKTU_PAKAI'] . '","' . $dat['JUMLAH_KELUAR'] . '")') or die(mysql_error());								
					}else{
						mysql_query('INSERT INTO t_hemodialisa_resep(HEMODIALISA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,PSIKOTROPIKA,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['RESEP'] . '","' . $dat['DOSIS'] . '","' . $dat['JUMLAH_KELUAR'] . '",
							"' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $harga_jual . '","' . $dat['FORMULARIUM'] . '",
							"' . $dat['FORMULARIUM_NASIONAL'] . '","' . $dat['SATUAN_DOSIS'] . '",
							"' . $dat['WAKTU_PAKAI'] . '","' . $dat['JUMLAH_KELUAR'] . '")') or die(mysql_error());								
					}		
						
					}
				
			break;
			
			case 'ranapresepcopy' :
				if(isset($_GET['idx']) and isset($_GET['idx2'])){	
						$qry = 'SELECT t_irna_resep.IRNA_ID,t_irna_resep.RESEP,t_irna_resep.RACIKAN,t_irna_resep.GENERIK,
							t_irna_resep.NO_RESEP,t_irna_resep.ST_RESEP,t_irna_resep.IRNA_RESEP_ID,
							t_irna_resep.DOSIS,t_irna_resep.JUMLAH,t_irna_resep.PSIKOTROPIKA,
							t_irna_resep.SATUAN,t_irna_resep.FORMULARIUM,t_irna_resep.FORMULARIUM_NASIONAL,
							t_irna_resep.JUMLAH_KELUAR,t_irna_resep.HARGA,t_irna_resep.PERSEDIAAN_ID,
							t_irna_resep.SATUAN_DOSIS,t_irna_resep.WAKTU_PAKAI
							FROM t_irna_resep
							WHERE IRNA_ID = "' . $_GET['idx'] . '" AND NO_RESEP = "' . $_GET['idx2'] . '" 
							AND t_irna_resep.RESEP IS NOT NULL';
						$get = mysql_query($qry) or die(mysql_error());
						while($dat = mysql_fetch_array($get)){
							
							$irna_resep_id = $dat['IRNA_RESEP_ID'];
							$resep = $dat['RESEP'];
							$dosis = $dat['DOSIS'];
							$jumlah = $dat['JUMLAH'];
							$racikan = $dat['RACIKAN'];
							$generik = $dat['GENERIK'];
							$psikotropika = $dat['PSIKOTROPIKA'];
							$persediaan_id = $dat['PERSEDIAAN_ID'];
							$jumlah_keluar = $dat['JUMLAH_KELUAR'];
							$satuan = $dat['SATUAN'];
							$satuan_dosis = $dat['SATUAN_DOSIS'];
							$waktu_pakai = $dat['WAKTU_PAKAI'];
							
							$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
							mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
							$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
									m_persediaan_farmasi.FORMULARIUM_NASIONAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $persediaan_id . '"';	
							$get_harga = mysql_query($sql_harga) or die(mysql_error());
							$dat_harga = mysql_fetch_assoc($get_harga);
							$harga = $dat_harga['HARGA_JUAL'];
							$formularium = $dat_harga['FORMULARIUM'];						 
							$formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
							$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
							mysql_select_db($database, $connect) or die(mysql_error());
							
							mysql_query('INSERT INTO t_irna_resep(IRNA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,RACIKAN,GENERIK,PSIKOTROPIKA,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,
										SATUAN_DOSIS,WAKTU_PAKAI)
										VALUES("' . $_GET['idx'] . '",NOW(),"' . $resep . '","' . $dosis . '","' . $jumlah . '","' . $racikan . '","' . $generik . '","' . $psikotropika . '",
										"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
										"' . $formularium . '","' . $formularium_nasional . '",
										"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
							if($racikan == '1'){
								$sql_resep_id = 'SELECT t_irna_resep.IRNA_RESEP_ID FROM t_irna_resep
												WHERE t_irna_resep.IRNA_ID = "' . $_GET['idx'] . '"
												ORDER BY t_irna_resep.IRNA_RESEP_ID DESC LIMIT 1';
								$get_resep_id = mysql_query($sql_resep_id) or die(mysql_error());
								$dat_resep_id = mysql_fetch_assoc($get_resep_id);
								$resep_id = $dat_resep_id['IRNA_RESEP_ID']; 	
								
								$sql_racikan = 'SELECT t_irna_resep_racikan.RESEP,t_irna_resep_racikan.JUMLAH,t_irna_resep_racikan.PERSEDIAAN_ID,
											t_irna_resep_racikan.JUMLAH_KELUAR,t_irna_resep_racikan.SATUAN,t_irna_resep_racikan.HARGA,
											t_irna_resep_racikan.FORMULARIUM,t_irna_resep_racikan.FORMULARIUM_NASIONAL
											FROM t_irna_resep_racikan
											WHERE t_irna_resep_racikan.IRNA_RESEP_ID = "' . $irna_resep_id . '"';
								$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
								while($dat_racikan = mysql_fetch_array($get_racikan)){
									
									$racikan_resep = $dat_racikan['RESEP']; 
									$racikan_jumlah = $dat_racikan['JUMLAH']; 
									$racikan_persediaan_id = $dat_racikan['PERSEDIAAN_ID']; 
									$racikan_jumlah_keluar = $dat_racikan['JUMLAH_KELUAR']; 
									$racikan_satuan = $dat_racikan['SATUAN']; 
									
									$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
									mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
									$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.FORMULARIUM,
										m_persediaan_farmasi.FORMULARIUM_NASIONAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $racikan_persediaan_id . '"';	
									$get_harga = mysql_query($sql_harga) or die(mysql_error());
									$dat_harga = mysql_fetch_assoc($get_harga);
									$racikan_harga = $dat_harga['HARGA_JUAL'];
									$racikan_formularium = $dat_harga['FORMULARIUM'];						 
									$racikan_formularium_nasional = $dat_harga['FORMULARIUM_NASIONAL'];						 
						
									$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
									mysql_select_db($database, $connect) or die(mysql_error());
								
									mysql_query('INSERT INTO t_irna_resep_racikan(IRNA_RESEP_ID,RESEP,JUMLAH,
										PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
										VALUES("' . $resep_id . '","' . $racikan_resep . '","' . $racikan_jumlah . '",
										"' . $racikan_persediaan_id . '","' . $racikan_jumlah_keluar . '","' . $racikan_satuan . '","' . $racikan_harga . '",
										"' . $racikan_formularium . '","' . $racikan_formularium_nasional . '")') or die(mysql_error()); 
								
								}	
							}
						}	
				}
			break;
			
			case 'ranapaddpaketobat' :
					
					$arr_paket_obat = '';
					$cn = $_GET['cn'];
					$i = 1;
					while($i <= $cn){
						if(isset($_POST['id_' . $i])){
							$arr_paket_obat .= $_POST['id_' . $i] . ',';
						}
					$i++;
					}
					$arr_paket_obat .= '0';
					
					$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect) or die(mysql_error());
					
					$sql_paket_obat = 'SELECT pk.PAKET_OBAT_DETAIL_ID,pk.PAKET_OBAT_ID,
								pk.PERSEDIAAN_ID,pk.JUMLAH,pk.SATUAN,pk.DOSIS,pk.SATUAN_DOSIS,
								pk.WAKTU_PAKAI,pk.FORM_RS,pk.FORM_NAS,pk.GENERIK,fr.HARGA_JUAL,
								fr.NAMA_PERSEDIAAN
								FROM t_paket_obat_detail pk
								INNER JOIN m_persediaan_farmasi fr
								ON (pk.PERSEDIAAN_ID = fr.PERSEDIAAN_ID)
								WHERE PAKET_OBAT_DETAIL_ID IN (' . $arr_paket_obat . ')';
					$get_paket_obat = mysql_query($sql_paket_obat) or die(mysql_error());
					if(mysql_num_rows($get_paket_obat) > 0){
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
					
						while($dat = mysql_fetch_array($get_paket_obat)){
							mysql_query('INSERT INTO t_irna_resep(IRNA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							PAKET_OBAT_ID,JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_PERSEDIAAN'] . '","' . $dat['DOSIS'] . '",
							"' . $dat['JUMLAH'] . '","' . $dat['GENERIK'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $dat['HARGA_JUAL'] . '","' . $dat['FORM_RS'] . '",
							"' . $dat['FORM_NAS'] . '","' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '",
							"' . $dat['PAKET_OBAT_ID'] . '","' . $dat['JUMLAH'] . '")') or die(mysql_error());
						}
					}
			
			echo '1';
			
			break;
			
			case 'ranapreseptemplateaddobat' :
				$sql = 'SELECT t_irna_template_resep.RESEP,t_irna_template_resep.PERSEDIAAN_ID,
									t_irna_template_resep.JUMLAH_KELUAR,t_irna_template_resep.SATUAN,
									t_irna_template_resep.FORMULARIUM,t_irna_template_resep.FORMULARIUM_NASIONAL,
									t_irna_template_resep.DOSIS,t_irna_template_resep.GENERIK,t_irna_template_resep.PSIKOTROPIKA,
									t_irna_template_resep.SATUAN_DOSIS,t_irna_template_resep.WAKTU_PAKAI
									FROM t_irna_template_resep
									WHERE t_irna_template_resep.NO_TEMPLATE ="' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				while ($dat = mysql_fetch_assoc($get)){
					$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
					mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
					$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
									FROM m_persediaan_farmasi
									WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat['PERSEDIAAN_ID'] . '"';	
					$get_harga = mysql_query($sql_harga) or die(mysql_error());
					$dat_harga = mysql_fetch_assoc($get_harga);
					$harga_jual = $dat_harga['HARGA_JUAL']; 
						
					$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
					mysql_select_db($database, $connect) or die(mysql_error());
						
					mysql_query('INSERT INTO t_irna_resep(IRNA_ID,TGL_RESEP,RESEP,DOSIS,JUMLAH,GENERIK,PSIKOTROPIKA,
							PERSEDIAAN_ID,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI,
							JUMLAH_KELUAR) VALUES(
							"' . $_GET['idx'] . '",NOW(),"' . $dat['RESEP'] . '","' . $dat['DOSIS'] . '","' . $dat['JUMLAH_KELUAR'] . '",
							"' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '","' . $dat['PERSEDIAAN_ID'] . '",
							"' . $dat['SATUAN'] . '","' . $harga_jual . '","' . $dat['FORMULARIUM'] . '",
							"' . $dat['FORMULARIUM_NASIONAL'] . '","' . $dat['SATUAN_DOSIS'] . '",
							"' . $dat['WAKTU_PAKAI'] . '","' . $dat['JUMLAH_KELUAR'] . '")') or die(mysql_error());								
						
					}
				
			break;
			
			case 'ranapreseptemplateadd' :
	
				$sql = 'SELECT t_irna_template_resep.NAMA_RESEP,t_irna_template_resep.DOSIS,t_irna_template_resep.GENERIK,
						t_irna_template_resep.PSIKOTROPIKA,t_irna_template_resep.SATUAN_DOSIS,t_irna_template_resep.WAKTU_PAKAI
						FROM t_irna_template_resep
						WHERE t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID = "' . $_GET['resep'] . '"';
				$get = mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($get) > 0){
					$dat = mysql_fetch_assoc($get);
					mysql_query('INSERT INTO t_irna_resep(IRNA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
						SATUAN_DOSIS,WAKTU_PAKAI)
						VALUES("' . $_GET['idx'] . '",NOW(),"' . $dat['NAMA_RESEP'] . '","' . $dat['DOSIS'] . '",
								"1","' . $dat['GENERIK'] . '","' . $dat['PSIKOTROPIKA'] . '",
								"' . $dat['SATUAN_DOSIS'] . '","' . $dat['WAKTU_PAKAI'] . '")') or die(mysql_error());
					$sql_id = 'SELECT IRNA_RESEP_ID FROM t_irna_resep WHERE IRNA_ID = "' . $_GET['idx'] . '"
							ORDER BY IRNA_RESEP_ID DESC';
					$get_id = mysql_query($sql_id) or die(mysql_error());
					$dat_id = mysql_fetch_assoc($get_id);
					$resep_id = $dat_id['IRNA_RESEP_ID']; 
					
					$sql_detail = 'SELECT t_irna_template_resep_racikan.RESEP,t_irna_template_resep_racikan.PERSEDIAAN_ID,
									t_irna_template_resep_racikan.JUMLAH_KELUAR,t_irna_template_resep_racikan.SATUAN,
									t_irna_template_resep_racikan.FORMULARIUM,t_irna_template_resep_racikan.FORMULARIUM_NASIONAL
									FROM t_irna_template_resep_racikan
									WHERE t_irna_template_resep_racikan.IRNA_TEMPLATE_RESEP_ID ="' . $_GET['resep'] . '"';
					$get_detail = mysql_query($sql_detail) or die(mysql_error());
					while($dat_detail = mysql_fetch_array($get_detail)){
						
						$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
						mysql_select_db($database_3, $connect_3) or die(mysql_error());
						
						$sql_harga = 'SELECT m_persediaan_farmasi.HARGA_JUAL 
										FROM m_persediaan_farmasi
										WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $dat_detail['PERSEDIAAN_ID'] . '"';	
						$get_harga = mysql_query($sql_harga) or die(mysql_error());
						$dat_harga = mysql_fetch_assoc($get_harga);
						$harga_jual = $dat_harga['HARGA_JUAL']; 
						
						$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
						mysql_select_db($database, $connect) or die(mysql_error());
						
						mysql_query('INSERT INTO t_irna_resep_racikan(IRNA_RESEP_ID,RESEP,JUMLAH,PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,
								HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) VALUES("' . $resep_id . '","' . $dat_detail['RESEP'] . '",
								"' . $dat_detail['JUMLAH_KELUAR'] . '","' . $dat_detail['PERSEDIAAN_ID'] . '","' . $dat_detail['JUMLAH_KELUAR'] . '",
								"' . $dat_detail['SATUAN'] . '","' . $harga_jual . '","' . $dat_detail['FORMULARIUM'] . '",
								"' . $dat_detail['FORMULARIUM_NASIONAL'] . '")') or die(mysql_error());
					}
				}
				
			break;
			
			case 'ranapdeltemplateracikan' :
				mysql_query('DELETE FROM t_irna_template_resep_racikan WHERE IRNA_TEMPLATE_RESEP_RACIKAN_ID = "' . $_GET['racikan_id'] . '"') or die(mysql_error());
				
				$sql_racikan = 'SELECT t_irna_template_resep_racikan.IRNA_TEMPLATE_RESEP_RACIKAN_ID,
							t_irna_template_resep_racikan.RESEP,t_irna_template_resep_racikan.PERSEDIAAN_ID,t_irna_template_resep_racikan.JUMLAH_KELUAR,
							t_irna_template_resep_racikan.SATUAN,t_irna_template_resep_racikan.FORMULARIUM,t_irna_template_resep_racikan.FORMULARIUM_NASIONAL
							FROM t_irna_template_resep_racikan
							WHERE t_irna_template_resep_racikan.IRNA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){				
				?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
				<tr>
					<td width="20px" align="center"><?php echo $zx; ?></td>
					<td><?php echo $dat_racikan['RESEP']; ?></td>
					<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
					<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=ranapdeltemplateracikan&racikan_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_ID']; ?>');return false;" >hapus</a></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4" align="right"><input type="button" value="simpan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
				</tr>
				</table>
				</div>
				<?php }
			break;
			
			case 'ranapdeltemplateresepobat' :
				mysql_query('DELETE FROM t_irna_template_resep WHERE NO_TEMPLATE = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				$searchkey = '';
				if (isset($_SESSION['ranaptemplateresep_searchkey'])) $searchkey = $_SESSION['ranaptemplateresep_searchkey'];
				
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();

				$qry_resep = 'SELECT t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID,t_irna_template_resep.NAMA_RESEP,
					t_irna_template_resep.DOSIS,t_irna_template_resep.GENERIK,
					t_irna_template_resep.PSIKOTROPIKA,t_irna_template_resep.NO_TEMPLATE,
					t_irna_template_resep.RESEP,t_irna_template_resep.JUMLAH_KELUAR,t_irna_template_resep.SATUAN,
					t_irna_template_resep.FORMULARIUM,t_irna_template_resep.FORMULARIUM_NASIONAL,
					t_irna_template_resep.SATUAN_DOSIS,t_irna_template_resep.WAKTU_PAKAI
					FROM t_irna_template_resep
					WHERE t_irna_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
					AND t_irna_template_resep.RACIKAN IS NULL';
				if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irna_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
				$qry_resep = $qry_resep . ' ORDER BY t_irna_template_resep.NO_TEMPLATE,t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID';
				$get_resep = mysql_query($qry_resep) or die(mysql_error());
				?>
				<table class="tableData" id="tfhover">
				<tr>
					<th width="30">No</th>
					<th>Nama Resep</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Form RS</th>
					<th>Form Nas</th>
					<th width="100">Option</th>
				</tr>
				<?php
			$i = 1;
			$no_resepx = '';
			$no_resepy = '';
			$no_resep = '';
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				?>
				<tr>
					<td align="center"><?php if($no_resepy != $dat_resep['NO_TEMPLATE']){
									$no_resepy = $dat_resep['NO_TEMPLATE'];
									echo $i;  
									$i++;
							} ?></td>
					<td><?php if($no_resep != $dat_resep['NO_TEMPLATE']){
									echo $dat_resep['NAMA_RESEP'];  
									$no_resep = $dat_resep['NO_TEMPLATE'];
							} ?></td>
					<td><?php echo $dat_resep['RESEP']; ?></td>
					<td align="right"><?php echo $dat_resep['JUMLAH_KELUAR']; ?></td>
					<td><?php echo $dat_resep['SATUAN']; ?></td>
					<td><?php $arr_atp = explode('|',$dat_resep['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
					<td>
					<?php $arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?>
					</td>
					<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
					<td align="center">
						<?php if($no_resepx != $dat_resep['NO_TEMPLATE']){ 
							$no_resepx = $dat_resep['NO_TEMPLATE']; ?>
						<a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['NO_TEMPLATE']; ?>'); open_location(); return false;" >hapus</a>
						<?php } ?>
						</td>
				</tr>
				<?php } ?>
			</table>
			<?php
				
			break;
			
			case 'ranapdeltemplateobat' :
				mysql_query('DELETE FROM t_irna_template_resep WHERE IRNA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();
				
				$sql_racikan = 'SELECT * FROM t_irna_template_resep
						WHERE NO_TEMPLATE = "' . $_GET['no_resep'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				if(mysql_num_rows($get_racikan) > 0){ ?>
				<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
				<table width="95%" class="tableData" id="tfhover">
				<tr>
					<th>No</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Option</th>
				</tr>
			<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
			<tr>
				<td width="20px" align="center"><?php echo $zx; ?></td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
				<td width="100"><?php $arr_atp = explode('|',$dat_racikan['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_racikan['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
				<td width="100"><?php $arr_wkp = explode('|',$dat_racikan['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?></td>
				<td align="center"><?php if($dat_racikan['GENERIK'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($dat_racikan['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
				<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=ranapdeltemplateobat&resep_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_ID']; ?>&no_resep=<?php echo $dat_racikan['NO_TEMPLATE']; ?>');return false;" >hapus</a></td>
			</tr>
			<?php $zx++; } ?>
			<tr>
				<td colspan="8" align="right"><input type="button" value="selesai" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
			</tr>
			</table>
			</div>
				<?php }
			
			break;
			
			case 'ranapdeltemplateresep' :
				mysql_query('DELETE FROM t_irna_template_resep WHERE IRNA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				mysql_query('DELETE FROM t_irna_template_resep_racikan WHERE IRNA_TEMPLATE_RESEP_ID = "' . $_GET['resep_id'] . '"') or die(mysql_error());
				
				$searchkey = '';
				if (isset($_SESSION['ranaptemplateresep_searchkey'])) $searchkey = $_SESSION['ranaptemplateresep_searchkey'];
				
				$arr_nama_racikan = getResepNamaRacikan();
				$arr_aturan_pakai = getResepAturanPakai();
				$arr_satuan_resep = getResepSatuan();
				$arr_waktu_pakai = getResepWaktuPakai();

				$qry_resep = 'SELECT * FROM t_irna_template_resep
							WHERE PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
							AND RACIKAN = "1"';
				if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irna_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
				$get_resep = mysql_query($qry_resep) or die(mysql_error());
				?>
				<table class="tableData" id="tfhover">
				<tr>
					<th width="30">No</th>
					<th>Nama Resep</th>
					<th>Nama Racikan</th>
					<th>Aturan Pakai</th>
					<th>Waktu Pakai</th>
					<th>Generik</th>
					<th>Psikotropika</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Form RS</th>
					<th>Form Nas</th>
					<th width="100">Option</th>
				</tr>
			<?php
			$i = 1;
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				?>
				<tr>
					<td align="center"><?php echo $i; ?></td>
					<td><?php echo $dat_resep['NAMA_RESEP']; ?></td>
					<td><?php $arr_nmr = explode('|',$dat_resep['NAMA_RACIKAN']);
									$nmr = '';
									foreach($arr_nmr as $row){
										if(is_numeric($row)){
											$nmr .= $arr_nama_racikan[$row] . ',';
										}else{
											$nmr .= $row . ',';
										}
									}
									echo substr($nmr,0,strlen($nmr)-1); ?></td>
					<td><?php $arr_atp = explode('|',$dat_resep['DOSIS']);
									$atp = '';
									foreach($arr_atp as $row){
										if(is_numeric($row)){
											$atp .= $arr_aturan_pakai[$row] . ',';
										}else{
											$atp .= $row . ',';
										}
									}
									echo substr($atp,0,strlen($atp)-1);
									
									$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
									$str = '';
									foreach($arr_str as $row){
										if(is_numeric($row)){
											$str .= $arr_satuan_resep[$row] . ',';
										}else{
											$str .= $row . ',';
										}
									}
									echo ' ' . substr($str,0,strlen($str)-1);
				?></td>
					<td>
					<?php $arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
									$wkp = '';
									foreach($arr_wkp as $row){
										if(is_numeric($row)){
											$wkp .= $arr_waktu_pakai[$row] . ',';
										}else{
											$wkp .= $row . ',';
										}
									}
									$wkp = substr($wkp,0,strlen($wkp)-1);
									echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
				?>
					</td>
					<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
					<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center"><a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['IRNA_TEMPLATE_RESEP_ID']; ?>'); open_location(); return false;" >hapus</a></td>
				</tr>
				<?php
						$sql_racikan = 'SELECT * FROM t_irna_template_resep_racikan
										WHERE IRNA_TEMPLATE_RESEP_ID = "' . $dat_resep['IRNA_TEMPLATE_RESEP_ID'] . '"';
						$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
						while($dat_racikan = mysql_fetch_array($get_racikan)){
						?>
						 <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php echo $dat_racikan['RESEP']; ?></td>
							<td><?php echo $dat_racikan['JUMLAH_KELUAR']; ?></td>
							<td><?php echo $dat_racikan['SATUAN']; ?></td>
							<td align="center"><?php if($dat_racikan['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
							<td align="center"><?php if($dat_racikan['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
							<td align="center">&nbsp;</td>
						</tr>
						<?php
						}	
					$i++; }
			?>
			</table>
			<?php 
			
			break;
			
			case 'getmakanpasien' :
			?>
			<table border="1" class="tableData" id="tfhover" >
			<tr>
				<th>No</th>
				<th>Daftar</th>
				<th>Nomor MR</th>      
				<th>Nama Pasien</th>
				<th>Tgl Lahir</th>
				<th>No Tempat Tidur</th>
				<th>Diagnosa</th>
				<th>Diet</th>
				<th>Option</th>
			</tr>
			<?php
				$sql_pasien = 'SELECT irn.IRNA_ID,irn.NOMR,
					DATE_FORMAT(irn.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
					irn.NO_TMP_TIDUR,psn.NAMA_PASIEN,DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					gzp.DIAGNOSA,gzp.DIET,gzp.GIZI_PERMINTAAN_ID
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
					LEFT JOIN db_simrs.m_ruang rng ON (irn.RUANG_ID = rng.RUANG_ID)
					LEFT JOIN db_inventorirs.t_gizi_permintaan gzp ON (
						irn.IRNA_ID = gzp.RAWAT_ID
						AND DATE_FORMAT(gzp.TANGGAL_PERMINTAAN,"%d/%m/%Y") = "' . $_POST['tg'] . '"
						AND gzp.JADWAL_MAKAN = "' . $_POST['wk'] . '"	
					)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL AND irn.ST_BATAL IS NULL	
					AND rng.BANGSAL = "' . $_POST['rg'] . '" AND irn.ST_PULANG IS NULL';
				$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
				$x = 1;
				while($dat_pasien = mysql_fetch_array($get_pasien)){
				?>	
					<tr>
						<td align="center"><?php echo $x; ?></td>
						<td align="center"><?php echo $dat_pasien['TANGGAL_DAFTAR']; ?></td>
						<td align="center"><?php echo formatNoMR($dat_pasien['NOMR']); ?></td>
						<td><?php echo $dat_pasien['NAMA_PASIEN']; ?></td>
						<td align="center"><?php echo $dat_pasien['TGL_LAHIR']; ?></td>
						<td><?php echo $dat_pasien['NO_TMP_TIDUR']; ?></td>
						<td><input type="text" name="diagnosa_<?php echo $x; ?>" id="diagnosa_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIAGNOSA']; ?>" class="text_dt" style="width:250px;" />
						<script>
							jQuery(document).ready(function() {
								jQuery("#diagnosa_<?php echo $x; ?>").autocomplete("index.php?autocomp=autocompranapdiagnosagizi&rawat=<?php echo $dat_pasien['IRNA_ID']; ?>",{width: 250px});
							});
						</script></td>
						<td><input type="text" name="diet_<?php echo $x; ?>" id="diet_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIET']; ?>" class="text_dt" style="width:250px;" />
						<script>
							jQuery(document).ready(function() {
								jQuery("#diet_<?php echo $x; ?>").autocomplete("index.php?autocomp=autocompranapdiet&rawat=<?php echo $dat_pasien['IRNA_ID']; ?>",{width: 250px});
							});
						</script></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="<?php echo $dat_pasien['IRNA_ID']; ?>" 
						<?php if($dat_pasien['GIZI_PERMINTAAN_ID'] != '') echo 'checked'; ?> />
						</td>
					</tr>
				<?php
				$x++;
				}	
				$sql_pasien = 'SELECT gzp.* FROM db_inventorirs.t_gizi_permintaan gzp 
						WHERE gzp.RAWAT_ID IS NULL 
						AND DATE_FORMAT(gzp.TANGGAL_PERMINTAAN,"%d/%m/%Y") = "' . $_POST['tg'] . '"
						AND gzp.JADWAL_MAKAN = "' . $_POST['wk'] . '"';
				$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
				$jml_row_la = mysql_num_rows($get_pasien);
				$g = 1;
				while($dat_pasien = mysql_fetch_array($get_pasien)){
				if($g == 1){
				?>	
					<tr>
						<td colspan="3" rowspan="<?php echo $jml_row_la + 1; ?>">Diluar Akomodasi</td>
						<td><input type="text" name="pemesan_<?php echo $x; ?>" value="<?php echo $dat_pasien['NAMA_PASIEN']; ?>" class="text_dt" style="width:250px;" /></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="text" name="diagnosa_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIAGNOSA']; ?>" class="text_dt" style="width:250px;" /></td>
						<td><input type="text" name="diet_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIET']; ?>" class="text_dt" style="width:250px;" /></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="x" checked />
						</td>
					</tr>
				<?php }else{ ?>
				<tr>
						<td><input type="text" name="pemesan_<?php echo $x; ?>" value="<?php echo $dat_pasien['NAMA_PASIEN']; ?>" class="text_dt" style="width:250px;" /></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="text" name="diagnosa_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIAGNOSA']; ?>" class="text_dt" style="width:250px;" /></td>
						<td><input type="text" name="diet_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIET']; ?>" class="text_dt" style="width:250px;" /></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="x" checked />
						</td>
					</tr>
				<?php }
				$x++;
				$g++;
				}	
			if($jml_row_la == 0){ ?>
					<tr>
						<td colspan="3">Diluar Akomodasi</td>
						<td><input type="text" name="pemesan_<?php echo $x; ?>"<?php echo $dat_pasien['NAMA_PASIEN']; ?> class="text_dt" style="width:250px;" /></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="text" name="diagnosa_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIAGNOSA']; ?>" class="text_dt" style="width:250px;" /></td>
						<td><input type="text" name="diet_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIET']; ?>" class="text_dt" style="width:250px;" /></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="x" />
						</td>
					</tr>
			<?php }else{ ?>
					<tr>
						<td><input type="text" name="pemesan_<?php echo $x; ?>"<?php echo $dat_pasien['NAMA_PASIEN']; ?> class="text_dt" style="width:250px;" /></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="text" name="diagnosa_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIAGNOSA']; ?>" class="text_dt" style="width:250px;" /></td>
						<td><input type="text" name="diet_<?php echo $x; ?>" value="<?php echo $dat_pasien['DIET']; ?>" class="text_dt" style="width:250px;" /></td>
						<td align="center">
						<input type="checkbox" name="pasien_<?php echo $x; ?>" value="x" />
						</td>
					</tr>
			<?php } ?>
			<tr>
				<td colspan="9" align="right">
				<input type="submit" name="simpan" value="simpan" class="myButton1" />
				<input type="button" value="tutup" class="myButton1" onclick="tutup();">
			</tr>	
			</table>
			<input type="hidden" name="cnpasien" value="<?php echo $x; ?>" />
			<?php
			
			break;
			
			case 'detailtarif' :
			
			$arr_ck = explode('|',$_POST['kode_tarif_group']);
			$arr_kode_tarif_group = explode('-',$arr_ck[1]);
			$kode_tarif_group = $arr_kode_tarif_group[1];
			$filter_report = $arr_ck[3];
			$report_id = $arr_ck[2];			
			$level = $arr_ck[4];			
				
			$sql = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
				t_filter_report_tarif.ID_FILTER
				FROM m_tarif
				LEFT JOIN t_filter_report_tarif 
				ON (m_tarif.KODE_TARIF = t_filter_report_tarif.KODE_TARIF_GROUP
				AND t_filter_report_tarif.NAMA_TARIF_FILTER = "' . $filter_report . '"
				AND t_filter_report_tarif.REPORT_ID = "' . $report_id . '"
				AND t_filter_report_tarif.LEVEL_DT = "2")
				WHERE m_tarif.ST_AKTIF = "1"
				AND m_tarif.KODE_TARIF_GROUP = "' . $kode_tarif_group . '"';
			$get = mysql_query($sql) or die(mysql_error()); 
			$row = mysql_num_rows($get); ?>
			<table class="tableData">
			<?php $i = 0;
			while($dat = mysql_fetch_array($get)){
				$i++; ?>	
					<tr>
					<td width="140px" align="right"><i><?php echo $i; ?></i>&nbsp;</td>
					<td align="center" width="80px"><i><?php echo $dat['KODE_TARIF']; ?></i></td>	
					<td width="300px"><i><?php echo $dat['NAMA_TARIF']; ?></i></td>
					<td>
						<?php if($level == '2'){ ?>
						<input type="checkbox" name="kd_jenis_tarif200<?php echo $i; ?>" id="kd_jenis_tarif200<?php echo $i; ?>" value="2-<?php echo $dat['KODE_TARIF']; ?>|<?php echo $report_id; ?>|<?php echo $filter_report; ?>|<?php echo $level; ?>" <?php if($dat['ID_FILTER'] != '') echo 'checked'; ?> onclick="JavaScript : centang_opt(200<?php echo $i; ?>,this.value);">
						<?php }else{ ?>
						<input type="checkbox" name="kd_jenis_tarif200<?php echo $i; ?>" id="kd_jenis_tarif200<?php echo $i; ?>" value="2-<?php echo $dat['KODE_TARIF']; ?>|<?php echo $report_id; ?>|<?php echo $filter_report; ?>|<?php echo $level; ?>" disabled>
						<?php } ?>
					</td>	
					</tr>
				<?php	}  ?>
			</table> 
            <?php 
			break;
			
			case 'simpancekfilterreport' :
				$arr_val = explode('|',$_GET['val']);
				$arr_tarif = explode('-',$arr_val[0]);
				$level = $arr_tarif[0];
				$kode_tarif = $arr_tarif[1];
				$filter_report = $arr_val[2];
				$report_id = $arr_val[1];	
				
				if($_GET['opt'] == 1){
					mysql_query('INSERT INTO t_filter_report_tarif(KODE_TARIF_GROUP,NAMA_TARIF_FILTER,LEVEL_DT,REPORT_ID)
							VALUES("' . $kode_tarif . '","' . $filter_report . '","' . $level . '","' . $report_id . '")') or die(mysql_error());
				}
				
				if($_GET['opt'] == 2){
					mysql_query('DELETE FROM t_filter_report_tarif WHERE KODE_TARIF_GROUP = "' . $kode_tarif . '"
							AND NAMA_TARIF_FILTER = "' . $filter_report . '"
							AND LEVEL_DT = "' . $level . '"
							AND REPORT_ID = "' . $report_id . '"') or die(mysql_error());
				}
				
			break;
			
			case 'visitharianpasieniri' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$dokter = $_POST['dokter'];
			$id = $_POST['id'];
			$tanggal = $_POST['tanggal'];
			$ruang = $_POST['ruang'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT VISIT_DOKTER_ID 
							FROM mutu_kepatuhan_jam_visit_dokter 
							WHERE IRNA_ID = "' . $id . '"
							AND PEGAWAI_ID = "' . $dokter . '"
							AND RUANG_ID = "' . $ruang . '"
							AND TANGGAL = STR_TO_DATE("' . $tanggal . '","%d/%m/%Y %H:%i")') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){
				mysql_query('INSERT INTO mutu_kepatuhan_jam_visit_dokter(
							PEGAWAI_ID,IRNA_ID,TANGGAL,RUANG_ID,KETERANGAN,
							PENGUMPUL_DATA)
							VALUES("' . $dokter . '","' . $id . '",
							STR_TO_DATE("' . $tanggal . '","%d/%m/%Y %H:%i"),
							"' . $ruang . '","' . $keterangan . '",
							"' . currentUser() . '")') or die(mysql_error());
			}else{
				mysql_query('UPDATE mutu_kepatuhan_jam_visit_dokter 
							SET KETERANGAN = "' . $keterangan . '",
							PENGUMPUL_DATA = "' . currentUser() . '" 
							WHERE IRNA_ID = "' . $id . '"
							AND PEGAWAI_ID = "' . $dokter . '"
							AND RUANG_ID = "' . $ruang . '"
							AND TANGGAL = STR_TO_DATE("' . $tanggal . '","%d/%m/%Y %H:%i")') or die(mysql_error());
			}	
			
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kepatuhanpenggunaanformularium' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$idx = $_POST['idx'];
			$nomormr = $_POST['nomormr'];
			$tanggal = $_POST['tanggal'];
			$formularium = $_POST['formularium'];
			$nonformularium = $_POST['nonformularium'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT KEPATUHAN_FORMULARIUM_ID 
							FROM mutu_kepatuhan_formularium 
							WHERE RAWAT_ID = "' . $idx . '"
							AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tanggal . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kepatuhan_formularium(
						RAWAT_ID,NOMR,FORMULARIUM,
						NON_FORMULARIUM,TANGGAL,
						KETERANGAN,PENGUMPUL_DATA)
						VALUES("' . $idx . '","' . $nomormr . '","' . $formularium . '",
						"' . $nonformularium . '",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . $keterangan . '","' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kepatuhan_formularium
					SET FORMULARIUM = "' . $formularium . '",
					NON_FORMULARIUM = "' . $nonformularium . '",
					KETERANGAN = "' . $keterangan . '",
					PENGUMPUL_DATA = "' . currentUser() . '"
					WHERE RAWAT_ID = "' . $idx . '"
					AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tanggal . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'pencegahanpasienjatuh' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$idx = $_POST['idx'];
			$glk = $_POST['glk'];
			$stk = $_POST['stk'];
			$ptt = $_POST['ptt'];
			$edk = $_POST['edk'];
			$jth = $_POST['jth'];
			$asm = $_POST['asm'];
			$grd = $_POST['grd'];
			$tgl = $_POST['tgl'] . ' ' . date('H:i:s');
			$rng = $_POST['rng'];
							
			/*$get_id = mysql_query('SELECT PASIEN_JATUH_ID 
							FROM mutu_pencegahan_resiko_pasien_jatuh 
							WHERE RAWAT_ID = "' . $idx . '"
							AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tgl . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	*/
				mysql_query('INSERT INTO mutu_pencegahan_resiko_pasien_jatuh(
						RAWAT_ID,RUANG_ID,ASSESMENT,GRADING,GELANG_KUNING,
						SEGITIGA_KUNING,PAGAR_TT,EDUKASI,JATUH,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $idx . '","' . $rng . '","' . $asm . '","' . $grd . '",
						"' . $glk . '","' . $stk . '","' . $ptt . '","' . $edk . '",
						"' . $jth . '",STR_TO_DATE("' . $tgl . '","%d/%m/%Y %H:%i:%s"),"' . currentUser() . '")') or die(mysql_error());
			/*	}else{
					mysql_query('UPDATE mutu_pencegahan_resiko_pasien_jatuh
						SET RUANG_ID = "' . $rng . '",
						ASSESMENT = "' . $asm . '",
						GRADING = "' . $grd . '",
						GELANG_KUNING = "' . $glk . '",
						SEGITIGA_KUNING = "' . $stk . '",
						PAGAR_TT = "' . $ptt . '",
						EDUKASI = "' . $edk . '",
						JATUH = "' . $jth . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE RAWAT_ID = "' . $idx . '"
						AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tgl . '"') or die(mysql_error());
				}	*/
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kepatuhanclinicalpathway' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$idx = $_POST['idx'];
			$pkj = $_POST['pkj'];
			$obt = $_POST['obt'];
			$pnj = $_POST['pnj'];
			$det = $_POST['det'];
			$edk = $_POST['edk'];
			$tgl = $_POST['tgl'];
			$rng = $_POST['rng'];
							
			$get_id = mysql_query('SELECT CLINICAL_PATHWAY_ID 
							FROM mutu_kepatuhan_clinical_pathway 
							WHERE RAWAT_ID = "' . $idx . '"
							AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tgl . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kepatuhan_clinical_pathway(
							RAWAT_ID,RUANG_ID,PENGKAJIAN,OBAT,PENUNJANG,
							DIET,EDUKASI,TANGGAL,PENGUMPUL_DATA)
							VALUES("' . $idx . '","' . $rng . '","' . $pkj . '",
							"' . $obt . '","' . $pnj . '","' . $det . '",
							"' . $edk . '",STR_TO_DATE("' . $tgl . '","%d/%m/%Y"),
							"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kepatuhan_clinical_pathway
						SET PENGKAJIAN = "' . $pkj . '",
						OBAT = "' . $obt . '",
						PENUNJANG = "' . $pnj . '",
						DIET = "' . $det . '",
						EDUKASI = "' . $edk . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE RAWAT_ID = "' . $idx . '"
						AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $tgl . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'ketidaksesuaiandiagnosisbedah' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagpra = $_POST['diagpra'];
			$diagpasca = $_POST['diagpasca'];
			$tanggal = $_POST['tanggal'];
			$sesuai = $_POST['sesuai'];
							
			$get_id = mysql_query('SELECT DIAGNOSA_BEDAH_ID 
							FROM mutu_ketidaksesuaian_diagnosa_bedah 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_ketidaksesuaian_diagnosa_bedah(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA_PRABEDAH,DIAGNOSA_PASCABEDAH,
						SESUAI,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '","' . $order . '",
						"' . $diagpra . '","' . $diagpasca . '","' . $sesuai . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_ketidaksesuaian_diagnosa_bedah
						SET DIAGNOSA_PRABEDAH = "' . $diagpra . '",
						DIAGNOSA_PASCABEDAH = "' . $diagpasca . '",
						SESUAI = "' . $sesuai . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'infeksidaerahoperasi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$jenis = $_POST['jenis'];
			$tanggal = $_POST['tanggal'];
			$infeksi = $_POST['infeksi'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT INFEKSI_DAERAH_OPERASI_ID 
							FROM mutu_infeksi_daerah_operasi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_infeksi_daerah_operasi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,JNS_OPERASI,
						INFEKSI,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $jenis . '","' . $infeksi . '",
						"' . $keterangan . '",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_infeksi_daerah_operasi
						SET DIAGNOSA = "' . $diagnosa . '",
						JNS_OPERASI = "' . $jenis . '",
						INFEKSI = "' . $infeksi . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'angkaktd' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$ktd = $_POST['ktd'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT ANGKA_KTD_ID 
							FROM mutu_angka_ktd 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_angka_ktd(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KTD,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $ktd . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_angka_ktd
						SET DIAGNOSA = "' . $diagnosa . '",
						KTD = "' . $ktd . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kelengkapanassesment' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$assesment = $_POST['assesment'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT ASSESMENT_ID 
							FROM mutu_kelengkapan_assesment_praoperasi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kelengkapan_assesment_praoperasi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KELENGKAPAN_ASSESMENT,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $assesment . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kelengkapan_assesment_praoperasi
						SET DIAGNOSA = "' . $diagnosa . '",
						KELENGKAPAN_ASSESMENT = "' . $assesment . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kelengkapanlap_anestesi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$lap_anestesi = $_POST['lap_anestesi'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT ANESTESI_ID 
							FROM mutu_kelengkapan_laporan_anestesi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kelengkapan_laporan_anestesi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KELENGKAPAN_LAPORAN,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $lap_anestesi . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kelengkapan_laporan_anestesi
						SET DIAGNOSA = "' . $diagnosa . '",
						KELENGKAPAN_LAPORAN = "' . $lap_anestesi . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kelengkapanlap_operasi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$lap_operasi = $_POST['lap_operasi'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT LAP_OPERASI_ID 
							FROM mutu_kelengkapan_laporan_operasi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kelengkapan_laporan_operasi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KELENGKAPAN_LAPORAN,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $lap_operasi . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kelengkapan_laporan_operasi
						SET DIAGNOSA = "' . $diagnosa . '",
						KELENGKAPAN_LAPORAN = "' . $lap_operasi . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kejadiannsalah_sisi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$salah_sisi = $_POST['salah_sisi'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT SALAH_SISI_ID 
							FROM mutu_kejadian_salah_sisi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kejadian_salah_sisi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KEJADIAN_SALAH_SISI,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $salah_sisi . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kejadian_salah_sisi
						SET DIAGNOSA = "' . $diagnosa . '",
						KEJADIAN_SALAH_SISI = "' . $salah_sisi . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'kejadiannsalah_pasien' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$tanggal = $_POST['tanggal'];
			$salah_pasien = $_POST['salah_pasien'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT PASIEN_OPERASI_ID 
							FROM mutu_kejadian_salah_pasien_operasi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kejadian_salah_pasien_operasi(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,
						KEJADIAN_SALAH_PASIEN,KETERANGAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '",
						"' . $order . '","' . $diagnosa . '",
						"' . $salah_pasien . '","' . $keterangan . '",
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kejadian_salah_pasien_operasi
						SET DIAGNOSA = "' . $diagnosa . '",
						KEJADIAN_SALAH_PASIEN = "' . $salah_pasien . '",
						KETERANGAN = "' . $keterangan . '",
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'pemakaianventilator' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$jenis = $_POST['jenis'];
			$tanggal = $_POST['tanggal'];
			$tanggal_1 = $_POST['tanggal_1'];
			$tanggal_2 = $_POST['tanggal_2'];
			$jam_1 = $_POST['jam_1'];
			$jam_2 = $_POST['jam_2'];
			$menit_1 = $_POST['menit_1'];
			$menit_2 = $_POST['menit_2'];
							
			$get_id = mysql_query('SELECT PEMAKAIAN_VENTILATOR_ID 
							FROM mutu_pemakaian_ventilator 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_pemakaian_ventilator(
						OPERASI_ID,RAWAT_ID,JNS_ORDER,DIAGNOSA,JNS_OPERASI,
						JAM_PEMASANGAN,JAM_PELEPASAN,TANGGAL,PENGUMPUL_DATA)
						VALUES("' . $operasi . '","' . $idx . '","' . $order . '",
						"' . $diagnosa . '","' . $jenis . '",
						STR_TO_DATE("' . $tanggal_1 . ' ' . $jam_1 . ':' . $menit_1 . '","%d/%m/%Y %H:%i"),
						STR_TO_DATE("' . $tanggal_2 . ' ' . $jam_2 . ':' . $menit_2 . '","%d/%m/%Y %H:%i"),
						STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
						"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_pemakaian_ventilator
						SET DIAGNOSA = "' . $diagnosa . '",
						JNS_OPERASI = "' . $jenis . '",
						JAM_PEMASANGAN = STR_TO_DATE("' . $tanggal_1 . ' ' . $jam_1 . ':' . $menit_1 . '","%d/%m/%Y %H:%i"),
						JAM_PELEPASAN = STR_TO_DATE("' . $tanggal_2 . ' ' . $jam_2 . ':' . $menit_2 . '","%d/%m/%Y %H:%i"),
						PENGUMPUL_DATA = "' . currentUser() . '"
						WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'informedconsent' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$jenis = $_POST['jenis'];
			$tanggal = $_POST['tanggal'];
			$tranfusi = $_POST['tranfusi'];
			$informed = $_POST['informed'];
							
			$get_id = mysql_query('SELECT INFORMED_CONSENT_ID 
							FROM mutu_informed_consent 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_informed_consent(
							OPERASI_ID,RAWAT_ID,JNS_ORDER,
							DIAGNOSA,JNS_OPERASI,TRANSFUSI_DARAH,
							INFORMED_CONSENT,TANGGAL,PENGUMPUL_DATA)
							VALUES("' . $operasi . '","' . $idx . '",
							"' . $order . '","' . $diagnosa . '",
							"' . $jenis . '","' . $tranfusi . '",
							"' . $informed . '",
							STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
							"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_informed_consent
							SET DIAGNOSA = "' . $diagnosa . '",
							JNS_OPERASI = "' . $jenis . '",
							TRANSFUSI_DARAH = "' . $tranfusi . '",
							INFORMED_CONSENT = "' . $informed . '",
							PENGUMPUL_DATA = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'monitoringtransfusi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$diagnosa = $_POST['diagnosa'];
			$jenis = $_POST['jenis'];
			$tanggal = $_POST['tanggal'];
			$tranfusi = $_POST['tranfusi'];
			$monitoring = $_POST['monitoring'];
							
			$get_id = mysql_query('SELECT MONITORING_TRANSFUSI_ID 
							FROM mutu_monitoring_transfusi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_monitoring_transfusi(
							OPERASI_ID,RAWAT_ID,JNS_ORDER,
							DIAGNOSA,JNS_OPERASI,TRANSFUSI_DARAH,
							MONITORING,TANGGAL,PENGUMPUL_DATA)
							VALUES("' . $operasi . '","' . $idx . '",
							"' . $order . '","' . $diagnosa . '",
							"' . $jenis . '","' . $tranfusi . '",
							"' . $monitoring . '",
							STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
							"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_monitoring_transfusi
							SET DIAGNOSA = "' . $diagnosa . '",
							JNS_OPERASI = "' . $jenis . '",
							TRANSFUSI_DARAH = "' . $tranfusi . '",
							MONITORING = "' . $monitoring . '",
							PENGUMPUL_DATA = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'identifikasipasienbedah' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$tanggal = $_POST['tanggal'];
			$tindakan = $_POST['tndk'];
			$obat = $_POST['pmob'];
			$tranfusi = $_POST['trfs'];
							
			$get_id = mysql_query('SELECT KEPATUHAN_IDENTIFIKASI_ID 
							FROM mutu_kepatuhan_identifikasi_pasien_bedah 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_kepatuhan_identifikasi_pasien_bedah(
							OPERASI_ID,RAWAT_ID,JNS_ORDER,
							SEBELUM_TINDAKAN,SEBELUM_PEMBERIAN_OBAT,
							SEBELUM_TRANSFUSI,TGL_OBSERVASI,PENGUMPUL_DATA)
							VALUES("' . $operasi . '","' . $idx . '",
							"' . $order . '","' . $tindakan . '",
							"' . $obat . '","' . $tranfusi . '",
							STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
							"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_kepatuhan_identifikasi_pasien_bedah
							SET SEBELUM_TINDAKAN = "' . $tindakan . '",
							SEBELUM_PEMBERIAN_OBAT = "' . $obat . '",
							SEBELUM_TRANSFUSI = "' . $tranfusi . '",
							PENGUMPUL_DATA = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'tbakpasienbedah' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$tanggal = $_POST['tanggal'];
			$penelepon = $_POST['penelepon'];
			$penerima = $_POST['penerima'];
			$verifikasi = $_POST['verifikasi'];
			
			$app_id = substr($penelepon,0,1);
			$penelepon_id = substr($penelepon,1,5);
			$penelepon_id = $penelepon_id * 1;
			
			$app_id_penerima = substr($penerima,0,1);
			$penerima_id = substr($penerima,1,5);
			$penerima_id = $penerima_id * 1;
							
			$get_id = mysql_query('SELECT TBAK_ID 
							FROM mutu_tbak_pasien_bedah 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_tbak_pasien_bedah(
							OPERASI_ID,RAWAT_ID,JNS_ORDER,APP_ID,
							APP_ID_PENERIMA,PENELEPON_ID,PENERIMA_TELEPON_ID,
							VERIFIKASI_24JAM,TANGGAL,PENGUMPUL_DATA)
							VALUES("' . $operasi . '","' . $idx . '",
							"' . $order . '","' . $app_id . '",
							"' . $app_id_penerima . '","' . $penelepon_id . '",
							"' . $penerima_id . '","' . $verifikasi . '",
							STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
							"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_tbak_pasien_bedah
							SET APP_ID = "' . $app_id . '",
							APP_ID_PENERIMA = "' . $app_id_penerima . '",
							PENELEPON_ID = "' . $penelepon_id . '",
							PENERIMA_TELEPON_ID = "' . $penerima_id . '",
							VERIFIKASI_24JAM = "' . $verifikasi . '",
							PENGUMPUL_DATA = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'surgicalsafetychecklist' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$tanggal = $_POST['tanggal'];
			$surgical = $_POST['surgical'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT SAFETY_CHECKLIST_ID 
							FROM mutu_surgical_safety_checklist 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_surgical_safety_checklist(
								OPERASI_ID,RAWAT_ID,JNS_ORDER,SURGICAL_SAFETY_CHECKLIST,
								KETERANGAN,TANGGAL,PENGUMPUL_DATA) VALUES("' . $operasi . '",
								"' . $idx . '","' . $order . '","' . $surgical . '",
								"' . $keterangan . '",
								STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
								"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_surgical_safety_checklist
								SET SURGICAL_SAFETY_CHECKLIST = "' . $surgical . '",
								KETERANGAN = "' . $keterangan . '",
								PENGUMPUL_DATA = "' . currentUser() . '"
								WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'penandaanlukaoperasi' :
			
			$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
			mysql_select_db($database_5, $connect_5) or die(mysql_error());
			
			$operasi = $_POST['operasi'];
			$idx = $_POST['idx'];
			$order = $_POST['order'];
			$tanggal = $_POST['tanggal'];
			$penandaan = $_POST['penandaan'];
			$keterangan = $_POST['keterangan'];
							
			$get_id = mysql_query('SELECT PENUNDAAN_LUKA_OPERASI_ID 
							FROM mutu_penandaan_luka_operasi 
							WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
			if(mysql_num_rows($get_id) == 0){	
				mysql_query('INSERT INTO mutu_penandaan_luka_operasi(
								OPERASI_ID,RAWAT_ID,JNS_ORDER,PENANDAAN_LUKA_OPERASI,
								KETERANGAN,TANGGAL,PENGUMPUL_DATA) VALUES("' . $operasi . '",
								"' . $idx . '","' . $order . '","' . $penandaan . '",
								"' . $keterangan . '",
								STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"),
								"' . currentUser() . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE mutu_penandaan_luka_operasi
								SET PENANDAAN_LUKA_OPERASI = "' . $penandaan . '",
								KETERANGAN = "' . $keterangan . '",
								PENGUMPUL_DATA = "' . currentUser() . '"
								WHERE OPERASI_ID = "' . $operasi . '"') or die(mysql_error());
				}	
				
			echo 'Data telah disimpan.';
			
			break;
			
			case 'bayarirjaall' :
			
			$idx = $_GET['idx'];
			$kasir = $_GET['kasir'];
			$tgl1 = '';
			$tgl2 = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];

			$potongan = getCashPotongan($_GET['ch']);
			
			$sql_tarif  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
								SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
								t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
								FROM t_irja_tarif 
								INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
								INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
								LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
								t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
								t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
								ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
								t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
								t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
					
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$status = $dat_tarif['ST_BAYAR'];
				$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE IRJA_ID = "' . $idx . '" AND NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						$no_kw_bayar = getNomorHarian('Kasir');
						$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" AND JNS_ORDER = "IRJ"';
						$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
						while($dat_penunjang = mysql_fetch_array($get_penunjang)){
							$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
							mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
								SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
								KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
								WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"') or die(mysql_error());
						}
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_operasi_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE OPERASI_ID = "' . $dat_tarif_operasi['OPERASI_ID'] . '" AND NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');	
						mysql_query('UPDATE t_hemodialisa_tarif 
								INNER JOIN t_hemodialisa 
								ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
								SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
								SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
								KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
								AND t_hemodialisa.JNS_ORDER = "IRJ" 
								AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){
							$no_kw_bayar = getNomorHarian('Kasir');
							$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" AND (JNS_ORDER = "HRJ" OR JNS_ORDER = "ORJ")';
							$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
							while($dat_penunjang = mysql_fetch_array($get_penunjang)){
								$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
								mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
									SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
									KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
									WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
							}
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$status = $dat_ambulance['ST_BAYAR'];
				$no_bayar = $dat_ambulance['NO_PEMBAYARAN'];
				if($status != 'Batal'){ 
					if($no_bayar == ''){ 
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE RAWAT_ID = "' . $idx . '" AND JNS_ORDER = "IRJ"
							AND NO_TARIF = "' . $dat_ambulance['NO_TARIF'] . '"') or die(mysql_error());
					} 
				} 
			}

			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW(),
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '" 
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							NO_PEMBAYARAN = "' . $no_kw_bayar . '",
							TANGGAL_BAYAR = NOW(),
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '" 
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				}	
			//
		break;
		
		case 'bayarirnaall' :
		//
		$idx = $_GET['idx'];
		
		$tgl1 = '';
		$tgl2 = '';
		$ruang = '';
		if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
		if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
		if(isset($_GET['ruang'])) $ruang = $_GET['ruang'];
		
		$ruang_tindakan = '';
		if($ruang != ''){
			$arr_ruang = explode('|',$ruang);
			$ruang_tindakan = $arr_ruang[1];
		}

		$potongan = getCashPotongan($_GET['ch']);
		
		$sql_tarif  = 'SELECT DISTINCT t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				SUM(t_irna_tarif.KUANTITI *(CASE WHEN t_irna_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_irna_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_irna_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_irna_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_irna_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_irna_tarif.ST_BAYAR,
				t_irna_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.KELAS_JAMINAN
				FROM t_irna_tarif 
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF IS NOT NULL ';
				
		if($ruang_tindakan != '') $sql_tarif .= 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
		$sql_tarif .= 'GROUP BY t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				t_irna_tarif.ST_BAYAR,t_irna_tarif.USER_KASIR
				ORDER BY t_irna_tarif.TGL_TARIF';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

		$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	

		$sql_tarif_operasi  = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2") ';
				
		if($ruang_tindakan != '') $sql_tarif_operasi .= 'AND t_operasi.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
		$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

		$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_hemodialisa 
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_hemodialisa .= 'AND t_hemodialisa.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
		$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	

		$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang_hemodialisa .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());	

		$sql_ambulance_irna  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_ambulance_irna .= 'AND t_ambulance_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_ambulance_irna .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_ambulance_irna .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_ambulance_irna .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
					ORDER BY t_ambulance_tarif.TGL_TARIF';
		$get_ambulance_irna = mysql_query($sql_ambulance_irna) or die(mysql_error());	

		while($dat_tarif = mysql_fetch_array($get_tarif)){
			$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
			$status = $dat_tarif['ST_BAYAR'];
			if($status != 'Batal'){ 
				if($no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_irna_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE IRNA_ID = "' . $idx . '" AND NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		} 
	
		while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
			$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
			$status = $dat_tarif_penunjang['ST_BAYAR'];
			if($status != 'Batal'){ 
				if($no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" AND JNS_ORDER = "IRN"';
					$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
					while($dat_penunjang = mysql_fetch_array($get_penunjang)){
						$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
						mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
								SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
								KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"   
								WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"') or die(mysql_error());
					}
				} 
			}
		}
	
		while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
			$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
			$status = $dat_tarif_operasi['ST_BAYAR'];					
			if($status != 'Batal'){ 
				if($no_bayar == ''){ 
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_operasi_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE OPERASI_ID = "' . $dat_tarif_operasi['OPERASI_ID'] . '" AND NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
	
		while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
			$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
			$status = $dat_tarif_hemodialisa['ST_BAYAR'];
			if($status != 'Batal'){ 
				if($no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
						SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
						KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
						AND t_hemodialisa.JNS_ORDER = "IRN" 
						AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
	
		while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
			$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
			$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
			if($status != 'Batal'){ 
				if($no_bayar == ''){ 
					$no_kw_bayar = getNomorHarian('Kasir');
					$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" AND (JNS_ORDER = "HRI" OR JNS_ORDER = "ORI")';
					$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
					while($dat_penunjang = mysql_fetch_array($get_penunjang)){
						$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
						mysql_query('UPDATE t_ipenunjang_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TANGGAL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE PENUNJANG_ID = "' . $penunjang_id . '" AND NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
					}
				}
			}
		}
	
		//ambulace irna
		while($dat_ambulance_irna = mysql_fetch_array($get_ambulance_irna)){
			$no_bayar = $dat_ambulance_irna['NO_PEMBAYARAN'];
			$status = $dat_ambulance_irna['ST_BAYAR'];
			if($status != 'Batal'){ 
				if($no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = "' . $no_kw_bayar . '",TGL_BAYAR = NOW(),ST_BAYAR = "Lunas",
							SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_KASIR = "' . currentUser() . '",
							KODE_CASH = "' . $_GET['ch'] . '",PERC_POTONGAN = "' . $potongan . '",KODE_REKENING = "' . $_GET['rk'] . '"  
							WHERE RAWAT_ID = "' . $idx . '" AND JNS_ORDER = "IRN"
							AND NO_TARIF = "' . $dat_ambulance_irna['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
		//end ambulance irna
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());	

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
				
		$sql_resep  .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW(),
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_resep .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW(),
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"  
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}
		//
		
		break;
		
		case 'costsharing' :
		
		$idx = $_GET['idx'];
		$cs = $_GET['cs'];
		mysql_query('UPDATE t_irna SET COST_SHARING = "' . $cs . '" WHERE IRNA_ID = "' . $idx . '"') or die();
		
		break;
		
		case 'tracerrm' :
		
		if(isset($_POST['nomr'])){
			
			$ret = false;
			$nomr = $_POST['nomr'];
			$arr_nomr = explode('X',$nomr);
			if(sizeof($arr_nomr) >= 3){
				$x = 0;
				while($x < sizeof($arr_nomr)){
					if(strlen($arr_nomr[$x]) == 6 and is_numeric($arr_nomr[$x])){
						$qry = 'SELECT t_rm_tracer.RM_TRACER_ID 
								FROM t_rm_tracer
								INNER JOIN t_irja
								ON (t_rm_tracer.IRJA_ID = t_irja.IRJA_ID)
								WHERE t_irja.NOMR = "' . $arr_nomr[$x] . '"
								AND t_rm_tracer.RM_TERIMA IS NULL 
								AND t_rm_tracer.RM_KIRIM IS NOT NULL
								ORDER BY t_rm_tracer.RM_TRACER_ID DESC LIMIT 1';
						$get = mysql_query($qry) or die(mysql_error());
						if(mysql_num_rows($get) > 0){
							$dat = mysql_fetch_assoc($get);
							$id = $dat['RM_TRACER_ID'];
							mysql_query('UPDATE t_rm_tracer SET RM_TERIMA = NOW(),
										RM_USER_TERIMA = "' . currentUser() . '"
										WHERE RM_TRACER_ID = "' . $id . '"') or die(mysql_error());
							$ret = true;
						}else{
							$qry = 'SELECT IRJA_ID 
								FROM t_irja
								WHERE NOMR = "' . $arr_nomr[$x] . '"
								ORDER BY IRJA_ID DESC LIMIT 1';
							$get = mysql_query($qry) or die(mysql_error());
							if(mysql_num_rows($get) > 0){
								$dat = mysql_fetch_assoc($get);
								$id = $dat['IRJA_ID']; 
								mysql_query('INSERT INTO t_rm_tracer(IRJA_ID,RM_KIRIM,RM_USER_KIRIM)
									VALUES("' . $id . '",NOW(),"' . currentUser() . '")') or die(mysql_error());
								$ret = true;
							}
						}	
					}
				$x++;
				}
			}	
			if($ret == true) echo 'Ok';
		}		
		
		break;
		
		case 'cekuploadgaji' :
		
		$dokumen = $_POST['xdokumen'];
		$tahun = $_POST['xtahun'];
		$bulan = $_POST['xbulan'];
		
		if($dokumen == 'gaji'){
			$sql_gaji = 'SELECT COUNT(*) AS ADA FROM db_sdm.r_gaji WHERE TAHUN = "' . $tahun . '" AND BULAN = "' . $bulan . '"';
			$get_gaji = mysql_query($sql_gaji) or die(mysql_error());
			$dat_gaji = mysql_fetch_assoc($get_gaji);
			echo $dat_gaji['ADA'];
		}else if($dokumen == 'makan'){
			$sql_gaji = 'SELECT COUNT(*) AS ADA FROM db_sdm.r_uang_makan WHERE TAHUN = "' . $tahun . '" AND BULAN = "' . $bulan . '"';
			$get_gaji = mysql_query($sql_gaji) or die(mysql_error());
			$dat_gaji = mysql_fetch_assoc($get_gaji);
			echo $dat_gaji['ADA'];
		}else if($dokumen == 'remunerasi'){
			$sql_gaji = 'SELECT COUNT(*) AS ADA FROM db_sdm.r_remunerasi WHERE TAHUN = "' . $tahun . '" AND BULAN = "' . $bulan . '"';
			$get_gaji = mysql_query($sql_gaji) or die(mysql_error());
			$dat_gaji = mysql_fetch_assoc($get_gaji);
			echo $dat_gaji['ADA'];
		}	
				
		break;
		
		case 'detailtarifupdate' :
		
		$arr_tarif_id = explode('-',$_POST['tarif_id']);
		if(sizeof($arr_tarif_id) == 2){
			$sql_tarif = 'SELECT * FROM m_tarif WHERE TARIF_ID = "' . $arr_tarif_id[1] . '"';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
			$dat_tarif = mysql_fetch_assoc($get_tarif);
			?>
			<form name="form<?php echo $arr_tarif_id[1]; ?>" id="form<?php echo $arr_tarif_id[1]; ?>" method="post">
			<input type="hidden" name="tarif_id" value="<?php echo $arr_tarif_id[1]; ?>" />
			<input type="hidden" name="kode_tarif" value="<?php echo $dat_tarif['KODE_TARIF']; ?>" />
			<table border="1" class="tableData" id="tfhover" >
				<tr>
					<td width="23">&nbsp;</td>
					<td width="200">Tarif Group</td>
					<td><select name="kode_tarif_group" class="text_dt" style="width:358px;" >
					<?php $sql_group = 'SELECT * FROM m_tarif_group ORDER BY NAMA_TARIF_GROUP';
						$get_group = mysql_query($sql_group) or die(mysql_error());	
						while($dat_group = mysql_fetch_array($get_group)){ ?>
						<option value="<?php echo $dat_group['KODE_TARIF_GROUP']; ?>" <?php if($dat_tarif['KODE_TARIF_GROUP'] == $dat_group['KODE_TARIF_GROUP']) echo 'selected="selected"'; ?> ><?php echo $dat_group['NAMA_TARIF_GROUP']; ?></option>
					<?php } ?>
					</select></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana ICU</td>
					<td><input type="text" name="jasa_sarana_icu" value="<?php echo $dat_tarif['JASA_SARANA_ICU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Nama</td>
					<td><input type="text" name="nama_tarif" value="<?php echo $dat_tarif['NAMA_TARIF']; ?>" class="text_dt" style="width:350px;" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan ICU</td>
					<td><input type="text" name="jasa_pelayanan_icu" value="<?php echo $dat_tarif['JASA_PELAYANAN_ICU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Satuan</td>
					<td><input type="text" name="satuan" value="<?php echo $dat_tarif['SATUAN']; ?>" class="text_dt" style="width:350px;" /></td>
					<td>&nbsp;</td>
					<td>Tarif ICU</td>
					<td><input type="text" name="tarif_icu" value="<?php echo $dat_tarif['TARIF_ICU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana</td>
					<td><input type="text" name="jasa_sarana" value="<?php echo $dat_tarif['JASA_SARANA']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana NICU</td>
					<td><input name="jasa_sarana_nicu" type="text" class="text_dt" id="jasa_sarana_nicu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_SARANA_NICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Dokter</td>
					<td><input type="text" name="jasa_dokter" value="<?php echo $dat_tarif['JASA_DOKTER']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan NICU</td>
					<td><input name="jasa_pelayanan_nicu" type="text" class="text_dt" id="jasa_pelayanan_nicu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_PELAYANAN_NICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa RS</td>
					<td><input type="text" name="jasa_rs" value="<?php echo $dat_tarif['JASA_RS']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif NICU</td>
					<td><input name="tarif_nicu" type="text" class="text_dt" id="tarif_nicu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['TARIF_NICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan</td>
					<td><input type="text" name="jasa_pelayanan" value="<?php echo $dat_tarif['JASA_PELAYANAN']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana PICU</td>
					<td><input name="jasa_sarana_picu" type="text" class="text_dt" id="jasa_sarana_picu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_SARANA_PICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Non Kelas</td>
					<td><input type="text" name="tarif_non_kelas" value="<?php echo $dat_tarif['TARIF_NON_KELAS']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan PICU</td>
					<td><input name="jasa_pelayanan_picu" type="text" class="text_dt" id="jasa_pelayanan_picu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_PELAYANAN_PICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 3</td>
					<td><input type="text" name="jasa_sarana_kelas_3" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_3']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif PICU</td>
					<td><input name="tarif_picu" type="text" class="text_dt" id="tarif_picu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['TARIF_PICU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 3</td>
					<td><input type="text" name="jasa_pelayanan_kelas_3" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_3']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana ICCU </td>
					<td><input name="jasa_sarana_iccu" type="text" class="text_dt" id="jasa_sarana_iccu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_SARANA_ICCU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 3</td>
					<td><input type="text" name="tarif_kelas_3" value="<?php echo $dat_tarif['TARIF_KELAS_3']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan ICCU </td>
					<td><input name="jasa_pelayanan_iccu" type="text" class="text_dt" id="jasa_pelayanan_iccu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_PELAYANAN_ICCU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 2</td>
					<td><input type="text" name="jasa_sarana_kelas_2" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif ICCU </td>
					<td><input name="tarif_iccu" type="text" class="text_dt" id="tarif_iccu" style="width:350px;text-align:right" value="<?php echo $dat_tarif['TARIF_ICCU']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 2</td>
					<td><input type="text" name="jasa_pelayanan_kelas_2" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana Perina </td>
					<td><input name="jasa_sarana_perina" type="text" class="text_dt" id="jasa_sarana_perina" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_SARANA_PERINA']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 2</td>
					<td><input type="text" name="tarif_kelas_2" value="<?php echo $dat_tarif['TARIF_KELAS_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Perina </td>
					<td><input name="jasa_pelayanan_perina" type="text" class="text_dt" id="jasa_pelayanan_perina" style="width:350px;text-align:right" value="<?php echo $dat_tarif['JASA_PELAYANAN_PERINA']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas 1</td>
					<td><input type="text" name="jasa_sarana_kelas_1" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_1']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Tarif Perina </td>
					<td><input name="tarif_perina" type="text" class="text_dt" id="tarif_perina" style="width:350px;text-align:right" value="<?php echo $dat_tarif['TARIF_PERINA']; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas 1</td>
					<td><input type="text" name="jasa_pelayanan_kelas_1" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_1']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Sarana Kelas Perina Sehat</td>
					<td><input type="text" name="jasa_sarana_kelas_perina_sehat" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_PERINA_SEHAT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tarif Kelas 1</td>
					<td><input type="text" name="tarif_kelas_1" value="<?php echo $dat_tarif['TARIF_KELAS_1']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan Kelas Perina Sehat</td>
					<td><input type="text" name="jasa_pelayanan_kelas_perina_sehat" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_PERINA_SEHAT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Utama (VIP) </td>
				  <td><input type="text" name="jasa_sarana_kelas_utama" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_UTAMA']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Perina Sehat</td>
				  <td><input type="text" name="tarif_kelas_perina_sehat" value="<?php echo $dat_tarif['TARIF_KELAS_PERINA_SEHAT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Utama (VIP) </td>
				  <td><input type="text" name="jasa_pelayanan_kelas_utama" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_UTAMA']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Perina Sakit</td>
				  <td><input type="text" name="jasa_sarana_kelas_perina_sakit" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_PERINA_SAKIT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Utama (VIP) </td>
				  <td><input type="text" name="tarif_kelas_utama" value="<?php echo $dat_tarif['TARIF_KELAS_UTAMA']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Perina Sakit</td>
				  <td><input type="text" name="jasa_pelayanan_kelas_perina_sakit" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_PERINA_SAKIT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="jasa_sarana_kelas_utama_2" value="<?php echo $dat_tarif['JASA_SARANA_KELAS_UTAMA_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Perina Sakit</td>
				  <td><input type="text" name="tarif_kelas_perina_sakit" value="<?php echo $dat_tarif['TARIF_KELAS_PERINA_SAKIT']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Pelayanan Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="jasa_pelayanan_kelas_utama_2" value="<?php echo $dat_tarif['JASA_PELAYANAN_KELAS_UTAMA_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif Kelas Utama 2 (VVIP) </td>
				  <td><input type="text" name="tarif_kelas_utama_2" value="<?php echo $dat_tarif['TARIF_KELAS_UTAMA_2']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Jasa Sarana HCU</td>
				  <td><input type="text" name="jasa_sarana_hcu" value="<?php echo $dat_tarif['JASA_SARANA_HCU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jasa Pelayanan HCU</td>
					<td><input type="text" name="jasa_pelayanan_hcu" value="<?php echo $dat_tarif['JASA_PELAYANAN_HCU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>Tarif HCU</td>
				  <td><input type="text" name="tarif_hcu" value="<?php echo $dat_tarif['TARIF_HCU']; ?>" class="text_dt" style="width:350px;text-align:right" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="checkbox" name="st_aktif" value="1" <?php if($dat_tarif['ST_AKTIF'] == '1') echo 'checked="checked"'; ?>/>
                    Aktif&nbsp;&nbsp;
                    <input name="button" type="button" class="myButton" onclick="simpan_update(<?php echo $arr_tarif_id[1]; ?>);" value="simpan"/></td>
				</tr>
			</table>
			</form>
			<?php	
		}
		
		break;
		
		case 'simpantarifupdate' :
		
			$st_aktif = '';
			if(isset($_POST['st_aktif'])) $st_aktif = '1';
				mysql_query('UPDATE m_tarif
					  SET NAMA_TARIF = "' . $_POST['nama_tarif'] .  '",
					  SATUAN = "' . $_POST['satuan'] .  '",
					  KODE_TARIF_GROUP = "' . $_POST['kode_tarif_group'] .  '",
					  JASA_SARANA = "' . $_POST['jasa_sarana'] .  '",
					  JASA_DOKTER = "' . $_POST['jasa_dokter'] .  '",
					  JASA_RS = "' . $_POST['jasa_rs'] .  '",
					  JASA_PELAYANAN = "' . $_POST['jasa_pelayanan'] .  '",
					  TARIF_NON_KELAS = "' . $_POST['tarif_non_kelas'] .  '",
					  JASA_SARANA_KELAS_3 = "' . $_POST['jasa_sarana_kelas_3'] .  '",
					  JASA_PELAYANAN_KELAS_3 = "' . $_POST['jasa_pelayanan_kelas_3'] .  '",
					  TARIF_KELAS_3 = "' . $_POST['tarif_kelas_3'] .  '",
					  JASA_SARANA_KELAS_2 = "' . $_POST['jasa_sarana_kelas_2'] .  '",
					  JASA_PELAYANAN_KELAS_2 = "' . $_POST['jasa_pelayanan_kelas_2'] .  '",
					  TARIF_KELAS_2 = "' . $_POST['tarif_kelas_2'] .  '",
					  JASA_SARANA_KELAS_1 = "' . $_POST['jasa_sarana_kelas_1'] .  '",
					  JASA_PELAYANAN_KELAS_1 = "' . $_POST['jasa_pelayanan_kelas_1'] .  '",
					  TARIF_KELAS_1 = "' . $_POST['tarif_kelas_1'] .  '",
					  JASA_SARANA_KELAS_UTAMA = "' . $_POST['jasa_sarana_kelas_utama'] .  '",
					  JASA_PELAYANAN_KELAS_UTAMA = "' . $_POST['jasa_pelayanan_kelas_utama'] .  '",
					  TARIF_KELAS_UTAMA = "' . $_POST['tarif_kelas_utama'] .  '",
					  JASA_SARANA_KELAS_UTAMA_2 = "' . $_POST['jasa_sarana_kelas_utama_2'] .  '",
					  JASA_PELAYANAN_KELAS_UTAMA_2 = "' . $_POST['jasa_pelayanan_kelas_utama_2'] .  '",
					  TARIF_KELAS_UTAMA_2 = "' . $_POST['tarif_kelas_utama_2'] .  '",
					  JASA_SARANA_HCU = "' . $_POST['jasa_sarana_hcu'] .  '",
					  JASA_PELAYANAN_HCU = "' . $_POST['jasa_pelayanan_hcu'] .  '",
					  TARIF_HCU = "' . $_POST['tarif_hcu'] .  '",
					  JASA_SARANA_ICU = "' . $_POST['jasa_sarana_icu'] .  '",
					  JASA_PELAYANAN_ICU = "' . $_POST['jasa_pelayanan_icu'] .  '",
					  TARIF_ICU = "' . $_POST['tarif_icu'] .  '",
					  JASA_SARANA_NICU = "' . $_POST['jasa_sarana_nicu'] .  '",
					  JASA_PELAYANAN_NICU = "' . $_POST['jasa_pelayanan_nicu'] .  '",
					  TARIF_NICU = "' . $_POST['tarif_nicu'] .  '",
					  JASA_SARANA_PICU = "' . $_POST['jasa_sarana_picu'] .  '",
					  JASA_PELAYANAN_PICU = "' . $_POST['jasa_pelayanan_picu'] .  '",
					  TARIF_PICU = "' . $_POST['tarif_picu'] .  '",
					  JASA_SARANA_ICCU = "' . $_POST['jasa_sarana_iccu'] .  '",
					  JASA_PELAYANAN_ICCU = "' . $_POST['jasa_pelayanan_iccu'] .  '",
					  TARIF_ICCU = "' . $_POST['tarif_iccu'] .  '",
					  JASA_SARANA_PERINA = "' . $_POST['jasa_sarana_perina'] .  '",
					  JASA_PELAYANAN_PERINA = "' . $_POST['jasa_pelayanan_perina'] .  '",
					  TARIF_PERINA = "' . $_POST['tarif_perina'] .  '",
					  JASA_SARANA_KELAS_PERINA_SEHAT = "' . $_POST['jasa_sarana_kelas_perina_sehat'] .  '",
					  JASA_PELAYANAN_KELAS_PERINA_SEHAT = "' . $_POST['jasa_pelayanan_kelas_perina_sehat'] .  '",
					  TARIF_KELAS_PERINA_SEHAT = "' . $_POST['tarif_kelas_perina_sehat'] .  '",
					  JASA_SARANA_KELAS_PERINA_SAKIT = "' . $_POST['jasa_sarana_kelas_perina_sakit'] .  '",
					  JASA_PELAYANAN_KELAS_PERINA_SAKIT = "' . $_POST['jasa_pelayanan_kelas_perina_sakit'] .  '",
					  TARIF_KELAS_PERINA_SAKIT = "' . $_POST['tarif_kelas_perina_sakit'] .  '",
					  ST_AKTIF = "' . $st_aktif .  '",
					  USER_ADMIN = "' . currentUser() .  '"
					  WHERE TARIF_ID = "' . $_POST['tarif_id'] . '"') or die(mysql_error());
					  
			$sql_cek_group = 'SELECT LABORATORIUM,LABORATORIUM_CITO,RADIOLOGI,RADIOLOGI_CITO,NAMA_TARIF_GROUP
				FROM m_tarif_group WHERE KODE_TARIF_GROUP = "' . $_POST['kode_tarif_group'] . '"';
			$get_cek_group = mysql_query($sql_cek_group) or die(mysql_error());
			$dat_cek_group = mysql_fetch_assoc($get_cek_group);	
			if($dat_cek_group['LABORATORIUM'] == '1' or $dat_cek_group['LABORATORIUM_CITO'] == '1'
				or $dat_cek_group['RADIOLOGI'] == '1' or $dat_cek_group['RADIOLOGI_CITO'] == '1'){
					mysql_query('UPDATE m_tarif_pemeriksaan
						SET CH_REPORT = "' . $dat_cek_group['NAMA_TARIF_GROUP'] . '",
						NAMA_PEMERIKSAAN_ORDER = "' . $_POST['nama_tarif'] . '",
						NAMA_PEMERIKSAAN = "' . $_POST['nama_tarif'] . '"
						WHERE KODE_TARIF = "' . $_POST['kode_tarif'] . '"') or die(mysql_error());
			}
					  
		echo 'ok';
		
		break;
		
		case 'simpantariftambah' :
		
		$ada_labrad = false;
		$st_labrad = false;
		$sql_cek_group = 'SELECT LABORATORIUM,LABORATORIUM_CITO,RADIOLOGI,RADIOLOGI_CITO,NAMA_TARIF_GROUP
			FROM m_tarif_group WHERE KODE_TARIF_GROUP = "' . $_POST['kode_tarif_group'] . '"';
		$get_cek_group = mysql_query($sql_cek_group) or die(mysql_error());
		$dat_cek_group = mysql_fetch_assoc($get_cek_group);	
		if($dat_cek_group['LABORATORIUM'] == '1' or $dat_cek_group['LABORATORIUM_CITO'] == '1'
			or $dat_cek_group['RADIOLOGI'] == '1' or $dat_cek_group['RADIOLOGI_CITO'] == '1'){
			$st_labrad = true;	

			$sql_cek_pemeriksaan = 'SELECT KODE_TARIF FROM m_tarif_pemeriksaan
				WHERE KODE_TARIF = "' . $_POST['kode_tarif'] . '"';
			$get_cek_pemeriksaan = mysql_query($sql_cek_pemeriksaan) or die(mysql_error());
			if(mysql_num_rows($get_cek_pemeriksaan) > 0){
				$ada_labrad = true;
			}	
		}
		
		$sql_cek_kode = 'SELECT TARIF_ID FROM m_tarif 
					WHERE KODE_TARIF = "' . $_POST['kode_tarif'] . '"
					AND TAHUN_UPDATE = "' . $_POST['tahun'] . '"
					AND ST_AKTIF = "1"';
		$get_cek_kode = mysql_query($sql_cek_kode) or die(mysql_error());
		if($ada_labrad or mysql_num_rows($get_cek_kode) > 0){
			echo 'Kode Tarif Sudah Digunakan';
		}else{
			if($_POST['kode_tarif_group'] == '' or $_POST['nama_tarif'] == '' or $_POST['kode_tarif'] == ''){
				echo 'Kode Tarif, Nama, Group Harus Diisi';
			}else{
				$st_aktif = '';
				if(isset($_POST['st_aktif'])) $st_aktif = '1';
				
				mysql_query('INSERT INTO m_tarif(KODE_TARIF,NAMA_TARIF,SATUAN,KODE_TARIF_GROUP,JASA_SARANA,JASA_DOKTER,
						JASA_RS,JASA_PELAYANAN,TARIF_NON_KELAS,JASA_SARANA_KELAS_3,JASA_PELAYANAN_KELAS_3,TARIF_KELAS_3,
						JASA_SARANA_KELAS_2,JASA_PELAYANAN_KELAS_2,TARIF_KELAS_2,JASA_SARANA_KELAS_1,JASA_PELAYANAN_KELAS_1,
						TARIF_KELAS_1,JASA_SARANA_KELAS_UTAMA,JASA_PELAYANAN_KELAS_UTAMA,TARIF_KELAS_UTAMA,
						JASA_SARANA_KELAS_UTAMA_2,JASA_PELAYANAN_KELAS_UTAMA_2,TARIF_KELAS_UTAMA_2,
						JASA_SARANA_KELAS_PERINA_SEHAT,JASA_PELAYANAN_KELAS_PERINA_SEHAT,TARIF_KELAS_PERINA_SEHAT,
						JASA_SARANA_KELAS_PERINA_SAKIT,JASA_PELAYANAN_KELAS_PERINA_SAKIT,TARIF_KELAS_PERINA_SAKIT,
						JASA_SARANA_HCU,JASA_PELAYANAN_HCU,TARIF_HCU,JASA_SARANA_ICU,JASA_PELAYANAN_ICU,TARIF_ICU,
						TAHUN_UPDATE,ST_AKTIF,USER_ADMIN,JASA_SARANA_NICU,JASA_PELAYANAN_NICU,TARIF_NICU, 
						JASA_SARANA_PICU,JASA_PELAYANAN_PICU,TARIF_PICU,
						JASA_SARANA_ICCU,JASA_PELAYANAN_ICCU,TARIF_ICCU,
						JASA_SARANA_PERINA,JASA_PELAYANAN_PERINA,TARIF_PERINA)
						VALUES("' . $_POST['kode_tarif'] . '","' . $_POST['nama_tarif'] . '","' . $_POST['satuan'] . '",
						"' . $_POST['kode_tarif_group'] . '","' . $_POST['jasa_sarana'] . '","' . $_POST['jasa_dokter'] . '",
						"' . $_POST['jasa_rs'] . '","' . $_POST['jasa_pelayanan'] . '","' . $_POST['tarif_non_kelas'] . '",
						"' . $_POST['jasa_sarana_kelas_3'] . '","' . $_POST['jasa_pelayanan_kelas_3'] . '",
						"' . $_POST['tarif_kelas_3'] . '","' . $_POST['jasa_sarana_kelas_2'] . '","' . $_POST['jasa_pelayanan_kelas_2'] . '",
						"' . $_POST['tarif_kelas_2'] . '","' . $_POST['jasa_sarana_kelas_1'] . '","' . $_POST['jasa_pelayanan_kelas_1'] . '",
						"' . $_POST['tarif_kelas_1'] . '","' . $_POST['jasa_sarana_kelas_utama'] . '","' . $_POST['jasa_pelayanan_kelas_utama'] . '",
						"' . $_POST['tarif_kelas_utama'] . '","' . $_POST['jasa_sarana_kelas_utama_2'] . '",
						"' . $_POST['jasa_pelayanan_kelas_utama_2'] . '","' . $_POST['tarif_kelas_utama_2'] . '",
						"' . $_POST['jasa_sarana_kelas_perina_sehat'] . '","' . $_POST['jasa_pelayanan_kelas_perina_sehat'] . '",
						"' . $_POST['tarif_kelas_perina_sehat'] . '","' . $_POST['jasa_sarana_kelas_perina_sakit'] . '",
						"' . $_POST['jasa_pelayanan_kelas_perina_sakit'] . '","' . $_POST['tarif_kelas_perina_sakit'] . '",
						"' . $_POST['jasa_sarana_hcu'] . '","' . $_POST['jasa_pelayanan_hcu'] . '","' . $_POST['tarif_hcu'] . '",
						"' . $_POST['jasa_sarana_icu'] . '","' . $_POST['jasa_pelayanan_icu'] . '","' . $_POST['tarif_icu'] . '",
						"' . $_POST['tahun'] . '","' . $st_aktif . '", "' . currentUser() . '",
						"' . $_POST['jasa_sarana_nicu'] . '","' . $_POST['jasa_pelayanan_nicu'] . '","' . $_POST['tarif_nicu'] . '",
						"' . $_POST['jasa_sarana_picu'] . '","' . $_POST['jasa_pelayanan_picu'] . '","' . $_POST['tarif_picu'] . '",
						"' . $_POST['jasa_sarana_iccu'] . '","' . $_POST['jasa_pelayanan_iccu'] . '","' . $_POST['tarif_iccu'] . '",
						"' . $_POST['jasa_sarana_perina'] . '","' . $_POST['jasa_pelayanan_perina'] . '","' . $_POST['tarif_perina'] . '")') or die(mysql_error());

				if($st_labrad){
					if($ada_labrad == false){
						mysql_query('INSERT INTO m_tarif_pemeriksaan(CH_REPORT,KODE_TARIF,NAMA_PEMERIKSAAN_ORDER,
							NAMA_PEMERIKSAAN,REPORT_FORMAT,FORM_HASIL)
							VALUES("' . $dat_cek_group['NAMA_TARIF_GROUP'] . '","' . $_POST['kode_tarif'] . '",
							"' . $_POST['nama_tarif'] . '","' . $_POST['nama_tarif'] . '","1","1")') or die(mysql_error());
					}	
				}
			echo 'ok';
			}
		}
		
		break;
		
		case 'verifirja' :
			$cruser = currentUser();
			
			mysql_query('UPDATE t_irja_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE IRJA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());		
			
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_irja_tarif 
						WHERE IRJA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_irja_tarif 
					SET NO_PEMBAYARAN = "' . $no_bayar . '",
					TGL_BAYAR = NOW(),
					ST_BAYAR = "Lunas",
					USER_KASIR = "' . $cruser . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '" 
					AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
			
			break;
			
		case 'verifmcu' :
			$cruser = currentUser();
		
			mysql_query('UPDATE t_irja_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE IRJA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());		
			
			$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
					AND JNS_ORDER = "IRJ"';
			$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
			while($dat_penunjang = mysql_fetch_array($get_penunjang)){
				$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}
			
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_irja_tarif 
						WHERE IRJA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_irja_tarif 
					SET NO_PEMBAYARAN = "' . $no_bayar . '",
					TGL_BAYAR = NOW(),
					ST_BAYAR = "Lunas",
					USER_KASIR = "' . $cruser . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '" 
					AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					
				$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
					AND JNS_ORDER = "IRJ"';
				$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
				while($dat_penunjang = mysql_fetch_array($get_penunjang)){
					$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif 
						SET NO_PEMBAYARAN = "' . $no_bayar . '",
						TANGGAL_BAYAR = NOW(),
						ST_BAYAR = "Lunas",
						USER_KASIR = "' . $cruser . '" 
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
				}	
			}	
			
			break;	

		case 'verifpenunjang' :
			$cruser = currentUser();
			
			if(strtoupper($_GET['ord']) == 'APS'){
				$penunjang_id = $_GET['idx'];
				mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
						
				$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_ipenunjang_tarif
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';	
				$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
				$dat_bayar = mysql_fetch_assoc($get_bayar);
				if($dat_bayar['NO_PEMBAYARAN'] == ''){
					$no_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_ipenunjang_tarif 
						SET NO_PEMBAYARAN = "' . $no_bayar . '",
						TANGGAL_BAYAR = NOW(),
						ST_BAYAR = "Lunas",
						USER_KASIR = "' . $cruser . '" 
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
				}	
			}else{
				$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
						AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"';
				$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
				while($dat_penunjang = mysql_fetch_array($get_penunjang)){
					$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
						
						$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_ipenunjang_tarif
						WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';	
						$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
						$dat_bayar = mysql_fetch_assoc($get_bayar);
						if($dat_bayar['NO_PEMBAYARAN'] == ''){
							$no_bayar = getNomorHarian('Kasir');
							mysql_query('UPDATE t_ipenunjang_tarif 
								SET NO_PEMBAYARAN = "' . $no_bayar . '",
								TANGGAL_BAYAR = NOW(),
								ST_BAYAR = "Lunas",
								USER_KASIR = "' . $cruser . '" 
								WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
								AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
						}	
				}
			}
		break;
		
		case 'verifoperasi' :
            $cruser = currentUser();
			
			mysql_query('UPDATE t_operasi_tarif SET ST_VERIF = "' . $cruser . '"
						WHERE OPERASI_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_operasi_tarif 
						WHERE OPERASI_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_operasi_tarif 
						SET NO_PEMBAYARAN = "' . $no_bayar . '",
						TGL_BAYAR = NOW(),
						ST_BAYAR = "Lunas",
						USER_KASIR = "' . $cruser . '" 
						WHERE OPERASI_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
			
		break;
		
		case 'verifhemodialisa' :
			$cruser = currentUser();
			
			mysql_query('UPDATE t_hemodialisa_tarif 
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					SET t_hemodialisa_tarif.ST_VERIF = "' . $cruser . '"
					WHERE t_hemodialisa.RAWAT_ID = "' . $_GET['idx'] . '" 
					AND t_hemodialisa.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" 
					AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						WHERE t_hemodialisa.RAWAT_ID = "' . $_GET['idx'] . '" 
						AND t_hemodialisa.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" 
						AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_hemodialisa_tarif 
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					SET NO_PEMBAYARAN = "' . $no_bayar . '",
					TGL_BAYAR = NOW(),
					ST_BAYAR = "Lunas",
					USER_KASIR = "' . $cruser . '" 
					WHERE t_hemodialisa.RAWAT_ID = "' . $_GET['idx'] . '" 
					AND t_hemodialisa.JNS_ORDER = "' . strtoupper($_GET['ord']) . '" 
					AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}			
		
		break;
		
		case 'verifambulance' :
			$cruser = currentUser();
			
			mysql_query('UPDATE t_ambulance_tarif SET ST_VERIF = "' . $cruser . '"
					WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
					AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
					AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
					
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_ambulance_tarif 
						WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
						AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
						AND NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_ambulance_tarif 
							SET NO_PEMBAYARAN = "' . $no_bayar . '",
							TGL_BAYAR = NOW(),
							ST_BAYAR = "Lunas",
							USER_KASIR = "' . $cruser . '" 
							WHERE RAWAT_ID = "' . $_GET['idx'] . '" 
							AND JNS_ORDER = "' . strtoupper($_GET['ord']) . '"
							AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
			
		break;	
		
		case 'veriffarmasi' :
			$cruser = currentUser();
			
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
			mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET ST_VERIF = "' . $cruser . '"
					WHERE NO_PENGELUARAN = "' . $_GET['no'] . '"
					AND FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
					
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
					FROM t_farmasi_apotik_pengeluaran
					WHERE NO_PENGELUARAN = "' . $_GET['no'] . '"
					AND FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran 
					SET USER_PEMBAYARAN = "' . $cruser . '",
					NO_PEMBAYARAN = "' . $no_bayar . '",
					TANGGAL_BAYAR = NOW()
					WHERE FARMASI_PENGELUARAN_APOTIK_ID = "' . $_GET['idx'] . '" 
					AND NO_PENGELUARAN = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
					
			break;
			
		case 'verifirjaall' :
			
			$idx = $_GET['idx'];
			$tgl1 = '';
			$tgl2 = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
			
			$sql_tarif  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
								SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
								t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irja_tarif.ST_VERIF
								FROM t_irja_tarif 
								INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
								INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
								LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
								t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
								t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
								ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.ST_VERIF
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,t_operasi_tarif.ST_VERIF
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_hemodialisa_tarif.ST_VERIF
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
								t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
								t_ipenunjang_tarif.ST_VERIF
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ambulance_tarif.ST_VERIF
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
								t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
					
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$status = $dat_tarif['ST_BAYAR'];
				$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
				$verif = $dat_tarif['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){
						mysql_query('UPDATE t_irja_tarif SET ST_VERIF = "' . currentUser() . '" 
							WHERE IRJA_ID = "' . $idx . '" 
							AND NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
				$verif = $dat_tarif_penunjang['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){ 
						$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" 
										AND JNS_ORDER = "IRJ"';
						$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
						while($dat_penunjang = mysql_fetch_array($get_penunjang)){
							$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
							mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . currentUser() . '"
								WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
								AND NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"') or die(mysql_error());
						}
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
				$verif = $dat_tarif_operasi['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){ 
						mysql_query('UPDATE t_operasi_tarif SET ST_VERIF = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $dat_tarif_operasi['OPERASI_ID'] . '" 
							AND NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
				$verif = $dat_tarif_hemodialisa['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){	
						mysql_query('UPDATE t_hemodialisa_tarif 
								INNER JOIN t_hemodialisa 
								ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
								SET t_hemodialisa_tarif.ST_VERIF = "' . currentUser() . '"
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
								AND t_hemodialisa.JNS_ORDER = "IRJ" 
								AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
				$verif = $dat_tarif_penunjang_hemodialisa['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){
							$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" 
									AND (JNS_ORDER = "HRJ" OR JNS_ORDER = "ORJ")';
							$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
							while($dat_penunjang = mysql_fetch_array($get_penunjang)){
								$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
								mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . currentUser() . '"
									WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
									AND NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
							}
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$status = $dat_ambulance['ST_BAYAR'];
				$no_bayar = $dat_ambulance['NO_PEMBAYARAN'];
				$verif = $dat_ambulance['ST_VERIF'];
				if($status != 'Batal'){ 
					if($no_bayar != '' and $verif == ''){ 
						mysql_query('UPDATE t_ambulance_tarif SET ST_VERIF = "' . currentUser() . '"
							WHERE RAWAT_ID = "' . $idx . '" 
							AND JNS_ORDER = "IRJ"
							AND NO_TARIF = "' . $dat_ambulance['NO_TARIF'] . '"') or die(mysql_error());
					} 
				} 
			}

			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				$verif = $dat_resep['ST_VERIF'];
				if($status != '1' and $no_bayar != '' and $verif == ''){
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET ST_VERIF = "' . currentUser() . '"
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
				t_farmasi_apotik_pengeluaran.ST_VERIF
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					$verif = $dat_resep['ST_VERIF'];
					if($status != '1' and $no_bayar != '' and $verif == ''){
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET ST_VERIF = "' . currentUser() . '"
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				}	
			//
		break;	
		
		case 'verifirna' :
			$cruser = currentUser();
			mysql_query('UPDATE t_irna_tarif SET ST_VERIF = "' . $cruser . '" 
						WHERE IRNA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
						
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
						FROM t_irna_tarif 
						WHERE IRNA_ID = "' . $_GET['idx'] . '" 
						AND NO_TARIF = "' . $_GET['no'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_irna_tarif 
					SET NO_PEMBAYARAN = "' . $no_bayar . '",
					TGL_BAYAR = NOW(),
					ST_BAYAR = "Lunas",
					USER_KASIR = "' . $cruser . '" 
					WHERE IRNA_ID = "' . $_GET['idx'] . '" 
					AND NO_TARIF = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
			
		break;
		
		case 'verifirnaall' :
		//
		$idx = $_GET['idx'];
		
		$tgl1 = '';
		$tgl2 = '';
		$ruang = '';
		if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
		if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
		if(isset($_GET['ruang'])) $ruang = $_GET['ruang'];
		
		$ruang_tindakan = '';
		if($ruang != ''){
			$arr_ruang = explode('|',$ruang);
			$ruang_tindakan = $arr_ruang[1];
		}
		
		$sql_tarif  = 'SELECT DISTINCT t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				SUM(t_irna_tarif.KUANTITI *(CASE WHEN t_irna_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_irna_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_irna_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_irna_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_irna_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_irna_tarif.ST_BAYAR,
				t_irna_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.KELAS_JAMINAN,t_irna_tarif.ST_VERIF
				FROM t_irna_tarif 
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF IS NOT NULL ';
				
		if($ruang_tindakan != '') $sql_tarif .= 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
		$sql_tarif .= 'GROUP BY t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				t_irna_tarif.ST_BAYAR,t_irna_tarif.USER_KASIR
				ORDER BY t_irna_tarif.TGL_TARIF';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

		$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.ST_VERIF
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	

		$sql_tarif_operasi  = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,t_operasi_tarif.ST_VERIF
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2") ';
				
		if($ruang_tindakan != '') $sql_tarif_operasi .= 'AND t_operasi.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
		$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

		$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_hemodialisa_tarif.ST_VERIF
				FROM t_hemodialisa 
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_hemodialisa .= 'AND t_hemodialisa.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
		$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	

		$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,t_ipenunjang_tarif.ST_VERIF
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang_hemodialisa .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());	

		$sql_ambulance_irna  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ambulance_tarif.ST_VERIF
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_ambulance_irna .= 'AND t_ambulance_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_ambulance_irna .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_ambulance_irna .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_ambulance_irna .= 'GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
					t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
					ORDER BY t_ambulance_tarif.TGL_TARIF';
		$get_ambulance_irna = mysql_query($sql_ambulance_irna) or die(mysql_error());	

		while($dat_tarif = mysql_fetch_array($get_tarif)){
			$status = $dat_tarif['ST_BAYAR'];
			$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
			$verif = $dat_tarif['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){
					mysql_query('UPDATE t_irna_tarif SET ST_VERIF = "' . currentUser() . '" 
							WHERE IRNA_ID = "' . $idx . '" 
							AND NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"') or die(mysql_error());		
				} 
			} 
		} 
	
		while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
			$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
			$status = $dat_tarif_penunjang['ST_BAYAR'];
			$verif = $dat_tarif_penunjang['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){
					$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" 
							AND JNS_ORDER = "IRN"';
					$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
					while($dat_penunjang = mysql_fetch_array($get_penunjang)){
						$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
						mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . currentUser() . '"
								WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
								AND NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"') or die(mysql_error());
					}
				} 
			}
		}
	
		while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
			$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
			$status = $dat_tarif_operasi['ST_BAYAR'];					
			$verif = $dat_tarif_operasi['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){ 
					mysql_query('UPDATE t_operasi_tarif SET ST_VERIF = "' . currentUser() . '"
							WHERE OPERASI_ID = "' . $dat_tarif_operasi['OPERASI_ID'] . '" 
							AND NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
	
		while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
			$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
			$status = $dat_tarif_hemodialisa['ST_BAYAR'];
			$verif = $dat_tarif_hemodialisa['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){
					mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET ST_VERIF = "' . currentUser() . '" 
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
						AND t_hemodialisa.JNS_ORDER = "IRN" 
						AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
	
		while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
			$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
			$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
			$verif = $dat_tarif_penunjang_hemodialisa['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){ 
					$sql_penunjang = 'SELECT PENUNJANG_ID FROM t_ipenunjang WHERE RAWAT_ID = "' . $idx . '" 
								AND (JNS_ORDER = "HRI" OR JNS_ORDER = "ORI")';
					$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
					while($dat_penunjang = mysql_fetch_array($get_penunjang)){
						$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
						mysql_query('UPDATE t_ipenunjang_tarif SET ST_VERIF = "' . currentUser() . '"
							WHERE PENUNJANG_ID = "' . $penunjang_id . '" 
							AND NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
					}
				}
			}
		}
	
		//ambulace irna
		while($dat_ambulance_irna = mysql_fetch_array($get_ambulance_irna)){
			$no_bayar = $dat_ambulance_irna['NO_PEMBAYARAN'];
			$status = $dat_ambulance_irna['ST_BAYAR'];
			$verif = $dat_ambulance_irna['ST_VERIF'];
			if($status != 'Batal'){ 
				if($no_bayar != '' and $verif == ''){
					mysql_query('UPDATE t_ambulance_tarif SET ST_VERIF = "' . currentUser() . '"
							WHERE RAWAT_ID = "' . $idx . '" 
							AND JNS_ORDER = "IRN"
							AND NO_TARIF = "' . $dat_ambulance_irna['NO_TARIF'] . '"') or die(mysql_error());
				}
			}
		}
		//end ambulance irna
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());	

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
				
		$sql_resep  .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			$verif = $dat_resep['ST_VERIF'];
			if($status != '1' and $no_bayar != '' and $verif == ''){
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET ST_VERIF = "' . currentUser() . '"
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN,
					t_farmasi_apotik_pengeluaran.ST_VERIF
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_resep .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			$verif = $dat_resep['ST_VERIF'];
			if($status != '1' and $no_bayar != '' and $verif == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET ST_VERIF = "' . currentUser() . '"
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}
		//
		
		break;
		
		case 'cekstatusekspertise' :
			$sql_diagnosa = 'SELECT *
					FROM t_ipenunjang_tarif_pemeriksaan
					WHERE PENUNJANG_TARIF_ID = "' . $_POST['idx'] . '"
					AND ST_DIAGNOSA IS NULL';
			$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());		
			echo mysql_num_rows($get_diagnosa);
			
		break;
		
		case 'templateekspertise' :
			
			mysql_query('UPDATE t_ipenunjang_tarif SET JENIS_FOTO = "' . $_POST['template'] . '"
				WHERE PENUNJANG_TARIF_ID = "' . $_POST['idx'] . '"') or die(mysql_error());		
			
			echo 'ok';			
		break;
		
		case 'veriflainlain' :
			$cruser = currentUser();
			
			$connect_6 = mysql_connect($hostname_6, $username_6, $password_6) or die(mysql_error());
			mysql_select_db($database_6, $connect_6) or die(mysql_error());
			
			mysql_query('UPDATE r_penerimaan_lainlain_tarif SET ST_VERIF = "' . $cruser . '"
					WHERE PENERIMAAN_LAINLAIN_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
					
			break;
			
		case 'bayartidakdiklaimirja' :
			
			$idx = $_GET['idx'];
			$tgl1 = '';
			$tgl2 = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];

			$potongan = getCashPotongan($_GET['ch']);
			
			$sql_tarif  = 'SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,
						DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
						t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
						SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
						t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
						m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR
						FROM t_irja_tarif 
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
						LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.IRJA_TARIF_ID
					ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,
							DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,
								DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,
								DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
			$user_bayar = currentUser();
								
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$id_tarif = $dat_tarif['IRJA_TARIF_ID'];
				$status = $dat_tarif['ST_BAYAR'];
				$tdk_klaim = $dat_tarif['TDK_KLAIM'];
				$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_irja_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE IRJA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());	
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
				$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_hemodialisa_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$id_tarif = $dat_ambulance['AMBULANCE_TARIF_ID'];
				$status = $dat_ambulance['ST_BAYAR'];
				$tdk_klaim = $dat_ambulance['TDK_KLAIM'];
				$bayar = $dat_ambulance['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			/*
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							NO_PEMBAYARAN = "' . $no_kw_bayar . '",
							TANGGAL_BAYAR = NOW()
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				} */	
			//
		break;	
		
		case 'bayartidakdiklaimirna' :
			
			$idx = $_GET['idx'];
			$tgl1 = '';
			$tgl2 = '';
			$ruang = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
			if(isset($_GET['ruang'])) $ruang = $_GET['ruang'];
			
			$ruang_tindakan = '';
			if($ruang != ''){
				$arr_ruang = explode('|',$ruang);
				$ruang_tindakan = $arr_ruang[1];
			}

			$potongan = getCashPotongan($_GET['ch']);
			
			$sql_tarif  = 'SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,
						DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
						t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
						SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
						t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
						m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR
						FROM t_irja_tarif 
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
						LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.IRJA_TARIF_ID
					ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,
							DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,
								DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,
								DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
			$user_bayar = currentUser();
								
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$id_tarif = $dat_tarif['IRJA_TARIF_ID'];
				$status = $dat_tarif['ST_BAYAR'];
				$tdk_klaim = $dat_tarif['TDK_KLAIM'];
				$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_irja_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE IRJA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());	
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
				$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_hemodialisa_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$id_tarif = $dat_ambulance['AMBULANCE_TARIF_ID'];
				$status = $dat_ambulance['ST_BAYAR'];
				$tdk_klaim = $dat_ambulance['TDK_KLAIM'];
				$bayar = $dat_ambulance['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar == ''){
						mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_BAYAR = NOW(),
							TDK_KLAIM_USER = "' . $user_bayar . '",
							TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							KODE_CASH = "' . $_GET['ch'] . '",
							PERC_POTONGAN = "' . $potongan . '",
							KODE_REKENING = "' . $_GET['rk'] . '"
							WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			/*
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							NO_PEMBAYARAN = "' . $no_kw_bayar . '",
							TANGGAL_BAYAR = NOW()
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				} */	
			//
			
		$sql_tarif  = 'SELECT t_irna_tarif.IRNA_TARIF_ID,t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				SUM(t_irna_tarif.KUANTITI *(CASE WHEN t_irna_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_irna_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_irna_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_irna_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_irna_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_irna_tarif.ST_BAYAR,
				t_irna_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.KELAS_JAMINAN,m_tarif.TDK_KLAIM,t_irna_tarif.TDK_KLAIM_BAYAR
				FROM t_irna_tarif 
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF IS NOT NULL ';
				
		if($ruang_tindakan != '') $sql_tarif .= 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
		$sql_tarif .= 'GROUP BY t_irna_tarif.IRNA_TARIF_ID
				ORDER BY t_irna_tarif.TGL_TARIF';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

		$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	

		$sql_tarif_operasi  = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2") ';
				
		if($ruang_tindakan != '') $sql_tarif_operasi .= 'AND t_operasi.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
				ORDER BY t_operasi_tarif.TGL_TARIF';
		$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

		$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
				FROM t_hemodialisa 
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_hemodialisa .= 'AND t_hemodialisa.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
		$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	

		$sql_tarif_penunjang_hemodialisa = 'SELECT  t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
				m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang_hemodialisa .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());	

		$sql_ambulance_irna  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_ambulance_irna .= 'AND t_ambulance_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_ambulance_irna .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_ambulance_irna .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_ambulance_irna .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
					ORDER BY t_ambulance_tarif.TGL_TARIF';
		$get_ambulance_irna = mysql_query($sql_ambulance_irna) or die(mysql_error());	

		while($dat_tarif = mysql_fetch_array($get_tarif)){
			$id_tarif = $dat_tarif['IRNA_TARIF_ID'];
			$status = $dat_tarif['ST_BAYAR'];
			$tdk_klaim = $dat_tarif['TDK_KLAIM'];
			$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_irna_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE IRNA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		} 
	
		while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
			$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
			$status = $dat_tarif_penunjang['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
			$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
			$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
			$status = $dat_tarif_operasi['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
			$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
			$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
			$status = $dat_tarif_hemodialisa['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
			$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_hemodailisa_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
			$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
			$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
			$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		//ambulace irna
		while($dat_ambulance_irna = mysql_fetch_array($get_ambulance_irna)){
			$id_tarif = $dat_ambulance_irna['AMBULANCE_TARIF_ID'];
			$status = $dat_ambulance_irna['ST_BAYAR'];
			$tdk_klaim = $dat_ambulance_irna['TDK_KLAIM'];
			$bayar = $dat_ambulance_irna['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar == ''){
					mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_BAYAR = NOW(),
						TDK_KLAIM_USER = "' . $user_bayar . '",
						TDK_KLAIM_SHIFT = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						KODE_CASH = "' . $_GET['ch'] . '",
						PERC_POTONGAN = "' . $potongan . '",
						KODE_REKENING = "' . $_GET['rk'] . '"
						WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
		//end ambulance irna
		
		/*
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());	

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
				
		$sql_resep  .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_resep .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		} */
		//
		
		break;
		
		case 'veriftidakdiklaimirja' :
			
			$idx = $_GET['idx'];
			$tgl1 = '';
			$tgl2 = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
			
			$sql_tarif  = 'SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,
						DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
						t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
						SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
						t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
						m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR
						FROM t_irja_tarif 
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
						LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.IRJA_TARIF_ID
					ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,
							DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,
								DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,
								DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
			$user_bayar = currentUser();
								
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$id_tarif = $dat_tarif['IRJA_TARIF_ID'];
				$status = $dat_tarif['ST_BAYAR'];
				$tdk_klaim = $dat_tarif['TDK_KLAIM'];
				$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_irja_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE IRJA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());	
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
				$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_hemodialisa_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$id_tarif = $dat_ambulance['AMBULANCE_TARIF_ID'];
				$status = $dat_ambulance['ST_BAYAR'];
				$tdk_klaim = $dat_ambulance['TDK_KLAIM'];
				$bayar = $dat_ambulance['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			/*
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							NO_PEMBAYARAN = "' . $no_kw_bayar . '",
							TANGGAL_BAYAR = NOW()
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				} */	
			//
		break;	
		
		case 'veriftidakdiklaimirna' :
			
			$idx = $_GET['idx'];
			$tgl1 = '';
			$tgl2 = '';
			$ruang = '';
			if(isset($_GET['tgl1'])) $tgl1 = $_GET['tgl1'];
			if(isset($_GET['tgl2'])) $tgl2 = $_GET['tgl2'];
			if(isset($_GET['ruang'])) $ruang = $_GET['ruang'];
			
			$ruang_tindakan = '';
			if($ruang != ''){
				$arr_ruang = explode('|',$ruang);
				$ruang_tindakan = $arr_ruang[1];
			}
			
			$sql_tarif  = 'SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,
						DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
						t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
						SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
						t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
						m_tarif.TDK_KLAIM,t_irja_tarif.TDK_KLAIM_BAYAR
						FROM t_irja_tarif 
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
						LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
			$sql_tarif .= 'GROUP BY t_irja_tarif.IRJA_TARIF_ID
					ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND t_ipenunjang.JNS_ORDER = "IRJ"	
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,
							DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
							t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
							SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
								WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
								WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
							END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
							t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
							t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID,
							m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
							FROM t_operasi_tarif 
							INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
							AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") ';
							
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
							ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,
								DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
								SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
								t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
								FROM t_hemodialisa 
								INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
								INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
								AND t_hemodialisa.JNS_ORDER = "IRJ"	
								AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
								AND t_hemodialisa.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
						
			$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
								ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,
								DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
								t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
								SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
								t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
								m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
								FROM t_ipenunjang 
								INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
								INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
								INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
								AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
								AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
								AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';					
								
			$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,
								DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
								t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
								SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
								t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,
								m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
								FROM t_ambulance_tarif 
								INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
								LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
								WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
								AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
								
			if($tgl1 != '' and $tgl2 == '') $sql_ambulance .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_ambulance .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';		
						
			$sql_ambulance .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
								ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
			$user_bayar = currentUser();
								
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$id_tarif = $dat_tarif['IRJA_TARIF_ID'];
				$status = $dat_tarif['ST_BAYAR'];
				$tdk_klaim = $dat_tarif['TDK_KLAIM'];
				$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_irja_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE IRJA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());		
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());	
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
				$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_hemodialisa_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
				$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$id_tarif = $dat_ambulance['AMBULANCE_TARIF_ID'];
				$status = $dat_ambulance['ST_BAYAR'];
				$tdk_klaim = $dat_ambulance['TDK_KLAIM'];
				$bayar = $dat_ambulance['TDK_KLAIM_BAYAR'];
				if($status != 'Batal'){ 
					if($tdk_klaim == '1' and $bayar != ''){
						mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
							WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
					} 
				} 
			}

			/*
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep  .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar == ''){
					$no_kw_bayar = getNomorHarian('Kasir');
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
				
			if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
			if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
							AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';	
						
			$sql_resep .= 'GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar == ''){
						$no_kw_bayar = getNomorHarian('Kasir');
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							NO_PEMBAYARAN = "' . $no_kw_bayar . '",
							TANGGAL_BAYAR = NOW()
							WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}
				} */	
			//
			
		$sql_tarif  = 'SELECT t_irna_tarif.IRNA_TARIF_ID,t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irna_tarif.DESKRIPSI,t_irna_tarif.IRNA_ID,t_irna_tarif.NO_PEMBAYARAN,
				SUM(t_irna_tarif.KUANTITI *(CASE WHEN t_irna_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_irna_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_irna_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_irna_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_irna_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_irna_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_irna_tarif.ST_BAYAR,
				t_irna_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.KELAS_JAMINAN,m_tarif.TDK_KLAIM,t_irna_tarif.TDK_KLAIM_BAYAR
				FROM t_irna_tarif 
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF IS NOT NULL ';
				
		if($ruang_tindakan != '') $sql_tarif .= 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif .= 'AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif .= 'AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
	
		$sql_tarif .= 'GROUP BY t_irna_tarif.IRNA_TARIF_ID
				ORDER BY t_irna_tarif.TGL_TARIF';
		$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

		$sql_tarif_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());	

		$sql_tarif_operasi  = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,m_tarif.TDK_KLAIM,t_operasi_tarif.TDK_KLAIM_BAYAR
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2") ';
				
		if($ruang_tindakan != '') $sql_tarif_operasi .= 'AND t_operasi.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_operasi .= 'AND DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_operasi .= 'AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_operasi .= 'GROUP BY t_operasi_tarif.OPERASI_TARIF_ID
				ORDER BY t_operasi_tarif.TGL_TARIF';
		$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());

		$sql_tarif_hemodialisa = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_hemodialisa_tarif.TDK_KLAIM_BAYAR
				FROM t_hemodialisa 
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_hemodialisa .= 'AND t_hemodialisa.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_hemodialisa .= 'AND DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_hemodialisa .= 'GROUP BY t_hemodialisa_tarif.HEMODIALISA_TARIF_ID
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
		$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	

		$sql_tarif_penunjang_hemodialisa = 'SELECT  t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER,
				m_tarif.TDK_KLAIM,t_ipenunjang_tarif.TDK_KLAIM_BAYAR
				FROM t_ipenunjang 
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL ';
				
		if($ruang_tindakan != '') $sql_tarif_penunjang_hemodialisa .= 'AND t_ipenunjang.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_tarif_penunjang_hemodialisa .= 'AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_tarif_penunjang_hemodialisa .= 'AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_tarif_penunjang_hemodialisa .= 'GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
		$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());	

		$sql_ambulance_irna  = 'SELECT t_ambulance_tarif.AMBULANCE_TARIF_ID,t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
					t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
					t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,m_tarif.TDK_KLAIM,t_ambulance_tarif.TDK_KLAIM_BAYAR
					FROM t_ambulance_tarif 
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_ambulance_irna .= 'AND t_ambulance_tarif.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_ambulance_irna .= 'AND DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_ambulance_irna .= 'AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
				AND STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_ambulance_irna .= 'GROUP BY t_ambulance_tarif.AMBULANCE_TARIF_ID
					ORDER BY t_ambulance_tarif.TGL_TARIF';
		$get_ambulance_irna = mysql_query($sql_ambulance_irna) or die(mysql_error());	

		while($dat_tarif = mysql_fetch_array($get_tarif)){
			$id_tarif = $dat_tarif['IRNA_TARIF_ID'];
			$status = $dat_tarif['ST_BAYAR'];
			$tdk_klaim = $dat_tarif['TDK_KLAIM'];
			$bayar = $dat_tarif['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_irna_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE IRNA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		} 
	
		while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
			$id_tarif = $dat_tarif_penunjang['PENUNJANG_TARIF_ID'];
			$status = $dat_tarif_penunjang['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_penunjang['TDK_KLAIM'];
			$bayar = $dat_tarif_penunjang['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
			$id_tarif = $dat_tarif_operasi['OPERASI_TARIF_ID'];
			$status = $dat_tarif_operasi['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_operasi['TDK_KLAIM'];
			$bayar = $dat_tarif_operasi['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_operasi_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE OPERASI_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
			$id_tarif = $dat_tarif_hemodialisa['HEMODIALISA_TARIF_ID'];
			$status = $dat_tarif_hemodialisa['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_hemodialisa['TDK_KLAIM'];
			$bayar = $dat_tarif_hemodialisa['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_hemodailisa_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE HEMODIALISA_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
			$id_tarif = $dat_tarif_penunjang_hemodialisa['PENUNJANG_TARIF_ID'];
			$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
			$tdk_klaim = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM'];
			$bayar = $dat_tarif_penunjang_hemodialisa['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_ipenunjang_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE PENUNJANG_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
	
		//ambulace irna
		while($dat_ambulance_irna = mysql_fetch_array($get_ambulance_irna)){
			$id_tarif = $dat_ambulance_irna['AMBULANCE_TARIF_ID'];
			$status = $dat_ambulance_irna['ST_BAYAR'];
			$tdk_klaim = $dat_ambulance_irna['TDK_KLAIM'];
			$bayar = $dat_ambulance_irna['TDK_KLAIM_BAYAR'];
			if($status != 'Batal'){ 
				if($tdk_klaim == '1' and $bayar != ''){
					mysql_query('UPDATE t_ambulance_tarif SET TDK_KLAIM_VERIF = "' . $user_bayar . '"
						WHERE AMBULANCE_TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
				} 
			}
		}
		//end ambulance irna
		
		/*
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());	

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
				
		$sql_resep  .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		}

		$sql_resep  = 'SELECT DISTINCT t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL ';
					
		if($ruang_tindakan != '') $sql_resep .= 'AND t_farmasi_apotik_pengeluaran.RUANG_ID = "' . $ruang_tindakan . '" ';				
		if($tgl1 != '' and $tgl2 == '') $sql_resep .= 'AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") = "' . $tgl1 . '" ';
		if($tgl1 != '' and $tgl2 != '') $sql_resep .= 'AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl1 . '","%d/%m/%Y")
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl2 . '","%d/%m/%Y") ';
			
		$sql_resep .= 'GROUP BY t_ranap_resep.RANAP_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_ranap_resep.NO_RESEP DESC';	
		$get_resep = mysql_query($sql_resep) or die(mysql_error());	
		while($dat_resep = mysql_fetch_array($get_resep)){
			$no_resep = $dat_resep['NO_RESEP'];
			$status = $dat_resep['ST_BATAL'];
			$no_bayar = $dat_resep['NO_PEMBAYARAN'];
			if($status != '1' and $no_bayar == ''){
				$no_kw_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_PEMBAYARAN = "' . $no_kw_bayar . '",
						TANGGAL_BAYAR = NOW()
						WHERE NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
			}
		} */
		//
		
		break;
		
		case 'addtarifkartupasien' :
		
		$idx = $_GET['idx'];
		$jenis_bayar_id = $_GET['bayar'];
		$tarif_id = $_GET['tarif'];
		
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if($jenis_bayar_id <> '1'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$nomor = getNomorHarian('Tarif');
		
		mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
						VALUES("' . $idx . '",NOW(),"' . $tarif_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
						"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . currentUser() . '",NULL)') or die(mysql_error());	
		break;
		
		case 'verifpengembalianfarmasi' :
			$cruser = currentUser();
			
			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
			mysql_query('UPDATE t_farmasi_apotik_pengembalian_resep SET ST_VERIF = "' . $cruser . '"
					WHERE NO_PENGEMBALIAN = "' . $_GET['no'] . '"
					AND FARMASI_PENGEMBALIAN_APOTIK_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
					
			$sql_bayar = 'SELECT NO_PEMBAYARAN 
					FROM t_farmasi_apotik_pengembalian_resep
					WHERE NO_PENGEMBALIAN = "' . $_GET['no'] . '"
					AND FARMASI_PENGEMBALIAN_APOTIK_ID = "' . $_GET['idx'] . '"';
			$get_bayar = mysql_query($sql_bayar) or die(mysql_error());
			$dat_bayar = mysql_fetch_assoc($get_bayar);
			if($dat_bayar['NO_PEMBAYARAN'] == ''){
				$no_bayar = getNomorHarian('Kasir');
				mysql_query('UPDATE t_farmasi_apotik_pengembalian_resep 
					SET USER_PEMBAYARAN = "' . $cruser . '",
					NO_PEMBAYARAN = "' . $no_bayar . '",
					TANGGAL_BAYAR = NOW()
					WHERE FARMASI_PENGEMBALIAN_APOTIK_ID = "' . $_GET['idx'] . '" 
					AND NO_PENGEMBALIAN = "' . $_GET['no'] . '"') or die(mysql_error());
			}	
					
			break;
			
			case 'klinikaddperubahankulitsaraf' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $_POST['irja_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_1_pkus_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pengkajian_awal_medik_kusta/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					if(empty($_POST['idx'])){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_kusta 
							(IRJA_ID,TANDA_PERUBAHAN_KULIT_SARAF,CATATAN_TANDA_PERUBAHAN_KULIT_SARAF,REGISTER)
							VALUES ("' . $_POST['irja_id'] . '","' . $nama_file . '","' . $_POST['catatan'] . '",
							"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_kusta
							SET TANDA_PERUBAHAN_KULIT_SARAF = "' . $nama_file . '",
							CATATAN_TANDA_PERUBAHAN_KULIT_SARAF = "' . $_POST['catatan'] . '",
							REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
							WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					}
					echo 'Simpan Data Pengkajian Awal Medis Berhasil.';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'klinikaddpemeriksaanmata' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $_POST['irja_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_1_pm_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file2 = $_POST['nomr'] . '_1_pm_gbm_l_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img2'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file2,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file3 = $_POST['nomr'] . '_1_pm_gbm_r_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img3'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file3,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file4 = $_POST['nomr'] . '_1_pm_fundus_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img4'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file4,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					if(empty($_POST['idx'])){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_mata 
							(IRJA_ID,PEMERIKSAAN_MATA_GBR,PEMERIKSAAN_MATA_GBM_L,PEMERIKSAAN_MATA_GBM_R,
							PEMERIKSAAN_MATA_GBR_FUNDUS)
							VALUES ("' . $_POST['irja_id'] . '","' . $nama_file . '","' . $nama_file2 . '",
							"' . $nama_file3 . '","' . $nama_file4 . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_mata
							SET PEMERIKSAAN_MATA_GBR = "' . $nama_file . '",
							PEMERIKSAAN_MATA_GBM_L = "' . $nama_file2 . '",
							PEMERIKSAAN_MATA_GBM_R = "' . $nama_file3 . '",
							PEMERIKSAAN_MATA_GBR_FUNDUS = "' . $nama_file4 . '"
							WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'klinikaddpemeriksaangigi' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $_POST['irja_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_1_odontogram_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_gigi/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					if(empty($_POST['idx'])){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_gigi 
							(IRJA_ID,ODONTOGRAM_GBR)
							VALUES ("' . $_POST['irja_id'] . '","' . $nama_file . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_gigi
							SET ODONTOGRAM_GBR = "' . $nama_file . '"
							WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'copytindakankepam' :
			
			$tindakan = '';
			$sql_tindakan = 'SELECT m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $_GET['irja_id'] . '"
				AND t_irja_tarif.NO_TARIF = "' . $_GET['nomor'] . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
				AND m_tarif.KODE_TARIF <> "103001" 
				AND m_tarif.KODE_TARIF <> "102001"';
			$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
			while($dat_tindakan = mysql_fetch_array($get_tindakan)){
				
				$temp_tindakan = $dat_tindakan['NAMA_TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],array('02','09','93'))) $temp_tindakan = 'Konsultasi';
				$tindakan .= ', ' . $temp_tindakan;
			}
			$tindakan = substr($tindakan,2,strlen($tindakan));
			
			$table = 't_irja_pengkajian_awal_medis';
			$field = 'RENCANA_TATALAKSANA_NON_FARMAKA';
			if($_GET['unit'] == '5') {
				$table = 't_irja_pengkajian_awal_medis_gigi';
				$field = 'TERAPI_NON_FARMAKA';
			}		
			if($_GET['unit'] == '29'){
				$table = 't_irja_pengkajian_awal_medis_mata';
				$field = 'RENCANA_TATALAKSANA_NON_FARMAKA';
			}	
			if($_GET['unit'] == '35'){
				$table = 't_irja_pengkajian_awal_medis_kusta';
				$field = 'RENCANA_TATALAKSANA_NON_FARMAKA';
			}	
			$sql_pengkajian = 'SELECT IRJA_ID,FINAL,' . $field . ' 
							FROM ' . $table . '
							WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';				
			$get_pengkajian = mysql_query($sql_pengkajian) or die(mysql_error());
			if(mysql_num_rows($get_pengkajian) == 0){
				mysql_query('INSERT INTO ' . $table . ' (IRJA_ID,' . $field . ',REGISTER)
					VALUES ("' . $_GET['irja_id'] . '","' . $tindakan . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
				echo 'Tindakan Sudah Dicopy.';	
			}else{
				$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
				if($dat_pengkajian[$field] != '') $tindakan = $dat_pengkajian[$field] . ' \n' . $tindakan;
				mysql_query('UPDATE ' . $table . '
					SET ' . $field . ' = "' . $tindakan . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
					WHERE IRJA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
				echo 'Tindakan Sudah Dicopy.';
			}	
							
			break;
			
			case 'copyresepkepam' :
			
			$arr_aturan_pakai = getResepAturanPakai();
			$arr_satuan_resep = getResepSatuan();
			$arr_waktu_pakai = getResepWaktuPakai();
			$arr_nama_racikan = getResepNamaRacikan();

			$v_resep = '';
			$sql_resep = 'SELECT t_irja_resep.IRJA_ID,t_irja_resep.IRJA_RESEP_ID,
				t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
				t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
				t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
				t_irja_resep.JUMLAH_KELUAR,t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
				FROM t_irja_resep
				WHERE t_irja_resep.IRJA_ID = "' . $_GET['irja_id'] . '" 
				AND t_irja_resep.RESEP IS NOT NULL
				AND t_irja_resep.NO_RESEP = "' . $_GET['nomor'] . '"';
			$get_resep = mysql_query($sql_resep);
			
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				$resep = $dat_resep['RESEP'];
				if($dat_resep['RACIKAN'] == '1'){
					$resep = '';
					$arr_nmr = explode('|',$dat_resep['RESEP']);
						foreach($arr_nmr as $row){
							if(is_numeric($row)){
								$resep .= $arr_nama_racikan[$row] . ' ';
							}else{
								$resep .= $row . ' ';
							}
						}
					$resep = substr($resep,0,strlen($resep)-1); 
				}
			
			$v_resep .= $resep . ' ' . $dat_resep['JUMLAH'] . ' ' . $dat_resep['SATUAN'];
			
				$arr_atp = explode('|',$dat_resep['DOSIS']);
				$atp = '';
				foreach($arr_atp as $row){
					if(is_numeric($row)){
						$atp .= $arr_aturan_pakai[$row] . ',';
					}else{
						$atp .= $row . ',';
					}
				}
			$v_resep .= ' ' . substr($atp,0,strlen($atp)-1);
						
				$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
				$str = '';
				foreach($arr_str as $row){
					if(is_numeric($row)){
						$str .= $arr_satuan_resep[$row] . ',';
					}else{
						$str .= $row . ',';
					}
				}
			$v_resep .= ' ' . substr($str,0,strlen($str)-1);
				
				$arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
				$wkp = '';
				foreach($arr_wkp as $row){
					if(is_numeric($row)){
						$wkp .= $arr_waktu_pakai[$row] . ',';
					}else{
						$wkp .= $row . ',';
					}
				}
				$wkp = substr($wkp,0,strlen($wkp)-1);
			$v_resep .= ' ' . str_replace('Bila perlu,','Bila perlu ',$wkp); 
		 
			if($dat_resep['RACIKAN'] == '1'){
				$sql_racikan = 'SELECT t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,
							t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.FORMULARIUM,
							t_irja_resep_racikan.FORMULARIUM_NASIONAL,
							t_irja_resep_racikan.JUMLAH_KELUAR
							FROM t_irja_resep_racikan 
							WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_resep['IRJA_RESEP_ID'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				while($dat_racikan = mysql_fetch_array($get_racikan)){
					$v_resep .= ' \n  ' . $dat_racikan['RESEP'] . ' ' . $dat_racikan['JUMLAH'] . ' ' . $dat_racikan['SATUAN'];
				}	
			}
				$v_resep .= ' \n';
			}
			
			$table = 't_irja_pengkajian_awal_medis';
			$field = 'RENCANA_TATALAKSANA';
			if($_GET['unit'] == '5') {
				$table = 't_irja_pengkajian_awal_medis_gigi';
				$field = 'TERAPI';
			}		
			if($_GET['unit'] == '29'){
				$table = 't_irja_pengkajian_awal_medis_mata';
				$field = 'RENCANA_TATALAKSANA';
			}	
			if($_GET['unit'] == '35'){
				$table = 't_irja_pengkajian_awal_medis_kusta';
				$field = 'RENCANA_TATALAKSANA';
			}	
			$sql_pengkajian = 'SELECT IRJA_ID,FINAL,' . $field . ' 
							FROM ' . $table . '
							WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';				
			$get_pengkajian = mysql_query($sql_pengkajian) or die(mysql_error());
			if(mysql_num_rows($get_pengkajian) == 0){
				mysql_query('INSERT INTO ' . $table . ' (IRJA_ID,' . $field . ',REGISTER)
					VALUES ("' . $_GET['irja_id'] . '","' . $v_resep . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
				echo 'Resep Sudah Dicopy.';	
			}else{
				$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
				if($dat_pengkajian[$field] != '') $v_resep = $dat_pengkajian[$field] . ' \n' . $v_resep;
				mysql_query('UPDATE ' . $table . '
					SET ' . $field . ' = "' . $v_resep . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
					WHERE IRJA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
				echo 'Resep Sudah Dicopy.';
			}	
							
			break;
			
			case 'copylaboratoriumkepam' :
			
			if($_GET['unit'] == '5'){
				echo 'Tidak Ada.';
				break;
			}	
			
			$lis = $_GET['laboratorium'];
			if($lis == ''){
				$tindakan = '';
				$sql_tindakan = 'SELECT DISTINCT m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,
					m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_ORDER,
					t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
					t_ipenunjang_tarif_pemeriksaan.METHODE,
					t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
					m_tarif_pemeriksaan.TEXT_HASIL,m_tarif.KODE_TARIF
					FROM t_ipenunjang_tarif
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
					AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
					t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
					LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"	
					AND t_ipenunjang.NO_ORDER = "' . $_GET['nomor'] . '"
					ORDER BY m_tarif_pemeriksaan.KODE_TARIF,m_tarif_pemeriksaan.REPORT_ORDER';
				$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
				$nama_pemeriksaan_group = '';
				while($dat_tindakan = mysql_fetch_array($get_tindakan)){
					if($nama_pemeriksaan_group != $dat_tindakan['NAMA_PEMERIKSAAN_GROUP']) { 
							$tindakan .= $dat_tindakan['NAMA_PEMERIKSAAN_GROUP'] . ' \n ';
							$nama_pemeriksaan_group = $dat_tindakan['NAMA_PEMERIKSAAN_GROUP'];		
						}
						
					$hasil_a = explode('|!|',$dat_tindakan['HASIL_DIAGNOSA']);
					$hasil = '';
					if(sizeof($hasil_a) == 5){
						$hasil = 'Bi=' . $hasil_a[0];
						$hasil .= ',Mi=' . $hasil_a[1];
						$hasil .= ',S(%)=' . $hasil_a[2];
						$hasil .= ',F(%)=' . $hasil_a[3];
						$hasil .= ',G(%)=' . $hasil_a[4];
					}else{
						$hasil = $dat_tindakan['HASIL_DIAGNOSA'];
					}	
					$tindakan .= '- ' . $dat_tindakan['NAMA_PEMERIKSAAN'] . ' : ' .  $hasil .  ' \n ';
				}
			}else{
				$tindakan = '';
				$sql_tindakan = 'SELECT LIS_ID,PENUNJANG_ID,RAWAT_ID,JNS_ORDER,NO_ORDER,NO_TARIF,KODE_TEST,NAMA_TEST,GROUP_TEST,
						RUJUKAN,TIPE_DATA,HASIL,FLAG,SATUAN,KETERANGAN_HASIL,KODE_PETUGAS,NAMA_PETUGAS,
						DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y") AS TGL_VALIDASI,
						DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y %H:%i:%s") AS TGL_TRANS
						FROM t_laboratorium_lis_data
						WHERE RAWAT_ID = "' . $_GET['irja_id'] . '" 
						AND NO_ORDER = "' . $_GET['nomor'] . '"
						AND JNS_ORDER = "IRJ"
						ORDER BY LIS_ID';
				$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());		
				while($dat_tindakan = mysql_fetch_array($get_tindakan)){
					
					if($dat_tindakan['HASIL'] == ''){
						$tindakan .= $dat_tindakan['NAMA_TEST'] . ' \n ';
					}else{
						$tindakan .= $dat_tindakan['NAMA_TEST'] . ' : ' . $dat_tindakan['HASIL'];
						if($dat_tindakan['SATUAN'] != '') $tindakan .= ' ' . $dat_tindakan['SATUAN'];
						if($dat_tindakan['RUJUKAN'] != '') $tindakan .= ' (' . $dat_tindakan['RUJUKAN'] . ')';
						$tindakan .= ' \n ';
					}
				}	
			}
				
			$table = 't_irja_pengkajian_awal_medis';
			$field = 'HASIL_PEMERIKSAAN_PENUNJANG';	
			if($_GET['unit'] == '29'){
				$table = 't_irja_pengkajian_awal_medis_mata';
				$field = 'HASIL_PEMERIKSAAN_PENUNJANG';
			}	
			if($_GET['unit'] == '35'){
				$table = 't_irja_pengkajian_awal_medis_kusta';
				$field = 'HASIL_PEMERIKSAAN_PENUNJANG';
			}	
			$sql_pengkajian = 'SELECT IRJA_ID,FINAL,' . $field . ' 
							FROM ' . $table . '
							WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';				
			$get_pengkajian = mysql_query($sql_pengkajian) or die(mysql_error());
			if(mysql_num_rows($get_pengkajian) == 0){
				mysql_query('INSERT INTO ' . $table . ' (IRJA_ID,' . $field . ',REGISTER)
					VALUES ("' . $_GET['irja_id'] . '","' . $tindakan . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
				echo 'Pemeriksaan Penunjang Sudah Dicopy.';	
			}else{
				$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
				if($dat_pengkajian[$field] != '') $tindakan = $dat_pengkajian[$field] . ' \n' . $tindakan;
				mysql_query('UPDATE ' . $table . '
					SET ' . $field . ' = "' . $tindakan . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
					WHERE IRJA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
				echo 'Pemeriksaan Penunjang Sudah Dicopy.';
			}	
							
			break;
			
			case 'copyradiologikepam' :
			
			if($_GET['unit'] == '5'){
				echo 'Tidak Ada.';
				break;
			}

			$sql_periksa = 'SELECT t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				m_tarif.NAMA_TARIF,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif 
				ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan 
				ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['irja_id'] . '"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['nomor'] . '"
				ORDER BY t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID
				DESC LIMIT 1';
			$get_periksa = mysql_query($sql_periksa) or die(mysql_error());
			$dat_periksa = mysql_fetch_assoc($get_periksa);
			$pemeriksaan_id = $dat_periksa['PENUNJANG_TARIF_PEMERIKSAAN_ID'];
			$tindakan = $dat_periksa['NAMA_PEMERIKSAAN_ORDER'] . ' :';	
			
			$sql_tindakan = 'SELECT t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $pemeriksaan_id . '"';
			$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
			$dat_tindakan = mysql_fetch_assoc($get_tindakan);

			
			$a_tindakan = explode(':',$dat_tindakan['HASIL_DIAGNOSA']);
			if(sizeof($a_tindakan) > 0){
				$s = 1;
				while($s < sizeof($a_tindakan)){
					$tindakan .= $a_tindakan[$s];
					$s++;
				}	
			}	
			
			$tindakan = str_replace('<br />',' ',$tindakan);
			$tindakan = str_replace('<strong>','',$tindakan);
			$tindakan = str_replace('</strong>','',$tindakan);
			$tindakan = str_replace('<ul>','',$tindakan);
			$tindakan = str_replace('</ul>','',$tindakan);
			$tindakan = str_replace('<li>','',$tindakan);
			$tindakan = str_replace('</li>','',$tindakan);
			$tindakan = str_replace('<em>','',$tindakan);
			$tindakan = str_replace('</em>','',$tindakan);
			
			$table = 't_irja_pengkajian_awal_medis';
			$field = 'HASIL_PEMERIKSAAN_PENUNJANG';	
			if($_GET['unit'] == '29'){
				$table = 't_irja_pengkajian_awal_medis_mata';
				$field = 'HASIL_PEMERIKSAAN_PENUNJANG';
			}	
			if($_GET['unit'] == '35'){
				$table = 't_irja_pengkajian_awal_medis_kusta';
				$field = 'HASIL_PEMERIKSAAN_PENUNJANG';
			}	
			$sql_pengkajian = 'SELECT IRJA_ID,FINAL,' . $field . ' 
							FROM ' . $table . '
							WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';				
			$get_pengkajian = mysql_query($sql_pengkajian) or die(mysql_error());
			if(mysql_num_rows($get_pengkajian) == 0){
				mysql_query('INSERT INTO ' . $table . ' (IRJA_ID,' . $field . ',REGISTER)
					VALUES ("' . $_GET['irja_id'] . '","' . $tindakan . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
				echo 'Pemeriksaan Penunjang Sudah Dicopy.';	
			}else{
				$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
				if($dat_pengkajian[$field] != '') $tindakan = $dat_pengkajian[$field] . ' \n' . $tindakan;
				mysql_query('UPDATE ' . $table . '
					SET ' . $field . ' = "' . $tindakan . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
					WHERE IRJA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
				echo 'Pemeriksaan Penunjang Sudah Dicopy.';
			}	
							
			break;
			
			case 'klinikaddpemeriksaansarafotot' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $_POST['irja_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_1_pso_kaki_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pengkajian_awal_medik_kusta/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);
					$nama_file2 = $_POST['nomr'] . '_1_pso_tangan_' . $_POST['irja_id'] . '.jpg';
					$imageData2 = $_POST['img2'];
					$filteredData2=substr($imageData2, strpos($imageData2, ",")+1);
					$unencodedData2=base64_decode($filteredData2);
					$fp2 = fopen($rmfile_path . '/pengkajian_awal_medik_kusta/' . $nama_file2,'wb');
					fwrite($fp2,$unencodedData2);
					fclose($fp2);
					if(empty($_POST['idx'])){
						mysql_query('INSERT INTO t_irja_pemeriksaan_saraf_dan_otot 
							(IRJA_ID,TEST_RASA_KAKI,TEST_RASA_TANGAN)
							VALUES ("' . $_POST['irja_id'] . '","' . $nama_file . '","' . $nama_file2 . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pemeriksaan_saraf_dan_otot
							SET TEST_RASA_KAKI = "' . $nama_file . '",
							TEST_RASA_TANGAN = "' . $nama_file2 . '"
							WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'klinikaddpencegahankecacatan' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $_POST['irja_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_1_epk_' . $_POST['irja_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pengkajian_awal_medik_kusta/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);
					if(empty($_POST['idx'])){
						mysql_query('INSERT INTO t_irja_evaluasi_pencegahan_kecacatan 
							(IRJA_ID,KECACATAN_GBR)
							VALUES ("' . $_POST['irja_id'] . '","' . $nama_file . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_evaluasi_pencegahan_kecacatan
							SET KECACATAN_GBR = "' . $nama_file . '"
							WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'copyaskepkepam' :
				$irja_id = $_GET['irja_id'];
				$unit = $_GET['unit'];
				
				$keluhan_utama = '';
				$riwayat_penyakit = '';
				$riwayat_penyakit_keluarga = '';
				$keadaan_umum = '';
				$td = '';
				$nadi = '';
				$nadi_teratur = '';
				$gcs = '';
				$suhu = '';
				$tb = '';
				$kepala = '';
				$leher = '';
				$bb = '';
				$rr = '';
				$jantung = '';
				$paru = '';
				$abdomen = '';
				$extremitas = '';
				$alergi = '';
				
				//from askep
				if($unit == '2'){
					$sql_asuhan = 'SELECT DS_KELUHAN_UTAMA,DS_RIWAYAT_PENYAKIT_DIDERITA,
							DS_RIWAYAT_PENYAKIT_KELUARGA,DO_PEMERIKSAAN_UMUM
							FROM t_irja_pengkajian_awal_kandungan
							WHERE IRJA_ID = "' . $irja_id . '"';
					$get_asuhan = mysql_query($sql_asuhan) or die(mysql_error());
					$dat_asuhan = mysql_fetch_assoc($get_asuhan);
					$keluhan_utama = $dat_asuhan['DS_KELUHAN_UTAMA'];
					$arr_riwayat_penyakit = str_replace('|','"',$dat_asuhan['DS_RIWAYAT_PENYAKIT_DIDERITA']);
					$arr_riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($arr_riwayat_penyakit));
					$arr_riwayat_penyakit = json_decode($arr_riwayat_penyakit,true);
					$riwayat_penyakit = $arr_riwayat_penyakit['riwayat']; 
					$riwayat_penyakit_keluarga = $dat_asuhan['DS_RIWAYAT_PENYAKIT_KELUARGA'];
					$arr_pemeriksaan_umum = str_replace('|','"',$dat_asuhan['DO_PEMERIKSAAN_UMUM']);
					$arr_pemeriksaan_umum = preg_replace('/\r|\n/','\n',trim($arr_pemeriksaan_umum));
					$arr_pemeriksaan_umum = json_decode($arr_pemeriksaan_umum,true);
					$td = $arr_pemeriksaan_umum['pem_td'];
					$nadi = $arr_pemeriksaan_umum['pem_nadi'];
					$nadi_teratur = $arr_pemeriksaan_umum[''];
					$suhu = $arr_pemeriksaan_umum['pem_suhu'];
					$tb = $arr_pemeriksaan_umum['pem_tb'];
					$bb = $arr_pemeriksaan_umum['pem_bb_sk'];
					$rr = $arr_pemeriksaan_umum['pem_napas'];
				}else if($unit == '5'){
					$sql_asuhan = 'SELECT KELUHAN_UTAMA,TANDA_VITAL,
							ANTROPOMETRI,RIWAYAT_ALERGI
							FROM t_irja_pengkajian_awal_kesehatan_mulut
							WHERE IRJA_ASKEP_ID = "' . $irja_id . '"';
					$get_asuhan = mysql_query($sql_asuhan) or die(mysql_error());
					$dat_asuhan = mysql_fetch_assoc($get_asuhan);
					$keluhan_utama = $dat_asuhan['KELUHAN_UTAMA'];
					$alergi = $dat_asuhan['RIWAYAT_ALERGI'];
					$tanda_vital = str_replace('|','"',$dat_asuhan['TANDA_VITAL']);
					$tanda_vital = preg_replace('/\r|\n/','\n',trim($tanda_vital));
					$tanda_vital = json_decode($tanda_vital,true);
					$antropometri = str_replace('|','"',$dat_asuhan['ANTROPOMETRI']);
					$antropometri = preg_replace('/\r|\n/','\n',trim($antropometri));
					$antropometri = json_decode($antropometri,true);
					
					$td = $tanda_vital['td'];
					$nadi = $tanda_vital['nadi'];
					$rr = $tanda_vital['rr'];
					$suhu = $tanda_vital['suhu'];
					
					$tb = $antropometri['tb'];
					$bb = $antropometri['bb'];
				}else{
					$sql_asuhan = 'SELECT KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
						TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,TINGGI_BADAN,
						RIWAYAT_ALERGI_OBAT
						FROM t_irja_askep 
						WHERE IRJA_ASKEP_ID = "' . $irja_id . '"';
					$get_asuhan = mysql_query($sql_asuhan) or die(mysql_error());
					$dat_asuhan = mysql_fetch_assoc($get_asuhan);
					$keluhan_utama = $dat_asuhan['KELUHAN_UTAMA'];
					$riwayat_penyakit = $dat_asuhan['RIWAYAT_PENYAKIT'];
					$riwayat_penyakit_keluarga = $dat_asuhan['RIWAYAT_PENYAKIT_KELUARGA'];
					$td = $dat_asuhan['TEKANAN_DARAH'];
					$nadi = $dat_asuhan['FREKUENSI_NADI'];
					$suhu = $dat_asuhan['SUHU_TUBUH'];
					$tb = $dat_asuhan['TINGGI_BADAN'];
					$bb = $dat_asuhan['BERAT_BADAN'];
					$rr = $dat_asuhan['FREKUENSI_NAFAS'];
					$alergi = $dat_asuhan['RIWAYAT_ALERGI_OBAT'];
				}
				
				//to pam
				if($unit == '35'){
					$sql_pam = 'SELECT pam.IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,ALERGI,PEMERIKSAAN,FINAL
						FROM t_irja_pengkajian_awal_medis_kusta pam
						LEFT JOIN t_irja_alergi ON (pam.IRJA_ID = t_irja_alergi.IRJA_ID) 
						WHERE pam.IRJA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);	
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pam_alergi = $dat_pam['ALERGI'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['pm_keadaan_umum'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_v'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_kepala'=>$pemeriksaan_fisik['pm_kepala'],
						'pm_bb'=>$bb,
						'pm_leher'=>$pemeriksaan_fisik['pm_leher'],
						'pm_rr'=>$rr,
						'pm_jantung'=>$pemeriksaan_fisik['pm_jantung'],
						'pm_paru'=>$pemeriksaan_fisik['pm_paru'],
						'pm_abdomen'=>$pemeriksaan_fisik['pm_abdomen'],
						'pm_extremitas'=>$pemeriksaan_fisik['pm_extremitas']);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);	
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_kusta (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_kusta 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					
					if($pam_alergi != '') $alergi .= $pam_alergi . ' \n ' . $alergi;
					mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error());		
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';	
				}else if($unit == '5'){
					$sql_pam = 'SELECT pam.IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,ALERGI,FINAL
						FROM t_irja_pengkajian_awal_medis_gigi pam
						LEFT JOIN t_irja_alergi ON (pam.IRJA_ID = t_irja_alergi.IRJA_ID) 
						WHERE pam.IRJA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);	
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pam_alergi = $dat_pam['ALERGI'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['pm_keadaan_umum'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_bb'=>$bb,
						'pm_rr'=>$rr);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_gigi (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,
						ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_gigi 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					
					if($pam_alergi != '') $alergi .= $pam_alergi . ' \n ' . $alergi;
					mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error());		
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';	
				}else if($unit == '29'){	
					$sql_pam = 'SELECT pam.IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,FINAL
						FROM t_irja_pengkajian_awal_medis_mata pam
						WHERE pam.IRJA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);	
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['pm_keadaan_umum'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_v'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_bb'=>$bb,
						'pm_rr'=>$rr);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_mata (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,
						ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis_mata 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';
				}else{
					$sql_pam = 'SELECT pam.IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,FINAL,ALERGI
						FROM t_irja_pengkajian_awal_medis pam
						LEFT JOIN t_irja_alergi ON (pam.IRJA_ID = t_irja_alergi.IRJA_ID) 
						WHERE pam.IRJA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);	
					$pam_alergi = $dat_pam['ALERGI'];
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['asas'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_v'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_kepala'=>$pemeriksaan_fisik['pm_kepala'],
						'pm_bb'=>$bb,
						'pm_leher'=>$pemeriksaan_fisik['pm_leher'],
						'pm_rr'=>$rr,
						'pm_jantung'=>$pemeriksaan_fisik['pm_jantung'],
						'pm_paru'=>$pemeriksaan_fisik['pm_paru'],
						'pm_abdomen'=>$pemeriksaan_fisik['pm_abdomen'],
						'pm_extremitas'=>$pemeriksaan_fisik['pm_extremitas']);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,
						ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					
					if($pam_alergi != '') $alergi .= $pam_alergi . ' \n ' . $alergi;
					mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error());		
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';
				}				
				
				break;
				
			case 'copyresepkecppt' :
			
			$arr_aturan_pakai = getResepAturanPakai();
			$arr_satuan_resep = getResepSatuan();
			$arr_waktu_pakai = getResepWaktuPakai();
			$arr_nama_racikan = getResepNamaRacikan();

			$v_resep = '';
			$sql_resep = 'SELECT t_irja_resep.IRJA_ID,t_irja_resep.IRJA_RESEP_ID,
				t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
				t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
				t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
				t_irja_resep.JUMLAH_KELUAR,t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
				FROM t_irja_resep
				WHERE t_irja_resep.IRJA_ID = "' . $_GET['irja_id'] . '" 
				AND t_irja_resep.RESEP IS NOT NULL
				AND t_irja_resep.NO_RESEP = "' . $_GET['nomor'] . '"';
			$get_resep = mysql_query($sql_resep);
			
			while ($dat_resep = mysql_fetch_array($get_resep)) {
				$resep = $dat_resep['RESEP'];
				if($dat_resep['RACIKAN'] == '1'){
					$resep = '';
					$arr_nmr = explode('|',$dat_resep['RESEP']);
						foreach($arr_nmr as $row){
							if(is_numeric($row)){
								$resep .= $arr_nama_racikan[$row] . ' ';
							}else{
								$resep .= $row . ' ';
							}
						}
					$resep = substr($resep,0,strlen($resep)-1); 
				}
			
			$v_resep .= $resep . ' ' . $dat_resep['JUMLAH'] . ' ' . $dat_resep['SATUAN'];
			
				$arr_atp = explode('|',$dat_resep['DOSIS']);
				$atp = '';
				foreach($arr_atp as $row){
					if(is_numeric($row)){
						$atp .= $arr_aturan_pakai[$row] . ',';
					}else{
						$atp .= $row . ',';
					}
				}
			$v_resep .= ' ' . substr($atp,0,strlen($atp)-1);
						
				$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
				$str = '';
				foreach($arr_str as $row){
					if(is_numeric($row)){
						$str .= $arr_satuan_resep[$row] . ',';
					}else{
						$str .= $row . ',';
					}
				}
			$v_resep .= ' ' . substr($str,0,strlen($str)-1);
				
				$arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
				$wkp = '';
				foreach($arr_wkp as $row){
					if(is_numeric($row)){
						$wkp .= $arr_waktu_pakai[$row] . ',';
					}else{
						$wkp .= $row . ',';
					}
				}
				$wkp = substr($wkp,0,strlen($wkp)-1);
			$v_resep .= ' ' . str_replace('Bila perlu,','Bila perlu ',$wkp); 
		 
			if($dat_resep['RACIKAN'] == '1'){
				$sql_racikan = 'SELECT t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,
							t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.FORMULARIUM,
							t_irja_resep_racikan.FORMULARIUM_NASIONAL,
							t_irja_resep_racikan.JUMLAH_KELUAR
							FROM t_irja_resep_racikan 
							WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_resep['IRJA_RESEP_ID'] . '"';
				$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
				while($dat_racikan = mysql_fetch_array($get_racikan)){
					$v_resep .= '<br>' . $dat_racikan['RESEP'] . ' ' . $dat_racikan['JUMLAH'] . ' ' . $dat_racikan['SATUAN'];
				}	
			}
				$v_resep .= '<br>';
			}
			
			$sql_perk = 'SELECT t_irja_perkembangan.* 
						FROM t_irja_perkembangan
						INNER JOIN m_pegawai 
						ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_pegawai_tipe
						ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
						WHERE t_irja_perkembangan.IRJA_ID = "' . $_GET['irja_id'] . '"
						AND m_pegawai.TIPE_PEGAWAI_ID IN (1,2,3)
						ORDER BY t_irja_perkembangan.IRJA_PERKEMBANGAN_ID DESC LIMIT 1';				
			$get_perk = mysql_query($sql_perk) or die(mysql_error());
			if(mysql_num_rows($get_perk) == 0){
				$v_resep = htmlspecialchars($v_resep);
				$v_resep = str_replace('"',"'",$v_resep);
				
				$hasil_asesmen = array('s'=>'','o'=>'','a'=>'',
					'd0'=>'','d1'=>'','d2'=>'','d3'=>'',
					'd4'=>'','d5'=>'','d6'=>'','d7'=>'',
					'p'=>$v_resep);
				$hasil_asesmen = json_encode($hasil_asesmen);
				$hasil_asesmen = str_replace('"','|',$hasil_asesmen);					
				
				mysql_query('INSERT INTO t_irja_perkembangan (IRJA_ID,NOMR,UNIT_ID,TANGGAL,PEMBERI_ASUHAN,HASIL_ASESMEN,
							INTRUKSI_PPA,VERIFIKASI_DPJP,REGISTER) 
							VALUES ("' . $_GET['irja_id'] .'","' . $_GET['nomr'] . '","' . $_GET['unit'] . '",NOW(),
							"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '","'. $hasil_asesmen .'","","",
							"' . currentUser() . '")') or die(mysql_error());
				echo 'Resep Sudah Dicopy.';	
			}else{
				$dat_perk = mysql_fetch_assoc($get_perk);
				$hasil_asesmen = $dat_perk['HASIL_ASESMEN'];
				$hasil_asesmen = str_replace('|','"',$dat_perk['HASIL_ASESMEN']);
				$hasil_asesmen = json_decode($hasil_asesmen,true);
				$perkem_id = $dat_perk['IRJA_PERKEMBANGAN_ID'];
				
				$v_resep = htmlspecialchars($v_resep);
				$v_resep = str_replace('"',"'",$v_resep);
				
				$hasil_asesmen = array('s'=>((isset($hasil_asesmen['s'])) ? $hasil_asesmen['s'] : ''),
					'o'=>((isset($hasil_asesmen['o'])) ? $hasil_asesmen['o'] : ''),
					'a'=>((isset($hasil_asesmen['a'])) ? $hasil_asesmen['a'] : ''),
					'd0'=>((isset($hasil_asesmen['d0'])) ? $hasil_asesmen['d0'] : ''),
					'd1'=>((isset($hasil_asesmen['d1'])) ? $hasil_asesmen['d1'] : ''),
					'd2'=>((isset($hasil_asesmen['d2'])) ? $hasil_asesmen['d2'] : ''),
					'd3'=>((isset($hasil_asesmen['d3'])) ? $hasil_asesmen['d3'] : ''),
					'd4'=>((isset($hasil_asesmen['d4'])) ? $hasil_asesmen['d4'] : ''),
					'd5'=>((isset($hasil_asesmen['d5'])) ? $hasil_asesmen['d5'] : ''),
					'd6'=>((isset($hasil_asesmen['d6'])) ? $hasil_asesmen['d6'] : ''),
					'd7'=>((isset($hasil_asesmen['d7'])) ? $hasil_asesmen['d7'] : ''),
					'p'=>((isset($hasil_asesmen['p']) and $hasil_asesmen['p'] != '') ? $hasil_asesmen['p'] . '<br>' : '') . $v_resep);
				$hasil_asesmen = json_encode($hasil_asesmen);
				$hasil_asesmen = str_replace('"','|',$hasil_asesmen);

				mysql_query('UPDATE t_irja_perkembangan 
					SET HASIL_ASESMEN = "' . $hasil_asesmen . '",
					REGISTER = "' . currentUser() . '"
					WHERE IRJA_PERKEMBANGAN_ID= "' . $perkem_id . '"') or die(mysql_error());	
				echo 'Resep Sudah Dicopy.';	
			}	
							
			break;
			
			case 'hmdcopyaskepkepam' :
				$irja_id = $_GET['irja_id'];
				$unit = $_GET['unit'];
				
				$keluhan_utama = '';
				$riwayat_penyakit = '';
				$riwayat_penyakit_keluarga = '';
				$keadaan_umum = '';
				$td = '';
				$nadi = '';
				$nadi_teratur = '';
				$gcs = '';
				$suhu = '';
				$tb = '';
				$kepala = '';
				$leher = '';
				$bb = '';
				$rr = '';
				$jantung = '';
				$paru = '';
				$abdomen = '';
				$extremitas = '';
				$alergi = '';
				
				//from askep
				if($unit == ''){
					$sql_asuhan = 'SELECT KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
						TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,TINGGI_BADAN,
						RIWAYAT_ALERGI_OBAT
						FROM t_irja_askep 
						WHERE IRJA_ASKEP_ID = "' . $irja_id . '"';
				}else{
					$sql_asuhan = 'SELECT KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
						TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,TINGGI_BADAN,
						RIWAYAT_ALERGI_OBAT
						FROM t_hemodialisa_askep 
						WHERE HEMODIALISA_ASKEP_ID = "' . $irja_id . '"';
				}		
						
					$get_asuhan = mysql_query($sql_asuhan) or die(mysql_error());
					$dat_asuhan = mysql_fetch_assoc($get_asuhan);
					$keluhan_utama = $dat_asuhan['KELUHAN_UTAMA'];
					$riwayat_penyakit = $dat_asuhan['RIWAYAT_PENYAKIT'];
					$riwayat_penyakit_keluarga = $dat_asuhan['RIWAYAT_PENYAKIT_KELUARGA'];
					$td = $dat_asuhan['TEKANAN_DARAH'];
					$nadi = $dat_asuhan['FREKUENSI_NADI'];
					$suhu = $dat_asuhan['SUHU_TUBUH'];
					$tb = $dat_asuhan['TINGGI_BADAN'];
					$bb = $dat_asuhan['BERAT_BADAN'];
					$rr = $dat_asuhan['FREKUENSI_NAFAS'];
					$alergi = $dat_asuhan['RIWAYAT_ALERGI_OBAT'];
				
				//to pam
				if($unit == ''){
				
					$sql_pam = 'SELECT pam.IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,FINAL,ALERGI
						FROM t_irja_pengkajian_awal_medis pam
						LEFT JOIN t_irja_alergi ON (pam.IRJA_ID = t_irja_alergi.IRJA_ID) 
						WHERE pam.IRJA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);	
					$pam_alergi = $dat_pam['ALERGI'];
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['asas'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_v'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_kepala'=>$pemeriksaan_fisik['pm_kepala'],
						'pm_bb'=>$bb,
						'pm_leher'=>$pemeriksaan_fisik['pm_leher'],
						'pm_rr'=>$rr,
						'pm_jantung'=>$pemeriksaan_fisik['pm_jantung'],
						'pm_paru'=>$pemeriksaan_fisik['pm_paru'],
						'pm_abdomen'=>$pemeriksaan_fisik['pm_abdomen'],
						'pm_extremitas'=>$pemeriksaan_fisik['pm_extremitas']);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,
						ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irja_pengkajian_awal_medis 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					
					if($pam_alergi != '') $alergi .= $pam_alergi . ' \n ' . $alergi;
					mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error());		
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';
				}else{
					$sql_pam = 'SELECT pam.HEMODIALISA_ID AS IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
						ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,FINAL,ALERGI
						FROM t_hemodialisa_pengkajian_awal_medis pam
						LEFT JOIN t_hemodialisa_alergi ON (pam.HEMODIALISA_ID = t_hemodialisa_alergi.HEMODIALISA_ID) 
						WHERE pam.HEMODIALISA_ID = "' . $irja_id . '"';
					$get_pam = mysql_query($sql_pam) or die(mysql_error());	
					$dat_pam = mysql_fetch_assoc($get_pam);
					$pam_alergi = $dat_pam['ALERGI'];	
					$pam_keluhan_utama = $dat_pam['ANAMNESIS_KELUHAN_UTAMA'];
					$pam_riwayat_penyakit_dahulu = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
					$pam_riwayat_penyakit_keluarga = $dat_pam['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
					$pemeriksaan_fisik = str_replace('|','"',$dat_pam['PEMERIKSAAN']);
					$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
					$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
					$pam_idx = $dat_pam['IRJA_ID'];
					
					$pemeriksaan = array('pm_keadaan_umum'=>$pemeriksaan_fisik['asas'],
						'pm_td'=>$td,
						'pm_gcs_e'=>$pemeriksaan_fisik['pm_gcs_e'],
						'pm_gcs_m'=>$pemeriksaan_fisik['pm_gcs_m'],
						'pm_gcs_v'=>$pemeriksaan_fisik['pm_gcs_v'],
						'pm_nadi'=>$nadi,
						'pm_suhu'=>$suhu,
						'pm_nadi_teratur'=>$pemeriksaan_fisik['pm_nadi_teratur'],
						'pm_tb'=>$tb,
						'pm_kepala'=>$pemeriksaan_fisik['pm_kepala'],
						'pm_bb'=>$bb,
						'pm_leher'=>$pemeriksaan_fisik['pm_leher'],
						'pm_rr'=>$rr,
						'pm_jantung'=>$pemeriksaan_fisik['pm_jantung'],
						'pm_paru'=>$pemeriksaan_fisik['pm_paru'],
						'pm_abdomen'=>$pemeriksaan_fisik['pm_abdomen'],
						'pm_extremitas'=>$pemeriksaan_fisik['pm_extremitas']);
					$pemeriksaan = json_encode($pemeriksaan);
					$pemeriksaan = str_replace('"','|',$pemeriksaan);
					if($pam_idx == ''){
						mysql_query('INSERT INTO t_hemodialisa_pengkajian_awal_medis (HEMODIALISA_ID,ANAMNESIS_KELUHAN_UTAMA,
						ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN)
							VALUES("' . $irja_id . '",
							"' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							"' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							"' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							"' . $pemeriksaan . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_hemodialisa_pengkajian_awal_medis 
							SET ANAMNESIS_KELUHAN_UTAMA = "' . (($pam_keluhan_utama == '') ? $keluhan_utama : $pam_keluhan_utama . '\n' . $keluhan_utama) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . (($pam_riwayat_penyakit_dahulu == '') ? $riwayat_penyakit : $pam_riwayat_penyakit_dahulu . '\n' . $riwayat_penyakit) . '",
							ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . (($pam_riwayat_penyakit_keluarga == '') ? $riwayat_penyakit_keluarga : $pam_riwayat_penyakit_keluarga . '\n' . $riwayat_penyakit_keluarga) . '",
							PEMERIKSAAN = "' . $pemeriksaan . '"
							WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
					}
					
					if($pam_alergi != '') $alergi .= $pam_alergi . ' \n ' . $alergi;
					mysql_query('DELETE FROM t_hemodialisa_alergi WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
					mysql_query('INSERT INTO t_hemodialisa_alergi(HEMODIALISA_ID,ALERGI) VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error());		
					echo 'Pengkajian Awal Keperawatan Telah Dicopy.';
				}	
							
				
				break;
				
				case 'hmdcopytindakankepam' :
			
				$tindakan = '';
				if($_GET['unit'] == ''){
					$sql_tindakan = 'SELECT m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP
						FROM t_irja_tarif
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.IRJA_ID = "' . $_GET['irja_id'] . '"
						AND t_irja_tarif.NO_TARIF = "' . $_GET['nomor'] . '"
						AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
						AND m_tarif.KODE_TARIF <> "103001" 
						AND m_tarif.KODE_TARIF <> "102001"';
						
					$sql_pengkajian = 'SELECT IRJA_ID,FINAL,RENCANA_TATALAKSANA_NON_FARMAKA 
								FROM t_irja_pengkajian_awal_medis
								WHERE IRJA_ID = "' . $_GET['irja_id'] . '"';	
				}else{
					$sql_tindakan = 'SELECT m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP
						FROM t_hemodialisa_tarif
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_hemodialisa_tarif.HEMODIALISA_ID = "' . $_GET['irja_id'] . '"
						AND t_hemodialisa_tarif.NO_TARIF = "' . $_GET['nomor'] . '"
						AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
						AND m_tarif.KODE_TARIF <> "103001" 
						AND m_tarif.KODE_TARIF <> "102001"';
						
					$sql_pengkajian = 'SELECT HEMODIALISA_ID,FINAL,RENCANA_TATALAKSANA_NON_FARMAKA 
								FROM t_hemodialisa_pengkajian_awal_medis
								WHERE HEMODIALISA_ID = "' . $_GET['irja_id'] . '"';	
				}		
				$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
				while($dat_tindakan = mysql_fetch_array($get_tindakan)){
				
					$temp_tindakan = $dat_tindakan['NAMA_TARIF'];
					if(in_array($dat_tindakan['KODE_TARIF_GROUP'],array('02','09','93'))) $temp_tindakan = 'Konsultasi';
					$tindakan .= ', ' . $temp_tindakan;
				}
				$tindakan = substr($tindakan,2,strlen($tindakan));
									
				$get_pengkajian = mysql_query($sql_pengkajian) or die(mysql_error());
				if(mysql_num_rows($get_pengkajian) == 0){
					
					if($_GET['unit'] == ''){
						mysql_query('INSERT INTO t_irja_pengkajian_awal_medis (IRJA_ID,RENCANA_TATALAKSANA_NON_FARMAKA,REGISTER)
							VALUES ("' . $_GET['irja_id'] . '","' . $tindakan . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
					}else{
						mysql_query('INSERT INTO t_hemodialisa_pengkajian_awal_medis (HEMODIALISA_ID,RENCANA_TATALAKSANA_NON_FARMAKA,REGISTER)
							VALUES ("' . $_GET['irja_id'] . '","' . $tindakan . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die();
					}		
					
					echo 'Tindakan Sudah Dicopy.';	
				}else{
					$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
					if($dat_pengkajian['RENCANA_TATALAKSANA_NON_FARMAKA'] != '') $tindakan = $dat_pengkajian[$field] . ' \n' . $tindakan;
						
						if($_GET['unit'] == ''){
							mysql_query('UPDATE t_irja_pengkajian_awal_medis
								SET RENCANA_TATALAKSANA_NON_FARMAKA = "' . $tindakan . '",
								REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
								WHERE IRJA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
						}else{
							mysql_query('UPDATE t_hemodialisa_pengkajian_awal_medis
								SET RENCANA_TATALAKSANA_NON_FARMAKA = "' . $tindakan . '",
								REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
								WHERE HEMODIALISA_ID = "' . $_GET['irja_id'] . '"') or die(mysql_error());	
						}		
					echo 'Tindakan Sudah Dicopy.';
				}	
								
				break;
				
				case 'loadtriase' :
				
					mysql_query('UPDATE t_igd_triase SET IRJA_ID = "' . $_POST['idx'] . '" 
							WHERE TRIASE_ID = "' . $_POST['idx_triase'] . '"') or die(mysql_error());
					echo 'ok';		
				
				break;
				
				case 'ranapaddpemeriksaangigi' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irna WHERE IRNA_ID = "' . $_POST['irna_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_2_odontogram_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_gigi/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					if(empty($_POST['idx_pam'])){
						mysql_query('INSERT INTO t_irna_pengkajian_awal_medis_gigi 
							(IRNA_ID,ODONTOGRAM_GBR)
							VALUES ("' . $_POST['irna_id'] . '","' . $nama_file . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irna_pengkajian_awal_medis_gigi
							SET ODONTOGRAM_GBR = "' . $nama_file . '"
							WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'ranapaddpemeriksaanmata' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irna WHERE IRNA_ID = "' . $_POST['irna_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_2_pm_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file2 = $_POST['nomr'] . '_2_pm_gbm_l_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img2'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file2,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file3 = $_POST['nomr'] . '_2_pm_gbm_r_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img3'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file3,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					$nama_file4 = $_POST['nomr'] . '_2_pm_fundus_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img4'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pemeriksaan_mata/' . $nama_file4,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					
					if(empty($_POST['idx_pam'])){
						mysql_query('INSERT INTO t_irna_pengkajian_awal_medis_mata 
							(IRNA_ID,PEMERIKSAAN_MATA_GBR,PEMERIKSAAN_MATA_GBM_L,PEMERIKSAAN_MATA_GBM_R,
							PEMERIKSAAN_MATA_GBR_FUNDUS)
							VALUES ("' . $_POST['irna_id'] . '","' . $nama_file . '","' . $nama_file2 . '",
							"' . $nama_file3 . '","' . $nama_file4 . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irna_pengkajian_awal_medis_mata
							SET PEMERIKSAAN_MATA_GBR = "' . $nama_file . '",
							PEMERIKSAAN_MATA_GBM_L = "' . $nama_file2 . '",
							PEMERIKSAAN_MATA_GBM_R = "' . $nama_file3 . '",
							PEMERIKSAAN_MATA_GBR_FUNDUS = "' . $nama_file4 . '"
							WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;
			
			case 'ranapaddperubahankulitsaraf' :
				$st_save = true;
				if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
				$sql_dokter = 'SELECT PEGAWAI_ID FROM t_irna WHERE IRNA_ID = "' . $_POST['irna_id'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				if($dat_dokter['PEGAWAI_ID'] != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	
				if($st_save){
					$nama_file = $_POST['nomr'] . '_2_pkus_' . $_POST['irna_id'] . '.jpg';
					$imageData = $_POST['img'];
					$filteredData=substr($imageData, strpos($imageData, ",")+1);
					$unencodedData=base64_decode($filteredData);
					$fp = fopen($rmfile_path . '/pengkajian_awal_medik_kusta/' . $nama_file,'wb');
					fwrite($fp,$unencodedData);
					fclose($fp);	
					if(empty($_POST['idx_pam'])){
						mysql_query('INSERT INTO t_irna_pengkajian_awal_medis_kusta 
							(IRNA_ID,TANDA_PERUBAHAN_KULIT_SARAF)
							VALUES ("' . $_POST['irna_id'] . '","' . $nama_file . '")') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_irna_pengkajian_awal_medis_kusta
							SET TANDA_PERUBAHAN_KULIT_SARAF = "' . $nama_file . '"
							WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
					}
					echo 'ok';
				}else{
					echo 'Harus Oleh Dokter DPJP.';
				}		
			break;

			case 'batalbayarlainlain' :
				mysql_query('UPDATE db_simkeu.r_penerimaan_lainlain
					SET NO_PEMBAYARAN = NULL,
					REGISTER = "' . currentUser() . '",
					KODE_CASH = NULL,
					PERC_POTONGAN = 0,
					KODE_REKENING = NULL 
					WHERE PENERIMAAN_LAINLAIN_ID = "' . $_GET['idx'] . '"') or die(mysql_error());

			break;	
			
			case 'ctmptidurnew' :
			
			$sql_tmp_tidur = 'SELECT NO_TMP_TIDUR
							FROM m_ruang_detail
							WHERE RUANG_ID = "' . $_GET['ruang_id'] . '"
							AND (NO_TMP_TIDUR NOT IN (
								SELECT NO_TMP_TIDUR
								FROM t_irna
								WHERE NO_PENDAFTARAN IS NOT NULL
								AND ST_BATAL IS NULL
								AND PASIEN_MASUK IS NOT NULL
								AND ST_PULANG IS NULL
								AND RUANG_ID = "' . $_GET['ruang_id'] . '"
								)
								OR NO_TMP_TIDUR = "' . $_GET['no'] . '")	
							ORDER BY NO_TMP_TIDUR';
			$get_tmp_tidur = mysql_query($sql_tmp_tidur) or die(mysql_error());				
            ?>
            <select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
                <?php while($dat_tmp_tidur = mysql_fetch_array($get_tmp_tidur)){  ?>
					<option value="<?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?>" <?php if($dat_tmp_tidur['NO_TMP_TIDUR'] == $_GET['no']) echo 'selected'; ?> ><?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?></option>
				<?php }  ?>
            </select>
            <?php
            
			break;
			
			case 'ctmptidurnew_kamar' :
			
			$sql_tmp_tidur = 'SELECT NO_TMP_TIDUR
							FROM m_ruang_detail
							WHERE RUANG_ID = "' . $_GET['ruang_id'] . '"
							AND (NO_TMP_TIDUR NOT IN (
								SELECT NO_TMP_TIDUR
								FROM t_irna
								WHERE NO_PENDAFTARAN IS NOT NULL
								AND ST_BATAL IS NULL
								AND PASIEN_MASUK IS NOT NULL
								AND ST_PULANG IS NULL
								AND RUANG_ID = "' . $_GET['ruang_id'] . '"
								)
								OR NO_TMP_TIDUR = "' . $_GET['no'] . '")	
							ORDER BY NO_TMP_TIDUR';
			$get_tmp_tidur = mysql_query($sql_tmp_tidur) or die(mysql_error());				
            ?>
            <select name="tmp_tidur_new_kamar" id="tmp_tidur_new_kamar" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
                <?php while($dat_tmp_tidur = mysql_fetch_array($get_tmp_tidur)){  ?>
					<option value="<?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?>" <?php if($dat_tmp_tidur['NO_TMP_TIDUR'] == $_GET['no']) echo 'selected'; ?> ><?php echo $dat_tmp_tidur['NO_TMP_TIDUR']; ?></option>
				<?php }  ?>
            </select>
            <?php
            
			break;
			
			case 'laboratoriumformaddpemeriksaan' :
							
				$penunjang_id = $_GET['irna_id'];				
				$tarif_id = $_GET['tarif_id'];
				
				$get_tarif = mysql_query('SELECT DATE_FORMAT(TANGGAL_DAFTAR,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DAFTAR,
					JENIS_BAYAR_ID,ST_BAYAR,NO_TARIF,NO_SJP,NO_PEMBAYARAN
					FROM t_ipenunjang_tarif
					WHERE PENUNJANG_ID = "' . $penunjang_id . '"
					AND KUANTITI = 0') or die(mysql_error());
				$dat_tarif = mysql_fetch_assoc($get_tarif);
				$tanggal_daftar = $dat_tarif['TANGGAL_DAFTAR'];
				$jenis_bayar_id = $dat_tarif['JENIS_BAYAR_ID'];				
				$st_bayar = $dat_tarif['ST_BAYAR'];
				$nomor = $dat_tarif['NO_TARIF'];
				$no_sjp = $dat_tarif['NO_SJP'];
				$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
				
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,
						TANGGAL_DAFTAR,UNIT_PENUNJANG_ID,JENIS_BAYAR_ID,ST_BAYAR,NO_TARIF,
						NO_SJP,NO_PEMBAYARAN) 
						VALUES("' . $penunjang_id . '","' . $tarif_id . '",1,
						STR_TO_DATE("' . $tanggal_daftar . '","%d-%m-%Y %H:%i:%s"),"45",
						"' . $jenis_bayar_id . '","' . $st_bayar . '","' . $nomor . '",
						"' . $no_sjp . '","' . $no_bayar . '")') or die(mysql_error());
				
			
			echo 'ok';
			
			break;
			
			case 'ceklaboratoriumformaddpemeriksaan' :
				
				$penunjang_id = $_POST['xirna_id'];
				$tarif_id = $_POST['xtarif_id'];
				
				$sql_cek = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS JML
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $penunjang_id . '" 
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
							AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Bank Darah (Laboratorium)")
							AND t_ipenunjang_tarif.TARIF_ID = "' . $tarif_id . '"';			
				$get_cek = mysql_query($sql_cek) or die(mysql_error());
				$dat_cek = mysql_fetch_assoc($get_cek);
			
				echo $dat_cek['JML']; 	
				
			break;
			
			case 'simpancekfilterreportobat' :
				$arr_val = explode('|',$_GET['val']);
				$arr_tarif = explode('-',$arr_val[0]);
				$level = $arr_tarif[0];
				$kode_tarif = $arr_tarif[1];
				$filter_report = $arr_val[2];
				$report_id = $arr_val[1];	
				
				if($_GET['opt'] == 1){
					mysql_query('INSERT INTO t_filter_report_obat(KODE_GROUP,NAMA_FILTER,LEVEL_DT,REPORT_ID)
							VALUES("' . $kode_tarif . '","' . $filter_report . '","' . $level . '","' . $report_id . '")') or die(mysql_error());
				}
				
				if($_GET['opt'] == 2){
					mysql_query('DELETE FROM t_filter_report_obat WHERE KODE_GROUP = "' . $kode_tarif . '"
							AND NAMA_FILTER = "' . $filter_report . '"
							AND LEVEL_DT = "' . $level . '"
							AND REPORT_ID = "' . $report_id . '"') or die(mysql_error());
				}
				
			break;
			
			case 'batalirjaall' :
			
			$idx = $_GET['idx'];
			$st = $_GET['st'];
			
			$sql_tarif  = 'SELECT DISTINCT t_irja_tarif.NO_TARIF,t_irja_tarif.NO_TARIF_DAFTAR,
				DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_irja_tarif.ST_BAYAR,
				t_irja_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_irja_tarif 
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_jaminan ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" 
				AND t_irja_tarif.NO_TARIF IS NOT NULL
				AND t_irja_tarif.TGL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR)
				GROUP BY t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_irja_tarif.DESKRIPSI,t_irja_tarif.IRJA_ID,t_irja_tarif.NO_PEMBAYARAN,
				t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
				ORDER BY t_irja_tarif.TGL_TARIF';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());

			$sql_tarif_penunjang = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_ipenunjang 
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ"	
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL 
				AND t_ipenunjang_tarif.TANGGAL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR) 
				GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang = mysql_query($sql_tarif_penunjang) or die(mysql_error());

			$sql_tarif_operasi = 'SELECT DISTINCT t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				SUM(t_operasi_tarif.KUANTITI *(CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
				WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
				WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
				WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
				WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
				WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
				WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
				WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END)) AS HARGA,t_operasi_tarif.ST_BAYAR,
				t_operasi_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_operasi_tarif.KELAS_RAWAT,
				t_operasi_tarif.KELAS_JAMINAN,t_operasi.OPERASI_ID
				FROM t_operasi_tarif 
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '" 
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1") 
				AND t_operasi_tarif.TGL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR) 
				GROUP BY t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_operasi_tarif.DESKRIPSI,t_operasi_tarif.OPERASI_ID,t_operasi_tarif.NO_PEMBAYARAN,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.USER_KASIR
				ORDER BY t_operasi_tarif.TGL_TARIF';
			$get_tarif_operasi = mysql_query($sql_tarif_operasi) or die(mysql_error());	

			$sql_tarif_hemodialisa = 'SELECT DISTINCT t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_hemodialisa_tarif.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				SUM(t_hemodialisa_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_hemodialisa_tarif.ST_BAYAR,
				t_hemodialisa_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_hemodialisa 
				INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "IRJ"	
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa.ST_BATAL IS NULL 
				AND t_hemodialisa_tarif.TGL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR) 
				GROUP BY t_hemodialisa_tarif.NO_TARIF,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),
				t_hemodialisa.DESKRIPSI,t_hemodialisa.RAWAT_ID,t_hemodialisa_tarif.NO_PEMBAYARAN,
				t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR
				ORDER BY t_hemodialisa.TANGGAL_ORDER';
			$get_tarif_hemodialisa = mysql_query($sql_tarif_hemodialisa) or die(mysql_error());	
				
			$sql_tarif_penunjang_hemodialisa = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENUNJANG_ID,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN,t_ipenunjang.JNS_ORDER
				FROM t_ipenunjang 
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND (t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL 
				AND t_ipenunjang_tarif.TANGGAL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR) 
				GROUP BY t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),
				t_ipenunjang.DESKRIPSI,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_PEMBAYARAN,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang_tarif.USER_KASIR
				ORDER BY t_ipenunjang_tarif.TANGGAL_DAFTAR';
			$get_tarif_penunjang_hemodialisa = mysql_query($sql_tarif_penunjang_hemodialisa) or die(mysql_error());

			$sql_ambulance  = 'SELECT DISTINCT t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
				SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS HARGA,t_ambulance_tarif.ST_BAYAR,
				t_ambulance_tarif.USER_KASIR,m_jaminan.NAMA_JAMINAN
				FROM t_ambulance_tarif 
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_jaminan ON (t_ambulance_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.JNS_ORDER = "IRJ"
				AND t_ambulance_tarif.NO_TARIF IS NOT NULL 
				AND t_ambulance_tarif.TGL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR) 
				GROUP BY t_ambulance_tarif.NO_TARIF,DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d/%m/%Y"),
				t_ambulance_tarif.GMAP_DIRECTION,t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_PEMBAYARAN,
				t_ambulance_tarif.ST_BAYAR,t_ambulance_tarif.USER_KASIR
				ORDER BY t_ambulance_tarif.TGL_TARIF';
			$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());	
			
					
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$status = $dat_tarif['ST_BAYAR'];
				$no_bayar = $dat_tarif['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){
						mysql_query('UPDATE t_irja_tarif 
							SET NO_PEMBAYARAN = NULL,
							TGL_BAYAR = NULL,
							ST_BAYAR = NULL,
							SHIFT_ID = NULL,
							USER_KASIR = "' . currentUser() . '",
							KODE_CASH = NULL,
							PERC_POTONGAN = 0,
							KODE_REKENING = NULL,
							ST_BATAL = "' . $st . '"		
							WHERE IRJA_ID = "' . $idx . '" 
							AND NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_tarif_penunjang = mysql_fetch_array($get_tarif_penunjang)){
				$status = $dat_tarif_penunjang['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){ 
						mysql_query('UPDATE t_ipenunjang_tarif 
							SET NO_PEMBAYARAN = NULL,
							TANGGAL_BAYAR = NULL,
							ST_BAYAR = NULL,
							SHIFT_KASIR = NULL,
							USER_KASIR = "' . currentUser() . '",
							KODE_CASH = NULL,
							PERC_POTONGAN = 0,
							KODE_REKENING = NULL,
							ST_BATAL_BAYAR = "' . $st . '"	 	
							WHERE PENUNJANG_ID = "' . $dat_tarif_penunjang['PENUNJANG_ID'] . '" 
							AND NO_TARIF = "' . $dat_tarif_penunjang['NO_TARIF'] . '"') or die(mysql_error());
					} 
				}
			}
	
			//operasi
			while($dat_tarif_operasi = mysql_fetch_array($get_tarif_operasi)){
				$status = $dat_tarif_operasi['ST_BAYAR'];
				$no_bayar = $dat_tarif_operasi['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){ 
						mysql_query('UPDATE t_operasi_tarif 
							SET NO_PEMBAYARAN = NULL,
							TGL_BAYAR = NULL,
							ST_BAYAR = NULL,
							SHIFT_ID = NULL,
							USER_KASIR = "' . currentUser() . '" ,
							KODE_CASH = NULL,
							PERC_POTONGAN = 0,
							KODE_REKENING = NULL,
							ST_BATAL_BAYAR = "' . $st . '"		
							WHERE OPERASI_ID = "' . $dat_tarif_operasi['OPERASI_ID'] . '" 
							AND NO_TARIF = "' . $dat_tarif_operasi['NO_TARIF'] . '"') or die(mysql_error());
					}
				}
			}	
			//end operasi
				
			//hemodialisa
			while($dat_tarif_hemodialisa = mysql_fetch_array($get_tarif_hemodialisa)){
				$status = $dat_tarif_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_hemodialisa['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){
						mysql_query('UPDATE t_hemodialisa_tarif 
								INNER JOIN t_hemodialisa 
								ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
								SET NO_PEMBAYARAN = NULL,
								TGL_BAYAR = NULL,
								ST_BAYAR = NULL,
								SHIFT_KASIR = NULL,
								USER_KASIR = "' . currentUser() . '",
								KODE_CASH = NULL,
								PERC_POTONGAN = 0,
								KODE_REKENING = NULL,
								ST_BATAL_BAYAR = "' . $st . '"		
								WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" 
								AND t_hemodialisa.JNS_ORDER = "IRJ" 
								AND t_hemodialisa_tarif.NO_TARIF = "' . $dat_tarif_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());	
						}
					}	
				}
	
			while($dat_tarif_penunjang_hemodialisa = mysql_fetch_array($get_tarif_penunjang_hemodialisa)){
				$status = $dat_tarif_penunjang_hemodialisa['ST_BAYAR'];
				$no_bayar = $dat_tarif_penunjang_hemodialisa['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){
							mysql_query('UPDATE t_ipenunjang_tarif 
								SET NO_PEMBAYARAN = NULL,
								TANGGAL_BAYAR = NULL,
								ST_BAYAR = NULL,
								SHIFT_KASIR = NULL,
								USER_KASIR = "' . currentUser() . '",
								KODE_CASH = NULL,
								PERC_POTONGAN = 0,
								KODE_REKENING = NULL,
								ST_BATAL_BAYAR = "' . $st . '"	 	
								WHERE PENUNJANG_ID = "' . $dat_tarif_penunjang_hemodialisa['PENUNJANG_ID'] . '" 
								AND NO_TARIF = "' . $dat_tarif_penunjang_hemodialisa['NO_TARIF'] . '"') or die(mysql_error());
					} 
				} 
			}

			while($dat_ambulance = mysql_fetch_array($get_ambulance)){
				$status = $dat_ambulance['ST_BAYAR'];
				$no_bayar = $dat_ambulance['NO_PEMBAYARAN'];
				if($status == 'Lunas'){ 
					if($no_bayar != ''){ 
						mysql_query('UPDATE t_ambulance_tarif 
							SET NO_PEMBAYARAN = NULL,
							TGL_BAYAR = NULL,
							ST_BAYAR = NULL,
							SHIFT_ID = NULL,
							USER_KASIR = "' . currentUser() . '",
							KODE_CASH = NULL,
							PERC_POTONGAN = 0,
							KODE_REKENING = NULL,
							ST_BATAL = "' . $st . '"
							WHERE RAWAT_ID = "' . $idx . '" 
							AND JNS_ORDER = "IRJ"
							AND NO_TARIF = "' . $dat_ambulance['NO_TARIF'] . '"') or die(mysql_error());
					} 
				} 
			}

			$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
			mysql_select_db($database_3, $connect_3) or die(mysql_error());

			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
					FROM t_farmasi_apotik_pengeluaran
					INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
					AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
					AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
					INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL 
					AND t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR)
					GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
					t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
					t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
					t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
					ORDER BY t_rajal_resep.NO_RESEP';	
			$get_resep = mysql_query($sql_resep) or die(mysql_error());	
			while($dat_resep = mysql_fetch_array($get_resep)){
				$no_resep = $dat_resep['NO_RESEP'];
				$status = $dat_resep['ST_BATAL'];
				$no_bayar = $dat_resep['NO_PEMBAYARAN'];
				if($status != '1' and $no_bayar != ''){
					mysql_query('UPDATE t_farmasi_apotik_pengeluaran 
						SET USER_PEMBAYARAN = "' . currentUser() . '",
						SHIFT_PEMBAYARAN = NULL,
						NO_PEMBAYARAN = NULL,
						TANGGAL_BAYAR = NULL,
						KODE_CASH = NULL,
						PERC_POTONGAN = 0,
						KODE_REKENING = NULL,
						ST_BATAL_BAYAR = "' . $st. '" 	
						WHERE FARMASI_PENGELUARAN_APOTIK_ID = "' . $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID'] . '" 
						AND NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
				}
			}	
	
			//farmasi hemodialisa
			$sql_resep  = 'SELECT DISTINCT t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN,m_jaminan.NAMA_JAMINAN
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN m_persediaan_farmasi_detail ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID = m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
				AND (t_farmasi_apotik_pengeluaran_detail.KODE_PRODUKSI = m_persediaan_farmasi_detail.KODE_PRODUKSI)
				INNER JOIN m_persediaan_farmasi ON (m_persediaan_farmasi_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
				AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
				AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL 
				AND t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR > DATE_ADD(NOW(), INTERVAL -1 HOUR)
				GROUP BY t_rajal_resep.RAJAL_ID,t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.NO_RESEP,t_farmasi_apotik_pengeluaran.ST_BATAL,
				t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN,t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN
				ORDER BY t_rajal_resep.NO_RESEP';	
				$get_resep = mysql_query($sql_resep) or die(mysql_error());	
				while($dat_resep = mysql_fetch_array($get_resep)){
					$no_resep = $dat_resep['NO_RESEP'];
					$status = $dat_resep['ST_BATAL'];
					$no_bayar = $dat_resep['NO_PEMBAYARAN'];
					if($status != '1' and $no_bayar != ''){
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran 
							SET USER_PEMBAYARAN = "' . currentUser() . '",
							SHIFT_PEMBAYARAN = NULL,
							NO_PEMBAYARAN = NULL,
							TANGGAL_BAYAR = NULL,
							KODE_CASH = NULL,
							PERC_POTONGAN = 0,
							KODE_REKENING = NULL,
							ST_BATAL_BAYAR = "' . $st. '" 	
							WHERE FARMASI_PENGELUARAN_APOTIK_ID = "' . $dat_resep['FARMASI_PENGELUARAN_APOTIK_ID'] . '" 
							AND NO_PENGELUARAN = "' . $dat_resep['NO_PENGELUARAN'] . '"') or die(mysql_error());
					}	
				}	
			//
		break;
	}
}
?>