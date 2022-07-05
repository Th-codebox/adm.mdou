<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
    array(
        // Put front-end settings there
        // (for example, url rules).
		'components' => array(
			// uncomment the following to enable URLs in path-format
			'urlManager'=>array(
				'urlFormat'=>'path',
				'showScriptName'=>false,
				'rules'=>array(
//				  'gii'=>'gii',
//				  'gii/<controller:\w+>'=>'gii/<controller>',
//                  'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
                  'site/section/<id:\d+>'=>'site/section',
				),
			),
		),
    )
);
