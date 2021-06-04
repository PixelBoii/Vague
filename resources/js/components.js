import ResourceBuilder from './Components/ResourceBuilder';
import PrimaryButton from './Components/PrimaryButton';
import SecondaryButton from './Components/SecondaryButton';
import DangerousButton from './Components/DangerousButton';

export default {
	install (app) {
        app.component('ResourceBuilder', ResourceBuilder);
        app.component('PrimaryButton', PrimaryButton);
        app.component('SecondaryButton', SecondaryButton);
        app.component('DangerousButton', DangerousButton);
	}
};
