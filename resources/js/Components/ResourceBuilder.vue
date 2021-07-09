<script>
import axios from 'axios';
import { h, defineAsyncComponent } from 'vue';

export default {
    name: 'ResourceBuilder',
    props: [
        'element'
    ],
    methods: {
        getComponent(el) {
            let component = el.component;
            let content = [ el.content ];

            if (Array.isArray(el.content)) {
                content = el.content.map(el => this.getComponent(el));
            }

            if (component == 'fragment') {
                return content;
            } else {
                if (el.import) {
                    component = defineAsyncComponent(() => import('@/Components/' + el.component + '.vue'));
                }

                return h(
                    component,
                    {
                        ...el.attributes,
                        ...el.events.reduce((events, event) => {
                            events[event.name] = async () => {
                                await axios.post(`${window.location.pathname}/elements/${event.element}/events/${event.name}` + window.location.search, event.args);

                                this.$inertia.reload();
                            }

                            return events;
                        }, {})
                    },
                    {
                        default() {
                            return content;
                        }
                    }
                );
            }
        }
    },
    render() {
        return this.getComponent(this.$props.element);
    }
}
</script>
