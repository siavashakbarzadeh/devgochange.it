@extends('layouts.admin')

@section('page-title')
    {{__('Manage Document')}}
@endsection
@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.6.0/dist/multiple-select.min.css">
    <style>
        select {
            width: 100%;
        }

        .ms-parent .placeholder{
            background-color: unset !important;
        }

        .ck-editor__editable {
            min-height: 400px;
        }
    </style>
@endpush
@push('script-page')
    <script src="https://unpkg.com/multiple-select@1.6.0/dist/multiple-select.min.js"></script>
{{--    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>--}}
    <script>
        $('input[name="now"]').change(function (e) {
            const val= parseInt($(e.target).val());
            if(val === 1) {
                $('input[name="schedule_date"]').prop('disabled', true);
                $('input[name="schedule_time"]').prop('disabled', true);
                $('.schedule-date').hide();
            } else {
                $('input[name="schedule_date"]').prop('disabled', false);
                $('input[name="schedule_time"]').prop('disabled', false);
                $('.schedule-date').show();
            }
        });
        $(function () {
            $('select').multipleSelect({
                placeholder:"",
                filter: true
            });
            CKEDITOR.replace("message");
            /*console.log(CKEDITOR)
            CKEDITOR.ClassicEditor.create(document.getElementById("message"), {
                placeholder: document.getElementById("message").getAttribute("placeholder"),
                toolbar: {
                    items: [
                        'heading',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', 'removeFormat', 'findAndReplace', '-',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'horizontalLine', 'pageBreak', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [
                        {
                            name: /.*!/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                htmlEmbed: {
                    showPreviews: true
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                removePlugins: [
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType'
                ]
            });*/
        })
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Document')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create document')
            <a href="#" data-url="{{ route('document-upload.create') }}" data-ajax-popup="true" data-title="{{__('Create New Document Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

        @endcan
    </div>
@endsection
@section('content')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="col-xl">
					<form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data">
						@csrf
					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Recipient Set In Different Ways')}}</h6>
						    <div class="card-body">
					    		<div class="row">
									<div class="col-md-6 mb-2">
										<div class="mb-3">
                                            <div class="input-group input-group-merge">
                                                <label class="w-100 d-block">
                                                    <select name="emails[]" multiple="multiple" class="multiple-select">
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->email }}" @if(old('emails') && in_array($customer->email,old('emails'))) selected @endif>{{ $customer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
										</div>
									</div>
					    		</div>
					      	</div>
					    </div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Email Header Information')}}</h6>
						    <div class="card-body">
						    	<div class="row">
						    		<div class="col-md-4 mb-2">
					            		<label class="form-label">
					            			{{ __('Subject')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<input type="text"  value="{{old("subject")}}" name="subject" id="subject" class="form-control" placeholder="{{ __('Write email subject here')}}">
					            		</div>
					          		</div>
						    		<div class="col-md-4 mb-2">
										<label class="form-label">
											{{ __('Send From')}}
										</label>
										<div class="input-group input-group-merge">
												<input class="form-control" value="{{old("from_name")}}" placeholder="{{ __('Sender Name (Optional)')}}" type="text" name="from_name" id="from_name">
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<label class="form-label">
											{{ __('Reply To Email')}}
										</label>
										<div class="input-group input-group-merge">
												<input class="form-control" value="{{old("reply_to_email")}}" type="email" placeholder="{{ __('Reply To Email (Optional)')}}" name="reply_to_email" id="reply_to_email">
										</div>
									</div>
						    	</div>
						    </div>
						</div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Email Body')}}</h6>
						    <div class="card-body">
				          		<div class="row">
					          		<div class="col-12">
					            		<label class="form-label">
					            			{{ __('Message Body')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group">
                                            <label class="w-100 d-block">
                                                <textarea class="form-control w-100" name="message" id="message">{!! old('message') !!}</textarea>
                                            </label>
					            		</div>
					          		</div>
				          		</div>
					      	</div>
					    </div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Sending Options')}}</h6>
						    <div class="card-body">
				          		<div class="row">
				          			<div class="col-md-6 mb-4">
					            		<label for="schedule" class="form-label">{{ __('Send Email')}} <sup class="text-danger">*</sup></label>
										<div>
											<div class="form-check form-check-inline">
												<input {{old("now") ==  '1'? "checked" :""}} class="form-check-input" type="radio" name="now" id="now" value="1" checked="">
												<label class="form-check-label" for="now">{{ __('Now')}}</label>
											</div>

											<div class="form-check form-check-inline">
												<input  {{old("now") ==  '2'? "checked" :""}} class="form-check-input" type="radio" name="now" id="later" value="2">
												<label class="form-check-label" for="later">{{ __('Later')}}</label>
											</div>
										</div>
					          		</div>
					          		<div class="col-md-6 schedule-date" @if(old("now") !=  '2') style="display:none;" @endif>
                                        <div class="d-flex gap-2 align-items-center w-100">
                                            <label class="d-flex flex-column">
                                                <input type="date" name="schedule_date" value="{{ old('schedule_date') }}" class="form-control" @if(old("now") !=  '2') disabled @endif>
                                                @error('schedule_date')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <label class="d-flex flex-column">
                                                <input type="time" name="schedule_time" value="{{ old('schedule_time') }}" class="form-control" @if(old("now") !=  '2') disabled @endif>
                                                @error('schedule_time')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                        </div>
                                    </div>
				          		</div>
				          	</div>
				        </div>

					    <button type="submit" class="btn btn-primary me-sm-3 me-1">
							{{__("Submit")}}
						</button>
				    </form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

