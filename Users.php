<?php
require_once 'connect.php';
include_once 'User.php';
if (!class_exists('User')) {
    die('Didn\'t find User class!');
}

class Users
{
    public $usersIds = [];

    public function __construct($ids_array)
    {
        $this->usersIds = $ids_array;
    }

    public function getUsers($connection)
    {
        $users = [];
        if (!empty($connection)) {
            foreach ($this->usersIds as $id) {
                $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
                $check_user = mysqli_query($connection, $sql);
                if (mysqli_num_rows($check_user) > 0) {
                    $users[] = mysqli_fetch_assoc($check_user);
                }
            }
        }
        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }

    public function deleteUsers($connection)
    {
        if (!empty($connection)) {
            foreach ($this->usersIds as $id) {
                $sql = "DELETE FROM `users` WHERE `id` = '$id'";
                if (mysqli_query($connection, $sql)) {
                    echo 'Users deleted!';
                } else {
                    echo "Ошибка: " . mysqli_error($connection);
                }
            }
        }
        $this->getUsers($connection);
    }
}







