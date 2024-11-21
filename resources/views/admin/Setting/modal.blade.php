<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form============ --}}
          <form method="post" id="_form" action="{{ route('setting.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- <input type="hidden" name="setting_id"  id="setting_id"> --}}
            <input type="hidden" name="_method"     id="_method">
            <div class="form-group">
                <label for="logo">{{ __("Logo") }}</label>
                <input type="file" class="form-control" id="logo" name="logo" maxlength="200" >
            </div>

            <div class="form-group">
                <label for="name">{{ __("name") }}</label>
                <input type="text" class="form-control n_name" id="name" name="name" maxlength="50" required>
            </div>

            <div class="form-group">
                <label for="description">{{ __("description") }}</label>
                <textarea class="form-control n_description" id="description" name="description" maxlength="400" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="instagram">{{ __("instagram") }}</label>
                <input type="text" class="form-control n_instagram" id="instagram" name="instagram" maxlength="300">
            </div>

            <div class="form-group">
                <label for="whatsApp">{{ __("whatsapp") }}</label>
                <input type="text" class="form-control n_whatsApp" id="whatsApp" name="whatsApp" maxlength="300">
            </div>

            <div class="form-group">
                <label for="facebook">{{ __("facebook") }}</label>
                <input type="text" class="form-control n_facebook" id="facebook" name="facebook" maxlength="300">
            </div>

            <div class="form-group">
                <label for="snapchat">{{ __("snapchat") }}</label>
                <input type="text" class="form-control n_snapchat" id="snapchat" name="snapchat" maxlength="300">
            </div>

            <div class="form-group">
                <label for="email">{{ __("Email") }}</label>
                <input type="email" class="form-control n_email" id="email" name="email" maxlength="150">
            </div>

            <div class="form-group">
                <label for="phone">{{ __("Phone") }}</label>
                <input type="text" class="form-control n_phone" id="phone" name="phone" maxlength="14">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("close") }}</button>
            <input type="submit" name="submit" class="btn btn-primary" value="{{ __('save') }}">
        </form>
        {{-- form============ --}}
        </div>
      </div>
    </div>
  </div>
