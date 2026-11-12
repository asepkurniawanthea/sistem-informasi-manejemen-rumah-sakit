<style>
html{
background:url(image/bg_pattern1.jpg);
}
</style>
<?php
if (isset($_POST['kunci_l'])) {
    $qry_pass = 'SELECT m_app_user.KUNCI FROM m_app_user WHERE m_app_user.NAMA_USER = "' . $_SESSION['SES_SIMRS_NAMA_USER'] . '"';
    $get_pass = mysql_query($qry_pass) or die(mysql_error());
    $dat_pass = mysql_fetch_assoc($get_pass);
    if (MD5($_POST['kunci_l']) == $dat_pass['KUNCI']) {
        if (!empty($_POST['kunci_b'])) {
            if (MD5($_POST['kunci_b']) == MD5($_POST['kunci_k'])) {
                mysql_query('UPDATE m_app_user SET KUNCI = "' . MD5($_POST['kunci_b']) . '" WHERE m_app_user.NAMA_USER = "' . $_SESSION['SES_SIMRS_NAMA_USER'] . '"') or die(mysql_error());
                ?>
                <script language="JavaScript" >
                    alert("Password Telah Berhasil Diubah.");
                    window.close();
                </script>
                <?php
            } else {
                $msg_info = 'Password Baru Tidak Valid.';
            }
        } else {
            $msg_info = 'Password Baru Tidak Valid.';
        }
    } else {
        $msg_info = 'Password Lama Tidak Valid.';
    }
}
?>
<form name="frmlogin" method="post" autocomplete="off">
<fieldset style="margin-top:5px; border-radius:5px; height:auto; margin:0; padding:0; padding-bottom:5px; stroke:red; ">
<legend style="font-weight:bold; height:25px; width:auto; padding-left:15px; margin-top:5px; margin-left:25px; padding-right:15px; text-align:center; border:-radius:5px; border:1px solid black; box-shadow:1px 1px 1px 1px rgba(0,0,0,2);">Ubah Password
</legend>
    <table class="tableform" width="100%">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>  
        <tr>
            <td>&nbsp;Password Lama</td>
            <td><input type="password" name="kunci_l" class="text_dt" size="25" /></td>
        </tr>  
        <tr>
            <td>&nbsp;Password Baru</td>
            <td><input type="password" name="kunci_b" class="text_dt" size="25" /></td>
        </tr>  
        <tr>
            <td>&nbsp;Konfirmasi</td>
            <td><input type="password" name="kunci_k" class="text_dt" size="25" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="ubah" class="myButton1" /></td>
        </tr>    
    </table>
</fieldset>	
</form>