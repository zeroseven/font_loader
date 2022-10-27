<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Font loader',
    'description' => 'With this extension external fonts can be loaded directly into your TYPO3 ecosystem and will be delivered from your local webserver',
    'category' => 'plugin',
    'author' => 'Raphael Thanner',
    'author_email' => 'r.thanner@zeroseven.de',
    'author_company' => 'zeroseven design studios GmbH',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99'
        ],
        'suggests' => [
        ]
    ]
];
