<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
  'font_path' 						=> public_path('fonts/'),
	'font_data'							=> [
			"thsarabun" => [ /*Thai */
	          'R' => "THSarabun.ttf",
	          'B' => "THSarabun Bold.ttf",
	          'I' => "THSarabun Italic.ttf",
	          'BI' => "THSarabun Bold Italic.ttf"
	      ]
		]
];
