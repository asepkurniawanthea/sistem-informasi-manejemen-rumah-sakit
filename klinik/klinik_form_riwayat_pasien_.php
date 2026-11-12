<?php 
$tgl_1 = '';
if (isset($_SESSION['rmsearch_tgl_1']))
    $tgl_1 = $_SESSION['rmsearch_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearch_tgl_1']))
    $tgl_2 = $_SESSION['rmsearch_tgl_2'];
if (isset($_POST['tgl_1'])) {
    $tgl_1 = $_POST['tgl_1'];
    $_SESSION['rmsearch_tgl_1'] = $_POST['tgl_1'];
}
if (isset($_POST['tgl_2'])) {
    $tgl_2 = $_POST['tgl_2'];
    $_SESSION['rmsearch_tgl_2'] = $_POST['tgl_2'];
}

$jnsdoc = '';
if (isset($_SESSION['rmsearch_jnsdoc']))
		$jnsdoc = $_SESSION['rmsearch_jnsdoc'];

if (isset($_POST['jnsdoc'])) {
    $jnsdoc = $_POST['jnsdoc'];
	$_SESSION['rmsearch_jnsdoc'] = $jnsdoc;
}
?>
<form name="search" method="post" action="<?php echo currentUrl(); ?>" >
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Jenis Dokumen</td>
            <td><select name="jnsdoc" class="text_dt" >
				<option value=""> - </option>
				<?php $qry_doc = 'SELECT * FROM m_rm_jenis_dokumen ORDER BY LIST_ORDER';
					$get_doc = mysql_query($qry_doc) or die(mysql_error()); 
					while($dat_doc = mysql_fetch_array($get_doc)){ ?>
					<option value="<?php echo $dat_doc['JENIS_DOKUMEN_ID']; ?>" <?php if($dat_doc['JENIS_DOKUMEN_ID'] == $jnsdoc) echo 'selected'; ?>><?php echo $dat_doc['JENIS_DOKUMEN']; ?></option>
					<?php } ?>
			</select></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" /></td>		
		</tr>
    </table>
</form>
<br />
<?php include('klinik/klinik_tmp_riwayat_pasien.php'); ?>	