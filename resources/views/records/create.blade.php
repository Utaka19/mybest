<header>
    <h1>今日の自己ベスト</h1>
</header>

<form action="#" method="POST">
    @csrf
    <div>
        <label for="category">カテゴリ</label>
        <select name="category" id="category" required>
            <option value="">選択してください</option>
            @foreach ($categories as $key => $label)
                <option value="{{ $key }}"
                    {{ old('category') === $key ?   'selected'    : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="title">ベスト</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
    </div>
    <div>
        <label for="note">メモ</label>
        <textarea name="note" id="note">{{ old('note') }}</textarea>
    </div>
    <div>
        <a href="#">数値を追加</a>
    </div>
    <button type="submit">保存する</button>
</form>
