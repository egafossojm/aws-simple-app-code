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
\define(__NAMESPACE__.'\STYLE_REGULAR', 1);
\define(__NAMESPACE__.'\STYLE_OFFSET', 2);
/**
 * Task_DB_Migrate.
 * This is the primary work-horse method, it runs all migrations available,
 * up to the current version.
 *
 * @category Ruckusing
 *
 * @author   Cody Caughlan <codycaughlan % gmail . com>
 *
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
class Task_Db_Migrate extends \YoastSEO_Vendor\Ruckusing_Task_Base implements \YoastSEO_Vendor\Ruckusing_Task_Interface
{
    /**
     * migrator util
     *
     * @var Ruckusing_Util_Migrator
     */
    private $_migrator_util = null;

    /**
     * Current Adapter
     *
     * @var Ruckusing_Adapter_Base
     */
    private $_adapter = null;

    /**
     * migrator directories
     *
     * @var string
     */
    private $_migratorDirs = null;

    /**
     * The task arguments
     *
     * @var array
     */
    private $_task_args = [];

    /**
     * debug
     *
     * @var bool
     */
    private $_debug = \false;

    /**
     * Return executed string
     *
     * @var string
     */
    private $_return = '';

    /**
     * Creates an instance of Task_DB_Migrate
     *
     * @param  Ruckusing_Adapter_Base  $adapter  The current adapter being used
     * @return Task_DB_Migrate
     */
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
        $this->_migrator_util = new \YoastSEO_Vendor\Ruckusing_Util_Migrator($this->_adapter);
    }

    /**
     * Primary task entry point
     *
     * @param  array  $args  The current supplied options.
     */
    public function execute($args)
    {
        if (! $this->_adapter->supports_migrations()) {
            throw new \YoastSEO_Vendor\Ruckusing_Exception('This database does not support migrations.', \YoastSEO_Vendor\Ruckusing_Exception::MIGRATION_NOT_SUPPORTED);
        }
        $this->_task_args = $args;
        $this->_return .= 'Started: '.\date('Y-m-d g:ia T')."\n\n";
        $this->_return .= "[db:migrate]: \n";
        try {
            // Check that the schema_version table exists, and if not, automatically create it
            $this->verify_environment();
            $target_version = null;
            $style = \YoastSEO_Vendor\STYLE_REGULAR;
            //did the user specify an explicit version?
            if (\array_key_exists('version', $this->_task_args)) {
                $target_version = \trim($this->_task_args['version']);
            }
            // did the user specify a relative offset, e.g. "-2" or "+3" ?
            if ($target_version !== null) {
                if (\preg_match('/^([\\-\\+])(\\d+)$/', $target_version, $matches)) {
                    if (\count($matches) == 3) {
                        $direction = $matches[1] == '-' ? 'down' : 'up';
                        $steps = \intval($matches[2]);
                        $style = \YoastSEO_Vendor\STYLE_OFFSET;
                    }
                }
            }
            //determine our direction and target version
            $current_version = $this->_migrator_util->get_max_version();
            if ($style == \YoastSEO_Vendor\STYLE_REGULAR) {
                if (\is_null($target_version)) {
                    $this->prepare_to_migrate($target_version, 'up');
                } elseif ($current_version > $target_version) {
                    $this->prepare_to_migrate($target_version, 'down');
                } else {
                    $this->prepare_to_migrate($target_version, 'up');
                }
            }
            if ($style == \YoastSEO_Vendor\STYLE_OFFSET) {
                $this->migrate_from_offset($steps, $current_version, $direction);
            }
            // Completed - display accumulated output
            if (! empty($output)) {
                $this->_return .= "\n\n";
            }
        } catch (\YoastSEO_Vendor\Ruckusing_Exception $ex) {
            if ($ex->getCode() == \YoastSEO_Vendor\Ruckusing_Exception::MISSING_SCHEMA_INFO_TABLE) {
                $this->_return .= "\tSchema info table does not exist. I tried creating it but failed. Check permissions.";
            } else {
                throw $ex;
            }
        }
        $this->_return .= "\n\nFinished: ".\date('Y-m-d g:ia T')."\n\n";

        return $this->_return;
    }

    /**
     * Migrate to a specific version using steps from current version
     *
     * @param  int  $steps  number of versions to jump to
     * @param  string  $current_version  current version
     * @param  $string  $direction direction to migrate to 'up'/'down'
     */
    private function migrate_from_offset($steps, $current_version, $direction)
    {
        $migrations = $this->_migrator_util->get_migration_files($this->_migratorDirs, $direction);
        $current_index = $this->_migrator_util->find_version($migrations, $current_version, \true);
        $current_index = $current_index !== null ? $current_index : -1;
        if ($this->_debug == \true) {
            $this->_return .= \print_r($migrations, \true);
            $this->_return .= "\ncurrent_index: ".$current_index."\n";
            $this->_return .= "\ncurrent_version: ".$current_version."\n";
            $this->_return .= "\nsteps: ".$steps." {$direction}\n";
        }
        // If we are not at the bottom then adjust our index (to satisfy array_slice)
        if ($current_index == -1 && $direction === 'down') {
            $available = [];
        } else {
            if ($direction === 'up') {
                $current_index += 1;
            } else {
                $current_index += $steps;
            }
            // check to see if we have enough migrations to run - the user
            // might have asked to run more than we have available
            $available = \array_slice($migrations, $current_index, $steps);
        }
        $target = \end($available);
        if ($this->_debug == \true) {
            $this->_return .= "\n------------- TARGET ------------------\n";
            $this->_return .= \print_r($target, \true);
        }
        $this->prepare_to_migrate(isset($target['version']) ? $target['version'] : null, $direction);
    }

    /**
     * Prepare to do a migration
     *
     * @param  string  $destination  version to migrate to
     * @param  $string  $direction direction to migrate to 'up'/'down'
     */
    private function prepare_to_migrate($destination, $direction)
    {
        try {
            $this->_return .= "\tMigrating ".\strtoupper($direction);
            if (! \is_null($destination)) {
                $this->_return .= " to: {$destination}\n";
            } else {
                $this->_return .= ":\n";
            }
            $migrations = $this->_migrator_util->get_runnable_migrations($this->_migratorDirs, $direction, $destination);
            if (\count($migrations) == 0) {
                $this->_return .= "\nNo relevant migrations to run. Exiting...\n";

                return;
            }
            $result = $this->run_migrations($migrations, $direction, $destination);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Run migrations
     *
     * @param  array  $migrations  nigrations to run
     * @param  $string  $target_method direction to migrate to 'up'/'down'
     * @param  string  $destination  version to migrate to
     * @return array
     */
    private function run_migrations($migrations, $target_method, $destination)
    {
        $last_version = -1;
        foreach ($migrations as $file) {
            $full_path = $this->_migratorDirs[$file['module']].\DIRECTORY_SEPARATOR.$file['file'];
            if (\is_file($full_path) && \is_readable($full_path)) {
                require_once $full_path;
                $klass = \YoastSEO_Vendor\Ruckusing_Util_Naming::class_from_migration_file($file['file']);
                $obj = new $klass($this->_adapter);
                $start = $this->start_timer();
                try {
                    //start transaction
                    $this->_adapter->start_transaction();
                    $result = $obj->{$target_method}();
                    //successfully ran migration, update our version and commit
                    $this->_migrator_util->resolve_current_version($file['version'], $target_method);
                    $this->_adapter->commit_transaction();
                } catch (\YoastSEO_Vendor\Ruckusing_Exception $e) {
                    $this->_adapter->rollback_transaction();
                    //wrap the caught exception in our own
                    throw new \YoastSEO_Vendor\Ruckusing_Exception(\sprintf('%s - %s', $file['class'], $e->getMessage()), \YoastSEO_Vendor\Ruckusing_Exception::MIGRATION_FAILED);
                }
                $end = $this->end_timer();
                $diff = $this->diff_timer($start, $end);
                $this->_return .= \sprintf("========= %s ======== (%.2f)\n", $file['class'], $diff);
                $last_version = $file['version'];
                $exec = \true;
            }
        }
        //update the schema info
        $result = ['last_version' => $last_version];

        return $result;
    }

    /**
     * Start Timer
     *
     * @return int
     */
    private function start_timer()
    {
        return \microtime(\true);
    }

    /**
     * End Timer
     *
     * @return int
     */
    private function end_timer()
    {
        return \microtime(\true);
    }

    /**
     * Calculate the time difference
     *
     * @param  int  $s  the start time
     * @param  int  $e  the end time
     * @return int
     */
    private function diff_timer($s, $e)
    {
        return $e - $s;
    }

    /**
     * Check the environment and create the migration dir if it doesn't exists
     */
    private function verify_environment()
    {
        if (! $this->_adapter->table_exists($this->_adapter->get_schema_version_table_name())) {
            $this->_return .= "\n\tSchema version table does not exist. Auto-creating.";
            $this->auto_create_schema_info_table();
        }
        $this->_migratorDirs = $this->get_framework()->migrations_directories();
        // create the migrations directory if it doesnt exist
        foreach ($this->_migratorDirs as $name => $path) {
            if (! \is_dir($path)) {
                $this->_return .= \sprintf("\n\tMigrations directory (%s) doesn't exist, attempting to create.", $path);
                if (\mkdir($path, 0755, \true) === \FALSE) {
                    $this->_return .= \sprintf("\n\tUnable to create migrations directory at %s, check permissions?", $path);
                } else {
                    $this->_return .= \sprintf("\n\tCreated OK");
                }
            }
        }
    }

    /**
     * Create the schema
     *
     * @return bool
     */
    private function auto_create_schema_info_table()
    {
        try {
            $this->_return .= \sprintf("\n\tCreating schema version table: %s", $this->_adapter->get_schema_version_table_name()."\n\n");
            $this->_adapter->create_schema_version_table();

            return \true;
        } catch (\Exception $e) {
            throw new \YoastSEO_Vendor\Ruckusing_Exception("\nError auto-creating 'schema_info' table: ".$e->getMessage()."\n\n", \YoastSEO_Vendor\Ruckusing_Exception::MIGRATION_FAILED);
        }
    }

    /**
     * Return the usage of the task
     *
     * @return string
     */
    public function help()
    {
        $output = <<<USAGE

\tTask: db:migrate [VERSION]

\tThe primary purpose of the framework is to run migrations, and the
\texecution of migrations is all handled by just a regular ol' task.

\tVERSION can be specified to go up (or down) to a specific
\tversion, based on the current version. If not specified,
\tall migrations greater than the current database version
\twill be executed.

\tExample A: The database is fresh and empty, assuming there
\tare 5 actual migrations, but only the first two should be run.

\t\tphp {$_SERVER['argv'][0]} db:migrate VERSION=20101006114707

\tExample B: The current version of the DB is 20101006114707
\tand we want to go down to 20100921114643

\t\tphp {$_SERVER['argv'][0]} db:migrate VERSION=20100921114643

\tExample C: You can also use relative number of revisions
\t(positive migrate up, negative migrate down).

\t\tphp {$_SERVER['argv'][0]} db:migrate VERSION=-2

USAGE;

        return $output;
    }
}
