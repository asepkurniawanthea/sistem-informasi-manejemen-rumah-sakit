<?php

if (isset($_SESSION['SES_SIMRS_REG'])) {
    if (isset($_REQUEST['link'])) {
        $link_id = $_REQUEST['link'];
		$arr_menu = json_decode($_SESSION['SES_SIMRS_MENU'],true);
		$st_find = false;
        $nama_file = '';
		$header_page = '';
			foreach ($arr_menu as $row_menu) {
				$nama_file = $row_menu[5];
				$header_page = $row_menu[3];
				if($_SESSION['SES_SIMRS_ADMIN'] == '1'){
					if($row_menu[1] == $link_id and $row_menu[7] == $_SESSION['SES_SIMRS_MODUL_ID']) {
						$st_find = true;
						break;
					}
				}else{
					if($row_menu[1] == $link_id and $row_menu[7] == $_SESSION['SES_SIMRS_MODUL_ID'] and $row_menu[4] == '') {
						$st_find = true;
						break;
					}	
				}	
			}    

            if ($st_find) {
                if (!file_exists($nama_file)) {					
                    include'error_404.php';
                } else {
				?><fieldset style="margin-top:5px; border-radius:5px; margin:0; padding:0; padding-bottom:5px; stroke:red; border:1px solid rgb(153,223,4);">
						<legend style="font-weight:bold; height:25px; width:auto; padding-left:15px; margin-top:5px; margin-left:25px; padding-right:15px; text-align:center; border-radius:5px; border:1px solid rgb(153,223,4); box-shadow:1px 1px 1px 1px rgba(0,0,0,2); color:#FFFFFF;"><table border="0"><tr><td align="center" width="100%" height="100%">
							<? echo strtoupper($header_page); ?>										
						</td></tr></table></legend>
						<? include($nama_file); ?>
					</fieldset>										
									
					<div style="height:50px;"></div>				
				<?	
				
                }
            } else {
                include'error_404.php';
            }
    } 
}
?>