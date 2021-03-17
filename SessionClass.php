<?php

class SESSION{
    public static $session = array();
    private static $sessionName = "YE_SESSION";
    private static $sessionFile = __DIR__ . "/session.json";
    private static $sessionExp = 3600;
    private static $sessionUUID = "";
    
    public static function init(){
        if(!isset($_COOKIE[self::$sessionName])){
            self::$sessionUUID = self::getUUID4();
            setcookie(self::$sessionName, self::$sessionUUID, strtotime("+1 month"), "/");
        }
        else{
            self::$sessionUUID = $_COOKIE[self::$sessionName];
        }
        
        if(!file_exists(self::$sessionFile)){
            file_put_contents(self::$sessionFile, json_encode(array()));
        }
        
        static::loadSession();
    }
    public static function loadSession(){
        $data = json_decode(file_get_contents(self::$sessionFile), true);
        if(!is_array($data)) $data = array();
        
        if(isset($data[self::$sessionUUID]) && $data[self::$sessionUUID]['time'] > time()){
            self::$session = $data[self::$sessionUUID]['data'];
        }
        else{
            unset($data[self::$sessionUUID]);
            setcookie(self::$sessionName, self::$sessionUUID, strtotime("+1 month"), "/");
            file_put_contents(self::$sessionFile, json_encode($data, true));
        }
    }
    public static function saveSession(){
        $oldSessionData = json_decode(file_get_contents(self::$sessionFile), true);
        if(!is_array($oldSessionData)) $oldSessionData = array();
        
        $oldSessionData[self::$sessionUUID]['data'] = self::$session;
        $oldSessionData[self::$sessionUUID]['time'] = (time() + self::$sessionExp);
        
        $newSessionData = array();
        foreach ($oldSessionData as $_SESSION_KEY => $_SESSION_DATA){
            if($_SESSION_DATA['time'] > time())
                $newSessionData[$_SESSION_KEY] = $_SESSION_DATA;
        }
        file_put_contents(self::$sessionFile, json_encode($newSessionData, true));
    }
    
    private static function getUUID4() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0x0fff ) | 0x4000, mt_rand( 0, 0x3fff ) | 0x8000, mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
    public static function setSessionName($sessionName){
        self::$sessionName = $sessionName;
    }
    public static function getSessionName(){
        return self::$sessionName;
    }
    public static function setSessionExp($sessionExp){
        self::$sessionExp = $sessionExp;
    }
    public static function setSessionExp(){
        return self::$sessionExp;
    }
    public static function setSessionFile($sessionFile){
        self::$sessionFile = $sessionFile;
    }
    public static function setSessionExp(){
        return self::$sessionFile;
    }
    
    /*
    public static function __set($index, $value){
        self::$session[$index] = $value;
        self::saveSession();
    }
    public static function __get($index){
        return self::$session[$index];
    }
    */
    
    public static function set($session){
        self::$session = $session;
        self::saveSession();
    }
    public static function get(){
        return self::$session;
    }
}

register_shutdown_function(array('SESSION', 'saveSession')); 
