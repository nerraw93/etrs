import Echo from "laravel-echo";

export default {

    /**
     * Methods
     *
     * @type {Object}
     * @author {goper}
     */
    methods: {

        /**
         * Subscribe to `announcement` channel
         *
         * @return {void}
         * @author [goper]
         */
        subscribeToAnnouncementChannel()
        {
            let user = $cookies.get('auth_user');

            this.broadcaster
                .private(`announcement.${user.id}`)
                .notification((notification) => {
                    alert('ping! query');
                });
        },



    },

    /**
     * Created hook
     *
     * @return {void}
     * @author [goper]
     */
    created()
    {
        this.broadcaster = window.broadcaster.getDriver();
    },

    /**
     * Mounted hook
     *
     * @return {void}
     * @author {goper}
     */
    mounted()
    {
        this.subscribeToAnnouncementChannel();
    },

};
