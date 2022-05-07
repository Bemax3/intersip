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

                                <Link
                                    :href="route('contacts.list.groups')"
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
                                    Back To Groups
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
                            :trash="true"
                            @toggle_retrieve_modal="toggleRetrieveModal"
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
                            <p class="empty-title">No Deleted Groups !</p>
                            <p class="empty-subtitle text-muted">
                                Groups you delete will appear here !
                            </p>
                            <div class="empty-action">
                                <Link
                                    :href="route('contacts.list.groups')"
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
                                    Back To Groups
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DeleteModal :id="deleteModal" :trash="false" />
        <RetrieveModal :id="retrieveModal" />
    </app-content>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { usePage } from "@inertiajs/inertia-vue3";
import GroupCard from "./GroupCard";
import AppContent from "../../AppContent";
import RetrieveModal from "./RetrieveModal";
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
            retrieveModal: {
                group_id: null,
            },
            deleteModal: {
                group_id: null,
            },
        };
    },
    components: {
        GroupCard,
        AppContent,
        RetrieveModal,
        DeleteModal,
    },
    methods: {
        toggleRetrieveModal(id) {
            this.retrieveModal.group_id = id;
        },
        toggleDeleteModal(id) {
            this.deleteModal.group_id = id;
        },
    },
};
</script>

<style></style>
