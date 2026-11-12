<?php
$tgl_1 = '';
if (isset($_SESSION['casemixmomnitoring_irja_tgl_1']))
    $tgl_1 = $_SESSION['casemixmomnitoring_irja_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['casemixmomnitoring_irja_tgl_1']))
    $tgl_2 = $_SESSION['casemixmomnitoring_irja_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['casemixmomnitoring_irja_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['casemixmomnitoring_irja_tgl_2'] = $_GET['tgl_2'];
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td align="right">&nbsp;</td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="20">No</th>
        <th width="80">Nomor MR</th>
        <th>Nama Pasien</th>
		<th width="40">Jns Kel</th>
		<th width="80">Tgl Lahir</th>
        <th>Poliklinik</th>
        <th>Dokter</th>
		<th>Pembayaran</th>
        <th>Diagnosa</th>
        <th width="80">Tarif Tindakan</th>
        <th width="80">Penunjang</th>
        <th width="80">Farmasi</th>
		<th width="80">Tarif Inacbgs</th>
		<th>Register</th>
        <th width="50">Option</th>
    </tr>
<?php
$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) 
	$tgl_filter_1 = 'CURRENT_DATE()';

$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) 
	$tgl_filter_2 = $tgl_filter_1;
					
$sql_monitor = 'SELECT t_trans.IRJA_ID,
					t_trans.NOMR,
					m_pasien.NAMA_PASIEN,
					m_pasien.JNS_KELAMIN,
					m_pasien.TGL_LAHIR,
					m_unit.NAMA_UNIT AS POLIKLINIK,
					m_pegawai.NAMA_PEGAWAI AS DOKTER,
					m_jaminan.NAMA_JAMINAN AS JAMINAN,
					t_trans.DIAGNOSA_1,
					t_trans.DIAGNOSA_2,
					t_trans.DIAGNOSA_3,
					SUM(t_trans.TARIF) AS TARIF,
					SUM(t_trans.TARIF_PENUNJANG) AS TARIF_PENUNJANG,
					SUM(t_trans.TARIF_FARMASI) AS TARIF_FARMASI,
					MIN(t_cbg_tarif.TARIF_CBG) AS TARIF_INACBGS,
					t_cbg_tarif_mon_irja.USER_CASEMIX
				FROM 
					(
						SELECT t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 0 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_1,
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 1 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_2,
							MAX(CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 2 THEN t_irja_diagnosa.ICD_CODE ELSE "" END) AS DIAGNOSA_3,
							0 AS TARIF,
							0 AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
						WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL
						GROUP BY t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID,	
							t_irja.PEGAWAI_ID,	
							t_irja.JENIS_BAYAR_ID	
						
						UNION					
						
						SELECT t_irja.IRJA_ID,
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							SUM(m_tarif.TARIF_NON_KELAS * t_irja_tarif.KUANTITI) AS TARIF,
							0 AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_tarif ON (
								t_irja.IRJA_ID = t_irja_tarif.IRJA_ID
								AND (t_irja_tarif.ST_BAYAR != "Batal"
								OR t_irja_tarif.ST_BAYAR IS NULL)
							)
							INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL
						GROUP BY t_irja.IRJA_ID
						
						UNION
						
						SELECT t_irja.IRJA_ID, 
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							0 AS TARIF,
							SUM(m_tarif.TARIF_NON_KELAS * t_ipenunjang_tarif.KUANTITI) AS TARIF_PENUNJANG,
							0 AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID AND t_ipenunjang.JNS_ORDER = "IRJ")
							INNER JOIN t_ipenunjang_tarif ON (
							t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID
								AND (t_ipenunjang_tarif.ST_BAYAR != "Batal"
								OR t_ipenunjang_tarif.ST_BAYAR IS NULL)
						)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							WHERE  t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL
						GROUP BY t_irja.IRJA_ID
						
						UNION
						
						SELECT t_irja.IRJA_ID, 
							t_irja.NOMR,
							t_irja.UNIT_ID AS POLIKLINIK,	
							t_irja.PEGAWAI_ID AS DOKTER,	
							t_irja.JENIS_BAYAR_ID AS JAMINAN,
							2 AS JNS_RAWAT,
							CASE WHEN t_irja.UNIT_ID = 35 THEN "0" ELSE "1" END AS KELAS_RS,
							"3" AS KELAS_RAWAT,	
							"" AS DIAGNOSA_1,
							"" AS DIAGNOSA_2,
							"" AS DIAGNOSA_3,
							0 AS TARIF,
							0 AS TARIF_PENUNJANG,
							SUM(t_irja_resep.HARGA * t_irja_resep.JUMLAH_KELUAR) AS TARIF_FARMASI
						FROM t_irja
							INNER JOIN t_irja_resep ON (t_irja.IRJA_ID = t_irja_resep.IRJA_ID)
							WHERE  t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
							AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL 
							AND t_irja.PASIEN_MASUK IS NOT NULL
						GROUP BY t_irja.IRJA_ID							
							) t_trans
						INNER JOIN m_pasien ON (t_trans.NOMR = m_pasien.NOMR)
						INNER JOIN m_unit ON (t_trans.POLIKLINIK = m_unit.UNIT_ID)
						INNER JOIN m_pegawai ON (t_trans.DOKTER = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_jaminan ON (t_trans.JAMINAN = m_jaminan.JAMINAN_ID)
						INNER JOIN t_cbg_tarif_mon_irja ON (t_trans.IRJA_ID = t_cbg_tarif_mon_irja.IRJA_ID AND t_cbg_tarif_mon_irja.ST_MON = "1") 
						LEFT JOIN t_cbg_tarif ON (t_trans.DIAGNOSA_1 = t_cbg_tarif.DIAGNOSA_UTAMA
							AND t_trans.DIAGNOSA_2 = t_cbg_tarif.DIAGNOSA_SEKUNDER_1 AND t_trans.DIAGNOSA_3 = t_cbg_tarif.DIAGNOSA_SEKUNDER_2
							AND t_trans.JNS_RAWAT = t_cbg_tarif.JNS_RAWAT AND t_trans.KELAS_RS = t_cbg_tarif.KELAS_RS
							AND t_trans.KELAS_RAWAT = t_cbg_tarif.KELAS_RAWAT)
						GROUP BY t_trans.IRJA_ID,t_trans.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,m_pasien.TGL_LAHIR,
							m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN
						ORDER BY t_cbg_tarif_mon_irja.CBG_IRJA_ID';
				$get_monitor = mysql_query($sql_monitor) or die(mysql_error());
				$i = 1;
				while($dat_monitor = mysql_fetch_array($get_monitor)){
					echo '<tr>';
					echo '<td align="center">' . $i . '</td>';
					echo '<td align="center">' . formatNomr($dat_monitor['NOMR']) . '</td>';
					echo '<td>' . $dat_monitor['NAMA_PASIEN'] . '</td>';
					echo '<td align="center">' . $dat_monitor['JNS_KELAMIN'] . '</td>';
					echo '<td align="center">' . changeDateFormat($dat_monitor['TGL_LAHIR']) . '</td>';
					echo '<td>' . $dat_monitor['POLIKLINIK'] . '</td>';
					echo '<td>' . $dat_monitor['DOKTER'] . '</td>';
					echo '<td>' . $dat_monitor['JAMINAN'] . '</td>';
					$diagnosa = $dat_monitor['DIAGNOSA_1'];
					if(!empty($dat_monitor['DIAGNOSA_2']))
						$diagnosa = $diagnosa . ', ' . $dat_monitor['DIAGNOSA_2'];
					if(!empty($dat_monitor['DIAGNOSA_3']))
						$diagnosa = $diagnosa . ', ' . $dat_monitor['DIAGNOSA_3'];	
					echo '<td>' . $diagnosa . '</td>';
					echo '<td align="right">' . currFormat($dat_monitor['TARIF']) . '</td>';
					echo '<td align="right">' . currFormat($dat_monitor['TARIF_PENUNJANG']) . '</td>';
					echo '<td align="right">' . currFormat($dat_monitor['TARIF_FARMASI']) . '</td>';
					echo '<td align="right">' . currFormat($dat_monitor['TARIF_INACBGS']) . '</td>';
					echo '<td>' . $dat_monitor['USER_CASEMIX'] . '</td>';
					echo '<td><a href="index.php?link=' . md5('klinikformpasienperiksa') . '&idx=' . $dat_monitor['IRJA_ID'] . '" >buka</a></td>';
					echo '</tr>';
				$i++; }
?>	
</table>
<span id="sound_ebd">
</span>
 <script language="JavaScript" >
	
	$(document).ready(function(){
        setInterval(function(){get_monitor()},60000);
    });
	
	function playSound(soundfile) {
		document.getElementById("sound_ebd").innerHTML= '<embed src="' +soundfile+ '" hidden="true" autostart="true" loop="false" />';
	}
    
	function get_monitor(){
		var rows = document.getElementById("tfhover").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
		
		$.ajax({
			type: 'POST',
			url: 'index.php?ajaxrequest=casemixirjamon',
			data: { tgl_1 : '<?php echo $tgl_1; ?>', tgl_2 : '<?php echo $tgl_2; ?>', vrows : rows },
			cache: false,
			success: function(data) {
				
				if (data.length > 2){
					playSound('casemix/ringout.wav');	
				
					$("#tfhover").find('tbody')
						.append($(data));
				}	
				
			},});
	}
	
 </script>