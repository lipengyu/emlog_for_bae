<?php
//header("location: ./install.php");exit;
/*��ƽ̨��ȡ��ѯҪ���ӵ����ݿ�����*/
$dbname = '';//���ݿ�����
/*�ӻ���������ȡ�����ݿ�������Ҫ�Ĳ���*/
$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
$user = getenv('HTTP_BAE_ENV_AK');
$pwd = getenv('HTTP_BAE_ENV_SK');
//mysql database address
define('DB_HOST',$host.':'.$port);
//mysql database user
define('DB_USER',$user);
//database password
define('DB_PASSWD',$pwd);
//database name
define('DB_NAME',$dbname);
//database prefix
define('DB_PREFIX','emlog_');
//auth key
define('AUTH_KEY','VWq5RC2k1T*^1gdvJ1*VFn50e1LSgc#M4c8ba17bcb8bf97039c28fe8d792d7c5');
//cookie name
define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_gSozFLFifPYsLA2MZC4lLv3d23jvbo7Q');
