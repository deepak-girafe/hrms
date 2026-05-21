{{-- Attendance Widget --}}

<div class="">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-header bg-white border-0">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">

                    Today's Attendance

                </h5>

                <span class="badge bg-light text-dark rounded-pill px-3 py-2">

                    {{ now()->format('d M Y') }}

                </span>

            </div>

        </div>

        <div class="card-body text-center">

            @php

                $todayAttendance = \App\Models\Attendance::where(

                    'user_id',
                    auth()->id()

                )->where(

                    'attendance_date',
                    now()->toDateString()

                )->first();

                $dayName = now()->format('l');

                $isWeeklyOff = in_array($dayName, [

                    'Saturday',
                    'Sunday'

                ]);

                $isHoliday = \App\Models\Holiday::where(
                    'holiday_date',
                    now()->toDateString()
                )->where(
                    'status',
                    'Active'
                )->exists();

            @endphp

            <h6 class="text-muted mb-4">

                {{ $dayName }}

            </h6>

            {{-- Weekly Off --}}

            @if($isWeeklyOff)

                <div class="alert alert-warning rounded-4 mb-0">

                    <i class="bi bi-calendar-x me-2"></i>

                    Weekly Off

                </div>

            {{-- Holiday --}}

            @elseif($isHoliday)

                <div class="alert alert-info rounded-4 mb-0">

                    <i class="bi bi-calendar-event me-2"></i>

                    Holiday

                </div>

            @else

                {{-- Not Marked --}}

                @if(!$todayAttendance)

                    <div class="mb-4">

                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;">

                            <i class="bi bi-camera-fill text-success"
                               style="font-size:35px;"></i>

                        </div>

                    </div>

                    <button class="btn btn-success rounded-pill px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#attendanceModal">

                        <i class="bi bi-camera-fill me-2"></i>

                        Mark Attendance

                    </button>

                {{-- Punch Out Pending --}}

                @elseif($todayAttendance && !$todayAttendance->punch_out)

                    <div class="mb-4">

                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;">

                            <i class="bi bi-check-circle-fill text-success"
                               style="font-size:35px;"></i>

                        </div>

                    </div>

                    <div class="mb-3">

                        <span class="badge bg-success px-4 py-3 rounded-pill">

                            Punch In:
                            {{ \Carbon\Carbon::parse($todayAttendance->punch_in)->format('h:i A') }}

                        </span>

                    </div>

                    <button class="btn btn-danger rounded-pill px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#attendanceOutModal">

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Punch Out

                    </button>

                {{-- Completed --}}

                @else

                    <div class="mb-4">

                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;">

                            <i class="bi bi-patch-check-fill text-primary"
                               style="font-size:35px;"></i>

                        </div>

                    </div>

                    <div class="alert alert-success rounded-4">

                        Attendance Completed

                    </div>

                    <div class="row mt-4">

                        <div class="col-4">

                            <small class="text-muted d-block mb-1">

                                In

                            </small>

                            <strong>

                                {{ \Carbon\Carbon::parse($todayAttendance->punch_in)->format('h:i A') }}

                            </strong>

                        </div>

                        <div class="col-4">

                            <small class="text-muted d-block mb-1">

                                Out

                            </small>

                            <strong>

                                {{ \Carbon\Carbon::parse($todayAttendance->punch_out)->format('h:i A') }}

                            </strong>

                        </div>

                        <div class="col-4">

                            <small class="text-muted d-block mb-1">

                                Hours

                            </small>

                            <strong>

                                {{ $todayAttendance->working_hours }}

                            </strong>

                        </div>

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>

{{-- Punch In Modal --}}

