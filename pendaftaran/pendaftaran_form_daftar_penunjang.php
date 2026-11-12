<?php
$jns_rawat = '2';
$pasien = 'penunjang';

$rawat_id = '';
$unit_id = '';
$pegawai_id = '';
$jenis_bayar_id = '';

$jkn_tgl_rujuk = '';
$jkn_no_rujuk = '';
$jkn_kd_pkk = '';
$jkn_nama_pkk = '';
$jkn_catatan = '';
$jkn_diagnosa = '';
$jkn_poliklinik = '';
$jkn_kelas_rawat = '';
$jkn_pbi_nonpbi = '';
$jkn_asal_rujukan = '';
$jkn_cob = '';
$jkn_penjamin = '';
$jkn_penjamin_1 = '';
$jkn_penjamin_2 = '';
$jkn_penjamin_3 = '';
$jkn_penjamin_4 = '';
$jkn_katarak = '';
$jkn_suplesi = '';
$jkn_nosep_suplesi = '';
$jkn_nosurat_skdp = '';
$jkn_dpjp_skdp = '';
$jkn_nama_dpjp_skdp = '';
$jkn_spesialis_dpjp_skdp = '';

$pasien_kecelakaan = '';
$kd_lokasi_kecelakaan_propinsi = '';
$kd_lokasi_kecelakaan_kota = '';
$kd_lokasi_kecelakaan_kecamatan = '';
$nama_lokasi_kecelakaan_propinsi = '';
$nama_lokasi_kecelakaan_kota = '';
$nama_lokasi_kecelakaan_kecamatan = '';
$tgl_kejadian_kecelakaan = '';
$keterangan_kecelakaan = '';
$kasus_polisi = '';

$tgl_daftar = getDateSkr();
$no_sep = '';
$no_peserta = '';

$unit_id_rujuk = '';
$jenis_bayar_id_rujuk = '';
$tgl_daftar_rujuk = '';
$no_sep_rujuk = '';

$st_ok = 0;
$_SESSION['nilai_bayar'] = 0;

