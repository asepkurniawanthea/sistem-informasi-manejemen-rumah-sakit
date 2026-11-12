<?php
$nomr = '';
if (isset($_SESSION['rmsearchearsip_nomr']))
    $nomr = $_SESSION['rmsearchearsip_nomr'];

if (isset($_GET['nomr'])){
    $nomr = $_GET['nomr'];
	$_SESSION['rmsearchearsip_nomr'] = $nomr;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
			<td>Nomor MR</td>
            <td colspan="2"><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
if(!empty($nomr)){

$sql_search = 'SELECT *,DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_search = mysql_query($sql_search) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_search);
$nama_pasien = (($dat_pasien['NAMA_PASIEN'] != '') ? $dat_pasien['NAMA_PASIEN'] : '&nbsp;');
$tgl_lahir = (($dat_pasien['TGL_LAHIR'] != '') ? $dat_pasien['TGL_LAHIR'] : '&nbsp;');
$jns_kelamin = (($dat_pasien['JNS_KELAMIN'] != '') ? $dat_pasien['JNS_KELAMIN'] : '&nbsp;');
$alamat = (($dat_pasien['ALAMAT'] != '') ? $dat_pasien['ALAMAT'] : '&nbsp;');
$nik = (($dat_pasien['NIK'] != '') ? $dat_pasien['NIK'] : '&nbsp;');
	
$umur = getUmur($tgl_lahir);
	?>
	<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php
	$qry_riwayat = 'SELECT t_rm_dokumen_earsip.FILE_ID,
			CASE WHEN t_rm_dokumen_earsip.JNS_PERAWATAN = "1" THEN "Rawat Jalan" 
				WHEN t_rm_dokumen_earsip.JNS_PERAWATAN = "2" THEN "Rawat Inap"
			END AS JNS_PERAWATAN,
			DATE_FORMAT(t_rm_dokumen_earsip.TANGGAL,"%d-%m-%Y") AS TANGGAL,
			t_rm_dokumen_earsip.NAMA_FILE
			FROM t_rm_dokumen_earsip
			WHERE t_rm_dokumen_earsip.NOMR = "' . $nomr . '"
			ORDER BY t_rm_dokumen_earsip.TANGGAL DESC';
	$extparam = '&nomr=' . $nomr;
	include('rekammedik/rm_list_earsip.php');
	echo '</div>';
}
?>
