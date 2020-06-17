import ViewPdfModal from "@components/orders/ViewPdfModal";

export default {

    components: {
        ViewPdfModal,
    },

    data() {
        return {
            openViewPdfModal: false,
            viewPdfSrc: '',
        };
    },

    methods: {

        /**
         * View PDF
         * @param  {integer} batchId
         * @return {void}
         */
        viewPdf(batchId)
        {
            this.viewPdfSrc = '';
            let role = 'client';
            let userRole = this.$store.getters['auth/getUserRole'];
            if (userRole == 10) {
                role = 'admin';
            }

            http.getJSON(`/api/${role}/batch/${batchId}/pdf`)
                .then(({data}) => {
                    this.openViewPdfModal = true;
                    this.viewPdfSrc = window.location.origin + '/' + data.path;
                })
                .catch(error => {
                    this.catchError(error);
                });

        },

        closePdfModal()
        {
            this.openViewPdfModal = false;
        },
    },
}
