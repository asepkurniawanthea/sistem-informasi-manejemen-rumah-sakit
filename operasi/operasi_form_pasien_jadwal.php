<?php
if (isset($_POST['operasi_id']))
    include('operasi/operasi_save_jadwal.php');
	
if(isset($_GET['idx'])){
$ord = $_GET['ord'];
if($ord == 'IRJ'){
	$qry_jadwal = 'SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,t_operasi.RAWAT_ID,
				m_pegawai.NAMA_PEGAWAI,t_operasi.JNS_ORDER,t_operasi.UNIT_ID,
				t_operasi.TANGGAL_ORDER AS F_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,m_pasien.JNS_KELAMIN,
				m_pasien.NIK,t_operasi.PEGAWAI_PELAKSANA_ID,
				DATE_FORMAT(t_operasi.TANGGAL_RENCANA_OPERASI,"%d/%m/%Y") AS TANGGAL_RENCANA_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%i") AS MENIT_OPERASI
				FROM t_operasi
				INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_operasi.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'IRN'){
	$qry_jadwal = 'SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				t_operasi.RAWAT_ID,
				m_pegawai.NAMA_PEGAWAI,t_operasi.JNS_ORDER,t_operasi.RUANG_ID AS UNIT_ID,
				t_operasi.TANGGAL_ORDER AS F_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,m_pasien.JNS_KELAMIN,
				m_pasien.NIK,t_operasi.PEGAWAI_PELAKSANA_ID,
				DATE_FORMAT(t_operasi.TANGGAL_RENCANA_OPERASI,"%d/%m/%Y") AS TANGGAL_RENCANA_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%i") AS MENIT_OPERASI
				FROM t_operasi
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_operasi.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'APS'){
	$qry_jadwal = 'SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,t_operasi.ALAMAT,
				t_operasi.INSTANSI_PENGIRIM AS NAMA_UNIT,"" AS RAWAT_ID,
				t_operasi.PENGIRIM AS NAMA_PEGAWAI,t_operasi.JNS_ORDER,"" AS UNIT_ID,
				t_operasi.TANGGAL_ORDER AS F_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,t_operasi.JNS_KELAMIN,
				m_pasien.NIK,t_operasi.PEGAWAI_PELAKSANA_ID,
				DATE_FORMAT(t_operasi.TANGGAL_RENCANA_OPERASI,"%d/%m/%Y") AS TANGGAL_RENCANA_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%i") AS MENIT_OPERASI
				FROM t_operasi
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $_GET['idx'] . '"';
}	
$get_jadwal = mysql_query($qry_jadwal) or die(mysql_error());
$dat_jadwal = mysql_fetch_assoc($get_jadwal);
$nomr = $dat_jadwal['NOMR'];
$nama_pasien = $dat_jadwal['NAMA_PASIEN'];
$tgl_lahir = $dat_jadwal['TGL_LAHIR'];
$jns_kelamin = $dat_jadwal['JNS_KELAMIN'];
$alamat = $dat_jadwal['ALAMAT'];
$nik = $dat_jadwal['NIK'];

$operasi_id = $dat_jadwal['OPERASI_ID'];
$pegawai_operasi_id = $dat_jadwal['PEGAWAI_PELAKSANA_ID'];

$tgl_rencana_operasi = $dat_jadwal['TANGGAL_RENCANA_OPERASI'];
$tgl_operasi = $dat_jadwal['TANGGAL_OPERASI'];
$tgl_order = $dat_jadwal['TANGGAL_ORDER'];
$jam_operasi = $dat_jadwal['JAM_OPERASI'];
$menit_operasi = $dat_jadwal['MENIT_OPERASI'];

$dokter_pengirim = $dat_jadwal['NAMA_PEGAWAI'];
$instansi_pengirim = $dat_jadwal['NAMA_UNIT'];
$unit_id = $dat_jadwal['UNIT_ID'];

$umur = getUmurDaftar($tgl_lahir,$tgl_order);
?>
<div style=" height:auto; padding:15px;">
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
	<input type="hidden" name="ord" id="ord" value="<?php echo $ord; ?>" />
	<input type="hidden" name="unit_id" id="unit_id" value="<?php echo $unit_id; ?>" />
	
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
       <?php include('pasien/pasien_view_short.php'); ?>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dokter_pengirim; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $instansi_pengirim; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Instansi Pengirim</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Rencana Operasi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_rencana_operasi; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pelaksana Operasi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="pegawai_operasi_id" id="pegawai_operasi_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($pegawai_operasi_id); ?>
                </select></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Operasi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="text" name="tgl_operasi" id="tgl_1" size="15" class="text_dt" value="<?php echo $tgl_operasi; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jam Operasi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="jam_operasi" id="jam_operasi" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_operasi); ?>
			</select>
			<select name="menit_operasi" id="menit_operasi" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_operasi); ?>
			</select></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
    </div>
	
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; " align="right">
		<input type="submit" value="simpan" class="myButton1" />
    </div>       
   
</form>

</div>
<?php } ?>