<template>
    <div
        class="modal modal-blur fade"
        id="modal-delete-selected-contact"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-sm modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    @click="close"
                ></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon mb-2 text-danger icon-lg"
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
                        <path d="M12 9v2m0 4v.01"></path>
                        <path
                            d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"
                        ></path>
                    </svg>
                    <h3>Are you sure?</h3>
                    <div class="text-muted">
                        Do you really want to delete these
                        {{ contacts.length }} contacts?
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a
                                    href="#"
                                    class="btn w-100"
                                    data-bs-dismiss="modal"
                                    @click="close"
                                >
                                    Cancel
                                </a>
                            </div>
                            <div class="col">
                                <a
                                    href="#"
                                    class="btn btn-danger w-100"
                                    data-bs-dismiss="modal"
                                    @click="deleteContact()"
                                >
                                    Delete Contacts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    name: "DeleteSelectedModal",
    props: {
        contacts: Array,
        trash: Boolean,
    },
    setup(props) {
        const form = useForm({
            contacts_ids: props.contacts,
            trash: props.trash,
        });

        return { form };
    },
    watch: {
        contacts: {
            deep: true,
            handler() {
                this.form.contacts_ids = this.contacts;
            },
        },
    },
    methods: {
        deleteContact() {
            this.form.post("/contacts/list/contacts/destroy-many", {
                onSuccess: () => {
                    this.form.reset();
                },
            });
        },
    },
};
</script>

<style></style>
