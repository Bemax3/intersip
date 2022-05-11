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
                            <h2 class="page-title">Contacts</h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <span class="d-none d-sm-inline">
                                    <a
                                        class="btn dropdown-toggle"
                                        href="#navbar-base"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"
                                        role="button"
                                        aria-expanded="false"
                                    >
                                        <span class="nav-link-title">
                                            Import Contacts
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a
                                                    class="dropdown-item"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-import"
                                                >
                                                    Import Excel File
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    :href="
                                                        route(
                                                            'contacts.download.template'
                                                        )
                                                    "
                                                >
                                                    Download Template
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <a
                                    href="#"
                                    class="btn btn-primary d-none d-sm-inline-block"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-create-contact"
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
                                    New Contact
                                </a>
                                <Link
                                    as="button"
                                    :href="route('contacts.list.properties')"
                                    class="btn btn-info d-none d-sm-inline-block"
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
                                        <path
                                            d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"
                                        />
                                        <path
                                            d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"
                                        />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    Properties
                                </Link>
                                <Link
                                    as="button"
                                    :href="route('contacts.list.groups')"
                                    class="btn btn-warning d-none d-sm-inline-block"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/users -->
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
                                        <circle cx="9" cy="7" r="4" />
                                        <path
                                            d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                        />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path
                                            d="M21 21v-2a4 4 0 0 0 -3 -3.85"
                                        />
                                    </svg>
                                    Groups
                                </Link>
                                <Link
                                    as="button"
                                    :href="
                                        route('contacts.list.contacts.trash')
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
                                <a
                                    href="#"
                                    class="btn btn-primary d-sm-none btn-icon"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-create-contact"
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
                    <div class="row row-deck row-cards">
                        <div class="col-12" v-if="contacts.data.length !== 0">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Contacts</h3>
                                </div>
                                <div class="card-body border-bottom py-3">
                                    <div class="d-flex">
                                        <div class="text-muted">
                                            Show
                                            <div class="mx-2 d-inline-block">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    v-model="perPageForm.amount"
                                                    size="3"
                                                    aria-label="Invoices count"
                                                />
                                            </div>
                                            entries
                                        </div>
                                        <div class="ms-auto text-muted">
                                            Search:
                                            <div class="ms-2 d-inline-block">
                                                <input
                                                    type="text"
                                                    v-model="searchForm.search"
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
                                                        type="checkbox"
                                                        v-model="form.all"
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
                                                    {{ p.property_name }}
                                                </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="results.length > 0">
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
                                                            :id="contact.id"
                                                            :value="contact.id"
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
                                                                index + 1
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
                                                                p.pivot.value ||
                                                                "_"
                                                            }}
                                                        </td>
                                                    </template>
                                                    <td>
                                                        <a
                                                            class="btn btn-ghost-success active w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit-contact"
                                                            @click="
                                                                toggleEditResultModal(
                                                                    contact.id
                                                                )
                                                            "
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
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
                                                                />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    <td class="text-end">
                                                        <a
                                                            class="btn btn-ghost-danger active w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-delete-contact"
                                                            @click="
                                                                toggleDeleteModal(
                                                                    contact.id
                                                                )
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
                                            </template>
                                            <template v-else
                                                ><tr
                                                    v-for="(
                                                        contact, index
                                                    ) in contacts.data"
                                                    :key="contact.id"
                                                >
                                                    <td>
                                                        <input
                                                            class="form-check-input m-0 align-middle"
                                                            type="checkbox"
                                                            :id="contact.id"
                                                            :value="contact.id"
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
                                                                index + 1
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
                                                                p.pivot.value ||
                                                                "_"
                                                            }}
                                                        </td>
                                                    </template>
                                                    <td>
                                                        <a
                                                            class="btn btn-ghost-success active w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit-contact"
                                                            @click="
                                                                toggleEditModal(
                                                                    contact.id
                                                                )
                                                            "
                                                        >
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
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
                                                                />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    <td class="text-end">
                                                        <a
                                                            class="btn btn-ghost-danger active w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-delete-contact"
                                                            @click="
                                                                toggleDeleteModal(
                                                                    contact.id
                                                                )
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
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    class="card-footer d-flex align-items-center"
                                >
                                    <p class="m-0 text-muted">
                                        <button
                                            class="btn btn-ghost-danger active w-100"
                                            data-bs-toggle="modal"
                                            :disabled="
                                                form.contacts.length == 0
                                            "
                                            data-bs-target="#modal-delete-selected-contact"
                                            @click="toggleDeleteSelectedModal()"
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
                                    <Pagination :links="contacts.links" />
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
                                <p class="empty-title">No Contacts found</p>
                                <p class="empty-subtitle text-muted">
                                    Try Creating New Contacts or Import Some !
                                </p>
                                <div class="empty-action">
                                    <a
                                        href="#"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-create-contact"
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
                                        Add your first contact
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <DeleteModal :id="deleteModal" :trash="true" />
            <CreateModal :countries="countries" :properties="properties" />
            <DeleteSelectedModal :contacts="contactsToDelete" :trash="true" />
            <UpdateModal
                v-if="
                    contacts.data.length !== 0 && updateModal.contact !== null
                "
                :countries="countries"
                :contact="updateModal.contact"
                :properties="properties"
            />
            <ImportModal :contactsImport="$page.props.imports.contactsImport" />
        </div>
    </app-content>
</template>

<script>
import { computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppContent from "./../../AppContent";
import Pagination from "./../../Pagination/Pagination";
import DeleteModal from "./DeleteModal";
import CreateModal from "./CreateModal";
import UpdateModal from "./UpdateModal";
import ImportModal from "./ImportModal";
import DeleteSelectedModal from "./DeleteSelectedModal";
import { usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";
export default {
    setup() {
        const contacts = computed(() => usePage().props.value.contacts);
        const countries = computed(() => usePage().props.value.countries);
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
            contacts,
            countries,
            properties,
            form,
            searchForm,
            perPageForm,
            lowercase,
        };
    },
    data() {
        return {
            deleteModal: {
                contact_id: null,
            },
            updateModal: {
                contact:
                    this.contacts.data.length > 0
                        ? this.contacts.data[0]
                        : null,
            },
            contactsToDelete: this.form.contacts,
            results: [],
        };
    },
    components: {
        AppContent,
        Pagination,
        DeleteModal,
        CreateModal,
        UpdateModal,
        ImportModal,
        DeleteSelectedModal,
    },
    watch: {
        "searchForm.search": function (val) {
            if (val === "") {
                this.results = [];
                this.contacts = computed(() => usePage().props.value.contacts);
            } else
                axios
                    .get("list/contacts/search", { params: { keywords: val } })
                    .then((response) => (this.results = response.data))
                    .catch((error) => {});
        },
        "perPageForm.amount": function (val) {
            if (val === "" || val.length < 2) {
                this.contacts = computed(() => usePage().props.value.contacts);
            } else window.location.href = "list?amount=" + val;
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
        toggleEditModal(id) {
            this.updateModal.contact = this.contacts.data.filter(
                (contact) => contact.id == id
            )[0];
        },
        toggleEditResultModal(id) {
            this.updateModal.contact = this.results.filter(
                (contact) => contact.id == id
            )[0];
        },
        toggleDeleteSelectedModal() {
            this.contactsToDelete = this.form.contacts;
        },
    },
};
</script>

<style></style>
