<?php

return [
    'sources' => [
        'web_file' => [
            'title' => 'Web File Source Type',
            'description' => 'Points to one or more URLs to download files from the internet for later parsing. All configuration data is encrypted.',
            'icon' => 'ArrowDownTrayIcon',
            'background' => 'bg-indigo-500',
        ],
        'web' => [
            'title' => 'Scrape a Web Page',
            'description' => 'Simple scraper to fetch the desired data from a web page and pass it to LLM.',
            'icon' => 'Bars4Icon',
            'background' => 'bg-sky-500',
        ],
        'web_hook' => [
            'title' => 'Create a Webhook to Send Data',
            'description' => 'Add a webhook here to send logs or other data.',
            'icon' => 'Bars4Icon',
            'background' => 'bg-sky-500',
        ],
        's3_directory' => [
            'title' => 'S3 Directory to Get Files From',
            'description' => 'Retrieve files from an S3 directory.',
            'icon' => 'Bars4Icon',
            'background' => 'bg-red-500',
        ],
    ],
    'transformers' => [
        'pdf_transformer' => [
            'title' => 'Break Pages of PDF into Text and Document Chunks',
            'description' => 'If you have a PDF as a source, use this transformer to extract pages and text.',
            'icon' => 'DocumentIcon',
            'background' => 'bg-blue-500',
        ],
        'embed_transformer' => [
            'title' => 'Vectorize Your Data',
            'description' => 'Create embeddings out of all your document chunks.',
            'icon' => 'ArrowsRightLeftIcon',
            'background' => 'bg-red-700',
        ],
    ],
    'outbounds' => [
        'chat_ui' => [
            'title' => 'Add a ChatUI to the Project Page',
            'description' => 'Users can use the chosen Chat LLM to interact with the related data.',
            'icon' => 'ChatBubbleLeftIcon',
            'background' => 'bg-sky-500',
        ],
        'api' => [
            'title' => 'Add an API',
            'description' => 'Attach a secure API to communicate with your data from any other app.',
            'icon' => 'PhoneIcon',
            'background' => 'bg-green-500',
        ],
    ],
    'response_types' => [
        'embed_question' => [
            'title' => 'Convert Incoming Question/Request into an Embedding',
            'description' => 'This allows you to search the vector database if you have vectorized your data.',
            'icon' => 'MegaphoneIcon',
            'route' => 'embed_question',
            'requires' => ['transformers:embed_transformer'],
            'background' => 'bg-sky-500',
            'active' => 1,
        ],
        'vector_search' => [
            'title' => 'Search Vector Database',
            'description' => 'Search the vector database with your request and pass it on to the next response type or to the user',
            'icon' => 'MagnifyingGlassIcon',
            'route' => 'vector_search',
            'requires' => ['embed_question'],
            'background' => 'bg-green-500',
            'active' => 1,
        ],
        'combine_content' => [
            'title' => 'Combine Content',
            'description' => 'This will merge together the document chunks that result from a search to make sure they fit in a prompt',
            'icon' => 'ArrowsPointingInIcon',
            'route' => 'combine_content',
            'requires' => ['embed_question'],
            'background' => 'bg-slate-800',
            'active' => 1,
        ],
        'chat_ui' => [
            'title' => 'Integrate with Chat LLM APIs',
            'description' => 'Create a chat system with platforms like OpenAI or others. It will pass any info into the {context} token in the prompt_token',
            'icon' => 'ChatBubbleLeftIcon',
            'route' => 'chat_ui',
            'background' => 'bg-pink-500',
            'active' => 1,
        ],
    ],
];
