<?php
//Kopierad över från Book.php i redovisa/
namespace Anax\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";
    protected $tableIdColumn = "userId";


    /**
    * Columns in the table.
    *
    * @var integer $id primary key auto incremented.
    */
    public $userId;
    public $username;
    public $password;
    public $email;

    /**
    * Set the password.
    *
    * @param string $password the password to use.
    *
    * @return void
    */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    //funktionen för att kontrollera så att anv + pw är korrekt
    public function passwordController($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }

    public function findMostActiveFrontpage($join, $where)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select("*, count(User.userId) as total")
                        ->from($this->tableName)
                        ->join($join, $where)
                        ->groupBy("User.userId")
                        ->orderBy("total DESC")
                        ->limit("3")
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
