@extends('vague::errors.minimal')

@section('title', __('Forbidden'))
@section('image', '/vendor/vague/assets/403.svg')

@section('code', 403)

@section('message', "Forbidden, are you sure you've got what it takes?")