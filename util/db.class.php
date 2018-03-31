<?php
/**
 * Created: 28/03/2018 15:03
 */

class db
{
    /** @var string */
    private $charset = 'utf8mb4';
    /** @var string */
    private $dsn;
    /** @var array */
    private $opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    /** @var PDO */
    private $connection;

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->connection;
    }

    /**
     * @param PDO $connection
     */
    public function setConnection(PDO $connection): void {
        $this->connection = $connection;
    }

    /** @var null|db */
    protected static $_instance = null;
    public static function getInstance(): db
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    protected function __clone() {}
    protected function __construct() {
        $conf = config::getInstance();
        log::info("Connecting to database.");
        try {
            $this->dsn = "mysql:host=".$conf->getDbHost().";dbname=".$conf->getDbDatabase().";charset=$this->charset";
            $this->connection = new PDO($this->dsn, $conf->getDbUser(), $conf->getDbPass(), $this->opt);

        } catch(PDOException $ex) {
            log::FATAL("Could not connect to database.", $ex);
            die("Could not connect to database.<br>". $ex->getMessage());
        }
        log::info("Successfully connected to database.");
    }


}