<div class="modal fade"
     id="attendanceModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Mark Attendance

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body text-center">

                <video id="video"
                       width="320"
                       height="240"
                       autoplay
                       class="rounded-4 border shadow-sm"></video>

                <canvas id="canvas"
                        width="320"
                        height="240"
                        class="d-none"></canvas>

                <form method="POST"
                      action="{{ route('attendance.punchin') }}"
                      id="attendanceForm">

                    @csrf

                    <input type="hidden"
                           name="image"
                           id="imageInput">

                    <input type="hidden"
                           name="latitude"
                           id="latitude">

                    <input type="hidden"
                           name="longitude"
                           id="longitude">

                    <button type="button"
                            onclick="captureAttendance()"
                            class="btn btn-success rounded-pill px-4 mt-4">

                        <i class="bi bi-camera-fill me-2"></i>

                        Capture & Punch In

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

{{-- Punch Out Modal --}}

<div class="modal fade"
     id="attendanceOutModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Punch Out

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body text-center">

                <video id="videoOut"
                       width="320"
                       height="240"
                       autoplay
                       class="rounded-4 border shadow-sm"></video>

                <canvas id="canvasOut"
                        width="320"
                        height="240"
                        class="d-none"></canvas>

                <form method="POST"
                      action="{{ route('attendance.punchout') }}"
                      id="attendanceOutForm">

                    @csrf

                    <input type="hidden"
                           name="image"
                           id="imageOutInput">

                    <input type="hidden"
                           name="latitude"
                           id="latitudeOut">

                    <input type="hidden"
                           name="longitude"
                           id="longitudeOut">

                    <button type="button"
                            onclick="capturePunchOut()"
                            class="btn btn-danger rounded-pill px-4 mt-4">

                        <i class="bi bi-camera-fill me-2"></i>

                        Capture & Punch Out

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

/*
|--------------------------------------------------------------------------
| Camera Access
|--------------------------------------------------------------------------
*/

async function startCamera(videoId)
{
    try {

        const stream = await navigator
            .mediaDevices
            .getUserMedia({
                video: true
            });

        document.getElementById(
            videoId
        ).srcObject = stream;

    } catch (err) {

        alert(
            'Camera access denied'
        );
    }
}

/*
|--------------------------------------------------------------------------
| Modal Events
|--------------------------------------------------------------------------
*/

document.getElementById(
    'attendanceModal'
).addEventListener(

    'shown.bs.modal',

    function () {

        startCamera('video');
    }

);

document.getElementById(
    'attendanceOutModal'
).addEventListener(

    'shown.bs.modal',

    function () {

        startCamera('videoOut');
    }

);

/*
|--------------------------------------------------------------------------
| GPS
|--------------------------------------------------------------------------
*/

if(navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(

        function(position) {

            document.getElementById(
                'latitude'
            ).value = position.coords.latitude;

            document.getElementById(
                'longitude'
            ).value = position.coords.longitude;

            document.getElementById(
                'latitudeOut'
            ).value = position.coords.latitude;

            document.getElementById(
                'longitudeOut'
            ).value = position.coords.longitude;

        }

    );
}

/*
|--------------------------------------------------------------------------
| Punch In
|--------------------------------------------------------------------------
*/

function captureAttendance()
{
    const canvas = document.getElementById(
        'canvas'
    );

    const context = canvas.getContext('2d');

    const video = document.getElementById(
        'video'
    );

    context.drawImage(

        video,
        0,
        0,
        320,
        240

    );

    const image = canvas.toDataURL(
        'image/png'
    );

    document.getElementById(
        'imageInput'
    ).value = image;

    document.getElementById(
        'attendanceForm'
    ).submit();
}

/*
|--------------------------------------------------------------------------
| Punch Out
|--------------------------------------------------------------------------
*/

function capturePunchOut()
{
    const canvas = document.getElementById(
        'canvasOut'
    );

    const context = canvas.getContext('2d');

    const video = document.getElementById(
        'videoOut'
    );

    context.drawImage(

        video,
        0,
        0,
        320,
        240

    );

    const image = canvas.toDataURL(
        'image/png'
    );

    document.getElementById(
        'imageOutInput'
    ).value = image;

    document.getElementById(
        'attendanceOutForm'
    ).submit();
}

</script>