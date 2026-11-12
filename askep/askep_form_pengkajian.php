<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id']))
    include('askep/askep_save_pengkajian.php');

$irna_id = $_GET['idx'];
?>
<script>
jQuery(document).ready(function(){
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab_content:first").show(); //Show first tab content
	//On Click Event
	jQuery("ul.tabs li").click(function() {
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("span").attr("id"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
	
	jQuery(".tab_content3").hide(); //Hide all content
	jQuery("ul.tabs3 li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab_content3:first").show(); //Show first tab content
	//On Click Event
	jQuery("ul.tabs3 li").click(function() {
		jQuery("ul.tabs3 li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(".tab_content3").hide(); //Hide all tab content
		var activeTab = jQuery(this).find("span").attr("id"); //Find the rel attribute value to identify the active tab + content
		jQuery(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
});
</script>
<style type="text/css">
ul.tabs {margin: 0;padding: 0;float: left;list-style: none;height: 32px;border-bottom: 1px solid #999;border-left: 1px solid #999;width: 100%;}
ul.tabs li {float: left;margin: 0;padding: 0 3px;height: 31px;line-height: 31px;border: 1px solid #999;border-left: none;margin-bottom: -1px;background: #e0e0e0;overflow: hidden;position: relative;}
ul.tabs li:hover{ background:#FF9; display:block; cursor:pointer;}
ul.tabs li a {text-decoration: none;color: #000;display: block;font-size: 10px;padding: 0 10px;border: 1px solid #fff;outline: none;}
ul.tabs li a:hover {background: #ccc;}	
html ul.tabs li.active, html ul.tabs li.active a:hover  {background: #fff;border-bottom: 1px solid #fff;}
.tab_container {border: 1px solid #999;	border-top: none;clear: both;float: left; width: 100%;background: #fff;	-moz-border-radius-bottomright: 5px;-khtml-border-radius-bottomright: 5px;	-webkit-border-bottom-right-radius: 5px;-moz-border-radius-bottomleft: 5px;	-khtml-border-radius-bottomleft: 5px;	-webkit-border-bottom-left-radius: 5px; padding-top:30px;}
.tab_content {padding: 5px;font-size: 11px; text-align:left;}

ul.tabs3 {margin: 0;padding: 0;float: left;list-style: none;height: 32px;border-bottom: 1px solid #999;border-left: 1px solid #999;width: 100%;}
ul.tabs3 li {float: left;margin: 0;padding: 0 3px;height: 31px;line-height: 31px;border: 1px solid #999;border-left: none;margin-bottom: -1px;background: #e0e0e0;overflow: hidden;position: relative;}
ul.tabs3 li:hover{ background:#FF9; display:block; cursor:pointer;}
ul.tabs3 li a {text-decoration: none;color: #000;display: block;font-size: 10px;padding: 0 10px;border: 1px solid #fff;outline: none;}
ul.tabs3 li a:hover {background: #ccc;}	
html ul.tabs3 li.active, html ul.tabs3 li.active a:hover  {background: #fff;border-bottom: 1px solid #fff;}
.tab_container3 {border: 1px solid #999;	border-top: none;clear: both;float: left; width: 100%;background: #fff;	-moz-border-radius-bottomright: 5px;-khtml-border-radius-bottomright: 5px;	-webkit-border-bottom-right-radius: 5px;-moz-border-radius-bottomleft: 5px;	-khtml-border-radius-bottomleft: 5px;	-webkit-border-bottom-left-radius: 5px; padding-top:5px;}
.tab_content3 {padding: 5px;font-size: 11px; text-align:left;}
</style>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <!--start content-->
	<div align="center">
        <div align="right" style="margin:0px;">
		<ul class="tabs">
    		<li><span id="#101">Data Umum Pasien</span></li>
			<li><span id="#102">Diagnosa Pasien</span></li>
			<li><span id="#103">Perawat Penanggungjawab</span></li>
			<li><span id="#104">Status Keperawatan Pasien</span></li>
			<li><span id="#105">Status Kesehatan Pasien</span></li>
			<li><span id="#106">Riwayat Kesehatan Keluarga</span></li>
			<li><span id="#107">Riwayat Tumbuh Kembang</span></li>
			<li><span id="#108">Status Fisiologis</span></li>
			<li><span id="#109">Psikologis</span></li>
    	</ul>
        <div class="tab_container">
			<div id="101" class="tab_content">
			Content
			</div>
			<div id="102" class="tab_content">
			Content 2	
			</div>
			<div id="103" class="tab_content">
			Content 3
			</div>
			<div id="104" class="tab_content">
			<!--Content 4-->
			<?php include('askep/askep_form_pengkajian_status_keperawatan.php'); ?>
			</div>
			<div id="105" class="tab_content">
			Content 5
			</div>			
			<div id="106" class="tab_content">
			Content 6
			</div>			
			<div id="107" class="tab_content">
			Content 7
			</div>
			<div id="108" class="tab_content">
			Content 8
			</div>
			<div id="109" class="tab_content">
			Content 9
			</div>
	 
			<!--<div id="101" class="tab_content3">-->
				<ul class="tabs">
					<li><span id="#110">Sosial</span></li>
					<li><span id="#111">Budaya</span></li>
					<li><span id="#112">Spiritual</span></li>
					<li><span id="#113">Kebutuhan Edukasi Pasien</span></li>
					<li><span id="#114">Pola Kebiasaan</span></li>
					<li><span id="#115">Hasil Pemeriksaan</span></li>
					<li><span id="#116">Prioritas Resiko Masalah</span></li>
					<li><span id="#119">Tindakan Medis</span></li>
					<li><span id="#117">Alasan Alih Rawat Internal</span></li>
					<li><span id="#118">Alasan Rujuk Eksternal</span></li>
				</ul>
			<div class="tab_container">
			<div id="110" class="tab_content">
			Content 10  
			</div>
			<div id="111" class="tab_content">
			Content 11
			</div>
			<div id="112" class="tab_content">
			Content 12   
			</div>
			<div id="113" class="tab_content">
			Content 13  
			</div>
			<div id="114" class="tab_content">
			Content 14
			</div>
			<div id="115" class="tab_content">
			Content 15
			</div>
			<div id="116" class="tab_content">
			Content 16
			</div>
			<div id="117" class="tab_content">
			Content 17
			</div>
			<div id="118" class="tab_content">
			Content 18
			</div>
			<div id="119" class="tab_content">
			Content 19
			</div>
			</div>
		</div>
		</div>
		</div>
		</div>
	<!--end content-->
	<br clear="all" />
	<table width="100%" >
      <tr>
            <td colspan="12" align="right">&nbsp;
			<input type="checkbox" name="selesai" value="1" />Selesai&nbsp;&nbsp;&nbsp;
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<input type="button" name="print" value="print" class="myButton1" /></td>	
      </tr>
	</table>
</form>