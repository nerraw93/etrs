import axios from 'axios';

export default {
    created() {
        axios.interceptors.request.use((config) => {
            this.$store.dispatch('app/toggleLoading', true)
            return config;
        }, (error) => {
            this.$store.dispatch('app/toggleLoading', false)
            const { status } = error.response

            if (status == 401)
                window.location.reload()

            return Promise.reject(error);
        });

        axios.interceptors.response.use((response) => {
            this.$store.dispatch('app/toggleLoading', false)
            return response;
        }, (error) => {
            this.$store.dispatch('app/toggleLoading', false)
            const { status } = error.response
            if (status == 502)
                this.errorToast('Something went wrong. Please reload the page again.')

            if (status == 401)
                window.location.reload()

            return Promise.reject(error);
        });
    }
}
