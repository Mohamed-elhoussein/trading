<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="staticBackdropupdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form method="post" action="{{ route('updateCustomer') }}" style="width: 90%;margin:auto;">
                <div class="form-group">
                    @csrf
                  <label for="exampleInputEmail1">name</label>
                  <input type="text" name="name" placeholder="name"  class="form-control U_name" id="exampleInputEmail1">
                </div>
                <input type="hidden" name="id" id="customer_id">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" placeholder="email" class="form-control U_email" id="exampleInputEmail1" >
                  </div>


                    <div class="form-group">
                  <label for="exampleInputEmail1">Phone</label>
                  <input type="text" name="phone" placeholder="phone" class="form-control U_phone" id="exampleInputEmail1" >
                </div>

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Access</label>
                  <select name="country_id" class="form-control" id="exampleFormControlSelect1">
                    @php
                         $locale = app()->getLocale();
                    @endphp
                    @foreach ($county as $county)
                    <option value="{{ $county->id }}" > {{ $locale=="ar"?$county->title_ar : $county->title_en}} </option>

                    @endforeach
                  </select>
                </div>

              <!--   <button type="submit" class="btn btn-primary">Submit</button> -->

              <br>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" name="submit" class="btn btn-primary" value="edit">
        </form>
        </div>
      </div>
    </div>
  </div>
