<table class="tableData" id="tfhover" >
<?php
$qry_biodata = 'SELECT DISTINCT * FROM (SELECT NoMR AS NOMOR_MR,
				"" AS TGLPERTAMADATANG,
				NAMA_KELUARGA,NAMA_SENDIRI,
				`ALMT RT_RW_N0_JLN_NO` AS ALMT_RT_RW_N0_JLN_NO,
				KECAMATAN,KABKODYAPROPINSI,
				"" AS TELEPON,KELAMIN,
				LAHIR,TEMPATLAHIR,
				AGAMA,Type AS TYPEKUSTA,  
				MDT_MULAI,BTA_MH_MULA2,
				PENDIDIKAN,STATUSKAWIN,
				DIKIRIMOLEH,YANGPERLUDIHUBUNGI,
				ALAMATDIATAS,TELEPONDIATAS,
				"" AS BTA_RATA2SEMULA,"" AS TGL_BTA_DIATAS,
				"" AS RFT_COT
				FROM z_kusta_pasien
				WHERE NoMR = "' . $nomr . '"
				UNION
				SELECT NOMOR_MR,
				TGLPERTAMADATANG,
				NAMA_KELUARGA,NAMA_SENDIRI,
				`ALMT RT_RW_N0_JLN_NO` AS ALMT_RT_RW_N0_JLN_NO,
				KECAMATAN,KABKODYAPROPINSI,
				TELEPON,KELAMIN,
				LAHIR,TEMPATLAHIR,
				AGAMA,TYPEKUSTA,
				MDT_MULAI,BTA_MH_MULA2,
				PENDIDIKAN,STATUSKAWIN,
				DIKIRIMOLEH,YANGPERLUDIHUBUNGI,
				ALAMATDIATAS,TELEPONDIATAS,
				"" AS BTA_RATA2SEMULA,"" AS TGL_BTA_DIATAS,
				"" AS RFT_COT
				FROM z_kusta_pasien_1
				WHERE NOMOR_MR = "' . $nomr . '"
				UNION
				SELECT NOMOR_MR,
				"" AS TGLPERTAMADATANG,
				NAMA_KELUARGA,NAMA_SENDIRI,
				`ALMT_RT_RW_NO-JLN` AS ALMT_RT_RW_N0_JLN_NO,
				KECAMATAN,KAB_KODYA_PROPINSI,
				TELEPON,KELAMIN,	
				LAHIR,TEMPATLAHIR,
				AGAMA,TYPE_KUSTA,
				MDT_MULAI,"" AS BTA_MH_MULA2,
				PENDIDIKAN,STATUSKAWIN,
				CARAMASUKRS AS DIKIRIMOLEH,
				YGPERLUDIHUBUNGI,
				ALAMAT_DIATAS AS ALAMATDIATAS,
				TELPN_DIATAS AS TELEPONDIATAS,
				BTA_RATA2SEMULA,TGL_BTA_DIATAS,
				`RFT(COT)` AS RFT_COT
				FROM z_kusta_pasien_masuk
				WHERE NOMOR_MR = "' . $nomr . '"
				) t_pasien';
$get_biodata = mysql_query($qry_biodata) or die(mysql_error());
?>
<tr>
	<th>No</th>
    <th>Nama Pasien</th>
	<th>Nama Keluarga</th>
	<th>Alamat</th>
	<th>Kecamatan</th>
	<th>Kodya/Propinsi</th>
	<th>Telepon</th>
	<th>Jns Kelamin</th>
	<th>Agama</th>
	<th>Pendidikan</th>
	<th>St Kawin</th>
</tr>
<?php
$i = 1;
while ($dat_biodata = mysql_fetch_array($get_biodata)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_biodata['NAMA_SENDIRI']; ?></td>
		<td><?php echo $dat_biodata['NAMA_KELUARGA']; ?></td>
		<td><?php echo $dat_biodata['ALMT_RT_RW_N0_JLN_NO']; ?></td>
		<td><?php echo $dat_biodata['KECAMATAN']; ?></td>
		<td><?php echo $dat_biodata['KABKODYAPROPINSI']; ?></td>
		<td><?php echo $dat_biodata['TELEPON']; ?></td>
		<td><?php echo $dat_biodata['KELAMIN']; ?></td>
		<td><?php echo $dat_biodata['AGAMA']; ?></td>
		<td><?php echo $dat_biodata['PENDIDIKAN']; ?></td>
		<td><?php echo $dat_biodata['STATUSKAWIN']; ?></td>
	</tr>
	<tr>
        <td align="center">&nbsp;</td>
		<td><strong>Tmp Lahir :</strong> <?php echo $dat_biodata['TEMPATLAHIR']; ?></td>
		<td><strong>Tgl Lahir :</strong> <?php echo $dat_biodata['LAHIR']; ?></td>
		<td><strong>Type Kusta :</strong> <?php echo $dat_biodata['TYPEKUSTA']; ?></td>
		<td><strong>Tgl Pertama Dtg :</strong> <?php echo $dat_biodata['TGLPERTAMADATANG']; ?></td>
		<td><strong>BTA MH Mula-mula :</strong> <?php echo $dat_biodata['BTA_MH_MULA2']; ?></td>
		<td colspan="2"><strong>MDT Mulai :</strong> <?php echo $dat_biodata['MDT_MULAI']; ?></td>
		<td><strong>BTA Rata-rata Semula :</strong> <?php echo $dat_biodata['BTA_RATA2SEMULA']; ?></td>
		<td><strong>Tanggal :</strong> <?php echo $dat_biodata['TGL_BTA_DIATAS']; ?></td>
		<td><strong>RFT (COT) :</strong> <?php echo $dat_biodata['RFT_COT']; ?></td>
	</tr>
	<tr>
        <td align="center">&nbsp;</td>
		<td colspan="2"><strong>Dikirim Oleh :</strong> <?php echo $dat_biodata['DIKIRIMOLEH']; ?></td>
		<td colspan="3"><strong>Yg Perlu Dihubungi :</strong> <?php echo $dat_biodata['YANGPERLUDIHUBUNGI']; ?></td>
		<td colspan="3"><strong>Alamat :</strong> <?php echo $dat_biodata['ALAMATDIATAS']; ?></td>
		<td colspan="2"><strong>Telepon :</strong> <?php echo $dat_biodata['TELEPONDIATAS']; ?></td>
	</tr>
    <?php
    $i++;
	}
?>
</table>	