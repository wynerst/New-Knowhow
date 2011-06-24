<?php
// edocs biblio/record detail
// output the buffer
ob_start(); /* <- DONT REMOVE THIS COMMAND */
?>
<table class="border margined" style="width: 99%;" cellpadding="5" cellspacing="0">
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{judul}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Number'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{number}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Subject(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{subjects}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Issuing Authority'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{authors}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Date of Issue'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{tanggal}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Jenis'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{jenis}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Main text'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{main}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Revoked by'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{revoke}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Ammend by'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{ammend}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('English text'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{english}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Notes'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{catatan}</td>
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
