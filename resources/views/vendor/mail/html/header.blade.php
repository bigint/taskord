<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Taskord')
<img loading=lazy src="https://i.ibb.co/9ypjVDG/logo-8l-Lu9-EPFa.png" class="logo" alt="Taskord Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
