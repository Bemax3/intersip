<template>
    <ul class="pagination m-0 ms-auto">
        <Link
            v-for="(link, p) in links"
            :key="p"
            :href="link.url"
            class="page-item"
            :class="[link.active ? 'active' : '']"
        >
            <li class="page-link">
                <template v-if="link.label === 'Previous'"
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
                        ></path>
                        <polyline points="15 6 9 12 15 18"></polyline>
                    </svg>
                </template>
                {{ link.label }}
                <template v-if="link.label === 'Next'"
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
                        ></path>
                        <polyline points="9 6 15 12 9 18"></polyline>
                    </svg>
                </template>
            </li>
        </Link>
    </ul>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        links: Array,
    },
};
</script>

<style></style>
