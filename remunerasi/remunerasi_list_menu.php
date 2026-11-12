<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Nama Pegawai</th>
        <th>Tindakan</th>        
       
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $sql, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
       	$data2=mysql_query('SELECT 
			  m_pegawai.NAMA_PEGAWAI,
			  t_irja_tarif.PEGAWAI_ID,
			  t_irja_tarif.IRJA_TARIF_ID,
			  m_tarif.NAMA_TARIF,
			  m_tarif_group.NAMA_TARIF_GROUP
			FROM
			  t_irja_tarif
			INNER JOIN m_pegawai ON (t_irja_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
			WHERE t_irja_tarif.IRJA_TARIF_ID ="'.$data['IRJA_TARIF_ID'].'"');
				
				$data5=mysql_fetch_array($data2);			
					
        ?>
        <tr>
            <td align="center"><?
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
            <td align="left"><?php echo $data5['NAMA_PEGAWAI']; ?></td>            
			<td align="left"><?php echo $data5['NAMA_TARIF'].' ('.$data5['NAMA_TARIF_GROUP'].')'; ?></td>                       
        </tr>
        <?
    }
    ?>
</table>
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