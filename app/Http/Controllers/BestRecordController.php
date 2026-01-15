<?php

namespace App\Http\Controllers;

use App\Models\BestRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BestRecordController extends Controller
{
    public function create()
    {
        $today = now()->toDateString();

        $todayRecord = BestRecord::where('user_id', Auth::id())
            ->where('recorded_on', $today)
            ->first();

        if ($todayRecord) {
            return redirect()
                ->route('records.edit', $todayRecord);
        }

        return view('records.create',
        ['today' => $today,
        'categories' => config('categories'),
        'units' => config('units'),]);
    }

    public function store(Request $request)
    {
        $request->merge(['value' => trim((string) $request->input('value'))]);

        $validated = $request->validate(
            [
                'category' => ['required', Rule::in (array_keys(config('categories')))],
                'title'    => ['required', 'string',    'max:255'],
                'note'     => ['nullable', 'string'],
                'value'    => ['nullable', 'decimal:0,2'],
                'unit'     => [
                    'exclude_if:value,null',
                    'required_with:value',
                    Rule::in(array_keys(config  ('units'))),
                ],
            ],
            [
                'title.required' => ':attributeは必須です。',
                'value.decimal' => ':attributeは小数第2位までで入力してください。',
                'unit.required_with' => ':attributeを選択してください。',
                'unit.in' => ':attributeの選択が不正です。',
            ],
            [
                'category' => 'カテゴリ',
                'title' => 'ベスト',
                'note' => 'メモ',
                'value' => '数値',
                'unit' => '単位',
            ]
        );

        $today = now()->toDateString();

        $exists = BestRecord::where('user_id', Auth::id())
            ->where('recorded_on', $today)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'common' => '今日はすでに記録があります',
                ]);
        }

        BestRecord::create([
            'user_id'     => Auth::id(),
            'recorded_on' => $today,
            'category'    => $validated['category'],
            'title'       => $validated['title'],
            'note'        => $validated['note'] ?? null,
            'value'       => $validated['value'] ?? null,
            'unit'        => $validated['unit'] ?? null,
        ]);

        return redirect()
            ->route('home')
            ->with('status', '保存しました');
    }

    public function edit(BestRecord $bestRecord)
    {
        abort_unless($bestRecord->user_id === Auth::id(), 403);

        return view('records.edit',
        ['record' => $bestRecord,
        'categories' => config('categories'),
        'units' => config('units'),]);
    }

    public function update(Request $request, BestRecord $bestRecord)
    {
        $request->merge(['value' => trim((string) $request->input('value'))]);

        $validated = $request->validate(
            [
                'category' => ['required', Rule::in (array_keys(config('categories')))],
                'title'    => ['required', 'string',    'max:255'],
                'note'     => ['nullable', 'string'],
                'value'    => ['nullable', 'decimal:0,2'],
                'unit'     => [
                    'exclude_if:value,null',
                    'required_with:value',
                    Rule::in(array_keys(config  ('units'))),
                ],
            ],
            [
                'title.required' => ':attributeは必須です。',
                'value.decimal' => ':attributeは小数第2位までで入力してください。',
                'unit.required_with' => ':attributeを選択してください。',
                'unit.in' => ':attributeの選択が不正です。',
            ],
            [
                'category' => 'カテゴリ',
                'title' => 'ベスト',
                'note' => 'メモ',
                'value' => '数値',
                'unit' => '単位',
            ]
        );

        abort_unless($bestRecord->user_id === Auth::id(), 403);

        $bestRecord->update([
            'category'    => $validated['category'],
            'title'       => $validated['title'],
            'note'        => $validated['note'] ?? null,
            'value'       => $validated['value'] ?? null,
            'unit'        => $validated['unit'] ?? null,
        ]);

        return redirect()
            ->route('home')
            ->with('status', '更新しました');
    }
}
