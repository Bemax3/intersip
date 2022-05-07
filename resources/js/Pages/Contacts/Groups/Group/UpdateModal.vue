<template>
    <div
        class="modal modal-blur fade"
        id="modal-edit-contact"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Contact</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="updateContact">
                    <input type="hidden" :value="csrfToken" name="_token" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select
                                        class="form-select"
                                        v-model="form.country"
                                    >
                                        <option
                                            v-for="country in countries"
                                            :key="country.id"
                                            :value="country.id"
                                        >
                                            {{
                                                country.settings_country_short_name
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Phone Number</label
                                    >
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            +{{ form.code }}
                                        </span>
                                        <input
                                            :class="[
                                                form.errors.number
                                                    ? 'is-invalid'
                                                    : '',
                                            ]"
                                            v-model="form.number"
                                            type="text"
                                            class="form-control ps-0"
                                            autocomplete="off"
                                        />
                                        <div
                                            v-if="form.errors.number"
                                            class="invalid-feedback"
                                        >
                                            {{ form.errors.number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-lg-4"
                                v-for="(field, index) in form.fields"
                                :key="index"
                            >
                                <div class="mb-3">
                                    <label class="form-label">{{
                                        field.property_name
                                    }}</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        v-model="form.fields[index].pivot.value"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a
                            class="btn btn-link link-secondary"
                            data-bs-dismiss="modal"
                            id="modal-edit-close"
                        >
                            Cancel
                        </a>
                        <button class="btn btn-primary ms-auto" type="submit">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/runtime-core";
export default {
    name: "UpdateModal",
    props: {
        countries: Array,
        contact: Object,
        properties: Object,
    },
    data() {
        return {
            csrfToken: null,
            code: this.countries.find((x) => x.id === this.contact.country_id)
                .settings_country_calling_code,
        };
    },
    setup(props) {
        const contact = { ...props.contact };
        const code = props.countries.find(
            (x) => x.id === contact.country_id
        ).settings_country_calling_code;
        const phone = contact.contact_phone_number.substring(code.length);
        const form = useForm({
            contact_id: contact.id,
            country: contact.country_id,
            code: code,
            fields: contact.properties,
            number: phone,
        });

        return { form };
    },
    mounted() {
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    },
    watch: {
        "form.country": function (val) {
            this.form.code = this.countries.find(
                (country) => country.id === val
            ).settings_country_calling_code;
        },
        countries: {
            handler() {},
        },
        contact: {
            handler() {
                const code = this.countries.find(
                    (x) => x.id === this.contact.country_id
                ).settings_country_calling_code;

                const phone = this.contact.contact_phone_number.substring(
                    code.length
                );
                this.form.contact_id = this.contact.id;
                this.form.country = this.contact.country_id;
                this.form.code = code;
                this.form.fields = this.contact.properties;
                this.form.number = phone;
            },
        },
    },
    methods: {
        updateContact() {
            this.form.post("/contacts/list/contacts/update", {
                onSuccess: () => {
                    this.form.reset();
                    document.querySelector("#modal-edit-close").click();
                },
            });
        },
    },
};
</script>

<style></style>
