<?php

$LLL = 'LLL:EXT:typo3_features/Resources/Private/Language/locallang_db.xml:tx_typo3features_domain_model_feature';

return [
    'ctrl' => [
        'title' => $LLL,
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xlf:LGL.prependAtCopy',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'fe_group' => 'fe_groups',
            'be_group' => 'be_groups',
        ],
        'iconfile' => 'EXT:typo3_features/Resources/Public/Icons/feature.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'key, name, description, class_string',
    ],
    'types' => [
        '0' => [
            'showitem' => implode(',', [
                implode(',', [
                    '--div--;LLL:EXT:typo3_features/Resources/Private/Language/locallang_tabs.xlf:general',
                    'key,name,description,class_string',
                ]),
                implode(',', [
                    '--div--;LLL:EXT:typo3_features/Resources/Private/Language/locallang_tabs.xlf:access',
                    'hidden',
                    '--palette--;;timeRestriction'
                ]),
                implode(',', [
                    '--div--;LLL:EXT:typo3_features/Resources/Private/Language/locallang_tabs.xlf:accessFrontend',
                    'fe_users,fe_groups',
                ]),
                implode(',', [
                    '--div--;LLL:EXT:typo3_features/Resources/Private/Language/locallang_tabs.xlf:accessBackend',
                    'be_users,be_groups',
                ]),
            ])
        ],
    ],
    'palettes' => [
        'timeRestriction' => ['showitem' => 'starttime, endtime'],
    ],
    'columns' => [
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2106),
                ],
            ],
        ],
        'fe_users' => [
            'exclude' => true,
            'label' => $LLL . '.fe_users',
            'config' => [
                'type' => 'group',
                'allowed' => 'fe_users',
            ],
        ],
        'fe_groups' => [
            'exclude' => true,
            'label' => $LLL . '.fe_groups',
            'config' => [
                'type' => 'group',
                'allowed' => 'fe_groups',
            ],
        ],
        'be_users' => [
            'exclude' => true,
            'label' => $LLL . '.be_users',
            'config' => [
                'type' => 'group',
                'allowed' => 'be_users',
            ],
        ],
        'be_groups' => [
            'exclude' => true,
            'label' => $LLL . '.be_groups',
            'config' => [
                'type' => 'group',
                'allowed' => 'be_groups',
            ],
        ],

        'key' => [
            'exclude' => false,
            'label' => $LLL . '.key',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => $LLL . '.name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => $LLL . '.description',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'class_string' => [
            'exclude' => false,
            'label' => $LLL . '.class_string',
            'description' => $LLL . '.class_string.desc',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256
            ],
        ],
    ],
];
