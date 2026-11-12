<?php 
$irna_id = $_GET['idx'];

$qry_askep = 'SELECT STATUS_FUNGSIONAL_ID,MENGENDALIKAN_RANGSANG_DEFEKASI_0,MENGENDALIKAN_RANGSANG_DEFEKASI_1,MENGENDALIKAN_RANGSANG_DEFEKASI_2,
			MENGENDALIKAN_RANGSANG_BERKEMIH_0,MENGENDALIKAN_RANGSANG_BERKEMIH_1,MENGENDALIKAN_RANGSANG_BERKEMIH_2,MEMBERSIHKAN_DIRI_0,
			MEMBERSIHKAN_DIRI_1,PENGGUNAAN_JAMBAN_0,PENGGUNAAN_JAMBAN_1,PENGGUNAAN_JAMBAN_2,
			MAKAN_0,MAKAN_1,MAKAN_2,BERBARING_KE_DUDUK_0,BERBARING_KE_DUDUK_1,BERBARING_KE_DUDUK_2,BERBARING_KE_DUDUK_3,BERJALAN_0,
			BERJALAN_1,BERJALAN_2,BERJALAN_3,MEMAKAI_BAJU_0,MEMAKAI_BAJU_1,MEMAKAI_BAJU_2,NAIK_TURUN_TANGGA_0,NAIK_TURUN_TANGGA_1,NAIK_TURUN_TANGGA_2,
			MANDI_0,MANDI_2,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,PERAWAT
			FROM t_irna_askep_status_fungsional
			WHERE STATUS_FUNGSIONAL_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$status_fungsional_id = $dat_askep['STATUS_FUNGSIONAL_ID'];
$mengendalikan_rangsang_defekasi_0 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_DEFEKASI_0']);
$mengendalikan_rangsang_defekasi_1 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_DEFEKASI_1']);
$mengendalikan_rangsang_defekasi_2 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_DEFEKASI_2']);
$mengendalikan_rangsang_berkemih_0 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_BERKEMIH_0']);
$mengendalikan_rangsang_berkemih_1 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_BERKEMIH_1']);
$mengendalikan_rangsang_berkemih_2 = explode('|',$dat_askep['MENGENDALIKAN_RANGSANG_BERKEMIH_2']);
$membersihkan_diri_0 = explode('|',$dat_askep['MEMBERSIHKAN_DIRI_0']);
$membersihkan_diri_1 = explode('|',$dat_askep['MEMBERSIHKAN_DIRI_1']);
$penggunaan_jamban_0 = explode('|',$dat_askep['PENGGUNAAN_JAMBAN_0']);
$penggunaan_jamban_1 = explode('|',$dat_askep['PENGGUNAAN_JAMBAN_1']);
$penggunaan_jamban_2 = explode('|',$dat_askep['PENGGUNAAN_JAMBAN_2']);
$makan_0 = explode('|',$dat_askep['MAKAN_0']);
$makan_1 = explode('|',$dat_askep['MAKAN_1']);
$makan_2 = explode('|',$dat_askep['MAKAN_2']);
$berbaring_ke_duduk_0 = explode('|',$dat_askep['BERBARING_KE_DUDUK_0']);
$berbaring_ke_duduk_1 = explode('|',$dat_askep['BERBARING_KE_DUDUK_1']);
$berbaring_ke_duduk_2 = explode('|',$dat_askep['BERBARING_KE_DUDUK_2']);
$berbaring_ke_duduk_3 = explode('|',$dat_askep['BERBARING_KE_DUDUK_3']);
$berjalan_0 = explode('|',$dat_askep['BERJALAN_0']);
$berjalan_1 = explode('|',$dat_askep['BERJALAN_1']);
$berjalan_2 = explode('|',$dat_askep['BERJALAN_2']);
$berjalan_3 = explode('|',$dat_askep['BERJALAN_3']);
$memakai_baju_0 = explode('|',$dat_askep['MEMAKAI_BAJU_0']);
$memakai_baju_1 = explode('|',$dat_askep['MEMAKAI_BAJU_1']);
$memakai_baju_2 = explode('|',$dat_askep['MEMAKAI_BAJU_2']);
$naik_turun_tangga_0 = explode('|',$dat_askep['NAIK_TURUN_TANGGA_0']);
$naik_turun_tangga_1 = explode('|',$dat_askep['NAIK_TURUN_TANGGA_1']);
$naik_turun_tangga_2 = explode('|',$dat_askep['NAIK_TURUN_TANGGA_2']);
$mandi_0 = explode('|',$dat_askep['MANDI_0']);
$mandi_2 = explode('|',$dat_askep['MANDI_2']);
$tanggal = $dat_askep['TANGGAL'];
$perawat = explode('|',$dat_askep['PERAWAT']);		
?>
<form name="search" method="post" action="<?php echo currentUrl(); ?>" >
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="status_fungsional_id" id="status_fungsional_id" value="<?php echo $status_fungsional_id; ?>" />
<table class="tableData">
<tr>
    <th rowspan="2" width="25px">No</th>
    <th rowspan="2">Fungsi</th>
    <th rowspan="2" width="40px">Skor</th>
    <th rowspan="2">Uraian</th>
    <th colspan="7">Nilai Skor </th>
  </tr>
  <tr>
    <th>Sebelum Sakit</th>
    <th>Saat Masuk</th>
    <th>Minggu I<br />Di RS</th>
    <th>Minggu II<br />Di RS</th>
    <th>Minggu III<br />Di RS</th>
    <th>Minggu IV<br />Di RS</th>
    <th>Saat Pulang</th>
  </tr>
