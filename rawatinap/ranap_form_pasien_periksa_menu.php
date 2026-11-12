<?php if($new_rm == ''){ ?>
<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
<table>
	<tr><td>
<? if(isset($_GET['smn']) and $_GET['smn'] == 'bdta') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>		
<? } else { ?>
	<? if (!isset($_GET['smn'])) { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>
	<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>">Identitas</a>
	</div>
	<? } ?>
<? } ?>	

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekam Medik</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Rekam Medik</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rmsk') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Masuk</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Masuk</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'kjam') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'anms') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemeriksaan & Terapi</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=anms&idx=<?php echo $_GET['idx']; ?>" >Pemeriksaan & Terapi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'dgns') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Diagnosa</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>" >Diagnosa</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'alrg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Alergi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>" >Alergi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP (Farmasi)</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP (Farmasi)</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'kpro') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Keperawatan Pra Operasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" >Catatan Keperawatan Pra Operasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'prkb') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpob') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekonsiliasi Obat</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" >Rekonsiliasi Obat</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pemulangan</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'plng') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Keluar</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=plng&idx=<?php echo $_GET['idx']; ?>" >Riwayat Keluar</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'kmtn') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Sebab kematian</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" >Sebab Kematian</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pndh') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pindah Ruang</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" >Pindah Ruang</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
	<div id="mode-maju5">
	<a href="#" style="color:#FF0000;" onclick="view_askep();">Asuhan Keperawatan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="#" onclick="view_askep();" >Asuhan Keperawatan</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmby') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rincian Pembayaran</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" >Rincian Pembayaran</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'scvd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Covid 19</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" >Status Covid 19</a>
	</div>
<? } ?>	
</td></tr>
</table>
</div>
<?php }else{ 
//new erekam medik
?>
<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
<table>
	<tr><td>
<? if(isset($_GET['smn']) and $_GET['smn'] == 'bdta') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>		
<? } else { ?>
	<? if (!isset($_GET['smn'])) { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>
	<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>">Identitas</a>
	</div>
	<? } ?>
<? } ?>	

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekam Medik</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Rekam Medik</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rmsk') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Masuk</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Masuk</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'kjam') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien Terintegrasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien Terintegrasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rsmd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rsmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resume Medis</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rsmd&idx=<?php echo $_GET['idx']; ?>" >Resume Medis</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rspd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rspd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rspd&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lmks') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lembar Konsultasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" >Lembar Konsultasi</a>
		</div>
	<? } ?>
	
</td></tr>
</table>
</div>
<?php }else if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
<div  style="height:auto; margin:5px; padding:5px; margin-bottom:3px; border:1px solid #999; border-radius:5px;  background-color:#C8EFAD; z-index:1;">
<table>
	<tr><td>
<? if(isset($_GET['smn']) and $_GET['smn'] == 'bdta') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>		
<? } else { ?>
	<? if (!isset($_GET['smn'])) { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Identitas</a>
	</div>
	<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=bdta&idx=<?php echo $_GET['idx']; ?>">Identitas</a>
	</div>
	<? } ?>
<? } ?>	

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rwyt') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekam Medik</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rwyt&idx=<?php echo $_GET['idx']; ?>" >Rekam Medik</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rmsk') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Riwayat Masuk</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rmsk&idx=<?php echo $_GET['idx']; ?>" >Riwayat Masuk</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'kjam') { ?>
	<div id="mode-maju5" >
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Medis</a>
	</div>		
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kjam&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Medis</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'cppt') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Perkembangan Pasien Terintegrasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">	
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>" >Catatan Perkembangan Pasien Terintegrasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rsmd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rsmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resume Medis</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rsmd&idx=<?php echo $_GET['idx']; ?>" >Resume Medis</a>
	</div>
<? } ?>
<!--
<? if(isset($_GET['smn']) and $_GET['smn'] == 'askp') { ?>
	<div id="mode-maju5">
	<a href="#" style="color:#FF0000;" onclick="view_askep();">Asuhan Keperawatan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="#" onclick="view_askep();" >Asuhan Keperawatan</a>
	</div>
<? } ?>
-->

