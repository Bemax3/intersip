<template>
    <div
        class="modal modal-blur fade"
        id="modal-retrieve-group"
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
                    <div>If you proceed, you will untrash this Group !</div>
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
                        @click="retrieveGroup()"
                    >
                        Yes, retrieve group
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
            group_id: props.id.group_id,
        });

        return { form };
    },
    watch: {
        id: {
            deep: true,
            handler() {
                this.form.group_id = this.id.group_id;
            },
        },
    },
    methods: {
        retrieveGroup() {
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
