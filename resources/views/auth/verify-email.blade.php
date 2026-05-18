<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Email Verification</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height:100vh;">

        <div class="col-md-6">

            <div class="card border-0 shadow rounded-4">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">

                            Verify Email Address

                        </h2>

                        <p class="text-muted">

                            Thanks for signing up! Before getting started,
                            please verify your email address by clicking the
                            link we just emailed to you.

                        </p>

                    </div>

                    @if (session('status') == 'verification-link-sent')

                        <div class="alert alert-success">

                            A new verification link has been sent to your email address.

                        </div>

                    @endif

                    <div class="d-flex justify-content-between align-items-center">

                        <form method="POST"
                              action="{{ route('verification.send') }}">

                            @csrf

                            <button type="submit"
                                    class="btn btn-primary rounded-pill">

                                Resend Verification Email

                            </button>

                        </form>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-danger rounded-pill">

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>