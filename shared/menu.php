<style>
.list_isi{
	height:550px;
}

</style>

<?php
$icon_f[1] = 'Ambulance.png';
$icon_f[2] = 'Appointment.png';
$icon_f[3] = 'Band-Aid.png';
$icon_f[4] = 'Blood.png';
$icon_f[5] = 'Eye-Hospital.png';
$icon_f[6] = 'First-Aid-Kit-01.png';
$icon_f[7] = 'Heart-ECG.png';
$icon_f[8] = 'Hospital.png';
$icon_f[9] = 'Hospital-Lab.png';
$icon_f[10] = 'Instrument-Microscope.png';
$icon_f[11] = 'Instrument-Thermometer.png';
$icon_f[12] = 'Insurance-Bill.png';
$icon_f[13] = 'Medicine.png';
$icon_f[14] = 'Syringe-02.png';
$icon_f[15] = 'Ambulance.png';
$icon_f[16] = 'Appointment.png';
$icon_f[17] = 'Band-Aid.png';
$icon_f[18] = 'Blood.png';
$icon_f[19] = 'Eye-Hospital.png';
$icon_f[20] = 'First-Aid-Kit-01.png';
$icon_f[21] = 'Heart-ECG.png';
$icon_f[22] = 'Hospital.png';
$icon_f[23] = 'Hospital-Lab.png';
$icon_f[24] = 'Instrument-Microscope.png';
$icon_f[25] = 'Instrument-Thermometer.png';
$icon_f[26] = 'Insurance-Bill.png';
$icon_f[27] = 'Medicine.png';
$icon_f[28] = 'Syringe-02.png';
$icon_f[29] = 'Ambulance.png';
$icon_f[30] = 'Appointment.png';
$icon_f[31] = 'Band-Aid.png';
$icon_f[32] = 'Blood.png';
$icon_f[33] = 'Eye-Hospital.png';
$icon_f[34] = 'First-Aid-Kit-01.png';
$icon_f[35] = 'Heart-ECG.png';
$icon_f[36] = 'Hospital.png';
$icon_f[37] = 'Hospital-Lab.png';
$icon_f[38] = 'Instrument-Microscope.png';
$icon_f[39] = 'Instrument-Thermometer.png';
$icon_f[40] = 'Insurance-Bill.png';
$icon_f[41] = 'Medicine.png';
$icon_f[42] = 'Syringe-02.png';
$icon_f[43] = 'Ambulance.png';
$icon_f[44] = 'Appointment.png';
$icon_f[45] = 'Band-Aid.png';
$icon_f[46] = 'Blood.png';
$icon_f[47] = 'Eye-Hospital.png';
$icon_f[48] = 'First-Aid-Kit-01.png';
$icon_f[49] = 'Heart-ECG.png';
$icon_f[50] = 'Hospital.png';
$icon_f[51] = 'Hospital-Lab.png';
$icon_f[52] = 'Instrument-Microscope.png';
$icon_f[53] = 'Instrument-Thermometer.png';
$icon_f[54] = 'Insurance-Bill.png';
$icon_f[55] = 'Medicine.png';
$icon_f[56] = 'Syringe-02.png';


if (isset($_SESSION['SES_SIMRS_REG'])) {
    $view_menu = json_decode($_SESSION['SES_SIMRS_MENU'],true);
	$menu_group = $_GET['menu'];

    if (sizeof($view_menu) > 0) {
        $img_idx = 11;
		$x = 1;
		$m_page = 4;
		if(sizeof($view_menu) > 12) $m_page = 6;
		echo '<table border="0" style="float:left;">';
		echo '<tr>';
        foreach ($view_menu as $row_menu) {
            if($row_menu[0] == $menu_group and $row_menu[6] == '1'){
				$nama_menu = $row_menu[2];
				$link_id = $row_menu[1];
				$judul_menu = $row_menu[3];
				$param = $row_menu[8];
            ?>
			<td>
			<div style=" background-color:#FFCC00; z-index:1; ">
            <div class="menu_dt">
                <a href="index.php?link=<?php echo $link_id; ?>&<?php echo $param; ?>">
                    <table border="0" width="100%" height="100%" align="center" id="tbl_dt">
                        <tr>
                            <td align="center">							
                                <div style="width:100%; height:35px;  ">
								<div style="height:100px; width:100%; " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?php echo $img_idx;?>','','<?php 
										
										echo 'image/icons/' . $icon_f[$x];
										
									?>',1)"><img src="<?php 
										
										echo 'image/icons/' . $icon_f[$x];

									?>" name="Image<?php echo $img_idx;?>" width="35px" height="35px" border="0">
                                </div></div>
                              <div style="width:100%; padding-top:2px; height:50px;">
									<table height="100%">
										<tr>
											<td align="center" valign="middle">
												<?php echo $judul_menu; ?>
											</td>
										</tr>
									</table>
							  </div>
                            </td>
                        </tr>				
                    </table>
                </a>
            </div>						
			</div>
			</td>
            <?php
			if(($x % $m_page) == 0) { echo '</tr><tr>'; }
            $img_idx++; 
			$x++;
			}
        }
		echo '</tr>';
		echo '<table>';
    } else {	
        include'shared/no_menu.php';
    }	
}
?>
<div style="position:absolute;  padding-top:5px; z-index:1; background-color:#FFF; right:15px; top:25px;bottom:50px; width:250px; height:300px; max-button:400px; border-radius:5px; border:5px solid white; padding:5px; /* box-shadow:0px -1px 5px 0px rgb(0,0,0,2); */ background-color:#75c30c;" align="center">
<div style="border:0px solid white; width:100%; height:100%; border-radius:10px; ">
<img src="image/User_2.png" height="100px" width="80px"><br/>
<font color="#FFFFFF"><?php echo strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']); ?></font><br/><br/>
<font color="#FFFFFF">Modul <?php 
		if($_SESSION['SES_SIMRS_NAMA_MODUL'] == 'Klinik'){ 
			echo 'Poliklinik';
		}else if($_SESSION['SES_SIMRS_NAMA_MODUL'] == 'IGD'){ 
			echo 'Instalasi Gawat Darurat';
		}else if($_SESSION['SES_SIMRS_NAMA_MODUL'] == 'Kusta'){ 
			echo 'Poliklinik Kusta';
		}else if($_SESSION['SES_SIMRS_NAMA_MODUL'] == 'Penunjang'){ 
			echo 'Penunjang [' . $_SESSION['SES_SIMRS_NAMA_UNIT'] . ']';
		}else{ 
			echo $_SESSION['SES_SIMRS_NAMA_MODUL']; 
}?></font><br/><br/>
<font color="#FFFFFF"><?php echo $s_nama_unit_ext; ?></font><br/><br/>
<font color="#FFFFFF"><?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ 
			echo 'Login : Administrator'; 
		} else { 
			echo 'Login : User'; 
		} ?></font><br/><br/>
<div style="color:#FFFFFF; padding:5px; border-radius:5px; " onclick="window.open('index.php?popup=ubahpassword','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=380,height=250'); return false;"><a href="#" style="color:#FF0000; " ><i>ubah password</i></a></div>		
</div>
</div>