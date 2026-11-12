<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 1.1</h3></div>
<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 1.1</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>DATA DASAR RUMAH SAKIT</h1></td></tr>
			</table>
			<?php
			
			if(isset($_POST['submit']))
			{
				
				$sqlview	 = 'select * from data_dasar where tahun = '.$_POST['tahun'];
				$query		 = mysql_query($sqlview);
				if(mysql_num_rows($query) > 0)
				{
						echo $sql	= 'update data_dasar 
								nomor_kode_rs = '.$_POST['no_kode_rs'].',  tanggal_registrasi = '.$_POST['tanggal_registrasi'].',  nama_rumah_sakit = '.$_POST['nama_rumah_sakit'].', jenis_rumah_sakit = '.$_POST['jenis_rs'].', kelas_rumah_sakit = '.$_POST['kelas_rs'].', 
								nama_direktur_rs = '.$_POST['nama_direktur'].', nama_penyelenggara_rs = '.$_POST['nama_penyelenggara'].',  kab_kota = '.$_POST['kab_kota'].',  kode_pos = '.$_POST['kode_pos'].',  telepon = '.$_POST['telepon'].',  fax = '.$_POST['fax'].', 
								email = '.$_POST['email'].', nomor_telp_bag_umum = '.$_POST['telp_humas'].',  website = '.$_POST['website'].',  tanah = '.$_POST['tanah'].',  bangunan = '.$_POST['bangunan'].',  nomor = '.$_POST['nomor'].',  tanggal = '.$_POST['tanggal'].', 
								oleh = '.$_POST['oleh'].',  sifat = '.$_POST['sifat'].',  masa_berlaku_thn = '.$_POST['masa_berlaku'].',  status_penyelenggara_swasta = '.$_POST['status_penyelenggara_swasta'].',  akreditasi_rs = '.$_POST['akreditasi'].',  pentahapan = '.$_POST['pentahapan_akreditasi'].',  status = '.$_POST['status_akreditasi'].', 
								tanggal_akreditasi = '.$_POST['tanggal_akreditasi'].',  vvip = '.$_POST['vvip'].',  vip = '.$_POST['vip'].',  i = '.$_POST['i'].',  ii = '.$_POST['ii'].',  iii = '.$_POST['iii'].', 
								dokter_spa = '.$_POST['dr_spa'].',  dokter_spog = '.$_POST['dr_spog'].',  dokter_sppd = '.$_POST['dr_sppd'].',  dokter_spb = '.$_POST['dr_spb'].',  dokter_sprad = '.$_POST['dr_sprad'].',  dokter_sprm = '.$_POST['dr_sprm'].',  dokter_span = '.$_POST['dr_span'].', 
								dokter_spjp = '.$_POST['dr_spjp'].',  dokter_spm = '.$_POST['dr_spm'].',  dokter_sptht = '.$_POST['dr_sptht'].',  dokter_spkj = '.$_POST['dr_spjk'].',  dokter_umum = '.$_POST['dr_umum'].', 
								dokter_gigi = '.$_POST['dr_gigi'].',  dokter_gigi_spesialis = '.$_POST['dr_gigisp'].',  perawat = '.$_POST['perawat'].',  bidan = '.$_POST['bidan'].',  farmasi = '.$_POST['farmasi'].', 
								tenaga_kesehatan_lainnya = '.$_POST['tenaga_kesehatan_lain'].',  tenaga_non_kesehatan = '.$_POST['tenaga_non_kesehatan'].' where tahun = '.$_POST['tahun'];
				}else{
						echo $sql	= 'insert into data_dasar (nomor_kode_rs,tanggal_registrasi,nama_rumah_sakit,jenis_rumah_sakit, kelas_rumah_sakit, nama_direktur_rs, nama_penyelenggara_rs, kab_kota, kode_pos, telepon,
												fax, email, nomor_telp_bag_umum, website, tanah, bangunan, nomor, tanggal, oleh, sifat, masa_berlaku_thn, status_penyelenggara_swasta, akreditasi_rs, pentahapan, status,
												tanggal_akreditasi, vvip, vip, i, ii, iii, dokter_spa, dokter_spog, dokter_sppd, dokter_spb, dokter_sprad, dokter_sprm, dokter_span, dokter_spjp, dokter_spm, dokter_sptht, 
												dokter_spkj, dokter_umum, dokter_gigi, dokter_gigi_spesialis, perawat, bidan, farmasi, tenaga_kesehatan_lainnya, tenaga_non_kesehatan,tahun)
									values("'.$_POST['no_kode_rs'].'","'.$_POST['tanggal_registrasi'].'","'.$_POST['nama_rumah_sakit'].'","'.$_POST['jenis_rs'].'","'.$_POST['kelas_rs'].'","'.$_POST['nama_direktur'].'","'.$_POST['nama_penyelenggara'].'",
											"'.$_POST['kab_kota'].'","'.$_POST['kode_pos'].'","'.$_POST['telepon'].'","'.$_POST['fax'].'","'.$_POST['email'].'","'.$_POST['telp_humas'].'","'.$_POST['website'].'",
											"'.$_POST['tanah'].'","'.$_POST['bangunan'].'","'.$_POST['nomor'].'","'.$_POST['tanggal'].'","'.$_POST['oleh'].'","'.$_POST['sifat'].'","'.$_POST['masa_berlaku'].'",
											"'.$_POST['status_penyelenggara_swasta'].'","'.$_POST['akreditasi'].'","'.$_POST['pentahapan_akreditasi'].'","'.$_POST['status_akreditasi'].'","'.$_POST['tanggal_akreditasi'].'","'.$_POST['vvip'].'","'.$_POST['vip'].'",
											"'.$_POST['i'].'","'.$_POST['ii'].'","'.$_POST['iii'].'","'.$_POST['dr_spa'].'","'.$_POST['dr_spog'].'","'.$_POST['dr_sppd'].'","'.$_POST['dr_spb'].'",
											"'.$_POST['dr_sprad'].'","'.$_POST['dr_sprm'].'","'.$_POST['dr_span'].'","'.$_POST['dr_spjp'].'","'.$_POST['dr_spm'].'","'.$_POST['dr_sptht'].'","'.$_POST['dr_spjk'].'",
											"'.$_POST['dr_umum'].'","'.$_POST['dr_gigi'].'","'.$_POST['dr_gigisp'].'","'.$_POST['perawat'].'","'.$_POST['bidan'].'","'.$_POST['farmasi'].'","'.$_POST['tenaga_kesehatan_lain'].'",
											"'.$_POST['tenaga_non_kesehatan'].'","'.$_POST['tahun'].'")';
				}
				$query_simpan	= mysql_query($sql);
				
			}
			$viewtahun		  = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
			$sql_showing = "select * from data_dasar where tahun = '".$viewtahun."'";
			$sql_show	 = mysql_query($sql_showing);
			
			?>
		
			<form method="post" action="index.php?link=rl11">
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td width="20%"><strong><h2>TAHUN</h2></strong></td><td>
					<select name="tahun">
						<?php
						$sqltahun	= mysql_query('select min(tahun) as startTahun from data_dasar');
						if(mysql_num_rows($sqltahun) > 0)
						{
							$data = mysql_fetch_array($sqltahun);
							$startTahun	= $data['startTahun'];
						}else{
							$startTahun	= date('Y');
						}
						
						for($i=$startTahun; $i<=date('Y'); $i++)
						{
							echo '<option value="'.$i.'"> '.$i.' </option>';
						}
						?>
						
					</select>
				</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2"><h2>RL 1.1 Data Dasar Rumah Sakit</h2></td></tr>
			</table>
			
			
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			  <tr><td>1.</td><td>Nomor Kode RS</td><td>: <input type="text" name="no_kode_rs" class="inputrl11"></td></tr>
			  <tr><td>2.</td><td>Tanggal Registrasi</td><td>: <input type="text" name="tanggal_registrasi" class="inputrl11"></td></tr>
			  <tr><td>3.</td><td>Nama Rumah Sakit</td><td>: <input type="text" name="nama_rumah_sakit" class="inputrl11"></td></tr>
			  <tr><td>4.</td><td>Jenis Rumah Sakit</td><td>: <select name="jenis_rs" id="jenis_rs" class="selectbox">
              													<option value=""> -- Jenis Rumah Sakit --</option>
																<?php
																$query_jenis	= mysql_query('select * from jenis_rumahsakit');
																if(mysql_num_rows($query_jenis) > 0)
																{
																	while($data = mysql_fetch_array($query_jenis)){
																		echo '<option value="'.$data['id'].'"> '.$data['jenis'].' ( '.$data['uraian'].') </option>';
																	}
																}
																?>
              												 </select></td></tr>
			  <tr><td>5.</td><td>Kelas Rumah Sakit</td><td>: <select name="kelas_rs" id="kelas_rs" class="selectbox">
              													<option value=""> -- Kelas Rumah Sakit -- </option>
                                                                <?php
																$query_kelas	= mysql_query('select * from kelas');
																if(mysql_num_rows($query_kelas) > 0)
																{
																	while($data = mysql_fetch_array($query_kelas)){
																		echo '<option value="'.$data['id'].'"> '.$data['kepemilikan'].' ( '.$data['kelas'].' ) </option>';
																	}
																}
																?>
              												 </select></td></tr>
			  <tr><td>6.</td><td>Nama Direktur RS</td><td>: <input type="text" name="nama_direktur" class="inputrl11"></td></tr>
			  <tr><td>7.</td><td>Nama Penyelenggara RS</td><td>: <input type="text" name="nama_penyelenggara" class="inputrl11"></td></tr>
			  <tr><td>8.</td><td>Alamat / Lokasi RS</td><td></td></tr>
			  <tr><td></td><td>8.1 Kab / Kota</td><td>: <input type="text" name="kab_kota" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.2 Kode Pos</td><td>: <input type="text" name="kode_pos" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.3 Telepon</td><td>: <input type="text" name="telepon" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.4 Fax</td><td>: <input type="text" name="fax" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.5 Email</td><td>: <input type="text" name="email" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.6 No Telp Bag. Umum / Humas RS</td><td>: <input type="text" name="telp_humas" class="inputrl11"></td></tr>
			  <tr><td></td><td>8.7 Website</td><td>: <input type="text" name="website" class="inputrl11"></td></tr>
			  <tr><td>9.</td><td>Luas Rumah Sakit</td><td></td></tr>
			  <tr><td></td><td>9.1 Tanah</td><td>: <input type="text" name="tanah" class="inputrl11"></td></tr>
			  <tr><td></td><td>9.2 Bangunan</td><td>: <input type="text" name="bangunan" class="inputrl11"></td></tr>
			  <tr><td>10.</td><td>Surat Izin Penetapan</td><td></td></tr>
			  <tr><td></td><td>10.1 Nomor</td><td>: <input type="text" name="nomor" class="inputrl11"></td></tr>
			  <tr><td></td><td>10.2 Tanggal</td><td>: <input type="text" name="tanggal" class="inputrl11"></td></tr>
			  <tr><td></td><td>10.3 Oleh</td><td>: <input type="text" name="oleh" class="inputrl11"></td></tr>
			  <tr><td></td><td>10.4 Sifat</td><td>: <input type="text" name="sifat" class="inputrl11"></td></tr>
			  <tr><td></td><td>10.5 Masa Berlaku s/d thn</td><td>: <input type="text" name="masa_berlaku" class="inputrl11"></td></tr>
			  <tr><td>11.</td><td>Status Penyelnggara Swasta</td><td>: <select name="status_penyelenggara_swasta" id="status_penyelenggara_swasta" class="selectbox">
              <option value=""> -- Status Penyelenggara -- </option>
               <?php
				$query_penyelenggara	= mysql_query('select * from penyelenggara_swasta');
				if(mysql_num_rows($query_penyelenggara) > 0)
				{
					while($data = mysql_fetch_array($query_penyelenggara)){
						echo '<option value="'.$data['id'].'"> '.$data['nama'].'</option>';
					}
				}
				?>
              </select></td></tr>
			  <tr><td>12.</td><td>Akreditasi RS</td><td>: <select name="akreditasi" id="akreditasi" class="selectbox">
              												<option value=""> -- Akreditasi RS -- </option>
                                                            <option value="sudah"> Sudah </option>
                                                            <option value="belum"> Belum </option>
              											</select></td></tr>
			  <tr><td></td><td>12.1 Pentahapan</td><td>: <select name="pentahapan_akreditasi" id="pentahapan_akreditasi" class="selectbox">
              												<option value=""> -- Pentahapan Akreditasi -- </option>
                                                            <?php
															$query_tahapan	= mysql_query('select * from pentahapan_akreditasi');
															if(mysql_num_rows($query_tahapan) > 0)
															{
																while($data = mysql_fetch_array($query_tahapan)){
																	echo '<option value="'.$data['id'].'"> '.$data['pentahapan'].'</option>';
																}
															}
															?>
              											</select></td></tr>
			  <tr><td></td><td>12.2 Status</td><td>: <select name="status_akreditasi" id="status_akreditasi" class="selectbox">
															<option value=""> -- Status Akreditasi -- </option>
              												 <?php
															$query_status	= mysql_query('select * from status_akreditasi');
															if(mysql_num_rows($query_status) > 0)
															{
																while($data = mysql_fetch_array($query_status)){
																	echo '<option value="'.$data['id'].'"> '.$data['status'].'</option>';
																}
															}
															?>
              											</select></td></tr>
			  <tr><td></td><td>12.3 Tanggal Akreditasi</td><td>: <input type="text" name="tanggal_akreditasi" class="inputrl11"></td></tr>
			  <tr><td>13.</td><td>Tempat Tidur</td><td></td></tr>
			  <tr><td></td><td>13.1 VVIP</td><td>: <input type="text" name="vvip" class="inputrl11"></td></tr>
			  <tr><td></td><td>13.2 VIP</td><td>: <input type="text" name="vip" class="inputrl11"></td></tr>
			  <tr><td></td><td>13.3 I</td><td>: <input type="text" name="i" class="inputrl11"></td></tr>
			  <tr><td></td><td>13.4 II</td><td>: <input type="text" name="ii" class="inputrl11"></td></tr>
			  <tr><td></td><td>13.5 III</td><td>: <input type="text" name="iii" class="inputrl11"></td></tr>
			  <tr><td>14.</td><td>Tenaga Medis</td><td></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.A</td><td>: <input type="text" name="dr_spa" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.OG</td><td>: <input type="text" name="dr_spog" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.Pd</td><td>: <input type="text" name="dr_sppd" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.B</td><td>: <input type="text" name="dr_spb" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.Rad</td><td>: <input type="text" name="dr_sprad" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.RM</td><td>: <input type="text" name="dr_sprm" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.An</td><td>: <input type="text" name="dr_span" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.Jp</td><td>: <input type="text" name="dr_spjp" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.M</td><td>: <input type="text" name="dr_spm" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.THT</td><td>: <input type="text" name="dr_sptht" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Sp.Kj</td><td>: <input type="text" name="dr_spkj" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Umum</td><td>: <input type="text" name="dr_umum" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Gigi</td><td>: <input type="text" name="dr_gigi" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Dokter Gigi Spesialis</td><td>: <input type="text" name="dr_igisp" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Perawat</td><td>: <input type="text" name="perawat" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Bidan</td><td>: <input type="text" name="bidan" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Farmasi</td><td>: <input type="text" name="farmasi" class="inputrl11"></td></tr>
			  <tr><td></td><td>14.1 Tenaga Kesehatan Lainnya</td><td>: <input type="text" name="tenaga_kesehatan_lain" class="inputrl11"></td></tr>
			  <tr><td>15.</td><td>Tenaga Non Kesehatan</td><td>: <input type="text" name="tenaga_non_kesehatan" class="inputrl11"></td></tr>
			  <tr><td colspan="3"> <input type="submit" name="submit" value="Simpan"></td></tr>
			</table>
				
			</form>
			<form action="rm/rl11_xls.php" method="get">
				<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
				<input type="submit" value="export xls"  />
			</form>
        </td>
		
    </tr>
</table>
</div>
</div>