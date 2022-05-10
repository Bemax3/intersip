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
                                Contact List > contacts > Trashed
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
                                    Back To contacts
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
                                <div
                                    class="col-12"
                                    v-if="contacts.data.length !== 0"
                                >
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Contacts</h3>
                                        </div>
                                        <div
                                            class="card-body border-bottom py-3"
                                        >
                                            <div class="d-flex">
                                                <div class="text-muted">
                                                    Show
                                                    <div
                                                        class="mx-2 d-inline-block"
                                                    >
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm"
                                                            v-model="
                                                                perPageForm.amount
                                                            "
                                                            size="3"
                                                            aria-label="Invoices count"
                                                        />
                                                    </div>
                                                    entries
                                                </div>
                                                <div class="ms-auto text-muted">
                                                    Search:
                                                    <div
                                                        class="ms-2 d-inline-block"
                                                    >
                                                        <input
                                                            type="text"
                                                            v-model="
                                                                searchForm.search
                                                            "
                                                            class="form-control form-control-sm"
                                                            aria-label="Search invoice"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table card-table table-vcenter text-nowrap datatable"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th class="w-1">
                                                            <input
                                                                class="form-check-input m-0 align-middle"
                                                                v-model="
                                                                    form.all
                                                                "
                                                                type="checkbox"
                                                                aria-label="Select all invoices"
                                                            />
                                                        </th>
                                                        <th class="w-1">
                                                            No.
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-sm text-dark icon-thick"
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
                                                                <polyline
                                                                    points="6 15 12 9 18 15"
                                                                ></polyline>
                                                            </svg>
                                                        </th>
                                                        <th>Phone Number</th>

                                                        <th
                                                            v-for="p in properties"
                                                            :key="p.id"
                                                        >
                                                            {{
                                                                p.property_name
                                                            }}
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template
                                                        v-if="
                                                            results.length > 0
                                                        "
                                                    >
                                                        <tr
                                                            v-for="(
                                                                contact, index
                                                            ) in results"
                                                            :key="contact.id"
                                                        >
                                                            <td>
                                                                <input
                                                                    class="form-check-input m-0 align-middle"
                                                                    type="checkbox"
                                                                    :id="
                                                                        contact.id
                                                                    "
                                                                    :value="
                                                                        contact.id
                                                                    "
                                                                    v-model="
                                                                        form.contacts
                                                                    "
                                                                    aria-label="Select invoice"
                                                                />
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-muted"
                                                                    >{{
                                                                        index +
                                                                        1
                                                                    }}</span
                                                                >
                                                            </td>
                                                            <td>
                                                                {{
                                                                    contact.contact_phone_number
                                                                }}
                                                            </td>

                                                            <template
                                                                v-for="p in contact.properties"
                                                                :key="p.id"
                                                            >
                                                                <td
                                                                    v-if="
                                                                        p.property_showing
                                                                    "
                                                                >
                                                                    {{
                                                                        p.pivot
                                                                            .value ||
                                                                        "_"
                                                                    }}
                                                                </td>
                                                            </template>
                                                            <td>
                                                                <a
                                                                    class="btn btn-ghost-success active w-100"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-retrieve-contact"
                                                                    @click="
                                                                        toggleRetrieveModal(
                                                                            contact.id
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
                                                                    data-bs-target="#modal-delete-contact"
                                                                    @click="
                                                                        toggleDeleteModal(
                                                                            contact.id
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
                                                    </template>
                                                    <template v-else>
                                                        <tr
                                                            v-for="(
                                                                contact, index
                                                            ) in contacts.data"
                                                            :key="contact.id"
                                                        >
                                                            <td>
                                                                <input
                                                                    class="form-check-input m-0 align-middle"
                                                                    type="checkbox"
                                                                    :id="
                                                                        contact.id
                                                                    "
                                                                    :value="
                                                                        contact.id
                                                                    "
                                                                    v-model="
                                                                        form.contacts
                                                                    "
                                                                    aria-label="Select invoice"
                                                                />
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-muted"
                                                                    >{{
                                                                        index +
                                                                        1
                                                                    }}</span
                                                                >
                                                            </td>
                                                            <td>
                                                                {{
                                                                    contact.contact_phone_number
                                                                }}
                                                            </td>

                                                            <template
                                                                v-for="p in contact.properties"
                                                                :key="p.id"
                                                            >
                                                                <td
                                                                    v-if="
                                                                        p.property_showing
                                                                    "
                                                                >
                                                                    {{
                                                                        p.pivot
                                                                            .value ||
                                                                        "_"
                                                                    }}
                                                                </td>
                                                            </template>

                                                            <td>
                                                                <a
                                                                    class="btn btn-ghost-success active w-100"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-retrieve-contact"
                                                                    @click="
                                                                        toggleRetrieveModal(
                                                                            contact.id
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
                                                                    data-bs-target="#modal-delete-contact"
                                                                    @click="
                                                                        toggleDeleteModal(
                                                                            contact.id
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
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            class="card-footer d-flex align-items-center"
                                        >
                                            <p class="m-0 text-muted">
                                                <button
                                                    class="btn btn-ghost-success active w-100"
                                                    data-bs-toggle="modal"
                                                    :disabled="
                                                        form.contacts.length ==
                                                        0
                                                    "
                                                    data-bs-target="#modal-retrieve-many-contact"
                                                    @click="
                                                        toggleRetrieveSelectedModal()
                                                    "
                                                >
                                                    Retrieve Selected &nbsp;
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
                                                        />
                                                    </svg>
                                                </button>
                                            </p>
                                            <p class="m-0 text-muted">
                                                <button
                                                    class="btn btn-ghost-danger active w-100"
                                                    data-bs-toggle="modal"
                                                    :disabled="
                                                        form.contacts.length ==
                                                        0
                                                    "
                                                    data-bs-target="#modal-delete-selected-contact"
                                                    @click="
                                                        toggleDeleteSelectedModal()
                                                    "
                                                >
                                                    Delete Selected &nbsp;
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
                                                </button>
                                            </p>
                                            <Pagination
                                                :links="contacts.links"
                                            />
                                        </div>
                                    </div>
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
                                        <p class="empty-title">
                                            No Trashed Elements
                                        </p>
                                        <p class="empty-subtitle text-muted">
                                            Trashed Contacts will appear here !
                                        </p>
                                        <div class="empty-action">
                                            <Link
                                                :href="
                                                    route(
                                                        'contacts.list.contacts'
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
                                                Back To contacts
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
        <DeleteSelectedModal :contacts="contactsToDelete" :trash="false" />
        <DeleteModal :id="deleteModal" :trash="false" />
        <RetrieveSelectedContacts :contacts="contactsToRetrieve" />
        <RetrieveModal :id="retrieveModal" />
    </app-content>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { usePage, useForm } from "@inertiajs/inertia-vue3";
import RetrieveModal from "./RetrieveModal";
import DeleteModal from "./DeleteModal";
import RetrieveSelectedContacts from "./RetrieveSelectedContacts";
import Pagination from "./../../Pagination/Pagination";
import DeleteSelectedModal from "./DeleteSelectedModal";
import AppContent from "../../AppContent.vue";
import axios from "axios";
export default {
    setup() {
        const contacts = computed(() => usePage().props.value.contacts);
        const properties = computed(() => usePage().props.value.properties);
        const amount = computed(() => usePage().props.value.pagination);
        const form = useForm({
            contacts: [],
            all: false,
        });
        const searchForm = useForm({
            search: null,
        });
        const perPageForm = useForm({
            amount: amount.value,
        });
        function lowercase(val) {
            return val.toLowerCase();
        }
        return {
            properties,
            contacts,
            perPageForm,
            form,
            lowercase,
            searchForm,
        };
    },
    data() {
        return {
            retrieveModal: {
                contact_id: null,
            },
            deleteModal: {
                contact_id: null,
            },
            contactsToRetrieve: this.form.contacts,
            contactsToDelete: this.form.contacts,
            results: [],
        };
    },
    watch: {
        "searchForm.search": function (val) {
            if (val === "") {
                this.results = [];
                this.contacts = computed(() => usePage().props.value.contacts);
            } else
                axios
                    .get("/contacts/list/contacts/trash/search", {
                        params: { keywords: val },
                    })
                    .then((response) => (this.results = response.data))
                    .catch((error) => {});
        },
        "perPageForm.amount": function (val) {
            if (val === "" || val.length < 2) {
                this.contacts = computed(() => usePage().props.value.contacts);
            } else window.location.href = "trash?amount=" + val;
        },
        "form.all": function (checked) {
            if (checked) {
                this.contacts.data.forEach((element) => {
                    this.form.contacts.push(element.id);
                });
            } else {
                this.form.contacts = [];
            }
        },
    },
    methods: {
        toggleDeleteModal(id) {
            this.deleteModal.contact_id = id;
        },
        toggleRetrieveModal(id) {
            this.retrieveModal.contact_id = id;
        },
        toggleRetrieveSelectedModal() {
            this.contactsToRetrieve = this.form.contacts;
        },
        toggleDeleteSelectedModal() {
            this.contactsToDelete = this.form.contacts;
        },
    },
    components: {
        AppContent,
        RetrieveModal,
        Pagination,
        RetrieveSelectedContacts,
        DeleteSelectedModal,
        DeleteModal,
    },
};
</script>

<style></style>
