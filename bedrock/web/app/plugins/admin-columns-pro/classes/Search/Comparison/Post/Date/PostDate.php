<?php

namespace ACP\Search\Comparison\Post\Date;

use ACP\Search\Comparison\Post;
use ACP\Search\Operators;

class PostDate extends Post\Date
{
    public function operators()
    {
        return new Operators([
            Operators::EQ,
            Operators::GT,
            Operators::LT,
            Operators::BETWEEN,
            Operators::TODAY,
            Operators::PAST,
            Operators::FUTURE,
        ], false);
    }

    public function get_field()
    {
        return 'post_date';
    }
}
