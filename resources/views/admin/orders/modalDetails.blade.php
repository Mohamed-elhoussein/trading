

<div class="modal fade" id="exampleModalwalletHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="width: 873px;  right: 150px;" >
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">walletHistory</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="loading" class="loading-overlay" style="display: none;  position:absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10;">

            <p style=" font-size: 1.5rem; color: #333; text-align: center;"> Loading... </p>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Id</th>
                        <th scope="col">Action </th>
                        <th scope="col">data</th>
                        <th scope="col">do by</th>
                        <th scope="col">trading type</th>
                        <th scope="col">Customer Id</th>
                        <th scope="col">User Id</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody id="OrderDetails"></tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
