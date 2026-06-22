@extends('layouts.app')

@section('title', 'CRUNCHEEDOUGH')

@section('content')
<div class="container mt-5">
    <table class="table table-bordered">
        <!-- Heading Row -->
        <tr>
            <th colspan="2" class="text-center align-middle">
                <span class="text-success fs-3">CRUNCHEEDOUGH</span>
            </th>
        </tr>

        <!-- Catalogs Setting & Screens -->
        <tr>
            <td class="text-center align-middle">
                <img src="{{ asset('img/setting.jpg') }}" alt="Counter Screen" class="small-img mb-2">
            </td>
            <td class="text-center align-middle">
                <img src="{{ asset('img/scr.jpg') }}" alt="Counter Screen" class="small-img mb-2">
            </td>
        </tr>

        <!-- Category Foods/Desserts & Counter Screen -->
        <tr>
            <td class="text-center align-middle">
                <a href="{{ route('category.foods.desserts') }}">
                    <img src="{{ asset('img/des.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <img src="{{ asset('img/cook.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <br> Category Foods/Desserts
                </a>
            </td>
            <td class="text-center align-middle">
                <a href="{{ route('counter') }}">
    <img src="{{ asset('img/a.jpg') }}" alt="Counter Screen" class="small-img mb-2">
    <br> Counter Screen
</a>
                
                <br>
            </td>
        </tr>

        <!-- Options in Foods/Desserts & Kitchen Screen -->
        <tr>  
            <td class="text-center align-middle">
                <a href="{{ route('subFoods.index') }}">
                    <img src="{{ asset('img/sub1.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <img src="{{ asset('img/sub2.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <br> Options in Foods/Desserts
                </a>
            </td>
            <td class="text-center align-middle">
                <a href="{{ route('kitchen') }}">
                    <img src="{{ asset('img/shif.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <br> Kitchen Screen
                </a>
                <br><a href="">Current Date</a>
            </td>
        </tr>

        <!-- Items Section -->
        <tr>
            <td class="text-center align-middle">
                <a href="{{ route('foodItems.index') }}">
                    <img src="{{ asset('img/ds1.jpg') }}" alt="Counter Screen" class="small-img mb-2">
                    <br> Items
                </a>
            </td>
            <td class="text-center align-middle">
                <!-- Add content for this cell if needed -->
            </td>
        </tr>

        <!-- Exit Option for Admin -->
        @if (session('admn') == 1)
        <tr>
            <td colspan="2" class="text-center align-middle">
                <a href="">Exit</a>
            </td>
        </tr>
        @endif
    </table>
</div>
@endsection
