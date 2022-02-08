<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1">{{ $settings['network_name'] ?? '' }}</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">{{ __('common.sign_in_to_start') }}</p>

            <form @submit.prevent="loginByAuth">
                <div class="input-group mb-1 mt-2">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        v-model="email"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <form-error-list-printer :error-list="loginErrors.email" />
                <div class="input-group mb-1 mt-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        v-model="password"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                </div>
                <form-error-list-printer :error-list="loginErrors.password" />

                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button class="mt-4 btn btn-primary w-100" type="submit">
                            {{ __('common.sign_in') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-0 mt-2">
                <a href="#">
                    {{ __('common.forgot_password') }}
                </a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
