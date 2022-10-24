<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Font loader',
    'description' => 'Load Google Fonts and Fontawesome to share from your TYPO3',
    'category' => 'plugin',
    'author' => 'Raphael Thanner',
    'author_email' => 'r.thanner@zeroseven.de',
    'author_company' => 'zeroseven design studios GmbH',
    'state' => 'beta',
    'clearCacheOnLoad' => 1,
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99'
        ],
        'suggests' => [
        ]
    ]
];
