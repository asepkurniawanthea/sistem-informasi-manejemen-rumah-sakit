<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
$penyetor = '';
if (isset($_SESSION['pembayaranreportrekapbayar_penyetor']))
    $penyetor = $_SESSION['pembayaranreportrekapbayar_penyetor'];
$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportrekapbayar_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportrekapbayar_jns_bayar'];

if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
}
if (isset($_GET['penyetor'])) {
    $penyetor = $_GET['penyetor'];
    $_SESSION['pembayaranreportrekapbayar_penyetor'] = $_GET['penyetor'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportrekapbayar_jns_bayar'] = $_GET['jns_bayar'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$cash = '';
if (isset($_SESSION['pembayaranreportrekapbayar_cash']))
    $cash = $_SESSION['pembayaranreportrekapbayar_cash'];

if (isset($_GET['cash'])) {
    $cash = $_GET['cash'];
    $_SESSION['pembayaranreportrekapbayar_cash'] = $_GET['cash'];
}

$rekening = '';
if (isset($_SESSION['pembayaranreportrekapbayar_rekening']))
    $rekening = $_SESSION['pembayaranreportrekapbayar_rekening'];

if (isset($_GET['rekening'])) {
    $rekening = $_GET['rekening'];
    $_SESSION['pembayaranreportrekapbayar_rekening'] = $_GET['rekening'];
}

$arr_cash = getCash();
$arr_rekening = getRekening();

$arr_total_cash = array();	

$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);	

$arr_nonjaminan = '0,';
foreach(getArrNonJaminan() as $row){
	$arr_nonjaminan .= $row . ',';
}
$arr_nonjaminan = substr($arr_nonjaminan,0,strlen($arr_nonjaminan)-1);
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <?php if(currentModul() == 'kasir'){ ?>
		<tr>
            <td>Penyetor</td>
            <td><?php $penyetor = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
				echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?></td>
       </tr>
		<?php }else{ ?>
		<tr>
            <td>Penyetor</td>
            <td><select name="penyetor" id="penyetor" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php $sql_penyetor = 'SELECT DISTINCT NAMA_PEGAWAI FROM m_pegawai
								INNER JOIN m_app_user 
								ON (m_pegawai.PEGAWAI_ID = m_app_user.PEGAWAI_ID)
								WHERE m_app_user.MODUL_ID = 2
								ORDER BY NAMA_PEGAWAI';
						$get_penyetor = mysql_query($sql_penyetor) or die(mysql_error());			
						while($dat_penyetor = mysql_fetch_array($get_penyetor)){ ?>
							<option value="<?php echo $dat_penyetor['NAMA_PEGAWAI']; ?>" <?php if($penyetor == $dat_penyetor['NAMA_PEGAWAI']) echo 'checked'; ?> ><?php echo $dat_penyetor['NAMA_PEGAWAI']; ?></option>
						<?php } ?>
                </select></td>
       </tr>
		<?php } ?>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Pembayaran</td>
            <td>
			<?php $arr_jenis_bayar = getArrJnsBayar();
				foreach($arr_jenis_bayar as $row){
					if(in_array($row['id'],getArrNonJaminan())){
						echo '<input type="radio" name="jns_bayar" value="' . $row['id'] . '" ' . (($jns_bayar == $row['id']) ? 'checked' : '') . ' />&nbsp;' . $row['nama'] . '&nbsp;&nbsp;';
					}
				}
			?>	
			</td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Umum</td>
            <td>
            	<?php
            		echo '<select name="cash" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_cash as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($cash == $row['kode']) ? 'selected' : '') . '>' . $row['deskripsi'] . '</option>';
					}
					echo '</select>';
            	?>
            </td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Rekening</td>
            <td>
            	<?php
            		echo '<select name="rekening" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_rekening as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($rekening == $row['kode']) ? 'selected' : '') .  '>' . $row['kode'] . '</option>';
					}
					echo '</select>';
            	?>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_REQUEST['kasir']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (
				SELECT t_bayar_l1.RAWAT_ID,
				t_bayar_l1.NOMR,
				psn.NAMA_PASIEN,
				t_bayar_l1.TGL_MASUK,
				t_bayar_l1.TGL_KELUAR,
				CASE WHEN t_bayar_l1.UNIT_ID IS NOT NULL THEN unt.NAMA_UNIT	
					WHEN t_bayar_l1.RUANG_ID IS NOT NULL THEN rng.NAMA_RUANG
				ELSE "" END AS NAMA_UNIT,	
				t_bayar_l1.TARIF_ID,
				mtrg.NAMA_TARIF_GROUP,
				mtr.NAMA_TARIF,
				t_bayar_l1.PASIEN,
				CAST(t_bayar_l1.TGL_BAYAR AS UNSIGNED) AS TGL_BAYAR,
				t_bayar_l1.SHIFT,
				t_bayar_l1.KODE_CASH,
				t_bayar_l1.PERC_POTONGAN,
				t_bayar_l1.KODE_REKENING,
				t_bayar_l1.KASIR AS USER_KASIR,
				SUM(t_bayar_l1.KUANTITI) AS KUANTITI,
				SUM(CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
					THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
						END 
					END) AS HARGA
					FROM (
							-- igd
							SELECT "TND" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "AMB" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND tfamb.JNS_ORDER = "IRJ"
							UNION ALL
							SELECT "HMD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end igd
							
							-- igd tdk klaim
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL) 
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRJ"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND hmd.JNS_ORDER = "IRJ"	
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end igd tdk klaim
							
							-- rawat jalan
							UNION ALL
							SELECT "TND" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND tfamb.JNS_ORDER = "IRJ"
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat jalan
							
							-- rawat jalan tdk klaim
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRJ"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat jalan tdk klaim
							
							-- rawat inap
							UNION ALL
							SELECT "TND" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							UNION ALL
							SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND tfamb.JNS_ORDER = "IRN"
							UNION ALL
							SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND hmd.JNS_ORDER = "IRN"
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas"
							AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat inap
							
							-- rawat inap tdk diklaim
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRN"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND hmd.JNS_ORDER = "IRN"
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat inap tdk klaim
					) t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_pasien psn
					ON (t_bayar_l1.NOMR = psn.NOMR)
					LEFT JOIN db_simrs.m_unit unt
					ON (t_bayar_l1.UNIT_ID = unt.UNIT_ID)
					LEFT JOIN db_simrs.m_ruang rng
					ON (t_bayar_l1.RUANG_ID = rng.RUANG_ID)
					' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l1.KASIR) = "' . strtoupper($penyetor) . '"') . '
					AND (mtr.MCU IS NULL OR mtr.MCU = "")
					GROUP BY t_bayar_l1.PASIEN,
					t_bayar_l1.RAWAT_ID,
					mtr.TARIF_ID,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT,
					t_bayar_l1.KODE_CASH,
					t_bayar_l1.PERC_POTONGAN,
					t_bayar_l1.KODE_REKENING,
					t_bayar_l1.KASIR
					-- aps
					UNION ALL
					SELECT CONCAT("x",t_bayar_l0.PENUNJANG_ID) RAWAT_ID,
					t_bayar_l0.NO_PASIEN_PENUNJANG AS NOMR,
					t_bayar_l0.NAMA_PASIEN,
					t_bayar_l0.TGL_MASUK,
					t_bayar_l0.TGL_KELUAR,
					t_bayar_l0.INSTANSI_PENGIRIM AS NAMA_UNIT,
					t_bayar_l0.TARIF_ID,
					mtrg.NAMA_TARIF_GROUP,
					mtr.NAMA_TARIF,
					t_bayar_l0.PASIEN,
					CAST(t_bayar_l0.TGL_BAYAR AS UNSIGNED) AS TGL_BAYAR,
					t_bayar_l0.SHIFT,
					t_bayar_l0.KODE_CASH,
					t_bayar_l0.PERC_POTONGAN,
					t_bayar_l0.KODE_REKENING,
					t_bayar_l0.KASIR,
					SUM(t_bayar_l0.KUANTITI) AS KUANTITI,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l0.KELAS_RAWAT = ""
						THEN t_bayar_l0.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "3" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_3 
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "2" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_2
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "1" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_1
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "VIP" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "VVIP" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "HCU" THEN t_bayar_l0.KUANTITI * mtr.TARIF_HCU
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "ICU" THEN t_bayar_l0.KUANTITI * mtr.TARIF_ICU
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "NICU" THEN t_bayar_l0.KUANTITI * mtr.TARIF_NICU
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "PICU" THEN t_bayar_l0.KUANTITI * mtr.TARIF_PICU
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "ICCU" THEN t_bayar_l0.KUANTITI * mtr.TARIF_ICCU
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "PERINA" THEN t_bayar_l0.KUANTITI * mtr.TARIF_PERINA
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_bayar_l0.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l0.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
						END 
					END) AS HARGA
					FROM (
							SELECT "APS" AS PASIEN,pnj.PENUNJANG_ID,
							pnj.NO_PASIEN_PENUNJANG,
							pnj.NAMA_PASIEN,
							pnj.INSTANSI_PENGIRIM,
							pnj.JENIS_BAYAR_ID,
							DATE_FORMAT(pnj.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(pnj.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_ipenunjang pnj
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND pnj.JNS_ORDER = "APS"
							AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					) t_bayar_l0
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l0.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l0.KASIR) = "' . strtoupper($penyetor) . '"') . '
					GROUP BY t_bayar_l0.PENUNJANG_ID,
					mtr.TARIF_ID,
					t_bayar_l0.TGL_BAYAR,
					t_bayar_l0.SHIFT,
					t_bayar_l0.KODE_CASH,
					t_bayar_l0.PERC_POTONGAN,
					t_bayar_l0.KODE_REKENING
					-- end aps
					
					-- farmasi igd
					UNION ALL
					SELECT * FROM (
						SELECT igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						unt2.NAMA_UNIT,
						NULL AS TARIF_ID,
						CONVERT("-" USING latin1) AS NAMA_TARIF_GROUP,
						CONVERT("Resep" USING latin1) AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_simrs.t_irja igd
						INNER JOIN m_pasien psn2
						ON (igd.NOMR = psn2.NOMR)
						INNER JOIN m_unit unt2
						ON (igd.UNIT_ID = unt2.UNIT_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi igd
							
						-- farmasi rawat jalan
						UNION ALL
						SELECT igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						unt2.NAMA_UNIT,
						NULL AS TARIF_ID,
						CONVERT("-" USING latin1) AS NAMA_TARIF_GROUP,
						CONVERT("Resep" USING latin1) AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_simrs.t_irja igd
						INNER JOIN m_pasien psn2
						ON (igd.NOMR = psn2.NOMR)
						INNER JOIN m_unit unt2
						ON (igd.UNIT_ID = unt2.UNIT_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID NOT IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi rawat jalan
						
						-- farmasi rawat inap
						UNION ALL
						SELECT irn.IRNA_ID AS RAWAT_ID,
						irn.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						rng2.NAMA_RUANG,
						NULL AS TARIF_ID,
						CONVERT("-" USING latin1) AS NAMA_TARIF_GROUP,
						CONVERT("Resep" USING latin1) AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_simrs.t_irna irn
						INNER JOIN m_pasien psn2
						ON (irn.NOMR = psn2.NOMR)
						INNER JOIN m_ruang rng2
						ON (irn.RUANG_ID = rng2.RUANG_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "2"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY irn.IRNA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi rawat inap
						
						-- farmasi aps
						UNION ALL
						SELECT CONCAT("y",fms.FARMASI_PENGELUARAN_APOTIK_ID) AS RAWAT_ID,
						fms.NIK AS NOMR,
						fms.NAMA_PELANGGAN AS NAMA_PASIEN,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.INSTANSI_PENGIRIM AS NAMA_UNIT,
						NULL AS TARIF_ID,
						CONVERT("-" USING latin1) AS NAMA_TARIF_GROUP,
						CONVERT("Resep" USING latin1) AS NAMA_TARIF,
						"APS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE fms.NO_PENGELUARAN IS NOT NULL
						' . (($jns_bayar == '1') ? 'AND fms.JENIS_PENGELUARAN = "3"' : 'AND fms.JENIS_PENGELUARAN = "123"') . '
						AND fms.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi aps
						) t_bayar_l0
						' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l0.USER_KASIR) = "' . strtoupper($penyetor) . '"') . '
					
						-- penerimaan lain-lain
						UNION ALL
						SELECT CONCAT("z",pnl.PENERIMAAN_LAINLAIN_ID) AS RAWAT_ID,
						pnl.TELEPON AS NOMR,
						pnl.PIC AS NAMA_PASIEN,
						DATE_FORMAT(pnl.TANGGAL,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(pnl.TANGGAL,"%d-%m-%Y") AS TGL_KELUAR,
						pnl.NAMA_INSTANSI AS NAMA_UNIT,
						pnltf.TARIF_ID,
						mtrg.NAMA_TARIF_GROUP,
						mtr.NAMA_TARIF,
						"LAIN" AS PASIEN,
						"" AS TGL_BAYAR,
						"" AS SHIFT,
						pnl.KODE_CASH,
						pnl.PERC_POTONGAN,
						pnl.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(pnl.REGISTER,"|",-1)) AS USER_KASIR,
						SUM(pnltf.KUANTITI) AS KUANTITI,
						SUM(pnltf.KUANTITI * mtr.TARIF_NON_KELAS) AS HARGA
						FROM db_simkeu.r_penerimaan_lainlain pnl
						INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnltf
						ON (pnl.PENERIMAAN_LAINLAIN_ID = pnltf.PENERIMAAN_LAINLAIN_ID)
						INNER JOIN m_tarif mtr 
						ON (pnltf.TARIF_ID = mtr.TARIF_ID)
						INNER JOIN m_tarif_group mtrg
						ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)	
						WHERE DATE(pnl.TANGGAL) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnl.TANGGAL) <= ' . $tgl_filter_2 . '
						' . (($jns_bayar == '1') ? '' : 'AND pnl.PENERIMAAN_LAINLAIN_ID = "xyz"') . '
						' . (($penyetor == '') ? '' : ' AND UPPER(SUBSTRING_INDEX(pnl.REGISTER,"|",-1)) = "' . strtoupper($penyetor) . '"') . '
						AND pnl.NO_PEMBAYARAN IS NOT NULL
						' . (($cash != '') ? ' AND pnl.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnl.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY pnl.PENERIMAAN_LAINLAIN_ID,
						pnl.KODE_CASH,
						pnl.PERC_POTONGAN,
						pnl.KODE_REKENING
					) t_bayar_l2
					ORDER BY RAWAT_ID,
					KODE_CASH,
					PERC_POTONGAN,
					KODE_REKENING';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
   
   <tr>
     <th rowspan="2">No</th>
     <th rowspan="2">NOMR</th>
     <th rowspan="2">Nama Pasien </th>
     <th rowspan="2">Tgl Masuk </th>
     <th rowspan="2">Tgl Keluar </th>
     <th rowspan="2">Unit/ Ruang</th>
     <th rowspan="2">Group Tarif</th>
     <th rowspan="2">Tarif</th>
     <th rowspan="2">Bayar</th>
     <th colspan="5">Jumlah</th>
     <th colspan="6">Rupiah</th>
	 <th colspan="4">Pembayaran Umum</th>
   </tr>
  <tr>
    <th>Shift 1 </th>
    <th>Shift 2 </th>
    <th>Shift 3 AM</th>
	<th>Shift 3 PM</th>
	<th>-</th>
    <th>Shift 1 </th>
    <th>Shift 2</th>
    <th>Shift 3 AM</th>
	<th>Shift 3 PM</th>
	<th>-</th>
	<th>Total</th>
	<th>Jenis</th>
	<th>Potongan %</th>
	<th>Potongan Rp</th>
	<th>Rekening</th>
  </tr>
