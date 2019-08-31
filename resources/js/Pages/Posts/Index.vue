<template>
    <Layout title="Posts">
        <header class="flex items-end mb-4">
            <h1 class="text-2xl leading-tight">
                Posts
            </h1>
            <InertiaLink
                href="/posts/create"
                class="p-2 bg-white border border-gray-400 rounded-sm leading-none ml-3 text-sm font-semibold text-purple-600 hover:bg-purple-600 hover:border-purple-700 hover:text-white"
            >
                Add new
            </InertiaLink>
        </header>
        <nav class="flex items-end justify-between mb-2 text-sm">
            <ul class="flex">
                <li>
                    <InertiaLink href="/posts" :preserve-scroll="true">
                        <span :class="!status ? 'font-semibold' : 'text-purple-600 hover:text-purple-500'">
                            All
                        </span>
                        <span class="text-gray-700">({{ counts.all }})</span>
                    </InertiaLink>
                </li>
                <li v-if="counts.published">
                    <span class="text-gray-500 mx-1">|</span>
                    <InertiaLink href="/posts?status=published" :preserve-scroll="true">
                        <span :class="status === 'published' ? 'font-semibold' : 'text-purple-600 hover:text-purple-500'">
                            Published
                        </span>
                        <span class="text-gray-600">
                            ({{ counts.published }})
                        </span>
                    </InertiaLink>
                </li>
                <li v-if="counts.draft">
                    <span class="text-gray-500 mx-1">|</span>
                    <InertiaLink href="/posts?status=draft" :preserve-scroll="true">
                        <span :class="status === 'draft' ? 'font-semibold' : 'text-purple-600 hover:text-purple-500'">
                            Draft
                        </span>
                        <span class="text-gray-600">
                            ({{ counts.draft }})
                        </span>
                    </InertiaLink>
                </li>
                <li v-if="counts.trashed">
                    <span class="text-gray-500 mx-1">|</span>
                    <InertiaLink href="/posts?status=trashed" :preserve-scroll="true">
                        <span :class="status === 'trashed' ? 'font-semibold' : 'text-purple-600 hover:text-purple-500'">
                            Trash
                        </span>
                        <span class="text-gray-600">
                            ({{ counts.trashed }})
                        </span>
                    </InertiaLink>
                </li>
            </ul>
            <TextField type="search" placeholder="Search…" v-model="search" />
        </nav>
        <table class="w-full bg-white shadow-md mb-2">
            <thead>
                <tr class="border-b">
                    <th class="px-3 py-2">Title</th>
                    <th class="px-3 py-2">Author</th>
                    <th class="px-3 py-2">Published at</th>
                    <th class="px-3 py-2">Last modified</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr v-for="post in posts" :key="post.id" class="odd:bg-gray-100">
                    <td class="p-3">
                        <InertiaLink
                            :href="post.links.edit"
                            class="font-medium text-purple-600 hover:text-purple-500"
                        >
                            {{ post.title }}
                        </InertiaLink>
                        <span v-if="post.deleted_at" class="text-red-600">
                            – Trash
                        </span>
                        <span v-else-if="!post.published_at" class="text-gray-600">
                            – Draft
                        </span>
                    </td>
                    <td class="p-3">
                        {{ post.author.name }}
                    </td>
                    <td class="p-3">
                        {{ post.published_at | date }}
                    </td>
                    <td class="p-3">
                        {{ post.updated_at | date }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="border-t">
                    <th class="px-3 py-2">Title</th>
                    <th class="px-3 py-2">Author</th>
                    <th class="px-3 py-2">Published at</th>
                    <th class="px-3 py-2">Last modified</th>
                </tr>
            </tfoot>
        </table>
        <p class="text-right text-gray-700">
            {{ posts.length === 1 ? '1 item' : `${posts.length} items` }}
        </p>
    </Layout>
</template>

<script>
import { stringify } from 'qs';
import debounce from 'lodash/debounce';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: ['posts', 'status', 'counts', 'initialSearch'],

    data() {
        return {
            search: this.initialSearch
        };
    },

    watch: {
        search: debounce(function() {
            const query = stringify({
                search: this.search || undefined,
                status: this.status || undefined
            });

            Inertia.visit(query ? `/posts?${query}` : '/posts', {
                preserveScroll: true,
                preserveState: true,
                only: ['posts'],
            });
        }, 250)
    }
};
</script>
