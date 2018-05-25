$(function(){
    $("body").on("change", 'select[name="service_icon"]', function(){        
        var icon = $(this).val();
       $("#service_icon_show").find("fa").remove();
       $("#service_icon_show").html("<i  class='fa-2x fa "+icon+"'></i>");
       
    });
    
    
//    $("#myselect option[value=3]").attr('selected', 'selected');
// 
//// Or just...
//$("#myselect").val(3);
});