@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('exe.user.show') . " : " . $user->id }}</div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $user->name }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Surname') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $user->surname }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="tel"
                                    class="form-control"
                                    value="{{ $user->phone }}"
                                    disabled
                                >
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    disabled
                                >
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="type_id" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.type') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ $user->type->name }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="department_id" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.department') }}</label>
                            <div class="col-md-6">
                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ $user->department->name }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="is_active" class="col-md-4 col-form-label text-md-end">{{ __('exe.user.isactive') }}</label>
                            <div class="col-md-6">
                                <div class="form-control border-0">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        @checked($user->is_active)
                                    disabled
                                    >
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
