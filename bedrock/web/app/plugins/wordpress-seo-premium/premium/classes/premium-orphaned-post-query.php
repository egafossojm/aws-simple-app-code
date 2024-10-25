<?php
/**
 * WPSEO Premium plugin file.
 */

/**
 * Represents the orphaned post query methods.
 */
class WPSEO_Premium_Orphaned_Post_Query
{
    /**
     * Returns the total number of orphaned items for the given post types.
     *
     * @param  array  $post_types  The post types to get the counts for.
     * @return array The counts for all post types.
     */
    public static function get_counts(array $post_types)
    {
        global $wpdb;

        $post_type_counts = array_fill_keys($post_types, 0);
        $subquery = self::get_orphaned_content_query();

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT COUNT( ID ) as total_orphaned, post_type
					FROM {$wpdb->posts}
					WHERE
						ID IN ( ".$subquery." )
						AND post_status = 'publish'
						AND post_type IN ( ".implode(',', array_fill(0, count($post_types), '%s')).' )
					GROUP BY post_type',
                $post_types
            )
        );

        foreach ($results as $result) {
            $post_type_counts[$result->post_type] = (int) $result->total_orphaned;
        }

        return $post_type_counts;
    }

    /**
     * Returns a query to retrieve the object ids from the records with an incoming link count of 0.
     *
     * @return string Query for get all objects with an incoming link count of 0 from the DB.
     */
    public static function get_orphaned_content_query()
    {
        static $query;

        if ($query === null) {
            $storage = new WPSEO_Meta_Storage;
            $query = sprintf(
                'SELECT object_id FROM %1$s WHERE %1$s.incoming_link_count = 0',
                $storage->get_table_name()
            );

            $frontpage_id = self::get_frontpage_id();
            if ($frontpage_id) {
                $query .= " AND object_id != '{ $frontpage_id }' ";
            }
        }

        return $query;
    }

    /**
     * Returns all the object ids from the records with an incoming link count of 0.
     *
     * @return array Array with the object ids.
     */
    public static function get_orphaned_object_ids()
    {
        global $wpdb;

        $storage = new WPSEO_Meta_Storage;
        $query = 'SELECT object_id FROM '.$storage->get_table_name().' WHERE incoming_link_count = 0';

        // phpcs:ignore WordPress.DB.PreparedSQL -- See above, query is fine without preparing.
        $object_ids = $wpdb->get_col($query);
        $object_ids = self::remove_frontpage_id($object_ids);

        return $object_ids;
    }

    /**
     * Removes the frontpage id from orphaned id's when the frontpage is a static page.
     *
     * @param  array  $object_ids  The orphaned object ids.
     * @return array The orphaned object ids, without frontpage id.
     */
    protected static function remove_frontpage_id($object_ids)
    {
        // When the frontpage is a static page, remove it from the object ids.
        if (get_option('show_on_front') !== 'page') {
            return $object_ids;
        }

        $frontpage_id = get_option('page_on_front');

        // If the frontpage ID exists in the list, remove it.
        $object_id_key = array_search($frontpage_id, $object_ids, true);
        if ($object_id_key !== false) {
            unset($object_ids[$object_id_key]);
        }

        return $object_ids;
    }

    /**
     * Retrieves the frontpage id when set, otherwise null.
     *
     * @return int|null The frontpage id when set.
     */
    protected static function get_frontpage_id()
    {
        if (get_option('show_on_front') !== 'page') {
            return null;
        }

        $page_on_front = get_option('page_on_front', null);
        if (empty($page_on_front)) {
            return null;
        }

        return (int) $page_on_front;
    }
}
