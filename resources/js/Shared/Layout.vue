<template>
    <div class="min-h-screen flex flex-col">
        <div class="fixed top-0 mt-10 right-0">
            <p
                v-if="$page.flash.success"
                class="bg-green-200 text-green-900 px-6 py-3 border-l-4 border-green-300 shadow-lg"
            >{{ $page.flash.success }}</p>
            <p
                v-if="Object.keys($page.errors).length"
                class="bg-red-200 text-red-900 px-6 py-3 border-l-4 border-red-300 shadow-lg"
            >Correct the errors in the form.</p>
        </div>
        <header
            v-if="sidebar"
            class="flex items-center justify-between bg-gray-900 text-gray-400 px-3 py-1 text-sm"
        >
            <div class="flex items-center">
                <svg class="w-5" viewBox="0 0 114 114" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" fill-rule="evenodd">
                        <circle fill="#4A5568" cx="57" cy="57" r="57" />
                        <path
                            d="M45.8 40L63 57.2 45.8 74.4H28l17.2-17.2L28 40h17.8zm26.9 0l17.2 17.2-17.2 17.2H54.9l17.2-17.2L54.9 40h17.8z"
                            fill="#FFF"
                            fill-rule="nonzero"
                        />
                    </g>
                </svg>
                <span class="ml-2">inertia-news.com</span>
            </div>
            <p>
                Howdy, {{ $page.auth.user.name }}
                <InertiaLink href="/logout" class="ml-2 underline">Log out</InertiaLink>
            </p>
        </header>
        <div class="flex-1 flex">
            <nav v-if="sidebar" class="w-48 bg-gray-900 text-gray-400 py-3 text-sm">
                <ul>
                    <li class="mb-2">
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-tachometer-alt w-8 inline-block text-center"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <InertiaLink
                            href="/posts"
                            class="block px-1 py-2 text-gray-200 bg-purple-700 link-active"
                        >
                            <i class="fas fa-thumbtack w-8 inline-block text-center"></i> Posts
                        </InertiaLink>
                        <ul class="text-gray-200 bg-gray-800 py-2">
                            <li>
                                <InertiaLink
                                    href="/posts"
                                    class="block px-4 py-1 font-bold"
                                >All Posts</InertiaLink>
                            </li>
                            <li>
                                <InertiaLink
                                    href="/posts/create"
                                    class="block px-4 py-1 hover:text-purple-400 text-gray-400"
                                >Add New</InertiaLink>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-photo-video w-8 inline-block text-center"></i> Media
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-file w-8 inline-block text-center"></i> Pages
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-comment w-8 inline-block text-center"></i> Comments
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-paint-brush w-8 inline-block text-center"></i> Appearance
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-plug w-8 inline-block text-center"></i> Plugins
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-user w-8 inline-block text-center"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-wrench w-8 inline-block text-center"></i> Tools
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-1 py-2 hover:text-purple-400 hover:bg-black">
                            <i class="fas fa-sliders-h w-8 inline-block text-center"></i> Settings
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="flex flex-col flex-1 px-8 py-6">
                <main class="flex-1">
                    <slot />
                </main>
                <footer class="pt-12 flex justify-between text-gray-700">
                    <p class="italic">
                        Thank you for creating with
                        <a
                            href="https://github.com/inertiajs/inertia"
                            target="_blank"
                            class="text-purple-600 hover:text-purple-500 underline"
                        >Inertia</a>.
                    </p>
                    <p>Version 0.1.3</p>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {},
        sidebar: { default: true }
    },

    created() {
        document.title = this.title ? `${this.title} | Inertia News` : 'Inertia News';
    }
};
</script>

