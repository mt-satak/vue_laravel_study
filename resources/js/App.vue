<!--ルートコンポーネント-->
<template>
    <div>
        <header>
            <NavBar />
        </header>
        <main>
            <div class="container">
                <Message />
                <RouterView />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
import Message from './components/Message.vue';
import NavBar from './components/NavBar.vue';
import Footer from './components/Footer.vue';
import { INTERNAL_SERVER_ERROR } from "./util";

export default {
    components: {
        Message,
        NavBar,
        Footer
    },
    computed: {
        errorCode () {
            return this.$store.state.error.code;
        }
    },
    watch: {
        errorCode: {
            handler (val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500');
                }
            },
            immediate: true
        },
        $route () {
            this.$store.commit('error/setCode', null);
        }
    }
}
</script>