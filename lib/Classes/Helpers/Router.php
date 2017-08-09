<?php

namespace Helpers;

class Router extends Filter{
	public $route;
	public $page;

    public function CheckRoute($default = 'Home', $errorSite = 'index.php?p=home'){
		if($this->checkMethod('GET') || $this->checkMethod('POST')){
			$GET = $this->sanitizeArray(INPUT_GET);
			if(isset($GET['p']) && !empty($GET['p'])){
				$this->route = $GET['p'];
				$this->page = __VIEW__ . $GET['p'] . '.php';
				if(file_exists($this->page)){
					return $this->page;
				} else {
					header('Location:' . __BASE__ . $errorSite);
				}
			} else {
				header('Location:' . __BASE__ . 'index.php?p=home');
			}
		}
	}

}