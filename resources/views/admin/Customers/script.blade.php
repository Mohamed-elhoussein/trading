<script>
    const _token="{{ csrf_token() }}";
$(document).ready(function() {
    $(document).on("click", ".modal_update", function() {
        var row = $(this).closest("tr");
        var customer_id = $(this).data("customer-id");
        // console.log(customer_id);

        var name = row.find(".name-column").text();
        var email = row.find(".email-column").text();
        var phone = row.find(".phone-column").text();

        $(".U_name").val(name);
        $(".U_email").val(email);
        $(".U_phone").val(phone);
        $("#customer_id").val(customer_id);
    });
    delete_()
});








function delete_()
{
    $(document).on("click", ".__delete", function() {
        var customer_id = $(this).data("customer-id");
        var row = $(this).closest('tr'); // حفظ الصف في متغير

        $.ajax({
            url:'/dashboard/Customer/deleteCustomer/',
            method:"POST",
            data:{customer_id:customer_id , _token:_token},
            success:function(data){
                 console.log(data);
                 toastr.success('Customer deleted successfully!');
                 row.remove();

              },

              error: function(xhr, status, error) {
                console.log(error);
                toastr.error('An error occurred while deleting the customer.');

              }

        });
    });
}

</script>
