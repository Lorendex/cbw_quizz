<?php
/**
 * Created: 28/03/2018 12:38
 */

class log
{
    private $messages = [];
    private $all_messages = [];

    private static $log_fatal;
    private static $log_error;
    private static $log_warning;
    private static $log_info;
    private static $log_debug;

    protected static $_instance = null;
    public static function getInstance(): log
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
        self::$log_fatal = $conf->isLogFatal();
        self::$log_error = $conf->isLogError();
        self::$log_warning = $conf->isLogWarning();
        self::$log_info = $conf->isLogInfo();
        self::$log_debug = $conf->isLogDebug();
        unset($conf);
    }

    private function log_message(int $type = 0, string $message, $exception): void {
        $msg = trim($message);
        if(empty($msg)) return;
        if($type == 0) return;
        $log_type;
        $add_message;
        switch ($type){
            case 1: {
                $log_type = "FATAL:";
                $add_message = self::$log_fatal ? true : false;
            } break;
            case 2: {
                $log_type = "ERROR:";
                $add_message = self::$log_error ? true : false;
            } break;
            case 3: {
                $log_type = "WARN :";
                $add_message = self::$log_warning ? true : false;
            } break;
            case 4: {
                $log_type = "INFO :";
                $add_message = self::$log_info ? true : false;
            } break;
            case 5: {
                $log_type = "DEBUG:";
                $add_message = self::$log_debug ? true : false;
            } break;
            default: {
                $log_type = "NONE :";
                $add_message = false;
            } break;
        }
        $dt = new \DateTime();
        $newMsg  = "[" . $dt->format('Y-m-d H:i:s'). "] ";
        $newMsg .= $log_type . " ";
        $newMsg .= $msg;
        if($exception !== null) {
            $newMsg .= PHP_EOL . $exception->getMessage();
            $newMsg .= PHP_EOL . $exception->getTraceAsString();
        }
        $newMsg .= PHP_EOL;
        if($add_message) {
            $this->messages[] = $newMsg;
        }
        $this->all_messages[] = $newMsg;
    }
    public static function fatal(string $message, $exception = null): void {
        self::getInstance()->log_message(1, $message, $exception);
    }
    public static function error(string $message, $exception = null): void {
        self::getInstance()->log_message(2, $message, $exception);
    }
    public static function warn(string $message, $exception = null): void {
        self::getInstance()->log_message(3, $message, $exception);
    }
    public static function info(string $message, $exception = null): void {
        self::getInstance()->log_message(4, $message, $exception);
    }
    public static function debug(string $message, $exception = null): void {
        self::getInstance()->log_message(5, $message, $exception);
    }
    public static function dump_array($arr){
        self::getInstance()->log_message(5, print_r($arr,true), null);
    }

    /**
     * @return string[]
     */
    public function getMessages(): array{
        $clean = [];
        $conf = config::getInstance();
        foreach($this->messages as $msg) {
            $tmp = str_replace($conf->getDbPass(), "**DBPASS**",$msg);
            $tmp = str_replace($conf->getDbUser(), "**DBUSER**",$tmp);
            $tmp = str_replace($conf->getDbHost(), "**DBSERVER**",$tmp);
            $tmp = str_replace($conf->getDbDatabase(), "**DBDATABASE**",$tmp);
            $clean[] = $tmp;
        }
        unset($conf);
        return $clean;
    }
}