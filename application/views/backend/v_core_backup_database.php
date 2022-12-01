<?php
/*
------------------------------
Menu Name: Backup Database
File Name: V_core_backup_database.php
File Path: /var/www/pis/application/views/v_core_backup_database.php
Create Date Time: 2020-05-18 20:12:29
------------------------------
*/
?>
<div class="col-xs-12 col-md-8 col-sm-12 col-lg-6 row">
	<div class="list-group">
		<?php
		foreach (json_decode($o_backuplist, TRUE) as $row) {
			print "<a href=\"" . site_url() . "c_core_backup_database/gf_download_backup_file/" . $row['filename'] . "\" class=\"list-group-item\">" . $row['fileseq'] . ". " . $row['filename'] . " (" . $row['filemodified'] . ")<span class=\"badge\">" . $row['filesize'] . "</span></a>";
		}
		?>
	</div>
</div>