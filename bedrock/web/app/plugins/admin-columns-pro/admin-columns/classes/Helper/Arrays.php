<?php

namespace AC\Helper;

class Arrays
{
    /**
     * @param  mixed  $array
     * @return bool
     */
    public function is_associative($array)
    {
        if (! is_array($array)) {
            return false;
        }

        foreach ($array as $key => $value) {
            if (is_string($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string  $glue
     * @return string
     */
    public function implode_associative(array $array, $glue)
    {
        $result = [];

        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $result[] = sprintf('%s[ %s ]', $key, $this->implode_associative($item, $glue));
            } elseif (is_numeric($key)) {
                $result[] = $this->wrap_boolean_in_italic($item);
            } else {
                $result[] = sprintf('%s: %s', $key, $this->wrap_boolean_in_italic($item));
            }
        }

        return implode($glue, $result);
    }

    private function wrap_boolean_in_italic($value)
    {
        if (is_bool($value)) {
            $value = sprintf('<em>%s</em>', $value ? 'true' : 'false');
        }

        return $value;
    }

    /**
     * Implode for multi dimensional array
     *
     * @param  string  $glue
     * @param  string|array  $pieces
     * @return string Imploded array
     *
     * @since 3.0
     */
    public function implode_recursive($glue, $pieces)
    {
        if (is_array($pieces)) {
            foreach ($pieces as $r_pieces) {
                if (is_array($r_pieces)) {
                    $retVal[] = $this->implode_recursive($glue, $r_pieces);
                } else {
                    $retVal[] = $r_pieces;
                }
            }
            if (isset($retVal) && is_array($retVal)) {
                return implode($glue, $retVal);
            }
        }

        if (is_scalar($pieces)) {
            return $pieces;
        }

        return false;
    }

    /**
     * Replace a single key in an associative array
     *
     * @param  array  $input  Input array.
     * @param  int|string  $old_key  Key to replace.
     * @param  int|string  $new_key  Key to replace $old_key with
     * @return array
     *
     * @since 2.2.7
     */
    public function key_replace($input, $old_key, $new_key)
    {
        $keys = array_keys($input);
        $old_key_pos = array_search($old_key, $keys);

        if ($old_key_pos === false) {
            return $input;
        }

        $keys[$old_key_pos] = $new_key;

        return array_combine($keys, array_values($input));
    }

    /**
     * Indents any object as long as it has a unique id and that of its parent.
     *
     * @param  array  $array
     * @param  int  $parentId
     * @param  string  $parentKey
     * @param  string  $selfKey
     * @param  string  $childrenKey
     * @return array Indented Array
     *
     * @since 1.0
     */
    public function indent($array, $parentId = 0, $parentKey = 'post_parent', $selfKey = 'ID', $childrenKey = 'children')
    {
        $indent = [];

        $i = 0;
        foreach ($array as $v) {
            if ($parentId == $v->$parentKey) {
                $indent[$i] = $v;
                $indent[$i]->$childrenKey = $this->indent($array, $v->$selfKey, $parentKey, $selfKey);

                $i++;
            }
        }

        return $indent;
    }

    /**
     * Remove empty values from array
     *
     * @param  array  $array
     * @return array
     */
    public function filter($array)
    {
        return array_filter($array, [ac_helper()->string, 'is_not_empty']);
    }

    /**
     * Insert element into array at specific position
     *
     * @param  array  $array
     * @param  array  $insert
     * @param  string  $position
     * @return array
     */
    public function insert($array, $insert, $position)
    {
        $new = [];
        foreach ($array as $key => $value) {
            $new[$key] = $value;
            if ($key === $position) {
                $new = array_merge($new, $insert);
            }

        }

        return $new;
    }

    /**
     * Get duplicates from array
     *
     *
     * @return array
     */
    public function get_duplicates(array $array)
    {
        return array_intersect($array, array_unique(array_diff_key($array, array_unique($array))));
    }

    /**
     * Returns all integers from an array or comma separated string
     *
     * @param  array|string  $mixed
     * @return int[]
     */
    public function get_integers_from_mixed($mixed)
    {
        $string = ac_helper()->array->implode_recursive(',', $mixed);

        return ac_helper()->string->string_to_array_integers($string);
    }
}