<?php $no = 1; 
$jumlah_1 = 0;
$jumlah_2 = 0;
$jumlah_3 = 0;
$jumlah_4 = 0;
$jumlah_5 = 0;

$rupiah_1 = 0;
$rupiah_2 = 0;
$rupiah_3 = 0;
$rupiah_4 = 0;
$rupiah_5 = 0;
$rupiah_6 = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo formatNomr($dat_kunjungan['NOMR']); ?></td>
    <td><?php echo $dat_kunjungan['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_kunjungan['TGL_MASUK']; ?></td>
	<td><?php echo $dat_kunjungan['TGL_KELUAR']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_TARIF_GROUP']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_TARIF']; ?></td>
	<td><?php echo $dat_kunjungan['PASIEN']; ?></td>
	<?php
	$sub_jumlah_1 = 0; 
	$sub_jumlah_2 = 0;
	$sub_jumlah_3 = 0;
	$sub_jumlah_4 = 0;
	$sub_jumlah_5 = 0;
	
	$sub_rupiah_1 = 0; 
	$sub_rupiah_2 = 0;
	$sub_rupiah_3 = 0;
	$sub_rupiah_4 = 0;
	$sub_rupiah_5 = 0;
	$sub_rupiah_6 = 0;
	
	if($dat_kunjungan['SHIFT'] != '0' and $dat_kunjungan['SHIFT'] != ''){
		if($dat_kunjungan['SHIFT'] == '1'){
			$sub_jumlah_1 = $dat_kunjungan['KUANTITI'];
			$sub_rupiah_1 = $dat_kunjungan['HARGA'];
			$jumlah_1 += $dat_kunjungan['KUANTITI'];
			$rupiah_1 += $dat_kunjungan['HARGA'];
		}

		if($dat_kunjungan['SHIFT'] == '2'){
			$sub_jumlah_2 = $dat_kunjungan['KUANTITI'];
			$sub_rupiah_2 = $dat_kunjungan['HARGA'];
			$jumlah_2 += $dat_kunjungan['KUANTITI'];
			$rupiah_2 += $dat_kunjungan['HARGA'];
		}	
		
		if($dat_kunjungan['SHIFT'] == '3'){
			if($dat_kunjungan['TGL_BAYAR'] <= 12){
				$sub_jumlah_3 = $dat_kunjungan['KUANTITI'];
				$sub_rupiah_3 = $dat_kunjungan['HARGA'];
				$jumlah_3 += $dat_kunjungan['KUANTITI'];
				$rupiah_3 += $dat_kunjungan['HARGA'];
			}else{
				$sub_jumlah_4 = $dat_kunjungan['KUANTITI'];
				$sub_rupiah_4 = $dat_kunjungan['HARGA'];
				$jumlah_4 += $dat_kunjungan['KUANTITI'];
				$rupiah_4 += $dat_kunjungan['HARGA'];
			}	
		}
	}else{
		$sub_jumlah_5 = $dat_kunjungan['KUANTITI'];
		$sub_rupiah_5 = $dat_kunjungan['HARGA'];
		$jumlah_5 += $dat_kunjungan['KUANTITI'];
		$rupiah_5 += $dat_kunjungan['HARGA'];
	}
	
	$sub_rupiah_6 = $dat_kunjungan['HARGA'];
	$rupiah_6 += $dat_kunjungan['HARGA'];
	?>
    <td align="right"><?php echo currFormat($sub_jumlah_1); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_2); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_3); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_4); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_5); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_1); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_2); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_3); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_4); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_5); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_6); ?></td>
	<td><?php echo $dat_kunjungan['KODE_CASH']; ?></td>
	<td align="right"><?php echo $dat_kunjungan['PERC_POTONGAN']; ?></td>
	<td align="right"><?php 
		$sub_rupiah_potongan = $sub_rupiah_1 + $sub_rupiah_2 + $sub_rupiah_3 + $sub_rupiah_4 + $sub_rupiah_5;
		$potongan = ($dat_kunjungan['PERC_POTONGAN'] / 100) * $sub_rupiah_potongan;
		echo currFormat($potongan);
	?></td>
	<td><?php echo $dat_kunjungan['KODE_REKENING']; ?></td>
  </tr>
 <?php 
	$arr_total_cash[$dat_kunjungan['KODE_CASH']] = 0;
 $no++; 
 } ?>
