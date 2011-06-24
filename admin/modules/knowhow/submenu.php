<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
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

/* Bibliographic module submenu items */

$menu[] = array('Header', __('Knowhow List'));
$menu[] = array(__('List of Regulations'), MODULES_WEB_ROOT_DIR.'knowhow/index.php', __('Show Existing Regulation data'));
$menu[] = array(__('List of Instrument'), MODULES_WEB_ROOT_DIR.'knowhow/instrument.php', __('List of Instruments'));
$menu[] = array(__('List of Memo/Advice/Opinions'), MODULES_WEB_ROOT_DIR.'knowhow/memo.php', __('List of Memos'));
//$menu[] = array(__('Add New Bibliography'), MODULES_WEB_ROOT_DIR.'knowhow/index.php?action=detail', __('Add New Bibliographic Data/Catalog'));
$menu[] = array('Header', __('New KH Data'));
$menu[] = array(__('Add New Regulations'), MODULES_WEB_ROOT_DIR.'knowhow/index.php?action=detail', __('Add New Regulations'));
$menu[] = array(__('Add New Memo/Advice/Opinions'), MODULES_WEB_ROOT_DIR.'knowhow/memo.php?action=detail', __('Add New Memo/Advice/Opinions'));
$menu[] = array(__('Add New Instruments'), MODULES_WEB_ROOT_DIR.'knowhow/instrument.php?action=detail', __('Add New Instrument'));
$menu[] = array(__('PDF Extraction'), MODULES_WEB_ROOT_DIR.'knowhow/pdf2teks.php', __('Extract pdf text to KH'));
$menu[] = array(__('DOC file Extraction'), MODULES_WEB_ROOT_DIR.'knowhow/doc2teks.php', __('Extract DOC MsWord text to KH'));
$menu[] = array(__('Collection Type'), MODULES_WEB_ROOT_DIR.'knowhow/jenis_koleksi.php', __('Master file of Collection Type'));
?>
