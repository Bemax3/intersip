<template>
    <div
        class="modal modal-blur fade"
        id="modal-import"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
            v-if="!contactsImport"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Contacts</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="importContacts">
                    <input type="hidden" :value="csrfToken" name="_token" />
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Excel File</label>
                            <input
                                :class="[form.errors.file ? 'is-invalid' : '']"
                                type="file"
                                class="form-control"
                                @input="form.file = $event.target.files[0]"
                                placeholder="Excel File"
                            />
                            <div
                                v-if="form.errors.file"
                                class="invalid-feedback"
                            >
                                {{ form.errors.file }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a
                            class="btn btn-link link-secondary"
                            data-bs-dismiss="modal"
                            id="import-modal-close"
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
                            Next
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
            v-else
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fields</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <form @submit.prevent="createContactsFields">
                    <div
                        class="modal-body"
                        v-if="fieldsForm.fields.length !== 0"
                    >
                        <div class="row">
                            <div
                                class="col-lg-4"
                                v-for="(field, index) in fieldsForm.fields"
                                :key="index"
                            >
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Detected New Field</label
                                    >
                                    <input
                                        class="form-control"
                                        type="text"
                                        v-model="fieldsForm.fields[index]"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="modal-body">No New Fields Detected !</div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn me-auto"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <div class="alert alert-warning" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-octagon -->
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
                                        />
                                        <path
                                            d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z"
                                        />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line
                                            x1="12"
                                            y1="16"
                                            x2="12.01"
                                            y2="16"
                                        />
                                    </svg>
                                </div>
                                <div>Existing Numbers Will Be Updated !</div>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                        >
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    name: "ImportModal",
    props: {
        contactsImport: Object,
    },
    watch: {
        contactsImport: function (newVal, old) {
            if (newVal !== null) {
                this.fieldsForm.fields = newVal.fields;
                this.fieldsForm.filepath = newVal.filepath;
            }
        },
    },
    data() {
        const fieldsForm = useForm({
            fields: null,
            filepath: null,
        });
        return {
            csrfToken: null,
            fieldsForm,
        };
    },
    setup() {
        const form = useForm({
            file: null,
        });
        return { form };
    },
    mounted() {
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    },
    methods: {
        importContacts() {
            this.form.post("list/contacts/import", {
                onSuccess: () => {
                    this.form.reset();
                    // document.querySelector("#import-modal-close").click();
                },
            });
        },
        createContactsFields() {
            this.fieldsForm.post("list/contacts/import/new-fields", {
                onSuccess: () => {
                    this.fieldsForm.reset();
                    // location.reload();
                },
            });
        },
    },
};
</script>

<style></style>
