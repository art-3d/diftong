<?php 

return [
	'class' 			=> 'nodge\eauth\EAuth',
	'popup'	 	=> true,
	'cache' 		=> false,
	'cacheExpire'	=> 0,
	'httpClient'		=> array(
	      // uncomment this to use streams in safe_mode
	      //'useStreamsFallback' => true,
	),
	'services' => array(
		'twitter' => array(
			'class'	=> 'nodge\eauth\services\TwitterOAuth1Service',
			'key'	=> 'CPGqYWmjIVj4lkj1nbJTCAkiM',
			'secret'	=> 'E4QK8K0WgsFUH6Ue2sdAkmdaEwDKaMMbZkSX3snl2QgcGoKeOb',
		),
		'github' => array(
			'class'			=> 'nodge\eauth\services\GitHubOAuth2Service',
			'clientId'		=> '9351f85caf60b4bc2f2b',
			'clientSecret'	=> 'e08b5485cb7b8830b68170a94101ec89a03d18f0', 	
		),
              'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
              ),
      )
];