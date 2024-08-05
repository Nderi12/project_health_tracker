import axios from 'axios'
import Csrf from "./Csrf";
const baseURL = ''

// create axios object
let http = axios.create({
    baseURL: baseURL,
    headers:
        {
            'Accept': 'application/json'
        }
})

http.defaults.withCredentials = true

//get refresh token from localStorage
const getRefreshToken = function () {
    return JSON.parse(localStorage.getItem('RefreshToken'))
}

const handleRefreshingToken = function () {
    return http.post(refreshEndPoint, {
        refresh_token: getRefreshToken()
    })
}

// set storage token to localStorage
const setAccessToken = function (value) {
    localStorage.setItem('AccessToken',JSON.stringify(value))
}


// set refresh token to localStorage
const setRefreshToken = function (value) {
    localStorage.setItem('RefreshToken',JSON.stringify(value))
}


//get access token
const getAccessToken = function () {
    // should hold oath2 access token
    if (localStorage.getItem('AccessToken')) {
        return JSON.parse(localStorage.getItem('AccessToken'))
    }
    return null
}

const setCurrentUserToLocalStorage = function (value) {
    localStorage.setItem('CurrentUser',JSON.stringify(value))
}

const getCurrentUser = function () {
    if (localStorage.getItem('CurrentUser')) {
        return JSON.parse(localStorage.getItem('CurrentUser'))
    }
    return null
}

const setUserDataToLocalStorage = function (value) {
    localStorage.setItem('UserData',JSON.stringify(value))
}

const getUserDataFromLocalStorage = function () {
    if (localStorage.getItem('UserData')) {
        return JSON.parse(localStorage.getItem('UserData'))
    }
    return null
}

const setAuth = function (value) {
    localStorage.setItem('auth',value)
}

const getAuth = function () {
    if (localStorage.getItem('auth')) {
        return localStorage.getItem('auth')
    }
    return null
}

const getCookie = async () => {
       await axios.get('sanctum/csrf-cookie')
}



http.interceptors.request.use(getCookie())

// add interceptors for 401 unauthorized request -- we assume the access_token expired
http.interceptors.response.use(
    response => response,
    error => {
        // eslint-disable-next-line no-unused-vars
        const { config, response } = error;
        console.log('axios interceptor', response.status)

        // console.log('config at http interceptors', config)
        // if status 401 >> means token expired
        if (response && response.status === 401) {

            location.reload()
            location.replace('/')
            localStorage.clear();
            sessionStorage.clear();

        }
        // any other error status will be returned
        return Promise.reject(error);
    }
)


export {
    http, baseURL,
    setAccessToken, getAccessToken,
    setRefreshToken, getRefreshToken,
    setUserDataToLocalStorage, getUserDataFromLocalStorage,
    setCurrentUserToLocalStorage, getCurrentUser,
    setAuth, getAuth,
    Csrf
}
