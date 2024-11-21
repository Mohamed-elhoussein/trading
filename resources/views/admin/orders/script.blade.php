
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- form create oredr ===================================================== --}}
<script>

window.totalPrice = {};
window.volume = {};
    $(document).ready(function(){
        $("#__asset").change(function(){
            const xagAsk = window.currentPrices['XAGUSD']?.ask;
            const xauAsk = window.currentPrices['XAUUSD']?.ask;

            var stock = $(this).val();
            if(stock =="XAGUSD"){
                $(".Total_price").html(xagAsk);
                updateTotalPrice(xagAsk);

            }else if(stock =="XAUUSD"){
                console.log(xauAsk);
                $(".Total_price").html(xauAsk);
                updateTotalPrice(xauAsk);

            } else if(!stock){
                toastr.error("Please selecte any stock")
                $(".Total_price_display").html("");
            }

        })





        function updateTotalPrice(type) {
            $(".Quantity").on("keyup", function() {
                var gram = $(this).val();
                if (!isNaN(gram) && gram > 0) {
                    var ounces = gram / 31.1035; // تحويل الجرامات إلى أونصات
                    var total = ounces * type; // حساب التكلفة الإجمالية
                    window.totalPrice["total"] = total;
                    window.volume["valu"]= ounces;

                    $(".Total_price_display").html('$ '+`${total.toFixed(2)}`); // عرض السعر الإجمالي
                } else {
                    $(".Total_price_display").html("يرجى إدخال عدد صحيح من الجرامات."); // رسالة خطأ
                }
            });


            var currentGram = $(".Quantity").val();
            if (!isNaN(currentGram) && currentGram > 0) {
                var ounces = currentGram / 31.1035; // تحويل الجرامات إلى أونصات
                var total = ounces * type; // حساب التكلفة الإجمالية
                $(".Total_price_display").html( '$' +`${total.toFixed(2)}`); // عرض السعر الإجمالي
                $("#volume").val(ounces);
                $("#total_price").val(total.toFixed(2));

            }
        }



    })
</script>
{{-- form create oredr ===================================================== --}}









{{-- script to send data to controller and save data in database --}}
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $("#form_add_order").submit(function(e) {
        e.preventDefault();

        // الحصول على القيم المحسوبة
        const volume = window.volume.valu;
        const total_price = window.totalPrice.total;

        // تحقق من القيم
        console.log("Ounces:", volume);
        console.log("Total:", total_price);

        // جمع البيانات من النموذج
        const formData = $(this).serializeArray();

        // إنشاء كائن البيانات لإرساله
        const dataToSend = {
            volume: volume,
            total_price: total_price,
            profit:0,
            openPrice: total_price / volume
        };

        // دمج البيانات المدخلة مع القيم المحسوبة
        formData.forEach(function(item) {
            dataToSend[item.name] = item.value; // إضافة كل حقل إلى كائن البيانات
        });

        // Send the form data using AJAX
        $.ajax({
            method: 'POST',
            url: '/dashboard/orders/add', // Replace with your server endpoint
            data: dataToSend,
            success: function(response) {
                console.log("Response:", response);
                window.location.reload();
                // يمكنك هنا إضافة رسالة نجاح للمستخدم
            },
            error: function(error) {
                console.log("Error:", error);
                // يمكنك هنا إضافة رسالة خطأ للمستخدم
            }
        });
    });
});
</script>
{{-- script to send data to controller and save data in database --}}




