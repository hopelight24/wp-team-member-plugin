<?php

class TeamMember {

	const VERSION = '1.0.0';
	const PLUGIN_SLUG = 'team-member';

	protected $registration_handler;

	public function __construct( $registration_handler ) {
		$this->registration_handler = $registration_handler;
	}

	public function activate() {
		$this->registration_handler->register();
		flush_rewrite_rules();
	}

	public function deactivate() {
		flush_rewrite_rules();
	}

}