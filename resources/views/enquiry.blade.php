@extends('layouts.myapp')
@section('content')


    <div class="flex flex-col items-center justify-center max-w-screen-xl mx-auto my-20 ">
         <form class="w-full" action="{{ route('store_enquiry') }}" method="GET" enctype="multipart/form-data">

            @csrf
            <div class="md:w-2/3 w-5/6 md:px-24 px-4 pb-8 mx-auto mt-2 space-y-12 bg-white border-2 border-gray-600 rounded-md">
                <div class="pb-12 border-b border-gray-900/10">
                    <h2 class="mt-2 text-lg font-bold leading-7 text-center text-gray-900">Fill the new Enquiry details</h2>

                    <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="brand" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="brand"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="sm:col-span-3">
                            <label for="model" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input type="text" name="email" id="model"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2 sm:col-start-1">
                            <label for="engine" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                            <div class="mt-2">
                                <input type="text" name="address" id="engine"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('address')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Mobile No</label>
                            <div class="mt-2">
                                <input type="text" name="mobile_no" id="quantity"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('mobile_no')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="stars" class="block text-sm font-medium leading-6 text-gray-900">Vehicle Type
                                </label>
                            <div class="mt-2">
                                <select id="stars" name="vehicle_type"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option></option>
                                    <option value="car">Car</option>
                                    <option value="suv">SUV</option>
                                    <option value="van">Van</option>
                                    <option value="auto">Auto</option>
                                    <option value="bus">Bus</option>
                                </select>
                            </div>
                            @error('vehicle_type')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">Start Date
                            </label>
                            <div class="mt-2">
                                <input type="date" name="start_date" id="reduce"  value= {{ $startDate }}
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('start_date')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">End Date
                            </label>
                            <div class="mt-2">
                                <input type="date" name="end_date" id="reduce"value= {{ $endDate }}
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('end_date')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">Start Loc
                            </label>
                            <div class="mt-2">
                                <input type="text" name="start_loc" id="reduce" value={{ $start_location }}
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('start_loc')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">End Loc
                            </label>
                            <div class="mt-2">
                                <input type="text" name="end_loc" id="reduce" value={{ $end_location }}
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('end_loc')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">Seat
                            </label>
                            <div class="mt-2">
                                <input type="text" name="seat" id="reduce"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('seat')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">Luckage
                            </label>
                            <div class="mt-2">
                                <input type="text" name="luckage" id="reduce"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('luckage')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="insurance_status"
                                class="block text-sm font-medium leading-6 text-gray-900">Journey Type</label>
                            <div class="mt-2">
                                <select id="insurance_status" name="journey_type"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option></option>
                                    <option value="drop">Drop</option>
                                    <option value="drop&pickup">drop & Pickup</option>
                                </select>
                            </div>
                            @error('journey_type')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="status" class="block text-sm font-medium leading-6 text-gray-900">AC</label>
                            <div class="mt-2">
                                <select id="status" name="AC"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option></option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            @error('AC')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-6">
                            <label for="insurance_status" class="block text-sm font-medium leading-6 text-gray-900">Description
                            </label>
                            <div class="mt-2">
                                <textarea type="text" name="desc" id="reduce"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            @error('desc')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>


                <div class="flex items-center justify-center mb-6 gap-x-6">
                    <a href=""
                        class="w-20 p-1 text-sm font-semibold leading-6 text-center text-gray-900 border-2 rounded-md border-pr-200 hover:bg-white bg-sec-300">Cancel</a>
                    <button type="submit"
                        class="w-1/3 px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-pr-400 hover:bg-pr-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pr-400">Save</button>
                </div>

            </div>


        </form>

    </div>
@endsection