function applySelect(selectName) {
    $("select[name='"+selectName+"']").children('option').each(function() {
        $(this).attr('selected', false);
    });
    //clear preview image
    $("ul[id='preview_"+selectName+"']").html('');

    $("input[name='bg_"+selectName+"']").each(function(e) {
        if ($(this).attr('checked')) {

            $("select[name='"+selectName+"']").children('option[value="'+$(this).val()+'"]').attr('selected', 'selected');

            //append the image to preview
            $("ul[id='preview_"+selectName+"']").append("<li class='span1 thumbnail'><img width='100px' height='50px;' src='"+$(this).attr('imagepath')+"' /></li>");
        }
    });
}

function initSelect(selectName, imagePath) {
    //clear preview image
    $("ul[id='preview_"+selectName+"']").html('');
    $("select[name='"+selectName+"']").children('option').each(function() {
        if ($(this).attr('selected')) {
            //append the image to preview
            image = imagePath + '/' + $(this).text();
            if (typeof imagePath !== 'undefined') {
                $("ul[id='preview_"+selectName+"']").append("<li class='span1 thumbnail'><img width='100px' height='50px;' src='"+image+"' /></li>");
            }
        } else {
            $("input[name='bg_"+selectName+"'][value="+$(this).val()+"]").attr('checked', false);
        }
    });
}

function checkAll(selectName)
{
    $("input[name='bg_"+selectName+"']").each(function(e) {
        $(this).attr('checked', 'checked');
    });
}

function clearAll(selectName)
{
    $("input[name='bg_"+selectName+"']").each(function(e) {
        $(this).attr('checked', false);
    });
}