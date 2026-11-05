<?php
class TransactionAction
{
    private PDO $pdo;
    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    function formateresult(bool $success, string $msg,$transactions=[])
    {
        return [
            "success" => $success,
            "msg" => $msg,
            "transactions"=>$transactions
        ];
    }
    public function AddTransaction(string $description, int $userId, int $amount, string $type, string $category, string $date)
    {
        try {
            $sql = $this->pdo->prepare("INSERT INTO transaction (description,userId,amount,type,category,date) VALUES(?,?,?,?,?,?)");
            $sql->execute([$description, $userId, $amount, $type, $category, $date]);
            if ($sql->rowCount() == 1) {
                return $this->formateresult(true, "Transaction Added Successfully");
            }
        } catch (\Throwable $th) {
            return $this->formateresult(false, "Failed to add transaction.");
        }
    }
    public function GetUserTransactionsById(string $id)
    {
        if (!isset($id)) return $this->formateresult(false, "Id can't be null or empty");
        try {
            $sql = $this->pdo->prepare("SELECT * FROM transaction WHERE userId=?");
            $sql->execute([$id]);
            $transactions=$sql->fetchAll(PDO::FETCH_ASSOC);
            return $this->formateresult(true,"Transaction Fetched Successfully",$transactions);
        } catch (\Throwable $th) {
            return $this->formateresult(false,"Failed To fetch transactions");
        }
    }
}
