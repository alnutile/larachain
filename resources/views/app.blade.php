<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel and Large Language Models (LLM) </title>
        <meta name="description" content="LaraChain offers a pluggable framework for communicating with Large Language Models (LLM) from Google, OpenAI, Azure, Hugging Face, and more using the power of Laravel.">
        <meta name="keywords" content="ChatGPT, OpenAI, Laravel, Large Language Models, LLM, Google, OpenAI, Azure, Hugging Face, Horizon, Events, Facades, Tailwind, Inertia, JetStream, LaraChain, PHP, Project-Centric Data Storage, Team-Level Permissions, APIs, ChatGPT Plugins">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia


        @if(config('larachain.google_analytics'))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{config('larachain.google_analytics')}}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '{{config('larachain.google_analytics')}}');
            </script>
        @endif

    </body>
</html>
