<?php
const DEFAULT_APP = 'Dashboard';
 
// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app']))
	$_GET['app'] = DEFAULT_APP;
 


require __DIR__.'/../lib/MBFram/SplClassLoader.php';

(new SplClassLoader('MBFram', __DIR__.'/../lib'))->register();
(new SplClassLoader('MBForm', __DIR__.'/../lib'))->register();
(new SplClassLoader('App', __DIR__.'/..'))->register();
(new SplClassLoader('Model', __DIR__.'/../lib/vendors'))->register();
(new SplClassLoader('Entity', __DIR__.'/../lib/vendors'))->register();
(new SplClassLoader('FormBuilder', __DIR__.'/../lib/vendors'))->register();
 

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass;
$app->run();