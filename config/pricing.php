<?php

return [
	
	'fixings' => [
		0 => [
			'name' => 'None'
		],
		1 => [
			'name' => 'Standard string'
		],
		2 => [
			'name' => 'Invisible'
		],
		3 => [
			'name' => 'Picture stand'
		],
	],
	
	'artwork_mounting' => [
		0 => [
			'name' => 'None'
		],
		1 => [
			'name' => 'Dry mount'
		],
		2 => [
			'name' => 'Hinge mount'
		],
		3 => [
			'name' => 'Photo mount'
		],
	],
	
	'labour' => [
		'cutting_frame' => 2,
		
		'pinning_frame'		=> 2, // Normal frame
		'pinning_big_frame' => 4, // 700x700 and over
		'big_frame' => [
			'width'		=> 700,
			'height'	=> 700
		],
		
		'cutting_glass'			=> 1.5,
		'cutting_backing_board' => 1.5,
		'cutting_mountboard'	=> 1.5,
		'dry_mount'				=> 5,
		'atg_tape_mounting'		=> 0.5, // Mount supplied artwork with ATG tape
		'hinge_mount'			=> 6,
		'sealing'				=> 3.5,
		'attach_picture_stand'	=> 3.5,
		'assembly'				=> 5,
		'lining_frame'			=> 25, // Lining frame for box frames
		'multimount'			=> 1, // per aperture
		
		'pence_per_minute' => 100
	],
	
	'foam_board' => [
		'5mm' => [
			'width' => '1016',
			'height' => '764',
			'price' => '800'
		],
		'10mm' => [
			'width' => '1016',
			'height' => '764',
			'price' => '1400'
		]
	],
	
	'wastage' => [
		'mould' => 25 // %
	]
];