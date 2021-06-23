@foreach ($questions as $question)
    {{ 'https://taskord.com/question/' . $question->slug }}
@endforeach
