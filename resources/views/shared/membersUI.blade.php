@extends('layouts.app')

@section('title', '共有メンバー')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">共有メンバー</h2>
    
    <div class="space-y-3">
        @forelse ($members ?? [] as $member)
        <div class="bg-gray-900 rounded-lg p-4 flex items-center justify-between">
            <div>
                <h3 class="font-medium">{{ $member->name }}</h3>
                <p class="text-sm text-gray-400">{{ $member->email }}</p>
            </div>
            <button class="text-red-500 hover:text-red-400">削除</button>
        </div>
        @empty
        <p class="text-gray-500 text-center py-10">共有メンバーがいません</p>
        @endforelse
    </div>

    <button class="mt-6 w-full bg-teal-400 text-black font-bold py-3 rounded-lg hover:bg-teal-500">
        メンバーを追加
    </button>
</div>
@endsection