<?php
/**
 * detail class
 * Class for document/record detail
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 * Some security patches by Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

require 'content_list.inc.php';

class edocs_detail extends content_list
{
    private $obj_db = false;
    private $record_detail = array();
    private $detail_id = 0;
    private $error = false;
    private $output_format = 'html';
    protected $detail_prefix = '';
    protected $detail_suffix = '';
    public $record_title;
    public $metadata;

    /**
     * Class Constructor
     *
     * @param   object  $obj_db
     * @param   integer $int_detail_id
     * @param   str     $str_output_format
     * @return  void
     */
    public function __construct($obj_db, $int_detail_id, $str_output_format = 'html')
    {
        if (!in_array($str_output_format, array('html', 'xml'))) {
            $this->output_format = trim($str_output_format);
        } else { $this->output_format = $str_output_format; }

        $this->obj_db = $obj_db;
        $this->detail_id = $int_detail_id;
		//        $_sql = sprintf('SELECT b.*, jp.* FROM knowhow AS b
		//            LEFT JOIN jenis_peraturan AS jp ON b.id_jenis_peraturan=jp.id
		//            WHERE b.biblio_id=%d', $int_detail_id);
        $_sql = sprintf('SELECT b.* FROM knowhow AS b
            WHERE b.biblio_id=%d', $int_detail_id);
        // for debugging purpose only
        // die($_sql);
        // query the data to database
        $_det_q = $obj_db->query($_sql);
        if ($obj_db->error) {
            $this->error = $obj_db->error;
        } else {
            $this->error = false;
            $this->record_detail = $_det_q->fetch_assoc();
            // free the memory
            $_det_q->free_result();
        }
    }


    /**
     * Method to print out the document detail based on template
     *
     * @return  void
     */
    public function showDetail()
    {
        if ($this->error) {
            return '<div style="padding: 5px; margin: 3px; border: 1px dotted #FF0000; color: #FF0000;">Error Fetching data for record detail. Server return error message: '.$this->error.'</div>';
        } else {
            if ($this->output_format == 'html' AND !empty($this->list_template)) {
                return parent::parseListTemplate($this->htmlOutput());
            } else {
                // external output function
                if (function_exists($this->output_format)) {
                    $_ext_func = $this->output_format;
                    return $_ext_func();
                }
                return null;
            }
        }
    }


    /**
     * Record detail output in HTML mode
     * @return  array
     *
     */
    protected function htmlOutput()
    {
        // get global configuration vars array
        global $sysconf;

        foreach ($this->record_detail as $idx => $data) {
            if ($idx == 'notes') {
                $data = nl2br($data);
            } else {
                $data = trim(strip_tags($data));
            }
            $this->record_detail[$idx] = $data;
        }

        // check image
        if (!empty($this->record_detail['image'])) {
            $this->record_detail['image'] = '<img src="./lib/phpthumb/phpThumb.php?src=../../images/docs/'.urlencode($this->record_detail['image']).'&w=200" border="0" />';
        } else {
            $this->record_detail['image'] = '<img src="./'.$sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/image.png" border="0" />';
        }

        // get the authors data
        $_edocs_authors_q = $this->obj_db->query('SELECT author_name FROM mst_author AS a'
            .' LEFT JOIN knowhow_author AS ba ON a.author_id=ba.author_id WHERE ba.biblio_id='.$this->detail_id);
        $authors = '';
        while ($data = $_edocs_authors_q->fetch_row()) {
            $authors .= '<a href="?p=kh&author='.urlencode('"'.$data[0].'"').'&search=Search" title="'.__('View others documents with this author').'">'.$data[0]."</a><br />";
        }
        $this->record_detail['authors'] = $authors;
        // free memory
        $_edocs_authors_q->free_result();

        // get the topics data
        $_edocs_topics_q = $this->obj_db->query('SELECT topic FROM mst_topic AS a
            LEFT JOIN knowhow_topic AS ba ON a.topic_id=ba.topic_id WHERE ba.biblio_id='.$this->detail_id);
        $topics = '';
        while ($data = $_edocs_topics_q->fetch_row()) {
            $topics .= '<a href="?p=kh&subject='.urlencode('"'.$data[0].'"').'&search=Search" title="'.__('View others documents with this subject').'">'.$data[0]."</a><br />";
        }
        $this->record_detail['topic'] = $topics;
        // free memory
        $_edocs_topics_q->free_result();

        // get related regulation data
        $_related_reg_q = $this->obj_db->query('SELECT k.biblio_id, k.number, kr.level FROM knowhow_relation AS kr'
            .' LEFT JOIN knowhow AS k ON kr.relation_id=k.biblio_id WHERE kr.biblio_id='.$this->detail_id
			.' GROUP BY kr.level');
        $relations = '';
        while ($data = $_related_reg_q->fetch_row()) {
			switch ($data[2]) {
				Case 1:
					$linkage = "Amended";
					break;
				Case 2:
					$linkage = "Amending";
					break;
				Case 3:
					$linkage = "Revoked";
					break;
				Case 4:
					$linkage = "Revoking";
					break;
				Case 5:
					$linkage = "See Also";
					break;
				default:
					$linkage = "Not Defined";
			}
            $relations .= '<a href="?p=show_kh_detail&id='.$data[0].'" title="'.__('View related documents with this number').'">(&nbsp;'.$linkage."&nbsp;)&nbsp;".$data[1]."</a><br />";
        }
        $this->record_detail['relations'] = $relations;
        // free memory
        $_related_reg_q->free_result();

        // get tags data
        $_edocs_tag_q = $this->obj_db->query('SELECT topic FROM mst_tag AS t
            LEFT JOIN knowhow_tag AS kt ON t.topic_id=kt.topic_id WHERE kt.biblio_id='.$this->detail_id);
        $tags = '';
        while ($data = $_edocs_tag_q->fetch_row()) {
            $tags .= '<a href="?p=kh&tag='.urlencode('"'.$data[0].'"').'&search=Search" title="'.__('View others documents with this tag').'">'.$data[0]."</a><br />";
        }
        $this->record_detail['tag'] = $tags;
        // free memory
        $_edocs_tag_q->free_result();

        // attachments
        $this->record_detail['file_att'] = '<div id="attachListLoad">LOADING LIST...</div>';
        $this->record_detail['file_att'] .= '<script type="text/javascript">'
            .'jQuery(document).ready(function() { jQuery.ajax({
                url: \'lib/contents/kh_list.php\',
                type: \'POST\',
                data: \'id='.$this->detail_id.'\',
                error: function(errorRespond) { $(\'#attachListLoad\').html(\'Error requesting page!\'); },
                success: function(ajaxRespond) { $(\'#attachListLoad\').html(ajaxRespond); }
                }
              )
            });
            </script>';

        return $this->record_detail;
    }


    /**
     * Get Record detail prefix
     */
    public function getPrefix()
    {
        return $this->detail_prefix;
    }


    /**
     * Get Record detail suffix
     */
    public function getSuffix()
    {
        return $this->detail_suffix;
    }
}
?>
