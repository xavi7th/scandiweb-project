$(document).ready(function(){
    function hasError(errMsg, formData){
        formData.preventDefault(formData);
        return $("#error_log").html(errMsg).show().delay(5000).fadeOut();
    }

    function hasSuccess(errMsg){
        return $("#success_log").html(errMsg).show().delay(5000).fadeOut();
    }
});
