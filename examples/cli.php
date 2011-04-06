<?php

error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

set_include_path(dirname(__FILE__).'/../lib' . PATH_SEPARATOR. dirname(__FILE__).'/../lib/vendor' . PATH_SEPARATOR . dirname(__FILE__).'/../lib/vendor/Zend' . PATH_SEPARATOR . get_include_path());
mb_internal_encoding('utf-8');

require_once 'PHPPdf/Autoloader.php';

PHPPdf\Autoloader::register();
PHPPdf\Autoloader::register(dirname(__FILE__).'/../lib/vendor');

$facade = PHPPdf\Parser\FacadeBuilder::create()->setCache('File', array('cache_dir' => __DIR__.'/cache/'))
                                               ->setUseCacheForStylesheetConstraint(true)
                                               ->build();
if($_SERVER['argc'] < 3) 
{
    die('Passe example name and destination file path, for example `cli.php example-name \some\destination\file.pdf`');
}

$name = basename($_SERVER['argv'][1]);
$destinationPath = $_SERVER['argv'][2];

$documentFilename = './'.$name.'.xml';
$stylesheetFilename = './'.$name.'-style.xml';

if(!is_readable($documentFilename) || !is_readable($stylesheetFilename))
{
    die(sprintf('Example "%s" dosn\'t exist.', $name));
}

if(!is_writable(dirname($destinationPath)))
{
    die(sprintf('"%s" isn\'t writable.', $destinationPath));
}

$xml = str_replace('dir:', __DIR__.'/', file_get_contents($documentFilename));
$stylesheet = PHPPdf\Util\DataSource::fromFile($stylesheetFilename);

$content = $facade->render($xml, $stylesheet);

file_put_contents($destinationPath, $content);