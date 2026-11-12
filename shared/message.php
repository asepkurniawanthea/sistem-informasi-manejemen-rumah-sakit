<?php if(!isset($_SESSION['SES_SIMRS_MESSAGE'])){ 
$sql_message = 'SELECT DISTINCT db_repository.msg_broadcast.TIME_SEND,db_repository.msg_broadcast.CONTENT_MESSAGE
				FROM db_repository.msg_broadcast
				WHERE db_repository.msg_broadcast.APP_ID = "1"
				AND db_repository.msg_broadcast.MODUL_ID = "' . $_SESSION['SES_SIMRS_MODUL_ID'] . '"
				AND (db_repository.msg_broadcast.ST_MESSAGE IS NULL 
				OR db_repository.msg_broadcast.ST_MESSAGE = "")
				ORDER BY db_repository.msg_broadcast.TIME_SEND ASC';
$get_message = mysql_query($sql_message) or die(mysql_error());
if(mysql_num_rows($get_message) > 0){				
?>
<script type="text/javascript" src="script/toastr.js" language="javascript"></script>
<link type="text/css" href="style/toastr.css" rel="stylesheet" />
<script type="text/javascript">
<?php while($dat_message = mysql_fetch_array($get_message)){ ?>
	toastr.info('<?php echo $dat_message['CONTENT_MESSAGE']; ?>', '', {timeOut: 30000});
<?php } ?>
</script>
<?php }
$_SESSION['SES_SIMRS_MESSAGE'] = 'toastr';
}
?>
<!--
<?php
if(currentModul() == 'rawat inap' or currentModul() == 'klinik' or currentModul() == 'igd'
	or currentModul() == 'hemodialisa' or currentModul() == 'kamar operasi'){ ?>
<script type="text/javascript" src="script/toastr.js" language="javascript"></script>
<link type="text/css" href="style/toastr.css" rel="stylesheet" />
<script language="javascript">
setInterval(function(){
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/notif/index.php?notif=hasillabkritis',
			data: { unit : '<?php echo currentModul(); ?>'},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					toastr.remove();
					var arrData = JSON.parse(data);
					for (var i = 0; i < arrData.length; i++) {
						var counter = arrData[i];
						toastr.info('NOMR : ' + counter.NMR + '<br />TANGGAL : ' + counter.TGL, 'Hasil Laboratorium Kritis', {timeOut: 30000});
					}	
				}	
			},});
	},5000);
</script>					
<?php					
} ?>
-->
<?php if(currentModul() == 'igd'){ ?>
<script type="text/javascript" src="script/toastr.js" language="javascript"></script>
<link type="text/css" href="style/toastr.css" rel="stylesheet" />
<script language="javascript">
setInterval(function(){
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/notif/index.php?notif=daftarrawatinap',
			data: { unit : '<?php echo currentModul(); ?>'},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					toastr.remove();
					var arrData = JSON.parse(data);
					for (var i = 0; i < arrData.length; i++) {
						var counter = arrData[i];
						toastr.info('NOMR : ' + counter.NMR, counter.MSG, {timeOut: 3000});
					}	
				}	
			},});
	},120000);
</script>					
<?php					
} 
?>

<?php if(currentModul() == 'pendaftaran'){ ?>
<script type="text/javascript" src="script/toastr.js" language="javascript"></script>
<link type="text/css" href="style/toastr.css" rel="stylesheet" />
<script language="javascript">
setInterval(function(){
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/notif/index.php?notif=rencanajaminan',
			data: { unit : '<?php echo currentModul(); ?>'},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					toastr.remove();
					var arrData = JSON.parse(data);
					for (var i = 0; i < arrData.length; i++) {
						var counter = arrData[i];
						toastr.info('NOMR : ' + counter.NMR, counter.MSG, {timeOut: 3000});
					}	
				}	
			},});
	},120000);
</script>					
<?php					
} 
?>

<?php if(currentModul() == 'laboratorium'){ ?>
<script type="text/javascript" src="script/toastr.js" language="javascript"></script>
<link type="text/css" href="style/toastr.css" rel="stylesheet" />
<script language="javascript">
setInterval(function(){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/notif/index.php?notif=orderlaboratorium',
		data: { unit : '<?php echo currentModul(); ?>'},
		cache: false,
		success: function(data) {
		if (data.length > 0){
			toastr.remove();
			var arrData = JSON.parse(data);
			for (var i = 0; i < arrData.length; i++) {
				var counter = arrData[i];
				toastr.info('NOMR : ' + counter.NMR, counter.MSG, {timeOut: 5000});
			}	
			var xaudio = document.getElementById('myAudio');
			xaudio.play();	
		}	
	},});
},10000);	
</script>					
<?php					
}
?>