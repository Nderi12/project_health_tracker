import { http } from './boot'

export default {
    getCookie() {
        return http.get('sanctum/csrf-cookie')
    }
}
