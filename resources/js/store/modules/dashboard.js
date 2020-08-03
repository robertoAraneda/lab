import http from '../../services/axios'

export default {
    namespaced: true,
    actions: {
        get: async () => {
            const response = await fetch('/api/state')

            console.log(response)
        }
    }
}
