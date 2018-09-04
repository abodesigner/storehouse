<?php

	function lang( $phrase ) {
		static $lang = array(

			// Dasboard

			'HOME_ADMIN' 	=> 'Dashboard',
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 		=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS' 	    => 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 			=> 'Logs'
		);

		return $lang[$phrase];
	}
