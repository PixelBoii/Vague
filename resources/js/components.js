import { Head, Link } from '@inertiajs/vue3';
import ResourceBuilder from './Components/ResourceBuilder.vue';
import PrimaryButton from './Components/PrimaryButton.vue';
import SecondaryButton from './Components/SecondaryButton.vue';
import DangerousButton from './Components/DangerousButton.vue';
import Input from './Components/Input.vue';

export default {
	install (app) {
        app.component('ResourceBuilder', ResourceBuilder);
        app.component('PrimaryButton', PrimaryButton);
        app.component('SecondaryButton', SecondaryButton);
        app.component('DangerousButton', DangerousButton);
        app.component('Input', Input);
        app.component('InertiaHead', Head);
        app.component('InertiaLink', Link);
	}
};
