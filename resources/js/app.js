import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'
import Messagerie from './components/MessagerieComponent'
import Messages from './components/MessagesComponent'

Vue.use(VueRouter)

let $messagerie = document.querySelector('#messagerie')

if($messagerie) {

    const routes = [
        { path : '/'},
        { path : '/:id', component: Messages, name: 'conversation'},
    ]

    const router = new VueRouter({
        mode: 'history',
        routes,
        base: $messagerie.getAttribute('data-base')
    })

    new Vue({
        el: '#messagerie',
        components: { Messagerie },
        store,
        router
    })

}

