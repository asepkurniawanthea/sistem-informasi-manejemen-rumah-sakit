<?php
if(isset($_POST['pasien']) and isset($_POST['nophoto']) and isset($_FILES['file'])){ 

$pasien = $_POST['pasien'];
$nophoto = $_POST['nophoto'];

$filename = $_FILES['file']['name'];

if(!file_exists('original/' . $pasien)){
	mkdir('original/' . $pasien, 0700, true);
	mkdir('original/' . $pasien . '/' . $nophoto, 0700, true);
}else{
	if(!file_exists('original/' . $pasien . '/' . $nophoto)){
		mkdir('original/' . $pasien . '/' . $nophoto, 0700, true);
	}
}

if(!file_exists('thumbnail/' . $pasien)){
	mkdir('thumbnail/' . $pasien, 0700, true);
	mkdir('thumbnail/' . $pasien . '/' . $nophoto, 0700, true);
}else{
	if(!file_exists('thumbnail/' . $pasien . '/' . $nophoto)){
		mkdir('thumbnail/' . $pasien . '/' . $nophoto, 0700, true);
	}
}

move_uploaded_file($_FILES['file']['tmp_name'], 'original/' . $pasien . '/' . $nophoto . '/' . $filename);

$thumbnail_width = 154;
$thumbnail_height = 189;

$arr_image_details = getimagesize('original/' . $pasien . '/' . $nophoto . '/' . $filename); 
$original_width = $arr_image_details[0];
$original_height = $arr_image_details[1];

if ($original_width > $original_height) {
    $new_width = $thumbnail_width;
    $new_height = intval($original_height * $new_width / $original_width);
} else {
    $new_height = $thumbnail_height;
    $new_width = intval($original_width * $new_height / $original_height);
}

$dest_x = intval(($thumbnail_width - $new_width) / 2);
$dest_y = intval(($thumbnail_height - $new_height) / 2);

$old_image = ImageCreateFromJPEG('original/' . $pasien . '/' . $nophoto . '/' . $filename);
$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
ImagePNG($new_image, 'thumbnail/' . $pasien . '/' . $nophoto . '/' . $filename);
}
?>