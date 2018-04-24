$(document).ready(function() {
                
    // $('#mainTable').DataTable( {
    //     "order": [[ 8, "desc" ]],
    //     "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]]
    // } );

});

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
            $('#sheet-id').val( payload['google_sheet_id'] );
            $('#rss-url').val( payload['rss_url'] );
            $('#type').val( payload['type'] );
        },
        error: function (error) {
          console.log(error);
        }

    });
}