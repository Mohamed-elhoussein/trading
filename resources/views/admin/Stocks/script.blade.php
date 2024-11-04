















<script>

        $(document).ready(function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



            $('#form_add_stock').on('submit', function(event) {
                event.preventDefault(); // لمنع الإرسال الافتراضي للنموذج

                const name = $('#name').val();
                const price = $('#price').val();
                const quantity = $('#quantity').val();

                $.ajax({
                    url: '/dashboard/stocks/',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {

                        t_body(name,price,quantity,response);
                        updateModal();
                        delete_();

                        $('#form_add_stock')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            updateModal();
            delete_();
        });





        function t_body(name,price,quantity,response){


            var id=$("#id_auto").val();
            $(".t_body").append(`<tr>
                <td class="td_id">${id}</td>
                <td class="td_name">${name}</td>
                <td class="td_price">${price}</td>
                <td class="td_quntity">${quantity}</td>
                <td><button  stock_id="${response.id}" data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn model_update" data-id="1" data-name="mohamed" data-email="mohamed@y.com" data-status="1"><i class="bx bxs-edit"></i></button>
                <button stock_id="${response.id }"class="btn btn-danger delete-btn"><i class="bx bxs-trash"></i> </button>
                </td>
                <td>${response.date}</td>
            </tr>`);
            let lastIdElement = $(".t_body tr:last-child td.td_id");
            let lastValue = parseInt(lastIdElement.text(), 10) || 0; // معالجة حالة NaN

            let newId = lastValue + 1;

            $(".t_body tr:last-child td.td_id").text(newId);
            $("#id_auto").val(newId);
        }




</script>



<script>
    function updateModal(){
        $(".model_update").click(function(){
                var stock_id=$(this).attr("stock_id");

                var name    =$(this).closest("tr").find(".td_name").html();
                var price   =$(this).closest("tr").find(".td_price").html();
                var quntity =$(this).closest("tr").find(".td_quantity").html();

                $(".input__name").val(name);
                $(".input__price").val(price);
                $(".input__quantity").val(quntity);

                $("#update_stocks").attr("action","/dashboard/stocks/"+stock_id)
            })


    }
</script>



<script>
    function delete_(){
        $(".delete-btn").click(function(){
        var id =$(this).attr("stock_id");
        var row = $(this).closest("tr");
            $.ajax({
                    url: '/dashboard/stocks/' + id,
                    method: 'DELETE',
                    success: function(response) {
                        console.log(response);
                        row.remove();
                    },
                    error: function(xhr, status, error) {
                    console.log("Error status: " + status);
                    console.log("Response: " + xhr.responseText);
                    console.log("Error message: " + error);
                    }

            });

        });
    }
</script>














{{-- <script>
const user = "{{ env('MT5_USER') }}";
const password = "{{ env('MT5_PASSWORD') }}";
const host = "{{ env('MT5_HOST') }}";
const port = "{{ env('MT5_PORT') }}";




async function connectToAPI() {
    try {
        const response = await fetch(`https://mt5.mtapi.io/Connect?user=${user}&password=${password}&host=${host}&port=${port}`);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const id = await response.text();
        console.log("ID received:", id);
        createWebSocket(id);

    } catch (error) {
        console.error("Error connecting to API:", error);
    }
}








// function subscribeToSymbols(id) {
//     fetch(`https://mt5.mtapi.io/SubscribeMany?id=${id}&symbols=XAUUSD,XAGUSD`)
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             console.log("Subscribed to symbols successfully");
//             createWebSocket(id);
//         })
//         .catch(error => {
//             console.error("Error subscribing to symbols:", error);
//         });
// }






let ws;

function createWebSocket(id) {
    const wsUrl = `wss://mt5.mtapi.io/OnQuote?id=${id}`;
    ws = new WebSocket(wsUrl);

    ws.onopen = function() {
        console.log("WebSocket connection established");
    };

    ws.onmessage = function(event) {
        const data = JSON.parse(event.data);
        console.log("Received data:", data);

        if (data.type === 'Quote' && data.data) {
            const symbol = data.data.symbol;
            const bid = data.data.bid;
            const ask = data.data.ask;

            console.log(`Symbol: ${symbol}, Bid: ${bid}, Ask: ${ask}`);

            // تحديث الأسعار //
            if (symbol === 'XAUUSD') {
                document.getElementById('xau-Bid').innerHTML  = ` ${bid}`;
                document.getElementById('xau-ask').innerHTML  = ` ${ask}`;
            } else if (symbol === 'XAGUSD') {
                document.getElementById('xag-Bid').innerHTML  = ` ${bid}`;
                document.getElementById('xag-ask').innerHTML  = `${ask}`;
            }
        }
    };

    ws.onclose = function(event) {
        console.warn("WebSocket connection closed:", event);
        // حاول إعادة الاتصال بعد فترة
        setTimeout(() => {
            console.log("Attempting to reconnect...");
            connectToAPI(); // أعيد الاتصال بـ API لجلب معرف جديد
        }, 5000); // إعادة الاتصال بعد 5 ثوانٍ
    };

    ws.onerror = function(error) {
        console.error("WebSocket error:", error);
    };
}



connectToAPI();

    setInterval(() => {
connectToAPI(); // أعيد الاتصال بـ API لجلب معرف جديد
}, 5000); // إعادة الاتصال بعد 5 ثوانٍ



</script>



<script>
    async function sendOrder(id, symbol, operation, volume) {
    try {
        const response = await fetch(`https://mt5.mtapi.io/OrderSend?id=${id}&symbol=${symbol}&operation=${operation}&volume=${volume}`, {
            method: 'GET', // استخدام طريقة GET
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        console.log("Order result:", result);
    } catch (error) {
        console.error("Error sending order:", error);
    }
}

// حساب عدد اللوتات لشراء 20 جرام من الذهب
const gramsToBuy = 20;
const gramsPerOunce = 28.3495;
const ouncesPerLot = 100; // لوت واحد يساوي 100 أونصة
const volume = (gramsToBuy / gramsPerOunce) / ouncesPerLot; // حساب حجم اللوت

// مثال على كيفية استدعاء الوظيفة
const id = "your_id"; // استبدل هذا بالمعرف الفعلي من Connect
const symbol = "XAUUSD"; // رمز الذهب
const operation = "Buy"; // نوع العملية

sendOrder(id, symbol, operation, volume);

</script> --}}




{{-- <script>
    $(document).ready(function() {
        var route="{{ route('gold-price.index') }}";
        // setInterval(function() {
            $.ajax({
                url: route,
                method: 'GET',
                success: function(data) {
                    // تحديث واجهة المستخدم بالبيانات
                    console.log(data);
                    // يمكنك تحديث العناصر في الصفحة هنا
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching gold price:', error);
                }
            });
        // }, 1000); // 1000 مللي ثانية = 1 ثانية
    });
</script> --}}
