<?php
/**
 * WPSEO plugin file.
 */

/**
 * Represents the state of the table being accessible.
 */
class WPSEO_Link_Table_Accessible
{
    /**
     * @var string
     */
    const ACCESSIBLE = '0';

    /**
     * @var string
     */
    const INACCESSBILE = '1';

    /**
     * Checks if the given table name exists.
     *
     * @return bool True when table is accessible.
     */
    public static function is_accessible()
    {
        $value = get_transient(self::transient_name());

        // If the value is not set, check the table.
        if ($value === false) {
            return self::check_table();
        }

        return $value === self::ACCESSIBLE;
    }

    /**
     * Sets the transient value to 1, to indicate the table is not accessible.
     *
     * @return void
     */
    public static function set_inaccessible()
    {
        set_transient(self::transient_name(), self::INACCESSBILE, HOUR_IN_SECONDS);
    }

    /**
     * Removes the transient.
     *
     * @return void
     */
    public static function cleanup()
    {
        delete_transient(self::transient_name());
    }

    /**
     * Sets the transient value to 0, to indicate the table is accessible.
     *
     * @return void
     */
    protected static function set_accessible()
    {
        /*
         * Prefer to set a 0 timeout, but if the timeout was set before WordPress will not delete the transient
         * correctly when overridden with a zero value.
         *
         * Setting a YEAR_IN_SECONDS instead.
         */
        set_transient(self::transient_name(), self::ACCESSIBLE, YEAR_IN_SECONDS);
    }

    /**
     * Checks if the table exists if not, set the transient to indicate the inaccessible table.
     *
     * @return bool True if table is accessible.
     */
    protected static function check_table()
    {
        global $wpdb;

        $storage = new WPSEO_Link_Storage;
        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $storage->get_table_name());
        if ($wpdb->get_var($query) !== $storage->get_table_name()) {
            self::set_inaccessible();

            return false;
        }

        self::set_accessible();

        return true;
    }

    /**
     * Returns the name of the transient.
     *
     * @return string The name of the transient to use.
     */
    protected static function transient_name()
    {
        return 'wpseo_link_table_inaccessible';
    }
}