<tr>
	<td rowspan="3" align="center">1</td>
    <td rowspan="3">Mengendalikan rangsang defekasi (BAB)</td>
	<td align="center">0</td>
	<td>Tak terkendali/ tak teratur (perlu pencahar)</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_0" id="mengendalikan_rangsang_defekasi_0_0" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[0]) and ($mengendalikan_rangsang_defekasi_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_1" id="mengendalikan_rangsang_defekasi_0_1" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[1]) and ($mengendalikan_rangsang_defekasi_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_2" id="mengendalikan_rangsang_defekasi_0_2" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[2]) and ($mengendalikan_rangsang_defekasi_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_3" id="mengendalikan_rangsang_defekasi_0_3" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[3]) and ($mengendalikan_rangsang_defekasi_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_4" id="mengendalikan_rangsang_defekasi_0_4" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[4]) and ($mengendalikan_rangsang_defekasi_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_5" id="mengendalikan_rangsang_defekasi_0_5" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[5]) and ($mengendalikan_rangsang_defekasi_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_6" id="mengendalikan_rangsang_defekasi_0_6" value="0" <?php if(isset($mengendalikan_rangsang_defekasi_0[6]) and ($mengendalikan_rangsang_defekasi_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Kadang-kadang tak terkendali</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_0" id="mengendalikan_rangsang_defekasi_1_0" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[0]) and ($mengendalikan_rangsang_defekasi_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_1" id="mengendalikan_rangsang_defekasi_1_1" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[1]) and ($mengendalikan_rangsang_defekasi_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_2" id="mengendalikan_rangsang_defekasi_1_2" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[2]) and ($mengendalikan_rangsang_defekasi_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_3" id="mengendalikan_rangsang_defekasi_1_3" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[3]) and ($mengendalikan_rangsang_defekasi_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_4" id="mengendalikan_rangsang_defekasi_1_4" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[4]) and ($mengendalikan_rangsang_defekasi_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_5" id="mengendalikan_rangsang_defekasi_1_5" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[5]) and ($mengendalikan_rangsang_defekasi_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_6" id="mengendalikan_rangsang_defekasi_1_6" value="1" <?php if(isset($mengendalikan_rangsang_defekasi_1[6]) and ($mengendalikan_rangsang_defekasi_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_0" id="mengendalikan_rangsang_defekasi_2_0" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[0]) and ($mengendalikan_rangsang_defekasi_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_1" id="mengendalikan_rangsang_defekasi_2_1" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[1]) and ($mengendalikan_rangsang_defekasi_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_2" id="mengendalikan_rangsang_defekasi_2_2" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[2]) and ($mengendalikan_rangsang_defekasi_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_3" id="mengendalikan_rangsang_defekasi_2_3" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[3]) and ($mengendalikan_rangsang_defekasi_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_4" id="mengendalikan_rangsang_defekasi_2_4" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[4]) and ($mengendalikan_rangsang_defekasi_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_5" id="mengendalikan_rangsang_defekasi_2_5" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[5]) and ($mengendalikan_rangsang_defekasi_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_6" id="mengendalikan_rangsang_defekasi_2_6" value="2" <?php if(isset($mengendalikan_rangsang_defekasi_2[6]) and ($mengendalikan_rangsang_defekasi_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="3" align="center">2</td>
    <td rowspan="3">Mengendalikan rangsang berkemih (BAK)</td>
	<td align="center">0</td>
	<td>Tidak terkendali/ pakai keteter</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_0" id="mengendalikan_rangsang_berkemih_0_0" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[0]) and ($mengendalikan_rangsang_berkemih_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_1" id="mengendalikan_rangsang_berkemih_0_1" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[1]) and ($mengendalikan_rangsang_berkemih_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_2" id="mengendalikan_rangsang_berkemih_0_2" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[2]) and ($mengendalikan_rangsang_berkemih_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_3" id="mengendalikan_rangsang_berkemih_0_3" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[3]) and ($mengendalikan_rangsang_berkemih_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_4" id="mengendalikan_rangsang_berkemih_0_4" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[4]) and ($mengendalikan_rangsang_berkemih_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_5" id="mengendalikan_rangsang_berkemih_0_5" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[5]) and ($mengendalikan_rangsang_berkemih_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_6" id="mengendalikan_rangsang_berkemih_0_6" value="0" <?php if(isset($mengendalikan_rangsang_berkemih_0[6]) and ($mengendalikan_rangsang_berkemih_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Kadang-kadang tak terkendali (1 x 24 jam)</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_0" id="mengendalikan_rangsang_berkemih_1_0" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[0]) and ($mengendalikan_rangsang_berkemih_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_1" id="mengendalikan_rangsang_berkemih_1_1" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[1]) and ($mengendalikan_rangsang_berkemih_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_2" id="mengendalikan_rangsang_berkemih_1_2" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[2]) and ($mengendalikan_rangsang_berkemih_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_3" id="mengendalikan_rangsang_berkemih_1_3" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[3]) and ($mengendalikan_rangsang_berkemih_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_4" id="mengendalikan_rangsang_berkemih_1_4" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[4]) and ($mengendalikan_rangsang_berkemih_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_5" id="mengendalikan_rangsang_berkemih_1_5" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[5]) and ($mengendalikan_rangsang_berkemih_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_6" id="mengendalikan_rangsang_berkemih_1_6" value="1" <?php if(isset($mengendalikan_rangsang_berkemih_1[6]) and ($mengendalikan_rangsang_berkemih_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_0" id="mengendalikan_rangsang_berkemih_2_0" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[0]) and ($mengendalikan_rangsang_berkemih_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_1" id="mengendalikan_rangsang_berkemih_2_1" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[1]) and ($mengendalikan_rangsang_berkemih_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_2" id="mengendalikan_rangsang_berkemih_2_2" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[2]) and ($mengendalikan_rangsang_berkemih_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_3" id="mengendalikan_rangsang_berkemih_2_3" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[3]) and ($mengendalikan_rangsang_berkemih_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_4" id="mengendalikan_rangsang_berkemih_2_4" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[4]) and ($mengendalikan_rangsang_berkemih_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_5" id="mengendalikan_rangsang_berkemih_2_5" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[5]) and ($mengendalikan_rangsang_berkemih_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_6" id="mengendalikan_rangsang_berkemih_2_6" value="2" <?php if(isset($mengendalikan_rangsang_berkemih_2[6]) and ($mengendalikan_rangsang_berkemih_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="2" align="center">3</td>
    <td rowspan="2">Membersihkan diri (cuci muka, sisir rambut, sikat gigi)</td>
	<td align="center">0</td>
	<td>Butuh pertolongan orang lain</td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_0" id="membersihkan_diri_0_0" value="0" <?php if(isset($membersihkan_diri_0[0]) and ($membersihkan_diri_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_1" id="membersihkan_diri_0_1" value="0" <?php if(isset($membersihkan_diri_0[1]) and ($membersihkan_diri_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_2" id="membersihkan_diri_0_2" value="0" <?php if(isset($membersihkan_diri_0[2]) and ($membersihkan_diri_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_3" id="membersihkan_diri_0_3" value="0" <?php if(isset($membersihkan_diri_0[3]) and ($membersihkan_diri_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_4" id="membersihkan_diri_0_4" value="0" <?php if(isset($membersihkan_diri_0[4]) and ($membersihkan_diri_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_5" id="membersihkan_diri_0_5" value="0" <?php if(isset($membersihkan_diri_0[5]) and ($membersihkan_diri_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_0_6" id="membersihkan_diri_0_6" value="0" <?php if(isset($membersihkan_diri_0[6]) and ($membersihkan_diri_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_0" id="membersihkan_diri_1_0" value="1" <?php if(isset($membersihkan_diri_1[0]) and ($membersihkan_diri_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_1" id="membersihkan_diri_1_1" value="1" <?php if(isset($membersihkan_diri_1[1]) and ($membersihkan_diri_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_2" id="membersihkan_diri_1_2" value="1" <?php if(isset($membersihkan_diri_1[2]) and ($membersihkan_diri_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_3" id="membersihkan_diri_1_3" value="1" <?php if(isset($membersihkan_diri_1[3]) and ($membersihkan_diri_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_4" id="membersihkan_diri_1_4" value="1" <?php if(isset($membersihkan_diri_1[4]) and ($membersihkan_diri_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_5" id="membersihkan_diri_1_5" value="1" <?php if(isset($membersihkan_diri_1[5]) and ($membersihkan_diri_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="membersihkan_diri_1_6" id="membersihkan_diri_1_6" value="1" <?php if(isset($membersihkan_diri_1[6]) and ($membersihkan_diri_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="3" align="center">4</td>
	<td rowspan="3">Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram)</td>
	<td align="center">0</td>
	<td>Tergantung pertolongan orang lain</td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_0" id="penggunaan_jamban_0_0" value="0" <?php if(isset($penggunaan_jamban_0[0]) and ($penggunaan_jamban_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_1" id="penggunaan_jamban_0_1" value="0" <?php if(isset($penggunaan_jamban_0[1]) and ($penggunaan_jamban_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_2" id="penggunaan_jamban_0_2" value="0" <?php if(isset($penggunaan_jamban_0[2]) and ($penggunaan_jamban_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_3" id="penggunaan_jamban_0_3" value="0" <?php if(isset($penggunaan_jamban_0[3]) and ($penggunaan_jamban_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_4" id="penggunaan_jamban_0_4" value="0" <?php if(isset($penggunaan_jamban_0[4]) and ($penggunaan_jamban_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_5" id="penggunaan_jamban_0_5" value="0" <?php if(isset($penggunaan_jamban_0[5]) and ($penggunaan_jamban_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_0_6" id="penggunaan_jamban_0_6" value="0" <?php if(isset($penggunaan_jamban_0[6]) and ($penggunaan_jamban_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Perlu pertolongan pada beberapa kegiatan teapi dapat mengerjakan sendiri kegiatan yang lain</td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_0" id="penggunaan_jamban_1_0" value="1" <?php if(isset($penggunaan_jamban_1[0]) and ($penggunaan_jamban_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_1" id="penggunaan_jamban_1_1" value="1" <?php if(isset($penggunaan_jamban_1[1]) and ($penggunaan_jamban_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_2" id="penggunaan_jamban_1_2" value="1" <?php if(isset($penggunaan_jamban_1[2]) and ($penggunaan_jamban_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_3" id="penggunaan_jamban_1_3" value="1" <?php if(isset($penggunaan_jamban_1[3]) and ($penggunaan_jamban_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_4" id="penggunaan_jamban_1_4" value="1" <?php if(isset($penggunaan_jamban_1[4]) and ($penggunaan_jamban_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_5" id="penggunaan_jamban_1_5" value="1" <?php if(isset($penggunaan_jamban_1[5]) and ($penggunaan_jamban_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_1_6" id="penggunaan_jamban_1_6" value="1" <?php if(isset($penggunaan_jamban_1[6]) and ($penggunaan_jamban_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_0" id="penggunaan_jamban_2_0" value="2" <?php if(isset($penggunaan_jamban_2[0]) and ($penggunaan_jamban_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_1" id="penggunaan_jamban_2_1" value="2" <?php if(isset($penggunaan_jamban_2[1]) and ($penggunaan_jamban_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_2" id="penggunaan_jamban_2_2" value="2" <?php if(isset($penggunaan_jamban_2[2]) and ($penggunaan_jamban_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_3" id="penggunaan_jamban_2_3" value="2" <?php if(isset($penggunaan_jamban_2[3]) and ($penggunaan_jamban_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_4" id="penggunaan_jamban_2_4" value="2" <?php if(isset($penggunaan_jamban_2[4]) and ($penggunaan_jamban_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_5" id="penggunaan_jamban_2_5" value="2" <?php if(isset($penggunaan_jamban_2[5]) and ($penggunaan_jamban_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="penggunaan_jamban_2_6" id="penggunaan_jamban_2_6" value="2" <?php if(isset($penggunaan_jamban_2[6]) and ($penggunaan_jamban_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="3" align="center">5</td>
    <td rowspan="3">Makan</td>
	<td align="center">0</td>
	<td>Tidak mampu</td>
	<td align="center"><input type="checkbox" name="makan_0_0" id="makan_0_0" value="0" <?php if(isset($makan_0[0]) and ($makan_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_1" id="makan_0_1" value="0" <?php if(isset($makan_0[1]) and ($makan_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_2" id="makan_0_2" value="0" <?php if(isset($makan_0[2]) and ($makan_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_3" id="makan_0_3" value="0" <?php if(isset($makan_0[3]) and ($makan_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_4" id="makan_0_4" value="0" <?php if(isset($makan_0[4]) and ($makan_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_5" id="makan_0_5" value="0" <?php if(isset($makan_0[5]) and ($makan_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_0_6" id="makan_0_6" value="0" <?php if(isset($makan_0[6]) and ($makan_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Perlu ditolong memotong makanan</td>
	<td align="center"><input type="checkbox" name="makan_1_0" id="makan_1_0" value="1" <?php if(isset($makan_1[0]) and ($makan_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_1" id="makan_1_1" value="1" <?php if(isset($makan_1[1]) and ($makan_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_2" id="makan_1_2" value="1" <?php if(isset($makan_1[2]) and ($makan_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_3" id="makan_1_3" value="1" <?php if(isset($makan_1[3]) and ($makan_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_4" id="makan_1_4" value="1" <?php if(isset($makan_1[4]) and ($makan_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_5" id="makan_1_5" value="1" <?php if(isset($makan_1[5]) and ($makan_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_1_6" id="makan_1_6" value="1" <?php if(isset($makan_1[6]) and ($makan_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="makan_2_0" id="makan_2_0" value="2" <?php if(isset($makan_2[0]) and ($makan_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_1" id="makan_2_1" value="2" <?php if(isset($makan_2[1]) and ($makan_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_2" id="makan_2_2" value="2" <?php if(isset($makan_2[2]) and ($makan_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_3" id="makan_2_3" value="2" <?php if(isset($makan_2[3]) and ($makan_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_4" id="makan_2_4" value="2" <?php if(isset($makan_2[4]) and ($makan_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_5" id="makan_2_5" value="2" <?php if(isset($makan_2[5]) and ($makan_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="makan_2_6" id="makan_2_6" value="2" <?php if(isset($makan_2[6]) and ($makan_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="4" align="center">6</td>
    <td rowspan="4">Berubah sikap dari berbaring ke duduk</td>
	<td align="center">0</td>
	<td>Tidak mampu</td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_0" id="berbaring_ke_duduk_0_0" value="0" <?php if(isset($berbaring_ke_duduk_0[0]) and ($berbaring_ke_duduk_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_1" id="berbaring_ke_duduk_0_1" value="0" <?php if(isset($berbaring_ke_duduk_0[1]) and ($berbaring_ke_duduk_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_2" id="berbaring_ke_duduk_0_2" value="0" <?php if(isset($berbaring_ke_duduk_0[2]) and ($berbaring_ke_duduk_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_3" id="berbaring_ke_duduk_0_3" value="0" <?php if(isset($berbaring_ke_duduk_0[3]) and ($berbaring_ke_duduk_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_4" id="berbaring_ke_duduk_0_4" value="0" <?php if(isset($berbaring_ke_duduk_0[4]) and ($berbaring_ke_duduk_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_5" id="berbaring_ke_duduk_0_5" value="0" <?php if(isset($berbaring_ke_duduk_0[5]) and ($berbaring_ke_duduk_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_6" id="berbaring_ke_duduk_0_6" value="0" <?php if(isset($berbaring_ke_duduk_0[6]) and ($berbaring_ke_duduk_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Perlu banyak bantuan untuk bisa duduk (2 orang)</td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_0" id="berbaring_ke_duduk_1_0" value="1" <?php if(isset($berbaring_ke_duduk_1[0]) and ($berbaring_ke_duduk_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_1" id="berbaring_ke_duduk_1_1" value="1" <?php if(isset($berbaring_ke_duduk_1[1]) and ($berbaring_ke_duduk_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_2" id="berbaring_ke_duduk_1_2" value="1" <?php if(isset($berbaring_ke_duduk_1[2]) and ($berbaring_ke_duduk_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_3" id="berbaring_ke_duduk_1_3" value="1" <?php if(isset($berbaring_ke_duduk_1[3]) and ($berbaring_ke_duduk_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_4" id="berbaring_ke_duduk_1_4" value="1" <?php if(isset($berbaring_ke_duduk_1[4]) and ($berbaring_ke_duduk_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_5" id="berbaring_ke_duduk_1_5" value="1" <?php if(isset($berbaring_ke_duduk_1[5]) and ($berbaring_ke_duduk_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_6" id="berbaring_ke_duduk_1_6" value="1" <?php if(isset($berbaring_ke_duduk_1[6]) and ($berbaring_ke_duduk_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Batuan (1 orang)</td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_0" id="berbaring_ke_duduk_2_0" value="2" <?php if(isset($berbaring_ke_duduk_2[0]) and ($berbaring_ke_duduk_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_1" id="berbaring_ke_duduk_2_1" value="2" <?php if(isset($berbaring_ke_duduk_2[1]) and ($berbaring_ke_duduk_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_2" id="berbaring_ke_duduk_2_2" value="2" <?php if(isset($berbaring_ke_duduk_2[2]) and ($berbaring_ke_duduk_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_3" id="berbaring_ke_duduk_2_3" value="2" <?php if(isset($berbaring_ke_duduk_2[3]) and ($berbaring_ke_duduk_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_4" id="berbaring_ke_duduk_2_4" value="2" <?php if(isset($berbaring_ke_duduk_2[4]) and ($berbaring_ke_duduk_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_5" id="berbaring_ke_duduk_2_5" value="2" <?php if(isset($berbaring_ke_duduk_2[5]) and ($berbaring_ke_duduk_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_6" id="berbaring_ke_duduk_2_6" value="2" <?php if(isset($berbaring_ke_duduk_2[6]) and ($berbaring_ke_duduk_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
</tr>
<tr>
	<td align="center">3</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_0" id="berbaring_ke_duduk_3_0" value="3" <?php if(isset($berbaring_ke_duduk_3[0]) and ($berbaring_ke_duduk_3[0]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_1" id="berbaring_ke_duduk_3_1" value="3" <?php if(isset($berbaring_ke_duduk_3[1]) and ($berbaring_ke_duduk_3[1]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_2" id="berbaring_ke_duduk_3_2" value="3" <?php if(isset($berbaring_ke_duduk_3[2]) and ($berbaring_ke_duduk_3[2]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_3" id="berbaring_ke_duduk_3_3" value="3" <?php if(isset($berbaring_ke_duduk_3[3]) and ($berbaring_ke_duduk_3[3]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_4" id="berbaring_ke_duduk_3_4" value="3" <?php if(isset($berbaring_ke_duduk_3[4]) and ($berbaring_ke_duduk_3[4]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_5" id="berbaring_ke_duduk_3_5" value="3" <?php if(isset($berbaring_ke_duduk_3[5]) and ($berbaring_ke_duduk_3[5]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_6" id="berbaring_ke_duduk_3_6" value="3" <?php if(isset($berbaring_ke_duduk_3[6]) and ($berbaring_ke_duduk_3[6]=='3')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="4" align="center">7</td>
    <td rowspan="4">Berpindah/ berjalan</td>
	<td align="center">0</td>
	<td>Tidak mampu</td>
	<td align="center"><input type="checkbox" name="berjalan_0_0" id="berjalan_0_0" value="0" <?php if(isset($berjalan_0[0]) and ($berjalan_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_1" id="berjalan_0_1" value="0" <?php if(isset($berjalan_0[1]) and ($berjalan_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_2" id="berjalan_0_2" value="0" <?php if(isset($berjalan_0[2]) and ($berjalan_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_3" id="berjalan_0_3" value="0" <?php if(isset($berjalan_0[3]) and ($berjalan_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_4" id="berjalan_0_4" value="0" <?php if(isset($berjalan_0[4]) and ($berjalan_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_5" id="berjalan_0_5" value="0" <?php if(isset($berjalan_0[5]) and ($berjalan_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_0_6" id="berjalan_0_6" value="0" <?php if(isset($berjalan_0[6]) and ($berjalan_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Bisa (pindah) dengan kursi roda</td>
	<td align="center"><input type="checkbox" name="berjalan_1_0" id="berjalan_1_0" value="1" <?php if(isset($berjalan_1[0]) and ($berjalan_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_1" id="berjalan_1_1" value="1" <?php if(isset($berjalan_1[1]) and ($berjalan_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_2" id="berjalan_1_2" value="1" <?php if(isset($berjalan_1[2]) and ($berjalan_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_3" id="berjalan_1_3" value="1" <?php if(isset($berjalan_1[3]) and ($berjalan_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_4" id="berjalan_1_4" value="1" <?php if(isset($berjalan_1[4]) and ($berjalan_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_5" id="berjalan_1_5" value="1" <?php if(isset($berjalan_1[5]) and ($berjalan_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_1_6" id="berjalan_1_6" value="1" <?php if(isset($berjalan_1[6]) and ($berjalan_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Berjalan dengan bantuan 1 orang</td>
	<td align="center"><input type="checkbox" name="berjalan_2_0" id="berjalan_2_0" value="2" <?php if(isset($berjalan_2[0]) and ($berjalan_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_1" id="berjalan_2_1" value="2" <?php if(isset($berjalan_2[1]) and ($berjalan_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_2" id="berjalan_2_2" value="2" <?php if(isset($berjalan_2[2]) and ($berjalan_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_3" id="berjalan_2_3" value="2" <?php if(isset($berjalan_2[3]) and ($berjalan_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_4" id="berjalan_2_4" value="2" <?php if(isset($berjalan_2[4]) and ($berjalan_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_5" id="berjalan_2_5" value="2" <?php if(isset($berjalan_2[5]) and ($berjalan_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_2_6" id="berjalan_2_6" value="2" <?php if(isset($berjalan_2[6]) and ($berjalan_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">3</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="berjalan_3_0" id="berjalan_3_0" value="3" <?php if(isset($berjalan_3[0]) and ($berjalan_3[0]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_1" id="berjalan_3_1" value="3" <?php if(isset($berjalan_3[1]) and ($berjalan_3[1]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_2" id="berjalan_3_2" value="3" <?php if(isset($berjalan_3[2]) and ($berjalan_3[2]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_3" id="berjalan_3_3" value="3" <?php if(isset($berjalan_3[3]) and ($berjalan_3[3]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_4" id="berjalan_3_4" value="3" <?php if(isset($berjalan_3[4]) and ($berjalan_3[4]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_5" id="berjalan_3_5" value="3" <?php if(isset($berjalan_3[5]) and ($berjalan_3[5]=='3')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="berjalan_3_6" id="berjalan_3_6" value="3" <?php if(isset($berjalan_3[6]) and ($berjalan_3[6]=='3')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="3" align="center">8</td>
    <td rowspan="3">Memakai baju</td>
	<td align="center">0</td>
	<td>Tergantung orang lain</td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_0" id="memakai_baju_0_0" value="0" <?php if(isset($memakai_baju_0[0]) and ($memakai_baju_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_1" id="memakai_baju_0_1" value="0" <?php if(isset($memakai_baju_0[1]) and ($memakai_baju_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_2" id="memakai_baju_0_2" value="0" <?php if(isset($memakai_baju_0[2]) and ($memakai_baju_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_3" id="memakai_baju_0_3" value="0" <?php if(isset($memakai_baju_0[3]) and ($memakai_baju_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_4" id="memakai_baju_0_4" value="0" <?php if(isset($memakai_baju_0[4]) and ($memakai_baju_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_5" id="memakai_baju_0_5" value="0" <?php if(isset($memakai_baju_0[5]) and ($memakai_baju_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_0_6" id="memakai_baju_0_6" value="0" <?php if(isset($memakai_baju_0[6]) and ($memakai_baju_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Sebagian dibantu (misalnya mengancingkan baju)</td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_0" id="memakai_baju_1_0" value="1" <?php if(isset($memakai_baju_1[0]) and ($memakai_baju_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_1" id="memakai_baju_1_1" value="1" <?php if(isset($memakai_baju_1[1]) and ($memakai_baju_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_2" id="memakai_baju_1_2" value="1" <?php if(isset($memakai_baju_1[2]) and ($memakai_baju_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_3" id="memakai_baju_1_3" value="1" <?php if(isset($memakai_baju_1[3]) and ($memakai_baju_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_4" id="memakai_baju_1_4" value="1" <?php if(isset($memakai_baju_1[4]) and ($memakai_baju_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_5" id="memakai_baju_1_5" value="1" <?php if(isset($memakai_baju_1[5]) and ($memakai_baju_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_1_6" id="memakai_baju_1_6" value="1" <?php if(isset($memakai_baju_1[6]) and ($memakai_baju_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_0" id="memakai_baju_2_0" value="2" <?php if(isset($memakai_baju_2[0]) and ($memakai_baju_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_1" id="memakai_baju_2_1" value="2" <?php if(isset($memakai_baju_2[1]) and ($memakai_baju_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_2" id="memakai_baju_2_2" value="2" <?php if(isset($memakai_baju_2[2]) and ($memakai_baju_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_3" id="memakai_baju_2_3" value="2" <?php if(isset($memakai_baju_2[3]) and ($memakai_baju_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_4" id="memakai_baju_2_4" value="2" <?php if(isset($memakai_baju_2[4]) and ($memakai_baju_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_5" id="memakai_baju_2_5" value="2" <?php if(isset($memakai_baju_2[5]) and ($memakai_baju_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="memakai_baju_2_6" id="memakai_baju_2_6" value="2" <?php if(isset($memakai_baju_2[6]) and ($memakai_baju_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td rowspan="3" align="center">9</td>
    <td rowspan="3">Naik turun tangga</td>
	<td align="center">0</td>
	<td>Tidak mampu</td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_0" id="naik_turun_tangga_0_0" value="0" <?php if(isset($naik_turun_tangga_0[0]) and ($naik_turun_tangga_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_1" id="naik_turun_tangga_0_1" value="0" <?php if(isset($naik_turun_tangga_0[1]) and ($naik_turun_tangga_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_2" id="naik_turun_tangga_0_2" value="0" <?php if(isset($naik_turun_tangga_0[2]) and ($naik_turun_tangga_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_3" id="naik_turun_tangga_0_3" value="0" <?php if(isset($naik_turun_tangga_0[3]) and ($naik_turun_tangga_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_4" id="naik_turun_tangga_0_4" value="0" <?php if(isset($naik_turun_tangga_0[4]) and ($naik_turun_tangga_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_5" id="naik_turun_tangga_0_5" value="0" <?php if(isset($naik_turun_tangga_0[5]) and ($naik_turun_tangga_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_0_6" id="naik_turun_tangga_0_6" value="0" <?php if(isset($naik_turun_tangga_0[6]) and ($naik_turun_tangga_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">1</td>
	<td>Butuh pertolongan</td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_0" id="naik_turun_tangga_1_0" value="1" <?php if(isset($naik_turun_tangga_1[0]) and ($naik_turun_tangga_1[0]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_1" id="naik_turun_tangga_1_1" value="1" <?php if(isset($naik_turun_tangga_1[1]) and ($naik_turun_tangga_1[1]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_2" id="naik_turun_tangga_1_2" value="1" <?php if(isset($naik_turun_tangga_1[2]) and ($naik_turun_tangga_1[2]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_3" id="naik_turun_tangga_1_3" value="1" <?php if(isset($naik_turun_tangga_1[3]) and ($naik_turun_tangga_1[3]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_4" id="naik_turun_tangga_1_4" value="1" <?php if(isset($naik_turun_tangga_1[4]) and ($naik_turun_tangga_1[4]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_5" id="naik_turun_tangga_1_5" value="1" <?php if(isset($naik_turun_tangga_1[5]) and ($naik_turun_tangga_1[5]=='1')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_1_6" id="naik_turun_tangga_1_6" value="1" <?php if(isset($naik_turun_tangga_1[6]) and ($naik_turun_tangga_1[6]=='1')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_0" id="naik_turun_tangga_2_0" value="2" <?php if(isset($naik_turun_tangga_2[0]) and ($naik_turun_tangga_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_1" id="naik_turun_tangga_2_1" value="2" <?php if(isset($naik_turun_tangga_2[1]) and ($naik_turun_tangga_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_2" id="naik_turun_tangga_2_2" value="2" <?php if(isset($naik_turun_tangga_2[2]) and ($naik_turun_tangga_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_3" id="naik_turun_tangga_2_3" value="2" <?php if(isset($naik_turun_tangga_2[3]) and ($naik_turun_tangga_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_4" id="naik_turun_tangga_2_4" value="2" <?php if(isset($naik_turun_tangga_2[4]) and ($naik_turun_tangga_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_5" id="naik_turun_tangga_2_5" value="2" <?php if(isset($naik_turun_tangga_2[5]) and ($naik_turun_tangga_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="naik_turun_tangga_2_6" id="naik_turun_tangga_2_6" value="2" <?php if(isset($naik_turun_tangga_2[6]) and ($naik_turun_tangga_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
</tr>
<tr>
	<td rowspan="2" align="center">10</td>
    <td rowspan="2">Mandi</td>
	<td align="center">0</td>
	<td>Tergantung orang lain</td>
	<td align="center"><input type="checkbox" name="mandi_0_0" id="mandi_0_0" value="0" <?php if(isset($mandi_0[0]) and ($mandi_0[0]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_1" id="mandi_0_1" value="0" <?php if(isset($mandi_0[1]) and ($mandi_0[1]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_2" id="mandi_0_2" value="0" <?php if(isset($mandi_0[2]) and ($mandi_0[2]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_3" id="mandi_0_3" value="0" <?php if(isset($mandi_0[3]) and ($mandi_0[3]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_4" id="mandi_0_4" value="0" <?php if(isset($mandi_0[4]) and ($mandi_0[4]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_5" id="mandi_0_5" value="0" <?php if(isset($mandi_0[5]) and ($mandi_0[5]=='0')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_0_6" id="mandi_0_6" value="0" <?php if(isset($mandi_0[6]) and ($mandi_0[6]=='0')) echo 'checked="checked"'; ?> /></td>
</tr>
<tr>
	<td align="center">2</td>
	<td>Mandiri</td>
	<td align="center"><input type="checkbox" name="mandi_2_0" id="mandi_2_0" value="2" <?php if(isset($mandi_2[0]) and ($mandi_2[0]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_1" id="mandi_2_1" value="2" <?php if(isset($mandi_2[1]) and ($mandi_2[1]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_2" id="mandi_2_2" value="2" <?php if(isset($mandi_2[2]) and ($mandi_2[2]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_3" id="mandi_2_3" value="2" <?php if(isset($mandi_2[3]) and ($mandi_2[3]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_4" id="mandi_2_4" value="2" <?php if(isset($mandi_2[4]) and ($mandi_2[4]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_5" id="mandi_2_5" value="2" <?php if(isset($mandi_2[5]) and ($mandi_2[5]=='2')) echo 'checked="checked"'; ?> /></td>
	<td align="center"><input type="checkbox" name="mandi_2_6" id="mandi_2_6" value="2" <?php if(isset($mandi_2[6]) and ($mandi_2[6]=='2')) echo 'checked="checked"'; ?> /></td>
</tr>
<?php 
$skor_st_1 = '';
$skor_st_2 = '';
$skor_st_3 = '';
$skor_st_4 = '';
$skor_st_5 = '';
$skor_st_6 = '';
$skor_st_7 = '';

if(!empty($status_fungsional_id)){
	$skor_st_1 = $mengendalikan_rangsang_defekasi_0[0] + $mengendalikan_rangsang_defekasi_1[0] + $mengendalikan_rangsang_defekasi_2[0] + 
				$mengendalikan_rangsang_berkemih_0[0] + $mengendalikan_rangsang_berkemih_1[0] + $mengendalikan_rangsang_berkemih_2[0] + 
				$membersihkan_diri_0[0] + $membersihkan_diri_1[0] + $penggunaan_jamban_0[0] + $penggunaan_jamban_1[0] + 
				$penggunaan_jamban_2[0] + $makan_0[0] + $makan_1[0] + $makan_2[0] + $berbaring_ke_duduk_0[0] + 
				$berbaring_ke_duduk_1[0] + $berbaring_ke_duduk_2[0] + $berbaring_ke_duduk_3[0] + $berjalan_0[0] + $berjalan_1[0] + 
				$berjalan_2[0] + $berjalan_3[0] + $memakai_baju_0[0] + $memakai_baju_1[0] + $memakai_baju_2[0] + 
				$naik_turun_tangga_0[0] + $naik_turun_tangga_1[0] + $naik_turun_tangga_2[0] + $mandi_0[0] + $mandi_2[0]; 
	$skor_st_2 = $mengendalikan_rangsang_defekasi_0[1] + $mengendalikan_rangsang_defekasi_1[1] + $mengendalikan_rangsang_defekasi_2[1] + 
				$mengendalikan_rangsang_berkemih_0[1] + $mengendalikan_rangsang_berkemih_1[1] + $mengendalikan_rangsang_berkemih_2[1] + 
				$membersihkan_diri_0[1] + $membersihkan_diri_1[1] + $penggunaan_jamban_0[1] + $penggunaan_jamban_1[1] + 
				$penggunaan_jamban_2[1] + $makan_0[1] + $makan_1[1] + $makan_2[1] + $berbaring_ke_duduk_0[1] + 
				$berbaring_ke_duduk_1[1] + $berbaring_ke_duduk_2[1] + $berbaring_ke_duduk_3[1] + $berjalan_0[1] + $berjalan_1[1] + 
				$berjalan_2[1] + $berjalan_3[1] + $memakai_baju_0[1] + $memakai_baju_1[1] + $memakai_baju_2[1] + 
				$naik_turun_tangga_0[1] + $naik_turun_tangga_1[1] + $naik_turun_tangga_2[1] + $mandi_0[1] + $mandi_2[1];
	$skor_st_3 = $mengendalikan_rangsang_defekasi_0[2] + $mengendalikan_rangsang_defekasi_1[2] + $mengendalikan_rangsang_defekasi_2[2] + 
				$mengendalikan_rangsang_berkemih_0[2] + $mengendalikan_rangsang_berkemih_1[2] + $mengendalikan_rangsang_berkemih_2[2] + 
				$membersihkan_diri_0[2] + $membersihkan_diri_1[2] + $penggunaan_jamban_0[2] + $penggunaan_jamban_1[2] + 
				$penggunaan_jamban_2[2] + $makan_0[2] + $makan_1[2] + $makan_2[2] + $berbaring_ke_duduk_0[2] + 
				$berbaring_ke_duduk_1[2] + $berbaring_ke_duduk_2[2] + $berbaring_ke_duduk_3[2] + $berjalan_0[2] + $berjalan_1[2] + 
				$berjalan_2[2] + $berjalan_3[2] + $memakai_baju_0[2] + $memakai_baju_1[2] + $memakai_baju_2[2] + 
				$naik_turun_tangga_0[2] + $naik_turun_tangga_1[2] + $naik_turun_tangga_2[2] + $mandi_0[2] + $mandi_2[2];	
	$skor_st_4 = $mengendalikan_rangsang_defekasi_0[3] + $mengendalikan_rangsang_defekasi_1[3] + $mengendalikan_rangsang_defekasi_2[3] + 
				$mengendalikan_rangsang_berkemih_0[3] + $mengendalikan_rangsang_berkemih_1[3] + $mengendalikan_rangsang_berkemih_2[3] + 
				$membersihkan_diri_0[3] + $membersihkan_diri_1[3] + $penggunaan_jamban_0[3] + $penggunaan_jamban_1[3] + 
				$penggunaan_jamban_2[3] + $makan_0[3] + $makan_1[3] + $makan_2[3] + $berbaring_ke_duduk_0[3] + 
				$berbaring_ke_duduk_1[3] + $berbaring_ke_duduk_2[3] + $berbaring_ke_duduk_3[3] + $berjalan_0[3] + $berjalan_1[3] + 
				$berjalan_2[3] + $berjalan_3[3] + $memakai_baju_0[3] + $memakai_baju_1[3] + $memakai_baju_2[3] + 
				$naik_turun_tangga_0[3] + $naik_turun_tangga_1[3] + $naik_turun_tangga_2[3] + $mandi_0[3] + $mandi_2[3];
	$skor_st_5 = $mengendalikan_rangsang_defekasi_0[4] + $mengendalikan_rangsang_defekasi_1[4] + $mengendalikan_rangsang_defekasi_2[4] + 
				$mengendalikan_rangsang_berkemih_0[4] + $mengendalikan_rangsang_berkemih_1[4] + $mengendalikan_rangsang_berkemih_2[4] + 
				$membersihkan_diri_0[4] + $membersihkan_diri_1[4] + $penggunaan_jamban_0[4] + $penggunaan_jamban_1[4] + 
				$penggunaan_jamban_2[4] + $makan_0[4] + $makan_1[4] + $makan_2[4] + $berbaring_ke_duduk_0[4] + 
				$berbaring_ke_duduk_1[4] + $berbaring_ke_duduk_2[4] + $berbaring_ke_duduk_3[4] + $berjalan_0[4] + $berjalan_1[4] + 
				$berjalan_2[4] + $berjalan_3[4] + $memakai_baju_0[4] + $memakai_baju_1[4] + $memakai_baju_2[4] + 
				$naik_turun_tangga_0[4] + $naik_turun_tangga_1[4] + $naik_turun_tangga_2[4] + $mandi_0[4] + $mandi_2[4];
	$skor_st_6 = $mengendalikan_rangsang_defekasi_0[5] + $mengendalikan_rangsang_defekasi_1[5] + $mengendalikan_rangsang_defekasi_2[5] + 
				$mengendalikan_rangsang_berkemih_0[5] + $mengendalikan_rangsang_berkemih_1[5] + $mengendalikan_rangsang_berkemih_2[5] + 
				$membersihkan_diri_0[5] + $membersihkan_diri_1[5] + $penggunaan_jamban_0[5] + $penggunaan_jamban_1[5] + 
				$penggunaan_jamban_2[5] + $makan_0[5] + $makan_1[5] + $makan_2[5] + $berbaring_ke_duduk_0[5] + 
				$berbaring_ke_duduk_1[5] + $berbaring_ke_duduk_2[5] + $berbaring_ke_duduk_3[5] + $berjalan_0[5] + $berjalan_1[5] + 
				$berjalan_2[5] + $berjalan_3[5] + $memakai_baju_0[5] + $memakai_baju_1[5] + $memakai_baju_2[5] + 
				$naik_turun_tangga_0[5] + $naik_turun_tangga_1[5] + $naik_turun_tangga_2[5] + $mandi_0[5] + $mandi_2[5];
	$skor_st_7 = $mengendalikan_rangsang_defekasi_0[6] + $mengendalikan_rangsang_defekasi_1[6] + $mengendalikan_rangsang_defekasi_2[6] + 
				$mengendalikan_rangsang_berkemih_0[6] + $mengendalikan_rangsang_berkemih_1[6] + $mengendalikan_rangsang_berkemih_2[6] + 
				$membersihkan_diri_0[6] + $membersihkan_diri_1[6] + $penggunaan_jamban_0[6] + $penggunaan_jamban_1[6] + 
				$penggunaan_jamban_2[6] + $makan_0[6] + $makan_1[6] + $makan_2[6] + $berbaring_ke_duduk_0[6] + 
				$berbaring_ke_duduk_1[6] + $berbaring_ke_duduk_2[6] + $berbaring_ke_duduk_3[6] + $berjalan_0[6] + $berjalan_1[6] + 
				$berjalan_2[6] + $berjalan_3[6] + $memakai_baju_0[6] + $memakai_baju_1[6] + $memakai_baju_2[6] + 
				$naik_turun_tangga_0[6] + $naik_turun_tangga_1[6] + $naik_turun_tangga_2[6] + $mandi_0[6] + $mandi_2[6];			
}
?>
<tr>
	<td colspan="4" align="center">TOTAL SKOR</td>
	<td align="center"><?php echo $skor_st_1; ?></td>
	<td align="center"><?php echo $skor_st_2; ?></td>
	<td align="center"><?php echo $skor_st_3; ?></td>
	<td align="center"><?php echo $skor_st_4; ?></td>
	<td align="center"><?php echo $skor_st_5; ?></td>
	<td align="center"><?php echo $skor_st_6; ?></td>
	<td align="center"><?php echo $skor_st_7; ?></td>
</tr>
<tr>
	<td colspan="4" align="center">Perawat</td>
	<td align="center"><select name="perawat_0" id="perawat_0" class="text_dt" style="width:75px;" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[0]) and !empty($perawat[0])){ 
				$xperawat = $perawat[0];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_1" id="perawat_1" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[1]) and !empty($perawat[1])){ 
				$xperawat = $perawat[1];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_2" id="perawat_2" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[2]) and !empty($perawat[2])){ 
				$xperawat = $perawat[2];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_3" id="perawat_3" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[3]) and !empty($perawat[3])){ 
				$xperawat = $perawat[3];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_4" id="perawat_4" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[4]) and !empty($perawat[4])){ 
				$xperawat = $perawat[4];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_5" id="perawat_5" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[5]) and !empty($perawat[5])){ 
				$xperawat = $perawat[5];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
	<td align="center"><select name="perawat_6" id="perawat_6" class="text_dt" style="width:75px;">
		<option> - </option>
		<?php if(isset($perawat[6]) and !empty($perawat[6])){ 
				$xperawat = $perawat[6];
			}else{
				$xperawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			}	
			echo getPerawat($xperawat); ?>
		</select></td>
</tr>
</table>
<table border="0" width="100%">
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tanggal</td><td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>		
</table>
</form>