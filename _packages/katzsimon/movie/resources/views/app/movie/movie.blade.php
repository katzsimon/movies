<div class="card @if(isset($loop) && !$loop->last)mb-12 @endif">
    <div class="card-header object-cover flex items-end" style="background-image: url(https://picsum.photos/640/480?{{ $item['id'] }});background-size:cover;height:200px;background-position: center;">
        <h3 class="text-4xl font-bold text-white tracking-wide" style="text-shadow:0 3px 5px rgba(0, 0, 0, 0.8)">{{ $item['name']??'' }}</h3>
    </div>
    <div class="card-body">
        <div>
            <strong>Rating: </strong>
            @for($i = 0; $i < $item['rating']; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="inline" style="width:1rem;height:1rem;">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            @endfor
        </div>
        <div>
            <strong>Genre: </strong> {{ $item['genre'] }}
        </div>
        <div>
            <strong>Runtime: </strong> {{ $item['runtime'] }} minutes
        </div>
        <div>
            <strong>Starring: </strong> {{ $item['starring'] }}
        </div>
        <div>
            <strong>Description: </strong> <div>{{ $item['description'] }}</div>
        </div>

    </div>
    @if(isset($item['screening_count']))
    <div class="card-footer">
        @if($item['screening_count']>0)
        <a href="{{ route("screenings", $item['id']) }}" class="btn btn-primary">Where can I watch?</a>
        @else
            <div><strong>This movie is currently not screening</strong></div>
        @endif
    </div>
    @endif
</div>
