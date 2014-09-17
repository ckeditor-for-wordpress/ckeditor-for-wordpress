<?php
/*
Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or http://ckeditor.com/license
*/
?>
<div class="wrap">
	<div id="icon-wp-ckeditor" class="icon32"><br /></div>
	<h2><?php _e('CKEditor - Upload Settings', 'ckeditor_wordpress') ?></h2>
	<form method="post">
		<?php wp_nonce_field('ckeditor_create_nonce_upload','csrf_ckeditor-for-wordpress'); ?>
		<h3><?php _e('Upload Options', 'ckeditor_wordpress') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('File browser', 'ckeditor_wordpress')?></th>
				<td>
					<select name="options[upload][browser]">
						<option value="disabled"<?php echo ($this->options['upload']['browser'] == 'disabled'?' selected="selected"':'') ?>><?php _e('Disabled', 'ckeditor_wordpress'); ?></option>
						<option value="builtin"<?php echo ($this->options['upload']['browser'] == 'builtin'?' selected="selected"':'') ?>><?php _e('Built-in (old)', 'ckeditor_wordpress'); ?></option>
						<option value="ckfinder"<?php echo ($this->options['upload']['browser'] == 'ckfinder'?' selected="selected"':'') ?>>CKFinder</option>
					</select>
					<?php if (isset($message['upload_browser'])): ?><br/><span class="error"><?php echo $message['upload_browser'] ?></span><?php endif; ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Store uploads in this folder', 'ckeditor_wordpress')?></th>
				<td>
					<input type="text" class="regular-text" name="options[upload][user_file_path]" value="<?php echo htmlspecialchars($this->options['upload']['user_file_path']);?>"/>
					<br />
					<span class="description"><?php _e('Default value:')?> wp-content/uploads</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Allowed file extensions', 'ckeditor_wordpress') ?></th>
				<td><input type="text" class="regular-text" name="options[upload][files_allowed_ext]" value="<?php echo htmlspecialchars($this->options['upload']['files_allowed_ext']);?>"/>
				<?php if (isset($message['upload_files_allowed_ext'])): ?><span class="error"><?php echo $message['upload_files_allowed_ext'] ?></span><?php endif; ?>
				<br />
				<span class="description"><?php _e('Allowed extensions separated by comma.', 'ckeditor_wordpress');?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Allowed image extensions', 'ckeditor_wordpress') ?></th>
				<td><input type="text" class="regular-text" name="options[upload][images_allowed_ext]" value="<?php echo htmlspecialchars($this->options['upload']['images_allowed_ext']);?>"/>
				<?php if (isset($message['upload_images_allowed_ext'])): ?><span class="error"><?php echo $message['upload_images_allowed_ext'] ?></span><?php endif; ?>
				<br />
				<span class="description"><?php _e('Allowed extensions separated by comma.', 'ckeditor_wordpress');?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Allowed flash extensions', 'ckeditor_wordpress') ?></th>
				<td><input type="text" class="regular-text" name="options[upload][flash_allowed_ext]" value="<?php echo htmlspecialchars($this->options['upload']['flash_allowed_ext']);?>"/>
				<?php if (isset($message['upload_flash_allowed_ext'])): ?><span class="error"><?php echo $message['upload_flash_allowed_ext'] ?></span><?php endif; ?>
				<br />
				<span class="description"><?php _e('Allowed extensions separated by comma.', 'ckeditor_wordpress');?></span>
				</td>
			</tr>
		</table>

		<h3><?php _e('CKFinder Options', 'ckeditor_wordpress') ?></h3>
		<?php
		$checkCKFinder = $this->ckfinder_status();
		if (!strpos($checkCKFinder, "ckeditor_ok")){?>
				<div class="instruction_box">
						<b><?php _e('CKFinder status: ', 'ckeditor_wordpress'); ?></b><?php echo $checkCKFinder; ?><br/><br/>
						<b><?php _e('Installation instruction:' , 'ckeditor_wordpress');?></b><br/>
						<?php _e('1. Download CKFinder for PHP: ', 'ckeditor_wordpress');?>
						<a href="http://ckfinder.com/download" target="_blank">http://ckfinder.com/download</a><br/>
						<?php _e('2. Unpack contents of the "ckfinder" folder to ', 'ckeditor_wordpress');?>
						"wp-content/plugins/ckeditor-for-wordpress/ckfinder/" directory<br/>
						<?php _e('3. Rename ckfinder_config.php to config.php (overwrite default config.php distributed with CKFinder.)', 'ckeditor_wordpress');?>
				</div>
		<?php } ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('CKFinder access', 'ckeditor_wordpress') ?></th>
				<td>
				<select name="options[ckfinder][permissions][access]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_access') ); ?></select>
				<br />
				<span class="description"><?php _e('The lowest role which should be able to access CKFinder', 'ckeditor_wordpress');?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Maximum size of uploaded file', 'ckeditor_wordpress') ?></th>
				<td>
				<input type="text" name="options[ckfinder][file_max_size]" value="<?php echo htmlspecialchars($this->options['ckfinder']['file_max_size']);?>" />
				<?php if (isset($message['ckfinder_file_max_size'])): ?><span class="error"><?php echo $message['ckfinder_file_max_size'] ?></span><?php endif; ?>
				<br />
				<span class="description"><?php _e('Maximum size is defined in bytes, but shorthand notation may be also used. Available options are: G, M, K (case insensitive). 1M equals 1048576 bytes (one Megabyte), 1K equals 1024 bytes (one Kilobyte), 1G equals one Gigabyte.', 'ckeditor_wordpress') ?></span>
				</td>
			</tr>
		</table>
		<table class="widefat" style="width:560px;">
		<thead>
		<tr>
			<th colspan="4"><?php _e('Permissions', 'ckeditor_wordpress') ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<tr valign="top">
			<th scope="row"><?php _e('Folder View');?></th><td><select name="options[ckfinder][permissions][folderView]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_folderView') ); ?></select></td>
			<th scope="row"><?php _e('File View');?></th><td><select name="options[ckfinder][permissions][fileView]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_fileView') ); ?></select></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Folder Create');?></th><td><select name="options[ckfinder][permissions][folderCreate]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_folderCreate') ); ?></select></td>
			<th scope="row"><?php _e('File Upload');?></th><td><select name="options[ckfinder][permissions][fileUpload]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_fileUpload') ); ?></select></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Folder Rename');?></th><td><select name="options[ckfinder][permissions][folderRename]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_folderRename') ); ?></select></td>
			<th scope="row"><?php _e('File Rename');?></th><td><select name="options[ckfinder][permissions][fileRename]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_fileRename') ); ?></select></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Folder Delete');?></th><td><select name="options[ckfinder][permissions][folderDelete]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_folderDelete') ); ?></select></td>
			<th scope="row"><?php _e('File Delete');?></th><td><select name="options[ckfinder][permissions][fileDelete]"><?php wp_dropdown_roles( $this->get_role('ckeditor_ckfinder_fileDelete') ); ?></select></td>
		</tr>
		</tbody>
		</table>

		<table class="widefat" style="width:560px;margin-top:10px">
		<thead>
		<tr>
			<th colspan="2"><?php _e('Images');?></th><th colspan="2"><?php _e('Thumbnails');?></th>
		</tr>
		</thead>
		<tr>
		<tr valign="top">
			<th scope="row"><?php _e('Max Width');?></th><td><input type="text" name="options[ckfinder][images_width]" value="<?php echo htmlspecialchars($this->options['ckfinder']['images_width']);?>"/> px <?php if (isset($message['ckfinder_images_width'])): ?><br /><span class="error"><?php echo $message['ckfinder_images_width'] ?></span><?php endif; ?></td>
			<th scope="row"><?php _e('Max Width');?></th><td><input type="text" name="options[ckfinder][thumbnails_width]" value="<?php echo htmlspecialchars($this->options['ckfinder']['thumbnails_width']);?>"/> px <?php if (isset($message['ckfinder_thumbnails_width'])): ?><br /><span class="error"><?php echo $message['ckfinder_thumbnails_width'] ?></span><?php endif; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Max Height');?></th><td><input type="text" name="options[ckfinder][images_height]" value="<?php echo htmlspecialchars($this->options['ckfinder']['images_height']);?>"/> px <?php if (isset($message['ckfinder_images_height'])): ?><br /><span class="error"><?php echo $message['ckfinder_images_height'] ?></span><?php endif; ?></td>
			<th scope="row"><?php _e('Max Height');?></th><td><input type="text" name="options[ckfinder][thumbnails_height]" value="<?php echo htmlspecialchars($this->options['ckfinder']['thumbnails_height']);?>"/> px <?php if (isset($message['ckfinder_thumbnails_height'])): ?><br /><span class="error"><?php echo $message['ckfinder_thumbnails_height'] ?></span><?php endif; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Quality'); ?></th><td><input type="text" name="options[ckfinder][images_quality]" value="<?php echo htmlspecialchars($this->options['ckfinder']['images_quality']);?>"/><?php if (isset($message['ckfinder_images_quality'])): ?><br /><span class="error"><?php echo $message['ckfinder_images_quality'] ?></span><?php endif; ?></td>
			<th scope="row"><?php _e('Quality'); ?></th><td><input type="text" name="options[ckfinder][thumbnails_quality]" value="<?php echo htmlspecialchars($this->options['ckfinder']['thumbnails_quality']);?>"/><?php if (isset($message['ckfinder_thumbnails_quality'])): ?><br /><span class="error"><?php echo $message['ckfinder_thumbnails_quality'] ?></span><?php endif; ?></td>
		</tr>
		<tr valign="top">
			<td colspan="2" rowspan="2"><div class="description" style="width:260px">Set the maximum size of uploaded images. Larger images are scaled down proportionally.</div></td>
			<th scope="row"><?php _e('Enabled'); ?></th><td><?php echo $this->checkbox('ckfinder', 'thumbnails_enabled', '');?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Direct Access'); ?></th><td><?php echo $this->checkbox('ckfinder', 'thumbnails_direct_access', '');?></td>
		</tr>
		</table>

		<table class="widefat" style="width:550px;margin-top:10px">
		<thead>
		<tr>
			<th colspan="4"><?php _e('CKFinder License', 'ckeditor_wordpress') ?></th>
		</tr>
		</thead>
		<tr>
		<tr valign="top">
			<th scope="row"><?php _e('License Name'); ?></th><td><input type="text" name="options[ckfinder][license_name]" value="<?php echo htmlspecialchars($this->options['ckfinder']['license_name']);?>"/></td>
			<th scope="row"><?php _e('License Key'); ?></th><td><input type="text" name="options[ckfinder][license_key]" value="<?php echo htmlspecialchars($this->options['ckfinder']['license_key']);?>"/></td>
		</tr>
		<tr valign="top">
			<td colspan="4"><span class="description"><?php _e('Paste your CKFinder license key here. See <a href="http://ckfinder.com/license">CKFinder license</a>.', 'ckeditor_wordpress'); ?></div></td>
		</tr>
		</table>

		<p class="submit">
			<input type="hidden" name="df_submit" value="1" />
			<input type="submit" class="button-primary" value="Update Options" name="submit_update" />
		</p>
</form>
</div>
