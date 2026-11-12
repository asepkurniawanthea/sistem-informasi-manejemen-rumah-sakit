<?php if(isset($_GET['idx'])){ ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#icd_code1").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code2").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code3").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code4").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code5").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code6").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code7").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
	jQuery(document).ready(function() {
        jQuery("#icd_code8").autocomplete("index.php?autocomp=rmicd10",{width: 400});
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#icd_cm_code1").autocomplete("index.php?autocomp=rmicd9",{width: 400});
    });
	
	jQuery(document).ready(function() {
        jQuery("#icd_cm_code_penunjang1").autocomplete("index.php?autocomp=rmicd9",{width: 400});
    });
</script>
<?php
$irja_id = $_GET['idx'];
if (isset($_POST['irja_id']))
    include('rekammedik/rm_save_coding.php');
	
if (isset($_GET['idg']))
    include('rekammedik/rm_del_add_diagnosa.php');	
	
if (isset($_GET['idt']))
    include('rekammedik/rm_del_add_tindakan.php');

if (isset($_GET['idp']))
    include('rekammedik/rm_del_add_penunjang.php');		
	
$qry_tracer = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
		m_pasien.ALAMAT,m_pasien.NAMA_IBU,m_pasien.NIK,m_jaminan.NAMA_JAMINAN,
		m_unit.NAMA_UNIT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
		FROM t_irja 
		INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)	
		INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)  
		INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)  
		WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
$get_tracer = mysql_query($qry_tracer) or die(mysql_error());
$dat_tracer = mysql_fetch_assoc($get_tracer);
$nomr = $dat_tracer['NOMR'];
$nama_pasien = $dat_tracer['NAMA_PASIEN'];
$tmp_lahir = $dat_tracer['TMP_LAHIR'];
$tgl_lahir = changeDateFormat($dat_tracer['TGL_LAHIR']);
$jns_kelamin = $dat_tracer['JNS_KELAMIN'];
$nama_ibu = $dat_tracer['NAMA_IBU'];
$nik = $dat_tracer['NIK'];
$alamat = $dat_tracer['ALAMAT'];
$jns_pembayaran = $dat_tracer['NAMA_JAMINAN'];
$nama_unit = $dat_tracer['NAMA_UNIT'];
$tanggal_daftar = $dat_tracer['TANGGAL_DAFTAR'];
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableform" >
    <?php
    include('pasien/pasien_view_short.php');
    ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Poliklinik</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tanggal_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">
</table>
</div>
<?php
$sql_diagnosa = 'SELECT * FROM (
				SELECT t_irja_diagnosa.IRJA_DIAGNOSA_ID,t_irja_diagnosa.IRJA_ID,t_irja_diagnosa.DIAGNOSA_ORDER,t_irja_diagnosa.DIAGNOSA,
				t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.KASUS_BARU,t_irja_diagnosa.USER_RM,0 AS ORD
				FROM t_irja_diagnosa
				WHERE t_irja_diagnosa.IRJA_ID = "' . $irja_id . '"
				) t
				ORDER BY ORD,DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
