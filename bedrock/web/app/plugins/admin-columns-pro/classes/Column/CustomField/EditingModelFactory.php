<?php

namespace ACP\Column\CustomField;

use AC\Column;
use ACP\Editing\Model;

class EditingModelFactory
{
    /**
     * @param  string  $type
     * @return Model
     */
    public static function create($type, Column\CustomField $column)
    {

        switch ($type) {

            case 'array':
                return new Model\Disabled($column);

            case 'checkmark':
                return new Model\CustomField\Checkmark($column);

            case 'color':
                return new Model\CustomField\Color($column);

            case 'count':
                return new Model\Disabled($column);

            case 'date':
                return new Model\CustomField\Date($column);

            case 'excerpt':
                return new Model\CustomField\Text($column);

            case 'has_content':
                return new Model\Disabled($column);

            case 'image':
                return new Model\CustomField\Image($column);

            case 'library_id':
                return new Model\CustomField\Media($column);

            case 'link':
                return new Model\CustomField($column);

            case 'numeric':
                return new Model\CustomField\Numeric($column);

            case 'title_by_id':
                return new Model\CustomField\Post($column);

            case 'user_by_id':
                return new Model\CustomField\User($column);

            default:
                return new Model\CustomField\Text($column);
        }
    }
}
