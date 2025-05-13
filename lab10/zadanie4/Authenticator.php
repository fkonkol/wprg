<?php

class Authenticator
{
    public function attempt($email, $password)
    {
        $contents = @file_get_contents('users.json');
        $users = $contents ? json_decode($contents, true) : [];

        $filteredUsers = array_filter($users, fn($user) => $user['email'] === $email);
        $user = $filteredUsers ? array_values($filteredUsers)[0] : null;

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login($user);
                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        setcookie('PHPSESSID', '', ['expires' => time() - 3600]);
    }
}
