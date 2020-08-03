import axios from 'axios'

let http = axios.create({
    baseURL: `http://127.0.0.1:8000/`,
    headers: {
        'Content-Type': 'application/json; charset=UTF-8',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    }
})

export default http
