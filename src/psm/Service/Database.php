<?php

/**
 * PHP Server Monitor
 * Monitor your servers and websites.
 *
 * This file is part of PHP Server Monitor.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Service;

class Database
{

    /**
     * DB hostname
     * @var string $db_host
     */
    protected $db_host;

    /**
     * DB port
     * @var string|integer $db_port
     */
    protected $db_port;

    /**
     * DB name
     * @var string $db_name
     */
    protected $db_name;

    /**
     * DB user password
     * @var string $db_pass
     */
    protected $db_pass;

    /**
     * DB username
     * @var string $db_user
     */
    protected $db_user;

    /**
     * PDOStatement of last query
     * @var int|bool|\PDOStatement $last
     */
    protected $last;

    /**
     * Mysql db connection identifer
     * @var \PDO $pdo
     * @see pdo()
     */
    protected $pdo;

    /**
     * Connect status
     * @var boolean
     * @see connect()
     */
    protected $status = false;

    /**
     * Constructor
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     * @param string|integer $port
     */
    public function __construct($host = null, $user = null, $pass = null, $db = null, $port = '')
    {
        if ($host != null && $user != null && $pass !== null && $db != null) {
            $this->db_host = $host;
            $this->db_port = $port;
            $this->db_name = $db;
            $this->db_user = $user;
            $this->db_pass = $pass;
            $this->connect();
        }
    }

    /**
     * Exectues query and fetches result.
     *
     * If you dont want to fetch a result, use exec().
     * @param string $query SQL query
     * @param boolean $fetch automatically fetch results, or return PDOStatement?
     * @return \PDOStatement|int|bool|array object
     */
    public function query($query, $fetch = true)
    {
        // Execute query and process results
        try {
            $this->last = $this->pdo()->query($query);
        } catch (\PDOException $e) {
            $this->error($e);
        }

        if ($fetch && $this->last != false) {
            $cmd = strtolower(substr($query, 0, 6));

            switch ($cmd) {
                case 'insert':
                    // insert query, return insert id
                    $result = $this->getLastInsertedId();
                    break;
                case 'update':
                case 'delete':
                    // update/delete, returns rowCount
                    $result = $this->getNumRows();
                    break;
                default:
                    $result = $this->last->fetchAll(\PDO::FETCH_ASSOC);
                    break;
            }
        } else {
            $result = $this->last;
        }
        return $result;
    }

    /**
     * Execute SQL statement and return number of affected rows
     * @param string $query
     * @return int
     */
    public function exec($query)
    {
        try {
            $this->last = $this->pdo()->exec($query);
        } catch (\PDOException $e) {
            $this->error($e);
        }

        return $this->last;
    }

    /**
     * Prepare and execute SQL statement with parameters
     * @param string $query SQL statement
     * @param array $parameters An array of values with as many elements as there are
     *     bound parameters in the SQL statement
     * @param boolean $fetch automatically fetch results, or return PDOStatement?
     * @return array|\PDOStatement if $fetch = true, array, otherwise \PDOStatement
     */
    public function execute($query, $parameters, $fetch = true)
    {
        try {
            $this->last = $this->pdo()->prepare($query);
            $this->last->execute($parameters);
        } catch (\PDOException $e) {
            $this->error($e);
        }

        if ($fetch && $this->last != false) {
            $result = $this->last->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $result = $this->last;
        }
        return $result;
    }

    /**
     * Performs a select on the given table and returns an multi dimensional associative array with results
     * @param string $table tablename
     * @param mixed $where string or array with where data
     * @param array $fields array with fields to be retrieved. if empty all fields will be retrieved
     * @param string $limit limit. for example: 0,30
     * @param array $orderby fields for the orderby clause
     * @param string $direction ASC or DESC. Defaults to ASC
     * @return \PDOStatement array multi dimensional array with results
     */
    public function select($table, $where = null, $fields = null, $limit = '', $orderby = null, $direction = 'ASC')
    {
        // build query
        $query_parts = array();
        $query_parts[] = 'SELECT SQL_CALC_FOUND_ROWS';

        // Fields
        if ($fields !== null && !empty($fields)) {
            $query_parts[] = "`" . implode('`,`', $fields) . "`";
        } else {
            $query_parts[] = ' * ';
        }

        // From
        $query_parts[] = "FROM `{$table}`";

        // Where clause
        $query_parts[] = $this->buildSQLClauseWhere($table, $where);

        // Order by
        if ($orderby) {
            $query_parts[] = $this->buildSQLClauseOrderBy($orderby, $direction);
        }

        // Limit
        if ($limit != '') {
            $query_parts[] = 'LIMIT ' . $limit;
        }

        $query = implode(' ', $query_parts);

        return $this->query($query);
    }

    /**
     * Alias to select() but uses limit = 1 to return only one row.
     * @param string $table tablename
     * @param mixed $where string or array with where data
     * @param array $fields array with fields to be retrieved. if empty all fields will be retrieved
     * @param array $orderby fields for the orderby clause
     * @param string $direction ASC or DESC. Defaults to ASC
     * @return array
     */
    public function selectRow($table, $where = null, $fields = null, $orderby = null, $direction = 'ASC')
    {
        $result = $this->select($table, $where, $fields, '1', $orderby, $direction);

        if (isset($result[0])) {
            $result = $result[0];
        }

        return $result;
    }

    /**
     * Remove a record from database
     * @param string $table tablename
     * @param mixed $where Where clause array or primary Id (string) or where clause (string)
     * @return int number of affected rows
     */
    public function delete($table, $where = null)
    {
        $sql = 'DELETE FROM `' . $table . '` ' . $this->buildSQLClauseWhere($table, $where);

        return $this->exec($sql);
    }

    /**
     * Insert or update data to the database
     * @param string $table table name
     * @param array $data data to save or insert
     * @param string|array $where either string ('user_id=2' or just '2' (works only with primary field)) or
     *  array with where clause (only when updating)
     * @return int|array|\PDOStatement
     */
    public function save($table, array $data, $where = null)
    {
        if ($where === null) {
            // insert mode
            $query = "INSERT INTO ";
            $exec = false;
        } else {
            $query = "UPDATE ";
            $exec = true;
        }

        $query .= "`{$table}` SET ";

        foreach ($data as $field => $value) {
            if (is_null($value)) {
                $value = 'NULL';
            } else {
                $value = $this->quote($value);
            }
            $query .= "`{$table}`.`{$field}`={$value}, ";
        }

        $query = substr($query, 0, -2) . ' ' . $this->buildSQLClauseWhere($table, $where);

        if ($exec) {
            return $this->exec($query);
        }
        return $this->query($query);
    }

    /**
     * Insert multiple rows into a single table
     *
     * This method is preferred  over calling the insert() lots of times
     * so it can be optimized to be inserted with 1 query.
     * It can only be used if all inserts have the same fields, records
     * that do not match the fields provided in the first record will be
     * skipped.
     *
     * @param string $table
     * @param array $data
     * @return \PDOStatement
     * @see insert()
     */
    public function insertMultiple($table, array $data)
    {
        if (empty($data)) {
            return false;
        }

        // prepare first part
        $query = "INSERT INTO `{$table}` ";
        $fields = array_keys($data[0]);
        $query .= "(`" . implode('`,`', $fields) . "`) VALUES ";

        // prepare all rows to be inserted with placeholders for vars (\?)
        $q_part = array_fill(0, count($fields), '?');
        $q_part = "(" . implode(',', $q_part) . ")";

        $q_part = array_fill(0, count($data), $q_part);
        $query .= implode(',', $q_part);

        $pst = $this->pdo()->prepare($query);

        $i = 1;
        foreach ($data as $row) {
            // make sure the fields of this row are identical to first row
            $diff_keys = array_diff_key($fields, array_keys($row));

            if (!empty($diff_keys)) {
                continue;
            }
            foreach ($fields as $field) {
                $pst->bindParam($i++, $row[$field]);
            }
        }

        try {
            $this->last = $pst->execute();
        } catch (\PDOException $e) {
            $this->error($e);
        }
        return $this->last;
    }

    /**
     * Check if a certain table exists.
     * @param string $table
     * @return boolean
     */
    public function ifTableExists($table)
    {
        $table = $this->quote($table);
        $db = $this->quote($this->getDbName());

        $if_exists = "SELECT COUNT(*) AS `cnt`
			FROM `information_schema`.`tables`
			WHERE `table_schema` = {$db}
			AND `table_name` = {$table};
		";
        $if_exists = $this->query($if_exists);

        if (isset($if_exists[0]['cnt']) && $if_exists[0]['cnt'] == 1) {
            return true;
        } else {
            false;
        }
    }

    /**
     * Quote a string
     * @param string $value
     * @return string
     */
    public function quote($value)
    {
        return $this->pdo()->quote($value);
    }

    /**
     * Get the PDO object
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }

    /**
     * Get number of rows of last statement
     * @return int number of rows
     */
    public function getNumRows()
    {
        return $this->last->rowCount();
    }

    /**
     * Get the last inserted id after an insert
     * @return int
     */
    public function getLastInsertedId()
    {
        return $this->pdo()->lastInsertId();
    }

    /**
     * Build WHERE clause for query
     * @param string $table table name
     * @param mixed $where can be primary id (eg '2'), can be string (eg 'name=pepe') or can be array
     * @return string sql where clause
     * @see buildSQLClauseOrderBy()
     */
    public function buildSQLClauseWhere($table, $where = null)
    {

        $query = '';

        if ($where !== null) {
            if (is_array($where)) {
                $query .= " WHERE ";

                foreach ($where as $field => $value) {
                    $query .= "`{$table}`.`{$field}`={$this->quote($value)} AND ";
                }
                $query = substr($query, 0, -5);
            } else {
                if (strpos($where, '=') === false) {
                    // no field given, use primary field
                    $primary = $this->getPrimary($table);
                    $query .= " WHERE `{$table}`.`{$primary}`={$this->quote($where)}";
                } elseif (strpos(strtolower(trim($where)), 'where') === false) {
                    $query .= " WHERE {$where}";
                } else {
                    $query .= ' ' . $where;
                }
            }
        }
        return $query;
    }

    /**
     * Build ORDER BY clause for a query
     * @param mixed $order_by can be string (with or without order by) or array
     * @param string $direction
     * @return string sql order by clause
     * @see buildSQLClauseWhere()
     */
    public function buildSQLClauseOrderBy($order_by, $direction)
    {
        $query = '';

        if ($order_by !== null) {
            if (is_array($order_by)) {
                $query .= " ORDER BY ";

                foreach ($order_by as $field) {
                    $query .= "`{$field}`, ";
                }
                // remove trailing ", "
                $query = substr($query, 0, -2);
            } else {
                if (strpos(strtolower(trim($order_by)), 'order by') === false) {
                    $query .= " ORDER BY {$order_by}";
                } else {
                    $query .= ' ' . $order_by;
                }
            }
        }
        if (strlen($query) > 0) {
            // check if "ASC" or "DESC" is already in the order by clause
            if (
                strpos(strtolower(trim($query)), 'asc') === false &&
                strpos(strtolower(trim($query)), 'desc') === false
            ) {
                $query .= ' ' . $direction;
            }
        }

        return $query;
    }

    /**
     * Get the host of the current connection
     * @return string
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * Get the db name of the current connection
     * @return string
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * Get the db user of the current connection
     * @return string
     */
    public function getDbUser()
    {
        return $this->db_user;
    }

    /**
     * Get status of the connection
     * @return boolean
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Connect to the database.
     *
     * @return resource mysql resource
     */
    protected function connect()
    {
        // Initizale connection
        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $this->db_host .
                    ';port=' . $this->db_port .
                    ';dbname=' . $this->db_name .
                    ';charset=utf8',
                $this->db_user,
                $this->db_pass
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->status = true;
        } catch (\PDOException $e) {
            $this->status = false;
            return $this->onConnectFailure($e);
        }
        return $this->pdo;
    }

    /**
     * Is called after connection failure
     */
    protected function onConnectFailure(\PDOException $e)
    {
        trigger_error('MySQL connection failed: ' . $e->getMessage(), E_USER_WARNING);
        return false;
    }

    /**
     * Disconnect from current link
     */
    protected function disconnect()
    {
        $this->pdo = null;
    }

    /**
     * Handle a PDOException
     * @param \PDOException $e
     */
    protected function error(\PDOException $e)
    {
        trigger_error('SQL error: ' . $e->getMessage(), E_USER_WARNING);
    }
}
