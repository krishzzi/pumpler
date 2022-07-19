<?php


function dd(...$sub)
{
	echo "<div style='background-color: darkgoldenrod;color: black;padding: 2rem'> <pre >";
	foreach ($sub as $value)
	{
		print_r($value);
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


	function request()
	{

		return $_REQUEST;
	}
