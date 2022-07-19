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


function renderJson($data)
{
	header('Content-Type: application/json; charset=utf-8');
	echo empty($data) ? json_encode(200,['status' => 200,'message' => 'something wrong happen!', 'data' => []]) : json_encode(200,['status' => 200,'message' => 'success', 'data' => $data]);
	die();
}

function renderJsonError($msg,$code=204)
{
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($code,['status' => $code, 'message' => $msg,'data' => []]);
	die();
}
