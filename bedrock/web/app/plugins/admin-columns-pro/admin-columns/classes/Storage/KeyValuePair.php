<?php

namespace AC\Storage;

interface KeyValuePair
{
    /**
     * @return mixed
     */
    public function get(array $args = []);

    /**
     * @param  mixed  $value
     * @return bool
     */
    public function save($value);

    /**
     * @return bool
     */
    public function delete();
}
