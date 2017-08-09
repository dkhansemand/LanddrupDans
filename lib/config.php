<?php
    ## Localization settings, used for date/time
    setlocale(LC_TIME, "");
    setlocale(LC_ALL, 'da_DK');

    ## Define globals
    define('__PROJECTFOLDER__', 'danseskole');
    define('__BASE__', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');
    define('__VIEW__', './partials/');

    define('__DB_HOST__','localhost');
	define('__DB_USERNAME__', 'root');
	define('__DB_PASSWORD__', '');
	define('__DB_NAME__', 'landdrupDans');
    define('_LOG_PATH_', dirname(__DIR__) . '/log/');

    ## Auto class loader from folder './lib/Classes'
    ## Class autoloader
	function classLoader($className){
		$className = str_replace('\\', '/', $className);
		if(file_exists(__DIR__ .'/Classes/'. $className . '.php')){
			require_once __DIR__ .'/Classes/'. $className . '.php';
		} else {
			echo 'ERROR: '. __DIR__ .'/Classes/'. $className . '.php';
		}
	}
	spl_autoload_register('classLoader');

    ## Import classes
    use Database\DB;
    use Controller\User;
    use Controller\Pages;
    use Controller\Content;
    use Controller\Teams;
    use Controller\Message;
    use Controller\News;
    use Helpers\Validate;
    use Helpers\Router;
    use Helpers\Filter;
    use Security\Token;
    use Media\upload; 

    $db = new DB(__DB_HOST__, __DB_USERNAME__, __DB_PASSWORD__, __DB_NAME__);

    $filter = new Filter();
    
    ## Check route
    $router = new Router();
    $partialView = $router->CheckRoute();

    $token = new Token();
    $validator = new Validate();
    $upload = new upload();

    ## User controller
    $user = new User();
    
    $page = new Pages();
    $content = new Content();
    $teams = new Teams();
    $message_ = new Message();
    $news_ = new News();
