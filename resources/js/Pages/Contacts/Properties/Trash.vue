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
                            <h2 class="page-title">
                                Contact List > Properties > Trashed
                            </h2>
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
                                    :href="route('contacts.list.properties')"
                                    :data="{ listId: listId }"
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
                                    Back To Properties
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
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table
                                    class="table table-vcenter card-table"
                                    v-if="properties.length !== 0"
                                >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Showing in Table</th>
                                            <th class="w-1"></th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="p in properties" :key="p.id">
                                            <td>{{ p.property_name }}</td>
                                            <td class="text-muted">
                                                {{ p.property_description }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge me-1"
                                                    :class="[
                                                        p.property_showing
                                                            ? 'bg-success'
                                                            : 'bg-danger',
                                                    ]"
                                                ></span
                                                >{{
                                                    p.property_showing
                                                        ? "Yes"
                                                        : "No"
                                                }}
                                            </td>
                                            <td>
                                                <a
                                                    class="btn btn-ghost-success active w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-retrieve-property"
                                                    @click="
                                                        toggleRetrieveModal(
                                                            p.id
                                                        )
                                                    "
                                                    ><!-- Download SVG icon from http://tabler-icons.io/i/trash-off -->
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
                                                        <line
                                                            x1="3"
                                                            y1="3"
                                                            x2="21"
                                                            y2="21"
                                                        />
                                                        <path
                                                            d="M4 7h3m4 0h9"
                                                        />
                                                        <line
                                                            x1="10"
                                                            y1="11"
                                                            x2="10"
                                                            y2="17"
                                                        />
                                                        <line
                                                            x1="14"
                                                            y1="14"
                                                            x2="14"
                                                            y2="17"
                                                        />
                                                        <path
                                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l.077 -.923"
                                                        />
                                                        <line
                                                            x1="18.384"
                                                            y1="14.373"
                                                            x2="19"
                                                            y2="7"
                                                        />
                                                        <path
                                                            d="M9 5v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                                        /></svg
                                                ></a>
                                            </td>
                                            <td>
                                                <a
                                                    class="btn btn-ghost-danger active w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete-property"
                                                    @click="
                                                        toggleDeleteModal(p.id)
                                                    "
                                                    ><!-- Download SVG icon from http://tabler-icons.io/i/trash-off -->
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
                                                        <line
                                                            x1="4"
                                                            y1="7"
                                                            x2="20"
                                                            y2="7"
                                                        />
                                                        <line
                                                            x1="10"
                                                            y1="11"
                                                            x2="10"
                                                            y2="17"
                                                        />
                                                        <line
                                                            x1="14"
                                                            y1="11"
                                                            x2="14"
                                                            y2="17"
                                                        />
                                                        <path
                                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                                                        />
                                                        <path
                                                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                                        /></svg
                                                ></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else>
                                    <div class="empty">
                                        <div class="empty-img">
                                            <img
                                                src="../../../../img/static/illustrations/undraw_printing_invoices_5r4r.svg"
                                                height="128"
                                                alt=""
                                            />
                                        </div>
                                        <p class="empty-title">
                                            No Trashed Elements
                                        </p>
                                        <p class="empty-subtitle text-muted">
                                            Peoperties Trashed will appear here
                                            !
                                        </p>
                                        <div class="empty-action">
                                            <Link
                                                :href="
                                                    route(
                                                        'contacts.list.properties'
                                                    )
                                                "
                                                :data="{ listId: listId }"
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
                                                    <polyline
                                                        points="11 7 6 12 11 17"
                                                    />
                                                    <polyline
                                                        points="17 7 12 12 17 17"
                                                    />
                                                </svg>
                                                Back To Properties
                                            </Link>
                                        </div>
                                    </div>
                                </div>
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
import RetrieveModal from "./RetrieveModal";
import DeleteModal from "./DeleteModal";
import AppContent from "../../AppContent.vue";
export default {
    setup() {
        const properties = computed(() => usePage().props.value.properties);
        const listId = computed(() => usePage().props.value.listId);

        return {
            properties,
            listId,
        };
    },
    data() {
        return {
            retrieveModal: {
                property_id: null,
            },
            deleteModal: {
                property_id: null,
            },
        };
    },
    methods: {
        toggleDeleteModal(id) {
            this.deleteModal.property_id = id;
        },
        toggleRetrieveModal(id) {
            this.retrieveModal.property_id = id;
        },
    },
    components: { AppContent, RetrieveModal, DeleteModal },
};
</script>

<style></style>
