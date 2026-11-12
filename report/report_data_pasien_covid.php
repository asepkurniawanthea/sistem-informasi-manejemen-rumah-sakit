<?php
$tahun = date("Y");
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tahun']))
    $tahun = $_SESSION['pendaftaranreportrekapkunjungan_tahun'];
$bulan = date("m");
if (isset($_SESSION['pendaftaranreportrekapkunjungan_bulan']))
    $bulan = $_SESSION['pendaftaranreportrekapkunjungan_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['pendaftaranreportrekapkunjungan_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['pendaftaranreportrekapkunjungan_bulan'] = $_GET['bulan'];
}

?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tahun</td>
            <td><select name="tahun" id="tahun" class="text_dt">
			<option value="2020" <? if($tahun=="2020") echo "selected"?>>2020</option>
			<option value="2021" <? if($tahun=="2021") echo "selected"?>>2021</option>
			<option value="2022" <? if($tahun=="2022") echo "selected"?>>2022</option>
			<option value="2023" <? if($tahun=="2023") echo "selected"?>>2023</option>
			<option value="2024" <? if($tahun=="2024") echo "selected"?>>2024</option>
			<option value="2025" <? if($tahun=="2025") echo "selected"?>>2025</option>
			</select></td>
       </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" id="bulan" class="text_dt">
			<option value="01" <? if($bulan=="01") echo"selected"?>>Januri</option>
			<option value="02" <? if($bulan=="02") echo"selected"?>>Febuari</option>
			<option value="03" <? if($bulan=="03") echo"selected"?>>Maret</option>
			<option value="04" <? if($bulan=="04") echo"selected"?>>April</option>
			<option value="05" <? if($bulan=="05") echo"selected"?>>Mei</option>
			<option value="06" <? if($bulan=="06") echo"selected"?>>Juni</option>
			<option value="07" <? if($bulan=="07") echo"selected"?>>Juli</option>
			<option value="08" <? if($bulan=="08") echo"selected"?>>Agustus</option>
			<option value="09" <? if($bulan=="09") echo"selected"?>>September</option>
			<option value="10" <? if($bulan=="10") echo"selected"?>>Oktober</option>
			<option value="11" <? if($bulan=="11") echo"selected"?>>Nopember</option>
			<option value="12" <? if($bulan=="12") echo"selected"?>>Desember</option>
			</select></td>
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<!--
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			-->
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT TANGGAL_DAFTAR,
sum(IGD_LAKI_SUSPECT) as IGD_LAKI_SUSPECT,
sum(IGD_LAKI_COMFIRM) as IGD_LAKI_COMFIRM,
sum(IGD_PEREMPUAN_SUSPECT) as IGD_PEREMPUAN_SUSPECT,
sum(IGD_PEREMPUAN_COMFIRM) as IGD_PEREMPUAN_COMFIRM,
sum(RAWAT_JALAN_LAKI_SUSPECT) as RAWAT_JALAN_LAKI_SUSPECT,
sum(RAWAT_JALAN_LAKI_COMFIRM) as RAWAT_JALAN_LAKI_COMFIRM,
sum(RAWAT_JALAN_PEREMPUAN_SUSPECT) as RAWAT_JALAN_PEREMPUAN_SUSPECT,
sum(RAWAT_JALAN_PEREMPUAN_COMFIRM) as RAWAT_JALAN_PEREMPUAN_COMFIRM,
sum(RAWAT_INAP_LAKI_SUSPECT) as RAWAT_INAP_LAKI_SUSPECT,
sum(RAWAT_INAP_LAKI_COMFIRM) as RAWAT_INAP_LAKI_COMFIRM,
sum(RAWAT_INAP_PEREMPUAN_SUSPECT) as RAWAT_INAP_PEREMPUAN_SUSPECT,
sum(RAWAT_INAP_PEREMPUAN_COMFIRM) as RAWAT_INAP_PEREMPUAN_COMFIRM 
FROM (

SELECT DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d") as TANGGAL_DAFTAR,
count(case when t_irja.unit_id=9 and m_pasien.jns_kelamin="L" and ST_COVID19="1" then irja_id end) as IGD_LAKI_SUSPECT,
count(case when t_irja.unit_id=9 and m_pasien.jns_kelamin="L" and ST_COVID19="2" then irja_id end) as IGD_LAKI_COMFIRM,
count(case when t_irja.unit_id=9 and m_pasien.jns_kelamin="P" and ST_COVID19="1" then irja_id end) as IGD_PEREMPUAN_SUSPECT,
count(case when t_irja.unit_id=9 and m_pasien.jns_kelamin="P" and ST_COVID19="2" then irja_id end) as IGD_PEREMPUAN_COMFIRM,
count(case when t_irja.unit_id<>9 and m_pasien.jns_kelamin="L" and ST_COVID19="1" then irja_id end) as RAWAT_JALAN_LAKI_SUSPECT,
count(case when t_irja.unit_id<>9 and m_pasien.jns_kelamin="L" and ST_COVID19="2" then irja_id end) as RAWAT_JALAN_LAKI_COMFIRM,
count(case when t_irja.unit_id<>9 and m_pasien.jns_kelamin="P" and ST_COVID19="1" then irja_id end) as RAWAT_JALAN_PEREMPUAN_SUSPECT,
count(case when t_irja.unit_id<>9 and m_pasien.jns_kelamin="P" and ST_COVID19="2" then irja_id end) as RAWAT_JALAN_PEREMPUAN_COMFIRM,
0 as RAWAT_INAP_LAKI_SUSPECT,
0 as RAWAT_INAP_LAKI_COMFIRM,
0 as RAWAT_INAP_PEREMPUAN_SUSPECT,
0 as RAWAT_INAP_PEREMPUAN_COMFIRM
FROM t_irja inner join m_pasien on (t_irja.nomr = m_pasien.nomr) 
where ST_COVID19 is not null and DATE_FORMAT (TANGGAL_DAFTAR,"%Y%m")="'.$tahun.$bulan.'"
group by DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d")
UNION ALL
SELECT DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d") as TANGGAL_DAFTAR,
0 as IGD_LAKI_SUSPECT,
0 as IGD_LAKI_COMFIRM,
0 as IGD_PEREMPUAN_SUSPECT,
0 as IGD_PEREMPUAN_COMFIRM,
0 as RAWAT_JALAN_LAKI_SUSPECT,
0 as RAWAT_JALAN_LAKI_COMFIRM,
0 as RAWAT_JALAN_PEREMPUAN_SUSPECT,
0 as RAWAT_JALAN_PEREMPUAN_COMFIRM,
count(case when m_pasien.jns_kelamin="L" then irna_id end) as RAWAT_INAP_LAKI_SUSPECT,
count(case when m_pasien.jns_kelamin="L" then irna_id end) as RAWAT_INAP_LAKI_COMFIRM,
count(case when m_pasien.jns_kelamin="P" then irna_id end) as RAWAT_INAP_PEREMPUAN_SUSPECT,
count(case when m_pasien.jns_kelamin="P" then irna_id end) as RAWAT_INAP_PEREMPUAN_COMFIRM
FROM t_irna inner join m_pasien on (t_irna.nomr = m_pasien.nomr)
where ST_COVID19 is not null and DATE_FORMAT (TANGGAL_DAFTAR,"%Y%m")="'.$tahun.$bulan.'"
group by DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d")
) tran
group by TANGGAL_DAFTAR ';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
     <th rowspan="3" width="5">No</th>
    <th rowspan="3">Tanggal</th>
    <th colspan="4" scope="col">IGD</th>
    <th colspan="4" scope="col">Rawat Jalan</th>
    <th colspan="4" scope="col">Rawat Inap</th>
    <!--<th rowspan="2" scope="col">Rujukan</th>-->
    <th rowspan="3" scope="col">Action</th>
  </tr>
  <tr>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
  </tr>
  <tr>
    <th >L</th>
    <th >P</th>
    <th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
    <th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
  </tr>
