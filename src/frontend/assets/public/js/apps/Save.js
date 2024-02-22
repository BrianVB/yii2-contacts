
/**
 * A variable vueAppData is registered in the yii asset bundle that we use here
 */
var RootComponent = {
    el: 'main.content',
    components: {
        ArticleEditor,
        DataModelField,
        FormItemsEditor,
        StatefulButton,
        DataModelFieldCheckToggle
    },
    setup(props, context){
        console.log(vueAppData)
    },
}

var app = createApp(RootComponent);
app.mount(RootComponent.el);