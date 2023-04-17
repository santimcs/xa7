<?php 
session_start();

require "../app/core/init.php";

// Default home page is app/pages/home.php
$URL = isset($_GET['url']) ? $_GET['url'] : "home";
$URL = explode("/", $URL);

//get page number
$page = isset($_GET['page']) ? $_GET['page'] : "1";
$page = (int)$page;
$prev_page = $page <= 1 ? 1 : $page - 1;
$next_page = $page + 1;

$file = page(strtolower($URL[0]));
// show($file);
if(file_exists($file))
{
	require $file;
}else{
	require page("404");
}