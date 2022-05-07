<template>
    <div class="col-sm-6 col-lg-3">
        <!-- :href="route('contacts.list.group.contacts')" -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Name</div>
                </div>
                <Link
                    class="links"
                    :data="{ group_id: group.id }"
                    :href="route('contacts.list.group.contacts')"
                >
                    <div class="h1 mb-3">{{ group.group_name }}</div>
                </Link>
                <div class="d-flex mb-2 align-items-center">
                    <div class="subheader">Description</div>
                </div>
                <div class="h4 mb-3">{{ group.group_description }}</div>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar"
                            ><!-- Download SVG icon from http://tabler-icons.io/i/user -->
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
                                <circle cx="12" cy="7" r="4"></circle>
                                <path
                                    d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                ></path>
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ group.contacts_count }} Contacts
                        </div>
                    </div>
                </div>
                <div class="hr-text">Actions</div>
                <div class="row" v-if="!trash">
                    <div class="col">
                        <a
                            class="btn btn-ghost-success active w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-update-group"
                            @click="toggleEditModal(group.id)"
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
                                <line x1="16" y1="5" x2="19" y2="8" />
                            </svg>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            class="btn btn-ghost-danger active w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-delete-group"
                            @click="toggleDeleteModal(group.id)"
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
                        </a>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col">
                        <a
                            class="btn btn-ghost-success active w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-retrieve-group"
                            @click="toggleRetrieveModal(group.id)"
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
                                <line x1="3" y1="3" x2="21" y2="21" />
                                <path d="M4 7h3m4 0h9" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="14" x2="14" y2="17" />
                                <path
                                    d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l.077 -.923"
                                />
                                <line x1="18.384" y1="14.373" x2="19" y2="7" />
                                <path
                                    d="M9 5v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                />
                            </svg>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            class="btn btn-ghost-danger active w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-delete-group"
                            @click="toggleDeleteModal(group.id)"
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
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "GroupCard",
    props: {
        group: Object,
        trash: Boolean,
    },
    methods: {
        toggleEditModal(id) {
            this.$emit("toggle_edit_modal", id);
        },
        toggleDeleteModal(id) {
            this.$emit("toggle_delete_modal", id);
        },
        toggleRetrieveModal(id) {
            this.$emit("toggle_retrieve_modal", id);
        },
    },
};
</script>

<style scoped>
.links {
    text-decoration: none;
}
</style>
