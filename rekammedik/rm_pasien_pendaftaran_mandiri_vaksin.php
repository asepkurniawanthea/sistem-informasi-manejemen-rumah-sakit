<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_1']))
    $tgl_1 = $_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_1']))
    $tgl_2 = $_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearch_pendaftaran_mandiri_vaksin_tgl_2'] = $_GET['tgl_2'];
}

$nama = '';
if (isset($_SESSION['rmsearch_pendaftaran_mandiri_vaksin_nama']))
		$nama = $_SESSION['rmsearch_pendaftaran_mandiri_vaksin_nama'];

if (isset($_GET['nama'])) {
    $nama = $_GET['nama'];
	$_SESSION['rmsearch_pendaftaran_mandiri_vaksin_nama'] = $nama;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nama/ No KTP/ No Telepon</td>
			<td><input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" size="30" class="text_dt" /></td>	
            <td colspan="3">
				&nbsp;
			</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>&nbsp;</td>
			<td><input name="submit" type="submit" class="myButton" value="cari" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>	
            <td align="right" colspan="3">
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());	
$qry_kunjungan = 'SELECT d.DAFTAR_ID,
	d.CUSTOMER_ID,
	d.MEMBER_ID,
	d.NAMA_PASIEN,
	d.TMP_LAHIR,
	DATE_FORMAT(d.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	d.JNS_KELAMIN,
	d.ALAMAT,
	d.PEKERJAAN,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	d.NO_CONTACT,
	d.NIK,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.ST_SELESAI,
	d.REGISTER
	FROM t_daftar_vaksin_online d
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . 
	' AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2;
	
if (!empty($nama)) {
    $qry_kunjungan = $qry_kunjungan . ' AND CONCAT(d.NAMA_PASIEN,d.NO_CONTACT,d.NIK) LIKE "%' . $nama . '%"';
}
$qry_kunjungan = $qry_kunjungan . ' ORDER BY d.NAMA_PASIEN';

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&nama=' . $nama;
$action = '';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
        <th colspan="2">Tanggal</th>
        <th rowspan="2">Nama</th>
		<th rowspan="2">Tmp Lahir</th>
        <th rowspan="2">Tgl Lahir</th>
        <th rowspan="2">Jns Kelamin</th>
        <th rowspan="2">Alamat</th>
		<th rowspan="2">No Telepon</th>
		<th rowspan="2">No KTP</th>
		<th rowspan="2">Pekerjaan</th>
		<th rowspan="2">Register</th>
		<th rowspan="2">Option</th>
    </tr>
    <tr>
		<th>Daftar<br />Online </th>		
		<th>Rencana<br />Divaksin</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['DAFTAR_ID'];
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['TGL_RENCANA_KUNJUNGAN']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['TMP_LAHIR']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
			<td><?php $no_telepon = $data['NO_CONTACT'];
				$no_telepon_baru = '';
				if(strlen($no_telepon) >= 10){
					if(substr($no_telepon,0,2) == '08'){
						$no_telepon_baru = '628' . substr($no_telepon,2,strlen($no_telepon) - 2);
					}else if(substr($no_telepon,0,4) == '+628'){
						$no_telepon_baru = substr($no_telepon,1,strlen($no_telepon) - 1);	
					}else{
						$no_telepon_baru = $no_telepon;
					}	
				}	
				if(substr($no_telepon_baru,0,3) == '628'){
					echo '<div onclick="openwhatsapp(' . $no_telepon_baru . ');"><img src="image/whatsapp.png" width="15" height="15" style="float:left;">&nbsp;' . $no_telepon . '</div>';	
				}else{
					echo $no_telepon;
				} ?></td>
			<td><?php echo $data['NIK']; ?></td>	
			<td><?php echo $data['PEKERJAAN']; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
			<td align="center">
			<div id="sel_<?php echo $data['DAFTAR_ID'] ;?>">
			<?php if($data['ST_SELESAI'] == ''){ ?>
			<a href="#" onclick="selesai_vaksin(<?php echo $data['DAFTAR_ID'] ;?>,'<?php echo $data['NAMA_PASIEN'] ;?>');">selesai_vaksin</a>
			<?php } ?>	
			</div>
			</td>
        </tr>
        <?
    }
    ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>	
		<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
            <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
            <input type="hidden" name="nama" value="<?php echo $nama; ?>" />
            <input type="hidden" name="xlsfile" value="rekammedik/xls_pasien_pendaftaran_mandiri_vaksin.php" />
            <input type="hidden" name="xlsname" value="rpt_pasien_pendaftaran_mandiri_vaksin.xls" />            
        </form>
<script language="javascript">
function openwhatsapp(phone){
	window.open('https://wa.me/' + phone);
}	

function selesai_vaksin(id,nama){
	if(confirm(nama + " Selesai Vaksin ?")){
		_div = 'sel_' + id;
		MyAjaxRequest(_div,'index.php?ajaxrequest=selesaivaksin&id=' + id);
		return false;
		
		alert('Simpan Data Berhasil.');
	}
}
</script>			