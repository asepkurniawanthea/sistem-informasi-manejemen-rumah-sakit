<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 2</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 2</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>KETENAGAAN</h1></td></tr>
			</table>
		
			<form action="index.php?link=rl2" method="post">
			<?php 
				$date = date('Y') - 10;
				$koders	= isset($_REQUEST['kode_rs']) ? $_REQUEST['kode_rs'] : '';
				$namars	= isset($_REQUEST['nama_rs']) ? $_REQUEST['nama_rs'] : '';
				$tahun	= isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
				
				if(isset($_POST['submit'])){
					if($_POST['submit'] == 'Simpan'){
							$tenaga_1_1		= isset($_REQUEST['tenaga_1_1'])  ? implode('-',$_REQUEST['tenaga_1_1']) : 0;
							$tenaga_1_2		= isset($_REQUEST['tenaga_1_2'])  ? implode('-',$_REQUEST['tenaga_1_2']) : 0;
							$tenaga_1_3		= isset($_REQUEST['tenaga_1_3'])  ? implode('-',$_REQUEST['tenaga_1_3']) : 0;
							$tenaga_1_4		= isset($_REQUEST['tenaga_1_4'])  ? implode('-',$_REQUEST['tenaga_1_4']) : 0;
							$tenaga_1_5		= isset($_REQUEST['tenaga_1_5'])  ? implode('-',$_REQUEST['tenaga_1_5']) : 0;
							$tenaga_1_6		= isset($_REQUEST['tenaga_1_6'])  ? implode('-',$_REQUEST['tenaga_1_6']) : 0;
							$tenaga_1_7		= isset($_REQUEST['tenaga_1_7'])  ? implode('-',$_REQUEST['tenaga_1_7']) : 0;
							$tenaga_1_8		= isset($_REQUEST['tenaga_1_8'])  ? implode('-',$_REQUEST['tenaga_1_8']) : 0;
							$tenaga_1_9		= isset($_REQUEST['tenaga_1_9'])  ? implode('-',$_REQUEST['tenaga_1_9']) : 0;
							$tenaga_1_10	= isset($_REQUEST['tenaga_1_10'])  ? implode('-',$_REQUEST['tenaga_1_10']) : 0;
							$tenaga_1_11	= isset($_REQUEST['tenaga_1_11'])  ? implode('-',$_REQUEST['tenaga_1_11']) : 0;
							$tenaga_1_12	= isset($_REQUEST['tenaga_1_12'])  ? implode('-',$_REQUEST['tenaga_1_12']) : 0;
							$tenaga_1_13	= isset($_REQUEST['tenaga_1_13'])  ? implode('-',$_REQUEST['tenaga_1_13']) : 0;
							$tenaga_1_14	= isset($_REQUEST['tenaga_1_14'])  ? implode('-',$_REQUEST['tenaga_1_14']) : 0;
							$tenaga_1_15	= isset($_REQUEST['tenaga_1_15'])  ? implode('-',$_REQUEST['tenaga_1_15']) : 0;
							$tenaga_1_16	= isset($_REQUEST['tenaga_1_16'])  ? implode('-',$_REQUEST['tenaga_1_16']) : 0;
							$tenaga_1_17	= isset($_REQUEST['tenaga_1_17'])  ? implode('-',$_REQUEST['tenaga_1_17']) : 0;
							$tenaga_1_18	= isset($_REQUEST['tenaga_1_18'])  ? implode('-',$_REQUEST['tenaga_1_18']) : 0;
							$tenaga_1_19	= isset($_REQUEST['tenaga_1_19'])  ? implode('-',$_REQUEST['tenaga_1_19']) : 0;
							$tenaga_1_20	= isset($_REQUEST['tenaga_1_20'])  ? implode('-',$_REQUEST['tenaga_1_20']) : 0;
							$tenaga_1_21	= isset($_REQUEST['tenaga_1_21'])  ? implode('-',$_REQUEST['tenaga_1_21']) : 0;
							$tenaga_1_22	= isset($_REQUEST['tenaga_1_22'])  ? implode('-',$_REQUEST['tenaga_1_22']) : 0;
							$tenaga_1_23	= isset($_REQUEST['tenaga_1_23'])  ? implode('-',$_REQUEST['tenaga_1_23']) : 0;
							$tenaga_1_24	= isset($_REQUEST['tenaga_1_24'])  ? implode('-',$_REQUEST['tenaga_1_24']) : 0;
							$tenaga_1_25	= isset($_REQUEST['tenaga_1_25'])  ? implode('-',$_REQUEST['tenaga_1_25']) : 0;
							$tenaga_1_26	= isset($_REQUEST['tenaga_1_26'])  ? implode('-',$_REQUEST['tenaga_1_26']) : 0;
							$tenaga_1_27	= isset($_REQUEST['tenaga_1_27'])  ? implode('-',$_REQUEST['tenaga_1_27']) : 0;
							$tenaga_1_28	= isset($_REQUEST['tenaga_1_28'])  ? implode('-',$_REQUEST['tenaga_1_28']) : 0;
							$tenaga_1_29	= isset($_REQUEST['tenaga_1_29'])  ? implode('-',$_REQUEST['tenaga_1_29']) : 0;
							$tenaga_1_30	= isset($_REQUEST['tenaga_1_30'])  ? implode('-',$_REQUEST['tenaga_1_30']) : 0;
							$tenaga_1_31	= isset($_REQUEST['tenaga_1_31'])  ? implode('-',$_REQUEST['tenaga_1_31']) : 0;
							$tenaga_1_32	= isset($_REQUEST['tenaga_1_32'])  ? implode('-',$_REQUEST['tenaga_1_32']) : 0;
							$tenaga_1_33	= isset($_REQUEST['tenaga_1_33'])  ? implode('-',$_REQUEST['tenaga_1_33']) : 0;
							$tenaga_1_34	= isset($_REQUEST['tenaga_1_34'])  ? implode('-',$_REQUEST['tenaga_1_34']) : 0;
							$tenaga_1_35	= isset($_REQUEST['tenaga_1_35'])  ? implode('-',$_REQUEST['tenaga_1_35']) : 0;
							$tenaga_1_36	= isset($_REQUEST['tenaga_1_36'])  ? implode('-',$_REQUEST['tenaga_1_36']) : 0;
							$tenaga_1_37	= isset($_REQUEST['tenaga_1_37'])  ? implode('-',$_REQUEST['tenaga_1_37']) : 0;
							
							$tenaga_2_1		= isset($_REQUEST['tenaga_2_1'])  ? implode('-',$_REQUEST['tenaga_2_1']) : 0;
							$tenaga_2_2		= isset($_REQUEST['tenaga_2_2'])  ? implode('-',$_REQUEST['tenaga_2_2']) : 0;
							$tenaga_2_3		= isset($_REQUEST['tenaga_2_3'])  ? implode('-',$_REQUEST['tenaga_2_3']) : 0;
							$tenaga_2_4		= isset($_REQUEST['tenaga_2_4'])  ? implode('-',$_REQUEST['tenaga_2_4']) : 0;
							$tenaga_2_5		= isset($_REQUEST['tenaga_2_5'])  ? implode('-',$_REQUEST['tenaga_2_5']) : 0;
							$tenaga_2_6		= isset($_REQUEST['tenaga_2_6'])  ? implode('-',$_REQUEST['tenaga_2_6']) : 0;
							$tenaga_2_7		= isset($_REQUEST['tenaga_2_7'])  ? implode('-',$_REQUEST['tenaga_2_7']) : 0;
							$tenaga_2_8		= isset($_REQUEST['tenaga_2_8'])  ? implode('-',$_REQUEST['tenaga_2_8']) : 0;
							$tenaga_2_9		= isset($_REQUEST['tenaga_2_9'])  ? implode('-',$_REQUEST['tenaga_2_9']) : 0;
							$tenaga_2_10	= isset($_REQUEST['tenaga_2_10'])  ? implode('-',$_REQUEST['tenaga_2_10']) : 0;
							$tenaga_2_11	= isset($_REQUEST['tenaga_2_11'])  ? implode('-',$_REQUEST['tenaga_2_11']) : 0;
							$tenaga_2_12	= isset($_REQUEST['tenaga_2_12'])  ? implode('-',$_REQUEST['tenaga_2_12']) : 0;
							
							$tenaga_3_1		= isset($_REQUEST['tenaga_3_1'])  ? implode('-',$_REQUEST['tenaga_3_1']) : 0;
							$tenaga_3_2		= isset($_REQUEST['tenaga_3_2'])  ? implode('-',$_REQUEST['tenaga_3_2']) : 0;
							$tenaga_3_3		= isset($_REQUEST['tenaga_3_3'])  ? implode('-',$_REQUEST['tenaga_3_3']) : 0;
							$tenaga_3_4		= isset($_REQUEST['tenaga_3_4'])  ? implode('-',$_REQUEST['tenaga_3_4']) : 0;
							$tenaga_3_5		= isset($_REQUEST['tenaga_3_5'])  ? implode('-',$_REQUEST['tenaga_3_5']) : 0;
							$tenaga_3_6		= isset($_REQUEST['tenaga_3_6'])  ? implode('-',$_REQUEST['tenaga_3_6']) : 0;
							$tenaga_3_7		= isset($_REQUEST['tenaga_3_7'])  ? implode('-',$_REQUEST['tenaga_3_7']) : 0;
							$tenaga_3_8		= isset($_REQUEST['tenaga_3_8'])  ? implode('-',$_REQUEST['tenaga_3_8']) : 0;
							$tenaga_3_9		= isset($_REQUEST['tenaga_3_9'])  ? implode('-',$_REQUEST['tenaga_3_9']) : 0;
							$tenaga_3_10	= isset($_REQUEST['tenaga_3_10'])  ? implode('-',$_REQUEST['tenaga_3_10']) : 0;
							
							$tenaga_4_1		= isset($_REQUEST['tenaga_4_1'])  ? implode('-',$_REQUEST['tenaga_4_1']) : 0;
							$tenaga_4_2		= isset($_REQUEST['tenaga_4_2'])  ? implode('-',$_REQUEST['tenaga_4_2']) : 0;
							$tenaga_4_3		= isset($_REQUEST['tenaga_4_3'])  ? implode('-',$_REQUEST['tenaga_4_3']) : 0;
							$tenaga_4_4		= isset($_REQUEST['tenaga_4_4'])  ? implode('-',$_REQUEST['tenaga_4_4']) : 0;
							$tenaga_4_5		= isset($_REQUEST['tenaga_4_5'])  ? implode('-',$_REQUEST['tenaga_4_5']) : 0;
							$tenaga_4_6		= isset($_REQUEST['tenaga_4_6'])  ? implode('-',$_REQUEST['tenaga_4_6']) : 0;
							$tenaga_4_7		= isset($_REQUEST['tenaga_4_7'])  ? implode('-',$_REQUEST['tenaga_4_7']) : 0;
							$tenaga_4_8		= isset($_REQUEST['tenaga_4_8'])  ? implode('-',$_REQUEST['tenaga_4_8']) : 0;
							$tenaga_4_9		= isset($_REQUEST['tenaga_4_9'])  ? implode('-',$_REQUEST['tenaga_4_9']) : 0;
							$tenaga_4_10	= isset($_REQUEST['tenaga_4_10'])  ? implode('-',$_REQUEST['tenaga_4_10']) : 0;
							$tenaga_4_11	= isset($_REQUEST['tenaga_4_11'])  ? implode('-',$_REQUEST['tenaga_4_11']) : 0;
							$tenaga_4_12	= isset($_REQUEST['tenaga_4_12'])  ? implode('-',$_REQUEST['tenaga_4_12']) : 0;
							$tenaga_4_13	= isset($_REQUEST['tenaga_4_13'])  ? implode('-',$_REQUEST['tenaga_4_13']) : 0;
							
							$tenaga_5_1	= isset($_REQUEST['tenaga_5_1'])  ? implode('-',$_REQUEST['tenaga_5_1']) : 0;
							$tenaga_5_2	= isset($_REQUEST['tenaga_5_2'])  ? implode('-',$_REQUEST['tenaga_5_2']) : 0;
							$tenaga_5_3	= isset($_REQUEST['tenaga_5_3'])  ? implode('-',$_REQUEST['tenaga_5_3']) : 0;
							$tenaga_5_4	= isset($_REQUEST['tenaga_5_4'])  ? implode('-',$_REQUEST['tenaga_5_4']) : 0;
							$tenaga_5_5	= isset($_REQUEST['tenaga_5_5'])  ? implode('-',$_REQUEST['tenaga_5_5']) : 0;
							$tenaga_5_6	= isset($_REQUEST['tenaga_5_6'])  ? implode('-',$_REQUEST['tenaga_5_6']) : 0;
							$tenaga_5_7	= isset($_REQUEST['tenaga_5_7'])  ? implode('-',$_REQUEST['tenaga_5_7']) : 0;
							
							$tenaga_6_1	= isset($_REQUEST['tenaga_6_1'])  ? implode('-',$_REQUEST['tenaga_6_1']) : 0;
							$tenaga_6_2	= isset($_REQUEST['tenaga_6_2'])  ? implode('-',$_REQUEST['tenaga_6_2']) : 0;
							$tenaga_6_3	= isset($_REQUEST['tenaga_6_3'])  ? implode('-',$_REQUEST['tenaga_6_3']) : 0;
							$tenaga_6_4	= isset($_REQUEST['tenaga_6_4'])  ? implode('-',$_REQUEST['tenaga_6_4']) : 0;
							$tenaga_6_5	= isset($_REQUEST['tenaga_6_5'])  ? implode('-',$_REQUEST['tenaga_6_5']) : 0;
							$tenaga_6_6	= isset($_REQUEST['tenaga_6_6'])  ? implode('-',$_REQUEST['tenaga_6_6']) : 0;
							$tenaga_6_7	= isset($_REQUEST['tenaga_6_7'])  ? implode('-',$_REQUEST['tenaga_6_7']) : 0;
							
							$tenaga_7_1		= isset($_REQUEST['tenaga_7_1'])  ? implode('-',$_REQUEST['tenaga_7_1']) : 0;
							$tenaga_7_2		= isset($_REQUEST['tenaga_7_2'])  ? implode('-',$_REQUEST['tenaga_7_2']) : 0;
							$tenaga_7_3		= isset($_REQUEST['tenaga_7_3'])  ? implode('-',$_REQUEST['tenaga_7_3']) : 0;
							$tenaga_7_4		= isset($_REQUEST['tenaga_7_4'])  ? implode('-',$_REQUEST['tenaga_7_4']) : 0;
							$tenaga_7_5		= isset($_REQUEST['tenaga_7_5'])  ? implode('-',$_REQUEST['tenaga_7_5']) : 0;
							$tenaga_7_6		= isset($_REQUEST['tenaga_7_6'])  ? implode('-',$_REQUEST['tenaga_7_6']) : 0;
							$tenaga_7_7		= isset($_REQUEST['tenaga_7_7'])  ? implode('-',$_REQUEST['tenaga_7_7']) : 0;
							$tenaga_7_8		= isset($_REQUEST['tenaga_7_8'])  ? implode('-',$_REQUEST['tenaga_7_8']) : 0;
							$tenaga_7_9		= isset($_REQUEST['tenaga_7_9'])  ? implode('-',$_REQUEST['tenaga_7_9']) : 0;
							$tenaga_7_10	= isset($_REQUEST['tenaga_7_10'])  ? implode('-',$_REQUEST['tenaga_7_10']) : 0;
							$tenaga_7_11	= isset($_REQUEST['tenaga_7_11'])  ? implode('-',$_REQUEST['tenaga_7_11']) : 0;
							$tenaga_7_12	= isset($_REQUEST['tenaga_7_12'])  ? implode('-',$_REQUEST['tenaga_7_12']) : 0;
							$tenaga_7_13	= isset($_REQUEST['tenaga_7_13'])  ? implode('-',$_REQUEST['tenaga_7_13']) : 0;
							$tenaga_7_14	= isset($_REQUEST['tenaga_7_14'])  ? implode('-',$_REQUEST['tenaga_7_14']) : 0;
							$tenaga_7_15	= isset($_REQUEST['tenaga_7_15'])  ? implode('-',$_REQUEST['tenaga_7_15']) : 0;
							$tenaga_7_16	= isset($_REQUEST['tenaga_7_16'])  ? implode('-',$_REQUEST['tenaga_7_16']) : 0;
							$tenaga_7_17	= isset($_REQUEST['tenaga_7_17'])  ? implode('-',$_REQUEST['tenaga_7_17']) : 0;
							$tenaga_7_18	= isset($_REQUEST['tenaga_7_18'])  ? implode('-',$_REQUEST['tenaga_7_18']) : 0;
							$tenaga_7_19	= isset($_REQUEST['tenaga_7_19'])  ? implode('-',$_REQUEST['tenaga_7_19']) : 0;
							$tenaga_7_20	= isset($_REQUEST['tenaga_7_20'])  ? implode('-',$_REQUEST['tenaga_7_20']) : 0;
							$tenaga_7_21	= isset($_REQUEST['tenaga_7_21'])  ? implode('-',$_REQUEST['tenaga_7_21']) : 0;
							$tenaga_7_22	= isset($_REQUEST['tenaga_7_22'])  ? implode('-',$_REQUEST['tenaga_7_22']) : 0;
							$tenaga_7_23	= isset($_REQUEST['tenaga_7_23'])  ? implode('-',$_REQUEST['tenaga_7_23']) : 0;
							
							$tenaga_8_1		= isset($_REQUEST['tenaga_8_1'])  ? implode('-',$_REQUEST['tenaga_8_1']) : 0;
							$tenaga_8_2		= isset($_REQUEST['tenaga_8_2'])  ? implode('-',$_REQUEST['tenaga_8_2']) : 0;
							$tenaga_8_3		= isset($_REQUEST['tenaga_8_3'])  ? implode('-',$_REQUEST['tenaga_8_3']) : 0;
							$tenaga_8_4		= isset($_REQUEST['tenaga_8_4'])  ? implode('-',$_REQUEST['tenaga_8_4']) : 0;
							$tenaga_8_5		= isset($_REQUEST['tenaga_8_5'])  ? implode('-',$_REQUEST['tenaga_8_5']) : 0;
							$tenaga_8_6		= isset($_REQUEST['tenaga_8_6'])  ? implode('-',$_REQUEST['tenaga_8_6']) : 0;
							$tenaga_8_7		= isset($_REQUEST['tenaga_8_7'])  ? implode('-',$_REQUEST['tenaga_8_7']) : 0;
							$tenaga_8_8		= isset($_REQUEST['tenaga_8_8'])  ? implode('-',$_REQUEST['tenaga_8_8']) : 0;
							$tenaga_8_9		= isset($_REQUEST['tenaga_8_9'])  ? implode('-',$_REQUEST['tenaga_8_9']) : 0;
							$tenaga_8_10	= isset($_REQUEST['tenaga_8_10'])  ? implode('-',$_REQUEST['tenaga_8_10']) : 0;
							$tenaga_8_11	= isset($_REQUEST['tenaga_8_11'])  ? implode('-',$_REQUEST['tenaga_8_11']) : 0;
							
							$tenaga_9_1		= isset($_REQUEST['tenaga_9_1'])  ? implode('-',$_REQUEST['tenaga_9_1']) : 0;
							$tenaga_9_2		= isset($_REQUEST['tenaga_9_2'])  ? implode('-',$_REQUEST['tenaga_9_2']) : 0;
							$tenaga_9_3		= isset($_REQUEST['tenaga_9_3'])  ? implode('-',$_REQUEST['tenaga_9_3']) : 0;
							$tenaga_9_4		= isset($_REQUEST['tenaga_9_4'])  ? implode('-',$_REQUEST['tenaga_9_4']) : 0;
							$tenaga_9_5		= isset($_REQUEST['tenaga_9_5'])  ? implode('-',$_REQUEST['tenaga_9_5']) : 0;
							$tenaga_9_6		= isset($_REQUEST['tenaga_9_6'])  ? implode('-',$_REQUEST['tenaga_9_6']) : 0;
							$tenaga_9_7		= isset($_REQUEST['tenaga_9_7'])  ? implode('-',$_REQUEST['tenaga_9_7']) : 0;
							$tenaga_9_8		= isset($_REQUEST['tenaga_9_8'])  ? implode('-',$_REQUEST['tenaga_9_8']) : 0;
							$tenaga_9_9		= isset($_REQUEST['tenaga_9_9'])  ? implode('-',$_REQUEST['tenaga_9_9']) : 0;
							$tenaga_9_10	= isset($_REQUEST['tenaga_9_10'])  ? implode('-',$_REQUEST['tenaga_9_10']) : 0;
							$tenaga_9_11	= isset($_REQUEST['tenaga_9_11'])  ? implode('-',$_REQUEST['tenaga_9_11']) : 0;
							$tenaga_9_12	= isset($_REQUEST['tenaga_9_12'])  ? implode('-',$_REQUEST['tenaga_9_12']) : 0;
							
							$tenaga_10_1	= isset($_REQUEST['tenaga_10_1'])  ? implode('-',$_REQUEST['tenaga_10_1']) : 0;
							$tenaga_10_2	= isset($_REQUEST['tenaga_10_2'])  ? implode('-',$_REQUEST['tenaga_10_2']) : 0;
							$tenaga_10_3	= isset($_REQUEST['tenaga_10_3'])  ? implode('-',$_REQUEST['tenaga_10_3']) : 0;
							$tenaga_10_4	= isset($_REQUEST['tenaga_10_4'])  ? implode('-',$_REQUEST['tenaga_10_4']) : 0;
							$tenaga_10_5	= isset($_REQUEST['tenaga_10_5'])  ? implode('-',$_REQUEST['tenaga_10_5']) : 0;
							$tenaga_10_6	= isset($_REQUEST['tenaga_10_6'])  ? implode('-',$_REQUEST['tenaga_10_6']) : 0;
							$tenaga_10_7	= isset($_REQUEST['tenaga_10_7'])  ? implode('-',$_REQUEST['tenaga_10_7']) : 0;
							$tenaga_10_8	= isset($_REQUEST['tenaga_10_8'])  ? implode('-',$_REQUEST['tenaga_10_8']) : 0;
							$tenaga_10_9	= isset($_REQUEST['tenaga_10_9'])  ? implode('-',$_REQUEST['tenaga_10_9']) : 0;
							$tenaga_10_10	= isset($_REQUEST['tenaga_10_10'])  ? implode('-',$_REQUEST['tenaga_10_10']) : 0;
							$tenaga_10_11	= isset($_REQUEST['tenaga_10_11'])  ? implode('-',$_REQUEST['tenaga_10_11']) : 0;
							
							$tenaga_11_1	= isset($_REQUEST['tenaga_11_1'])  ? implode('-',$_REQUEST['tenaga_11_1']) : 0;
							$tenaga_11_2	= isset($_REQUEST['tenaga_11_2'])  ? implode('-',$_REQUEST['tenaga_11_2']) : 0;
							$tenaga_11_3	= isset($_REQUEST['tenaga_11_3'])  ? implode('-',$_REQUEST['tenaga_11_3']) : 0;
							$tenaga_11_4	= isset($_REQUEST['tenaga_11_4'])  ? implode('-',$_REQUEST['tenaga_11_4']) : 0;
							$tenaga_11_5	= isset($_REQUEST['tenaga_11_5'])  ? implode('-',$_REQUEST['tenaga_11_5']) : 0;
							$tenaga_11_6	= isset($_REQUEST['tenaga_11_6'])  ? implode('-',$_REQUEST['tenaga_11_6']) : 0;
							$tenaga_11_7	= isset($_REQUEST['tenaga_11_7'])  ? implode('-',$_REQUEST['tenaga_11_7']) : 0;
							$tenaga_11_8	= isset($_REQUEST['tenaga_11_8'])  ? implode('-',$_REQUEST['tenaga_11_8']) : 0;
							$tenaga_11_9	= isset($_REQUEST['tenaga_11_9'])  ? implode('-',$_REQUEST['tenaga_11_9']) : 0;
							$tenaga_11_10	= isset($_REQUEST['tenaga_11_10'])  ? implode('-',$_REQUEST['tenaga_11_10']) : 0;
							$tenaga_11_11	= isset($_REQUEST['tenaga_11_11'])  ? implode('-',$_REQUEST['tenaga_11_11']) : 0;
							
							$tenaga_12_1	= isset($_REQUEST['tenaga_12_1'])  ? implode('-',$_REQUEST['tenaga_12_1']) : 0;
							$tenaga_12_2	= isset($_REQUEST['tenaga_12_2'])  ? implode('-',$_REQUEST['tenaga_12_2']) : 0;
							$tenaga_12_3	= isset($_REQUEST['tenaga_12_3'])  ? implode('-',$_REQUEST['tenaga_12_3']) : 0;
							$tenaga_12_4	= isset($_REQUEST['tenaga_12_4'])  ? implode('-',$_REQUEST['tenaga_12_4']) : 0;
							$tenaga_12_5	= isset($_REQUEST['tenaga_12_5'])  ? implode('-',$_REQUEST['tenaga_12_5']) : 0;
							$tenaga_12_6	= isset($_REQUEST['tenaga_12_6'])  ? implode('-',$_REQUEST['tenaga_12_6']) : 0;
							$tenaga_12_7	= isset($_REQUEST['tenaga_12_7'])  ? implode('-',$_REQUEST['tenaga_12_7']) : 0;
							$tenaga_12_8	= isset($_REQUEST['tenaga_12_8'])  ? implode('-',$_REQUEST['tenaga_12_8']) : 0;	
							
							$check	= mysql_query('select tahun from m_ketenagaan_data where tahun = "'.$tahun.'"');
							if(mysql_num_rows($check) > 0){
								mysql_query('delete m_ketenagaan_data where tahun = "'.$tahun.'"');
							}
							
							$sql	= mysql_query('insert into m_ketenagaan_data (dokter_umum,dokter_ppds, dokter_spes_bedah, dokter_spes_penyakit_dalam, dokter_spes_kes_anak, dokter_spes_obgin, 
dokter_spes_radiologi,dokter_spes_onkologi_radiasi, dokter_spes_kedokteran_nuklir, dokter_spes_anesthesi, dokter_spes_patologi_klinik, dokter_spes_jiwa, 
dokter_spes_mata, dokter_spes_tht, dokter_spes_kulit_kelamin, dokter_spes_kardiologi, dokter_spes_paru, dokter_spes_saraf, dokter_spes_bedah_saraf,
dokter_spes_bedah_orthopedi, dokter_spes_urologi, dokter_spes_patologi_anatomi, dokter_spes_patologi_forensik, dokter_spes_rehabilitasi_medik,
dokter_spes_bedah_plastik, dokter_spes_ked_olah_raga, dokter_spes_mikrobiologi_klinik, dokter_spes_parasitologi_klinik, dokter_spes_gizi_medik,
dokter_spes_farma_klinik,  dokter_spes_lainnya, dokter_sub_spesialis_lainnya, dokter_gigi, dokter_gigi_spesialis, dokter_gigi_mhamars, dokter_gigi_s2s3_kes_masy,
s3_dokter_konsultan, s3_keperawatan, s2_keperawatan, s1_keperawatan, d4_keperawatan, perawat_vokasional, perawat_spesialis, pembantu_keperawatan, s3_kebidanan,
s2_kebidanan, s1_kebidanan, d3_kebidanan, tenaga_keperawatan_lainnya, s3_farmasi_apoteker, s2_farmasi_apoteker, apoteker, s1_farmasi_farmakologi_kimia, akafarma,
akfar, analis_farmasi, asisten_apoteker_smf, st_lab_kimia_farmasi, tenaga_kefarmasian_lainnya, s3_kesehatan_masyarakat,
s3_epidemiologi, s3_psikologi, s2_kesehatan_masyarakat, s2_epidemiologi, s2_biomedik, s2_psikologi, s1_kesehatan_masyarakat, s1_psikologi,d3_kesehatan_masyarakat,
d3_sanitarian, d1_sanitarian, tenaga_kesehatan_masy_lainnya, s3_gizi_dietisien, s2_gizi_dietisien, s1_gizi_dietisien, d4_gizi_dietisien, akademi_d3_gizi_dietisien,
d1_gizi_dietisien, tenaga_gizi_lainnya, s1_fisio_terapis, d3_fisio_terapis, d3_okupasi_terapis, d3_terapi_wicara, d3_orthopedi, d3_akupuntur, tenaga_keterapian_fisik_lainnya,
s3_opto_elektronika_apl_laser, s2_opto_elektronika_apl_laser, radiografer, radioterapis_non_dokter, d4_fisika_medik, d3_teknik_gigi, d3_teknik_radiologi_radioterapi,
d3_refraksionis_optisien, d3_perekam_medis, d3_teknik_elektromedik, d3_analis_kesehatan, d3_informasi_kesehatan, d3_kardiovaskular, d3_orthotik_prostetik, d1_teknik_tranfusi,
teknisi_gigi, tenaga_it_dengan_teknologi_nano, teknisi_patologi_anatomi, teknisi_kardiovaskuler, teknisi_elektromedis, akupuntur_terapi, analis_kesehatan, tenaga_teknis_medis_lainnya,
s3_biologi, s3_kimia, s3_ekonomi_akuntansi, s3_administrasi, s3_hukum, s3_tehnik, s3_kes_sosial, s3_fisika, s3_komputer, s3_statistik, doktoral_lainnya_s3, s2_biologi,
s2_kimia, s2_ekonomi_akuntansi, s2_administrasi, s2_hukum, s2_tehnik, s2_kesejahteraan_sosial, s2_fisika, s2_komputer, s2_statistik, s2_administrasi_kes_masy, pasca_sarjana_lainnya_s2,
sarjana_biologi, sarjana_kimia, sarjana_ekonomi_akuntansi, sarjana_administrasi, sarjana_hukum, sarjana_tehnik, sarjana_kes_sosial, sarjana_fisika, sarjana_komputer, sarjana_statistik,
sarjana_lainnya_s1,sarjana_muda_biologi, sarjana_muda_kimia, sarjana_muda_ekonomi_akuntansi, sarjana_muda_administrasi, sarjana_muda_hukum, sarjana_muda_tehnik, sarjana_muda_kes_sosial,
sarjana_muda_statistik, sarjana_muda_komputer, sarjana_muda_sekretaris, sarjana_muda_d3_lainnya, sma_smu, smea, stm, smkk, spsa, smtp, sd_kebawah, smta_lainnya, tahun) 
values ("'.$tenaga_1_1.'","'.$tenaga_1_2.'","'.$tenaga_1_3.'","'.$tenaga_1_4.'","'.$tenaga_1_5.'","'.$tenaga_1_6.'","'.$tenaga_1_7.'","'.$tenaga_1_8.'","'.$tenaga_1_9.'","'.$tenaga_1_10.'","'.$tenaga_1_11.'",
"'.$tenaga_1_12.'","'.$tenaga_1_13.'","'.$tenaga_1_14.'","'.$tenaga_1_15.'","'.$tenaga_1_16.'","'.$tenaga_1_17.'","'.$tenaga_1_18.'","'.$tenaga_1_19.'","'.$tenaga_1_20.'","'.$tenaga_1_21.'","'.$tenaga_1_22.'",
"'.$tenaga_1_23.'","'.$tenaga_1_24.'","'.$tenaga_1_25.'","'.$tenaga_1_26.'","'.$tenaga_1_27.'","'.$tenaga_1_28.'","'.$tenaga_1_29.'","'.$tenaga_1_30.'","'.$tenaga_1_31.'","'.$tenaga_1_32.'","'.$tenaga_1_33.'","'.$tenaga_1_34.'",
"'.$tenaga_1_35.'","'.$tenaga_1_36.'","'.$tenaga_1_37.'",
"'.$tenaga_2_1.'","'.$tenaga_2_2.'","'.$tenaga_2_3.'","'.$tenaga_2_4.'","'.$tenaga_2_5.'","'.$tenaga_2_6.'","'.$tenaga_2_7.'","'.$tenaga_2_8.'","'.$tenaga_2_9.'","'.$tenaga_2_10.'","'.$tenaga_2_11.'",
"'.$tenaga_2_12.'",
"'.$tenaga_3_1.'","'.$tenaga_3_2.'","'.$tenaga_3_3.'","'.$tenaga_3_4.'","'.$tenaga_3_5.'","'.$tenaga_3_6.'","'.$tenaga_3_7.'","'.$tenaga_3_8.'","'.$tenaga_3_9.'","'.$tenaga_3_10.'",
"'.$tenaga_4_1.'","'.$tenaga_4_2.'","'.$tenaga_4_3.'","'.$tenaga_4_4.'","'.$tenaga_4_5.'","'.$tenaga_4_6.'","'.$tenaga_4_7.'","'.$tenaga_4_8.'","'.$tenaga_4_9.'","'.$tenaga_4_10.'","'.$tenaga_4_11.'",
"'.$tenaga_4_12.'","'.$tenaga_4_13.'",
"'.$tenaga_5_1.'","'.$tenaga_5_2.'","'.$tenaga_5_3.'","'.$tenaga_5_4.'","'.$tenaga_5_5.'","'.$tenaga_5_6.'","'.$tenaga_5_7.'",
"'.$tenaga_6_1.'","'.$tenaga_6_2.'","'.$tenaga_6_3.'","'.$tenaga_6_4.'","'.$tenaga_6_5.'","'.$tenaga_6_6.'","'.$tenaga_6_7.'",
"'.$tenaga_7_1.'","'.$tenaga_7_2.'","'.$tenaga_7_3.'","'.$tenaga_7_4.'","'.$tenaga_7_5.'","'.$tenaga_7_6.'","'.$tenaga_7_7.'","'.$tenaga_7_8.'","'.$tenaga_7_9.'","'.$tenaga_7_10.'","'.$tenaga_7_11.'",
"'.$tenaga_7_12.'","'.$tenaga_7_13.'","'.$tenaga_7_14.'","'.$tenaga_7_15.'","'.$tenaga_7_16.'","'.$tenaga_7_17.'","'.$tenaga_7_18.'","'.$tenaga_7_19.'","'.$tenaga_7_20.'","'.$tenaga_7_21.'",
"'.$tenaga_7_22.'","'.$tenaga_7_23.'",
"'.$tenaga_8_1.'","'.$tenaga_8_2.'","'.$tenaga_8_3.'","'.$tenaga_8_4.'","'.$tenaga_8_5.'","'.$tenaga_8_6.'","'.$tenaga_8_7.'","'.$tenaga_8_8.'","'.$tenaga_8_9.'","'.$tenaga_8_10.'","'.$tenaga_8_11.'",
"'.$tenaga_9_1.'","'.$tenaga_9_2.'","'.$tenaga_9_3.'","'.$tenaga_9_4.'","'.$tenaga_9_5.'","'.$tenaga_9_6.'","'.$tenaga_9_7.'","'.$tenaga_9_8.'","'.$tenaga_9_9.'","'.$tenaga_9_10.'","'.$tenaga_9_11.'",
"'.$tenaga_9_12.'",
"'.$tenaga_10_1.'","'.$tenaga_10_2.'","'.$tenaga_10_3.'","'.$tenaga_10_4.'","'.$tenaga_10_5.'","'.$tenaga_10_6.'","'.$tenaga_10_7.'","'.$tenaga_10_8.'","'.$tenaga_10_9.'","'.$tenaga_10_10.'","'.$tenaga_10_11.'",
"'.$tenaga_11_1.'","'.$tenaga_11_2.'","'.$tenaga_11_3.'","'.$tenaga_11_4.'","'.$tenaga_11_5.'","'.$tenaga_11_6.'","'.$tenaga_11_7.'","'.$tenaga_11_8.'","'.$tenaga_11_9.'","'.$tenaga_11_10.'","'.$tenaga_11_11.'",
"'.$tenaga_12_1.'","'.$tenaga_12_2.'","'.$tenaga_12_3.'","'.$tenaga_12_4.'","'.$tenaga_12_5.'","'.$tenaga_12_6.'","'.$tenaga_12_7.'","'.$tenaga_12_8.'","'.$tahun.'")');
					}else{
						$viewsql	= 'select * from m_ketenagaan_data where tahun = "'.$tahun.'"';
					}
				}else{
					$viewsql	= 'select * from m_ketenagaan_data where tahun = "'.$tahun.'"';
					
				}
				
				if($viewsql != '')
				{
					$queryview	= mysql_query($viewsql);
					if(mysql_num_rows($queryview) > 0)
					{
						$dataview	= mysql_fetch_array($queryview);
					}else{
						$dataview	= array();
					}
				}
				
			?>
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td> Kode RS </td><td>: <input type="text" name="kode_rs" class="inputrl12" value="<?php echo $koders;?>" /></td></tr>
                <tr><td> Nama RS </td><td>: <input type="text" name="nama_rs" class="inputrl12" value="<?php echo $namars;?>" /></td></tr>
                <tr><td> Tahun </td><td>: <select name="tahun" id="tahun" class="selectbox">
											<?php
											for($i=$date; $i<=date('Y'); $i++)
											{
												$selected	= ($i == $tahun) ? 'selected="selected"' : date('Y') ;
												echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
											}
											?>
										  </select></td></tr>
                <tr><td colspan="2"><input type="submit" name="submit" value="Lihat"></td></tr>
				<tr><td colspan="2"><input type="submit" name="submit" value="Simpan"></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <!--<tr><td colspan="2"><h2>RL 1.2 Indikator Pelayanan Rumah Sakit</h2></td></tr>-->
			</table>
			
			
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th rowspan="2">NO KODE</th><th rowspan="2">KUALIFIKASI PENDIDIKAN</th><th colspan="2">KEADAAN</th><th colspan="2">KEBUTUHAN</th><th colspan="2">KEKURANGAN</th></tr>
            	<tr><th>Laki - Laki</th><th>Perempuan</th><th>Laki - Laki</th><th>Perempuan</th><th>Laki - Laki</th><th>Perempuan</th></tr>
			</thead>
			<tbody>
				<?php
				$query1	= mysql_query('select * from m_ketenagaan_kelompok');
				if(mysql_num_rows($query1) > 0){
					while($data1 = mysql_fetch_array($query1)){
						echo '<tr><td colspan="8"> '.$data1['nama'].' </td><tr>';
						$query2	= mysql_query('select * from m_ketenagaan_jenis where kelompok_id = '.$data1['id']);
						if(mysql_num_rows($query2) > 0){
							while($data2 = mysql_fetch_array($query2)){
								echo '<tr><td align="center">'.$data2['id'].'</td><td colspan="7">'.$data2['nama'].'</td><tr>';
								$query3	= mysql_query('select * from m_ketenagaan where kelompok = '.$data2['kelompok_id'].' and jenis = '.$data2['id']);
								if(mysql_num_rows($query3) > 0){
									$i = 1;
									while($data3 = mysql_fetch_array($query3)){
										if($dataview) {
											$value	= explode('-',$dataview[$data3['nama_alias']]);
										}else{
											$value	= explode('-','0-0-0-0-0-0');
										}
										
										echo '<tr><td align="center">'.$data3['jenis'].'.'.$i.'</td><td>'.$data3['nama'].'</td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['0'].'"></td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['1'].'"></td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['2'].'"></td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['3'].'"></td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['4'].'"></td>
											<td><input type="text" name="tenaga_'.$data3['jenis'].'_'.$i.'[]" class="textbox" size="10" value="'.$value['5'].'"></td></tr>';
										$i++;
									}
								}
							}
						}
					}
				}
				?>
			</tbody>
			</table>
			</form>
			<form action="rm/rl2_xls.php" method="get">
				<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
				<input type="submit" value="export xls"  />
			</form>
        </td>
    </tr>
</table>
</div>
</div>