<template>
    <div
        class="modal modal-blur fade"
        id="modal-group-contacts"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-full-width modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Contacts to Add</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="col-12" v-if="contacts.length !== 0">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Contacts</h3>
                            </div>
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <div class="text-muted">
                                        Showing All entries
                                    </div>
                                    <div class="ms-auto text-muted">
                                        Search:
                                        <div class="ms-2 d-inline-block">
                                            <input
                                                type="text"
                                                class="form-control form-control-sm"
                                                v-model="searchForm.search"
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
                                                    aria-label="Select all contacts"
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
                                                        v-model="form.contacts"
                                                        aria-label="Select contact"
                                                    />
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{
                                                        index
                                                    }}</span>
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
                                                            p.pivot.value || "_"
                                                        }}
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                        <template v-else>
                                            <tr
                                                v-for="(
                                                    contact, index
                                                ) in contacts"
                                                :key="contact.id"
                                            >
                                                <td>
                                                    <input
                                                        class="form-check-input m-0 align-middle"
                                                        type="checkbox"
                                                        :id="contact.id"
                                                        :value="contact.id"
                                                        v-model="form.contacts"
                                                        aria-label="Select contact"
                                                    />
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{
                                                        index
                                                    }}</span>
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
                                                            p.pivot.value || "_"
                                                        }}
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <Pagination :links="contacts.links" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn me-auto"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                    <p v-if="form.errors.contacts" class="text-white bg-red">
                        <span class="font-medium">{{
                            form.errors.contacts
                        }}</span>
                    </p>

                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="groupContacts"
                    >
                        Add Selected Contacts
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "./../../../Pagination/Pagination";
import axios from "axios";
export default {
    name: "CreateModal",
    props: {
        contacts: Object,
        properties: Array,
    },
    components: {
        Pagination,
    },
    data() {
        return {
            csrfToken: null,
            results: [],
        };
    },
    setup() {
        const form = useForm({
            contacts: [],
            all: false,
        });
        const searchForm = useForm({
            search: null,
        });
        function lowercase(val) {
            return val.toLowerCase();
        }

        return { form, searchForm, lowercase };
    },
    mounted() {
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    },
    watch: {
        "searchForm.search": function (val) {
            if (val === "") {
                this.results = [];
            } else
                axios
                    .get("/contacts/list/group/search", {
                        params: { keywords: val },
                    })
                    .then((response) => (this.results = response.data))
                    .catch((error) => {});
        },
        "form.all": function (checked) {
            if (checked) {
                this.contacts.forEach((element) => {
                    this.form.contacts.push(element.id);
                });
            } else {
                this.form.contacts = [];
            }
        },
    },
    methods: {
        groupContacts() {
            this.form.post("/contacts/list/group/store", {
                onSuccess: () => {
                    this.form.reset();
                    document.querySelector("#modal-group-contacts").click();
                },
            });
        },
    },
};
</script>

<style scoped>
.table-responsive {
    height: 500px;
    overflow: scroll;
}
</style>
