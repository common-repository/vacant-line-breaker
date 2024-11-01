<?php
/*
Plugin Name: Vacant Line BReaker
Version: 0.7
Plugin URI: http://hennayagyu.com/
Description: Wordpress ignores multiple line breaks normaly. This plugin puts &lt;br /&gt; tags as many as line breaks.
Author: Kazuma YAGYU
Author URI: http://hennayagyu.com/
*/
/*	Copyright 2012  Kazuma YAGYU  (email : info(at)hennayagyu.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// localization
load_plugin_textdomain( 'vacant-line-breaker', false, dirname(plugin_basename( __FILE__ )). '/languages/' );

/* ------------------------------------------------------------------------ *
	install
 * ------------------------------------------------------------------------ */

register_activation_hook( __FILE__, 'vlbr_install');
function vlbr_install() {
	vlbr_add_options();
}
function vlbr_add_options() {
	add_option('vlbr_filter_target', 'both');
	add_option('vlbr_br_format', 1);
	add_option('vlbr_insert_paragraph_tags', true);
	add_option('vlbr_shortcodes', 'caption');
}

/* ------------------------------------------------------------------------ *
	uninstall
 * ------------------------------------------------------------------------ */

register_deactivation_hook( __FILE__, 'vlbr_uninstall');
function vlbr_uninstall() {
	vlbr_delete_options();
}
function vlbr_delete_options() {
	delete_option('vlbr_filter_target');
	delete_option('vlbr_br_format');
	delete_option('vlbr_insert_paragraph_tags');
	delete_option('vlbr_shortcodes');
}

/* ------------------------------------------------------------------------ *
	admin menu
 * ------------------------------------------------------------------------ */

// define options page
function vlbr_options() {
	?>
	<div id="wrap-vlbr" class="wrap">
		<h2>Vacant Line BReaker</h2>
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<table class="widefat">
				<tr>
					<th scope="row"><label for="vlbr_filter_target"><?php _e('Break lines in', 'vacant-line-breaker'); ?></label></th>
					<td><select name="vlbr_filter_target" id="vlbr_filter_target">
						<option value="both"<?php vlbr_option_select('vlbr_filter_target', 'both'); ?>><?php _e('both posts and comments', 'vacant-line-breaker'); ?></option>
						<option value="post"<?php vlbr_option_select('vlbr_filter_target', 'post'); ?>><?php _e('only posts', 'vacant-line-breaker'); ?></option>
						<option value="post"<?php vlbr_option_select('vlbr_filter_target', 'comment'); ?>><?php _e('only comments', 'vacant-line-breaker'); ?></option>
					</select></td>
				</tr>
				<tr>
					<th scope="row"><label for="vlbr_br_format"><?php _e('Break lines with', 'vacant-line-breaker'); ?></label></th>
					<td><select name="vlbr_br_format" id="vlbr_br_format">
						<option value="1"<?php vlbr_option_select('vlbr_br_format', 1); ?>><?php _e('&lt;br /&gt;s', 'vacant-line-breaker'); ?></option>
						<option value="0"<?php vlbr_option_select('vlbr_br_format', 0); ?>><?php _e('&lt;br&gt;s', 'vacant-line-breaker'); ?></option>
					</select></td>
				</tr>
				<tr>
					<th scope="row"><label for="vlbr_insert_paragraph_tags"><?php _e('Wrap paragraphs with', 'vacant-line-breaker'); ?></label></th>
					<td><select name="vlbr_insert_paragraph_tags" id="vlbr_insert_paragraph_tags">
						<option value="1"<?php vlbr_option_select('vlbr_insert_paragraph_tags', 1); ?>><?php _e('&lt;p&gt; tags', 'vacant-line-breaker'); ?></option>
						<option value="0"<?php vlbr_option_select('vlbr_insert_paragraph_tags', 0); ?>><?php _e('none'); ?></option>
					</select></td>
				</tr>
				<tr>
					<th scope="row"><label for="vlbr_shortcodes"><?php _e('Shortcodes', 'vacant-line-breaker'); ?></label></th>
					<td><input type="text" name="vlbr_shortcodes" id="vlbr_shortcodes" value="<?php vlbr_option_value('vlbr_shortcodes'); ?>"><span class="caution"><?php _e('* Each shortcodes should be separated with a |', 'vacant-line-breaker'); ?></span></td>
				</tr>
			</table>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="vlbr_filter_target, vlbr_br_format, vlbr_insert_paragraph_tags, vlbr_shortcodes" />
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
		</form>
	</div>
	<?php
}
function vlbr_option_select($name, $value) {
	if($value == get_option($name)) {
		echo ' selected="selected"';
	}
}
function vlbr_option_value($name) {
	$value = get_option($name);
	echo $value;
}

// add options page
add_action('admin_menu', 'vlbr_add_adminmenu');
function vlbr_add_adminmenu() {
	$page = add_options_page('Vacant Line BReaker Options', 'VL BReaker', 8, 'vlbr_adminmenu', 'vlbr_options');
	add_action("admin_print_scripts-$page", 'vlbr_admin_css');
}
function vlbr_admin_css() {
	$siteurl = get_option('siteurl');
	$cssurl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/vacant-line-breaker-admin.css';
	echo '<link rel="stylesheet" type="text/css" href="'. $cssurl. '" />'. "\n";
}

