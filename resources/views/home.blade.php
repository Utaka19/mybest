@php
    $fmt = fn($val) => rtrim(rtrim(number_format((float)$val, 2, '.', ''), '0'), '.');
@endphp

<x-app-layout>
    <header class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            MyBest
        </h1>
    </header>

    @if (session('status'))
        <div
            id="flash-status"
            class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800"
        >
            {{ session('status') }}
        </div>
    @endif

    <main>
        {{-- 今日カード --}}
        <section aria-labelledby="today-card-title" class="mb-6">
            <article class="relative rounded-xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
                {{-- 今日バッジ --}}
                <span class="absolute -top-2 left-4 rounded-full bg-blue-600 px-3 py-0.5 text-xs font-semibold text-white">
                    今日
                </span>

                {{-- ヘッダー --}}
                <header class="flex items-center justify-end text-sm text-blue-700">
                    <span>{{ $today }}</span>
                </header>

                {{-- 内容 --}}
                @if ($todayRecord)
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $todayRecord->title }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $categories[$todayRecord->category] }}
                    </p>
                    @if (!is_null($todayRecord->value))
                        <p class="mt-2 text-base font-medium text-gray-800">
                            {{ $fmt($todayRecord->value) }} {{ $units [$todayRecord->unit] }}
                        </p>
                    @endif

                    <a
                        href="{{ route('records.edit', $todayRecord) }}"
                        class="mt-4 inline-block rounded-md bg-white px-4 py-2 text-sm font-medium text-blue-700 shadow hover:bg-blue-100"
                    >
                        編集する
                    </a>
                @else
                    <p class="text-base text-gray-700">
                        まだ記録がありません
                    </p>

                    <a
                        href="{{ route('records.create') }}"
                        class="mt-4 inline-block rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        今日の自己ベストを記録する
                    </a>

                    <p class="mt-2 text-xs text-gray-500">
                        1日1件でOK
                    </p>
                @endif
            </article>
        </section>

        {{-- 過去の記録 --}}
        <section aria-labelledby="past-records-title">
            <h2
                id="past-records-title"
                class="mb-3 text-lg font-semibold text-gray-800"
            >
                過去の記録
            </h2>

            @forelse( $pastRecords as $pastRecord )
                <a
                    href="{{ route('records.edit', $pastRecord) }}"
                    class="block rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 my-3"
                >
                    <article>
                        <header class="flex items-center justify-between text-sm text-gray-500">
                            <p>{{ $pastRecord->recorded_on->format('Y-m-d') }}</p>
                            <p>{{ $categories[$pastRecord->category] }}</p>
                        </header>

                        <p class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $pastRecord->title }}
                        </p>

                        @if (!is_null($pastRecord->value))
                            <p class="mt-2 text-base text-gray-800">
                                {{ $fmt($pastRecord->value) }} {{ $units[$pastRecord->unit] }}
                            </p>
                        @endif
                    </article>
                </a>
            @empty
                <p class="text-sm text-gray-500">まだ記録がありません</p>
            @endforelse
            <div class="mt-4">
                {{ $pastRecords->links() }}
            </div>
        </section>
    </main>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const flashStatus = document.getElementById('flash-status');
    if (!flashStatus) return;

    setTimeout(() => {
        flashStatus.style.display = 'none';
    }, 3000);
});
</script>
