<?php

namespace YoastSEO_Vendor;

/**
 * Ruckusing
 *
 * @category  Ruckusing
 *
 * @author    Cody Caughlan <codycaughlan % gmail . com>
 *
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
/**
 * Ruckusing_Adapter_Interface
 *
 * Interface of adapters
 *
 * @category Ruckusing
 *
 * @author   Cody Caughlan <codycaughlan % gmail . com>
 *
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
interface Ruckusing_Adapter_Interface
{
    /**
     * get the current database name
     *
     * @return string
     */
    public function get_database_name();

    /**
     * Quote a raw string.
     *
     * @param  string  $value  Raw string
     * @param  string  $column  the column name
     * @return string
     */
    public function quote($value, $column = null);

    /**
     * supports migrations ?
     *
     * @return bool
     */
    public function supports_migrations();

    /**
     * native database types
     *
     * @return array
     */
    public function native_database_types();

    /**
     * schema
     *
     * @return void
     */
    public function schema($output_file);

    /**
     * execute
     *
     * @param  string  $query  Query SQL
     * @return void
     */
    public function execute($query);

    /**
     * Quote a raw string.
     *
     * @param  string  $str  Raw string
     * @return string
     */
    public function quote_string($str);

    //database level operations
    /**
     * database exists
     *
     * @param  string  $db  The database name
     * @return bool
     */
    public function database_exists($db);

    /**
     * create table
     *
     * @param  string  $table_name  The table name
     * @param  array  $options  Options for definition table
     * @return bool
     */
    public function create_table($table_name, $options = []);

    /**
     * drop database
     *
     * @param  string  $db  The database name
     * @return bool
     */
    public function drop_database($db);

    //table level opertions
    /**
     * table exists ?
     *
     * @param  string  $tbl  Table name
     * @return bool
     */
    public function table_exists($tbl);

    /**
     * drop table
     *
     * @param  string  $tbl  The table name
     * @return bool
     */
    public function drop_table($tbl);

    /**
     * rename table
     *
     * @param  string  $name  The old name of table
     * @param  string  $new_name  The new name
     * @return bool
     */
    public function rename_table($name, $new_name);

    //column level operations
    /**
     * rename column
     *
     * @param  string  $table_name  The table name where is the column
     * @param  string  $column_name  The old column name
     * @param  string  $new_column_name  The new column name
     * @return bool
     */
    public function rename_column($table_name, $column_name, $new_column_name);

    /**
     * add column
     *
     * @param  string  $table_name  The table name
     * @param  string  $column_name  The column name
     * @param  string  $type  The type generic of the column
     * @param  array  $options  The options definition of the column
     * @return bool
     */
    public function add_column($table_name, $column_name, $type, $options = []);

    /**
     * remove column
     *
     * @param  string  $table_name  The table name
     * @param  string  $column_name  The column name
     * @return bool
     */
    public function remove_column($table_name, $column_name);

    /**
     * change column
     *
     * @param  string  $table_name  The table name
     * @param  string  $column_name  The column name
     * @param  string  $type  The type generic of the column
     * @param  array  $options  The options definition of the column
     * @return void
     */
    public function change_column($table_name, $column_name, $type, $options = []);

    /**
     * remove index
     *
     * @param  string  $table_name  The table name
     * @param  string  $column_name  The column name
     * @return bool
     */
    public function remove_index($table_name, $column_name);

    /**
     * add index
     *
     * @param  string  $table_name  The table name
     * @param  string  $column_name  The column name
     * @param  array  $options  The options definition of the index
     * @return bool
     */
    public function add_index($table_name, $column_name, $options = []);

    /**
     * add timestamps
     *
     * @param  string  $table_name  The table name
     * @param  string  $created_column_name  Created at column name
     * @param  string  $updated_column_name  Updated at column name
     * @return bool
     */
    public function add_timestamps($table_name, $created_column_name, $updated_column_name);

    /**
     * remove timestamps
     *
     * @param  string  $table_name  The table name
     * @param  string  $created_column_name  Created at column name
     * @param  string  $updated_column_name  Updated at column name
     * @return bool
     */
    public function remove_timestamps($table_name, $created_column_name, $updated_column_name);

    /**
     * Wrapper to execute a query
     *
     * @param  string  $query  query to run
     * @return bool
     */
    public function query($query);

    /**
     * Wrapper to execute multiple queries
     *
     * @param  string  $queries  queries to run
     * @return bool
     */
    public function multi_query($queries);
}
