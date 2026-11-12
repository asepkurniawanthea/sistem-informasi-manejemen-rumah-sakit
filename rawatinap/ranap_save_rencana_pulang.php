<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$irna_rencana_pulang_id = $_POST['irna_rencana_pulang_id'];
$rencana_pulang = array('1_a'=>((isset($_POST['1_a'])) ? $_POST['1_a'] : ''),
						'1_b'=>((isset($_POST['1_b'])) ? $_POST['1_b'] : ''),
						'1_c'=>((isset($_POST['1_c'])) ? $_POST['1_c'] : ''),
						'1_d'=>((isset($_POST['1_d'])) ? $_POST['1_d'] : ''),
						
						'2_a'=>((isset($_POST['2_a'])) ? $_POST['2_a'] : ''),
						'2_b'=>((isset($_POST['2_b'])) ? $_POST['2_b'] : ''),
						'2_c'=>((isset($_POST['2_c'])) ? $_POST['2_c'] : ''),
						
						'2_d1'=>((isset($_POST['2_d1'])) ? $_POST['2_d1'] : ''),
						'2_d2'=>((isset($_POST['2_d2'])) ? $_POST['2_d2'] : ''),
						'2_d3'=>((isset($_POST['2_d3'])) ? $_POST['2_d3'] : ''),
						'2_d4'=>((isset($_POST['2_d4'])) ? $_POST['2_d4'] : ''),
						'2_d4_ket'=>replace_quote($_POST['2_d4_ket']),
						
						'2_e'=>((isset($_POST['2_e'])) ? $_POST['2_e'] : ''),
						
						'3_a'=>((isset($_POST['3_a'])) ? $_POST['3_a'] : ''),
						'3_b'=>((isset($_POST['3_b'])) ? $_POST['3_b'] : ''),
						'3_c'=>((isset($_POST['3_c'])) ? $_POST['3_c'] : ''),
						'3_d'=>((isset($_POST['3_d'])) ? $_POST['3_d'] : ''),
						'3_e'=>((isset($_POST['3_e'])) ? $_POST['3_e'] : ''),
						'3_f'=>((isset($_POST['3_f'])) ? $_POST['3_f'] : ''),
						
						'3_g1'=>((isset($_POST['3_g1'])) ? $_POST['3_g1'] : ''),
						'3_g2'=>((isset($_POST['3_g2'])) ? $_POST['3_g2'] : ''),
						'3_g3'=>((isset($_POST['3_g3'])) ? $_POST['3_g3'] : ''),
						
						'3_h1'=>((isset($_POST['3_h1'])) ? $_POST['3_h1'] : ''),
						'3_h2'=>((isset($_POST['3_h2'])) ? $_POST['3_h2'] : ''),
						'3_h3'=>((isset($_POST['3_h3'])) ? $_POST['3_h3'] : ''),
						'3_h4'=>((isset($_POST['3_h4'])) ? $_POST['3_h4'] : ''),
						
						'3_h4_ket'=>replace_quote($_POST['3_h4_ket']),
						
						'4_a'=>((isset($_POST['4_a'])) ? $_POST['4_a'] : ''),
						'4_b'=>((isset($_POST['4_b'])) ? $_POST['4_b'] : ''),
						'4_c'=>((isset($_POST['4_c'])) ? $_POST['4_c'] : ''),
						'4_d'=>((isset($_POST['4_d'])) ? $_POST['4_d'] : ''),
						'4_e'=>((isset($_POST['4_e'])) ? $_POST['4_e'] : ''),
						'4_f'=>((isset($_POST['4_f'])) ? $_POST['4_f'] : ''),
						
						'4_f_ket'=>replace_quote($_POST['4_f_ket']),
						
						'5_a'=>((isset($_POST['5_a'])) ? $_POST['5_a'] : ''),
						'5_b'=>((isset($_POST['5_b'])) ? $_POST['5_b'] : ''),
						'5_c'=>((isset($_POST['5_c'])) ? $_POST['5_c'] : ''),
						'5_d'=>((isset($_POST['5_d'])) ? $_POST['5_d'] : ''),
						'5_e'=>((isset($_POST['5_e'])) ? $_POST['5_e'] : ''),
						'5_f'=>((isset($_POST['5_f'])) ? $_POST['5_f'] : ''),
						'5_g'=>((isset($_POST['5_g'])) ? $_POST['5_g'] : ''),
						
						'5_g_ket'=>replace_quote($_POST['5_g_ket']),
						
						'6_a'=>((isset($_POST['6_a'])) ? $_POST['6_a'] : ''),
						'6_b'=>((isset($_POST['6_b'])) ? $_POST['6_b'] : ''),
						'6_c'=>((isset($_POST['6_c'])) ? $_POST['6_c'] : ''),
						
						'7_a'=>((isset($_POST['7_a'])) ? $_POST['7_a'] : ''),
						'7_b'=>((isset($_POST['7_b'])) ? $_POST['7_b'] : ''),
						'7_c'=>((isset($_POST['7_c'])) ? $_POST['7_c'] : ''),
						
						'8_a'=>((isset($_POST['8_a'])) ? $_POST['8_a'] : ''),
						'8_b'=>((isset($_POST['8_b'])) ? $_POST['8_b'] : ''),
						'8_c'=>((isset($_POST['8_c'])) ? $_POST['8_c'] : ''),
						
						'8_c_ket'=>replace_quote($_POST['8_c_ket']),
						'tl'=>replace_quote($_POST['tl']));
$rencana_pulang = json_encode($rencana_pulang);
$rencana_pulang = str_replace('"','|',$rencana_pulang);

$_err = '';
if (empty($_err)) {
			$extfield = 'PEGAWAI_ID';
			if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $extfield = 'PEGAWAI_ID_2';
				
			if(empty($irna_rencana_pulang_id)){
				mysql_query('INSERT INTO t_irna_rencana_pulang (IRNA_ID,RENCANA_PULANG,REGISTER,TGL_ASSESMENT,' . $extfield . ')
						VALUES ("'.$irna_id.'","' . $rencana_pulang . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
						NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());	
			}else{
				mysql_query('UPDATE t_irna_rencana_pulang SET RENCANA_PULANG = "'. $rencana_pulang .'",
						REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
						TGL_ASSESMENT = NOW(),
						' . $extfield . ' = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"	
						WHERE IRNA_ID = "'.$irna_rencana_pulang_id.'"') or die(mysql_error());
			}

			/*
			include('lib/vendor/autoload.php');
			include('lib/html2openxml/HTMLtoOpenXML.php');
			include('edoc_rekammedik/new/erm_create_rencana_pemulangan.php');
			erm_rencana_pemulangan($irna_id,'1');	
			*/
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Rencana Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>