<? if(isset($_GET['smn']) and $_GET['smn'] == 'tndk') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tindakan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>" >Tindakan</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'resp') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Resep</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>" >Resep</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'frms') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Obat & BHP (Farmasi)</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=frms&idx=<?php echo $_GET['idx']; ?>" >Obat & BHP (Farmasi)</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lbrm') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>"  style="color:#FF0000; ">Perm. Laboratorium</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>" >Perm. Laboratorium</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rdlg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Radiologi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>" >Perm. Radiologi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnjg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Penunjang Rehab Medik</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnjg&idx=<?php echo $_GET['idx']; ?>" >Perm. Penunjang Rehab Medik</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pekg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. EKG/EEG/USG</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pekg&idx=<?php echo $_GET['idx']; ?>" >Perm. EKG/EEG/USG</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'phmd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Hemodialisa</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>" >Perm. Hemodialisa</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'oprs') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Perm. Operasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>" >Perm. Operasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lpop') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lpop&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Laporan Operasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lpop&idx=<?php echo $_GET['idx']; ?>" >Laporan Operasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pkoh') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pkoh&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lokasi Pem. Lab BTA/ KOH</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pkoh&idx=<?php echo $_GET['idx']; ?>" >Lokasi Pem. Lab BTA/ KOH</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmhs') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmhs&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pem. Lab Histopatologik/ Sitopatologik</a>
		</div>
<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmhs&idx=<?php echo $_GET['idx']; ?>" >Pem. Lab Histopatologik/ Sitopatologik</a>
		</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'lmks') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Lembar Konsultasi</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=lmks&idx=<?php echo $_GET['idx']; ?>" >Lembar Konsultasi</a>
		</div>
	<? } ?>
<!--
<? if(isset($_GET['smn']) and $_GET['smn'] == 'kpro') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Keperawatan Pra Operasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kpro&idx=<?php echo $_GET['idx']; ?>" >Catatan Keperawatan Pra Operasi</a>
	</div>
<? } ?>
-->

<!--
<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpob') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekonsiliasi Obat</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" >Rekonsiliasi Obat</a>
	</div>
<? } ?>
-->

<? if(isset($_GET['smn']) and $_GET['smn'] == 'ktsw') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ktsw&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Kontrol Istimewa</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ktsw&idx=<?php echo $_GET['idx']; ?>" >Kontrol Istimewa</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'petp') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pemberian Edukasi</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=petp&idx=<?php echo $_GET['idx']; ?>" >Pemberian Edukasi</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'rcpl') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rencana Pemulangan</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=rcpl&idx=<?php echo $_GET['idx']; ?>" >Rencana Pemulangan</a>
	</div>
<? } ?>
<!--
<? if(isset($_GET['smn']) and $_GET['smn'] == 'kmtn') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Sebab kematian</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=kmtn&idx=<?php echo $_GET['idx']; ?>" >Sebab Kematian</a>
	</div>
<? } ?>
-->

<? if(isset($_GET['smn']) and $_GET['smn'] == 'trex') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=trex&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Transfer Pasien Eksternal</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=trex&idx=<?php echo $_GET['idx']; ?>" >Transfer Pasien Eksternal</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'srkn') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=srkn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surat Kontrol</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=srkn&idx=<?php echo $_GET['idx']; ?>" >Surat Kontrol</a>
		</div>
	<? } ?>
	
<? if(isset($_GET['smn']) and $_GET['smn'] == 'pndh') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pindah Ruang</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>" >Pindah Ruang</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'scvd') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Covid 19</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=scvd&idx=<?php echo $_GET['idx']; ?>" >Status Covid 19</a>
	</div>
<? } ?>		

<? if(isset($_GET['smn']) and $_GET['smn'] == 'nplg') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=nplg&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Status Pulang</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=nplg&idx=<?php echo $_GET['idx']; ?>" >Status Pulang</a>
	</div>
<? } ?>

