<?php
$irna_id = $_GET['idx'];
$pod = '';
if(isset($_GET['smn']) and $_GET['smn'] == 'lmkp') $pod = '1';

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_konsul.php');

$sql_konsul = 'SELECT t_irna_lembar_konsul.IRNA_KONSUL_ID,m_pegawai.NAMA_PEGAWAI,
	DATE_FORMAT(t_irna_lembar_konsul.TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
	FROM t_irna_lembar_konsul
	LEFT JOIN m_pegawai 
	ON (t_irna_lembar_konsul.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	WHERE IRNA_ID = "' . $irna_id . '"';
$get_konsul = mysql_query($sql_konsul) or die(mysql_error());	
if(mysql_num_rows($get_konsul) > 0){
?>
<table width="100%" border="1" class="tableData">
<tr>
<?php
$st_tr = '';
$x = 1;
while($dat_konsul = mysql_fetch_array($get_konsul)){ 
	echo '<td align="center"><a href="index.php?link=' . $_GET['link'] . '&smn=lmks&idx=' . $_GET['idx'] . '&ksi=' . $dat_konsul['IRNA_KONSUL_ID'] . '">' . $dat_konsul['TGL_ASSESMENT'] . ' ' . $dat_konsul['NAMA_PEGAWAI'] . '</a></td>';
	if($x == 10){
		echo '</tr><tr>';
		$st_tr = '1';
		$x = 1;
	}	
	$x++;
} 
if($x < 10){
	$z = $x;
	while($z < 12){
		echo '<td align="center">&nbsp;</td>';
	$z++;
	}	
}	
if($st_tr == '') echo '</tr>';
?>
</table></br>
<?php }

$id_konsul = '';
$sebab_konsul = '';
$hasil_konsul = '';
$dokter = '';
$tgl_jawab = '';

if(isset($_GET['ksi'])){	
	$qry_konsul_detail = 'SELECT t_irna_lembar_konsul.IRNA_KONSUL_ID,t_irna_lembar_konsul.IRNA_ID,
		t_irna_lembar_konsul.PEGAWAI_ID,t_irna_lembar_konsul.SEBAB_KONSUL,t_irna_lembar_konsul.HASIL_KONSUL,
		t_irna_lembar_konsul.TGL_ASSESMENT_JAWAB,m_pegawai.NAMA_PEGAWAI
		FROM t_irna_lembar_konsul
		LEFT JOIN m_pegawai 
		ON (t_irna_lembar_konsul.PEGAWAI_ID_PENGIRIM = m_pegawai.PEGAWAI_ID)
		WHERE t_irna_lembar_konsul.IRNA_KONSUL_ID = "' . $_GET['ksi'] . '" ';
	$qry_pod = 'AND (t_irna_lembar_konsul.POD = "" OR t_irna_lembar_konsul.POD IS NULL)';		
	if($pod == '1') $qry_pod = 'AND t_irna_lembar_konsul.POD = "1"';
	$qry_konsul_detail .= $qry_pod;		

	$get_konsul_detail = mysql_query($qry_konsul_detail) or die(mysql_error());
	$dat_konsul_detail = mysql_fetch_assoc($get_konsul_detail);
	$id_konsul = $dat_konsul_detail['IRNA_KONSUL_ID'];
	$sebab_konsul = $dat_konsul_detail['SEBAB_KONSUL'];
	$hasil_konsul = $dat_konsul_detail['HASIL_KONSUL'];
	$dokter = $dat_konsul_detail['PEGAWAI_ID'];	
	$tgl_jawab = $dat_konsul_detail['TGL_ASSESMENT_JAWAB'];	
	$dokter_pengirim = $dat_konsul_detail['NAMA_PEGAWAI'];	
}
?>
<form name="formrujukan" id="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="id_konsul" id="id_konsul" value="<?php echo $id_konsul; ?>" />
    <table border="0" width="90%">
		<?php if($id_konsul != ''){ ?>
		<tr>
			<td valign="top">Dokter Pengirim</td>
            <td colspan="2">
				: <?php echo $dokter_pengirim ; ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td valign="top">Dokter</td>
            <td colspan="2">
				<select name="dokter" class="text_dt">
					<option value="">-</option>
					<?php echo getDokterRanap($dokter); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">Sebab - sebab diadakannya konsultasi</td>
            <td colspan="2"><textarea name="sebab_konsul" class="text_dt10" style="height:250px;" /><?php echo $sebab_konsul; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top">Hasil dan saran konsultasi</td>
            <td colspan="2"><textarea name="hasil_konsul" class="text_dt10" style="height:250px;"  readonly /><?php echo $hasil_konsul; ?></textarea></td>
		</tr>
        <tr>
            <td colspan="2" align="right">&nbsp;</td>
			<td><?php if($irna_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
					<?php if($id_konsul == ''){ ?>
						<input type="button" value="simpan" onclick="simpan();" class="myButton1" />
					<?php }else{ ?>
						<?php if($tgl_jawab == ''){ ?>
							<input type="button" value="simpan" onclick="simpan();" class="myButton1" />
						<?php } ?>
							<?php $sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
									WHERE JNS_PERAWATAN = "2"
									AND NOMR = "' . $nomr . '"
									AND RAWAT_ID = "' . $irna_id . '"
									AND JENIS_DOKUMEN_ID = "31"
									AND ORDER_PENUNJANG = "' . $id_konsul . '"
									ORDER BY FILE_ID DESC LIMIT 1';
								$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
								$dat_view_rm = mysql_fetch_assoc($get_view_rm); ?>
							<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
					<?php } ?>
				<?php } ?></td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formrujukan').submit();
}	
</script>
