$(document).ready(function () {

    $('.editActivity').click(function () {
        $('#editActivityForm')[0].reset();
        $("input[name='activity_name']").val($('#selectActivity :selected').text());
        var id = $("#selectActivity").children(":selected").attr("id");
        $("input[name='activity_id']").val(id);

        $("#editActivityModal").modal();
    });

    $('.deleteActivity').click(function () {
        $("#spanActivityName").text($('#selectActivity :selected').text());
        var id = $("#selectActivity").children(":selected").attr("id");
        $("input[name='activity_id']").val(id);

        var url = $(this).data('url');
        $.ajax({
            type: "POST",
            url: url,
            data: {'id' : id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            success: function (result) {
                if (result["result"] === "Found") {
                    $('#delete').hide();
                    $('#noDelete').show();
                    $('#btnCancel').hide();
                    $('#btnYes').hide();
                    $('#btnOk').show();
                    $("#deleteActivityModal").modal();
                } else {
                    $('#noDelete').hide();
                    $('#delete').show();
                    $('#btnCancel').show();
                    $('#btnYes').show();
                    $('#btnOk').hide();
                    $("#deleteActivityModal").modal();
                }
            }
        });

        
    });
    

});