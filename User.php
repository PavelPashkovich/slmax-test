<?php
require_once 'connect.php';

class User
{
    public $id;
    public $name;
    public $last_name;
    public $birthday;
    public $gender;
    public $city_of_birth;

    public static $connection;

    public function __construct($id, $name, $last_name, $birthday, $gender, $city_of_birth )
    {

        $connection = self::getConnection();

        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->city_of_birth = $city_of_birth;

        if (!empty($connection)) {
            $sql = "SELECT * FROM `users` WHERE `id` = '$this->id'";
            $check_user = mysqli_query($connection, $sql);
            if (mysqli_num_rows($check_user) == 0) {
                $this->addUser();
            } else {
                $this->showUser($this->id);
            }
        }
    }

    protected static function getConnection()
    {
        if (!self::$connection){
            self::$connection = new \mysqli('localhost', 'root', '', 'slmax-test');
        }
        return self::$connection;
    }

    public function addUser()
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "INSERT INTO `users` (`id`, `name`, `last_name`, `birthday`, `gender`, `city_of_birth`) 
                                 VALUES ('$this->id', '$this->name', '$this->last_name', '$this->birthday', '$this->gender', '$this->city_of_birth')";
            if (mysqli_query($connection, $sql)) {
                return 'User added!';
            } else {
                return "Ошибка: " . mysqli_error($connection);
            }
        }
    }

    public function showUser($id)
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
            $check_user = mysqli_query($connection, $sql);
            if (mysqli_num_rows($check_user) > 0) {
                $user = mysqli_fetch_assoc($check_user);
                $gender = !$user['gender'] ? 'муж' : 'жен';
                return 'Имя и Фамилия: ' . $user['name'] . ' ' . $user['last_name'] . "<br>" .
                     'Дата рождения: ' . $user['birthday'] . "<br>" .
                     'Пол: ' . $gender . "<br>" .
                     'Город рождения: ' . $user['city_of_birth'];
            } else {
                return "Ошибка: Пользователь с указанным id не найден.";
            }
        }
    }

    public static function deleteUser($id)
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "DELETE FROM `users` WHERE `id` = '$id'";
            if (mysqli_query($connection, $sql)) {
                return 'User deleted!';
            } else {
                return "Ошибка: " . mysqli_error($connection);
            }
        }
    }

    public static function getAgeFromBirthday($id)
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "SELECT `birthday` FROM `users` WHERE `id` = '$id'";
            $check_user = mysqli_query($connection, $sql);
            if (mysqli_num_rows($check_user) > 0) {
                $birthday = mysqli_fetch_assoc($check_user);
                $age = date('Y') - date('Y', strtotime($birthday['birthday']));
                if (date('md', strtotime($birthday['birthday'])) > date('md')) {
                    $age--;
                }
                return $age;
            } else {
                return "Ошибка: Пользователь с указанным id не найден.";
            }
        }
    }

    public static function getGender($id)
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "SELECT `gender` FROM `users` WHERE `id` = '$id'";
            $check_user = mysqli_query($connection, $sql);
            if (mysqli_num_rows($check_user) > 0) {
                $gender = mysqli_fetch_assoc($check_user)['gender'];
                return !$gender ? 'муж' : 'жен';
            } else {
                return "Ошибка: Пользователь с указанным id не найден.";
            }
        }
    }

    public static function formatUser($id)
    {
        $connection = self::getConnection();
        if (!empty($connection)) {
            $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
            $check_user = mysqli_query($connection, $sql);
            if (mysqli_num_rows($check_user) > 0) {
                $user = mysqli_fetch_assoc($check_user);
                $age = self::getAgeFromBirthday($id);
                $gender = self::getGender($id);
                return new User($id, $user['name'], $user['last_name'], $age, $gender, $user['city_of_birth']);
            } else {
                return "Ошибка: Пользователь с указанным id не найден.";
            }
        }
    }
}


