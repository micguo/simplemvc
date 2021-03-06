<?php
class User
{
    private $db = null;
    private $id = null;
    private $pass = null;
    private $name = null;
    private $email = null;

    private static $activeUser = null;

    function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Save User entity to db
     * 
     * @return void
     * @todo  only handle insert right now, should add update in the future
     */
    public function save() 
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
     * @return array
     */
    public static function search($keyword) 
    {
        $sql = "SELECT * FROM User 
                WHERE Name LIKE :Keyword
                    OR Email LIKE :Keyword";
        $data = array('Keyword' => "%" . $keyword . "%");
        $stat =  Database::getConnection()->prepare($sql);
        $stat->execute($data);
        $rs = $stat->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    }

    /**
     * Load user info by given info
     * @param  mixed, int $uid
     *                array $userInfo
     *
     * @return boolean, true on success
     */
    public function load($userInfo)
    {
        if (!is_numeric($userInfo) && !is_array($userInfo)) {
            throw new InvalidArgumentException();
        }

        if (is_numeric($userInfo)) {
            $userInfo = array('Id' => $userInfo);
        }

        $whereArray = array();
        foreach ($userInfo as $key => $value) {
            switch ($key) {
                case 'Id':
                case 'Email':
                    $whereArray[] = $key . " = :" . $key;
                    break;
                case 'Pass':
                    $passToBeVerified = $value;
                    // Fall through
                default:
                    unset($userInfo[$key]);
                    break;
            }
        }
        $sql = "SELECT * FROM User WHERE " . implode(" AND ", $whereArray);
        $stat = $this->db->prepare($sql);
        $stat->execute($userInfo);

        $returnVal = false;
        if ($stat->rowCount() > 0) {
            $rs = $stat->fetch(PDO::FETCH_ASSOC);
            // Check password
            if (empty($passToBeVerified) || password_verify($passToBeVerified, $rs['Pass'])) {
                $this->setId($rs['Id']);
                $this->setEmail($rs['Email']);
                $this->setName($rs['Name']);
                $returnVal = true;
            }
        }

        return $returnVal;
    }

    /**
     * Check whether a name already exists in db
     * @return boolean
     */
    public function existsName($name) 
    {
        $sql = "SELECT Id 
                FROM User
                WHERE Name = :Name";
        $data = array('Name' => $name);

        $stat = $this->db->prepare($sql);
        $stat->execute($data);
        $returnVal = false;
        if ($stat->rowCount() > 0) {
            $returnVal = true;
        }

        return $returnVal;
    }

    /**
     * Check whether a email already exists in db
     * @return boolean
     */
    public function existsEmail($email) 
    {
        $sql = "SELECT Id 
                FROM User
                WHERE Email = :Email";
        $data = array('Email' => $email);

        $stat = $this->db->prepare($sql);
        $stat->execute($data);
        $returnVal = false;
        if ($stat->rowCount() > 0) {
            $returnVal = true;
        }

        return $returnVal;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    private function hash($pass) 
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    
    public function setPassAndHash($pass)
    {
        $this->pass = $this->hash($pass);
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Active user section start
     
    /**
     * Get logged in client's user object
     * @return User
     */
    public static function getActiveUser()
    {
        return self::$activeUser;
    }

    /**
     * Check whether client is logged in
     * @return boolean [description]
     */
    public static function isLogin()
    {
        if (!empty(self::$activeUser)) {
            $returnVal = true;
        } else {
            $returnVal = false;
        }

        return $returnVal;
    }

    /**
     * If we have uid in session, automatically log client in
     * @return [type] [description]
     */
    public static function loginBySession()
    {
        if (!empty($_SESSION['uid'])) {
            self::login($_SESSION['uid']);
        }
    }

    /**
     * Login process
     * This should not be called directly from outside
     * 
     * @param  int $uid [description]
     * @return void
     */
    private static function login($uid)
    {
        $userObj = new User();
        $userObj->load($uid);
        self::$activeUser = $userObj;
    }

    /**
     * Logout client
     * @return void
     */
    public static function logout()
    {
        self::$activeUser = null;
        unset($_SESSION['uid']);
    }

    // Active user section end
}