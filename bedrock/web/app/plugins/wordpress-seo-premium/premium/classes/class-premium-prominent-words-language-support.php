<?php

/**
 * Class WPSEO_Premium_Prominent_Words_Language_Support
 */
class WPSEO_Premium_Prominent_Words_Language_Support
{
    /**
     * @var array List of supported languages.
     */
    protected $supported_languages = ['en', 'de', 'nl', 'es', 'fr', 'it'];

    /**
     * Returns whether the current language is supported for the link suggestions.
     *
     * @param  string  $language  The language to check for.
     * @return bool Whether the current language is supported for the link suggestions.
     */
    public function is_language_supported($language)
    {
        return in_array($language, $this->supported_languages, true);
    }
}
