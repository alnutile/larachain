<template>
    <Head title="LaraChain"></Head>
    <nav class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!--
                          Icon when menu is closed.

                          Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                          Icon when menu is open.

                          Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center font-bold text-2xl text-indigo-500">
                        LaraChain
                    </div>

                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <Link :href="route('login')" class="font-medium text-indigo-700">Login</Link>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="space-y-1 pb-4 pt-2">
                <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                <Link :href="route('login')" class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700">Login</Link>
            </div>
        </div>
    </nav>

    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl sm:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Large Language Models and Your Data</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Want to start using Laravel and Large Language Models with your data?</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    This opensource product is a great foundation. With it you begin to chat with and LLM and your data as the context.
                </p>
            </div>
        </div>
        <div class="flex justify-center gap-8 mt-4 items-center text-xl max-w-7xl mx-auto">
            <div class="flex justify-start gap-2 items-center">
                💪
                <a class="underline" href="https://github.com/alnutile/larachain">OpenSource </a><ArrowTopRightOnSquareIcon class="text-gray-500 w-4"/></div>
            <div class="flex justify-start gap-2 items-center">
                🧠
                <a class="underline" href="https://github.com/alnutile/larachain/wiki">Wiki Learn More </a><ArrowTopRightOnSquareIcon class="text-gray-500 w-4"/></div>
            <div class="flex justify-start gap-2 items-center">
                📺
                <a class="underline" href="https://www.youtube.com/playlist?list=PLL8JVuiFkO9IvRPfwH4p2UFhvj7UJxiNv">YouTube </a><ArrowTopRightOnSquareIcon class="text-gray-500 w-4"/> </div>
        </div>
        <div class="relative overflow-hidden pt-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <img src="/marketing/search.gif" alt="App screenshot" class="mb-[-12%] rounded-xl shadow-2xl ring-1 ring-gray-900/10" width="2432" height="1442" />
                <div class="relative" aria-hidden="true">
                    <div class="absolute -inset-x-20 bottom-0 bg-gradient-to-t from-white pt-[7%]" />
                </div>
            </div>
        </div>
        <div class="mx-auto mt-16 max-w-7xl px-6 sm:mt-20 md:mt-24 lg:px-8">
            <dl class="mx-auto grid max-w-2xl grid-cols-1 gap-x-6 gap-y-10 text-base leading-7 text-gray-600 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-x-8 lg:gap-y-16">
                <div v-for="feature in features" :key="feature.name" class="relative pl-9">
                    <dt class="inline font-semibold text-gray-900">
                        <component :is="feature.icon" class="absolute left-1 top-1 h-5 w-5 text-indigo-600" aria-hidden="true" />
                        {{ feature.name }}
                    </dt>
                    {{ ' ' }}
                    <dd class="inline">{{ feature.description }}</dd>
                </div>
            </dl>
        </div>
    </div>


    <footer class="mt-32 bg-gray-900 sm:mt-56" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8 lg:py-32">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="w-10 h-10 text-2xl text-indigo-500">LaraChain</div>
                <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Solutions</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.solutions" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-300 hover:text-white">{{ item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Support</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.support" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-300 hover:text-white">{{ item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Company</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.company" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-300 hover:text-white">{{ item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Legal</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.legal" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-300 hover:text-white">{{ item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import {
    ArrowPathIcon,
    CloudArrowUpIcon,
    Cog6ToothIcon,
    UserGroupIcon,
    FingerPrintIcon,
    ArrowTopRightOnSquareIcon,
    FolderOpenIcon,
    ArrowsPointingOutIcon,
    PlayIcon,
    LockClosedIcon,
    ServerIcon,
} from '@heroicons/vue/20/solid'

const features = [
    {
        name: 'Download and Deploy',
        description: 'Your code your server (or host with us)',
        icon: CloudArrowUpIcon,
    },
    {
        name: 'Pluggable Framework',
        description: 'We will continue to build plugins but if you have some custom need you can easily build it to get your data into the system.',
        icon: PlayIcon,
    },
    {
        name: 'All the Power of Laravel',
        description: 'Horizon, Events, Facades, Tailwind, Inertia, JetStream all ready for you to build on top of',
        icon: ArrowPathIcon,
    },
    {
        name: 'Project Centric Data Storage',
        description: 'Import your data into different projects, then you chat with that data in that context.',
        icon: FolderOpenIcon,
    },
    {
        name: 'Team Level Permissions',
        description: 'Make Teams and add users so that you can securely search and share your content.',
        icon: UserGroupIcon,
    },
    {
        name: 'APIs, ChatGPT Plugins and more',
        description: 'Need to get to your data? Just turn on many of these egress methods to get to it.',
        icon: ArrowsPointingOutIcon,
    },
]

const footerNavigation = {
    solutions: [
        { name: 'LaraChain Wiki', href: 'https://github.com/alnutile/larachain/wiki' },
        { name: 'GitHub', href: 'https://github.com/alnutile/larachain' },
        { name: 'LinkedIn', href: 'https://www.linkedin.com/in/alfrednutile/' },
        { name: 'YouTube PlayList', href: 'https://www.youtube.com/playlist?list=PLL8JVuiFkO9IvRPfwH4p2UFhvj7UJxiNv' },
        { name: 'Alfred Nutile', href: 'https://alfrednutile.info/' },
    ],
    // support: [
    //     { name: 'Pricing', href: '#' },
    //     { name: 'Documentation', href: '#' },
    //     { name: 'Guides', href: '#' },
    //     { name: 'API Status', href: '#' },
    // ],
    // company: [
    //     { name: 'About', href: '#' },
    //     { name: 'Blog', href: '#' },
    //     { name: 'Jobs', href: '#' },
    //     { name: 'Press', href: '#' },
    //     { name: 'Partners', href: '#' },
    // ],
    // legal: [
    //     { name: 'Claim', href: '#' },
    //     { name: 'Privacy', href: '#' },
    //     { name: 'Terms', href: '#' },
    // ],
}
</script>
