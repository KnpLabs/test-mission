import { createStore } from 'vuex'
import comments from './modules/comments'

export default createStore({
    modules: {
        comments
    }
})

