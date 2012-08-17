<?php
class DB
{
    // Connection parameters 
	
    var $host = 'localhost';	
    var $user = 'hcmfbapp';
    var $password = 'hcmfbapppass';
    var $database = 'hcmfbapp';
    var $persistent = false;

    // Database connection handle 
    var $conn = NULL;

    // Query result 
    var $result = false;
	 function DB()
    //function DB($host, $user, $password, $database, $persistent = false)
    {
        /*$this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->persistent = $persistent;*/
    }
	

    function open()
    {
        // Choose the appropriate connect function 
        if ($this->persistent) {
            $func = 'mysql_pconnect';
        } else {
            $func = 'mysql_connect';
        }

        // Connect to the MySQL server 
        $this->conn = $func($this->host, $this->user, $this->password);
        if (!$this->conn) {
            return false;
        }
        // Select the requested database 
        if (!@mysql_select_db($this->database, $this->conn)) {
            return false;
        }

	 @mysql_query("SET NAMES 'utf8'", $this->conn);
        return true;
    }

    function close()
    {
        return (@mysql_close($this->conn));
    }

    function error()
    {
        return (mysql_error());
    }

    function query($sql = '')
    {
        $this->result = @mysql_query($sql, $this->conn);

        return ($this->result != false);
    }

    function affectedRows()
    {
        return (@mysql_affected_rows($this->conn));
    }

    function numRows()
    {
        return (@mysql_num_rows($this->result));
    }
	
	//this function is added on 9 dec 2003
	function lastID()
    {
        return (@mysql_insert_id($this->conn));
    }

	//this function is added on 9 dec 2003
	function getSingle($sql)
    {
		$this->query($sql);
		return (@mysql_result($this->result));
    }
	
    function fetchObject()
    {
        return (@mysql_fetch_object($this->result));//, MYSQL_ASSOC)); commented by abhishek since not working with perhaps mysql 5.x
    }

    function fetchArray()
    {
        return (@mysql_fetch_array($this->result));//, MYSQL_NUM)); made hidden by abhihsek since not working with php 5.x
    }

    function fetchAssoc()
    {
        return (@mysql_fetch_assoc($this->result));
    }

    function freeResult()
    {
        return (@mysql_free_result($this->result));
    }
	
	}
?>
