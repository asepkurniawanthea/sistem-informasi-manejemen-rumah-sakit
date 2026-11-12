<style>
.list_isi{
	height:550px;
}
</style>
<div class="rotator" style="top:25px; ">
    <?php
    $dir = $app_path . '/' . $site . '/image_slide';
    $dh = opendir($dir);
    $x = 1;
    while (false !== ($filename = readdir($dh))) {
        if ($x > 2) {
            if (file_exists('image_slide/' . $filename))
                echo '<img src="image_slide/' . $filename . ' " height="500" width="900"/>';
        }
        $x++;
    }
    ?>
</div>
<script type="text/javascript" language="javascript">
    $('.rotator').cycle({
        fx: 'fade',
        timeout: 6000
    });
</script>	