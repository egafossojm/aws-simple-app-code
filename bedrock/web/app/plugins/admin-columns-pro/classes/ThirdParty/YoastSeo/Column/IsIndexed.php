<?php

namespace ACP\ThirdParty\YoastSeo\Column;

use AC\Column;
use ACP\Editing;
use ACP\Search;
use ACP\ThirdParty\YoastSeo;

class IsIndexed extends Column\Meta implements Editing\Editable, Search\Searchable
{
    public function __construct()
    {
        $this->set_group('yoast-seo');
        $this->set_label('Is Indexed');
        $this->set_type('column-yoast_is_indexed');
    }

    public function get_value($id)
    {
        $raw_value = (int) $this->get_raw_value($id);

        switch ($raw_value) {
            case 0:
                return sprintf('%s <span style="color: #ccc;">%s</span>',
                    ac_helper()->icon->yes_or_no($this->get_default_post_type_index()),
                    ac_helper()->icon->dashicon(['icon' => 'info', 'class' => 'grey', 'tooltip' => __('Implicit', 'codepress-admin-columns')])
                );
            case 1:
                return ac_helper()->icon->yes();
            case 2:
                return ac_helper()->icon->no();
        }
    }

    private function get_default_post_type_index()
    {
        if (! class_exists('\WPSEO_Post_Type', false)) {
            return false;
        }

        return \WPSEO_Post_Type::is_post_type_indexable($this->get_post_type());
    }

    public function get_meta_key()
    {
        return '_yoast_wpseo_meta-robots-noindex';
    }

    public function editing()
    {
        return new YoastSeo\Editing\IsIndexed($this, $this->get_default_post_type_index());
    }

    public function search()
    {
        $null_value = $this->get_default_post_type_index() ? 1 : 2;

        return new YoastSeo\Search\IsIndexed($this->get_meta_key(), $null_value);
    }
}
