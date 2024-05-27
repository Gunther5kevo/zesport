<?php
include('functions.php');

$paramId = checkParamId('id');

if (is_numeric($paramId)) {
    $userId = validate($paramId);

    $user = getById($pdo, 'users', $userId); 

    if ($user['status'] == 200) {
        $userDeleteRes = deleteQuery($pdo, 'users', $userId); 
        if ($userDeleteRes) {
            redirect('users.php', 'User deleted successfully');
        } else {
            redirect('users.php', 'Failed to delete user');
        }
    } else {
        redirect('users.php', $user['message']);
    }
} else {
    redirect('users.php', $paramId);
}
?>
