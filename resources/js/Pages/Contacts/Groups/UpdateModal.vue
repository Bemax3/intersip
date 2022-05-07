<template>
    <div
        class="modal modal-blur fade"
        id="modal-update-group"
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
                    <h5 class="modal-title">Edit Group</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="updateGroup">
                    <input type="hidden" :value="csrfToken" name="_token" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Group Name</label>
                                    <input
                                        :class="[
                                            form.errors.group_name
                                                ? 'is-invalid'
                                                : '',
                                        ]"
                                        type="text"
                                        class="form-control"
                                        v-model="form.group_name"
                                        placeholder="Group Name"
                                    />
                                    <div
                                        v-if="form.errors.group_name"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.group_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Group Description</label
                                    >
                                    <input
                                        :class="[
                                            form.errors.group_description
                                                ? 'is-invalid'
                                                : '',
                                        ]"
                                        type="text"
                                        v-model="form.group_description"
                                        class="form-control"
                                        placeholder="Group Description (Optional)"
                                    />
                                    <div
                                        v-if="form.errors.group_description"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.group_description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a
                            class="btn btn-link link-secondary"
                            data-bs-dismiss="modal"
                            id="modal-update-group-close"
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
                            Update Group
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
    name: "UpdateModal",
    props: {
        group: Object,
    },
    data() {
        return {
            csrfToken: null,
        };
    },
    setup(props) {
        const group = { ...props.group };
        const form = useForm({
            group_id: group.id,
            group_name: group.group_name,
            group_description: group.group_description,
        });

        return { form };
    },
    watch: {
        group: {
            handler() {
                this.form.group_id = this.group.id;
                this.form.group_name = this.group.group_name;
                this.form.group_description = this.group.group_description;
            },
        },
    },
    mounted() {
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    },
    methods: {
        updateGroup() {
            this.form.post("groups/update", {
                onSuccess: () => {
                    this.form.reset();
                    document.querySelector("#modal-update-group-close").click();
                },
            });
        },
    },
};
</script>

<style></style>
