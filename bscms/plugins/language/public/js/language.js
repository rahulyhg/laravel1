!function(e){var a={};function t(n){if(a[n])return a[n].exports;var l=a[n]={i:n,l:!1,exports:{}};return e[n].call(l.exports,l,l.exports,t),l.l=!0,l.exports}t.m=e,t.c=a,t.d=function(e,a,n){t.o(e,a)||Object.defineProperty(e,a,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(a,"a",a),a},t.o=function(e,a){return Object.prototype.hasOwnProperty.call(e,a)},t.p="/",t(t.s=120)}({120:function(e,a,t){e.exports=t(121)},121:function(e,a){var t=function(){function e(e,a){for(var t=0;t<a.length;t++){var n=a[t];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(a,t,n){return t&&e(a.prototype,t),n&&e(a,n),a}}();var n=function(){function e(){!function(e,a){if(!(e instanceof a))throw new TypeError("Cannot call a class as a function")}(this,e)}return t(e,[{key:"bindEventToElement",value:function(){jQuery().select2&&$(".select-search-language").select2({width:"100%",templateResult:e.formatState,templateSelection:e.formatState});var a=$(".table-language");$(document).on("change","#language_id",function(e){var a=$(e.currentTarget).find("option:selected").data("language");void 0!==a&&a.length>0&&($("#lang_name").val(a[2]),$("#lang_locale").val(a[0]),$("#lang_code").val(a[1]),$("#flag_list").val(a[4]).trigger("change"),$(".lang_is_"+a[3]).prop("checked",!0),$("#btn-language-submit-edit").prop("id","btn-language-submit").text("Add new language"))}),$(document).on("click","#btn-language-submit",function(a){a.preventDefault();var t=$("#lang_name").val(),n=$("#lang_locale").val(),l=$("#lang_code").val(),r=$("#flag_list").val(),o=$("#lang_order").val(),g=$(".lang_is_rtl").prop("checked")?1:0;e.createOrUpdateLanguage(0,t,n,l,r,o,g,0)}),$(document).on("click","#btn-language-submit-edit",function(a){a.preventDefault();var t=$("#lang_id").val(),n=$("#lang_name").val(),l=$("#lang_locale").val(),r=$("#lang_code").val(),o=$("#flag_list").val(),g=$("#lang_order").val(),i=$(".lang_is_rtl").prop("checked")?1:0;e.createOrUpdateLanguage(t,n,l,r,o,g,i,1)}),a.on("click",".deleteDialog",function(e){e.preventDefault(),$(".delete-crud-entry").data("section",$(e.currentTarget).data("section")),$(".modal-confirm-delete").modal("show")}),$(".delete-crud-entry").on("click",function(e){e.preventDefault(),$(".modal-confirm-delete").modal("hide");var t=$(e.currentTarget).data("section");$.ajax({url:t,type:"GET",success:function(e){e.error?Bytesoft.showNotice("error",e.message):(e.data&&(a.find("i[data-id="+e.data+"]").unwrap(),$(".tooltip").remove()),a.find('a[data-section="'+t+'"]').closest("tr").remove(),Bytesoft.showNotice("success",e.message))},error:function(e){Bytesoft.handleError(e)}})}),a.on("click",".set-language-default",function(e){e.preventDefault();var t=$(e.currentTarget);$.ajax({url:t.data("section"),type:"GET",success:function(e){if(e.error)Bytesoft.showNotice("error",e.message);else{var n=a.find("td > i");n.replaceWith('<a data-section="'+route("languages.set.default")+"?lang_id="+n.data("id")+'" class="set-language-default tip" data-original-title="Choose '+n.data("name")+' as default language">'+n.closest("td").html()+"</a>"),t.find("i").unwrap(),$(".tooltip").remove(),Bytesoft.showNotice("success",e.message)}},error:function(e){Bytesoft.handleError(e)}})}),a.on("click",".edit-language-button",function(e){e.preventDefault();var a=$(e.currentTarget);$.ajax({url:route("languages.get")+"?lang_id="+a.data("id"),type:"GET",success:function(e){if(e.error)Bytesoft.showNotice("error",e.message);else{var a=e.data;$("#lang_id").val(a.lang_id),$("#lang_name").val(a.lang_name),$("#lang_locale").val(a.lang_locale),$("#lang_code").val(a.lang_code),$("#flag_list").val(a.lang_flag).trigger("change"),a.lang_rtl&&$(".lang_is_rtl").prop("checked",!0),$("#lang_order").val(a.lang_order),$("#btn-language-submit").prop("id","btn-language-submit-edit").text("Update")}},error:function(e){Bytesoft.handleError(e)}})})}}],[{key:"formatState",value:function(e){return e.id?$('<span><img src="'+$("#language_flag_path").val()+e.element.value.toLowerCase()+'.png" class="img-flag" /> '+e.text+"</span>"):e.text}},{key:"createOrUpdateLanguage",value:function(e,a,t,n,l,r,o,g){var i=route("languages.store");g&&(i=route("languages.edit")+"?lang_code="+n),$("#btn-language-submit").addClass("button-loading"),$.ajax({url:i,type:"POST",data:{lang_id:e,lang_name:a,lang_locale:t,lang_code:n,lang_flag:l,lang_order:r,lang_is_rtl:o},success:function(a){a.error?Bytesoft.showNotice("error",a.message):(g?$(".table-language").find("tr[data-id="+e+"]").replaceWith(a.data):$(".table-language").append(a.data),Bytesoft.showNotice("success",a.message)),$("#language_id").val("").trigger("change"),$("#lang_name").val(""),$("#lang_locale").val(""),$("#lang_code").val(""),$("#flag_list").val("").trigger("change"),$(".lang_is_ltr").prop("checked",!0),$("#btn-language-submit-edit").prop("id","btn-language-submit").text("Add new language"),$("#btn-language-submit").removeClass("button-loading")},error:function(e){Bytesoft.handleError(e)}})}}]),e}();$(document).ready(function(){(new n).bindEventToElement()})}});