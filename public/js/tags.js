$(document).ready(function() {
                
    // $('#mainTable').DataTable( {
    //     "order": [[ 8, "desc" ]],
    //     "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]]
    // } );

});

function getTag(tagId){
    console.log(tagId);
    $('#edit-source').modal('show');
    ajaxTag(tagId);
    
}

function ajaxTag(tagId) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/tag/get',
        type: 'POST',
        data: {id: tagId},
        success: function(payload) {
            console.log(payload);
            $('#id').val( payload['id'] );
            $('#name').val( payload['name'] );
            $('#keywords').val( payload['keywords'] );
        },
        error: function (error) {
          console.log(error);
        }

    });
}