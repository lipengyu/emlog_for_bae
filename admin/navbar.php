<?php
/**
 * 链接管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Navi_Model = new Navi_Model();

if ($action == '') {
	$emPage = new Log_Model();
	
	$navis = $Navi_Model->getNavis();
	$sorts = $CACHE->readCache('sort');
	$pages = $emPage->getAllPageList();

	include View::getView('header');
	require_once(View::getView('navbar'));
	include View::getView('footer');
	View::output();
}

if ($action== 'taxis') {
	$navi = isset($_POST['navi']) ? $_POST['navi'] : '';
	if (!empty($navi)) {
		foreach ($navi as $key=>$value) {
			$value = intval($value);
			$key = intval($key);
			$Navi_Model->updateNavi(array('taxis'=>$value), $key);
		}
		$CACHE->updateCache('navi');
		emDirect("./navbar.php?active_taxis=true");
	} else {
		emDirect("./navbar.php?error_b=true");
	}
}

if ($action== 'add') {
	$taxis = isset($_POST['taxis']) ? intval(trim($_POST['taxis'])) : 0;
	$naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
	$url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : 'n';
	
	if ($naviname =='' || $url =='') {
		emDirect("./navbar.php?error_a=true");
	}

	if (!preg_match("/^(http|https|ftp):\/\/.*$/i", $url)) {
		emDirect("./navbar.php?error_f=true");
	}

	$Navi_Model->addNavi($naviname, $url, $taxis, $newtab);
	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_add=true");
}

if ($action== 'add_sort') {
	$sort_ids = isset($_POST['sort_ids']) ? $_POST['sort_ids'] : array();

	$sorts = $CACHE->readCache('sort');

	if (empty($sort_ids)) {
		emDirect("./navbar.php?error_d=true");
	}

	foreach ($sort_ids as $val) {
		$sort_id = intval($val);
		$Navi_Model->addNavi($sorts[$sort_id]['sortname'], Url::sort($sort_id), 0, 'n');
	}

	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_add=true");
}

if ($action== 'add_page') {
	$pages = isset($_POST['pages']) ? $_POST['pages'] : array();

	if (empty($pages)) {
		emDirect("./navbar.php?error_e=true");
	}
	
	foreach ($pages as $id => $title) {
		$Navi_Model->addNavi($title, Url::log($id), 0, 'n');
	}

	$CACHE->updateCache('navi');
	emDirect('./navbar.php?active_add=true');
}

if ($action== 'mod') {
	$naviId = isset($_GET['navid']) ? intval($_GET['navid']) : '';

	$naviData = $Navi_Model->getOneNavi($naviId);
	extract($naviData);

	$conf_newtab = $newtab == 'y' ? 'checked="checked"' : '';
	$conf_isdefault = $isdefault == 'y' ? 'disabled="disabled"' : '';

	include View::getView('header');
	require_once(View::getView('naviedit'));
	include View::getView('footer');View::output();
}

if ($action=='update') {
	$naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
	$url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : 'n';
	$naviId = isset($_POST['navid']) ? intval($_POST['navid']) : '';
	$isdefault = isset($_POST['isdefault']) ? addslashes(trim($_POST['isdefault'])) : 'n';

	$navi_data = array(
		'naviname'=>$naviname,
		'newtab'=>$newtab
	);

	if ($isdefault == 'n') {
		$navi_data['url'] = $url;
	}

	$Navi_Model->updateNavi($navi_data, $naviId);

	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_edit=true");
}

if ($action == 'del') {
	$navid = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Navi_Model->deleteNavi($navid);
	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_del=true");
}

if ($action == 'hide') {
	$naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

	$Navi_Model->updateNavi(array('hide'=>'y'), $naviId);

	$CACHE->updateCache('navi');
	emDirect('./navbar.php');
}

if ($action == 'show') {
	$naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

	$Navi_Model->updateNavi(array('hide'=>'n'), $naviId);

	$CACHE->updateCache('navi');
	emDirect('./navbar.php');
}
