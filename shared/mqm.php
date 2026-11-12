<?php
$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect_4) or die(mysql_error());
							
if (isset($_GET['mqm'])) {
    $mqm = $_GET['mqm'];
    switch ($mqm) {
        case 'sisa' :
            $st = $_POST['st'];
			$group = $_POST['group'];
			$qry_group = '';
			if($group != '') $qry_group = 'AND t_trans.NO_ANTRIAN_GROUP = "' . $group . '"'; 
			
			$query = mysql_query('SELECT COUNT(t_trans.NO_ANTRIAN) AS SISA_ANTRIAN 
								FROM t_trans 
								WHERE t_trans.RESET IS NULL AND t_trans.SKIP IS NULL
								AND DATE(t_trans.PRINT_TIME) = CURRENT_DATE() 
								AND t_trans.CALL_TIME IS NULL
								AND t_trans.NO_ANTRIAN_GROUP IN ("A","B","C","D","E")	
								AND t_trans.SITE_ID = "' . $st . '"
								' . $qry_group) or die(mysql_error());
			$data = mysql_fetch_assoc($query);
			echo $data['SISA_ANTRIAN'];
			
            break;
			
		case 'listmanual' :
            $st = $_POST['st'];
			$group = $_POST['group'];
			$qry_group = '';
			if($group != '') $qry_group = 'AND t_trans.NO_ANTRIAN_GROUP = "' . $group . '"'; 
			
			$select = '<select name="manual" id="manual" class="text_dt" style="width:79px;height:25px;">
						<option value=""> -- </option>';
			$query = mysql_query('SELECT MAX(t_trans.TRANS_ID) AS TRANS_ID,t_trans.NO_ANTRIAN,t_trans.NO_ANTRIAN_GROUP
											FROM t_trans
											WHERE t_trans.CALL_TIME IS NULL
											AND DATE(t_trans.PRINT_TIME) = CURRENT_DATE() 
											AND t_trans.NO_ANTRIAN_GROUP IN ("A","B","C","D","E")	
											AND t_trans.SITE_ID = "' . $st . '"
											' . $qry_group . '
									GROUP BY t_trans.NO_ANTRIAN,t_trans.NO_ANTRIAN_GROUP		
									ORDER BY t_trans.NO_ANTRIAN') or die(mysql_error());
			while($data = mysql_fetch_array($query)){
				$select = $select . '<option value="' . $data['TRANS_ID'] . '" >' . substr('000',0,3 - strlen($data['NO_ANTRIAN'])) . $data['NO_ANTRIAN'] . '</option>';
			}	
			$select = $select . '</select>';	
			echo $select;
			
            break;	
			
		case 'listrecall' :
            $st = $_POST['st'];
			$group = $_POST['group'];
			$qry_group = '';
			if($group != '') $qry_group = 'AND t_trans.NO_ANTRIAN_GROUP = "' . $group . '"'; 
			
			$select = '<select name="recall" id="recall" class="text_dt" style="width:79px;height:25px;">
						<option value=""> -- </option>';
			$query = mysql_query('SELECT MAX(t_trans.TRANS_ID) AS TRANS_ID,t_trans.NO_ANTRIAN,t_trans.NO_ANTRIAN_GROUP
											FROM t_trans
											WHERE t_trans.CALL_TIME IS NOT NULL
											AND DATE(t_trans.PRINT_TIME) = CURRENT_DATE() 
											AND t_trans.NO_ANTRIAN_GROUP IN ("A","B","C","D","E")	
											AND t_trans.SITE_ID = "' . $st . '"
											' . $qry_group . '
									GROUP BY t_trans.NO_ANTRIAN,t_trans.NO_ANTRIAN_GROUP		
									ORDER BY t_trans.NO_ANTRIAN') or die(mysql_error());
			while($data = mysql_fetch_array($query)){
				$select = $select . '<option value="' . $data['TRANS_ID'] . '" >' . substr('000',0,3 - strlen($data['NO_ANTRIAN'])) . $data['NO_ANTRIAN'] . '</option>';
			}	
			$select = $select . '</select>';	
			echo $select;
			
            break;		
		
		case 'next' :
            $st = $_POST['st'];
			$lkt = $_POST['lkt'];
			$group = $_POST['group'];
			$qry_group = '';
			if($group != '') $qry_group = 'AND t_trans.NO_ANTRIAN_GROUP = "' . $group . '"'; 
			
			$query = mysql_query('SELECT t_trans.TRANS_ID, t_trans.NO_ANTRIAN, t_trans.NO_ANTRIAN_GROUP, t_trans.PRINT_TIME,
								t_trans.ST_ORDER,t_trans.IRJA_ID,t_trans.NO_ANTRIAN_GROUP
								FROM t_trans 
								WHERE t_trans.RESET IS NULL AND t_trans.SKIP IS NULL 
								AND DATE(t_trans.PRINT_TIME) = CURRENT_DATE() 
								AND t_trans.NO_ANTRIAN_GROUP IN ("A","B","C","D","E")	
								AND t_trans.SITE_ID = "' . $st . '"				
								AND t_trans.CALL_TIME IS NULL
								' . $qry_group . '
								ORDER BY t_trans.NO_ANTRIAN ASC LIMIT 1') or die(mysql_error());
			if(mysql_num_rows($query) > 0){					
				$data = mysql_fetch_assoc($query);
				$no_antrian = $data['NO_ANTRIAN'];
				$id_trans = $data['TRANS_ID'];
				$st_order = $data['ST_ORDER'];
				$irja_id = $data['IRJA_ID'];
				$group_antrian = $data['NO_ANTRIAN_GROUP'];
			
				mysql_query('UPDATE t_trans SET KODE_COUNTER = "' . $lkt . '", USER_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '", 
						NAMA_USER = "' . currentUser() . '", CALL_TIME = NOW(), 
						WAITING_TIME = TIME_TO_SEC(TIMEDIFF(NOW(), PRINT_TIME)),
						ST_KUNJUNGAN = "1"
						WHERE TRANS_ID = "' . $id_trans . '"') or die(mysql_error());
				mysql_query('INSERT INTO t_call(TRANS_ID,SITE_ID,NO_ANTRIAN,NO_ANTRIAN_GROUP,KODE_COUNTER) 
						VALUES("' . $id_trans . '","' . $st . '","' . $no_antrian . '",
						"' . $group_antrian . '","' . $lkt . '")') or die(mysql_error());
				echo $id_trans . '|' . $group_antrian . '-' . substr('000',0,3 - strlen($no_antrian)) . $no_antrian . '|' . $st_order . '|' . $irja_id . '|';
				$_SESSION['pendaftaran_mandiri_noantrian'] = substr('000',0,3 - strlen($no_antrian)) . $no_antrian;	
				$_SESSION['pendaftaran_mandiri_idtrans'] = $id_trans;
				$_SESSION['pendaftaran_mandiri_storder'] = $st_order;
				$_SESSION['pendaftaran_mandiri_irjaid'] = $irja_id;
				$_SESSION['pendaftaran_mandiri_grpantrian'] = $group_antrian;
			}else{
				echo 'fail';
			}		
			
            break;	
		
		case 'repeate' :
            $st = $_POST['st'];
			$lkt = $_POST['lkt'];
			
			if(!isset($_SESSION['pendaftaran_mandiri_idtrans']) or empty($_SESSION['pendaftaran_mandiri_idtrans'])){
				echo 'fail';
			}else{			
				mysql_query('UPDATE t_trans SET KODE_COUNTER = "' . $lkt . '", USER_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '", 
						NAMA_USER = "' . currentUser() . '", CALL_TIME = NOW(), 
						WAITING_TIME = TIME_TO_SEC(TIMEDIFF(NOW(), PRINT_TIME))
						WHERE TRANS_ID = "' . $_SESSION['pendaftaran_mandiri_idtrans'] . '"') or die(mysql_error());
			
				mysql_query('INSERT INTO t_call(TRANS_ID,SITE_ID,NO_ANTRIAN,NO_ANTRIAN_GROUP,KODE_COUNTER) 
						VALUES("' . $_SESSION['pendaftaran_mandiri_idtrans'] . '","' . $st . '",
						"' . $_SESSION['pendaftaran_mandiri_noantrian'] . '",
						"' . $_SESSION['pendaftaran_mandiri_grpantrian'] . '","' . $lkt . '")') or die(mysql_error());
				echo 'success';				
			}
			
            break;		
			
		case 'noshow' :
			if(!isset($_SESSION['pendaftaran_mandiri_idtrans']) or empty($_SESSION['pendaftaran_mandiri_idtrans'])){
				echo 'fail';
			}else{
				mysql_query('UPDATE t_trans SET NO_SHOW = "1", USER_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '", 
						NAMA_USER = "' . currentUser() . '" 
						WHERE TRANS_ID = "' . $_SESSION['pendaftaran_mandiri_idtrans'] . '"') or die(mysql_error());
				echo 'success';
				$_SESSION['pendaftaran_mandiri_noantrian'] = '';
				$_SESSION['pendaftaran_mandiri_idtrans'] = '';	
				$_SESSION['pendaftaran_mandiri_storder'] = '';
				$_SESSION['pendaftaran_mandiri_irjaid'] = '';
				$_SESSION['pendaftaran_mandiri_grpantrian'] = '';
			}	
			
            break;	
			
		case 'manual' :
            $st = $_POST['st'];
			$lkt = $_POST['lkt'];
			$man = $_POST['man'];
			
			$query = mysql_query('SELECT t_trans.TRANS_ID, t_trans.NO_ANTRIAN, t_trans.NO_ANTRIAN_GROUP, t_trans.PRINT_TIME,
								t_trans.ST_ORDER,t_trans.IRJA_ID,t_trans.NO_ANTRIAN_GROUP
								FROM t_trans 
								WHERE t_trans.TRANS_ID = "' . $man . '"') or die(mysql_error());
			$data = mysql_fetch_assoc($query);
			$no_antrian = $data['NO_ANTRIAN'];
			$id_trans = $data['TRANS_ID'];
			$st_order = $data['ST_ORDER'];
			$irja_id = $data['IRJA_ID'];
			$group_antrian = $data['NO_ANTRIAN_GROUP'];
			
			mysql_query('UPDATE t_trans SET KODE_COUNTER = "' . $lkt . '", USER_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '", 
						NAMA_USER = "' . currentUser() . '", CALL_TIME = NOW(), 
						WAITING_TIME = TIME_TO_SEC(TIMEDIFF(NOW(), PRINT_TIME)),
						ST_KUNJUNGAN = "1"
						WHERE TRANS_ID = "' . $id_trans . '"') or die(mysql_error());
			mysql_query('INSERT INTO t_call(TRANS_ID,SITE_ID,NO_ANTRIAN,NO_ANTRIAN_GROUP,KODE_COUNTER) 
						VALUES("' . $id_trans . '","' . $st . '","' . $no_antrian . '",
						"' . $group_antrian . '","' . $lkt . '")') or die(mysql_error());
			echo $id_trans . '|' . $group_antrian . '-' . substr('000',0,3 - strlen($no_antrian)) . $no_antrian . '|' . $st_order . '|' . $irja_id . '|';
			$_SESSION['pendaftaran_mandiri_noantrian'] = substr('000',0,3 - strlen($no_antrian)) . $no_antrian;	
			$_SESSION['pendaftaran_mandiri_idtrans'] = $id_trans;
			$_SESSION['pendaftaran_mandiri_storder'] = $st_order;
			$_SESSION['pendaftaran_mandiri_irjaid'] = $irja_id;
			$_SESSION['pendaftaran_mandiri_grpantrian'] = $group_antrian;
			
            break;

			case 'recall' :
            $st = $_POST['st'];
			$lkt = $_POST['lkt'];
			$rcl = $_POST['rcl'];
			
			mysql_query('INSERT INTO t_trans (PARENT_TRANS_ID,NO_ANTRIAN,NO_ANTRIAN_GROUP,SITE_ID,PRINT_TIME,NO_PENDAFTARAN, 
								KODE_COUNTER,USER_ID,NAMA_USER,CALL_TIME,WAITING_TIME,ST_KUNJUNGAN,ST_ORDER,IRJA_ID,DAFTAR_ID)			
								SELECT x.TRANS_ID,x.NO_ANTRIAN,x.NO_ANTRIAN_GROUP,x.SITE_ID,x.CALL_TIME,x.NO_PENDAFTARAN,
								"' . $lkt . '","' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '","' . currentUser() . '",NOW(),
								TIME_TO_SEC(TIMEDIFF(NOW(),x.CALL_TIME)),x.ST_KUNJUNGAN,x.ST_ORDER,x.IRJA_ID,x.DAFTAR_ID
								FROM t_trans x
								WHERE x.TRANS_ID = "' . $rcl . '"') or die(mysql_error());
			$query = mysql_query('SELECT t_trans.TRANS_ID, t_trans.NO_ANTRIAN, t_trans.NO_ANTRIAN_GROUP, t_trans.PRINT_TIME,
								t_trans.ST_ORDER,t_trans.IRJA_ID,t_trans.NO_ANTRIAN_GROUP
								FROM t_trans 
								WHERE t_trans.SITE_ID = "' . $st . '" 
								AND DATE(t_trans.PRINT_TIME) = CURRENT_DATE() 
								AND t_trans.NO_ANTRIAN IN (SELECT x.NO_ANTRIAN FROM t_trans x
								WHERE x.TRANS_ID = "' . $rcl . '")
								ORDER BY t_trans.TRANS_ID DESC LIMIT 1') or die(mysql_error());
			$data = mysql_fetch_assoc($query);
			$id_trans = $data['TRANS_ID'];
			$no_antrian = $data['NO_ANTRIAN'];
			$st_order = $data['ST_ORDER'];
			$irja_id = $data['IRJA_ID'];
			$group_antrian = $data['NO_ANTRIAN_GROUP'];
			
			mysql_query('INSERT INTO t_call(TRANS_ID,SITE_ID,NO_ANTRIAN,NO_ANTRIAN_GROUP,KODE_COUNTER) 
						VALUES("' . $id_trans . '","' . $st . '","' . $no_antrian . '",
						"' . $group_antrian . '","' . $lkt . '")') or die(mysql_error());
			echo $id_trans . '|' . $group_antrian . '-' . substr('000',0,3 - strlen($no_antrian)) . $no_antrian . '|' . $st_order . '|' . $irja_id . '|';
			$_SESSION['pendaftaran_mandiri_noantrian'] = substr('000',0,3 - strlen($no_antrian)) . $no_antrian;	
			$_SESSION['pendaftaran_mandiri_idtrans'] = $id_trans;
			$_SESSION['pendaftaran_mandiri_storder'] = $st_order;
			$_SESSION['pendaftaran_mandiri_irjaid'] = $irja_id;
			$_SESSION['pendaftaran_mandiri_grpantrian'] = $group_antrian;
			
            break;	
			
			case 'cekantrian' :
            			
			if(!isset($_SESSION['pendaftaran_mandiri_idtrans']) or empty($_SESSION['pendaftaran_mandiri_idtrans'])){
				echo 'fail';
			}else{			
				$sql = 'SELECT t_trans.NO_ANTRIAN_GROUP,t_trans.DAFTAR_ID,t_daftar_irja_online.KLINIK_ID,
						t_daftar_irja_online.PASIEN_BARU,t_daftar_irja_online.NOMR
						FROM t_trans
						LEFT JOIN t_daftar_irja_online
						ON (t_trans.DAFTAR_ID = t_daftar_irja_online.DAFTAR_ID)
						WHERE t_trans.TRANS_ID = "' . $_SESSION['pendaftaran_mandiri_idtrans'] . '"';
				$query = mysql_query($sql) or die(mysql_error());		
				$data = mysql_fetch_assoc($query);
				$id_trans = $_SESSION['pendaftaran_mandiri_idtrans'];
				$daftar_id = $data['DAFTAR_ID'];
				$group_antrian = $data['NO_ANTRIAN_GROUP'];
				$klinik_id = $data['KLINIK_ID'];
				$st_baru = $data['PASIEN_BARU'];
				$nomr = $data['NOMR'];
				
				echo $id_trans . '|' . $daftar_id . '|' . $group_antrian . '|' . $klinik_id . '|' . $st_baru . '|' . $nomr;
			}
			
            break;	
	}
}
?>