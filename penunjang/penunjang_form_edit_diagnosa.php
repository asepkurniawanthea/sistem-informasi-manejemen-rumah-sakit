<?php
if (isset($_GET['idx']) and isset($_GET['ord']) and isset($_GET['idp'])) {
    $idx = $_GET['idx'];
    $ord = $_GET['ord'];
	$idp = $_GET['idp'];
    $selesai = '';

    if ($ord == 'irj') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ" AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang_tarif.PENUNJANG_ID = "' . $_GET['idx'] . '"';
    } else if ($ord == 'irn') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN" AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang_tarif.PENUNJANG_ID = "' . $_GET['idx'] . '"';
    } else if ($ord == 'aps') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NOMR AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang.TANGGAL_BAYAR,
				t_ipenunjang.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS" AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL
				AND t_ipenunjang_tarif.PENUNJANG_ID = "' . $_GET['idx'] . '"';
    }
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    $dat_pasien = mysql_fetch_assoc($get_pasien);
    $nomr = $dat_pasien['NOMR'];
    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tgl_lahir = $dat_pasien['TGL_LAHIR'];
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $alamat = $dat_pasien['ALAMAT'];
    $nik = $dat_pasien['NIK'];
    $jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

    $penunjang_id = $dat_pasien['PENUNJANG_ID'];
    $pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
    $nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' . $dat_pasien['NAMA_PEGAWAI'] . ')';
    $tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
    $rawat_id = $dat_pasien['RAWAT_ID'];

    if (isset($_POST['penunjang_id']))
        include('penunjang/penunjang_save_diagnosa.php');
    ?>
    <div style=" height:auto; padding:15px; ">

        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <?php include('pasien/pasien_view_short.php'); ?>
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Order</div><br><br>
            <?php
            if ($ord == 'irj') {
                $qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
					CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
					ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
					FROM t_irja_diagnosa
					LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
					WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
            } else if ($ord == 'irn') {
                $qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,
					CASE WHEN TRIM(t_irna_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa.ICD_CODE
					ELSE CONCAT(t_irna_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
					FROM t_irna_diagnosa
					LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
					WHERE t_irna_diagnosa.IRNA_ID = "' . $rawat_id . '"
					ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
            } else if ($ord == 'aps') {
                $qry_diagnosa = 'SELECT t_ipenunjang.DIAGNOSA, "" AS ICD
					FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $idx . '"';
            }

            $get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
            $i = 0;
            ?>
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
            <div style=" width:20px; float:left; ">:</div>

            <?php
            if (mysql_num_rows($get_diagnosa) > 0) {
                while ($dat_diagnosa = mysql_fetch_array($get_diagnosa)) {
                    if ($i == 0) {
                        ?>
                        <div style=" width:850px; float:left; text-indent:5px; " align="left"><?php
                echo $i + 1;
                echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD'];
                        ?></div>
                        <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
                        <div style=" width:20px; float:right; ">&nbsp;</div>
                        <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
                        <?php
                    } else {
                        ?>
                        <div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
                        <div style=" width:20px; float:left; ">&nbsp;</div>
                        <div style=" width:850px; float:left; text-indent:5px; " align="left"><?php
                echo $i + 1;
                echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD'];
                        ?></div>
                        <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
                        <div style=" width:20px; float:right; ">&nbsp;</div>
                        <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
                        <?php
                    }
                    $i++;
                }
            } else {
                ?>
                <div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
                <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
                <div style=" width:20px; float:right; ">&nbsp;</div>
                <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
            <?php } ?>
        </div>

        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <?php
            $sql_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,t_ipenunjang_tarif.TANGGAL_DIAGNOSA,
							t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,
							t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.TANGGAL_PERIKSA,
							t_ipenunjang_tarif.HASIL_DIAGNOSA,
							t_ipenunjang_tarif.CATATAN_SPESIMEN,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idp . '" 
							AND m_tarif_group.PENUNJANG = "1" AND m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"';
            $get_tarif = mysql_query($sql_tarif) or die(mysql_error());
            $dat_tarif = mysql_fetch_assoc($get_tarif);
            if ($dat_tarif['ST_DIAGNOSA'] == '1')
                $selesai = '1';
            $pegawai_id = $dat_tarif['PEGAWAI_DIAGNOSA_ID'];
            ?>
            <table border="0" width="100%" class="tableform" >
                <tr>
                    <td width="215px">Jenis Pemeriksaan</td>
                    <td width="1">:</td>
                    <td  colspan="2"><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?php echo $dat_tarif['TANGGAL_PERIKSA']; ?></td>
                    <td width="150" align="right">&nbsp;</a></td>
                </tr>	
            </table>
        </div>
        <form name="form1" method="post">
            <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
                <table width="100%" border="0" class="tableform">
                <tr>
			       <td width="215px">Hasil Tindakan</td>
				   <td width="1">:</td>
                    <td colspan="6">
					<textarea name="hasil_tindakan" id="hasil_tindakan" class="text_dt2" ><?php echo $dat_tarif['HASIL_DIAGNOSA']; ?></textarea></td>
                </tr>
				<tr>
			        <td>Pelaksana</td>
					<td width="1">:</td>
                    <td colspan="6"><select name="pemeriksa" id="pemeriksa" style="width:250px;" class="text_dt" >
							<option value="" > - </option>
							<?php echo getPelaksanaPenunjang($dat_tarif['PEGAWAI_PERIKSA_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
						</select></td>
                </tr>	
                </table>
                <table width="100%" >
                    <tr>
                        <td colspan="6" align="right">
							<input type="checkbox" name="selesai" <?php if($dat_tarif['ST_DIAGNOSA'] == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai&nbsp;&nbsp;
                            <input type="submit" name="simpan" value="simpan" class="myButton1" />
							<input type="button" value="tutup" class="myButton1" onclick="javascript : selesaikan('index.php?link=<?php echo md5('penunjangformeditperiksa'); ?>&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $_GET['ord']; ?>');return false;" /></td>
                    </tr>
                </table>
				<input type="hidden" name="ord" value="<?php echo $_GET['ord']; ?>" />
				<input type="hidden" name="penunjang_id" value="<?php echo $idx; ?>" />
				<input type="hidden" name="penunjang_tarif_id" value="<?php echo $idp; ?>" />
            </div>
        </form>
    </div>
<?php } ?>
<script language="JavaScript" >
    function selesaikan(link){
        window.location = link;
    }
</script>