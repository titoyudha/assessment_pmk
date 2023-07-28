<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Name
    |--------------------------------------------------------------------------
    |
    | This is the name of your API and will be displayed in the documentation
    | and used in the generated JSON file.
    |
    */

    'api' => [
        'name' => 'Your API Name',
        'version' => '1.0.0',
        'description' => 'Description of your API',
        'defaultBasePath' => '/api',
    ],

    /*
    |--------------------------------------------------------------------------
    | Generator Settings
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the Swagger Lumen Generator. You can specify
    | the output paths for the generated documentation and the controllers
    | to include in the documentation.
    |
    */

    'generator' => [
        'output' => base_path('public/docs'),
        'defaults' => [
            'routes' => true,
            'paths' => base_path('app/Http/Controllers'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the Swagger UI. You can specify the path
    | for the Swagger UI to be accessible and customize its appearance.
    |
    */

    'ui' => [
        'enabled' => true,
        'url' => '/api/docs',
        'oauth2Redirect' => '/api/docs/oauth2-redirect',
        'operationsSorter' => 'alpha',
        'tagsSorter' => 'alpha',
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Definitions
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the security definitions used in the
    | Swagger documentation. You can specify the security definitions
    | required for your API endpoints.
    |
    */

    'securityDefinitions' => [
        'apiToken' => [
            'type' => 'apiKey',
            'name' => 'Authorization',
            'in' => 'header',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Additional Configuration
    |--------------------------------------------------------------------------
    |
    | This is additional configuration for the Swagger documentation. You can
    | specify settings such as authentication requirements and default response
    | formats.
    |
    */

    'documentation' => [
        'security' => [
            'apiToken' => [],
        ],
        'responses' => [
            'unauthorized' => [
                'description' => 'Unauthorized. Token not provided or invalid.',
            ],
            'internalServerError' => [
                'description' => 'Internal server error.',
            ],
            'notFound' => [
                'description' => 'Resource not found.',
            ],
            'errors' => [
                'type' => 'object',
                'properties' => [
                    'field' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'SuccessResponse' => [
                'type' => 'object',
                'properties' => [
                    'data' => [
                        'type' => 'null',
                    ],
                    'message' => [
                        'type' => 'string',
                    ],
                    'status' => [
                        'type' => 'integer',
                    ],
                ],
            ],
        ],
    ],

];

