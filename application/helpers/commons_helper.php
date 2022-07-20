<?php
defined('BASEPATH') OR exit('No direct script access allowed');



		function dd(...$sub)
		{
			echo "<div style='background-color: darkgoldenrod;color: black;padding: 2rem'> <pre >";
			foreach ($sub as $value)
			{
				$value = is_bool($value) ? ($value === true)? 'true':'false' : $value;
				echo PHP_EOL;
				print_r($value);
				echo PHP_EOL;
			}
			echo "</pre></div>";
			die();
		}


		function renderJson(array $data=[])
		{
			header('Content-Type: application/json; charset=utf-8');
			echo empty($data) ? json_encode(['status' => false,'message' => 'something wrong happen!', 'data' => []],400) : json_encode(['status' => true,'message' => 'success', 'data' => $data],200);
			die();
		}

		function renderJsonError($msg,$code=204)
		{
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(['status' => false, 'message' => $msg,'data' => []],$code);
			die();
		}

		function sendJSON(string $msg,$code=200,$status=true)
		{
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(['status' => $status, 'message' => $msg,'data' => []],$code);
			die();
		}



			function ObjectToArray($object, $assoc=1, $empty=''){

				$output = array();
				$assoc = (!empty($assoc)) ? TRUE : FALSE;

				if (!empty($object)) {
					$ArrayOrObject = is_object($object) ? get_object_vars($object) : $object;
					$i=0;
					foreach ($ArrayOrObject as $key => $value) {
						$key = ($assoc !== FALSE) ? $key : $i;
						if (is_array($value) || is_object($value)) {
							$output[$key] = (empty($value)) ? $empty : ObjectToArray($value);
						}
						else {
							$output[$key] = (empty($value)) ? $empty : (string)$value;
						}
						$i++;
					}
				}
				return $output;
			}






//public function arr2Obj(mixed $a)
//{
//
//	if (is_array($a) ) {
//		foreach($a as $k => $v) {
//			if (is_integer($k)) {
//				// only need this if you want to keep the array indexes separate
//				// from the object notation: eg. $o->{1}
//				$a['index'][$k] = arr2Obj($v);
//			}
//			else {
//				$a[$k] = arr2Obj($v);
//			}
//		}
//
//		return (object) $a;
//	}
//
//	// else maintain the type of $a
//	return $a;
//
//}


