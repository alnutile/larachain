<?php

return [
    'sources' => [
        'web_file' => [
            'title' => 'Web File Source Type',
            'description' => 'Point to one more URLs to download files from the internet for later parsing. All configuration data is encrypted',
            'icon' => 'ArrowDownTrayIcon',
            'background' => 'bg-indigo-500',
        ],
        'web' => [
            'description' => 'Another to-do system you’ll try but eventually give up on.',
            'icon' => 'Bars4Icon',
            'background' => 'bg-sky-500',
        ],
        's3_directory' => [
            'description' => 'Another to-do system you’ll try but eventually give up on.',
            'icon' => 'Bars4Icon',
            'background' => 'bg-red-500',
        ],
    ],
    'transformers' => [
        'pdf_transformer' => [
            'title' => 'Break Pages of PDF info text and Document Chunks',
            'description' => 'If you have a PDF for a source use this to get to the pages and text',
            'icon' => 'DocumentIcon',
            'background' => 'bg-indigo-500',
        ],
        'embed_transformer' => [
            'description' => 'Created Embeddings out of all your Document Chunks',
            'icon' => 'ArrowsRightLeftIcon',
            'background' => 'bg-red-700',
        ],
    ],
];
