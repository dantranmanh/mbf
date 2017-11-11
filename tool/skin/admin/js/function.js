
$(document).ready(function(){

    $('input[class="ids"]').click(function(){

        if($(this).is(":checked")){

            $(".btn-action").removeAttr("disabled");
        }

        else if($(this).is(":not(:checked)")){

            $(".btn-action").attr("disabled","disabled");
        }

    });
    
    $("#dropdown-toggle").click(function(){
        $(this).parent().parent().find('.panel-body').slideToggle("slow");
    });
});

function checkAll(listchkOneName,chkAllobj){
    var list = document.getElementsByName(listchkOneName);
    for (var i = 0; i < list.length; i++){
        list[i].checked = chkAllobj.checked;
    }
}

function gotoPermission(elId,controller,task){
    var elementId = $("#"+elId).attr('id');
    var countId = $('input#ids:checked').length;
    var id = $('input#ids:checked').val();

    var url;
    switch(elementId){

        case "btn-permission": 
        if(countId > 1){
            alert("Chỉ được chọn một bản ghi để phân quyền");
            return;
        }else{
            url = baseUrl+""+controller+"/index?task="+task+"&id="+id;
        }
        break;
        
        default: null;
    }
    $('#MyForm').attr('action',url);
}

function gotoAction(elId,controller){
    var elementId = $("#"+elId).attr('id');
    var countId = $('input#ids:checked').length;
    var id = $('input#ids:checked').val();

    var url;
    switch(elementId){
        case "delete": 
		if(confirm("Xóa bản ghi đã chọn?")){
			url = baseUrl+""+controller+"/delete";
		}
        break;
        case "edit": 
        if(countId > 1){
            alert("Chỉ được chọn một bản ghi để sửa");
            return;
        }else{
            url = baseUrl+""+controller+"/edit?id="+id;
        }
        break;
        case "status": 
        url = baseUrl+""+controller+"/activate";
        break;
        case "btn-permission": 
        url = baseUrl+""+controller+"/permission";
        break;
        
        /** Category type */
        case "typedelete": 
		if(confirm("Xóa bản ghi đã chọn?")){
			url = baseUrl+""+controller+"/typedelete";
		}
        break;
        case "typeedit": 
        if(countId > 1){
            alert("Chỉ được chọn một bản ghi để sửa");
            return;
        }else{
            url = baseUrl+""+controller+"/typeedit?id="+id;
        }
        break;
        case "typestatus": 
        url = baseUrl+""+controller+"/typeactivate";
        break;
        
        /** Category position */
        case "positiondelete": 
		if(confirm("Xóa bản ghi đã chọn?")){
			url = baseUrl+""+controller+"/positiondelete";
		}
        break;
        case "positionedit": 
        if(countId > 1){
            alert("Chỉ được chọn một bản ghi để sửa");
            return;
        }else{
            url = baseUrl+""+controller+"/positionedit?id="+id;
        }
        break;
        case "positionstatus": 
        url = baseUrl+""+controller+"/positionactivate";
        break;
        
        default: null;
    }
    $('#MyForm').attr('action',url);
}


function initTinymce(contentId, moxiePlugin){
    tinymce.init({
        selector: "#"+contentId,
        theme: "modern",
        extended_valid_elements : "iframe[src|title|width|height|allowfullscreen|frameborder]",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "moxiemanager",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        forced_root_block : "", // Remove tag p
        statusbar : false,
        toolbar1: "insertfile undo redo | fontsizeselect bold italic underline alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link | image media | forecolor backcolor | fullscreen",
        image_advtab: true,
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt 72pt",
    	external_plugins: {
    		"moxiemanager": moxiePlugin,
    	},
        document_base_url: "",
        convert_urls: false,
        onchange_callback: function(editor) {
			tinyMCE.triggerSave();
			$("#" + editor.id).valid();
		}
        
    });
}

function moxmanBrowseMulti(field_id){
    moxman.browse({
    	view: 'thumbs',
    	fields: field_id,
    	extensions:'jpg,gif,png',
    });
}

function moxmanBrowse(field_id){
    moxman.browse({
    	view: 'thumbs',
    	fields: field_id,
    	extensions:'jpg,gif,png'
    });
}

function moxmanBrowseFile(field_id){
    moxman.browse({
    	view: 'file',
    	fields: field_id,
    	extensions:'mp4,mp3,flv,wmv'
    });
}