<tr>
    <td colspan="9" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($jumlah_1); ?></td>
	<td align="right"><?php echo currFormat($jumlah_2); ?></td>
	<td align="right"><?php echo currFormat($jumlah_3); ?></td>
	<td align="right"><?php echo currFormat($jumlah_4); ?></td>
	<td align="right"><?php echo currFormat($jumlah_5); ?></td>
	<td align="right"><?php echo currFormat($rupiah_1); ?></td>
	<td align="right"><?php echo currFormat($rupiah_2); ?></td>
	<td align="right"><?php echo currFormat($rupiah_3); ?></td>
	<td align="right"><?php echo currFormat($rupiah_4); ?></td>
	<td align="right"><?php echo currFormat($rupiah_5); ?></td>
	<td align="right"><?php echo currFormat($rupiah_6); ?></td>
	<td colspan="4">&nbsp;</td>
  </tr>
<?php
	mysql_data_seek($get_kunjungan,0);
	while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){
		$arr_total_cash[$dat_kunjungan['KODE_CASH']] += $dat_kunjungan['HARGA'];
	}
	
	foreach($arr_total_cash as $key => $value){ ?>
		<tr>
			<td colspan="20">&nbsp;</td>
			<td><?php echo $key; ?></td>
			<td align="right" colspan="3"><?php echo currFormat($value); ?></td>
		</tr>		
<?php } ?> 
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="penyetor" value="<?php echo $penyetor; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
	<input type="hidden" name="cash" value="<?php echo $cash; ?>" />
	<input type="hidden" name="rekening" value="<?php echo $rekening; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_GET['kasir']; ?>" />
    <input type="hidden" name="xlsfile" value="pembayaran/xls_report_rekap_gabungan.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_gabungan.xls" />            
</form>