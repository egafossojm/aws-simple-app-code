<?php

namespace ACP;

use AC\Registrable;
use WP_Term_Query;

final class TermQueryInformation implements Registrable
{
    const KEY = 'ac_is_main_term_query';

    public function register()
    {
        add_action('parse_term_query', [$this, 'check_if_main_query'], 1);
    }

    public function check_if_main_query(WP_Term_Query $query)
    {
        if (! isset($query->query_vars['echo']) && ($query->query_vars['fields'] === 'all' || $query->query_vars['fields'] === 'count')) {
            $this->set_main_query($query);
        }
    }

    private function set_main_query(WP_Term_Query $query)
    {
        $query->query_vars[self::KEY] = true;
    }

    /**
     * @return bool
     */
    public function is_main_query(WP_Term_Query $query)
    {
        return isset($query->query_vars[self::KEY]) && $query->query_vars[self::KEY];
    }
}
