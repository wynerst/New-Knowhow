<?php
/**
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com)
 *
 */

/* Master Regulation Type */

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

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    $jpName = trim(strip_tags($_POST['jpName']));
    $code = trim(strip_tags($_POST['code']));
    // check form validity
    if (empty($jpName) AND empty($code)) {
        utility::jsAlert(__('kh_type Code And Name can\'t be empty'));
        exit();
    } else {
        $data['khtype_id'] = $dbs->escape_string($code);
        $data['type_coll'] = $dbs->escape_string($jpName);
        $data['input_date'] = date('Y-m-d');
        $data['last_update'] = date('Y-m-d');

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = $dbs->escape_string(trim($_POST['updateRecordID']));
            // update the data
            $update = $sql_op->update('mst_kh_type', $data, 'khtype_id=\''.$updateRecordID.'\'');
            if ($update) {
                // update language ID in biblio table to keep data integrity
                $sql_op->update('knowhow', array('kh_type' => $data['khtype_id']), 'kh_type=\''.$updateRecordID.'\'');
                utility::jsAlert(__('KH Type Successfully Updated'));
                echo '<script type="text/javascript">parent.jQuery(\'#mainContent\').simbioAJAX(parent.jQuery.ajaxHistory[1].url);</script>';
            } else { utility::jsAlert(__('KH Type Data FAILED to Updated. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('mst_kh_type', $data)) {
                utility::jsAlert(__('New KH Type Successfully Saved'));
                echo '<script type="text/javascript">parent.jQuery(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\');</script>';
            } else { utility::jsAlert(__('KH Type Data FAILED to Save. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array($_POST['itemID']);
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = $itemID;
        if (!$sql_op->delete('mst_kh_type', "khtype_id='$itemID'")) {
            $error_num++;
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(__('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.jQuery(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    } else {
        utility::jsAlert(__('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.jQuery(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner masterFileIcon">
    <?php echo strtoupper(__('KH Type')); ?> - <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>knowhow/jenis_koleksi.php?action=detail" class="headerText2"><?php echo __('Add New KH Collection Type'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>knowhow/jenis_koleksi.php" class="headerText2"><?php echo __('List'); ?></a>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>knowhow/jenis_koleksi.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }
    /* RECORD FORM */
    $itemID = $dbs->escape_string(trim(isset($_POST['itemID'])?$_POST['itemID']:0));
    $rec_q = $dbs->query("SELECT * FROM mst_kh_type WHERE khtype_id='$itemID'");
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        $form->record_id = $itemID;
        // form record title
        $form->record_title = $rec_d['type_coll'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.__('Update').'" class="button"';
    }

    /* Form Element(s) */
    // collection type  code
    $form->addTextField('text', 'code', __('Code Type').'*', $rec_d['khtype_id'], 'style="width: 20%;"');
    // jp name
    $form->addTextField('text', 'jpName', __('KH Collection Type').'*', $rec_d['type_coll'], 'style="width: 60%;"');

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.__('You are going to edit data').' : <b>'.$rec_d['jenis'].'</b>  <br />'.__('Last Update').$rec_d['last_update'].'</div>'; //mfc
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* jp LIST */
    // table spec
    $table_spec = 'mst_kh_type AS g';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('g.khtype_id',
            'g.type_coll AS \''.__('KH Type').'\'',
            'g.last_update AS \''.__('Last Update').'\'');
    } else {
        $datagrid->setSQLColumn('g.type_coll AS \''.__('KH Type').'\'',
            'g.last_update AS \''.__('Last Update').'\'');
    }
    $datagrid->setSQLorder('type_coll ASC');

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $datagrid->setSQLCriteria("g.type_coll LIKE '%$keywords%'");
    }

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
