<?php
$searchkey = '';
if (isset($_SESSION['rmsearchicd9_searchkey']))
		$searchkey = $_SESSION['rmsearchicd9_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchicd9_searchkey'] = $searchkey;
}
?>
<form name="searchicd" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>ICD Code/ Deskripsi</td>
            <td><input type="text" name="searchkey" id="searchkey" class="text_dt" value="<?php echo $searchkey; ?>" size="30" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
    $searchkey = str_replace(' ', '%', $searchkey);
	$search = '';
	if(!empty($searchkey)){
		 $search = ' AND CONCAT(m_icd_9cm.ICD_CODE,m_icd_9cm.DESKRIPSI) LIKE "%' . $searchkey . '%"';
	}
	$qry_icd = 'SELECT m_icd_9cm.ICD_CODE,m_icd_9cm.DESKRIPSI,m_icd_9cm.USER_RM
				FROM m_icd_9cm
				WHERE 1 ' . $search. ' ORDER BY m_icd_9cm.DESKRIPSI';

$extparam = '&searchkey=' . $searchkey;
$action = '';
include('rekammedik/rm_list_icd_9.php');
?>
