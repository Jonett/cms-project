$(function () {
    $('#workersTable').DataTable();
    $('#toolsTable').DataTable();
    $('#clientsTable').DataTable();
    
    $('#Toolsbtn').click(function(){
        if($('#tools').hasClass('d-none')){
            $('#tools').removeClass('d-none'); 
        }else{
            $('#tools').addClass('d-none'); 
        }
       
    });
});