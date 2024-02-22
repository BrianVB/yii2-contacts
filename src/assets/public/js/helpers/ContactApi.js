import YiiApiHelper from './../../yiivue/helpers/YiiApiHelper.js';

export default {
    ...YiiApiHelper,
    baseUrl: window.location.origin+'/contacts/api/v1',
    resourceName: 'contact'
}