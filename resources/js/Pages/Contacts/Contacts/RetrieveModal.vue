<template>
    <div
        class="modal modal-blur fade"
        id="modal-retrieve-contact"
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
                    <div>If you proceed, you will untrash this Contact !</div>
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
                        @click="retrieveProperty()"
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
        id: Object,
    },
    setup(props) {
        const form = useForm({
            contact_id: props.id.contact_id,
        });

        return { form };
    },
    watch: {
        id: {
            deep: true,
            handler() {
                this.form.contact_id = this.id.contact_id;
            },
        },
    },
    methods: {
        retrieveProperty() {
            this.form.post("trash/retrieve", {
                onSuccess: () => {
                    this.form.reset();
                },
            });
        },
    },
};
</script>

<style></style>
