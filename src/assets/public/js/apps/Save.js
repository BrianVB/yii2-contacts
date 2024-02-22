// --- Contact
import ContactForm from './../components/ContactForm.js';

// --- Vue
import { createApp, ref } from './../../vue/vue.esm-browser.prod.js';

/**
 * A variable vueAppData is registered in the yii asset bundle that we use here
 */
var RootComponent = {
    el: 'main.content',
    components: {
        ContactForm
    },
    setup(props, context){
        /**
         * Make contact into a ref for updating various parts of UI
         */
        const contact = ref(vueAppData.contact)

        /**
         * Updates the contact ref once the data is saved for it.
         * @return void
         */
        const handleContactSaved = function(contactData){
            const isNewRecord = !contact.value.id
            contact.value = {
                ...contact.value,
                ...contactData
            }
            if(isNewRecord){
                // --- If we just created a new record, redirect to the update page
                window.location = '/contacts/contact/update?id='+contact.value.id;
            }
        }

        return {
            contact,
            handleContactSaved,
            userSelection: vueAppData.userSelection
        }
    },
}

var app = createApp(RootComponent);
app.mount(RootComponent.el);