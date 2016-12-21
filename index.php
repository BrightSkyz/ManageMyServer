<?php
ob_start();
session_start();
$config = include($_SERVER['DOCUMENT_ROOT'].'/core/config.php');

if($config['db_address']==''){
    header("Location: /install.php");
    die();
}
include 'pages/includes/header.php';
$directory = $_SERVER['REQUEST_URI'];

$directories = explode("/", $directory);
$lim = count($directories);

include($_SERVER['DOCUMENT_ROOT'] . $page);
if($_SESSION['rank'] != 'superuser' && $directories[1]=="admin") {
    header('Location: /');
} elseif(empty($directories[0]) && empty($directories[1])){
    // Must be the index page
    $page_path = 'pages/index';
} elseif ($directories[1]=="admin" && empty($directories[2])) {
    $page_path = 'pages/admin/index';
}elseif ($directories[1]=="admin" && $directories[2]=="users" && empty($directories[3])) {
    $page_path = 'pages/admin/users/index';
} else {
    $n = 0;
    foreach($directories as $directory){
        if(strpos($directory, '?') !== false){
            $params = $directory; // Get URL parameters
            unset($directories[$n]);
        }
        $n++;
    }
    $page_path = 'pages' . implode('/', $directories);
    if(substr($page_path, -1) == "/"){
        $page_path = rtrim($page_path, '/');
    }
}
if($_SESSION['username']=='' && $page_path != 'pages/login'){
    header('Location: /login');
    die();
}
if(file_exists($page_path.".php")) {
    include $page_path. ".php";
} else {
    include $_SERVER['DOCUMENT_ROOT'].'/pages/errors/404.php';
}
?>
<?php
include 'pages/includes/footer.php';
?>
