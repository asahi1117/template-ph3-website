@props(['question', 'number'])

<div class="py-4 border-b border-gray-100">
    <p class="font-medium text-gray-900">Q{{ $number }}. {{ $question->text }}</p>
    <ul class="mt-2 text-gray-700">
        @foreach ($question->choices as $choice)
            <li class="py-1">
                {{ $choice->text }}
                @if ($choice->is_correct)
                    （正解）
                @endif
            </li>
        @endforeach
    </ul>
    @if ($question->supplement)
        <p class="mt-2 text-sm text-gray-500">{{ $question->supplement }}</p>
    @endif
</div>
