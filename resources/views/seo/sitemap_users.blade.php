@foreach ($users as $user)
    {!! nl2br(e('https://taskord.com/@'.$user->username."\n")) !!}
@endforeach
