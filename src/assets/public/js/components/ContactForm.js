// --- Contact
import ContactDataModel from './../models/Contact.js';
import { TITLES, SUFFIXES } from './../helpers/Contact.js';

// --- Form
import DataModelField  from './../../yiiform/components/data-model/DataModelField.js';
import DataModelSelect  from './../../yiiform/components/data-model/DataModelSelect.js';
import { useStatefulWithDataModel, UI_STATE_ENABLED, UI_STATE_WAIT } from './../../yiiform/composables/Stateful.js';
import StatefulButton from './../../yiiform/components/StatefulButton.js'
import SelectDropdown from './../../yiiform/components/SelectDropdown.js';

/**
 * FormFieldForm is a form for editing the properties of a form field
 */
export default {
    name: "ContactForm",
    props: {
        /**
         * Represents a `contact` record
         */
        contact: Object,
        /**
         * The default selection to display in the SelectDropdown
         */
        userSelection: Object
    },
    components: {
        DataModelField,
        DataModelSelect,
        SelectDropdown,
        StatefulButton
    },
    emits: [
        'contact-saved'
    ],
    setup(props, context){
        const {
            dataModel: contactDataModel,
            uiState,
            saveButtonAttrs
        } = useStatefulWithDataModel(ContactDataModel, { ...props.contact } )

        /** 
         * @return void
         */
        const save = function(){
            uiState.value = UI_STATE_WAIT;
            contactDataModel.save().then( ([response, json]) => {
                    context.emit('contact-saved', json);
                }).catch(contactDataModel.handleNonValidationErrors)
                .finally(() => { uiState.value = UI_STATE_ENABLED });
        }

        return {
            contactDataModel,
            save,
            saveButtonAttrs,
            titleOptions: TITLES,
            suffixOptions: SUFFIXES,
            userSelection: props.userSelection
        }
    },
    template: `<div class="contact-form">
    <data-model-field :data-model="contactDataModel" attribute="user_id">
    <template #input>
        <select-dropdown :ajax-options="{ request: { url: '/contacts/contact/search-users' } }"
            :initial-selection="userSelection"
            no-matches-text="No matching users"
            prompt="Start typing email to search"
            searching-text="Searching users..."
            :input-attributes="{type: 'search', placeholder: 'Enter user email', class: {'form-control': true} }"
            v-model="contactDataModel.attributes.user_id"
            model-selection-prop="id"></select-dropdown>
    </template>    
    </data-model-field>
    <data-model-field :data-model="contactDataModel" attribute="title">
        <template #input>
            <data-model-select :data-model="contactDataModel" 
                attribute="title"
                :options="titleOptions"></data-model-select>
        </template>
    </data-model-field>
    <data-model-field :data-model="contactDataModel" attribute="given_name"></data-model-field>
    <data-model-field :data-model="contactDataModel" attribute="middle_name"></data-model-field>
    <data-model-field :data-model="contactDataModel" attribute="family_name"></data-model-field>
    <data-model-field :data-model="contactDataModel" attribute="suffix">
        <template #input>
            <data-model-select :data-model="contactDataModel" 
                attribute="suffix"
                :options="suffixOptions"></data-model-select>
        </template>
    </data-model-field>
    <stateful-button class="d-block w-100" v-bind="saveButtonAttrs" @click="save"></stateful-button>&nbsp;
</div>`
}