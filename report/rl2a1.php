<!--<script language="javascript" type="text/javascript" src="../include/cal2.js"> </script>
<script language="javascript" type="text/javascript" src="../include/cal_conf2.js"> </script>
<link href="../dq_sirs.css" type="text/css" rel="stylesheet" />-->
<?php 
include '../include/connect.php';
?>
<div align="center">
<div id="frame">
	<div id="frame_title">
	  <h3>Laporan RL2A1</h3></div>
    <form name="formsearch" method="get" >
<table cellspacing="1" width="95%" cellpadding="1" class="tb">
  <tr>
    <td colspan="16" align="center">DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP SURVEILANS RUMAH SAKIT</td>
  </tr>
  <tr>
    <td colspan="16">&nbsp;</td>
  </tr>
  <tr>
    <td width="7"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="10"></td>
    <td width="498"></td>
    <td width="116">Dari tanggal</td>
    <td colspan="3"><input id="tgl_pesan" name="tgl_pesan" <?php echo 'value='.$_GET['tgl_pesan']; ?>></td>
    <td width="44"><a href="javascript:showCal('Calendar3')"><img align="top" src="img/date.png" border="0" /></a></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align="left" valign="top"><table cellpadding="0" cellspacing="0">
      <tr>
          <td width="30"></td>
        </tr>
      </table></td>
    <td>Sampai Tanggal</td>
    <td colspan="3"><input id="tgl_pesan2" name="tgl_pesan2" <?php echo 'value='.stripslashes($_GET['tgl_pesan2']); ?>></td>
    <td><a href="javascript:showCal('Calendar11')"><img align="top" src="img/date.png" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="4">&nbsp;</td>
    <td></td>
    <td width="24"></td>
    <td width="61"><input type="hidden" id="link" name="link" value="RL2A1" /></td>
    <td width="55"><input type="submit" class="text" value="CARI" /></td>
    <td></td>
  </tr>
</table>
</form>

<table cellspacing="1" cellpadding="1" class="tb">
  <tr>
    <th width="55" rowspan="5">NOURUT</th>
    <th width="49" rowspan="5">NODTD</th>
    <th width="148" rowspan="5">NO.DAFTARTERPERINCI</th>
    <th width="174" rowspan="5">GOLONGAN SEBAB-SEBAB SAKIT</th>
    <th colspan="8" rowspan="3">PASIEN KELUAR (HIDUP &amp;  MATI) MENURUT GOLONGAN UMUR</th>
    <th colspan="2">PASIEN KEL</th>
    <th width="55">&nbsp;</th>
    <th width="58">JML</th>
  </tr>
  <tr>
    <th colspan="2">(H &amp; M) ME-</th>
    <th width="55">JML</th>
    <th width="58">PASIEN</th>
  </tr>
  <tr>
    <th colspan="2">NURUT SEX</th>
    <th width="55">PASIEN</th>
    <th width="58">KEL.</th>
  </tr>
  <tr>
    <th width="28">0-28</th>
    <th width="38">28 HR-</th>
    <th width="26">1-4</th>
    <th width="26">5-14</th>
    <th width="30">15-24</th>
    <th width="30">25-44</th>
    <th width="30">45-64</th>
    <th width="32">65+</th>
    <th width="45">&nbsp;</th>
    <th width="27">&nbsp;</th>
    <th width="55">KELUAR</th>
    <th width="58">MATI</th>
  </tr>
  <tr>
    <th width="28">HR</th>
    <th width="38">&lt;1TH</th>
    <th width="26">TH</th>
    <th width="26">TH</th>
    <th width="30">TH</th>
    <th width="30">TH</th>
    <th width="30">TH</th>
    <th width="32">TH</th>
    <th width="45">LK</th>
    <th width="27">PR</th>
    <th width="55">(13+14)</th>
    <th width="58">&nbsp;</th>
  </tr>
  <tr>
    <th width="55">1</th>
    <th width="49">2</th>
    <th width="148">3</th>
    <th width="174">4</th>
    <th width="28">5</th>
    <th width="38">6</th>
    <th width="26">7</th>
    <th width="26">8</th>
    <th width="30">9</th>
    <th width="30">10</th>
    <th width="30">11</th>
    <th width="32">12</th>
    <th width="45">13</th>
    <th width="27">14</th>
    <th width="55">15</th>
    <th width="58">16</th>
  </tr>
  <?
  $SQL = "call pr_rl2a1('".$_GET['tgl_pesan']."','".$_GET['tgl_pesan2']."')";
  $QUERY = mysql_query($SQL)or die(mysql_error());
  $no=0;
  while($DATA=mysql_fetch_array($QUERY)){
  ?>
  <tr <?   echo "class =";
                $count++;
                if ($count % 2) {
                echo "tr1"; }
                else {
                echo "tr2";
                }
        ?>>    
    <td><?php  $no=$no+1; echo $no;?></td>
    <td><?php  echo $DATA['dtd']?></td>
    <td><?php  echo $DATA['norinci'];  ?>  </td>
    <td><?php  echo $DATA['sebabpenyakit']?></td>
    <td><?php  echo $DATA['_28hr']?></td>
    <td><?php  echo $DATA['_1thn']?></td>
    <td><?php  echo $DATA['_4thn']?></td>
    <td><?php  echo $DATA['_14thn']?></td>
    <td><?php  echo $DATA['_24thn']?></td>
    <td><?php  echo $DATA['_44thn']?></td>
    <td><?php  echo $DATA['_64thn']?></td>
    <td><?php  echo $DATA['_65thn']?></td>
    <td><?php  echo $DATA['L']?></td>
    <td><?php  echo $DATA['P']?></td>
    <td><?php  if($DATA['L']+$DATA['P']!=0)echo $DATA['L']+$DATA['P'];?></td>
    <td> </td>
  </tr>
  <? } ?>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td width="28">&nbsp;</td>
    <td width="38">&nbsp;</td>
    <td width="26">&nbsp;</td>
    <td width="26">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td width="32">&nbsp;</td>
    <td width="45">&nbsp;</td>
    <td width="27">&nbsp;</td>
    <td width="55">&nbsp;</td>
    <td width="58">&nbsp;</td>
  </tr>
</table>
<div align="right" class="tb" style="background-color:#FFF">  
  <div>
<br />
<form name="formprint" method="post" action="rm/excelexport.php" target="_blank" >
<input type="hidden" name="query" value="<?=$SQL?>" />
<input type="hidden" name="header" value="LAPORAN RL2A1" />
<input type="hidden" name="filename" value="rl2a1" />
<input type="submit" value="Export To Ms Excel Document" class="text" /> 
</form>
    
    </div>
</div>

</div>
</div>