<? if(isset($_GET['smn']) and $_GET['smn'] == 'pmby') { ?>
	<div id="mode-maju5">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rincian Pembayaran</a>
	</div>
<? } else { ?>
	<div id="mode-maju">
	<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pmby&idx=<?php echo $_GET['idx']; ?>" >Rincian Pembayaran</a>
	</div>
<? } ?>
</td></tr>
</table>
<table>
	<tr><td>
	<!--askep-->
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pjna') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pjna&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Keperawatan Rawat Inap Umum</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pjna&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Keperawatan Rawat Inap Umum</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pjnk') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pjnk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pengkajian Awal Keperawatan Rawat Inap Kusta</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pjnk&idx=<?php echo $_GET['idx']; ?>" >Pengkajian Awal Keperawatan Rawat Inap Kusta</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ctkp') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ctkp&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Keperawatan</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ctkp&idx=<?php echo $_GET['idx']; ?>" >Catatan Keperawatan</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnsf') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnsf&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Penilaian Status Fungsional</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnsf&idx=<?php echo $_GET['idx']; ?>">Penilaian Status Fungsional</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ctpo') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ctpo&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Catatan Pemberian Obat</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ctpo&idx=<?php echo $_GET['idx']; ?>" >Catatan Pemberian Obat</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpob') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Rekonsiliasi Obat</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>" >Rekonsiliasi Obat</a>
		</div>
	<? } ?>
		
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'peso') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=peso&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Pelaporan Efek Samping Obat</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=peso&idx=<?php echo $_GET['idx']; ?>" >Pelaporan Efek Samping Obat</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'tnsn') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tnsn&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Tensi-Nafas-Suhu-Nadi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=tnsn&idx=<?php echo $_GET['idx']; ?>" >Tensi-Nafas-Suhu-Nadi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'ckmb') { ?>
		<div id="mode-maju5">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ckmb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Intake/Output</a>
		</div>
	<? } else { ?>
		<div id="mode-maju">
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=ckmb&idx=<?php echo $_GET['idx']; ?>" >Intake/Output</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'sppi') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=sppi&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Surveilans Pencegahan & Pengendalian Infeksi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=sppi&idx=<?php echo $_GET['idx']; ?>" >Surveilans Pencegahan & Pengendalian Infeksi</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'mfsc') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=mfsc&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Skala Jatuh Morse</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=mfsc&idx=<?php echo $_GET['idx']; ?>" >Skala Jatuh Morse</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'cpsc') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpsc&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Comfort Scale</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=cpsc&idx=<?php echo $_GET['idx']; ?>" >Comfort Scale</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'snfl') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=snfl&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Skala Nyeri Flacc</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=snfl&idx=<?php echo $_GET['idx']; ?>" >Skala Nyeri Flacc</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'nrwb') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=nrwb&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Numeric Rating Scale & Skala Nyeri Wong Baker</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=nrwb&idx=<?php echo $_GET['idx']; ?>" >Numeric Rating Scale & Skala Nyeri Wong Baker</a>
		</div>
	<? } ?>
	
	<? if(isset($_GET['smn']) and $_GET['smn'] == 'asgz') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=asgz&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Asuhan Gizi</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=asgz&idx=<?php echo $_GET['idx']; ?>" >Asuhan Gizi</a>
		</div>
	<? } ?>


<!--<? if(isset($_GET['smn']) and $_GET['smn'] == 'pstj') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pstj&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Persetujuan Tindakan Kedokteran</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pstj&idx=<?php echo $_GET['idx']; ?>" >Persetujuan Tindakan Kedokteran</a>
		</div>
	<? } ?>

	<? if(isset($_GET['smn']) and $_GET['smn'] == 'pnlk') { ?>
		<div id="mode-maju5" >
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnlk&idx=<?php echo $_GET['idx']; ?>" style="color:#FF0000; ">Penolakan Tindakan Kedokteran</a>
		</div>		
	<? } else { ?>
		<div id="mode-maju">	
		<a href="index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=pnlk&idx=<?php echo $_GET['idx']; ?>" >Penolakan Tindakan Kedokteran</a>
		</div>
	<? } ?>
-->
	<!--end askep-->
	</td></tr>
</table>	
</div>
<?php } ?>

