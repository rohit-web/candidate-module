@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Candidate') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="web_address" class="col-md-4 col-form-label text-md-right">{{ __('Web Address') }}</label>

                            <div class="col-md-6">
                                <input id="web_address" type="text" class="form-control @error('web_address') is-invalid @enderror" name="web_address" value="{{ old('web_address') }}" autocomplete="web_address">

                                @error('web_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cover_letter" class="col-md-4 col-form-label text-md-right">{{ __('Cover Letter') }}</label>

                            <div class="col-md-6">
                                <textarea id="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror" name="cover_letter" value="{{ old('cover_letter') }}">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Are you working?') }}</label>

                            <div class="col-md-6">
                                Yes{!! Form::radio('is_working', 1) !!}
                                No{!! Form::radio('is_working', 0) !!}
                                @error('is_working')
                                    <span class="invalid-feedback" style="display:block;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cover_letter" class="col-md-4 col-form-label text-md-right">{{ __('Upload Resume') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control-file @error('resume') is-invalid @enderror" name="resume" id="file" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Please upload a valid resume. Size of file should not be more than 3MB.</small>
                                
                                @error('resume')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('mimes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Candidate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
