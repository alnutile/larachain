<?php

use App\Source\Types\WebFile;

return array(
    'sources' =>
        array(
            'web_file' =>
                array(
                    'name' => 'Web File Source Type',
                    'class' => WebFile::class,
                    'id' => "web_file",
                    'route' => "sources.web_file.create",
                    'description' => 'Points to one or more URLs to download files from the internet for later parsing. All configuration data is encrypted.',
                    'icon' => 'ArrowDownTrayIcon',
                    'background' => 'bg-indigo-500',
                ),
            'web' =>
                array(
                    'name' => 'Scrape a Web Page',
                    'id' => "web",
                    'route' => "sources.web.create",
                    'description' => 'Simple scraper to fetch the desired data from a web page and pass it to LLM.',
                    'icon' => 'Bars4Icon',
                    'active' => 0,
                    'background' => 'bg-sky-500',
                ),
            'web_hook' =>
                array(
                    'name' => 'Create a Webhook to Send Data',
                    'description' => 'Add a webhook here to send logs or other data.',
                    'icon' => 'Bars4Icon',
                    'route' => "sources.web_hook.create",
                    'id' => "web_hook",
                    'active' => 0,
                    'background' => 'bg-sky-500',
                ),
            's3_directory' =>
                array(
                    'name' => 'S3 Directory to Get Files From',
                    'description' => 'Retrieve files from an S3 directory.',
                    'icon' => 'Bars4Icon',
                    'active' => 0,
                    'route' => "sources.s3_directory.create",
                    'id' => "s3_directory",
                    'background' => 'bg-red-500',
                ),
        ),
    'transformers' =>
        array(
            'pdf_transformer' =>
                array(
                    'name' => 'Break Pages of PDF into Text and Document Chunks',
                    'description' => 'If you have a PDF as a source, use this transformer to extract pages and text.',
                    'icon' => 'DocumentIcon',
                    'route' => "sources.pdf_transformer.create",
                    'id' => "pdf_transformer",
                    'background' => 'bg-blue-500',
                ),
            'embed_transformer' =>
                array(
                    'name' => 'Vectorize Your Data',
                    'description' => 'Create embeddings out of all your document chunks.',
                    'icon' => 'ArrowsRightLeftIcon',
                    'route' => "sources.embed_transformer.create",
                    'id' => "embed_transformer",
                    'background' => 'bg-red-700',
                ),
        ),
    'outbounds' =>
        array(
            'chat_ui' =>
                array(
                    'name' => 'Add a ChatUI to the Project Page',
                    'description' => 'Users can use the chosen Chat LLM to interact with the related data.',
                    'icon' => 'ChatBubbleLeftIcon',
                    'route' => "outbounds.chat_ui.create",
                    'active' => 1,
                    'id' => "chat_ui",
                    'background' => 'bg-sky-500',
                ),
            'api' =>
                array(
                    'name' => 'Add an API',
                    'description' => 'Attach a secure API to communicate with your data from any other app.',
                    'icon' => 'PhoneIcon',
                    'route' => "outbounds.api.create",
                    'id' => "api",
                    'active' => 0,
                    'background' => 'bg-green-500',
                ),
        ),
    'response_types' =>
        array(
            'embed_question' =>
                array(
                    'name' => 'Convert Incoming Question/Request into an Embedding',
                    'description' => 'This allows you to search the vector database if you have vectorized your data.',
                    'icon' => 'MegaphoneIcon',
                    'route' => "response_types.embed_question.create",
                    'id' => "embed_question",
                    'requires' =>
                        array(
                            0 => 'transformers:embed_transformer',
                        ),
                    'background' => 'bg-sky-500',
                    'active' => 1,
                ),
            'vector_search' =>
                array(
                    'name' => 'Search Vector Database',
                    'description' => 'Search the vector database with your request and pass it on to the next response type or to the user',
                    'icon' => 'MagnifyingGlassIcon',
                    'route' => "response_types.vector_search.create",
                    'id' => "vector_search",
                    'requires' =>
                        array(
                            0 => 'embed_question',
                        ),
                    'background' => 'bg-green-500',
                    'active' => 1,
                ),
            'combine_content' =>
                array(
                    'name' => 'Combine Content',
                    'description' => 'This will merge together the document chunks that result from a search to make sure they fit in a prompt',
                    'icon' => 'ArrowsPointingInIcon',
                    'route' => "response_types.combine_content.create",
                    'id' => "combine_content",
                    'requires' =>
                        array(
                            0 => 'embed_question',
                        ),
                    'background' => 'bg-slate-800',
                    'active' => 1,
                ),
            'trim_text' =>
                array(
                    'name' => 'Trim Text',
                    'description' => 'designed to help you trim text inputs, making it easier to fit more content within GPT’s context window. By tokenizing, stemming, and removing spaces, this library prepares your text inputs for efficient processing with GPT models.',
                    'icon' => 'DocumentTextIcon',
                    'route' => "response_types.trim_text.create",
                    'id' => "trim_text",
                    'background' => 'bg-slate-800',
                    'active' => 1,
                ),
            'chat_ui' =>
                array(
                    'name' => 'Integrate with Chat LLM APIs',
                    'description' => 'Create a chat system with platforms like OpenAI or others. It will pass any info into the {context} token in the prompt_token',
                    'icon' => 'ChatBubbleLeftIcon',
                    'route' => "response_types.chat_ui.create",
                    'id' => "chat_ui",
                    'background' => 'bg-green-500',
                    'active' => 1,
                ),
            'string_replace' =>
                array(
                    'name' => 'String Replace',
                    'description' => 'This will allow you to enter an array of words to look for and an array of words to replace them with',
                    'icon' => 'MegaphoneIcon',
                    'route' => "response_types.string_replace.create",
                    'id' => "string_replace",
                    'requires' =>
                        array(),
                    'background' => 'bg-green-500',
                    'active' => 1,
                ),
            'string_remove' =>
                array(
                    'name' => 'string_remove',
                    'description' => 'Remove string',
                    'icon' => 'MegaphoneIcon',
                    'route' => "response_types.string_remove.create",
                    'id' => "string_remove",
                    'requires' =>
                        array(),
                    'background' => 'bg-green-500',
                    'active' => 1,
                ),
            'preg_replace' =>
                array(
                    'name' => 'Preg Replace',
                    'description' => 'Add a pregreplace to run against a string',
                    'icon' => 'MegaphoneIcon',
                    'route' => "response_types.preg_replace.create",
                    'id' => "preg_replace",
                    'requires' =>
                        array(),
                    'background' => 'bg-red-700',
                    'active' => 1,
                ),
        ),
);
