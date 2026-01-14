<header>
    <h1>今日の自己ベスト</h1>
</header>

@if ($errors->has('common'))
    <p>{{ $errors->first('common') }}</p>
@endif

<form action="{{ route('records.store') }}" method="POST">
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
        @error('title')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="note">メモ</label>
        <textarea name="note" id="note">{{ old('note') }}</textarea>
    </div>
    <div>
        <button type="button" id="btn-add-value">
            数値を追加
        </button>
    </div>
    {{-- 数値ブロック（初期は非表示） --}}
    <div id="value-block" style="display: none;">
        <div>
            <label for="value">数値</label>
            <input
                type="text"
                name="value"
                id="value"
                inputmode="decimal"
                value="{{ old('value') }}"
                placeholder="例：52.5"
            >
            @error('value')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="unit">単位</label>
            <select name="unit" id="unit" disabled>
                <option value="">選択してください</option>
                @foreach ($units as $key => $label)
                    <option value="{{ $key }}"
                        {{ old('unit') === $key ?   'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('unit')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="button" id="btn-remove-value">
                数値を削除
            </button>
        </div>
    </div>
    <button type="submit">保存する</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.getElementById('btn-add-value');
    const removeBtn = document.getElementById('btn-remove-value');
    const block = document.getElementById('value-block');
    const valueInput = document.getElementById('value');
    const unitSelect = document.getElementById('unit');

    const showBlock = () => {
        block.style.display = 'block';
        addBtn.style.display = 'none';
        syncUnitState();
        valueInput.focus();
    };

    const hideBlock = () => {
        // 値をクリア
        valueInput.value = '';
        unitSelect.value = '';
        // 非表示
        block.style.display = 'none';
        addBtn.style.display = 'inline-block';
        // unitは無効に戻す
        unitSelect.disabled = true;
    };

    const hasValue = () => {
        return valueInput.value.trim() !== '';
    };

    const syncUnitState = () => {
        // valueが空なら unit を無効、入っていれば有効
        unitSelect.disabled = !hasValue();
    };

    // 追加ボタン
    addBtn.addEventListener('click', showBlock);

    // 削除ボタン
    removeBtn.addEventListener('click', hideBlock);

    // value入力に応じてunitを制御
    valueInput.addEventListener('input', syncUnitState);

    // バリデーションエラーで戻ってきたとき：old(value)があれば開いた状態にする
    const oldValue = valueInput.value.trim();
    if (oldValue !== '') {
        showBlock();
    }
});
</script>
