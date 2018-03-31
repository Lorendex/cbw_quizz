<?php
/**
 * Created: 28/03/2018 10:44
 */

class user_session
{
    const TABLE = "user_sessions";
    /**
     * @var int
     */
    private $id;
    /**
     * @var int[]
     */
    private $answered_questions = [];

    /**
     * @var string
     */
    private $username;
    /**
     * @var DateTime
     */
    private $last_active;
    /**
     * @var int
     */
    private $last_question;

    /**
     * 36 char unique id - mysql function uuid()
     * @var string
     */
    private $token;

    /**
     * @return string
     */
    public function getToken(): string {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return int[]
     */
    public function getAnsweredQuestions(): array {
        return $this->answered_questions;
    }

    /**
     * @param int[] $answered_questions
     */
    public function setAnsweredQuestions(array $answered_questions): void {
        $this->answered_questions = $answered_questions;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    /**
     * @param string $username
     */
    public function setUsernameAndSave(string $username): void {
        $this->username = $username;
        $db = db::getInstance()->getConnection();
        $stmt = $db->prepare(queryhelper::USER_SESSION_UPDATE_NAME());
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        unset($db, $stmt);
    }

    /**
     * @return DateTime
     */
    public function getLastActive(): DateTime {
        return $this->last_active;
    }

    /**
     * @param DateTime $last_active
     */
    public function setLastActive(DateTime $last_active): void {
        $this->last_active = $last_active;
    }

    /**
     * @return int
     */
    public function getLastQuestion(): int {
        return $this->last_question;
    }

    /**
     * @param int $last_question
     */
    public function setLastQuestion(int $last_question): void {
        $this->last_question = $last_question;
    }

    /**
     * @param int $id
     * @return user_session
     */
    public static function loadByID(int $id): user_session {

    }

    public function hasUsername(){
        if($this->getUsername() === "Unknown" )
            return false;
        return true;
    }

    /**
     * @return user_session
     */
    public static function loadByToken(): user_session {
        $conf = config::getInstance();
        $token = $_SESSION[$conf->getSessionName()]["token"];
        $sess = null;
        if(empty($token)){
            log::info("No token found in session, creating new session.");
            $sess = user_session::generateNewSession();
            $_SESSION[$conf->getSessionName()]["token"] = $sess->getToken();
        } else {
            log::debug("Token found, load session.");
            $db = db::getInstance()->getConnection();
            $stmt = $db->prepare(queryhelper::USER_SESSION_BY_TOKEN());
            $stmt->bindParam(":token", $token);
            $stmt->execute();
            $result = $stmt->fetch();
            if(!is_array($result)) {
                log::warn("Session could not be loaded, creating new Session");
                $sess = user_session::generateNewSession();
                $_SESSION[$conf->getSessionName()]["token"] = $sess->getToken();
            } else {
                $sess = new user_session();
                $sess->setId($result["ID"]);
                $sess->setLastActive(new DateTime($result["lastactive"]));
                $sess->setLastQuestion($result["lastquestion"]);
                $sess->setToken($result["token"]);
                $sess->setUsername($result["username"]);
            }
        }
        return $sess;
    }

    /**
     * @param user_session $sess
     */
    private static function save(user_session $sess): void {

    }

    /**
     * @return user_session
     */
    public static function generateNewSession(): user_session{
        $conf = config::getInstance();
        $user_name = self::hasSavedNameInCookie() ? htmlspecialchars($_COOKIE[$conf->getCookieName()]) : "Unknown";

        $db = db::getInstance()->getConnection();

        #create session
        $stmt = $db->prepare(queryhelper::USER_SESSION_CREATE());
        $stmt->bindParam(":username", $user_name);
        $result = $stmt->execute();

        #get id
        $id = $db->lastInsertId();
        log::debug("Created id = " . $id);
        #load session
        $stmt2 = $db->prepare(queryhelper::USER_SESSION_BY_ID());
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();
        $result2 = $stmt2->fetch();

        # create user_session
        $session = new user_session();
        $session->setId($result2["ID"]);
        $session->setLastActive(new DateTime($result2["lastactive"]));
        $session->setLastQuestion($result2["lastquestion"]);
        $session->setToken($result2["token"]);
        $session->setUsername($result2["username"]);
        unset($result2, $result, $stmt, $stmt2, $db, $conf);
        return $session;
    }

    private static function hasSavedNameInCookie(){
        if(isset($_COOKIE) && isset($_COOKIE[config::getInstance()->getCookieName()]))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public static function userSessionAviable(): bool {
        $conf = config::getInstance();
        if(isset($_SESSION) && isset($_SESSION[$conf->getSessionName()])) {
            log::debug("Session found.");
            unset($conf);
            return true;
        }
        unset($conf);
        return false;
    }
}