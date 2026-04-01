<h1>Your Presentations</h1>

@foreach($presentations as $p)
    <div>
        <p><strong>Provider:</strong> {{ $p->provider }}</p>
        <p>{{ Str::limit($p->input_text, 100) }}</p>
        <small>{{ $p->created_at }}</small>
    </div>
@endforeach