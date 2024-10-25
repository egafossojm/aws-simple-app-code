<?php

namespace AC;

use WP_Screen;

class Screen implements Registrable
{
    /**
     * @var WP_Screen
     */
    protected $screen;

    public function register()
    {
        add_action('current_screen', [$this, 'init']);
    }

    public function init(WP_Screen $screen)
    {
        $this->set_screen($screen);

        do_action('ac/screen', $this, $this->screen->id);
    }

    /**
     * @return bool
     */
    public function is_screen($id)
    {
        return $this->has_screen() && $this->get_screen()->id === $id;
    }

    /**
     * @return $this
     */
    public function set_screen(WP_Screen $screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * @return WP_Screen
     */
    public function get_screen()
    {
        return $this->screen;
    }

    /**
     * @return bool
     */
    public function has_screen()
    {
        return $this->screen instanceof WP_Screen;
    }

    /**
     * @return string
     */
    public function get_id()
    {
        return $this->screen->id;
    }

    /**
     * @return string
     */
    public function get_base()
    {
        return $this->screen->base;
    }

    /**
     * @return string
     */
    public function get_post_type()
    {
        return $this->screen->post_type;
    }

    /**
     * @return ListScreen|false
     */
    public function get_list_screen()
    {
        foreach (AC()->get_list_screens() as $list_screen) {
            if ($list_screen->is_current_screen($this->screen)) {
                return $list_screen;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function is_list_screen()
    {
        return $this->get_list_screen() !== false;
    }

    /**
     * Check if current screen is plugins screen
     *
     * @return bool
     */
    public function is_plugin_screen()
    {
        return $this->is_screen('plugins');
    }

    /**
     * @param  string|null  $slug
     * @return bool
     */
    public function is_admin_screen($slug = null)
    {
        if ($slug !== null) {
            return $this->is_main_admin_screen() && $slug === filter_input(INPUT_GET, 'tab');
        }

        return $this->is_main_admin_screen();
    }

    /**
     * @return bool
     */
    private function is_main_admin_screen()
    {
        return $this->get_id() === 'settings_page_'.Admin::PLUGIN_PAGE;
    }
}
