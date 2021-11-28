<?php
return [
    'adminEmail' => 'admin@example.com',
    'validDocTypes' => [
	    					'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //xlsx
	                        'application/vnd.ms-excel', //xls, csv
	                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
	                        'application/msword', //doc
	                        'text/plain', //txt
	                        'application/pdf'
	                   	],
	'validImageTypes' => [
				            'image/jpeg', 
				            'image/png'
				        ],
    'docIcon' => [
    				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'web/images/icons/icon-excel.png',
    				'application/vnd.ms-excel' => 'web/images/icons/icon-excel.png',
    				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'web/images/icons/icon-word.png',
    				'application/msword' => 'web/images/icons/icon-word.png',
    				'text/plain' => 'web/images/icons/icon-txt.png',
    				'application/pdf' => 'web/images/icons/icon-pdf.png',
    			],
];
