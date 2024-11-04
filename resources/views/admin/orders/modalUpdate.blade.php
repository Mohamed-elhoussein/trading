<!-- Modal -->
<div class="modal fade" id="varyingcontentModal_update" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingcontentModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Customer Name:</strong>
                    <span id="customerName"></span>
                </div>
                <div class="mb-3">
                    <strong>Stock Symbol:</strong>
                    <span id="stockSymbol"></span>
                </div>
                <div class="mb-3">
                    <strong>Volume:</strong>
                    <span id="volume"></span>
                </div>

                <div class="mb-3">
                    <strong>Total Price:</strong>
                    <span id="totalPrice"></span>
                </div>

                <div>
                    <strong>Current Price:</strong>
                    <span id="currentPrice"></span>
                </div>


                <div class="mb-3">
                    <strong>Order Status:</strong>
                    <span id="orderStatus"></span>
                </div>
                <div class="mb-3">
                    <strong>Delivery Status:</strong>
                    <span id="deliveryStatus"></span>
                </div>
                <div class="mb-3">
                    <strong>Shipping Address:</strong>
                    <span id="shippingAddress"></span>
                </div>
            </div>

            <form action="" method="post" id="form_update_order">

                <div class="form-group div_order_status" >
                    <label for="exampleFormControlSelect1"> order status </label>
                    <select name="order_status" class="form-control " id="order_status" >
                        <option value="open" >open</option>
                        <option value="closed" >closed</option>
                    </select>
                </div>
                <br><br><br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">save</button>
                    <br>
                    <button  id="OpenTrading_mt5" class="btn btn-primary Trading_mt5 " orderId="" data-bs-dismiss="modal">Trading With Mt5</button>
                    <button id="CloseTrading_mt5" class="btn btn-danger  Trading_mt5 " orderId="" data-bs-dismiss="modal">Close With Mt5</button>
                </div>
            </form>
        </div>
    </div>
</div>
