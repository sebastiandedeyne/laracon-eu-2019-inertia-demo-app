<template>
    <div>
        <label v-if="label" :for="name" class="block text-gray-700 mb-1">
            {{ label }}
        </label>
        <textarea
            ref="textarea"
            class="w-full bg-gray-100 border shadow-inner p-2 focus:outline-none focus:border-purple-500"
            :class="needsCorrection ? 'border-red-700' : 'border-gray-300'"
            rows="10"
            :name="name"
            :id="name"
            autocomplete="off"
            :value="value"
            :placeholder="placeholder"
            @input="handleInput"
        />
        <p v-if="hasError" class="mt-1 text-xs text-red-600">
            {{ errors[0] }}
        </p>
    </div>
</template>

<script>
import autosize from 'autosize';

export default {
    inheritAttrs: false,

    props: ['name', 'type', 'value', 'placeholder', 'label', 'errors'],

    data() {
        return {
            needsCorrection: false,
        }
    },

    watch: {
        errors(errors) {
            if (errors && errors.length && !this.needsCorrection) {
                this.needsCorrection = true;
            }
        }
    },

    mounted() {
        autosize(this.$refs.textarea);
    },

    computed: {
        hasError() {
            return this.errors && this.errors.length;
        },
    },

    methods: {
        handleInput(event) {
            if (this.needsCorrection) {
                this.needsCorrection = false;
            }

            this.$emit('input', event.target.value);
        },
    },
};
</script>
