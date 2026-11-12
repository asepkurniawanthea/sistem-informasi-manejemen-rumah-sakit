<?php
if (isset($_GET['idp']) and isset($_GET['rpt'])) {
    $idp = $_GET['idp'];
	$rpt = $_GET['rpt'];
	
	$sql_diagnosa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,t_ipenunjang_tarif.CATATAN_SPESIMEN,
				t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,t_ipenunjang_tarif_pemeriksaan.SATUAN,t_ipenunjang_tarif_pemeriksaan.METHODE
				FROM t_ipenunjang_tarif
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idp . '"
				ORDER BY m_tarif_pemeriksaan.REPORT_ORDER';
        $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
        ?>
            <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
                <table width="100%" border="0" class="tableData" id="tfhover" >
                    <?php
                    if ($rpt == '1') {
                        ?>
                        <tr>
                            <th width="30">No</th>
                            <th width="200">Jenis Pemeriksaan</th>
                            <th>Hasil</th>
                            <th width="80">Satuan</th>
                            <th width="150">Nilai Rujukan</th>
							<th width="80">Metode</th>
                        </tr>
                    <?php } else if ($rpt == '2') { ?>
                        <tr>
                            <th width="30">No</th>
                            <th width="200">Jenis Pemeriksaan</th>
                            <th colspan="5">Hasil</th>
                            <th width="150">Nilai Rujukan</th>
							<th width="80">Metode</th>
                        </tr>
                    <?php } else if ($rpt == '3') { ?>
                        <tr>
                            <th width="30">No</th>
                            <th width="200">Jenis Pemeriksaan</th>
                            <th>Hasil</th>
							<th width="80">Metode</th>
                        </tr>	
                        <?php
                    } $z = 1;
                    $nama_pemeriksaan_group = '';
                    $ret_selesai = true;
					$catatan_spesimen = '';
					while ($dat_diagnosa = mysql_fetch_array($get_diagnosa)) {
                        $catatan_spesimen = $dat_diagnosa['CATATAN_SPESIMEN'];
						if ($rpt == '1') {
                            include('klinik/klinik_view_diagnosa_lab_1.php');
                        } else if ($rpt == '2') {
                            include('klinik/klinik_view_diagnosa_lab_2.php');
                        } else if ($rpt == '3') {
                            include('klinik/klinik_view_diagnosa_lab_3.php');
                        }
                        $z++;
                    }
                    ?>
				<tr>
					<td>&nbsp;</td>
                    <td>Catatan Spesimen</td>
                    <td colspan="7"><?php echo $catatan_spesimen; ?></td>
                </tr>		
                </table>
                <table width="100%" >
                    <tr>
                        <td colspan="6" align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : window.close();" /></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
<?php 
mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_LAPOR = NOW()
				WHERE PENUNJANG_TARIF_ID = "' . $idp . '"
				AND TANGGAL_LAPOR IS NULL') or die(mysql_error());
} ?>