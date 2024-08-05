// window._ = require('lodash');

import './bootstrap';
// try {
//     // require('bootstrap');
// } catch (e) {}
import axios from 'axios'

// window.axios = require('axios');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
