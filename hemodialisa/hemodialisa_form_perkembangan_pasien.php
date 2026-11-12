<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irja_id = $_GET['idx'];
$jns_order = $_GET['ord'];

if($status_anamnesis == '1' && $status_diagnosa == '1'){
	
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$pemberi_asuhan = '';
$hasil_asesmen = '';
$intruksi_ppa = '';
$verifikasi_dpjp = '';	

if (isset($_GET['idrc']))
    include('hemodialisa/hemodialisa_del_perkembangan_pasien.php');	

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_perkembangan_pasien.php');			

if(empty($jns_order)){
	$sql_perkembangan = 'SELECT t_irja_perkembangan.IRJA_PERKEMBANGAN_ID,t_irja_perkembangan.TANGGAL,
					t_irja_perkembangan.PEMBERI_ASUHAN,t_irja_perkembangan.HASIL_ASESMEN,t_irja_perkembangan.INTRUKSI_PPA,
					t_irja_perkembangan.VERIFIKASI_DPJP,m_pegawai.NAMA_PEGAWAI
					FROM t_irja_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_irja_perkembangan.IRJA_ID = "' . $irja_id . '"
					ORDER BY t_irja_perkembangan.TANGGAL';
}else{
	$sql_perkembangan = 'SELECT t_hemodialisa_perkembangan.HEMODIALISA_PERKEMBANGAN_ID AS IRJA_PERKEMBANGAN_ID,t_hemodialisa_perkembangan.TANGGAL,
					t_hemodialisa_perkembangan.PEMBERI_ASUHAN,t_hemodialisa_perkembangan.HASIL_ASESMEN,t_hemodialisa_perkembangan.INTRUKSI_PPA,
					t_hemodialisa_perkembangan.VERIFIKASI_DPJP,m_pegawai.NAMA_PEGAWAI
					FROM t_hemodialisa_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_hemodialisa_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_hemodialisa_perkembangan.HEMODIALISA_ID = "' . $irja_id . '"
					ORDER BY t_hemodialisa_perkembangan.TANGGAL';
}					
$get_perkembangan = mysql_query($sql_perkembangan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>Tanggal<br />& Pukul</th>
	<th>Profesional<br />Pemberi Asuhan</th>
	<th>Hasil Asesmen-IAR<br />Penatalaksana Pasien (SOAP/ ADIME)</th>
	<th>Intruksi PPA<br />(Termasuk Pasca Bedah)</th>
	<th>Verifikasi DPJP</th>
	<th>Option</th>
</tr>
<?php while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){ ?>
	<tr>
		<td><?php echo $dat_perkembangan['TANGGAL']; ?></td>
		<td><?php echo $dat_perkembangan['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $dat_perkembangan['HASIL_ASESMEN']; ?></td>
		<td><?php echo $dat_perkembangan['INTRUKSI_PPA']; ?></td>
		<td><?php echo $dat_perkembangan['VERIFIKASI_DPJP']; ?></td>
		<td align="center"><a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_perkembangan['IRJA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >hapus</a></td>
	</tr>
<?php } ?>
</table>
<br />
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="jns_order" id="jns_order" value="<?php echo $jns_order; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0" width="100%">
	<tr><td>
	<table border="0" width="100%">
	<tr>
    <td>&nbsp;</td>
    <td>Tanggal & Pukul</td>
    <td><input type="text" name="tanggal" id="tgl_1" size="15" class="text_dt" value="<?php echo $tanggal; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/>
	  <select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select></td>
    <td>&nbsp;</td>
	</tr>
	<tr>
    <td>&nbsp;</td>
    <td width="180">Profesional Pemberi Asuhan</td>
    <td width="200"><select name="pemberi_asuhan" id="pemberi_asuhan" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($pemberi_asuhan); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Hasil Asesmen-IAR</td>
    <td><textarea name="hasil_asesmen" rows="5" class="text_dt3" ><?php echo $hasil_asesmen; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Intruksi PPA</td>
    <td><textarea name="intruksi_ppa" rows="5" class="text_dt3" ><?php echo $intruksi_ppa; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Verifikasi DPJP</td>
    <td><textarea name="verifikasi_dpjp" rows="5" class="text_dt3" ><?php echo $verifikasi_dpjp; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="simpan" value="simpan" class="myButton1" /></td>
    <td>&nbsp;</td>
  </tr>
  </table>
	</td>
	<td>
	</td></tr></table>
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&idx=<?php echo $irja_id; ?>";
 </script>
<?php } ?>