$cndiagnosa = mysql_num_rows($get_diagnosa);
while ($dat_diagnosa = mysql_fetch_array($get_diagnosa)) {
    $irja_diagnosa_id[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['IRJA_DIAGNOSA_ID'];
    $diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['DIAGNOSA'];
    $icd_code[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['ICD_CODE'];
	$kasus_baru[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['KASUS_BARU'];
	$user_rm[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['USER_RM'];
	$diagnosa_tbl[$dat_diagnosa['DIAGNOSA_ORDER']] = $dat_diagnosa['ORD'];
}

$sql_tindakan = 'SELECT * FROM (
				SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.IRJA_ID,m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP,
				t_irja_tarif.ICD_CODE,m_tarif_group.NAMA_TARIF_GROUP,t_irja_tarif.DESKRIPSI,0 AS ORD
				FROM m_tarif
				INNER JOIN t_irja_tarif ON (m_tarif.TARIF_ID = t_irja_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
				AND m_tarif.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF_GROUP <> "02"
				AND m_tarif.KODE_TARIF_GROUP <> "09" AND m_tarif.KODE_TARIF_GROUP <> "92"
				AND m_tarif.KODE_TARIF_GROUP <> "93" 	
				AND t_irja_tarif.ST_BAYAR = "Lunas"
				UNION ALL
				SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID AS IRJA_TARIF_ID,t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,
				m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP,t_hemodialisa_tarif.ICD_CODE,m_tarif_group.NAMA_TARIF_GROUP,
				t_hemodialisa_tarif.DESKRIPSI,1 AS ORD
				FROM m_tarif
				INNER JOIN t_hemodialisa_tarif ON (m_tarif.TARIF_ID = t_hemodialisa_tarif.TARIF_ID)
				INNER JOIN t_hemodialisa ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $irja_id . '"
				AND t_hemodialisa.JNS_ORDER = "IRJ"
				AND m_tarif.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF_GROUP <> "02"
				AND m_tarif.KODE_TARIF_GROUP <> "09" AND m_tarif.KODE_TARIF_GROUP <> "92"
				AND m_tarif.KODE_TARIF_GROUP <> "93" 	
				AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
				UNION ALL
				SELECT t_operasi_tarif.OPERASI_TARIF_ID AS IRJA_TARIF_ID,t_operasi.OPERASI_ID AS IRJA_ID,
				m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP,t_operasi_tarif.ICD_CODE,m_tarif_group.NAMA_TARIF_GROUP,
				t_operasi_tarif.DESKRIPSI,2 AS ORD
				FROM m_tarif
				INNER JOIN t_operasi_tarif ON (m_tarif.TARIF_ID = t_operasi_tarif.TARIF_ID)
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
				AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
				AND m_tarif.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF_GROUP <> "02"
				AND m_tarif.KODE_TARIF_GROUP <> "09" AND m_tarif.KODE_TARIF_GROUP <> "92"
				AND m_tarif.KODE_TARIF_GROUP <> "93" 	
				AND t_operasi_tarif.ST_BAYAR = "Lunas"
				) t';
$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
$cntindakan = mysql_num_rows($get_tindakan);
$a = 1;
while ($dat_tindakan = mysql_fetch_array($get_tindakan)) {
    $irja_tarif_id[$a] = $dat_tindakan['IRJA_TARIF_ID'];
    $tindakan[$a] = $dat_tindakan['NAMA_TARIF'] . ' (' . $dat_tindakan['NAMA_TARIF_GROUP'] . ')';
    $icd_cm_code[$a] = $dat_tindakan['ICD_CODE'];
	$tindakan_rm[$a] = $dat_tindakan['DESKRIPSI'];
	$tindakan_tbl[$a] = $dat_tindakan['ORD'];
    $a++;
}

$sql_penunjang = 'SELECT * FROM (
				SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang.RAWAT_ID,m_tarif.NAMA_TARIF,m_tarif.KODE_TARIF_GROUP,
				t_ipenunjang_tarif.ICD_CODE,m_tarif_group.NAMA_TARIF_GROUP,
				t_ipenunjang.DESKRIPSI
				FROM m_tarif
				INNER JOIN t_ipenunjang_tarif ON (m_tarif.TARIF_ID = t_ipenunjang_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ"
				OR t_ipenunjang.JNS_ORDER = "ORJ")	
				AND m_tarif.KODE_TARIF_GROUP <> "01"  AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
				) t';
$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
$cnpenunjang = mysql_num_rows($get_penunjang);
$y = 1;
while ($dat_penunjang = mysql_fetch_array($get_penunjang)) {
    $penunjang_tarif_id[$y] = $dat_penunjang['PENUNJANG_TARIF_ID'];
    $penunjang[$y] = $dat_penunjang['NAMA_TARIF'] . ' (' . $dat_penunjang['NAMA_TARIF_GROUP'] . ')';
    $icd_cm_code_penunjang[$y] = $dat_penunjang['ICD_CODE'];
	$penunjang_rm[$y] = $dat_penunjang['DESKRIPSI'];
    $y++;
}
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="codingicd" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData">
			<tr>
			<td><strong>Diagnosa</strong></td>
            <td><?php if (isset($diagnosa[0])) echo $diagnosa[0]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id1" id="irja_diagnosa_id1" value="<?php echo ((isset($irja_diagnosa_id[0])) ? $irja_diagnosa_id[0] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl1" id="diagnosa_tbl1" value="<?php echo ((isset($diagnosa_tbl[0])) ? $diagnosa_tbl[0] : ''); ?>" />
                <input type="text" name="icd_code1" id="icd_code1" value="<?php echo ((isset($icd_code[0])) ? $icd_code[0] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru1" value="1" <?php echo ((isset($kasus_baru[0]) and $kasus_baru[0] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[0]) and !empty($user_rm[0])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[0]; ?>&nmg=<?php echo $diagnosa[0]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[1])) echo $diagnosa[1]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id2" id="irja_diagnosa_id2" value="<?php echo ((isset($irja_diagnosa_id[1])) ? $irja_diagnosa_id[1] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl2" id="diagnosa_tbl2" value="<?php echo ((isset($diagnosa_tbl[1])) ? $diagnosa_tbl[1] : ''); ?>" />
                <input type="text" name="icd_code2" id="icd_code2" value="<?php echo ((isset($icd_code[1])) ? $icd_code[1] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru2" value="1" <?php echo ((isset($kasus_baru[1]) and $kasus_baru[1] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[1]) and !empty($user_rm[1])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[1]; ?>&nmg=<?php echo $diagnosa[1]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[2])) echo $diagnosa[2]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id3" id="irja_diagnosa_id3" value="<?php echo ((isset($irja_diagnosa_id[2])) ? $irja_diagnosa_id[2] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl3" id="diagnosa_tbl3" value="<?php echo ((isset($diagnosa_tbl[2])) ? $diagnosa_tbl[2] : ''); ?>" />
                <input type="text" name="icd_code3" id="icd_code3" value="<?php echo ((isset($icd_code[2])) ? $icd_code[2] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru3" value="1" <?php echo ((isset($kasus_baru[2]) and $kasus_baru[2] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[2]) and !empty($user_rm[2])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[2]; ?>&nmg=<?php echo $diagnosa[2]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[3])) echo $diagnosa[3]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id4" id="irja_diagnosa_id4" value="<?php echo ((isset($irja_diagnosa_id[3])) ? $irja_diagnosa_id[3] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl4" id="diagnosa_tbl4" value="<?php echo ((isset($diagnosa_tbl[3])) ? $diagnosa_tbl[3] : ''); ?>" />
                <input type="text" name="icd_code4" id="icd_code4" value="<?php echo ((isset($icd_code[3])) ? $icd_code[3] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru4" value="1" <?php echo ((isset($kasus_baru[3]) and $kasus_baru[3] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[3]) and !empty($user_rm[3])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[3]; ?>&nmg=<?php echo $diagnosa[3]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<!--
			<tr>
			<td><strong>Diagnosa Banding</strong></td>
            <td><?php if (isset($diagnosa[4])) echo $diagnosa[4]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id5" id="irja_diagnosa_id5" value="<?php echo ((isset($irja_diagnosa_id[4])) ? $irja_diagnosa_id[4] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl5" id="diagnosa_tbl5" value="<?php echo ((isset($diagnosa_tbl[4])) ? $diagnosa_tbl[4] : ''); ?>" />
                <input type="text" name="icd_code5" id="icd_code5" value="<?php echo ((isset($icd_code[4])) ? $icd_code[4] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru5" value="1" <?php echo ((isset($kasus_baru[4]) and $kasus_baru[4] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[4]) and !empty($user_rm[4])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[4]; ?>&nmg=<?php echo $diagnosa[4]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[5])) echo $diagnosa[5]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id6" id="irja_diagnosa_id6" value="<?php echo ((isset($irja_diagnosa_id[5])) ? $irja_diagnosa_id[5] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl6" id="diagnosa_tbl6" value="<?php echo ((isset($diagnosa_tbl[5])) ? $diagnosa_tbl[5] : ''); ?>" />
                <input type="text" name="icd_code6" id="icd_code6" value="<?php echo ((isset($icd_code[5])) ? $icd_code[5] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru6" value="1" <?php echo ((isset($kasus_baru[5]) and $kasus_baru[5] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[5]) and !empty($user_rm[5])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[5]; ?>&nmg=<?php echo $diagnosa[5]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[6])) echo $diagnosa[6]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id7" id="irja_diagnosa_id7" value="<?php echo ((isset($irja_diagnosa_id[6])) ? $irja_diagnosa_id[6] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl7" id="diagnosa_tbl7" value="<?php echo ((isset($diagnosa_tbl[6])) ? $diagnosa_tbl[6] : ''); ?>" />
                <input type="text" name="icd_code7" id="icd_code7" value="<?php echo ((isset($icd_code[6])) ? $icd_code[6] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru7" value="1" <?php echo ((isset($kasus_baru[6]) and $kasus_baru[6] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[6]) and !empty($user_rm[6])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[6]; ?>&nmg=<?php echo $diagnosa[6]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
            <td><?php if (isset($diagnosa[7])) echo $diagnosa[7]; ?></td>
			<td colspan="2"><input type="hidden" name="irja_diagnosa_id8" id="irja_diagnosa_id8" value="<?php echo ((isset($irja_diagnosa_id[7])) ? $irja_diagnosa_id[7] : ''); ?>" />
				<input type="hidden" name="diagnosa_tbl8" id="diagnosa_tbl8" value="<?php echo ((isset($diagnosa_tbl[7])) ? $diagnosa_tbl[7] : ''); ?>" />
                <input type="text" name="icd_code8" id="icd_code8" value="<?php echo ((isset($icd_code[7])) ? $icd_code[7] : ''); ?>" size="63" class="text_dt" /></td>
			<td><input type="checkbox" name="kasus_baru8" value="1" <?php echo ((isset($kasus_baru[7]) and $kasus_baru[7] == '1') ? 'checked' : ''); ?> />&nbsp;Kasus Baru</td>
			<td><?php if(isset($user_rm[7]) and !empty($user_rm[7])){ ?>
				<a href="<?php echo currentUrl(); ?>&idg=<?php echo $irja_diagnosa_id[7]; ?>&nmg=<?php echo $diagnosa[7]; ?>" >hapus</a>
				<?php } ?></td>
			</tr>
			-->
        <tr><td colspan="6">&nbsp;</td></tr>
		<?php if(currentModul() == 'rekam medik'){ ?>
        <tr><td><strong>Tindakan</strong></td>
            <td colspan="2"><?php if (isset($tindakan[1])) echo $tindakan[1]; ?></td><td><?php if (isset($tindakan[1])) { ?><input type="hidden" name="irja_tarif_id1" id="irja_tarif_id1" value="<?php echo $irja_tarif_id[1]; ?>" />
					<input type="hidden" name="tindakan_tbl1" id="tindakan_tbl1" value="<?php echo $tindakan_tbl[1]; ?>" />
                    <input type="text" name="icd_cm_code1" id="icd_cm_code1" value="<?php echo $icd_cm_code[1]; ?>" size="63" class="text_dt" /><?php } ?></td>
					<td></td>
					<td><?php if(isset($tindakan_rm[1]) and $tindakan_rm[1] == 'Tindakan (MR)'){ ?>
					<a href="<?php echo currentUrl(); ?>&idt=<?php echo $irja_tarif_id[1]; ?>&nmt=<?php echo $tindakan[1]; ?>" >hapus</a>
					<?php } ?></td>
            <?php
            $k = 2;
            while ($k < $a) {
                ?>
            <tr><td>&nbsp;</td><td colspan="2"><?php echo $tindakan[$k]; ?></td><td><input type="hidden" name="irja_tarif_id<?php echo $k; ?>" id="irja_tarif_id<?php echo $k; ?>" value="<?php echo $irja_tarif_id[$k]; ?>" />
					<input type="hidden" name="tindakan_tbl<?php echo $k; ?>" id="tindakan_tbl<?php echo $k; ?>" value="<?php echo $tindakan_tbl[$k]; ?>" />
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#icd_cm_code<?php echo $k; ?>").autocomplete("index.php?autocomp=rmicd9",{width: 400});
                        });
                    </script>
                    <input type="text" name="icd_cm_code<?php echo $k; ?>" id="icd_cm_code<?php echo $k; ?>" value="<?php echo $icd_cm_code[$k]; ?>" size="63" class="text_dt" /></td>
					<td></td>
					<td><?php if($tindakan_rm[$k] == 'Tindakan (MR)'){ ?>
					<a href="<?php echo currentUrl(); ?>&idt=<?php echo $irja_tarif_id[$k]; ?>&nmt=<?php echo $tindakan[$k]; ?>" >hapus</a>
					<?php } ?></td>
                <?php
                $k++;
            }
            ?>
		<tr><td colspan="6">&nbsp;</td></tr>
        <tr><td><strong>Penunjang</strong></td>
            <td colspan="2"><?php if (isset($penunjang[1])) echo $penunjang[1]; ?></td><td><?php if (isset($penunjang[1])) { ?><input type="hidden" name="penunjang_tarif_id1" id="penunjang_tarif_id1" value="<?php echo $penunjang_tarif_id[1]; ?>" />
                    <input type="text" name="icd_cm_code_penunjang1" id="icd_cm_code_penunjang1" value="<?php echo $icd_cm_code_penunjang[1]; ?>" size="63" class="text_dt" /><?php } ?></td>
					<td></td>
					<td><?php if(isset($penunjang_rm[1]) and $penunjang_rm[1] == 'Penunjang (MR)'){ ?>
					<a href="<?php echo currentUrl(); ?>&idp=<?php echo $penunjang_tarif_id[1]; ?>&nmp=<?php echo $penunjang[1]; ?>" >hapus</a>
					<?php } ?></td>
            <?php
            $m = 2;
            while ($m < $y) {
                ?>
            <tr><td>&nbsp;</td><td colspan="2"><?php echo $penunjang[$m]; ?></td><td><input type="hidden" name="penunjang_tarif_id<?php echo $m; ?>" id="penunjang_tarif_id<?php echo $m; ?>" value="<?php echo $penunjang_tarif_id[$m]; ?>" />
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#icd_cm_code_penunjang<?php echo $m; ?>").autocomplete("index.php?autocomp=rmicd9",{width: 400});
                        });
                    </script>
                    <input type="text" name="icd_cm_code_penunjang<?php echo $m; ?>" id="icd_cm_code_penunjang<?php echo $m; ?>" value="<?php echo $icd_cm_code_penunjang[$m]; ?>" size="63" class="text_dt" /></td>
					<td></td>
					<td><?php if($penunjang_rm[$m] == 'Penunjang (MR)'){ ?>
					<a href="<?php echo currentUrl(); ?>&idp=<?php echo $penunjang_tarif_id[$m]; ?>&nmp=<?php echo $penunjang[$m]; ?>" >hapus</a>
					<?php } ?></td>
                <?php
                $m++;
            }
         }   ?>	
		</table>	
        <table width="100%">
		<tr><td align="right">
                <input type="hidden" name="cndiagnosa" id="cndiagnosa" value="<?php echo $cndiagnosa; ?>" />
                <input type="hidden" name="cntindakan" id="cntindakan" value="<?php echo $cntindakan; ?>" />
				<input type="hidden" name="cnpenunjang" id="cnpenunjang" value="<?php echo $cnpenunjang; ?>" />
                <?php if(currentModul() == 'rekam medik'){ ?>
				<!--
				<a href="#" onclick="window.open('index.php?popup=rmformdiagnosa&idx=<?php echo $irja_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250')" ><input type="button" value="tambah diagnosa" class="myButton1" /></a>
				-->
				<a href="#" onclick="window.open('index.php?popup=rmformtindakan&idx=<?php echo $irja_id; ?>&grp=03','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=550')" ><input type="button" value="tambah tindakan" class="myButton1" /></a>
				<a href="#" onclick="window.open('index.php?popup=rmformpenunjang&idx=<?php echo $irja_id; ?>&grp=15','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=550')" ><input type="button" value="tambah penunjang" class="myButton1" /></a>
				
				<?php } ?>
				<input type="submit" value="simpan" class="myButton1" />
				<input type="button" value="selesai" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('rmicdpasienrawatjalan'); ?>');return false;" />
                </td></tr>
		</table>
</form>	
</div>
<?php } ?>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}
</script>