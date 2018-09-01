<?php

	function lang( $phrase ) {
		
		static $lang = array(

			'MESSAGE' => 'Welcome to arabic',
			'ADMIN'   => 'Adminstrator'
		);

			return $lang[$phrase];
	}