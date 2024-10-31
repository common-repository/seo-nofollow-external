<?php
/*
Plugin Name: SEO Nofollow External
Plugin URI: http://codeilike.com/nofollow-external
Description: Automatically add rel="nofollow" and target="_blank" to all external links. To get started, click the "Activate" link to the left of this description.
Author: Ifty Rahman
Author URI: http://ifty.info/
Version: 0.1
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// Make All External Link Nofollow
add_filter('the_content', 'cil_nofollow_external');
function cil_nofollow_external($content){
	return preg_replace_callback('/<a[^>]+/', 'cil_nofollow_callback', $content);
}

function cil_nofollow_callback($matches){
	$link = $matches[0];
	$mu_url = get_bloginfo('url');

	if (strpos($link, 'rel') === false){
		$link = preg_replace("%(href=\S(?!$mu_url))%i", 'rel="nofollow" $1', $link);
	}elseif (preg_match("%href=\S(?!$mu_url)%i", $link)){
		$link = preg_replace('/rel=S(?!nofollow)\S*/i', 'rel="nofollow"', $link);
	}
	return $link;
}

// Automatically add target="_blank"
add_filter('the_content', 'cil_new_tab_link');
function cil_new_tab_link($content){
	return preg_replace_callback('/<a[^>]+/', 'cil_target_callback', $content);
}

function cil_target_callback($matches){
	$link = $matches[0];
	$mu_url = get_bloginfo('url');

	if (strpos($link, 'target') === false){
		$link = preg_replace("%(href=\S(?!$mu_url))%i", 'target="_blank" $1', $link);
	}elseif (preg_match("%href=\S(?!$mu_url)%i", $link)){
		$link = preg_replace('/target=S(?!_blank)\S*/i', 'target="_blank"', $link);
	}
	return $link;
}


?>