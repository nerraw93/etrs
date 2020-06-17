import Echo from "laravel-echo";
import merge from 'lodash/merge';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

export default class Broadcaster {

    /**
     * Constructor
     *
     * @param {Object} options custom options
     * @author {goper}
     */
    constructor(options = {})
    {
        this.driver = new Echo(merge({
            broadcaster: 'pusher',
            encrypted: true,
            key: options.key,
            cluster: options.cluster,
            auth: {
                headers: {
                    Authorization: 'Bearer ' + $cookies.get('access_token')
                },
            },
            // namespace: "App.Events"
        }, options));
    }

    /**
    * Get driver instance
    *
    * @return {Echo}
    * @author {goper}
    */
    getDriver()
    {
        return this.driver;
    }
}
