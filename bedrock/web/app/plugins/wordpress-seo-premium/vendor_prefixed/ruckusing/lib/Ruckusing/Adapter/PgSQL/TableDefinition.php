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
 * Ruckusing_Adapter_PgSQL_TableDefinition
 *
 * @category Ruckusing
 *
 * @author   Cody Caughlan <codycaughlan % gmail . com>
 *
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
class Ruckusing_Adapter_PgSQL_TableDefinition extends \YoastSEO_Vendor\Ruckusing_Adapter_TableDefinition
{
    /**
     * adapter PgSQL
     *
     * @var Ruckusing_Adapter_Pgsql_Base
     */
    private $_adapter;

    /**
     * Name
     *
     * @var string
     */
    private $_name;

    /**
     * options
     *
     * @var array
     */
    private $_options;

    /**
     * sql
     *
     * @var string
     */
    private $_sql = '';

    /**
     * initialized
     *
     * @var bool
     */
    private $_initialized = \false;

    /**
     * Columns
     *
     * @var array
     */
    private $_columns = [];

    /**
     * Table definition
     *
     * @var array
     */
    private $_table_def;

    /**
     * primary keys
     *
     * @var array
     */
    private $_primary_keys = [];

    /**
     * auto generate id
     *
     * @var bool
     */
    private $_auto_generate_id = \true;

    /**
     * Creates an instance of Ruckusing_PostgresTableDefinition
     *
     * @param  Ruckusing_Adapter_PgSQL_Base  $adapter  the current adapter
     * @param  string  $name  the table name
     * @param  array  $options
     * @return \Ruckusing_Adapter_PgSQL_TableDefinition
     *
     * @throws Ruckusing_Exception
     */
    public function __construct($adapter, $name, $options = [])
    {
        //sanity check
        if (! $adapter instanceof \YoastSEO_Vendor\Ruckusing_Adapter_PgSQL_Base) {
            throw new \YoastSEO_Vendor\Ruckusing_Exception('Invalid Postgres Adapter instance.', \YoastSEO_Vendor\Ruckusing_Exception::INVALID_ADAPTER);
        }
        if (! $name) {
            throw new \YoastSEO_Vendor\Ruckusing_Exception("Invalid 'name' parameter", \YoastSEO_Vendor\Ruckusing_Exception::INVALID_ARGUMENT);
        }
        $this->_adapter = $adapter;
        $this->_name = $name;
        $this->_options = $options;
        $this->init_sql($name, $options);
        $this->_table_def = new \YoastSEO_Vendor\Ruckusing_Adapter_TableDefinition($this->_adapter, $this->_options);
        if (\array_key_exists('id', $options)) {
            if (\is_bool($options['id']) && $options['id'] == \false) {
                $this->_auto_generate_id = \false;
            }
            //if its a string then we want to auto-generate an integer-based primary key with this name
            if (\is_string($options['id'])) {
                $this->_auto_generate_id = \true;
                $this->_primary_keys[] = $options['id'];
            }
        }
    }

    /**
     * Create a column
     *
     * @param  string  $column_name  the column name
     * @param  string  $type  the column type
     * @param  array  $options
     */
    public function column($column_name, $type, $options = [])
    {
        //if there is already a column by the same name then silently fail and continue
        if ($this->_table_def->included($column_name) == \true) {
            return;
        }
        $column_options = [];
        if (\array_key_exists('primary_key', $options)) {
            if ($options['primary_key'] == \true) {
                $this->_primary_keys[] = $column_name;
            }
        }
        /*
         if (array_key_exists('auto_increment', $options)) {
        if ($options['auto_increment'] == true) {
        $column_options['auto_increment'] = true;
        }
        }
        */
        $column_options = \array_merge($column_options, $options);
        $column = new \YoastSEO_Vendor\Ruckusing_Adapter_ColumnDefinition($this->_adapter, $column_name, $type, $column_options);
        $this->_columns[] = $column;
    }

    //column
    /**
     * Shortcut to create timestamps columns (default created_at, updated_at)
     *
     * @param  string  $created_column_name  Created at column name
     * @param  string  $updated_column_name  Updated at column name
     */
    public function timestamps($created_column_name = 'created_at', $updated_column_name = 'updated_at')
    {
        $this->column($created_column_name, 'datetime', ['null' => \false]);
        $this->column($updated_column_name, 'datetime', ['null' => \false]);
    }

    /**
     * Get all primary keys
     *
     * @return string
     */
    private function keys()
    {
        if (\count($this->_primary_keys) > 0) {
            $lead = ' PRIMARY KEY (';
            $quoted = [];
            foreach ($this->_primary_keys as $key) {
                $quoted[] = \sprintf('%s', $this->_adapter->identifier($key));
            }
            $primary_key_sql = ",\n".$lead.\implode(',', $quoted).')';

            return $primary_key_sql;
        } else {
            return '';
        }
    }

    /**
     * Table definition
     *
     * @param  bool  $wants_sql
     * @return bool|string
     *
     * @throws Ruckusing_Exception
     */
    public function finish($wants_sql = \false)
    {
        if ($this->_initialized == \false) {
            throw new \YoastSEO_Vendor\Ruckusing_Exception(\sprintf("Table Definition: '%s' has not been initialized", $this->_name), \YoastSEO_Vendor\Ruckusing_Exception::INVALID_TABLE_DEFINITION);
        }
        if (\is_array($this->_options) && \array_key_exists('options', $this->_options)) {
            $opt_str = $this->_options['options'];
        } else {
            $opt_str = null;
        }
        $close_sql = \sprintf(') %s;', $opt_str);
        $create_table_sql = $this->_sql;
        if ($this->_auto_generate_id === \true) {
            $this->_primary_keys[] = 'id';
            $primary_id = new \YoastSEO_Vendor\Ruckusing_Adapter_ColumnDefinition($this->_adapter, 'id', 'primary_key');
            $create_table_sql .= $primary_id->to_sql().",\n";
        }
        $create_table_sql .= $this->columns_to_str();
        $create_table_sql .= $this->keys().$close_sql;
        if ($wants_sql) {
            return $create_table_sql;
        } else {
            return $this->_adapter->execute_ddl($create_table_sql);
        }
    }

    /**
     * get all columns
     *
     * @return string
     */
    private function columns_to_str()
    {
        $str = '';
        $fields = [];
        $len = \count($this->_columns);
        for ($i = 0; $i < $len; $i++) {
            $c = $this->_columns[$i];
            $fields[] = $c->__toString();
        }

        return \implode(",\n", $fields);
    }

    /**
     * Init create sql
     *
     * @param  string  $name
     * @param  array  $options
     *
     * @throws Exception
     * @throws Ruckusing_Exception
     */
    private function init_sql($name, $options)
    {
        //are we forcing table creation? If so, drop it first
        if (\array_key_exists('force', $options) && $options['force'] == \true) {
            try {
                $this->_adapter->drop_table($name);
            } catch (\YoastSEO_Vendor\Ruckusing_Exception $e) {
                if ($e->getCode() != \YoastSEO_Vendor\Ruckusing_Exception::MISSING_TABLE) {
                    throw $e;
                }
                //do nothing
            }
        }
        $temp = '';
        $create_sql = \sprintf('CREATE%s TABLE ', $temp);
        $create_sql .= \sprintf("%s (\n", $this->_adapter->identifier($name));
        $this->_sql .= $create_sql;
        $this->_initialized = \true;
    }
}
