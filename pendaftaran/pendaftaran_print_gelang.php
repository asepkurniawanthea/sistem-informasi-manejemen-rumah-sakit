<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Print</title>
        <link rel="stylesheet" media="screen" href="style/gelang.css" type="text/css">
            <link rel="stylesheet" media="print" href="style/gelang_print.css" type="text/css">
                </head>
                <body>
                    <div id="TopLayer" ><a href="Javascript:self.print()">Print</a></div>
                    <div id="TextLayer" align="left">
					<table border="0">
					  <tr><td rowspan="3" align="center"><img src="image/lOGOsitanala.jpg" witdh="70" height="70"></td><td colspan="2"><strong><?php echo $_GET['pasien']; ?></strong></td></tr>
					  <tr>
					    <td><?php echo $_GET['norm']; ?></td>
						<!--<td>&nbsp;&nbsp;<?php echo $_GET['tglmasuk']; ?></td>-->
					  </tr>
					  <tr>
					    <!--<td><?php echo $_GET['dokter']; ?></td>-->
						<!--<td>&nbsp;&nbsp;<?php echo $_GET['ruangan']; ?></td>-->
					  </tr>
					</table>
                    </div>
                </body>
                </html>
