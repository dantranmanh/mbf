<?php
/**
* Db.php
* 
* Core_Database_Db class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_Database_Db {
    
    private static $link = null;
    private static $result;
    public static $sql;
    public static $numQueries = 0;
    public $prefix = DB_PREFIX;

    private static function connect() {
        self::$link = @mysql_connect( DB_HOST, DB_USER, DB_PASSWORD )
            or die( "Couldn't establish link to database-server: ".DB_HOST );
        mysql_select_db( DB_DATABASE )
            or die( "Couldn't select Database: ".DB_DATABASE );

        mysql_query( "SET NAMES ".DB_CHARSET );
    }

    public static function foundRows() {
        $r = self::query( 'SELECT FOUND_ROWS() AS foundRows' );
        return $r[0]['foundRows'];
    }

    public static function numRows() {
        return mysql_num_rows( self::$result );
    }

    public static function affectedRows() {
        return mysql_affected_rows( self::$result );
    }

    public static function insertId() {
        return mysql_insert_id( self::$link );
    }

    public static function query( $q, $params = array() ) {
        if( self::$link === null ) {
            self::connect();
        }

        if( !is_array( $params ) ) {
            $params = array_slice( func_get_args(), 1 );
        }

        if( !empty( $params ) ) {
            $q = preg_replace('/:(\d+)/e', 'self::quote($params[\\1 - 1])', $q );
        }
        self::$numQueries++;
        self::$sql = $q;
        self::$result = mysql_query( $q, self::$link );

        if( !self::$result ) {
            return false;
        }
        else if( !is_resource( self::$result ) ) {
            return true;
        }

        $rset = array();
        while ( $row = mysql_fetch_object( self::$result ) ) {
            $rset[] = $row;
        }
        return $rset;
    }

    public static function getRow( $q, $params = array() ) {
        if( !is_array( $params ) ) {
            $params = array_slice( func_get_args(), 1 );
        }

        $r = self::query( $q, $params );
        return array_shift( $r );
    }

    public static function updateRow( $table, $idFields, $updateFields ) {
        $updateString = implode( ',', self::quoteArray( $updateFields, true ) );
        $idString = implode( ' AND ', self::quoteArray( $idFields, true ) );
        return self::query( "UPDATE $table SET $updateString WHERE $idString" );
    }

    public static function insertRow( $table, $insertFields ) {
        $insertString = implode( ',', self::quoteArray( $insertFields, true ) );
        return self::query( "INSERT INTO $table SET $insertString" );
    }
    
    public function deleteRow($table, $idFields){
        $idString = implode( ' AND ', self::quoteArray( $idFields, true ) );
        return self::query("DELETE FROM $table WHERE $idString");
    }

    public static function getError() {
        if( $e = mysql_error( self::$link ) ) {
            return "MySQL reports: '$e' on query\n".self::$sql;
        }
        return false;
    }

    public static function quote( $s ) {
        if( $s === true ) {
            return 1;
        }
        else if( $s === false ) {
            return 0;
        }
        else if( is_int($s) || is_float($s) ) {
            return $s;
        }
        else {
            //return "'".mysql_real_escape_string( $s )."'";
            return "'".addslashes( $s )."'";
        }
    }

    public static function quoteArray( &$fields, $useKeys = false ) {
        $r = array();
        foreach( $fields as $key => &$value ) {
            $r[] = ( $useKeys ? "`$key`=":'' ) . self::quote( $value );
        }
        return $r;
    }
    
    public function close(){
        mysql_close(self::$link);
    }
}