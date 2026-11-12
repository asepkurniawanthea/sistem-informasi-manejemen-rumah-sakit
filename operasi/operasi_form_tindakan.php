<?php 
$operasi_id = $_GET['idx'];

if (isset($_POST['operasi_id']))
    include('operasi/operasi_save_tindakan.php');

if (isset($_GET['idk']))
    include('operasi/operasi_del_add_tindakan.php');

$operasi_id = $_GET['idx'];
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
?>
<form name="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('operasi/operasi_tmp_tindakan.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			Pelaksana&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			Tanggal&nbsp;&nbsp;
			<input type="text" name="tanggal" id="tgl_3" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>&nbsp;&nbsp;	
			<a href="#" onclick="window.open('index.php?popup=operasiformtindakan&idx=<?php echo $operasi_id; ?>&kelas=<?php echo $kelas_rawat; ?>&pegawai=<?php echo $pegawai_id; ?>&grp=58','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas_rawat; ?>" />
			<input type="hidden" name="kelas_jaminan" value="<?php echo $kelas_jaminan; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		</table>
</form>