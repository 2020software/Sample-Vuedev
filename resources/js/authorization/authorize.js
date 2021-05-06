import policies from './policies.js';

export default {
    install (Vue, options) {
        Vue.prototype.authorize = function (policy, model) {    // policy = policies.js
            if ( ! window.Auth.signedIn ) return false;
       
            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;
       
                return policies[policy](user, model);
            }
        };

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}