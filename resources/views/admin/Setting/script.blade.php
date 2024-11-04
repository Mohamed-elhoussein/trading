




<script>
    const path="{{ route('setting.update','') }}/";
$(document).ready(function() {
    $(document).on("click", ".model_update", function() {

        // $(".div_order_status").css("display","block");
        // $("#form_add_order").attr("action",path);

        var order_id=$(this).attr("setting-id");

        $("#_method").val('PUT');

        var href=path+order_id;
        $("#_form").attr("action",href);


        var     row                = $(this).closest("tr");
        var    _name               = row.find("._name").text().trim();
        var    _description        = row.find("._description").text().trim();
        var    _instagram          = row.find("._instagram").text().trim();
        var    _whatsApp           = row.find("._whatsApp").text().trim();
        var    _facebook           = row.find("._facebook").text().trim();
        var    _snapchat           = row.find("._snapchat").text().trim();
        var    _email              = row.find("._email").text().trim();
        var    _phone              = row.find("._phone").text().trim();

        $(".n_name").val(_name);
        $(".n_description").val(_description);
        $(".n_instagram").val(_instagram);
        $(".n_whatsApp").val(_whatsApp);
        $(".n_facebook").val(_facebook);
        $(".n_snapchat").val(_snapchat);
        $(".n_email").val(_email);
        $(".n_phone").val(_phone);

});


function openModal() {
        $("#varyingcontentModal").modal('show'); // استخدم Bootstrap لفتح الموديل
    }

 // حدث إغلاق الـ modal

 $('#exampleModal').on('hidden.bs.modal', function() {
     const path="{{ route('setting.store') }}";

        // تفريغ كل حقول الإدخال
        $(this).find('input[type="text"],input[type="email"] ,input[type="number"], textarea').val(''); // تفريغ الحقول النصية والرقمية
    });

    openModal()


    var route = "{{ route('setting.destroy', '') }}/";
    $(".modal_delete").click(function(){
        var id=$(this).attr('setting-id');
        $(".__destroy").attr("action",route+id);


    });
});

</script>

<
@if ($errors->any())
    <script>
        $(document).ready(function() {
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        });
    </script>
@endif


