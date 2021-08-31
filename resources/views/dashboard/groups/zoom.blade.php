<html>
<head>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css" />
</head>
<body>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- import ZoomMtg dependencies -->
    <script src="https://source.zoom.us/1.9.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.9.0/lib/vendor/lodash.min.js"></script>

    <!-- import ZoomMtg -->
    <script src="https://source.zoom.us/zoom-meeting-1.9.0.min.js"></script>


    <script>
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareJssdk();
        $.post("/dashboard/generate-zoom-signature", {_token: "{{ csrf_token() }}", group_id: {{ $event->zoom_meeting_id }}}, function(data) {
            var signature = data;
{{--            @if(Auth::user()->role != "user")--}}
            ZoomMtg.init({
                leaveUrl: '{{ url("/dashboard/zoom-leave") }}',
                isSupportAV: true,
                success: function() {
{{--                    @endif--}}
                    ZoomMtg.join({
                        signature: signature,
                        meetingNumber: {{ $event->zoom_meeting_id }},
                        userName: '{{ Auth::user()->name }} {{ Auth::user()->surname }}',
                        apiKey: '{{ env("ZOOM_API_KEY") }}',
                        userEmail: '{{ Auth::user()->email }}',
                        passWord: '{{ $event->zoom_meeting_password }}',
                        success: (success) => {
                            console.log(success)
                        },
                        error: (error) => {
                            console.log(error)
                        }
                    });
{{--                    @if(Auth::user()->role != "user")--}}
                }
            });
{{--            @endif--}}
        });
    </script>
</body>
</html>