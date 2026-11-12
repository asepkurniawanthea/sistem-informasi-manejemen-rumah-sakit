<?php
$array_filter_tarif = array();
$sql_array_filter_tarif = 'SELECT m_jenis_tarif.KODE_JENIS_TARIF,m_jenis_tarif.JENIS_TARIF,
						t_filter_report_tarif.KODE_TARIF_GROUP,t_filter_report_tarif.LEVEL_DT
						FROM m_jenis_tarif
						INNER JOIN t_filter_report_tarif 
						ON (m_jenis_tarif.KODE_JENIS_TARIF = t_filter_report_tarif.KODE_JENIS_TARIF)
						ORDER BY m_jenis_tarif.KODE_JENIS_TARIF';
$get_array_filter_tarif = mysql_query($sql_array_filter_tarif) or die(mysql_error());
while($dat_array_filter_tarif = mysql_fetch_array($get_array_filter_tarif)){
	$array_filter_tarif[] = array('kd_jenis'=>$dat_array_filter_tarif['KODE_JENIS_TARIF'],
									'jenis_tarif'=>$dat_array_filter_tarif['JENIS_TARIF'],
									'tarif_group'=>$dat_array_filter_tarif['KODE_TARIF_GROUP'],
									'lvl'=>$dat_array_filter_tarif['LEVEL_DT']);
}						

function getArrayFilter($jenis_tarif,$lvl='1'){
	global $array_filter_tarif;
	$ret = array();
	
	foreach($array_filter_tarif as $arr){
		if(strtolower($arr['jenis_tarif']) == strtolower($jenis_tarif) and $arr['lvl'] == $lvl){
			$ret[] = $arr['tarif_group'];	
		}
	}
	
	if(sizeof($ret) < 1) $ret[] = '00'; 
	return $ret;
}

function getStringArrayFilter($jenis_tarif,$lvl='1'){
	global $array_filter_tarif;
	$ret = '';
	
	foreach($array_filter_tarif as $arr){
		if(strtolower($arr['jenis_tarif']) == strtolower($jenis_tarif) and $arr['lvl'] == $lvl){
			$ret .= '"' . $arr['tarif_group'] . '",';	
		}
	}
	
	if($ret == '') {
		$ret = '"00"';
	}else{
		$ret = substr($ret,0,strlen($ret) - 1);
	}	
	return $ret;
}
?>