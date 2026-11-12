<?php
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
	
	$sql_diagnosa = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				t_ipenunjang_tarif.HASIL_DIAGNOSA
				FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idp . '"';
        $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
		$dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
		$hasil_diagnosa = $dat_diagnosa['HASIL_DIAGNOSA']; 
        ?>
            <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
                <table width="100%" border="0" class="tableform">
                        <tr>
                            <td width="100">Hasil Tindakan</td>
                            <td>:&nbsp;&nbsp;<?php echo $hasil_diagnosa; ?></td>
                        </tr>     		
                </table>
                <table width="100%" >
                    <tr>
                        <td colspan="6" align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : window.close();" /></td>
                    </tr>
                </table>
            </div>
<?php } ?>