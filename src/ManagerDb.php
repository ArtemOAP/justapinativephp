<?php
namespace App\Api;


class ManagerDb implements ManagerDbInterface
{
    /**
     * @var \PDO
     */
    public static $pdo;
    public $patches = array();

    protected static $instance = null;

    final public static function Connect()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            try {
                self::$pdo = new \PDO('mysql:host=localhost;dbname=geo;charset=utf8', 'root', '');
            } catch (\PDOException $e) {
                //TODO log
                echo 'Error BD';
            }
        }
        return self::$instance;
    }

    public function createItem($name, $email, $date_birth, $gender)
    {
        $data = [];
        try {

            $prep = self::$pdo->prepare("INSERT INTO users (name, email, gender, date_birth,date) values (:name, :email, :gender, :date_birth,now() )");
            $prep->execute($data);

        } catch (\PDOException $e) {
           //log
        }
        self::$pdo = null;
    }

    public function showAll():array
    {
        $queryBild = self::$pdo->query('SELECT name, email from users');
        $queryBild->setFetchMode(\PDO::FETCH_OBJ);
        return $queryBild->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find(int $id):array
    {
        $stat = self::$pdo->prepare('SELECT name, email from users WHERE id = :id');
        $stat->execute(['id'=>$id]);
        return $stat->fetchAll(\PDO::FETCH_OBJ);
    }

    public function countItems()
    {
        $queryBild = self::$pdo->query('SELECT count(*) from users');
        $count = $queryBild->fetchAll(\PDO::FETCH_NUM);
        return ['count'=> $count[0][0]];
    }

    final protected function __clone()
    {
    }

    protected function __construct()
    {
    }

}