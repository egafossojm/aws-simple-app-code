<?php

namespace AC\Storage;

use AC\Expirable;
use Exception;
use LogicException;

final class Timestamp implements Expirable, KeyValuePair
{
    /**
     * @var KeyValuePair
     */
    private $storage;

    public function __construct(KeyValuePair $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param  int|null  $time
     * @return bool
     */
    public function is_expired($time = null)
    {
        if ($time === null) {
            $time = time();
        }

        return $time > (int) $this->get();
    }

    /**
     * @param  int  $value
     * @return bool
     */
    public function validate($value)
    {
        return preg_match('/^[1-9][0-9]*$/', $value);
    }

    /**
     * @return mixed
     */
    public function get(array $args = [])
    {
        return $this->storage->get($args);
    }

    public function delete()
    {
        return $this->storage->delete();
    }

    /**
     * @param  int  $value
     * @return bool
     *
     * @throws Exception
     */
    public function save($value)
    {
        if (! $this->validate($value)) {
            throw new LogicException('Value needs to be a positive integer.');
        }

        return $this->storage->save($value);
    }
}
