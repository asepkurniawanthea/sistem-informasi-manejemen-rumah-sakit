<?php if(isset($_GET['img'])){ 

$path = 'http://192.168.1.5/get_image/index.php?img=' . $_GET['img'];
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

echo '<br>';
echo '<br>';
echo '<img src="' . $base64 . '" width="1024px;">';
				
} ?>