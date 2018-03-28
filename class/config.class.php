<?php
/**
 * Created: 27/03/2018 22:11
 */

class config
{
    /** @var string */
    private $db_host;
    /** @var string */
    private $db_user;
    /** @var string */
    private $db_pass;
    /** @var string */
    private $db_database;
    /** @var int */
    private $db_port = 3306;

    /** @var bool */
    private $log_fatal = true;
    /** @var bool */
    private $log_error = true;
    /** @var bool */
    private $log_warning = true;
    /** @var bool */
    private $log_info = true;
    /** @var bool */
    private $log_debug = true;
    /** @var string */
    private $session_name = "cbw_session";
    /** @var string */
    private $cookie_name = "cbw_cookie";

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

    /**
     * @return bool
     */
    public function isLogFatal(): bool {
        return $this->log_fatal;
    }

    /**
     * @param bool $log_fatal
     */
    public function setLogFatal(bool $log_fatal): void {
        $this->log_fatal = $log_fatal;
    }

    /**
     * @return bool
     */
    public function isLogError(): bool {
        return $this->log_error;
    }

    /**
     * @param bool $log_error
     */
    public function setLogError(bool $log_error): void {
        $this->log_error = $log_error;
    }

    /**
     * @return bool
     */
    public function isLogWarning(): bool {
        return $this->log_warning;
    }

    /**
     * @param bool $log_warning
     */
    public function setLogWarning(bool $log_warning): void {
        $this->log_warning = $log_warning;
    }

    /**
     * @return bool
     */
    public function isLogInfo(): bool {
        return $this->log_info;
    }

    /**
     * @param bool $log_info
     */
    public function setLogInfo(bool $log_info): void {
        $this->log_info = $log_info;
    }

    /**
     * @return bool
     */
    public function isLogDebug(): bool {
        return $this->log_debug;
    }

    /**
     * @param bool $log_debug
     */
    public function setLogDebug(bool $log_debug): void {
        $this->log_debug = $log_debug;
    }

    /**
     * @return string
     */
    public function getSessionName(): string {
        return $this->session_name;
    }

    /**
     * @param string $session_name
     */
    public function setSessionName(string $session_name): void {
        $this->session_name = $session_name;
    }

    /**
     * @return string
     */
    public function getCookieName(): string {
        return $this->cookie_name;
    }

    /**
     * @param string $cookie_name
     */
    public function setCookieName(string $cookie_name): void {
        $this->cookie_name = $cookie_name;
    }

}