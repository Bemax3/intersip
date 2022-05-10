<template>
    <div
        class="modal modal-blur fade"
        id="modal-add-property"
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
                    <h5 class="modal-title">New Property</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="addProperty">
                    <input type="hidden" :value="csrfToken" name="_token" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Property Name</label
                                    >
                                    <input
                                        :class="[
                                            form.errors.property_name
                                                ? 'is-invalid'
                                                : '',
                                        ]"
                                        type="text"
                                        class="form-control"
                                        v-model="form.property_name"
                                        placeholder="Property Name"
                                    />
                                    <div
                                        v-if="form.errors.property_name"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.property_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Property Description</label
                                    >
                                    <input
                                        :class="[
                                            form.errors.property_description
                                                ? 'is-invalid'
                                                : '',
                                        ]"
                                        type="text"
                                        v-model="form.property_description"
                                        class="form-control"
                                        placeholder="Property Description (Optional)"
                                    />
                                    <div
                                        v-if="form.errors.property_description"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.property_description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <div class="form-label">
                                    Show Property in table
                                </div>
                                <label class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        v-model="form.property_showing"
                                    />
                                    <span class="form-check-label">Show</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a
                            class="btn btn-link link-secondary"
                            data-bs-dismiss="modal"
                            id="modal-add-property-close"
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
                            Create new Property
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
    name: "CreateModal",
    props: {},
    data() {
        return {
            csrfToken: null,
        };
    },
    setup() {
        const form = useForm({
            property_name: null,
            property_description: null,
            property_showing: true,
        });

        return { form };
    },
    mounted() {
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    },
    watch: {},
    methods: {
        addProperty() {
            this.form.post("properties/store", {
                onSuccess: () => {
                    this.form.reset();
                    document.querySelector("#modal-add-property-close").click();
                },
            });
        },
    },
};
</script>

<style></style>
