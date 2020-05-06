$(() => {
    
    $('#businessSelect').change(() => {
        $('#eventContainer').empty();
        console.log($('#businessSelect').val());
        $.post('admin/selectBusiness', {business_id: $('#businessSelect').val()}, (data) => {
            $(data).appendTo('#eventContainer');
        });
    });
    $('#userSelect').change(() => {
        $('#eventContainer').empty();
        console.log($('#userSelect').val());
        $.post('admin/selectUser', {user_id: $('#userSelect').val()}, (data) => {
            $(data).appendTo('#eventContainer').show('SLOW');
        });
    });
});
