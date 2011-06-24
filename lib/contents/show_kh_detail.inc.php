<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

/* Showing record detail in HTML */
// filter the ID
$detail_id = intval($_GET['id']);
// include detail library and template
include LIB_DIR.'knowhow_detail.inc.php';

// select template
$kh_type = $dbs->query("SELECT kh_type FROM knowhow WHERE biblio_id=$detail_id");
while ($kh_data = $kh_type->fetch_row()) {
	switch ($kh_data[0]) {
		case 'memo':
			include $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/knowhow_memo_template.php';
			break;
		case 'inst':
			include $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/knowhow_inst_template.php';
			break;
		default:
			include $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/knowhow_detail_template.php';
		
	}
}

// create detail object
$detail = new edocs_detail($dbs, $detail_id);
$detail->setListTemplate($detail_template);
// set the content for info box
$info = '<strong>'.strtoupper(__('Record Detail')).'</strong><hr />';
if (!defined('LIGHTWEIGHT_MODE')) {
    $info .= '<a href="javascript: history.back();">'.__('Back To Previous').'</a> &nbsp;';
}
// output the record detail
echo $detail->showDetail();
$page_title = $detail->record_title;
$metadata = '';
echo '<br />'."\n";
?>
