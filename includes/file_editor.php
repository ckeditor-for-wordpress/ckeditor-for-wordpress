<div class="wrap">
	<div id="icon-wp-ckeditor" class="icon32"><br /></div>
	<h2><?php _e('CKEditor - configuration files', 'ckeditor_wordpress') ?></h2>
	<?php if (count($files) > 1): ?>
	<form method="post">
		<table class="form-table">
			<tr valign="top">
				<td>
					<select name="file">
					<?php foreach($files as $filename => $path): ?>
						<option value="<?php echo $filename ?>"<?php echo ($filename==$file?' selected="selected"':'') ?>><?php echo $filename ?></option>
					<?php endforeach; ?>
					</select>
					<input type="submit" value="Change" />
				</td>
			</tr>
		</table>
	</form>
	<?php endif; ?>
	<form method="post" name="template" id="template">
		<?php wp_nonce_field('ckeditor_create_nonce_file_editor','csrf_ckeditor-for-wordpress'); ?>
		<input type="hidden" name="file" value="<?php echo $file ?>" />
		<h3><?php _e('Browsing ', 'ckeditor_wordpress') ?>: <i><?php echo $file ?></i></h3>
		<table class="form-table">
			<tr valign="top">
				<td>
					<textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1"  class="codepress javascript" style="width: 97%"><?php echo $content ?></textarea>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="hidden" name="df_submit" value="1" />
			<input type="submit" class="button-primary" value="Update File" name="submit_update" />
		</p>
	</form>
</div>
