<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="mail-container">
        <div class="text-content">
            <p>Dear Mr/Mrs <strong>{{ $data['guardian_name'] }}</strong>,</p>
            <?php
                if ($data['gender'] == 'Male') {
                    $hs = 'he';
                    $sd = 'son';
                    $hshr = 'his';
                } else {
                    $hs = 'she';;
                    $sd = 'daughter';
                    $hshr = 'her';
                }
            ?>
            <p>This is your {{ $sd }}'s <strong>{{ $data['std_fullname'] }}</strong> guidance update. We've been notified that {{ $hs }} has <strong>{{ $data['count'] }} {{ $data['violation'] }}</strong> violations.
                A <strong>{{ $data['type'] }}</strong> notice for {{ $hshr }} <strong>{{ $data['subject'] }}</strong> subject as of <strong>{{$data['yr_sem']}}</strong> Year/Sem period will be served.
                <br/><br/>You may come to our school office regarding this matter.
            </p>
            <p><strong>Hopefully Yours,</strong><br/>CSJP Guidance</p>
        </div>
    </div>
</body>
</html>