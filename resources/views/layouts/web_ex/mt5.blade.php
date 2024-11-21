<script>
    window.currentPrices = {};


    let ws;

async function connectToAPI() {
    try {
        // Request the backend to authenticate and get the connection ID
        const response = await fetch('/api/trading/connect');

        if (!response.ok) {
            throw new Error('Connection failed');
        }

        const data = await response.json();
        const id = data.id;
        // console.log("Received connection ID:", id);
        subscribeToSymbols(id);
    } catch (error) {
        console.error("Error connecting to API:", error);
    }
}

async function subscribeToSymbols(id) {


    try {
        const response = await fetch(`/api/trading/subscribe/${id}`);

        if (!response.ok) {
            throw new Error('Subscription failed');
        }

        const data = await response.json();
        console.log(data.message); // Successfully subscribed

        createWebSocket(id);
    } catch (error) {
        console.error("Error subscribing to symbols:", error);
    }
}

function createWebSocket(id) {
    const wsUrl = `wss://mt5.mtapi.io/OnQuote?id=${id}`;
    ws = new WebSocket(wsUrl);

    ws.onopen = function() {
        console.log("WebSocket connection established");
    };

    ws.onmessage = function(event) {
        const data = JSON.parse(event.data);
        // console.log("Received data:", data);

        if (data.type === 'Quote' && data.data) {
            const symbol = data.data.symbol;
            const bid = data.data.bid;
            const ask = data.data.ask;

            console.log(`Symbol: ${symbol}, Bid: ${bid}, Ask: ${ask}`);
            updatePrices(symbol, bid, ask);
                var xau_Bid = document.getElementById('xau-Bid')
                var xau_ask = document.getElementById('xau-ask')

                var xag_Bid = document.getElementById('xag-Bid')
                var xag_ask = document.getElementById('xag-ask')

                if (symbol === 'XAUUSD'  && xau_Bid && xau_ask) {
                    xau_Bid.innerHTML  = ` ${bid}`;
                    xau_ask.innerHTML  = ` ${ask}`;

                } else if (symbol === 'XAGUSD' && xag_Bid && xag_ask ) {
                    xag_Bid.innerHTML  = `${bid}`;
                    xag_ask.innerHTML  = `${ask}`;
                }



        }
    };

    ws.onclose = function(event) {
        console.warn("WebSocket connection closed:", event);
        setTimeout(() => {
            console.log("Reconnecting...");
            connectToAPI();
        }, 2000);
    };

    ws.onerror = function(error) {
        console.error("WebSocket error:", error);
    };


    // to create oredre ===========================
    // ############################################

        function sendOrder(symbol, volume, type) {
        const order = {
            action: "OrderSend", // تحديد نوع العملية
            symbol: symbol,
            volume: volume,
            type: type === "buy" ? 0 : 1 // 0 للشراء، 1 للبيع
        };


        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify(order));
            console.log("Order sent:", order);
        } else {
            // console.error("WebSocket is not open. Cannot send order.");
        }
    }

    // to create oredre ===========================
    // ############################################

    }



    connectToAPI();

    </script>

<script>

    function updatePrices(symbol, bid, ask) {
        // تحديث الأسعار في الكائن العالمي
        window.currentPrices[symbol] = { bid, ask };

        // تحديث عناصر HTML
        const bidElement = document.getElementById(`${symbol}-Bid`);
        const askElement = document.getElementById(`${symbol}-Ask`);

        if (bidElement && askElement) {
            bidElement.innerHTML = `${bid}`;
            askElement.innerHTML = `${ask}`;
        }
    }
    </script>








<script>
// function FormOrder(){
//     document.getElementById('asset').addEventListener('change', function() {
//     const selectedAsset = this.value;
//         console.log(selectedAsset);


//     if (selectedAsset === 'XAUUSD') {
//         document.getElementById('bidPrice').innerHTML = document.getElementById('xau-Bid').innerHTML.trim();
//         document.getElementById('askPrice').innerHTML = document.getElementById('xau-ask').innerHTML.trim();
//     } else if (selectedAsset === 'XAGUSD') {
//         document.getElementById('bidPrice').innerHTML = document.getElementById('xag-Bid').innerHTML.trim();
//         document.getElementById('askPrice').innerHTML = document.getElementById('xag-ask').innerHTML.trim();
//     }
// });






// Create order form submission
// document.getElementById('orderForm').addEventListener('submit', function(e) {
//     e.preventDefault();
//     const asset = document.getElementById('asset').value;
//     const bidPrice = document.getElementById('bidPrice').innerHTML;
//     const askPrice = document.getElementById('askPrice').innerHTML;

//     console.log(`Creating order for ${asset} at Bid: ${bidPrice}, Ask: ${askPrice}`);
//     // Implement your order creation logic here
// });
// }
</script>
















    {{-- <script>
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




