<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Kode</th>
        <th>Nama Tindakan</th>
		<th>Laboratorium</th>
		<th>Radiologi</th>
		<th>Rehabilitasi Medik</th>
		<th>Kamar Operasi</th>
        <th>ICD Code</th>
		<th width="200">Register</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_tindakan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
	$x = 1;	
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['TARIF_ID'];
        ?>
        <tr>
            <td width="30" align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center" width="80"><?php echo $data['KODE_TARIF']; ?></td>
            <td><?php echo $data['NAMA_TARIF']; ?></td>
			<td width="80" align="center"><?php if($data['LABORATORIUM'] == '1' or $data['LABORATORIUM_CITO'] == '1') echo '&radic;'; ?></td>
			<td width="80" align="center"><?php if($data['RADIOLOGI'] == '1' or $data['RADIOLOGI_CITO'] == '1') echo '&radic;'; ?></td>
            <td width="80" align="center"><?php if($data['REHABILITASI_MEDIK'] == '1') echo '&radic;'; ?></td>
            <td width="80" align="center"><?php if($data['KAMAR_OPERASI'] == '1') echo '&radic;'; ?></td>
			<td width="100">
			<script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#icd_code<?php echo $x; ?>").autocomplete("index.php?autocomp=rmicd9",{width: 400});
                        });
                    </script>
			<input type="hidden" name="tarif_id<?php echo $x; ?>" value="<?php echo $id; ?>" />
			<input type="text" id="icd_code<?php echo $x; ?>" name="icd_code<?php echo $x; ?>" value="<?php echo $data['ICD_CODE']; ?>" class="text_dt" size="50" /></td>
			<td width="80"><?php echo $data['USER_RM']; ?></td>
        </tr>
        <?
    $x++; }
    ?>
</table>
<input type="hidden" name="cnr" value="<?php echo $x; ?>" />
</form>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>