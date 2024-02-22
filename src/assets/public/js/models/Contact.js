import VueDataModel from './../../yiivue/models/VueDataModel.js'
import ContactApi from './../helpers/ContactApi.js';

export default class Contact extends VueDataModel {
    get attributeDefaults(){
        return {
            id: null,
            user_id: null,
            title: null,
            given_name: null,
            middle_name: null,
            family_name: null,
            suffix: null,
            default_address_id: null,
            create_time: null,
            update_time: null,
        }
    }
    get apiHelper(){
        return ContactApi;
    }
    get attributeLabels(){
        return {
            user_id: 'User',
        }
    }
    get attributeHints(){
        return {
            given_name: 'The name given to you by the parents when a child is born',
            middle_name: 'Another name given by the parents to a child',
            family_name: 'The name of the family lineage',
            suffix: 'Optional suffix for after the family name',
            title: 'Optional title to be addressed by',
            user_id: 'The user account associated with this contact',
        }
    }
}