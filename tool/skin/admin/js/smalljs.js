function showErrorMessage(message){

}
function isNotEmpty(value) {
    if(value === null || value == '' || !value) return false;
    return true;
}
function export_tq_excel(formId) {
    jQuery('#task').val('exportexcel');
    jQuery(formId).submit();
}