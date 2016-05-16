<?php

return [
 	'search/?'	=> 'main/search',
	'inst/?' 		=> 'main/inst',
	'tech/?'  	=> 'main/tech',
	'feedback'  => 'main/feedback',
	'about' 	  => 'main/about',
		// reg/auth/logout
	'login'	        	=> 'security/login',
	'signup'	        => 'security/signup',
	'logout'	        => 'security/logout',
	'forgot-password' => 'security/forgot-password',
		//ajax
	'getlink' => 'ajax/getlink',
		//regions
	'sumy' 				  => 'main/region',
	'kiev' 				  => 'main/region',
	'donetsk' 			=> 'main/region',
	'lviv' 				  => 'main/region',
	'odessa' 			  => 'main/region',
	'volyn' 				=> 'main/region',
	'vinnytsia' 		=> 'main/region',
	'dnipropetrovsk'=> 'main/region',
	'zhytomyr' 			=> 'main/region',
	'zakarpattia' 	=> 'main/region',
	'zaporizhia' 		=> 'main/region',
	'ivano-frankivsk' => 'main/region',
	'kirovohrad' 		=> 'main/region',
	'crimea' 			  => 'main/region',
	'lugansk' 			=> 'main/region',
	'mykolaiv' 			=> 'main/region',
	'poltava' 			=> 'main/region',
	'rivne' 				=> 'main/region',
	'ternopil' 			=> 'main/region',
	'kharkiv' 			=> 'main/region',
	'herson' 			  => 'main/region',
	'khmelnytsky' 	=> 'main/region',
	'cherkasy' 			=> 'main/region',
	'chernigov' 		=> 'main/region',
	'chernivtsi' 		=> 'main/region',
		//directions
	'directions/?<instance:\w*>/?<id:\d*>/?' => 'main/directions',
		// selected institutions
	'inst/<id:\d+>/?' 	=> 'main/iselected',
	'tech/<id:\d+>/?' 	=> 'main/tselected',
	'<en_title:\w+>' 	  => 'main/iselected',
];
