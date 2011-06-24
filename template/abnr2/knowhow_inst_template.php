<?php
// edocs biblio/record detail
// output the buffer
ob_start(); /* <- DONT REMOVE THIS COMMAND */
?>
<table class="border margined" style="width: 99%;" cellpadding="5" cellspacing="0">
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{title}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Author(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{authors}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Date Created'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{create_date}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Revision Date'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{revision_date}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Topic(s)/Subject(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{topic}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('References'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{reference}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Notes/Abstract'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{notes}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Tag'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{tag}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Documents'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{file_att}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top">&nbsp;</td>
<td class="tblContent" style="width: 80%;" valign="top"><a href="javascript: history.back();"><?php print __('Back To Previous'); ?></a></td>
</tr>
</table>
<?php
// put the buffer to template var
$detail_template = ob_get_clean();
?>
