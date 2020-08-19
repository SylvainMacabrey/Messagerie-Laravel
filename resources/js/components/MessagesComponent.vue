<template>
    <div class="card">
        <div class="card-header">John</div>
        <div class="card-body conversations">
            <div class="row" v-for="message in messages">
                <Message :message="message" :user="user"/>
            </div>
            <form action="" method="post" class="text-center">
                <textarea name="content" v-model="content" :class="{ 'form-control mb-4': true, 'is-invalid': errors['content'] }" placeholder="Votre message" @keypress.enter="sendMessage"></textarea>
                <div class="invalid-feedback">{{ errors.content }}</div>
            </form>
        </div>
    </div>
</template>

<script>
import Message from './MessageComponent'
import { mapGetters } from 'vuex'
export default {
    components: { Message },
    data () {
        return {
            content: '',
            errors: {}
        }
    },
    computed: {
        ...mapGetters(['user']),
        messages: function () {
            return this.$store.getters.messages(this.$route.params.id)
        }
    },
    mounted () {
        this.loadMessages()
    },
    watch: {
        '$route.params.id': function () {
            this.loadMessages
        }
    },
    methods: {
        loadMessages () {
            this.$store.dispatch('loadMessages', this.$route.params.id)
        },
        async sendMessage (e) {
            if(e.shiftKey === false) {
                try {
                    await this.$store.dispatch('sendMessage', {
                        content: this.content,
                        userId: this.$route.params.id
                    })
                } catch (e) {
                    this.errors = e.errors || {}
                }
            }
        }
    }
}
</script>
