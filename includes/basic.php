<?php
/*
Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or http://ckeditor.com/license
*/
?>
<div class=wrap>
	<div id="icon-wp-ckeditor" class="icon32"><br /></div>
	<h2><?php _e('CKEditor - Basic Settings', 'ckeditor_wordpress') ?></h2>
	<form method="post" >
		<?php wp_nonce_field('ckeditor_create_nonce_basic','csrf_ckeditor-for-wordpress'); ?>
		<h3><?php _e('Common Options', 'ckeditor_wordpress') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Select the skin to load', 'ckeditor_wordpress')?></th>
				<td>
					<select name="options[appearance][skin]">
						<option value="kama"<?php echo ($this->options['appearance']['skin'] == 'kama'?' selected="selected"':'') ?>>Kama</option>
						<option value="moono"<?php echo ($this->options['appearance']['skin'] == 'moono'?' selected="selected"':'') ?>>Moono</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('User Interface color', 'ckeditor_wordpress')?></th>
				<td>
					<select name="options[appearance][uicolor]" id="edit-uicolor">
						<option value="default"<?php echo ($this->options['appearance']['uicolor'] == 'default'?' selected="selected"':'') ?>>Default</option>
						<option value="custom"<?php echo ($this->options['appearance']['uicolor'] == 'custom'?' selected="selected"':'') ?>>Custom</option>
					</select>
					<textarea style="display:none;" class="ckeditor_ui_demo" id="edit-uicolor-textarea">
					Click on the &lt;strong&gt;UI Color Picker&lt;/strong&gt; button to set your color preferences.
					</textarea>
					<input type="hidden" name="options[appearance][uicolor_user]" id="edit-uicolor-user" value="<?php echo $this->options['appearance']['uicolor_user']?>" />
				</td>
			</tr>
			</table>

		<h3><?php _e('Post/Page Editor options', 'ckeditor_wordpress')?></h3>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Default state', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[appearance][default_state]">
						<option value="t"<?php echo ($this->options['appearance']['default_state']=='t'?' selected="selected"':'') ?>>Enabled</option>
						<option value="f"<?php echo ($this->options['appearance']['default_state']=='f'?' selected="selected"':'') ?>>Disabled</option>
					</select>
					<br />
					<span class="description"><?php _e('Default editor state. If disabled, rich text editor may still be enabled by pressing the "Visual" tab.', 'ckeditor_wordpress') ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Excerpt state', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[appearance][excerpt_state]">
						<option value="t"<?php echo ($this->options['appearance']['excerpt_state']=='t'?' selected="selected"':'') ?>>Enabled</option>
						<option value="f"<?php echo ($this->options['appearance']['excerpt_state']=='f'?' selected="selected"':'') ?>>Disabled</option>
					</select>
					<br />
					<span class="description"><?php _e('When enabled , CKEditor will be used in excerpt field.', 'ckeditor_wordpress') ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Editor toolbar', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[appearance][post_toolbar]">
						<option value="WordpressBasic"<?php echo ($this->options['appearance']['post_toolbar']=='WordpressBasic'?' selected="selected"':'') ?>>WordpressBasic</option>
						<option value="WordpressFull"<?php echo ($this->options['appearance']['post_toolbar']=='WordpressFull'?' selected="selected"':'') ?>>WordpressFull</option>
						<option value="Full"<?php echo ($this->options['appearance']['post_toolbar']=='Full'?' selected="selected"':'') ?>>Full</option>
					</select>
					<br />
					<span class="description"><?php _e('Choose a default toolbar set. To change the toolbar, edit', 'ckeditor_wordpress') ?> "ckeditor.config.js".</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Editor height')?></th>
				<td><input type="text" name="options[appearance][post_editor_height]"	value="<?php echo $this->options['appearance']['post_editor_height']; ?>"/>px</td>
			</tr>
		</table>

		<h3><?php _e('Comment Editor Options', 'ckeditor_wordpress')?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Use CKEditor', 'ckeditor_wordpress')?></th>
				<td><?php echo $this->checkbox('appearance','comment_editor', 'Use CKEditor as comment editor');?></td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Comment toolbar', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[appearance][comment_toolbar]">
						<option value="WordpressBasic"<?php echo ($this->options['appearance']['comment_toolbar']=='WordpressBasic'?' selected="selected"':'') ?>>WordpressBasic</option>
						<option value="WordpressFull"<?php echo ($this->options['appearance']['comment_toolbar']=='WordpressFull'?' selected="selected"':'') ?>>WordpressFull</option>
						<option value="Full"<?php echo ($this->options['appearance']['comment_toolbar']=='Full'?' selected="selected"':'') ?>>Full</option>
					</select>
					<br />
					<span class="description"><?php _e('Choose a default toolbar set. To change the toolbar, edit', 'ckeditor_wordpress') ?> "ckeditor.config.js"</span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Editor height for comment', 'ckeditor_wordpress')?></th>
				<td><input type="text" name="options[appearance][comment_editor_height]" value="<?php echo htmlspecialchars($this->options['appearance']['comment_editor_height']);?>"/>px</td>
			</tr>
		</table>
		<p class="submit">
			<input type="hidden" name="df_submit" value="1" />
			<input type="submit" class="button-primary" value="Update Options" name="submit_update" />
		</p>
	</form>
</div>
