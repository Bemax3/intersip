<template>
    <Link
        class="links"
        :href="route('contacts.list.contacts')"
        :data="{ listId: list.id }"
    >
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Name</div>
                    </div>
                    <div class="h1 mb-3">{{ list.contact_list_name }}</div>
                    <div class="d-flex mb-2">
                        <div>Description</div>
                        <div class="ms-auto">
                            <span class="d-inline-flex align-items-center lh-1">
                                {{ list.contact_list_description }}
                            </span>
                        </div>
                    </div>
                    <!-- <div class="progress progress-sm">
                    <div
                        class="progress-bar bg-blue"
                        style="width: 75%"
                        role="progressbar"
                        aria-valuenow="75"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <span class="visually-hidden">75% Complete</span>
                    </div>
                </div> -->
                </div>
            </div>
        </div>
    </Link>
</template>

<script>
export default {
    name: "ListCard",
    props: {
        list: Object,
    },
};
</script>

<style scoped>
.links {
    text-decoration: none;
}
</style>
