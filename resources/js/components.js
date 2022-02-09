import { Head, Link } from '@inertiajs/inertia-vue3';
import ResourceBuilder from './Components/ResourceBuilder';
import PrimaryButton from './Components/PrimaryButton';
import SecondaryButton from './Components/SecondaryButton';
import DangerousButton from './Components/DangerousButton';
import Input from './Components/Input';

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
