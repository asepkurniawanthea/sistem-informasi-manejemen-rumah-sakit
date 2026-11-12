<?php
$irna_id = $_GET['idx'];
if (isset($_POST['irna_id'])){
	
	$irna_id = $_POST['irna_id'];
	$id_kontrol = $_POST['id_kontrol'];
	$tgl_assesment = $_POST['tgl_assesment'];
	$jam_assesment = $_POST['jam_assesment'];
	$mnt_assesment = $_POST['mnt_assesment'];
	$kesadaran = $_POST['kesadaran'];
	$suhu = $_POST['suhu'];
	$nadi = $_POST['nadi'];
	$td = $_POST['td'];
	$respirasi = $_POST['respirasi'];
	$pemberian_cairan_peros = $_POST['pemberian_cairan_peros'];
	$pemberian_cairan_parenteral = $_POST['pemberian_cairan_parenteral'];
	$pengeluaran_cairan_bak = $_POST['pengeluaran_cairan_bak'];
	$pengeluaran_cairan_bab = $_POST['pengeluaran_cairan_bab'];
	$pengeluaran_cairan_muntah = $_POST['pengeluaran_cairan_muntah'];
	$pengeluaran_cairan_pendarahan = $_POST['pengeluaran_cairan_pendarahan'];
	$pengeluaran_cairan_lain = $_POST['pengeluaran_cairan_lain'];

	if($id_kontrol == ''){
		mysql_query('INSERT INTO t_irna_kontrol_istimewa (IRNA_ID,KESADARAN,SUHU,NADI,TD,RESPIRASI,PEMBERIAN_CAIRAN_PEROS,
			PEMBERIAN_CAIRAN_PARENTERAL,PENGELUARAN_CAIRAN_BAK,PENGELUARAN_CAIRAN_BAB,PENGELUARAN_CAIRAN_MUNTAH,
			PENGELUARAN_CAIRAN_PENDARAHAN,PENGELUARAN_CAIRAN_LAIN,TGL_ASSESMENT,REGISTER) 
			VALUES ("' . $irna_id . '","' . $kesadaran . '","' . $suhu . '","' . $nadi . '","' . $td . '",
			"' . $respirasi . '","' . $pemberian_cairan_peros . '","' . $pemberian_cairan_parenteral . '",
			"' . $pengeluaran_cairan_bak . '","' . $pengeluaran_cairan_bab . '","' . $pengeluaran_cairan_muntah . '",
			"' . $pengeluaran_cairan_pendarahan . '","' . $pengeluaran_cairan_lain . '",
			STR_TO_DATE("' . $tgl_assesment . ' ' . $jam_assesment . ':' . $mnt_assesment . ':01","%d/%m/%Y %H:%i:%s"),
			"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_kontrol_istimewa 
			SET KESADARAN = "' . $kesadaran . '",
			SUHU = "' . $suhu . '",
			NADI = "' . $nadi . '",
			TD = "' . $td . '",
			RESPIRASI = "' . $respirasi . '",
			PEMBERIAN_CAIRAN_PEROS = "' . $pemberian_cairan_peros . '",
			PEMBERIAN_CAIRAN_PARENTERAL = "' . $pemberian_cairan_parenteral . '",
			PENGELUARAN_CAIRAN_BAK = "' . $pengeluaran_cairan_bak . '",
			PENGELUARAN_CAIRAN_BAB = "' . $pengeluaran_cairan_bab . '",
			PENGELUARAN_CAIRAN_MUNTAH = "' . $pengeluaran_cairan_muntah . '",
			PENGELUARAN_CAIRAN_PENDARAHAN = "' . $pengeluaran_cairan_pendarahan . '",
			PENGELUARAN_CAIRAN_LAIN = "' . $pengeluaran_cairan_lain . '",
			TGL_ASSESMENT = STR_TO_DATE("' . $tgl_assesment . ' ' . $jam_assesment . ':' . $mnt_assesment . ':01","%d/%m/%Y %H:%i:%s"),
			REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
			ST_CREATE_ERM = NULL
			WHERE IRNA_KONTROL_ID = "' . $id_kontrol . '"') or die(mysql_error());
	}
	?>
    <script language="JavaScript" >
        alert('Simpan Data Kontrol Istimewa Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=ktsw&idx=<?php echo $_GET['idx']; ?>";
    </script>		
<?php } ?>
<table class="tableData" id="tfhover" >
	<tr>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Kesadaran</th>
		<th rowspan="2">Suhu</th>
		<th rowspan="2">Nadi</th>
		<th rowspan="2">TD</th>
		<th rowspan="2">Respirasi</th>
		<th colspan="2">Pemberian Cairan</th>
		<th colspan="5">Pengeluaran Cairan</th>
		<th rowspan="2">Perawat</th>
		<th rowspan="2">Option</th>
	</tr>	
	<tr>
		<th>Per Os</th>
		<th>Parenteral</th>
		<th>Diurese<br/>(BAK)</th>
		<th>Defikasi<br/>(BAB)</th>
		<th>Muntah</th>
		<th>Pendarahan</th>
		<th>Lain-lain</th>
	</tr>
	<?php
	$qry_kontrol = 'SELECT IRNA_KONTROL_ID,IRNA_ID,KESADARAN,SUHU,NADI,TD,RESPIRASI,PEMBERIAN_CAIRAN_PEROS,
		PEMBERIAN_CAIRAN_PARENTERAL,PENGELUARAN_CAIRAN_BAK,PENGELUARAN_CAIRAN_BAB,PENGELUARAN_CAIRAN_MUNTAH,
		PENGELUARAN_CAIRAN_PENDARAHAN,PENGELUARAN_CAIRAN_LAIN,
		DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y %H:%i:%s") AS TGL_ASSESMENT,
		REGISTER
		FROM t_irna_kontrol_istimewa
		WHERE IRNA_ID = "' . $irna_id . '"
		ORDER BY TGL_ASSESMENT';
	$get_kontrol = mysql_query($qry_kontrol) or die(mysql_error());
	while($dat_kontrol = mysql_fetch_array($get_kontrol)){ 
		$ada_data = $dat_kontrol['IRNA_KONTROL_ID']; 
	?>
		<tr>
			<td align="center"><?php echo $dat_kontrol['TGL_ASSESMENT']; ?></td>
			<td><?php echo $dat_kontrol['KESADARAN']; ?></td>
			<td><?php echo $dat_kontrol['SUHU']; ?></td>
			<td><?php echo $dat_kontrol['NADI']; ?></td>
			<td><?php echo $dat_kontrol['TD']; ?></td>
			<td><?php echo $dat_kontrol['RESPIRASI']; ?></td>
			<td><?php echo $dat_kontrol['PEMBERIAN_CAIRAN_PEROS']; ?></td>
			<td><?php echo $dat_kontrol['PEMBERIAN_CAIRAN_PARENTERAL']; ?></td>
			<td><?php echo $dat_kontrol['PENGELUARAN_CAIRAN_BAK']; ?></td>
			<td><?php echo $dat_kontrol['PENGELUARAN_CAIRAN_BAB']; ?></td>
			<td><?php echo $dat_kontrol['PENGELUARAN_CAIRAN_MUNTAH']; ?></td>
			<td><?php echo $dat_kontrol['PENGELUARAN_CAIRAN_PENDARAHAN']; ?></td>
			<td><?php echo $dat_kontrol['PENGELUARAN_CAIRAN_LAIN']; ?></td>
			<td><?php echo $dat_kontrol['REGISTER']; ?></td>
			<td align="center">
			<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_kontrol['IRNA_KONTROL_ID']; ?>">ubah</a>
			</td>
		</tr>
	<?php } ?>	
</table>
</br>
<?php 
$id_kontrol = '';

$tgl_assesment = date('d/m/Y');
$jam_assesment = date('H');
$mnt_assesment = date('i');
$kesadaran = '';
$suhu = '';
$nadi = '';
$td = '';
$respirasi = '';
$pemberian_cairan_peros = '';
$pemberian_cairan_parenteral = '';
$pengeluaran_cairan_bak = '';
$pengeluaran_cairan_bab = '';
$pengeluaran_cairan_muntah = '';
$pengeluaran_cairan_pendarahan = '';
$pengeluaran_cairan_lain = '';

if(isset($_GET['idk'])){
	$qry_kontrol = 'SELECT IRNA_KONTROL_ID,IRNA_ID,KESADARAN,SUHU,NADI,TD,RESPIRASI,PEMBERIAN_CAIRAN_PEROS,
		PEMBERIAN_CAIRAN_PARENTERAL,PENGELUARAN_CAIRAN_BAK,PENGELUARAN_CAIRAN_BAB,PENGELUARAN_CAIRAN_MUNTAH,
		PENGELUARAN_CAIRAN_PENDARAHAN,PENGELUARAN_CAIRAN_LAIN,
		DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
		DATE_FORMAT(TGL_ASSESMENT,"%H") AS JAM_ASSESMENT,
		DATE_FORMAT(TGL_ASSESMENT,"%i") AS MNT_ASSESMENT
		FROM t_irna_kontrol_istimewa
		WHERE IRNA_KONTROL_ID = "' . $_GET['idk'] . '"';
	$get_kontrol = mysql_query($qry_kontrol) or die(mysql_error());
	$dat_kontrol = mysql_fetch_assoc($get_kontrol);
	$id_kontrol = $dat_kontrol['IRNA_KONTROL_ID'];
	$tgl_assesment = $dat_kontrol['TGL_ASSESMENT'];
	$jam_assesment = $dat_kontrol['JAM_ASSESMENT'];
	$mnt_assesment = $dat_kontrol['MNT_ASSESMENT'];
	$kesadaran = $dat_kontrol['KESADARAN'];
	$suhu = $dat_kontrol['SUHU'];
	$nadi = $dat_kontrol['NADI'];
	$td = $dat_kontrol['TD'];
	$respirasi = $dat_kontrol['RESPIRASI'];
	$pemberian_cairan_peros = $dat_kontrol['PEMBERIAN_CAIRAN_PEROS'];
	$pemberian_cairan_parenteral = $dat_kontrol['PEMBERIAN_CAIRAN_PARENTERAL'];
	$pengeluaran_cairan_bak = $dat_kontrol['PENGELUARAN_CAIRAN_BAK'];
	$pengeluaran_cairan_bab = $dat_kontrol['PENGELUARAN_CAIRAN_BAB'];
	$pengeluaran_cairan_muntah = $dat_kontrol['PENGELUARAN_CAIRAN_MUNTAH'];
	$pengeluaran_cairan_pendarahan = $dat_kontrol['PENGELUARAN_CAIRAN_PENDARAHAN'];
	$pengeluaran_cairan_lain = $dat_kontrol['PENGELUARAN_CAIRAN_LAIN'];
}	
?>
<form name="search" id="search" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="id_kontrol" id="id_kontrol" value="<?php echo $id_kontrol; ?>" />
    <table border="0" width="90%">
		<tr>
			<td valign="top">Tanggal</td>
            <td colspan="2"><input type="text" name="tgl_assesment" id="tgl_1" class="text_dt" size="10" value="<?php echo $tgl_assesment; ?>" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
			<select name="jam_assesment" id="jam_assesment" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_assesment); ?>
			</select>
			<select name="mnt_assesment" id="mnt_assesment" style="width:50px;" class="text_dt" >
			<?php echo getMenit($mnt_assesment); ?>
			</select></td>
		</tr>
		<tr>
			<td valign="top">Kesadaran</td>
            <td colspan="2"><input type="text" name="kesadaran" class="text_dt" value="<?php echo $kesadaran; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Suhu</td>
            <td colspan="2"><input type="text" name="suhu" class="text_dt" value="<?php echo $suhu; ?>" /></td>
		</tr>
		<tr>
			<td valign="top">Nadi</td>
            <td colspan="2"><input type="text" name="nadi" class="text_dt" value="<?php echo $nadi; ?>" /></td>
		</tr>
		<tr>
			<td valign="top">Tekanan Darah</td>
            <td colspan="2"><input type="text" name="td" class="text_dt" value="<?php echo $td; ?>" /></td>
		</tr>
		<tr>
			<td valign="top">Respirasi</td>
            <td colspan="2"><input type="text" name="respirasi" class="text_dt" value="<?php echo $respirasi; ?>" /></td>
		</tr>
		<tr>
			<td valign="top">Pemberian Cairan :</td>
            <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top">Per Os</td>
            <td colspan="2"><input type="text" name="pemberian_cairan_peros" class="text_dt" value="<?php echo $pemberian_cairan_peros; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Parenteral</td>
            <td colspan="2"><input type="text" name="pemberian_cairan_parenteral" class="text_dt" value="<?php echo $pemberian_cairan_parenteral; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Pengeluaran Cairan :</td>
            <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top">Diurese (BAK)</td>
            <td colspan="2"><input type="text" name="pengeluaran_cairan_bak" class="text_dt" value="<?php echo $pengeluaran_cairan_bak; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Defikasi (BAB)</td>
            <td colspan="2"><input type="text" name="pengeluaran_cairan_bab" class="text_dt" value="<?php echo $pengeluaran_cairan_bab; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Muntah</td>
            <td colspan="2"><input type="text" name="pengeluaran_cairan_muntah" class="text_dt" value="<?php echo $pengeluaran_cairan_muntah; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Pendarahan</td>
            <td colspan="2"><input type="text" name="pengeluaran_cairan_pendarahan" class="text_dt" value="<?php echo $pengeluaran_cairan_pendarahan; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">Lain-lain</td>
            <td colspan="2"><input type="text" name="pengeluaran_cairan_lain" class="text_dt" value="<?php echo $pengeluaran_cairan_lain; ?>" style="width:400px;"/></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
		</tr>
        <tr>
            <td colspan="2" align="right">&nbsp;</td>
			<td><?php if($irna_final == ''){ ?>
			<input type="button" value="simpan" onclick="simpan();" class="myButton1" />
			<?php if(!empty($ada_data)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irna_id . '"
						AND JENIS_DOKUMEN_ID = "31"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
			<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
				<?php } } ?></td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#search').submit();
}	
</script>
