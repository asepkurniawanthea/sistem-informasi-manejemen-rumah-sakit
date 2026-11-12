<?php
$tahun = Date('Y');
if (isset($_SESSION['reportkunjunganpasien_tahun']))
    $tahun = $_SESSION['reportkunjunganpasien_tahun'];

if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['reportkunjunganpasien_tahun'] = $_GET['tahun'];
}
?>
<script type="text/javascript" src="charts/FusionCharts.js"></script>	
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tahun</td>
            <td> <select name="tahun" id="tahun" style="width: 150px;" class="text_dt" >
                            <?php
                            $vtahun = 2014;
                            while ($vtahun <= 2020) {
                                ?>
                                <option value="<?php echo $vtahun; ?>"
                                        <?php if ($vtahun == $tahun) echo "selected='selected'"; ?> ><?php echo $vtahun; ?></option>
                                        <?php
                                        $vtahun++;
                                    }
                                    ?>
                        </select></td>
       </tr>
		<tr>
			<td>&nbsp;</td>
            <td><input type="submit" value="buka" class="myButton" />&nbsp;<a href="index.php?menu=tr" ><input type="button" value="tutup" class="myButton" /></a></td>	
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
if (!empty($tahun)) {

    $filename = 'report/data_report_bulanan_kunjungan_umum_' . getIpAddress() . '.xml';
    @unlink($filename);

    $strXML = '<graph xaxisname="BULAN" yaxisname="KUNJUNGAN" 
				hovercapbg="DEDEBE" hovercapborder="889E6D" 
				formatNumberScale="0"
				rotateNames="0" yAxisMaxValue="1000" numdivlines="9" 
				divLineColor="CCCCCC" divLineAlpha="80" decimalPrecision="0" 
				showAlternateHGridColor="1" AlternateHGridAlpha="30" 
				AlternateHGridColor="CCCCCC" caption="KUNJUNGAN PASIEN POLIKLINIK UMUM" subcaption="">';
	$strXML .= '<categories font="Arial" fontSize="11" fontColor="000000">
				<category name="Jan" hoverText="Januari"/>
				<category name="Peb" hoverText="Pebruari"/>
				<category name="Mar" hoverText="Maret"/>
				<category name="Apr" hoverText="April"/>
				<category name="Mei" hoverText="Mei"/>
				<category name="Jun" hoverText="Juni"/>
				<category name="Jul" hoverText="Juli"/>
				<category name="Agu" hoverText="Agustus"/>
				<category name="Sep" hoverText="September"/>
				<category name="Okt" hoverText="Oktober"/>
				<category name="Nop" hoverText="Nopember"/>
				<category name="Des" hoverText="Desember"/>
				</categories>';
	
    $strQuery = 'SELECT SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "01" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_1,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "01" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_1,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "02" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_2,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "02" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_2,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "03" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_3,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "03" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_3,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "04" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_4,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "04" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_4,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "05" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_5,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "05" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_5,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "06" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_6,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "06" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_6,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "07" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_7,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "07" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_7,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "08" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_8,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "08" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_8,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "09" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_9,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "09" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_9,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "10" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_10,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "10" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_10,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "11" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_11,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "11" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_11,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "12" AND t_irja.ST_BARU = "1" THEN 1 END) AS BARU_12,
						SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m")= "12" AND (t_irja.ST_BARU IS NULL OR t_irja.ST_BARU = "0" OR t_irja.ST_BARU = "") THEN 1 END) AS LAMA_12
				FROM t_irja 
				WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35
				AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y") = "' . $tahun . '"';
    $result = mysql_query($strQuery) or die(mysql_error());
    
	$strXML .= '<dataset seriesname="Pasien Baru" color="FDC12E">';
    $data0 = mysql_fetch_assoc($result);
	$l = 1;
	while ($l < 13) {
        $strXML .= '<set value="' . $data0['BARU_' . $l] . '"/>';
        $l++;
    }
	
	$strXML .= '</dataset><dataset seriesname="Pasien Lama" color="56B9F9">';
	
	mysql_data_seek($result, 0);
	$data1 = mysql_fetch_assoc($result);
	$l = 1;
	while ($l < 13) {
        $strXML .= '<set value="' . $data1['LAMA_' . $l] . '"/>';
        $l++;
    }
	$strXML .= '</dataset>';
    $strXML .= '</graph>';

    $handle = fopen($filename, 'x+');
    fwrite($handle, $strXML);
    fclose($handle);
    ?>
    </br>
    </br>
    <div id="chartContainer1">FusionCharts will load here!</div> 
    <script type="text/javascript">

        var myChart = new FusionCharts( "charts/FCF_MSColumn2D.swf", 
        "myChartId", "1024", "400", "0", "1" );
        myChart.setXMLUrl("<?php echo $filename; ?>");
        myChart.render("chartContainer1");      
    </script>      
<?php } ?>
