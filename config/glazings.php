<?php

return [
	
	'1' => [
		'name'	=> 'Standard Float Glass',
		
		'sheet' => [
			'width'		=> '1220',
			'height'	=> '914',
			'price'		=> '282',
			
			'oversized' => [
				'width'		=> '1830',
				'height'	=> '1220',
				'price'		=> '650',
			],
		],
	],
	
	'2' => [
		'name'	=> 'Specialist Glass',
		
		'options' => [
			'1' => [
				'name'	=> 'Standard Anti-reflective',
				
				'sheet' => [
					'width'		=> '1220',
					'height'	=> '914',
					'price'		=> '150',
				],
			],
			
			'2' => [
				'name'	=> 'Art Glass AR70',
				'desc'	=> 'Anti reflective and 70% UV filtering',
				
				'sheet' => [
					'width'		=> '914',
					'height'	=> '1220',
					'price'		=> '3100',
				],
			],
			
			'3' => [
				'name'	=> 'Art Glass A99',
				'desc'	=> '99% UV filter only',
				
				'sheet' => [
					'width'		=> '914',
					'height'	=> '1220',
					'price'		=> '1550',
				],
			],
			
			'4' => [
				'name'	=> 'Art Glass AR92',
				'desc'	=> '90% UV filter and Anti reflective',
				
				'sheet' => [
					'width'		=> '914',
					'height'	=> '1220',
					'price'		=> '5000',
				],
			]
		]
	],
	
	'3' => [
		'name'	=> 'Acrylic',
		
		'options' => [
			'1' => [
				'name'	=> 'Styrene 1.2mm',
				
				'sheet' => [
					'width'		=> '1220',
					'height'	=> '914',
					'price'		=> '459',
				],
			],
			
			'2' => [
				'name'	=> 'Clear Acrylic',
				
				'sheet' => [
					'width'		=> '1525',
					'height'	=> '1025',
					'price'		=> '1550',
					
					'oversized' => [
						'width'		=> '1850',
						'height'	=> '1250',
						'price'		=> '2276',
					],
				],
			],
		],
	],
	
	'4' => [
		'name'	=> 'Mirror Glass',
		
		'sheet' => [
			'width'		=> '920',
			'height'	=> '1220',
			'price'		=> '738',
			
			'oversized' => [
				'width'		=> '1830',
				'height'	=> '1220',
				'price'		=> '1517',
			],
		],
	]
];