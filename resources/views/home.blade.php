<x-app-layout>
    <header>
        <h1>MyBest</h1>
    </header>

    <main>
        {{-- 今日カード --}}
        <section aria-labelledby="today-card-title">
            <article>
                <header>
                    <span>今日</span>
                    <span>
                        {{ $today }}
                    </span>
                </header>

                @if ($todayRecord)
                    <p>{{ $todayRecord->title }}</p>
                    <p>{{ $categories[$todayRecord->category] }}</p>
                    @if (!is_null($todayRecord->value))
                        <p>{{ $todayRecord->value }} {{ $todayRecord->unit }}</p>
                    @endif

                    <a href="{{ route('records.edit', $todayRecord) }}">
                        編集する
                    </a>
                @else
                    <p>まだ記録がありません</p>

                    <a href="{{ route('records.create') }}">
                        今日の自己ベストを記録する
                    </a>

                    <p>1日1件でOK</p>
                @endif
            </article>
        </section>

        {{-- 過去の記録 --}}
        <section aria-labelledby="past-records-title">
            <h2 id="past-records-title">過去の記録</h2>
        </section>
    </main>
</x-app-layout>
