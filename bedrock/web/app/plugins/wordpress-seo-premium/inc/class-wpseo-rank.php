<?php
/**
 * WPSEO plugin file.
 */

/**
 * Holder for SEO Rank information.
 */
class WPSEO_Rank
{
    /**
     * @var string
     */
    const BAD = 'bad';

    /**
     * @var string
     */
    const OK = 'ok';

    /**
     * @var string
     */
    const GOOD = 'good';

    /**
     * @var string
     */
    const NO_FOCUS = 'na';

    /**
     * @var string
     */
    const NO_INDEX = 'noindex';

    /**
     * All possible ranks.
     *
     * @var array
     */
    protected static $ranks = [
        self::BAD,
        self::OK,
        self::GOOD,
        self::NO_FOCUS,
        self::NO_INDEX,
    ];

    /**
     * Holds the translation from seo score slug to actual score range.
     *
     * @var array
     */
    protected static $ranges = [
        self::NO_FOCUS => [
            'start' => 0,
            'end' => 0,
        ],
        self::BAD => [
            'start' => 1,
            'end' => 40,
        ],
        self::OK => [
            'start' => 41,
            'end' => 70,
        ],
        self::GOOD => [
            'start' => 71,
            'end' => 100,
        ],
    ];

    /**
     * @var int
     */
    protected $rank;

    /**
     * @param  int  $rank  The actual rank.
     */
    public function __construct($rank)
    {
        if (! in_array($rank, self::$ranks, true)) {
            $rank = self::BAD;
        }

        $this->rank = $rank;
    }

    /**
     * Returns the saved rank for this rank.
     *
     * @return string
     */
    public function get_rank()
    {
        return $this->rank;
    }

    /**
     * Returns a CSS class for this rank.
     *
     * @return string
     */
    public function get_css_class()
    {
        $labels = [
            self::NO_FOCUS => 'na',
            self::NO_INDEX => 'noindex',
            self::BAD => 'bad',
            self::OK => 'ok',
            self::GOOD => 'good',
        ];

        return $labels[$this->rank];
    }

    /**
     * Returns a label for this rank.
     *
     * @return string
     */
    public function get_label()
    {
        $labels = [
            self::NO_FOCUS => __('Not available', 'wordpress-seo'),
            self::NO_INDEX => __('No index', 'wordpress-seo'),
            self::BAD => __('Needs improvement', 'wordpress-seo'),
            self::OK => __('OK', 'wordpress-seo'),
            self::GOOD => __('Good', 'wordpress-seo'),
        ];

        return $labels[$this->rank];
    }

    /**
     * Returns a label for use in a drop down.
     *
     * @return mixed
     */
    public function get_drop_down_label()
    {
        $labels = [
            self::NO_FOCUS => sprintf(
                /* translators: %s expands to the SEO score */
                __('SEO: %s', 'wordpress-seo'),
                __('No Focus Keyphrase', 'wordpress-seo')
            ),
            self::BAD => sprintf(
                /* translators: %s expands to the SEO score */
                __('SEO: %s', 'wordpress-seo'),
                __('Needs improvement', 'wordpress-seo')
            ),
            self::OK => sprintf(
                /* translators: %s expands to the SEO score */
                __('SEO: %s', 'wordpress-seo'),
                __('OK', 'wordpress-seo')
            ),
            self::GOOD => sprintf(
                /* translators: %s expands to the SEO score */
                __('SEO: %s', 'wordpress-seo'),
                __('Good', 'wordpress-seo')
            ),
            self::NO_INDEX => sprintf(
                /* translators: %s expands to the SEO score */
                __('SEO: %s', 'wordpress-seo'),
                __('Post Noindexed', 'wordpress-seo')
            ),
        ];

        return $labels[$this->rank];
    }

    /**
     * Gets the drop down labels for the readability score.
     *
     * @return string The readability rank label.
     */
    public function get_drop_down_readability_labels()
    {
        $labels = [
            self::BAD => sprintf(
                /* translators: %s expands to the readability score */
                __('Readability: %s', 'wordpress-seo'),
                __('Needs improvement', 'wordpress-seo')
            ),
            self::OK => sprintf(
                /* translators: %s expands to the readability score */
                __('Readability: %s', 'wordpress-seo'),
                __('OK', 'wordpress-seo')
            ),
            self::GOOD => sprintf(
                /* translators: %s expands to the readability score */
                __('Readability: %s', 'wordpress-seo'),
                __('Good', 'wordpress-seo')
            ),
        ];

        return $labels[$this->rank];
    }

    /**
     * @return int The starting score for this rank.
     */
    public function get_starting_score()
    {
        // No index does not have a starting score.
        if ($this->rank === self::NO_INDEX) {
            return -1;
        }

        return self::$ranges[$this->rank]['start'];
    }

    /**
     * @return int The end score for this rank.
     */
    public function get_end_score()
    {
        // No index does not have an end score.
        if ($this->rank === self::NO_INDEX) {
            return -1;
        }

        return self::$ranges[$this->rank]['end'];
    }

    /**
     * Returns a rank for a specific numeric score.
     *
     * @param  int  $score  The score to determine a rank for.
     * @return self
     */
    public static function from_numeric_score($score)
    {
        // Set up the default value.
        $rank = new self(self::BAD);

        foreach (self::$ranges as $rank_index => $range) {
            if ($range['start'] <= $score && $score <= $range['end']) {
                $rank = new self($rank_index);
                break;
            }
        }

        return $rank;
    }

    /**
     * Returns a list of all possible SEO Ranks.
     *
     * @return WPSEO_Rank[]
     */
    public static function get_all_ranks()
    {
        return array_map(['WPSEO_Rank', 'create_rank'], self::$ranks);
    }

    /**
     * Returns a list of all possible Readability Ranks.
     *
     * @return WPSEO_Rank[]
     */
    public static function get_all_readability_ranks()
    {
        return array_map(['WPSEO_Rank', 'create_rank'], [self::BAD, self::OK, self::GOOD]);
    }

    /**
     * Converts a numeric rank into a WPSEO_Rank object, for use in functional array_* functions.
     *
     * @param  string  $rank  SEO Rank.
     * @return WPSEO_Rank
     */
    private static function create_rank($rank)
    {
        return new self($rank);
    }
}
