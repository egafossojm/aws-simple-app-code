<?php
/**
 * WPSEO plugin file.
 */

/**
 * Class WPSEO_Help_Center_Item.
 */
class WPSEO_Help_Center_Item
{
    /**
     * Identifier for this tab.
     *
     * @var string
     */
    private $identifier;

    /**
     * Label to display.
     *
     * @var string
     */
    private $label;

    /**
     * The dashicon classname to display in front of the label.
     *
     * @var string
     */
    private $dashicon;

    /**
     * Optional arguments.
     *
     * @var array
     */
    private $args = [];

    /**
     * WPSEO_Help_Center_Item constructor.
     *
     * @param  string  $identifier  Unique identifier for this tab.
     * @param  string  $label  Label to display.
     * @param  array  $args  Optional. Settings for this tab.
     * @param  string  $dashicon  Optional. The classname of the dahsicon to put in front of the label.
     */
    public function __construct($identifier, $label, $args = [], $dashicon = '')
    {
        $this->identifier = $identifier;
        $this->label = $label;
        $this->dashicon = $dashicon;
        $this->args = $args;
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function get_label()
    {
        return $this->label;
    }

    /**
     * Get the identifier.
     *
     * @return string
     */
    public function get_identifier()
    {
        return $this->identifier;
    }

    /**
     * Get the dashicon.
     *
     * @return string
     */
    public function get_dashicon()
    {
        return $this->dashicon;
    }

    /**
     * Get the content of this tab.
     *
     * @return mixed|string
     */
    public function get_content()
    {
        if (! empty($this->args['content'])) {
            return $this->args['content'];
        }

        if (! empty($this->args['callback'])) {
            return call_user_func_array($this->args['callback'], [$this]);
        }

        if (! empty($this->args['view'])) {
            $view = $this->args['view'];
            if (substr($view, -4) === '.php') {
                $view = substr($view, 0, -4);
            }

            if (! empty($this->args['view_arguments'])) {
                extract($this->args['view_arguments']);
            }

            include WPSEO_PATH.'admin/views/'.$view.'.php';
        }

        return '';
    }
}