/* ------------------------------------------------------------------------ *
	add "Settings" link to admin plugins page
 * ------------------------------------------------------------------------ */

function vlbr_add_settings_link($links, $file) {
	$plugin = plugin_basename(__FILE__);
	if($file == $plugin) {
		$settings_link = array( sprintf('<a href="options-general.php?page=vlbr_adminmenu">%s</a>', __('Settings')) );
		return array_merge($settings_link, $links);
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'vlbr_add_settings_link', 10, 2 );

/* ------------------------------------------------------------------------ *
	apply filters
 * ------------------------------------------------------------------------ */

// in posts
if("post" == get_option(vlbr_filter_target) || "both" == get_option(vlbr_filter_target)) {
	remove_filter('the_content', 'wpautop');
	add_filter('the_content', 'vlbr_break_lines');
}
function vlbr_break_lines($str) {
	$br = get_option(vlbr_br_format)? "<br />": "<br>";
	$need_p_tag = get_option(vlbr_insert_paragraph_tags)? true: false;
	$shortcode_not_allowed_in_paragraph = get_option(vlbr_shortcodes);

	// tags
	$tags_allowed_to_be_put_before_br = "a|abbr|b|bdo|cite|code|del|dfn|em|i|ins|kbd|label|mark|meta|meter|noscript|output|progress|q|ruby|s|samp|select|small|span|strong|sub|sup|svg|time|var";
	$tags_not_allowed_in_paragraph = "address|article|aside|audio|blockquote|canvas|div|dl|figure|footer|form|h[1-6]|header|hgroup|iframe|nav|object|ol|pre|section|table|textarea|ul|video";
	$single_tags_allowed_to_be_put_before_br = "button|img|input|keygen";
	$single_tags_not_allowed_in_paragraph = "hr";
	// attention: blockquote, del, ins, label
	// not mentioned: area, br, caption, col, colgroup, command, datalist, dt, dd, embed, fieldset, legend, map, math*, menu, optgroup, option, script, source, summary, tbody, td, tfoot, th, thead, tr

	// simplify line break codes
	$str = str_replace(array("\r\n", "\r"), "\n", $str);

	// add <br>s
	$str = preg_replace('/^\n/m', $br. "\n", $str); // after vacant lines
	$str = preg_replace('/([^>])\n/', "$1". $br. "\n", $str); // after texts
	$str = preg_replace('/(<\/(?:'. $tags_allowed_to_be_put_before_br. ')>)\n/i', "$1". $br. "\n", $str); // after phrasing tags
	$str = preg_replace('/(<(?:'. $single_tags_allowed_to_be_put_before_br. ')( [^>]+)?>)\n/i', "$1". $br. "\n", $str); // after single tags

	// add <p>s
	if($need_p_tag) {
		// add temporaly </p>
		$_close_p = '</_$$closing_p_tag$$_>';
		$str = preg_replace('/(<(?:'. $tags_not_allowed_in_paragraph. ')( [^>]+)?>)/i', $_close_p. "\n$1", $str);

		// add <p>
		$str = preg_replace('/(<\/(?:'. $tags_not_allowed_in_paragraph. ')>)/i', "$1\n<p>", $str);

		// add <p> after shortcodes
		$str = preg_replace('/]<br ?\/?>/i', "]\n<p>", $str);

		// add both
		$str = preg_replace('/(<(?:'. $single_tags_not_allowed_in_paragraph. ')( [^>]+)?>)/i', "</p>\n$1\n<p>", $str);

		// change temporaly </p> to real </p>
		$str = str_replace('</_$$closing_p_tag$$_>', '</p>', $str); // replace temporaly closing 'p' tags to </p>s

		// shortcode
		$str = preg_replace('/<br ?\/?>\n(\[(?:'. $shortcode_not_allowed_in_paragraph. ')( [^\]]+)?\])/i', "</p>\n$1", $str);
		$str = preg_replace('/(\[\/(?:'. $shortcode_not_allowed_in_paragraph. ')\])<br ?\/?>/i', "$1\n<p>", $str);

		// wrap all sentences with a <p>
		$str = "<p>". $str. "</p>";

		// erace vacant <p>s
		$str = preg_replace('/<p>\s*<\/p>/i', "", $str);
		$str = preg_replace('/<p>\s*<p>/i', "<p>", $str);
		$str = preg_replace('/(?:<br ?\/?>|<\/p>)\s*<\/p>/i', "</p>", $str);

		// adjust multiple <p>s
		$str = preg_replace('/(<p>)+/i', "<p>", $str);
		$str = preg_replace('/(<\/p>)+/i', "</p>", $str);
	}

	return $str;
}

// in comments
if("comment" == get_option(vlbr_filter_target) || "both" == get_option(vlbr_filter_target)) {
	remove_filter('comment_text','get_comment_text');
	add_filter('comment_text','vlbr_break_comment_lines');
}
function vlbr_break_comment_lines() {
	global $comment;
	$comment_text = apply_filters('get_comment_text', $comment->comment_content);
	$comment_text = make_clickable($comment_text);
	echo vlbr_break_lines($comment_text);
}
?>