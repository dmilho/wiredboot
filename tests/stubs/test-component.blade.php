<div>
    <h1>{{ $title }}</h1>

    <ul>
        @foreach ($slides() as $slide)
            <li>{{ $slide }}</li>
        @endforeach
    </ul>
</div>
