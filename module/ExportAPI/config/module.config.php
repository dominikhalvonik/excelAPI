<?php
return [
    'controllers' => [
        'factories' => [
            'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => \ExportAPI\V1\Rpc\ExportXls\ExportXlsControllerFactory::class,
            'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => \ExportAPI\V1\Rpc\SearchFile\SearchFileControllerFactory::class,
            'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => \ExportAPI\V1\Rpc\DownloadFile\DownloadFileControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \ExportAPI\Service\ExportFile::class => \ExportAPI\Factory\Service\ExportFileFactory::class,
            \ExportAPI\Model\ManageFiles::class => \ExportAPI\Factory\Model\ManageFilesFactory::class,
            \ExportAPI\Service\DownloadFile::class => \ExportAPI\Factory\Service\DownloadFileFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'export-api.rpc.export-xls' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/export-xls',
                    'defaults' => [
                        'controller' => 'ExportAPI\\V1\\Rpc\\ExportXls\\Controller',
                        'action' => 'exportXls',
                    ],
                ],
            ],
            'export-api.rpc.search-file' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/search[/:fileName]',
                    'defaults' => [
                        'controller' => 'ExportAPI\\V1\\Rpc\\SearchFile\\Controller',
                        'action' => 'searchFile',
                    ],
                ],
            ],
            'export-api.rpc.download-file' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/download[/:fileID]',
                    'defaults' => [
                        'controller' => 'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller',
                        'action' => 'downloadFile',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'export-api.rpc.export-xls',
            1 => 'export-api.rpc.search-file',
            2 => 'export-api.rpc.download-file',
        ],
    ],
    'zf-rpc' => [
        'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
            'service_name' => 'ExportXls',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'export-api.rpc.export-xls',
        ],
        'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
            'service_name' => 'SearchFile',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'export-api.rpc.search-file',
        ],
        'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
            'service_name' => 'DownloadFile',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'export-api.rpc.download-file',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => 'Json',
            'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => 'Json',
            'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
            ],
            'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
            ],
            'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
                0 => 'application/vnd.export-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-content-validation' => [
        'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
            'input_filter' => 'ExportAPI\\V1\\Rpc\\ExportXls\\Validator',
        ],
        'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
            'input_filter' => 'ExportAPI\\V1\\Rpc\\SearchFile\\Validator',
        ],
        'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
            'input_filter' => 'ExportAPI\\V1\\Rpc\\DownloadFile\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'ExportAPI\\V1\\Rpc\\ExportXls\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'sheets',
                'description' => 'Spredsheet data',
                'field_type' => 'JSON',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'headers',
                'description' => 'Headers',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'data',
                'description' => 'Data',
            ],
        ],
        'ExportAPI\\V1\\Rpc\\SearchFile\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'fileName',
                'description' => 'Name of file',
            ],
        ],
        'ExportAPI\\V1\\Rpc\\DownloadFile\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'fileID',
                'description' => 'fileID',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
                'actions' => [
                    'ExportXls' => [
                        'GET' => false,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
                'actions' => [
                    'SearchFile' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
                'actions' => [
                    'DownloadFile' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
        ],
    ],
];
