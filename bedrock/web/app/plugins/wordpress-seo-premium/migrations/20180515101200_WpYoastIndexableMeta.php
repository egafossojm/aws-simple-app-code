<?php
/**
 * Class WpYoastIndexableMeta
 */

use Yoast\WP\Free\Yoast_Model;
use YoastSEO_Vendor\Ruckusing_Migration_Base;

/**
 * Indexable meta migration.
 */
class WpYoastIndexableMeta extends Ruckusing_Migration_Base
{
    /**
     * Migration up.
     */
    public function up()
    {
        $table_name = $this->get_table_name();

        $indexable_meta_table = $this->create_table($table_name);
        $indexable_meta_table->column(
            'indexable_id',
            'integer',
            [
                'unsigned' => true,
                'limit' => 11,
            ]
        );
        $indexable_meta_table->column('meta_key', 'string', ['limit' => 191]);
        $indexable_meta_table->column(
            'meta_value',
            'text',
            [
                'null' => true,
                'limit' => 191,
            ]
        );

        // Execute the SQL to create the table.
        $indexable_meta_table->finish();

        $this->add_index(
            $table_name,
            [
                'indexable_id',
                'meta_key',
            ],
            [
                'name' => 'indexable_meta',
                'unique' => true,
            ]
        );

        $this->add_timestamps($table_name);
    }

    /**
     * Migration down.
     */
    public function down()
    {
        $this->drop_table($this->get_table_name());
    }

    /**
     * Retrieves the table name to use.
     *
     * @return string The table name to use.
     */
    protected function get_table_name()
    {
        return Yoast_Model::get_table_name('Indexable_Meta');
    }
}
