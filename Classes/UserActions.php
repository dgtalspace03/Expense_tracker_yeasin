<?php
class UserActions
{
    private PDO $pdo;
    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    function formateresult(bool $success, string $msg)
    {
        return [
            "success" => $success,
            "msg" => $msg,
        ];
    }
    public function CreateUser(string $name, string $email, string $password)
    {
        if (!isset($email) || !isset($name) || !isset($password)) {
            return $this->formateresult(false, "Email and password cant be null");
        }

        $smt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
        $smt->execute([$email]);
        if ($smt->rowCount() == 1)
            return $this->formateresult(false, "Email Not available");
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sq = $this->pdo->prepare("INSERT INTO user (name,email,password) values (?,?,?)");
        $sq->execute([$name,$email,$password_hash]);
        if($sq->rowCount()==1){
            return $this->formateresult(true, "Account Created Successfully");
        }
    }
}
