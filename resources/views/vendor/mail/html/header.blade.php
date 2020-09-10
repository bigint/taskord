<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Taskord')
<img src="https://taskord.com/images/logo.svg" class="logo" alt="Taskord Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
