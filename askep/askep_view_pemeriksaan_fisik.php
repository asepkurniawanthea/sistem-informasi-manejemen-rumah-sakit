<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

$sql_grafik = 'SELECT TENSI_ID,TANGGAL,NADI_SUHU,PERNAFASAN,
				TEKANAN_DARAH,BERAT_TINGGI_BADAN,USER_ASKEP
				FROM t_irna_askep_tensi_nafas_nadi_suhu
				WHERE TENSI_ID = "' . $irna_id . '"';
$get_grafik = mysql_query($sql_grafik) or die(mysql_error());
$dat_grafik = mysql_fetch_assoc($get_grafik);
$tensi_id = $dat_grafik['TENSI_ID'];
$tanggal = explode('|',$dat_grafik['TANGGAL']);
$nadi_suhu = explode('|',$dat_grafik['NADI_SUHU']);
$pernafasan = explode('|',$dat_grafik['PERNAFASAN']);
$tekanan_darah = explode('|',$dat_grafik['TEKANAN_DARAH']);
$berat_tinggi_badan = explode('|',$dat_grafik['BERAT_TINGGI_BADAN']);
?>
<div style="width:1250px;overflow:scroll;" >
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="tensi_id" id="tensi_id" value="<?php echo $tensi_id; ?>" />
  <table width="100%" border="1" class="tableData">
  <tr>
    <th colspan="30">GRAFIK</th>
  </tr>
  <tr>
    <td colspan="2">TANGGAL</td>
    <td colspan="4" align="center">1-
	<input type="text" name="tanggal_1" id="tgl_edu_1" value="<?php if(isset($tanggal[0])) echo $tanggal[0]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
    <td colspan="4" align="center">2-
	<input type="text" name="tanggal_2" id="tgl_edu_2" value="<?php if(isset($tanggal[1])) echo $tanggal[1]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
    <td colspan="4" align="center">3-
	<input type="text" name="tanggal_3" id="tgl_edu_3" value="<?php if(isset($tanggal[2])) echo $tanggal[2]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
    <td colspan="4" align="center">4-
	<input type="text" name="tanggal_4" id="tgl_edu_4" value="<?php if(isset($tanggal[3])) echo $tanggal[3]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
    <td colspan="4" align="center">5-
	<input type="text" name="tanggal_5" id="tgl_edu_5" value="<?php if(isset($tanggal[4])) echo $tanggal[4]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></td>
    <td colspan="4" align="center">6-
	<input type="text" name="tanggal_6" id="tgl_edu_6" value="<?php if(isset($tanggal[5])) echo $tanggal[5]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu6')"/></td>
    <td colspan="4" align="center">7-
	<input type="text" name="tanggal_7" id="tgl_edu_7" value="<?php if(isset($tanggal[6])) echo $tanggal[6]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu7')"/></td>
  </tr>
  <tr>
    <td align="center">Nadi</td>
    <td align="center">Suhu</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
    <td align="center">6</td>
    <td align="center">12</td>
    <td align="center">18</td>
    <td align="center">24</td>
  </tr>
  <tr>
    <td rowspan="2" valign="top" align="center">180</td>
    <td rowspan="2" valign="top" align="center">42</td>
    <?php $x = 0; 
	while($x<28){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 28; 
	while($x<56){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="3" valign="bottom" align="center">160</td>
    <td rowspan="3" valign="bottom" align="center">41</td>
    <?php $x = 56; 
	while($x<84){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 84; 
	while($x<112){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 112; 
	while($x<140){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">140</td>
    <td rowspan="5" valign="bottom" align="center">40</td>
    <?php $x = 140; 
	while($x<168){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 168; 
	while($x<196){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 196; 
	while($x<224){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 224; 
	while($x<252){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 252; 
	while($x<280){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">120</td>
    <td rowspan="5" valign="bottom" align="center">39</td>
    <?php $x = 280; 
	while($x<308){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 308; 
	while($x<336){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 336; 
	while($x<364){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 364; 
	while($x<392){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 392; 
	while($x<420){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">100</td>
    <td rowspan="5" valign="bottom" align="center">38</td>
    <?php $x = 420; 
	while($x<448){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 448; 
	while($x<476){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 476; 
	while($x<504){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 504; 
	while($x<532){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 532; 
	while($x<560){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">80</td>
    <td rowspan="5" valign="bottom" align="center">37</td>
    <?php $x = 560; 
	while($x<588){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 588; 
	while($x<616){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 616; 
	while($x<644){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 644; 
	while($x<672){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 672; 
	while($x<700){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">60</td>
    <td rowspan="5" valign="bottom" align="center">36</td>
    <?php $x = 700; 
	while($x<728){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 728; 
	while($x<756){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 756; 
	while($x<784){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 784; 
	while($x<812){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 812; 
	while($x<840){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td rowspan="5" valign="bottom" align="center">40</td>
    <td rowspan="5" valign="bottom" align="center">35</td>
    <?php $x = 840; 
	while($x<868){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 868; 
	while($x<896){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 896; 
	while($x<924){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 924; 
	while($x<952){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <?php $x = 952; 
	while($x<980){ ?>
	<td align="center"><input type="checkbox" name="nadi_suhu_<?php echo $x+1; ?>" value="1" <?php if(isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td colspan="2">Pernafasan</td>
    <?php $x = 0; 
	while($x<28){ ?>
	<td align="center"><input type="text" name="pernafasan_<?php echo $x+1; ?>" value="<?php if(isset($pernafasan[$x])) echo  $pernafasan[$x]; ?>" class="text_dt" style="width:25px;" /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td colspan="2">Tekanan Darah </td>
    <?php $x = 0; 
	while($x<14){ ?>
	<td colspan="2" align="center"><input type="text" name="tekanan_darah_<?php echo $x+1; ?>" value="<?php if(isset($tekanan_darah[$x])) echo  $tekanan_darah[$x]; ?>" class="text_dt" style="width:60px;" /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
    <td colspan="2">BB &amp; TB </td>
    <?php $x = 0; 
	while($x<7){ ?>
	<td colspan="4" align="center"><input type="text" name="berat_tinggi_badan_<?php echo $x+1; ?>" value="<?php if(isset($berat_tinggi_badan[$x])) echo  $berat_tinggi_badan[$x]; ?>" class="text_dt" style="width:140px;" /></td>
    <?php $x++; } ?>
  </tr>
  <tr>
            <td colspan="30" align="right">
			&nbsp;
			</td>	
        </tr>
</table>
</form>
</div>