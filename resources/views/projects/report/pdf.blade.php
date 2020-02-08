<!doctype html>
<head>
    <style type="text/css">
        body {
            font-family: DejaVu Sans;
        }
        p {
            font-size: 13px;
            word-break: break-all;
            line-height: 1;

        }

        h2 {
            font-size: 15px;
            color: #999;
        }



        div.row {
            width: 100%;
            clear: both;

        }

        .wrapper {
            width: 120px;
            height: 120px;
            float: left;
            margin-left: 3px;
        }
        .exmpl img {
            object-fit: cover;
            width: 100%;
            height: 100%;

        }
    </style>
</head>
<body>
Просмотры: <strong>{{ $views }}</strong> |
Лайки: <strong>{{ $likes }}</strong> |
Репосты: <strong>{{ $reposts }}</strong> |
Комментарии: <strong>{{$comments}}</strong><br>


@foreach($items as $item)

    <div class='row'>
        <h2>{{ $item['date'] }}</h2>
        <p>{{ $item['text'] }}</p>
        @if(count($item['attach']))
            @include('projects.report.attach', $item['attach'])
        @endif


    </div>

@endforeach

</body>
</html>
