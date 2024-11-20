import { router, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

const page = usePage();
const toast = useToast();

export const notifications = () => {
    router.on("finish", () => {
        const message = page.props.message;

        // Check if message is defined and has a body property
        if (message && message.body) {
            toast(message.body, {
                type: message.type || 'default', // Provide a default type if type is undefined
            });
        } else {
        }
    });
};
