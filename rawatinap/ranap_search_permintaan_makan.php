<style>
.list_isi{
	height:550px;
}
</style>
<?php
$ruang_id = '';
if (isset($_SESSION['ranapsearchpermintaangizi_ruang_id']))
		$ruang_id = $_SESSION['ranapsearchpermintaangizi_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['ranapsearchpermintaangizi_ruang_id'] = $ruang_id;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
			<td>Ruang</td>
			<td><select name="ruang_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('ranapformpermintaanmakan'); ?>"><input type="button" value="permintaan baru" class="myButton" /></a></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_menugizi = 'SELECT DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				t_irna.NOMR,m_pasien.NAMA_PASIEN,
				m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_gizi_permintaan_makan_ranap.DIAGNOSA,
				t_gizi_permintaan_makan_ranap.DIET,
				t_gizi_permintaan_makan_ranap.ALERGI,
				t_gizi_permintaan_makan_ranap.VEGETARIAN,
				t_gizi_permintaan_makan_ranap.PUASA,
				t_gizi_permintaan_makan_ranap.JENIS_MAKAN,
				t_gizi_permintaan_makan_ranap.USER_UNIT,
				t_irna.NO_TMP_TIDUR,t_irna.IRNA_ID,
				t_gizi_permintaan_makan_ranap.KAMAR
				FROM db_simrs.t_irna 
				INNER JOIN db_simrs.m_pasien 
				ON (t_irna.NOMR = m_pasien.NOMR) 
				INNER JOIN db_simrs.m_ruang 
				ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN db_inventorirs.t_gizi_permintaan_makan_ranap 
				ON (t_irna.IRNA_ID = t_gizi_permintaan_makan_ranap.RANAP_ID)
				WHERE t_irna.PASIEN_MASUK IS NOT NULL AND t_irna.ST_BATAL IS NULL	
				AND t_irna.ST_PULANG IS NULL
				' . (($ruang_id != '') ? 'AND m_ruang.BANGSAL = "' . $ruang_id . '"' : '') . '
				ORDER BY m_pasien.NAMA_PASIEN';

$extparam = '&ruang_id=' . $ruang_id;
include('rawatinap/ranap_list_permintaan_makan.php');
?>