{{-- <script>
    function sendOrder(symbol, operation, volume, totalPrice) {
    const id = "{{ env('MT5_ID') }}"; // تأكد من تعيين المعرف الصحيح هنا
    const url = `https://mt5.mtapi.io/OrderSend?id=${id}&symbol=${symbol}&operation=${operation}&volume=${volume}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("Order sent successfully:", data);
            // تخزين الطلب في قاعدة البيانات
            storeOrderInDB(symbol, operation, volume, totalPrice);
        })
        .catch(error => {
            console.error("Error sending order:", error);
            toastr.error("Error sending order: " + error.message);
        });
}
</script> --}}





{{-- <script>
    const _token="{{ csrf_token() }}";
    $(document).ready(function(){
        $(".__stocks").change(function(){
            var stock_id=$(this).val();
            $.ajax({
                url:"/dashboard/orders/getPriceStock/" + stock_id,
                method:"GET",
                success:function(data){
                    if (data) {
                $(".__price-stock").html(`<option value="${data.price}">${data.price}</option>`);
                } else {
                    $(".__price-stock").html('<option value="">لا يوجد سعر not found price</option>'); // في حالة عدم وجود بيانات
                }
             },

                error:function(data){
                    console.log(data);
                 },


            });


        });

    });
</script> --}}





 <script>
    const path="{{ route('orders.update') }}";
 $(document).ready(function() {
    $(document).on("click", ".model_update", function() {



        $("#form_update_order").attr("action",path);
        var order_id=$(this).attr("order-id");


        $("#order_id").val(order_id);
        $(".Trading_mt5").attr("orderId",order_id);
        const orderId = $(this).attr('order-id');
        const customerName = $(this).closest('tr').find('.customer_id').text();
        const stockSymbol = $(this).closest('tr').find('.stock_id').text().trim();
        const volume = parseFloat($(this).closest('tr').find('.volume').text().trim()); // تحويل القيمة إلى عدد
        const totalPrice = parseFloat($(this).closest('tr').find('.totalPrice').text().trim());
        const orderStatus = $(this).closest('tr').find('.order_status').text().trim();
        const deliveryStatus = $(this).closest('tr').find('.__delivery').text();
        const shippingAddress = $(this).closest('tr').find('.shipping_address').text();


        // console.log(stockSymbol);

        const xagBid = window.currentPrices['XAGUSD']?.bid;
        const xauBid = window.currentPrices['XAUUSD']?.bid;
        var current_price = "";
        if (stockSymbol === "XAGUSD" && xagBid) {

                console.log(xagBid);

             current_price = volume * xagBid;
            $('#currentPrice').text(current_price);

        } else if (stockSymbol === "XAUUSD" && xauBid) {
             current_price = volume * xauBid;
            $('#currentPrice').text(current_price);

        }else {
            $('#currentPrice').text("");
            current_price = ""
        }

        // const current_price = $(this).closest('tr').find('.current_price').text();
        // ملء البيانات في الـ modal
        $('#customerName').text(customerName);
        $('#stockSymbol').text(stockSymbol);
        $('#volume').text(volume);
        $('#totalPrice').text(totalPrice);
        $('#orderStatus').text(orderStatus);
        $('#deliveryStatus').text(deliveryStatus);
        $('#shippingAddress').text(shippingAddress);
        console.log(orderStatus);

        $('#order_status').val(orderStatus);

        // send data by ajax to update data in database #####################
        $("#form_update_order").submit(function(e){
            e.preventDefault();

            var order_status=$("#order_status").val();
            const openPrice = window.totalPrice.total;
            $.ajax({
                method: 'POST',
                url:path,
                data:{
                    order_status:order_status,
                    current_price:current_price,
                    order_id:order_id,
                    openPrice: openPrice,

                },
                success:function(data){
                    // console.log(data);
                    window.location.reload();

                },
                error:function(error){
                    console.log(error);

                }

            })

        })


        // send data by ajax to update data in database #####################


});
})



 </script>





{{-- script open Order --}}
<script>
    $(document).ready(function(){
        $("#OpenTrading_mt5").click(function(e){
            e.preventDefault();
            var path="{{ route('Trading/sendOrder') }}";
            const volume = $("#volume").html();
            const Symbol = $("#stockSymbol").html();
            const orderId = $(".Trading_mt5").attr("orderId");


            console.log(volume, Symbol);
            $.ajax({
                url:path,
                method: "POST",
                data:{
                    operation:"Buy",
                    volume:volume,
                    Symbol:Symbol,
                    orderId:orderId,

                },

                success: function(response) {
                    $("#varyingcontentModal_update").hide();
                    toastr.success(response.message); // رسالة نجاح
                },

                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.error || 'حدث خطأ';
                    toastr.error(errorMessage); // رسالة خطأ
                }
            })

        })
    })
</script>

{{-- script open Order --}}


{{-- script close Order --}}
<script>
    $(document).ready(function(){
        $("#CloseTrading_mt5").click(function(e){
            e.preventDefault();
            var path="{{ route('Trading/closeOrder') }}";
            const orderId = $(".Trading_mt5").attr("orderId");


            console.log(volume, Symbol);
            $.ajax({
                url:path,
                method: "POST",
                data:{
                    orderId:orderId,
                },

                success: function(response) {
                    console.log(response);

                    $("#varyingcontentModal_update").hide();
                    toastr.success(response.message); // رسالة نجاح
                },

                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.error || 'حدث خطأ';
                    toastr.error(errorMessage); // رسالة خطأ
                }
            })

        })
    })
</script>
{{-- script close Order --}}






<script>
    $(document).ready(function(){
        $(document).on('click',"#ordertHistory",function(){
            document.getElementById('loading').style.display = 'block';
            var order_id=$(this).attr("order-id");
            $("#OrderDetails").html('');

            $.ajax({
                url:"/dashboard/orderHistory/" + order_id,
                metod:"GET",
                success:function(response)
                {
                    var orderDetails = '';
                    response.forEach(function(item) {


                        console.log(item);
                        const createdAt = new Date(item.created_at);
                        const formattedDate = createdAt.toISOString().slice(0, 19).replace("T", " ");
                        var data = item.data ? JSON.parse(item.data) : {}; // تحويل الـ string إلى JSON
                        var formattedData = `
                            <ul>
                                <li><strong>Message:</strong> ${data.message || 'N/A'}</li>
                                <li><strong>Ticket:</strong> ${data.ticket ?? 'N/A'}</li>
                                <li><strong>Profit:</strong> ${data.profit ?? 'N/A'}</li>
                                <li><strong>Volume:</strong> ${data.volume ?? 'N/A'}</li>
                                <li><strong>Open Price:</strong> ${data.openPrice ?? 'N/A'}</li>
                                <li><strong>Close Price:</strong> ${data.ClosePrice ?? 'N/A'}</li>
                                <li><strong>Symbol:</strong> ${data.symbol ?? 'N/A'}</li>
                                <li><strong>State:</strong> ${data.state ?? 'N/A'}</li>
                            </ul>
                        `;

                        orderDetails += `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.order_id}</td>
                                <td  style="white-space: wrap; overflow: hidden; max-width: 100px;">${item.action}</td>
                                <td>${formattedData}</td>
                                <td>${item.do_by}</td>
                                <td>${item.trading_type}</td>
                                <td>${item.customer ?item.customer.name:""}</td>
                                <td>${item.user ? item.user.name : 'N/A'}</td>
                                <td>${formattedDate}</td>

                            </tr>
                        `;
                    });


                    $("#OrderDetails").html(orderDetails);
                    $('#myModal').modal('show');
                    document.getElementById('loading').style.display = 'none';

                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            })

        })
    });
</script>



