<?php
$nama_user = '';
if (isset($_POST['nama_user'])) {
    $nama_user = $_POST['nama_user'];
    $kunci = md5($_POST['kunci']);
    $sql_login = 'SELECT m_app_user.USER_ID, m_app_user.NAMA_USER, m_pegawai.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI, 
  				m_app_user.KUNCI, m_app_user.MODUL_ID, m_app_user.UNIT_ID,
				m_app_modul.NAMA_MODUL, m_unit.NAMA_UNIT, m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,
				m_ruang.KELAS_RAWAT,m_app_user.ADMIN,m_ruang.BANGSAL,m_pegawai.TIPE_PEGAWAI_ID 
				FROM m_app_user
				INNER JOIN m_app_modul ON (m_app_user.MODUL_ID = m_app_modul.MODUL_ID)
				INNER JOIN m_pegawai ON (m_app_user.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
  				LEFT JOIN m_unit ON (m_app_user.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (m_app_user.RUANG_ID = m_ruang.RUANG_ID)
				WHERE m_app_user.NAMA_USER ="' . $nama_user . '" AND m_app_user.KUNCI = "' . $kunci . '"';
    $get_login = mysql_query($sql_login) or die(mysql_error());
    if (mysql_num_rows($get_login) > 0) {
        $dat_login = mysql_fetch_assoc($get_login);
        $_SESSION['SES_SIMRS_REG'] = $dat_login['KUNCI'];
        $_SESSION['SES_SIMRS_NAMA_USER'] = $dat_login['NAMA_USER'];
        $_SESSION['SES_SIMRS_PEGAWAI_ID'] = $dat_login['PEGAWAI_ID'];
        $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] = $dat_login['NAMA_PEGAWAI'];
        $_SESSION['SES_SIMRS_MODUL_ID'] = $dat_login['MODUL_ID'];
        $_SESSION['SES_SIMRS_NAMA_MODUL'] = $dat_login['NAMA_MODUL'];
        $_SESSION['SES_SIMRS_UNIT_ID'] = $dat_login['UNIT_ID'];
        $_SESSION['SES_SIMRS_NAMA_UNIT'] = $dat_login['NAMA_UNIT'];
        $_SESSION['SES_SIMRS_RUANG_ID'] = $dat_login['RUANG_ID'];
        $_SESSION['SES_SIMRS_NAMA_RUANG'] = $dat_login['NAMA_RUANG'];
		$_SESSION['SES_SIMRS_KELAS_RAWAT'] = $dat_login['KELAS_RAWAT'];
        $_SESSION['SES_SIMRS_BANGSAL'] = $dat_login['BANGSAL'];
		$_SESSION['SES_SIMRS_TIPE_PEGAWAI'] = $dat_login['TIPE_PEGAWAI_ID'];
		$_SESSION['SES_SIMRS_ADMIN'] = $dat_login['ADMIN'];
		$_SESSION['SES_SIMRS_SHIFT'] = '';
		$_SESSION['SES_SIMRS_SHIFT_KASIR'] = '';
		
		$arr_menu = array();
		$sql_menu = 'SELECT m_app_menu.NAMA_MENU, m_app_menu.LINK_ID, m_app_menu.NAMA_FILE,m_app_modul_menu.MODUL_ID,
				m_app_menu.JUDUL_MENU,m_app_menu.PARAM,m_app_menu.MENU_ID,m_app_modul_menu.MENU_GROUP,
				m_app_menu.ST_TAMPILKAN,m_app_menu.ADMIN
				FROM m_app_user
				INNER JOIN m_app_modul ON (m_app_user.MODUL_ID = m_app_modul.MODUL_ID)
				INNER JOIN m_app_modul_menu ON (m_app_modul.MODUL_ID = m_app_modul_menu.MODUL_ID)
				INNER JOIN m_app_menu ON (m_app_modul_menu.MENU_ID = m_app_menu.MENU_ID)
				WHERE m_app_user.NAMA_USER = "' . $nama_user . '"  
				ORDER BY m_app_modul_menu.MENU_GROUP,m_app_modul_menu.URUT';
		$get_menu = mysql_query($sql_menu) or die(mysql_error());
		while($dat_menu = mysql_fetch_array($get_menu)){
			$arr_menu[$dat_menu['MENU_ID']] = array($dat_menu['MENU_GROUP'],$dat_menu['LINK_ID'],$dat_menu['NAMA_MENU'],
				$dat_menu['JUDUL_MENU'],$dat_menu['ADMIN'],$dat_menu['NAMA_FILE'],$dat_menu['ST_TAMPILKAN'],
				$dat_menu['MODUL_ID'],$dat_menu['PARAM']); 
		}	
		$_SESSION['SES_SIMRS_MENU'] = json_encode($arr_menu);
		
    } else {
        $msg_info = 'Username Atau Password Tidak Valid.';
    }
}

if (isset($_SESSION['SES_SIMRS_REG'])) {
    ?>
    <script language="JavaScript" type="text/javascript">
        window.location='index.php';
    </script>
    <?php
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="image/logo.png" rel="shortcut icon" />
        <link href="style/font/fontface.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="style/default.css" />
        <link rel="stylesheet" type="text/css" href="style/component.css" />
		<link href="style/simrs.css" rel="stylesheet" type="text/css"/>
        <script src="script/modernizr.custom.js"></script>
		<script type="text/javascript" src="script/jquery-1.2.6.pack.js" language="javascript"></script>		
        <style>
            body{	
                font-family: 'TitilliumText14L600wt';	
            }
        </style>
        <title><?php echo $app_title_brw; ?></title>
        <script language="JavaScript" type="text/JavaScript">
            <!--
            function MM_reloadPage(init) {  //reloads the window if Nav4 resized
                if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
                        document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
                else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
            }
            MM_reloadPage(true);
            //-->
        </script>
    </head>
    <body onload="document.getElementById('nama_user').focus();" >
        <div style="left:0; bottom:0; top:0; right:0; margin:auto; padding:auto; width:100%; height:100%; background: rgb(153,223,4);
             background: -moz-linear-gradient(top,  rgb(153,223,4) 2%, rgb(60,131,15) 100%);
             background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(153,223,4)), 
             color-stop(100%,rgb(60,131,15)));
             background: -webkit-linear-gradient(top,  rgb(153,223,4) 2%,rgb(60,131,15) 100%);
             background: -o-linear-gradient(top,  rgb(153,223,4) 2%rgb(60,131,15) 100%);
             background: -ms-linear-gradient(top,  rgb(153,223,4) 2%rgb(60,131,15) 100%);
             background: linear-gradient(to bottom,  rgb(153,223,4) 2%rgb(60,131,15) 100%);
             filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='rgb(153,223,4)', endColorstr='rgb(60,131,15)',GradientType=0 ); position:absolute;">&nbsp;</div>
        <div style="left:0; bottom:0; top:0; right:0; margin:auto; padding:auto; width:100%; height:100%; background-color:#FFFFFF; opacity:0.1; position:absolute;">&nbsp;</div>
        <div style="left:0; bottom:0; top:0; right:0; margin:auto; padding:auto; width:100%; height:100%; position:absolute;">
            <table align="center" border="0" width="100%" height="100%" >
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="60%" align="center" valign="bottom" style=" letter-spacing:10px; color:#FFFFFF; ">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="60%" height="50%" align="center" valign="top"><span style="font-size:35px;color:#fff; text-shadow:5px 5px 5px rgba(0,0,0,2);"><?php echo $app_title_hdr2; ?></span>
                        <div align="center" style="background-color:#fff; width:80%; height:80%; border:1px dashed #999">

                            <table align="center" height="100%" width="100%" border="1" >
                                <tr>
                                    <td>
                                        <table align="center" height="100%" width="100%" border="0" style="border:1px dashed #999;background-image:url(image/bg_log.PNG)" >
                                            <form name="login" id="login" method="post" action="index.php" autocomplete="off" >
                                            <tr>
                                                <td>
                                                    <ul class="grid cs-style-4">
                                                        <li>
                                                        <figure>
                                                            <div align="left" style=" width:600px; "><img src="image/lock.png" width="200px" height="200px"></div>
                                                            <figcaption>
                                                                <h3>masukan</h3>
                                                                <span>username dan password</span>

                                                                <table border="0">								
                                                                    <tr>
                                                                        <td><input name="nama_user" id="nama_user" type="text" class="text_dt" style="background-color:#99FF00;" size="25" value="<?php echo $nama_user; ?>"  placeholder="username" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input name="kunci" type="password" class="text_dt" style="line-height:2em; background-color:#99FF00;" size="25" height="50px;" align="middle" placeholder="password" ></td>					
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="right"><input name="submit" value="login" type="submit" class="myButton" ></td>
                                                                    </tr>
                                                                </table>							

                                                            </figcaption>
                                                        </figure>
                                                        </li>				
                                                    </ul>
                                                </td>
                                            </tr>
                                            </form>
                                            <tr>
                                                <td align="right" id="dt"><font color="#000000" ><i><?php echo $app_title_ftr; ?></i>&nbsp;</td>
                                            </tr>
                                        </table>

                                    </td>							
                                </tr>						
                            </table>

                        </div>				
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="60%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
            </table>
        </div>
      
	
	</body>
</html>
