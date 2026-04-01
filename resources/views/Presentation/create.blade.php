<form action="{{ route('presentations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <textarea name="content" placeholder="Paste your text"></textarea>

    <input type="file" name="document" accept=".docx">

    <select name="provider">
        <option value="openai">OpenAI</option>
        <option value="grok">Grok</option>
    </select>

    <button type="submit">Generate</button>
</form>