<?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['IGD_LAKI_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['IGD_LAKI_COMFIRM']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['IGD_PEREMPUAN_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['IGD_PEREMPUAN_COMFIRM']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_JALAN_LAKI_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_JALAN_LAKI_COMFIRM']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_JALAN_PEREMPUAN_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_JALAN_PEREMPUAN_COMFIRM']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_INAP_LAKI_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_INAP_LAKI_COMFIRM']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_INAP_PEREMPUAN_SUSPECT']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['RAWAT_INAP_PEREMPUAN_COMFIRM']); ?></td> 
	<td width="100px" align="center"><input type="button" value="kirim" class="myButton"
	onclick="kirim('<?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?>',
	<?php echo $dat_kunjungan['IGD_LAKI_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['IGD_LAKI_COMFIRM']; ?>,
	<?php echo $dat_kunjungan['IGD_PEREMPUAN_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['IGD_PEREMPUAN_COMFIRM']; ?>,
	<?php echo $dat_kunjungan['RAWAT_JALAN_LAKI_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['RAWAT_JALAN_LAKI_COMFIRM']; ?>,
	<?php echo $dat_kunjungan['RAWAT_JALAN_PEREMPUAN_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['RAWAT_JALAN_PEREMPUAN_COMFIRM']; ?>,
	<?php echo $dat_kunjungan['RAWAT_INAP_LAKI_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['RAWAT_INAP_LAKI_COMFIRM']; ?>,
	<?php echo $dat_kunjungan['RAWAT_INAP_PEREMPUAN_SUSPECT']; ?>,
	<?php echo $dat_kunjungan['RAWAT_INAP_PEREMPUAN_COMFIRM']; ?>);"></td>
  </tr>
 <?php $no++; } ?> 
<!-- <tr>
	<td colspan="14" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>-->
</table>
<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
            <input type="hidden" name="xlsfile" value="pendaftaran/xls_rekap_kunjungan_pasien_klinik.php" />
            <input type="hidden" name="xlsname" value="rpt_kunjungan_pasien_klinik.xls" />            
        </form>
<script>
function kirim ( vtanggal,vigd_suspect_l,vigd_suspect_p,vigd_confirm_l,vigd_confirm_p,vrj_suspect_l,vrj_suspect_p,vrj_confirm_l,				vrj_confirm_p,vri_suspect_l,vri_suspect_p,vri_confirm_l,vri_confirm_p){
$.ajax({
  type: "POST",
  url: "http://<?php echo $_SERVER['HTTP_HOST'];?>/nsimrs/shared/bridging_yankes.php?sirskemkes=pasienmasuk",
  data: {tanggal:vtanggal,
  igd_suspect_l:vigd_suspect_l,
  igd_suspect_p:vigd_suspect_p,
  igd_confirm_l:vigd_confirm_l,
  igd_confirm_p:vigd_confirm_p,
  rj_suspect_l:vrj_suspect_l,
  rj_suspect_p:vrj_suspect_p,
  rj_confirm_l:vrj_confirm_l,
  rj_confirm_p:vrj_confirm_p,
  ri_suspect_l:vri_suspect_l,
  ri_suspect_p:vri_suspect_p,
  ri_confirm_l:vri_confirm_l,
  ri_confirm_p:vri_confirm_p},
  success: function(data) {
                           alert (data);
                            }
}); return false
}
</script>
