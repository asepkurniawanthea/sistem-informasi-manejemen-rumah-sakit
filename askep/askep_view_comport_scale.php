<?php
$irna_id = $_GET['idx'];

$sql_comport = 'SELECT t_irna_askep_comport_scale.COMPORT_SCALE_ID,
			  t_irna_askep_comport_scale.KEWASPADAAN,
			  t_irna_askep_comport_scale.KETENANGAN,
			  t_irna_askep_comport_scale.DISTRES_PERNAPASAN,
			  t_irna_askep_comport_scale.MENANGIS,
			  t_irna_askep_comport_scale.PERGERAKAN,
			  t_irna_askep_comport_scale.TONUS_OTOT,
			  t_irna_askep_comport_scale.TEGANGAN_WAJAH,
			  t_irna_askep_comport_scale.TEKANAN_DARAH_BASAH,
			  t_irna_askep_comport_scale.TANGGAL,
			  t_irna_askep_comport_scale.PERAWAT,
			  t_irna_askep_comport_scale.USER_ASKEP
			FROM t_irna_askep_comport_scale
			WHERE t_irna_askep_comport_scale.COMPORT_SCALE_ID = "' . $_GET['idx'] . '"';
$get_comport = mysql_query($sql_comport) or die(mysql_error());
$dat_comport = mysql_fetch_array($get_comport);

