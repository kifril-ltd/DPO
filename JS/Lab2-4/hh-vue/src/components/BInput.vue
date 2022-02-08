<template>
    <b-form-group 
        :label="label" 
        :label-for="id" 
    >
        <b-form-input
                :id="id" 
                :placeholder="placeholder"
                :type="type"
                :state="isValid ? null : false"
                aria-describedby="invalid-message"
                :value="value"
                @input.native="onInput($event.target.value)"
        >
        </b-form-input>
        <b-form-invalid-feedback id="invalid-message">
            <ul id="error-messages">
                <li v-for="error in errors" :key="error">
                    {{ error }}
                </li>
            </ul>
        </b-form-invalid-feedback>
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
            placeholder: {
                type: String,
                require: false,
                default: ''
            },
            type: {
                type: String,
                require: false,
                default: 'text'
            },
            value: {
                type: String,
                require: true,
            },
            rules: {
                type: Array,
                require: false
            },
        },

        data() {
            return {
                isValid: true,
                errors: [],
            }
        },

        methods: {
            onInput(value) {
                
                if (this.rules) {
                    this.validate(value);
                }
                
                this.$emit('input', value);
                this.$emit('validation', !this.isValid);
            },

            validate(value) {
                this.errors = [];
                this.isValid = true;

                for (const rule of this.rules) {
                  if (value && !rule.regex.test(value)) {
                    this.errors.push(rule.message)
                    this.isValid = false;
                  }
                  if (!value)
                    this.isValid = false;
                }
            }
        },
    }
</script>