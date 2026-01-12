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
                    <time datetime="{{ today()->format('Y-m-d') }}">
                        {{ today()->format('Y-m-d') }}
                    </time>
                </header>

                <p>まだ記録がありません</p>

                <a href="{{ url('/') }}">
                    今日の自己ベストを記録する
                </a>

                <p>1日1件でOK</p>
            </article>
        </section>

        {{-- 過去の記録 --}}
        <section aria-labelledby="past-records-title">
            <h2 id="past-records-title">過去の記録</h2>
        </section>
    </main>
</x-app-layout>
