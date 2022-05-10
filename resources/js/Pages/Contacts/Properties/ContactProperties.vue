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
                                Contact List > Properties
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
                                <a
                                    href="#"
                                    class="btn btn-primary d-none d-sm-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-add-property"
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
                                    New Property
                                </a>
                                <Link
                                    as="button"
                                    :href="
                                        route('contacts.list.properties.trash')
                                    "
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
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
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
                                        <!-- <tr>
                                            <td>PhoneNumber</td>
                                            <td class="text-muted">
                                                The number of the contact
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-success me-1"
                                                ></span
                                                >Yes
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->
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
                                                    data-bs-target="#modal-edit-property"
                                                    @click="
                                                        toggleUpdateModal(p.id)
                                                    "
                                                    ><svg
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
                                                            d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"
                                                        />
                                                        <path
                                                            d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"
                                                        />
                                                        <line
                                                            x1="16"
                                                            y1="5"
                                                            x2="19"
                                                            y2="8"
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
                                                >
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
                                                        />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <CreateModal />
        <EditModal :property="updateModal.property" />
        <DeleteModal :id="deleteModal" :trash="true" />
    </app-content>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { usePage } from "@inertiajs/inertia-vue3";
import CreateModal from "./CreateModal";
import EditModal from "./EditModal";
import DeleteModal from "./DeleteModal";
import AppContent from "../../AppContent.vue";
export default {
    setup() {
        const properties = computed(() => usePage().props.value.properties);
        return {
            properties,
        };
    },
    data() {
        return {
            updateModal: {
                property: this.properties[0],
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
        toggleUpdateModal(id) {
            this.updateModal.property = this.properties.filter(
                (property) => property.id == id
            )[0];
        },
    },
    components: { AppContent, CreateModal, EditModal, DeleteModal },
};
</script>

<style></style>
