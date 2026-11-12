<?php 
/*
ini_set('session.gc_maxlifetime', 10800);    
session_set_cookie_params(10800);
session_start();
*/
ini_set('session.gc_maxlifetime', 10800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
session_save_path(dirname(__FILE__) . '/sessions');
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    ?>
    <script language="JavaScript" type="text/javascript">
        window.location='index.php';
    </script>
    <?php
}

include('config/config.php');
include('shared/connect_db.php');
$skip_login = false;
if(isset($_GET['skip_login'])) $skip_login = true;
if (!isset($_SESSION['SES_SIMRS_REG']) and $skip_login == false) {
    include('shared/login.php');
} else {
	if (isset($_POST['page_to_excel'])) {
        include_once('shared/page_to_excel.class.php');
        $exp = new ExportToExcel();
        $exp->exportWithPage($_POST['xlsfile'], $_POST['xlsname']);
        die();
    }
    if (isset($_GET['filesharing'])) {
        include('admin/admin_donwload_filesharing.php');
        die();
    }
	if (isset($_GET['autocomp'])) {
		include('shared/autocomp.php');
        die();
    }
    include('shared/function.php');
    include('shared/enum_function.php');
	include('shared/bridge.php');
    if (isset($_GET['ajaxrequest'])) {
        include('shared/ajax_request.php');
        die();
    }
	if (isset($_GET['eklaim'])) {
        include('inacbg/inacbg_donwload_arsip.php');
        die();
    }
	if (isset($_GET['dicom'])) {
        include('dicom/view_image.php');
        die();
    }
	if (isset($_GET['dicomdownload'])) {
        include('dicom/download.php');
        die();
    }
	if (isset($_GET['print'])) {
        include('shared/print.php');
        die();
    }
	if (isset($_GET['printlab'])) {
        include('laboratorium/laboratorium_print_hasil.php');
        die();
    }
	if (isset($_GET['flex'])) {
        include('flexpaper/view.php');
        die();
    }
	if (isset($_GET['mqm'])) {
        include('shared/mqm.php');
        die();
    }
	if (isset($_GET['inacbg'])) {
        include('inacbg/call_api.php');
        die();
    }
	if (isset($_GET['sep'])) {
        include('sep/call_api.php');
        die();
    }
    $msg_info = '';
	$umur = '&nbsp;';
    $s_nama_user = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
    $s_nama_modul = $_SESSION['SES_SIMRS_NAMA_MODUL'];
    $s_nama_unit = '';
	$s_nama_unit_ext = '';
	if (currentModul() == 'klinik'){
        $s_nama_unit =  'Poliklinik [' . $_SESSION['SES_SIMRS_NAMA_UNIT'] . ']';
		$s_nama_unit_ext = $_SESSION['SES_SIMRS_NAMA_UNIT'];
	}else if (currentModul() == 'penunjang' or currentModul() == 'igd'){
        $s_nama_unit =  $_SESSION['SES_SIMRS_NAMA_UNIT'];	
    }else if (currentModul() == 'rawat inap'){
		$s_nama_unit =  'Rawat Inap ';
		if($_SESSION['SES_SIMRS_BANGSAL'] != '') $s_nama_unit .= ' [' . $_SESSION['SES_SIMRS_BANGSAL'] . ']';
		$s_nama_unit_ext = $_SESSION['SES_SIMRS_BANGSAL'];
	}else{
		$s_nama_unit = currentModul();
	}
    $s_nama_unit = strtoupper($s_nama_unit);
    $user_name = currentUser();
    include('shared/pagination.php');
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
        "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title><?php echo $app_title_brw; ?></title>
            <link href="image/logo.png" rel="shortcut icon" />
            <link href="style/simrs.css" rel="stylesheet" type="text/css"/>
            <link href="style/font/fontface.css" rel="stylesheet" type="text/css"/>
            <link type="text/css" href="style/jquery.autocomplete.css" rel="stylesheet" />
			
			<style>
			.title_poli{
			position:fixed;
			right:25%;
			top:0;
font-size:20px; color:#fff;			
			padding:25px;
			width:auto;
			float:right;
		}
html {
	background:url(image/bg_pattern1.jpg);
}
</style>
			<script type="text/javascript">
                function tableHover(){
					if(document.getElementById('tfhover')){
						var tfrow = document.getElementById('tfhover').rows.length;
						var tbRow=[];
						for (var i=1;i<tfrow;i++) {
							tbRow[i]=document.getElementById('tfhover').rows[i];
							tbRow[i].onmouseover = function(){
								this.style.backgroundColor = '#EBFDE3';												
								this.style.color = '#000000';
							};
							tbRow[i].onmouseout = function() {
								this.style.backgroundColor = '#ffffff';
								this.style.color = '#999999';
							};
						}
					}	
                };
            </script>
			<script type="text/javascript" src="script/ajaxrequest.js" language="javascript"></script>
            <script type="text/javascript" src="script/xmlhttp.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery-1.2.6.pack.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery.min.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery.cycle.all.latest.js" language="javascript"></script>
            <script type="text/javascript" src="script/function.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery-ui-1.8.23.custom.min.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery.ui.datepicker-id.js" language="javascript"></script>
            <script type="text/javascript" src="script/jquery.autocomplete.js" language="javascript"></script>
			<script src="script/calendar.js" type="text/javascript" language="javascript"></script>
			<script src="script/cal_config.js" type="text/javascript" language="javascript"></script>
			<script type="text/javascript" src="sep/js/sepscript.js" language="javascript"></script>	<!-- SEP Bridging Script Source -->
			<script type="text/javascript" src="inacbg/js/inascript.js" language="javascript"></script>	<!-- Inacbg Bridging Script Source -->
            <script type="text/javascript" language="javascript">			
                function MM_reloadPage(init) {  //reloads the window if Nav4 resized
                    if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
                            document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
                    else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
                }
                MM_reloadPage(true);

                function MM_preloadImages() { //v3.0
                    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
                        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
                            if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
                    }

                    function MM_swapImgRestore() { //v3.0
                        var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
                    }

                    function MM_findObj(n, d) { //v4.01
                        var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                        if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                        for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                        if(!x && d.getElementById) x=d.getElementById(n); return x;
                    }

                    function MM_swapImage() { //v3.0
                        var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
                        if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
                    }
            </script>		
            <script type="text/javascript" charset="utf-8">
                    window.history.forward();
                    function noBack() { window.history.forward(); }
            </script>	
        </head>
        <body onload="noBack();tableHover();" onpageshow="if (event.persisted) noBack();" onunload="">
            <?php
            if (isset($_GET['popup'])) {
                include('shared/popup.php');
                die();
            }
            ?>		
			<div id="Layer1" style="position:absolute; left:500px; top:0; width:450px; height:11%; z-index:1; border: 1px none #000000;">
				<?php
				$home = 'home';
				$transaksi = 'transaksi';
				$report = 'report';
				$utility = 'utility';
				if(currentModul() == 'eksekutif report'){
					echo '&nbsp;';
				} else {
				?>
                <a href="index.php?menu=hm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','image/home1.png',1)"><div id="menu_utama" align="center">
                        <div><img src="image/home.png" name="Image3" width="35" height="35" border="0"><br><?php echo $home; ?>		
                        </div>
                    </div></a>	
		
                <a href="index.php?menu=tr" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','image/modul1.png',1)"><div id="menu_utama" align="center">
                        <div><img src="image/modul.png" name="Image5" width="35" height="35" border="0"><br><?php echo $transaksi; ?>		
                        </div>
                    </div></a>	

                <a href="index.php?menu=rp" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','image/report1.png',1)"><div id="menu_utama" align="center">
                        <div><img src="image/report.png" name="Image4" width="35" height="35" border="0"><br><?php echo $report; ?></div>                    
                    </div></a>			

                <a href="index.php?menu=tl" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','image/utility1.png',1)"><div id="menu_utama" align="center">
                        <div><img src="image/utility.png" name="Image6" width="35" height="35" border="0"><br><?php echo $utility; ?>			
                        </div>
                    </div></a>
				<?php } ?>
				<div>
				<table border="0">
					<tr><td style="color:#FFFFFF; font-size:17px; padding-top:15px; "><?php if(!empty($s_nama_unit) and (trim($s_nama_unit) != '/')) echo $s_nama_unit; ?></td></tr>
				</table>
				</div>	
            </div>
            <div style="left:0; right:0; top:0; height:100%; width:100%; position:absolute;">
                <div class="top">
                    <div id="top_logo1" align="center">&nbsp;</div>
                    <div id="top_logo" align="center"><table align="center" width="100%" height="98%" style=" position:relative; padding:0px"><tr><td><img src="image/logo.png" id="img" title="developer:katha.gandewa@gmail.com" alt="katha.gandewa@gmail.com"></td></tr></table></div>
                    <div id="top_nmcom" align="center">
                        <table width="50%" height="100%" style="position:absolute; " cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="bottom" style="font-size:12px; color:#FFFFFF; text-shadow:1px 1px 1px rgba(0,0,0,2); letter-spacing:0px;"><span><?php echo $app_title_hdr1; ?></span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="font-size:25px; color:#FFFFFF; text-shadow:1px 1px 1px rgba(0,0,0,2);"><?php echo $app_title_hdr2; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div id="top_quest1" align="center"></div>
                    <div id="top_quest" align="center">
                        <table height="20%" border="0" align="right" style="position:relative; ">
                            <tr>
								<td width="98%" style="color:#FFFFFF; font-size:15px; padding-right:5px; border-bottom-style:dotted; border-bottom-width:1px; border-left-color:#FFFFFF; " align="right" height="auto">
								<a href="index.php?logout=1" >logout&nbsp;<img src="image/logout.png" width="20" height="20"></a></td>
                                <td rowspan="4" width="2%" style="border-left-style:dotted; border-left-width:1px; border-left-color:#FFFFFF; ">&nbsp;</td>

                            </tr>
                            <tr>
                                <td width="98%" style="color:#FFFFFF; font-size:15px; padding-right:5px; border-bottom-style:dotted; border-bottom-width:1px; border-left-color:#FFFFFF; " align="right" height="auto"><?php echo $s_nama_user; ?>&nbsp;<img src="image/user.png" width="20" height="20"></td>
                            </tr>
                            <tr>
                                <td width="98%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="98%">&nbsp;</td>
                            </tr>			
                        </table>		
                    </div>	
                </div>
                <div class="list_top" align="center"></div>
                <div class="list_isi" align="center">
                    <div style="height:100% ">
                        <table border="0" width="100%" height="auto" align="center">
                            <tr>
                                <td width="0.5%">&nbsp;</td>
                                <td align="center" >
                                    <div style="width:100%; height:auto;" align="center">
                                        <?php
                                        if (currentModul() == 'kasir') {
                                            if ($_SESSION['SES_SIMRS_SHIFT'] == '') {
                                                ?>
												<script type="text/javascript" language="javascript">	
													window.open('index.php?popup=shift','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=300,height=200');
												</script>
												<?php
                                            }
										}	
                                        if (isset($_REQUEST['menu'])) {
                                            if ($_REQUEST['menu'] == 'hm') {
                                                   include('shared/home.php');
                                            } else {
                                                   include('shared/menu.php');
                                            }
                                        } else if (isset($_REQUEST['link'])) {
                                            include('shared/switch_page.php');
                                        } else {
                                            
											if (currentModul() == 'eksekutif report') {
                                                ?>
                                                <script language="JavaScript" type="text/javascript">
                                                        window.location='index.php?menu=tr';
                                                </script>
                                                <?php
                                            } else {
                                                include('shared/slide.php');
                                            }
											
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td width="0.5%">&nbsp;</td>
									
							
                        </table><br><br>
                    </div>
                </div>
                <div class="list_bottom" align="center">&nbsp;</div>
                <div class="bottom" >	
                    <table align="right" height="100%" cellpadding="0" cellspacing="0" style="margin-right:25px; color:#FFFFFF; text-shadow:1px 1px 1px rgba(0,0,0,2); ">
                        <tr>
                            <td><?php echo $app_title_ftr; ?></td>
                        </tr>
                    </table>
                </div>	
            </div>
        <audio id="myAudio" src="notif.mp3"></audio>        
        </body>
    </html>
<?php 
include('shared/message.php'); 
} if (!empty($msg_info)) { ?>
    <script language="javascript">
            alert('<?php echo $msg_info; ?>');
    </script>
<?php }
if(isset($_SESSION['SES_SIMRS_REG']) and currentModul() == 'rekam medik'){ ?>
<script type="text/javascript" src="script/scanner/jquery.scannerdetection.js" language="javascript"></script>
<script language="javascript" type="text/javascript">
 function kirim_nomr(xnomr){
	$.ajax({
		url: "index.php?ajaxrequest=tracerrm",
		type: "post",
		data: {
			nomr : xnomr
		},
		success: function (response) {
			if(response.trim() =='Ok'){
				window.location = "index.php?link=68e79f8d10554a8e118545868b8a661e";	
			}
		}
	}); 
 }
 
 jQuery(document).ready(function ($) {
    $(window).scannerDetection();
    $(window).bind('scannerDetectionComplete', function (e, data) {
	  kirim_nomr(data.string);
    })
    .bind('scannerDetectionError', function (e, data) {
      console.log('detection error ' + data.string);
    })
    .bind('scannerDetectionReceive', function (e, data) {
      console.log(data);
    })      
    $(window).scannerDetection('success');      
  });
</script>
<?php 
}
@mysql_close($connect); @mysql_close($connect_2); @mysql_close($connect_3); @mysql_close($connect_4);
@mysql_close($connect_5); @mysql_close($connect_6); @mysql_close($connect_7); @mysql_close($connect_8);
@mysql_close($connect_9);
?>
