<?php

/**
 * class DB
 *
 */

class DB
{
    private static $_host;
    private static $_db;
    private static $_user;
    private static $_pass;
    private static $_charset;
    private static $_dsn;
    private static $_opt;
    private static $_pdo;

    public static function pdo(array $db_conn = null) {

        if (self::$_pdo === null) {
            if ($db_conn == null) {
                self::setDsn();
                self::$_pdo = new PDO(self::$_dsn, self::$_user, self::$_pass, self::$_opt);
            } else {
                self::setDsn($db_conn);
                self::$_pdo = new PDO(self::$_dsn, $db_conn['user'], $db_conn['pass'], $db_conn['opt']);
            }
        }

        return self::$_pdo;
    }

    private function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    private static function setDsn(array $db_conn = null)
    {
        if ($db_conn == null) {
            self::$_dsn = "mysql:host=".self::$_host.";dbname=".self::$_db.";charset=".self::$_charset;
        } else {
            self::$_dsn = "mysql:host=".$db_conn['host'].";dbname=".$db_conn['db'].";charset=".$db_conn['charset'];
        }
    }
}

