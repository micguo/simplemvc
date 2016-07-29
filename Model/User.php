<?php
class User
{
    private $db = null;
    private $pass = null;
    private $name = null;
    private $email = null;

    function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Insert User entity to db
     * 
     * @return void
     * @todo  db error handling
     */
    public function insert() 
    {
        if (empty($this->name) || empty($this->pass) || empty($this->email)) {
            throw new Exception("User is not set correctly, insert failed.");
        }

        $sql = "INSERT INTO User
                    (Name, Pass, Email)
                VALUES
                    (:Name, :Pass, :Email)";
        $data = array(
            'Name' => $this->name,
            'Pass' => $this->pass,
            'Email' => $this->email
        );

        $stat = $this->db->prepare($sql);
        $stat->execute($data);
    }

    /**
     * Search user entity by email or name
     * @return [type] [description]
     */
    public function search() 
    {

    }

    /**
     * Check whether a name already exists in db
     * @return boolean
     */
    public function existsName($name) 
    {
        $sql = "SELECT id 
                FROM User
                WHERE Name = :Name";
        $data = array('Name' => $name);

        $stat = $this->db->prepare($sql);
        $stat->execute($data);
        $retrunVal = false;
        if ($stat->rowCount() > 0) {
            $retrunVal = true;
        }

        return $retrunVal;
    }

    /**
     * Check whether a email already exists in db
     * @return boolean
     */
    public function existsEmail($email) 
    {
        $sql = "SELECT id 
                FROM User
                WHERE Email = :Email";
        $data = array('Email' => $email);

        $stat = $this->db->prepare($sql);
        $stat->execute($data);
        $retrunVal = false;
        if ($stat->rowCount() > 0) {
            $retrunVal = true;
        }

        return $retrunVal;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPass($pass)
    {
        $this->pass = password_hash($pass, PASSWORD_DEFAULT);
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}