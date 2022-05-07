<template>
    <div
        class="modal modal-blur fade"
        id="modal-retrieve-many-contact"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-sm modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Are you sure?</div>
                    <div>
                        If you proceed, you will untrash
                        {{ contacts.length }} Contact !
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-success"
                        data-bs-dismiss="modal"
                        @click="retrieveContacts()"
                    >
                        Yes, retrieve contact
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    name: "RetrieveModal",
    props: {
        contacts: Array,
    },
    setup(props) {
        const form = useForm({
            contacts_ids: props.contacts,
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
        retrieveContacts() {
            this.form.post("trash/retrieve-many", {
                onSuccess: () => {
                    this.form.reset();
                },
            });
        },
    },
};
</script>

<style></style>
