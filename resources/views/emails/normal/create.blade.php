@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('select').select2({width: '100%'});
            $(document).on('click', '.select2-results__group', function (event) {
                const select = $('select');
                const groupName = $(this).html()
                const options = select.find('option');
                $.each(options, function (key, value) {
                    if ($(value)[0].parentElement.label.indexOf(groupName) >= 0) {
                        $(value).prop("selected", "selected");
                    }
                });
                select.trigger("change");
                select.select2('close');
            });
        });
    </script>
@endpush
@section('content')
    <div class="wrapper-content pd-all-20">
        <form action="{{ route('admin.emails.normal.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="emails" class="text-title-field">Emails</label>
                <select name="emails[]" id="emails" multiple>
                    @foreach($emails as $key=>$email)
                        <optgroup label="{{ $key }}">
                            @foreach($email as $item)
                                <option value="{{ $item['email'] }}"
                                        @if(old('emails') && in_array($item['email'],old('emails'))) selected @endif>{{ $item['email'] }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('emails')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label for="subject" class="text-title-field">Subject</label>
                        <input type="text" class="form-control next-input @error('subject') is-invalid @enderror"
                               name="subject" id="subject" value="{{ old('subject') }}">
                        @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label for="reply_to" class="text-title-field">Reply to</label>
                        <input type="text" class="form-control next-input @error('reply_to') is-invalid @enderror"
                               name="reply_to" id="reply_to" value="{{ old('reply_to') }}">
                        @error('reply_to')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="body" class="text-title-field">Body</label>

                <textarea name="body" id="body" rows="10"
                          class="form-control next-input @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                @error('body')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-success">Send</button>
        </form>
    </div>
@endsection
