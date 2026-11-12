<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&grp=<?php echo $_GET['grp']; ?>&no=<?php echo $_GET['no']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if($_GET['grp'] == '170'){
		$no_order = '';
		$qry_order = 'SELECT DISTINCT NO_ORDER,JNS_PENUNJANG FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif
				ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		while($dat_order = mysql_fetch_array($get_order)){
			$no_order = $dat_order['NO_ORDER'];
			if($dat_order['JNS_PENUNJANG'] == 'LAB'){
				include('lis/simrs2lis.php');
				lis_cancel_order($_GET['idx'],$dat_order['NO_ORDER']);
			}
		}	
		mysql_query('DELETE t_ipenunjang_tarif
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang.NO_ORDER = "' . $no_order . '"');
		mysql_query('DELETE FROM t_ipenunjang
				WHERE t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang.NO_ORDER = "' . $no_order . '"');		
		
		
		mysql_query('DELETE FROM t_irna_tarif WHERE IRNA_ID = "' . $_GET['idx'] . '"
					AND NO_TARIF = "' . $_GET['no'] . '"');
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '" 
					WHERE IRNA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
		mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $_GET['idx'] . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "34"
				AND ORDER_PENUNJANG = "' . $_GET['idk'] . '"') or die(mysql_error());	
	}else{	
		mysql_query('DELETE FROM t_irna_tarif WHERE IRNA_TARIF_ID = "' . $_GET['idk'] . '"');
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '" 
					WHERE IRNA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
		mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $_GET['idx'] . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "34"
				AND ORDER_PENUNJANG = "' . $_GET['idk'] . '"') or die(mysql_error());
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>