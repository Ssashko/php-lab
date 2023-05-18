<?php

class Autorization {
    protected $login;
    protected $password;
    protected $admin;
    protected $id;
    protected $captcha;
    protected $email;
    protected $connection;
    protected $errors;
    public function __construct($data) {
        $this->login = $data['login'];
        $this->captcha = $data['g-recaptcha-response'];
        $this->password = $data['password'];
        $this->errors = array();
        $this->admin = 0;
        $this->connection = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        if($this->connection->connect_errno)
        {
            $this->errors["database"] = "Помилка бази даних";
        }
    }
    public function hash_password() {
        return password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function validate_fields() {
        if(!password_validate($this->password))
            $this->errors["password"] = "Пароль повинен складатися з 7-30 символів з великою/малою буквою, цифрою";
        if(!login_validate($this->login))
            $this->errors["login"] = "Логін повинен складатися з 4-30 символів";
        if(!captha_validate($this->captcha))
            $this->errors["captcha"] = "Помилка капчі";
        
    }
    public function has_error() {
        return count($this->errors) > 0;
    }
    public function exec() {
        $account = $this->connection->query("SELECT `id`, `admin`, `password`, `email` FROM user WHERE `login` = '{$this->login}' ")->fetch_array();
        if($account == null)
            $this->errors["account"] = "Обліковий запис не знайдено";
        else if(!password_verify($this->password, $account["password"]))
            $this->errors["account"] = "Неправильний пароль";
        else
        {
            $this->email = $account["email"];
            $this->id = $account["id"];
            $this->admin = boolval($account["admin"]);
        }
    }
    public function auth() {
        $_SESSION['auth']  = true;
        $_SESSION['login'] = $this->login;
        $_SESSION['email'] = $this->email;
        $_SESSION['admin'] = $this->admin;
        $_SESSION['id'] = $this->id;
    }
    public function getErrors() {
        return $this->errors;
    }
    public function __destruct() {
        $this->connection->close();
    }
}
class Registration extends Autorization {
    
    private $password_check;

    public function __construct($data) {
        parent::__construct($data);
        $this->password_check = $data['password_check'];
        $this->email = $data['email'];
    }
    public function validate_fields() {
        parent::validate_fields();
        
        if($this->password_check !== $this->password)
            $this->errors["password_check"] = "Паролі не збігається";
        if(!email_validate($this->email))
            $this->errors["email"] = "Некоректна електронна пошта";
    }
    public function exec() {
        $count = intval($this->connection->query("SELECT COUNT(*) FROM user WHERE `email` = '{$this->email}' OR `login` = '{$this->login}' ")->fetch_array()[0]);
        
        if($count)
            $this->errors["db_already_registered"] = "Логін або електронна пошта вже зареєстрована";
            
        $this->connection->query("INSERT INTO user (`login`, `password`, `email`) VALUES ('{$this->login}','{$this->hash_password()}','{$this->email}')");
        $this->id = $this->connection->insert_id;
    }
    public function __destruct() {
        parent::__destruct();
    }
}

?>