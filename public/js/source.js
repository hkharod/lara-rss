/*Sources JS*/

function getSource(sourceId){
    console.log(sourceId);
    $('#edit-source').modal('show');
    ajaxSource(sourceId);
    
}

function ajaxSource(sourceId) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/source/get',
        type: 'POST',
        data: {id: sourceId},
        success: function(payload) {
            console.log(payload);
            $('#id').val( payload['id'] );
            $('#title').val( payload['title'] );
            $('#rss-url').val( payload['rss_url'] );
            $('#delete-id').val( payload['id'] );
        },
        error: function (error) {
          console.log(error);
        }

    });
}