@extends('layouts.app')

@section('content')
    <div class="h-full">
        @auth
            @if (!Auth::user()->is_admin)
                <a href="/additem" class="font-medium text-[18px] h-12 w-fit px-4 flex items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                    Register food item
                </a>

                <h1 class="text-[20px] font-bold mb-4">Donated Food List</h1>
                <div class="h-full w-full flex flex-col">
                    @if ($fooditems->isEmpty())
                        <p>No food items available.</p>
                    @else
                        @foreach ($fooditems as $fooditem)
                            <div class="border rounded-lg shadow-lg p-4 mb-4 bg-white">
                                <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                <p><strong>Description:</strong> {{ $fooditem->description }}</p>
                                <p><strong>Type:</strong> {{ $fooditem->itemType->name ?? 'N/A' }}</p>
                                <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                <p><strong>Registered By:</strong> {{ $fooditem->user->username }}</p>
                                <p><strong>Registered at:</strong> {{ $fooditem->created_at }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            @elseif(Auth::user()->is_admin == true)
                <a href="/register" class=" font-medium text-[18px] h-12 w-fit px-4 flex items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                    Register User
                </a>
                <div class="w-full flex flex-col md:flex-row gap-y-8 md:gap-y-0 md:gap-x-8 ">
                    <div class="pb-8 min-h-[270px] w-full md:w-1/2 flex flex-col bg-white shadow-md rounded-2xl px-6">
                        <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                            <div class="text-[20px] font-bold">User List</div>
                            <form action="{{ route('dashboard.search') }}" method="GET" class="w-1/2 h-full relative">
                                <input
                                    name="username"
                                    class="w-full bg-whiteDarker h-full rounded-xl shadow-sm px-4"
                                    type="text"
                                    placeholder="search"
                                    value="{{ request('username') }}"
                                />
                                <span class="absolute top-2 right-2 material-symbols-outlined">manage_search</span>
                            </form>

                        </div>

                        <div class="pt-4 flex flex-col items-center justify-start gap-y-2">
                            @if (request('username'))
                                @if ($searchedUsers->isEmpty())
                                    <div>No users found.</div>
                                @else
                                    @foreach ($searchedUsers as $user)
                                        @if (!$user->is_admin)
                                            <a href="{{ route('user.fooditems', ['id' => $user->id]) }}"
                                            class="cursor-pointer w-full md:h-[70px] rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                                <div class="relative flex flex-row justify-between items-center w-full h-full">
                                                    <div class="">
                                                        <h2 class="text-lg font-medium ">{{ $user->username }}</h2>
                                                        <p class="text-md font-normal">{{ $user->email }}</p>
                                                    </div>
                                                    <span class="material-symbols-outlined h-[20px]">
                                                    arrow_forward_ios
                                                    </span>
                                                </div>

                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                @foreach ($users as $user)
                                    @if (!$user->is_admin)
                                        <a href="{{ route('user.fooditems', ['id' => $user->id]) }}"
                                        class="cursor-pointer w-full md:h-[70px] rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                        <div class="relative flex flex-row justify-between items-center w-full h-full">
                                            <div class="">
                                                <h2 class="text-lg font-medium ">{{ $user->username }}</h2>
                                                <p class="text-md font-normal">{{ $user->email }}</p>
                                            </div>
                                            <span class="material-symbols-outlined h-[20px]">
                                            arrow_forward_ios
                                            </span>
                                        </div>

                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="pb-8 min-h-[270px] w-full md:w-1/2 flex flex-col bg-white shadow-md rounded-2xl px-6">

                        @isset($clickeduser)
                                <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                                    <div class="text-[20px] font-bold">Donated Food List for: {{ $clickeduser->username }}</div>
                                </div>
                                @if ($fooditems->isEmpty())
                                        <div class="">No food items for this user.</div>
                                    @else
                                        <div class="w-full h-full flex flex-col justify-start items-center gap-y-2 pt-4">
                                            @foreach ($fooditems as $fooditem)

                                                <a href="{{ route('fooditem.edit', ['id' => $fooditem->id]) }}" class="cursor-pointer w-full  rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                                    <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                                    <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                                    <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                                    <p>Click to edit</p>
                                                </a>


                                            @endforeach
                                        </div>

                                    @endif

                        @else
                            <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                                    <div class="text-[20px] font-bold">Empty</div>
                                </div>
                        @endisset

                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection
