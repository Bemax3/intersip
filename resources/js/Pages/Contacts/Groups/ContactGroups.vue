<template>
    <app-content>
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Contact Groups</h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <!-- <span class="d-none d-sm-inline">
                                    <a href="#" class="btn btn-white">
                                        New view
                                    </a>
                                </span> -->
                                <a
                                    href="#"
                                    class="btn btn-primary d-none d-sm-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-create-group"
                                >
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
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="19"
                                        ></line>
                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>
                                    </svg>
                                    New Group
                                </a>
                                <Link
                                    as="button"
                                    :href="route('contacts.list.groups.trash')"
                                    class="btn btn-teal d-none d-sm-inline-block"
                                >
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
                                        />
                                        <line x1="4" y1="7" x2="20" y2="7" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                        <path
                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                                        />
                                        <path
                                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                        />
                                    </svg>
                                    Trash
                                </Link>
                                <Link
                                    :href="route('contacts.list.contacts')"
                                    class="btn btn-secondary d-none d-sm-inline-block"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevrons-left -->
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
                                        <polyline points="11 7 6 12 11 17" />
                                        <polyline points="17 7 12 12 17 17" />
                                    </svg>
                                    Back To Contacts
                                </Link>
                                <a
                                    href="#"
                                    class="btn btn-primary d-sm-none btn-icon"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-report"
                                    aria-label="Create new report"
                                >
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
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="19"
                                        ></line>
                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div
                        class="row row-deck row-cards"
                        v-if="groups.length !== 0"
                    >
                        <GroupCard
                            v-for="group in groups"
                            :key="group.id"
                            :group="group"
                            @toggle_edit_modal="toggleEditModal"
                            @toggle_delete_modal="toggleDeleteModal"
                        />
                    </div>
                    <div v-else>
                        <div class="empty">
                            <div class="empty-img">
                                <img
                                    src="../../../../img/static/illustrations/undraw_printing_invoices_5r4r.svg"
                                    height="128"
                                    alt=""
                                />
                            </div>
                            <p class="empty-title">No Groups found</p>
                            <p class="empty-subtitle text-muted">
                                Try Creating New Groups!
                            </p>
                            <div class="empty-action">
                                <a
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-create-group"
                                    class="btn btn-primary"
                                >
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
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="19"
                                        ></line>
                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>
                                    </svg>
                                    Add your first group
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <CreateModal />
        <UpdateModal v-if="groups.length !== 0" :group="editModal.group" />
        <DeleteModal :id="deleteModal" :trash="true" />
    </app-content>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { usePage } from "@inertiajs/inertia-vue3";
import GroupCard from "./GroupCard";
import AppContent from "../../AppContent";
import CreateModal from "./CreateModal";
import UpdateModal from "./UpdateModal";
import DeleteModal from "./DeleteModal";
export default {
    setup() {
        const groups = computed(() => usePage().props.value.groups);
        return {
            groups,
        };
    },
    data() {
        return {
            editModal: {
                group: this.groups[0],
            },
            deleteModal: {
                group_id: null,
            },
        };
    },

    components: {
        GroupCard,
        AppContent,
        CreateModal,
        UpdateModal,
        DeleteModal,
    },
    methods: {
        toggleEditModal(id) {
            this.editModal.group = this.groups.filter(
                (group) => group.id == id
            )[0];
        },
        toggleDeleteModal(id) {
            this.deleteModal.group_id = id;
        },
    },
};
</script>

<style></style>
