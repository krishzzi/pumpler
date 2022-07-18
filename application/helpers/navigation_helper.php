<?php

function dd(...$sub)
{
	echo "<div class='bg-warning text-light'> <pre>";
	foreach ($sub as $value)
	{
		print_r($value);
	}
	echo "</pre></div>";
	die();
}


function route_to(string $uri)
{
	$this->load->helper('url');
	return base_url($uri);
}



function getSidebar():array
{
	return [

		[
			'label' => 'Dashboard',
			'icon'  => 'far fa-circle text-danger',
			'url' => 'admin.dashboard',
//                'badge' => 'New',
//                'badgeColor' => 'danger',
		],


		[
			'label' => 'Categories',
			'icon'  => 'fas fa-th',
			'url' => 'category_url',
			'child' => [
				[
					'label' => 'Post',
					'icon'  => 'fas fa-th',
					'url' => 'post_url',
				],
			],
		],


	];



}
