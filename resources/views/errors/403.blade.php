@extends('errors::minimal')

@section('title', __('اجازه ورود ندارید'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
