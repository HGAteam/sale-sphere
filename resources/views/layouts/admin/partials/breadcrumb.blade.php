<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
    <div>
        <h1>{{ $pageTitle }}</h1>
        <p class="breadcrumbs">
            @foreach ($breadcrumb as $crumb)
                <span>
                    @if (isset($crumb['url']))
                        <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    @else
                        {{ $crumb['label'] }}
                    @endif

                    @if (!$loop->last)
                        <span><i class="mdi mdi-chevron-right"></i></span>
                    @endif
                </span>
            @endforeach
        </p>
    </div>
    <div class="breadcrumb">
        @if (!$href && $modalLink != '#')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{ $modalLink }}">
                {{ $modalName }}
            </button>
        @elseif ($href)
            <a href="{{ $href }}" class="btn btn-primary">
                {{ $modalName }}
            </a>
        @endif
        @if (isset($modalLink2) && $modalLink2 != '#' && ($href2 || isset($modalName2)))
            @if (!$href2 && isset($modalName2))
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="{{ $modalLink2 }}">
                    {{ $modalName2 }}
                </button>
            @elseif ($href2)
                <a href="{{ $href2 }}" class="btn btn-success">
                    {{ $modalName2 }}
                </a>
            @endif
        @endif
    </div>
</div>
