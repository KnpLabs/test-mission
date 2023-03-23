import config from "../../../config"
const { apiUrl } = config

const state = () => ({
    articleComments: []
})

const actions = {
    async getComments({commit }) {
        const res = await fetch (`${apiUrl}/api/comments`, {
            method: 'GET',
            headers: {
            Accept: 'application/json'
            }
        })

        if (!res.ok) {
            throw new Error('Failed to fetch comments.')
        }

        commit('fetchAllComments', res.json() )
    }
}

const mutations = {
    fetchAllComments(state, comments) {
        state.articleComments = comments
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
