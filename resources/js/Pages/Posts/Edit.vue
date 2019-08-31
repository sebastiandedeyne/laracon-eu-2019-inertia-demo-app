<template>
    <Layout :title="pageTitle">
        <header class="mb-4">
            <h1 class="text-2xl leading-tight">
                {{ pageTitle }}
            </h1>
        </header>
        <div class="flex">
            <div class="flex-1 mr-3 bg-white shadow p-6">
                <section class="flex-1">
                    <TextField placeholder="Add title" class="mb-1 text-xl" v-model="form.title" :errors="$page.errors.title" />
                    <p class="text-sm text-gray-700 ml-2 mb-8">
                        Permalink:
                        <a :href="`https://inertia-news.com/${slug}`" target="_blank" class="text-purple-600 hover:text-purple-500" >
                            https://inertia-news.com/{{ slug }}
                        </a>
                    </p>
                    <TextareaField v-model="form.content" :errors="$page.errors.content" />
                </section>
            </div>
            <section class="w-1/3 ml-3">
                <div class="bg-white shadow mb-2">
                    <header class="p-4 border-b font-bold">
                        Status
                    </header>
                    <div class="p-4 text-gray-700">
                        <p class="mb-2">
                            <i class="fas fa-map-pin inline-block w-4 text-center mr-2"></i>
                            Status:
                            <strong class="text-gray-900">
                                {{ status | upperFirst }}
                            </strong>
                        </p>
                        <p v-if="post.author" class="mb-2">
                            <i class="fas fa-user inline-block w-4 text-center mr-2"></i>
                            Author:
                            <strong class="text-gray-900">
                                {{ post.author.name }}
                            </strong>
                            <span v-if="post.author.id === $page.auth.user.id">
                                (me)
                            </span>
                        </p>
                        <p v-if="status === 'published'" class="mb-2">
                            <i class="fas fa-calendar-week inline-block w-4 text-center mr-2"></i>
                            Published at:
                            <strong class="text-gray-900">
                                {{ post.published_at | date }}
                            </strong>
                        </p>
                    </div>
                    <div v-if="!post.created_at" class="p-4 border-t flex items-center justify-between">
                        <InertiaLink
                            href="/posts"
                            method="post"
                            :data="{ ...form, status: 'draft' }"
                            class="text-gray-700 hover:text-purple-500 mr-2"
                        >
                            Save draft
                        </InertiaLink>
                        <InertiaLink
                            href="/posts"
                            method="post"
                            :data="{ ...form, status: 'published' }"
                            class="button"
                        >
                            Publish
                        </InertiaLink>
                    </div>
                    <div v-else-if="!post.deleted_at" class="p-4 border-t flex items-center justify-between">
                        <InertiaLink
                            :href="post.links.update"
                            method="put"
                            :data="{ ...form, status: 'draft'}"
                            class="text-gray-700 hover:text-purple-500 mr-2"
                        >
                            Save draft
                        </InertiaLink>
                        <InertiaLink
                            :href="post.links.update"
                            method="put"
                            :data="{ ...form, status: 'published' }"
                            class="button"
                        >
                            Publish
                        </InertiaLink>
                    </div>
                </div>
                <div v-if="post.created_at" class="text-right">
                    <p v-if="!post.deleted_at">
                        <InertiaLink
                            :href="post.links.destroy"
                            method="delete"
                            class="mr-4 text-sm underline text-red-600 hover:text-red-500"
                        >
                            Move to trash
                        </InertiaLink>
                    </p>
                    <p v-else>
                        <InertiaLink
                            :href="post.links.restore"
                            method="post"
                            class="mr-4 text-sm underline text-gray-700 hover:text-gray-600"
                        >
                            Restore
                        </InertiaLink>
                    </p>
                </div>
            </section>
        </div>
    </Layout>
</template>

<script>
import kebabCase from 'lodash/kebabCase';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: ['post'],

    data() {
        return {
            form: {
                title: this.post.title,
                content: this.post.content
            }
        };
    },

    remember: ['form'],

    computed: {
        pageTitle() {
            return this.post.created_at ? 'Edit Post' : 'Add New Post';
        },

        slug() {
            return this.post.slug || kebabCase(this.form.title);
        },

        status() {
            if (this.post.deleted_at) {
                return 'trashed';
            }

            if (this.post.published_at) {
                return 'published';
            }

            return 'draft';
        }
    },
};
</script>
