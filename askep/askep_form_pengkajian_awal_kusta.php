<?php 
$irna_id = $_GET['idx'];
if (isset($_POST['irna_id'])) include('askep/askep_save_pengkajian_awal_kusta.php');

$qry_askep = 'SELECT PENGKAJIAN_AWAL_ID,NAMA_PANGGILAN,STATUS_KAWIN,STATUS_KAWIN_KET,JUMLAH_ANAK,AGAMA,PENDIDIKAN,PENDIDIKAN_KET,PEKERJAAN,
			PEKERJAAN_KET,ALAMAT,NO_TELEPON,
			DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
			DATE_FORMAT(TANGGAL_MASUK,"%H") AS JAM_MASUK,
			DATE_FORMAT(TANGGAL_MASUK,"%i") AS MENIT_MASUK,
			CARA_MASUK,TIDAK_ADA_ALERGI,ALERGI_OBAT,ALERGI_OBAT_KET,ALERGI_OBAT_REAKSI,
			ALERGI_MAKANAN,ALERGI_MAKANAN_KET,ALERGI_MAKANAN_REAKSI,ALERGI_LAINNYA,ALERGI_LAINNYA_KET,ALERGI_LAINNYA_REAKSI,GELANG_TANDA_ALERGI,
			ALERGI_TIDAK_DIKETAHUI,ALASAN_MASUK_RS,PERNAH_DIRAWAT,PERNAH_DIRAWAT_KAPAN,PERNAH_DIRAWAT_DIMANA,DIAGNOSIS,TANDA_VITAL,TERPASANG_ALAT_IMPLAN,
			TERPASANG_ALAT_IMPLAN_KET,PENYAKIT_RIWAYAT_KELUARGA,PENYAKIT_RIWAYAT_PENYAKIT,PENYAKIT_RIWAYAT_KET,STATUS_PSIKOLOGIS,STATUS_PSIKOLOGIS_KET,
			STATUS_MENTAL,STATUS_MENTAL_KET_1,STATUS_MENTAL_KET_2,STATUS_SOSIAL,STATUS_SOSIAL_KET,STATUS_SOSIAL_KERABAT,PEMERIKSAAN_FISIK_KEPALA,
			PEMERIKSAAN_FISIK_MATA,PEMERIKSAAN_FISIK_TELINGA,PEMERIKSAAN_FISIK_HIDUNG,PEMERIKSAAN_FISIK_MULUT,PEMERIKSAAN_FISIK_LEHER,PEMERIKSAAN_FISIK_THORAX,
			PEMERIKSAAN_FISIK_ABDOMEN,PEMERIKSAAN_FISIK_KULIT,PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT,SKRINING_GIZI,STATUS_FUNGSIONAL,STATUS_FUNGSIONAL_KET,
			RISIKO_CEDERA,SKRINING_NYERI,PEMERIKSAAN_PENUNJANG,KEBUTUHAN_EDUKASI,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,DATE_FORMAT(TANGGAL,"%H") AS JAM,
			DATE_FORMAT(TANGGAL,"%i") AS MENIT,DATE_FORMAT(TANGGAL_PELENGKAP,"%d/%m/%Y") AS TANGGAL_PELENGKAP,DATE_FORMAT(TANGGAL_PELENGKAP,"%H") AS JAM_PELENGKAP,
			DATE_FORMAT(TANGGAL_PELENGKAP,"%i") AS MENIT_PELENGKAP,PERAWAT,PERAWAT_PELENGKAP,
			PEMERIKSAAN_FISIK_EKSTREMITAS	
			FROM t_irna_askep_pengkajian_awal_kusta
			WHERE PENGKAJIAN_AWAL_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$pengkajian_awal_id = $dat_askep['PENGKAJIAN_AWAL_ID'];
$nama_panggilan = $dat_askep['NAMA_PANGGILAN'];
$status_kawin = $dat_askep['STATUS_KAWIN'];
$status_kawin_ket = $dat_askep['STATUS_KAWIN_KET'];
$jumlah_anak = $dat_askep['JUMLAH_ANAK'];
$agama = $dat_askep['AGAMA'];
$pendidikan = $dat_askep['PENDIDIKAN'];
$pendidikan_ket = $dat_askep['PENDIDIKAN_KET'];
$pekerjaan = $dat_askep['PEKERJAAN'];
$pekerjaan_ket = $dat_askep['PEKERJAAN_KET'];
$alamat = $dat_askep['ALAMAT'];
$no_telepon = $dat_askep['NO_TELEPON'];
$tanggal_masuk = $dat_askep['TANGGAL_MASUK'];
$jam_masuk = $dat_askep['JAM_MASUK'];
$menit_masuk = $dat_askep['MENIT_MASUK'];
$cara_masuk = $dat_askep['CARA_MASUK'];
$tidak_ada_alergi = $dat_askep['TIDAK_ADA_ALERGI'];
$alergi_obat = $dat_askep['ALERGI_OBAT'];
$alergi_obat_ket = $dat_askep['ALERGI_OBAT_KET'];
$alergi_obat_reaksi = $dat_askep['ALERGI_OBAT_REAKSI'];
$alergi_makanan = $dat_askep['ALERGI_MAKANAN'];
$alergi_makanan_ket = $dat_askep['ALERGI_MAKANAN_KET'];
$alergi_makanan_reaksi = $dat_askep['ALERGI_MAKANAN_REAKSI'];
$alergi_lainnya = $dat_askep['ALERGI_LAINNYA'];
$alergi_lainnya_ket = $dat_askep['ALERGI_LAINNYA_KET'];
$alergi_lainnya_reaksi = $dat_askep['ALERGI_LAINNYA_REAKSI'];
$gelang_tanda_alergi = $dat_askep['GELANG_TANDA_ALERGI'];
$alergi_tidak_diketahui = $dat_askep['ALERGI_TIDAK_DIKETAHUI'];
$alasan_masuk_rs = $dat_askep['ALASAN_MASUK_RS'];
$pernah_dirawat = $dat_askep['PERNAH_DIRAWAT'];
$pernah_dirawat_kapan = $dat_askep['PERNAH_DIRAWAT_KAPAN'];
$pernah_dirawat_dimana = $dat_askep['PERNAH_DIRAWAT_DIMANA'];
$diagnosis = $dat_askep['DIAGNOSIS'];
$tanda_vital = $dat_askep['TANDA_VITAL'];
$terpasang_alat_implan = $dat_askep['TERPASANG_ALAT_IMPLAN'];
$terpasang_alat_implan_ket = $dat_askep['TERPASANG_ALAT_IMPLAN_KET'];
$penyakit_riwayat_keluarga = $dat_askep['PENYAKIT_RIWAYAT_KELUARGA'];
$penyakit_riwayat_penyakit = $dat_askep['PENYAKIT_RIWAYAT_PENYAKIT'];
$penyakit_riwayat_ket = $dat_askep['PENYAKIT_RIWAYAT_KET'];
$status_psikologis = $dat_askep['STATUS_PSIKOLOGIS'];
$status_psikologis_ket = $dat_askep['STATUS_PSIKOLOGIS_KET'];
$status_mental = $dat_askep['STATUS_MENTAL'];
$status_mental_ket_1 = $dat_askep['STATUS_MENTAL_KET_1'];
$status_mental_ket_2 = $dat_askep['STATUS_MENTAL_KET_2'];
$status_sosial = $dat_askep['STATUS_SOSIAL'];
$status_sosial_ket = $dat_askep['STATUS_SOSIAL_KET'];
$status_sosial_kerabat = $dat_askep['STATUS_SOSIAL_KERABAT'];
$pemeriksaan_fisik_kepala = $dat_askep['PEMERIKSAAN_FISIK_KEPALA'];
$pemeriksaan_fisik_mata = $dat_askep['PEMERIKSAAN_FISIK_MATA'];
$pemeriksaan_fisik_telinga = $dat_askep['PEMERIKSAAN_FISIK_TELINGA'];
$pemeriksaan_fisik_hidung = $dat_askep['PEMERIKSAAN_FISIK_HIDUNG'];
$pemeriksaan_fisik_mulut = $dat_askep['PEMERIKSAAN_FISIK_MULUT'];
$pemeriksaan_fisik_leher = $dat_askep['PEMERIKSAAN_FISIK_LEHER'];
$pemeriksaan_fisik_thorax = $dat_askep['PEMERIKSAAN_FISIK_THORAX'];
$pemeriksaan_fisik_abdomen = $dat_askep['PEMERIKSAAN_FISIK_ABDOMEN'];
$pemeriksaan_fisik_kulit = $dat_askep['PEMERIKSAAN_FISIK_KULIT'];
$pemeriksaan_fisik_ektremitas = $dat_askep['PEMERIKSAAN_FISIK_EKSTREMITAS'];
$pemeriksaan_fisik_terkait_penyakit = $dat_askep['PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT'];
$skrining_gizi = $dat_askep['SKRINING_GIZI'];
$status_fungsional = $dat_askep['STATUS_FUNGSIONAL'];
$status_fungsional_ket = $dat_askep['STATUS_FUNGSIONAL_KET'];
$risiko_cedera = $dat_askep['RISIKO_CEDERA'];
$skrining_nyeri = $dat_askep['SKRINING_NYERI'];
$pemeriksaan_penunjang = $dat_askep['PEMERIKSAAN_PENUNJANG'];
$kebutuhan_edukasi = $dat_askep['KEBUTUHAN_EDUKASI'];			
$tanggal = $dat_askep['TANGGAL'];			
$jam = $dat_askep['JAM'];			
$menit = $dat_askep['MENIT'];			
$perawat = $dat_askep['PERAWAT'];		
$tanggal_pelengkap = $dat_askep['TANGGAL_PELENGKAP'];			
$jam_pelengkap = $dat_askep['JAM_PELENGKAP'];			
$menit_pelengkap = $dat_askep['MENIT_PELENGKAP'];				
$perawat_pelengkap = $dat_askep['PERAWAT_PELENGKAP'];			

$arr_tanda_vital = explode('||',$tanda_vital);
$arr_penyakit_riwayat_keluarga = explode('||',$penyakit_riwayat_keluarga);
$arr_penyakit_riwayat_penyakit = explode('||',$penyakit_riwayat_penyakit);
$arr_status_psikologis = explode('||',$status_psikologis);
$arr_status_mental = explode('||',$status_mental);
$arr_status_sosial = explode('||',$status_sosial);
$arr_status_sosial_kerabat = explode('||',$status_sosial_kerabat);
$arr_pemeriksaan_fisik_kepala = explode('||',$pemeriksaan_fisik_kepala);
$arr_pemeriksaan_fisik_mata = explode('||',$pemeriksaan_fisik_mata);
$arr_pemeriksaan_fisik_telinga = explode('||',$pemeriksaan_fisik_telinga);
$arr_pemeriksaan_fisik_hidung = explode('||',$pemeriksaan_fisik_hidung);
$arr_pemeriksaan_fisik_mulut = explode('||',$pemeriksaan_fisik_mulut);
$arr_pemeriksaan_fisik_leher = explode('||',$pemeriksaan_fisik_leher);
$arr_pemeriksaan_fisik_thorax = explode('||',$pemeriksaan_fisik_thorax);
$arr_pemeriksaan_fisik_abdomen = explode('||',$pemeriksaan_fisik_abdomen);
$arr_pemeriksaan_fisik_kulit = explode('||',$pemeriksaan_fisik_kulit);
$arr_pemeriksaan_fisik_ekstremitas = explode('||',$pemeriksaan_fisik_ektremitas);
$arr_skrining_gizi = explode('||',$skrining_gizi);
$arr_risiko_cedera = explode('||',$risiko_cedera);
$arr_skrining_nyeri = explode('||',$skrining_nyeri);
$arr_kebutuhan_edukasi = explode('||',$kebutuhan_edukasi);
?>
<form name="formedukasi" id="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="pengkajian_awal_id" id="pengkajian_awal_id" value="<?php echo $pengkajian_awal_id; ?>" />
<table border="0" width="100%">
<tr>
    <td colspan="4"><strong>1. IDENTITAS PASIEN</strong></td>
</tr>
<tr>
	<td width="150px;">&nbsp;</td>
    <td width="200px;">Nama Panggilan</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="text" name="nama_panggilan" id="nama_panggilan" value="<?php echo $nama_panggilan; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Status Perkawinan</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="radio" name="status_kawin" id="status_kawin" value="1" <?php if($status_kawin == '1') echo 'checked="checked"'; ?> />&nbsp;Kawin, Perkawinan ke
		<input type="text" name="status_kawin_ket" id="status_kawin_ket" value="<?php echo $status_kawin_ket; ?>" class="text_dt" style="width:50px;" />
		<input type="radio" name="status_kawin" id="status_kawin" value="2" <?php if($status_kawin == '2') echo 'checked="checked"'; ?> />&nbsp;Janda
		<input type="radio" name="status_kawin" id="status_kawin" value="3" <?php if($status_kawin == '3') echo 'checked="checked"'; ?> />&nbsp;Duda
		<input type="radio" name="status_kawin" id="status_kawin" value="4" <?php if($status_kawin == '4') echo 'checked="checked"'; ?> />&nbsp;Belum Kawin</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Jumlah Anak</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="text" name="jumlah_anak" id="jumlah_anak" value="<?php echo $jumlah_anak; ?>" class="text_dt" style="width:50px;" />&nbsp;orang</td>
