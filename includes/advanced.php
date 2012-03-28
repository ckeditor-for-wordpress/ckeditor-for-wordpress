<div class="wrap">
	<div id="icon-wp-ckeditor" class="icon32"><br /></div>
	<h2><?php _e('CKEditor - Advanced Settings', 'ckeditor_wordpress') ?></h2>
	<form method="post" id="ca_form">
		<?php wp_nonce_field('ckeditor_create_nonce_advanced','csrf_ckeditor-for-wordpress'); ?>
		<h3><?php _e('CSS Options', 'ckeditor_wordpress') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Editor CSS', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[css][mode]">
						<option value="default"<?php echo ($this->options['css']['mode']=='default'?' selected="selected"':'') ?>><?php _e('CKEditor default (recommended)', 'ckeditor_wordpress');?></option>
						<option value="theme"<?php echo ($this->options['css']['mode']=='theme'?' selected="selected"':'') ?>><?php _e('Use theme css', 'ckeditor_wordpress');?></option>
						<option value="self"<?php echo ($this->options['css']['mode']=='self'?' selected="selected"':'') ?>><?php _e('Define css', 'ckeditor_wordpress');?></option>
					</select>
					<div class="description"><?php _e("Defines the CSS to be used in the editor area.<br />Use theme css - load style.css from current site theme.<br />Define css - enter path for css file below.<br />CKEditor default - uses default CSS from editor.", 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('CSS path', 'ckeditor_wordpress') ?></th>
				<td>
					<input type="text" name="options[css][path]" value="<?php echo htmlspecialchars($this->options['css']['path']) ?>" />
					<?php if (isset($message['css_path'])): ?><span class="error"><?php echo $message['css_path'] ?></span><?php endif; ?>
					<div class="description"><?php _e('Enter path to CSS file (Example: "css/editor.css") or a list of css files separated by a comma (Example: "/wp-content/themes/default/style.css,http://example.com/style.css"). Make sure to select "Define css" above.<br />Available placeholders:<br />%h - host name (/).<br />%t - path to theme.', 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Predefined styles', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[css][styles]">
						<option value="theme"<?php echo ($this->options['css']['styles']=='theme'?' selected="selected"':'') ?>><?php _e('Use theme ckeditor.styles.js', 'ckeditor_wordpress');?></option>
						<option value="self"<?php echo ($this->options['css']['styles']=='self'?' selected="selected"':'') ?>><?php _e('Define path to ckeditor.styles.js', 'ckeditor_wordpress');?></option>
						<option value="default"<?php echo ($this->options['css']['styles']=='default'?' selected="selected"':'') ?>><?php _e('CKEditor default', 'ckeditor_wordpress');?></option>
					</select>
					<div class="description"><?php _e('Define the location of "ckeditor.styles.js" file. It is used by the "Style" dropdown list available in the default toolbar.', 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Predefined styles path', 'ckeditor_wordpress') ?></th>
				<td>
					<input type="text" name="options[css][style_path]" value="<?php echo htmlspecialchars($this->options['css']['style_path']) ?>" />
					<?php if (isset($message['css_style_path'])): ?><span class="error"><?php echo $message['css_style_path'] ?></span><?php endif; ?>
					<div class="description"><?php _e('Enter path to file with predefined styles (Example: "/ckeditor.styles.js"). Be sure to select "define path to ckeditor.styles.js" above.<br />Available placeholders:<br />%h - host name (/).<br />%t - path to theme .', 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
		</table>
		<h3><?php _e('Output Formatting', 'ckeditor_wordpress') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Output formatting', 'ckeditor_wordpress')?><br /><span class="description">(<?php _e('Writer rules', 'ckeditor_wordpress'); ?>)</span></th>
				<td>
					<?php echo $this->checkbox('advanced', 'p_indent', 'indent the element contents.');?><br />
					<?php echo $this->checkbox('advanced', 'p_break_before_open', 'break line before the opener tag.');?><br />
					<?php echo $this->checkbox('advanced', 'p_break_after_open', 'break line after the opener tag.');?><br />
					<?php echo $this->checkbox('advanced', 'p_break_before_close', 'break line before the closer tag.');?><br />
					<?php echo $this->checkbox('advanced', 'p_break_after_close', 'break line after the closer tag.');?><br />
				</td>
			</tr>
		</table>
		<h3><?php _e('Advanced Options', 'ckeditor_wordpress') ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Spell checker', 'ckeditor_wordpress')?><br /></th>
				<td>
					<?php echo $this->checkbox('advanced', 'scayt_autoStartup', 'SCAYT auto startup.');?><br />
					<div class="description"><?php _e('If enabled, turns on SCAYT (Spell Check As You Type) automatically after loading the editor.', 'ckeditor_wordpress'); ?></div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Built-in spell checker', 'ckeditor_wordpress')?></th>
				<td><?php echo $this->checkbox('advanced', 'native_spell_checker', 'Enable the built-in spell checker while typing natively available in the browser.');?>
				<div class="description">(<?php _e('currently Firefox and Safari only', 'ckeditor_wordpress');?>)</div></td></tr>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('HTML entities', 'ckeditor_wordpress')?></th>
				<td><?php echo $this->checkbox('advanced', 'entities', 'Using HTML entities in the output.');?>
				<div class="description">(<?php _e('Convert all applicable characters to HTML entities', 'ckeditor_wordpress');?>)</div></td></tr>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Plugins', 'ckeditor_wordpress')?></th>
				<td>
					<?php
						$plugins = apply_filters('ckeditor_external_plugins', array());
						$plugins = array_keys($plugins);
						$plugins[] = "autogrow";
						$plugins[] = "tableresize";
						sort($plugins);

						foreach ($plugins as $plugin){
							if ($plugin == "wpgallery" || $plugin == "wpeditimage") continue;
							if (!isset($this->options['plugins'][$plugin])){
								$this->options['plugins'][$plugin] = 't';
							}
							echo $this->checkbox('plugins', $plugin, ucfirst($plugin) . ' plugin') . '<br />';
						}
					?>
				<div class="description">(<?php _e('Choose the plugins which u want to load into CKEditor', 'ckeditor_wordpress');?>)</div>
			</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Load method', 'ckeditor_wordpress') ?></th>
				<td>
					<select name="options[advanced][load_method]">
						<option value="ckeditor.js"<?php echo ($this->options['advanced']['load_method']=='ckeditor.js'?' selected="selected"':'') ?>>ckeditor.js</option>
						<option value="ckeditor_basic.js"<?php echo ($this->options['advanced']['load_method']=='ckeditor_basic.js'?' selected="selected"':'') ?>>ckeditor_basic.js</option>
						<?php if (file_exists(dirname(dirname(__FILE__))."/ckeditor/_source")):?>
						<option value="ckeditor_source.js"<?php echo ($this->options['advanced']['load_method']=='ckeditor_source.js'?' selected="selected"':'') ?>>ckeditor_source.js (for developers only)</option>
						<?php endif; ?>
					</select>
					<div class="description"><?php _e('Select the load method of CKEditor. If ckeditor_base.js is used, only a small file is initially loaded and the rest part of the editor is loaded later (see "Load timeout"). This might be handy if CKEditor is disabled by default.', 'ckeditor_wordpress');?><br/>
					<?php _e('You can also choose loading ckeditor_source.js (for developers), but only if you download the full CKEditor package from <a href="http://ckeditor.com/download">CKEditor web site</a> and unpack it in the "ckeditor" folder. CKEditor distributed with this plugin does not contain _source files as well as the _samples folder to reduce the size of a plugin, that\'s why this option is not available by default.', 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Load timeout', 'ckeditor_wordpress')?></th>
				<td>
					<input type="text" name="options[advanced][load_timeout]"	value="<?php echo $this->options['advanced']['load_timeout']; ?>"/>s
					<?php if (isset($message['advanced_load_timeout'])): ?><span class="error"><?php echo $message['advanced_load_timeout'] ?></span><?php endif; ?>
					<div class="description"><?php _e('The time to wait (in seconds) to load the full editor code after the page load, if the "ckeditor_basic.js" file is used. If set to zero, the editor is loaded on demand.', 'ckeditor_wordpress') ?></div>
				</td>
			</tr>
			<?php
				$langs = apply_filters('ckeditor_load_lang_options', array());
			?>
			<tr valign="top">
				<th scope="row"><?php _e('Language', 'ckeditor_wordpress')?></th>
				<td>
			<?php
				if (isset($this->options['advanced']['language']))
				{
					$selected = $this->options['advanced']['language'];
				}else{
					$selected = (get_locale())? get_locale() : 'en';
				}
			?>
				<select name="options[advanced][language]">
					<?php foreach ($langs AS $key => $lang): ?>
						<option value="<?php echo $key?>" <?php if($key == $selected):?>selected="selected"<?php endif;?>><?php echo $lang ?></option>
					<?php endforeach; ?>
				</select>
				<br /><span class="description"><?php _e('The language for the CKEditor user interface.', 'ckeditor_wordpress'); ?></span>
				<?php if (isset($message['advanced_language'])): ?><span class="error"><?php echo $message['advanced_language'] ?></span><?php endif; ?>
				</td>
			</tr>
			<?php
				if (isset($this->options['advanced']['detect_language_auto']))
				{
					$auto = $this->options['advanced']['detect_language_auto'];
				} else {
					$auto = 't';
				}
			?>
			<tr valign="top">
				<th scope="row"><?php _e('Auto-detect language', 'ckeditor_wordpress')?></th>
				<td>
					<input id="autodetect_enabled" name="options[advanced][detect_language_auto]" type="radio" value="t" <?php if($auto == 't'):?>checked="checked"<?php endif; ?>><label for="autodetect_enabled">Enabled</label> <br/>
					<input id="autodetect_disabled" name="options[advanced][detect_language_auto]" type="radio" value="f" <?php if($auto == 'f'):?>checked="checked"<?php endif; ?>><label for="autodetect_disabled"> Disabled</label>
					<br /><span class="description"><?php _e('Automatically detect the user language.', 'ckeditor_wordpress'); ?></span>
					<?php if (isset($message['advanced_detect_language_auto'])): ?><br/><span class="error"><?php echo $message['advanced_detect_language_auto'] ?></span><?php endif; ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Language direction ', 'ckeditor_wordpress')?></th>
				<td>
			<?php
				if (isset($this->options['advanced']['language_direction']))
				{
					$selected = $this->options['advanced']['language_direction'];
				}else{
					$selected = 'default';
				}
			?>
				<select name="options[advanced][language_direction]">
					<option value="default" <?php if($selected == 'default'):?>selected="selected"<?php endif;?>>Get from current locale (default)</option>
					<option value="ltr" <?php if($selected == 'ltr'):?>selected="selected"<?php endif;?>>Left-To-Right</option>
					<option value="rtl" <?php if($selected == 'rtl'):?>selected="selected"<?php endif;?>>Right-To-Left</option>
				</select>
				<br /><span class="description"><?php _e('Choose the language direction used in the editing area. Even when CKEditor automatically detects the user language and adjusts its user interface, the editing area is not automatically changed into the LTR or RTL mode. To be able to type LTR (like English) and RTL (like Arabic, Hebrew, Persian) content at the same time, please make sure that the BidiLtr and BidiRtl buttons are enabled in the toolbar.', 'ckeditor_wordpress'); ?></span>
				<?php if (isset($message['advanced_language_direction'])): ?><span class="error"><?php echo $message['advanced_language_dierction'] ?></span><?php endif; ?>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="hidden" name="df_submit" value="1" />
			<input type="submit" class="button-primary" value="Update Options" name="submit_update" />
		</p>
	</form>
</div>
