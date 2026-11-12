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
					m_jaminan.NAMA_JAMINAN
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE IRJA_ID = "' . $rawat_id . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_penunjang = mysql_fetch_assoc($get_kunjungan);

    $asal_pasien_id = $dat_penunjang['ASAL_PASIEN_ID'];
    $ket_asal_pasien = $dat_penunjang['KET_ASAL_PASIEN'];
    $dokter = $dat_penunjang['NAMA_PEGAWAI'];
    $unit = $dat_penunjang['NAMA_UNIT'];
    $asal_pasien = $dat_penunjang['KET_ASAL_PASIEN'];
    $jaminan = $dat_penunjang['NAMA_JAMINAN'];

    $jenis_bayar_id_rujuk = $dat_penunjang['JENIS_BAYAR_ID'];
    $unit_id_rujuk = $dat_penunjang['UNIT_ID'];
    $tgl_daftar_rujuk = changeDateFormat($dat_penunjang['TANGGAL_DAFTAR']);
	$pegawai_id_rujuk = $dat_penunjang['PEGAWAI_ID'];
    $nomr = $dat_penunjang['NOMR'];
	$no_sep_rujuk = $dat_penunjang['NO_SEP'];
	
	$pasien_kecelakaan = $dat_penunjang['KECELAKAAN'];
	$lokasi_kecelakaan = $dat_penunjang['LOKASI_KECELAKAAN'];

    $sql_diagnosa = 'SELECT CONCAT(t_irja_diagnosa.ICD_CODE," ",t_irja_diagnosa.DIAGNOSA) AS DIAGNOSA
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0';
    $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
    $dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
    $diagnosa_awal = $dat_diagnosa['DIAGNOSA'];

    //
	$sql_penunjang = 'SELECT t_ipenunjang_tarif.*,m_icd_x.DESKRIPSI,
					MAX(t_ipenunjang_tarif.ST_PERIKSA) AS STP,
					MAX(t_ipenunjang_tarif.ST_DIAGNOSA) AS STD,
					t_ipenunjang.RESULT_FR_LIS
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					LEFT JOIN m_icd_x ON (t_ipenunjang_tarif.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
					WHERE t_ipenunjang.JNS_ORDER = "IRJ" 
					AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"';
	$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
	$dat_penunjang = mysql_fetch_assoc($get_penunjang);	
	
    $jkn_tgl_rujuk = changeDateFormat($dat_penunjang['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_penunjang['JKN_NO_RUJUK'];
	$jkn_kd_pkk = $dat_penunjang['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_penunjang['JKN_NAMA_PKK'];
	$jkn_catatan = $dat_penunjang['JKN_CATATAN'];
	$jkn_diagnosa = $dat_penunjang['JKN_DIAGNOSA'];
	$jkn_nama_diagnosa = $dat_penunjang['DESKRIPSI'];
	$jkn_poliklinik = $dat_penunjang['JKN_POLIKLINIK'];
	$jkn_kelas_rawat = $dat_penunjang['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_penunjang['JKN_PBI_NONPBI'];
	$jkn_asal_rujukan = $dat_penunjang['JKN_ASAL_RUJUKAN'];
	$jkn_cob = $dat_penunjang['JKN_COB'];
	$jkn_penjamin = $dat_penunjang['JKN_PENJAMIN'];
	$jkn_penjamin_r = explode(',',$jkn_penjamin);
	foreach($jkn_penjamin_r as $jp){
		if($jp == '1') $jkn_penjamin_1 = '1';
		if($jp == '2') $jkn_penjamin_2 = '2';
		if($jp == '3') $jkn_penjamin_3 = '3';
		if($jp == '4') $jkn_penjamin_4 = '4';
	}
	
	$jkn_unit_id = $dat_penunjang['UNIT_PENUNJANG_ID'];
	
	$jkn_katarak = $dat_penunjang['JKN_KATARAK'];
	$jkn_nosurat_skdp = $dat_penunjang['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_penunjang['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_penunjang['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_penunjang['JKN_SPESIALISASI_DPJP_SKDP'];

    
	$no_sep = $dat_penunjang['NO_SEP'];
    $no_peserta = $dat_penunjang['NO_PESERTA'];
	
	$jenis_bayar_id_lama = $dat_penunjang['JENIS_BAYAR_ID'];
	$unit_id_lama = $dat_penunjang['UNIT_PENUNJANG_ID']; 
	
	$unit_id = $unit_id_lama;
	$jenis_bayar_id = $jenis_bayar_id_lama; 
	$pegawai_id = $dat_penunjang['PEGAWAI_PERIKSA_ID'];
	$tgl_daftar = changeDateFormat($dat_penunjang['TANGGAL_DAFTAR']);
	
	$st_periksa = $dat_penunjang['STP'];
	$st_diagnosa = $dat_penunjang['STD'];
	$st_lis = $dat_penunjang['RESULT_FR_LIS'];
    //
}

if (isset($_GET['un']))
    $unit_id = $_GET['un'];
if (isset($_GET['pu']))
    $pegawai_id = $_GET['pu'];
if (isset($_GET['by']))
    $jenis_bayar_id = $_GET['by'];
if (isset($_GET['se']))
    $no_sep = $_GET['se'];
if (isset($_GET['tg']))
    $tgl_daftar = $_GET['tg'];
if (isset($_GET['ps']))
    $no_peserta = $_GET['ps'];	

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jkn_no_telp = $dat_pasien['NO_TELEPON'];

if (isset($_POST['rawat_id']))
    include('pendaftaran/pendaftaran_save_edit_daftar_penunjang.php');
?>
<script type="text/javascript">
    function centang_opt(ck,nl){
        if(document.getElementById(ck).checked){
            MyAjaxRequest('total','index.php?ajaxrequest=totalpenunjang&opt=1&nilai=' + nl);
            return false;
        }else{
            MyAjaxRequest('total','index.php?ajaxrequest=totalpenunjang&opt=2&nilai=' + nl);
            return false;
        }
    }
</script>
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
                <div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
                <div style=" width:20px; float:left; ">&nbsp;</div>
                <div style=" width:250px; float:left; text-indent:5px; " align="left">
                    &nbsp;
                </div>
               <div style=" width:300px; float:right; text-indent:5px; " align="right">
					<!--
				   <a href="#" onclick="Javascript : tambah_tindakan('<?php echo md5('pendaftaranformeditpemeriksaanpenunjang'); ?>','<?php echo $rawat_id; ?>');" >
                        <input type="button" value="tambah penunjang" class="myButton" />
                    </a>-->
					<a href="index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>" ><input type="button" value="tutup" class="myButton" /></a>
                </div>
                <div style=" width:20px; float:right; ">&nbsp;</div>
                <div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 
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
                
				<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
                <div style=" width:20px; float:left; ">&nbsp;</div>
                <div style=" width:350px; float:left; text-indent:5px;margin:5px;" align="left">
					&nbsp;
                </div>
                <div style=" width:300px; float:right; text-indent:5px; " align="right">
					<!--
                    <a href="#" onclick="Javascript : tambah_tindakan('<?php echo md5('pendaftaranformeditpemeriksaanpenunjang'); ?>','<?php echo $rawat_id; ?>');" >
                        <input type="button" value="tambah penunjang" class="myButton" />
                    </a>
					-->
					<a href="index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>" ><input type="button" value="tutup" class="myButton" /></a>
                </div>
                <div style=" width:20px; float:right; ">&nbsp;</div>
                <div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
            </div>

            <!------------------------------------------------------------------------------------->
        </div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <div id="tableTmp" >
                <table class="tableData" id="tfhover" >
                    <?php $no_tarif = $_GET['no']; 
					include('pendaftaran/pendaftaran_tmp_edit_penunjang.php'); ?>
                    <tr>
                        <td colspan="5" align="right"><div id="total">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?></div></td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                </table>
                <input type="hidden" name="cnt_p" value="<?php echo $i; ?>" />	
            </div>
        </div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
            <a href="#" onclick="javascript : cetak_ulang(); return false;" ><input type="button" value="cetak ulang" class="myButton" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="ubah_sep" value="1" checked="checked" />&nbsp;Ubah SEP&nbsp;&nbsp;
			<input type="submit" value="simpan" class="myButton1" />
			<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
			<?php if($st_periksa == '' and $st_diagnosa == '' and $st_lis == ''){ ?>
			<a href="#" onclick="javascript : batalkan_pendaftaran('<?php echo $_GET['idx']; ?>','<?php echo $_GET['no']; ?>','1'); return false;" ><input type="button" value="batalkan pendaftaran" class="myButton" /></a>
			<?php } } ?> 
			<!--<input type="button" value="simpan" class="myButton1" onclick="JavaScript : cek_centang('<?php echo $i; ?>');" />-->
            <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
            <input type="hidden" name="rawat_id" id="rawat_id" value="<?php echo $rawat_id; ?>" />
            <input type="hidden" name="jenis_bayar_id_rujuk" id="jenis_bayar_id_rujuk" value="<?php echo $jenis_bayar_id_rujuk; ?>" />
            <input type="hidden" name="jkn_jns_rawat" id="jkn_jns_rawat" value="2" />
            <input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
			<input type="hidden" name="tgl_daftar_rujuk" id="tgl_daftar_rujuk" value="<?php echo $tgl_daftar_rujuk; ?>" />
			<input type="hidden" name="no_sep_rujuk" id="no_sep_rujuk" value="<?php echo $no_sep_rujuk; ?>" />
			<input type="hidden" name="tgl_status" id="tgl_status" value="" />
			<input type="hidden" name="no" id="no" value="<?php echo $_GET['no']; ?>" />
			<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
			<div id="batal"></div>
        </div>
    </form>

</div>
<script type="text/javascript">
    document.getElementById("jkn_unit_id").focus();
	
	function batalkan_pendaftaran(idx,no,jns){
		if(confirm('Batalkan Pendaftaran Penunjang?')){
			MyAjaxRequest('batal','index.php?ajaxrequest=batalpendaftaranpenunjang&no=' + no + '&jns=' + jns);
			alert('Pendaftaran Telah Dibatalkan.');
			window.location = "index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>";			
		}	
	}
	
	function cetak_ulang(){
		var p_sjp = 'no';
		var p_sep = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		
		<?php if($jenis_bayar_id == '12'){ ?>
			if(confirm('Print Juga SEP?')){
				p_sep = 'yes';
			}
		<?php } ?>
		
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang_edit.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $_GET['no']; ?>&sjp=' + p_sjp + '&jn=1&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			
	}

    function cek_centang(i){
        var j = 2;
        var x = 0;
        while (j < i) {
            var myElem = document.getElementById("tarif" + j);
            if(myElem != null){
                if(document.getElementById("tarif" + j).checked){ x = 1; }
            }	
            j++;
        }
	
        if(x == 0){
            alert('Nama Pemeriksaan Belum Dipilih');
        }else{
            if(confirm('Yakin Simpan Pendaftaran ?')){
                document.getElementById("pendaftaranedit").submit();
            }
        }	
    }

    function tambah_tindakan(link,idx){
        var by = document.getElementById("jenis_bayar_id").value;
		var un = null;
		var pu = null
        if(by == '12'){
			un = document.getElementById("jkn_unit_id").value;
			pu = document.getElementById("jkn_pegawai_id").value;
		}else{
			un = document.getElementById("unit_id").value;
			pu = document.getElementById("pegawai_id").value;
		} 
        var tg = document.getElementById("tgl_daftar").value;
		var ps = document.getElementById("no_peserta").value;
		
		if(by == '12'){
			se = document.getElementById("jkn_no_sep").value;
		}else{
			se = document.getElementById("no_sep").value;
		}
		
        window.location = "index.php?link=" + link + "&idx=" + idx + "&no=" + "<?php echo $_GET['no']; ?>" + "&un=" + un + "&pu=" + pu + "&se=" + se + "&tg=" + tg + "&by=" + by + "&ps=" + ps;
    }
	
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
					
						/* $.ajax({
							type: 'POST',
							url: 'index.php?ajaxrequest=kunjunganpenunjangrehabmedik&idx=<?php echo $rawat_id; ?>',
							data: { x : '1' },
							cache: false,
							success: function(data) {
						
							if (data.length > 1){
								kx = data * 1;
								if(kx >= 3){
									alert('Pasien Sudah 3 Kali Pemeriksaan Penunjang Rehab Medik. \n Kembali Konsultasi.');
									document.getElementById('jkn_unit_id').value = "";
								}
							}
						
						},}); */
						
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
						
						/* $.ajax({
							type: 'POST',
							url: 'index.php?ajaxrequest=kunjunganpenunjangrehabmedik&idx=<?php echo $rawat_id; ?>',
							data: { x : '1' },
							cache: false,
							success: function(data) {
						
							if (data.length > 1){
								kx = data * 1;
								if(kx >= 3){
									alert('Pasien Sudah 3 Kali Pemeriksaan Penunjang Rehab Medik. \n Kembali Konsultasi.');
									document.getElementById('jkn_unit_id').value = "";
								}
							}
						
						},}); */
					
					
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
		
		<?php if(!empty($no_sep)){ ?>
			if((jns_bayar == '<?php echo $jenis_bayar_id_lama; ?>') && (jns_penunjang == '<?php echo $unit_id_lama; ?>')){
				if(jns_bayar == 12){
					document.getElementById("jkn_no_sep").value = '<?php echo $no_sep; ?>';
				}else{
					document.getElementById("no_sep").value = '<?php echo $no_sep; ?>';
				}
			}	
		<?php } ?>
	
    }
	
    ubah_nopeserta('<?php echo $nomr; ?>','<?php echo $jenis_bayar_id; ?>','<?php if(isset($_GET['ps'])) echo $no_peserta; ?>');	
	
    function ubah_nopeserta(nomr,jns_bayar,no_peserta){
        MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertapenunjang&nomr=' + nomr + '&jns_bayar=' + jns_bayar + '&no_peserta=' + no_peserta);
    }
	
	<?php
	if(isset($_GET['se'])){
		if($_GET['by'] != '12'){
			echo 'document.getElementById("no_sep").value = "' . $no_sep . '";';
		}else{
			echo 'document.getElementById("jkn_no_sep").value = "' . $no_sep . '";';
		}	
	}
	
	if (isset($_POST['rawat_id'])){
		if($_POST['jenis_bayar_id'] != '12'){
			echo 'document.getElementById("no_sep").value = "' . $no_sep . '";';
		}else{
			echo 'document.getElementById("jkn_no_sep").value = "' . $no_sep . '";';
		}
	}
	?>
	
</script>