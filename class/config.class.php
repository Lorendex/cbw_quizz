<?php
/**
 * Created: 27/03/2018 22:11
 */

class config
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_database;
    private $db_port = 3306;

    protected static $_instance = null;
    public static function getInstance(): config
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    protected function __clone() {}
    protected function __construct() {}

    /**
     * @return string
     */
    public function getDbHost(): string {
        return $this->db_host;
    }

    /**
     * @param string $db_host
     */
    public function setDbHost($db_host): void {
        $this->db_host = $db_host;
    }

    /**
     * @return string
     */
    public function getDbUser(): string {
        return $this->db_user;
    }

    /**
     * @param string $db_user
     */
    public function setDbUser($db_user): void {
        $this->db_user = $db_user;
    }

    /**
     * @return string
     */
    public function getDbPass(): string {
        return $this->db_pass;
    }

    /**
     * @param string $db_pass
     */
    public function setDbPass($db_pass): void {
        $this->db_pass = $db_pass;
    }

    /**
     * @return string
     */
    public function getDbDatabase(): string {
        return $this->db_database;
    }

    /**
     * @param string $db_database
     */
    public function setDbDatabase($db_database): void {
        $this->db_database = $db_database;
    }

    /**
     * @return int
     */
    public function getDbPort(): int {
        return $this->db_port;
    }

    /**
     * @param int $db_port
     */
    public function setDbPort(int $db_port): void {
        $this->db_port = $db_port;
    }



}