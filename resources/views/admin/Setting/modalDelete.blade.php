<!-- Button trigger modal -->


  <!-- Modal -->
  <form action="" method="post" class="__destroy">
    @csrf
    @method('Delete')
      <div class="modal fade" id="exampleModaldel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 style="color: red">Are you sure you want to Delete your setting</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

              <input type="submit"  class="btn btn-danger" value="Delete">
            </div>
          </div>
        </div>
      </div>


  </form>
