<?php
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
	
	$sql_diagnosa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_pegawai.NAMA_PEGAWAI,
				t_ipenunjang_tarif.HASIL_DIAGNOSA
				FROM t_ipenunjang_tarif
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idp . '"';
        $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
		$dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
        ?>
            <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
                <table width="100%" border="0" class="tableData" id="tfhover" >
                <tr>
					<td colspan="2">Hasil Diagnosa :</td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $dat_diagnosa['HASIL_DIAGNOSA']; ?></td>
				</tr>
				<tr>
                    <td width="100px">Dokter</td>
                    <td><?php echo $dat_diagnosa['NAMA_PEGAWAI']; ?></td>
                </tr>		
                </table>
                <table width="100%" >
                    <tr>
                        <td colspan="2" align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : window.close();" /></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
<?php } ?>