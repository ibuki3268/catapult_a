@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
  <h1>ログインページ</h1>
  <form>
    <input type="text" placeholder="メールアドレス">
    <input type="password" placeholder="パスワード">
    <button type="submit">ログイン</button>
  </form>
@endsection