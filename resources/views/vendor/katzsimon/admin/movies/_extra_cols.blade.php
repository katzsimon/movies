@if(!isset($item))
    {{-- Extra Column Header --}}
    <th class="text-center">Screenings</th>
@else
    {{-- Extra Column Data --}}
    <td class="text-center">{{ $item['screening_count']??'' }}</td>
@endif
