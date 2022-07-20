<?php

    function arr2Obj(mixed $a)
    {

        if (is_array($a) ) {
            foreach($a as $k => $v) {
                if (is_integer($k)) {
                    // only need this if you want to keep the array indexes separate
                    // from the object notation: eg. $o->{1}
                    $a['index'][$k] = arr2Obj($v);
                }
                else {
                    $a[$k] = arr2Obj($v);
                }
            }

            return (object) $a;
        }

        // else maintain the type of $a
        return $a;

    }


	function isCli():bool
	{
		if (PHP_SAPI === 'cli')
		{
			if(defined('STDIN'))
			{
				return true;
			}
			if(isset($_SERVER['argv']) && isset($_SERVER['argc']))
			{
				return true;
			}
		}
		return false;

	}


	function request()
	{
        $data = array_merge([
            'method' => $_SERVER['REQUEST_METHOD'],
            'query' => $_SERVER['REQUEST_URI'],
            'uri' => $_SERVER['REQUEST_URI'],
            'fullUrl' => $_SERVER['REQUEST_SCHEME'].'//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            'url' => $_SERVER['REQUEST_SCHEME'].'//'.$_SERVER['HTTP_HOST'],
            'isPost' => strtolower($_SERVER['REQUEST_METHOD']) === 'post',
            'isGet' => strtolower($_SERVER['REQUEST_METHOD']) === 'get',
            'get' => arr2Obj($_GET),
            'post' => arr2Obj($_POST),
            'file' => arr2Obj($_FILES),
            'hasFile' => !empty($_FILES['name'])
        ],contentLoad());

        if(is_string($data) || is_object($data))
        {
            return arr2Obj(ObjectToArray($data));
        }


        if(is_array($data))
        {
            return arr2Obj($data);
        }



	}

    function requestHas(string $key):bool
    {
        return isset(request()->$key);
    }

    function validInput(string $key)
    {
        if(requestHas($key))
        {
            return request()->$key;
        }else{
            $contentKey = contentLoad()[$key];
            if(isset($contentKey))
            {
                return $contentKey;
            }else{
                return null;
            }
        }
    }


	function redirect(string $url) {
		ob_start();
		header('Location: '.$url);
		ob_end_flush();
		die();
	}


	function contentLoad():array
	{
		$data = [];
		if (strtolower($_SERVER['REQUEST_METHOD']) === 'get') {
			foreach ($_GET as $key => $value) {
				$data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
			foreach ($_POST as $key => $value) {
				$data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $data;
	}


	function token()
	{
		return password_hash(bin2hex(random_bytes(52)),PASSWORD_DEFAULT);
	}

	function validPassword(string $value,string $password)
	{
		return password_verify($value,$password);
	}


	function jsonResponse(string $msg,int $code=200,array $data=[],bool $status=true)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['status' => $status, 'message' => $msg,'data' => $data],$code);
		die();
	}




	function setSession(string $key,string $value)
	{
		return $_SESSION['app_session'][$key] = json_encode($value);
	}

	function getSession(string $key)
	{
		if(isset($_SESSION['app_session'][$key]) && !empty($_SESSION['app_session'][$key]))
		{
			return json_decode($_SESSION['app_session'][$key]);
		}else{
			return null;
		}
	}

	function removeSession(string $key)
	{
		unset($_SESSION['app_session'][$key]);
		return true;
	}






    /**
     * Authorization
     */




