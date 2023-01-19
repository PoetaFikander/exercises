@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('exe.user.edit') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ $user->name }}"
                                        required
                                        autocomplete="name"
                                        placeholder="Kapitan"
                                        autofocus
                                    >
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="surname"
                                        type="text"
                                        class="form-control @error('surname') is-invalid @enderror"
                                        name="surname"
                                        value="{{ $user->surname }}"
                                        required
                                        autocomplete="surname"
                                        placeholder="Nemo"
                                    >
                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="phone"
                                        type="tel"
                                        pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        name="phone"
                                        value="{{ $user->phone }}"
                                        required
                                        autocomplete="phone"
                                        placeholder="123-456-789"
                                    >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ $user->email }}"
                                        required
                                        autocomplete="email"
                                        placeholder="kapitan@nemo.com"
                                    >
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="type_id" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.type') }}</label>

                                <div class="col-md-6">
                                    <select id="type_id" class="form-control" name="type_id">
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" @if($type->id == $user->type_id) selected @endif>{{ $type->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department_id" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.department') }}</label>

                                <div class="col-md-6">
                                    <select id="department_id" class="form-control" name="department_id">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                    @if($department->id == $user->department_id) selected @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="is_active" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.isactive') }}</label>

                                <div class="col-md-6">
                                    <div class="form-control border-0">
                                        <input
                                            id="is_active"
                                            type="checkbox"
                                            class="form-check-input"
                                            name="is_active"
                                            @checked($user->is_active)
                                        >
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('exe.buttons.edit') }}
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
