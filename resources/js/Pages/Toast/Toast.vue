<template>
    <div
        class="alert alert-important alert-dismissible visible"
        :class="notif.type"
        role="alert"
        v-if="notif && show"
    >
        <div class="d-flex">
            <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <template v-if="notif.type === 'alert-success'">
                        <path d="M5 12l5 5l10 -10" />
                    </template>
                    <template v-else>
                        <circle cx="12" cy="12" r="9" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </template>
                </svg>
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
            </div>
            <div>{{ notif.body }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        notif: Object,
    },
    data() {
        return {
            show: false,
        };
    },
    mounted() {
        this.show = true;
        setTimeout(() => (this.show = false), 3000);
    },
    watch: {
        notif: {
            deep: true,
            handler() {
                this.show = true;
                setTimeout(() => (this.show = false), 3000);
            },
        },
    },
};
</script>

<style scoped>
.alert {
    position: sticky;
    bottom: 1rem;
    margin: 1rem;
    max-width: 400px;
}
</style>
