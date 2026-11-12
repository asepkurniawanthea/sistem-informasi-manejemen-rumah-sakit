<!doctype html>
<html>
<head>
    <title><?php echo $app_title_brw; ?></title>
    <link href="image/logo.png" rel="shortcut icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width" />
    <style type="text/css" media="screen">
        html, body	{ height:100%; }
        body { margin:0; padding:0; overflow:auto; }
        #flashContent { display:none; }
    </style>

    <link rel="stylesheet" type="text/css" href="flexpaper/css/flexpaper.css" />
    <script type="text/javascript" src="flexpaper/js/jquery.min.js"></script>
    <script type="text/javascript" src="flexpaper/js/flexpaper.js"></script>
    <script type="text/javascript" src="flexpaper/js/flexpaper_handlers.js"></script>
</head>
<body>
<div style="position:absolute;left:10px;top:10px;">
<div id="documentViewer" class="flexpaper_viewer" style="width:1200px;height:600px"></div>

<script type="text/javascript">
    function getDocumentUrl(document){
        return "php/services/view.php?doc={doc}&format={format}&page={page}".replace("{doc}",document);
    }

    var startDocument = "Paper";

    $('#documentViewer').FlexPaperViewer(
            { config : {

                SWFFile : 'flexpaper/docs/<?php echo $_GET['nomr'] . '_' . $_GET['file']; ?>.swf',

                Scale : 0.6,
                ZoomTransition : 'easeOut',
                ZoomTime : 0.5,
                ZoomInterval : 0.2,
                FitPageOnLoad : true,
                FitWidthOnLoad : true,
                FullScreenAsMaxWindow : false,
                ProgressiveLoading : false,
                MinZoomSize : 0.2,
                MaxZoomSize : 5,
                SearchMatchAll : false,
                InitViewMode : 'Portrait',
                RenderingOrder : 'flash',
                StartAtPage : '',

                ViewModeToolsVisible : true,
                ZoomToolsVisible : true,
                NavToolsVisible : true,
                CursorToolsVisible : true,
                SearchToolsVisible : true,
                WMode : 'window',
                localeChain: 'en_US',
				PrintEnabled: false,
				PrintToolsVisible: false
            }}
    );
</script>
</div>
</div>
</body>
</html>