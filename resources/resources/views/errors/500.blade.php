@extends('errors::minimal')

@section('title', __('Error 500'))
@section('code', '500')
@section('message', __('Error 500'))
@section('description', "Something went wrong on our servers. We are looking into it. Please try again later.")
