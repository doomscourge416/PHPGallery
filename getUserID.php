<?php

// FIXME: $target должен работать в index.php foreach comment as comment
function getUserId($pdo, $target){
    $query = "SELECT username FROM users WHERE (id = '{$target}')";
    $result = mysqli_query($pdo, $query);
    return $username = mysqli_fetch_assoc($result)['username'];
}


?>