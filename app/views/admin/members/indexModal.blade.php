<div class="modal " id="myModal" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="myModalLabel">Seller Information</h4>
            </div>
            <div class="modal-body" id="myModaltext">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn default"  data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function onShowModal(id){
        var base_url = window.location.origin;
        $.ajax ({
            url: base_url + '/admin/members/viewSeller',
            type: 'POST',
            data: {id: id},
            cache: false,
            dataType : "json",
            success: function (data) {
                if(data.result == "success"){
                    $("#myModaltext").html(data.list);
                    var a = $("<a>")
                            .attr("href", "#myModal")
                            .attr("data-toggle","modal")
                            .appendTo("body");

                    a[0].click();

                    a.remove();
                }
            }
        });
    }
</script>
