<?php

class Location_Geo_Loader {

    /**
     * The array of actions.
     *
     */
    protected $actions;

    /**
     * The array of filters.
     *
     */
    protected $filters;

    /**
     * Initialize the actions and filters.
     *
     */
    public function __construct() {

        $this->actions = array();
        $this->filters = array();

    }

    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }

    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }

    private function add( $max_sb_hooks, $max_sb_hook, $max_sb_component, $max_sb_callback, $max_sb_priority, $max_sb_accepted_args ) {

        $max_sb_hooks[] = array(
            'hook'          => $max_sb_hook,
            'component'     => $max_sb_component,
            'callback'      => $max_sb_callback,
            'priority'      => $max_sb_priority,
            'accepted_args' => $max_sb_accepted_args
        );

        return $max_sb_hooks;

    }

    public function max_run() {

        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

    }

}