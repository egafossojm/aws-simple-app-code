<?php
/**
 * WPSEO plugin file.
 */
if (! interface_exists('WPSEO_Graph_Piece')) {
    /**
     * An interface for registering Schema Graph Pieces.
     *
     * @since 10.2
     */
    interface WPSEO_Graph_Piece
    {
        /**
         * Add your piece of the graph.
         *
         * @return array|bool $graph A graph piece on success, false on failure.
         */
        public function generate();

        /**
         * Determines whether or not a piece should be added to the graph.
         *
         * @return bool
         */
        public function is_needed();
    }
}
