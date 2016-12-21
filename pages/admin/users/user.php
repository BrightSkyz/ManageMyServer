<?php
$conn = new mysqli($config['db_address'], $config['db_username'], $config['db_password'], $config['db_name']);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$sql = 'SELECT * FROM '.$config['table_prefix'].'_users WHERE id=? ORDER BY id';
$stmt = $conn->stmt_init();
if(!$stmt->prepare($sql))
{
    print "Failed to prepare statement\n";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$users = array();
while ($row = $result->fetch_array(MYSQLI_NUM))
{
    $results[] = $row;
    $username = $row[0];
    $rank = $row[2];
    $root = $row[3];
    $users[$username] = array($rank, $root);
}
if(sizeof($users) == 0){
    echo 'No users with that ID found';
} else {
    echo'<br><div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>';
    foreach($results as $user) {
        echo'<tr><td>'.$user[4].'<td><a href="/admin/users/user/?id='.$user[4].'">'.$user[0].'</td><td>'.$user[2].'</td></tr>';
    }
    echo'</tbody>
     </table>
   </div>';
}
?>