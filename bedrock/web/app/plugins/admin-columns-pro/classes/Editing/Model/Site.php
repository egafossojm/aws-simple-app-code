<?php

namespace ACP\Editing\Model;

use ACP\Editing\Model;

abstract class Site extends Model
{
    /**
     * @return bool
     */
    protected function update_site($id, $args)
    {
        return update_blog_details($id, $args);
    }
}
