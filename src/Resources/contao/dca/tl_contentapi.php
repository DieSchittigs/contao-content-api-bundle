<?php

/**
 * Table tl_contentapi
 */
$GLOBALS['TL_DCA']['tl_contentapi'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'			=> 'Table',
		'ctable'				=> array('tl_contentapi'),
		'closed'				=> true,
        'sql' => array
        (
            'keys' => array
            (
                'id'       => 'primary'
            )
        )
	),

	// Fields
	'fields' => array
	(
    	'id' => array
    	(
            'sql'           => "int(10) unsigned NOT NULL auto_increment"
    	),
    	'tstamp' => array
    	(
	        'sql'           => "int(10) unsigned NOT NULL default '0'"
    	)
	)
);
