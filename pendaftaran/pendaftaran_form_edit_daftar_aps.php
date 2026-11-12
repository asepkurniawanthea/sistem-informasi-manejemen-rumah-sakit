<?php
$tgl_daftar = getDateSkr();

$st_ok = 0;
$_SESSION['nilai_bayar'] = 0;

if (isset($_GET['idx'])) {
$penunjang_id = $_GET['idx'];
$sql_penunjang = 'SELECT "1" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.UNIT_ID,t_ipenunjang_tarif.NO_SJP,t_ipenunjang.PENGIRIM,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.NO_PESERTA,
					m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.TANGGAL_DAFTAR,t_ipenunjang_tarif.JENIS_BAYAR_ID,
					t_ipenunjang.NO_PASIEN_PENUNJANG,t_ipenunjang.NAMA_PASIEN,t_ipenunjang.TGL_LAHIR,
					t_ipenunjang.JNS_KELAMIN,t_ipenunjang.ALAMAT,t_ipenunjang.NIK,
					t_ipenunjang.INSTANSI_PENGIRIM,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang.DIAGNOSA_PENGIRIM,t_ipenunjang.ALAMAT_INSTANSI_PENGIRIM,
					t_ipenunjang.NO_TELP_INSTANSI_PENGIRIM,t_ipenunjang.TANGGAL_PERMINTAAN,
					t_ipenunjang.NO_ORDER
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
					AND t_ipenunjang.JNS_ORDER = "APS" ';
$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
$dat_penunjang = mysql_fetch_assoc($get_penunjang);
$unit_id = $dat_penunjang['UNIT_ID'];
$no_sjp = $dat_penunjang['NO_SJP'];
$pemeriksa = $dat_penunjang['NAMA_PEMERIKSA'];
$st_periksa = $dat_penunjang['ST_PERIKSA'];
$jns_pnj = $dat_penunjang['JNS'];
$no_sep = $dat_penunjang['NO_SEP'];

$jaminan = $dat_penunjang['NAMA_JAMINAN'];
$no_peserta = $dat_penunjang['NO_PESERTA'];
$tgl_daftar = changeDateFormat($dat_penunjang['TANGGAL_DAFTAR']);
$jenis_bayar_id = $dat_penunjang['JENIS_BAYAR_ID'];

$nomr = $dat_penunjang['NO_PASIEN_PENUNJANG'];
$nama_pasien = $dat_penunjang['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_penunjang['TGL_LAHIR']);
$jns_kelamin = $dat_penunjang['JNS_KELAMIN'];
$alamat = $dat_penunjang['ALAMAT'];
$nik = $dat_penunjang['NIK'];			

$dokter_pengirim = $dat_penunjang['PENGIRIM'];			
$instansi_pengirim = $dat_penunjang['INSTANSI_PENGIRIM'];
$alamat_instansi_pengirim = $dat_penunjang['ALAMAT_INSTANSI_PENGIRIM'];
$telp_instansi_pengirim = $dat_penunjang['NO_TELP_INSTANSI_PENGIRIM'];
$diagnosa = $dat_penunjang['DIAGNOSA_PENGIRIM'];
$tgl_permintaan = changeDateFormat($dat_penunjang['TANGGAL_PERMINTAAN']);
$asal_pasien_id = '1';
$asal_pasien = 'APS';
$no_order = $dat_penunjang['NO_ORDER'];
}

if (isset($_GET['un']))
    $unit_id = $_GET['un'];
if (isset($_GET['in']))
    $instansi_pengirim = $_GET['in'];
if (isset($_GET['do']))
    $dokter_pengirim = $_GET['do'];
if (isset($_GET['al']))
    $alamat_instansi_pengirim = $_GET['al'];
if (isset($_GET['te']))
    $telp_instansi_pengirim = $_GET['te'];
if (isset($_GET['ta']))
    $tgl_permintaan = $_GET['ta'];	
if (isset($_GET['di']))
    $diagnosa = $_GET['di'];	

if (isset($_POST['penunjang_id']))
    include('pendaftaran/pendaftaran_save_edit_aps.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jkn_diagnosa").autocomplete("index.php?autocomp=autocompjkndiagnosa",{width: 350});
    });
	
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
    <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Id APS</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php if(strlen($nomr) > 6) { echo $nomr; }else{ echo formatNomr($nomr); } ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($nama_pasien==''){
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
			if ($tgl_lahir==''){
				echo "-"; 
			} else {			
				echo getUmurDaftar($tgl_lahir,$tgl_daftar);
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
			if ($alamat==''){
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
			if ($nik==''){
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Pasien</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
   	<!------------------------------------------------------------------------------------->
    </div>
	
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
     
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt">
			<?php $arr_jenis_bayar = getArrJnsBayar(); 
				foreach($arr_jenis_bayar as $row){
					//if(in_array($row['id'],getArrNonJaminan())){
						echo '<option value="' . $row['id'] . '" ' . (($row['id'] == $jenis_bayar_id) ? 'selected':'') .  ' >' . $row['nama'] . '</option>';
					//}	
				}	
			?>
			</select>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<br /><br />
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Penunjang Tujuan</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left"><select name="unit_id" id="unit_id" style="width:228px;" class="text_dt">
			<option value=""> - </option>
			<?php echo getUnit('pnj',$unit_id); ?>
		</select></div>
		<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
		
		<!----------------------------------------------------------------------------------->
		
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Instansi Pengirim</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="instansi_pengirim" id="instansi_pengirim" class="text_dt" value="<?php echo $instansi_pengirim; ?>" size="50" /></div>
		<div style=" width:300px; float:right; text-indent:5px; " align="left">
			<input type="text" name="dokter_pengirim" id="dokter_pengirim" class="text_dt" value="<?php echo $dokter_pengirim; ?>" size="35" /></div>
		<div style=" width:20px; float:right; ">:</div>
		<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter Pengirim</div><br><br>
		
		<!------------------------------------------------------------------------------------>
			
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat Instansi</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="alamat_instansi_pengirim" id="alamat_instansi_pengirim" class="text_dt" value="<?php echo $alamat_instansi_pengirim; ?>" size="50" /></div>
		<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
		
		
		<!------------------------------------------------------------------------------------>
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Telepon</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="telp_instansi_pengirim" id="telp_instansi_pengirim" class="text_dt" value="<?php echo $telp_instansi_pengirim; ?>" size="35" /></div>
		<div style=" width:300px; float:right; text-indent:5px; " align="left">
			<input type="text" name="tgl_permintaan" id="tgl_minta" value="<?php echo $tgl_permintaan; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/></div>
		<div style=" width:20px; float:right; ">:</div>
		<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Permintaan</div><br><br>
		
		
		<!------------------------------------------------------------------------------------->
		
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<textarea name="diagnosa" id="diagnosa" class="text_dt3" ><?php echo $diagnosa; ?></textarea></div>
		<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br><br><br><br>
		
		
                <div style=" width:300px; float:right; text-indent:5px; " align="right">
                    <!--
					<a href="#" onclick="Javascript : tambah_tindakan('<?php echo md5('pendaftaranformeditpemeriksaanaps'); ?>','<?php echo $penunjang_id; ?>');" >
                        <input type="button" value="tambah penunjang" class="myButton" />
                    </a>-->
					<a href="index.php?link=<?php echo md5('pendaftaranlistaps'); ?>" ><input type="button" value="tutup" class="myButton" /></a>
                </div>
                <div style=" width:20px; float:right; ">&nbsp;</div>
                <div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
            </div>

            <!------------------------------------------------------------------------------------->

        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <div id="tableTmp" >
                <table class="tableData" id="tfhover" >
                    <?php $no_tarif = $_GET['no']; 
					include('pendaftaran/pendaftaran_tmp_edit_aps.php'); ?>
                    <tr>
                        <td colspan="5" align="right"><div id="total">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?></div></td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                </table>
                <input type="hidden" name="cnt_p" value="<?php echo $i; ?>" />	
            </div>
        </div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
            <a href="#" onclick="javascript : cetak_ulang(); return false;" ><input type="button" value="cetak ulang" class="myButton" /></a>
			<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1' and $st_periksa == ''){ ?>
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<a href="#" onclick="javascript : batalkan_pendaftaran('<?php echo $_GET['idx']; ?>','<?php echo $_GET['no']; ?>','1'); return false;" ><input type="button" value="batalkan pendaftaran" class="myButton" /></a>
			<?php } ?>
		   <!--<input type="button" value="simpan" class="myButton1" onclick="JavaScript : cek_centang('<?php echo $i; ?>');" />-->
            <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
            <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
            <input type="hidden" name="no" id="no" value="<?php echo $_GET['no']; ?>" />
			<input type="hidden" name="no_order" id="no_order" value="<?php echo $no_order; ?>" />
			<input type="hidden" name="unit_id_ls" id="unit_id_ls" value="<?php echo $unit_id; ?>" />
			<div id="batal"></div>
        </div>
    </form>

</div>
<script type="text/javascript">
	
	function batalkan_pendaftaran(idx,no,jns){
		if(confirm('Batalkan Pendaftaran Penunjang?')){
			MyAjaxRequest('batal','index.php?ajaxrequest=batalpendaftaranpenunjang&no=' + no + '&jns=' + jns);
			alert('Pendaftaran Telah Dibatalkan.');
			window.location = "index.php?link=<?php echo md5('pendaftaranlistaps'); ?>";			
		}	
	}
	
	function cetak_ulang(){
		var p_sjp = 'no';
		var p_sep = 'no';
			
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_aps_edit.php?idx=<?php echo $penunjang_id; ?>&no=<?php echo $_GET['no']; ?>&sjp=' + p_sjp + '&jn=1&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			
	}

    function cek_centang(i){
        j = 2;
        x = 0;
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
        xun = document.getElementById("unit_id").value;
        xin = document.getElementById("instansi_pengirim").value;
        xdo = document.getElementById("dokter_pengirim").value;
		xal = document.getElementById("alamat_instansi_pengirim").value;
		xte = document.getElementById("telp_instansi_pengirim").value;
		xta = document.getElementById("tgl_minta").value;
		xdi = document.getElementById("diagnosa").value;
		
        window.location = "index.php?link=" + link + "&idx=" + idx + "&no=" + "<?php echo $_GET['no']; ?>" + "&un=" + xun + "&in=" + xin + "&do=" + xdo + "&al=" + xal + "&te=" + xte + "&ta=" + xta + "&di=" + xdi;
    }

</script>