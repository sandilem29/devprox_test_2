@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if (isset($toImport))
                    @if ($toImport > 0)
                        <p class="alert alert-warning">Users left to import: {{ $toImport }}</p>
                    @endif
                 @endif
                 @if (!isset($toImport))
                    @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                    @endif
                 @endif

            <div class="card">
                
                <div class="card-header">{{ __('Upload CSV') }}</div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('upload_file') }}" aria-label="{{ __('Upload CSV') }}" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Select CSV file') }}</label>

                            <div class="col-md-6">
                            <input id="file" type="file" class="form-control" name="file" required>
                                @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                     
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="upload">
                                    {{ __('Upload CSV') }}
                                </button>

                                <button type="reset" class="btn btn-secondary">
                                    {{ __('Cancel') }}
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