<template>
    <div class="wrapper">
        <Header />
        <NavBar />
        <slot></slot>
        <Footer />
        <Toast :notif="$page.props.flash.message" />
    </div>
</template>

<script>
import Header from "./Header/Header";
import Footer from "./Footer/Footer";
import NavBar from "./NavBar/NavBar";
import Toast from "./Toast/Toast.vue";
export default {
    components: {
        Header,
        Footer,
        NavBar,
        Toast,
    },
};
</script>

<style></style>
