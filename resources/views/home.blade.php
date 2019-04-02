@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">  
            <div class="card">
               
                <div class="card-header">{{ __('Generate CSV') }}</div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('create_csv') }}" aria-label="{{ __('Create CSV') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="number_of_records" class="col-md-4 col-form-label text-md-right">{{ __('Number of records') }}</label>

                            <div class="col-md-6">
                                <input id="number_of_record" placeholder="Number of records" type="number" class="form-control{{ $errors->has('number_of_records') ? ' is-invalid' : '' }}" name="number_of_records" value="{{ old('number_of_records') }}" required autofocus>

                                @if ($errors->has('number_of_records'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('number_of_records') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                     
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="create_records">
                                    {{ __('Generate CSV') }}
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