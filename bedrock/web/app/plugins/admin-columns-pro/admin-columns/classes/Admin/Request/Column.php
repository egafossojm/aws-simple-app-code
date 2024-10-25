<?php

namespace AC\Admin\Request;

use AC;
use AC\Column\Placeholder;
use AC\ListScreenFactory;
use AC\View;

abstract class Column extends AC\Admin\Request\Handler
{
    /** @var AC\ListScreen */
    protected $list_screen;

    /**
     * @return AC\Column
     */
    abstract public function get_column();

    public function request(AC\Request $request)
    {
        $this->list_screen = ListScreenFactory::create($request->get('list_screen'), $request->get('layout'));

        if (! $this->list_screen) {
            wp_die();
        }

        $column = $this->get_column();

        if (! $column) {
            wp_send_json_error([
                'type' => 'message',
                'error' => sprintf(__('Please visit the %s screen once to load all available columns', 'codepress-admin-columns'), ac_helper()->html->link($this->list_screen->get_screen_link(), $this->list_screen->get_label())),
            ]);
        }

        $current_original_columns = (array) $request->get('current_original_columns', []);

        // Not cloneable message
        if (in_array($column->get_type(), $current_original_columns)) {
            wp_send_json_error([
                'type' => 'message',
                'error' => sprintf(
                    __('%s column is already present and can not be duplicated.', 'codepress-admin-columns'),
                    '<strong>'.$column->get_label().'</strong>'),
            ]);
        }

        // Placeholder message
        if ($column instanceof Placeholder) {
            wp_send_json_error([
                'type' => 'message',
                'error' => $column->get_message(),
            ]);
        }

        wp_send_json_success($this->render_column($column));
    }

    /**
     * @return string
     */
    private function render_column(AC\Column $column)
    {
        $view = new View([
            'column' => $column,
        ]);

        $view->set_template('admin/edit-column');

        return $view->render();
    }
}
