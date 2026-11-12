<?php
if (isset($_GET['idx'])) {
	$irna_id = $_GET['idx'];
    $sql_rawat = 'SELECT t_irna.NOMR,t_irna.IRNA_ID,t_irna.TANGGAL_DAFTAR,t_irna.RUANG_ID,
					t_irna.JENIS_BAYAR_ID,t_irna.P_JAWAB_NAMA,t_irna.P_JAWAB_NO_TELP,t_irna.P_JAWAB_ALAMAT,
					t_irna.P_JAWAB_ALAMAT_RT,t_irna.P_JAWAB_ALAMAT_RW,t_irna.P_JAWAB_KELURAHAN_ID,t_irna.P_JAWAB_KECAMATAN_ID,
					t_irna.P_JAWAB_KOTA_ID,t_irna.P_JAWAB_PROPINSI_ID,t_irna.P_JAWAB_HUBUNGAN,m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,
					m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,
					t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.DIAGNOSA_AWAL,t_irna.NO_TMP_TIDUR
					FROM t_irna
					LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_kelurahan ON (t_irna.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
					LEFT JOIN m_kecamatan ON (t_irna.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
					LEFT JOIN m_propinsi ON (t_irna.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
					LEFT JOIN m_kota ON (t_irna.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) WHERE IRNA_ID = "' . $irna_id . '"';
    $get_rawat = mysql_query($sql_rawat);
    $dat_rawat = mysql_fetch_assoc($get_rawat);

    $nomr = $dat_rawat['NOMR'];
	$ruang_id = $dat_rawat['NAMA_RUANG'];
    $jenis_bayar_id = $dat_rawat['NAMA_JAMINAN'];
	$tanggal_daftar = $dat_rawat['TANGGAL_DAFTAR'];
	$dokter = $dat_rawat['NAMA_PEGAWAI'];
	$no_peserta = $dat_rawat['NO_PESERTA'];
	$no_sep = $dat_rawat['NO_SEP'];
	$no_sjp = $dat_rawat['NO_SJP'];
	$diagnosa_awal = $dat_rawat['DIAGNOSA_AWAL'];
	$tmp_tidur = $dat_rawat['NO_TMP_TIDUR'];
		
    $p_jawab_nama = $dat_rawat['P_JAWAB_NAMA'];
    $p_jawab_no_telp = $dat_rawat['P_JAWAB_NO_TELP'];
    $p_jawab_alamat = $dat_rawat['P_JAWAB_ALAMAT'];
    $p_jawab_alamat_rt = $dat_rawat['P_JAWAB_ALAMAT_RT'];
    $p_jawab_alamat_rw = $dat_rawat['P_JAWAB_ALAMAT_RW'];
    $p_jawab_kelurahan_id = $dat_rawat['NAMA_KELURAHAN'];
    $p_jawab_kecamatan_id = $dat_rawat['NAMA_KECAMATAN'];
    $p_jawab_kota_id = $dat_rawat['NAMA_KOTA'];
    $p_jawab_propinsi_id = $dat_rawat['NAMA_PROPINSI'];
    $p_jawab_hubungan = $dat_rawat['P_JAWAB_HUBUNGAN'];
       
    $sql_pasien = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
				m_pasien.AGAMA_ID,m_pasien.PENDIDIKAN_ID,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_pasien.KELURAHAN_ID,
				m_pasien.KECAMATAN_ID,m_pasien.KOTA_ID,m_pasien.PROPINSI_ID,m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,
				m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
				FROM m_pasien
				  LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				  LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) WHERE m_pasien.NOMR = "' . $nomr . '"';
    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tmp_lahir = $dat_pasien['TMP_LAHIR'];
    $tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $st_kawin = $dat_pasien['ST_KAWIN'];
    $agama_id = $dat_pasien['NAMA_AGAMA'];
    $pendidikan_id = $dat_pasien['NAMA_PENDIDIKAN'];
    $pekerjaan_id = $dat_pasien['PEKERJAAN'];
    $alamat = $dat_pasien['ALAMAT'];
    $alamat_rt = $dat_pasien['ALAMAT_RT'];
    $alamat_rw = $dat_pasien['ALAMAT_RW'];
    $kelurahan_id = $dat_pasien['NAMA_KELURAHAN'];
    $kecamatan_id = $dat_pasien['NAMA_KECAMATAN'];
    $kota_id = $dat_pasien['NAMA_KOTA'];
    $propinsi_id = $dat_pasien['NAMA_PROPINSI'];
    $kode_pos = $dat_pasien['KODE_POS'];
    $no_telepon = $dat_pasien['NO_TELEPON'];
    $nama_ibu = $dat_pasien['NAMA_IBU'];
    $nama_ayah = $dat_pasien['NAMA_AYAH'];
    $nama_suami_isteri = $dat_pasien['NAMA_SUAMI_ISTERI'];
    $nik = $dat_pasien['NIK'];
    $khusus = $dat_pasien['KHUSUS'];
    ?>
	<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
		
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $ruang_id; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left"><?php echo $dokter; ?></div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br>            
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $tmp_tidur; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
			
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $jenis_bayar_id; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php 
					if ($no_peserta=='') {
						echo "-";
					}else {					
						echo $no_peserta; 
					}
				?>
			</div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>            
        
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $no_sep; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left"><?php echo $no_sjp; ?></div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor SJP</div><br><br>           
       
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa Awal</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:750px; float:left; text-indent:25px; " align="left"><?php echo $diagnosa_awal; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br> 
		</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;"> 
			
        <?php
        include('pasien/pasien_view.php');
        ?>
	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">        
        <?php
        include('pendaftaran/pendaftaran_view_pjawab.php');
        ?>
  	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
		<?php $link = 'pendaftaranbarurawatinap'; ?>
        <a href="index.php?link=<?php echo md5($link); ?>" ><input type="button" value="tutup" class="myButton" /></a>
        <a href="#" onclick="javascript : cetak_gelang();return false;" ><input type="button" value="cetak gelang pasien" class="myButton1" /></a>
    </div>
	</div>
<?php
function ubahDateFormat($originalDate) {
    $date = new DateTime($originalDate);
    return $date->format('d M Y');
}
$rm1=substr($nomr,0,2);
$rm2=substr($nomr,2,2);
$rm3=substr($nomr,4,2);

$nomr = $rm1 . '.' . $rm2 . '.' . $rm3;
$umur = ubahDateFormat($dat_pasien['TGL_LAHIR']);
$pasien = $nama_pasien.' ('.strtoupper($jns_kelamin).', '.$umur.')';
$tgl_masuk = date('d M Y');
?>	
<script language="javascript" type="text/javascript">
function cetak_gelang(){
	window.open("index.php?print=gelangpasien&pasien=<?php echo $pasien; ?>&norm=<?php echo 'MR '.$nomr; ?>&tglmasuk=<?php echo ubahDateFormat($tanggal_daftar); ?>&dokter=<?php echo $dokter; ?>&ruangan=<?php echo $ruang_id; ?>","Gelang Pasien");
}
</script>
	
    <?php
}
?>
