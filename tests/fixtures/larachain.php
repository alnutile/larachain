<?php

return [
    'sources' => [
        'web_file' => [
            'name' => 'Web File Source Type',
            'class' => 'App\\Source\\Types\\WebFile',
            'active' => 1,
            'description' => 'Points to one or more URLs to download files from the internet for later parsing. All configuration data is encrypted.',
        ],
        'web' => [
            'name' => 'Scrape a Web Page',
            'description' => 'Simple scraper to fetch the desired data from a web page and pass it to LLM.',
            'icon' => 'Bars4Icon',
            'active' => 1,
            'background' => 'bg-sky-500',
        ],
        'web_hook' => [
            'name' => 'Create a Webhook to Send Data',
            'description' => 'Add a webhook here to send logs or other data.',
            'icon' => 'Bars4Icon',
            'active' => 0,
            'background' => 'bg-sky-500',
        ],
        's3_directory' => [
            'name' => 'S3 Directory to Get Files From',
            'description' => 'Retrieve files from an S3 directory.',
            'icon' => 'Bars4Icon',
            'active' => 0,
            'background' => 'bg-red-500',
        ],
    ],
    'transformers' => [
        'pdf_transformer' => [
            'name' => 'Break Pages of PDF into Text and Document Chunks',
            'description' => 'If you have a PDF as a source, use this transformer to extract pages and text.',
            'icon' => 'DocumentIcon',
            'class' => 'App\\Transformer\\Types\\PdfTransformer',
            'active' => 1,
            'background' => 'bg-blue-500',
        ],
        'embed_transformer' => [
            'name' => 'Vectorize Your Data',
            'description' => 'Create embeddings out of all your document chunks.',
            'icon' => 'ArrowsRightLeftIcon',
            'class' => 'App\\Transformer\\Types\\EmbedTransformer',
            'active' => 1,
            'background' => 'bg-red-700',
        ],
    ],
    'outbounds' => [
        'chat_ui' => [
            'name' => 'Add a ChatUI to the Project Page',
            'description' => 'Users can use the chosen Chat LLM to interact with the related data.',
            'icon' => 'ChatBubbleLeftIcon',
            'active' => 1,
            'background' => 'bg-sky-500',
        ],
        'api' => [
            'name' => 'Add an API',
            'description' => 'Attach a secure API to communicate with your data from any other app.',
            'icon' => 'PhoneIcon',
            'active' => 0,
            'background' => 'bg-green-500',
        ],
    ],
    'response_types' => [
        'embed_question' => [
            'name' => 'Convert Incoming Question/Request into an Embedding',
            'description' => 'This allows you to search the vector database if you have vectorized your data.',
            'icon' => 'MegaphoneIcon',
            'class' => 'App\\ResponseType\\Types\\EmbedQuestion',
            'requires' => [
                0 => 'transformers:embed_transformer',
            ],
            'background' => 'bg-sky-500',
            'active' => 1,
        ],
        'vector_search' => [
            'name' => 'Search Vector Database',
            'description' => 'Search the vector database with your request and pass it on to the next response type or to the user',
            'icon' => 'MagnifyingGlassIcon',
            'class' => 'App\\ResponseType\\Types\\VectorSearch',
            'requires' => [
                0 => 'embed_question',
            ],
            'background' => 'bg-green-500',
            'active' => 1,
        ],
        'combine_content' => [
            'name' => 'Combine Content',
            'description' => 'This will merge together the document chunks that result from a search to make sure they fit in a prompt',
            'icon' => 'ArrowsPointingInIcon',
            'class' => 'App\\ResponseType\\Types\\CombineContent',
            'requires' => [
                0 => 'embed_question',
            ],
            'background' => 'bg-slate-800',
            'active' => 1,
        ],
        'trim_text' => [
            'name' => 'Trim Text',
            'description' => 'designed to help you trim text inputs, making it easier to fit more content within GPT’s context window. By tokenizing, stemming, and removing spaces, this library prepares your text inputs for efficient processing with GPT models.',
            'icon' => 'DocumentTextIcon',
            'background' => 'bg-slate-800',
            'class' => 'App\\ResponseType\\Types\\TrimText',
            'active' => 1,
        ],
        'chat_ui' => [
            'name' => 'Integrate with Chat LLM APIs',
            'description' => 'Create a chat system with platforms like OpenAI or others. It will pass any info into the {context} token in the prompt_token',
            'icon' => 'ChatBubbleLeftIcon',
            'class' => 'App\\ResponseType\\Types\\ChatUi',
            'background' => 'bg-green-500',
            'active' => 1,
        ],
        'string_replace' => [
            'name' => 'String Replace',
            'description' => 'This will allow you to enter an array of words to look for and an array of words to replace them with',
            'icon' => 'MegaphoneIcon',
            'class' => 'App\\ResponseType\\Types\\StringReplace',
            'requires' => [
            ],
            'background' => 'bg-green-500',
            'active' => 1,
        ],
        'string_remove' => [
            'name' => 'string_remove',
            'class' => 'App\\ResponseType\\Types\\StringRemove',
            'description' => 'Remove string',
            'icon' => 'MegaphoneIcon',
            'requires' => [
            ],
            'background' => 'bg-green-500',
            'active' => 1,
        ],
        'preg_replace' => [
            'name' => 'Preg Replace',
            'class' => 'App\\ResponseType\\Types\\PregReplace',
            'description' => 'Add a preg-replace to run against a string',
            'icon' => 'MegaphoneIcon',
            'requires' => [
            ],
            'background' => 'bg-red-700',
            'active' => 1,
        ],
    ],
];
