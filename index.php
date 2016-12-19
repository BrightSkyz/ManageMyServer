
<?php
include 'pages/includes/header.php';
$directory = $_SERVER['REQUEST_URI'];

$directories = explode("/", $directory);
$lim = count($directories);

include($_SERVER['DOCUMENT_ROOT'] . $page);
if(empty($directories[0]) && empty($directories[1])){
    // Must be the index page
    $page_path = 'pages/index.php';
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
include $page_path. ".php";
?>



<?php
include 'pages/includes/footer.php';
?>