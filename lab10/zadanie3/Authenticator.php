<?php

class Authenticator
{
    public function attempt($email, $password)
    {
        if ($email === "test@example.com" && $password === "asdfasdf") {
            $this->login([
                'email' => $email,
            ]);
            return true;
        }
        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
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