if (isset($_GET['idx'])) {
    $rawat_id = $_GET['idx'];
    $sql_kunjungan = 'SELECT t_irja.*,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN,
					m_jaminan.NAMA_JAMINAN,m_icd_x.DESKRIPSI,
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_icd_x ON (t_irja.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
					WHERE IRJA_ID = "' . $rawat_id . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);

    $asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
    $ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
    $dokter = $dat_kunjungan['NAMA_PEGAWAI'];
    $unit = $dat_kunjungan['NAMA_UNIT'];
    $asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
    $jaminan = $dat_kunjungan['NAMA_JAMINAN'];
	
	$pasien_kecelakaan = $dat_kunjungan['KECELAKAAN'];
	$kd_lokasi_kecelakaan_propinsi = $dat_kunjungan['KD_LOKASI_KECELAKAAN_PROPINSI'];
	$kd_lokasi_kecelakaan_kota = $dat_kunjungan['KD_LOKASI_KECELAKAAN_KABUPATEN'];
	$kd_lokasi_kecelakaan_kecamatan = $dat_kunjungan['KD_LOKASI_KECELAKAAN_KECAMATAN'];
	$nama_lokasi_kecelakaan_propinsi = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_PROPINSI'];
	$nama_lokasi_kecelakaan_kota = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_KABUPATEN'];
	$nama_lokasi_kecelakaan_kecamatan = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_KECAMATAN'];
	$tgl_kejadian_kecelakaan = changeDateFormat($dat_kunjungan['TGL_KEJADIAN_KECELAKAAN']);
	$keterangan_kecelakaan = $dat_kunjungan['KETERANGAN_KECELAKAAN'];
	$kasus_polisi = $dat_kunjungan['KASUS_POLISI'];

    $jenis_bayar_id_rujuk = $dat_kunjungan['JENIS_BAYAR_ID'];
    $unit_id_rujuk = $dat_kunjungan['UNIT_ID'];
    $tgl_daftar_rujuk = changeDateFormat($dat_kunjungan['TANGGAL_DAFTAR']);
	$pegawai_id_rujuk = $dat_kunjungan['PEGAWAI_ID'];

    $jenis_bayar_id = $jenis_bayar_id_rujuk;

    $nomr = $dat_kunjungan['NOMR'];

    $sql_diagnosa = 'SELECT CONCAT(t_irja_diagnosa.ICD_CODE," ",t_irja_diagnosa.DIAGNOSA) AS DIAGNOSA
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0';
    $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
    $dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
    $diagnosa_awal = $dat_diagnosa['DIAGNOSA'];

    //
    $jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
	$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
	$jkn_catatan = $dat_kunjungan['JKN_CATATAN'];
	$jkn_diagnosa = $dat_kunjungan['JKN_DIAGNOSA'];
	$jkn_nama_diagnosa = $dat_kunjungan['DESKRIPSI'];
	$jkn_poliklinik = $dat_kunjungan['JKN_POLIKLINIK'];
	$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];
	$jkn_asal_rujukan = $dat_kunjungan['JKN_ASAL_RUJUKAN'];
	$jkn_cob = $dat_kunjungan['JKN_COB'];
	$jkn_penjamin = $dat_kunjungan['JKN_PENJAMIN'];
	$jkn_penjamin_r = explode(',',$jkn_penjamin);
	foreach($jkn_penjamin_r as $jp){
		if($jp == '1') $jkn_penjamin_1 = '1';
		if($jp == '2') $jkn_penjamin_2 = '2';
		if($jp == '3') $jkn_penjamin_3 = '3';
		if($jp == '4') $jkn_penjamin_4 = '4';
	}
	
	$jkn_unit_id = $dat_kunjungan['UNIT_ID'];
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	
	$jkn_katarak = $dat_kunjungan['JKN_KATARAK'];
	$jkn_suplesi = $dat_kunjungan['JKN_SUPLESI'];
	$jkn_nosep_suplesi = $dat_kunjungan['JKN_NO_SEP_SUPLESI'];
	$jkn_nosurat_skdp = $dat_kunjungan['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_kunjungan['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_kunjungan['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_kunjungan['JKN_SPESIALISASI_DPJP_SKDP'];

    $no_sep = $dat_kunjungan['NO_SEP'];
    $no_peserta = $dat_kunjungan['NO_PESERTA'];
	
	$no_sep_rujuk = $no_sep;
    //
}

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jkn_no_telp = $dat_pasien['NO_TELEPON'];
$dokter_pengirim = '';

if (isset($_POST['rawat_id']))
    include('pendaftaran/pendaftaran_save_daftar_penunjang.php');
?>
<div style=" height:auto; padding:15px; ">
    <form name="pendaftaranedit" id="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
                <?php
                if ($nama_pasien == '') {
                    echo "-";
                } else {
                    echo $nama_pasien;
                }
                ?>
            </div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>
            <!------------------------------------------------------------------------------------->

            <div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_lahir; ?></div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
                <?php
                if ($tgl_lahir == '') {
                    echo "-";
                } else {
                    echo getUmur($tgl_lahir);
                }
                ?>
            </div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Umur</div><br><br>
            <!------------------------------------------------------------------------------------->

            <div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
                <?php
                if ($alamat == '') {
                    echo "-";
                } else {
                    echo $alamat;
                }
                ?>
            </div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>
            <!------------------------------------------------------------------------------------->

            <div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left">
                <?php
                if ($nik == '') {
                    echo "-";
                } else {
                    echo $nik;
                }
                ?>
            </div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
            <!------------------------------------------------------------------------------------->

            <div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dokter; ?></div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Asal Pasien</div><br><br>
            <!------------------------------------------------------------------------------------->

            <div style=" width:250px; float:left; text-indent:25px; " align="left">Kiriman Dari</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit; ?></div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br>
            <!------------------------------------------------------------------------------------->
        </div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <?php if($unit_id_rujuk == '9'){ ?>
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left">
                <select name="dokter_pengirim" id="dokter_pengirim" style="width:228px;" class="text_dt" >
					<option value="">-</option>
                     <?php echo getDokter($dokter_pengirim,'9'); ?>
                </select>
            </div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
                &nbsp;
            </div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
			<?php }else{ ?>
			<input type="hidden" name="dokter_pengirim" value="<?php echo $pegawai_id_rujuk; ?>" />
			<?php } ?>
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left">
                <select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : ubah_nopeserta('<?php echo $nomr; ?>',this.value,'<?php if(isset($_GET['ps'])) echo $no_peserta; ?>');ubah_formdaftar(this.value,document.getElementById('jkn_unit_id').value);return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id, '1'); ?>
                </select>
            </div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
                <div id="cnopeserta" ></div>
            </div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
              
            <!------------------------------------------------------------------------------------->
            <div id="form_daftar_1">
				<?php include('pendaftaran/pendaftaran_form_nonjkn.php'); ?>
            </div>

            <!------------------------------------------------------------------------------------->

            <div id="form_daftar_2"> 
                <div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Pasien</div>
                <div style=" width:20px; float:left; ">:</div>
                <div style=" width:250px; float:left; text-indent:5px; " align="left">
                    <input type="text" name="jkn_nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>" size="34" class="text_dt" readonly="readonly" />
                </div>
                <div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
                <div style=" width:20px; float:right; ">&nbsp;</div>
                <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 

                <div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
                <div style=" width:20px; float:left; ">:</div>
                <div style=" width:250px; float:left; text-indent:5px; " align="left">
                    <input type="text" name="jkn_tgl_lahir" id="tgl_lahir" value="<?php echo $tgl_lahir; ?>" size="15" class="text_dt" readonly="readonly" />
                </div>
                <div style=" width:300px; float:right; text-indent:5px; " align="left"><input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if ($jns_kelamin == 'L') echo 'checked="checked"'; ?>/>
                    &nbsp;Laki-laki&nbsp;&nbsp;
                    <input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if ($jns_kelamin == 'P') echo 'checked="checked"'; ?> />
                    &nbsp;Perempuan</div>
                <div style=" width:20px; float:right; ">:</div>
                <div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Kelamin</div><br><br> 
				
				<?php include('pendaftaran/pendaftaran_form_jkn.php'); ?>
            </div>

            <!------------------------------------------------------------------------------------->
        </div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
            <a href="index.php?link=<?php echo md5('pendaftaranbarupenunjang'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan >>" class="myButton1" />
            <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
            <input type="hidden" name="rawat_id" id="rawat_id" value="<?php echo $rawat_id; ?>" />
            <input type="hidden" name="jenis_bayar_id_rujuk" id="jenis_bayar_id_rujuk" value="<?php echo $jenis_bayar_id_rujuk; ?>" />
            <input type="hidden" name="jkn_jns_rawat" id="jkn_jns_rawat" value="2" />
            <input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
			<input type="hidden" name="tgl_daftar_rujuk" id="tgl_daftar_rujuk" value="<?php echo $tgl_daftar_rujuk; ?>" />
			<input type="hidden" name="no_sep_rujuk" id="no_sep_rujuk" value="<?php echo $no_sep_rujuk; ?>" />
			<input type="hidden" name="tgl_status" id="tgl_status" value="" />
			<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
        </div>
    </form>

</div>
<script type="text/javascript">
    document.getElementById("jkn_unit_id").focus();
    ubah_formdaftar('<?php echo $jenis_bayar_id; ?>','<?php echo $unit_id; ?>');

    function ubah_formdaftar(jns_bayar,jns_penunjang){
		var rawat_id = document.getElementById("rawat_id").value;
		var jns_bayar_rujuk = document.getElementById("jenis_bayar_id_rujuk").value;
		var tgl_daftar = document.getElementById("tgl_daftar").value;
		var tgl_daftar_rujuk = document.getElementById("tgl_daftar_rujuk").value;
		
        if(jns_bayar == 12){
				if(jns_bayar != jns_bayar_rujuk){
					document.getElementById("jkn_no_sep").value = '';
					document.getElementById("tgl_status").value = 2;
					document.getElementById("jkn_no_sep").size = 26;
					document.getElementById("csep").style.display = 'block';
				}else{
					if((jns_penunjang == 31) || (jns_penunjang == 40) || (jns_penunjang == 41) || (jns_penunjang == 47) || (jns_penunjang == 51)){
						
						if(tgl_daftar_rujuk != tgl_daftar){
							document.getElementById("jkn_no_sep").value = '';
							document.getElementById("tgl_status").value = 2;
							document.getElementById("jkn_no_sep").size = 26;
							document.getElementById("csep").style.display = 'block';
						}else{
							document.getElementById("jkn_no_sep").value = document.getElementById("no_sep_rujuk").value;
							document.getElementById("tgl_status").value = 1;
							document.getElementById("jkn_no_sep").size = 34;
							document.getElementById("csep").style.display = 'none';
						}
					}else{
							document.getElementById("jkn_no_sep").value = document.getElementById("no_sep_rujuk").value;
							document.getElementById("tgl_status").value = 1;
							document.getElementById("jkn_no_sep").size = 34;
							document.getElementById("csep").style.display = 'none';
					}
				}
			
				document.getElementById("form_daftar_2").style.display = 'block';
				document.getElementById("form_daftar_1").style.display = 'none';
        }else{
            if(jns_bayar != 1){
				if(jns_bayar != jns_bayar_rujuk){
					document.getElementById("no_sep").value = '';
					document.getElementById("tgl_status").value = 2;
				}else{
					if((jns_penunjang == 31) || (jns_penunjang == 40) || (jns_penunjang == 41) || (jns_penunjang == 47) || (jns_penunjang == 51)){
					
					
						if(tgl_daftar_rujuk != tgl_daftar){
							document.getElementById("no_sep").value = '';
							document.getElementById("tgl_status").value = 2;
							
						}else{
							document.getElementById("no_sep").value = document.getElementById("no_sep_rujuk").value;
							document.getElementById("tgl_status").value = 1;
						}
					}else{
							document.getElementById("no_sep").value = document.getElementById("no_sep_rujuk").value;
							document.getElementById("tgl_status").value = 1;
					}
				}	
            }else{
					document.getElementById("no_sep").value = '';
					document.getElementById("tgl_status").value = 2;
			}
            document.getElementById("form_daftar_2").style.display = 'none';
            document.getElementById("form_daftar_1").style.display = 'block';
        }
    }
	
    ubah_nopeserta('<?php echo $nomr; ?>','<?php echo $jenis_bayar_id; ?>','<?php if(isset($_GET['ps'])) echo $no_peserta; ?>');	
	
    function ubah_nopeserta(nomr,jns_bayar,no_peserta){
        MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertapenunjang&nomr=' + nomr + '&jns_bayar=' + jns_bayar + '&no_peserta=' + no_peserta);
    }
</script>