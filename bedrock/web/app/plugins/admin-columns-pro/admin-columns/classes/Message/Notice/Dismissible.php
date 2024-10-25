<?php

namespace AC\Message\Notice;

use AC\Ajax\Handler;
use AC\Ajax\NullHandler;
use AC\Message\Notice;
use AC\View;

class Dismissible extends Notice
{
    /**
     * @var Handler
     */
    protected $handler;

    /**
     * @param  string  $message
     */
    public function __construct($message, ?Handler $handler = null)
    {
        if ($handler === null) {
            $handler = new NullHandler;
        }

        $this->handler = $handler;

        parent::__construct($message);
    }

    public function render()
    {
        $data = [
            'message' => $this->message,
            'type' => $this->type,
            'id' => $this->id,
            'dismissible_callback' => $this->handler->get_params(),
        ];

        $view = new View($data);
        $view->set_template('message/notice/dismissible');

        return $view->render();
    }

    /**
     * Enqueue scripts & styles
     */
    public function enqueue_scripts()
    {
        parent::enqueue_scripts();

        wp_enqueue_script('ac-message', AC()->get_url().'assets/js/notice-dismissible.js', [], AC()->get_version(), true);
    }
}
