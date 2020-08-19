import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const fetchApi = async function (url, options = {}) {
    let response = await fetch(url, {
        credentials: 'same-origin',
        headers: {
            'X-Request-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        ...options
    })
    if(response.ok) {
        return response.json()
    } else {
        throw await response.json()
    }
}

export default new Vuex.Store({
    strict: true,
    state: {
        user: null,
        conversations: {}
    },
    getters: {
        user: (state) => {
            return state.user
        },
        conversations: (state) => {
            return state.conversations
        },
        conversation: (state) => {
            return (id) => {
                return state.conversations[id] || {}
            }
        },
        messages : (state) => {
            return (id) => {
                let conversation = state.conversations[id]
                if(conversation && conversation.messages) {
                    return conversation.messages
                } else {
                    return []
                }
            }
        }
    },
    mutations: {
        setUser: (state, userId) => {
            state.user = userId
        },
        addConversations: (state, { conversations }) => {
            conversations.forEach((c) => {
                let conversation = state.conversations[c.id] || {}
                conversation = { ...conversation, ...c }
                state.conversations = { ...state.conversations, ...{[c.id]: conversation} }
            })
        },
        addMessages: (state, { messages, id }) => {
            let conversation = state.conversations[id] || {}
            conversation.messages = messages
            conversation.loaded = true
            state.conversations = { ...state.conversations, ...{[id]: conversation} }
        }
    },
    actions: {
        loadConversations: async (context) => {
            let response = await fetchApi('/api/conversations')
            context.commit('addConversations', { conversations: response.conversations })
        },
        loadMessages: async (context, conversationId) => {
            if(!context.getters.conversation(conversationId).loaded) {
                let response = await fetchApi('/api/conversations/' + conversationId)
                context.commit('addMessages', { messages: response.messages, id: conversationId })
            }
        },
        sendMessage: async (context, { content, userId }) => {
            let response = await fetchApi('/api/conversations/' + userId, {
                method: 'POST',
                body: JSON.stringify({
                    content: content
                })
            })
            console.log('REPONSE => ' + response)
        }
    }
})
