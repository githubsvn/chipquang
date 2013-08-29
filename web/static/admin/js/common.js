function checkAllCheckbox(){
    var inptCheckbox = $('input[type="checkbox"]').eq(0);
    var hCheck = true;
    inptCheckbox.click(function(){
        if(hCheck){
            $('input:checkbox[class="chkItem"]').attr('checked', true);
            hCheck = false;
        }else{
            $('input:checkbox[class="chkItem"]').attr('checked', false);
            hCheck = true;
        }
    });
}

function checkDelete(){
    var btnDel = $('#btn-del');
    var inptCheckboxs = $('input[type="checkbox"]');
    var hCheck = false;
    var frmRss = $('#frmList');
    btnDel.click(function(){
        $('.chkItem:checked').each(function(){
            hCheck = true;
            return false;
        });

        if(!hCheck){
            alert(js_lang_please_choose_at_least_one_item);
            return false;
        } else {
            if (confirm(js_lang_do_you_want_to_delete)){
                frmRss.attr('action', btnDel.attr('rel')).submit();
            }
        }
    });
}

function compareCheckBox()
{
    var total = 0;
    var totalChecked = 0;
    $('.chkItem').each(function(){
        total ++;
    });
    $('.chkItem:checked').each(function(){
        totalChecked ++;
    });

    if (totalChecked == total) {
        return true;
    }
    return false;
}

$( document ).ready( function() {
    $(".defaultCheckBox").click(function() {
        window.location.href = this.src;
    });

    $(".delete").click(function() {
        if (confirm(js_lang_do_you_want_to_delete)){
            window.location.href = this.rel;
        }
    });


    /* ARTICLE */
    $("select[name^='media_id']").change(function(){
        $("#article_preview_background").html("");
        $(this).children('option:selected').each(function(){
            $("#article_preview_background").append("<img src='"+media_image_path+$(this).text()+"' width=400 />");
        });
    });
    $("select[name^='media_id']").mouseover(function(e){
        var $target = $(e.target);
        if($target.is('option')){
            $("#article_preview_background").html("<img src='"+media_image_path+$target.text()+"' width=400 />");
        }
    });
    $("select[name^='media_id']").mouseout(function(e){
        $("#article_preview_background").html("");
        $(this).children('option:selected').each(function(){
            $("#article_preview_background").append("<img src='"+media_image_path+$(this).text()+"' width=400 />");
        });
    });

    checkAllCheckbox();
    checkDelete();

    $('.chkItem').click(function(){
        var isEqual = false;
        isEqual = compareCheckBox();
        if (isEqual) {
            $("#checkAll").attr('checked', true);
        } else {
            $("#checkAll").attr('checked', false);
        }
    });
});

