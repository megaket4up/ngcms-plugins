<?php
/*
=====================================================
 NG FORUM v.alfa
-----------------------------------------------------
 Author: Nail' R. Davydov (ROZARD)
-----------------------------------------------------
 Jabber: ROZARD@ya.ru
 E-mail: ROZARD@list.ru
-----------------------------------------------------
 © Настоящий программист никогда не ставит
 комментариев. То, что писалось с трудом, должно
 пониматься с трудом. :))
-----------------------------------------------------
 Данный код защищен авторскими правами
=====================================================
*/
if (!defined('NGCMS')) die ('HAL');
$tpath = locatePluginTemplates(array('topic_modify'), 'forum', pluginGetVariable('forum', 'localsource'), pluginGetVariable('forum', 'localskin'));
$xt = $twig->loadTemplate($tpath['topic_modify'] . 'topic_modify.tpl');
if (isset($params['id']))
	$id = isset($params['id']) ? intval($params['id']) : '';
else
	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
if (empty($id))
	return $output = information('id сообщения не указан не передан', $title = 'Информация');
$time = time() + ($config['date_adjust'] * 60);
$sql = 'SELECT p.message, p.author_id, p.tid, p.id, p.c_data, t.title FROM ' . prefix . '_forum_posts AS p LEFT JOIN ' . prefix . '_forum_topics AS t ON p.tid = t.id INNER JOIN ' . prefix . '_forum_forums AS f ON t.fid = f.id WHERE p.id = ' . securemysql($id) . ' LIMIT 1';
$row = $mysql->record($sql);
$title = isset($_REQUEST['title']) ? secureinput($_REQUEST['title']) : '';
$message = isset($_REQUEST['message']) ? secureinput($_REQUEST['message']) : '';
$del['id']['attach_delete'] = isset($_REQUEST['attach_delete']) ? secureinput($_REQUEST['attach_delete']) : array();
if (isset($_REQUEST['submit'])) {
}
$error_input = '';
if (isset($error_text) && is_array($error_text))
	foreach ($error_text as $error)
		$error_input .= msg(array("type" => "error", "text" => $error), 0, 2);
else $error_input = '';
foreach ($mysql->select('SELECT * FROM ' . prefix . '_forum_attach WHERE pid = ' . securemysql($id) . ' ORDER BY id') as $row_4) {
	$list_attach[] = array(
		'file_id'   => $row_4['id'],
		'file'      => $row_4['file'],
		'file_link' => link_downloads($row_4['id']),
		'size'      => round($row_4['size'] / 1024, 2),
		'int_file'  => $row_4['downloads'],
	);
}
$tVars = array(
	'list_attach' => $list_attach,
	'subject'     => array(
		'true'  => $edit_subject,
		'print' => ($subject) ? $subject : $row['title']
	),
	'message'     => array(
		'true'  => ($message) ? 1 : 0,
		'print' => ($message) ? $message : $row['message']
	),
	'preview'     => array(
		'true'  => isset($_REQUEST['preview']) ? 1 : 0,
		'print' => bb_codes($message)
	),
	'error'       => array(
		'true'  => ($error_input) ? 1 : 0,
		'print' => $error_input
	)
);
$output = $xt->render($tVars);