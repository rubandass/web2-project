$(document).ready(function () {

    $('.editItem').click(function () {
        $('#editItemForm')[0].reset();
        $("input[name='item_name']").val($('#selectItem :selected').text());
        var id = $("#selectItem").children(":selected").attr("id");
        $("input[name='item_id']").val(id);

        $("#editItemModal").modal();
    });

    $('.deleteItem').click(function () {
        var id = $("#selectItem").children(":selected").attr("id");
        $("input[name='item_id']").val(id);
        $.ajax({
            type: "POST",
            url: "/checkItems",
            data: {
                'id' : id,
                'item' : $("input[name='item']").val()
        },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            success: function (result) {
                $(".spanItemName").text($('#selectItem :selected').text());
                if (result["result"] === "Found") {
                    $('#delete').hide();
                    $('#noDelete').show();
                    $('#btnCancel').hide();
                    $('#btnYes').hide();
                    $('#btnOk').show();
                    $("#deleteItemModal").modal();
                } else {
                    $('#noDelete').hide();
                    $('#delete').show();
                    $('#btnCancel').show();
                    $('#btnYes').show();
                    $('#btnOk').hide();
                    $("#deleteItemModal").modal();
                }
            }
        });

        
    });
    

});