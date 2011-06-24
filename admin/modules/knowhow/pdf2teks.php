<?php
/**
 * Copyright (C) 2010  Wardiyono (wynerst@gmail.com)
 *
 */

/* Read text from pdf file */

// key to authenticate
define('INDEX_AUTH', '1');

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

/* Text Extraction */
if (isset($_GET['fid']) AND isset($_GET['bid']) AND $can_read AND $can_write) {
    $bib_id = (integer)$_GET['bid'];
    $file_id = (integer)$_GET['fid'];
    // check form validity

	if (stripos(PHP_OS, 'Linux') !== false) {
	} else {
        utility::jsAlert(__('Can NOT continue for NON LINUX Operating System!'));
		exit();
	}

    if (empty($bib_id) AND empty($file_id)) {
        utility::jsAlert(__('Can NOT continue without file dan biblio data!'));
        exit();
    } else {
		// get file detail: name, location
		$file_q = $dbs->query("SELECT * from knowhow_files WHERE file_id=".$file_id);
		$file_d = $file_q->fetch_assoc();
		$file_d = str_replace(" ", "\ ", $file_d);
		$file_d = str_replace("(", "\(", $file_d);
		$file_d = str_replace(")", "\)", $file_d);
		$file_loc = REPO_BASE_DIR.str_ireplace('/', DIRECTORY_SEPARATOR, $file_d['file_dir']).$file_d['file_name'];

        unset($file_q);
		unset($file_d);
		//die($file_loc);
		
		$extraction = shell_exec('/usr/bin/pdftotext '.$file_loc.' -');
		//$extraction = '/usr/bin/pdftotext '.$file_loc.' -';

		if (empty($extraction)) {
	        utility::jsAlert(__("Extraction result is empty! \n Please cek your pdf file."));
	        exit();
		} else {
			// get current KH data
			$biblio_q = $dbs->query("SELECT * from knowhow WHERE biblio_id=".$bib_id);
			$biblio_d = $biblio_q->fetch_assoc();

			// create new instance
			$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'], 'post');
			$form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';
			// form table attributes
			$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
			$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
			$form->table_content_attr = 'class="alterCell2"';

			$form->addTextField('textarea', 'maintext', __('Main text').'*', $biblio_d['main_text'], 'rows="10" style="width: 100%; overflow: auto;"');
			$form->addTextField('textarea', 'extract', __('PDF extraction result').'*', $extraction, 'rows="10" style="width: 100%; overflow: auto;"');
			// add /replace option
			$_textoptions[] = array(0, __('Add to main text'));
			$_textoptions[] = array(1, __('Replace existing main text'));
			$form->addRadio('textoption', __('Options'), $_textoptions, 0);
			$form->addHidden('biblio_id', $bib_id);
			echo $form->printOut();

			exit();
		}
    }
    exit();
} else if (isset($_POST['saveData']) AND $can_read AND $can_write) {

		$main_text = trim($dbs->escape_string(strip_tags($_POST['maintext'],'<br><p><div><span><i><em><strong><b><code>s')));
		$extraction = trim($dbs->escape_string(strip_tags($_POST['extract'],'<br><p><div><span><i><em><strong><b><code>s')));
		$option = (integer)$_POST['textoption'];
		$biblio_id = (integer)$_POST['biblio_id'];

		$data=array();
		
		if ($option == 0) {
			$data['main_text'] = $main_text . chr(10) . $extraction;
		} else {
			$data['main_text'] = $extraction;
		}
		
		//die(addslashes($content));
        $data['last_update'] = date('Y-m-d H:i:s');

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
		/* INSERT RECORD MODE */
		// insert the data
		
		if ($sql_op->update('knowhow', $data, 'biblio_id ='.$biblio_id)) {
			utility::jsAlert(__('PDF text extracted and add to KH data successfully'));
			echo '<script type="text/javascript">parent.jQuery(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\');</script>';
		} else { utility::jsAlert(__('KH Type Data FAILED to Save. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
		exit();

}
/* RECORD OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner masterFileIcon">
    <?php echo strtoupper(__('PDF Text Extractions')); ?> - <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>knowhow/pdf2teks.php" class="headerText2"><?php echo __('List pdf file available'); ?></a>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>knowhow/pdf2teks.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
/* main content */

/* File attachemetn LIST */
// table spec
if (stripos(PHP_OS, 'Linux') !== false) {
} else {
	echo '<div class="infoBox">'.__('Currently it is only available for LINUX OS').'</b></div>'; //mfc
}

$table_spec = 'knowhow_attachment as att left join knowhow_files as f on f.file_id = att.file_id
	left join knowhow as k on k.biblio_id = att.biblio_id';

// create datagrid
$datagrid = new simbio_datagrid();
if ($can_read AND $can_write) {
	$datagrid->setSQLColumn('f.file_name', 'f.file_title', 
	'k.title', 'k.number', 'k.kh_type',
	'concat("<a href=""../admin/modules/knowhow/pdf2teks.php?fid=", att.file_id, "&amp;bid=", att.biblio_id, """>Add text</a>") AS Extract');
} else {
	$datagrid->setSQLColumn('att.file_id', 'att.biblio_id',
	'f.file_name', 'f.file_title', 
	'k.title', 'k.number', 'k.kh_type');
}
$datagrid->setSQLorder('f.last_update ASC');

// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
   $keywords = $dbs->escape_string($_GET['keywords']);
   $datagrid->setSQLCriteria("f.file_name LIKE '%$keywords%' OR 
		f.file_title LIKE '%$keywords%' OR
		k.title LIKE '%$keywords%' OR
		k.number LIKE '%$keywords%' OR
		k.kh_type LIKE '%$keywords%' AND f.mime_type='application/pdf'");
} else {
   $datagrid->setSQLCriteria("f.mime_type='application/pdf'");	
}

// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// set delete proccess URL
$datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, false);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
	$msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
	echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
}

echo $datagrid_result;

/* main content end */
?>