$comport_scale_id = $dat_comport['COMPORT_SCALE_ID'];
$kewaspadaan = explode('|',$dat_comport['KEWASPADAAN']);
$ketenangan = explode('|',$dat_comport['KETENANGAN']);
$distres_pernapasan = explode('|',$dat_comport['DISTRES_PERNAPASAN']);
$menangis = explode('|',$dat_comport['MENANGIS']);
$pergerakan = explode('|',$dat_comport['PERGERAKAN']);
$tonus_otot = explode('|',$dat_comport['TONUS_OTOT']);
$tegangan_wajah = explode('|',$dat_comport['TEGANGAN_WAJAH']);
$tekanan_darah_basah = explode('|',$dat_comport['TEKANAN_DARAH_BASAH']);
$tanggal = explode('|',$dat_comport['TANGGAL']);
$perawat = explode('|',$dat_comport['PERAWAT']);
?>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="comport_scale_id" value="<?php echo $comport_scale_id; ?>" />
	<table align="center" width="80%" class="tableData">
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Kategori</th>
			<th>Skala</th>		
			<th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		    <th width="130px">Skor</th>
		</tr>		
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">KEWASPADAAN</td>			
			<td>1. Tidur pulas</td>
		    <td align="center"><input type="radio" name="kewaspadaan_1" value="1" <?php if(isset($kewaspadaan[0]) and $kewaspadaan[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_2" value="1" <?php if(isset($kewaspadaan[1]) and $kewaspadaan[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_3" value="1" <?php if(isset($kewaspadaan[2]) and $kewaspadaan[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_4" value="1" <?php if(isset($kewaspadaan[3]) and $kewaspadaan[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_5" value="1" <?php if(isset($kewaspadaan[4]) and $kewaspadaan[4] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>2. Tidur kurang nyenyak</td>		
		    <td align="center"><input type="radio" name="kewaspadaan_1" value="2" <?php if(isset($kewaspadaan[0]) and $kewaspadaan[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_2" value="2" <?php if(isset($kewaspadaan[1]) and $kewaspadaan[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_3" value="2" <?php if(isset($kewaspadaan[2]) and $kewaspadaan[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_4" value="2" <?php if(isset($kewaspadaan[3]) and $kewaspadaan[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_5" value="2" <?php if(isset($kewaspadaan[4]) and $kewaspadaan[4] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>3. Gelisah</td>		
		    <td align="center"><input type="radio" name="kewaspadaan_1" value="3" <?php if(isset($kewaspadaan[0]) and $kewaspadaan[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_2" value="3" <?php if(isset($kewaspadaan[1]) and $kewaspadaan[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_3" value="3" <?php if(isset($kewaspadaan[2]) and $kewaspadaan[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_4" value="3" <?php if(isset($kewaspadaan[3]) and $kewaspadaan[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_5" value="3" <?php if(isset($kewaspadaan[4]) and $kewaspadaan[4] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>	
		<tr>			
			<td>4. Sadar sepenuhnya dan waspada</td>		
		    <td align="center"><input type="radio" name="kewaspadaan_1" value="4" <?php if(isset($kewaspadaan[0]) and $kewaspadaan[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_2" value="4" <?php if(isset($kewaspadaan[1]) and $kewaspadaan[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_3" value="4" <?php if(isset($kewaspadaan[2]) and $kewaspadaan[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_4" value="4" <?php if(isset($kewaspadaan[3]) and $kewaspadaan[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_5" value="4" <?php if(isset($kewaspadaan[4]) and $kewaspadaan[4] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>5. Hiper alert</td>		
		    <td align="center"><input type="radio" name="kewaspadaan_1" value="5" <?php if(isset($kewaspadaan[0]) and $kewaspadaan[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_2" value="5" <?php if(isset($kewaspadaan[1]) and $kewaspadaan[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_3" value="5" <?php if(isset($kewaspadaan[2]) and $kewaspadaan[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_4" value="5" <?php if(isset($kewaspadaan[3]) and $kewaspadaan[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="kewaspadaan_5" value="5" <?php if(isset($kewaspadaan[4]) and $kewaspadaan[4] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>	
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">KETENANGAN</td>			
			<td>1. Tenang</td>
		    <td align="center"><input type="radio" name="ketenangan_1" value="1" <?php if(isset($ketenangan[0]) and $ketenangan[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_2" value="1" <?php if(isset($ketenangan[1]) and $ketenangan[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_3" value="1" <?php if(isset($ketenangan[2]) and $ketenangan[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_4" value="1" <?php if(isset($ketenangan[3]) and $ketenangan[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_5" value="1" <?php if(isset($ketenangan[4]) and $ketenangan[4] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Agak cemas</td>
		    <td align="center"><input type="radio" name="ketenangan_1" value="2" <?php if(isset($ketenangan[0]) and $ketenangan[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_2" value="2" <?php if(isset($ketenangan[1]) and $ketenangan[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_3" value="2" <?php if(isset($ketenangan[2]) and $ketenangan[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_4" value="2" <?php if(isset($ketenangan[3]) and $ketenangan[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_5" value="2" <?php if(isset($ketenangan[4]) and $ketenangan[4] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>3. Cemas</td>
		    <td align="center"><input type="radio" name="ketenangan_1" value="3" <?php if(isset($ketenangan[0]) and $ketenangan[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_2" value="3" <?php if(isset($ketenangan[1]) and $ketenangan[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_3" value="3" <?php if(isset($ketenangan[2]) and $ketenangan[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_4" value="3" <?php if(isset($ketenangan[3]) and $ketenangan[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_5" value="3" <?php if(isset($ketenangan[4]) and $ketenangan[4] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>4. Sangat cemas</td>
		    <td align="center"><input type="radio" name="ketenangan_1" value="4" <?php if(isset($ketenangan[0]) and $ketenangan[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_2" value="4" <?php if(isset($ketenangan[1]) and $ketenangan[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_3" value="4" <?php if(isset($ketenangan[2]) and $ketenangan[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_4" value="4" <?php if(isset($ketenangan[3]) and $ketenangan[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_5" value="4" <?php if(isset($ketenangan[4]) and $ketenangan[4] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>5. Panik</td>
		    <td align="center"><input type="radio" name="ketenangan_1" value="5" <?php if(isset($ketenangan[0]) and $ketenangan[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_2" value="5" <?php if(isset($ketenangan[1]) and $ketenangan[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_3" value="5" <?php if(isset($ketenangan[2]) and $ketenangan[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_4" value="5" <?php if(isset($ketenangan[3]) and $ketenangan[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="ketenangan_5" value="5" <?php if(isset($ketenangan[4]) and $ketenangan[4] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">DISTRES PERNAPASAN</td>
			<td>1. Tidak ada respirasi spontan dan tidak ada batuk</td>
		    <td align="center"><input type="radio" name="distres_pernapasan_1" value="1" <?php if(isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_2" value="1" <?php if(isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_3" value="1" <?php if(isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_4" value="1" <?php if(isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_5" value="1" <?php if(isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Respirasi spontan dengan sedikit/ tidak ada respon terhadap ventilasi</td>
		    <td align="center"><input type="radio" name="distres_pernapasan_1" value="2" <?php if(isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_2" value="2" <?php if(isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_3" value="2" <?php if(isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_4" value="2" <?php if(isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_5" value="2" <?php if(isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>3. Kadang-kadang batuk atau terdapat tahanan terhadap ventilasi</td>
		    <td align="center"><input type="radio" name="distres_pernapasan_1" value="3" <?php if(isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_2" value="3" <?php if(isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_3" value="3" <?php if(isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_4" value="3" <?php if(isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_5" value="3" <?php if(isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>4. Sering batuk, terdapat tahanan/ perlawanan terhadap ventilator</td>
		    <td align="center"><input type="radio" name="distres_pernapasan_1" value="4" <?php if(isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_2" value="4" <?php if(isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_3" value="4" <?php if(isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_4" value="4" <?php if(isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_5" value="4" <?php if(isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>5. Melawan secara aktif terhadap ventilator, batuk terus menerus/ tersedak</td>
		    <td align="center"><input type="radio" name="distres_pernapasan_1" value="5" <?php if(isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_2" value="5" <?php if(isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_3" value="5" <?php if(isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_4" value="5" <?php if(isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="distres_pernapasan_5" value="5" <?php if(isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">MENANGIS</td>
			<td>1. Bernapas dengan tenang</td>
		    <td align="center"><input type="radio" name="menangis_1" value="1" <?php if(isset($menangis[0]) and $menangis[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="1" <?php if(isset($menangis[1]) and $menangis[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="1" <?php if(isset($menangis[2]) and $menangis[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="1" <?php if(isset($menangis[3]) and $menangis[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="1" <?php if(isset($menangis[4]) and $menangis[4] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>	
		<tr>
			<td>2. Terisak-isak</td>
		    <td align="center"><input type="radio" name="menangis_1" value="2" <?php if(isset($menangis[0]) and $menangis[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="2" <?php if(isset($menangis[1]) and $menangis[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="2" <?php if(isset($menangis[2]) and $menangis[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="2" <?php if(isset($menangis[3]) and $menangis[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="2" <?php if(isset($menangis[4]) and $menangis[4] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>	
		<tr>
			<td>3. Meraung</td>
		    <td align="center"><input type="radio" name="menangis_1" value="3" <?php if(isset($menangis[0]) and $menangis[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="3" <?php if(isset($menangis[1]) and $menangis[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="3" <?php if(isset($menangis[2]) and $menangis[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="3" <?php if(isset($menangis[3]) and $menangis[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="3" <?php if(isset($menangis[4]) and $menangis[4] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>4. Menangis</td>
		    <td align="center"><input type="radio" name="menangis_1" value="4" <?php if(isset($menangis[0]) and $menangis[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="4" <?php if(isset($menangis[1]) and $menangis[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="4" <?php if(isset($menangis[2]) and $menangis[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="4" <?php if(isset($menangis[3]) and $menangis[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="4" <?php if(isset($menangis[4]) and $menangis[4] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>5. Berteriak</td>
		    <td align="center"><input type="radio" name="menangis_1" value="5" <?php if(isset($menangis[0]) and $menangis[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_2" value="5" <?php if(isset($menangis[1]) and $menangis[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_3" value="5" <?php if(isset($menangis[2]) and $menangis[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_4" value="5" <?php if(isset($menangis[3]) and $menangis[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="menangis_5" value="5" <?php if(isset($menangis[4]) and $menangis[4] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">PERGERAKAN</td>
			<td>1. Tidak ada pergerakan</td>
			<td align="center"><input type="radio" name="pergerakan_1" value="1" <?php if(isset($pergerakan[0]) and $pergerakan[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_2" value="1" <?php if(isset($pergerakan[1]) and $pergerakan[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_3" value="1" <?php if(isset($pergerakan[2]) and $pergerakan[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_4" value="1" <?php if(isset($pergerakan[3]) and $pergerakan[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_5" value="1" <?php if(isset($pergerakan[4]) and $pergerakan[4] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>2. Kadang-kadang bergerak perlahan</td>
			<td align="center"><input type="radio" name="pergerakan_1" value="2" <?php if(isset($pergerakan[0]) and $pergerakan[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_2" value="2" <?php if(isset($pergerakan[1]) and $pergerakan[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_3" value="2" <?php if(isset($pergerakan[2]) and $pergerakan[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_4" value="2" <?php if(isset($pergerakan[3]) and $pergerakan[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_5" value="2" <?php if(isset($pergerakan[4]) and $pergerakan[4] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>3. Sering bergerak perlahan</td>
			<td align="center"><input type="radio" name="pergerakan_1" value="3" <?php if(isset($pergerakan[0]) and $pergerakan[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_2" value="3" <?php if(isset($pergerakan[1]) and $pergerakan[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_3" value="3" <?php if(isset($pergerakan[2]) and $pergerakan[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_4" value="3" <?php if(isset($pergerakan[3]) and $pergerakan[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_5" value="3" <?php if(isset($pergerakan[4]) and $pergerakan[4] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>4. Pergerakan aktif/ gelisah</td>
			<td align="center"><input type="radio" name="pergerakan_1" value="4" <?php if(isset($pergerakan[0]) and $pergerakan[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_2" value="4" <?php if(isset($pergerakan[1]) and $pergerakan[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_3" value="4" <?php if(isset($pergerakan[2]) and $pergerakan[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_4" value="4" <?php if(isset($pergerakan[3]) and $pergerakan[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_5" value="4" <?php if(isset($pergerakan[4]) and $pergerakan[4] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td>5. Bergerak aktif termasuk badan dan kepala</td>
			<td align="center"><input type="radio" name="pergerakan_1" value="5" <?php if(isset($pergerakan[0]) and $pergerakan[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_2" value="5" <?php if(isset($pergerakan[1]) and $pergerakan[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_3" value="5" <?php if(isset($pergerakan[2]) and $pergerakan[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_4" value="5" <?php if(isset($pergerakan[3]) and $pergerakan[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="pergerakan_5" value="5" <?php if(isset($pergerakan[4]) and $pergerakan[4] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TONUS OTOT</td>
			<td>1. Otot relaks sepenuhnya, tidak ada tonus otot</td>
		    <td align="center"><input type="radio" name="tonus_otot_1" value="1" <?php if(isset($tonus_otot[0]) and $tonus_otot[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_2" value="1" <?php if(isset($tonus_otot[1]) and $tonus_otot[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_3" value="1" <?php if(isset($tonus_otot[2]) and $tonus_otot[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_4" value="1" <?php if(isset($tonus_otot[3]) and $tonus_otot[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_5" value="1" <?php if(isset($tonus_otot[4]) and $tonus_otot[4] == '1') echo 'checked="checked"'; ?> /></td>
		 </tr>
		<tr>
			<td>2. Penurunan tonus otot</td>
		    <td align="center"><input type="radio" name="tonus_otot_1" value="2" <?php if(isset($tonus_otot[0]) and $tonus_otot[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_2" value="2" <?php if(isset($tonus_otot[1]) and $tonus_otot[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_3" value="2" <?php if(isset($tonus_otot[2]) and $tonus_otot[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_4" value="2" <?php if(isset($tonus_otot[3]) and $tonus_otot[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_5" value="2" <?php if(isset($tonus_otot[4]) and $tonus_otot[4] == '2') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>3. Tonus otot normal</td>
		    <td align="center"><input type="radio" name="tonus_otot_1" value="3" <?php if(isset($tonus_otot[0]) and $tonus_otot[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_2" value="3" <?php if(isset($tonus_otot[1]) and $tonus_otot[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_3" value="3" <?php if(isset($tonus_otot[2]) and $tonus_otot[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_4" value="3" <?php if(isset($tonus_otot[3]) and $tonus_otot[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_5" value="3" <?php if(isset($tonus_otot[4]) and $tonus_otot[4] == '3') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>4. Peningkatan tonus otot dan fleksi jari tangan dan kaki</td>
		    <td align="center"><input type="radio" name="tonus_otot_1" value="4" <?php if(isset($tonus_otot[0]) and $tonus_otot[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_2" value="4" <?php if(isset($tonus_otot[1]) and $tonus_otot[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_3" value="4" <?php if(isset($tonus_otot[2]) and $tonus_otot[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_4" value="4" <?php if(isset($tonus_otot[3]) and $tonus_otot[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_5" value="4" <?php if(isset($tonus_otot[4]) and $tonus_otot[4] == '4') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>5. Kekakuan otot ekstrim dan fleksi tangan dan kaki</td>
		    <td align="center"><input type="radio" name="tonus_otot_1" value="5" <?php if(isset($tonus_otot[0]) and $tonus_otot[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_2" value="5" <?php if(isset($tonus_otot[1]) and $tonus_otot[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_3" value="5" <?php if(isset($tonus_otot[2]) and $tonus_otot[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_4" value="5" <?php if(isset($tonus_otot[3]) and $tonus_otot[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tonus_otot_5" value="5" <?php if(isset($tonus_otot[4]) and $tonus_otot[4] == '5') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TEGANGAN WAJAH</td>
			<td>1. Otot wajah relaks sepenuhnya</td>
		    <td align="center"><input type="radio" name="tegangan_wajah_1" value="1" <?php if(isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_2" value="1" <?php if(isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_3" value="1" <?php if(isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_4" value="1" <?php if(isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_5" value="1" <?php if(isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '1') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>2. Tonus otot wajah normal, tidak terlihat tegangan otot wajah yang nyata</td>
		    <td align="center"><input type="radio" name="tegangan_wajah_1" value="2" <?php if(isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_2" value="2" <?php if(isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_3" value="2" <?php if(isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_4" value="2" <?php if(isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_5" value="2" <?php if(isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '2') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>3. Tegangan beberapa otot wajah nyata</td>
		    <td align="center"><input type="radio" name="tegangan_wajah_1" value="3" <?php if(isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_2" value="3" <?php if(isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_3" value="3" <?php if(isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_4" value="3" <?php if(isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_5" value="3" <?php if(isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '3') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>4. Tegangan hampir di seluruh otot wajah</td>
		    <td align="center"><input type="radio" name="tegangan_wajah_1" value="4" <?php if(isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_2" value="4" <?php if(isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_3" value="4" <?php if(isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_4" value="4" <?php if(isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_5" value="4" <?php if(isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '4') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>5. Seluruh otot wajah tegang, meringis</td>
		    <td align="center"><input type="radio" name="tegangan_wajah_1" value="5" <?php if(isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_2" value="5" <?php if(isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_3" value="5" <?php if(isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_4" value="5" <?php if(isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tegangan_wajah_5" value="5" <?php if(isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '5') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TEKANAN DARAH BASAH</td>
			<td>1. Tekanan darah dibawah batas normal</td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_1" value="1" <?php if(isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_2" value="1" <?php if(isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_3" value="1" <?php if(isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_4" value="1" <?php if(isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_5" value="1" <?php if(isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '1') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>2. Tekanan darah berada dibatas normal secara konsisten</td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_1" value="2" <?php if(isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_2" value="2" <?php if(isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_3" value="2" <?php if(isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_4" value="2" <?php if(isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_5" value="2" <?php if(isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '2') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>3. Peningkatan tekanan darah sesekali >= 15% diatas batas normal (1 - 3 kali dalam observasi selama 2 menit)</td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_1" value="3" <?php if(isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_2" value="3" <?php if(isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_3" value="3" <?php if(isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_4" value="3" <?php if(isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_5" value="3" <?php if(isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '3') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>4. Seringnya peningkatan tekanan darah >= 15% diatas batas normal (> 3 kali dalam observasi selama 2 menit)</td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_1" value="4" <?php if(isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_2" value="4" <?php if(isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_3" value="4" <?php if(isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_4" value="4" <?php if(isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_5" value="4" <?php if(isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '4') echo 'checked="checked"'; ?> /></td>
		 </tr>
		 <tr>
			<td>5. Peningkatan tekanan darah secara terus-menerus >= 15%</td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_1" value="4" <?php if(isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_2" value="4" <?php if(isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_3" value="4" <?php if(isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_4" value="4" <?php if(isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="tekanan_darah_basah_5" value="4" <?php if(isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '4') echo 'checked="checked"'; ?> /></td>
		 </tr>
		<?php
		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		if(!empty($comport_scale_id)){
			$total_skor_1 = $kewaspadaan[0] + $ketenangan[0] + $distres_pernapasan[0] + $menangis[0] + $pergerakan[0] + $tonus_otot[0] + $tegangan_wajah[0] + $tekanan_darah_basah[0];
			$total_skor_2 = $kewaspadaan[1] + $ketenangan[1] + $distres_pernapasan[1] + $menangis[1] + $pergerakan[1] + $tonus_otot[1] + $tegangan_wajah[1] + $tekanan_darah_basah[1];
			$total_skor_3 = $kewaspadaan[2] + $ketenangan[2] + $distres_pernapasan[2] + $menangis[2] + $pergerakan[2] + $tonus_otot[2] + $tegangan_wajah[2] + $tekanan_darah_basah[2];
			$total_skor_4 = $kewaspadaan[3] + $ketenangan[3] + $distres_pernapasan[3] + $menangis[3] + $pergerakan[3] + $tonus_otot[3] + $tegangan_wajah[3] + $tekanan_darah_basah[3];
			$total_skor_5 = $kewaspadaan[4] + $ketenangan[4] + $distres_pernapasan[4] + $menangis[4] + $pergerakan[4] + $tonus_otot[4] + $tegangan_wajah[4] + $tekanan_darah_basah[4];
		}	
		?>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center"><?php echo $total_skor_1; ?></td>
		    <td align="center"><?php echo $total_skor_2; ?></td>
		    <td align="center"><?php echo $total_skor_3; ?></td>
		    <td align="center"><?php echo $total_skor_4; ?></td>
		    <td align="center"><?php echo $total_skor_5; ?></td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center"><select name="perawat_1" id="perawat_1" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[0])) $xperawat = $perawat[0]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_2" id="perawat_2" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[1])) $xperawat = $perawat[1]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_3" id="perawat_3" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[2])) $xperawat = $perawat[2]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_4" id="perawat_4" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[3])) $xperawat = $perawat[3]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_5" id="perawat_5" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[4])) $xperawat = $perawat[4]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    </td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TANGGAL</td>
		    <td><input type="text" name="tanggal_1" id="tgl_edu_1" value="<?php if(isset($tanggal[0])) echo $tanggal[0]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
		    <td><input type="text" name="tanggal_2" id="tgl_edu_2" value="<?php if(isset($tanggal[1])) echo $tanggal[1]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
		    <td><input type="text" name="tanggal_3" id="tgl_edu_3" value="<?php if(isset($tanggal[2])) echo $tanggal[2]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
		    <td><input type="text" name="tanggal_4" id="tgl_edu_4" value="<?php if(isset($tanggal[3])) echo $tanggal[3]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
		    <td><input type="text" name="tanggal_5" id="tgl_edu_5" value="<?php if(isset($tanggal[4])) echo $tanggal[4]; ?>" class="text_dt" style="width:80px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></td>
		</tr>
		<tr>
			<td colspan="13" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
			Keterangan :<br />
			9-18 : nyeri terkontrol<br />
			19-26 : nyeri ringan<br />
			27-35 : nyeri sedang<br />
			>35 : nyeri berat
			</td>
			<td colspan="11" valign="top">
			* Untuk pasien di ruang rawat intensif/ kamar operasi/ ruang rawat inap yang tidak dapat dinilai menggunakan Numeric Rating Scale Wong Baker Faces Pain Scale
			</td>
		</tr>	
    </table>
</form>