</tr>
<tr>
	<td>&nbsp;</td>	
    <td>Agama</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="radio" name="agama" id="agama" value="1" <?php if($agama == '1') echo 'checked="checked"'; ?> />&nbsp;Islam
	<input type="radio" name="agama" id="agama" value="2" <?php if($agama == '3') echo 'checked="checked"'; ?> />&nbsp;Kristen Katolik
	<input type="radio" name="agama" id="agama" value="3" <?php if($agama == '2') echo 'checked="checked"'; ?> />&nbsp;Kristen Protestan
	<input type="radio" name="agama" id="agama" value="4" <?php if($agama == '5') echo 'checked="checked"'; ?> />&nbsp;Budha
	<input type="radio" name="agama" id="agama" value="5" <?php if($agama == '4') echo 'checked="checked"'; ?> />&nbsp;Hindu</td>
</tr>
<tr>
	<td>&nbsp;</td>	
    <td>Pendidikan</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="radio" name="pendidikan" id="pendidikan" value="1" <?php if($pendidikan == '1') echo 'checked="checked"'; ?> />&nbsp;SD
	<input type="radio" name="pendidikan" id="pendidikan" value="2" <?php if($pendidikan == '2') echo 'checked="checked"'; ?> />&nbsp;SMP
	<input type="radio" name="pendidikan" id="pendidikan" value="3" <?php if($pendidikan == '3') echo 'checked="checked"'; ?> />&nbsp;SMU
	<input type="radio" name="pendidikan" id="pendidikan" value="4" <?php if($pendidikan == '4') echo 'checked="checked"'; ?> />&nbsp;D3
	<input type="radio" name="pendidikan" id="pendidikan" value="5" <?php if($pendidikan == '5') echo 'checked="checked"'; ?> />&nbsp;S1
	<input type="radio" name="pendidikan" id="pendidikan" value="6" <?php if($pendidikan == '6') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="pendidikan_ket" id="pendidikan_ket" value="<?php echo $pendidikan_ket; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Pekerjaan</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="radio" name="pekerjaan" id="pekerjaan" value="1" <?php if($pekerjaan == '1') echo 'checked="checked"'; ?> />&nbsp;Swasta
	<input type="radio" name="pekerjaan" id="pekerjaan" value="2" <?php if($pekerjaan == '2') echo 'checked="checked"'; ?> />&nbsp;BUMN
	<input type="radio" name="pekerjaan" id="pekerjaan" value="3" <?php if($pekerjaan == '3') echo 'checked="checked"'; ?> />&nbsp;PNS
	<input type="radio" name="pekerjaan" id="pekerjaan" value="4" <?php if($pekerjaan == '4') echo 'checked="checked"'; ?> />&nbsp;Wiraswasta
	<input type="radio" name="pekerjaan" id="pekerjaan" value="5" <?php if($pekerjaan == '5') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="pekerjaan_ket" id="pekerjaan_ket" value="<?php echo $pekerjaan_ket; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Alamat</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><textarea name="alamat" id="alamat" class="text_dt2" ><?php echo $alamat; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>No Telepon</td>
	<td width="10px;">:</td>
	<td colspan="2"><input type="text" name="no_telepon" id="no_telepon" value="<?php echo $no_telepon; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal Masuk</td>
	<td width="10px;">:</td>
	<td colspan="2"colspan="2"><input type="text" name="tanggal_masuk" id="tgl_edu_1" value="<?php echo $tanggal_masuk; ?>" class="text_dt" /><img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/>
	Pukul <select name="jam_masuk" id="jam_masuk" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_masuk); ?>
			</select>
			<select name="menit_masuk" id="menit_masuk" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_masuk); ?>
			</select>
	Dengan <input type="radio" name="cara_masuk" id="cara_masuk" value="1" <?php if($cara_masuk == '1') echo 'checked="checked"'; ?> />&nbsp;Jalan
	<input type="radio" name="cara_masuk" id="cara_masuk" value="2" <?php if($cara_masuk == '2') echo 'checked="checked"'; ?> />&nbsp;Kursi Roda
	<input type="radio" name="cara_masuk" id="cara_masuk" value="3" <?php if($cara_masuk == '3') echo 'checked="checked"'; ?> />&nbsp;Brand Kard</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4" align="center"><strong>ALERGI/ REAKSI</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="tidak_ada_alergi" id="tidak_ada_alergi" value="1" <?php if($tidak_ada_alergi == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak ada alergi</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_obat" id="alergi_obat" value="1" <?php if($alergi_obat == '1') echo 'checked="checked"'; ?> />&nbsp;Alergi obat, sebutkan
	<input type="text" name="alergi_obat_ket" id="alergi_obat_ket" value="<?php echo $alergi_obat_ket; ?>" class="text_dt" style="width:280px;" />
	&nbsp;Reaksi&nbsp;<input type="text" name="alergi_obat_reaksi" id="alergi_obat_reaksi" value="<?php echo $alergi_obat_reaksi; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_makanan" id="alergi_makanan" value="1" <?php if($alergi_makanan == '1') echo 'checked="checked"'; ?> />&nbsp;Alergi makanan, sebutkan
	<input type="text" name="alergi_makanan_ket" id="alergi_makanan_ket" value="<?php echo $alergi_makanan_ket; ?>" class="text_dt" style="width:280px;" />
	&nbsp;Reaksi&nbsp;<input type="text" name="alergi_makanan_reaksi" id="alergi_makanan_reaksi" value="<?php echo $alergi_makanan_reaksi; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_lainnya" id="alergi_lainnya" value="1" <?php if($alergi_lainnya == '1') echo 'checked="checked"'; ?> />&nbsp;Alergi lainnya, sebutkan
	<input type="text" name="alergi_lainnya_ket" id="alergi_lainnya_ket" value="<?php echo $alergi_lainnya_ket; ?>" class="text_dt" style="width:280px;" />
	&nbsp;Reaksi&nbsp;<input type="text" name="alergi_lainnya_reaksi" id="alergi_lainnya_reaksi" value="<?php echo $alergi_lainnya_reaksi; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="gelang_tanda_alergi" id="gelang_tanda_alergi" value="1" <?php if($gelang_tanda_alergi == '1') echo 'checked="checked"'; ?> />&nbsp;Gelang Tanda Alergi dipasang (warna merah)</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_tidak_diketahui" id="alergi_tidak_diketahui" value="1" <?php if($alergi_tidak_diketahui == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak diketahui</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>2. ALASAN MASUK RS (Keluhan utama saat masuk RS)</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="3"><textarea name="alasan_masuk_rs" id="alasan_masuk_rs" class="text_dt2" ><?php echo $alasan_masuk_rs; ?></textarea></td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>3. RIWAYAT KESEHATAN/ PENGOBATAN/ PERAWATAN SEBELUMNYA</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Pernah dirawat</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pernah_dirawat" id="pernah_dirawat" value="1" <?php if($pernah_dirawat == '1') echo 'checked="checked"'; ?> />&nbsp;Ya
	<input type="radio" name="pernah_dirawat" id="pernah_dirawat" value="2" <?php if($pernah_dirawat == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak<br />
	Kapan <input type="text" name="pernah_dirawat_kapan" id="pernah_dirawat_kapan" value="<?php echo $pernah_dirawat_kapan; ?>" class="text_dt" style="width:280px;" />&nbsp;Di mana 
	<input type="text" name="pernah_dirawat_dimana" id="pernah_dirawat_dimana" value="<?php echo $pernah_dirawat_dimana; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
    <td colspan="2">Diagnosis
	<input type="text" name="diagnosis" id="diagnosis" value="<?php echo $diagnosis; ?>" class="text_dt" style="width:605px;" /></td>
</tr>
<?php 

?>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Tanda-tanda vital</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">Suhu&nbsp;<input type="text" name="tanda_vital_1" id="tanda_vital_1" value="<?php if(isset($arr_tanda_vital[0])) echo $arr_tanda_vital[0]; ?>" class="text_dt" />&nbsp;C,&nbsp;
	Nadi <input type="text" name="tanda_vital_2" id="tanda_vital_2" value="<?php if(isset($arr_tanda_vital[1]))echo $arr_tanda_vital[1]; ?>" class="text_dt" />&nbsp;x/mnt&nbsp;
	<input type="radio" name="tanda_vital_3" id="tanda_vital_3" value="1" <?php if(isset($arr_tanda_vital[2]) and $arr_tanda_vital[2] == '1') echo 'checked="checked"'; ?> />&nbsp;reguler
	<input type="radio" name="tanda_vital_3" id="tanda_vital_3" value="2" <?php if(isset($arr_tanda_vital[2]) and $arr_tanda_vital[2] == '2') echo 'checked="checked"'; ?> />&nbsp;ireguler<br />
	TD <input type="text" name="tanda_vital_4" id="tanda_vital_4" value="<?php if(isset($arr_tanda_vital[3]))echo $arr_tanda_vital[3]; ?>" class="text_dt" />&nbsp;mmHg,&nbsp;
	Pernapasan <input type="text" name="tanda_vital_5" id="tanda_vital_5" value="<?php if(isset($arr_tanda_vital[4]))echo $arr_tanda_vital[4]; ?>" class="text_dt" />&nbsp;x/mnt,&nbsp;
	BB <input type="text" name="tanda_vital_6" id="tanda_vital_6" value="<?php if(isset($arr_tanda_vital[5]))echo $arr_tanda_vital[5]; ?>" class="text_dt" />&nbsp;kg&nbsp;<br />
	Tinggi badan <input type="text" name="tanda_vital_7" id="tanda_vital_7" value="<?php if(isset($arr_tanda_vital[6]))echo $arr_tanda_vital[6]; ?>" class="text_dt" />&nbsp;cm
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="terpasang_alat_implan" id="terpasang_alat_implan" value="1" <?php if($terpasang_alat_implan == '1') echo 'checked="checked"'; ?> />&nbsp;Alat implant yang terpasang, sebutkan
	<input type="text" name="terpasang_alat_implan_ket" id="terpasang_alat_implan_ket" value="<?php echo $terpasang_alat_implan_ket; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">Apakah ada riwayat dalam keluarga
	(<input type="checkbox" name="penyakit_riwayat_keluarga_1" id="penyakit_riwayat_keluarga_1" value="1" <?php if(isset($arr_penyakit_riwayat_keluarga[0]) and $arr_penyakit_riwayat_keluarga[0] == '1') echo 'checked="checked"'; ?> />&nbsp;ayah
	<input type="checkbox" name="penyakit_riwayat_keluarga_2" id="penyakit_riwayat_keluarga_2" value="1" <?php if(isset($arr_penyakit_riwayat_keluarga[1]) and $arr_penyakit_riwayat_keluarga[1] == '1') echo 'checked="checked"'; ?> />&nbsp;ibu
	<input type="checkbox" name="penyakit_riwayat_keluarga_3" id="penyakit_riwayat_keluarga_3" value="1" <?php if(isset($arr_penyakit_riwayat_keluarga[2]) and $arr_penyakit_riwayat_keluarga[2] == '1') echo 'checked="checked"'; ?> />&nbsp;kakek
	<input type="checkbox" name="penyakit_riwayat_keluarga_4" id="penyakit_riwayat_keluarga_4" value="1" <?php if(isset($arr_penyakit_riwayat_keluarga[3]) and $arr_penyakit_riwayat_keluarga[3] == '1') echo 'checked="checked"'; ?> />&nbsp;nenek)
		memiliki penyakit Mayor
	<input type="checkbox" name="penyakit_riwayat_penyakit_1" id="penyakit_riwayat_penyakit_1" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[0]) and $arr_penyakit_riwayat_penyakit[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Asma
	<input type="checkbox" name="penyakit_riwayat_penyakit_2" id="penyakit_riwayat_penyakit_2" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[1]) and $arr_penyakit_riwayat_penyakit[1] == '1') echo 'checked="checked"'; ?> />&nbsp;DM<br />
	<input type="checkbox" name="penyakit_riwayat_penyakit_3" id="penyakit_riwayat_penyakit_3" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[2]) and $arr_penyakit_riwayat_penyakit[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Cardiovascular
	<input type="checkbox" name="penyakit_riwayat_penyakit_4" id="penyakit_riwayat_penyakit_4" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[3]) and $arr_penyakit_riwayat_penyakit[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Kanker
	<input type="checkbox" name="penyakit_riwayat_penyakit_5" id="penyakit_riwayat_penyakit_5" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[4]) and $arr_penyakit_riwayat_penyakit[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Talasemia
	<input type="checkbox" name="penyakit_riwayat_penyakit_6" id="penyakit_riwayat_penyakit_6" value="1" <?php if(isset($arr_penyakit_riwayat_penyakit[5]) and $arr_penyakit_riwayat_penyakit[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Lain-lain, sebutkan
	<input type="text" name="penyakit_riwayat_ket" id="penyakit_riwayat_ket" value="<?php echo $penyakit_riwayat_ket; ?>" class="text_dt" style="width:280px;" /></td>
	</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>4. RIWAYAT PSIKOSOSIAL</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Psikologis</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="status_psikologis_1" id="status_psikologis_1" value="1" <?php if(isset($arr_status_psikologis[0]) and $arr_status_psikologis[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Cemas
	<input type="checkbox" name="status_psikologis_2" id="status_psikologis_2" value="1" <?php if(isset($arr_status_psikologis[1]) and $arr_status_psikologis[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Takut
	<input type="checkbox" name="status_psikologis_3" id="status_psikologis_3" value="1" <?php if(isset($arr_status_psikologis[2]) and $arr_status_psikologis[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Marah
	<input type="checkbox" name="status_psikologis_4" id="status_psikologis_4" value="1" <?php if(isset($arr_status_psikologis[3]) and $arr_status_psikologis[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Sedih
	<input type="checkbox" name="status_psikologis_5" id="status_psikologis_5" value="1" <?php if(isset($arr_status_psikologis[4]) and $arr_status_psikologis[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Kecendrungan bunuh diri<br />
	<input type="checkbox" name="status_psikologis_6" id="status_psikologis_6" value="1" <?php if(isset($arr_status_psikologis[5]) and $arr_status_psikologis[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Senang
	<input type="checkbox" name="status_psikologis_7" id="status_psikologis_7" value="1" <?php if(isset($arr_status_psikologis[6]) and $arr_status_psikologis[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Gelisah
	<input type="checkbox" name="status_psikologis_8" id="status_psikologis_8" value="1" <?php if(isset($arr_status_psikologis[7]) and $arr_status_psikologis[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Cuek
	<input type="checkbox" name="status_psikologis_9" id="status_psikologis_9" value="1" <?php if(isset($arr_status_psikologis[8]) and $arr_status_psikologis[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Lain-lain, sebutkan
	<input type="text" name="status_psikologis_ket" id="status_psikologis_ket" value="<?php echo $status_psikologis_ket; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Mental</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="status_mental_1" id="status_mental_1" value="1" <?php if(isset($arr_status_mental[0]) and $arr_status_mental[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Sadar dan orientasi baik<br />
	<input type="checkbox" name="status_mental_2" id="status_mental_2" value="1" <?php if(isset($arr_status_mental[1]) and $arr_status_mental[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada masalah perilaku sebutkan
	<input type="text" name="status_mental_ket_1" id="status_mental_ket_1" value="<?php echo $status_mental_ket_1; ?>" class="text_dt" style="width:280px;" /><br />
	<input type="checkbox" name="status_mental_3" id="status_mental_3" value="1" <?php if(isset($arr_status_mental[2]) and $arr_status_mental[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Perilaku kekerasan yang dialami pasien sebelumnya
	<input type="text" name="status_mental_ket_2" id="status_mental_ket_2" value="<?php echo $status_mental_ket_2; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Sosial</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">a. Hubungan pasien dengan anggota keluarga <input type="radio" name="status_sosial_1" id="status_sosial_1" value="1" <?php if(isset($arr_status_sosial[0]) and $arr_status_sosial[0] == '1') echo 'checked="checked"'; ?> />&nbsp;baik 
	<input type="radio" name="status_sosial_1" id="status_sosial_1" value="2" <?php if(isset($arr_status_sosial[0]) and $arr_status_sosial[0] == '2') echo 'checked="checked"'; ?> />&nbsp;tidak baik<br />
	b. Tempat tinggal <input type="radio" name="status_sosial_2" id="status_sosial_2" value="1" <?php if(isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Rumah
	<input type="radio" name="status_sosial_2" id="status_sosial_2" value="2" <?php if(isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '2') echo 'checked="checked"'; ?> />&nbsp;Apartemen
	<input type="radio" name="status_sosial_2" id="status_sosial_2" value="3" <?php if(isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '3') echo 'checked="checked"'; ?> />&nbsp;Panti<br />
	<input type="radio" name="status_sosial_2" id="status_sosial_2" value="4" <?php if(isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '4') echo 'checked="checked"'; ?> />&nbsp;Lainnya
	<input type="text" name="status_sosial_ket" id="status_sosial_ket" value="<?php echo $status_sosial_ket; ?>" class="text_dt" style="width:280px;" /><br />
	c. Kerabat terdekat yang dapat dihubungi : Nama <input type="text" name="status_sosial_kerabat_1" id="status_sosial_kerabat_1" value="<?php if(isset($arr_status_sosial_kerabat[0]))echo $arr_status_sosial_kerabat[0]; ?>" class="text_dt" style="width:280px;" /><br />
	Hubungan <input type="text" name="status_sosial_kerabat_2" id="status_sosial_kerabat_2" value="<?php if(isset($arr_status_sosial_kerabat[1]))echo $arr_status_sosial_kerabat[1]; ?>" class="text_dt" style="width:280px;" />
	Telepon <input type="text" name="status_sosial_kerabat_3" id="status_sosial_kerabat_3" value="<?php if(isset($arr_status_sosial_kerabat[2]))echo $arr_status_sosial_kerabat[2]; ?>" class="text_dt" /></td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>5. PEMERIKSAAN FISIK</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>a. Kepala</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_kepala_1" id="pemeriksaan_fisik_kepala_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_kepala[0]) and $arr_pemeriksaan_fisik_kepala[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="radio" name="pemeriksaan_fisik_kepala_1" id="pemeriksaan_fisik_kepala_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_kepala[0]) and $arr_pemeriksaan_fisik_kepala[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Abnormal
	<input type="text" name="pemeriksaan_fisik_kepala_2" id="pemeriksaan_fisik_kepala_2" value="<?php if(isset($arr_pemeriksaan_fisik_kepala[1])) echo $arr_pemeriksaan_fisik_kepala[1]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">b. Mata</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_mata_1" id="pemeriksaan_fisik_mata_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[0]) and $arr_pemeriksaan_fisik_mata[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Isokor
	<input type="checkbox" name="pemeriksaan_fisik_mata_2" id="pemeriksaan_fisik_mata_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[1]) and $arr_pemeriksaan_fisik_mata[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Anisokor
	<input type="checkbox" name="pemeriksaan_fisik_mata_3" id="pemeriksaan_fisik_mata_3" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[2]) and $arr_pemeriksaan_fisik_mata[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Lagoptalmus
	<input type="checkbox" name="pemeriksaan_fisik_mata_4" id="pemeriksaan_fisik_mata_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[3]) and $arr_pemeriksaan_fisik_mata[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Katarak
	<input type="checkbox" name="pemeriksaan_fisik_mata_5" id="pemeriksaan_fisik_mata_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[4]) and $arr_pemeriksaan_fisik_mata[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Strabismus
	<input type="checkbox" name="pemeriksaan_fisik_mata_6" id="pemeriksaan_fisik_mata_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[5]) and $arr_pemeriksaan_fisik_mata[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Uvitis
	<input type="checkbox" name="pemeriksaan_fisik_mata_7" id="pemeriksaan_fisik_mata_7" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[6]) and $arr_pemeriksaan_fisik_mata[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Ikterik
	<input type="checkbox" name="pemeriksaan_fisik_mata_8" id="pemeriksaan_fisik_mata_8" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[7]) and $arr_pemeriksaan_fisik_mata[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Madriasis<br />
	<input type="checkbox" name="pemeriksaan_fisik_mata_9" id="pemeriksaan_fisik_mata_9" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[8]) and $arr_pemeriksaan_fisik_mata[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Konjungtivitis
	<input type="checkbox" name="pemeriksaan_fisik_mata_10" id="pemeriksaan_fisik_mata_10" value="1" <?php if(isset($arr_pemeriksaan_fisik_mata[9]) and $arr_pemeriksaan_fisik_mata[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Menggunakan alat bantu
	<input type="text" name="pemeriksaan_fisik_mata_11" id="pemeriksaan_fisik_mata_11" value="<?php if(isset($arr_pemeriksaan_fisik_mata[10])) echo $arr_pemeriksaan_fisik_mata[10]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>c. Telinga</td>
	<td colspan="2">&nbsp;</td>
</tr>	
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Simetris
	<input type="radio" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak simetris
	<input type="radio" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="3" <?php if(isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '3') echo 'checked="checked"'; ?> />
	<input type="text" name="pemeriksaan_fisik_telinga_2" id="pemeriksaan_fisik_telinga_2" value="<?php if(isset($arr_pemeriksaan_fisik_telinga[1])) echo $arr_pemeriksaan_fisik_telinga[1]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pendengaran</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_telinga_3" id="pemeriksaan_fisik_telinga_3" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[2]) and $arr_pemeriksaan_fisik_telinga[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Baik
	<input type="radio" name="pemeriksaan_fisik_telinga_3" id="pemeriksaan_fisik_telinga_3" value="2" <?php if(isset($arr_pemeriksaan_fisik_telinga[2]) and $arr_pemeriksaan_fisik_telinga[2] == '2') echo 'checked="checked"'; ?> />&nbsp;Kurang/ Tuli
	<input type="checkbox" name="pemeriksaan_fisik_telinga_4" id="pemeriksaan_fisik_telinga_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[3]) and $arr_pemeriksaan_fisik_telinga[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Kiri
	<input type="checkbox" name="pemeriksaan_fisik_telinga_5" id="pemeriksaan_fisik_telinga_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[4]) and $arr_pemeriksaan_fisik_telinga[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Kanan</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Lubang telinga</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Bersih
	<input type="radio" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="2" <?php if(isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '2') echo 'checked="checked"'; ?> />&nbsp;Kotor
	<input type="radio" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="3" <?php if(isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '3') echo 'checked="checked"'; ?> />&nbsp;Cerumen
	<input type="radio" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="4" <?php if(isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '4') echo 'checked="checked"'; ?> />&nbsp;Ada warna
	<input type="text" name="pemeriksaan_fisik_telinga_7" id="pemeriksaan_fisik_telinga_7" value="<?php if(isset($arr_pemeriksaan_fisik_telinga[6])) echo $arr_pemeriksaan_fisik_telinga[6]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Alat bantu dengar</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_telinga_8" id="pemeriksaan_fisik_telinga_8" value="1" <?php if(isset($arr_pemeriksaan_fisik_telinga[7]) and $arr_pemeriksaan_fisik_telinga[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="pemeriksaan_fisik_telinga_8" id="pemeriksaan_fisik_telinga_8" value="2" <?php if(isset($arr_pemeriksaan_fisik_telinga[7]) and $arr_pemeriksaan_fisik_telinga[7] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya, jenis alat bantu
	<input type="text" name="pemeriksaan_fisik_telinga_9" id="pemeriksaan_fisik_telinga_9" value="<?php if(isset($arr_pemeriksaan_fisik_telinga[8])) echo $arr_pemeriksaan_fisik_telinga[8]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>d. Hidung</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Simetris
	<input type="radio" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Pelana
	<input type="radio" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="3" <?php if(isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '3') echo 'checked="checked"'; ?> />&nbsp;Polip
	<input type="radio" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="4" <?php if(isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '4') echo 'checked="checked"'; ?> />&nbsp;Asimetris
	<input type="radio" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="5" <?php if(isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '5') echo 'checked="checked"'; ?> />&nbsp;Sadlenose</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Membran mukosa</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Kering
	<input type="radio" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="2" <?php if(isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '2') echo 'checked="checked"'; ?> />&nbsp;Lembab
	<input type="radio" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="3" <?php if(isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '3') echo 'checked="checked"'; ?> />&nbsp;Mengeluarkan
	<input type="checkbox" name="pemeriksaan_fisik_hidung_3" id="pemeriksaan_fisik_hidung_3" value="1" <?php if(isset($arr_pemeriksaan_fisik_hidung[2]) and $arr_pemeriksaan_fisik_hidung[2] == '1') echo 'checked="checked"'; ?> />&nbsp;lendir
	<input type="checkbox" name="pemeriksaan_fisik_hidung_4" id="pemeriksaan_fisik_hidung_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_hidung[3]) and $arr_pemeriksaan_fisik_hidung[3] == '1') echo 'checked="checked"'; ?> />&nbsp;darah</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kemampuan menghidu</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Baik
	<input type="radio" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="2" <?php if(isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak baik
	<input type="radio" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="3" <?php if(isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '3') echo 'checked="checked"'; ?> />&nbsp;Keluhan lain
	<input type="text" name="pemeriksaan_fisik_hidung_6" id="pemeriksaan_fisik_hidung_6" value="<?php if(isset($arr_pemeriksaan_fisik_hidung[5])) echo $arr_pemeriksaan_fisik_hidung[5]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>e. Mulut</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Rongga mulut</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_mulut_1" id="pemeriksaan_fisik_mulut_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[0]) and $arr_pemeriksaan_fisik_mulut[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Berbau
	<input type="radio" name="pemeriksaan_fisik_mulut_1" id="pemeriksaan_fisik_mulut_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_mulut[0]) and $arr_pemeriksaan_fisik_mulut[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak berbau</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Membran mukosa</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Warna
	<input type="text" name="pemeriksaan_fisik_mulut_3" id="pemeriksaan_fisik_mulut_3" value="<?php if(isset($arr_pemeriksaan_fisik_mulut[2])) echo $arr_pemeriksaan_fisik_mulut[2]; ?>" class="text_dt" style="width:280px;" />
	<input type="radio" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="2" <?php if(isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '2') echo 'checked="checked"'; ?> />&nbsp;Kering
	<input type="radio" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="3" <?php if(isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '3') echo 'checked="checked"'; ?> />&nbsp;Basah</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Lidah</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_mulut_4" id="pemeriksaan_fisik_mulut_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[3]) and $arr_pemeriksaan_fisik_mulut[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Kotor
	<input type="radio" name="pemeriksaan_fisik_mulut_4" id="pemeriksaan_fisik_mulut_4" value="2" <?php if(isset($arr_pemeriksaan_fisik_mulut[3]) and $arr_pemeriksaan_fisik_mulut[3] == '2') echo 'checked="checked"'; ?> />&nbsp;Bersih</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Gigi</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_mulut_5" id="pemeriksaan_fisik_mulut_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[4]) and $arr_pemeriksaan_fisik_mulut[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Caries
	<input type="radio" name="pemeriksaan_fisik_mulut_5" id="pemeriksaan_fisik_mulut_5" value="2" <?php if(isset($arr_pemeriksaan_fisik_mulut[4]) and $arr_pemeriksaan_fisik_mulut[4] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_mulut_6" id="pemeriksaan_fisik_mulut_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[5]) and $arr_pemeriksaan_fisik_mulut[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Palsu, jumlah gigi
	<input type="text" name="pemeriksaan_fisik_mulut_7" id="pemeriksaan_fisik_mulut_7" value="<?php if(isset($arr_pemeriksaan_fisik_mulut[6])) echo $arr_pemeriksaan_fisik_mulut[6]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tonsil</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_mulut_8" id="pemeriksaan_fisik_mulut_8" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[7]) and $arr_pemeriksaan_fisik_mulut[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada pembesaran
	<input type="radio" name="pemeriksaan_fisik_mulut_8" id="pemeriksaan_fisik_mulut_8" value="2" <?php if(isset($arr_pemeriksaan_fisik_mulut[7]) and $arr_pemeriksaan_fisik_mulut[7] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak ada
	<input type="checkbox" name="pemeriksaan_fisik_mulut_9" id="pemeriksaan_fisik_mulut_9" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[8]) and $arr_pemeriksaan_fisik_mulut[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Peradangan Labio Schizis</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelainan/ gangguan lain</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_mulut_10" id="pemeriksaan_fisik_mulut_10" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[9]) and $arr_pemeriksaan_fisik_mulut[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Palato Schizis
	<input type="checkbox" name="pemeriksaan_fisik_mulut_11" id="pemeriksaan_fisik_mulut_11" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[10]) and $arr_pemeriksaan_fisik_mulut[10] == '1') echo 'checked="checked"'; ?> />&nbsp;Stomatitis
	<input type="checkbox" name="pemeriksaan_fisik_mulut_12" id="pemeriksaan_fisik_mulut_12" value="1" <?php if(isset($arr_pemeriksaan_fisik_mulut[11]) and $arr_pemeriksaan_fisik_mulut[11] == '1') echo 'checked="checked"'; ?> />&nbsp;Pelo</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>f. Leher</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pergerakan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_leher_1" id="pemeriksaan_fisik_leher_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[0]) and $arr_pemeriksaan_fisik_leher[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Bebas
	<input type="radio" name="pemeriksaan_fisik_leher_1" id="pemeriksaan_fisik_leher_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_leher[0]) and $arr_pemeriksaan_fisik_leher[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Kaku
	<input type="checkbox" name="pemeriksaan_fisik_leher_2" id="pemeriksaan_fisik_leher_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[1]) and $arr_pemeriksaan_fisik_leher[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Benjolan
	<input type="text" name="pemeriksaan_fisik_leher_3" id="pemeriksaan_fisik_leher_3" value="<?php if(isset($arr_pemeriksaan_fisik_leher[2])) echo $arr_pemeriksaan_fisik_leher[2]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelenjar tiroid</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_leher_4" id="pemeriksaan_fisik_leher_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[3]) and $arr_pemeriksaan_fisik_leher[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Teraba
	<input type="radio" name="pemeriksaan_fisik_leher_4" id="pemeriksaan_fisik_leher_4" value="2" <?php if(isset($arr_pemeriksaan_fisik_leher[3]) and $arr_pemeriksaan_fisik_leher[3] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak teraba
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tekanan vena jugularis</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_leher_5" id="pemeriksaan_fisik_leher_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[4]) and $arr_pemeriksaan_fisik_leher[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Meningkat
	<input type="radio" name="pemeriksaan_fisik_leher_5" id="pemeriksaan_fisik_leher_5" value="2" <?php if(isset($arr_pemeriksaan_fisik_leher[4]) and $arr_pemeriksaan_fisik_leher[4] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Reflek menelan/ batuk</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_leher_6" id="pemeriksaan_fisik_leher_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[5]) and $arr_pemeriksaan_fisik_leher[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemeriksaan_fisik_leher_6" id="pemeriksaan_fisik_leher_6" value="2" <?php if(isset($arr_pemeriksaan_fisik_leher[5]) and $arr_pemeriksaan_fisik_leher[5] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_leher_7" id="pemeriksaan_fisik_leher_7" value="1" <?php if(isset($arr_pemeriksaan_fisik_leher[6]) and $arr_pemeriksaan_fisik_leher[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="pemeriksaan_fisik_leher_8" id="pemeriksaan_fisik_leher_8" value="<?php if(isset($arr_pemeriksaan_fisik_leher[7])) echo $arr_pemeriksaan_fisik_leher[7]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelainan/ gangguan lain</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="text" name="pemeriksaan_fisik_leher_9" id="pemeriksaan_fisik_leher_9" value="<?php if(isset($arr_pemeriksaan_fisik_leher[8])) echo $arr_pemeriksaan_fisik_leher[8]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>g. Thorax</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk dada</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="radio" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Pigeon chest
	<input type="radio" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="3" <?php if(isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '3') echo 'checked="checked"'; ?> />&nbsp;Funnel chest
	<input type="radio" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="4" <?php if(isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '4') echo 'checked="checked"'; ?> />&nbsp;Barrel chest
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pola napas</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Apnoe
	<input type="radio" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '2') echo 'checked="checked"'; ?> />&nbsp;Dispnea
	<input type="radio" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="3" <?php if(isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '3') echo 'checked="checked"'; ?> />&nbsp;Orthopnea
	<input type="radio" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="4" <?php if(isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '4') echo 'checked="checked"'; ?> />&nbsp;Lainnya
	<input type="text" name="pemeriksaan_fisik_thorax_3" id="pemeriksaan_fisik_thorax_3" value="<?php if(isset($arr_pemeriksaan_fisik_thorax[2])) echo $arr_pemeriksaan_fisik_thorax[2]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk tulang belakang</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="radio" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '2') echo 'checked="checked"'; ?> />&nbsp;Kiposis
	<input type="radio" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="3" <?php if(isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '3') echo 'checked="checked"'; ?> />&nbsp;Lordosis
	<input type="radio" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="4" <?php if(isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '4') echo 'checked="checked"'; ?> />&nbsp;Scoliosis
	<input type="radio" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="5" <?php if(isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '5') echo 'checked="checked"'; ?> />&nbsp;Gibus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Suara napas</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Vesikuler
	<input type="radio" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '2') echo 'checked="checked"'; ?> />&nbsp;Wheezzing
	<input type="radio" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="3" <?php if(isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '3') echo 'checked="checked"'; ?> />&nbsp;Ronchi
	(<input type="checkbox" name="pemeriksaan_fisik_thorax_6" id="pemeriksaan_fisik_thorax_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[5]) and $arr_pemeriksaan_fisik_thorax[5] == '1') echo 'checked="checked"'; ?> />&nbsp;L
	<input type="checkbox" name="pemeriksaan_fisik_thorax_7" id="pemeriksaan_fisik_thorax_7" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[6]) and $arr_pemeriksaan_fisik_thorax[6] == '2') echo 'checked="checked"'; ?> />&nbsp;R)
	<input type="radio" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="4" <?php if(isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '4') echo 'checked="checked"'; ?> />&nbsp;Reguler
	<input type="radio" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="5" <?php if(isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '5') echo 'checked="checked"'; ?> />&nbsp;Ireguler
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Perkusi</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Sonor
	<input type="radio" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '2') echo 'checked="checked"'; ?> />&nbsp;Redup
	<input type="radio" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="3" <?php if(isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '3') echo 'checked="checked"'; ?> />&nbsp;Pekak
	<input type="radio" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="4" <?php if(isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '4') echo 'checked="checked"'; ?> />&nbsp;Hipersonor
	<input type="radio" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="5" <?php if(isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '5') echo 'checked="checked"'; ?> />&nbsp;Tympan
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Batuk</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_9" id="pemeriksaan_fisik_thorax_9" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[8]) and $arr_pemeriksaan_fisik_thorax[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Produktif
	<input type="radio" name="pemeriksaan_fisik_thorax_9" id="pemeriksaan_fisik_thorax_9" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[8]) and $arr_pemeriksaan_fisik_thorax[8] == '2') echo 'checked="checked"'; ?> />&nbsp;Non produktif
	<input type="radio" name="pemeriksaan_fisik_thorax_10" id="pemeriksaan_fisik_thorax_10" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[9]) and $arr_pemeriksaan_fisik_thorax[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Warna sputum
	<input type="text" name="pemeriksaan_fisik_thorax_11" id="pemeriksaan_fisik_thorax_11" value="<?php if(isset($arr_pemeriksaan_fisik_thorax[10])) echo $arr_pemeriksaan_fisik_thorax[10]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Payudara</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_thorax_12" id="pemeriksaan_fisik_thorax_12" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[11]) and $arr_pemeriksaan_fisik_thorax[11] == '1') echo 'checked="checked"'; ?> />&nbsp;Simetris
	<input type="radio" name="pemeriksaan_fisik_thorax_12" id="pemeriksaan_fisik_thorax_12" value="2" <?php if(isset($arr_pemeriksaan_fisik_thorax[11]) and $arr_pemeriksaan_fisik_thorax[11] == '2') echo 'checked="checked"'; ?> />&nbsp;Asimetris
	<input type="checkbox" name="pemeriksaan_fisik_thorax_13" id="pemeriksaan_fisik_thorax_13" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[12]) and $arr_pemeriksaan_fisik_thorax[12] == '1') echo 'checked="checked"'; ?> />&nbsp;Pembesaran
	(<input type="checkbox" name="pemeriksaan_fisik_thorax_14" id="pemeriksaan_fisik_thorax_14" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[13]) and $arr_pemeriksaan_fisik_thorax[13] == '1') echo 'checked="checked"'; ?> />&nbsp;Kanan
	<input type="checkbox" name="pemeriksaan_fisik_thorax_15" id="pemeriksaan_fisik_thorax_15" value="1" <?php if(isset($arr_pemeriksaan_fisik_thorax[14]) and $arr_pemeriksaan_fisik_thorax[14] == '1') echo 'checked="checked"'; ?> />&nbsp;Kiri)
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>h. Abdomen</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_abdomen_1" id="pemeriksaan_fisik_abdomen_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[0]) and $arr_pemeriksaan_fisik_abdomen[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Kembung
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_2" id="pemeriksaan_fisik_abdomen_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[1]) and $arr_pemeriksaan_fisik_abdomen[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Distensi
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_3" id="pemeriksaan_fisik_abdomen_3" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[2]) and $arr_pemeriksaan_fisik_abdomen[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Datar
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_4" id="pemeriksaan_fisik_abdomen_4" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[3]) and $arr_pemeriksaan_fisik_abdomen[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Asites
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_5" id="pemeriksaan_fisik_abdomen_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[4]) and $arr_pemeriksaan_fisik_abdomen[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Konstipasi
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_6" id="pemeriksaan_fisik_abdomen_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[5]) and $arr_pemeriksaan_fisik_abdomen[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Flatus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
	<td colspan="2">Bising usus <input type="text" name="pemeriksaan_fisik_abdomen_7" id="pemeriksaan_fisik_abdomen_7" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[6])) echo $arr_pemeriksaan_fisik_abdomen[6]; ?>" class="text_dt" />x/mnt,
	Lingkar perut <input type="text" name="pemeriksaan_fisik_abdomen_8" id="pemeriksaan_fisik_abdomen_8" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[7])) echo $arr_pemeriksaan_fisik_abdomen[7]; ?>" class="text_dt" />cm<br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_9" id="pemeriksaan_fisik_abdomen_9" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[8]) and $arr_pemeriksaan_fisik_abdomen[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Nyeri
	(<input type="checkbox" name="pemeriksaan_fisik_abdomen_10" id="pemeriksaan_fisik_abdomen_10" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[9]) and $arr_pemeriksaan_fisik_abdomen[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Tekan
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_11" id="pemeriksaan_fisik_abdomen_11" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[10]) and $arr_pemeriksaan_fisik_abdomen[10] == '1') echo 'checked="checked"'; ?> />&nbsp;Lepas),
	Kwadran <input type="text" name="pemeriksaan_fisik_abdomen_12" id="pemeriksaan_fisik_abdomen_12" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[11])) echo $arr_pemeriksaan_fisik_abdomen[11]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pembesaran kelenjar</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_abdomen_13" id="pemeriksaan_fisik_abdomen_13" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[12]) and $arr_pemeriksaan_fisik_abdomen[12] == '1') echo 'checked="checked"'; ?> />&nbsp;Inguinalis
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_14" id="pemeriksaan_fisik_abdomen_14" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[13]) and $arr_pemeriksaan_fisik_abdomen[13] == '1') echo 'checked="checked"'; ?> />&nbsp;Umbilikus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>i. Genitalia</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="text" name="pemeriksaan_fisik_abdomen_15" id="pemeriksaan_fisik_abdomen_15" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[14])) echo $arr_pemeriksaan_fisik_abdomen[14]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Hemoroid</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_16" id="pemeriksaan_fisik_abdomen_16" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[15]) and $arr_pemeriksaan_fisik_abdomen[15] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemeriksaan_fisik_abdomen_16" id="pemeriksaan_fisik_abdomen_16" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[15]) and $arr_pemeriksaan_fisik_abdomen[15] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Anus (<input type="radio" name="pemeriksaan_fisik_abdomen_17" id="pemeriksaan_fisik_abdomen_17" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[16]) and $arr_pemeriksaan_fisik_abdomen[16] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemeriksaan_fisik_abdomen_17" id="pemeriksaan_fisik_abdomen_17" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[16]) and $arr_pemeriksaan_fisik_abdomen[16] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak)
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Laki-laki, Scrotum</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_18" id="pemeriksaan_fisik_abdomen_18" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[17]) and $arr_pemeriksaan_fisik_abdomen[17] == '1') echo 'checked="checked"'; ?> />&nbsp;Simetris
	<input type="radio" name="pemeriksaan_fisik_abdomen_18" id="pemeriksaan_fisik_abdomen_18" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[17]) and $arr_pemeriksaan_fisik_abdomen[17] == '2') echo 'checked="checked"'; ?> />&nbsp;Asimetris
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_19" id="pemeriksaan_fisik_abdomen_19" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[18]) and $arr_pemeriksaan_fisik_abdomen[18] == '1') echo 'checked="checked"'; ?> />&nbsp;Pembesaran
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_20" id="pemeriksaan_fisik_abdomen_20" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[19]) and $arr_pemeriksaan_fisik_abdomen[19] == '1') echo 'checked="checked"'; ?> />&nbsp;Luka
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_21" id="pemeriksaan_fisik_abdomen_21" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[20]) and $arr_pemeriksaan_fisik_abdomen[20] == '1') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="pemeriksaan_fisik_abdomen_22" id="pemeriksaan_fisik_abdomen_22" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[21])) echo $arr_pemeriksaan_fisik_abdomen[21]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Wanita</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengeluaran secret berlebih</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_23" id="pemeriksaan_fisik_abdomen_23" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[22]) and $arr_pemeriksaan_fisik_abdomen[22] == '1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemeriksaan_fisik_abdomen_23" id="pemeriksaan_fisik_abdomen_23" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[22]) and $arr_pemeriksaan_fisik_abdomen[22] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_24" id="pemeriksaan_fisik_abdomen_24" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[23]) and $arr_pemeriksaan_fisik_abdomen[23] == '1') echo 'checked="checked"'; ?> />&nbsp;Berbau
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_25" id="pemeriksaan_fisik_abdomen_25" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[24]) and $arr_pemeriksaan_fisik_abdomen[24] == '1') echo 'checked="checked"'; ?> />&nbsp;Warna
	<input type="text" name="pemeriksaan_fisik_abdomen_26" id="pemeriksaan_fisik_abdomen_26" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[25])) echo $arr_pemeriksaan_fisik_abdomen[25]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Haid</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_27" id="pemeriksaan_fisik_abdomen_27" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[26]) and $arr_pemeriksaan_fisik_abdomen[26] == '1') echo 'checked="checked"'; ?> />&nbsp;Teratur
	<input type="radio" name="pemeriksaan_fisik_abdomen_27" id="pemeriksaan_fisik_abdomen_27" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[26]) and $arr_pemeriksaan_fisik_abdomen[26] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak teratur
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_28" id="pemeriksaan_fisik_abdomen_28" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[27]) and $arr_pemeriksaan_fisik_abdomen[27] == '1') echo 'checked="checked"'; ?> />&nbsp;Amenorhea
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_29" id="pemeriksaan_fisik_abdomen_29" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[28]) and $arr_pemeriksaan_fisik_abdomen[28] == '1') echo 'checked="checked"'; ?> />&nbsp;Dismenorhea
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hamil</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_30" id="pemeriksaan_fisik_abdomen_30" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[29]) and $arr_pemeriksaan_fisik_abdomen[29] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="pemeriksaan_fisik_abdomen_30" id="pemeriksaan_fisik_abdomen_30" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[29]) and $arr_pemeriksaan_fisik_abdomen[29] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya,
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_31" id="pemeriksaan_fisik_abdomen_31" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[30]) and $arr_pemeriksaan_fisik_abdomen[30] == '1') echo 'checked="checked"'; ?> />
	G <input type="text" name="pemeriksaan_fisik_abdomen_32" id="pemeriksaan_fisik_abdomen_32" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[31])) echo $arr_pemeriksaan_fisik_abdomen[31]; ?>" class="text_dt" />
	P <input type="text" name="pemeriksaan_fisik_abdomen_33" id="pemeriksaan_fisik_abdomen_33" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[32])) echo $arr_pemeriksaan_fisik_abdomen[32]; ?>" class="text_dt" />
	Ab <input type="text" name="pemeriksaan_fisik_abdomen_34" id="pemeriksaan_fisik_abdomen_34" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[33])) echo $arr_pemeriksaan_fisik_abdomen[33]; ?>" class="text_dt" /><br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_35" id="pemeriksaan_fisik_abdomen_35" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[34]) and $arr_pemeriksaan_fisik_abdomen[34] == '1') echo 'checked="checked"'; ?> />&nbsp;Usia
	<input type="text" name="pemeriksaan_fisik_abdomen_36" id="pemeriksaan_fisik_abdomen_36" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[35])) echo $arr_pemeriksaan_fisik_abdomen[35]; ?>" class="text_dt" />minggu,
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_37" id="pemeriksaan_fisik_abdomen_37" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[36]) and $arr_pemeriksaan_fisik_abdomen[36] == '1') echo 'checked="checked"'; ?> />&nbsp;Taksiran partus
	<input type="text" name="pemeriksaan_fisik_abdomen_38" id="pemeriksaan_fisik_abdomen_38" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[37])) echo $arr_pemeriksaan_fisik_abdomen[37]; ?>" class="text_dt" /><br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_39" id="pemeriksaan_fisik_abdomen_39" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[38]) and $arr_pemeriksaan_fisik_abdomen[38] == '1') echo 'checked="checked"'; ?> />&nbsp;HPHT
	<input type="text" name="pemeriksaan_fisik_abdomen_40" id="pemeriksaan_fisik_abdomen_40" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[39])) echo $arr_pemeriksaan_fisik_abdomen[39]; ?>" class="text_dt" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kontrasepsi</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="pemeriksaan_fisik_abdomen_41" id="pemeriksaan_fisik_abdomen_41" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[40]) and $arr_pemeriksaan_fisik_abdomen[40] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="pemeriksaan_fisik_abdomen_41" id="pemeriksaan_fisik_abdomen_41" value="2" <?php if(isset($arr_pemeriksaan_fisik_abdomen[40]) and $arr_pemeriksaan_fisik_abdomen[40] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya,
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_42" id="pemeriksaan_fisik_abdomen_42" value="1" <?php if(isset($arr_pemeriksaan_fisik_abdomen[41]) and $arr_pemeriksaan_fisik_abdomen[41] == '1') echo 'checked="checked"'; ?> />&nbsp;Jenis KB
	<input type="text" name="pemeriksaan_fisik_abdomen_43" id="pemeriksaan_fisik_abdomen_43" value="<?php if(isset($arr_pemeriksaan_fisik_abdomen[42])) echo $arr_pemeriksaan_fisik_abdomen[42]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td><strong>j. Extremitas</strong></td>
	<td colspan="2">:&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td colspan="2">
		<table>
			<tr>
				<td></td>
				<td>Eks. Atas (Ka)</td>
				<td>Eks. Atas (Ki)</td>
				<td>Eks. Bawah (Ka)</td>
				<td>Eks. Bawah (Ki)</td>
			</tr>
			<tr>
				<td>Nyeri (1-5)</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_1" id="pemeriksaan_fisik_ekstremitas_1" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[0])) echo $arr_pemeriksaan_fisik_ekstremitas[0]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_2" id="pemeriksaan_fisik_ekstremitas_2" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[1])) echo $arr_pemeriksaan_fisik_ekstremitas[1]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_3" id="pemeriksaan_fisik_ekstremitas_3" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[2])) echo $arr_pemeriksaan_fisik_ekstremitas[2]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_4" id="pemeriksaan_fisik_ekstremitas_4" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[3])) echo $arr_pemeriksaan_fisik_ekstremitas[3]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
			<tr>
				<td>Kelemahan</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_5" id="pemeriksaan_fisik_ekstremitas_5" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[4])) echo $arr_pemeriksaan_fisik_ekstremitas[4]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_6" id="pemeriksaan_fisik_ekstremitas_6" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[5])) echo $arr_pemeriksaan_fisik_ekstremitas[5]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_7" id="pemeriksaan_fisik_ekstremitas_7" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[6])) echo $arr_pemeriksaan_fisik_ekstremitas[6]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_8" id="pemeriksaan_fisik_ekstremitas_8" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[7])) echo $arr_pemeriksaan_fisik_ekstremitas[7]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
			<tr>
				<td>Kekuatan (0-5)</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_9" id="pemeriksaan_fisik_ekstremitas_9" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[8])) echo $arr_pemeriksaan_fisik_ekstremitas[8]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_10" id="pemeriksaan_fisik_ekstremitas_10" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[9])) echo $arr_pemeriksaan_fisik_ekstremitas[9]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_11" id="pemeriksaan_fisik_ekstremitas_11" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[10])) echo $arr_pemeriksaan_fisik_ekstremitas[10]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_12" id="pemeriksaan_fisik_ekstremitas_12" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[11])) echo $arr_pemeriksaan_fisik_ekstremitas[11]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
			<tr>
				<td>Fleksi/ Ekstensi</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_13" id="pemeriksaan_fisik_ekstremitas_13" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[12])) echo $arr_pemeriksaan_fisik_ekstremitas[12]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_14" id="pemeriksaan_fisik_ekstremitas_14" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[13])) echo $arr_pemeriksaan_fisik_ekstremitas[13]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_15" id="pemeriksaan_fisik_ekstremitas_15" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[14])) echo $arr_pemeriksaan_fisik_ekstremitas[14]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_16" id="pemeriksaan_fisik_ekstremitas_16" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[15])) echo $arr_pemeriksaan_fisik_ekstremitas[15]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
			<tr>
				<td>Inflamasi</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_17" id="pemeriksaan_fisik_ekstremitas_17" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[16])) echo $arr_pemeriksaan_fisik_ekstremitas[16]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_18" id="pemeriksaan_fisik_ekstremitas_18" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[17])) echo $arr_pemeriksaan_fisik_ekstremitas[17]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_19" id="pemeriksaan_fisik_ekstremitas_19" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[18])) echo $arr_pemeriksaan_fisik_ekstremitas[18]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_20" id="pemeriksaan_fisik_ekstremitas_20" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[19])) echo $arr_pemeriksaan_fisik_ekstremitas[19]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
			<tr>
				<td>Fraktur</td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_21" id="pemeriksaan_fisik_ekstremitas_21" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[20])) echo $arr_pemeriksaan_fisik_ekstremitas[20]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_22" id="pemeriksaan_fisik_ekstremitas_22" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[21])) echo $arr_pemeriksaan_fisik_ekstremitas[21]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_23" id="pemeriksaan_fisik_ekstremitas_23" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[22])) echo $arr_pemeriksaan_fisik_ekstremitas[22]; ?>" class="text_dt" style="width:100px;" /></td>
				<td><input type="text" name="pemeriksaan_fisik_ekstremitas_24" id="pemeriksaan_fisik_ekstremitas_24" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[23])) echo $arr_pemeriksaan_fisik_ekstremitas[23]; ?>" class="text_dt" style="width:100px;" /></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tangan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_ekstremitas_25" id="pemeriksaan_fisik_ekstremitas_25" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[24]) and $arr_pemeriksaan_fisik_ekstremitas[24] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_26" id="pemeriksaan_fisik_ekstremitas_26" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[25]) and $arr_pemeriksaan_fisik_ekstremitas[25] == '1') echo 'checked="checked"'; ?> />&nbsp;Lumpuh
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_27" id="pemeriksaan_fisik_ekstremitas_27" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[26]) and $arr_pemeriksaan_fisik_ekstremitas[26] == '1') echo 'checked="checked"'; ?> />&nbsp;Clawhand
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_28" id="pemeriksaan_fisik_ekstremitas_28" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[27]) and $arr_pemeriksaan_fisik_ekstremitas[27] == '1') echo 'checked="checked"'; ?> />&nbsp;Drophand
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_29" id="pemeriksaan_fisik_ekstremitas_29" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[28]) and $arr_pemeriksaan_fisik_ekstremitas[28] == '1') echo 'checked="checked"'; ?> />&nbsp;Kontraktur
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_30" id="pemeriksaan_fisik_ekstremitas_30" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[29]) and $arr_pemeriksaan_fisik_ekstremitas[29] == '1') echo 'checked="checked"'; ?> />&nbsp;Atropsi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_31" id="pemeriksaan_fisik_ekstremitas_31" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[30]) and $arr_pemeriksaan_fisik_ekstremitas[30] == '1') echo 'checked="checked"'; ?> />&nbsp;Anastesi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_32" id="pemeriksaan_fisik_ekstremitas_32" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[31]) and $arr_pemeriksaan_fisik_ekstremitas[31] == '1') echo 'checked="checked"'; ?> />&nbsp;Absorbsi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_33" id="pemeriksaan_fisik_ekstremitas_33" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[32]) and $arr_pemeriksaan_fisik_ekstremitas[32] == '1') echo 'checked="checked"'; ?> />&nbsp;Mutilasi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_34" id="pemeriksaan_fisik_ekstremitas_34" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[33]) and $arr_pemeriksaan_fisik_ekstremitas[33] == '1') echo 'checked="checked"'; ?> />&nbsp;Oedema
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_35" id="pemeriksaan_fisik_ekstremitas_35" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[34]) and $arr_pemeriksaan_fisik_ekstremitas[34] == '1') echo 'checked="checked"'; ?> />&nbsp;Luka
	<input type="text" name="pemeriksaan_fisik_ekstremitas_36" id="pemeriksaan_fisik_ekstremitas_36" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[35])) echo $arr_pemeriksaan_fisik_ekstremitas[35]; ?>" class="text_dt" /><br/>
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_37" id="pemeriksaan_fisik_ekstremitas_37" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[36]) and $arr_pemeriksaan_fisik_ekstremitas[36] == '1') echo 'checked="checked"'; ?> />&nbsp;Banana fingers
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_38" id="pemeriksaan_fisik_ekstremitas_38" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[37]) and $arr_pemeriksaan_fisik_ekstremitas[37] == '1') echo 'checked="checked"'; ?> />&nbsp;Tremor
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_39" id="pemeriksaan_fisik_ekstremitas_39" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[38]) and $arr_pemeriksaan_fisik_ekstremitas[38] == '1') echo 'checked="checked"'; ?> />&nbsp;Atropi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_40" id="pemeriksaan_fisik_ekstremitas_40" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[39]) and $arr_pemeriksaan_fisik_ekstremitas[39] == '1') echo 'checked="checked"'; ?> />&nbsp;Alat bantu
	<input type="text" name="pemeriksaan_fisik_ekstremitas_41" id="pemeriksaan_fisik_ekstremitas_41" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[40])) echo $arr_pemeriksaan_fisik_ekstremitas[40]; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kaki</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_ekstremitas_42" id="pemeriksaan_fisik_ekstremitas_42" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[41]) and $arr_pemeriksaan_fisik_ekstremitas[41] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_43" id="pemeriksaan_fisik_ekstremitas_43" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[42]) and $arr_pemeriksaan_fisik_ekstremitas[42] == '1') echo 'checked="checked"'; ?> />&nbsp;Lumpuh
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_44" id="pemeriksaan_fisik_ekstremitas_44" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[43]) and $arr_pemeriksaan_fisik_ekstremitas[43] == '1') echo 'checked="checked"'; ?> />&nbsp;Dropfoot
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_45" id="pemeriksaan_fisik_ekstremitas_45" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[44]) and $arr_pemeriksaan_fisik_ekstremitas[44] == '1') echo 'checked="checked"'; ?> />&nbsp;Kontraktur
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_46" id="pemeriksaan_fisik_ekstremitas_46" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[45]) and $arr_pemeriksaan_fisik_ekstremitas[45] == '1') echo 'checked="checked"'; ?> />&nbsp;Clawfoot
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_47" id="pemeriksaan_fisik_ekstremitas_47" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[46]) and $arr_pemeriksaan_fisik_ekstremitas[46] == '1') echo 'checked="checked"'; ?> />&nbsp;Atropi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_48" id="pemeriksaan_fisik_ekstremitas_48" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[47]) and $arr_pemeriksaan_fisik_ekstremitas[47] == '1') echo 'checked="checked"'; ?> />&nbsp;Absorbsi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_49" id="pemeriksaan_fisik_ekstremitas_49" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[48]) and $arr_pemeriksaan_fisik_ekstremitas[48] == '1') echo 'checked="checked"'; ?> />&nbsp;Oedema
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_50" id="pemeriksaan_fisik_ekstremitas_50" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[49]) and $arr_pemeriksaan_fisik_ekstremitas[49] == '1') echo 'checked="checked"'; ?> />&nbsp;Anastesi
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_51" id="pemeriksaan_fisik_ekstremitas_51" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[50]) and $arr_pemeriksaan_fisik_ekstremitas[50] == '1') echo 'checked="checked"'; ?> />&nbsp;Luka
	<input type="text" name="pemeriksaan_fisik_ekstremitas_52" id="pemeriksaan_fisik_ekstremitas_52" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[51])) echo $arr_pemeriksaan_fisik_ekstremitas[51]; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Alat Bantu</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_ekstremitas_53" id="pemeriksaan_fisik_ekstremitas_53" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[52]) and $arr_pemeriksaan_fisik_ekstremitas[52] == '1') echo 'checked="checked"'; ?> />&nbsp;Kaki palsu
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_54" id="pemeriksaan_fisik_ekstremitas_54" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[53]) and $arr_pemeriksaan_fisik_ekstremitas[53] == '1') echo 'checked="checked"'; ?> />&nbsp;Sandal khusus
	<input type="text" name="pemeriksaan_fisik_ekstremitas_55" id="pemeriksaan_fisik_ekstremitas_55" value="<?php if(isset($arr_pemeriksaan_fisik_ekstremitas[54])) echo $arr_pemeriksaan_fisik_ekstremitas[54]; ?>" class="text_dt" />
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_56" id="pemeriksaan_fisik_ekstremitas_56" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[55]) and $arr_pemeriksaan_fisik_ekstremitas[55] == '1') echo 'checked="checked"'; ?> />&nbsp;Kursi Roda
	<input type="checkbox" name="pemeriksaan_fisik_ekstremitas_57" id="pemeriksaan_fisik_ekstremitas_57" value="1" <?php if(isset($arr_pemeriksaan_fisik_ekstremitas[56]) and $arr_pemeriksaan_fisik_ekstremitas[56] == '1') echo 'checked="checked"'; ?> />&nbsp;Tongkat
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>k. Kulit</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">Warna <input type="text" name="pemeriksaan_fisik_kulit_4" id="pemeriksaan_fisik_kulit_4" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[3])) echo $arr_pemeriksaan_fisik_kulit[3]; ?>" class="text_dt" />
	<input type="checkbox" name="pemeriksaan_fisik_kulit_1" id="pemeriksaan_fisik_kulit_1" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[0]) and $arr_pemeriksaan_fisik_kulit[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="radio" name="pemeriksaan_fisik_kulit_2" id="pemeriksaan_fisik_kulit_2" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[1]) and $arr_pemeriksaan_fisik_kulit[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Lembab
	<input type="radio" name="pemeriksaan_fisik_kulit_2" id="pemeriksaan_fisik_kulit_2" value="2" <?php if(isset($arr_pemeriksaan_fisik_kulit[1]) and $arr_pemeriksaan_fisik_kulit[1] == '2') echo 'checked="checked"'; ?> />&nbsp;Kering
	<input type="radio" name="pemeriksaan_fisik_kulit_3" id="pemeriksaan_fisik_kulit_3" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[2]) and $arr_pemeriksaan_fisik_kulit[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Hangat
	<input type="radio" name="pemeriksaan_fisik_kulit_3" id="pemeriksaan_fisik_kulit_3" value="2" <?php if(isset($arr_pemeriksaan_fisik_kulit[2]) and $arr_pemeriksaan_fisik_kulit[2] == '2') echo 'checked="checked"'; ?> />&nbsp;Dingin
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_kulit_5" id="pemeriksaan_fisik_kulit_5" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[4]) and $arr_pemeriksaan_fisik_kulit[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Bersisik
	<input type="checkbox" name="pemeriksaan_fisik_kulit_6" id="pemeriksaan_fisik_kulit_6" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[5]) and $arr_pemeriksaan_fisik_kulit[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Makula
	<input type="text" name="pemeriksaan_fisik_kulit_7" id="pemeriksaan_fisik_kulit_7" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[6])) echo $arr_pemeriksaan_fisik_kulit[6]; ?>" class="text_dt" />
	<input type="checkbox" name="pemeriksaan_fisik_kulit_8" id="pemeriksaan_fisik_kulit_8" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[7]) and $arr_pemeriksaan_fisik_kulit[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Bercak putih
	<input type="text" name="pemeriksaan_fisik_kulit_9" id="pemeriksaan_fisik_kulit_9" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[8])) echo $arr_pemeriksaan_fisik_kulit[8]; ?>" class="text_dt" /><br/></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
	<td colspan="2"><input type="checkbox" name="pemeriksaan_fisik_kulit_10" id="pemeriksaan_fisik_kulit_10" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[9]) and $arr_pemeriksaan_fisik_kulit[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Modul
	<input type="checkbox" name="pemeriksaan_fisik_kulit_11" id="pemeriksaan_fisik_kulit_11" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[10]) and $arr_pemeriksaan_fisik_kulit[10] == '1') echo 'checked="checked"'; ?> />&nbsp;Erhytema
	<input type="text" name="pemeriksaan_fisik_kulit_12" id="pemeriksaan_fisik_kulit_12" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[11])) echo $arr_pemeriksaan_fisik_kulit[11]; ?>" class="text_dt" />
	<input type="checkbox" name="pemeriksaan_fisik_kulit_13" id="pemeriksaan_fisik_kulit_13" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[12]) and $arr_pemeriksaan_fisik_kulit[12] == '1') echo 'checked="checked"'; ?> />&nbsp;Infiltrat
	<input type="text" name="pemeriksaan_fisik_kulit_14" id="pemeriksaan_fisik_kulit_14" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[13])) echo $arr_pemeriksaan_fisik_kulit[13]; ?>" class="text_dt" /><br/></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
	<td colspan="2">Luka <input type="text" name="pemeriksaan_fisik_kulit_15" id="pemeriksaan_fisik_kulit_15" value="<?php if(isset($arr_pemeriksaan_fisik_kulit[14])) echo $arr_pemeriksaan_fisik_kulit[14]; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10px;" valign="top"></td>
	<td colspan="2">Tugor <input type="radio" name="pemeriksaan_fisik_kulit_16" id="pemeriksaan_fisik_kulit_16" value="1" <?php if(isset($arr_pemeriksaan_fisik_kulit[15]) and $arr_pemeriksaan_fisik_kulit[15] == '1') echo 'checked="checked"'; ?> />&nbsp;Elastis
	<input type="radio" name="pemeriksaan_fisik_kulit_16" id="pemeriksaan_fisik_kulit_16" value="2" <?php if(isset($arr_pemeriksaan_fisik_kulit[15]) and $arr_pemeriksaan_fisik_kulit[15] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak Elastis</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>6. PENAPISAN/ SKRINING GIZI (skrining gizi berdasarkan MST)</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">
	<table border="0">
		<tr>
			<td><strong>Parameter</strong></td>
			<td align="right"><strong>Skor</strong></td>
		</tr>
		<tr>
			<td>1. Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 3 bulan terakhir ?</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Tidak ada penurunan berat badan</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_1" id="skrining_gizi_1" value="1" <?php 
			$total_skor = 0;
			if(isset($arr_skrining_gizi[0]) and $arr_skrining_gizi[0] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 0;
			} ?> />&nbsp;0</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Tidak yakin/ tidak tahu/ terasa baju lebih longgar</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_2" id="skrining_gizi_2" value="1" <?php 
			if(isset($arr_skrining_gizi[1]) and $arr_skrining_gizi[1] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 2;
			} ?> />&nbsp;2</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Jika ya, berapa penurunan berat badan tersebut</td>
			<td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1 - 5 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_3" id="skrining_gizi_3" value="1" <?php 
			if(isset($arr_skrining_gizi[2]) and $arr_skrining_gizi[2] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 1;
			} ?> />&nbsp;1</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6 - 10 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_4" id="skrining_gizi_4" value="1" <?php 
			if(isset($arr_skrining_gizi[3]) and $arr_skrining_gizi[3] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 2;
			} ?> />&nbsp;2</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11 - 15 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_5" id="skrining_gizi_5" value="1" <?php 
			if(isset($arr_skrining_gizi[4]) and $arr_skrining_gizi[4] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 3;
			} ?> />&nbsp;3</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;> 15 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_6" id="skrining_gizi_6" value="1" <?php 
			if(isset($arr_skrining_gizi[5]) and $arr_skrining_gizi[5] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 4;
			} ?> />&nbsp;4</td>
		</tr>
		<tr>
			<td>2. Apakah asupan makanan berkurang karena tidak nafsu makan ?</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Tidak</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_7" id="skrining_gizi_7" value="1" <?php 
			if(isset($arr_skrining_gizi[6]) and $arr_skrining_gizi[6] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 0;
			} ?> />&nbsp;0</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Ya</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_8" id="skrining_gizi_8" value="1" <?php 
			if(isset($arr_skrining_gizi[7]) and $arr_skrining_gizi[7] == '1') {
				echo 'checked="checked"';
				$total_skor = $total_skor + 1;
			} ?> />&nbsp;1</td>
		</tr>
		<tr>
			<td>(Bila skor >= 2 dilakukan pengkajian lanjut oleh ahli gizi)</td>
			<td align="right">Total Skor :&nbsp;&nbsp;<?php echo $total_skor; ?></td>
		</tr>
	</table>
	</td>
  </tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>7. STATUS FUNGSIONAL</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">Aktivitas dan mobilisasi (Lampiran Formulir Pengkajian Status Fungsional Barthel Index)<br />
	<input type="radio" name="status_fungsional" id="status_fungsional" value="1" <?php if($status_fungsional == '1') echo 'checked="checked"'; ?> />&nbsp;Mandiri
	<input type="radio" name="status_fungsional" id="status_fungsional" value="2" <?php if($status_fungsional == '2') echo 'checked="checked"'; ?> />&nbsp;Perlu bantuan, sebutkan
	<input type="text" name="status_fungsional_ket" id="status_fungsional_ket" value="<?php echo $status_fungsional_ket; ?>" class="text_dt" style="width:280px;" />
	<input type="radio" name="status_fungsional" id="status_fungsional" value="3" <?php if($status_fungsional == '3') echo 'checked="checked"'; ?> />&nbsp;Ketergantungan total<br />
	(Bila ketergantungan total kolaborasi ke DPJP/ PPDS untuk konsul ke Rehabilitasi Medik)
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>8. RISIKO CEDERA/ JATUH (Gunakan Fornulir Penilaian Risiko Jatuh sesuai usia untuk penilaian)</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">
	<input type="radio" name="risiko_cedera_1" id="risiko_cedera_1" value="1" <?php if(isset($arr_risiko_cedera[0]) and $arr_risiko_cedera[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="risiko_cedera_1" id="risiko_cedera_1" value="2" <?php if(isset($arr_risiko_cedera[0]) and $arr_risiko_cedera[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya,
	bila ya isi formulir pemantauan pencegahan jatuh sesuai usia (Dewasa, Geriatri) sesuai kebutuhan. Jika ya, gelang risiko jatuh (di pasien) dan segitiga
	(di tempat tidur/ brankar/ kursi roda) warna kuning terpasang
	<input type="checkbox" name="risiko_cedera_2" id="risiko_cedera_2" value="1" <?php if(isset($arr_risiko_cedera[1]) and $arr_risiko_cedera[1] == '1') echo 'checked="checked"'; ?> /><br />
	Diberitahukan ke dokter <input type="radio" name="risiko_cedera_3" id="risiko_cedera_3" value="1" <?php if(isset($arr_risiko_cedera[2]) and $arr_risiko_cedera[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Ya, Pukul
	<input type="text" name="risiko_cedera_4" id="risiko_cedera_4" value="<?php if(isset($arr_risiko_cedera[3])) echo $arr_risiko_cedera[3]; ?>" class="text_dt" />
	<input type="radio" name="risiko_cedera_3" id="risiko_cedera_3" value="2" <?php if(isset($arr_risiko_cedera[2]) and $arr_risiko_cedera[2] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Riwayat Jatuh</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="risiko_cedera_5" id="risiko_cedera_5" value="1" <?php if(isset($arr_risiko_cedera[4]) and $arr_risiko_cedera[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Ya
	<input type="radio" name="risiko_cedera_5" id="risiko_cedera_5" value="2" <?php if(isset($arr_risiko_cedera[4]) and $arr_risiko_cedera[4] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Alat Bantu</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="risiko_cedera_6" id="risiko_cedera_6" value="1" <?php if(isset($arr_risiko_cedera[5]) and $arr_risiko_cedera[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Kursi roda
	<input type="checkbox" name="risiko_cedera_7" id="risiko_cedera_7" value="1" <?php if(isset($arr_risiko_cedera[6]) and $arr_risiko_cedera[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Kruk
	<input type="checkbox" name="risiko_cedera_8" id="risiko_cedera_8" value="1" <?php if(isset($arr_risiko_cedera[7]) and $arr_risiko_cedera[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Sandal MCR
	<input type="checkbox" name="risiko_cedera_9" id="risiko_cedera_9" value="1" <?php if(isset($arr_risiko_cedera[8]) and $arr_risiko_cedera[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Sandal FDS
	<input type="checkbox" name="risiko_cedera_10" id="risiko_cedera_10" value="1" <?php if(isset($arr_risiko_cedera[9]) and $arr_risiko_cedera[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Kaki palsu
	<input type="checkbox" name="risiko_cedera_11" id="risiko_cedera_11" value="1" <?php if(isset($arr_risiko_cedera[10]) and $arr_risiko_cedera[10] == '1') echo 'checked="checked"'; ?> />&nbsp;Tangan palsu</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Terpasang infus</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="radio" name="risiko_cedera_12" id="risiko_cedera_12" value="1" <?php if(isset($arr_risiko_cedera[11]) and $arr_risiko_cedera[11] == '1') echo 'checked="checked"'; ?> />&nbsp;Ya
	<input type="radio" name="risiko_cedera_12" id="risiko_cedera_12" value="2" <?php if(isset($arr_risiko_cedera[11]) and $arr_risiko_cedera[11] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kecacatan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="risiko_cedera_13" id="risiko_cedera_13" value="1" <?php if(isset($arr_risiko_cedera[12]) and $arr_risiko_cedera[12] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="checkbox" name="risiko_cedera_14" id="risiko_cedera_14" value="1" <?php if(isset($arr_risiko_cedera[13]) and $arr_risiko_cedera[13] == '1') echo 'checked="checked"'; ?> />&nbsp;Klowhand
	<input type="checkbox" name="risiko_cedera_15" id="risiko_cedera_15" value="1" <?php if(isset($arr_risiko_cedera[14]) and $arr_risiko_cedera[14] == '1') echo 'checked="checked"'; ?> />&nbsp;Drofoot
	<input type="checkbox" name="risiko_cedera_16" id="risiko_cedera_16" value="1" <?php if(isset($arr_risiko_cedera[15]) and $arr_risiko_cedera[15] == '1') echo 'checked="checked"'; ?> />&nbsp;Kaki bunting
	<input type="checkbox" name="risiko_cedera_17" id="risiko_cedera_17" value="1" <?php if(isset($arr_risiko_cedera[16]) and $arr_risiko_cedera[16] == '1') echo 'checked="checked"'; ?> />&nbsp;Legophtalmus
</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Gaya berjalan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><input type="checkbox" name="risiko_cedera_18" id="risiko_cedera_18" value="1" <?php if(isset($arr_risiko_cedera[17]) and $arr_risiko_cedera[17] == '1') echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="checkbox" name="risiko_cedera_19" id="risiko_cedera_19" value="1" <?php if(isset($arr_risiko_cedera[18]) and $arr_risiko_cedera[18] == '1') echo 'checked="checked"'; ?> />&nbsp;Lemah
	<input type="checkbox" name="risiko_cedera_20" id="risiko_cedera_20" value="1" <?php if(isset($arr_risiko_cedera[19]) and $arr_risiko_cedera[19] == '1') echo 'checked="checked"'; ?> />&nbsp;Pincang
	<input type="checkbox" name="risiko_cedera_21" id="risiko_cedera_21" value="1" <?php if(isset($arr_risiko_cedera[20]) and $arr_risiko_cedera[20] == '1') echo 'checked="checked"'; ?> />&nbsp;Bedrest</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">Diberitahukan ke dokter <input type="radio" name="risiko_cedera_22" id="risiko_cedera_22" value="1" <?php if(isset($arr_risiko_cedera[21]) and $arr_risiko_cedera[21] == '1') echo 'checked="checked"'; ?> />&nbsp;Ya, Pukul
	<input type="text" name="risiko_cedera_23" id="risiko_cedera_23" value="<?php if(isset($arr_risiko_cedera[22])) echo $arr_risiko_cedera[22]; ?>" class="text_dt" />
	<input type="radio" name="risiko_cedera_22" id="risiko_cedera_22" value="2" <?php if(isset($arr_risiko_cedera[21]) and $arr_risiko_cedera[21] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>9. PENAPISAN/ SKRINING NYERI</strong></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td rowspan="5"><img src="askep/02.png" alt="a" height="120px"/></td>
  <td colspan="2" rowspan="5">
  <table border="0">
	<tr>
	<td width="10px;" valign="top"></td>
	<td>O = onset</td>
	<td><input type="text" name="skrining_nyeri_2" id="skrining_nyeri_2" value="<?php if(isset($arr_skrining_nyeri[1])) echo $arr_skrining_nyeri[1]; ?>" class="text_dt" style="width:280px;" /></td>
	</tr>
	<tr>
	<td width="10px;" valign="top"></td>
	<td>P = pemicu</td>
	<td><input type="text" name="skrining_nyeri_3" id="skrining_nyeri_3" value="<?php if(isset($arr_skrining_nyeri[2])) echo $arr_skrining_nyeri[2]; ?>" class="text_dt" style="width:280px;" /></td>
	</tr>
	<tr>
	<td width="10px;" valign="top"></td>
	<td>Q = kwalitas</td>
	<td><input type="text" name="skrining_nyeri_4" id="skrining_nyeri_4" value="<?php if(isset($arr_skrining_nyeri[3])) echo $arr_skrining_nyeri[3]; ?>" class="text_dt" style="width:280px;" /></td>
	</tr>
	<tr>
	<td width="10px;" valign="top"></td>
	<td>R = lokasi</td>
	<td><input type="text" name="skrining_nyeri_5" id="skrining_nyeri_5" value="<?php if(isset($arr_skrining_nyeri[4])) echo $arr_skrining_nyeri[4]; ?>" class="text_dt" style="width:280px;" /></td>
	</tr>
	<tr>
	<td width="10px;" valign="top"></td>
	<td>S = skala nyeri</td>
	<td><input type="text" name="skrining_nyeri_1" id="skrining_nyeri_1" value="<?php if(isset($arr_skrining_nyeri[0])) echo $arr_skrining_nyeri[0]; ?>" class="text_dt" style="width:280px;" /></td>
	</tr>
  </table>
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">
	<input type="radio" name="skrining_nyeri_6" id="skrining_nyeri_6" value="1" <?php if(isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Nyeri kronis
	<input type="radio" name="skrining_nyeri_6" id="skrining_nyeri_6" value="2" <?php if(isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '2') echo 'checked="checked"'; ?> />&nbsp;Nyeri akut
	<input type="radio" name="skrining_nyeri_6" id="skrining_nyeri_6" value="3" <?php if(isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '3') echo 'checked="checked"'; ?> />&nbsp;Tidak ada nyeri
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">Nyeri hilang, bila :<br />
	<input type="checkbox" name="skrining_nyeri_7" id="skrining_nyeri_7" value="1" <?php if(isset($arr_skrining_nyeri[6]) and $arr_skrining_nyeri[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Minum obat
	<input type="checkbox" name="skrining_nyeri_8" id="skrining_nyeri_8" value="1" <?php if(isset($arr_skrining_nyeri[7]) and $arr_skrining_nyeri[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Istirahat
	<input type="checkbox" name="skrining_nyeri_9" id="skrining_nyeri_9" value="1" <?php if(isset($arr_skrining_nyeri[8]) and $arr_skrining_nyeri[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Mendengar musik
	<input type="checkbox" name="skrining_nyeri_10" id="skrining_nyeri_10" value="1" <?php if(isset($arr_skrining_nyeri[9]) and $arr_skrining_nyeri[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Berubah posisi/ tidur<br />
	<input type="checkbox" name="skrining_nyeri_11" id="skrining_nyeri_11" value="1" <?php if(isset($arr_skrining_nyeri[10]) and $arr_skrining_nyeri[10] == '1') echo 'checked="checked"'; ?> />&nbsp;Lain-lain, sebutkan
	<input type="text" name="skrining_nyeri_12" id="skrining_nyeri_12" value="<?php if(isset($arr_skrining_nyeri[11])) echo $arr_skrining_nyeri[11]; ?>" class="text_dt" style="width:280px;" /><br />
	Diberitahukan ke dokter/ Tim Pain Manajemen <br /><input type="radio" name="skrining_nyeri_13" id="skrining_nyeri_13" value="1" <?php if(isset($arr_skrining_nyeri[12]) and $arr_skrining_nyeri[12] == '1') echo 'checked="checked"'; ?> />&nbsp;Ya, pukul
	<input type="text" name="skrining_nyeri_14" id="skrining_nyeri_14" value="<?php if(isset($arr_skrining_nyeri[13])) echo $arr_skrining_nyeri[13]; ?>" class="text_dt" />
	<input type="radio" name="skrining_nyeri_13" id="skrining_nyeri_13" value="2" <?php if(isset($arr_skrining_nyeri[12]) and $arr_skrining_nyeri[12] == '2') echo 'checked="checked"'; ?> />&nbsp;Tidak
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">PEMERIKSAAN PENUNJANG (tuliskan hasil pemeriksaan penunjang baik Laboratorium, EKG, maupun pencitraan pasien)</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2"><textarea name="pemeriksaan_penunjang" id="pemeriksaan_penunjang" class="text_dt2" ><?php echo $pemeriksaan_penunjang; ?></textarea></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>10. KEBUTUHAN EDUKASI</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">a. Terdapat hambatan dalam pembelajaran <input type="radio" name="kebutuhan_edukasi_1" id="kebutuhan_edukasi_1" value="1" <?php if(isset($arr_kebutuhan_edukasi[0]) and $arr_kebutuhan_edukasi[0] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="kebutuhan_edukasi_1" id="kebutuhan_edukasi_1" value="2" <?php if(isset($arr_kebutuhan_edukasi[0]) and $arr_kebutuhan_edukasi[0] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">b. Jika ya, sebutkan hambatannya<br /><input type="checkbox" name="kebutuhan_edukasi_2" id="kebutuhan_edukasi_2" value="1" <?php if(isset($arr_kebutuhan_edukasi[1]) and $arr_kebutuhan_edukasi[1] == '1') echo 'checked="checked"'; ?> />&nbsp;Pendengaran
	<input type="checkbox" name="kebutuhan_edukasi_3" id="kebutuhan_edukasi_3" value="1" <?php if(isset($arr_kebutuhan_edukasi[2]) and $arr_kebutuhan_edukasi[2] == '1') echo 'checked="checked"'; ?> />&nbsp;Penglihatan
	<input type="checkbox" name="kebutuhan_edukasi_4" id="kebutuhan_edukasi_4" value="1" <?php if(isset($arr_kebutuhan_edukasi[3]) and $arr_kebutuhan_edukasi[3] == '1') echo 'checked="checked"'; ?> />&nbsp;Kognitif
	<input type="checkbox" name="kebutuhan_edukasi_5" id="kebutuhan_edukasi_5" value="1" <?php if(isset($arr_kebutuhan_edukasi[4]) and $arr_kebutuhan_edukasi[4] == '1') echo 'checked="checked"'; ?> />&nbsp;Fisik
	<input type="checkbox" name="kebutuhan_edukasi_6" id="kebutuhan_edukasi_6" value="1" <?php if(isset($arr_kebutuhan_edukasi[5]) and $arr_kebutuhan_edukasi[5] == '1') echo 'checked="checked"'; ?> />&nbsp;Budaya
	<input type="checkbox" name="kebutuhan_edukasi_7" id="kebutuhan_edukasi_7" value="1" <?php if(isset($arr_kebutuhan_edukasi[6]) and $arr_kebutuhan_edukasi[6] == '1') echo 'checked="checked"'; ?> />&nbsp;Agama
	<input type="checkbox" name="kebutuhan_edukasi_8" id="kebutuhan_edukasi_8" value="1" <?php if(isset($arr_kebutuhan_edukasi[7]) and $arr_kebutuhan_edukasi[7] == '1') echo 'checked="checked"'; ?> />&nbsp;Emosi
	<input type="checkbox" name="kebutuhan_edukasi_9" id="kebutuhan_edukasi_9" value="1" <?php if(isset($arr_kebutuhan_edukasi[8]) and $arr_kebutuhan_edukasi[8] == '1') echo 'checked="checked"'; ?> />&nbsp;Bahasa<br />
	<input type="checkbox" name="kebutuhan_edukasi_10" id="kebutuhan_edukasi_10" value="1" <?php if(isset($arr_kebutuhan_edukasi[9]) and $arr_kebutuhan_edukasi[9] == '1') echo 'checked="checked"'; ?> />&nbsp;Lainnya
	<input type="text" name="kebutuhan_edukasi_11" id="kebutuhan_edukasi_11" value="<?php if(isset($arr_kebutuhan_edukasi[10])) echo $arr_kebutuhan_edukasi[10]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">c. Dibutuhkan penerjemah <input type="radio" name="kebutuhan_edukasi_12" id="kebutuhan_edukasi_12" value="1" <?php if(isset($arr_kebutuhan_edukasi[11]) and $arr_kebutuhan_edukasi[11] == '1') echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="kebutuhan_edukasi_12" id="kebutuhan_edukasi_12" value="2" <?php if(isset($arr_kebutuhan_edukasi[11]) and $arr_kebutuhan_edukasi[11] == '2') echo 'checked="checked"'; ?> />&nbsp;Ya, sebutkan
	<input type="text" name="kebutuhan_edukasi_13" id="kebutuhan_edukasi_13" value="<?php if(isset($arr_kebutuhan_edukasi[12])) echo $arr_kebutuhan_edukasi[12]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">d. Kebutuhan pembelajaran pasien (pilih topik pembelajaran)<br /><input type="checkbox" name="kebutuhan_edukasi_14" id="kebutuhan_edukasi_14" value="1" <?php if(isset($arr_kebutuhan_edukasi[13]) and $arr_kebutuhan_edukasi[13] == '1') echo 'checked="checked"'; ?> />&nbsp;Diagnosa & manajemen
	<input type="checkbox" name="kebutuhan_edukasi_15" id="kebutuhan_edukasi_15" value="1" <?php if(isset($arr_kebutuhan_edukasi[14]) and $arr_kebutuhan_edukasi[14] == '1') echo 'checked="checked"'; ?> />&nbsp;Obat-obatan
	<input type="checkbox" name="kebutuhan_edukasi_16" id="kebutuhan_edukasi_16" value="1" <?php if(isset($arr_kebutuhan_edukasi[15]) and $arr_kebutuhan_edukasi[15] == '1') echo 'checked="checked"'; ?> />&nbsp;Perawatan luka
	<input type="checkbox" name="kebutuhan_edukasi_17" id="kebutuhan_edukasi_17" value="1" <?php if(isset($arr_kebutuhan_edukasi[16]) and $arr_kebutuhan_edukasi[16] == '1') echo 'checked="checked"'; ?> />&nbsp;Rehabilitasi
	<input type="checkbox" name="kebutuhan_edukasi_18" id="kebutuhan_edukasi_18" value="1" <?php if(isset($arr_kebutuhan_edukasi[17]) and $arr_kebutuhan_edukasi[17] == '1') echo 'checked="checked"'; ?> />&nbsp;Manajemen nyeri<br />
	<input type="checkbox" name="kebutuhan_edukasi_19" id="kebutuhan_edukasi_19" value="1" <?php if(isset($arr_kebutuhan_edukasi[18]) and $arr_kebutuhan_edukasi[18] == '1') echo 'checked="checked"'; ?> />&nbsp;Diet & nutrisi
	<input type="checkbox" name="kebutuhan_edukasi_20" id="kebutuhan_edukasi_20" value="1" <?php if(isset($arr_kebutuhan_edukasi[19]) and $arr_kebutuhan_edukasi[19] == '1') echo 'checked="checked"'; ?> />&nbsp;Lainnya
	<input type="text" name="kebutuhan_edukasi_21" id="kebutuhan_edukasi_21" value="<?php if(isset($arr_kebutuhan_edukasi[20])) echo $arr_kebutuhan_edukasi[20]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>11. MASALAH/ DIAGNOSA (cantumkan minimal dua masalah/ diagnosa keperawatan yang prioritas)</strong></td>
</tr>
<?php
	$sql_diagnosa = 'SELECT MASALAH_DIAGNOSA_ID,MASALAH_DIAGNOSA
					FROM t_irna_askep_masalah_diagnosa_kusta
					WHERE PENGKAJIAN_AWAL_ID ="' . $irna_id . '"';
	$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
	$d = 0;
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		?>
	<tr>
	<td valign="top" align="right"><?php echo $d + 1; ?>.</td>
	<td colspan="3">
	<input type="hidden" name="id_diagnosa_<?php echo $d; ?>" value="<?php echo $dat_diagnosa['MASALAH_DIAGNOSA_ID']; ?>" />
	<textarea name="masalah_diagnosa_<?php echo $d; ?>" id="masalah_diagnosa_<?php echo $d; ?>" class="text_dt2" ><?php echo $dat_diagnosa['MASALAH_DIAGNOSA'];?></textarea></td>
	</tr>	
<?php $d++; }	
?>
<tr>
	<td valign="top" align="right"><?php echo $d + 1; ?>.</td>
	<td colspan="3">
	<input type="hidden" name="cn_diagnosa" value="<?php echo $d; ?>" />
	<textarea name="masalah_diagnosa" id="masalah_diagnosa" class="text_dt2" ></textarea></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
    <td colspan="4"><strong>12. PERENCANAAN KEPERAWATAN (uraikan tujuan, kriteria hasil, dan intervensi sesuai masalah keperawatan yang ditemukan pada pasien)</strong></td>
</tr>
<?php
	$sql_perencanaan = 'SELECT PERENCANAAN_KEPERAWATAN_ID,DIAGNOSA,TUJUAN,KRITERIA_HASIL,INTERVENSI
						FROM t_irna_askep_perencanaan_keperawatan_kusta
					WHERE PENGKAJIAN_AWAL_ID ="' . $irna_id . '"';
	$get_perencanaan = mysql_query($sql_perencanaan) or die(mysql_error());
	$d = 0;
	while($dat_perencanaan = mysql_fetch_array($get_perencanaan)){
		?>
	<tr>
	<td align="right"><?php echo $d + 1; ?>.&nbsp;</td>
	<td>Diagnosa Keperawatan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<input type="hidden" name="id_perencanaan_<?php echo $d; ?>" value="<?php echo $dat_perencanaan['PERENCANAAN_KEPERAWATAN_ID']; ?>" />
	<input type="text" name="diagnosa_perencanaan_<?php echo $d; ?>" id="diagnosa_perencanaan_<?php echo $d; ?>" value="<?php echo $dat_perencanaan['DIAGNOSA']; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td>Tujuan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<input type="text" name="tujuan_perencanaan_<?php echo $d; ?>" id="tujuan_perencanaan_<?php echo $d; ?>" value="<?php echo $dat_perencanaan['TUJUAN']; ?>" class="text_dt" style="width:280px;" /></td></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td valign="top">Kriteria Hasil</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<textarea name="kriteria_perencanaan_<?php echo $d; ?>" id="kriteria_perencanaan_<?php echo $d; ?>" class="text_dt2" ><?php echo $dat_perencanaan['KRITERIA_HASIL']; ?></textarea></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td valign="top">Intervensi</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<textarea name="intervensi_perencanaan_<?php echo $d; ?>" id="intervensi_perencanaan_<?php echo $d; ?>" class="text_dt2" ><?php echo $dat_perencanaan['INTERVENSI']; ?></textarea></td>
</tr>	
<?php $d++; }	
?>
<tr>
	<td align="right"><?php echo $d + 1; ?>.&nbsp;</td>
	<td>Diagnosa Keperawatan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<input type="hidden" name="cn_perencanaan" value="<?php echo $d; ?>" />
	<input type="text" name="diagnosa_perencanaan" id="diagnosa_perencanaan" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td>Tujuan</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<input type="text" name="tujuan_perencanaan" id="tujuan_perencanaan" class="text_dt" style="width:280px;" /></td></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td valign="top">Kriteria Hasil</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<textarea name="kriteria_perencanaan" id="kriteria_perencanaan" class="text_dt2" ></textarea></td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td valign="top">Intervensi</td>
	<td width="10px;" valign="top">:</td>
	<td colspan="2">
	<textarea name="intervensi_perencanaan" id="intervensi_perencanaan" class="text_dt2" ></textarea></td>
</tr>
</table>
<table border="0" width="100%">
<tr>
	<td>&nbsp;</td>
    <td width="260px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal</td>
	<td>:&nbsp;<input type="text" name="tanggal" id="tgl_edu_2" value="<?php echo $tanggal; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/>
	Pukul <select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Perawat yang melakukan pengkajian</td>
	<td>:&nbsp;<select name="perawat" id="perawat" class="text_dt" style="width:330px;">
		<option> - </option>
		<?php if(empty($perawat)) $perawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
		echo getPerawat($perawat); ?>
		</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal</td>
	<td>:&nbsp;<input type="text" name="tanggal_pelengkap" id="tgl_edu_3" value="<?php echo $tanggal_pelengkap; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/>
	Pukul <select name="jam_pelengkap" id="jam_pelengkap" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_pelengkap); ?>
			</select>
			<select name="menit_pelengkap" id="menit_pelengkap" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_pelengkap); ?>
			</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Perawat yang melengkapi pengkajian</td>
	<td>:&nbsp;<select name="perawat_pelengkap" id="perawat_pelengkap" class="text_dt" style="width:330px;">
		<option> - </option>
		<?php if(empty($perawat_pelengkap)) $perawat_pelengkap = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
		echo getPerawat($perawat_pelengkap); ?>
		</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td align="right">
	<?php if($irna_final == ''){ ?>
	<input type="button" value="simpan" class="myButton" onclick="simpan();" />
	<?php } ?>
	</td>
</tr>		
</table>
</form> 
<script>
function simpan(){
	_haschange = false;
	$('#formedukasi').submit();
}	
</script>