@php
    $segments = Request::segments();
    $title = ucfirst(end($segments));
@endphp
<div class="row">
<div class="col-12">
<div class="page-title-box">
    <div class="page-title-left">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Início</a></li>

            @foreach ($segments as $index => $segment)
                @php
                    $path = implode('/', array_slice($segments, 0, $index + 1));
                    $label = ucwords(str_replace('-', ' ', $segment));
                @endphp

                @if ($loop->last)
                    <li class="breadcrumb-item active">{{ $label }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ url($path) }}">{{ $label }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</div>
</div>
</div>
