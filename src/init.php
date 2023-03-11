<?php
ini_set('default_charset', 'UTF-8');
date_default_timezone_set ("Europe/Berlin");

// dev
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//prod
//ini_set('display_errors', '0');     # don't show any errors...
//ini_set('display_startup_errors', 0);
//error_reporting(E_ALL | E_STRICT);



if (!isset($_rel_path)) {
    $_rel_path = ".";
}
/*log */
require_once($_rel_path . '/includes/php/log4/Logger.php');
$config = array(
    'rootLogger' => array(
        'appenders' => array('default'),
    ),
    'appenders' => array(
        'default' => array(
            'class' => 'LoggerAppenderRollingFile',
            'layout' => array(
                'class' => 'LoggerLayoutPattern',
            ),
            'params' => array(
                'name' => "file",
                'file' => $_rel_path . '/l0g/train.log',
                'append' => true
            )
        )
        ));

Logger::configure($config);
$logger = Logger::getLogger('');
$prout ='prout';

