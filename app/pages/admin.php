<?php 

if(!is_admin())
{
	message("only admins can access the admin page");
	redirect('login');
}

	// $section 	= $URL[1] ?? "dashboard";
	$section 	= isset($URL[1]) ? $URL[1] : "dashboard";
	// $action 	= $URL[2] ?? null;
	$action 	= isset($URL[2]) ? $URL[2] : null;
	// $id 		= $URL[3] ?? null;
	$id 		= isset($URL[3]) ? $URL[3] : null;

	switch ($section) {
		case 'dashboard':
			require page('admin/dashboard');
			break;

		case 'users':
			require page('admin/users');
			break;

		case 'portfolios':
			require page('admin/portfolios');
			break;
		
		default:
			require page('admin/404');
			break;
	}
