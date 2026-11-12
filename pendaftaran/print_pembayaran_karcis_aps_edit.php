<?php 
echo 'Printing ...<br/>';
require_once('lib/nusoap.php');
require_once('config/config.php');
require_once('function.php');

if(isset($_GET['idx']) and isset($_GET['no'])){ 

$irja_id = $_GET['idx'];
$irja_no = $_GET['no'];

$tanggal = date('d-m-Y');
$jam = date('H:i:s');

	$client = new soapclient($ws_url);
    $response = $client->call('getPenunjangEdit', array('idx' => $irja_id,'nomor' => $irja_no,'aps' => 'aps'));
    if ($client->fault) {
        echo 'FAULT: <p>Code: (' . $client->faultcode . ')</p>';
        echo 'String: ' . $client->faultstring;
        exit;
    } else {
        $r = $response;
        $count = count($r);
        for ($i = 0; $i <= $count - 1; $i++) {
			$nomr = $r[$i]['NOMR'];
			$tgl_daftar = $r[$i]['TANGGAL_DAFTAR'];
			$nama_unit = $r[$i]['NAMA_UNIT'];
			$nama_penunjang = $r[$i]['NAMA_PENUNJANG'];
			$nama_pegawai = $r[$i]['NAMA_PEGAWAI'];
			$nama_jaminan = $r[$i]['NAMA_JAMINAN'];
			$no_sjp = $r[$i]['NO_SJP'];
			$no_pendaftaran = $r[$i]['NO_TARIF'];
			$user_pendaftaran = $r[$i]['USER_PENDAFTARAN'];	
			
			$nama_pasien = $r[$i]['NAMA_PASIEN'];
			$tmp_lahir = $r[$i]['TMP_LAHIR'];
			$tgl_lahir = $r[$i]['TGL_LAHIR'];
			$tgl_lahir_2 = $r[$i]['TGL_LAHIR_2'];
			$jns_kelamin = $r[$i]['JNS_KELAMIN'];
			$nama_ibu = $r[$i]['NAMA_IBU'];
			$alamat = $r[$i]['ALAMAT'];
			$nama_kelurahan = $r[$i]['NAMA_KELURAHAN'];
			$nama_kecamatan = $r[$i]['NAMA_KECAMATAN'];
        }
    }

if ($jns_kelamin == 'L') $jns_kelamin = 'Lk';
if ($jns_kelamin == 'P') $jns_kelamin = 'Pr';

$a = datediff($tgl_lahir_2, date('Y-m-d'));

$user_pendaftaran_array = explode('|',$user_pendaftaran);
$user_pendaftaran = $user_pendaftaran_array[1]; 

$largura = 20; 
$altura = 10;  
$fator_x = $largura / 72; 
$fator_y = $largura / 300; 
$fator_z = $fator_x / $fator_y;

$largura_f = $largura * $fator_z;
$altura_f = $altura * $fator_z;
	
$handle = printer_open($printer_karcis) or die();
printer_start_doc($handle, 'My Document');
printer_start_page($handle);

printer_draw_bmp($handle, $rs_logo, 1, 3, $largura_f, $altura_f);

$font = printer_create_font('Arial', 13, 6, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
printer_draw_text($handle, $hd_1, 110, 10);
printer_draw_text($handle, $hd_2, 107, 22);
printer_draw_text($handle, $hd_3, 78, 34);
printer_delete_font($font);

$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, '000000');
printer_select_pen($handle, $pen);
printer_draw_line($handle, 1, 50, 450, 50);

if(empty($nama_penunjang)) $nama_penunjang =  $nama_penunjang = 'PENUNJANG';

$font = printer_create_font('Arial', 18, 9, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
printer_draw_text($handle, 'KWITANSI PENUNJANG', 80, 53);
printer_delete_font($font);

$font = printer_create_font('Arial', 13, 6, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
printer_draw_text($handle, 'Nama Pasien', 5, 75);
printer_draw_text($handle, 'Nomor Id', 5, 99);
printer_draw_text($handle, 'Alamat/Telp', 5, 111);

printer_draw_text($handle, 'Nomor', 245, 75);
printer_draw_text($handle, 'Instansi', 245, 87);
printer_draw_text($handle, 'Nama Dokter', 245, 99);

if (strlen($nama_pasien) > 20) {
        printer_draw_text($handle, ': ' . substr($nama_pasien, 0, 20), 82, 75);
        printer_draw_text($handle, substr($nama_pasien, 20, strlen($nama_pasien) - 20), 87, 87);
    } else {
        printer_draw_text($handle, ': ' . $nama_pasien, 82, 75);
    }
    
	printer_draw_text($handle, ':', 82, 99);
	
	printer_delete_font($font);
    $font = printer_create_font('Arial', 16, 8, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);
	
	printer_draw_text($handle, $nomr, 88, 97);
	
	printer_delete_font($font);
    $font = printer_create_font('Arial', 13, 6, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);
    
	
	if (strlen($alamat) > 20) {
        printer_draw_text($handle, ': ' . substr($alamat, 0, 20), 82, 111);
        printer_draw_text($handle, substr($alamat, 20, strlen($alamat) - 20), 87, 123);
    } else {
        printer_draw_text($handle, ': ' . $alamat, 82, 111);
    }
	printer_draw_text($handle, ': ' . $irja_no, 320, 75);
	printer_draw_text($handle, ': ' . $nama_unit, 320, 87);
    if (strlen(trim($nama_pegawai)) > 16) {
        printer_draw_text($handle, ': ' . substr(trim($nama_pegawai), 0, 16), 320, 99);
        printer_draw_text($handle, substr(trim($nama_pegawai), 16, strlen(trim($nama_pegawai)) - 16), 325, 111);
    } else {
        printer_draw_text($handle, ': ' . trim($nama_pegawai), 320, 99);
    }

    $x = 140;
	if (strlen($alamat) <= 20) $x = $x - 12;
	
	printer_draw_line($handle, 1, $x, 450, $x);
    printer_draw_line($handle, 1, $x + 18, 450, $x + 18);
	
	printer_draw_text($handle, 'No  Pemeriksaan', 2, $x + 2);
	printer_draw_text($handle, 'Jml', 280, $x + 2);
	printer_draw_text($handle, 'Biaya (Rp.)', 330, $x + 2);

    $x = 165;
	if (strlen($alamat) <= 20) $x = $x - 12;


$tindakan = array();
$jml = array();
$harga = array();
$total_row = 0;
$total_bayar = 0;
	$client = new soapclient($ws_url);
    $response = $client->call('getPembayaranPenunjangEdit', array('idx' => $irja_id,'nomor' => $irja_no,'ord' => 'aps'));
    if ($client->fault) {
        echo 'FAULT: <p>Code: (' . $client->faultcode . ')</p>';
        echo 'String: ' . $client->faultstring;
        exit;
    } else {
        $r = $response;
        $count = count($r);
        $total_row = 0;
		for ($i = 0; $i <= $count - 1; $i++) {
			$tindakan[$i] = $r[$i]['NAMA_TARIF'];
			$jml[$i] = $r[$i]['KUANTITI'];
			$harga[$i] = $r[$i]['TARIF_NON_KELAS'];
			$total_bayar = $total_bayar + $r[$i]['TARIF_NON_KELAS']; 
			$total_row++;
        }
    }

$l = 0;
while($l < $total_row){
 printer_draw_text($handle, $l + 1, 2, $x);
 if(strlen($tindakan[$l]) > 40 ){
  printer_draw_text($handle, substr($tindakan[$l], 0, 40), 20, $x); 
  printer_draw_text($handle, substr($tindakan[$l], 40, strlen($tindakan[$l]) - 40), 20, $x + 10); 
  
  $x = $x + 13;
 }else{
  printer_draw_text($handle, $tindakan[$l], 20, $x);
 }

 write_num($jml[$l], $handle, $x, 295, 7);
 write_num(curr_format($harga[$l], 2), $handle, $x, 400, 7);
 
 $l = $l + 1;
 $x = $x + 13;
 if($x > 270){
	printer_end_page($handle);
	printer_end_doc($handle);
	printer_start_doc($handle, 'My Document');
	printer_start_page($handle);
	
	printer_draw_line($handle, 1, 10, 450, 10);
    printer_draw_line($handle, 1, 28, 450, 28);
	printer_draw_text($handle, 'No  Pemeriksaan', 2, 12);
	printer_draw_text($handle, 'Jml', 280, 12);
	printer_draw_text($handle, 'Biaya (Rp.)', 330, 12);
	$x = 35; 
 }
}

printer_draw_line($handle, 1, 278, 450, 278);

printer_draw_text($handle, 'Total : Rp.', 250, 280);
printer_draw_text($handle, 'Tangerang, ' . $tanggal . ' ' . $jam, 250, 300);
printer_draw_text($handle, 'Kasir', 50, 332);

printer_draw_text($handle, 'Petugas', 280, 312);
printer_draw_text($handle, $user_pendaftaran, 270, 332);
printer_draw_text($handle, 'Pasien :', 2, 305);

$terbilang = trim(strtoupper(set_terbilang(round($total_bayar))) . ' RUPIAH');
	if(strlen($terbilang) > 33){
		printer_draw_text($handle, substr($terbilang, 0, 33), 2, 280);
        printer_draw_text($handle, substr($terbilang, 33, strlen($terbilang) - 33), 2, 292);
	}else{
		printer_draw_text($handle, $terbilang, 2, 280);
	}	
	
$font = printer_create_font('Arial', 18, 9, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
printer_draw_text($handle, $nama_jaminan, 50, 305);

write_num(curr_format(round($total_bayar), 2), $handle, 280, 400, 10);
printer_draw_line($handle, 1, 348, 450, 348);

printer_delete_font($font);
$font = printer_create_font('Arial', 6, 5, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
printer_draw_text($handle, '1. Tanda pembayaran ini dianggap sah apabila mendapat validasi kasir', 1, 350);
printer_draw_text($handle, '2. Bila terdapat biaya-biaya yang belum termasuk dalam tagihan ini,', 1, 355);
printer_draw_text($handle, '   akan ditagihkan kemudian', 1, 360);

printer_end_page($handle);
printer_end_doc($handle);

printer_close($handle);
} ?>
<script language="javascript" type="text/javascript">
window.close();
</script>


