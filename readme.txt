=== Plugin Name ===
Contributors: Kazuma YAGYU
Donate link: http://hennayagyu.com/
Tags: formatting, post, text
Requires at least: 3.0.4
Tested up to: 3.3.2
Stable tag: 0.7

Wordpress ignores multiple line breaks normaly. This plugin breaks lines as may as you want.

== Description ==

This plugin changes the WordPress's native formatting rules to keep the numbers of the line breaks you wrote.
It adds &lt;br /&gt; tags as many as line breaks in posts, comments, or both, even if the line was vacant.
You can change the settings below in the admin panel. For example: you can choose to add &lt;p&gt; tags for wrapping the paragraphs or not.

= Settings =
You can choose settings below.

1. Choose the target area: in posts, comments, or both(default).
1. Choose the breaking tag format: &lt;br /&gt;(default) or &lt;br&gt;.
1. Choose the tag which the paragraphs will be wrapped with: &lt;p&gt; tag(default) or none.
1. Shortcodes that you want to exclude from &lt;p&gt; tag wrapping.
This doesn't work if you choose "none" in option #3.
Default is only "caption" but you can set multiple shortcodes separating "|". Ex. "caption|map"

= Attention =
This plugin doesn't work with the Visual Editor, so far.


= For Japanese users =
このプラグインは行末に&lt;br /&gt;を追加します。
記事投稿時の改行の数だけ&lt;br /&gt;が追加されます。
段落に&lt;p&gt;タグを追加するか、といったいくつかの設定ができます。
※ビジュアルリッチエディターではうまく動作しません


== Installation ==

1. Upload 'vacant-line-breaker' folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit settings through the 'Settings' menu as you like

== Frequently Asked Questions ==

= Can I use this plugin with the Visual Editor? =

Unfortunately, no.

= This plugin changes data in DB? =

No. This plugin changes no data in DB. This plugin just changes a little the WordPress's native formatting rules when a post or a comment is shown in page.


== Screenshots ==

1. Edit settings through the 'Settings' menu as you like.


== Changelog ==

= 0.7 =
* Add p tag after shortcodes.

= 0.6 =
* Fixed problems with closing tags.

= 0.5 =
* Fixed problems with video.

= 0.4 =
* Fixed problems with single tags.

= 0.3 =
* Add an option for shortcodes.

= 0.2 =
* Available in Japanese.

= 0.1 =
* First release.

== Upgrade Notice ==

No upgrade, so far.