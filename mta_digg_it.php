<?php

// This is a PLUGIN TEMPLATE.

// Copy this file to a new name like abc_myplugin.php.  Edit the code, then
// run this file at the command line to produce a plugin for distribution:
// $ php abc_myplugin.php > abc_myplugin-0.1.txt

// Plugin name is optional.  If unset, it will be extracted from the current
// file name. Uncomment and edit this line to override:
$plugin['name'] = 'mta_digg_it';

$plugin['version'] = '0.1';
$plugin['author'] = 'Morgan Aldridge';
$plugin['author_uri'] = 'http://www.makkintosshu.com/';
$plugin['description'] = 'Implements embedding of Digg.com\'s new smart "Digg This" button with Submit capability.';

// Plugin types:
// 0 = regular plugin; loaded on the public web side only
// 1 = admin plugin; loaded on both the public and admin side
// 2 = library; loaded only when include_plugin() or require_plugin() is called
$plugin['type'] = 0; 


@include_once('zem_tpl.php');

if (0) {
?>
# --- BEGIN PLUGIN HELP ---

This plug-in implements a single tag (@mta_digg_it@) which will embed a "smart":http://blog.digg.com/?p=62, JavaScript "Digg This" button (with submit capability) in your article. The first time someone clicks on the "Digg This" button, they'll be brought to digg.com's "link submission":http://digg.com/ page with most of the information about the link already filled out (you can provide more or less information using various attributes). Any subsequent clicks will be brought to digg.com to "digg" the article.

h3. Syntax

The @mta_digg_it@ tag has the following syntactic structure:

p. @<txp:mta_digg_it />@

h3. Attributes

The @mta_digg_it@ tag will accept the following attributes (note: attributes are *case sensitive*):

p. *<code>digg_url="string"</code>*

When passed a url string, the URL of the article submitted to digg.com will be set to said string. When this attribute is not present (default), the current article's permlink URL will be used.

*<code>title="string"</code>*

When passed a string, the title (short description) of the article sumbitted to digg.com will be set to said string. When this attribute is not present (default), the current article's title will be used.

*<code>bodytext="string"</code>*

When passed a string, the body text (long description) of the article submitted to digg.com will be set to said string. When this attribute is not present (default), no body text will be submitted and the user can specify their own.

*<code>digg_topic="string"</code>*

When passed a string, the topic of the article submitted to digg.com will be set to said string. When left blank or the attribute is not present (default), no topic will be submitted and the user will have to select one of the above manually. Acceptable values: @apple@, @baseball@, @basketball@, @business_finance@, @celebrity@, @design@, @environment@, @extreme_sports@, @football@, @gadgets@, @gaming_news@, @general_sciences@, @golf@, @hardware@, @health@, @hockey@, @linux_unix@, @mods@, @motorsport@, @movies@, @music@, @offbeat_news@, @other_sports@, @playable_web_games@, @political_opinion@, @politics@, @programming@, @security@, @soccer@, @software@, @space@, @tech_deals@, @tech_news@, @television@, @tennis@, @videos_animation@, @videos_comedy@, @videos_educational@, @videos_gaming@, @videos_music@, @videos_people@, @videos_sports@, @world_news@.

*<code>bgcolor="string"</code>*

When passed a string (any valid "CSS color":http://www.w3schools.com/css/css_colors.asp), the background color around the "Digg It" button will be set to said color. When the attribute is not present (default) the background color will be set to white.

*<code>compact="integer"</code>*

When set to *1*, a smaller, horizontal "Digg It" button will be used instead of the standard, larger, vertical "Digg It" button. Available values: *1* or *0* (default).

h3. Examples

p. @<txp:mta_digg_it />@

p. @<txp:mta_digg_it skin="compact" bgcolor="#000"/>@

p. @<txp:mta_digg_it bodytext="<txp:excerpt />" />@


# --- END PLUGIN HELP ---
<?php
}

# --- BEGIN PLUGIN CODE ---


function mta_digg_it($atts)
{
	global $thisarticle;
	$digg_js = '';
	
	extract(lAtts(array(
		'digg_url' => permlinkurl($thisarticle),
		'title' => $thisarticle['title'],
		'bodytext' => '',
		'digg_topic' => '',
		'bgcolor' => '',
		'compact' => 0
	),$atts));
	
	$digg_js .= '<script type="text/javascript">'."\n";
	$digg_js .= 'digg_url = \''.$digg_url."';\n";
    if ( $title != '' )
    {
    	$digg_js .= 'digg_title = \''.htmlspecialchars($title)."';\n";
    }
    if ( $bodytext != '' )
    {
    	$digg_js .= 'digg_bodytext = \''.htmlspecialchars($bodytext)."';\n";
    }
    if ( $digg_topic != '' )
    {
    	$digg_js .= 'digg_topic = \''.$digg_topic."';\n";
    }
    if ( $bgcolor != '' )
    {
    	$digg_js .= 'digg_bgcolor = \''.$bgcolor."';\n";
    }
    if ( $compact == 1 )
    {
    	$digg_js .= 'digg_skin = \'compact\';'."\n";
    }
    $digg_js .= '</script>'."\n";
	
	$digg_js .= '<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>';
	
	return $digg_js;
}

# --- END PLUGIN CODE ---

?>