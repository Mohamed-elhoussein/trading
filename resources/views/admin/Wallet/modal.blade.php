<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form============ --}}
          <form method="post" action="{{ route('wallet.store') }}">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlSelect1">Access</label>
                <select name="customer_id " class="form-control" id="exampleFormControlSelect1">
                    @foreach ($customer as $customer)
                    <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
                    @endforeach
                </select>
              </div>
            <div class="form-group">
              <label for="exampleInputEmail1">amount</label>
              <input type="number" name="amount" placeholder="amount"  class="form-control" id="exampleInputEmail1">
            </div>

          <br>




          <!--   <button type="submit" class="btn btn-primary">Submit</button> -->

          <br>
          {{-- form============ --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" name="submit" class="btn btn-primary" value="save">
        </form>
        </div>
      </div>
    </div>
  </div>
