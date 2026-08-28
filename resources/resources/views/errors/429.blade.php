@extends('errors::minimal')

@section('title', __('Error 429'))
@section('code', '429')
@section('message', __('Error 429'))
@section('description', "You have made too many requests in a short period of time. Please slow down and try again later.")
