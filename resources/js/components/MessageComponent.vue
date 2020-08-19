<template>
    <div :class="cls">
        <strong style="font-weight: bold">{{ name }}</strong><br>
        <div :class="cls2">{{ message.content }}</div>
    </div>
</template>

<script>
export default {
    props: {
        user: Number,
        message: Object
    },
    computed: {
        isMe () {
            return this.message.from_id === this.user
        },
        cls () {
            let cls = ['col-md-10']
            if(this.isMe) {
                cls.push('offset-md-2 text-right')
            }
            return cls
        },
        cls2 () {
            let cls = ['bulle']
            if(this.isMe) {
                cls.push('mabulle')
            }
            return cls
        },
        name () {
            return this.isMe ? 'Moi' : this.message.from.name
        }
    }
}
</script>

<style>
.bulle {
    background-color: turquoise;
    border-radius: 50px;
    padding: 10px;
    color: white;
    display: inline-block;
    margin: 15px 0;
}
.mabulle {
    background-color: teal;
}
</style>