<?php } ?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if(!isset($_GET['smn'])){
	include('rawatinap/ranap_form_biodata.php');
}else{
	if($_GET['smn'] == 'bdta') include('rawatinap/ranap_form_biodata.php');
	if($_GET['smn'] == 'rmsk') include('rawatinap/ranap_form_riwayat_masuk.php');
	if($_GET['smn'] == 'prkb') include('rawatinap/ranap_form_perkembangan.php');
	if($_GET['smn'] == 'tndk') include('rawatinap/ranap_form_tindakan.php');	
	if($_GET['smn'] == 'lbrm') include('rawatinap/ranap_form_laboratorium.php');
	if($_GET['smn'] == 'rdlg') include('rawatinap/ranap_form_radiologi.php');
	if($_GET['smn'] == 'pnjg') include('rawatinap/ranap_form_penunjang.php');
	if($_GET['smn'] == 'resp') include('rawatinap/ranap_form_resep.php');
	if($_GET['smn'] == 'frms') include('rawatinap/ranap_form_farmasi.php');
	if($_GET['smn'] == 'cpob') include('rawatinap/ranap_form_rekonsiliasi_obat.php');
	if($_GET['smn'] == 'plng') include('rawatinap/ranap_form_pulang.php');
	if($_GET['smn'] == 'kmtn') include('rawatinap/ranap_form_sebab_kematian.php');
	if($_GET['smn'] == 'ckmb') include('rawatinap/ranap_form_catatan_keluar_masuk.php');
	if($_GET['smn'] == 'pndh') include('rawatinap/ranap_form_pindah_kamar.php');
	if($_GET['smn'] == 'pekg') include('rawatinap/ranap_form_penunjang_ekg.php');
	if($_GET['smn'] == 'alrg') include('rawatinap/ranap_form_alergi.php');
	if($_GET['smn'] == 'anms') include('rawatinap/ranap_form_anamnesis.php');
	if($_GET['smn'] == 'pmby') include('rawatinap/ranap_form_pembayaran.php');
	if($_GET['smn'] == 'oprs') include('rawatinap/ranap_form_operasi.php');
	if($_GET['smn'] == 'kpro') include('operasi/operasi_form_catatan_keperawatan_praoperasi.php');
	if($_GET['smn'] == 'lpop') include('operasi/operasi_form_laporan_pembedahan.php');
	if($_GET['smn'] == 'rwyt') include('rawatinap/ranap_form_riwayat_pasien.php');
	if($_GET['smn'] == 'phmd') include('rawatinap/ranap_form_hemodialisa.php');
	if($_GET['smn'] == 'kjam') include('rawatinap/ranap_form_pengkajian_awal.php');
	if($_GET['smn'] == 'dgns') include('rawatinap/ranap_form_diagnosa.php');
	if($_GET['smn'] == 'rcpl') include('rawatinap/ranap_form_rencana_pulang.php');
	if($_GET['smn'] == 'petp') include('rawatinap/ranap_form_edukasi_pasien.php');
	if($_GET['smn'] == 'scvd') include('rawatinap/ranap_form_covid.php');
	if($_GET['smn'] == 'cppt') include('rawatinap/ranap_form_perkembangan_pasien_terintegrasi.php');
	if($_GET['smn'] == 'vpnj') include('rawatinap/ranap_form_pemeriksaan_penunjang.php');
	if($_GET['smn'] == 'rspd') include('rawatinap/ranap_form_resep.php');
	if($_GET['smn'] == 'rsmd') include('rawatinap/ranap_form_resume_medis.php');
	if($_GET['smn'] == 'pakp') include('rawatinap/ranap_form_pengkajian_awal_keperawatan.php');
	if($_GET['smn'] == 'nplg') include('rawatinap/ranap_form_status_pulang.php');
	if($_GET['smn'] == 'lmks') include('rawatinap/ranap_form_lembar_konsul.php');
	if($_GET['smn'] == 'trex') include('rawatinap/ranap_form_transfer_eksternal.php');
	if($_GET['smn'] == 'srkn') include('rawatinap/ranap_form_surat_kontrol.php');
	if($_GET['smn'] == 'ktsw') include('rawatinap/ranap_form_kontrol_istimewa.php');
	if($_GET['smn'] == 'pmhs') include('rawatinap/ranap_form_histopatologik_sitopatologik.php');
	if($_GET['smn'] == 'pkoh') include('rawatinap/ranap_form_koh.php');
	if($_GET['smn'] == 'asgz') include('rawatinap/ranap_form_asuhan_gizi.php');
	//if($_GET['smn'] == 'pstj') include('rawatinap/ranap_form_operasi_persetujuan_dokter.php');
	//if($_GET['smn'] == 'pnlk') include('rawatinap/ranap_form_operasi_penolakan_dokter.php');
	//if($_GET['smn'] == 'pnlk') include('rawatinap/ranap_maintain.php');
	//if($_GET['smn'] == 'pstj') include('rawatinap/ranap_maintain.php');
	
	if($_GET['smn'] == 'pnsf') include('askep/askep_form_status_fungsional.php');
	if($_GET['smn'] == 'pjna') include('askep/askep_form_pengkajian_awal.php');
	if($_GET['smn'] == 'ctkp') include('askep/askep_form_catatan_keperawatan.php');
	if($_GET['smn'] == 'ctpo') include('askep/askep_form_catatan_pemberian_obat.php');
	if($_GET['smn'] == 'peso') include('askep/askep_form_pelaporan_eso.php');
	if($_GET['smn'] == 'tnsn') include('askep/askep_form_pemeriksaan_fisik.php');
	if($_GET['smn'] == 'sppi') include('askep/askep_form_pengendalian_infeksi.php');
	if($_GET['smn'] == 'mfsc') include('askep/askep_form_morsefall_scale.php');
	if($_GET['smn'] == 'cpsc') include('askep/askep_form_comport_scale.php');
	if($_GET['smn'] == 'snfl') include('askep/askep_form_skala_nyeri_flacc.php');
	if($_GET['smn'] == 'nrwb') include('askep/askep_form_numeric_rating_scale.php');
	if($_GET['smn'] == 'ckmb') include('askep/askep_form_catatan_keluar_masuk.php');
	if($_GET['smn'] == 'pjnk') include('askep/askep_form_pengkajian_awal_kusta.php');  

}
?>
</div>