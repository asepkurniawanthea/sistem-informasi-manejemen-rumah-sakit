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

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$jns_batal = '';
if (isset($_SESSION['pembayaranreportrekapbayar_jns_batal']))
    $jns_batal = $_SESSION['pembayaranreportrekapbayar_jns_batal'];

if (isset($_GET['jns_batal'])) {
    $jns_batal = $_GET['jns_batal'];
    $_SESSION['pembayaranreportrekapbayar_jns_batal'] = $_GET['jns_batal'];
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

$str_jenis_batal = '0,';
foreach(getJenisBatalBayar() as $key=>$val){
	$str_jenis_batal .= '"' . $key . '",' ;
}
$str_jenis_batal = substr($str_jenis_batal,0,strlen($str_jenis_batal)-1);
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
			<td>Batal Bayar</td>
            <td>
			<select name="jns_batal" class="text_dt" style="width:140px;">
			<option value=""> - </option>
			<?php $arr_batal_desc = array(
					'1' => 'Batal',
					'2' => 'Dikembalikan',
					'9' => 'Lain-lain'
				); 
				$arr_jenis_batal = getJenisBatalBayar();
				foreach($arr_jenis_batal as $key=>$val){
					echo '<option value="' . $key . '" ' . (($key == $jns_batal) ? 'selected' : '') .  '>' . $arr_batal_desc[$key] . '</option>';
				}
			?>	
			</select>
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
				STR_TO_DATE(SUBSTR(t_bayar_l1.TGL_KASIR,0,6),"%y%m%d") AS TGL_KASIR,
				t_bayar_l1.STATUS_BATAL,
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
							SUBSTRING_INDEX(trf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING,
							trf.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND trf.ST_BATAL IN (' . $str_jenis_batal . ')
							AND trf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND trf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "PNJ" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING,
							pnjtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND pnjtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND pnjtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND pnjtf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "AMB" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING,
							tfamb.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND tfamb.JNS_ORDER = "IRJ"
							AND tfamb.ST_BATAL IN (' . $str_jenis_batal . ')
							AND tfamb.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND tfamb.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "HMD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING,
							hmdtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND hmdtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND hmdtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND hmdtf.NO_PEMBAYARAN IS NULL
								
							UNION ALL
							SELECT "OPR" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING,
							optf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND optf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND optf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND optf.NO_PEMBAYARAN IS NULL
							-- end igd
							
							-- rawat jalan
							UNION ALL
							SELECT "TND" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING,
							trf.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND trf.ST_BATAL IN (' . $str_jenis_batal . ')
							AND trf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND trf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING,
							pnjtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND pnjtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND pnjtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND pnjtf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING,
							tfamb.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND tfamb.JNS_ORDER = "IRJ"
							AND tfamb.ST_BATAL IN (' . $str_jenis_batal . ')
							AND tfamb.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND tfamb.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING,
							hmdtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND hmdtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND hmdtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND hmdtf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING,
							optf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND optf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND optf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND optf.NO_PEMBAYARAN IS NULL
							-- end rawat jalan
							
							-- rawat inap
							UNION ALL
							SELECT "TND" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING,
							trf.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND trf.ST_BATAL IN (' . $str_jenis_batal . ')
							AND trf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND trf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING,
							pnjtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							AND pnjtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND pnjtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND pnjtf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING,
							tfamb.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND tfamb.JNS_ORDER = "IRN"
							AND tfamb.ST_BATAL IN (' . $str_jenis_batal . ')
							AND tfamb.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND tfamb.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING,
							hmdtf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND hmd.JNS_ORDER = "IRN"
							AND irn.ST_BATAL IS NULL
							AND hmdtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND hmdtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND hmdtf.NO_PEMBAYARAN IS NULL
							
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING,
							optf.ST_BATAL_BAYAR AS STATUS_BATAL
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND optf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND optf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND optf.NO_PEMBAYARAN IS NULL
							-- end rawat inap
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
					AND STR_TO_DATE(SUBSTR(t_bayar_l1.TGL_KASIR,0,6),"%y%m%d") >= ' . $tgl_filter_1 . '
					AND STR_TO_DATE(SUBSTR(t_bayar_l1.TGL_KASIR,0,6),"%y%m%d") <= ' . $tgl_filter_2 . '
					AND (mtr.MCU IS NULL OR mtr.MCU = "")
					GROUP BY t_bayar_l1.PASIEN,
					t_bayar_l1.RAWAT_ID,
					mtr.TARIF_ID,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT,
					t_bayar_l1.KODE_CASH,
					t_bayar_l1.PERC_POTONGAN,
					t_bayar_l1.KODE_REKENING,
					t_bayar_l1.KASIR,
					t_bayar_l1.STATUS_BATAL
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
					t_bayar_l0.USER_KASIR,
					STR_TO_DATE(SUBSTR(t_bayar_l0.TGL_KASIR,0,6),"%y%m%d") AS TGL_KASIR,
					t_bayar_l0.STATUS_BATAL,
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
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS USER_KASIR,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",1) AS TGL_KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING,
							pnjtf.ST_BATAL AS STATUS_BATAL
							FROM db_simrs.t_ipenunjang pnj
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							AND pnj.JNS_ORDER = "APS"
							AND pnjtf.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
							AND pnjtf.JENIS_BAYAR_ID IN (' . $arr_nonjaminan . ') 
							AND pnjtf.NO_PEMBAYARAN IS NULL
					) t_bayar_l0
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l0.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l0.USER_KASIR) = "' . strtoupper($penyetor) . '"') . '
					AND STR_TO_DATE(SUBSTR(t_bayar_l0.TGL_KASIR,0,6),"%y%m%d") >= ' . $tgl_filter_1 . '
					AND STR_TO_DATE(SUBSTR(t_bayar_l0.TGL_KASIR,0,6),"%y%m%d") <= ' . $tgl_filter_2 . '
					GROUP BY t_bayar_l0.PENUNJANG_ID,
					mtr.TARIF_ID,
					t_bayar_l0.TGL_BAYAR,
					t_bayar_l0.SHIFT,
					t_bayar_l0.KODE_CASH,
					t_bayar_l0.PERC_POTONGAN,
					t_bayar_l0.KODE_REKENING,
					t_bayar_l0.STATUS_BATAL
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
						"-" AS TARIF_ID,
						"-" AS NAMA_TARIF_GROUP,
						"Resep" AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",1)) AS TGL_KASIR,
						fms.ST_BATAL_BAYAR AS STATUS_BATAL,
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
						AND fms.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
						AND fms.JAMINAN_ID IN (' . $arr_nonjaminan . ')
						AND fms.NO_PEMBAYARAN IS NULL						
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						fms.ST_BATAL_BAYAR
						-- end farmasi igd
							
						-- farmasi rawat jalan
						UNION ALL
						SELECT igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						unt2.NAMA_UNIT,
						"-" AS TARIF_ID,
						"-" AS NAMA_TARIF_GROUP,
						"Resep" AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",1)) AS TGL_KASIR,
						fms.ST_BATAL_BAYAR AS STATUS_BATAL,
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
						AND fms.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
						AND fms.JAMINAN_ID IN (' . $arr_nonjaminan . ') 
						AND fms.NO_PEMBAYARAN IS NULL
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						fms.ST_BATAL_BAYAR
						-- end farmasi rawat jalan
						
						-- farmasi rawat inap
						UNION ALL
						SELECT irn.IRNA_ID AS RAWAT_ID,
						irn.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						rng2.NAMA_RUANG,
						"-" AS TARIF_ID,
						"-" AS NAMA_TARIF_GROUP,
						"Resep" AS NAMA_TARIF,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",1)) AS TGL_KASIR,
						fms.ST_BATAL_BAYAR AS STATUS_BATAL,
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
						AND fms.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
						AND fms.JAMINAN_ID IN (' . $arr_nonjaminan . ') 
						AND fms.NO_PEMBAYARAN IS NULL
						GROUP BY irn.IRNA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						fms.ST_BATAL_BAYAR
						-- end farmasi rawat inap
						
						-- farmasi aps
						UNION ALL
						SELECT CONCAT("y",fms.FARMASI_PENGELUARAN_APOTIK_ID) AS RAWAT_ID,
						fms.NIK AS NOMR,
						fms.NAMA_PELANGGAN AS NAMA_PASIEN,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.INSTANSI_PENGIRIM AS NAMA_UNIT,
						"-" AS TARIF_ID,
						"-" AS NAMA_TARIF_GROUP,
						"Resep" AS NAMA_TARIF,
						"APS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",1)) AS TGL_KASIR,
						fms.ST_BATAL_BAYAR AS STATUS_BATAL,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "3"
						AND fms.ST_BATAL IS NULL
						AND fms.ST_BATAL_BAYAR IN (' . $str_jenis_batal . ')
						AND fms.JAMINAN_ID IN (' . $arr_nonjaminan . ') 
						AND fms.NO_PEMBAYARAN IS NULL
						GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING,
						fms.ST_BATAL_BAYAR
						-- end farmasi aps
						) t_bayar_l0
						' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l0.USER_KASIR) = "' . strtoupper($penyetor) . '"') . '
						AND STR_TO_DATE(SUBSTR(t_bayar_l0.TGL_KASIR,0,6),"%y%m%d") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(SUBSTR(t_bayar_l0.TGL_KASIR,0,6),"%y%m%d") <= ' . $tgl_filter_2 . '
					
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
						UPPER(SUBSTRING_INDEX(pnl.REGISTER,"|",1)) AS TGL_KASIR,
						pnl.ST_BATAL AS STATUS_BATAL,
						SUM(pnltf.KUANTITI) AS KUANTITI,
						SUM(pnltf.KUANTITI * mtr.TARIF_NON_KELAS) AS HARGA
						FROM db_simkeu.r_penerimaan_lainlain pnl
						INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnltf
						ON (pnl.PENERIMAAN_LAINLAIN_ID = pnltf.PENERIMAAN_LAINLAIN_ID)
						INNER JOIN m_tarif mtr 
						ON (pnltf.TARIF_ID = mtr.TARIF_ID)
						INNER JOIN m_tarif_group mtrg
						ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)	
						WHERE pnl.NO_PEMBAYARAN IS NOT NULL 
						AND pnl.ST_BATAL IN (' . $str_jenis_batal . ')
						AND pnl.NO_PEMBAYARAN IS NULL
						' . (($penyetor == '') ? '' : ' AND UPPER(SUBSTRING_INDEX(pnl.REGISTER,"|",-1)) = "' . strtoupper($penyetor) . '"') . '
						AND STR_TO_DATE(SUBSTR(SUBSTRING_INDEX(pnl.REGISTER,"|",1),0,6),"%y%m%d") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(SUBSTR(SUBSTRING_INDEX(pnl.REGISTER,"|",1),0,6),"%y%m%d") <= ' . $tgl_filter_2 . '
						GROUP BY pnl.PENERIMAAN_LAINLAIN_ID,
						pnl.KODE_CASH,
						pnl.PERC_POTONGAN,
						pnl.KODE_REKENING,
						pnl.ST_BATAL
					) t_bayar_l2
					ORDER BY RAWAT_ID,
					KODE_CASH,
					PERC_POTONGAN,
					KODE_REKENING,
					STATUS_BATAL';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
   
   <tr>
     <th>No</th>
     <th>NOMR</th>
     <th>Nama Pasien </th>
     <th>Tgl Masuk </th>
     <th>Tgl Keluar </th>
     <th>Unit/ Ruang</th>
     <th>Group Tarif</th>
     <th>Tarif</th>
     <th>Bayar</th>
     <th>Jumlah</th>
     <th>Rupiah</th>
	 <th>Batal Bayar</th>
   </tr>
<?php $no = 1; 
$jumlah = 0;
$rupiah = 0;
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
	<td align="right"><?php echo currFormat($dat_kunjungan['KUANTITI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['HARGA']); ?></td>
	<td><?php echo $arr_batal_desc[$dat_kunjungan['STATUS_BATAL']]; ?></td>
	<?php $jumlah += $dat_kunjungan['KUANTITI']; 
		$rupiah += $dat_kunjungan['HARGA']; ?>
  </tr>
 <?php 
 $no++; 
 } ?>
<tr>
    <td colspan="8" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($jumlah); ?></td>
	<td align="right"><?php echo currFormat($rupiah); ?></td>
	<td colspan="4">&nbsp;</td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="penyetor" value="<?php echo $penyetor; ?>" />
	<input type="hidden" name="jns_batal" value="<?php echo $jns_batal; ?>" />
    <input type="hidden" name="xlsfile" value="pembayaran/xls_report_batal_bayar.php" />
    <input type="hidden" name="xlsname" value="rpt_batal_bayar.xls" />            
</form>