<?php


namespace app\Models;


use app\Core\Model;

class UserModel extends Model
{
    public function addUser($login, $password)
    {
        $data = [
            'login'    => $login,
            'password' => md5($password.'123')
        ];

        $allowed = array("login", "password");

        $sql = "INSERT INTO users SET ".$this::pdoSet($allowed, $data);
        $query = $this->db->prepare($sql);
        $query->execute($data);
    }

    public function login()
    {
        $data = [
            'login'    => $this->data['login'],
            'password' => md5($this->data['password'].'123')
        ];

        $sql = "SELECT id,login,password FROM users WHERE login = :login AND password = :password";
        $query = $this->db->prepare($sql);
        $query->execute($data);

        $user = $query->fetch();

        if(!empty($user)) {
            $session_hash = md5($user['login'] . $user['password'] . time());
            $this->db->query("UPDATE users SET session_hash = '{$session_hash}' WHERE id={$user['id']}");

            $_SESSION['session_hash'] = $session_hash;

            return true;
        }

        return false;
    }

    public function hasLogged()
    {
        if(isset($_SESSION['session_hash'])) {
            $sql = "SELECT COUNT(*) as count FROM users WHERE session_hash = :session_hash";
            $query = $this->db->prepare($sql);
            $query->execute(array('session_hash' => $_SESSION['session_hash']));

            return (bool)$query->fetchColumn();
        }

        return false;
    }
}