/* lazy user interface */
var Lazyui = {
    init : (targetElement, lazyui) => {
        $.post('lazyui', { lazyui : lazyui }, (lazyui)=>{
           $('.lazyui-'+targetElement).empty();
           $('.lazyui-'+targetElement).append(lazyui); 
        });
    },
    fanzyInit: (targetElement, lazyui) => {
        $.post('lazyui', { lazyui : lazyui }, (lazyui)=>{
           $('.lazyui-'+targetElement).empty();
           $('.lazyui-'+targetElement).hide().append(lazyui).show('slow');

        });
    }
};
var Lazycheck = {
    lazyForm : (targetForm, formName, length) => {
        var formLen = $(targetForm).val().length;
        if(formLen < length){
            $('form').submit(function(e){
               e.preventDefault(); 
            });
            Lazyerror.formTooShort(length, formName);
        }
    }
};
/* TODO : get error message texts via window object instead of hard coded */ 
var Lazyerror = {
    formTooShort: (requiredLen, formName) => {
        alert(formName+' needs to have atleast '+requiredLen+' characters.');
    }
};