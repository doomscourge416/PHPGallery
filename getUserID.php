<?php

// FIXME: Неиспользуется
function getUserId($pdo, $target){
    $query = "SELECT username FROM users WHERE (id = '{$target}')";
    $result = mysqli_query($pdo, $query);
    return $username = mysqli_fetch_assoc($result)['username'];
}


?>