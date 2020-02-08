<div class="row">
    @foreach($item['attach'] as $index => $field)

        @if(isset($field['src_big']))
            <div class="wrapper exmpl">
                <img src="{{ $field['src_big'] }}">
            </div>
        @elseif(isset($field['video_title']))
            <p>Видео: {{ $field['video_title'] }} <br>
            <div class="wrapper exmpl">
                <img src="{{ $field['video_cover_big'] }}">
            </div>
            </p>
        @endif

    @endforeach
</div>
