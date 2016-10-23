// $(function() { 
//     $('#_file').on('change',function() { 
//         var file = this.files[0]; 
//         var r = new FileReader(); 
//         r.readAsDataURL(file); 
//         $(r).on('load',function() { 
//             $.post("upload.php",
//             {
//                 data:this.result,
//             },
//             function(data,status){
//                 json = jQuery.parseJSON(data);
//                 $("#photo").attr("src",json.url);
//                 //alert(json.code);
//             });          
//         }) 
//     }) 
// })

function file_change(_file){
    var file = _file.files[0]; 
        var r = new FileReader(); 
        r.readAsDataURL(file); 
        $(r).on('load',function() { 
            $.post("upload.php",
            {
                data:this.result,
            },
            function(data,status){
                json = jQuery.parseJSON(data);
                $("#photo").attr("src",json.url);
                //alert(json.code);
            });          
    }) 
}