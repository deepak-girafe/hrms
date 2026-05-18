<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Confirm Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height:100vh;">

        <div class="col-md-5">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <h3 class="fw-bold">
                            Confirm Password
                        </h3>

                        <p class="text-muted">

                            This is a secure area of the application.
                            Please confirm your password before continuing.

                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('password.confirm') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required
                                   autocomplete="current-password">

                            @error('password')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="d-grid">

                            <button type="submit"
                                    class="btn btn-primary rounded-pill">

                                Confirm Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>