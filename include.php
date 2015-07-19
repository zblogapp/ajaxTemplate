<?php
#注册插件
RegisterPlugin("ajaxTemplate", "ActivePlugin_ajaxTemplate");

function ActivePlugin_ajaxTemplate() {
	Add_Filter_Plugin('Filter_Plugin_Html_Js_Add', 'ajaxTemplate_html_js_add');

}

function ajaxTemplate_html_js_add() {

	global $zbp;
	global $bloghost;
	$parsedUrl = parse_url($bloghost);
	$config = unserialize($zbp->Config('ajaxTemplate')->selectors);
	$callbackIng = $zbp->Config('ajaxTemplate')->callbackIng;
	$callbackEd = $zbp->Config('ajaxTemplate')->callbackEd;
	$path = $parsedUrl['path'];
	if ($path !== '/') {
		$path = substr($path, 0, strrpos($path, '/'));
	}

	echo "\n" . '; document.writeln("<script src=\"' . $bloghost . 'zb_users/plugin/ajaxTemplate/ajaxtemplate.js\"></script><script src=\"' . $bloghost . 'zb_users/plugin/ajaxTemplate/page.min.js\"></script>");';
	echo '$(function() {';
	echo '$.ajaxTemplate({host: "' . $path . '", replaceSelector: ' . json_encode($config) . '}, function(pageObject) {' . $callbackIng . '}, function(pageObject, xhrData) {' . $callbackEd . '});';
	echo '});';
	echo "\n";

}

function InstallPlugin_ajaxTemplate() {}
function UninstallPlugin_ajaxTemplate() {}