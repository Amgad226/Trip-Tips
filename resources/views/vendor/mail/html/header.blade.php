<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Trip-Tips')
<!-- <img src="{{url('/storage/6.png')}}" class="logo" alt="Trip-Tips Logo"> -->
<span style="color: #FCB700;font-size: 40px;font-family:'Oleo Script' " class="one">{{config('app.name')}}</span>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

