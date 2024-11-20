import '../css/app.css';
import './bootstrap';
import { createI18n } from 'vue-i18n';
import { createApp, h, reactive, watch } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import en from './lang/en.json';
import tr from './lang/tr.json';
import ar from './lang/ar.json';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast from "vue-toastification";
import { notifications } from "./Plugins/notifications";
import 'vue-toastification/dist/index.css';

const appName = 'Thunder Menu';

// Retrieve the stored language preference from localStorage or default to 'en'
const initialLanguage = localStorage.getItem('selectedLanguage') || 'en';

// Set up the i18n instance
const i18n = createI18n({
    locale: initialLanguage, // Use the stored language as the initial locale
    fallbackLocale: 'en', // Fallback language
    messages: {
        en,
        ar,
        tr,
    },
});
const options = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: true,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false,
};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Create the Vue application instance
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(Toast, options)
            .use(notifications)
            .use(ZiggyVue);

        // Define a reactive global language variable
        const globalLanguage = reactive({
            selectedLanguage: initialLanguage,
        });

        // Add the global language variable to app's globalProperties
        app.config.globalProperties.$globalLanguage = globalLanguage;

        // Watch for changes in the selected language and update localStorage and i18n locale
        watch(
            () => globalLanguage.selectedLanguage,
            (newLanguage) => {
                localStorage.setItem('selectedLanguage', newLanguage);
                i18n.global.locale = newLanguage;
            }
        );

        // Mount the app
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
