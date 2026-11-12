<?php
$irna_id = $_GET['idx'];

$pasien_pulang_id = '';
$ket_pasien_pulang = '';
$minta_rujukan = '';
$selesai = '';
$rujukan_unit_id = '';
$tempat_rujukan = '';
$lanjut_pengobatan = '';
$tanggal_kontrol = '';
$cara_dirawat = '';

$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%H") AS JAM_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%i") AS MENIT_KELUAR,
				t_irna.PASIEN_PULANG_ID,t_irna.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
				t_irna.KEADAAN_PULANG_ID,t_irna.TEMPAT_RUJUKAN,t_irna.LANJUT_PENGOBATAN,
				DATE_FORMAT(t_irna.TGL_KONTROL_POLIKLINIK,"%d/%m/%Y") AS TGL_KONTROL_POLIKLINIK,
				t_irna.KOMPLIKASI,t_irna.CARA_DIRAWAT
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$tanggal_pulang = $dat_pasien['TANGGAL_KELUAR'];
$pasien_pulang_id = $dat_pasien['PASIEN_PULANG_ID'];
$ket_pasien_pulang = $dat_pasien['KET_PASIEN_PULANG'];
$pasien_keadaan_pulang_id = $dat_pasien['KEADAAN_PULANG_ID'];
$lanjut_pengobatan = $dat_pasien['LANJUT_PENGOBATAN'];
$tempat_rujukan = $dat_pasien['TEMPAT_RUJUKAN'];
$tanggal_kontrol = $dat_pasien['TGL_KONTROL_POLIKLINIK'];
$komplikasi = $dat_pasien['KOMPLIKASI'];
$cara_dirawat = $dat_pasien['CARA_DIRAWAT'];
if($dat_pasien['NO_RAWAT'] != '') $selesai = '1';

$tgl_keluar = date('d/m/Y');
$jam_keluar = date('H');
$menit_keluar = date('i');

if(!empty($tanggal_pulang)){
	$tgl_keluar = $dat_pasien['TANGGAL_KELUAR'];
	$jam_keluar = $dat_pasien['JAM_KELUAR'];
	$menit_keluar = $dat_pasien['MENIT_KELUAR'];
}

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_status_pulang.php');

if (isset($_GET['idt']))
    include('rawatinap/ranap_del_terapi_pulang.php');

?>
<form name="search" id="search" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0" width="90%">
		  <tr>
            <td width="20%">Tanggal Keluar</td>
            <td width="30%"><input type="text" name="tgl_keluar" id="tgl_1" class="text_dt" value="<?php echo $tgl_keluar; ?>" size="10" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
			<select name="jam_keluar" id="jam_keluar" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_keluar); ?>
			</select>
			<select name="menit_keluar" id="menit_keluar" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_keluar); ?>
			</select>	</td>
			<td width="20%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>
		<tr>
            <td width="20%">Cara Keluar</td>
            <td width="30%">
                <select name="pasien_pulang_id" id="pasien_pulang_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPulangRanap($pasien_pulang_id); ?>
                </select>
            </td>
			<td width="20%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>
		<tr>
            <td width="20%">Keadaan Keluar</td>
            <td width="30%">
                <select name="pasien_keadaan_pulang_id" id="pasien_keadaan_pulang_id" style="width:240px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getKeadaanPulangRanap($pasien_keadaan_pulang_id); ?>
                </select>
            </td>
			<td width="20%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>
		<tr>
            <td width="20%">Tempat Rujukan</td>
            <td width="30%"><input type="text" name="tempat_rujukan" value="<?php echo $tempat_rujukan; ?>" size="57" class="text_dt"  /></td>
			<td width="20%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>
		<tr>
			<td>Keterangan</td>
            <td colspan="3"><textarea name="ket_pasien_pulang" class="text_dt3" ><?php echo $ket_pasien_pulang; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" align="right"><?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
			<input type="checkbox" name="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } 
			if($irna_final == '' or $_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" /><?php } ?></td>
		</tr>
    </table>
</form>
<script languange="javascript" >
	function add_diagnosa(idx){
		window.open('index.php?popup=ranapformdiagnosa&idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250');
		return false;
	}
	
	function add_terapi(idx){
		window.open('index.php?popup=ranapformterapipulang&idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250');
		return false;
	}
	
	function fr_sebab_kematian(id){
		if(id == 3){
			MyAjaxRequest('form_sebab_kematian','index.php?ajaxrequest=formsebabkematian&id=' + id);
		}
		return false;
	}
	
	function add_diagnosa_hapus(idx){
		window.open('index.php?popup=ranapformhapusdiagnosa&idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250');
		return false;
	}
	
	function simpan(){
		_haschange = false;
		$('#search').submit();
	}	
</script>