<template>
    <b-form-group 
        :label="label" 
        :label-for="id"
        >
        <b-form-select 
            :id="id" 
            :options="options"
            :value="value"
            @input.native="onInput($event.target.value)"
        >
        </b-form-select>
    </b-form-group>
</template>

<script>
    export default {
        name: 'BInput',
        props: {
            id: {
                type: String,
                require: true
            },
            label: {
                type: String,
                require: true
            },
            value: {
                type: String,
                require: true,
            },
            options: {
                type: Array,
                require: false
            },
        },

        methods: {
            onInput(value) {
                this.$emit('input', value);
            },
        },
    }
</script>