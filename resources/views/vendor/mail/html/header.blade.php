<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<!-- <img src="{{url('/storage/6.png')}}" class="logo" alt="Trip-Tips Logo"> -->
<span class="one">Trip Tips</span>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
