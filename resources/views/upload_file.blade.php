<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <title>Upload The CSV</title>
</head>

<body>
    <div class="container">
        <div class="title">Welcome! upload your csv file with as many records as you want!</div>
        <div class="form-container">
            <form method="post" enctype="multipart/form-data" id="upload_form">
                @csrf
                <input type="file" name="csvfile" id="csvfile">
                <input type="submit" value="Upload">
                <input type="hidden" value="2" id="name">
            </form>
        </div>

        <div class="progress_bar_div" id="progress_bar_div">
            <progress value="0" max="100" id="progress_bar">0 %</progress>
        </div>
        <div class="success" id="success">

        </div>

    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        document.getElementById("progress_bar_div").style.visibility = "hidden";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#upload_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('upload') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    var clearIntervalvar = setInterval(function() {
                        getBatchDetails({
                            id: data.id
                        });
                    }, 2000);

                    window.value = clearIntervalvar;

                }
            })
        });

        function getBatchDetails(batchId) {
            console.log(batchId);
            $.ajax({
                url: "{{ route('batch') }}",
                method: "GET",
                data: {
                    'id': batchId.id
                },
                dataType: 'JSON',
                success: function(data) {
                    document.getElementById("progress_bar_div").style.visibility = "visible";
                    document.getElementById("progress_bar").value = data.processedJobs;
                    document.getElementById("progress_bar").max = data.totalJobs;

                    if (data.totalJobs - data.processedJobs === 0) {
                        clearInterval(window.value);
                        document.getElementById("success").innerHTML = "File uploaded successfully.";
                    }
                }
            })
        }

    });
</script>