@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200 email-settings">
        <div class="row">
            @if (config('core.setting.general.enable_email_smtp_settings', true))
                <div class="col-12 col-lg-6">
                    {!! Form::open(['route' => ['settings.email.normal-email-config']]) !!}

                    <div class="flexbox-annotated-section">
                        <div class="flexbox-annotated-section-annotation">
                            <div class="annotated-section-title pd-all-20">
                                <h2>Email settings</h2>
                            </div>
                            <div class="annotated-section-description pd-all-20 p-none-t">
                                <p class="color-note">Email template using HTML &amp; system variables.</p>
                            </div>
                        </div>

                        <div class="flexbox-annotated-section-content">
                            <div class="wrapper-content pd-all-20">
                                <div data-type="smtp" class="setting-wrapper">
                                    <div class="form-group mb-3">
                                        <label for="port" class="text-title-field">Port</label>

                                        <input type="number" class="form-control next-input @error('port') is-invalid @enderror" name="port" id="port" data-counter="10" placeholder="Ex: 587" value="{{ old('port') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('port') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="host" class="text-title-field">Host</label>

                                        <input type="text" class="form-control next-input @error('host') is-invalid @enderror" name="host" id="host" data-counter="60" placeholder="Ex: smtp.gmail.com" value="{{ old('host') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('host') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="username" class="text-title-field">Username</label>

                                        <input type="text" class="form-control next-input @error('username') is-invalid @enderror" name="username" id="username" data-counter="120" placeholder="Username to login to mail server" value="{{ old('username') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('username') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="text-title-field">Password</label>

                                        <input type="password" class="form-control next-input @error('password') is-invalid @enderror" name="password" id="password" data-counter="120" placeholder="Password to login to mail server" value="{{ old('password') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('password') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="encryption" class="text-title-field">Encryption</label>

                                        <input type="text" class="form-control next-input @error('encryption') is-invalid @enderror" name="encryption" id="encryption" data-counter="20" placeholder="Encryption: ssl or tls" value="{{ old('encryption') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('encryption') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="from_name" class="text-title-field">Sender name</label>

                                    <input type="text" class="form-control next-input @error('from_name') is-invalid @enderror" name="from_name" id="from_name" data-counter="60" placeholder="Name" value="{{ old('from_name') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('from_name') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="from_address" class="text-title-field">Sender email</label>

                                    <input type="text" class="form-control next-input @error('from_address') is-invalid @enderror" name="from_address" id="from_address" data-counter="60" placeholder="admin@example.com" value="{{ old('from_address') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp'))->offsetGet('from_address') }}">
                                </div>

                                <button class="btn btn-success" type="submit">
                                    {{ trans('core/setting::setting.submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @endif
            @if (config('core.setting.general.enable_email_smtp_settings', true))
                <div class="col-12 col-lg-6">
                    {!! Form::open(['route' => ['settings.email.pec-email-config']]) !!}

                    <div class="flexbox-annotated-section">
                        <div class="flexbox-annotated-section-annotation">
                            <div class="annotated-section-title pd-all-20">
                                <h2>PEC settings</h2>
                            </div>
                            <div class="annotated-section-description pd-all-20 p-none-t">
                                <p class="color-note">Email template using HTML &amp; system variables.</p>
                            </div>
                        </div>

                        <div class="flexbox-annotated-section-content">
                            <div class="wrapper-content pd-all-20">
                                <div data-type="smtp" class="setting-wrapper">
                                    <div class="form-group mb-3">
                                        <label for="pec_port" class="text-title-field">Port</label>

                                        <input type="number" class="form-control next-input @error('pec_port') is-invalid @enderror" name="pec_port" id="pec_port" data-counter="10" placeholder="Ex: 587" value="{{ old('pec_port') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('port') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="pec_host" class="text-title-field">Host</label>

                                        <input type="text" class="form-control next-input @error('pec_host') is-invalid @enderror" name="pec_host" id="pec_host" data-counter="60" placeholder="Ex: smtp.gmail.com" value="{{ old('pec_host') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('host') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="pec_username" class="text-title-field">Username</label>

                                        <input type="text" class="form-control next-input @error('pec_username') is-invalid @enderror" name="pec_username" id="pec_username" data-counter="120" placeholder="Username to login to mail server" value="{{ old('pec_username') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('username') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="pec_password" class="text-title-field">Password</label>

                                        <input type="password" class="form-control next-input @error('pec_password') is-invalid @enderror" name="pec_password" id="pec_password" data-counter="120" placeholder="Password to login to mail server" value="{{ old('pec_password') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('password') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="pec_encryption" class="text-title-field">Encryption</label>

                                        <input type="text" class="form-control next-input @error('pec_encryption') is-invalid @enderror" name="pec_encryption" id="pec_encryption" data-counter="20" placeholder="Encryption: ssl or tls" value="{{ old('pec_encryption') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('encryption') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pec_from_name" class="text-title-field">Sender name</label>

                                    <input type="text" class="form-control next-input @error('pec_from_name') is-invalid @enderror" name="pec_from_name" id="pec_from_name" data-counter="60" placeholder="Name" value="{{ old('pec_from_name') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('from_name') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pec_from_address" class="text-title-field">Sender email</label>

                                    <input type="text" class="form-control next-input @error('pec_from_address') is-invalid @enderror" name="pec_from_address" id="pec_from_address" data-counter="60" placeholder="admin@example.com" value="{{ old('pec_from_address') ?? optional(collect(json_decode(\Botble\Setting\Facades\Setting::get(\Botble\Setting\Models\Setting::MAILS),true))->get('smtp_pec'))->offsetGet('from_address') }}">
                                </div>

                                <button class="btn btn-success" type="submit">
                                    {{ trans('core/setting::setting.submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @endif
        </div>
    </div>

    {{--    <x-core-base::modal--}}
    {{--        id="send-test-email-modal"--}}
    {{--        :title="trans('core/setting::setting.test_email_modal_title')"--}}
    {{--        type="info"--}}
    {{--        button-id="send-test-email-btn"--}}
    {{--        :button-label="trans('core/setting::setting.send')"--}}
    {{--    >--}}
    {{--        <p>{{ trans('core/setting::setting.test_email_description') }}</p>--}}
    {{--        <div class="form-group mb-3">--}}
    {{--            <input type="email" class="form-control" name="email" placeholder="{{ trans('core/setting::setting.test_email_input_placeholder') }}">--}}
    {{--        </div>--}}
    {{--    </x-core-base::modal>--}}

    {{--    {!! $jsValidation !!}--}}
@endsection
