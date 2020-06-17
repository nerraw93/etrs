import {forEach, isEmpty} from "lodash";
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification';

export default {

    methods:
    {
        /**
         * Get error
         * @param  {[type]} status [description]
         * @param  {[type]} data   [description]
         * @return {[type]}        [description]
         */
        catchError({status, data})
        {
            if (status == 422) {
                this.getErrorMessage(data);
            }

        },

        /**
         * Display error
         * @param  {[type]} errors  [description]
         * @param  {[type]} message [description]
         * @return {[type]}         [description]
         */
        getErrorMessage({errors, message})
        {
            let errorMessage = message;

            if (!isEmpty(errors)) {
                errorMessage = '';
                forEach(errors, (error) => {
                    forEach(error, (message) => {
                        errorMessage += message + "\n";
                    });
                });
            }

            Notification.open({
                message: errorMessage,
                type: 'is-danger',
                duration: 3000,
            });
        },

        errorToast(message = 'Error') {
            Notification.open({
                message: message,
                type: 'is-danger',
            });
        },

        /**
         * Display success message
         * @param  {String} [message='Success'] [description]
         * @return {[type]}                     [description]
         */
        successToast(message = 'Success')
        {
            Notification.open({
                message: message,
                type: 'is-success',
            });
        },
    },


}
