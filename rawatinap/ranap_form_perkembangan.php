<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
if (isset($_GET['idrc']))
    include('rawatinap/ranap_del_perkembangan.php');	

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_perkembangan.php');			

$irna_perkembangan_id = '';
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$pemberi_asuhan = $_SESSION['SES_SIMRS_PEGAWAI_ID'];
$hasil_asesmen = '';
$intruksi_ppa = '';
$verifikasi_dpjp = '';	

$sql_perkembangan = 'SELECT IRNA_PERKEMBANGAN_ID,TANGGAL_PERIKSA AS TANGGAL,
					t_irna_perkembangan.PEGAWAI_ID,HASIL_ASESMEN,INTRUKSI_PPA,
					VERIFIKASI_DPJP,m_pegawai.NAMA_PEGAWAI
					FROM t_irna_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_irna_perkembangan.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE IRNA_ID = "' . $idx . '"
					ORDER BY TANGGAL_PERIKSA';
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
		<td align="center" width="80px">
		<a href="<?php echo currentUrl(); ?>&idre=<?php echo $dat_perkembangan['IRNA_PERKEMBANGAN_ID']; ?>" >ubah</a>
		<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_perkembangan['IRNA_PERKEMBANGAN_ID']; ?>&nmr=<?php echo $dat_perkembangan['TANGGAL']; ?>" >hapus</a>
		</td>
	</tr>
<?php } ?>
</table>
<br />
<?php 
if(isset($_GET['idre'])){
	$irna_perkembangan_id = $_GET['idre'];
	$sql_ubah = 'SELECT IRNA_PERKEMBANGAN_ID,IRNA_ID,
			DATE_FORMAT(TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL,
			DATE_FORMAT(TANGGAL_PERIKSA,"%H") AS JAM,
			DATE_FORMAT(TANGGAL_PERIKSA,"%i") AS MENIT,
			HASIL_ASESMEN,
			INTRUKSI_PPA,PEGAWAI_ID,VERIFIKASI_DPJP
			FROM t_irna_perkembangan
			WHERE IRNA_PERKEMBANGAN_ID = "' . $irna_perkembangan_id . '"';
	$get_ubah = mysql_query($sql_ubah) or die(mysql_error());		
	$dat_ubah = mysql_fetch_assoc($get_ubah);
	$irna_perkembangan_id = $dat_ubah['IRNA_PERKEMBANGAN_ID'];
	$tanggal = $dat_ubah['TANGGAL'];
	$jam = $dat_ubah['JAM'];
	$menit = $dat_ubah['MENIT'];
	$pemberi_asuhan = $dat_ubah['PEGAWAI_ID'];
	$hasil_asesmen = $dat_ubah['HASIL_ASESMEN'];
	$intruksi_ppa = $dat_ubah['INTRUKSI_PPA'];
	$verifikasi_dpjp = $dat_ubah['VERIFIKASI_DPJP'];	
}
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="irna_perkembangan_id" id="irna_perkembangan_id" value="<?php echo $irna_perkembangan_id; ?>" />
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
                    <?php echo getPelaksanaRanap($pemberi_asuhan, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
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