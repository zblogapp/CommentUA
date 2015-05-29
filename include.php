<?php
$commentua_list = array();
define('COMMENTUA_PATH', dirname(__FILE__) . '/');
RegisterPlugin("CommentUA", "ActivePlugin_CommentUA");

function ActivePlugin_CommentUA() {
	Add_Filter_Plugin('Filter_Plugin_Comment_Call', 'CommentUA_GetUserAgent');
}

function InstallPlugin_CommentUA() {
}

function UninstallPlugin_CommentUA() {
}

function CommentUA_include() {
	include_once COMMENTUA_PATH . 'php-useragent/useragent.class.php';
}

function CommentUA_SubMenu($id) {
	$arySubMenu = array(
		'default' => array('代码调用', 'main.php', 'left', false),
		'test' => array('UA测试', 'main.php?action=test', 'left', false),
		'help' => array('帮助', 'main.php?action=help', 'right', false),
	);
	if (!isset($arySubMenu[$id])) {
		$id = 'default';
	}

	foreach ($arySubMenu as $k => $v) {
		echo '<a href="' . $v[1] . '" ' . ($v[3] ? 'target="_blank"' : '');
		echo '><span class="m-' . $v[2] . ' ' . ($id == $k ? 'm-now' : '');
		echo '">' . $v[0] . '</span></a>';
	}
}

function CommentUA_GetUserAgent($object, $method, $args) {
	global $commentua_list;
	global $bloghost;
	$hash = md5(strtolower($object->Agent));
	CommentUA_include();
	$useragent = UserAgentFactory::analyze($object->Agent, null, $bloghost . 'zb_users/plugin/CommentUA/img/');
	if (!isset($commentua_list[$hash])) {
		$commentua_list[$hash] = array(
			'platform' => $useragent->platform,
			'browser' => $useragent->browser,
		);

		$commentua_list[$hash]['all_16'] = $commentua_list[$hash]['platform']['all_16'] . '&nbsp;' . $commentua_list[$hash]['browser']['all_16'];
		$commentua_list[$hash]['all_24'] = $commentua_list[$hash]['platform']['all_24'] . '&nbsp;' . $commentua_list[$hash]['browser']['all_24'];

	}

	if (is_string($object)) {
		return $commentua_list[$hash];
	} else {
		$object->CommentUA = $commentua_list[$hash];
		return '';
	}
}