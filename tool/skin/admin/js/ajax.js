function ajaxGuiLaiSms(transactionId,url) {
    if(isNotEmpty(transactionId) && isNotEmpty(url)){
        //alert(transactionId);
        showAjaxLoading();
        jQuery.ajax({
            url : url,
            type : "post",
            dataType:"text",
            data : {
                transactionid : transactionId
            },
            success : function (result){
                hideAjaxLoading();
                alert('Yêu cầu gửi lại SMS đã được đưa vào hàng chờ trong hệ thống!')
            }
        });
        hideAjaxLoading();
    }else{
        alert('Transaction Id / Url không để trống!');
    }

}
function hideAjaxLoading() {
    jQuery('#ajaxLoading').removeClass('show');
}
function showAjaxLoading() {
    jQuery('#ajaxLoading').addClass('show');
}