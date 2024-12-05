<style>
    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
    }

    .pagination a.active {
        background-color: #00bac7;
        color: white;
        border-radius: 10px;
    }

    .pagination a:hover:not(.active) {background-color: #00bac7}

    .divPagination{
        border-top: 1px solid #00bac7;
        display: flex; 
        flex-direction: column; 
        align-items: center;
        padding: 10px;
    }
    .disable{
        pointer-events: none !important; 
        color: lightgray !important;
    }

</style>

@if ($paginator->hasPages())
    <div class="divPagination">
        <div class="pagination">
            @if ($paginator->onFirstPage())
            <a href="#" class="disable"><span><b>← Anterior</b></span></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><b>← Anterior </b></a>
            @endif

        
            @foreach ($elements as $element)
            
                @if (is_string($element))
                    <a href="#"><span><b>{{$element}}</b></span></a>
                @endif

            
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="active"><span><b>{{$page}}</b></span></a>
                        @else
                            <a href="{{ $url }}"><b>{{$page}}</b></a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"><b>Próximo →</b></a>
            @else
                <a href="#" class="disable"><span><b>Próximo →</b></span></a>
            @endif
        </div>
    </div>
@endif 