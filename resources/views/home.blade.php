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

                @if ($today_record)
                    <p>{{ $today_record->title }}</p>
                    <p>{{ $today_record->category }}</p>
                    @if (!is_null($today_record->value))
                        <p>{{ $today_record->value }} {{ $today_record->unit }}</p>
                    @endif

                    <a href="#">
                        編集する
                    </a>
                @else
                    <p>まだ記録がありません</p>

                    <a href="/records/create">
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
