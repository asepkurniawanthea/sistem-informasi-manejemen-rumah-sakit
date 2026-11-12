<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$arr_jenis_diet = array('BTS','RS','RSDH','RSRP','RSDM','RSRG','DL','DLDH','DLRP','DLDM','DLDMRG','DLDMDJ','DLDMRP','DLDJ','DLRG','DM','DMRP','DMDH','DMRG','DMRGRP','DMRGRPurin','DMRGRSDH','RG','DJ','RP','RPRG','DH','DHRG','Tinggi Serat','R. Purin','TKTP','Putel');
$ret = '';
foreach($arr_jenis_diet as $row) {
	if (stripos($row,$q) !== false) {
		$ret .= $row . " \n ";
	}	
}

echo $ret;
?>