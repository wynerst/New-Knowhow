<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 */

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

/* Showing list of catalogues and also for searching handling */

// include required class class
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_tokenizecql.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require LIB_DIR.'knowhow_list_model.inc.php';

// index choice
if ($sysconf['edocs_index']['type'] == 'sphinx') {
    require LIB_DIR.'sphinx/sphinxapi.php';
    require LIB_DIR.'edocs_list_sphinx.inc.php';
} else {
    require LIB_DIR.'knowhow_list.inc.php';
}

// create edocs list object
try {
    $edocs_list = new biblio_list($dbs, $sysconf['opac_result_num']);
    // if we are in searching mode
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        // default vars
        $is_adv = false;
        $keywords = '';
        $criteria = '';
        // simple search
        if (isset($_GET['keywords'])) {
            $keywords = trim(strip_tags(urldecode($_GET['keywords'])));
        }
        if ($keywords && !preg_match('@[a-z0-9_.]+=[^=]+\s+@i', $keywords.' ')) {
            $criteria = 'title='.$keywords.' OR notes='.$keywords;
            $edocs_list->setSQLcriteria($criteria);
        } else {
            $edocs_list->setSQLcriteria($keywords);
        }
        // advanced search
        $is_adv = isset($_GET['search']) || isset($_GET['title']) || isset($_GET['author']) || isset($_GET['number'])
            || isset($_GET['subject']) || isset($_GET['location'])
            || isset($_GET['khtype']);
        if ($is_adv) {
            $title = '';
            if (isset($_GET['title'])) {
                $title = trim(strip_tags(urldecode($_GET['title'])));
            }
            $author = '';
            if (isset($_GET['author'])) {
                $author = trim(strip_tags(urldecode($_GET['author'])));
            }
            $subject = '';
            if (isset($_GET['subject'])) {
                $subject = trim(strip_tags(urldecode($_GET['subject'])));
            }
            $number = '';
            if (isset($_GET['number'])) {
                $number = trim(strip_tags(urldecode($_GET['number'])));
            }
            $khtype = '';
            if (isset($_GET['khtype'])) {
                $khtype = trim(strip_tags(urldecode($_GET['khtype'])));
            }			
            // don't do search if all search field is empty
            if ($title || $author || $subject || $khtype) {
                $criteria = '';
                if ($title) { $criteria .= ' title='.$title; }
                if ($author) { $criteria .= ' author='.$author; }
                if ($subject) { $criteria .= ' subject='.$subject; }
                if ($number) { $criteria .= ' number="'.$number.'"'; }
                if ($khtype) { $criteria .= ' khtype="'.$khtype.'"'; }
                $criteria = trim($criteria);
                $edocs_list->setSQLcriteria($criteria);
            }
        }

        // search result info construction
        if ($is_adv) {
            $info .= '<div style="clear: both;">'.__('Found  <strong>{edocs_list->num_rows}</strong> from your keywords').': <strong><cite>'.$keywords.'</cite></strong></div>  ';
            if ($title) { $info .= 'Title : <strong><cite>'.$title.'</cite></strong>, '; }
			if ($number) { $info .= 'Number : <strong><cite>'.$Number.'</cite></strong>, '; }
            if ($author) { $info .= 'Author : <strong><cite>'.$author.'</cite></strong>, '; }
            if ($subject) { $info .= 'Subject : <strong><cite>'.$subject.'</cite></strong>, '; }
            if ($khtype) { $info .= 'Type : <strong><cite>'.$khtype.'</cite></strong>, '; }
            // strip last comma
            $info = substr_replace($info, '', -2);
        } else {
            $info .= '<div style="clear: both;">'.__('Found  <strong>{edocs_list->num_rows}</strong> from your keywords').': <strong><cite>'.$keywords.'</cite></strong></div>';
        }
    }

    // show the list
    echo $edocs_list->getDocumentList();
    echo '<br />'."\n";
    // set result number info
    $info = str_replace('{edocs_list->num_rows}', $edocs_list->num_rows, $info);
    // count total pages
    $total_pages = ceil($edocs_list->num_rows/$sysconf['opac_result_num']);

    // page number info
    if (isset($_GET['page']) AND $_GET['page'] > 1) {
        $page = intval($_GET['page']);
        $msg = str_replace('{page}', $page, __('You currently on page <strong>{page}</strong> of <strong>{total_pages}</strong> page(s)'));
        $msg = str_replace('{total_pages}', $total_pages, $msg);
        $info .= '<div style="clear: both;">'.$msg.'</div>';
    } else {
        $page = 1;
    }
    // query time
    $info .= '<div>'.__('Query took').' <b>'.$edocs_list->query_time.'</b> '.__('second(s) to complete').'</div>';

} catch (Exception $err) {
    $info = '<div class="errorBox">'.$err->getMessage().'</div>';
}
?>
